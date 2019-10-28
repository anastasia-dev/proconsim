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
<?$slide = 0;?>
<?$oneslid = ""?>
<?if($arResult['DETAIL_PICTURE']['SRC'] != ""):?>
	<?$slide ++;?>
	<?$oneslid = $arResult['DETAIL_PICTURE']['SRC']?>
<?endif;?>
<?if(!empty($arResult['PROPERTIES']['PICS_NEWS']['VALUE'])):?>
	<?foreach($arResult['PROPERTIES']['PICS_NEWS']['VALUE'] as $DopPict):?>
		<?$slide ++;?>
		<?$oneslid = $DopPict;?>
	<?endforeach;?>
<?endif;?>
<div class="news-title">Новости</div>
<div class="col-md-6">
	<div class="slider">
	<?if($slide>1):?>
		<div class="owl-carousel">
			<?if($arResult['DETAIL_PICTURE']['SRC']!=""):?>
				<div class="item"><img src="<?=$arResult['DETAIL_PICTURE']['SRC']?>" alt=""></div>
			<?endif;?>
			<?if(!empty($arResult['PROPERTIES']['PICS_NEWS']['VALUE'])):?>
				<?foreach($arResult['PROPERTIES']['PICS_NEWS']['VALUE'] as $DopPict):?>
					<?$src = CFile::GetPath($DopPict);?>
					<div class="item"><img src="<?=$src?>" alt=""></div>
				<?endforeach;?>
			<?endif;?>
		</div>
	<?elseif($slide == 1):?>
		<?if(is_int($oneslid)):?>
			<?$oneslid = CFile::GetPath($oneslid);?>
		<?endif;?>
		<img src="<?=$oneslid?>" style="width: 100%;"/>
	<?endif?>
	</div>
</div>
<div class="date"><?=$arResult['DATE_ACTIVE_FROM']?></div>
<h1 class="title"><?=$arResult['NAME']?></h1>
<?=$arResult['DETAIL_TEXT']?>


