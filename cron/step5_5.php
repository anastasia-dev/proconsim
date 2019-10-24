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

$priceCode = "C";
$loadType = 2;
if(isset($argv[1])){
    $priceCode = $argv[1];
}
if(isset($argv[2])){
    $loadType = intval($argv[2]);
}

$for_report = "";
$text = "";
$fileName = date("YmdHis");
//$fp = fopen($_SERVER["DOCUMENT_ROOT"]."/cron/load-price-res-".$priceCode."-".$fileName.".txt", "a");
selectRecords();
//$text .= "\r\n\r\n";
//fwrite($fp, $text);
//fclose($fp);

function selectRecords(){    
    $connection = Bitrix\Main\Application::getConnection();
	$sqlHelper = $connection->getSqlHelper();
    $limit = 100;
    
    $arPrices = array();
    
    $sql = "SELECT id,record FROM load_prices";
    $recordset = $connection->query($sql, $limit);
    while ($recordrow = $recordset->fetch())
    {                
        $arPrices[]= unserialize($recordrow["record"]);
        $connection->queryExecute("DELETE FROM load_prices WHERE id='" . $recordrow["id"] . "'");
    }
    $countPrices = count($arPrices);

    if($countPrices>0){
        loadPrices($arPrices);
        selectRecords();
    }	      
}

