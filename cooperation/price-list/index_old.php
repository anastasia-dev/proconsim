<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Прайс-лист");
?>
		<div class=" row text-right search" style="margin-bottom:25px;">
		<div class="col-xs-6">
		<?
	$e_sort = 'show_counter';
	$o_sort = 'desc';
	$SORT_FIELD = $APPLICATION->get_cookie("SORT_FIELD");
	if($SORT_FIELD == "priced"):
		$e_sort = 'PROPERTY_MINIMUM_PRICE';
		$o_sort = 'desc';
	elseif($SORT_FIELD == "priceu"):
		$e_sort = 'PROPERTY_MINIMUM_PRICE';
		$o_sort = 'asc';
	elseif($SORT_FIELD == "new"):
		$e_sort = 'show_counter';
		$o_sort = 'desc';
	endif;
	?>
	<?if($_GET['sort'] == "priced"):
		$e_sort = 'PROPERTY_MINIMUM_PRICE';
		$o_sort = 'desc';
		$APPLICATION->set_cookie("SORT_FIELD", 'priced', time()+60*60*24, "/");
	elseif($_GET['sort'] == "priceu"):
		$e_sort = 'PROPERTY_MINIMUM_PRICE';
		$o_sort = 'asc';
		$APPLICATION->set_cookie("SORT_FIELD", 'priceu', time()+60*60*24, "/");
	elseif($_GET['sort'] == "new"):
		$e_sort = 'show_counter';
		$o_sort = 'desc';
		$APPLICATION->set_cookie("SORT_FIELD", 'new', time()+60*60*24, "/");
	endif;?>
	<?
	$COUNT_E = $APPLICATION->get_cookie("COUNT_E");
	if(intval($COUNT_E) != 0):
		$count = $COUNT_E;
	endif;
	?>
	<?if(intval($_GET['count']) != 0):
		$count = intval($_GET['count']);
		$APPLICATION->set_cookie("COUNT_E", intval($_GET['count']), time()+60*60*24, "/");
	endif;?>
	<?if(intval($count) == 100):?>
		<?$count = 10000000;?>
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
	<ul style="display:inline-flex; margin-top:8px;">
		<li>Сортировать по <select name="" id="" onchange="document.location=this.options[this.selectedIndex].value">
			<option value="?sort=new" <?if($e_sort == "show_counter"):?>selected<?endif?>>популярности</option>
			<option value="?sort=priceu" <?if($e_sort == "PROPERTY_MINIMUM_PRICE" and $o_sort == 'asc'):?>selected<?endif?>>цене &uarr;</option>
			<option value="?sort=priced" <?if($e_sort == "PROPERTY_MINIMUM_PRICE" and $o_sort == 'desc'):?>selected<?endif?>>цене &darr;</option>
		</select></li>
		<li></li>
		<li style="margin-left:15px;">Товаров на странице <select name="" id="" onchange="document.location=this.options[this.selectedIndex].value">
			<option value="?count=10">10</option>
			<option value="?count=20" <?if($count == "20"):?>selected<?endif?>>20</option>
			<option value="?count=50" <?if($count == "50"):?>selected<?endif?>>50</option>
			<option value="?count=100" <?if($count == 10000000):?>selected<?endif?>>Все</option>
		</select></li>
	</ul>

		</div><div class="col-xs-6">
		<?if($_GET['mask'] != ""):?>
			<?
				GLOBAL $arrFilter;
				$arrFilter['NAME'] = "%".$_GET['mask']."%";
			?>
		<?endif;?>
			<form action="/cooperation/price-list/" method="GET">
				<span><i class="fa fa-search" aria-hidden="true"></i></span>
				<input type="text" name="mask" <?if($_GET['mask'] != ""):?>value="<?=$_GET['mask']?>"<?endif;?> class="input_box" placeholder="Поиск по прайс-листу">
				<?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"price-pdf", 
	array(
		"COMPONENT_TEMPLATE" => "price-pdf",
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => "21",
		"NEWS_COUNT" => "1",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_ORDER1" => "DESC",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"FILTER_NAME" => "",
		"FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "PDF",
			1 => "",
		),
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"PREVIEW_TRUNCATE_LEN" => "",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"SET_TITLE" => "N",
		"SET_BROWSER_TITLE" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_LAST_MODIFIED" => "N",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"PAGER_TEMPLATE" => ".default",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Новости",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"SET_STATUS_404" => "N",
		"SHOW_404" => "N",
		"MESSAGE_404" => ""
	),
	false
);?>
				
			</form>
			</div>
		</div>
	
