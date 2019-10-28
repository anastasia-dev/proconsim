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
$count=0;
?>
<div class="news-list visible-lg visible-md">

<?foreach($arResult["ITEMS"] as $arItem):?>
	<?if(trim($arItem['DETAIL_PICTURE']['SRC']) != "" && $count<2):?>
		<? $count++;
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>
	<div class="banner-catalog-img" id="<?=$this->GetEditAreaId($arItem['ID']);?>"><?if($arItem['PROPERTIES']['LINK']['VALUE'] != ""):?><a href="/bitrix/redirect.php?event1=banner<?=$arItem['ID']?>&event2=catalog&event3=catalog&goto=<?=$arItem['PROPERTIES']['LINK']['VALUE']?>"><?endif;?><img src="<?=$arItem['DETAIL_PICTURE']['SRC']?>" alt="<?=$arItem['DETAIL_PICTURE']['ALT']?>" class="img-responsive"><?if($arItem['PROPERTIES']['LINK']['VALUE'] != ""):?></a><?endif;?></div>
	<?endif;?>
<?endforeach;?>
</div>