function loadPrices($prices){
	global $text; 
    global $fp;  
    global $priceCode; 
    /* Коды по регионам */
	$regFilter = Array("IBLOCK_ID"=>6);
    $regPrice = array();
    $Regions = array();
    if($priceCode != "C"){
        $regSelect = array("ID","NAME","IBLOCK_ID","PROPERTY_CODE_IMPORT","PROPERTY_PRICE_ID_".$priceCode."","PROPERTY_PRICE_CODE_".$priceCode."");
        $regRes = CIBlockElement::GetList(Array(), $regFilter, false, false, $regSelect);	
    	while($regOb = $regRes->GetNextElement()){
    		$regFields = $regOb->GetFields();
    		$Regions[$regFields['ID']] = $regFields['~PROPERTY_CODE_IMPORT_VALUE'];
    		$regPrice[$regFields['ID']]['ID'] = $regFields['~PROPERTY_PRICE_ID_'.$priceCode.'_VALUE'];
    		$regPrice[$regFields['ID']]['CODE'] = $regFields['~PROPERTY_PRICE_CODE_'.$priceCode.'_VALUE'];
    	}
    }else{
        $regSelect = array("ID","NAME","IBLOCK_ID","PROPERTY_CODE_IMPORT","PROPERTY_PRICE_ID",'PROPERTY_PRICE_CODE');
        $regRes = CIBlockElement::GetList(Array(), $regFilter, false, false, $regSelect);	
    	while($regOb = $regRes->GetNextElement()){
    		$regFields = $regOb->GetFields();
    		$Regions[$regFields['ID']] = $regFields['~PROPERTY_CODE_IMPORT_VALUE'];
    		$regPrice[$regFields['ID']]['ID'] = $regFields['~PROPERTY_PRICE_ID_VALUE'];
    		$regPrice[$regFields['ID']]['CODE'] = $regFields['~PROPERTY_PRICE_CODE_VALUE'];
    	}
    }
    $arLimits = getLimits();
    foreach($prices as $price){
        if($price["Код"]){
            $arProduct = getProductID($price["Код"]);
            $ID = $arProduct["ID"];
            $active = $arProduct['ACTIVE'];
            $nalichieAll = 0;
            if(isset($price['Наличие'])){
		      $nalichieAll = $price['Наличие'];
	        }
            $limitIdOld = $arProduct['LIMIT'];
            $limit = trim($price['Ограничение']);
            $limitID = array_search($limit, $arLimits);
            
            $NALICHIE = array();
            $el = new CIBlockElement;
            foreach($price["CENA"] as $key=>$Cena){
                
                $region = $Cena['Регион']; 
                $regionCode = intval(array_search($region, $Regions));  
                if($regionCode > 0){
                    $Price = str_replace(",",".",$Cena['Сумма']);
                    $Count = $Cena['Остатки'];                                 
                    $NALICHIE[$key]['VALUE'] = $regionCode;
                    $NALICHIE[$key]['DESCRIPTION'] = $Count;
                    $CODE = $regPrice[$regionCode]['ID'];
               	
            		$arFields = Array(
            		"PRODUCT_ID" => $ID,
            		"CATALOG_GROUP_ID" => $CODE,
            		"PRICE" => $Price,
            		"CURRENCY" => "RUB");
            		$res = CPrice::GetList(array(), array("PRODUCT_ID" => $ID, "CATALOG_GROUP_ID" => $CODE));
            
            		if ($arr = $res->Fetch()){
            			CPrice::Update($arr["ID"], $arFields);
                        //$text .= iconv("UTF-8", "Windows-1251","Обновляем цену ".$arr["ID"])."\r\n";
    	                //$text .= iconv("UTF-8", "Windows-1251", serialize($arFields))."\r\n\r\n";
            		}
            		else{
            			CPrice::Add($arFields);
                        //$text .= iconv("UTF-8", "Windows-1251","Добавляем")."\r\n";
                        //$text .= iconv("UTF-8", "Windows-1251", serialize($arFields))."\r\n";
            		}
            
            		if($CODE == 2){
            			$arFieldsBase = Array(
            			"PRODUCT_ID" => $ID,
            			"CATALOG_GROUP_ID" => 1,
            			"PRICE" => $Price,
            			"CURRENCY" => "RUB");
            			$resBase = CPrice::GetList(
            			array(),
            			array(
            				"PRODUCT_ID" => $ID,
            				"CATALOG_GROUP_ID" => 1
            			));
            			if ($arrBase = $resBase->Fetch()){
            				CPrice::Update($arrBase["ID"], $arFieldsBase);
                            //$text .= "CODE = 2\r\n";
                            //$text .= iconv("UTF-8", "Windows-1251","Обновляем цену ".$arrBase["ID"])."\r\n";
    	                    //$text .= iconv("UTF-8", "Windows-1251", serialize($arFieldsBase))."\r\n\r\n";
            			}
            			else{
            				CPrice::Add($arFieldsBase);
                            //$text .= "CODE = 2\r\n";
                            //$text .= iconv("UTF-8", "Windows-1251","Добавляем")."\r\n";
                            //$text .= iconv("UTF-8", "Windows-1251", serialize($arFieldsBase))."\r\n";
            			}
            
            			if(empty($Price)){
                            $arUpdateProductArray = Array(
                                                      "MODIFIED_BY"    => 1632,   // элемент изменен текущим пользователем                                          
                                                      "ACTIVE"         => "N", // не активен
                                                      );
                             $text .= iconv("UTF-8", "Windows-1251","Цена = 0, деактивируем PRODUCT_ID=".$ID)."\r\n";                         
                            $resUp = $el->Update($ID, $arUpdateProductArray);
                            if(!$resUp){
                               //echo  $el->LAST_ERROR;
                               //$text .= "ERROR! ".$el->LAST_ERROR."\r\n";
                            }else{                                
                                //$text .= "OK! ".iconv("UTF-8", "Windows-1251", serialize($arUpdateProductArray))."\r\n";
                            }                                            
                                                                   
                        }else{
                            if($active=="N"){
                                $arUpdateProductArray = Array(
                                                      "MODIFIED_BY"    => 1632,   // элемент изменен текущим пользователем                                          
                                                      "ACTIVE"         => "Y", // не активен
                                                      ); 
                                //$text .= iconv("UTF-8", "Windows-1251","Цена <> 0, активируем PRODUCT_ID=".$ID)."\r\n";                      
                                $resUp = $el->Update($ID, $arUpdateProductArray);
                                if(!$resUp){
                                   //echo  $el->LAST_ERROR;
                                   //$text .= "ERROR! ".$el->LAST_ERROR."\r\n";
                                }else{
                                    //$text .= "OK! ".iconv("UTF-8", "Windows-1251", serialize($arUpdateProductArray))."\r\n";
                                }                                           
                            }
                        }
            		}
                }
            }
            $arrProps = array(138 => $NALICHIE, 145 => $nalichieAll);
			if($limitID!=$limitIdOld){
                if($limit=="Без ограничений"){
                    $limitID = false;
                }
            	$arrProps[156]=$limitID;
                // Новинка
                if($limitID=="limit_9"){
                    $arrProps[6]=1;
            	}else{
                    $arrProps[6]=false;  
            	}
                // Распродажа
                if($limitID=="limit_5"){
                    $arrProps[8]=3;
                    $db_old_groups = CIBlockElement::GetElementGroups($ID, true);
                    $ar_new_groups = Array(30);
                    while($ar_group = $db_old_groups->Fetch())
                        $ar_new_groups[] = $ar_group["ID"];
                    CIBlockElement::SetElementSection($ID, $ar_new_groups);            	
            	}else{
                    $arrProps[8]=false;
            	} 
            	if($limitIdOld=="limit_5"){
            		$db_old_groups = CIBlockElement::GetElementGroups($ID, true);
                    $deleteValue = 30;
            		$ar_old_groups = array();
                    while($ar_group = $db_old_groups->Fetch())
                        $ar_old_groups[] = $ar_group["ID"];
            
                    $ar_new_groups = array_diff($ar_old_groups, [$deleteValue]);
                    CIBlockElement::SetElementSection($ID, $ar_new_groups);   
                }    
			}           
            
            //$text .= iconv("UTF-8", "Windows-1251","Свойства")."\r\n"; 
            //$text .= iconv("UTF-8", "Windows-1251", serialize($arrProps))."\r\n"; 
            CIBlockElement::SetPropertyValuesEx($ID, $IBLOCK_PROD_ID, $arrProps);            
            //$text .= "\r\n\r\n";                
        }else{
            //$text .= iconv("UTF-8", "Windows-1251","Товар с артикулом ".$price["Код"]." - не найден!")."\r\n"; 
        }
    }    
    //fwrite($fp, $text);
    $text = "";
} 

