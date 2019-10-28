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
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?>
<?endif;?>
<div class="goods-wrap">
	<?if($arResult['ITEMS']){?>
	<?foreach($arResult['ITEMS'] as $arItem):?>
	<div class="goods-item">
		<div class="g-img"><a href="<?=$arItem['DETAIL_PAGE_URL']?>"><img id="img-<?=$arItem['ID']?>" src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt=""></a></div>
		<div class="g-desc"><p><a href="<?=$arItem['DETAIL_PAGE_URL']?>"><?=$arItem['NAME']?></a></p></div>
		<?if(empty($arItem['OFFERS'])):?>
			<?if ($arItem['CAN_BUY']):?>
			<input type="hidden" class="price-value-<?=$arItem['ID']?>" value="<?=$arItem['MIN_PRICE']['VALUE']?>">
			<div class="g-price price-product-<?=$arItem['ID']?>">
            <?if($arItem['MIN_PRICE']['VALUE']>0){?>
                <span nowrap><?=number_format($arItem['MIN_PRICE']['VALUE'],2,',',' ');?> р</span>
            <?}else{?> 
                <?echo "<span style=\"font-size:12px;\">".('' != $arParams['MESS_NOT_AVAILABLE'] ? $arParams['MESS_NOT_AVAILABLE'] : GetMessage('CT_BCS_TPL_MESS_PRODUCT_NOT_AVAILABLE'))."</span>";?>
            <?}?> 
            </div>
			<div class="g-count hidden-xs">
				<div class="wrap-count">
					<button onclick="MinusSelect('<?=$arItem['ID']?>')">-</button>
					<input type="text" value="1" class="input-sm-<?=$arItem['ID']?>">
					<button onclick="PlusSelect('<?=$arItem['ID']?>')">+</button>
				</div>
			</div>
			<input type="hidden" class="in-basket-count-value-<?=$arItem['ID']?>" value="<?=intval($arResult['BASKET'][$arItem['ID']])?>">
			<div class="g-btn"><button class="btn-bye b-g-sm-<?=$arItem['ID']?>" onclick="addToBasket('<?echo $arItem['ADD_URL'];?>','<?=$arItem['ID']?>');"><i class="demo-icon icon-cart"></i><?if(intval($arResult['BASKET'][$arItem['ID']]) != 0):?><span class="in-basket-count"><?=intval($arResult['BASKET'][$arItem['ID']])?></span><?endif;?></button></div>
			<?else:?>
			<div class="g-price" ></div>
			<div class="g-count">
				<div class="wrap-count">
					<?echo ('' != $arParams['MESS_NOT_AVAILABLE'] ? $arParams['MESS_NOT_AVAILABLE'] : GetMessage('CT_BCS_TPL_MESS_PRODUCT_NOT_AVAILABLE'));?>
				</div>
			</div>
			<div class="g-btn"><button class="btn-bye not-available" disabled ><i class="demo-icon icon-cart"></i><?if(intval($arResult['BASKET'][$arItem['ID']]) != 0):?><span class="in-basket-count"><?=intval($arResult['BASKET'][$arItem['ID']])?></span><?endif;?></button></div>
			<?endif?>
		<?else:?>
			<?$canbuy = false;?>
			<?$price = 0;?>
			<?$id = 0;?>
			<?$addUrl = "";?>
			<?foreach($arItem['OFFERS'] as $arOffer):?>
				<?if($arOffer['CAN_BUY']):?>
					<?$canbuy = true;?>
					<?$price = $arOffer['MIN_PRICE']['VALUE'];?>
					<?$id = $arOffer['ID'];?>
					<?$addUrl = $arOffer['ADD_URL'];?>
					<?break;?>
				<?endif;?>
			<?endforeach?>
			<?if($canbuy):?>
			<input type="hidden" class="price-value-<?=$id?>" value="<?=$price?>">
			<div class="g-price price-product-<?=$id?>"><?=number_format($price,2,',',' ');?> <span>р</span></div>
			<div class="g-count">
				<div class="wrap-count">
					<button onclick="MinusSelect('<?=$id?>')">-</button>
					<input type="text" value="1" class="input-sm-<?=$id?>">
					<button onclick="PlusSelect('<?=$id?>')">+</button>
				</div>
			</div>
			<input type="hidden" class="in-basket-count-value-<?=$id?>" value="<?=intval($arResult['BASKET'][$arItem['ID']])?>">
			<div class="g-btn"><button class="btn-bye b-g-sm-<?=$id?>" onclick="addToBasket('<?echo $addUrl;?>','<?=$id?>');"><i class="demo-icon icon-cart"></i><?if(intval($arResult['BASKET'][$arItem['ID']]) != 0):?><span class="in-basket-count"><?=intval($arResult['BASKET'][$arItem['ID']])?></span><?endif;?></button></div>
			<?else:?>
			<div class="g-price" ></div>
			<div class="g-count">
				<div class="wrap-count">
					<?echo ('' != $arParams['MESS_NOT_AVAILABLE'] ? $arParams['MESS_NOT_AVAILABLE'] : GetMessage('CT_BCS_TPL_MESS_PRODUCT_NOT_AVAILABLE'));?>
				</div>
			</div>
			<div class="g-btn"><button class="btn-bye not-available" disabled ><i class="demo-icon icon-cart"></i><?if(intval($arResult['BASKET'][$arItem['ID']]) != 0):?><span class="in-basket-count"><?=intval($arResult['BASKET'][$arItem['ID']])?></span><?endif;?></button></div>
			<?endif;?>
		<?endif?>
	</div>
	<?endforeach;?>
	<?}else{?>
	<div>По вашему запросу ничего не найдено. Попробуйте изменить параметры поиска.</div>
	<?}?>
</div>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
<script>

function MinusSelect(id){
	var count = $('.input-sm-'+id).val();
	if(count < 2){
		return false;
	}else{
		var cost = $('.price-value-'+id).val();
		count = count - 1;
		cost = parseInt(cost) * count;
		cost = number_format(cost, 2, ',', ' ');
		$('.input-sm-'+id).val(count);
		/*$('.price-product-'+id).html(cost+" <span>р</span>");*/
	}
}
function PlusSelect(id){
	var count = $('.input-sm-'+id).val();
	if(count > 0){
	count = parseInt(count) + 1;
	
	var cost;
	cost = $('.price-value-'+id).val();
	cost = parseInt(cost) * count;
	cost = number_format(cost, 2, ',', ' ');
	$('.input-sm-'+id).val(count);
	/*$('.price-product-'+id).html(cost+" <span>р</span>");*/
	}
}
</script>