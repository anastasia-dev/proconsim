<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
CModule::IncludeModule('iblock');
CModule::IncludeModule("catalog");


$url_c = $_SERVER['DOCUMENT_ROOT']."/import/prices-remains.xml";

clearTable();
$xml_c = getXML($url_c);

//echo "<pre>";
//print_r($xml_c);
//cho "</pre>";
getRecords($xml_c);
selectRecords();
function getXML($url){
    $return = array();
    if (file_exists($url)) {

        libxml_use_internal_errors(true);

        $xml = simplexml_load_file($url); 

        if (!$xml) {
            $errors = libxml_get_errors();
        
            foreach ($errors as $error) {
                echo display_xml_error($error, $xml);
            }        
            $return["err"] = libxml_clear_errors();
            return $return;
        }else{
            return $xml;
        } 

    } else {
        $return["err"] = "Не удалось открыть файл ".$url;  
        return $return;      
    }  

}

function display_xml_error($error, $xml)
{
    $return  = $xml[$error->line - 1] . "\n";
    $return .= str_repeat('-', $error->column) . "^\n";

    switch ($error->level) {
        case LIBXML_ERR_WARNING:
            $return .= "Warning $error->code: ";
            break;
         case LIBXML_ERR_ERROR:
            $return .= "Error $error->code: ";
            break;
        case LIBXML_ERR_FATAL:
            $return .= "Fatal Error $error->code: ";
            break;
    }

    $return .= trim($error->message) .
               "\n  Line: $error->line" .
               "\n  Column: $error->column";

    if ($error->file) {
        $return .= "\n  File: $error->file";
    }

    return "$return\n\n--------------------------------------------\n\n";
}


function getRecords($xml_c){
	$connection = Bitrix\Main\Application::getConnection();
	$sqlHelper = $connection->getSqlHelper();
    
    $count_product = 0;

    foreach($xml_c->Типоразмер as $Product){
    
    	if($count_product<10){
          $arProduct = array();    		
          foreach($Product->attributes() as $attributeName=>$attributeValue){    		             
              $arProduct[$attributeName] = (string)$attributeValue;
    	  }
          $num=0;
		  foreach($Product->ЦеныИОстатки->Цена as $Cena){
			  foreach($Cena->attributes() as $attributeName=>$attributeValue){
				  $arProduct["CENA"][$num][$attributeName] = (string)$attributeValue;    	   
			  } 
              $num++;
		  }     
          //echo  serialize($arProduct);  
    		$connection->queryExecute("INSERT INTO load_prices (record) VALUES ('" . serialize($arProduct) . "')");
            $count_product++;
            //echo "<pre>";
            //print_r($arProduct);
            //echo "</pre>";
    	}
    	
    }
	return $count_product;
}

function clearTable(){    
    $connection = Bitrix\Main\Application::getConnection();
    $sqlHelper = $connection->getSqlHelper();
    $connection->queryExecute("TRUNCATE TABLE load_prices");    
}

function selectRecords(){
    $connection = Bitrix\Main\Application::getConnection();
	$sqlHelper = $connection->getSqlHelper();
    $limit = 2;
    
    $arPrices = array();
    
    $sql = "SELECT id,record FROM load_prices";
    $recordset = $connection->query($sql, $limit);
    while ($recordrow = $recordset->fetch())
    {
        echo $recordrow["id"]."<br />";
        //echo "<pre>";
        //print_r(unserialize($recordrow["record"]));
        //echo "</pre>";
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
	//echo "<pre>";
	//print_r($prices);
	//echo "</pre>";
    
    /* Коды по регионам */
	$regSelect = array("ID","NAME","IBLOCK_ID","PROPERTY_CODE_IMPORT","PROPERTY_PRICE_ID",'PROPERTY_PRICE_CODE');
	$regFilter = Array("IBLOCK_ID"=>6);
	$regRes = CIBlockElement::GetList(Array(), $regFilter, false, false, $regSelect);
	$regPrice = array();
	while($regOb = $regRes->GetNextElement()){
		$regFields = $regOb->GetFields();
		$Region[$regFields['ID']] = $regFields['~PROPERTY_CODE_IMPORT_VALUE'];
		$regPrice[$regFields['ID']]['ID'] = $regFields['~PROPERTY_PRICE_ID_VALUE'];
		$regPrice[$regFields['ID']]['CODE'] = $regFields['~PROPERTY_PRICE_CODE_VALUE'];
	}
    
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
            foreach($price["CENA"] as $key=>$Cena){
                $Price = str_replace(",",".",$Cena['Сумма']);
                $Count = $Cena['Остатки'];
                $region = $Cena['Регион'];                
                $NALICHIE[$key]['VALUE'] = array_search($region, $Region);
                $NALICHIE[$key]['DESCRIPTION'] = $Count;
                $CODE = $regPrice[array_search($Cena['Регион'], $Region)]['ID'];
               	if($CODE > 0){
            		$arFields = Array(
            		"PRODUCT_ID" => $ID,
            		"CATALOG_GROUP_ID" => $CODE,
            		"PRICE" => $arPrice[$key],
            		"CURRENCY" => "RUB");
            		$res = CPrice::GetList(array(), array("PRODUCT_ID" => $ID, "CATALOG_GROUP_ID" => $CODE));
            
            		if ($arr = $res->Fetch()){
            			//CPrice::Update($arr["ID"], $arFields);
            		}
            		else{
            			//CPrice::Add($arFields);
            		}
            
            		if($CODE == 2){
            			$arFieldsBase = Array(
            			"PRODUCT_ID" => $ID,
            			"CATALOG_GROUP_ID" => 1,
            			"PRICE" => $value,
            			"CURRENCY" => "RUB");
            			$resBase = CPrice::GetList(
            			array(),
            			array(
            				"PRODUCT_ID" => $ID,
            				"CATALOG_GROUP_ID" => 1
            			));
            			if ($arrBase = $resBase->Fetch()){
            				//CPrice::Update($arrBase["ID"], $arFieldsBase);
            			}
            			else{
            				//CPrice::Add($arFieldsBase);
            			}
            
            			if(empty($value)){
                            $arUpdateProductArray = Array(
                                                      "MODIFIED_BY"    => 1,   // элемент изменен текущим пользователем                                          
                                                      "ACTIVE"         => "N", // не активен
                                                      );
                                                      
                            //$resUp = $el->Update($ID, $arUpdateProductArray);
                            //if(!$resUp){
                               //echo  $el->LAST_ERROR;
                            //}                                            
                                                                   
                        }else{
                            if($active=="N"){
                                $arUpdateProductArray = Array(
                                                      "MODIFIED_BY"    => 1,   // элемент изменен текущим пользователем                                          
                                                      "ACTIVE"         => "Y", // не активен
                                                      ); 
                                //$resUp = $el->Update($ID, $arUpdateProductArray);
                                //if(!$resUp){
                                   //echo  $el->LAST_ERROR;
                                //}                                           
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
                    //CIBlockElement::SetElementSection($ID, $ar_new_groups);            	
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
                    //CIBlockElement::SetElementSection($ID, $ar_new_groups);   
                }    
			}            
            echo "<pre>";
        	print_r($arrProps);
        	echo "</pre>";
            //CIBlockElement::SetPropertyValuesEx($ID, $IBLOCK_PROD_ID, $arrProps);            
                            
        }
    }    
    
} 

function getProductID($articul){
	//echo $articul."<br />";
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
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>