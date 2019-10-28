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
$templateLibrary = array('popup');
$currencyList = '';
if (!empty($arResult['CURRENCIES']))
{
	$templateLibrary[] = 'currency';
	$currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}
$templateData = array(
	'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css',
	'TEMPLATE_CLASS' => 'bx_'.$arParams['TEMPLATE_THEME'],
	'TEMPLATE_LIBRARY' => $templateLibrary,
	'CURRENCIES' => $currencyList
);
GLOBAL $CITY;
unset($currencyList, $templateLibrary);

//echo "<pre>";
//print_r($arResult);
//echo "</pre>";


$strMainID = $this->GetEditAreaId($arResult['ID']);
$arItemIDs = array(
	'ID' => $strMainID,
	'PICT' => $strMainID.'_pict',
	'DISCOUNT_PICT_ID' => $strMainID.'_dsc_pict',
	'STICKER_ID' => $strMainID.'_sticker',
	'BIG_SLIDER_ID' => $strMainID.'_big_slider',
	'BIG_IMG_CONT_ID' => $strMainID.'_bigimg_cont',
	'SLIDER_CONT_ID' => $strMainID.'_slider_cont',
	'SLIDER_LIST' => $strMainID.'_slider_list',
	'SLIDER_LEFT' => $strMainID.'_slider_left',
	'SLIDER_RIGHT' => $strMainID.'_slider_right',
	'OLD_PRICE' => $strMainID.'_old_price',
	'PRICE' => $strMainID.'_price',
	'DISCOUNT_PRICE' => $strMainID.'_price_discount',
	'SLIDER_CONT_OF_ID' => $strMainID.'_slider_cont_',
	'SLIDER_LIST_OF_ID' => $strMainID.'_slider_list_',
	'SLIDER_LEFT_OF_ID' => $strMainID.'_slider_left_',
	'SLIDER_RIGHT_OF_ID' => $strMainID.'_slider_right_',
	'QUANTITY' => $strMainID.'_quantity',
	'QUANTITY_DOWN' => $strMainID.'_quant_down',
	'QUANTITY_UP' => $strMainID.'_quant_up',
	'QUANTITY_MEASURE' => $strMainID.'_quant_measure',
	'QUANTITY_LIMIT' => $strMainID.'_quant_limit',
	'BASIS_PRICE' => $strMainID.'_basis_price',
	'BUY_LINK' => $strMainID.'_buy_link',
	'ADD_BASKET_LINK' => $strMainID.'_add_basket_link',
	'BASKET_ACTIONS' => $strMainID.'_basket_actions',
	'NOT_AVAILABLE_MESS' => $strMainID.'_not_avail',
	'COMPARE_LINK' => $strMainID.'_compare_link',
	'PROP' => $strMainID.'_prop_',
	'PROP_DIV' => $strMainID.'_skudiv',
	'DISPLAY_PROP_DIV' => $strMainID.'_sku_prop',
	'OFFER_GROUP' => $strMainID.'_set_group_',
	'BASKET_PROP_DIV' => $strMainID.'_basket_prop',
	'SUBSCRIBE_LINK' => $strMainID.'_subscribe',
);
$strObName = 'ob'.preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);
$templateData['JS_OBJ'] = $strObName;

$strTitle = (
	isset($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]) && $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"] != ''
	? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]
	: $arResult['NAME']
);
$strAlt = (
	isset($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]) && $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"] != ''
	? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]
	: $arResult['NAME']
);
?>
								


<div class="bx_item_detail row <? echo $templateData['TEMPLATE_CLASS']; ?>" id="<? echo $arItemIDs['ID']; ?>">
<?
reset($arResult['MORE_PHOTO']);
$arFirstPhoto = current($arResult['MORE_PHOTO']);
?>
	<div class="bx_item_container">
<div class="bx_item_slider col-md-5" id="<? echo $arItemIDs['BIG_SLIDER_ID']; ?>">
	<div class="bx_bigimages" id="<? echo $arItemIDs['BIG_IMG_CONT_ID']; ?>">
<img style="display: none;" id="<? echo $arItemIDs['PICT']; ?>" src="<? echo $arFirstPhoto['SRC']; ?>" alt="<? echo $strAlt; ?>" title="<? echo $strTitle; ?>">

	<div class="bx_stick average left top" <?= (empty($arResult['LABEL'])? 'style="display:none;"' : '' ) ?> id="<? echo $arItemIDs['STICKER_ID'] ?>" title="<? echo $arResult['LABEL_VALUE']; ?>"><? echo $arResult['LABEL_VALUE']; ?></div>

	</div>
