<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
$compositeStub = (isset($arResult['COMPOSITE_STUB']) && $arResult['COMPOSITE_STUB'] == 'Y');
?>
<div class="backet">
	<a href="<?= $arParams['PATH_TO_BASKET'] ?>" class="count-basket"><i class="demo-icon icon-cart"></i>
	<span class="total"><?=intval($arResult['NUM_PRODUCTS'])?></span></a>
</div>