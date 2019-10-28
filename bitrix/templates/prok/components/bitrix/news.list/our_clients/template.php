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
<div class="col-md-12">
	<h2 class="title"><span><?=$arResult['NAME']?></span></h2>
	<ul>
<?$i = 0;?>
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<?if($i == 6):?>
		</ul><ul class="hidden-client">
	<?endif;?>
	<?$i++;?>
	<li id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		<?if(!empty($arItem["PROPERTIES"]["PARTNER_LINK"]["VALUE"])){?>
           <a href="<?=$arItem["PROPERTIES"]["PARTNER_LINK"]["VALUE"]?>" rel="nofollow" target="_blank">
		<?}?>
    	<img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt=""></li>
		<?if(!empty($arItem["PROPERTIES"]["PARTNER_LINK"]["VALUE"])){?>
			</a>
		<?}?>
<?endforeach;?>
	</ul>
	<div class="text-right">
		<a href="" class="hidden-client-button more">Посмотреть все</a>
		<a href="" class="hidden-client-button more small">Свернуть</a>
	</div>
</div>