<?
if ($arResult['SHOW_SLIDER'])
{
	if (!isset($arResult['OFFERS']) || empty($arResult['OFFERS']))
	{
		if (4 < $arResult['MORE_PHOTO_COUNT'])
		{
			$strClass = 'bx_slider_conteiner full';
			$strOneWidth = (100/$arResult['MORE_PHOTO_COUNT']).'%';
			$strWidth = (20*$arResult['MORE_PHOTO_COUNT']).'%';
			$strSlideStyle = '';
		}
		else
		{
			$strClass = 'bx_slider_conteiner';
			$strOneWidth = '20%';
			$strWidth = '100%';
			$strSlideStyle = 'display: none;';
		}
?>
	<div class="<? echo $strClass; ?>" id="<? echo $arItemIDs['SLIDER_CONT_ID']; ?>">
	<div class="bx_slider_scroller_container">
	<div class="bx_slide ">
	
	
	
	
	<div class="img-slider" style="width: <? echo $strWidth; ?>;" id="<? echo $arItemIDs['SLIDER_LIST']; ?>">
	<div class="slider-for popup-gallery">
	<?
	foreach ($arResult['MORE_PHOTO'] as $arOnePhoto)
	{?>
		<div data-value="<? echo $arOnePhoto['ID']; ?>" style="width: <? echo $strOneWidth; ?>;" >
<a href="<? echo $arOnePhoto['SRC']; ?>"><img id="img-<?=$arOnePhoto['ID']?>"  alt="<?=$arResult["NAME"]?>" src="<? echo $arOnePhoto['SRC']; ?>"></a></div>
<?	}
?>	</div>
	<div class="slider-nav">
	<?
	foreach ($arResult['MORE_PHOTO'] as $arOnePhoto)
	{
?>		<div data-value="<? echo $arOnePhoto['ID']; ?>" 
style="width: <? echo $strOneWidth; ?>;" ><img src="<? echo $arOnePhoto['SRC']; ?>"  alt="<?=$arResult["NAME"]?>"></div>
<?	}
	unset($arOnePhoto);?>
	</div>
	</div>
	</div>
	<div class="bx_slide_left" id="<? echo $arItemIDs['SLIDER_LEFT']; ?>" style="<? echo $strSlideStyle; ?>"></div>
	<div class="bx_slide_right" id="<? echo $arItemIDs['SLIDER_RIGHT']; ?>" style="<? echo $strSlideStyle; ?>"></div>
	</div>
	</div>
<?
	}
	else
	{
		foreach ($arResult['OFFERS'] as $key => $arOneOffer)
		{
			if (!isset($arOneOffer['MORE_PHOTO_COUNT']) || 0 >= $arOneOffer['MORE_PHOTO_COUNT'])
				continue;
			$strVisible = ($key == $arResult['OFFERS_SELECTED'] ? '' : 'none');
			if (5 < $arOneOffer['MORE_PHOTO_COUNT'])
			{
				$strClass = 'bx_slider_conteiner full';
				$strOneWidth = (100/$arOneOffer['MORE_PHOTO_COUNT']).'%';
				$strWidth = (25*$arOneOffer['MORE_PHOTO_COUNT']).'%';
				$strSlideStyle = '';
			}
			else
			{
				$strClass = 'bx_slider_conteiner';
				$strOneWidth = '25%';
				$strWidth = '100%';
				$strSlideStyle = 'display: none;';
			}
?>
	<div class="<? echo $strClass; ?>" id="<? echo $arItemIDs['SLIDER_CONT_OF_ID'].$arOneOffer['ID']; ?>" style="display: <? echo $strVisible; ?>;">
	<div class="bx_slider_scroller_container">
	<div class="bx_slide">
	<div class="img-slider" style="width: <? echo $strWidth; ?>;" 
id="<? echo $arItemIDs['SLIDER_LIST_OF_ID'].$arOneOffer['ID']; ?>">
	<div class="slider-for popup-gallery">
	<?
	foreach ($arResult['MORE_PHOTO'] as $arOnePhoto)
	{?>
		<div  data-value="<? echo $arOneOffer['ID'].'_'.$arOnePhoto['ID']; ?>" 
style="width: <? echo $strOneWidth; ?>;" >
<a href="<? echo $arOnePhoto['SRC']; ?>"><img src="<? echo $arOnePhoto['SRC']; ?>" alt="<?=$arResult["NAME"]?>"></a></div>
<?	}
?>	</div>
	<div class="slider-nav">
	<?
	foreach ($arResult['MORE_PHOTO'] as $arOnePhoto)
	{
?>		<div  data-value="<? echo $arOneOffer['ID'].'_'.$arOnePhoto['ID']; ?>" 
style="width: <? echo $strOneWidth; ?>;" ><img src="<? echo $arOnePhoto['SRC']; ?>" alt="<?=$arResult["NAME"]?>"></div>
<?	}
	unset($arOnePhoto);?>
	</div>
	</div>
	</div>
	<div class="bx_slide_left" id="<? echo $arItemIDs['SLIDER_LEFT_OF_ID'].$arOneOffer['ID'] ?>" 
style="<? echo $strSlideStyle; ?>" data-value="<? echo $arOneOffer['ID']; ?>"></div>
	<div class="bx_slide_right" id="<? echo $arItemIDs['SLIDER_RIGHT_OF_ID'].$arOneOffer['ID'] ?>" 
style="<? echo $strSlideStyle; ?>" data-value="<? echo $arOneOffer['ID']; ?>"></div>
	</div>
	</div>
<?
		}
	}
}
?>
</div>
<input type="hidden" class="in-basket-count-value-<?=$arResult['ID']?>" value="<?=intval($arResult['BASKET'][$arResult['ID']])?>">
<div class="bx_rt col-md-7">
<div class="title">
	<h1><?=$arResult['NAME']?></h1>	
	<?/*<div class="secr-title"><img src="img/ico-diametr.png" alt=""> 100 | 125 | 150  |  Все</div>*/?>
