<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Бренды");
?>

<div class="row">
<div class="col-md-3">
	<div class="menu-cat menu-catalog-page hidden-xs hidden-sm">
	<?$APPLICATION->IncludeComponent("bitrix:menu", "catalog_show", Array(
	"ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
		"CHILD_MENU_TYPE" => "left",	// Тип меню для остальных уровней
		"DELAY" => "N",	// Откладывать выполнение шаблона меню
		"MAX_LEVEL" => "2",	// Уровень вложенности меню
		"MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
		"MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
		"MENU_CACHE_TYPE" => "N",	// Тип кеширования
		"MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
		"ROOT_MENU_TYPE" => "left",	// Тип меню для первого уровня
		"USE_EXT" => "Y",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
		"COMPONENT_TEMPLATE" => "vertical_multilevel",
		"MENU_THEME" => "site"
	),
	false
);?>	
	
	</div>
</div>
<div class="col-md-9">
	<div class="col-md-12" style="padding-right: 0;">
		 <?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"catalog-slider", 
	array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"COMPONENT_TEMPLATE" => "catalog-slider",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "7",
		"IBLOCK_TYPE" => "visual",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "Y",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "20",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Новости",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "SORT",
		"SORT_BY2" => "NAME",
		"SORT_ORDER1" => "ASC",
		"SORT_ORDER2" => "ASC"
	),
	false
);?>
	</div>


<?
$arrFilter =  array(">PROPERTY_BRAND" => 0);
?> 

<div class="row">
		<div class="col-md-3" style="float: right; padding-right: 0;">
 <?$APPLICATION->IncludeComponent(
	"bitrix:catalog.smart.filter", 
	"catalog", 
	array(
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CONVERT_CURRENCY" => "N",
		"DISPLAY_ELEMENT_COUNT" => "Y",
		"FILTER_NAME" => "arrFilter",
		"FILTER_VIEW_MODE" => "vertical",
		"HIDE_NOT_AVAILABLE" => "N",
		"IBLOCK_ID" => "2",
		"IBLOCK_TYPE" => "catalog",
		"PAGER_PARAMS_NAME" => "arrPager",
		"POPUP_POSITION" => "left",
		"PRICE_CODE" => array(
		),
		"SAVE_IN_SESSION" => "N",
		"SECTION_CODE" => "",
		"SECTION_DESCRIPTION" => "-",
		"SECTION_ID" => $_REQUEST["SECTION_ID"],
		"SECTION_TITLE" => "-",
		"SEF_MODE" => "Y",
		"TEMPLATE_THEME" => "blue",
		"XML_EXPORT" => "N",
		"COMPONENT_TEMPLATE" => "catalog",
		"SEF_RULE" => "/catalog/brands/filter/#SMART_FILTER_PATH#/apply/",
		"SECTION_CODE_PATH" => "",
		"SMART_FILTER_PATH" => $_REQUEST["SMART_FILTER_PATH"]
	),
	false
);?>


		</div>
		<div class="col-md-9" style="padding-right:0;">
							<div class="content">
								<h1><?$APPLICATION->ShowTitle(false);?></h1>
								<div class="sort-panel">
