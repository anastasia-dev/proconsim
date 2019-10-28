<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<div class="slider">
<div class="owl-carousel">
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?if(trim($arItem['PREVIEW_PICTURE']['SRC']) != ""):?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>
		<div class="item" id="<?=$this->GetEditAreaId($arItem['ID']);?>"><?if($arItem['PROPERTIES']['LINK']['VALUE'] != ""):?><a href="/bitrix/redirect.php?event1=banner<?=$arItem['ID']?>&event2=index&event3=index&goto=<?=$arItem['PROPERTIES']['LINK']['VALUE']?>"><?endif;?><img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arItem['PREVIEW_PICTURE']['ALT']?>"><?if($arItem['PROPERTIES']['LINK']['VALUE'] != ""):?></a><?endif;?></div>
   <?endif;?>
<?endforeach;?>
</div>
</div>