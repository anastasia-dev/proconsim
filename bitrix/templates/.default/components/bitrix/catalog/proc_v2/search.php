<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$this->addExternalCss("/bitrix/css/main/bootstrap.css");


if (isset($arParams['USE_COMMON_SETTINGS_BASKET_POPUP']) && $arParams['USE_COMMON_SETTINGS_BASKET_POPUP'] == 'Y')
{
	$basketAction = (isset($arParams['COMMON_ADD_TO_BASKET_ACTION']) ? $arParams['COMMON_ADD_TO_BASKET_ACTION'] : '');
}
else
{
	$basketAction = (isset($arParams['SECTION_ADD_TO_BASKET_ACTION']) ? $arParams['SECTION_ADD_TO_BASKET_ACTION'] : '');
}
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
<div class="col-md-12">

<?
/////////   Вывод цены региона
$catalog_group_id = $_SESSION['PRICE_REGION_NUMER'];
$price = GetCatalogGroup($catalog_group_id);
$arPriceCode = array($price["NAME"]);
//print_r ($arPriceCode);
////////

$ELEMENT_SORT_FIELD = "PROPERTY_MINIMUM_PRICE";
$ELEMENT_SORT_ORDER = "asc";
$sort = "";
if(isset($_GET['sort']) && $_GET['sort'] == "priced"){
    $ELEMENT_SORT_FIELD = "PROPERTY_MINIMUM_PRICE";
    $ELEMENT_SORT_ORDER = "desc";
    $sort = "priced";   
}
if(isset($_GET['sort']) && $_GET['sort'] == "priceu"){
    $ELEMENT_SORT_FIELD = "PROPERTY_MINIMUM_PRICE";
    $ELEMENT_SORT_ORDER = "asc";
    $sort = "priceu";    
}
$PAGE_ELEMENT_COUNT = 20;
if(isset($_GET['count'])){
    $PAGE_ELEMENT_COUNT = intval($_GET['count']);
    if($PAGE_ELEMENT_COUNT>50){$PAGE_ELEMENT_COUNT=50;}    
}

//echo "<pre>";
//print_r($_GET);
//echo "</pre>";

if(isset($_GET['BRAND'])){   
    $GLOBALS["apiSearchFilter"]["PROPERTY_BRAND"] =  $_GET['BRAND'];  
} 
if(isset($_GET['NAIMENOVANIE'])){   
    $GLOBALS["apiSearchFilter"]["PROPERTY_NAIMENOVANIE"] =  $_GET['NAIMENOVANIE'];  
} 
if(isset($_GET['DN'])){   
    $GLOBALS["apiSearchFilter"]["PROPERTY_DN"] =  $_GET['DN'];  
}  
if(isset($_GET['PN'])){   
    $GLOBALS["apiSearchFilter"]["PROPERTY_PN"] =  $_GET['PN'];  
}   


//echo "<pre>";
//print_r($GLOBALS["apiSearchFilter"]);
//echo "</pre>";

?>
<div class="sort-panel">
<ul>
		<li>Сортировать по <select name="" id="" onchange="document.location=this.options[this.selectedIndex].value">            	
			<option value="<? echo $APPLICATION->GetCurPageParam("sort=priceu", array("sort", "priced"));?>" <?if($sort=="priceu"){?>selected<?}?>>цене &uarr;</option>
			<option value="<? echo $APPLICATION->GetCurPageParam("sort=priced", array("sort", "priceu"));?>" <?if($sort=="priced"){?>selected<?}?>>цене &darr;</option>
		</select></li>
		<li></li>
		<li>Товаров на странице <select name="" id="" onchange="document.location=this.options[this.selectedIndex].value">
			<option value="<? echo $APPLICATION->GetCurPageParam("count=10",array("count"));?>" <?if($PAGE_ELEMENT_COUNT==10){?>selected<?}?>>10</option>
			<option value="<? echo $APPLICATION->GetCurPageParam("count=20",array("count"));?>" <?if($PAGE_ELEMENT_COUNT==20){?>selected<?}?>>20</option>
			<option value="<? echo $APPLICATION->GetCurPageParam("count=50",array("count"));?>" <?if($PAGE_ELEMENT_COUNT==50){?>selected<?}?>>50</option>			
		</select></li>
</ul>
</div>


<div class="clearfix"></div>

<div class="row">
    <div class="col-md-3" style="float: right; padding-right: 0;">
    <div class="bx-filter">
    <div class="bx-filter-section container-fluid filter-block">
        <h3>ФИЛЬТР</h3>
        <form name="filter_form" id="filter_form" method="get" class="smartfilter">
        <?if($_GET["q"]){?>
        <input type="hidden" name="q" value="<?=$_GET["q"]?>">
        <?}?>
        <?if($_GET["sort"]){?>
        <input type="hidden" name="sort" value="<?=$_GET["sort"]?>">
        <?}?>
        <?if($_GET["count"]){?>
        <input type="hidden" name="count" value="<?=$_GET["count"]?>">
        <?}?>
        <div class="">
