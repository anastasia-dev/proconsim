<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
if(count($arResult["ERRORS"]) > 0)
{
	if(trim($arResult["VALUES"]["UF_INN"]) == ''){
	   $arResult["ERRORS"]["UF_INN"] = 'Поле "ИНН" обязательно для заполнения';
	}
}
//echo "<pre>";
//print_r($arResult);
//echo "</pre>";

?>