</div>
<?/*<pre><?print_r($arResult['OFFERS'])?></pre>*/?>
	
	<?if(empty($arResult['OFFERS'])):?>
	<div class="not-table-prop">
		<div class="item_info_section">
		<div> Арт. <?=$arResult['PROPERTIES']['ARTNUMBER']['VALUE']?></div>
		<?$minPrice = $arResult['MIN_PRICE'];?>
		<div class="buy-panel">
        
			<input type="hidden" id="price-value-<?=$arResult['ID']?>" class="price-value-<?=$arResult['ID']?>" value="<?=$minPrice['VALUE']?>">
			<div style="float:left;">
            <?if($minPrice['VALUE']>0):?>
                <strong class="price-product-<?=$arResult['ID']?>" id="price-product-<?=$arResult['ID']?>"><?=number_format($minPrice['VALUE'],2,',',' ');?> <span>руб</span></strong>
            <?else:?>
                <?echo "<strong style=\"font-size:20px;\">".('' != $arParams['MESS_NOT_AVAILABLE'] ? $arParams['MESS_NOT_AVAILABLE'] : GetMessage('CT_BCS_TPL_MESS_PRODUCT_NOT_AVAILABLE'))."</strong>";?>    
            <?endif;?>
            </div>
			
			<div style="float:right; display: initial;"><div class="g-count">
				<small>кол-во</small>
				<div class="wrap-count">
					<button onclick="MinusSelect('<?=$arResult['ID']?>')">-</button>
					<input type="text" value="1" class="input-sm-<?=$arResult['ID']?>">
					<button onclick="PlusSelect('<?=$arResult['ID']?>')">+</button>
				</div>
			</div>
			<div style="display:initial;"><button class="btn-bye b-g-sm-<?=$arResult['ID']?>" onclick="addToBasket('<?echo $arResult['ADD_URL'];?>','<?=$arResult['ID']?>');" ><i class="demo-icon icon-cart"></i><?if(intval($arResult['BASKET'][$arResult['ID']]) != 0):?><span class="in-basket-count"><?=intval($arResult['BASKET'][$arResult['ID']])?></span><?endif;?></button></div>
			</div>
		</div>
		
		<? 									
			if (!empty($arResult['DISPLAY_PROPERTIES']) || $arResult['SHOW_OFFERS_PROPS'])
			{
			?>
			<div class="item_info_section decsription">
			<?
				if (!empty($arResult['DISPLAY_PROPERTIES']))
				{
			?>
				<table>
			<?
					foreach ($arResult['DISPLAY_PROPERTIES'] as &$arOneProp)
					{
						if($arOneProp['NAME'] != "Артикул"):
						?><tr>
							<td><? echo $arOneProp['NAME']; ?></td><td><?
						echo (
							is_array($arOneProp['DISPLAY_VALUE'])
							? implode(' / ', $arOneProp['DISPLAY_VALUE'])
							: $arOneProp['DISPLAY_VALUE']
						); ?></td></tr><?
						else:
							$article = is_array($arOneProp['DISPLAY_VALUE']) ? implode(' / ', $arOneProp['DISPLAY_VALUE']) : $arOneProp['DISPLAY_VALUE'];
						endif;
					}
					unset($arOneProp);
					foreach($arResult['PROPERTIES']['NALICHIE']['VALUE'] as $key_nal => $val_nal):
						if(intval($val_nal) == $CITY):
							$arResult['CATALOG_QUANTITY'] = $arResult['PROPERTIES']['NALICHIE']['DESCRIPTION'][$key_nal];
						endif;
					endforeach;
					if($arResult['PROPERTIES']['NALICHIE_ALL']>0):
					//if($arResult['PROPERTIES']['NALICHIE_ALL']['VALUE']>0):
					//if($arResult['CATALOG_QUANTITY']>0):
					?><tr>
							<td>Наличие</td><td style="color:green;">в наличии</td></tr><?
					else:
					?><tr>
							<td>Наличие</td><td style="color:red;">под заказ <?=$arResult['CATALOG_QUANTITY'];?></td></tr><?
					endif;
			?>
                <?if($arResult['STOCK']){?>
                <tr><td>Акция</td><td>
                <?foreach ($arResult['STOCK'] as $stock){?>
                <div><a href="<?=$stock["DETAIL_PAGE_URL"]?>"><?=$stock["NAME"]?></a></div>
                <?}?>
                </td></tr>
                <?}?>
                
                <?if($arResult['NOVELTY']){?>
                <tr><td>Новинки</td><td>
                <?foreach ($arResult['NOVELTY'] as $novelty){?>
                <div><a href="<?=$novelty["DETAIL_PAGE_URL"]?>"><?=$novelty["NAME"]?></a></div>
                <?}?>
                </td></tr>
                <?}?>
				</table>
			<?
				}
			?>
			</div>
			<?
			}
			?>
		</div>
	</div>
	<?else:?>
	<div class="not-table-prop">
		<?foreach($arResult['OFFERS'] as $key => $arOffer):?>
		<div class="item_info_section">
		<div> Арт. <?=$arOffer['PROPERTIES']['ARTNUMBER']['VALUE']?></div>
		
		<?$minPrice = $arOffer['MIN_PRICE'];?>
		<div class="buy-panel">
			<input type="hidden" id="price-value-<?=$arOffer['ID']?>" class="price-value-<?=$arOffer['ID']?>" value="<?=$minPrice['VALUE']?>">
			<div style="float:left;"><strong class="price-product-<?=$arOffer['ID']?>" id="price-product-<?=$arOffer['ID']?>"><?=number_format($minPrice['VALUE'],2,',',' ');?> <span>руб</span></strong></div>
			
			<div style="float:right; display: initial;"><div class="g-count">
				<small>кол-во</small>
				<div class="wrap-count">
					<button onclick="MinusSelect('<?=$arOffer['ID']?>')">-</button>
					<input type="text" value="1" class="input-sm-<?=$arOffer['ID']?>">
					<button onclick="PlusSelect('<?=$arOffer['ID']?>')">+</button>
				</div>
			</div>
			<div style="display:initial;"><button class="btn-bye b-g-sm-<?=$arOffer['ID']?>" onclick="addToBasket('<?echo $arOffer['ADD_URL'];?>','<?=$arOffer['ID']?>');" ><i class="demo-icon icon-cart"></i><?if(intval($arResult['BASKET'][$arOffer['ID']]) != 0):?><span class="in-basket-count"><?=intval($arResult['BASKET'][$arOffer['ID']])?></span><?endif;?></button></div>
			</div>
		</div>
		
		<?											
			if (!empty($arResult['DISPLAY_PROPERTIES']) || $arResult['SHOW_OFFERS_PROPS'])
			{
			 
             
			?>
			<div class="item_info_section decsription">
			<?
				if (!empty($arResult['DISPLAY_PROPERTIES']))
				{
			?>
				<table>
			<?
					foreach ($arResult['DISPLAY_PROPERTIES'] as &$arOneProp)
					{
						if($arOneProp['NAME'] != "Артикул"):
						?><tr>
							<td><? echo $arOneProp['NAME']; ?></td><td><?
						echo (
							is_array($arOneProp['DISPLAY_VALUE'])
							? implode(' / ', $arOneProp['DISPLAY_VALUE'])
							: $arOneProp['DISPLAY_VALUE']
						); ?></td></tr><?
						else:
							$article = is_array($arOneProp['DISPLAY_VALUE']) ? implode(' / ', $arOneProp['DISPLAY_VALUE']) : $arOneProp['DISPLAY_VALUE'];
						endif;
					}
					unset($arOneProp);
					if($arResult['PROPERTIES']["NALICHIE_ALL"]['VALUE'] >0):
					?><tr>
							<td>Наличие</td><td style="color:green;">в наличии</td></tr><?
					else:
					?><tr>
							<td>Наличие</td><td style="color:red;">под заказ</td></tr><?
					endif;
			?>
				</table>
			<?
				}
			?>
			</div>
			<?
			}
			?>
		</div>
		<?endforeach;?>
	</div>


	<div class="option-block last-block">
		<div>
			<div>Артикул</div>
			<div>O</div>
			<div>Цена </div>
			<div>Кол-во</div>
			<div></div>
		</div>
		<?if(!empty($arResult['OFFERS'])):?>
		<?foreach($arResult['OFFERS'] as $arOffer):?>
		<?$minPrice = $arOffer['MIN_PRICE'];?>
		<div>
			<div><?=$arOffer['PROPERTIES']['ARTNUMBER']['VALUE']?></div>
			<div><?=$arOffer['PROPERTIES']['DIAMETR']['VALUE']?></div>
			<?if($arOffer['CAN_BUY']):?>
			<input type="hidden" id="price-value-<?=$arOffer['ID']?>" class="price-value-<?=$arOffer['ID']?>" value="<?=$minPrice['VALUE']?>">
			<div><strong id="price-product-<?=$arOffer['ID']?>" class="price-product-<?=$arOffer['ID']?>"><?=number_format($minPrice['VALUE'],2,',',' ');?> <span>руб</span></strong></div>
			<div class="g-count">
					<div class="wrap-count">
						<button onclick="MinusSelect('<?=$arOffer['ID']?>')">-</button>
						<input type="text" value="1" class="input-sm-<?=$arOffer['ID']?>">
						<button onclick="PlusSelect('<?=$arOffer['ID']?>')">+</button>
					</div>
			</div>
			<div><button class="btn-bye b-g-sm-<?=$arOffer['ID']?>" onclick="addToBasket('<?echo $arOffer['ADD_URL'];?>','<?=$arOffer['ID']?>');" ><i class="demo-icon icon-cart"></i><?if(intval($arResult['BASKET'][$arOffer['ID']]) != 0):?><span class="in-basket-count"><?=intval($arResult['BASKET'][$arOffer['ID']])?></span><?endif;?></button></div>
			<?else:?>
			<input type="hidden">
			<div class="g-price" ></div>
			<div class="g-count">
				<div class="wrap-count">
					<?echo ('' != $arParams['MESS_NOT_AVAILABLE'] ? $arParams['MESS_NOT_AVAILABLE'] : GetMessage('CT_BCS_TPL_MESS_PRODUCT_NOT_AVAILABLE'));?>
				</div>
			</div>
			<div class="g-btn"><button class="btn-bye not-available" disabled ><i class="demo-icon icon-cart"></i></button></div>
			
			<?endif;?>
		</div>
		<?endforeach;?>
		<?else:?>
		<?$minPrice = $arResult['MIN_PRICE'];?>
		<div>
			<div><?=$arResult['PROPERTIES']['ARTNUMBER']['VALUE']?></div>
			<div><?=$arResult['PROPERTIES']['DIAMETR']['VALUE']?></div>
			<?if($arResult['CAN_BUY']):?>
			<input type="hidden" id="price-value-<?=$arResult['ID']?>" value="<?=$minPrice['VALUE']?>">
			<div><strong id="price-product-<?=$arResult['ID']?>"><?=number_format($minPrice['VALUE'],0,'',' ');?> <span>руб</span></strong></div>
			<div class="g-count">
					<div class="wrap-count">
						<button onclick="MinusSelect('<?=$arResult['ID']?>')">-</button>
						<input type="text" value="1" class="input-sm-<?=$arResult['ID']?>">
						<button onclick="PlusSelect('<?=$arResult['ID']?>')">+</button>
					</div>
			</div>
			<div><button class="btn-bye b-g-sm-<?=$arResult['ID']?>" onclick="addToBasket('<?echo $arResult['ADD_URL'];?>','<?=$arResult['ID']?>');" ><i class="demo-icon icon-cart"></i></button>
			</div>
			<?else:?>
			<div class="g-price" ></div>
			<div class="g-count">
				<div class="wrap-count">
					<?echo ('' != $arParams['MESS_NOT_AVAILABLE'] ? $arParams['MESS_NOT_AVAILABLE'] : GetMessage('CT_BCS_TPL_MESS_PRODUCT_NOT_AVAILABLE'));?>
				</div>
			</div>
			<div class="g-btn"><button class="btn-bye not-available" disabled ><i class="demo-icon icon-cart"></i></button></div>
			<?endif;?>
		</div>
		<?endif;?>
	</div>
	<?endif;?>
	
	