<?

/* Бренды */
	$brSelect = array("ID","NAME");
	$brFilter = Array("IBLOCK_ID"=>5);
	$brRes = CIBlockElement::GetList(Array(), $brFilter, false, false, $brSelect);
	$BRAND_ARRAY = array();
	while($brOb = $brRes->GetNextElement()){
		$brFields = $brOb->GetFields();		
        $BRAND_ARRAY[$brFields['ID']] = $brFields['NAME'];
	}

$IBLOCK_ID = 2;
$arrProps = array(111,39,59,66);
 $arUrl = array("set_filter");
$properties = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$IBLOCK_ID));
while ($prop_fields = $properties->GetNext())
{
    if(in_array($prop_fields["ID"],$arrProps)){?>
        
         <div class="bx-filter-parameters-box  filter-box <?if(in_array($_GET[$prop_fields["CODE"]],$_GET)){?>bx-active<?}?>">
            <span class="bx-filter-container-modef"></span>
            <div class="bx-filter-parameters-box-title" onclick="hideFilterProps(this);">
				<span class="bx-filter-parameters-box-hint"><h4><?=$prop_fields["NAME"]?> <i class="fa fa-angle-down" aria-hidden="true"></i><i class="fa fa-angle-up" aria-hidden="true"></i></h4></span>
            </div>
          
          <div class="bx-filter-block filter-wrap" data-role="bx_filter_block">
				<div class="bx-filter-parameters-box-container">
				    
        <?
        $arUrl[] = $prop_fields["CODE"];
        $arPropValues = array();
        $dbItems = CIBlockElement::GetList(array(), array('IBLOCK_ID' => $IBLOCK_ID, 'ACTIVE' => 'Y', "ID" =>$_SESSION['SEARCH_ELEMENTS']), array('PROPERTY_'.$prop_fields["CODE"])); 
        $countProp = 0;       
        while($arItem = $dbItems->GetNext(true, false)) { 
            if(!empty($arItem['PROPERTY_'.$prop_fields["CODE"].'_VALUE'])){
                $countProp++;                
                //echo $arItem['PROPERTY_'.$prop_fields["CODE"].'_VALUE']."<br />"; ?>
                <div class="checkbox">
				        <div class="bx-filter-input-checkbox">
								<input
								type="checkbox"
								class="radio"
								value="<?=$arItem['PROPERTY_'.$prop_fields["CODE"].'_VALUE']?>"
								name="<?=$prop_fields["CODE"]?>[]"
                                id="prop_<? echo $prop_fields["ID"]."_".$countProp; ?>"
                                <?if(in_array($arItem['PROPERTY_'.$prop_fields["CODE"].'_VALUE'], $_GET[$prop_fields["CODE"]])){?>
                                checked
                                <?}?>
								/>
								<label data-role="label_prop_<? echo $prop_fields["ID"]."_".$countProp; ?>" class="bx-filter-param-label " for="prop_<? echo $prop_fields["ID"]."_".$countProp; ?>">
                                <?if($prop_fields["CODE"]=="BRAND" && $BRAND_ARRAY[$arItem['PROPERTY_'.$prop_fields["CODE"].'_VALUE']]){?>
                                        <?=$BRAND_ARRAY[$arItem['PROPERTY_'.$prop_fields["CODE"].'_VALUE']]?>
                                <?}else{?>
                                <?=$arItem['PROPERTY_'.$prop_fields["CODE"].'_VALUE']?>
                                <?}?>
                                </label>
				        </div>			
                </div>    
            <?    
            }//else{
                //echo "нет данных<br />";
           //}
//echo "<pre>";
//print_r($arItem);
//echo "</pre>";
        }?>
             </div> 
            </div>
         </div> 
    <?    
    }
  
}
?> 
       </div>
			<div class="" style="margin-top:15px;">
				<div class="col-xs-12 bx-filter-button-box">
					<div class="bx-filter-block">
						<div class="bx-filter-parameters-box-container">
							<button
								class="btn btn-themes btn-view"
								type="submit"
								id="set_filter"
								name="set_filter"
								value="Показать"
							><i class="fa fa-eye" aria-hidden="true"></i> Показать <span id="result_count"></span></button>
							<button
								class="btn btn-link btn-reset"
								type="button"
								id="del_filter"
								name="del_filter"
								value="Сбросить"
                                onclick ="clearForm('<?echo $APPLICATION->GetCurPageParam("",$arUrl);?>');"
							/><span>X</span> Сбросить</button>							
						</div>
					</div>
				</div>
        </div>
     
     </form>       
    </div>
  </div>  
  </div>
    <div class="col-md-9" style="float: right;">
 <?$APPLICATION->IncludeComponent(
	"api:search.catalog", 
	"search-results", 
	array(
		"ACTION_VARIABLE" => "action",
		"ADD_PICT_PROP" => "MORE_PHOTO",
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
		"CATALOG_TEMPLATE" => "search-results",
		"COMPONENT_TEMPLATE" => "search-results",
		"CONVERT_CURRENCY" => "N",
		"DETAIL_URL" => "",
		"DISABLE_INIT_JS_IN_COMPONENT" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_TOP_PAGER" => "Y",
		"ELEMENT_SORT_FIELD" => $ELEMENT_SORT_FIELD,
		"ELEMENT_SORT_FIELD2" => "id",
		"ELEMENT_SORT_ORDER" => $ELEMENT_SORT_ORDER,
		"ELEMENT_SORT_ORDER2" => "desc",
		"FILTER_NAME" => "apiSearchFilter",
		"HIDE_NOT_AVAILABLE" => "N",
		"IBLOCK_ID" => "2",
		"IBLOCK_TYPE" => "catalog",
		"INCLUDE_SUBSECTIONS" => "Y",
		"LABEL_PROP" => "-",
		"LINE_ELEMENT_COUNT" => "3",
		"MESSAGE_404" => "",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_BTN_SUBSCRIBE" => "Подписаться",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"OFFERS_CART_PROPERTIES" => "",
		"OFFERS_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"OFFERS_LIMIT" => "5",
		"OFFERS_PROPERTY_CODE" => array(
			0 => "ARTNUMBER",
			1 => "",
		),
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_FIELD2" => "id",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_ORDER2" => "desc",
		"OFFER_ADD_PICT_PROP" => "-",
		"OFFER_TREE_PROPS" => "",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Товары",
		"PAGE_ELEMENT_COUNT" => $PAGE_ELEMENT_COUNT,
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRICE_CODE" => $arPriceCode,
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_DISPLAY_MODE" => "N",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPERTIES" => array(
		),
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PRODUCT_SUBSCRIPTION" => "N",
		"PROPERTY_CODE" => array(
			0 => "ARTNUMBER",
			1 => "MANUFACTURER",
			2 => "MATERIAL",
			3 => "NAIMENOVANIE",
			4 => "BODY_MATERIAL",
			5 => "PURPOSE",
			6 => "",
		),
		"SECTION_CODE" => "",
		"SECTION_ID" => $_REQUEST["SECTION_ID"],
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SECTION_URL" => "",
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
		"SHOW_OLD_PRICE" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"TEMPLATE_THEME" => "blue",
		"USE_MAIN_ELEMENT_SECTION" => "N",
		"USE_PRICE_COUNT" => "N",
		"USE_PRODUCT_QUANTITY" => "Y",
		"USE_SEARCH" => "N"
	),
	false
);?>
    </div>

