<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<div class="col-md-4  not-margin" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		<div class="news-box">
			<div class="date">
				<?$day = substr($arItem['ACTIVE_FROM'],0,2);?>
				<?$year = substr($arItem['ACTIVE_FROM'],6,4);?>
				<div class="num"><?=$day?></div>
				<?=$arItem['DISPLAY_ACTIVE_FROM']?><br>
				<?=$year?>
			</div>
			<h3><?=$arItem['NAME']?></h3>
			<div class="prev-text"><a href="<?=$arItem['DETAIL_PAGE_URL']?>"><?=$arItem['PREVIEW_TEXT']?></a></div>
		</div>
		<?if($arItem['PREVIEW_PICTURE']['SRC'] != ""):?><a href="<?=$arItem['DETAIL_PAGE_URL']?>"><div class="image-preview"><img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>"></div></a><?endif?>
	</div>
<?endforeach?>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br clear="both"><?=$arResult["NAV_STRING"]?>
<?endif;?>
