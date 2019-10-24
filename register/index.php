<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Страница регистрации личного кабинета (только для юридических лиц). Компания Проконсим.");
$APPLICATION->SetTitle("Регистрация личного кабинета (для юридических лиц)");
?><?$APPLICATION->IncludeComponent(
	"proc:main.register", 
	"registr-new", 
	array(
		"AUTH" => "Y",
		"REQUIRED_FIELDS" => array(
			0 => "EMAIL",
			1 => "LAST_NAME",
			2 => "WORK_COMPANY",
			3 => "WORK_PHONE",
			4 => "WORK_STREET",
		),
		"SET_TITLE" => "Y",
		"SHOW_FIELDS" => array(
			0 => "EMAIL",
			1 => "LAST_NAME",
			2 => "WORK_COMPANY",
			3 => "WORK_PHONE",
			4 => "WORK_STREET",
			5 => "WORK_PROFILE",
		),
		"SUCCESS_PAGE" => "",
		"USER_PROPERTY" => array(
			0 => "UF_INN",
			1 => "UF_FILIAL_CODE",
			2 => "UF_FILIAL",
		),
		"USER_PROPERTY_NAME" => "",
		"USE_BACKURL" => "Y",
		"COMPONENT_TEMPLATE" => "registr-new"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>