<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
IncludeTemplateLangFile(__FILE__);

//echo "<pre>";
//print_r($_SESSION);
//echo "</pre>";

?>
    <!DOCTYPE html>
    <!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
    <!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
    <!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
    <!--[if (gte IE 9)|!(IE)]><!--><html lang="ru"> <!--<![endif]-->

    <head>
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','GTM-KJ2DD7M');</script>
        <!-- End Google Tag Manager -->


        <title><?$APPLICATION->ShowTitle();?></title>
        <meta charset="utf-8">
        <?$APPLICATION->ShowHead();?>

        <link rel="shortcut icon" href="<?=SITE_TEMPLATE_PATH?>/favicon/favicon.ico" type="image/x-icon">

        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="cmsmagazine" content="cdc79537f1d9f113c73cd2fd46ca0125" />

        <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/libs/bootstrap/css/bootstrap-grid.min.css">
        <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/libs/animate/animate.css">
        <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/libs/magnific/magnific-popup.css">
        <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/libs/owl.carousel/owl.carousel.css">
        <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/libs/font-awesome-4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/fonts/icon/css/icon.css">
        <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/libs/menu/css/component.css" />
        <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/libs/slick/slick.css">
        <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/libs/slick/slick-theme.css">

        <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/fonts.css">
        <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/main.css?6">
        <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/media.css?12">

        <script src="<?=SITE_TEMPLATE_PATH?>/libs/modernizr/modernizr.js"></script>
        <script src="<?=SITE_TEMPLATE_PATH?>/libs/jquery/jquery-1.11.2.min.js"></script>
    </head>

<body  class="mp-pusher" id="mp-pusher">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KJ2DD7M"
                      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

