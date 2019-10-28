<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
		</div><div class="col-md-12"><div class="sliderBrands">
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
<div class="brands-slick-item" style="width:180px;height: 110px;padding:5px;margin-left:5px;margin-right:5px;background-color:#ffffff;">
	<div style="height: 100%;background-image: url(<?=$arItem['PREVIEW_PICTURE']['SRC']?>);background-repeat: no-repeat;background-position: 50%;    background-size: contain;">
		<?if($arItem['PROPERTIES']['LINK']['VALUE'] != ""):?><a href="<?=$arItem['PROPERTIES']['LINK']['VALUE']?>" style="display:block;height:100%;">
		<?elseif($arResult['BRAND_LINK'][$arItem['ID']] != ""):?><a href="<?=$arResult['BRAND_LINK'][$arItem['ID']]?>filter/brands-is-<?=$arItem['CODE']?>/apply/" style="display:block;height:100%;"><?endif;?>
			
					
			
			<?if($arItem['PROPERTIES']['LINK']['VALUE'] != ""):?></a>
		<?elseif($arResult['BRAND_LINK'][$arItem['ID']] != ""):?></a><?endif;?>
        </div>
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

<script>
$(document).ready(function () {

$('.sliderBrands').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            arrows: true,
			prevArrow: '<span class="brands-slick-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></span>',
			nextArrow: '<span class="brands-slick-next"><i class="fa fa-angle-right" aria-hidden="true"></i></span>',
			responsive: [
				{
				  breakpoint: 1000,
				  settings: {
					slidesToShow: 4
				  }
				},
				{
				  breakpoint: 600,
				  settings: {
					slidesToShow: 2
				  }
				}
			  ]
        });
});
</script>
