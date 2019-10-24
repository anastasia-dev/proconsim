<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
CModule::IncludeModule("catalog");
if(CModule::IncludeModule('iblock')){
    $intSKUIBlock = IBLOCK_SKU_ID;
    $IBLOCK_PROD_ID = IBLOCK_PRODUCT_ID;
    //$intSKUProperty = 31;
	$TEK_ARRAY = array();
	$SKU_ARRAY = array();
	$arFilter = Array('IBLOCK_ID'=>IBLOCK_PRODUCT_ID);
	$db_list = CIBlockSection::GetList(Array(), $arFilter, false, array('ID','UF_EXPORT_ID'));
	$arSectionId = array();
	while($ar_result = $db_list->GetNext())
	{
		$arSectionId[$ar_result['UF_EXPORT_ID']] = $ar_result['ID'];
	}
	$arSelect = Array("ID", "NAME", "IBLOCK_ID", "CODE", "PROPERTY_ARTNUMBER");
	$arFilter = Array("IBLOCK_ID"=>IBLOCK_PRODUCT_ID);
	$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
	while($ob = $res->GetNextElement())
	{
		$arFields = $ob->GetFields();
		$TEK_ARRAY[$arFields['~PROPERTY_ARTNUMBER_VALUE']]['ID'] = $arFields['ID'];
		$TEK_ARRAY[$arFields['~PROPERTY_ARTNUMBER_VALUE']]['CODE'] = $arFields['CODE'];
		$TEK_ARRAY[$arFields['~PROPERTY_ARTNUMBER_VALUE']]['NAME'] = $arFields['~NAME'];
	}
    /*
	$SKUSelect = Array("ID", "NAME", "IBLOCK_ID", "PROPERTY_REGIONS", "PROPERTY_ARTNUMBER");
	$SKUFilter = Array("IBLOCK_ID"=>IBLOCK_SKU_ID, "ACTIVE"=>"Y");
	$SKUres = CIBlockElement::GetList(Array(), $SKUFilter, false, false, $SKUSelect);
	while($SKUob = $SKUres->GetNextElement())
	{
		$SKUFields = $SKUob->GetFields();
		$SKU_ARRAY[$SKUFields['~PROPERTY_ARTNUMBER_VALUE']][$SKUFields['~PROPERTY_REGIONS_VALUE']]['ID'] = $SKUFields['~ID'];
	}/*
    /* Бренды */
	$brSelect = array("ID","NAME");
	$brFilter = Array("IBLOCK_ID"=>5);
	$brRes = CIBlockElement::GetList(Array(), $brFilter, false, false, $brSelect);
	$BRAND_ARRAY = array();
	while($brOb = $brRes->GetNextElement()){
		$brFields = $brOb->GetFields();		
        $BRAND_ARRAY[strtoupper($brFields['NAME'])] = $brFields['ID'];
	}
    //echo "<pre>";
    //print_r($BRAND_ARRAY);
    //echo "</pre>";
 
    
    $WORKING_ENVIRONMENT = array('0100_WATER' => 20, '0200_STEAM' =>21, '0300_GAS'=>22,'0400_NATURALGAS'=>23,'0500_INERTGAS'=>24,'0600_FUELGAS'=>25,'0700_AIR'=>26,'0800_NONCORRLIQUID'=>27,'0900_LIQUID_AIR'=>28,'1000_WASTEWATER'=>29,'1100_CONDENSATE'=>30,'1200_PETROL'=>31,'1300_OIL'=>32);
    $CONTROL_TYPE = array('00100_MANUAL'=>33,'00200_BARESHAFT'=>34,'00300_AUTOMATIC'=>35,'00350_REDUCTOR'=>36,'00400_SPRING_DIAPH'=>37,'00500_FOR_EL_DRIVE'=>38,'00600_ELECTRIC_DRIVE'=>39);
    $TYBE_TYPE = array('000100_SHOVNY' => 40, '000200_BESSHOVNY' => 41);     
    $image_way = "http://www.proconsim.ru/image-imports/";
    $url_c = $_SERVER['DOCUMENT_ROOT']."/import/catalog.xml";
    $xml_c = simplexml_load_file($url_c);
    $count_product = 0;
    $el = new CIBlockElement;
    foreach($xml_c->offers->offer as $Offer){
       if($count_product<5){ 
        
        $with_preview = false;
        $NEW_ELEMENT = array();
        $image_num = 0;
        $SECTION_ID = intval($arSectionId[intval($Offer['modelID'])]);
        $PRODUCT_ID = $TEK_ARRAY[intval($Offer['id'])]['ID'];
        $NEW_ELEMENT['NAME'] = trim($Offer['name']);
		$NEW_ELEMENT['CODE'] = CUtil::translit(trim($Offer['name']),"ru",array('max_len' => 200));
		$NEW_ELEMENT['PROPS']['ARTNUMBER'] = trim($Offer['id']);
        if($SECTION_ID != 0):
        	$NEW_ELEMENT['SECTION_ID'] = $SECTION_ID;
        else:
        	$NEW_ELEMENT['SECTION_ID'] = false;
        endif;
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
        
        
        if($PRODUCT_ID == 0):
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
              
            //$PRODUCT_ID = $el->Add($arLoadProductArray);
            //echo $el->LAST_ERROR;
            //CCatalogProduct::add(array('ID' => $PRODUCT_ID, 'QUANTITY' => 100));
            
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
            /*  
            $res = $el->Update($PRODUCT_ID, $arLoadProductArray);
            if(!$res){
               echo  $el->LAST_ERROR;
            }else{
            	CIBlockElement::SetPropertyValuesEx(
            					  $PRODUCT_ID,
            					  $BLOCK_PROD_ID,
            					  $NEW_ELEMENT['PROPS']
            	);
            }*/
        endif;
        
        echo "<pre>";
        print_r($arLoadProductArray);
        echo "</pre>";
        
        
        if(in_array($NEW_ELEMENT['PROPS']['BRAND'],array(337,336,338,339))):
        	$mem_el = array($NEW_ELEMENT['SECTION_ID'],28);
        	//CIBlockElement::SetElementSection($PRODUCT_ID, $mem_el);
        endif;
        
        //echo $count_product.". ".intval($TEK_ARRAY[intval($Offer['id'])]['ID'])." ".intval($arSectionId[intval($Offer['modelID'])])."<br />";	
    	$count_product++;
      }  
    }
} 
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>