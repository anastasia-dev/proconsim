<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Title");
?>
<?
CModule::IncludeModule("sale");
if (!CSalePdf::isPdfAvailable()) die();
$pdf = new tFPDF('P', 'pt', 'A4');
$pdf->SetAutoPageBreak(true);
$pdf->AddPage();

$pdf->AddFont('Font', '', 'pt_sans-regular.ttf', true);
$pdf->AddFont('Font', 'B', 'pt_sans-bold.ttf', true);
$fontFamily = 'Font';
$fontSize   = 10.5;
$pdf->SetFont($fontFamily, 'B', $fontSize);

$pdf->Cell(0, 30, 'Каталог', 0, 0, 'C');

$pdf->Ln();

$pdf->SetFont($fontFamily, '', $fontSize);

$x = $pdf->GetX();
$y = $pdf->GetY();

$pdf->MultiCell(85, 20, 'Артикул', 1, 'C');
$x = $x+85;
$pdf->SetXY($x, $y);
$pdf->MultiCell(85, 20, 'Фото', 1, 'C');
$x = $x+85;
$pdf->SetXY($x, $y);
$pdf->MultiCell(85, 20, 'Название', 1, 'C');
$x = $x+85;
$pdf->SetXY($x, $y);
$pdf->MultiCell(85, 20, 'Масса', 1, 'C');
$x = $x+85;
$pdf->SetXY($x, $y);
$pdf->MultiCell(85, 20, 'Кол-во в упаковке', 1, 'C');
$x = $x+85;
$pdf->SetXY($x, $y);
$pdf->MultiCell(85, 20, 'Цена', 1, 'C');
//$x = $x+85;
//$pdf->SetXY($x, $y);


$myfile='temp2.pdf';
$pdf->Output($myfile, 'F');
if (!copy($myfile,$_SERVER['DOCUMENT_ROOT'].'/upload/temp2.pdf'))
{  }else{  unlink($myfile);  } 
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>