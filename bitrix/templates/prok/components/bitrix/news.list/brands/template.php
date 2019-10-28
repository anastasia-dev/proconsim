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

<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<div class="col-xs-6 col-sm-4 col-md-2 inner-brand"  id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		<?if($arItem['PROPERTIES']['LINK']['VALUE'] != ""):?><a href="<?=$arItem['PROPERTIES']['LINK']['VALUE']?>">
		<?elseif($arResult['BRAND_LINK'][$arItem['ID']] != ""):?><a href="<?=$arResult['BRAND_LINK'][$arItem['ID']]?>"><?endif;?>
		<div class="brands-box <?if(trim($arItem['PREVIEW_TEXT']) == ""):?>klein<?endif?>">
			<div class="brand-img">
				<?if(trim($arItem['PREVIEW_PICTURE']['SRC']) != ""):?>
					<img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arItem['PREVIEW_PICTURE']['ALT']?>">
				<?endif?>
				<?if(trim($arItem['DETAIL_PICTURE']['SRC']) != ""):?>
					<img src="<?=$arItem['DETAIL_PICTURE']['SRC']?>" alt="<?=$arItem['PREVIEW_PICTURE']['ALT']?>">
				<?endif?>
			</div>
			<h3><?=$arItem['NAME']?></h3>
			<p style="margin:0;"><?=$arItem['PREVIEW_TEXT']?></p>
		</div>
		<?if($arItem['PROPERTIES']['LINK']['VALUE'] != ""):?></a>
		<?elseif($arResult['BRAND_LINK'][$arItem['ID']] != ""):?></a><?endif;?>
	</div>
<?endforeach;?>

