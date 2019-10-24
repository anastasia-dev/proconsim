<?
define("NEED_AUTH", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Страница запроса пароля в случае, если вы его забыли");
$APPLICATION->SetTitle("Запрос пароля");
?>
<?$APPLICATION->IncludeComponent(
	"bitrix:system.auth.form", 
	"messages", 
	array(
		"FORGOT_PASSWORD_URL" => "",
		"PROFILE_URL" => "",
		"REGISTER_URL" => "",
		"SHOW_ERRORS" => "Y",
		"COMPONENT_TEMPLATE" => "messages"
	),
	false
);
?>
<?$APPLICATION->IncludeComponent(
	"bitrix:system.auth.forgotpasswd", 
	"fpass", 
	array(
		"COMPONENT_TEMPLATE" => "fpass"
	),
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>