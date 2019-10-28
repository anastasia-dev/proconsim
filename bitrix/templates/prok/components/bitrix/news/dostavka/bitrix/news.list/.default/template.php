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
//echo "<pre>";
//print_r($arResult);
//echo "</pre>";
$counter=0;
?>
<div class="row">

<?foreach($arResult["ITEMS"] as $arItem):?>
	<?

     $counter++;
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<div class="col-md-4 text-center" style="border-top:solid 1px #ededed;padding-top:10px;margin-bottom:20px;" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
    <?if($arItem["ELEMENTS"]){?>
		<a href="<?=$arItem["ELEMENTS"][0]["DETAIL_PAGE_URL"]?>">
    <?}?>    
			<div class="text-center is-send">
            <?if(!empty($arItem["PICTURE"])){?>
                <?echo CFile::ShowImage($arItem["PICTURE"], 0, 0, "alt=\"".$arItem["NAME"]."\" vspace=4");?>  
            <?}?><br /> 
			<b><?echo $arItem["NAME"]?></b>
			</div>
    <?if($arItem["ELEMENTS"]){?>        
		</a>
     <?}?>   
        <br />
        <p>
		<?if(!empty($arItem["ELEMENTS"][0]["PREVIEW_TEXT"])){?>
           <?echo $arItem["ELEMENTS"][0]["PREVIEW_TEXT"];?>
		<?}elseif(!empty($arItem["DESCRIPTION"])){?>
            <?echo $arItem["DESCRIPTION"]?>
        <?}?> 
        </p>
	</div>
<?php
    if (fmod($counter,3)==0){
        echo "</div><div class=\"row\">";
        }
?>
<?endforeach;?>

</div>