function getProductID($articul){	
    $arRes = array();
    $arSelect = Array("ID", "IBLOCK_ID", "ACTIVE", "PROPERTY_ARTNUMBER", "PROPERTY_LIMIT");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
    $arFilter = Array(
                     "IBLOCK_ID"=>2,                 
                     "PROPERTY_ARTNUMBER"=>$articul,
                     );
    $resProduct = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
     if($ob = $resProduct->GetNextElement()){ 
       $arFields = $ob->GetFields(); 
          $arRes["ID"] = $arFields["ID"];
          $arRes["ACTIVE"] = $arFields["ACTIVE"];
          $arRes["LIMIT"] = $arFields['PROPERTY_LIMIT_VALUE'];
     }  
     return $arRes;
}

function getLimits(){
    $arResLimits = array();
    if (CModule::IncludeModule('highloadblock'))
    {
        
        $arHLBlockLimit = Bitrix\Highloadblock\HighloadBlockTable::getById(5)->fetch();
        $obEntityLimit = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($arHLBlockLimit);
        $strEntityDataClassLimit = $obEntityLimit->getDataClass();
        $rsDataLimit = $strEntityDataClassLimit::getList(array('select' => array('*')));

        while ($arLimits = $rsDataLimit->Fetch()) {  			                 
			$arResLimits[$arLimits["UF_XML_ID"]]= $arLimits["UF_NAME"];        
        }

    } 
    return $arResLimits; 
}

function getID(){
    global $loadType;
    $connection = Bitrix\Main\Application::getConnection();
    $sqlHelper = $connection->getSqlHelper();
    $sql = "SELECT id FROM cron_loads WHERE LoadTYpe=".$loadType." ORDER BY id DESC";
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
   $file_report = "report_step5_5.txt";
   if ($frp = fopen($_SERVER["DOCUMENT_ROOT"]."/cron/".$file_report, "w")){
	fwrite($frp, $for_report);
	fclose($frp);
        //exit();
	//DIE("WRITE ERR FILE");
   } else {
	exit();
	//DIE("ERR FILE NOTH OPRN");
   }
}




require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>
