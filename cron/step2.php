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

$for_report = "";
$text = "";
$fileName = date("YmdHis");
$fp = fopen($_SERVER["DOCUMENT_ROOT"]."/cron/load-new-res-".$fileName.".txt", "a");
selectRecords();
$text .= "\r\n\r\n";
fwrite($fp, $text);
fclose($fp);

function selectRecords(){    
    $connection = Bitrix\Main\Application::getConnection();
	$sqlHelper = $connection->getSqlHelper();
    $limit = 500;
    
    $arProducts = array();
    
    $sql = "SELECT id,record FROM load_products";
    $recordset = $connection->query($sql, $limit);
    while ($recordrow = $recordset->fetch())
    {        
        $arProducts[]= unserialize($recordrow["record"]);
        $connection->queryExecute("DELETE FROM load_products WHERE id='" . $recordrow["id"] . "'");
    }
    $countProducts = count($arProducts);
    if($countProducts>0){
        loadProducts($arProducts);
        selectRecords();
    }	      
}

function loadProducts($products){
    global $text;
    
    CModule::IncludeModule("iblock");
    CModule::IncludeModule("catalog");
    
    $IBLOCK_PROD_ID = IBLOCK_PRODUCT_ID;
    $arSections = getSections();
    $arBrands = getBrands();
    
    $WORKING_ENVIRONMENT = array('0100_WATER' => 20, '0200_STEAM' =>21, '0300_GAS'=>22,'0400_NATURALGAS'=>23,'0500_INERTGAS'=>24,'0600_FUELGAS'=>25,'0700_AIR'=>26,'0800_NONCORRLIQUID'=>27,'0900_LIQUID_AIR'=>28,'1000_WASTEWATER'=>29,'1100_CONDENSATE'=>30,'1200_PETROL'=>31,'1300_OIL'=>32);
    $CONTROL_TYPE = array('00100_MANUAL'=>33,'00200_BARESHAFT'=>34,'00300_AUTOMATIC'=>35,'00350_REDUCTOR'=>36,'00400_SPRING_DIAPH'=>37,'00500_FOR_EL_DRIVE'=>38,'00600_ELECTRIC_DRIVE'=>39);
    $TYBE_TYPE = array('000100_SHOVNY' => 40, '000200_BESSHOVNY' => 41);
    $image_num = 0;

	foreach($products as $product){
		if($product["id"]){
            $NEW_ELEMENT = array();
            $with_preview = false;
			$PRODUCT_ID = intval(getProductID($product['id']));
            $text .= "PRODUCT_ID = ".$PRODUCT_ID."\r\n";
            $SECTION_ID = intval($arSections[intval($product['modelID'])]);              
			if(empty($SECTION_ID)){
                $NEW_ELEMENT['SECTION_ID'] = false;
			}else{
                $NEW_ELEMENT['SECTION_ID'] = $SECTION_ID; 
			}
            $NEW_ELEMENT['NAME'] = trim($product['name']);
            $NEW_ELEMENT['CODE'] = CUtil::translit(trim($product['name']),"ru",array('max_len' => 200));
		    $NEW_ELEMENT['PROPS']['ARTNUMBER'] = trim($product['id']);
            
            foreach($product['props'] as $props){
                foreach($props as $name=>$val){
                    if(substr(trim($name),0,4) != "PIC_"){
                        if($name == "WORKING_ENVIRONMENT"){
                            $prop_value = $WORKING_ENVIRONMENT[trim($val)];
                        }elseif($name == "CONTROL_TYPE"){
                            $prop_value = $CONTROL_TYPE[trim($val)];
                        }elseif($name == "TYBE_TYPE"){
                            $prop_value = $TYBE_TYPE[trim($val)];
                       }elseif($name == "BRAND"){
                            $prop_value = intval($arBrands[strtoupper(trim($val))]);
                        }else{
                            $prop_value = trim($val);
                        }
                        
                        $NEW_ELEMENT['PROPS'][trim($name)] = htmlspecialchars_decode($prop_value, ENT_QUOTES);
                    }else{
                        if(trim($name) == "PIC_1"){
                            $with_preview = true;
        					$image = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"]."/image-imports/".trim($val));
        					$NEW_ELEMENT['PROPS']['MORE_PHOTO']['n'.$image_num] = $image;
        					$image_num ++;
                        }else{
                            $NEW_ELEMENT['PROPS']['MORE_PHOTO']['n'.$image_num] = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"]."/image-imports/".trim($val));
		                    $image_num ++;
                        }
                    }
                }
            } 
            $el = new CIBlockElement;
           //НОВЫЙ
           if($PRODUCT_ID == 0){
                $arLoadProductArray = Array(
                  "MODIFIED_BY"    => 1632, // элемент изменен текущим пользователем
                  "IBLOCK_SECTION_ID" => $NEW_ELEMENT['SECTION_ID'],
                  "IBLOCK_ID"      => $IBLOCK_PROD_ID,
                  "PROPERTY_VALUES"=> $NEW_ELEMENT['PROPS'],
                  "CODE" 		   => $NEW_ELEMENT['CODE']."_".date('is'),
                  "NAME"           => $NEW_ELEMENT['NAME'],
                  "ACTIVE"         => "Y",            // активен
                  );
                  
                if($with_preview):
                		$arLoadProductArray['PREVIEW_PICTURE'] = $image;
                endif;   
                $text .= "Новый товар\r\n";
                $text .= iconv("UTF-8", "Windows-1251", serialize($arLoadProductArray))."\r\n";             
                
                if($PRODUCT_ID = $el->Add($arLoadProductArray)) {       
                   $text .= "New ID = ".$PRODUCT_ID."\r\n";
                   CCatalogProduct::add(array('ID' => $PRODUCT_ID));                   
                } else {
                   $text .= 'Error ADD: '.$el->LAST_ERROR."\r\n";                   
                }
                        
           }else{
            // ОБНОВЛЯЕМ
                $arLoadProductArray = Array(
                  "MODIFIED_BY"    => 1632, // элемент изменен текущим пользователем
                  "IBLOCK_SECTION_ID" => $NEW_ELEMENT['SECTION_ID'],
                  "NAME"           => $NEW_ELEMENT['NAME'],
                  "ACTIVE"         => "Y",            // активен
                  ); 
                if($with_preview):
                		$arLoadProductArray['PREVIEW_PICTURE'] = $image;
                endif;  
                $text .= "Обновляем товар\r\n";
    	        $text .= iconv("UTF-8", "Windows-1251", serialize($arLoadProductArray))."\r\n\r\n";
    	        $text .= iconv("UTF-8", "Windows-1251", serialize($NEW_ELEMENT['PROPS']))."\r\n";  
                
                
                $res = $el->Update($PRODUCT_ID, $arLoadProductArray);
                if(!$res){                   
                   $text .= 'Error UPDATE: '.$el->LAST_ERROR."\r\n";
                }else{
                	CIBlockElement::SetPropertyValuesEx(
                					  $PRODUCT_ID,
                					  $BLOCK_PROD_ID,
                					  $NEW_ELEMENT['PROPS']
                	);                	
                }                
           }
           
           if(in_array($NEW_ELEMENT['PROPS']['BRAND'],array(337,336,338,339, 423))){
            	$mem_el = array($NEW_ELEMENT['SECTION_ID'],28);
                $text .= iconv("UTF-8", "Windows-1251", serialize($mem_el))."\r\n";
            	CIBlockElement::SetElementSection($PRODUCT_ID, $mem_el);
           }
           
           $text .= "\r\n\r\n";
		}else{
		   $text .= "Ошибка: ".$product["id"]."\r\n";
           $text .= iconv("UTF-8", "Windows-1251", serialize($product))."\r\n";
           $text .= "\r\n\r\n";
		}
	}
} 