<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section", 
	"price-list", 
	array(
		"COMPONENT_TEMPLATE" => "price-list",
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => "2",
		"SECTION_ID" => $_REQUEST["SECTION_ID"],
		"SECTION_CODE" => "",
		"SECTION_USER_FIELDS" => array(
			0 => "UF_ICON_CLASS",
			1 => "",
		),
		"ELEMENT_SORT_FIELD" => $e_sort,
		"ELEMENT_SORT_ORDER" => $o_sort,
		"ELEMENT_SORT_FIELD2" => "id",
		"ELEMENT_SORT_ORDER2" => "desc",
		"FILTER_NAME" => "arrFilter",
		"INCLUDE_SUBSECTIONS" => "Y",
		"SHOW_ALL_WO_SECTION" => "Y",
		"HIDE_NOT_AVAILABLE" => "N",
		"PAGE_ELEMENT_COUNT" => $count,
		"LINE_ELEMENT_COUNT" => "3",
		"PROPERTY_CODE" => array(
			0 => "BRAND",
			1 => "BRANDS",
			2 => "",
		),
		"OFFERS_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"OFFERS_PROPERTY_CODE" => array(
			0 => "ARTNUMBER",
			1 => "",
		),
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_FIELD2" => "id",
		"OFFERS_SORT_ORDER2" => "desc",
		"OFFERS_LIMIT" => "5",
		"BACKGROUND_IMAGE" => "-",
		"TEMPLATE_THEME" => "blue",
		"PRODUCT_DISPLAY_MODE" => "Y",
		"ADD_PICT_PROP" => "MORE_PHOTO",
		"LABEL_PROP" => "NEWPRODUCT",
		"PRODUCT_SUBSCRIPTION" => "N",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_OLD_PRICE" => "N",
		"SHOW_CLOSE_POPUP" => "N",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_SUBSCRIBE" => "Подписаться",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"SECTION_URL" => "",
		"DETAIL_URL" => "",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SEF_MODE" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_GROUPS" => "Y",
		"SET_TITLE" => "N",
		"SET_BROWSER_TITLE" => "N",
		"BROWSER_TITLE" => "-",
		"SET_META_KEYWORDS" => "N",
		"META_KEYWORDS" => "-",
		"SET_META_DESCRIPTION" => "N",
		"META_DESCRIPTION" => "-",
		"SET_LAST_MODIFIED" => "N",
		"USE_MAIN_ELEMENT_SECTION" => "Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"CACHE_FILTER" => "N",
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRICE_CODE" => array(
			0 => "BASE",
		),
		"USE_PRICE_COUNT" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"PRICE_VAT_INCLUDE" => "Y",
		"CONVERT_CURRENCY" => "N",
		"BASKET_URL" => "/personal/basket.php",
		"USE_PRODUCT_QUANTITY" => "Y",
		"PRODUCT_QUANTITY_VARIABLE" => "",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PARTIAL_PRODUCT_PROPERTIES" => "Y",
		"PRODUCT_PROPERTIES" => array(
		),
		"OFFERS_CART_PROPERTIES" => array(
			0 => "DIAMETR",
		),
		"ADD_TO_BASKET_ACTION" => "ADD",
		"PAGER_TEMPLATE" => "only-digit-last",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Товары",
		"PAGER_SHOW_ALWAYS" => "Y",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"SET_STATUS_404" => "N",
		"SHOW_404" => "N",
		"MESSAGE_404" => "",
		"DISABLE_INIT_JS_IN_COMPONENT" => "N",
		"OFFER_ADD_PICT_PROP" => "MORE_PHOTO",
		"OFFER_TREE_PROPS" => array(
			0 => "DIAMETR",
		),
		"CUSTOM_FILTER" => "",
		"HIDE_NOT_AVAILABLE_OFFERS" => "N",
		"DISPLAY_COMPARE" => "N",
		"COMPATIBLE_MODE" => "Y"
	),
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>