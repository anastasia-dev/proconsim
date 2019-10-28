<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
/** @global CDatabase $DB */

$this->setFrameMode(true);

$templateData = array(
	'TEMPLATE_THEME' => $this->GetFolder() . '/themes/' . $arParams['TEMPLATE_THEME'] . '/style.css',
	'TEMPLATE_CLASS' => 'bx_' . $arParams['TEMPLATE_THEME']
);
CJSCore::Init(array("popup"));
$arSkuTemplate = array();
if (is_array($arResult['SKU_PROPS']))
{
	foreach ($arResult['SKU_PROPS'] as $iblockId => $skuProps)
	{
		$arSkuTemplate[$iblockId] = array();
		foreach ($skuProps as &$arProp)
		{
			ob_start();
			if ('TEXT' == $arProp['SHOW_MODE'])
			{
				if (5 < $arProp['VALUES_COUNT'])
				{
					$strClass = 'bx_item_detail_size full';
					$strWidth = ($arProp['VALUES_COUNT'] * 20) . '%';
					$strOneWidth = (100 / $arProp['VALUES_COUNT']) . '%';
					$strSlideStyle = '';
				}
				else
				{
					$strClass = 'bx_item_detail_size';
					$strWidth = '100%';
					$strOneWidth = '20%';
					$strSlideStyle = 'display: none;';
				}
				?>
			<div class="<? echo $strClass; ?>" id="#ITEM#_prop_<? echo $arProp['ID']; ?>_cont">
				<span class="bx_item_section_name_gray"><? echo htmlspecialcharsex($arProp['NAME']); ?></span>

				<div class="bx_size_scroller_container">
					<div class="bx_size">
						<ul id="#ITEM#_prop_<? echo $arProp['ID']; ?>_list" style="width: <? echo $strWidth; ?>;"><?
							foreach ($arProp['VALUES'] as $arOneValue)
							{
								?>
							<li
								data-treevalue="<? echo $arProp['ID'] . '_' . $arOneValue['ID']; ?>"
								data-onevalue="<? echo $arOneValue['ID']; ?>"
								style="width: <? echo $strOneWidth; ?>;"
								><i></i><span class="cnt"><? echo htmlspecialcharsex($arOneValue['NAME']); ?></span>
								</li><?
							}
							?></ul>
					</div>
					<div class="bx_slide_left" id="#ITEM#_prop_<? echo $arProp['ID']; ?>_left"
						data-treevalue="<? echo $arProp['ID']; ?>" style="<? echo $strSlideStyle; ?>"></div>
					<div class="bx_slide_right" id="#ITEM#_prop_<? echo $arProp['ID']; ?>_right"
						data-treevalue="<? echo $arProp['ID']; ?>" style="<? echo $strSlideStyle; ?>"></div>
				</div>
				</div><?
			}
			elseif ('PICT' == $arProp['SHOW_MODE'])
			{
				if (5 < $arProp['VALUES_COUNT'])
				{
					$strClass = 'bx_item_detail_scu full';
					$strWidth = ($arProp['VALUES_COUNT'] * 20) . '%';
					$strOneWidth = (100 / $arProp['VALUES_COUNT']) . '%';
					$strSlideStyle = '';
				}
				else
				{
					$strClass = 'bx_item_detail_scu';
					$strWidth = '100%';
					$strOneWidth = '20%';
					$strSlideStyle = 'display: none;';
				}
				?>
			<div class="<? echo $strClass; ?>" id="#ITEM#_prop_<? echo $arProp['ID']; ?>_cont">
				<span class="bx_item_section_name_gray"><? echo htmlspecialcharsex($arProp['NAME']); ?></span>

				<div class="bx_scu_scroller_container">
					<div class="bx_scu">
						<ul id="#ITEM#_prop_<? echo $arProp['ID']; ?>_list" style="width: <? echo $strWidth; ?>;"><?
							foreach ($arProp['VALUES'] as $arOneValue)
							{
								?>
							<li
								data-treevalue="<? echo $arProp['ID'] . '_' . $arOneValue['ID'] ?>"
								data-onevalue="<? echo $arOneValue['ID']; ?>"
								style="width: <? echo $strOneWidth; ?>; padding-top: <? echo $strOneWidth; ?>;"
								><i title="<? echo htmlspecialcharsbx($arOneValue['NAME']); ?>"></i>
						<span class="cnt"><span class="cnt_item"
								style="background-image:url('<? echo $arOneValue['PICT']['SRC']; ?>');"
								title="<? echo htmlspecialcharsbx($arOneValue['NAME']); ?>"
								></span></span></li><?
							}
							?></ul>
					</div>
					<div class="bx_slide_left" id="#ITEM#_prop_<? echo $arProp['ID']; ?>_left"
						data-treevalue="<? echo $arProp['ID']; ?>" style="<? echo $strSlideStyle; ?>"></div>
					<div class="bx_slide_right" id="#ITEM#_prop_<? echo $arProp['ID']; ?>_right"
						data-treevalue="<? echo $arProp['ID']; ?>" style="<? echo $strSlideStyle; ?>"></div>
				</div>
				</div><?
			}
			$arSkuTemplate[$iblockId][$arProp['CODE']] = ob_get_contents();
			ob_end_clean();
			unset($arProp);
		}
	}
}

