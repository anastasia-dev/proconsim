<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
CModule::IncludeModule("sale");
if (!CSalePdf::isPdfAvailable()) die();
require('catalog.class.php'); 

$catalog=new Catalog(); 
$catalog->Open(); 

$file = $_SERVER['DOCUMENT_ROOT'].'/load-test/file.csv';
if (!file_exists($file)) {
	exit("Файл ".$file." не найден!");
}


$data = $catalog->LoadData($file); 

//echo "<pre>";
//print_r($data);
//echo "</pre>";

if($data){
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
    $pdf->Cell(0, 30, $pdf->prepareToPdf('Каталог'), 0, 0, 'C');
    
    $pdf->Ln();
    
    $pdf->SetFont($fontFamily, '', $fontSize);
    
    $x1 = $pdf->GetX();
    $y1 = $pdf->GetY();
    $pdf->SetFont($fontFamily, 'B', $fontSize);
    $pdf->MultiCell(70, 20, $pdf->prepareToPdf('Артикул'), 'LT', 'C');
    $x1 = $x1+70;
    $pdf->SetXY($x1, $y1);
    $pdf->MultiCell(70, 20, $pdf->prepareToPdf('Фото'), 'LT', 'C');
    $x1 = $x1+70;
    $pdf->SetXY($x1, $y1);
    $pdf->MultiCell(160, 20, $pdf->prepareToPdf('Название'), 'LT', 'C');
    $x1 = $x1+160;
    $pdf->SetXY($x1, $y1);
    $pdf->MultiCell(70, 20, $pdf->prepareToPdf('Масса'), 'LT', 'C');
    $x1 = $x1+70;
    $pdf->SetXY($x1, $y1);
    $pdf->MultiCell(70, 10, $pdf->prepareToPdf('Кол-во в упаковке'), 'LT', 'C');
    $x1 = $x1+70;
    $pdf->SetXY($x1, $y1);
    $pdf->MultiCell(70, 20, $pdf->prepareToPdf('Цена'), 'LTR', 'C');
    $pdf->Ln(0);
    
    $pH = $pageHeight-$margin['top']-$margin['bottom'];
    
    foreach($data as $sections){
        
        
        $pdf->SetFont($fontFamily, 'B', $fontSize);
        $pdf->Cell($width, 20, $pdf->prepareToPdf($sections['NAME']), 'LTR', 2, 'C');
        if($sections['SUB']){
            foreach($sections['SUB'] as $subs){
                $pdf->SetFont($fontFamily, 'B', $fontSize);
                $pdf->Cell($width, 20, $pdf->prepareToPdf($subs['NAME']), 'LTR', 2, 'L');
                $count = 0;
                if($subs["PRODUCTS"]){
                    
                    $pdf->SetFont($fontFamily, '', $fontSize);
                    foreach($subs["PRODUCTS"] as $products){
                        $count++;
                        if($count<20){
                        $hieghtCell = 70;                
                        $nameWidth = $pdf->GetStringWidth($products[2]);
                        if($nameWidth>700){
                            $countH = ceil($nameWidth/160)+1;
                            $hieghtCell = $hieghtCell*$countH;
                        }    
                        $x = $pdf->GetX();
                        $y = $pdf->GetY();
                        $pY = $pH-$hieghtCell; 
                        if($y>$pY){                                
                            $pdf->Ln(0);
                            $pdf->Line($x,$y,$width+$x,$y);
                            $pdf->AddPage();                                
                            $x=42.51968503937; 
                            $y=42.51968503937;
                            $pdf->SetXY($x, $y);
                        } 
                        $pdf->MultiCell(70, $hieghtCell, $pdf->prepareToPdf($products[0]), 'LT', 'L');
                        $x = $x+70;
                        $pdf->SetXY($x, $y);
                        $pdf->MultiCell(70, $hieghtCell, $pdf->Image($products[1],$x,$y,65,67), 'LTR', 'C'); 
                        $x = $x+70;
                        $pdf->SetXY($x, $y);
                        $pdf->MultiCell(160, 15, $pdf->prepareToPdf($products[2]), 'T', 'L');
                        $x = $x+160;
                        $pdf->SetXY($x, $y);
                        $pdf->MultiCell(70, $hieghtCell, $pdf->prepareToPdf($products[3]), 'LT', 'L');
                        $x = $x+70;
                        $pdf->SetXY($x, $y); 
                        $pdf->MultiCell(70, $hieghtCell, $pdf->prepareToPdf($products[4]), 'LT', 'L');
                        $x = $x+70;
                        $pdf->SetXY($x, $y);
                        $pdf->MultiCell(70, $hieghtCell, $pdf->prepareToPdf($products[5]), 'LTR', 'L');
                        $pdf->Ln(0); 
                        }
                   }    
                }
                
            }
        }
    }
    $x = $pdf->GetX();
    $y = $pdf->GetY();   
    $pdf->Line($x,$y,$width+$x,$y);
    $myfile='temp.pdf';
    $pdf->Output($myfile, 'F');
    if (!copy($myfile,$_SERVER['DOCUMENT_ROOT'].'/upload/temp.pdf'))
    {  }else{  unlink($myfile);  } 
}

?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>