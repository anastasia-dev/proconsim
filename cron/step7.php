<?
$_SERVER["DOCUMENT_ROOT"] = "/home/webmaster/web/proconsim.ru/public_html";
$DOCUMENT_ROOT = $_SERVER["DOCUMENT_ROOT"];

define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

set_time_limit(0);
ini_set('display_errors', '1');
error_reporting(E_ALL ^ E_NOTICE);
ini_set('default_socket_timeout', 180);

CModule::IncludeModule("iblock");
CModule::IncludeModule("catalog");

$file_report = $_SERVER["DOCUMENT_ROOT"]."/cron/report_step7.txt";
if (file_exists($file_report)) {
    unlink($file_report);
}  

$for_report = "";

selectRecords();

function selectRecords(){
    $connection = Bitrix\Main\Application::getConnection();
	$sqlHelper = $connection->getSqlHelper();
    $limit = 1;
    
    $arRegSect = array();
    
    $sql = "SELECT id,record FROM load_groups";
    $recordset = $connection->query($sql, $limit);
    while ($recordrow = $recordset->fetch())
    {        
        $arRegSect[]= unserialize($recordrow["record"]);
        $connection->queryExecute("DELETE FROM load_groups WHERE id='" . $recordrow["id"] . "'");
    }
    $countRegSect = count($arRegSect);

    if($countRegSect>0){
        createPDF($arRegSect);
        selectRecords();
    }	      
}

