<?include ($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");?>
<?
$intSKUIBlock = IBLOCK_SKU_ID;
$IBLOCK_PROD_ID = IBLOCK_PRODUCT_ID;
$intSKUProperty = 31;
$url_c = $_SERVER['DOCUMENT_ROOT']."/import/additemprop.xml";
$xml_c = simplexml_load_file($url_c);
$STR = $_POST['str'];
$UPDATE = array();
$recommend_product = 0;
$NEW_SECTION = array();
foreach($xml_c->Типоразмеры->Типоразмер as $Offer):
	if($recommend_product == $STR):
		$MAIN_ID = intval($Offer['Код']);
		foreach($Offer->Свойства->Свойство as $Prop):
			if(trim($Prop['id'])=="NOVELTY"):
				$UPDATE['NEWPRODUCT'] = 1;
				$NEW_SECTION[] = 31;
			elseif(trim($Prop['id'])=="SALE"):
				$UPDATE['SPECIALOFFER'] = 3;
				$NEW_SECTION[] = 30;
			else:
				$UPDATE['SALELEADER'] = 2;
			endif;
		endforeach;
	endif;
	$recommend_product++;
endforeach;
CModule::IncludeModule('iblock');
$arSelect = Array("ID", "NAME", "IBLOCK_ID","PROPERTY_ARTNUMBER");
$arFilter = Array("IBLOCK_ID"=>IBLOCK_PRODUCT_ID, "ACTIVE"=>"Y", "PROPERTY_ARTNUMBER" => $MAIN_ID);
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
while($ob = $res->GetNextElement())
{
	$arFields = $ob->GetFields();
	if(intval($arFields['~PROPERTY_ARTNUMBER_VALUE']) == $MAIN_ID):
		$MAIN_ID_NEW = $arFields['ID'];
	endif;
}
if($MAIN_ID_NEW != $MAIN_ID):
	
	$db_old_groups = CIBlockElement::GetElementGroups($MAIN_ID_NEW, true);
	$ar_new_groups = Array($NEW_GROUP_ID);
	while($ar_group = $db_old_groups->Fetch())
		$NEW_SECTION[] = $ar_group["ID"];
	CIBlockElement::SetElementSection($MAIN_ID_NEW, $NEW_SECTION);
	CIBlockElement::SetPropertyValuesEx($MAIN_ID_NEW, $IBLOCK_PROD_ID, $UPDATE);
	echo $MAIN_ID_NEW;
endif;
?>
