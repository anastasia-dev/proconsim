<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>

<?
if($_POST){

    $curSectionID =intval($_POST["sectionid"]);
    $curPriceID =intval($_POST["priceid"]);
    $regionCode = htmlspecialcharsEx($_POST["code"]);
    $regionPhone = htmlspecialcharsEx($_POST["phone"]);
    $regionEmail = htmlspecialcharsEx($_POST["email"]);

    

    CModule::IncludeModule('iblock');
    CModule::IncludeModule("sale");
    if (!CSalePdf::isPdfAvailable()) die();
    $pdf = new CSalePdf('P', 'pt', 'A4');
    $pageWidth  = $pdf->GetPageWidth();
    $pageHeight = $pdf->GetPageHeight();
    $pdf->AddFont('Font', '', 'pt_sans-regular.ttf', true);
    $pdf->AddFont('Font', 'B', 'pt_sans-bold.ttf', true);
    $pdf->AddFont('Font', 'I', 'pt_sans-italic.ttf', true);
    $pdf->AddFont('Font', 'BI', 'pt_sans-bolditalic.ttf', true);
    
    $fontFamily = 'Font';
    $fontSize   = 10.5;
    $margin = array(
     'top' => 15 * 72/25.4,
     'right' => 15 * 72/25.4,
     //'bottom' => 15 * 72/25.4,
     'bottom' => 0,
     'left' => 15 * 72/25.4
    );
    $width = $pageWidth - $margin['left'] - $margin['right'];
	//$pdf->SetCompression(true);
    $pdf->SetDisplayMode(100, 'continuous');
    $pdf->SetMargins($margin['left'], $margin['top'], $margin['right']);
    $pdf->SetAutoPageBreak(true, $margin['bottom']);
    $pdf->AddPage();
    
    
    
    
    $x0 = $pdf->GetX();
    $y0 = $pdf->GetY();
    //$pdf->SetXY($x0, $y0);
    //echo "x=". $x0.", y=".$y0."<br />";
    //
    $pdf->SetFont($fontFamily, '', $fontSize);
    $pdf->MultiCell(1, 30, $pdf->prepareToPdf(''), 0, 'C');  
    $x0 = $x0+1;
    $pdf->SetXY($x0, $y0);
    $pdf->MultiCell(169, 30, $pdf->Image('/bitrix/templates/prok/img/logo.png',$x0,$y0,169,30,'PNG','https://proconsim.ru/'), 0, 'C');
    $x0 = $x0+169;
    $y0 = $y0-7;
    $pdf->SetXY($x0, $y0);
    $pdf->SetFont($fontFamily, 'B', 20);
    $pdf->SetTextColor(98,104,126);
    $pdf->MultiCell(200, 30, $pdf->prepareToPdf('ПРАЙС-ЛИСТ'), 0, 'C');
    $y0 = $y0+20;   
    $pdf->SetXY($x0, $y0);
    $pdf->SetFont($fontFamily, 'BI', 12);
    $pdf->MultiCell(200, 30, $pdf->prepareToPdf('от '.date("d.m.Y")), 0, 'C');
    $x0 = $x0+200;
    $y0 = $y0-13;
    $pdf->SetXY($x0, $y0);
    $pdf->SetFont($fontFamily, 'B', 12);    
    $pdf->MultiCell(15, 15, $pdf->Image('/bitrix/templates/prok/img/ico-phone-2.png',$x0,$y0,15,15,'PNG'), 0, 'R');
    $x0 = $x0+3;
    $pdf->SetXY($x0, $y0);
    $pdf->MultiCell(135, 15, $pdf->prepareToPdf($regionPhone), 0, 'R');
    $x0 = $x0-3;
    $y0 = $y0+25;
    $pdf->SetXY($x0, $y0);
    $pdf->MultiCell(15, 10, $pdf->Image('/bitrix/templates/prok/img/ico-envelope.png',$x0,$y0,15,10,'PNG'), 0, 'R');
    $x0 = $x0+10;
    $pdf->SetXY($x0, $y0);
    $pdf->SetFont($fontFamily, '', 11);
    $pdf->MultiCell(130, 15, $pdf->prepareToPdf($regionEmail), 0, 'R');
    
    
    
    $pdf->Ln();    
    
    
    // Список товаров
    
    $rsParentSection = CIBlockSection::GetByID($curSectionID);
    if ($arParentSection = $rsParentSection->GetNext())
    {
       $arFilter = array('IBLOCK_ID' => $arParentSection['IBLOCK_ID'],'>LEFT_MARGIN' => $arParentSection['LEFT_MARGIN'],'<RIGHT_MARGIN' => $arParentSection['RIGHT_MARGIN'],'>DEPTH_LEVEL' => $arParentSection['DEPTH_LEVEL']); // выберет потомков без учета активности
       $dbSection = CIBlockSection::GetList(array('left_margin' => 'asc'),$arFilter);
       $pdf->SetFillColor(157,157,157);
       $pdf->SetDrawColor(157,157,157);
       $pdf->SetFont($fontFamily, 'BI', 15);
       $pdf->SetTextColor(253,253,253);
       $pdf->Cell($width, 30, $pdf->prepareToPdf(strtoupper($arParentSection['NAME'])), 'LTR', 2, 'C', true);
    }
    
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont($fontFamily, '', $fontSize);
    
    
    $x1 = $pdf->GetX();
    $y1 = $pdf->GetY();
    $pdf->SetFont($fontFamily, 'B', $fontSize);
    $pdf->MultiCell(70, 20, $pdf->prepareToPdf('Артикул'), 'LT', 'C');
    $x1 = $x1+70;
    $pdf->SetXY($x1, $y1);    
    $pdf->MultiCell(280, 20, $pdf->prepareToPdf('Название'), 'LT', 'C');
    $x1 = $x1+280;
    $pdf->SetXY($x1, $y1);
    $pdf->MultiCell(45, 20, $pdf->prepareToPdf('Масса'), 'LT', 'C');
    $x1 = $x1+45;
    $pdf->SetXY($x1, $y1);
    $pdf->MultiCell(45, 10, $pdf->prepareToPdf('Кол-во в уп-ке'), 'LT', 'C');
    $x1 = $x1+45;
    $pdf->SetXY($x1, $y1);
    $pdf->MultiCell(70, 20, $pdf->prepareToPdf('Цена'), 'LTR', 'C');
    $pdf->Ln(0);
    
       
       $pH = $pageHeight-$margin['top']-$margin['bottom']-5;
       while( $arSection = $dbSection-> GetNext(true, false) ){
           
           $pdf->SetFont($fontFamily, 'B', $fontSize);
           $pdf->Cell($width, 20, $pdf->prepareToPdf($arSection['NAME']), 'LTR', 2, 'C');
                 
           
           
           $arSelect = Array("ID", "IBLOCK_ID", "NAME", "PREVIEW_PICTURE", "PROPERTY_ARTNUMBER", "PROPERTY_WEIGHT", "PROPERTY_QTY_PER_PACK", "CATALOG_GROUP_".$curPriceID);//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
           $arFilter = Array(
                         "IBLOCK_ID"=>2,                 
    			         "SECTION_ID"=>$arSection['ID'],
                         "ACTIVE"=> "Y",
                         ">CATALOG_PRICE_".$curPriceID => 0
                         );
           $resProduct = CIBlockElement::GetList(Array("PROPERTY_SORTORDER"=>"ASC","SORT"=>"ASC"), $arFilter, false, false, $arSelect);
           if (intval($resProduct->SelectedRowsCount())>0){              
                //$pdf->SetFont($fontFamily, '', $fontSize);
                $countPr = 0;
                while($obProduct = $resProduct->GetNextElement()){ 
                    $arFields = $obProduct->GetFields();
                    $countPr++;
					            
                    $hieghtCell = 30;

					//$arFields['NAME'] = TruncateText($arFields['NAME'],30);
					//$nameWidth = $pdf->GetStringWidth($arFields['NAME']);
                    
                    $nameWidth = strlen($arFields['NAME']);
                    if($nameWidth<52){
                        $hieghtCell = 15;
                    }else if($nameWidth<94){
						$hieghtCell = 45;                       
					}else if($nameWidth<152){ 
                        $hieghtCell = 45;
                    }else if($nameWidth<217){   
                        $hieghtCell = 60;
                    }    
                                        
                    $x = $pdf->GetX();
                    $y = $pdf->GetY();
    //echo "x=". $x.", y=".$y."<br />";
    //echo "YY= ". $pH." - ".$hieghtCell."<br />";   
                    
                    $pY = $pH-$hieghtCell;               
                    //echo "pY= ". $pY."<br />";  
                    if($y>$pY){                        
                        $pdf->Ln(0);
                        $pdf->Line($x,$y,$width+$x,$y);
                        $pdf->SetXY($x, $pH);
                        $pdf->SetFont($fontFamily,'B',8);                        
                        $pdf->Cell(0,10,'-'.$pdf->PageNo().'-',0,0,'C');
                        $pdf->AddPage();
                        $pdf->SetFont($fontFamily, '', $fontSize);
                        $isBreak = 1;
                        $x=42.51968503937; 
                        $y=42.51968503937;
                        $pdf->SetXY($x, $y);
                        $x = $pdf->GetX();
                        $y = $pdf->GetY();
                        $pdf->SetFont($fontFamily, 'B', $fontSize);
                        $pdf->MultiCell(70, 20, $pdf->prepareToPdf('Артикул'), 'LT', 'C');
                        $x = $x+70;
                        $pdf->SetXY($x, $y);    
                        $pdf->MultiCell(280, 20, $pdf->prepareToPdf('Название'), 'LT', 'C');
                        $x = $x+280;
                        $pdf->SetXY($x, $y);
                        $pdf->MultiCell(45, 20, $pdf->prepareToPdf('Масса'), 'LT', 'C');
                        $x = $x+45;
                        $pdf->SetXY($x, $y);
                        $pdf->MultiCell(45, 10, $pdf->prepareToPdf('Кол-во в уп-ке'), 'LT', 'C');
                        $x = $x+45;
                        $pdf->SetXY($x, $y);
                        $pdf->MultiCell(70, 20, $pdf->prepareToPdf('Цена'), 'LTR', 'C');
                        $pdf->Ln(0);
                        //$pdf->SetXY($x, $y);
                    } 
                    $x = $pdf->GetX();
                    $y = $pdf->GetY();
                    $pdf->SetFont($fontFamily, '', $fontSize);
                    $pdf->MultiCell(70, $hieghtCell, $pdf->prepareToPdf($arFields['PROPERTY_ARTNUMBER_VALUE']), 'LTR', 'C');
                    $x = $x+70;
                    $pdf->SetXY($x, $y);
                    
                    $pdf->MultiCell(280, 15, $pdf->prepareToPdf($arFields['NAME']), 'T', 'L');
                    $x = $x+280;
                    $pdf->SetXY($x, $y);
                    //echo "x=". $x.", y=".$y."<br />";                    
                    $pdf->MultiCell(45, $hieghtCell, $pdf->prepareToPdf($arFields['PROPERTY_WEIGHT_VALUE']), 'LT', 'L');
                    $x = $x+45;
                    $pdf->SetXY($x, $y);
                    //echo "x=". $x.", y=".$y."<br />";                    
                    $pdf->MultiCell(45, $hieghtCell, $pdf->prepareToPdf($arFields['PROPERTY_QTY_PER_PACK_VALUE']), 'LT', 'L');
                    $x = $x+45;
                    $pdf->SetXY($x, $y);
                    //echo "x=". $x.", y=".$y."<br /><br />";
                    $pdf->MultiCell(70, $hieghtCell, $pdf->prepareToPdf($arFields['CATALOG_PRICE_'.$curPriceID]), 'LTR', 'L');  
                    $pdf->Ln(0);						
                }   
           }
       }
    $x = $pdf->GetX();
    $y = $pdf->GetY();   
    $pdf->Line($x,$y,$width+$x,$y);
    $pdf->SetXY($x, $pH);
    $pdf->SetFont($fontFamily,'B',8);                        
    $pdf->Cell(0,10,'-'.$pdf->PageNo().'-',0,0,'C');
    
    $myfile= $arParentSection["CODE"].'-'.$regionCode.'.pdf';
	$pdf->Output($myfile, 'F');
	if (!copy($myfile,$_SERVER['DOCUMENT_ROOT'].'/upload/pdf/'.$myfile))
	{ echo "err"; }else{  unlink($myfile); echo '/upload/pdf/'.$myfile;  } 
	//echo '/upload/pdf/'.$myfile;
}
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>