</div>

	<div class="col-md-12">
									<div class="info-block">
										<div class="wrapper">
										    <div class="tabs">
                                                <span class="tab">Техническая документация</span>
										        <span class="tab">Дополнительная информация</span>										        
										        <span class="tab">Прочее</span>        
										    </div>
										    <div class="tab_content">										        
										        <div class="tab_item">
                                                <?
                                                  if(is_array($arResult['PROPERTIES']["DOCS"]["VALUE"])){
                                                        if (CModule::IncludeModule('highloadblock'))
                                                        {
                                                                $arHLBlockDocs = Bitrix\Highloadblock\HighloadBlockTable::getById(3)->fetch();
                                                                $obEntityDocs = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($arHLBlockDocs);
                                                                $strEntityDataClassDocs = $obEntityDocs->getDataClass();
                                                                $rsDataDocs = $strEntityDataClassDocs::getList(array(
                                                                                      'select' => array('*'),    
                                                                                      'filter' => array('UF_XML_ID' => $arResult['PROPERTIES']["DOCS"]["VALUE"]),            
                                                                ));
                                                                
                                                                $obEnum = new CUserFieldEnum;
                                                                $rsEnum = $obEnum->GetList(array(), array("USER_FIELD_ID" => 38));
                                                                $arTypes = array();
                                                                while($arEnum = $rsEnum->GetNext()){
                                                                   $arTypes[$arEnum["ID"]] = $arEnum["VALUE"];
                                                                }
                                                                
                                                                //echo "<pre>";
                                                                //print_r($arTypes);
                                                                //echo "</pre>";  
                                                                echo "<ul>";
                                                                while ($arItemDocs = $rsDataDocs->Fetch()) {                       
                                                                //echo "<pre>";
                                                                //print_r($arItemDocs);
                                                                //echo "</pre>";                                                         
                                                                
                                                                	   echo "<li><a href=\"".str_replace("/home/webmaster/web/proconsim.ru/public_html", "", $arItemDocs["UF_LINK"])."\">". $arTypes[$arItemDocs["UF_DOC_TYPES"]]." ".$arItemDocs["UF_NAME"]."</a></li>";
                                                                 
                                                                }
                                                                	echo "</ul>";
                                                        
                                                         }      
                                                           
                                                  }
                                                ?>
                                                
                                                </div>
                                                <div class="tab_item"><?=htmlspecialcharsBack($arResult['~DETAIL_TEXT'])?></div>
										        <div class="tab_item"><?=$arResult['PROPERTIES']['DOP_INFO']['~VALUE']['TEXT']?></div>
										    </div>
										</div>
										
									</div>

									
								</div>	
		


	</div>

