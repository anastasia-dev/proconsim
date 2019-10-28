<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Loader,
    Bitrix\Main\ModuleManager;
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
<?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"catalog-banners", 
	array(
		"COMPONENT_TEMPLATE" => "catalog-banners",
		"IBLOCK_TYPE" => "visual",
		"IBLOCK_ID" => "4",
		"NEWS_COUNT" => "20",
		"SORT_BY1" => "SORT",
		"SORT_ORDER1" => "ASC",
		"SORT_BY2" => "NAME",
		"SORT_ORDER2" => "ASC",
		"FILTER_NAME" => "",
		"FIELD_CODE" => array(
			0 => "DETAIL_PICTURE",
			1 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "LINK",
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
		"STRICT_SECTION_CHECK" => "N",
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
    </div>
    <div class="col-md-9">

        <?
        //echo "<pre>";
        //print_r($_SESSION);
        //echo "</pre>";

        $curSectionID = $arResult["VARIABLES"]["SECTION_ID"];

        $arFilter = Array(
            "IBLOCK_ID"=>2,
            "SECTION_ID"=>$curSectionID
        );

        $countSubSections = CIBlockSection::GetCount($arFilter);
        if($countSubSections>0){
            ?>
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


            <div class="col-xs-12">
                <?
                $APPLICATION->IncludeComponent(
                    "bitrix:catalog.section.list",
                    "",
                    array(
                        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                        "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
                        "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                        "CACHE_TIME" => $arParams["CACHE_TIME"],
                        "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                        "COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
                        "TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
                        "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
                        "VIEW_MODE" => $arParams["SECTIONS_VIEW_MODE"],
                        "SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
                        "HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
                        "ADD_SECTIONS_CHAIN" => (isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : '')
                    ),
                    $component,
                    array("HIDE_ICONS" => "Y")
                );
                ?>
                <?

                $res = CIBlockSection::GetByID($curSectionID);
                if($ar_res = $res->GetNext())
                    if(!empty($ar_res['DESCRIPTION'])){
                        echo $ar_res['DESCRIPTION'];
                    }

                ?>

            </div>

            <?
        }else{
        ?>
        <div class="row">
            <div class="hidden-xs hidden-sm col-md-3 col-lg-3" style="float: right; padding-right: 0;">
                <?$APPLICATION->ShowViewContent("right_area");?>


                <?
                $pdfprice = $_SERVER['DOCUMENT_ROOT']."/upload/pdf/".$arResult["VARIABLES"]["SECTION_CODE"]."-".$_SESSION['REGION_CODE'].".pdf";
                if (file_exists($pdfprice)) {
                    echo "<a href=\"/upload/pdf/".$arResult["VARIABLES"]["SECTION_CODE"]."-".$_SESSION['REGION_CODE'].".pdf\" style=\"display:block;margin-top: 15px;margin-right: 15px;\" target=\"_blank\"><img src=\"".SITE_TEMPLATE_PATH."/img/load-sub-pdf.gif\" style=\"width: 100%;\"
 alt=\"Скачать прайс\"></a>";
                }
                ?>
            </div>


            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9" style="padding-right:0;padding-left: 30px;">
                <div class="visible-xs visible-sm">
                    <?$APPLICATION->ShowViewContent("mob_area");?>

                </div>


                <div class="content">
                    <h1><?$APPLICATION->ShowTitle(false);?></h1>
                    <?
                    //echo $arCurSection['ID'];
                    $dir = $APPLICATION->GetCurDir();
                    $uri = $APPLICATION->GetCurUri();
                    //echo $uri;
                    $isFilter = strpos($uri, "/filter/");
                    $isFilterClear = strpos($uri, "/filter/clear/");
                    $arFilterCurSection = Array(
                        "IBLOCK_ID"=>2,
                        "ID"=>$arCurSection['ID']
                    );
                    $res = CIBlockSection::GetList(Array(),$arFilterCurSection,false,Array("CODE", "SECTION_PAGE_URL", "DESCRIPTION", "UF_TOP_DESC"));
                    if($ar_res = $res->GetNext())
                        $CurSectionCode = $ar_res["CODE"];
                    $CurSectionURL = $ar_res["SECTION_PAGE_URL"];

                    if(!empty($ar_res["UF_TOP_DESC"]) && ($isFilter===false || $isFilterClear!==false)){
                        echo "<div style=\"margin-bottom: 5px;\">".$ar_res["~UF_TOP_DESC"]."</div>\n";
                    }

                    ?>

                    <div style="margin-bottom: 5px;">
                        <?$APPLICATION->ShowViewContent('sotbit_seometa_top_desc');?>
                    </div>



                    <div class="sort-panel">
                        <?
                        /////////   Вывод цены региона
                        $catalog_group_id = $_SESSION['PRICE_REGION_NUMER'];
                        $price = GetCatalogGroup($catalog_group_id);
                        $arPriceCode = array($price["NAME"]);

                        ////////


                        //$arParams['ELEMENT_SORT_FIELD'] = "CATALOG_PRICE_".$catalog_group_id;
                        $arParams['ELEMENT_SORT_FIELD'] = "PROPERTY_SORTORDER";
                        $arParams['ELEMENT_SORT_ORDER'] = 'asc';
                        $arParams['ELEMENT_SORT_FIELD2'] = 'sort';
                        $arParams["ELEMENT_SORT_ORDER2"] = 'asc';
                        $SORT_FIELD = $APPLICATION->get_cookie("SORT_FIELD");
                        if($SORT_FIELD == "priced"):
                            $arParams['ELEMENT_SORT_FIELD'] = 'PROPERTY_MINIMUM_PRICE';
                            $arParams["ELEMENT_SORT_ORDER"] = 'desc';
                        elseif($SORT_FIELD == "priceu"):
                            $arParams['ELEMENT_SORT_FIELD'] = 'PROPERTY_MINIMUM_PRICE';
                            $arParams["ELEMENT_SORT_ORDER"] = 'asc';
                        elseif($SORT_FIELD == "new"):
                            $arParams['ELEMENT_SORT_FIELD'] = 'PROPERTY_SORTORDER';
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
                            $arParams['ELEMENT_SORT_FIELD'] = 'PROPERTY_SORTORDER';
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
                        <?//if(intval($arParams["PAGE_ELEMENT_COUNT"]) == 100):?>
                        <?//$arParams["PAGE_ELEMENT_COUNT"] = 99;?>
                        <?//endif?>
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
                                    <option value="?sort=new" <?if($arParams['ELEMENT_SORT_FIELD'] == "sort"):?>selected<?endif?>>по умолчанию</option>
                                    <option value="?sort=priceu" <?if($arParams['ELEMENT_SORT_FIELD'] == "PROPERTY_MINIMUM_PRICE" and $arParams["ELEMENT_SORT_ORDER"] == 'asc'):?>selected<?endif?>>цене &uarr;</option>
                                    <option value="?sort=priced" <?if($arParams['ELEMENT_SORT_FIELD'] == "PROPERTY_MINIMUM_PRICE" and $arParams["ELEMENT_SORT_ORDER"] == 'desc'):?>selected<?endif?>>цене &darr;</option>
                                </select></li>
                            <li></li>
                            <li>Товаров на странице <select name="" id="" onchange="document.location=this.options[this.selectedIndex].value">
                                    <option value="?count=30" <?if($arParams["PAGE_ELEMENT_COUNT"] == "30"):?>selected<?endif?>><?if($temp == "plits"):?>30<?else:?>30<?endif?></option>
                                    <option value="?count=60" <?if($arParams["PAGE_ELEMENT_COUNT"] == "60"):?>selected<?endif?>><?if($temp == "plits"):?>60<?else:?>60<?endif?></option>
                                    <option value="?count=90" <?if($arParams["PAGE_ELEMENT_COUNT"] == "90"):?>selected<?endif?>><?if($temp == "plits"):?>90<?else:?>90<?endif?></option>
                                    <?/*<option value="?count=100" <?if($arParams["PAGE_ELEMENT_COUNT"] == "100"):?>selected<?endif?>><?if($temp == "plits"):?>99<?else:?>100<?endif?></option>*/?>
                                    <?/*<option value="?count=100" <?if($arParams["PAGE_ELEMENT_COUNT"] == 10000000):?>selected<?endif?>>Все</option>*/?>
                                </select></li>
                        </ul>
                    </div>

                    <div class="template-view-button-product">
                        <a href="?type=plits" <?if($temp == "plits"):?>class="active"<?endif?>><i class="fa fa-th" aria-hidden="true"></i></a>
                        <a href="?type=list" <?if($temp != "plits"):?>class="active"<?endif?>><i class="fa fa-list" aria-hidden="true"></i></a>
                    </div>
                    <div style="clear:both;"></div>
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
                    //if ($USER->IsAdmin()){
                    //echo "<pre>";
                    //print_r($arResult["URL_TEMPLATES"]);
                    //echo "</pre>";
                    //}

                    ?>


                    <?$APPLICATION->IncludeComponent(
                        "bitrix:catalog.section",
                        $temp,
                        array(
                            "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                            "ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
                            "ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
                            "ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
                            "ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
                            "PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
                            "META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
                            "META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
                            "BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
                            "SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
                            "INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
                            "BASKET_URL" => $arParams["BASKET_URL"],
                            "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
                            "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
                            "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
                            "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
                            "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
                            "FILTER_NAME" => $arParams["FILTER_NAME"],
                            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                            "CACHE_TIME" => $arParams["CACHE_TIME"],
                            "CACHE_FILTER" => $arParams["CACHE_FILTER"],
                            "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                            "SET_TITLE" => 'Y',
                            "MESSAGE_404" => $arParams["MESSAGE_404"],
                            "SET_STATUS_404" => $arParams["SET_STATUS_404"],
                            "SHOW_404" => $arParams["SHOW_404"],
                            "FILE_404" => $arParams["FILE_404"],
                            "DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
                            "PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
                            "LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
                            //"PRICE_CODE" => $arParams["PRICE_CODE"],
                            "PRICE_CODE" => $arPriceCode,
                            "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
                            "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

                            "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
                            "USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
                            "ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
                            "PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
                            "PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],

                            "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
                            "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
                            "PAGER_TITLE" => $arParams["PAGER_TITLE"],
                            "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
                            "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
                            "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
                            "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
                            "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
                            "PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
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
                            //"SECTION_ID" => $arCurSection['ID'],
                            "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                            //"SECTION_CODE" => $CurSectionCode,
                            "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
                            //"SECTION_URL" => $CurSectionURL,
                            "DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
                            "USE_MAIN_ELEMENT_SECTION" => $arParams["USE_MAIN_ELEMENT_SECTION"],
                            'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                            'CURRENCY_ID' => $arParams['CURRENCY_ID'],
                            'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],

                            'LABEL_PROP' => $arParams['LABEL_PROP'],
                            'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
                            'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],

                            'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
                            'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
                            'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
                            'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
                            'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
                            'MESS_BTN_BUY' => $arParams['MESS_BTN_BUY'],
                            'MESS_BTN_ADD_TO_BASKET' => $arParams['MESS_BTN_ADD_TO_BASKET'],
                            'MESS_BTN_SUBSCRIBE' => $arParams['MESS_BTN_SUBSCRIBE'],
                            'MESS_BTN_DETAIL' => $arParams['MESS_BTN_DETAIL'],
                            'MESS_NOT_AVAILABLE' => $arParams['MESS_NOT_AVAILABLE'],

                            'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
                            "ADD_SECTIONS_CHAIN" => "Y",
                            'ADD_TO_BASKET_ACTION' => $basketAction,
                            'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
                            'COMPARE_PATH' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare'],
                            'BACKGROUND_IMAGE' => (isset($arParams['SECTION_BACKGROUND_IMAGE']) ? $arParams['SECTION_BACKGROUND_IMAGE'] : ''),
                            'DISABLE_INIT_JS_IN_COMPONENT' => (isset($arParams['DISABLE_INIT_JS_IN_COMPONENT']) ? $arParams['DISABLE_INIT_JS_IN_COMPONENT'] : ''),
                            //'SHOW_ALL_WO_SECTION' => "Y"
                        ),
                        $component
                    );
                    //$GLOBALS['CATALOG_CURRENT_SECTION_ID'] = $intSectionID;

                    if(!empty($ar_res['DESCRIPTION']) && stripos($_SERVER['QUERY_STRING'], 'PAGEN_') === FALSE && stripos($dir, '/filter/') === FALSE){
                        /*
                       $displayText = "block";
                       if(strlen($ar_res['DESCRIPTION'])>354){
                           $displayText = "none";
                           $obParser = new CTextParser;
                           $shortText = $obParser->html_cut($ar_res['DESCRIPTION'], 354);
                           echo "<div id=\"shortText\" style=\"margin-bottom:20px;\">".$shortText." <span id=\"readMore\" style=\"cursor:pointer;text-decoration:underline;\">читать далее</span></div>";

                       }
                       echo "<div id=\"fullText\" style=\"margin-bottom:20px;display:".$displayText.";\">".$ar_res['DESCRIPTION']." <span id=\"closeMore\" style=\"padding-left:10px;cursor:pointer;text-decoration:underline;\">свернуть</span></div>";
                        */
                        $res = cut_text($ar_res['DESCRIPTION'], 354);
                        echo "<div id=\"shortText\" style=\"margin-bottom:20px;\">".$res["SHORT_TEXT"]." <span id=\"readMore\" style=\"cursor:pointer;text-decoration:underline;\">читать далее</span></div>";
                        echo "<div id=\"fullText\" style=\"margin-bottom:20px;display:none;\">".$res["HIDE_TEXT"]." <span id=\"closeMore\" style=\"padding-left:10px;cursor:pointer;text-decoration:underline;\">свернуть</span></div>";
                    }

                    ?>

                    <div>
                        <?$APPLICATION->ShowViewContent('sotbit_seometa_bottom_desc');?>
                    </div>

                    <?
                    $APPLICATION->IncludeComponent(
                        "sotbit:seo.meta",
                        ".default",
                        array(
                            "FILTER_NAME" => $arParams["FILTER_NAME"],
                            "SECTION_ID" => $arCurSection["ID"],
                            "CACHE_TYPE" => "A",
                            "CACHE_TIME" => $arParams["CACHE_TIME"],
                            "COMPONENT_TEMPLATE" => ".default",
                            "KOMBOX_FILTER" => "N"
                        ),
                        false
                    );


                    $APPLICATION->IncludeComponent(
                        "sotbit:seo.meta.tags",
                        "cloud-tags",
                        array(
                            "CACHE_GROUPS" => "N",
                            "CACHE_TIME" => $arParams["CACHE_TIME"],
                            "CACHE_TYPE" => "A",
                            "CNT_TAGS" => "",
                            "IBLOCK_ID" => "2",
                            "IBLOCK_TYPE" => "catalog",
                            "INCLUDE_SUBSECTIONS" => "A",
                            "SECTION_ID" => $arCurSection["ID"],
                            "SORT" => "CONDITIONS",
                            "SORT_ORDER" => "desc",
                            "COMPONENT_TEMPLATE" => "cloud-tags"
                        ),
                        false
                    );
                    ?>


                </div>
            </div>
            <?
            }
            ?>
        </div>
    </div>
</div>
