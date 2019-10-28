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
	<h2 class="title"><span>Новости</span></h2>
</div>
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<div class="col-md-4" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		<div class="news-box">
			<div class="date">
				<?$day = substr($arItem['DATE_ACTIVE_FROM'],0,2);?>
				<?$year = substr($arItem['DATE_ACTIVE_FROM'],6,4);?>
				<div class="num"><?=$day?></div>
				<?=$arItem['DISPLAY_ACTIVE_FROM']?><br>
				<?=$year?>
			</div>
			<h3><a href="<?=$arItem['DETAIL_PAGE_URL']?>"><?=$arItem['NAME']?></a></h3>
			<?if(trim($arItem['PREVIEW_TEXT']) != ""):?><div class="prev-text"><a href="<?=$arItem['DETAIL_PAGE_URL']?>"><?=$arItem['PREVIEW_TEXT']?></a></div><?endif;?>
		</div>
		<?if($arItem['PREVIEW_PICTURE']['SRC'] != ""):?><a href="<?=$arItem['DETAIL_PAGE_URL']?>"><div class="image-preview"><img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>"></div></a><?endif?>
	</div>
<?endforeach?>
<div class="col-md-12">
		<div class="text-right">
	<a href="/news/" class="all-news">Архив новостей</a>
	</div>
</div>