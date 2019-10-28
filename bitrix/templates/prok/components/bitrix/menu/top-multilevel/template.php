<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<nav>
<ul>
<?
$previousLevel = 0;
$num = 0;
	foreach($arResult as $arItem):
		if($arItem['DEPTH_LEVEL'] == 1):?>
		<li <?if($arItem['SELECTED']):?>class="active"<?endif?>
		 <?if($arItem['IS_PARENT']):?>
			data-target="<?=$num?>"
			<?$num++?>
		 <?endif?>
		><a href="<?=$arItem['LINK']?>"><?=$arItem['TEXT']?></a></li>
		<?endif?>
	<?endforeach;?>
</ul>
</nav>
<?$first = true;?>
<?$num = 0;?>
<?foreach($arResult as $arItem):
	if($arItem['DEPTH_LEVEL'] == 2):?>
		<?if($first):?>
			<?$first=false;?>
			<div class="wrap-submenu second-level second-level-<?=$num?>">
				<div class="col-md-7 col-md-offset-5 sub-menu">
					<ul>
					<?$num++;?>
		<?endif?>
		<li><a href="<?=$arItem['LINK']?>"><?=$arItem['TEXT']?></a></li>	
	<?elseif($arItem['DEPTH_LEVEL'] == 1 and !$first):?>
		<?$first = true;?>
				</ul>
			</div>
		</div>
	<?endif;
endforeach;?>
<?$first = true;?>
<?foreach($arResult as $arItem):
	if($arItem['DEPTH_LEVEL'] == 3):?>
		<?if($first):?>
		<?$first=false;?>
			<div class="wrap-submenu third-level">
				<div class="col-md-7 col-md-offset-5 sub-menu">
					<ul>
		<?endif;?>
		<li><a href="<?=$arItem['LINK']?>"><?=$arItem['TEXT']?></a></li>
	<?elseif($arItem['DEPTH_LEVEL'] == 1 or $arItem['DEPTH_LEVEL'] == 2 and !$first):?>
		<?$first = true;?>
				</ul>
			</div>
		</div>
	<?endif;?>
<?endforeach?>
<?endif?>