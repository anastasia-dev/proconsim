<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
/** @global CDatabase $DB */
/** @global CMain $APPLICATION */
$frame = $this->createFrame()->begin("");
$templateData = array(
	'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css',
	'TEMPLATE_CLASS' => 'bx_'.$arParams['TEMPLATE_THEME']
);
$injectId = $arParams['UNIQ_COMPONENT_ID'];

if (isset($arResult['REQUEST_ITEMS']))
{
	// code to receive recommendations from the cloud
	CJSCore::Init(array('ajax'));

	// component parameters
	$signer = new \Bitrix\Main\Security\Sign\Signer;
	$signedParameters = $signer->sign(
		base64_encode(serialize($arResult['_ORIGINAL_PARAMS'])),
		'bx.bd.products.recommendation'
	);
	$signedTemplate = $signer->sign($arResult['RCM_TEMPLATE'], 'bx.bd.products.recommendation');

	?>

	<span id="<?=$injectId?>"></span>
	<div></div>
	<script type="text/javascript">
		BX.ready(function(){
			bx_rcm_get_from_cloud(
				'<?=CUtil::JSEscape($injectId)?>',
				<?=CUtil::PhpToJSObject($arResult['RCM_PARAMS'])?>,
				{
					'parameters':'<?=CUtil::JSEscape($signedParameters)?>',
					'template': '<?=CUtil::JSEscape($signedTemplate)?>',
					'site_id': '<?=CUtil::JSEscape(SITE_ID)?>',
					'rcm': 'yes'
				}
			);
		});
	</script>
	<?
	$frame->end();
	return;

	// \ end of the code to receive recommendations from the cloud
}


// regular template then
// if customized template, for better js performance don't forget to frame content with <span id="{$injectId}_items">...</span> 

if (!empty($arResult['ITEMS']))
{
	?>

	<span id="<?=$injectId?>_items">
	<script type="text/javascript">
	BX.message({
		CBD_MESS_BTN_BUY: '<? echo ('' != $arParams['MESS_BTN_BUY'] ? CUtil::JSEscape($arParams['MESS_BTN_BUY']) : GetMessageJS('CVP_TPL_MESS_BTN_BUY')); ?>',
		CBD_MESS_BTN_ADD_TO_BASKET: '<? echo ('' != $arParams['MESS_BTN_ADD_TO_BASKET'] ? CUtil::JSEscape($arParams['MESS_BTN_ADD_TO_BASKET']) : GetMessageJS('CVP_TPL_MESS_BTN_ADD_TO_BASKET')); ?>',
		CBD_MESS_BTN_DETAIL: '<? echo ('' != $arParams['MESS_BTN_DETAIL'] ? CUtil::JSEscape($arParams['MESS_BTN_DETAIL']) : GetMessageJS('CVP_TPL_MESS_BTN_DETAIL')); ?>',
		CBD_MESS_NOT_AVAILABLE: '<? echo ('' != $arParams['MESS_BTN_DETAIL'] ? CUtil::JSEscape($arParams['MESS_BTN_DETAIL']) : GetMessageJS('CVP_TPL_MESS_BTN_DETAIL')); ?>',
		CBD_BTN_MESSAGE_BASKET_REDIRECT: '<? echo GetMessageJS('CVP_CATALOG_BTN_MESSAGE_BASKET_REDIRECT'); ?>',
		CBD_BASKET_URL: '<? echo $arParams["BASKET_URL"]; ?>',
		CBD_ADD_TO_BASKET_OK: '<? echo GetMessageJS('CVP_ADD_TO_BASKET_OK'); ?>',
		CBD_TITLE_ERROR: '<? echo GetMessageJS('CVP_CATALOG_TITLE_ERROR') ?>',
		CBD_TITLE_BASKET_PROPS: '<? echo GetMessageJS('CVP_CATALOG_TITLE_BASKET_PROPS') ?>',
		CBD_TITLE_SUCCESSFUL: '<? echo GetMessageJS('CVP_ADD_TO_BASKET_OK'); ?>',
		CBD_BASKET_UNKNOWN_ERROR: '<? echo GetMessageJS('CVP_CATALOG_BASKET_UNKNOWN_ERROR') ?>',
		CBD_BTN_MESSAGE_SEND_PROPS: '<? echo GetMessageJS('CVP_CATALOG_BTN_MESSAGE_SEND_PROPS'); ?>',
		CBD_BTN_MESSAGE_CLOSE: '<? echo GetMessageJS('CVP_CATALOG_BTN_MESSAGE_CLOSE') ?>'
	});
	</script>
	
	
	<section class="carousel-goods">
		<div class="row">
			<div class="col-md-12">
				<h3><?=GetMessage("CVP_TPL_MESS_RCM")?></h3>
				<div class="owl-carousel2">
					<?foreach($arResult['ITEMS'] as $arItem):?>
					
					<div class="item">
						<div class="item-wrap">
							<div class="rows table-rows">
								<div class="g-img"><a href=""><img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt=""></a></div>
								<?if(empty($arItem['OFFERS'])):?>
									<input type="hidden" id="price-value-999<?=$arItem['ID']?>" value="<?=$arItem['MIN_PRICE']['VALUE']?>">
									<div class="g-price" id="price-product-999<?=$arItem['ID']?>"><?=number_format($arItem['MIN_PRICE']['DISCOUNT_VALUE_VAT'],0,'',' ');?> <span>руб</span></div>
									<div class="g-count">Кол-во
										<div class="wrap-count">
											<button onclick="MinusSelect('999<?=$arItem['ID']?>')">-</button>
											<input type="text" value="1" class="input-sm-999<?=$arItem['ID']?>">
											<button onclick="PlusSelect('999<?=$arItem['ID']?>')">+</button>
										</div>
									</div>
									<div class="g-btn"><button class="btn-bye" onclick="addToBasket('<?echo $arItem['ADD_URL'];?>','<?=$arItem['ID']?>');"><i class="demo-icon icon-cart"></i></button></div>
								<?else:?>
									<input type="hidden" id="price-value-999<?=$arItem['OFFERS'][0]['ID']?>" value="<?=$arItem['OFFERS'][0]['MIN_PRICE']['VALUE']?>">
									<div class="g-price" id="price-product-999<?=$arItem['OFFERS'][0]['ID']?>"><?=number_format($arItem['OFFERS'][0]['MIN_PRICE']['DISCOUNT_VALUE_VAT'],0,'',' ');?> <span>руб</span></div>
									<div class="g-count">Кол-во
										<div class="wrap-count">
											<button onclick="MinusSelect('999<?=$arItem['OFFERS'][0]['ID']?>')">-</button>
											<input type="text" value="1" class="input-sm-999<?=$arItem['OFFERS'][0]['ID']?>">
											<button onclick="PlusSelect('999<?=$arItem['OFFERS'][0]['ID']?>')">+</button>
										</div>
									</div>
									<div class="g-btn"><button class="btn-bye" onclick="addToBasket('<?echo $arItem['OFFERS'][0]['ADD_URL'];?>','<?=$arItem['OFFERS'][0]['ID']?>');"><i class="demo-icon icon-cart"></i></button></div>
								<?endif?>
							</div>
							<div class="rows">		
								<p><?=$arItem['NAME']?></p>	
							</div>
						</div>
					</div>
					<?endforeach;?>
					
					
				</div>
			</div>
		</div>
</section>
	
	
	
	
	
	
	
	
	
	
	</span>
	<script type="text/javascript">
	
	</script>
<?
}

$frame->end();