<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Title");
?>
<?
CModule::IncludeModule("sale");
if (!CSalePdf::isPdfAvailable()) die();
$pdf = new CSalePdf('P', 'pt', 'A4');
$pageWidth  = $pdf->GetPageWidth();
$pageHeight = $pdf->GetPageHeight();
$pdf->AddFont('Font', '', 'pt_sans-regular.ttf', true);
$pdf->AddFont('Font', 'B', 'pt_sans-bold.ttf', true);
$fontFamily = 'Font';
$fontSize   = 10.5;
$margin = array(
 'top' => 15 * 72/25.4,
 'right' => 15 * 72/25.4,
 'bottom' => 15 * 72/25.4,
 'left' => 15 * 72/25.4
);
$width = $pageWidth - $margin['left'] - $margin['right'];
$pdf->SetDisplayMode(100, 'continuous');
$pdf->SetMargins($margin['left'], $margin['top'], $margin['right']);
$pdf->SetAutoPageBreak(true, $margin['bottom']);
$pdf->AddPage();
$pdf->SetFont($fontFamily, 'B', $fontSize);

$x0 = $pdf->GetX();
$y0 = $pdf->GetY();
echo "x=". $x0.", y=".$y0."<br />";
$pdf->Cell(0, 30, $pdf->prepareToPdf('Каталог'), 0, 0, 'C');

$pdf->Ln();

$pdf->SetFont($fontFamily, '', $fontSize);


$x1 = $pdf->GetX();
$y1 = $pdf->GetY();
$pdf->SetFont($fontFamily, 'B', $fontSize);
$pdf->MultiCell(70, 20, $pdf->prepareToPdf('Артикул'), 'LT', 'C');
$x1 = $x1+70;
$pdf->SetXY($x1, $y1);
$pdf->MultiCell(230, 20, $pdf->prepareToPdf('Название'), 'LT', 'C');
$x1 = $x1+230;
$pdf->SetXY($x1, $y1);
$pdf->MultiCell(70, 20, $pdf->prepareToPdf('Масса'), 'LT', 'C');
$x1 = $x1+70;
$pdf->SetXY($x1, $y1);
$pdf->MultiCell(70, 10, $pdf->prepareToPdf('Кол-во в упаковке'), 'LT', 'C');
$x1 = $x1+70;
$pdf->SetXY($x1, $y1);
$pdf->MultiCell(70, 20, $pdf->prepareToPdf('Цена'), 'LTR', 'C');
$pdf->Ln(0);


// Список товаров

$filter = Array(
    'IBLOCK_ID' => 2,
    '!ID' => array(28,29,30,31,92)
 );
 $select = Array(
    'NAME',
    'SECTION_PAGE_URL'
 );

