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
<?
if (!empty($arResult['ITEMS'])):?>
<div class="price-table">
	<div class="table-content">
		<table>
			<thead>
				<tr>
					<td>
						Артикул
					</td>
					<td>
						Название
					</td>
					<td>
						Торговая марка
					</td>
					<td>
						Страна 
					</td>
					<td>
						Кол-во в уп.
					</td>
					<td colspan="1">
						Цена, руб.
					</td>
				</tr>
			</thead>
			<tbody>
<?foreach($arResult['ITEMS'] as $arItem):?>

	<tr>
		<td><?=$arItem['PROPERTIES']['ARTNUMBER']['VALUE']?></td>
		<td><?=$arItem['NAME']?></td>
		<td><?=$arItem['DISPLAY_PROPERTIES']['BRAND']['LINK_ELEMENT_VALUE'][$arItem['PROPERTIES']['BRAND']['VALUE']]['NAME']?></td>
		<td><?=$arItem['PROPERTIES']['COUNTRY']['VALUE']?></td>
		<td><?echo intval($arItem['PROPERTIES']['KOL_VO_UPAC']['VALUE']) ? intval($arItem['PROPERTIES']['KOL_VO_UPAC']['VALUE']) : 1;?></td>
		<?if(empty($arItem['OFFERS'])):?>
			<?if ($arItem['CAN_BUY']):?>
			<td>
				<input type="hidden" class="price-value-<?=$arItem['ID']?>" value="<?=$arItem['MIN_PRICE']['VALUE']?>">
				<div class="price-product-<?=$arItem['ID']?>"><?=number_format($arItem['MIN_PRICE']['VALUE'],0,'',' ');?> <span>руб</span></div>
			</td>
			<td class="price">
				<div class="wrap-count">
					<button onclick="MinusSelect('<?=$arItem['ID']?>')">-</button>
					<input type="text" value="1" class="input-sm-<?=$arItem['ID']?>">
					<button onclick="PlusSelect('<?=$arItem['ID']?>')">+</button>
				</div>
			</td>
			<td class="price">
			<input type="hidden" class="in-basket-count-value-<?=$arItem['ID']?>" value="<?=intval($arResult['BASKET'][$arItem['ID']])?>">
				<div class=""><button class="btn-bye b-g-sm-<?=$arItem['ID']?>" onclick="addToBasket('<?echo $arItem['ADD_URL'];?>','<?=$arItem['ID']?>');"><i class="demo-icon icon-cart"></i><?if(intval($arResult['BASKET'][$arItem['ID']]) != 0):?><span class="in-basket-count"><?=intval($arResult['BASKET'][$arItem['ID']])?></span><?endif;?></button></div>
			</td>
			<?else:?>
			<td></td>
			<td class="price">
				<div class="wrap-count">
					<?echo ('' != $arParams['MESS_NOT_AVAILABLE'] ? $arParams['MESS_NOT_AVAILABLE'] : GetMessage('CT_BCS_TPL_MESS_PRODUCT_NOT_AVAILABLE'));?>
				</div>
			</td>
			<td class="price">
				<div class=""><button class="btn-bye not-available" disabled ><i class="demo-icon icon-cart"></i></button></div>
			</td>
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
			<td>
				<input type="hidden" class="price-value-<?=$id?>" value="<?=$price?>">
				<div class="price-product-<?=$id?>"><?=number_format($price,0,'',' ');?> <span>руб</span></div>
			</td>
			<td class="price">
				<div class="wrap-count">
					<button onclick="MinusSelect('<?=$id?>')">-</button>
					<input type="text" value="1" class="input-sm-<?=$id?>">
					<button onclick="PlusSelect('<?=$id?>')">+</button>
				</div>
			</td>
			<td class="price">
			<input type="hidden" class="in-basket-count-value-<?=$id?>" value="<?=intval($arResult['BASKET'][$arItem['ID']])?>">
				<div class=""><button class="btn-bye b-g-sm-<?=$id?>" onclick="addToBasket('<?echo $addUrl;?>','<?=$id?>');"><i class="demo-icon icon-cart"></i><?if(intval($arResult['BASKET'][$arItem['ID']]) != 0):?><span class="in-basket-count"><?=intval($arResult['BASKET'][$arItem['ID']])?></span><?endif;?></button></div>
			</td>
			<?else:?>
			<td></td>
			<td class="price">
				<div class="wrap-count">
					<?echo ('' != $arParams['MESS_NOT_AVAILABLE'] ? $arParams['MESS_NOT_AVAILABLE'] : GetMessage('CT_BCS_TPL_MESS_PRODUCT_NOT_AVAILABLE'));?>
				</div>
			</td>
			<td class="price">
				<div class=""><button class="btn-bye not-available" disabled ><i class="demo-icon icon-cart"></i></button></div>
			</td>
			<?endif;?>
		<?endif?>
							
	</tr>
<?endforeach;?>
			</tbody>
		</table>
	</div>
</div>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
<?endif;?>
<script>function MinusSelect(id){
	var count = $('.input-sm-'+id).val();
	if(count < 2){
		return false;
	}else{
		var cost = $('.price-value-'+id).val();
		count = count - 1;
		cost = parseInt(cost) * count;
		cost = number_format(cost, 2, ',', ' ');
		$('.input-sm-'+id).val(count);
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
	}
}
</script>