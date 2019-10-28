<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_REQUEST["register_submit_button"]) && !$USER->IsAuthorized())
{
	if(!isset($_REQUEST["agrreement"])){
	   $arResult["ERRORS"]["AGREEMENT"] = "Подтвердите согласие с пользовательским соглашением";
	}
}

if(count($arResult["ERRORS"]) > 0)
{
    $myErrors = array(); 

    if(isset($arResult["ERRORS"]["NAME"])){
		//$arResult["ERRORS"]["NAME"] = "Поле \"Контактное лицо\" обязательно для заполнения";
        $myErrors["NAME"] = "Поле \"Имя\" обязательно для заполнения";
	}
	if(isset($arResult["ERRORS"]["LAST_NAME"])){
		//$arResult["ERRORS"]["LAST_NAME"] = "Поле \"Контактное лицо\" обязательно для заполнения";
        $myErrors["LAST_NAME"] = "Поле \"Фамиля\" обязательно для заполнения";
	}
	if(isset($arResult["ERRORS"]["PERSONAL_PHONE"])){
		//$arResult["ERRORS"]["PERSONAL_PHONE"] = "Поле \"Телефон\" обязательно для заполнения";
        $myErrors["PERSONAL_PHONE"] = "Поле \"Телефон\" обязательно для заполнения";
	}
	if(isset($arResult["ERRORS"]["EMAIL"])){
		//$arResult["ERRORS"]["EMAIL"] = "Поле \"E-mail\" обязательно для заполнения";
        $myErrors["EMAIL"] = "Поле \"E-mail\" обязательно для заполнения";
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
	if(isset($arResult["ERRORS"]["AGREEMENT"])){
        $myErrors["AGREEMENT"] = $arResult["ERRORS"]["AGREEMENT"];
	}
	$arResult["ERRORS"] = $myErrors;

}
//echo "<pre>";
//print_r($arResult);
//echo "</pre>";

?>