function getProductID($articul){
	//echo $articul."<br />\n";
    $arSelect = Array("ID", "IBLOCK_ID", "PROPERTY_ARTNUMBER");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
    $arFilter = Array(
                     "IBLOCK_ID"=>2,                 
                     "PROPERTY_ARTNUMBER"=>$articul,
                     );
    $resProduct = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
     if($ob = $resProduct->GetNextElement()){ 
       $arFields = $ob->GetFields(); 
          //echo $arFields["ID"]."<br />\n";
          return $arFields["ID"];
     }
     return false;  
}

function getSections(){
    $arFilter = Array('IBLOCK_ID'=>IBLOCK_PRODUCT_ID);
	$db_list = CIBlockSection::GetList(Array(), $arFilter, false, array('ID','UF_EXPORT_ID'));
	$arSections = array();
	while($ar_result = $db_list->GetNext())
	{
	    if(strlen($ar_result["UF_EXPORT_ID"]) > 0){
		  $arSections[$ar_result['UF_EXPORT_ID']] = $ar_result['ID'];
        }
	}
    return $arSections; 
} 
function getBrands(){
    $brSelect = array("ID","NAME");
	$brFilter = Array("IBLOCK_ID"=>5);
	$brRes = CIBlockElement::GetList(Array(), $brFilter, false, false, $brSelect);
	$arBrands = array();
	while($brOb = $brRes->GetNextElement()){
		$brFields = $brOb->GetFields();
        $arBrands[strtoupper(trim($brFields['NAME']))] = $brFields['ID'];		
	}
    return $arBrands;
}

function getID(){
    $connection = Bitrix\Main\Application::getConnection();
    $sqlHelper = $connection->getSqlHelper();
    $sql = "SELECT id FROM cron_loads WHERE LoadTYpe=1 ORDER BY id DESC";
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
   $file_report = "report_step2.txt";
   if ($frp = fopen($_SERVER["DOCUMENT_ROOT"]."/cron/".$file_report, "w")){
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
