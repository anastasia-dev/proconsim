<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Адрес и время работы центрального офиса и склада в Москве. Телефон: 8 (495) 988-00-32.");
$APPLICATION->SetPageProperty("title", "Контакты - Проконсим");
$APPLICATION->SetTitle("Контакты");
?><?$city_id = $APPLICATION->get_cookie('USER_CITY');?> <?$city = $APPLICATION->get_cookie('USER_CITY_NAME');?> 
<?
if(intval($city_id) == 0){
    $city = "moskva";
    $city_id = 439;
  }
?>
<?
  $arSelectRegions = Array("ID", "IBLOCK_ID", "NAME", "CODE", "PROPERTY_YANDEX_LAT", "PROPERTY_YANDEX_LON", "PROPERTY_CONTACTS_ADDRESS", "PROPERTY_CONTACTS_EMAIL", "PROPERTY_CONTACTS_PHONE", "PROPERTY_CONTACTS_MAP");
   $arFilterRegions = Array(
                         "IBLOCK_ID"=>6, 
                         "ACTIVE"=> "Y",
                         "ID" => $city_id
   );
   $resRegions = CIBlockElement::GetList(Array("SORT"=>"asc"), $arFilterRegions, false, false, $arSelectRegions);
   while($obRegions = $resRegions->GetNextElement()){ 
        $arRegionsFields = $obRegions->GetFields();
  //echo "<pre>";
//print_r($arRegionsFields);
//echo "</pre>";
  } 
?>
<div class="col-md-6">
<?if(!empty($arRegionsFields["PROPERTY_YANDEX_LAT_VALUE"]) && !empty($arRegionsFields["PROPERTY_YANDEX_LON_VALUE"])){?> 
     <?$APPLICATION->IncludeComponent(
    	"bitrix:map.yandex.view", 
    	"yamap", 
    	array(
    		"COMPONENT_TEMPLATE" => "yamap",
    		"CONTROLS" => array(
    			0 => "ZOOM",
    			1 => "MINIMAP",
    			2 => "TYPECONTROL",
    			3 => "SCALELINE",
    		),
    		"INIT_MAP_TYPE" => "MAP",
    		"MAP_DATA" => "a:4:{s:10:\"yandex_lat\";d:".$arRegionsFields["PROPERTY_YANDEX_LAT_VALUE"].";s:10:\"yandex_lon\";d:".$arRegionsFields["PROPERTY_YANDEX_LON_VALUE"].";s:12:\"yandex_scale\";i:17;s:10:\"PLACEMARKS\";a:1:{i:0;a:3:{s:3:\"LON\";d:".$arRegionsFields["PROPERTY_YANDEX_LON_VALUE"].";s:3:\"LAT\";d:".$arRegionsFields["PROPERTY_YANDEX_LAT_VALUE"].";s:4:\"TEXT\";s:0:\"\";}}}",
    		"MAP_HEIGHT" => "400",
    		"MAP_ID" => "",
    		"MAP_WIDTH" => "100%",
    		"OPTIONS" => array(
    			0 => "ENABLE_SCROLL_ZOOM",
    			1 => "ENABLE_DBLCLICK_ZOOM",
    			2 => "ENABLE_DRAGGING",
    		)
    	),
    	false
    );?>
<?}?>
<?if(!empty($arRegionsFields["~PROPERTY_CONTACTS_MAP_VALUE"]["TEXT"])){?> 
    <div style="margin-top: 20px;"><?=$arRegionsFields["~PROPERTY_CONTACTS_MAP_VALUE"]["TEXT"]?></div>
<?}?>
</div>
<div itemscope itemtype="http://schema.org/LocalBusiness" class="col-xs-12 col-md-6 txt-box">
    <h1 class="title-h2">КОНТАКТЫ</h1>
	<span itemprop="name" style="display: none;">ЗАО фирма «ПРОКОНСИМ»</span> 
    <div class="item">
        <div class="contacts-icon">
         <img src="/bitrix/templates/prok/img/ico-marker.png" alt="">
        </div>
        <div class="contacts-text"><?=$arRegionsFields["~PROPERTY_CONTACTS_ADDRESS_VALUE"]["TEXT"]?></div>
    </div>
    <div class="item">
        <div class="contacts-icon">
            <img src="/bitrix/templates/prok/img/ico-envelope.png" alt="">
        </div>
        <div class="contacts-text"><?=$arRegionsFields["~PROPERTY_CONTACTS_EMAIL_VALUE"]["TEXT"]?></div>
    </div>
    <div class="item">
        <div class="contacts-icon">
            <img src="/bitrix/templates/prok/img/ico-phone-2.png" alt="">
        </div>
        <div class="contacts-text"><?=$arRegionsFields["~PROPERTY_CONTACTS_PHONE_VALUE"]["TEXT"]?></div>
    </div>

