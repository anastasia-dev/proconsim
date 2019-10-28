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
</div>	
<div class="mini-boot">
<?$count = 0;?>		

<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<?if($count==4):?>
		</div><div class="col-md-12"><div class="owl-carousel4">
	<?elseif($count<4):?>
		<div class="col-md-3" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		<?if($arItem['PROPERTIES']['LINK']['VALUE'] != ""):?><a href="/catalog/nashi_brendy/filter/brand-is-<?=$arItem['CODE']?>/apply/">
		<?elseif($arResult['BRAND_LINK'][$arItem['ID']] != "" or $arResult['BRAND_LINK'][$arItem['NAME']] != ""):?><a href="/catalog/nashi_brendy/filter/brand-is-<?=$arItem['CODE']?>/apply/"><?endif;?>

			<div class="brands-box">
				<div class="brand-img">
					<?if(trim($arItem['PREVIEW_PICTURE']['SRC']) != ""):?>
						<img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arItem['PREVIEW_PICTURE']['ALT']?>">
					<?endif?>
					<?if(trim($arItem['DETAIL_PICTURE']['SRC']) != ""):?>
						<img src="<?=$arItem['DETAIL_PICTURE']['SRC']?>" alt="<?=$arItem['PREVIEW_PICTURE']['ALT']?>">
					<?endif?>
				</div>
				<h3><?=$arItem['NAME']?></h3>
				<p><?=$arItem['PREVIEW_TEXT']?></p>
						</div>
			<?if($arItem['PROPERTIES']['LINK']['VALUE'] != ""):?></a>
		<?elseif($arResult['BRAND_LINK'][$arItem['ID']] != "" or $arResult['BRAND_LINK'][$arItem['NAME']] != ""):?></a><?endif;?>
		</div>
	<?else:?>
		<div class="item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		<?if($arItem['PROPERTIES']['LINK']['VALUE'] != ""):?><a href="<?=$arItem['PROPERTIES']['LINK']['VALUE']?>">
		<?elseif($arResult['BRAND_LINK'][$arItem['ID']] != ""):?><a href="<?=$arResult['BRAND_LINK'][$arItem['ID']]?>filter/brands-is-<?=$arItem['CODE']?>/apply/"><?endif;?>

			<div class="brands-box">
				<div class="brand-img-full">
					<?if(trim($arItem['PREVIEW_PICTURE']['SRC']) != ""):?>
						<img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arItem['PREVIEW_PICTURE']['ALT']?>">
					<?endif?>
					<?/*if(trim($arItem['DETAIL_PICTURE']['SRC']) != ""):?>
						<img src="<?=$arItem['DETAIL_PICTURE']['SRC']?>" alt="<?=$arItem['PREVIEW_PICTURE']['ALT']?>">
					<?endif*/?>
				</div>
			</div>
			<?if($arItem['PROPERTIES']['LINK']['VALUE'] != ""):?></a>
		<?elseif($arResult['BRAND_LINK'][$arItem['ID']] != ""):?></a><?endif;?>
		</div>
	<?endif;?>
	<?$count++;?>	
<?endforeach;?>
</div>
</div>
<div class="col-md-12">
	<div class="text-right">
		<a href="/brands/" class="all-news">Посмотреть все бренды</a>
	</div>
</div>