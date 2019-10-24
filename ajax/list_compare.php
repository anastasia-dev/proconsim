<?require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");
$APPLICATION->IncludeComponent(
	"bitrix:catalog.compare.list",
	"",
	array(
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => "2",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"DETAIL_URL" => "#SECTION_CODE#",
		"COMPARE_URL" => "/catalog/compare.php",
		"NAME" => "CATALOG_COMPARE_LIST",
		"AJAX_OPTION_ADDITIONAL" => ""
	),
false
);
$APPLICATION->RestartBuffer();

$comparesCount = 0;
if(isset($_SESSION['CATALOG_COMPARE_LIST'], $_SESSION['CATALOG_COMPARE_LIST'][2])) {
	$comparesCount = sizeof($_SESSION['CATALOG_COMPARE_LIST'][2]['ITEMS']);
}

echo json_encode(array('count' => $comparesCount));
exit;
