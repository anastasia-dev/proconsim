<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
$compares = array();
if(isset($_SESSION['CATALOG_COMPARE_LIST'], $_SESSION['CATALOG_COMPARE_LIST'][2])) {
	$compares = $_SESSION['CATALOG_COMPARE_LIST'][2]['ITEMS'];
}

echo json_encode(array("res" => $compares));
