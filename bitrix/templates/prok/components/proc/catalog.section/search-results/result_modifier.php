<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogSectionComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();


if(!isset($_GET["set_filter"])){
$arSort[$arParams["ELEMENT_SORT_FIELD"]] = $arParams["ELEMENT_SORT_ORDER"];

global ${$arParams["FILTER_NAME"]};
$arrFilter = ${$arParams["FILTER_NAME"]};

$arFilter = array(
		"IBLOCK_ID"=>$arParams["IBLOCK_ID"],
		"ACTIVE"=>"Y",
		"GLOBAL_ACTIVE"=>"Y",
	);

$arSelect = array("ID");
$arResult["ALL_ELEMENTS"] = array();
$rsElements = CIBlockElement::GetList($arSort, array_merge($arrFilter, $arFilter), false, false, $arSelect);
while($arItem = $rsElements->GetNext())
	{
		$arResult["ALL_ELEMENTS"][] = (int)$arItem['ID'];
	}
//echo "<pre>";
//print_r($arResult["ALL_ELEMENTS"]);
//echo "</pre>";
$_SESSION["SEARCH_ELEMENTS"] = $arResult["ALL_ELEMENTS"];
}