</div>

</div></div></div>
<script>
function clearForm(url){
  window.location.href = url;
  return false;
}

function hideFilterProps (element)
{
	var obj = element.parentNode,
		filterBlock = obj.querySelector("[data-role='bx_filter_block']"),
		propAngle = obj.querySelector("[data-role='prop_angle']");
    
	if(BX.hasClass(obj, "bx-active"))
	{
		new BX.easing({
			duration : 300,
			start : { opacity: 1,  height: filterBlock.offsetHeight },
			finish : { opacity: 0, height:0 },
			transition : BX.easing.transitions.quart,
			step : function(state){
				filterBlock.style.opacity = state.opacity;
				filterBlock.style.height = state.height + "px";
			},
			complete : function() {
				filterBlock.setAttribute("style", "");
				BX.removeClass(obj, "bx-active");
			}
		}).animate();

		BX.addClass(propAngle, "fa-angle-down");
		BX.removeClass(propAngle, "fa-angle-up");
	}
	else
	{
		filterBlock.style.display = "block";
		filterBlock.style.opacity = 0;
		filterBlock.style.height = "auto";

		var obj_children_height = filterBlock.offsetHeight;
		filterBlock.style.height = 0;

		new BX.easing({
			duration : 300,
			start : { opacity: 0,  height: 0 },
			finish : { opacity: 1, height: obj_children_height },
			transition : BX.easing.transitions.quart,
			step : function(state){
				filterBlock.style.opacity = state.opacity;
				filterBlock.style.height = state.height + "px";
			},
			complete : function() {
			}
		}).animate();

		BX.addClass(obj, "bx-active");
		BX.removeClass(propAngle, "fa-angle-down");
		BX.addClass(propAngle, "fa-angle-up");
	}
};

</script>
