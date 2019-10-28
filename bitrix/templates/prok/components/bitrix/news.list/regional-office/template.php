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
<?$num = count($arResult['ITEMS']);?>
<?$num = intval($num/2);?>
<div class="row">
	<div class="col-md-6">
<?foreach($arResult["ITEMS"] as $key => $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<?if($arItem['~DETAIL_TEXT'] != ""):?>
	<?if($key==$num):?>
		</div><div class="col-md-6">
	<?endif?>
	<p id="<?=$this->GetEditAreaId($arItem['ID']);?>">
	<b><?=$arItem['NAME']?></b> <?=$arItem['~DETAIL_TEXT']?>
	</p>
	<?endif;?>
	<?endforeach;?>
</div></div>