<?
	$arParams['ELEMENT_SORT_FIELD'] = 'sort';
	$arParams["ELEMENT_SORT_ORDER"] = 'asc';
	$SORT_FIELD = $APPLICATION->get_cookie("SORT_FIELD");
	if($SORT_FIELD == "priced"):
		$arParams['ELEMENT_SORT_FIELD'] = 'PROPERTY_MINIMUM_PRICE';
		$arParams["ELEMENT_SORT_ORDER"] = 'desc';
	elseif($SORT_FIELD == "priceu"):
		$arParams['ELEMENT_SORT_FIELD'] = 'PROPERTY_MINIMUM_PRICE';
		$arParams["ELEMENT_SORT_ORDER"] = 'asc';
	elseif($SORT_FIELD == "new"):
		$arParams['ELEMENT_SORT_FIELD'] = 'sort';
		$arParams["ELEMENT_SORT_ORDER"] = 'asc';
	endif;
	?>
	<?if($_GET['sort'] == "priced"):
		$arParams['ELEMENT_SORT_FIELD'] = 'PROPERTY_MINIMUM_PRICE';
		$arParams["ELEMENT_SORT_ORDER"] = 'desc';
		$APPLICATION->set_cookie("SORT_FIELD", 'priced', time()+60*60*24, "/");
	elseif($_GET['sort'] == "priceu"):
		$arParams['ELEMENT_SORT_FIELD'] = 'PROPERTY_MINIMUM_PRICE';
		$arParams["ELEMENT_SORT_ORDER"] = 'asc';
		$APPLICATION->set_cookie("SORT_FIELD", 'priceu', time()+60*60*24, "/");
	elseif($_GET['sort'] == "new"):
		$arParams['ELEMENT_SORT_FIELD'] = 'sort';
		$arParams["ELEMENT_SORT_ORDER"] = 'asc';
		$APPLICATION->set_cookie("SORT_FIELD", 'new', time()+60*60*24, "/");
	endif;?>
	<?
	$COUNT_E = $APPLICATION->get_cookie("COUNT_E");
	if(intval($COUNT_E) != 0):
		$arParams["PAGE_ELEMENT_COUNT"] = $COUNT_E;
	endif;
	?>
	<?if(intval($_GET['count']) != 0):
		$arParams["PAGE_ELEMENT_COUNT"] = intval($_GET['count']);
		$APPLICATION->set_cookie("COUNT_E", intval($_GET['count']), time()+60*60*24, "/");
	endif;?>
	<?if(intval($arParams["PAGE_ELEMENT_COUNT"]) == 100):?>
		<?$arParams["PAGE_ELEMENT_COUNT"] = 10000000;?>
	<?endif?>
	<?$type = $APPLICATION->get_cookie("VIEW_PROD_TYPE");?>
<?if($_GET['type'] == 'plits'):?>
	<?$type = "plits";?>
<?endif?>
<?if($_GET['type'] == 'list' or $type == "list"):?>
	<?$APPLICATION->set_cookie("VIEW_PROD_TYPE", 'list', time()+60*60*24, "/");?>
	<?$temp = "";?>
<?else:?>
	<?$APPLICATION->set_cookie("VIEW_PROD_TYPE", 'plits', time()+60*60*24, "/");?>
	<?$temp = "plits";?>
<?endif;?>
	<ul>
		<li>Сортировать по <select name="" id="" onchange="document.location=this.options[this.selectedIndex].value">
			<option value="?sort=new" <?if($arParams['ELEMENT_SORT_FIELD'] == "sort"):?>selected<?endif?>>популярности</option>
			<option value="?sort=priceu" <?if($arParams['ELEMENT_SORT_FIELD'] == "PROPERTY_MINIMUM_PRICE" and $arParams["ELEMENT_SORT_ORDER"] == 'asc'):?>selected<?endif?>>цене &uarr;</option>
			<option value="?sort=priced" <?if($arParams['ELEMENT_SORT_FIELD'] == "PROPERTY_MINIMUM_PRICE" and $arParams["ELEMENT_SORT_ORDER"] == 'desc'):?>selected<?endif?>>цене &darr;</option>
		</select></li>
		<li></li>
		<li>Товаров на странице <select name="" id="" onchange="document.location=this.options[this.selectedIndex].value">
			<option value="?count=10"><?if($temp == "plits"):?>9<?else:?>10<?endif;?></option>
			<option value="?count=20" <?if($arParams["PAGE_ELEMENT_COUNT"] == "20"):?>selected<?endif?>><?if($temp == "plits"):?>21<?else:?>20<?endif?></option>
			<option value="?count=50" <?if($arParams["PAGE_ELEMENT_COUNT"] == "50"):?>selected<?endif?>><?if($temp == "plits"):?>51<?else:?>50<?endif?></option>
			<!--<option value="?count=100" <?if($arParams["PAGE_ELEMENT_COUNT"] == 10000000):?>selected<?endif?>>Все</option>-->
		</select></li>
	</ul>
</div>

