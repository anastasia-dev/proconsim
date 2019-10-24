<?include ($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");?>
<?
$intSKUIBlock = IBLOCK_SKU_ID;
$IBLOCK_PROD_ID = IBLOCK_PRODUCT_ID;
$intSKUProperty = 31;
$url_c = $_SERVER['DOCUMENT_ROOT']."/import/catalog.xml";
$image_way = "http://www.proconsim.ru/image-imports/";
$xml_c = simplexml_load_file($url_c);
$arBId = explode(",",$_POST['b_id']);
$arBName = explode(",",$_POST['b_name']);
$BRAND_ARRAY = array();
foreach($arBId as $key_brand => $value_brand):
	$BRAND_ARRAY[strtoupper($arBName[$key_brand])] = $value_brand;
endforeach;
$count_product = 0;
$WORKING_ENVIRONMENT = array('0100_WATER' => 20, '0200_STEAM' =>21, '0300_GAS'=>22,'0400_NATURALGAS'=>23,'0500_INERTGAS'=>24,'0600_FUELGAS'=>25,'0700_AIR'=>26,'0800_NONCORRLIQUID'=>27,'0900_LIQUID_AIR'=>28,'1000_WASTEWATER'=>29,'1100_CONDENSATE'=>30,'1200_PETROL'=>31,'1300_OIL'=>32);
$CONTROL_TYPE = array('00100_MANUAL'=>33,'00200_BARESHAFT'=>34,'00300_AUTOMATIC'=>35,'00350_REDUCTOR'=>36,'00400_SPRING_DIAPH'=>37,'00500_FOR_EL_DRIVE'=>38,'00600_ELECTRIC_DRIVE'=>39);
$TYBE_TYPE = array('000100_SHOVNY' => 40, '000200_BESSHOVNY' => 41);
$STR = $_POST['str'];
$with_preview = false;
$NEW_ELEMENT = array();
$PRODUCT_ID = intval($_POST['id']);
$fileName = $_POST['fileName'];
if(intval($_POST['section']) != 0):
	$NEW_ELEMENT['SECTION_ID'] = intval($_POST['section']);
else:
	$NEW_ELEMENT['SECTION_ID'] = false;
endif;
$image_num = 0;
foreach($xml_c->offers->offer as $Offer):
	if($count_product == intval($STR)):
		$NEW_ELEMENT['NAME'] = trim($Offer['name']);
		$NEW_ELEMENT['CODE'] = CUtil::translit(trim($Offer['name']),"ru",array('max_len' => 200));
		$NEW_ELEMENT['PROPS']['ARTNUMBER'] = trim($Offer['id']);
		foreach($Offer->propertyValues->propertyValue as $PROP):
			if(substr(trim($PROP['id']),0,4) != "PIC_"):
				if(trim($PROP['id']) == "WORKING_ENVIRONMENT"):
					$prop_value = $WORKING_ENVIRONMENT[trim($PROP->value)];
				elseif(trim($PROP['id']) == "CONTROL_TYPE"):
					$prop_value = $CONTROL_TYPE[trim($PROP->value)];
				elseif(trim($PROP['id']) == "TYBE_TYPE"):
					$prop_value = $TYBE_TYPE[trim($PROP->value)];
				elseif(trim($PROP['id']) == "BRAND"):
					$prop_value = intval($BRAND_ARRAY[strtoupper(trim($PROP->value))]);
				else:
					$prop_value = trim($PROP->value);
				endif;
				$NEW_ELEMENT['PROPS'][trim($PROP['id'])] = $prop_value;
			else:
				if(trim($PROP['id']) == "PIC_1"):
					$with_preview = true;
					$image = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"]."/image-imports/".trim($PROP->value));
					$NEW_ELEMENT['PROPS']['MORE_PHOTO']['n'.$image_num] = $image;
					$image_num ++;
				else:
					$NEW_ELEMENT['PROPS']['MORE_PHOTO']['n'.$image_num] = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"]."/image-imports/".trim($PROP->value));
					$image_num ++;
				endif;
			endif;
		endforeach;
	endif;
	$count_product++;
endforeach;

CModule::IncludeModule('iblock');
CModule::IncludeModule("catalog");
$el = new CIBlockElement;

$text = "";
$fp = fopen("load-new-res-".$fileName.".txt", "a");
//echo "<hr>PRODUCT_ID = ".$PRODUCT_ID."<br />";
$text .= "PRODUCT_ID = ".$PRODUCT_ID."\r\n";
if($PRODUCT_ID == 0):
    $arLoadProductArray = Array(
      "MODIFIED_BY"    => 1, // элемент изменен текущим пользователем
      "IBLOCK_SECTION_ID" => $NEW_ELEMENT['SECTION_ID'],
      "IBLOCK_ID"      => $IBLOCK_PROD_ID,
      "PROPERTY_VALUES"=> $NEW_ELEMENT['PROPS'],
      "CODE" 		   => $NEW_ELEMENT['CODE']."_".date('is'),
      "NAME"           => $NEW_ELEMENT['NAME'],
      "ACTIVE"         => "N",            // активен
      );
      
      if($with_preview):
    		$arLoadProductArray['PREVIEW_PICTURE'] = $image;
      endif;
    echo "<pre>Новый товар<br />";
    print_r($arLoadProductArray);  
    echo "</pre>";      
    if($PRODUCT_ID = $el->Add($arLoadProductArray)) {       
       $text .= "New ID = ".$PRODUCT_ID."\r\n";
       CCatalogProduct::add(array('ID' => $PRODUCT_ID));
       $text .= iconv("UTF-8", "Windows-1251", "Новый товар")."\r\n";
       $text .= iconv("UTF-8", "Windows-1251", serialize($arLoadProductArray))."\r\n";
    } else {
       $text .= 'Error ADD: '.$el->LAST_ERROR."\r\n";
       echo $el->LAST_ERROR;
    }
    
    //$PRODUCT_ID = $el->Add($arLoadProductArray);
    //echo $el->LAST_ERROR;

    echo "ok1";
else:
    $arLoadProductArray = Array(
      "MODIFIED_BY"    => 1, // элемент изменен текущим пользователем
      "IBLOCK_SECTION_ID" => $NEW_ELEMENT['SECTION_ID'],
      "NAME"           => $NEW_ELEMENT['NAME'],
      "ACTIVE"         => "Y",            // активен
      ); 
      if($with_preview):
    		$arLoadProductArray['PREVIEW_PICTURE'] = $image;
      endif;
    echo "<pre>Обновляем товар<br />";
    print_r($arLoadProductArray);  
    echo "</pre>"; 

    $res = $el->Update($PRODUCT_ID, $arLoadProductArray);
    if(!$res){
       echo  $el->LAST_ERROR;
       $text .= 'Error UPDATE: '.$el->LAST_ERROR."\r\n";
    }else{
    	CIBlockElement::SetPropertyValuesEx(
    					  $PRODUCT_ID,
    					  $BLOCK_PROD_ID,
    					  $NEW_ELEMENT['PROPS']
    	);
    	$text .= iconv("UTF-8", "Windows-1251", "Обновляем товар")."\r\n";
    	$text .= iconv("UTF-8", "Windows-1251", serialize($arLoadProductArray))."\r\n";
    	$text .= iconv("UTF-8", "Windows-1251", serialize($NEW_ELEMENT['PROPS']))."\r\n";
    	echo "ok2";
    }
endif;

if(in_array($NEW_ELEMENT['PROPS']['BRAND'],array(337,336,338,339))):
	$mem_el = array($NEW_ELEMENT['SECTION_ID'],28);
    $text .= iconv("UTF-8", "Windows-1251", serialize($mem_el))."\r\n";
	CIBlockElement::SetElementSection($PRODUCT_ID, $mem_el);
endif;
$text .= "\r\n\r\n";
fwrite($fp, $text);
fclose($fp);
?>