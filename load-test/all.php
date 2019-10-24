<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Title");
?>
<?
class PDF extends CSalePdf
{
	function Footer()
	{
		//Позиция на 1.5 cm от нижнего края документа
		//$this->SetY(-15);
		//Шрифт Arial, курсив, размер 8
		$this->SetFont('Arial','I',8);
		//Цвет текста - серый
		//$this->SetTextColor(128);
		//Номер страницы
		$this->Cell(0,10,$this->prepareToPdf('Page '.$this->PageNo()),0,0,'C');
	}

}

CModule::IncludeModule("sale");
if (!CSalePdf::isPdfAvailable()) die();
$pdf = new PDF('P', 'pt', 'A4');
$pageWidth  = $pdf->GetPageWidth();
$pageHeight = $pdf->GetPageHeight();
$pdf->AddFont('Font', '', 'pt_sans-regular.ttf', true);
$pdf->AddFont('Font', 'B', 'pt_sans-bold.ttf', true);
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
$pdf->SetDisplayMode(100, 'continuous');
$pdf->SetMargins($margin['left'], $margin['top'], $margin['right']);
$pdf->SetAutoPageBreak(true, $margin['bottom']);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont($fontFamily, 'B', $fontSize);

$x0 = $pdf->GetX();
$y0 = $pdf->GetY();
//echo "x=". $x0.", y=".$y0."<br />";
$pdf->Cell(0, 30, $pdf->prepareToPdf('ПРАЙС-ЛИСТ от '.date("d.m.Y")), 0, 0, 'C');

$pdf->Ln();

$pdf->SetFont($fontFamily, '', $fontSize);


$x1 = $pdf->GetX();
$y1 = $pdf->GetY();
$pdf->SetFont($fontFamily, 'B', $fontSize);
$pdf->MultiCell(60, 20, $pdf->prepareToPdf('Артикул'), 'LT', 'C');
$x1 = $x1+60;
$pdf->SetXY($x1, $y1);
$pdf->MultiCell(30, 20, $pdf->prepareToPdf('Фото'), 'LT', 'C');
$x1 = $x1+30;
$pdf->SetXY($x1, $y1);
$pdf->MultiCell(255, 20, $pdf->prepareToPdf('Название'), 'LT', 'C');
$x1 = $x1+255;
$pdf->SetXY($x1, $y1);
$pdf->MultiCell(55, 20, $pdf->prepareToPdf('Масса'), 'LT', 'C');
$x1 = $x1+55;
$pdf->SetXY($x1, $y1);
$pdf->MultiCell(40, 10, $pdf->prepareToPdf('Кол-во в упак.'), 'LT', 'C');
$x1 = $x1+40;
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
       
       
       $arSelect = Array("ID", "IBLOCK_ID", "NAME", "PROPERTY_ARTNUMBER", "PROPERTY_WEIGHT", "PROPERTY_QTY_PER_PACK", "CATALOG_GROUP_1");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
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
                
                $hieghtCell = 30;
                
                $nameWidth = $pdf->GetStringWidth($arFields['NAME']);
				//echo $arFields['NAME']." = ".$nameWidth."<br />";
                if($nameWidth<=249){
                    $hieghtCellName = 30;
                }else if($nameWidth>249 && $nameWidth<440) {
                    $hieghtCellName = 15;
                    $hieghtCell = $hieghtCellName*2; 
                }else if($nameWidth>440 && $nameWidth<680) {
                    $hieghtCellName = 15;
                    $hieghtCell = $hieghtCellName*3;   
                }else {   
                    $countH = ceil($nameWidth/250);
                    $hieghtCellName = 15;
                    $hieghtCell = $hieghtCellName*$countH;
                }
                
                $x = $pdf->GetX();
                $y = $pdf->GetY();


                $pY = $pH-$hieghtCell;               
				//echo "pY= ". $pY."<br />";  
                if($y>$pY){
                    $pdf->Ln(0);
                    $pdf->Line($x,$y,$width+$x,$y);
                    $pdf->AddPage();
                    $isBreak = 1;
                    $x=42.51968503937; 
                    $y=42.51968503937;
                    $pdf->SetXY($x, $y);
                } 
                
                $pdf->MultiCell(60, $hieghtCell, $pdf->prepareToPdf($arFields['PROPERTY_ARTNUMBER_VALUE']), 'LT', 'L');
                $x = $x+60;
                $pdf->SetXY($x, $y);
                //echo "x=". $x.", y=".$y."<br />";
                
                $photo = $_SERVER['DOCUMENT_ROOT'].'/upload/preview/'.$arFields['PROPERTY_ARTNUMBER_VALUE'].'.jpg';
                if (file_exists($photo)) {                    
                            $pdf->MultiCell(30, $hieghtCell, $pdf->Image($photo,$x,$y,25,25), 'LTR', 'C');
                }else{
                    $pdf->MultiCell(30, $hieghtCell, $pdf->prepareToPdf(''), 'LTR', 'C');
                }
                $x = $x+30;
                $pdf->SetXY($x, $y);
                //echo "x=". $x.", y=".$y."<br />";
                $pdf->MultiCell(255, $hieghtCellName, $pdf->prepareToPdf($arFields['NAME']), 'T', 'L');
                $x = $x+255;
                $pdf->SetXY($x, $y);
                //echo "x=". $x.", y=".$y."<br />";
                $pdf->MultiCell(70, $hieghtCell, $pdf->prepareToPdf($arFields['PROPERTY_WEIGHT_VALUE']), 'LT', 'L');
				//$pdf->MultiCell(55, $hieghtCell, $pdf->prepareToPdf('99 999,00'), 'LT', 'L');
                $x = $x+55;
                $pdf->SetXY($x, $y);
                //echo "x=". $x.", y=".$y."<br />";
                $pdf->MultiCell(40, $hieghtCell, $pdf->prepareToPdf($arFields['PROPERTY_QTY_PER_PACK_VALUE']), 'LT', 'L');
                $x = $x+40;
                $pdf->SetXY($x, $y);
                //echo "x=". $x.", y=".$y."<br /><br />";
                $pdf->MultiCell(70, $hieghtCell, $pdf->prepareToPdf($arFields['CATALOG_PRICE_1']), 'LTR', 'R');  
                $pdf->Ln(0);
                
                
                
            //} 
            }   
       }
   }
$x = $pdf->GetX();
$y = $pdf->GetY();   
$pdf->Line($x,$y,$width+$x,$y);

$myfile='all.pdf';
$pdf->Output($myfile, 'F');
if (!copy($myfile,$_SERVER['DOCUMENT_ROOT'].'/upload/all.pdf'))
{  }else{  unlink($myfile);  } 
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>