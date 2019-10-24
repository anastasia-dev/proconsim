<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Карта сайта");
?><div class="col-xs-12 sitemap"><?
$APPLICATION->IncludeComponent("bitrix:main.map", "sitemaps", Array(
	"CACHE_TYPE" => "A",	// Тип кеширования
		"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
		"SET_TITLE" => "N",	// Устанавливать заголовок страницы
		"LEVEL" => "4",	// Максимальный уровень вложенности (0 - без вложенности)
		"COL_NUM" => "2",	// Количество колонок
		"SHOW_DESCRIPTION" => "Y",	// Показывать описания
	),
	false
);
?></div><?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>