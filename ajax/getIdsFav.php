<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
use \Bitrix\Main\Application;
use \Bitrix\Main\Web\Cookie;

global $APPLICATION;
define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);
header('Content-type: text/html; charset=utf-8');
CModule::IncludeModule('iblock');
?>
<?
if(!$USER->IsAuthorized()){
	$arFavElements = unserialize($APPLICATION->get_cookie('bo_favorites'));
}
else{
	$idUser = $USER->GetID();
	$rsUser = CUser::GetByID($idUser);
	$arUser = $rsUser->Fetch();
	$arFavElements = unserialize($arUser['UF_FAVORITES']);
}
$favlements = array();
if(!empty($arFavElements)) {
	$favlements = $arFavElements;
}
echo json_encode(array("res" => $favlements));