$dbSection = CIBlockSection::GetList(
      Array(
               'LEFT_MARGIN' => 'ASC',
      ),
      array_merge( 
          Array(
             'ACTIVE' => 'Y',
             'GLOBAL_ACTIVE' => 'Y'
          ),
          is_array($filter) ? $filter : Array()
      ),
      false,
      array_merge(
          Array(
             'ID',
             'IBLOCK_SECTION_ID'
          ),
         is_array($select) ? $select : Array()
      )
   );   
   
   $pH = $pageHeight-$margin['top']-$margin['bottom'];
   while( $arSection = $dbSection-> GetNext(true, false) ){
       
       $pdf->SetFont($fontFamily, 'B', $fontSize);
       if(empty($arSection['IBLOCK_SECTION_ID'])){
          $pdf->Cell($width, 20, $pdf->prepareToPdf($arSection['NAME']), 'LTR', 2, 'C');
       }else{
          $pdf->Cell($width, 20, $pdf->prepareToPdf($arSection['NAME']), 'LTR', 2, 'L');
       }       
       
       
       $arSelect = Array("ID", "IBLOCK_ID", "NAME", "PREVIEW_PICTURE", "PROPERTY_ARTNUMBER", "PROPERTY_WEIGHT", "PROPERTY_QTY_PER_PACK", "CATALOG_GROUP_1");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
       $arFilter = Array(
                     "IBLOCK_ID"=>2,                 
			         "SECTION_ID"=>$arSection['ID'],
                     "ACTIVE"=> "Y",
                     ">CATALOG_PRICE_1" => 0
                     );
       $resProduct = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
       if (intval($resProduct->SelectedRowsCount())>0){              
            $pdf->SetFont($fontFamily, '', $fontSize);
            $countPr = 0;
            while($obProduct = $resProduct->GetNextElement()){ 
                $arFields = $obProduct->GetFields();
                $countPr++;
                //if($countPr<10){                
                $hieghtCell = 15;                
                $nameWidth = $pdf->GetStringWidth($arFields['NAME']);
                if($nameWidth>190){
                    $countH = ceil($nameWidth/190);
                    $hieghtCell = $hieghtCell*$countH;
                }     
                
                //echo $arFields['NAME'].", nameWidth=".$nameWidth.", countH = ".$countH.", hieghtCell=".$hieghtCell."<br />";
                
                $x = $pdf->GetX();
                $y = $pdf->GetY();
//echo "x=". $x.", y=".$y."<br />";
//echo "YY= ". $pH." - ".$hieghtCell."<br />";   

                $pY = $pH-$hieghtCell;               
                //echo "pY= ". $pY."<br />";  
                if($y>$pY){
                    //$pdf->SetAutoPageBreak(true);
                    $pdf->Ln(0);
                    $pdf->Line($x,$y,$width+$x,$y);
                    $pdf->AddPage();
                    $isBreak = 1;
                    $x=42.51968503937; 
                    $y=42.51968503937;
                    $pdf->SetXY($x, $y);
                } 
                
                $pdf->MultiCell(70, $hieghtCell, $pdf->prepareToPdf($arFields['PROPERTY_ARTNUMBER_VALUE']), 'LTR', 'L');
                $x = $x+70;
                $pdf->SetXY($x, $y);               
                //echo "x=". $x.", y=".$y."<br />";
                $pdf->MultiCell(230, 15, $pdf->prepareToPdf($arFields['NAME']), 'T', 'L');
                $x = $x+230;
                $pdf->SetXY($x, $y);
                //echo "x=". $x.", y=".$y."<br />";
                $pdf->MultiCell(70, $hieghtCell, $pdf->prepareToPdf($arFields['PROPERTY_WEIGHT_VALUE']), 'LT', 'L');
                $x = $x+70;
                $pdf->SetXY($x, $y);
                //echo "x=". $x.", y=".$y."<br />";
                $pdf->MultiCell(70, $hieghtCell, $pdf->prepareToPdf($arFields['PROPERTY_QTY_PER_PACK_VALUE']), 'LT', 'L');
                $x = $x+70;
                $pdf->SetXY($x, $y);
                //echo "x=". $x.", y=".$y."<br /><br />";
                $pdf->MultiCell(70, $hieghtCell, $pdf->prepareToPdf($arFields['CATALOG_PRICE_1']), 'LTR', 'L');  
                $pdf->Ln(0);            
                
              
            //} 
            }   
       }
   }
$x = $pdf->GetX();
$y = $pdf->GetY();   
$pdf->Line($x,$y,$width+$x,$y);
/*
$ROW1=150;
$Y=15;
$pdf->Cell($ROW1, $Y, $pdf->prepareToPdf('Артикул'), 0, 0, 'L');
$pdf->MultiCell(0, $Y, $pdf->prepareToPdf('Изображение'), 0, 'L');
$pdf->Cell($ROW1, $Y, $pdf->prepareToPdf('начало:'), 0, 0, 'L');
$pdf->MultiCell(0, $Y, $pdf->prepareToPdf('Свойцство}'), 0, 'L');
$pdf->Cell($ROW1, $Y, $pdf->prepareToPdf('конец:'), 0, 0, 'L');
$pdf->MultiCell(0, $Y, $pdf->prepareToPdf('еще свойство'), 0, 'L');
$pdf->Cell($ROW1, $Y, $pdf->prepareToPdf('Тип:'), 0, 0, 'L');
$pdf->MultiCell(0, $Y, $pdf->prepareToPdf('Свойство'), 0, 'L');
*/
$myfile='catalog.pdf';
$pdf->Output($myfile, 'F');
if (!copy($myfile,$_SERVER['DOCUMENT_ROOT'].'/upload/catalog.pdf'))
{  }else{  unlink($myfile);  } 
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>