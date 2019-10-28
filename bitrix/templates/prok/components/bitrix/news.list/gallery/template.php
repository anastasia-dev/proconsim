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
<div class="gallery-big">
<?foreach($arResult["ITEMS"] as $arItem):?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>
		<div class="item">
			<div class="row">
				<div class="col-sm-8">
					<div class="img"><img src="<?=$arItem['DETAIL_PICTURE']['SRC']?>" /></div>
				</div>
				<div class="col-sm-4 img-txt">
					<h2><?=$arItem['NAME']?></h2>
					<p>
					<?=$arItem['DETAIL_TEXT']?>
					</p>
				</div>
			</div>
		</div>
<?endforeach;?>
</div>
<?$i=0;?>
<div class="gallery-nav">
<?foreach($arResult["ITEMS"] as $arItem):?>

<?if($i%6==0 and $i != 0):?></div><div class="gallery-nav"><?endif?>
<?$i++;?>
<div class="item">
	<div class="img"><img src="<?=$arItem['DETAIL_PICTURE']['SRC']?>" /></div>
</div>
<?endforeach;?>
</div>