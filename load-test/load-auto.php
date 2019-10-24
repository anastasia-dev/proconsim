<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
CModule::IncludeModule('iblock');
CModule::IncludeModule("catalog");

$text = "";
$fp = fopen("load-res-".date("YmdHis").".txt", "a");
$text .= "START: ". date("Y-m-d H:i:s")."\r\n";
clearTable();
$text .= "STEP 1 (TRUNCATE TABLE load_products).\r\n";
$url_c = $_SERVER['DOCUMENT_ROOT']."/import/catalog.xml";
$xml_c = getXML($url_c);
if($xml_c["err"]){ 
	$text .= "STEP 2 (getXML). ERROR: ".$xml_c["err"]."\r\n";
}else{
	$text .= "STEP 2 (getXML). OK.\r\n";
	getRecords($xml_c);
	selectRecords();
}
$text .= "END: ". date("Y-m-d H:i:s")."\r\n";
fwrite($fp, $text);
fclose($fp);

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

    foreach($xml_c->offers->offer as $Offer){
    
		//if($count_product<150){
        $arProduct = array();
    		//echo "<pre>";
    		//print_r((array)$Offer);
    		//echo "</pre>";
          foreach($Offer->attributes() as $attributeName=>$attributeValue){
    		  //echo  $attributeName." = ". $attributeValue ."<br />";             
              $arProduct[$attributeName] = (string)htmlspecialchars($attributeValue, ENT_QUOTES);
    	  }
    	  foreach($Offer->picture->attributes() as $attributeName=>$attributeValue){
    		  //echo  $attributeName." = ". $attributeValue ."<br />";             
              $arProduct["picture"][$attributeName] = (string)$attributeValue;
    	  }
          foreach($Offer->propertyValues->propertyValue as $Prop){    
    		  //echo   $Prop["id"]." = ". $Prop->value."<br />";             
    		  $arProduct["props"][] = array((string)$Prop["id"]=>(string)$Prop->value);
    	  }
            //echo "<pre>Product";
    		//print_r($arProduct);
    		//echo "</pre>";
    		//echo serialize($arProduct);
    		//$DB->Query("INSERT INTO load_products (record) VALUES ('" . serialize($arProduct) . "')");
    		$connection->queryExecute("INSERT INTO load_products (record) VALUES ('" . serialize($arProduct) . "')");
            $count_product++;
			//}
    	
}
	echo "Запись в БД: ".$count_product."<br />";

}

function clearTable(){    
    $connection = Bitrix\Main\Application::getConnection();
    $sqlHelper = $connection->getSqlHelper();
    $connection->queryExecute("TRUNCATE TABLE load_products");    
}

function selectRecords(){
    $connection = Bitrix\Main\Application::getConnection();
	$sqlHelper = $connection->getSqlHelper();
    $limit = 2;
    
    $arProducts = array();
    
    $sql = "SELECT id,record FROM load_products";
    $recordset = $connection->query($sql, $limit);
    while ($recordrow = $recordset->fetch())
    {
        echo $recordrow["id"]."<br />";
        echo "<pre>";
        print_r(unserialize($recordrow["record"]));
        echo "</pre>";
        $arProducts[]= unserialize($recordrow["record"]);
        $connection->queryExecute("DELETE FROM load_products WHERE id='" . $recordrow["id"] . "'");
    }
    $countProducts = count($arProducts);
    if($countProducts>0){
		//loadProducts($arProducts);
        selectRecords();
    }	      
}

function loadProducts($products){
	echo "<pre>";
	print_r($products);
	echo "</pre>";
    $IBLOCK_PROD_ID = IBLOCK_PRODUCT_ID;
    $arSections = getSections();
    $arBrands = getBrands();
    echo "<pre>";
	print_r($arBrands);
	echo "</pre>";
    $WORKING_ENVIRONMENT = array('0100_WATER' => 20, '0200_STEAM' =>21, '0300_GAS'=>22,'0400_NATURALGAS'=>23,'0500_INERTGAS'=>24,'0600_FUELGAS'=>25,'0700_AIR'=>26,'0800_NONCORRLIQUID'=>27,'0900_LIQUID_AIR'=>28,'1000_WASTEWATER'=>29,'1100_CONDENSATE'=>30,'1200_PETROL'=>31,'1300_OIL'=>32);
    $CONTROL_TYPE = array('00100_MANUAL'=>33,'00200_BARESHAFT'=>34,'00300_AUTOMATIC'=>35,'00350_REDUCTOR'=>36,'00400_SPRING_DIAPH'=>37,'00500_FOR_EL_DRIVE'=>38,'00600_ELECTRIC_DRIVE'=>39);
    $TYBE_TYPE = array('000100_SHOVNY' => 40, '000200_BESSHOVNY' => 41);
    $image_num = 0;

	foreach($products as $product){
		if($product["id"]){
            $NEW_ELEMENT = array();
            $with_preview = false;
			$PRODUCT_ID = getProductID($product['id']);
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
                        
                        $NEW_ELEMENT['PROPS'][trim($name)] = $prop_value;
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

           //НОВЫЙ
           if($PRODUCT_ID == 0){
                $arLoadProductArray = Array(
                  "MODIFIED_BY"    => 1, // элемент изменен текущим пользователем
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
                
                echo "<pre>";
            	print_r($arLoadProductArray);
            	echo "</pre>";          
           }else{
            // ОБНОВЛЯЕМ
                $arLoadProductArray = Array(
                  "MODIFIED_BY"    => 1, // элемент изменен текущим пользователем
                  "IBLOCK_SECTION_ID" => $NEW_ELEMENT['SECTION_ID'],
                  "NAME"           => $NEW_ELEMENT['NAME'],
                  "ACTIVE"         => "Y",            // активен
                  ); 
                if($with_preview):
                		$arLoadProductArray['PREVIEW_PICTURE'] = $image;
                endif;
                echo "<pre>";
            	print_r($arLoadProductArray);
            	echo "</pre>";    
           }
		}
	}
} 

function getProductID($articul){
	echo $articul."<br />";
    $arSelect = Array("ID", "IBLOCK_ID", "PROPERTY_ARTNUMBER");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
    $arFilter = Array(
                     "IBLOCK_ID"=>2,                 
                     "PROPERTY_ARTNUMBER"=>$articul,
                     );
    $resProduct = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
     if($ob = $resProduct->GetNextElement()){ 
       $arFields = $ob->GetFields(); 
          echo $arFields["ID"]."<br />";
     }  
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
//$connection->queryExecute("INSERT INTO load_products (record) VALUES ('TEST')");

?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>