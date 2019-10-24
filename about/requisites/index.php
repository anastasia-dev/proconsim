<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("keywords_inner", "трубопроводная, запорная, арматура, клапаны, отводы, радиаторы");
$APPLICATION->SetPageProperty("title", "Реквизиты компании - Проконсим");
$APPLICATION->SetPageProperty("keywords", "Проконсим");
$APPLICATION->SetPageProperty("description", "Реквизиты компании Проконсим - оптовая продажа трубопроводной арматуры");
$APPLICATION->SetTitle("Реквизиты");?>
<?$city_id = $APPLICATION->get_cookie('USER_CITY');?> <?$city = $APPLICATION->get_cookie('USER_CITY_NAME');?> <?GLOBAL $FilterHeader;?> <?if(intval($city_id) == 0):?> <?$city = "moskva";?> <?else:?> <?endif?> <?GLOBAL $CityFilterSlid;?> <?GLOBAL $CITY;?> <?$CityFilterSlid['PROPERTY_LINK'] = $CITY;?> <?
$city_a = "/include/requisites/";
$city_a .= $city;
$city_a .= "_req.php";
?>
<?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	".default",
	Array(
		"AREA_FILE_RECURSIVE" => "Y",
		"AREA_FILE_SHOW" => "file",
		"AREA_FILE_SUFFIX" => "inc",
		"COMPONENT_TEMPLATE" => ".default",
		"EDIT_TEMPLATE" => "",
		"PATH" => $city_a
	)
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>