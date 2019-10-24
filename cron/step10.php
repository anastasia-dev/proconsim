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


$connection = Bitrix\Main\Application::getConnection();
$sqlHelper = $connection->getSqlHelper();
        
$connection->queryExecute("INSERT INTO cron_loads (LoadDate,LoadTYpe,FileDateUnix,FileDate,Status) VALUES (NOW(),'5','0',NOW(),'0')");

$file_report = $_SERVER["DOCUMENT_ROOT"]."/cron/report_step10.txt";
if (file_exists($file_report)) {
    unlink($file_report);
}    
$for_report = "";

clearTable();
$arRegions = getRegions(); 
getRecords($arRegions);


function getRegions(){   
   $arRegions = array();
   $arSelectRegions = Array("ID", "IBLOCK_ID", "NAME", "CODE", "PROPERTY_PRICE_ID", "PROPERTY_PHONE_PDF", "PROPERTY_EMAIL_PDF");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
   $arFilterRegions = Array(
                         "IBLOCK_ID"=>6, 
                         "ACTIVE"=> "Y",
                         "ID" => 334 
   );
   $resRegions = CIBlockElement::GetList(Array("SORT"=>"asc"), $arFilterRegions, false, false, $arSelectRegions);
   while($obRegions = $resRegions->GetNextElement()){ 
        $arRegionsFields = $obRegions->GetFields();               
        $arRegions[$arRegionsFields["ID"]] = array("NAME"     => $arRegionsFields["NAME"], 
                                                   "CODE"     => $arRegionsFields["CODE"], 
                                                   "PRICE_ID" => $arRegionsFields["PROPERTY_PRICE_ID_VALUE"]
                                             );
       if(empty($arRegionsFields["PROPERTY_PHONE_PDF_VALUE"])){
            $arRegions[$arRegionsFields["ID"]]["PHONE"] = "+7 (495) 988-00-32";
       }else{
            $arRegions[$arRegionsFields["ID"]]["PHONE"] = $arRegionsFields["PROPERTY_PHONE_PDF_VALUE"];
       }                                            
       if(empty($arRegionsFields["PROPERTY_EMAIL_PDF_VALUE"])){
            $arRegions[$arRegionsFields["ID"]]["EMAIL"] = "info@proconsim.ru";
       }else{
            $arRegions[$arRegionsFields["ID"]]["EMAIL"] = $arRegionsFields["PROPERTY_EMAIL_PDF_VALUE"];
       }             
   } 
   return $arRegions;
} 

function getRecords($arRegions){  
    $connection = Bitrix\Main\Application::getConnection();
	$sqlHelper = $connection->getSqlHelper();
    
    foreach($arRegions as $regID=>$region){
        $arSections = array(); 
        $arSections[$regID]["NAME"] = $region["NAME"];
        $arSections[$regID]["CODE"] = $region["CODE"];
        $arSections[$regID]["PRICE_ID"] = $region["PRICE_ID"];
        $arSections[$regID]["PHONE"] = $region["PHONE"];
        $arSections[$regID]["EMAIL"] = $region["EMAIL"];   
                       
       $arFilter = array('IBLOCK_ID' => 2,'ACTIVE' => 'Y','GLOBAL_ACTIVE' => 'Y', 'SECTION_ID'=>false,'!ID' => array(28,29,30,31,92)); 
       $rsSect = CIBlockSection::GetList(array('SORT' => 'asc'),$arFilter,true,array('ID','NAME','CODE','LEFT_MARGIN','RIGHT_MARGIN','DEPTH_LEVEL'));
       while ($arSect = $rsSect->GetNext())
       {	  
    	   if($arSect["ELEMENT_CNT"]>0){    	   		          
                   
                $arSubFilterCount = Array(
    			"IBLOCK_ID"=>$arSect["IBLOCK_ID"],
    			"SECTION_ID"=>$arSect["ID"]
    			);
    	        $countSub = CIBlockSection::GetCount($arSubFilterCount);    		   
               
               
                    $arSections[$regID]["SECTION_ID"] = $arSect["ID"];
                    $arSections[$regID]["SECTION_NAME"] = $arSect["NAME"];
                    $arSections[$regID]["SECTION_CODE"] = $arSect["CODE"];                    
                    $arSections[$regID]["COUNT_SUBS"] = $countSub;
                    
              
    		   if($countSub>0){
                   $arFilterSub = array('IBLOCK_ID' => $arSect['IBLOCK_ID'],'ACTIVE' => 'Y','GLOBAL_ACTIVE' => 'Y','>LEFT_MARGIN' => $arSect['LEFT_MARGIN'],'<RIGHT_MARGIN' => $arSect['RIGHT_MARGIN'],'>DEPTH_LEVEL' => $arSect['DEPTH_LEVEL']); 
    			   $rsSectSub = CIBlockSection::GetList(array('left_margin' => 'asc'),$arFilterSub,true,array('ID','NAME','CODE'));
                   $arSubSections = array();
                   $arSections[$regID]["SUB_SECTIONS"] = array();
    			   while ($arSectSub = $rsSectSub->GetNext())
    			   {
    				   
                            $arSubSections[$regID]["NAME"] = $region["NAME"];
                            $arSubSections[$regID]["CODE"] = $region["CODE"];
                            $arSubSections[$regID]["PRICE_ID"] = $region["PRICE_ID"];
                            $arSubSections[$regID]["PHONE"] = $region["PHONE"];
                            $arSubSections[$regID]["EMAIL"] = $region["EMAIL"];
                            $arSubSections[$regID]["SECTION_ID"] = $arSectSub["ID"];
                            $arSubSections[$regID]["SECTION_NAME"] = $arSectSub["NAME"];
                            $arSubSections[$regID]["SECTION_CODE"] = $arSectSub["CODE"];
                            $arSubSections[$regID]["PARENT_ID"] = $arSect["ID"];
                            $arSubSections[$regID]["PARENT_NAME"] = $arSect["NAME"];
                            $arSubSections[$regID]["COUNT_SUBS"] = 0;
                            $arSections[$regID]["SUB_SECTIONS"][$arSectSub["ID"]] = $arSectSub["NAME"];       
                       
                       $connection->queryExecute("INSERT INTO load_groups (record) VALUES ('" . serialize($arSubSections) . "')");
    					
    			   }      
    		   }             
               $connection->queryExecute("INSERT INTO load_groups (record) VALUES ('" . serialize($arSections) . "')");  
    	   }
           
       
       }
    } 
}

function clearTable(){    
    $connection = Bitrix\Main\Application::getConnection();
    $sqlHelper = $connection->getSqlHelper();
    $connection->queryExecute("TRUNCATE TABLE load_groups");    
}


require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>
