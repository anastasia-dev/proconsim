<?include ($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");?>
<?
$intSKUIBlock = IBLOCK_SKU_ID;
$IBLOCK_PROD_ID = IBLOCK_PRODUCT_ID;
$intSKUProperty = 31;
$url_c = $_SERVER['DOCUMENT_ROOT']."/import/product-links.xml";
$xml_c = simplexml_load_file($url_c);

$STR = $_POST['str'];
$recommend_product = 0;
$FULL_ARTNUMBER = array();
$F_RECOMMEND = array();
$F_RECOMMEND_ID = array();
$S_RECOMMEND = array();
$S_RECOMMEND_ID = array();
foreach($xml_c->Типоразмеры->Типоразмер as $Offer):
	if($recommend_product == $STR):
		$MAIN_ID = intval($Offer['Код']);
		$FULL_ARTNUMBER[] = intval($Offer['Код']);
		foreach($Offer->АналогичныеТипоразмеры->АналогичныйТипоразмер as $F_ART):
			$FULL_ARTNUMBER[] = intval($F_ART['id']); 
			$F_RECOMMEND[] = intval($F_ART['id']);
		endforeach;
		foreach($Offer->СопутствующиеТипоразмеры->СопутствующийТипоразмер as $S_ART):
			$FULL_ARTNUMBER[] = intval($S_ART['id']); 
			$S_RECOMMEND[] = intval($S_ART['id']);
		endforeach;
	endif;
	$recommend_product++;
endforeach;
CModule::IncludeModule('iblock');
$arSelect = Array("ID", "NAME", "IBLOCK_ID","PROPERTY_ARTNUMBER");
$arFilter = Array("IBLOCK_ID"=>IBLOCK_PRODUCT_ID, "ACTIVE"=>"Y", "PROPERTY_ARTNUMBER" => $FULL_ARTNUMBER);
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
while($ob = $res->GetNextElement())
{
	$arFields = $ob->GetFields();

	if(intval($arFields['~PROPERTY_ARTNUMBER_VALUE']) == $MAIN_ID):
		$MAIN_ID = $arFields['ID'];
	endif;
	if(in_array(intval($arFields['~PROPERTY_ARTNUMBER_VALUE']), $F_RECOMMEND)):
		$F_RECOMMEND_ID[] = $arFields['ID'];
	endif;
	if(in_array(intval($arFields['~PROPERTY_ARTNUMBER_VALUE']), $S_RECOMMEND)):
		$S_RECOMMEND_ID[] = $arFields['ID'];
	endif;
	/*print_r($arFields);*/
}
echo $MAIN_ID;
CIBlockElement::SetPropertyValuesEx($MAIN_ID, $IBLOCK_PROD_ID, array('RECOMMEND' => $F_RECOMMEND_ID, 'RECOMMEND2' => $S_RECOMMEND_ID));
?>