<?$APPLICATION->ShowPanel();?>
    <div id="mp-menu" class="mp-menu">
        <div class="mp-level">
            <h2>Все категории</h2>
            <?$APPLICATION->IncludeComponent("bitrix:menu", "catalog_show_mobile", Array(
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

<div class="container wrap">
    <div class="falshe-head"></div>
    <div class="scrolled-head">
        <header>
            <div class="top-header">
                <div class="row">
                    <div class="col-sm-1 col-xs-1 hidden-md hidden-lg">
                        <button id="trigger" class="menu-btn"><i class="demo-icon icon-menu"></i></button>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-3 col-xs-9 top-header-city">

                        <?$APPLICATION->IncludeComponent(
                            "bitrix:news.list",
                            "city_select",
                            array(
                                "COMPONENT_TEMPLATE" => "city_select",
                                "IBLOCK_TYPE" => "references",
                                "IBLOCK_ID" => "6",
                                "NEWS_COUNT" => "100",
                                "SORT_BY1" => "NAME",
                                "SORT_ORDER1" => "ASC",
                                "SORT_BY2" => "SORT",
                                "SORT_ORDER2" => "ASC",
                                "FILTER_NAME" => "",
                                "FIELD_CODE" => array(
                                    0 => "",
                                    1 => "",
                                ),
                                "PROPERTY_CODE" => array(
                                    0 => "PRICE_CODE",
                                    1 => "PRICE_ID",
                                    2 => "",
                                ),
                                "CHECK_DATES" => "Y",
                                "DETAIL_URL" => "",
                                "AJAX_MODE" => "N",
                                "AJAX_OPTION_JUMP" => "N",
                                "AJAX_OPTION_STYLE" => "Y",
                                "AJAX_OPTION_HISTORY" => "N",
                                "AJAX_OPTION_ADDITIONAL" => "",
                                "CACHE_TYPE" => "N",
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
                        );?>                </div>
                    <div class="col-lg-3 col-lg-push-6 col-md-3 col-md-push-5 col-sm-1 col-sm-push-7 col-xs-2 top-header-auth">
                        <?if($USER->IsAuthorized()):?>
                            <a href="/personal/" title="Войти в Личный кабинет"><img src="<?=SITE_TEMPLATE_PATH?>/images/user-new.png" alt="Войти в Личный кабинет"></a>
                        <?else:?>
                            <a href="/authorize/" title="Вход"><img src="<?=SITE_TEMPLATE_PATH?>/images/user-new.png" alt="Вход"></a>
                        <?endif;?>
                        <?GLOBAL $USER;?>
                        <?if(!$USER->IsAuthorized()):?>
                            <a href="/authorize/" class="hidden-xs hidden-sm" style="font-size: 14px;font-family: 'OpenSansBold';color: #ffffff;text-decoration: none;">Вход</a><span class="hidden-xs hidden-sm" style="font-size: 14px;font-family: 'OpenSansBold';color: #ffffff;padding-left: 3px;padding-right: 3px;">/</span><a href="/register/" class="hidden-xs hidden-sm" style="font-size: 14px;font-family: 'OpenSansBold';color: #ffffff;text-decoration: none;">Регистрация</a>
                        <?else:?>
                            <a href="/personal/" class="hidden-xs hidden-sm hidden-md" style="font-size: 14px;font-family: 'OpenSansBold';color: #ffffff;text-decoration: none;" title="Войти в Личный кабинет"><?=$USER->GetFullName()?></a><span class="hidden-xs hidden-sm hidden-md" style="font-size: 14px;font-family: 'OpenSansBold';color: #ffffff;padding-left: 3px;padding-right: 3px;">/</span>
                            <a href="?logout=yes" class="hidden-xs hidden-sm" style="font-size: 14px;font-family: 'OpenSansBold';color: #ffffff;text-decoration: none;">Выйти</a>
                        <?endif?>
                    </div>
                    <div class="col-lg-6 col-lg-pull-3 col-md-5 col-md-pull-4 col-sm-7 col-sm-pull-1 col-xs-12 top-header-address">
                        <div class="row">
                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                                <img src="<?=SITE_TEMPLATE_PATH?>/images/marker-new.png" alt="Адрес">
                            </div>
                            <div class="col-lg-11 col-md-11 col-sm-11 col-xs-11 top-header-address-text">
                                <a href="/contacts/" style="font-size: 14px;color: #ffffff;text-decoration: underline;"><?echo $_SESSION['REGION_ADDRESS'];?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">

                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-9">
                        <div class="logo-box">
                            <a href="/"><img src="<?=SITE_TEMPLATE_PATH?>/img/logo.png" class="img-responsive" alt=""></a>
                        </div>
                    </div>
                    <div class="col-lg-1 col-lg-push-8 col-md-1 col-md-push-8 col-sm-2 col-sm-push-6 col-xs-3 text-right add_top">
                        <?$APPLICATION->IncludeComponent("bitrix:sale.basket.basket.line", "cust-basket", Array(
                            "PATH_TO_BASKET" => SITE_DIR."personal/cart/",	// Страница корзины
                            "PATH_TO_PERSONAL" => SITE_DIR."personal/",	// Страница персонального раздела
                            "SHOW_PERSONAL_LINK" => "N",	// Отображать персональный раздел
                            "SHOW_NUM_PRODUCTS" => "Y",	// Показывать количество товаров
                            "SHOW_TOTAL_PRICE" => "Y",	// Показывать общую сумму по товарам
                            "SHOW_PRODUCTS" => "N",	// Показывать список товаров
                            "POSITION_FIXED" => "N",	// Отображать корзину поверх шаблона
                            "SHOW_AUTHOR" => "N",	// Добавить возможность авторизации
                            "PATH_TO_REGISTER" => SITE_DIR."login/",	// Страница регистрации
                            "PATH_TO_PROFILE" => SITE_DIR."personal/",	// Страница профиля
                            "COMPONENT_TEMPLATE" => ".default",
                            "PATH_TO_ORDER" => SITE_DIR."personal/order/make/",	// Страница оформления заказа
                            "SHOW_EMPTY_VALUES" => "Y",	// Выводить нулевые значения в пустой корзине
                            "HIDE_ON_BASKET_PAGES" => "Y",	// Не показывать на страницах корзины и оформления заказа
                        ),
                            false
                        );?>
                        <div class="compare_counter">
                            <a href="/catalog/compare.php" class="count-compare"><i class="compare_icon on_top"></i>
                                <span class="total"><?=count($_SESSION["CATALOG_COMPARE_LIST"][2]["ITEMS"])?></span>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-lg-pull-1 col-md-8 col-md-pull-1 col-sm-6 col-sm-pull-2 col-xs-12">
                        <div class="header-mode">
                            <div class="header-mode-text">Режим работы:</div>
                            <div class="header-mode-time">
                                <?if($_SESSION['REGION_MODE']){?>
                                    <?echo $_SESSION['REGION_MODE'];?>
                                <?}else{?>
                                    <?echo "ПН-ПТ с 9.00 до 18.00";?>
                                <?}?>
                            </div>
                        </div>
                    </div>
                    <div class="hidden-lg col-md-12 col-sm-12 hidden-xs"><div style="height: 1px;background-color: #dbd8d8;margin: 15px 0 20px 0;"></div></div>
                    <div class="col-lg-3 col-lg-pull-1 col-md-3 col-sm-4 col-xs-12">
                        <div class="hidden-md hidden-sm hidden-xs" style="font-size: 14px;font-family: 'OpenSansBold';color: #62687e;">Почта для заявок</div>
                        <div class="email-box"><img src="<?=SITE_TEMPLATE_PATH?>/images/mail-new.png" alt="Почта для заявок"><a href="mailto:<?echo $_SESSION['REGION_EMAIL'];?>" style="font-size: 14px;font-family: 'OpenSansBold';color: #62687e;margin-left: 10px;"><?echo $_SESSION['REGION_EMAIL'];?></a></div>
                    </div>
                    <div class="col-lg-2 col-lg-pull-1 col-md-9 col-sm-8 col-xs-12">
                        <div class="row">
                            <div class="col-lg-12 col-md-4 col-xs-6 col-sm-6">
                                <div class="phone-box">
                                    <img src="<?=SITE_TEMPLATE_PATH?>/img/ico-phone-2.png" alt="">
                                    <?echo $_SESSION['REGION_PHONE'];?>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-8 col-xs-6 col-sm-6">
                                <div class="header-call"><a class="popup-with-form" href="#call-form">Заказать звонок</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <section class="menu-panel">
            <div class="container">
                <div class="mp-wrap">
                    <div class="row">
                        <div class="col-md-2 catalog-menu-block">
                            <?if(preg_match('/^\/catalog\//', $APPLICATION->GetCurDir())):?>
                                <div class="menu-wrap hidden-sm hidden-xs menu-cat-inside">
                                    <h3><i class="demo-icon icon-menu"></i> <a href="/catalog/">каталог</a></h3>
                                </div>
                            <?else:?>
                                <div class="menu-wrap hidden-sm hidden-xs">
                                    <h3><i class="demo-icon icon-menu"></i> <a href="/catalog/">каталог</a></h3>
                                    <div class="menu-cat">
                                        <?$APPLICATION->IncludeComponent(
                                            "bitrix:menu",
                                            "catalog_show",
                                            array(
                                                "ALLOW_MULTI_SELECT" => "N",
                                                "CHILD_MENU_TYPE" => "left",
                                                "DELAY" => "N",
                                                "MAX_LEVEL" => "2",
                                                "MENU_CACHE_GET_VARS" => array(
                                                ),
                                                "MENU_CACHE_TIME" => "3600",
                                                "MENU_CACHE_TYPE" => "A",
                                                "MENU_CACHE_USE_GROUPS" => "Y",
                                                "ROOT_MENU_TYPE" => "left",
                                                "USE_EXT" => "Y",
                                                "COMPONENT_TEMPLATE" => "catalog_show",
                                                "MENU_THEME" => "site"
                                            ),
                                            false
                                        );?>							</div>
                                </div>
                            <?endif;?>
                        </div>
                        <div id="topsearch" class="col-md-3">
                            <?/*$APPLICATION->IncludeComponent(
	"bitrix:search.form",
	"top-search",
	array(
		"PAGE" => "#SITE_DIR#search/",
		"USE_SUGGEST" => "Y",
		"COMPONENT_TEMPLATE" => "top-search"
	),
	false
);*/?>

                            <?$APPLICATION->IncludeComponent(
	"api:search.title", 
	"top-search", 
	array(
		"BUTTON_TEXT" => "",
		"COMPONENT_TEMPLATE" => "top-search",
		"CONVERT_CURRENCY" => "N",
		"DETAIL_URL" => "/catalog/#SECTION_CODE_PATH#/#ELEMENT_CODE#/",
		"IBLOCK_2_FIELD" => array(
			0 => "NAME",
		),
		"IBLOCK_2_PROPERTY" => array(
			0 => "",
			1 => "ARTNUMBER",
			2 => "ARTNUMBER_MANUFACTURER",
		),
		"IBLOCK_2_REGEX" => "",
		"IBLOCK_2_SECTION" => array(
			0 => "16",
			1 => "17",
			2 => "18",
			3 => "19",
			4 => "20",
			5 => "21",
			6 => "22",
			7 => "23",
			8 => "26",
			9 => "27",
			10 => "28",
			11 => "29",
			12 => "32",
			13 => "34",
			14 => "35",
			15 => "36",
			16 => "38",
			17 => "42",
			18 => "43",
			19 => "44",
			20 => "46",
			21 => "48",
			22 => "50",
			23 => "51",
			24 => "52",
			25 => "53",
			26 => "54",
			27 => "57",
			28 => "62",
			29 => "63",
			30 => "64",
			31 => "65",
			32 => "66",
			33 => "67",
			34 => "68",
			35 => "69",
			36 => "70",
			37 => "71",
			38 => "72",
			39 => "73",
			40 => "74",
			41 => "75",
			42 => "77",
			43 => "78",
			44 => "79",
			45 => "80",
			46 => "82",
			47 => "88",
			48 => "89",
			49 => "91",
			50 => "94",
			51 => "95",
			52 => "96",
			53 => "97",
			54 => "98",
			55 => "99",
			56 => "100",
			57 => "101",
			58 => "102",
			59 => "103",
			60 => "104",
			61 => "105",
			62 => "107",
			63 => "108",
			64 => "127",
			65 => "128",
			66 => "129",
			67 => "30",
			68 => "31",
			69 => "92",
			70 => "109",
			71 => "106",
			72 => "",
		),
		"IBLOCK_2_SHOW_FIELD" => array(
		),
		"IBLOCK_2_SHOW_PROPERTY" => array(
		),
		"IBLOCK_2_TITLE" => "Главный каталог",
		"IBLOCK_ID" => array(
			0 => "2",
			1 => "",
		),
		"IBLOCK_TYPE" => array(
			0 => "catalog",
		),
		"INCLUDE_CSS" => "Y",
		"INCLUDE_JQUERY" => "Y",
		"INPUT_PLACEHOLDER" => "Найди среди 10 000 товаров!",
		"ITEMS_LIMIT" => "5",
		"JQUERY_BACKDROP_BACKGROUND" => "#3879D9",
		"JQUERY_BACKDROP_OPACITY" => "0.1",
		"JQUERY_BACKDROP_Z_INDEX" => "900",
		"JQUERY_SCROLL_THEME" => "_simple",
		"JQUERY_SEARCH_PARENT_ID" => ".api-search-title",
		"JQUERY_WAIT_TIME" => "500",
		"PICTURE" => array(
			0 => "PREVIEW_PICTURE",
			1 => "DETAIL_PICTURE",
		),
		"PRICE_CODE" => array(
		),
		"PRICE_EXT" => "N",
		"PRICE_VAT_INCLUDE" => "Y",
		"RESIZE_PICTURE" => "45x45",
		"RESULT_NOT_FOUND" => "По вашему запросу ничего не найдено...",
		"RESULT_PAGE" => SITE_DIR."catalog/",
		"RESULT_URL_TEXT" => "Все результаты",
		"SEARCH_MODE" => "JOIN",
		"SORT_BY1" => "SORT",
		"SORT_BY2" => "ID",
		"SORT_BY3" => "TIMESTAMP_X",
		"SORT_ORDER1" => "ASC",
		"SORT_ORDER2" => "DESC",
		"SORT_ORDER3" => "DESC",
		"USE_CURRENCY_SYMBOL" => "N",
		"USE_SEARCH_QUERY" => "Y",
		"USE_TITLE_RANK" => "Y"
	),
	false
);?>

                        </div>
                        <div id="topMenu" class="col-md-7" style="padding-left: 0 !important;">
                            <?$APPLICATION->IncludeComponent(
                                "bitrix:menu",
                                "top-menu",
                                array(
                                    "ALLOW_MULTI_SELECT" => "N",
                                    "CHILD_MENU_TYPE" => "left",
                                    "DELAY" => "N",
                                    "MAX_LEVEL" => "2",
                                    "MENU_CACHE_GET_VARS" => array(
                                    ),
                                    "MENU_CACHE_TIME" => "3600",
                                    "MENU_CACHE_TYPE" => "Y",
                                    "MENU_CACHE_USE_GROUPS" => "Y",
                                    "ROOT_MENU_TYPE" => "top",
                                    "USE_EXT" => "N",
                                    "COMPONENT_TEMPLATE" => "top-menu",
                                    "MENU_THEME" => "site"
                                ),
                                false
                            );?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="container" id="menu-slick">
        <div class="row">
            <div class="col-md-12">
                <?if($APPLICATION->GetCurPage() != "/"):?>
                    <?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "bc-new", Array(

                    ),
                        false
                    );?>
                <?endif;?>
            </div>
        </div>
    </div>
<section class="main-content <?if($APPLICATION->GetCurDir() != "/"):?>content-inside<?endif;?>
<?if($APPLICATION->GetCurDir() == "/contacts/" or $APPLICATION->GetCurDir() == "/contacts/main-office/"):?>contacts page<?endif;?>
<?if($APPLICATION->GetCurDir() == "/about/gallery/"):?>img-gallery page<?endif?>
<?if($APPLICATION->GetCurDir() == "/contacts/regional-branches/"):?>branches<?endif?>
<?if(preg_match('/about\/career/',$APPLICATION->GetCurDir()) or preg_match('/about\/information/',$APPLICATION->GetCurDir()) or preg_match('/support/',$APPLICATION->GetCurDir())):?> career page<?endif?>
<?if($APPLICATION->GetCurDir() == "/contacts/review/"):?>  reviews page<?endif?>
<?if($APPLICATION->GetCurDir() == "/authorize/"):?> checkout-box<?endif?>
<?if($APPLICATION->GetCurDir() == "/cooperation/price-list/"):?> price_list page<?endif?>">
    <div class="container">
<?if($APPLICATION->GetCurDir() == "/contacts/"  or $APPLICATION->GetCurDir() == "/contacts/main-office/"):?>
    <div class="contacts_top">
<?endif;?>
    <div class="row">
<?if($APPLICATION->GetCurDir() != "/"):?><div class="col-xs-12">
    <?if(!CSite::InDir('/catalog/')and !CSite::InDir('/about/career/') and !((CSite::InDir('/about/information/') and $APPLICATION->GetCurDir() != "/about/information/")) and !CSite::InDir('/contacts/') and !((CSite::InDir('/support/product-presentation/') and $APPLICATION->GetCurDir() != "/support/product-presentation/")) and !((CSite::InDir('/support/conversion-table/') and $APPLICATION->GetCurDir() != "/support/conversion-table/")) and !((CSite::InDir('/news/') and $APPLICATION->GetCurDir() != "/news/"))):?><h1 class="title title2"><?$APPLICATION->ShowTitle();?></h1><?endif?>
<?endif?>