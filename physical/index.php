<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Регистрация личного кабинета (для физических лиц)");
?><?$APPLICATION->IncludeComponent(
	"proc:main.register",
	"registr-physical",
	Array(
		"AUTH" => "Y",
		"COMPONENT_TEMPLATE" => "registr-physical",
		"REQUIRED_FIELDS" => array(0=>"EMAIL",1=>"NAME",2=>"LAST_NAME",3=>"PERSONAL_PHONE",),
		"SET_TITLE" => "N",
		"SHOW_FIELDS" => array(0=>"EMAIL",1=>"NAME",2=>"LAST_NAME",3=>"PERSONAL_PHONE",),
		"SUCCESS_PAGE" => "/personal/physical/",
		"USER_PROPERTY" => array(),
		"USER_PROPERTY_NAME" => "",
		"USE_BACKURL" => "Y"
	)
);?><br>
<?$APPLICATION->IncludeComponent("bitrix:system.auth.form", "auth_soc", Array(
	"FORGOT_PASSWORD_URL" => "",	// Страница забытого пароля
		"PROFILE_URL" => "",	// Страница профиля
		"REGISTER_URL" => "",	// Страница регистрации
		"SHOW_ERRORS" => "N",	// Показывать ошибки
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>