?>
<? if (!empty($arResult['ITEMS'])): ?>
		
	<section class="carousel-goods">
		<div class="row">
			<div class="col-md-12">
				<h3><?=GetMessage("CATALOG_RECOMMENDED_PRODUCTS_HREF_TITLE")?></h3>
				<div class="owl-carousel2">
					<?foreach($arResult['ITEMS'] as $arItem):?>
					
					<div class="item">
						<div class="item-wrap">
							<div class="rows table-rows">
								<div class="g-img"><a href="<?=$arItem['DETAIL_PAGE_URL']?>"><img id="img-<?=$arItem['ID']?>" src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt=""></a></div>
								<?if(empty($arItem['OFFERS'])):?>
									<input type="hidden" class="price-value-<?=$arItem['ID']?>" value="<?=$arItem['MIN_PRICE']['VALUE']?>">
									<div class="g-price price-product-<?=$arItem['ID']?>"><?=number_format($arItem['MIN_PRICE']['DISCOUNT_VALUE'],2,',',' ');?> <span>руб</span></div>
									<div class="g-count">Кол-во
										<div class="wrap-count">
											<button onclick="MinusSelect('<?=$arItem['ID']?>')">-</button>
											<input type="text" value="1" class="input-sm-<?=$arItem['ID']?>">
											<button onclick="PlusSelect('<?=$arItem['ID']?>')">+</button>
										</div>
									</div>
									<div class="g-btn"><button class="btn-bye" onclick="addToBasket('<?echo $arItem['ADD_URL'];?>','<?=$arItem['ID']?>');"><i class="demo-icon icon-cart"></i></button></div>
								<?else:?>
									<input type="hidden" class="price-value-<?=$arItem['OFFERS'][0]['ID']?>" value="<?=$arItem['MIN_PRICE']['VALUE']?>">
									<div class="g-price price-product-<?=$arItem['OFFERS'][0]['ID']?>"><?=number_format($arItem['OFFERS'][0]['MIN_PRICE']['DISCOUNT_VALUE'],2,',',' ');?> <span>руб</span></div>
									<div class="g-count">Кол-во
										<div class="wrap-count">
											<button onclick="MinusSelect('<?=$arItem['OFFERS'][0]['ID']?>')">-</button>
											<input type="text" value="1" class="input-sm-<?=$arItem['OFFERS'][0]['ID']?>">
											<button onclick="PlusSelect('<?=$arItem['OFFERS'][0]['ID']?>')">+</button>
										</div>
									</div>
									<div class="g-btn"><button class="btn-bye" onclick="addToBasket('<?echo $arItem['OFFERS'][0]['ADD_URL'];?>','<?=$arItem['OFFERS'][0]['ID']?>');"><i class="demo-icon icon-cart"></i></button></div>
								<?endif?>
							</div>
							<div class="rows">		
								<a href="<?=$arItem['DETAIL_PAGE_URL']?>"><p><?=$arItem['NAME']?></p></a>	
							</div>
						</div>
					</div>
					<?endforeach;?>
					
					
				</div>
			</div>
		</div>
</section>
	
	
	

	<script type="text/javascript">
		BX.message({
			MESS_BTN_BUY: '<? echo ('' != $arParams['MESS_BTN_BUY'] ? CUtil::JSEscape($arParams['MESS_BTN_BUY']) : GetMessageJS('CATALOG_RECOMMENDED_PRODUCTS_TPL_MESS_BTN_BUY')); ?>',
			MESS_BTN_ADD_TO_BASKET: '<? echo ('' != $arParams['MESS_BTN_ADD_TO_BASKET'] ? CUtil::JSEscape($arParams['MESS_BTN_ADD_TO_BASKET']) : GetMessageJS('CATALOG_RECOMMENDED_PRODUCTS_TPL_MESS_BTN_ADD_TO_BASKET')); ?>',

			MESS_BTN_DETAIL: '<? echo ('' != $arParams['MESS_BTN_DETAIL'] ? CUtil::JSEscape($arParams['MESS_BTN_DETAIL']) : GetMessageJS('CATALOG_RECOMMENDED_PRODUCTS_TPL_MESS_BTN_DETAIL')); ?>',

			MESS_NOT_AVAILABLE: '<? echo ('' != $arParams['MESS_BTN_DETAIL'] ? CUtil::JSEscape($arParams['MESS_BTN_DETAIL']) : GetMessageJS('CATALOG_RECOMMENDED_PRODUCTS_TPL_MESS_BTN_DETAIL')); ?>',
			BTN_MESSAGE_BASKET_REDIRECT: '<? echo GetMessageJS('CATALOG_RECOMMENDED_PRODUCTS_CATALOG_BTN_MESSAGE_BASKET_REDIRECT'); ?>',
			BASKET_URL: '<? echo $arParams["BASKET_URL"]; ?>',
			ADD_TO_BASKET_OK: '<? echo GetMessageJS('CATALOG_RECOMMENDED_PRODUCTS_ADD_TO_BASKET_OK'); ?>',
			TITLE_ERROR: '<? echo GetMessageJS('CATALOG_RECOMMENDED_PRODUCTS_CATALOG_TITLE_ERROR') ?>',
			TITLE_BASKET_PROPS: '<? echo GetMessageJS('CATALOG_RECOMMENDED_PRODUCTS_CATALOG_TITLE_BASKET_PROPS') ?>',
			TITLE_SUCCESSFUL: '<? echo GetMessageJS('CATALOG_RECOMMENDED_PRODUCTS_ADD_TO_BASKET_OK'); ?>',
			BASKET_UNKNOWN_ERROR: '<? echo GetMessageJS('CATALOG_RECOMMENDED_PRODUCTS_CATALOG_BASKET_UNKNOWN_ERROR') ?>',
			BTN_MESSAGE_SEND_PROPS: '<? echo GetMessageJS('CATALOG_RECOMMENDED_PRODUCTS_CATALOG_BTN_MESSAGE_SEND_PROPS'); ?>',
			BTN_MESSAGE_CLOSE: '<? echo GetMessageJS('CATALOG_RECOMMENDED_PRODUCTS_CATALOG_BTN_MESSAGE_CLOSE') ?>'
		});
	</script>
<? endif;?>