function createPDF($params){    
    $arSubs = array();
    $parentSectionID = 0;
    $parentSectionName = "";
    foreach($params[0] as $regionID=>$values){
        $curSectionID = $values["SECTION_ID"];
        $curSectionName = $values["SECTION_NAME"];
        $curSectionCode = $values["SECTION_CODE"];
        if(isset($values["PARENT_ID"])){
            $parentSectionID = $values["PARENT_ID"];
        }
        if(isset($values["PARENT_NAME"])){
            $parentSectionName = $values["PARENT_NAME"];
        }        
        $countSub = $values["COUNT_SUBS"];
        $curPriceID = $values["PRICE_ID"];
        $regionCode = $values["CODE"];
        $regionPhone = $values["PHONE"];
        $regionEmail = $values["EMAIL"];
        if(isset($values["SUB_SECTIONS"])){
            $arSubs = $values["SUB_SECTIONS"];
        }
    }
    
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
    $fontSize   = 9;
    $margin = array(
     //'top' => 15 * 72/25.4,
     //'right' => 15 * 72/25.4,
     'top' => 15 * 48/25.4,
     'right' => 15 * 48/25.4,
     //'bottom' => 15 * 72/25.4,
     'bottom' => 0,
     'left' => 15 * 48/25.4
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
    $x0 = $x0+220;
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
    
    //if (!empty($parentSectionName))
    //{
       
       $pdf->SetFillColor(157,157,157);
       $pdf->SetDrawColor(157,157,157);
       $pdf->SetFont($fontFamily, 'BI', 15);
       $pdf->SetTextColor(253,253,253);
       $pdf->Cell($width, 30, $pdf->prepareToPdf(strtoupper($curSectionName)), 'LTR', 2, 'C', true);       
       
    //}
    
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont($fontFamily, '', $fontSize);
    
    
    $x1 = $pdf->GetX();
    $y1 = $pdf->GetY();
    $pdf->SetFont($fontFamily, 'B', $fontSize);
    $pdf->MultiCell(50, 15, $pdf->prepareToPdf('Артикул'), 'LT', 'C');
    $x1 = $x1+50;
    $pdf->SetXY($x1, $y1);    
    $pdf->MultiCell(395, 15, $pdf->prepareToPdf('Наименование'), 'LT', 'C');
    $x1 = $x1+395;
    $pdf->SetXY($x1, $y1);
    $pdf->MultiCell(32, 15, $pdf->prepareToPdf('Ед.'), 'LT', 'C');
    $x1 = $x1+32;
    $pdf->SetXY($x1, $y1);
    $pdf->MultiCell(62, 15, $pdf->prepareToPdf('Цена,руб'), 'LTR', 'C');
    $pdf->Ln(0);
    
       
    $pH = $pageHeight-$margin['top']-$margin['bottom']-5;
       
    if($countSub>0){
       foreach($arSubs as $sectionID=>$section){
           
           $pdf->SetFont($fontFamily, 'B', $fontSize);
           $pdf->Cell($width, 15, $pdf->prepareToPdf($section), 'LTR', 2, 'C');                
           
           
           $arSelect = Array("ID", "IBLOCK_ID", "NAME", "PREVIEW_PICTURE", "PROPERTY_ARTNUMBER", "PROPERTY_EDIZM", "PROPERTY_QTY_PER_PACK", "CATALOG_GROUP_".$curPriceID);//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
           $arFilter = Array(
                         "IBLOCK_ID"=>2,                 
    			         "SECTION_ID"=>$sectionID,
                         "ACTIVE"=> "Y",
                         ">CATALOG_PRICE_".$curPriceID => 0
                         );
           $resProduct = CIBlockElement::GetList(Array("PROPERTY_SORTORDER"=>"ASC","SORT"=>"ASC"), $arFilter, false, false, $arSelect);
           if (intval($resProduct->SelectedRowsCount())>0){              
                
                $countPr = 0;
                while($obProduct = $resProduct->GetNextElement()){ 
                    $arFields = $obProduct->GetFields();
                    $countPr++;
					            
                    $hieghtCell = 30;
                    
                    $nameWidth = strlen($arFields['NAME']);
                  
                    if($nameWidth<86){
                        $hieghtCell = 15;
                        $name_height=15;
                    }else if($nameWidth<170){
						$hieghtCell = 20;  
                        $name_height=10;                     
					}else if($nameWidth<250){ 
                        $hieghtCell = 25;
                        $name_height=10; 
                    }else {   
                        $hieghtCell = 30;
                        $name_height=10; 
                    }    
                                        
                    $x = $pdf->GetX();
                    $y = $pdf->GetY();    
                    
                    $pY = $pH-$hieghtCell;               
                    
                    if($y>$pY){                        
                        $pdf->Ln(0);
                        $pdf->Line($x,$y,$width+$x,$y);
                        $pdf->SetXY($x, $pH);
                        $pdf->SetFont($fontFamily,'B',8);                        
                        $pdf->Cell(0,10,'-'.$pdf->PageNo().'-',0,0,'C');
                        $pdf->AddPage();
                        $pdf->SetFont($fontFamily, '', $fontSize);
                        $isBreak = 1;
                        $x=15 * 48/25.4; 
                        $y=15 * 48/25.4;
                        $pdf->SetXY($x, $y);
                        $x = $pdf->GetX();
                        $y = $pdf->GetY();
                        $pdf->SetFont($fontFamily, 'B', $fontSize);
                        $pdf->MultiCell(50, 15, $pdf->prepareToPdf('Артикул'), 'LT', 'C');
                        $x = $x+50;
                        $pdf->SetXY($x, $y);    
                        $pdf->MultiCell(395, 15, $pdf->prepareToPdf('Наименование'), 'LT', 'C');
                        $x = $x+395;
                        $pdf->SetXY($x, $y);
                        $pdf->MultiCell(32, 15, $pdf->prepareToPdf('Ед.'), 'LT', 'C');
                        $x = $x+32;
                        
                        $pdf->SetXY($x, $y);
                        $pdf->MultiCell(62, 15, $pdf->prepareToPdf('Цена,руб'), 'LTR', 'C');
                        $pdf->Ln(0);
                        
                    } 
                    $x = $pdf->GetX();
                    $y = $pdf->GetY();
                    $pdf->SetFont($fontFamily, '', $fontSize);
                    $pdf->MultiCell(50, $hieghtCell, $pdf->prepareToPdf($arFields['PROPERTY_ARTNUMBER_VALUE']), 'LTR', 'C');                    
                    $x = $x+50;
                    $pdf->SetXY($x, $y);
                    
                    $pdf->MultiCell(395, $name_height, $pdf->prepareToPdf($arFields['NAME']), 'T', 'L');
                    $x = $x+395;
                    $pdf->SetXY($x, $y);
                                      
                    $pdf->MultiCell(32, $hieghtCell, $pdf->prepareToPdf(strtolower($arFields['PROPERTY_EDIZM_VALUE'])), 'LT', 'C');
                    
                    $x = $x+32;
                    $pdf->SetXY($x, $y);
                    
                    $pdf->MultiCell(62, $hieghtCell, $pdf->prepareToPdf(number_format($arFields['CATALOG_PRICE_'.$curPriceID], 2, ',', ' ')), 'LTR', 'R');
                    
                    $pdf->Ln(0);						
                }   
           }
       }
    }else{ 
           
           $arSelect = Array("ID", "IBLOCK_ID", "NAME", "PREVIEW_PICTURE", "PROPERTY_ARTNUMBER", "PROPERTY_EDIZM", "PROPERTY_QTY_PER_PACK", "CATALOG_GROUP_".$curPriceID);//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
           $arFilter = Array(
                         "IBLOCK_ID"=>2,                 
    			         "SECTION_ID"=>$curSectionID,
                         "ACTIVE"=> "Y",
                         ">CATALOG_PRICE_".$curPriceID => 0
                         );
           $resProduct = CIBlockElement::GetList(Array("PROPERTY_SORTORDER"=>"ASC","SORT"=>"ASC"), $arFilter, false, false, $arSelect);
           if (intval($resProduct->SelectedRowsCount())>0){              
                
                $countPr = 0;
                while($obProduct = $resProduct->GetNextElement()){ 
                    $arFields = $obProduct->GetFields();
                    $countPr++;
					            
                    $hieghtCell = 30;
					                    
                    $nameWidth = strlen($arFields['NAME']);
                  
                    if($nameWidth<86){
                        $hieghtCell = 15;
                        $name_height=15;
                    }else if($nameWidth<170){
						$hieghtCell = 20;  
                        $name_height=10;                     
					}else if($nameWidth<250){ 
                        $hieghtCell = 25;
                        $name_height=10; 
                    }else {   
                        $hieghtCell = 30;
                        $name_height=10; 
                    }    
                                        
                    $x = $pdf->GetX();
                    $y = $pdf->GetY();
      
                    
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
                        $x=15 * 48/25.4; 
                        $y=15 * 48/25.4;
                        $pdf->SetXY($x, $y);
                        $x = $pdf->GetX();
                        $y = $pdf->GetY();
                        $pdf->SetFont($fontFamily, 'B', $fontSize);
                        $pdf->MultiCell(50, 15, $pdf->prepareToPdf('Артикул'), 'LT', 'C');
                        $x = $x+50;
                        $pdf->SetXY($x, $y);    
                        $pdf->MultiCell(395, 15, $pdf->prepareToPdf('Наименование'), 'LT', 'C');
                        $x = $x+395;
                        $pdf->SetXY($x, $y);
                        $pdf->MultiCell(32, 15, $pdf->prepareToPdf('Ед.'), 'LT', 'C');
                        $x = $x+32;
                        
                        $pdf->SetXY($x, $y);
                        $pdf->MultiCell(62, 15, $pdf->prepareToPdf('Цена,руб'), 'LTR', 'C');
                        $pdf->Ln(0);
                        
                    } 
                    $x = $pdf->GetX();
                    $y = $pdf->GetY();
                    $pdf->SetFont($fontFamily, '', $fontSize);
                    $pdf->MultiCell(50, $hieghtCell, $pdf->prepareToPdf($arFields['PROPERTY_ARTNUMBER_VALUE']), 'LTR', 'C');
                    
                    $x = $x+50;
                    $pdf->SetXY($x, $y);
                    
                    $pdf->MultiCell(395, $name_height, $pdf->prepareToPdf($arFields['NAME']), 'T', 'L');
                    $x = $x+395;
                    $pdf->SetXY($x, $y);
                                        
                    $pdf->MultiCell(32, $hieghtCell, $pdf->prepareToPdf(strtolower($arFields['PROPERTY_EDIZM_VALUE'])), 'LT', 'C');
                    
                    $x = $x+32;
                    $pdf->SetXY($x, $y);
                    
                    $pdf->MultiCell(62, $hieghtCell, $pdf->prepareToPdf(number_format($arFields['CATALOG_PRICE_'.$curPriceID], 2, ',', ' ')), 'LTR', 'R');
                    
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
    
    $myfile= $curSectionCode.'-'.$regionCode.'.pdf';
	$pdf->Output($myfile, 'F');
	if (!copy($myfile,$_SERVER['DOCUMENT_ROOT'].'/upload/pdf/'.$myfile))
	{ echo "err"; }else{  unlink($myfile);} 
	//echo '/upload/pdf/'.$myfile;
    
}

function getID(){
    $connection = Bitrix\Main\Application::getConnection();
    $sqlHelper = $connection->getSqlHelper();
    $sql = "SELECT id FROM cron_loads WHERE LoadTYpe=3 ORDER BY id DESC";
        $recordset = $connection->query($sql, 1);
        if ($recordrow = $recordset->fetch())
        {        
            $ID = $recordrow["id"]; 
            return $ID;
        }
    return false;       
}

if(!empty($for_report))
{   
   if ($frp = fopen($file_report, "w")){
	fwrite($frp, $for_report);
	fclose($frp);
        //exit();
	//DIE("WRITE ERR FILE");
   } else {
	exit();
	//DIE("ERR FILE NOTH OPRN");
   }
}else{
    if($id = getID()){
        $connection = Bitrix\Main\Application::getConnection();
        $sqlHelper = $connection->getSqlHelper();
        $connection->queryExecute("UPDATE cron_loads SET Status='1' WHERE id=".$id);
    }
}



require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>
