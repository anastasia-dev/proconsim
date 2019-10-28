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
<?$curPrice = "";?>
<?if ($USER->IsAuthorized()){
    $arPriceGroups = array(13,14,15,16);
    $arUserGroups = CUser::GetUserGroup($USER->GetID());    
    $result_intersect = array_intersect($arPriceGroups, $arUserGroups);    
    if($result_intersect){
        $rsGroup = CGroup::GetByID($result_intersect[key($result_intersect)]); 
        $arGroup = $rsGroup->Fetch();
        $curPrice = $arGroup["NAME"];
    }    
 }
?>
<?$city_id = $APPLICATION->get_cookie('USER_CITY');?>
<?//echo $city_id;?>
<?if(intval($city_id) == 0):?>
<?$city_id = 439;?>
<?endif;?>
<span class="city-select-text hidden-xs hidden-sm">Ваш город</span>
<select onchange="selectCity(this.value)" name="" id="select_city_top" class="city-select-select">
<option data-value="moskva" value="439" <?if($city_id == 439):?>selected<?endif;?>>Москва</option>
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?if($arItem['ID'] != 439):?>
		<option data-value="<?=$arItem['CODE']?>" value="<?=$arItem['ID']?>" <?if($city_id == $arItem['ID']):?>selected<?endif;?>><?=$arItem['NAME']?></option>
	<?endif;?>
	<?if($city_id == $arItem['ID']):?>
        <?$_SESSION["REGION_ID"] = $arItem["ID"];?>
        <?$_SESSION['REGION_NAME'] =  $arItem['NAME'];?>
        <?if(!empty($curPrice)){?>
		  <?$_SESSION['PRICE_REGION_NUMER'] = $arItem['PROPERTIES']['PRICE_ID_'.$curPrice]['~VALUE'];?>
		  <?$_SESSION['PRICE_REGION_NAME'] =  $arItem['PROPERTIES']['PRICE_CODE_'.$curPrice]['~VALUE'];?>
        <?}else{?>
            <?$_SESSION['PRICE_REGION_NUMER'] = $arItem['PROPERTIES']['PRICE_ID']['~VALUE'];?>
            <?$_SESSION['PRICE_REGION_NAME'] =  $arItem['PROPERTIES']['PRICE_CODE']['~VALUE'];?>
        <?}?>
		<?$_SESSION['REGION_CODE'] =  $arItem['CODE'];?>
        <?$_SESSION['REGION_EMAIL'] =  $arItem['PROPERTIES']['EMAIL_PDF']['~VALUE'];?>
        <?$_SESSION['REGION_PHONE'] =  $arItem['PROPERTIES']['PHONE_PDF']['~VALUE'];?>
        <?$_SESSION['REGION_ADDRESS'] =   $arItem['PROPERTIES']['ADDRESS']['~VALUE'];?>
        <?$_SESSION['REGION_MODE'] =   $arItem['PROPERTIES']['MODE']['~VALUE'];?>
	<?endif;?>
<?endforeach;?>
</select>
<?GLOBAL $CITY;?>
<?$CITY = $city_id;?>
