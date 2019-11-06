<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
IncludeTemplateLangFile(__FILE__);
?>
<?$city_id = $APPLICATION->get_cookie('USER_CITY');?>
<?$city_name = $APPLICATION->get_cookie('USER_CITY_NAME');?>
<?GLOBAL $FilterHeader;?>
<?if(intval($city_id) == 0):?>
    <?$FilterHeader = array('ID' => 439);?>
    <?$city_name = "moskva";?>
<?else:?>
    <?$FilterHeader = array('ID' => $city_id);?>
<?endif?>
<?if($APPLICATION->GetCurDir() != "/"):?>
    </div>
<?endif;?>
</div>
<?if($APPLICATION->GetCurDir() == "/contacts/"):?>
    </div>
<?endif;?>
</div>
</section>
</div>


<?if($APPLICATION->GetCurDir() == "/"):?>
    <section class="news-block">
        <div class="container">
            <div class="row">

                <?$APPLICATION->IncludeComponent(
                    "bitrix:news.list",
                    "news-onmain",
                    array(
                        "COMPONENT_TEMPLATE" => "news-onmain",
                        "IBLOCK_TYPE" => "news",
                        "IBLOCK_ID" => "1",
                        "NEWS_COUNT" => "3",
                        "SORT_BY1" => "ACTIVE_FROM",
                        "SORT_ORDER1" => "DESC",
                        "SORT_BY2" => "NAME",
                        "SORT_ORDER2" => "ASC",
                        "FILTER_NAME" => "",
                        "FIELD_CODE" => array(
                            0 => "PREVIEW_PICTURE",
                            1 => "DETAIL_PICTURE",
                            2 => "DATE_ACTIVE_FROM",
                            3 => "",
                        ),
                        "PROPERTY_CODE" => array(
                            0 => "",
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
                        "PREVIEW_TRUNCATE_LEN" => "40",
                        "ACTIVE_DATE_FORMAT" => "F",
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
                        "INCLUDE_SUBSECTIONS" => "N",
                        "DISPLAY_DATE" => "N",
                        "DISPLAY_NAME" => "Y",
                        "DISPLAY_PICTURE" => "N",
                        "DISPLAY_PREVIEW_TEXT" => "Y",
                        "PAGER_TEMPLATE" => ".default",
                        "DISPLAY_TOP_PAGER" => "N",
                        "DISPLAY_BOTTOM_PAGER" => "N",
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
        </div>
    </section>
    <section class="brands">
        <div class="container">
            <div class="row">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:news.list",
                    "brands-index",
                    array(
                        "COMPONENT_TEMPLATE" => "brands-index",
                        "IBLOCK_TYPE" => "catalog",
                        "IBLOCK_ID" => "5",
                        "NEWS_COUNT" => "500",
                        "SORT_BY1" => "SORT",
                        "SORT_ORDER1" => "ASC",
                        "SORT_BY2" => "NAME",
                        "SORT_ORDER2" => "ASC",
                        "FILTER_NAME" => "",
                        "FIELD_CODE" => array(
                            0 => "PREVIEW_PICTURE",
                            1 => "DETAIL_PICTURE",
                            2 => "",
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
                        "PREVIEW_TRUNCATE_LEN" => "65",
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
                        "INCLUDE_SUBSECTIONS" => "N",
                        "DISPLAY_DATE" => "N",
                        "DISPLAY_NAME" => "Y",
                        "DISPLAY_PICTURE" => "N",
                        "DISPLAY_PREVIEW_TEXT" => "Y",
                        "PAGER_TEMPLATE" => ".default",
                        "DISPLAY_TOP_PAGER" => "N",
                        "DISPLAY_BOTTOM_PAGER" => "N",
                        "PAGER_TITLE" => "Новости",
                        "PAGER_SHOW_ALWAYS" => "N",
                        "PAGER_DESC_NUMBERING" => "N",
                        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                        "PAGER_SHOW_ALL" => "N",
                        "PAGER_BASE_LINK_ENABLE" => "N",
                        "SET_STATUS_404" => "N",
                        "SHOW_404" => "N",
                        "MESSAGE_404" => "",
                        "STRICT_SECTION_CHECK" => "N"
                    ),
                    false
                );?>
            </div>
        </div>
    </section>
    <?php
//  хиты продаж
    global $arrFilter;
    $arrFilter = array('PROPERTY_SALELEADER_VALUE' => 'да');
    ?>
    <?$APPLICATION->IncludeComponent(
        "bitrix:catalog.section",
        "hits-index",
        Array(
            "ACTION_VARIABLE" => "action",
            "ADD_PICT_PROP" => "-",
            "ADD_PROPERTIES_TO_BASKET" => "Y",
            "ADD_SECTIONS_CHAIN" => "N",
            "ADD_TO_BASKET_ACTION" => "ADD",
            "AJAX_MODE" => "N",
            "AJAX_OPTION_ADDITIONAL" => "",
            "AJAX_OPTION_HISTORY" => "N",
            "AJAX_OPTION_JUMP" => "N",
            "AJAX_OPTION_STYLE" => "N",
            "BACKGROUND_IMAGE" => "-",
            "BASKET_URL" => "/personal/cart/",
            "BROWSER_TITLE" => "-",
            "CACHE_FILTER" => "N",
            "CACHE_GROUPS" => "Y",
            "CACHE_TIME" => "36000000",
            "CACHE_TYPE" => "A",
            "COMPATIBLE_MODE" => "Y",
            "CONVERT_CURRENCY" => "N",
            "CUSTOM_FILTER" => "",
            "DETAIL_URL" => "catalog/#SECTION_CODE_PATH#/#ELEMENT_CODE#/",
            "DISABLE_INIT_JS_IN_COMPONENT" => "N",
            "DISPLAY_BOTTOM_PAGER" => "N",
            "DISPLAY_COMPARE" => "N",
            "DISPLAY_TOP_PAGER" => "N",
            "ELEMENT_SORT_FIELD" => "sort",
            "ELEMENT_SORT_FIELD2" => "id",
            "ELEMENT_SORT_ORDER" => "asc",
            "ELEMENT_SORT_ORDER2" => "desc",
            "ENLARGE_PRODUCT" => "STRICT",
            "FILTER_NAME" => "arrFilter",
            "HIDE_NOT_AVAILABLE" => "Y",
            "HIDE_NOT_AVAILABLE_OFFERS" => "Y",
            "IBLOCK_ID" => "2",
            "IBLOCK_TYPE" => "catalog",
            "INCLUDE_SUBSECTIONS" => "Y",
            "LABEL_PROP" => array("NEWPRODUCT", "SALELEADER", "SPECIALOFFER", "CONTROL_TYPE", "WORKING_ENVIRONMENT", "TYBE_TYPE"),
            "LABEL_PROP_MOBILE" => array("NEWPRODUCT", "SALELEADER", "SPECIALOFFER", "CONTROL_TYPE", "WORKING_ENVIRONMENT", "TYBE_TYPE"),
            "LABEL_PROP_POSITION" => "top-left",
            "LAZY_LOAD" => "N",
            "LINE_ELEMENT_COUNT" => "3",
            "LOAD_ON_SCROLL" => "N",
            "MESSAGE_404" => "",
            "MESS_BTN_ADD_TO_BASKET" => "Купить",
            "MESS_BTN_BUY" => "Купить",
            "MESS_BTN_DETAIL" => "Подробнее",
            "MESS_BTN_SUBSCRIBE" => "Подписаться",
            "MESS_NOT_AVAILABLE" => "Нет в наличии",
            "META_DESCRIPTION" => "-",
            "META_KEYWORDS" => "-",
            "OFFERS_LIMIT" => "4",
            "PAGER_BASE_LINK_ENABLE" => "N",
            "PAGER_DESC_NUMBERING" => "N",
            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
            "PAGER_SHOW_ALL" => "N",
            "PAGER_SHOW_ALWAYS" => "N",
            "PAGER_TEMPLATE" => ".default",
            "PAGER_TITLE" => "Товары",
            "PAGE_ELEMENT_COUNT" => "4",
            "PARTIAL_PRODUCT_PROPERTIES" => "N",
            "PRICE_CODE" => array("BASE", "MSK", "CLB", "KRM", "PTG", "VGG", "VRJ", "EKB", "KZN", "KMV", "KRD", "NNV", "NSB", "RST", "SMR", "SPB", "SRT", "YAR", "UFA"),
            "PRICE_VAT_INCLUDE" => "Y",
            "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
            "PRODUCT_ID_VARIABLE" => "id",
            "PRODUCT_PROPERTIES" => array("NALICHIE", "NEWPRODUCT", "SALELEADER", "SPECIALOFFER", "MATERIAL", "RECOMMEND", "RECOMMEND2", "BRAND", "CONTROL_TYPE", "WORKING_ENVIRONMENT", "TYBE_TYPE", "DOCS"),
            "PRODUCT_PROPS_VARIABLE" => "prop",
            "PRODUCT_QUANTITY_VARIABLE" => "quantity",
            "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
            "PRODUCT_SUBSCRIPTION" => "N",
            "PROPERTY_CODE" => array("", ""),
            "PROPERTY_CODE_MOBILE" => array(),
            "RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
            "RCM_TYPE" => "personal",
            "SECTION_CODE" => "",
            "SECTION_CODE_PATH" => "",
            "SECTION_ID" => $_REQUEST["SECTION_ID"],
            "SECTION_ID_VARIABLE" => "SECTION_ID",
            "SECTION_URL" => "#SECTION_CODE_PATH#/",
            "SECTION_USER_FIELDS" => array("", ""),
            "SEF_MODE" => "Y",
            "SEF_RULE" => "",
            "SET_BROWSER_TITLE" => "N",
            "SET_LAST_MODIFIED" => "N",
            "SET_META_DESCRIPTION" => "N",
            "SET_META_KEYWORDS" => "N",
            "SET_STATUS_404" => "N",
            "SET_TITLE" => "N",
            "SHOW_404" => "N",
            "SHOW_ALL_WO_SECTION" => "Y",
            "SHOW_CLOSE_POPUP" => "N",
            "SHOW_DISCOUNT_PERCENT" => "N",
            "SHOW_FROM_SECTION" => "N",
            "SHOW_MAX_QUANTITY" => "N",
            "SHOW_OLD_PRICE" => "Y",
            "SHOW_PRICE_COUNT" => "1",
            "SHOW_SLIDER" => "N",
            "SLIDER_INTERVAL" => "3000",
            "SLIDER_PROGRESS" => "N",
            "TEMPLATE_THEME" => "blue",
            "USE_ENHANCED_ECOMMERCE" => "N",
            "USE_MAIN_ELEMENT_SECTION" => "N",
            "USE_PRICE_COUNT" => "N",
            "USE_PRODUCT_QUANTITY" => "N"
        )
    );?>
    <section class="action">
        <div class="container">
            <?/*$APPLICATION->IncludeComponent(
                "bitrix:news.line",
                "index-stock",
                Array(
                    "ACTIVE_DATE_FORMAT" => "d.m.Y",
                    "CACHE_GROUPS" => "Y",
                    "CACHE_TIME" => "300",
                    "CACHE_TYPE" => "A",
                    "COMPONENT_TEMPLATE" => ".default",
                    "DETAIL_URL" => "",
                    "FIELD_CODE" => array(0=>"",1=>"",),
                    "IBLOCKS" => array(0=>"19",),
                    "IBLOCK_TYPE" => "news",
                    "NEWS_COUNT" => "1",
                    "SORT_BY1" => "ACTIVE_FROM",
                    "SORT_BY2" => "SORT",
                    "SORT_ORDER1" => "DESC",
                    "SORT_ORDER2" => "ASC"
                )
            );*/?>
            <!--
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <h2 class="title"><span>Дисконт и акции</span></h2>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="discount-box box-main">
                            <a href="/stock/"><img src="img/action-banner.png" alt=""></a>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="discount-box box-main">
                            <a href="/catalog/rasprodazha/"><img src="img/sale-ban.png" alt=""></a>
                        </div>
                    </div>
                </div>
           -->
        </div>
    </section>
    <section class="information-block">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <h1 class="index"><span>Информация о «ПРОКОНСИМ»</span></h1>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="inf-box box-main b1"><a href="/about/">О компании</a></div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="inf-box box-main b2"><a href="/cooperation/price-list/">Прайс лист</a></div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="inf-box box-main b3"><a href="/cooperation/delivery/">Доставка и оплата</a></div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="inf-box box-main b4"><a href="/support/product-presentation/">Полезная документация</a></div>
                </div>
            </div>
        </div>
    </section>
    <section class="our-clients">
        <div class="container">
            <div class="row">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:news.list",
                    "our_clients",
                    array(
                        "COMPONENT_TEMPLATE" => "our_clients",
                        "IBLOCK_TYPE" => "visual",
                        "IBLOCK_ID" => "18",
                        "NEWS_COUNT" => "200",
                        "SORT_BY1" => "SORT",
                        "SORT_ORDER1" => "ASC",
                        "SORT_BY2" => "ID",
                        "SORT_ORDER2" => "ASC",
                        "FILTER_NAME" => "",
                        "FIELD_CODE" => array(
                            0 => "",
                            1 => "",
                        ),
                        "PROPERTY_CODE" => array(
                            0 => "PARTNER_LINK",
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
                        "MESSAGE_404" => "",
                        "STRICT_SECTION_CHECK" => "N"
                    ),
                    false
                );?>
            </div>
        </div>
    </section>
<?endif;?>
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="f-menu f-box">
                    <h4>Меню</h4>
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "bottom",
                        array(
                            "COMPONENT_TEMPLATE" => "bottom",
                            "ROOT_MENU_TYPE" => "bottom",
                            "MENU_CACHE_TYPE" => "Y",
                            "MENU_CACHE_TIME" => "3600",
                            "MENU_CACHE_USE_GROUPS" => "Y",
                            "MENU_CACHE_GET_VARS" => array(
                            ),
                            "MAX_LEVEL" => "1",
                            "CHILD_MENU_TYPE" => "left",
                            "USE_EXT" => "N",
                            "DELAY" => "N",
                            "ALLOW_MULTI_SELECT" => "N"
                        ),
                        false
                    );?>
                </div>
            </div>
            <div class="col-md-3">
                <div class="f-box f-contacts">
                    <h4>Контакты</h4>
                    <div class="phone-box">
                        <?echo $_SESSION['REGION_PHONE'];?>
                        <span>(Многоканальный)</span>
                    </div>
                    <div class="email-box">
                        <a href="mailto:<?echo $_SESSION['REGION_EMAIL'];?>"><?echo $_SESSION['REGION_EMAIL'];?></a>
                    </div>
                    <div class="add-box">
                        <p><?echo $_SESSION['REGION_ADDRESS'];?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="f-box f-add-reg">
                    <h4>Филиалы</h4>
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:news.list",
                        "city-contacts",
                        array(
                            "COMPONENT_TEMPLATE" => "city-contacts",
                            "IBLOCK_TYPE" => "references",
                            "IBLOCK_ID" => "6",
                            "NEWS_COUNT" => "200",
                            "SORT_BY1" => "SORT",
                            "SORT_ORDER1" => "ASC",
                            "SORT_BY2" => "NAME",
                            "SORT_ORDER2" => "ASC",
                            "FILTER_NAME" => "",
                            "FIELD_CODE" => array(
                                0 => "",
                                1 => "",
                            ),
                            "PROPERTY_CODE" => array(
                                0 => "",
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
                            "INCLUDE_SUBSECTIONS" => "N",
                            "DISPLAY_DATE" => "N",
                            "DISPLAY_NAME" => "Y",
                            "DISPLAY_PICTURE" => "N",
                            "DISPLAY_PREVIEW_TEXT" => "Y",
                            "PAGER_TEMPLATE" => ".default",
                            "DISPLAY_TOP_PAGER" => "N",
                            "DISPLAY_BOTTOM_PAGER" => "N",
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
            </div>
        </div>
    </div>
</footer>



<!-- Здесь пишем код -->

<div class="hidden">
    <form action="" class="form" id="callback">
        <h3>Оставить сообщение</h3>
        <!-- Hidden Required Fields -->
        <input type="hidden" name="project_name" value="oDay.kz">
        <input type="hidden" name="admin_email" value="info@oday.kz">
        <input type="hidden" name="form_subject" value="Форма - Получить консультацию">
        <!-- END Hidden Required Fields -->
        <input type="text"  name="Имя" placeholder="Ваше имя" class="vf-all" required="required"><br>
        <input type="text"  name="Телефон" placeholder="Номер телефона" class="vf-all" required="required"><br>
        <input type="text"  name="E-mail" placeholder="E-mail" class="vf-all" required="required"><br>
        <textarea name="" name="Сообщение" class="vf-all" id="" placeholder="Сообщение"></textarea>
        <button class="btn btn-feed vf-submit">Отправить</button>
    </form>
</div>

<form id="call-form" role="form" class="popup-form mfp-hide">
    <h3>Заказ звонка</h3>
    <div class="show-form">
        <p>Оставьте заявку и мы перезвоним Вам в ближайшее время.</p>

        <div class="form-group">
            <label class="sr-only" for="name">Ваше имя*</label>
            <input id="name" name="name" type="text" placeholder="Ваше имя" class="form-control">
        </div>
        <div class="form-group">
            <label class="sr-only" for="phone">Телефон*</label>
            <input id="phone" name="phone" type="tel" placeholder="Телефон*" class="form-control">
        </div>
        <div class="form-group">
            <label class="sr-only" for="question">Вопрос*</label>
            <textarea id="question" name="question" class="form-control" placeholder="Вопрос"></textarea>
        </div>
        <div>* Имя и телефон обязательны для заполнения</div>
        <div class="checkbox">
            <label>
                <input id="agreement" name="agreement" type="checkbox" value="1"> Я принимаю условия <a href="/agreement/">политики обработки персональных данных</a>
                <label>
        </div>
        <div><input type="button" id="sendCall" name="sendCall" class="btn-view btn-blue" value="Жду звонка!"></div>
    </div>
</form>


<!--[if lt IE 9]>
<script src="libs/html5shiv/es5-shim.min.js"></script>
<script src="libs/html5shiv/html5shiv.min.js"></script>
<script src="libs/html5shiv/html5shiv-printshiv.min.js"></script>
<script src="libs/respond/respond.min.js"></script>
<![endif]-->


<script src="<?=SITE_TEMPLATE_PATH?>/libs/waypoints/waypoints.min.js"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/libs/animate/animate-css.js"></script>

<script src="<?=SITE_TEMPLATE_PATH?>/libs/magnific/jquery.magnific-popup.min.js"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/libs/owl.carousel/owl.carousel.min.js"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/libs/jVForms/jVForms.min.js"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/libs/menu/classie.js"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/libs/menu/mlpushmenu.js"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/libs/slick/slick.min.js"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/js/common.js?8"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/js/resize-catalog.js?67"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/js/jquery.nicescroll.min.js"></script>


<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
    (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

    ym(7158430, "init", {
        id:7158430,
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true,
        trackHash:true
    });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/7158430" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

<script>


    $(document).ready(function(){
        $(".bx-filter-block.filter-wrap").niceScroll({
            cursorwidth:"6px",
            autohidemode: false,
        });

        $("#readMore, #closeMore").click(function () {
            //$( "#shortText" ).toggle();
            $( "#fullText" ).toggle();
        });

        jQuery(function($){
            $(document).mouseup(function (e){ // событие клика по веб-документу
                var div = $(".api-search-input"); // тут указываем ID элемента
                $('#topsearch').prop('className','col-md-10');
                $('#topMenu').hide();
                if (!div.is(e.target) // если клик был не по нашему блоку
                    && div.has(e.target).length === 0) { // и не по его дочерним элементам
                    $('#topsearch').prop('className','col-md-3');
                    $('#topMenu').show();
                }
            });
        });

/*        $(".api-search-input").click(function () {
            //console.log("IN");
            $('#topsearch').prop('className','col-md-10');
            $('#topMenu').hide();
        });*/

    });
    function SHMenu(){
        $('.opens-menu').toggleClass('active');
    }
    function number_format(number, decimals, dec_point, thousands_sep) {
        number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function(n, prec) {
                var k = Math.pow(10, prec);
                return '' + (Math.round(n * k) / k)
                    .toFixed(prec);
            };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
            .split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '')
            .length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1)
                .join('0');
        }
        return s.join(dec);
    }
    function StartPropLoad(col){
        var wid, wid_c;
        for(var i = 0; i < Number(col); i++){
            $.ajax({
                async: false,
                url:     '/load-catalog/load_sale.php',
                type:     "POST", //метод отправки
                data: "str="+i,
                dataType: "html", //формат данных
                success: function(response) { //Данные отправлены успешно
                    console.log(response);
                    wid = 100*(i+1)/(Number(col));
                    wid_c = Math.round(wid);
                    $('.progress-prop .green-bar').css('width',wid+'%');
                    $('.progress-prop .progress-description').html('Обработано '+(i+1)+' из '+col+'. ('+wid_c+'%)');
                },
                error: function(response) { // Данные не отправлены
                }
            });
        }
    }
    function StartRecommendLoad(col){
        var wid, wid_c;
        for(var i = 0; i < Number(col); i++){
            $.ajax({
                async: false,
                url:     '/load-catalog/load_recommend.php',
                type:     "POST", //метод отправки
                data: "str="+i,
                dataType: "html", //формат данных
                success: function(response) { //Данные отправлены успешно
                    console.log(response);
                    wid = 100*(i+1)/(Number(col));
                    wid_c = Math.round(wid);
                    $('.progress-recommend .green-bar').css('width',wid+'%');
                    $('.progress-recommend .progress-description').html('Обработано '+(i+1)+' из '+col+'. ('+wid_c+'%)');
                },
                error: function(response) { // Данные не отправлены
                }
            });
        }
    }
    function StartProductLoad(){
        $('.catalog-wzaim').prop('disabled',true);
        var all = $('#all-product').val();
        var id,section,wid,wid_c, sozd=0, obn=0, b_id, b_name;
        b_id = $('#brand-id-array').val();
        b_name = $('#brand-name-array').val();
        var d= new Date();
        var fileName=('0'+d.getDate()).substr(-2,2)+('0'+ parseInt(d.getMonth()+1)).substr(-2,2)+('0'+d.getFullYear()).substr(-2,2)+('0'+d.getHours()).substr(-2,2)+('0'+d.getMinutes()).substr(-2,2)+('0'+d.getSeconds()).substr(-2,2);
        //console.log(fileName);

        for(var i = 0; i < Number(all); i++){
            //for(var i = 0; i < 10; i++){
            id = $('#prod_num_'+i).val();
            section = $('#prod_num_'+i).data('section');
            $.ajax({
                async: false,
                url:     '/load-catalog/load_new.php',
                type:     "POST", //метод отправки
                data: "str="+i+"&id="+id+"&section="+section+"&b_id="+b_id+"&b_name="+b_name+"&fileName="+fileName,
                dataType: "html", //формат данных
                success: function(response) { //Данные отправлены успешно
                    if(response != ""){
                        console.log(response);
                        $("#resLoadNew").html(response);
                    }
                    if(response == "ok1"){
                        sozd++;
                    }else if(response == "ok2"){
                        obn ++;
                    }
                    wid = 100*(i+1)/(Number(all));
                    wid_c = Math.round(wid);
                    $('.progress-load .green-bar').css('width',wid+'%');
                    $('.progress-load .progress-description').html('Обработано '+(i+1)+' из '+all+'. ('+wid_c+'%). Создано - '+sozd+' обновлено - '+obn);
                },
                error: function(response) { // Данные не отправлены
                }
            });
        }
        window.location.href = "https://proconsim.ru/load-catalog/?load=price";
    }

    /*
    function StartPriceLoad(){
        $('.catalog-wzaim').prop('disabled',true);
        var id, sklad, price, count, code, name, all, wid, pricecode, nalichie;
        all = $('#all-count').val();
        $('.product').each(function(){
            id = $(this).val();
            numer = $(this).data('numer');
            sklad = $(this).data('sklad');
            price = $(this).data('price');
            count = $(this).data('count');
            code = $(this).data('code');
            name = $(this).data('name');
            active = $(this).data('active');
            update = $(this).data('update');
            artnumber = $(this).data('artnumber');
            pricecode = $(this).data('pricecode');
            nalichie = $(this).data('nalichie');
            $.ajax({
                async: false,
                url:     '/load-catalog/load_catalog.php',
                type:     "POST", //метод отправки
                data: "id="+id+"&sklad="+sklad+"&price="+price+"&count="+count+"&code="+code+"&name="+name+"&active="+active+"&artnumber="+artnumber+"&update="+update+"&pricecode="+pricecode+"&nalichie="+nalichie,
                dataType: "html", //формат данных
                success: function(response) { //Данные отправлены успешно
                    console.log(response);
                    wid = 100*Number(numer)/(Number(all)+1);
                    wid = Math.round(wid);
                    $('.progress-price .green-bar').css('width',wid+'%');
                    $('.progress-price .progress-description').html('Обработано '+numer+' из '+all+' ('+wid+'%)');
                },
                error: function(response) { // Данные не отправлены
                }
            });
        });
        loadGroups();
    }
*/

    function StartPriceLoadYa(){
        $('.catalog-wzaim').prop('disabled',true);
        var id, numer, price, all, wid;
        all = $('#all-count').val();
        $.ajax({
            async: false,
            url:     '/load-catalog/empty-prices-ya.php',
            //type:     "POST", //метод отправки
            //data: "id="+id+"&price="+price,
            dataType: "html", //формат данных
            success: function(response) { //Данные отправлены успешно
                console.log(response);
            },
            error: function(response) { // Данные не отправлены
            }
        });
        $('.product').each(function(){
            id = $(this).val();
            numer = $(this).data('numer');
            price = $(this).data('price');

            $.ajax({
                async: false,
                url:     '/load-catalog/up-prices-ya.php',
                type:     "POST", //метод отправки
                data: "id="+id+"&price="+price,
                dataType: "html", //формат данных
                success: function(response) { //Данные отправлены успешно
                    console.log(response);
                    wid = 100*Number(numer)/(Number(all)+1);
                    wid = Math.round(wid);
                    $('.progress-price .green-bar').css('width',wid+'%');
                    $('.progress-price .progress-description').html('Обработано '+numer+' из '+all+' ('+wid+'%)');
                },
                error: function(response) { // Данные не отправлены
                }
            });
        });
        createPDF();
    }

    function loadGroups(){
        $.ajax({
            async: false,
            url:     'groups.php',
            type:     "POST", //метод отправки
            data: "",
            success: function(response) { //Данные отправлены успешно
                //console.log(response);
                if(response=="err"){

                }else{
                    $("#res").html(response);
                    createPDF();
                }
            },
            error: function(response) { // Данные не отправлены
            }
        });
    }
    function createPDF(){
        $("div[id^='reg_']").each(function(){
            var divID = this.id;
            var d_d =divID.replace('reg_','');
            var splitDD = d_d.split("_");
            var priceID = splitDD[1];
            var sectionID = splitDD[0];
            var regionCode = $(this).attr('data-regioncode');
            var regionPhone = $(this).attr('data-phone');
            var regionEmail = $(this).attr('data-email');

            $.ajax({
                async: false,
                url:     'create-pdf.php',
                type:     "POST", //метод отправки
                data: "sectionid="+sectionID+"&priceid="+priceID+"&code="+regionCode+"&phone="+regionPhone+"&email="+regionEmail,
                success: function(response) { //Данные отправлены успешно
                    //console.log(response);
                    if(response=="err"){

                    }else{
                        //window.open('https://proconsim.ru'+response, '_blank');
                        $("#res_"+sectionID+"_"+priceID).html(" - "+response);
                    }
                },
                error: function(response) { // Данные не отправлены
                }
            });

        });
    }

    $(document).ready(function(){
        var width_brand = $('.owl-carousel4 .brands-box').width();
        var height_brand = $('.owl-carousel4 .brands-box').height();
        var img_w, img_h, margin_t, margin_l;
        $('.owl-carousel4 .brands-box img').each(function(){
            img_w = $(this).width();
            img_h = $(this).height();
            margin_l = (width_brand - img_w) / 2;
            margin_t = (height_brand - img_h) / 2;
            $(this).css('margin-top',margin_t);
            $(this).css('margin-left',margin_l);
        });
    });
    function addToBasket(urlb,id){
        $('.btn-bye').not('.not-available').prop('disabled',true);
        $('.btn-bye-large').prop('disabled',true);
        var count_b, in_basket;
        count_b = parseInt($('.in-basket-count-value-'+id).val())+parseInt($(".input-sm-"+id).val());
        in_basket = parseInt($('.count-basket .total').text());
        if(parseInt($('.in-basket-count-value-'+id).val()) == 0){
            $('.count-basket .total').text(in_basket+1);
        }
        $('.b-g-s-'+id).html('КУПИТЬ<span class="in-basket-count">'+count_b+'</span>');
        $('.b-g-sm-'+id).html('<i class="demo-icon icon-cart"></i><span class="in-basket-count">'+count_b+'</span>');
        $('.in-basket-count-value-'+id).val(count_b);

        if($(".slick-active").length>0){
            var divPic = $(".slick-active").attr("data-value");
            var pic = $("#img-"+divPic);
            var widthPic = "300px";
            //console.log("divPic = "+divPic);
        }

        if($("#img-"+id).length>0){
            var pic = $("#img-"+id);
            var widthPic = "200px";
        }

        if(pic.length>0){
            var strPict = pic.attr("src");
            var strImage = '<img src="'+strPict+'">';
            offset = pic.offset();
            var basketTop = $("#bx_basketFKauiI");

            $(strImage).css({'width' : widthPic,'position' : 'absolute', 'z-index' : '11100', top: offset.top-50, left:offset.left}).appendTo("body").animate({opacity: 0.3,left: basketTop.offset()['left'], top: basketTop.offset()['top'],width: 20}, 1000, function() {
                $(this).remove();
            });
        }
        $.ajax({
            type: "GET",
            url: urlb+"&quantity="+$(".input-sm-"+id).val(),
            dataType: "html",
            success: function(out){
                $('.btn-bye').not('.not-available').prop('disabled',false);
                $('.btn-bye-large').prop('disabled',false);

            }

        });
    }
</script>
<?CJSCore::Init(['masked_input']);?>
<script>
    BX.ready(function() {
        var result = new BX.MaskedInput({
            mask: '+7 (999) 999-99-99', // устанавливаем маску
            input: BX('phone'),
            placeholder: '_' // символ замены +7 ___ ___ __ __
        });

        result.setValue('_________________'); // устанавливаем значение
    });
</script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-127498102-2"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-127498102-2');
</script>

<!-- BEGIN JIVOSITE CODE {literal} -->
<script type='text/javascript'>
    (function(){ var widget_id = 'QdRvqYPFzK';var d=document;var w=window;function l(){
        var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();</script>
<!-- {/literal} END JIVOSITE CODE -->
<div class="done-w">
    <div class="done-window">Спасибо за заявку<br /><small>Ожидайте нашего звонка.</small></small></div>
</div>

<script src="/js/ingevents.4.0.8.min.js"></script>
<!-- calltouch -->
<script src="https://mod.calltouch.ru/init.js?id=azos7bmy"></script>
<!-- /calltouch -->	
</body>
</html>