<div class="template-view-button product">
<a href="?type=plits" <?if($temp == "plits"):?>class="active"<?endif?>><i class="fa fa-th" aria-hidden="true"></i></a>
<a href="?type=list" <?if($temp != "plits"):?>class="active"<?endif?>><i class="fa fa-list" aria-hidden="true"></i></a>
</div>
<?if($temp == "plits"):?>
	<?if($arParams["PAGE_ELEMENT_COUNT"] == 10):?>
		<?$arParams["PAGE_ELEMENT_COUNT"] = 9;?>
	<?elseif($arParams["PAGE_ELEMENT_COUNT"] == 20):?>
		<?$arParams["PAGE_ELEMENT_COUNT"] = 21;?>
	<?elseif($arParams["PAGE_ELEMENT_COUNT"] == 50):?>
		<?$arParams["PAGE_ELEMENT_COUNT"] = 51;?>
	<?endif;?>
<?endif;?>

<?
/////////   Вывод цены региона
$catalog_group_id = $_SESSION['PRICE_REGION_NUMER'];
$price = GetCatalogGroup($catalog_group_id);
$arPriceCode = array($price["NAME"]);

////////
?>


<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section", 
	"brendy", 
	array(
		"ACTION_VARIABLE" => "action",
		"ADD_PICT_PROP" => "-",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"ADD_TO_BASKET_ACTION" => "ADD",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"BACKGROUND_IMAGE" => "-",
		"BASKET_URL" => "/personal/basket.php",
		"BROWSER_TITLE" => "-",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"COMPATIBLE_MODE" => "Y",
		"CONVERT_CURRENCY" => "Y",
		"CUSTOM_FILTER" => "",
		"DETAIL_URL" => "/catalog/#SECTION_CODE#/#ELEMENT_CODE#/",
		"DISABLE_INIT_JS_IN_COMPONENT" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_COMPARE" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_FIELD2" => "id",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_ORDER2" => "desc",
		"ENLARGE_PRODUCT" => "STRICT",
		"FILTER_NAME" => "arrFilter",
		"HIDE_NOT_AVAILABLE" => "N",
		"HIDE_NOT_AVAILABLE_OFFERS" => "N",
		"IBLOCK_ID" => "2",
		"IBLOCK_TYPE" => "catalog",
		"INCLUDE_SUBSECTIONS" => "Y",
		"LABEL_PROP" => array(
		),
		"LAZY_LOAD" => "N",
		"LINE_ELEMENT_COUNT" => "3",
		"LOAD_ON_SCROLL" => "N",
		"MESSAGE_404" => "",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_BTN_SUBSCRIBE" => "Подписаться",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"OFFERS_CART_PROPERTIES" => array(
		),
		"OFFERS_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"OFFERS_LIMIT" => "5",
		"OFFERS_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_FIELD2" => "id",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_ORDER2" => "desc",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Товары",
		"PAGE_ELEMENT_COUNT" => "18",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
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
			17 => "TMN",
			18 => "UFA",
		),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons,compare",
		"PRODUCT_DISPLAY_MODE" => "N",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPERTIES" => array(
		),
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
		"PRODUCT_SUBSCRIPTION" => "Y",
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"PROPERTY_CODE_MOBILE" => array(
		),
		"RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
		"RCM_TYPE" => "personal",
		"SECTION_CODE" => "",
		"SECTION_ID" => $_REQUEST["SECTION_ID"],
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SECTION_URL" => "/catalog/#SECTION_CODE#/",
		"SECTION_USER_FIELDS" => array(
			0 => "",
			1 => "",
		),
		"SEF_MODE" => "N",
		"SET_BROWSER_TITLE" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "Y",
		"SHOW_404" => "N",
		"SHOW_ALL_WO_SECTION" => "Y",
		"SHOW_CLOSE_POPUP" => "N",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_FROM_SECTION" => "N",
		"SHOW_MAX_QUANTITY" => "N",
		"SHOW_OLD_PRICE" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"SHOW_SLIDER" => "Y",
		"SLIDER_INTERVAL" => "3000",
		"SLIDER_PROGRESS" => "N",
		"TEMPLATE_THEME" => "blue",
		"USE_ENHANCED_ECOMMERCE" => "N",
		"USE_MAIN_ELEMENT_SECTION" => "N",
		"USE_PRICE_COUNT" => "N",
		"USE_PRODUCT_QUANTITY" => "N",
		"COMPONENT_TEMPLATE" => "brendy",
		"SEF_RULE" => "",
		"SECTION_CODE_PATH" => "",
		"CURRENCY_ID" => "RUB"
	),
	false
);?>

							</div>
						</div>
		</div>
</div>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>