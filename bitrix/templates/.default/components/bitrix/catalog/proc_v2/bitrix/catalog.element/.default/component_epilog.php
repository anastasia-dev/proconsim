<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $templateData */
/** @var @global CMain $APPLICATION */
use Bitrix\Main\Loader;
global $APPLICATION;
if (isset($templateData['TEMPLATE_THEME']))
{
	$APPLICATION->SetAdditionalCSS($templateData['TEMPLATE_THEME']);
}
if (isset($templateData['TEMPLATE_LIBRARY']) && !empty($templateData['TEMPLATE_LIBRARY']))
{
	$loadCurrency = false;
	if (!empty($templateData['CURRENCIES']))
		$loadCurrency = Loader::includeModule('currency');
	CJSCore::Init($templateData['TEMPLATE_LIBRARY']);
	if ($loadCurrency)
	{
	?>
	<script type="text/javascript">
		BX.Currency.setCurrencies(<? echo $templateData['CURRENCIES']; ?>);
	</script>
<?
	}
}
if (isset($templateData['JS_OBJ']))
{
?><script type="text/javascript">
BX.ready(BX.defer(function(){
	if (!!window.<? echo $templateData['JS_OBJ']; ?>)
	{
		window.<? echo $templateData['JS_OBJ']; ?>.allowViewedCount(true);
	}
}));
</script><?
}

//if ($USER->IsAdmin()){
//echo "<pre>";
//print_r($arResult);
//echo "</pre>";
//}

if(!empty($arResult["CUSTOM_META"]["TITLE"])){
    $APPLICATION->SetTitle($arResult["CUSTOM_META"]["TITLE"]); 
    $APPLICATION->SetPageProperty('title', $arResult["CUSTOM_META"]["TITLE"]);
} elseif (
    isset($arResult['CUSTOM_IPROPERTY_VALUES']['ELEMENT_META_TITLE'])
    && !empty($arResult['CUSTOM_IPROPERTY_VALUES']['ELEMENT_META_TITLE'])
) {
    $APPLICATION->SetTitle($arResult['CUSTOM_IPROPERTY_VALUES']['ELEMENT_META_TITLE']); 
    $APPLICATION->SetPageProperty('title', $arResult['CUSTOM_IPROPERTY_VALUES']['ELEMENT_META_TITLE']); 
} else {
    $APPLICATION->SetTitle(htmlspecialcharsbx($arResult['NAME'])); 
    $APPLICATION->SetPageProperty('title', htmlspecialcharsbx($arResult['NAME']));
}

if(!empty($arResult["CUSTOM_META"]["KEYWORDS"])){
    $APPLICATION->SetPageProperty('keywords', $arResult["CUSTOM_META"]["KEYWORDS"]);
} elseif (
    isset($arResult['CUSTOM_IPROPERTY_VALUES']['ELEMENT_META_KEYWORDS'])
    && !empty($arResult['CUSTOM_IPROPERTY_VALUES']['ELEMENT_META_KEYWORDS'])
) { 
    $APPLICATION->SetPageProperty('keywords', $arResult['CUSTOM_IPROPERTY_VALUES']['ELEMENT_META_KEYWORDS']); 
}

if(!empty($arResult["CUSTOM_META"]["DESCRIPTION"])){
      $APPLICATION->SetPageProperty('description', $arResult["CUSTOM_META"]["DESCRIPTION"]);
} elseif (
    isset($arResult['CUSTOM_IPROPERTY_VALUES']['ELEMENT_META_DESCRIPTION'])
    && !empty($arResult['CUSTOM_IPROPERTY_VALUES']['ELEMENT_META_DESCRIPTION'])
) {
    $APPLICATION->SetPageProperty('description', $arResult['CUSTOM_IPROPERTY_VALUES']['ELEMENT_META_DESCRIPTION']);
}
?>