</div><?
if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']))
{
	foreach ($arResult['JS_OFFERS'] as &$arOneJS)
	{
		if ($arOneJS['PRICE']['DISCOUNT_VALUE'] != $arOneJS['PRICE']['VALUE'])
		{
			$arOneJS['PRICE']['DISCOUNT_DIFF_PERCENT'] = -$arOneJS['PRICE']['DISCOUNT_DIFF_PERCENT'];
			$arOneJS['BASIS_PRICE']['DISCOUNT_DIFF_PERCENT'] = -$arOneJS['BASIS_PRICE']['DISCOUNT_DIFF_PERCENT'];
		}
		$strProps = '';
		if ($arResult['SHOW_OFFERS_PROPS'])
		{
			if (!empty($arOneJS['DISPLAY_PROPERTIES']))
			{
				foreach ($arOneJS['DISPLAY_PROPERTIES'] as $arOneProp)
				{
					$strProps .= '<dt>'.$arOneProp['NAME'].'</dt><dd>'.(
						is_array($arOneProp['VALUE'])
						? implode(' / ', $arOneProp['VALUE'])
						: $arOneProp['VALUE']
					).'</dd>';
				}
			}
		}
		$arOneJS['DISPLAY_PROPERTIES'] = $strProps;
	}
	if (isset($arOneJS))
		unset($arOneJS);
	$arJSParams = array(
		'CONFIG' => array(
			'USE_CATALOG' => $arResult['CATALOG'],
			'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
			'SHOW_PRICE' => true,
			'SHOW_DISCOUNT_PERCENT' => ($arParams['SHOW_DISCOUNT_PERCENT'] == 'Y'),
			'SHOW_OLD_PRICE' => ($arParams['SHOW_OLD_PRICE'] == 'Y'),
			'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
			'SHOW_SKU_PROPS' => $arResult['SHOW_OFFERS_PROPS'],
			'OFFER_GROUP' => $arResult['OFFER_GROUP'],
			'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
			'SHOW_BASIS_PRICE' => ($arParams['SHOW_BASIS_PRICE'] == 'Y'),
			'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
			'SHOW_CLOSE_POPUP' => ($arParams['SHOW_CLOSE_POPUP'] == 'Y'),
			'USE_STICKERS' => true,
			'USE_SUBSCRIBE' => $showSubscribeBtn,
		),
		'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],
		'VISUAL' => array(
			'ID' => $arItemIDs['ID'],
		),
		'DEFAULT_PICTURE' => array(
			'PREVIEW_PICTURE' => $arResult['DEFAULT_PICTURE'],
			'DETAIL_PICTURE' => $arResult['DEFAULT_PICTURE']
		),
		'PRODUCT' => array(
			'ID' => $arResult['ID'],
			'NAME' => $arResult['~NAME']
		),
		'BASKET' => array(
			'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
			'BASKET_URL' => $arParams['BASKET_URL'],
			'SKU_PROPS' => $arResult['OFFERS_PROP_CODES'],
			'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
			'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
		),
		'OFFERS' => $arResult['JS_OFFERS'],
		'OFFER_SELECTED' => $arResult['OFFERS_SELECTED'],
		'TREE_PROPS' => $arSkuProps
	);
	if ($arParams['DISPLAY_COMPARE'])
	{
		$arJSParams['COMPARE'] = array(
			'COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
			'COMPARE_PATH' => $arParams['COMPARE_PATH']
		);
	}
}
else
{
	$emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
	if ('Y' == $arParams['ADD_PROPERTIES_TO_BASKET'] && !$emptyProductProperties)
	{
?>
<div id="<? echo $arItemIDs['BASKET_PROP_DIV']; ?>" style="display: none;">
<?
		if (!empty($arResult['PRODUCT_PROPERTIES_FILL']))
		{
			foreach ($arResult['PRODUCT_PROPERTIES_FILL'] as $propID => $propInfo)
			{
?>
	<input type="hidden" name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]" value="<? echo htmlspecialcharsbx($propInfo['ID']); ?>">
<?
				if (isset($arResult['PRODUCT_PROPERTIES'][$propID]))
					unset($arResult['PRODUCT_PROPERTIES'][$propID]);
			}
		}
		$emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
		if (!$emptyProductProperties)
		{
?>
	<table>
<?
			foreach ($arResult['PRODUCT_PROPERTIES'] as $propID => $propInfo)
			{
?>
	<tr><td><? echo $arResult['PROPERTIES'][$propID]['NAME']; ?></td>
	<td>
<?
				if(
					'L' == $arResult['PROPERTIES'][$propID]['PROPERTY_TYPE']
					&& 'C' == $arResult['PROPERTIES'][$propID]['LIST_TYPE']
				)
				{
					foreach($propInfo['VALUES'] as $valueID => $value)
					{
						?><label><input type="radio" name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]" value="<? echo $valueID; ?>" <? echo ($valueID == $propInfo['SELECTED'] ? '"checked"' : ''); ?>><? echo $value; ?></label><br><?
					}
				}
				else
				{
					?><select name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]"><?
					foreach($propInfo['VALUES'] as $valueID => $value)
					{
						?><option value="<? echo $valueID; ?>" <? echo ($valueID == $propInfo['SELECTED'] ? '"selected"' : ''); ?>><? echo $value; ?></option><?
					}
					?></select><?
				}
?>
	</td></tr>
<?
			}
