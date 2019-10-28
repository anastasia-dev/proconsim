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
//if ($USER->IsAdmin()){
//echo "<pre>";
//print_r($arResult['ITEMS']);
//echo "<pre>";
//}
?>

<div class="row plits-catalog izb">
    <?$num = 0;?>
    <?foreach($arResult['ITEMS'] as $arItem):?>
        <?if($num%3==0 and $num!=0):?>
            <!--</div><div class="row plits-catalog">-->
        <?endif;?>
        <?$num++;?>

        <div class="col-sm-3 col-xs-6">
            <div class="product-card">
                <div class="top-info-panel">
                    <div class="product-prop-icon">
                        <?if($arItem['PROPERTIES']['SPECIALOFFER']['VALUE'] == "да"):?>
                            <div class="sale-on-catalog">%</div>
                        <?endif;?>
                        <?//if($arItem['PROPERTIES']['NEWPRODUCT']['VALUE'] == "да"):
                        //if($arItem['NOVELTY']):
                        if($arItem['NOVELTY'] || $arItem['PROPERTIES']['NEWPRODUCT']['VALUE'] == "да"):?>
                            <div class="new-on-catalog">NEW</div>
                        <?endif;?>
                        <?if($arItem['PROPERTIES']['SALELEADER']['VALUE'] == "да"):?>
                            <div class="hit-on-catalog">ХИТ</div>
                        <?endif;?>
                        <?if($arItem['STOCK']):?>
                            <div><img src="<?=SITE_TEMPLATE_PATH?>/img/icon/action.png" width="44" height="16" /></div>
                        <?endif;?>
                    </div>
                    <?
                    if($arItem['PREVIEW_PICTURE']['ID']){
                        $file = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE']['ID'], array('width'=>150, 'height'=>150), BX_RESIZE_IMAGE_PROPORTIONAL, true, array());
                        //if ($USER->IsAdmin()){
                        //echo "<pre>";
                        //print_r($file);
                        //echo "</pre>";
                        //}
                    }else{
                        $file["src"] = $arItem['PREVIEW_PICTURE']['SRC'];
                    }
                    ?>
                    <a href="<?=$arItem['DETAIL_PAGE_URL']?>"><img id="img-<?=$arItem['ID']?>" src="<?=$file["src"]?>" alt="<?=$arItem['NAME']?>"></a>
                    <?if(intval($arItem['PROPERTIES']['BRAND']['VALUE']) != 0):?>
                        <div class="brand-image-card"><img src="<?=$arResult['BRANDS_LIST'][$arItem['PROPERTIES']['BRAND']['VALUE']]?>" /></div>
                    <?endif?>
                </div>
                <?if(empty($arItem['OFFERS'])):?>
                    <div class="article">
                        Арт. <?=$arItem['PROPERTIES']['ARTNUMBER']['VALUE']?>
                    </div>
                <?endif?>
                <div class="middle-info-panel"><a href="<?=$arItem['DETAIL_PAGE_URL']?>"><?=$arItem['~NAME']?></a></div>
                <div class="bottom-info-panel">

                    <?if(empty($arItem['OFFERS'])):?>
                        <?if ($arItem['CAN_BUY']):?>
                            <input type="hidden" class="price-value-<?=$arItem['ID']?>" id="price-value-<?=$arItem['ID']?>" value="<?=$arItem['MIN_PRICE']['VALUE']?>">

                            <?if($arItem['MIN_PRICE']['VALUE']>0){?>
                                <div class="price-on-table">
                                    <div class="price-product-<?=$arItem['ID']?>" id="price-product-<?=$arItem['ID']?>"><?=number_format($arItem['MIN_PRICE']['VALUE'],2,',',' ');?> <span>р</span></div>
                                </div>
                            <?}else{?>
                                <!--<div class="price-on-table-empty">-->
                                <div class="price-on-table">
                                    <?echo ('' != $arParams['MESS_NOT_AVAILABLE'] ? $arParams['MESS_NOT_AVAILABLE'] : GetMessage('CT_BCS_TPL_MESS_PRODUCT_NOT_AVAILABLE'));?>
                                </div>
                            <?}?>
                            <div class="row">
                                <div class="col-sm-6 col-xs-12">
                                    <div class="large-wrap-count">
                                        <button onclick="MinusSelect('<?=$arItem['ID']?>')">-</button>
                                        <input type="text" value="1" class="input-sm-<?=$arItem['ID']?>">
                                        <button onclick="PlusSelect('<?=$arItem['ID']?>')">+</button>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <input type="hidden" class="in-basket-count-value-<?=$arItem['ID']?>" value="<?=intval($arResult['BASKET'][$arItem['ID']])?>">
                                    <button class="btn-bye-large b-g-s-<?=$arItem['ID']?>" onclick="addToBasket('<?echo $arItem['ADD_URL'];?>','<?=$arItem['ID']?>');">КУПИТЬ<?if(intval($arResult['BASKET'][$arItem['ID']]) != 0):?><span class="in-basket-count"><?=intval($arResult['BASKET'][$arItem['ID']])?></span><?endif;?></button>
                                </div>
                            </div>

                        <?else:?>
                            <div class="row">
                                <div class="article">
                                    Арт. <?=$arItem['PROPERTIES']['ARTNUMBER']['VALUE']?>
                                </div>
                                <div class="col-xs-12">
                                    <div class="price-on-table-empty">
                                        <?echo ('' != $arParams['MESS_NOT_AVAILABLE'] ? $arParams['MESS_NOT_AVAILABLE'] : GetMessage('CT_BCS_TPL_MESS_PRODUCT_NOT_AVAILABLE'));?>
                                    </div>
                                </div>
                            </div>
                        <?endif?>
                    <?else:?>
                        <?$canbuy = false;?>
                        <?$price = 0;?>
                        <?$id = 0;?>
                        <?$addUrl = "";?>
                        <?foreach($arItem['OFFERS'] as $arOffer):?>
                            <?if($arOffer['CAN_BUY']):?>
                                <?$canbuy = true;?>
                                <?$art = $arOffer['PROPERTIES']['ARTNUMBER']['~VALUE'];?>
                                <?$price = $arOffer['MIN_PRICE']['VALUE'];?>
                                <?$id = $arOffer['ID'];?>
                                <?$addUrl = $arOffer['ADD_URL'];?>
                                <?break;?>
                            <?endif;?>
                        <?endforeach?>
                        <?if($canbuy):?>
                            <input type="hidden" class="price-value-<?=$id?>" id="price-value-<?=$id?>" value="<?=$price?>">
                            <div class="row">
                                <div class="article">
                                    Арт. <?=$art?>
                                </div>
                                <div class="col-xs-7">
                                    <div class="price-on-table">
                                        <div class=" price-product-<?=$id?>" id="price-product-<?=$id?>"><?=number_format($price,2,',',' ');?> <span>р</span></div>
                                    </div>
                                </div>
                                <div class="col-xs-5">
                                    <div class="large-wrap-count">
                                        <button onclick="MinusSelect('<?=$id?>')">-</button>
                                        <input type="text" value="1" class="input-sm-<?=$arItem['ID']?>">
                                        <button onclick="PlusSelect('<?=$id?>')">+</button>
                                    </div>
                                    <input type="hidden" class="in-basket-count-value-<?=$id?>" value="<?=intval($arResult['BASKET'][$arItem['ID']])?>">
                                    <button class="btn-bye-large b-g-s-<?=$id?>" onclick="addToBasket('<?echo $addUrl;?>','<?=$id;?>');">КУПИТЬ<?if(intval($arResult['BASKET'][$arItem['ID']]) != 0):?><span class="in-basket-count"><?=intval($arResult['BASKET'][$arItem['ID']])?></span><?endif;?></button>
                                </div>
                            </div>

                        <?else:?>
                            <div class="row">
                                <div class="article">
                                    Арт. <?=$art?>
                                </div>
                                <div class="col-xs-12">
                                    <div class="price-on-table">
                                        <?echo ('' != $arParams['MESS_NOT_AVAILABLE'] ? $arParams['MESS_NOT_AVAILABLE'] : GetMessage('CT_BCS_TPL_MESS_PRODUCT_NOT_AVAILABLE'));?>
                                    </div>
                                </div>
                            </div>
                        <?endif;?>
                    <?endif?>



                </div>
            </div>
        </div>
    <?endforeach;?>
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