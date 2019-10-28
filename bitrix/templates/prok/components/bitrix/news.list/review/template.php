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
<div class="reviews_list">
	<h2>Отзывы клиентов:</h2>
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<div class="item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		<div class="head">
			<div class="rating-star">
				<?for($i=0;$i<5;$i++){?>
					<?if($i<$arItem['PROPERTIES']['RATING']['VALUE']):?>
						<div class="star blue-star"></div>
					<?else:?>
						<div class="star gray-star"></div>
					<?endif?>
				<?}?>
			</div>
			<h3><?=$arItem['PROPERTIES']['USER']['VALUE']?> <span class="date"><?=$arItem['DISPLAY_ACTIVE_FROM']?></span></h3>
		</div>
		<p>			
			<?=$arItem['PREVIEW_TEXT']?>
		</p>
	</div>
<?endforeach?>
</div>
		