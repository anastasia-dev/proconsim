<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Избранное");
$APPLICATION->AddChainItem("Избранное");
?>
<?global $arrFilter_sect;
$ids_fav = getFavorites($USER,$APPLICATION->get_cookie('bo_favorites'));
//$arrFilter_sect = array('PROPERTY_SKU_MAIN'=>$ids_fav);
foreach($ids_fav as $val){
	$arrFilter_sect['ID'][] = $val;
}
//print_r($ids_fav);
if($_REQUEST['type'] == 'list'){
	$templat = '';
}else{
	$templat = 'plits';
}
//$templat = 'plits';
?>
<div class="template-view-button-product">
<a href="?type=plits" <?if($templat != ""):?>class="active"<?endif?>><i class="fa fa-th" aria-hidden="true"></i></a>
<a href="?type=list" <?if($templat == ""):?>class="active"<?endif?>><i class="fa fa-list" aria-hidden="true"></i></a>
</div>
<div style="clear:both;"></div>
<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section", 
	$templat, 
	array(
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => "2",
		"ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
		"ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
		"ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
		"ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
		"PROPERTY_CODE" => array(
			0 => "",
			1 => $arParams["LIST_PROPERTY_CODE"],
			2 => "",
		),
		"META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
		"META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
		"BROWSER_TITLE" => "-",
		"SET_LAST_MODIFIED" => "N",
		"INCLUDE_SUBSECTIONS" => "Y",
		"BASKET_URL" => $arParams["BASKET_URL"],
		"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
		"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
		"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
		"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
		"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
		"FILTER_NAME" => "arrFilter_sect",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "N",
		"SET_TITLE" => "Y",
		"MESSAGE_404" => $arParams["MESSAGE_404"],
		"SET_STATUS_404" => "N",
		"SHOW_404" => "N",
		"FILE_404" => $arParams["FILE_404"],
		"DISPLAY_COMPARE" => "N",
		"PAGE_ELEMENT_COUNT" => '20',
		"LINE_ELEMENT_COUNT" => '4',
		"PRICE_CODE" => array(
			0 => "BASE",
			1 => "MSK",
			2 => "CLB",
			3 => "KRM",
			4 => "PTG",
			5 => "VGG",
			6 => "VRJ",
			7 => "EKB",
			8 => "KZN",
			9 => "KMV",
			10 => "KRD",
			11 => "NNV",
			12 => "NSB",
			13 => "RST",
			14 => "SMR",
			15 => "SPB",
			16 => "SRT",
			17 => "UFA",
		),
		"USE_PRICE_COUNT" => "N",
		"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
		"PRICE_VAT_INCLUDE" => "N",
		"USE_PRODUCT_QUANTITY" => "N",
		"ADD_PROPERTIES_TO_BASKET" => "N",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRODUCT_PROPERTIES" => array(
		),
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"PAGER_TITLE" => $arParams["PAGER_TITLE"],
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
		"PAGER_SHOW_ALL" => "N",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
		"PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
		"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
		"OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
		"OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
		"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
		"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
		"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
		"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
		"OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],
		"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
		"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
		"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
		"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
		"USE_MAIN_ELEMENT_SECTION" => "N",
		"CONVERT_CURRENCY" => "N",
		"CURRENCY_ID" => $arParams["CURRENCY_ID"],
		"HIDE_NOT_AVAILABLE" => "Y",
		"LABEL_PROP" => "-",
		"ADD_PICT_PROP" => "-",
		"PRODUCT_DISPLAY_MODE" => $arParams["PRODUCT_DISPLAY_MODE"],
		"OFFER_ADD_PICT_PROP" => $arParams["OFFER_ADD_PICT_PROP"],
		"OFFER_TREE_PROPS" => $arParams["OFFER_TREE_PROPS"],
		"PRODUCT_SUBSCRIPTION" => "N",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_OLD_PRICE" => "N",
		"MESS_BTN_BUY" => $arParams["MESS_BTN_BUY"],
		"MESS_BTN_ADD_TO_BASKET" => $arParams["MESS_BTN_ADD_TO_BASKET"],
		"MESS_BTN_SUBSCRIBE" => $arParams["MESS_BTN_SUBSCRIBE"],
		"MESS_BTN_DETAIL" => $arParams["MESS_BTN_DETAIL"],
		"MESS_NOT_AVAILABLE" => $arParams["MESS_NOT_AVAILABLE"],
		"TEMPLATE_THEME" => (isset($arParams["TEMPLATE_THEME"])?$arParams["TEMPLATE_THEME"]:""),
		"ADD_SECTIONS_CHAIN" => "Y",
		"ADD_TO_BASKET_ACTION" => "ADD",
		"SHOW_CLOSE_POPUP" => "N",
		"COMPARE_PATH" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["compare"],
		"BACKGROUND_IMAGE" => (isset($arParams["SECTION_BACKGROUND_IMAGE"])?$arParams["SECTION_BACKGROUND_IMAGE"]:""),
		"DISABLE_INIT_JS_IN_COMPONENT" => "N",
		"COMPONENT_TEMPLATE" => "plits",
		"SECTION_USER_FIELDS" => array(
			0 => "",
			1 => "",
		),
		"SHOW_ALL_WO_SECTION" => "Y",
		"CUSTOM_FILTER" => "",
		"HIDE_NOT_AVAILABLE_OFFERS" => "N",
		"MESS_BTN_COMPARE" => "Сравнить",
		"SEF_MODE" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"SET_BROWSER_TITLE" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_META_DESCRIPTION" => "Y",
		"COMPATIBLE_MODE" => "Y"
	),
	$component
);


?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>