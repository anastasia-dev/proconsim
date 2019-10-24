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
</div><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>