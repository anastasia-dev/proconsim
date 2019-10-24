<?include ($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");?>
<?
$intSKUIBlock = IBLOCK_SKU_ID;
$IBLOCK_PROD_ID = IBLOCK_PRODUCT_ID;
$intSKUProperty = 31;
if(CModule::IncludeModule('iblock') and CModule::IncludeModule("catalog")){
	$ID = $_POST['id'];
    $active = $_POST['active'];
	$arPrice = explode(";",$_POST['price']);
	$arPriceCode = explode(";",$_POST['pricecode']);
	$arCount = explode(";",$_POST['count']);
	$arSklad = explode(";",$_POST['sklad']);
    $nalichieAll = intval($_POST["nalichie"]);
    $limit = $_POST['limit'];
    $limitIdOld = $_POST['limitOld'];
	$NALICHIE = array();
	foreach($arCount as $key_count => $Count):
		$NALICHIE[$key_count]['VALUE'] = $arSklad[$key_count];
		$NALICHIE[$key_count]['DESCRIPTION'] = $Count;
	endforeach;
    $arLId = explode(",",$_POST['l_id']);
    $arLName = explode(",",$_POST['l_name']);
    $limitID = $arLId[array_search($limit, $arLName)];
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
    		//PropertyIndex\Manager::updateElementIndex($IBLOCK_PROD_ID, $ID);
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
	CIBlockElement::SetPropertyValuesEx($ID, $IBLOCK_PROD_ID, $arrProps);
	//CCatalogProduct::Update($ID,array('QUANTITY' => 100));
	$el = new CIBlockElement;
	foreach($arPrice as $key => $value):
		$CODE = intval($arPriceCode[$key]);

	//if($CODE == 0):
	//$CODE = 1;
	//endif;
	if($CODE > 0){
		$arFields = Array(
		"PRODUCT_ID" => $ID,
		"CATALOG_GROUP_ID" => $CODE,
		"PRICE" => $arPrice[$key],
		"CURRENCY" => "RUB");
		$res = CPrice::GetList(array(), array("PRODUCT_ID" => $ID, "CATALOG_GROUP_ID" => $CODE));

		if ($arr = $res->Fetch()){
			CPrice::Update($arr["ID"], $arFields);
		}
		else{
			CPrice::Add($arFields);
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
				CPrice::Update($arrBase["ID"], $arFieldsBase);
			}
			else{
				CPrice::Add($arFieldsBase);
			}

			if(empty($value)){
                $arUpdateProductArray = Array(
                                          "MODIFIED_BY"    => 1,   // элемент изменен текущим пользователем                                          
                                          "ACTIVE"         => "N", // не активен
                                          );
                                          
                $resUp = $el->Update($ID, $arUpdateProductArray);
                if(!$resUp){
                   echo  $el->LAST_ERROR;
                }                                            
                                                       
            }else{
                if($active=="N"){
                    $arUpdateProductArray = Array(
                                          "MODIFIED_BY"    => 1,   // элемент изменен текущим пользователем                                          
                                          "ACTIVE"         => "Y", // не активен
                                          ); 
                    $resUp = $el->Update($ID, $arUpdateProductArray);
                    if(!$resUp){
                       echo  $el->LAST_ERROR;
                    }                                           
                }
            }
            
              
		}
    }

	endforeach;
}
echo "ok";?>				