?>
	</table>
<?
		}
?>
</div>
<?
	}
	if ($arResult['MIN_PRICE']['DISCOUNT_VALUE'] != $arResult['MIN_PRICE']['VALUE'])
	{
		$arResult['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'] = -$arResult['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'];
		$arResult['MIN_BASIS_PRICE']['DISCOUNT_DIFF_PERCENT'] = -$arResult['MIN_BASIS_PRICE']['DISCOUNT_DIFF_PERCENT'];
	}
	$arJSParams = array(
		'CONFIG' => array(
			'USE_CATALOG' => $arResult['CATALOG'],
			'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
			'SHOW_PRICE' => (isset($arResult['MIN_PRICE']) && !empty($arResult['MIN_PRICE']) && is_array($arResult['MIN_PRICE'])),
			'SHOW_DISCOUNT_PERCENT' => ($arParams['SHOW_DISCOUNT_PERCENT'] == 'Y'),
			'SHOW_OLD_PRICE' => ($arParams['SHOW_OLD_PRICE'] == 'Y'),
			'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
			'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
			'SHOW_BASIS_PRICE' => ($arParams['SHOW_BASIS_PRICE'] == 'Y'),
			'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
			'SHOW_CLOSE_POPUP' => ($arParams['SHOW_CLOSE_POPUP'] == 'Y'),
			'USE_STICKERS' => true,
			'USE_SUBSCRIBE' => $showSubscribeBtn,
		),
		'VISUAL' => array(
			'ID' => $arItemIDs['ID'],
		),
		'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],
		'PRODUCT' => array(
			'ID' => $arResult['ID'],
			'PICT' => $arFirstPhoto,
			'NAME' => $arResult['~NAME'],
			'SUBSCRIPTION' => true,
			'PRICE' => $arResult['MIN_PRICE'],
			'BASIS_PRICE' => $arResult['MIN_BASIS_PRICE'],
			'SLIDER_COUNT' => $arResult['MORE_PHOTO_COUNT'],
			'SLIDER' => $arResult['MORE_PHOTO'],
			'CAN_BUY' => $arResult['CAN_BUY'],
			'CHECK_QUANTITY' => $arResult['CHECK_QUANTITY'],
			'QUANTITY_FLOAT' => is_double($arResult['CATALOG_MEASURE_RATIO']),
			'MAX_QUANTITY' => $arResult['CATALOG_QUANTITY'],
			'STEP_QUANTITY' => $arResult['CATALOG_MEASURE_RATIO'],
		),
		'BASKET' => array(
			'ADD_PROPS' => ($arParams['ADD_PROPERTIES_TO_BASKET'] == 'Y'),
			'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
			'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
			'EMPTY_PROPS' => $emptyProductProperties,
			'BASKET_URL' => $arParams['BASKET_URL'],
			'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
			'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
		)
	);
	if ($arParams['DISPLAY_COMPARE'])
	{
		$arJSParams['COMPARE'] = array(
			'COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
			'COMPARE_PATH' => $arParams['COMPARE_PATH']
		);
	}
	unset($emptyProductProperties);
}
?>
<script type="text/javascript">
var <? echo $strObName; ?> = new JCCatalogElement(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
BX.message({
	ECONOMY_INFO_MESSAGE: '<? echo GetMessageJS('CT_BCE_CATALOG_ECONOMY_INFO'); ?>',
	BASIS_PRICE_MESSAGE: '<? echo GetMessageJS('CT_BCE_CATALOG_MESS_BASIS_PRICE') ?>',
	TITLE_ERROR: '<? echo GetMessageJS('CT_BCE_CATALOG_TITLE_ERROR') ?>',
	TITLE_BASKET_PROPS: '<? echo GetMessageJS('CT_BCE_CATALOG_TITLE_BASKET_PROPS') ?>',
	BASKET_UNKNOWN_ERROR: '<? echo GetMessageJS('CT_BCE_CATALOG_BASKET_UNKNOWN_ERROR') ?>',
	BTN_SEND_PROPS: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_SEND_PROPS'); ?>',
	BTN_MESSAGE_BASKET_REDIRECT: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_BASKET_REDIRECT') ?>',
	BTN_MESSAGE_CLOSE: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE'); ?>',
	BTN_MESSAGE_CLOSE_POPUP: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE_POPUP'); ?>',
	TITLE_SUCCESSFUL: '<? echo GetMessageJS('CT_BCE_CATALOG_ADD_TO_BASKET_OK'); ?>',
	COMPARE_MESSAGE_OK: '<? echo GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_OK') ?>',
	COMPARE_UNKNOWN_ERROR: '<? echo GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_UNKNOWN_ERROR') ?>',
	COMPARE_TITLE: '<? echo GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_TITLE') ?>',
	BTN_MESSAGE_COMPARE_REDIRECT: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_COMPARE_REDIRECT') ?>',
	PRODUCT_GIFT_LABEL: '<? echo GetMessageJS('CT_BCE_CATALOG_PRODUCT_GIFT_LABEL') ?>',
	SITE_ID: '<? echo SITE_ID; ?>'
});
function addToBasket(urlb,id){
	$.ajax({
        type: "GET",
        url: urlb+"&quantity="+$(".input-sm-"+id).val(),
		dataType: "html",
		success: function(out){

			alert("Товар добавлен в корзину");
		}
	});
}
function MinusSelect(id){
	var count = $('.input-sm-'+id).val();
	if(count < 2){
		return false;
	}else{
		var cost = $('.price-value-'+id).val();
		count = count - 1;
		cost = parseFloat(cost) * count;
		cost = number_format(cost, 2, ',', ' ');
		$('.input-sm-'+id).val(count);
		$('.price-product-'+id).html(cost+" <span>руб</span>");
	}
}
function PlusSelect(id){
	var count = $('.input-sm-'+id).val();
	if(count > 0){
	count = parseFloat(count) + 1;
	var cost;
	cost = $('.price-value-'+id).val();
	cost = parseFloat(cost) * count;
	cost = number_format(cost, 2, ',', ' ');
	$('.input-sm-'+id).val(count);
	$('.price-product-'+id).html(cost+" <span>руб</span>");
	console.log(id);
	}
}
</script>