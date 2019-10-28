<?
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2014 Bitrix
 */

/**
 * Bitrix vars
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

//one css for all system.auth.* forms
$APPLICATION->SetAdditionalCSS("/bitrix/css/main/system.auth/flat/style.css");


?>
<div class="bx-authform">
<?$APPLICATION->IncludeComponent(
	"bitrix:main.register",
	"registr-new",
	Array(
		"AUTH" => "Y",
		"REQUIRED_FIELDS" => array("WORK_COMPANY", "WORK_PHONE", "EMAIL", "LAST_NAME", "WORK_STREET"),
		"SET_TITLE" => "Y",
		"SHOW_FIELDS" => array("WORK_COMPANY", "WORK_PHONE", "EMAIL", "LAST_NAME", "WORK_STREET"),
		"SUCCESS_PAGE" => "",
		"USER_PROPERTY" => array("UF_INN"),
		"USER_PROPERTY_NAME" => "",
		"USE_BACKURL" => "Y"
	)
);

?><p><a href="<?=$arResult["AUTH_AUTH_URL"]?>"><b><?=GetMessage("AUTH_AUTH")?></b></a></p>
</div>
<?

?>