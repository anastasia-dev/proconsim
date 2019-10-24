<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php"); ?>
<?php
use \Bitrix\Main\Application;
use \Bitrix\Main\Web\Cookie;

global $APPLICATION;
define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);
header('Content-type: text/html; charset=utf-8');
CModule::IncludeModule('iblock');
$act = $_REQUEST['act'];
$ID = intval($_REQUEST['id']);
if ($ID > 0) {
    $arrItemID = array();
    if (!$USER->IsAuthorized()) {
        $arElements = unserialize($APPLICATION->get_cookie('bo_favorites'));
        if ($act == 'del') {
            unset($arElements[$ID]);
        } else {
            $arElements[$ID] = $ID;
        }

        $value = serialize($arElements);
        $time = 3600*24*30;//30 d
        $cookie = new Cookie("bo_favorites", $value, time() + $time);
        $cookie->setDomain($context->getServer()->getHttpHost());
        $cookie->setHttpOnly(true);
        $cookie->setSecure(false);
        $context->getResponse()->addCookie($cookie);
        $context->getResponse()->flush("");
    } else {
        $idUser = $USER->GetID();
        $rsUser = CUser::GetByID($idUser);
        $arUser = $rsUser->Fetch();
        $arElements = unserialize($arUser['UF_FAVORITES']);
        if ($act == 'del') {
            unset($arElements[$ID]);
        } else {
            $arElements[$ID] = $ID;
        }
        $USER->Update($idUser, array("UF_FAVORITES"=>serialize($arElements)));
    }
    $array = array("res" => $arElements,'count' => count($arElements));
    echo json_encode($array);
    exit;
}
