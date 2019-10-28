<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
if(count($arResult["ERRORS"]) > 0)
{
    $myErrors = array(); 
	if(isset($arResult["ERRORS"]["WORK_COMPANY"])){
		//$arResult["ERRORS"]["WORK_COMPANY"] = "Поле \"Название организации\" обязательно для заполнения";
        $myErrors["WORK_COMPANY"] = "Поле \"Название организации\" обязательно для заполнения";
	}
	if(trim($arResult["VALUES"]["UF_INN"]) == ''){
		//$arResult["ERRORS"]["UF_INN"] = 'Поле "ИНН" обязательно для заполнения';
        $myErrors["UF_INN"] = 'Поле "ИНН" обязательно для заполнения';
	}
	if(isset($arResult["ERRORS"]["WORK_PHONE"])){
		//$arResult["ERRORS"]["WORK_PHONE"] = "Поле \"Телефон\" обязательно для заполнения";
        $myErrors["WORK_PHONE"] = "Поле \"Телефон\" обязательно для заполнения";
	}
	if(isset($arResult["ERRORS"]["EMAIL"])){
		//$arResult["ERRORS"]["EMAIL"] = "Поле \"E-mail\" обязательно для заполнения";
        $myErrors["EMAIL"] = "Поле \"E-mail\" обязательно для заполнения";
	}
	if(isset($arResult["ERRORS"]["LAST_NAME"])){
		//$arResult["ERRORS"]["LAST_NAME"] = "Поле \"Контактное лицо\" обязательно для заполнения";
        $myErrors["LAST_NAME"] = "Поле \"Контактное лицо\" обязательно для заполнения";
	}
	if(trim($arResult["VALUES"]["UF_FILIAL"]) == ''){
		//$arResult["ERRORS"]["UF_INN"] = 'Поле "ИНН" обязательно для заполнения';
        $myErrors["UF_FILIAL"] = 'Поле "Желаемый филиал обслуживания" обязательно для заполнения';
	}
	if(isset($arResult["ERRORS"]["WORK_STREET"])){
		//$arResult["ERRORS"]["WORK_STREET"] = "Поле \"Адрес\" обязательно для заполнения";
        $myErrors["WORK_STREET"] = "Поле \"Адрес\" обязательно для заполнения";
	}
	if(isset($arResult["ERRORS"]["PASSWORD"])){
		//$arResult["ERRORS"]["PASSWORD"] = "Поле \"Пароль\" обязательно для заполнения";
        $myErrors["PASSWORD"] = "Поле \"Пароль\" обязательно для заполнения";
	}
	if(isset($arResult["ERRORS"]["CONFIRM_PASSWORD"])){
		//$arResult["ERRORS"]["CONFIRM_PASSWORD"] = "Поле \"Подтверждение пароля\" обязательно для заполнения";
        $myErrors["CONFIRM_PASSWORD"] = "Поле \"Подтверждение пароля\" обязательно для заполнения";
	}
	if(isset($arResult["ERRORS"][0])){
		//$arResult["ERRORS"][0] = "Неверно введено слово с картинки";
        $myErrors["0"] = $arResult["ERRORS"][0];
	}
	$arResult["ERRORS"] = $myErrors;

}
//echo "<pre>";
//print_r($arResult);
//echo "</pre>";

?>