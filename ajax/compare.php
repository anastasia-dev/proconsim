<?require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");?>
<?
//[CATALOG_COMPARE_LIST][2][ITEMS]
// action: ADD_TO_COMPARE_LIST
// id: 49990
CModule::IncludeModule("iblock");

$flag = false; // метка, у которое значение true сообщает что товар добавить нельзя

if ($_GET['clear_compare_list'] == 'y') {
	$_SESSION['CATALOG_COMPARE_LIST'][2]['ITEMS'] = array();
}

if ($_GET['action'] == 'ADD_TO_COMPARE_LIST' && (int)$_GET['id'] > 0) {

	$APPLICATION->IncludeComponent(
		"bitrix:catalog.compare.list", 
		".default", 
		array(
			"ACTION_VARIABLE" => "action",
			"AJAX_MODE" => "N",
			"AJAX_OPTION_ADDITIONAL" => "",
			"AJAX_OPTION_HISTORY" => "N",
			"AJAX_OPTION_JUMP" => "N",
			"AJAX_OPTION_STYLE" => "Y",
			"COMPARE_URL" => "/catalog/compare.php",
			"DETAIL_URL" => "",
			"IBLOCK_ID" => "2",
			"IBLOCK_TYPE" => "catalog",
			"NAME" => "CATALOG_COMPARE_LIST",
			"POSITION" => "top left",
			"POSITION_FIXED" => "Y",
			"PRODUCT_ID_VARIABLE" => "id",
			"COMPONENT_TEMPLATE" => ".default"
		),
		false
	);
} 

?>