</div>
    <div class="col-xs-12 col-md-12 txt-box">
        <h5 class="h5InText">Региональные филиалы</h5>
        <div class="big-map">
            <img src="<?=SITE_TEMPLATE_PATH?>/img/branches-map.png" alt="" class="img-responsive">
        </div>
        <div class="branches_list">
            <div class="row">
                <?$APPLICATION->IncludeComponent("bitrix:news.list", "regional-office", Array(
                    "COMPONENT_TEMPLATE" => ".default",
                    "IBLOCK_TYPE" => "references",	// Тип информационного блока (используется только для проверки)
                    "IBLOCK_ID" => "6",	// Код информационного блока
                    "NEWS_COUNT" => "100",	// Количество новостей на странице
                    "SORT_BY1" => "SORT",	// Поле для первой сортировки новостей
                    "SORT_ORDER1" => "ASC",	// Направление для первой сортировки новостей
                    "SORT_BY2" => "NAME",	// Поле для второй сортировки новостей
                    "SORT_ORDER2" => "ASC",	// Направление для второй сортировки новостей
                    "FILTER_NAME" => "",	// Фильтр
                    "FIELD_CODE" => array(	// Поля
                        0 => "DETAIL_TEXT",
                        1 => "",
                    ),
                    "PROPERTY_CODE" => array(	// Свойства
                        0 => "",
                        1 => "",
                    ),
                    "CHECK_DATES" => "Y",	// Показывать только активные на данный момент элементы
                    "DETAIL_URL" => "",	// URL страницы детального просмотра (по умолчанию - из настроек инфоблока)
                    "AJAX_MODE" => "N",	// Включить режим AJAX
                    "AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
                    "AJAX_OPTION_STYLE" => "Y",	// Включить подгрузку стилей
                    "AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
                    "AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
                    "CACHE_TYPE" => "A",	// Тип кеширования
                    "CACHE_TIME" => "36000000",	// Время кеширования (сек.)
                    "CACHE_FILTER" => "N",	// Кешировать при установленном фильтре
                    "CACHE_GROUPS" => "Y",	// Учитывать права доступа
                    "PREVIEW_TRUNCATE_LEN" => "",	// Максимальная длина анонса для вывода (только для типа текст)
                    "ACTIVE_DATE_FORMAT" => "d.m.Y",	// Формат показа даты
                    "SET_TITLE" => "N",	// Устанавливать заголовок страницы
                    "SET_BROWSER_TITLE" => "N",	// Устанавливать заголовок окна браузера
                    "SET_META_KEYWORDS" => "N",	// Устанавливать ключевые слова страницы
                    "SET_META_DESCRIPTION" => "N",	// Устанавливать описание страницы
                    "SET_LAST_MODIFIED" => "N",	// Устанавливать в заголовках ответа время модификации страницы
                    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",	// Включать инфоблок в цепочку навигации
                    "ADD_SECTIONS_CHAIN" => "N",	// Включать раздел в цепочку навигации
                    "HIDE_LINK_WHEN_NO_DETAIL" => "N",	// Скрывать ссылку, если нет детального описания
                    "PARENT_SECTION" => "",	// ID раздела
                    "PARENT_SECTION_CODE" => "",	// Код раздела
                    "INCLUDE_SUBSECTIONS" => "Y",	// Показывать элементы подразделов раздела
                    "DISPLAY_DATE" => "Y",	// Выводить дату элемента
                    "DISPLAY_NAME" => "Y",	// Выводить название элемента
                    "DISPLAY_PICTURE" => "Y",	// Выводить изображение для анонса
                    "DISPLAY_PREVIEW_TEXT" => "N",	// Выводить текст анонса
                    "PAGER_TEMPLATE" => ".default",	// Шаблон постраничной навигации
                    "DISPLAY_TOP_PAGER" => "N",	// Выводить над списком
                    "DISPLAY_BOTTOM_PAGER" => "Y",	// Выводить под списком
                    "PAGER_TITLE" => "Новости",	// Название категорий
                    "PAGER_SHOW_ALWAYS" => "N",	// Выводить всегда
                    "PAGER_DESC_NUMBERING" => "N",	// Использовать обратную навигацию
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// Время кеширования страниц для обратной навигации
                    "PAGER_SHOW_ALL" => "N",	// Показывать ссылку "Все"
                    "PAGER_BASE_LINK_ENABLE" => "N",	// Включить обработку ссылок
                    "SET_STATUS_404" => "N",	// Устанавливать статус 404
                    "SHOW_404" => "N",	// Показ специальной страницы
                    "MESSAGE_404" => "",	// Сообщение для показа (по умолчанию из компонента)
                ),
                    false
                );?>
            </div>
        </div>
    </div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>