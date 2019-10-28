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

$arViewModeList = $arResult['VIEW_MODE_LIST'];

$arViewStyles = array(
	'LIST' => array(
		'CONT' => 'bx_sitemap',
		'TITLE' => 'bx_sitemap_title',
		'LIST' => 'bx_sitemap_ul',
	),
	'LINE' => array(
		'CONT' => 'bx_catalog_line',
		'TITLE' => 'bx_catalog_line_category_title',
		'LIST' => 'bx_catalog_line_ul',
		'EMPTY_IMG' => $this->GetFolder().'/images/line-empty.png'
	),
	'TEXT' => array(
		'CONT' => 'bx_catalog_text',
		'TITLE' => 'bx_catalog_text_category_title',
		'LIST' => 'bx_catalog_text_ul'
	),
	'TILE' => array(
		'CONT' => 'bx_catalog_tile',
		'TITLE' => 'bx_catalog_tile_category_title',
		'LIST' => 'bx_catalog_tile_ul',
		'EMPTY_IMG' => $this->GetFolder().'/images/tile-empty.png'
	)
);
$arCurView = $arViewStyles[$arParams['VIEW_MODE']];

$strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
$strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
$arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));
?>

						
<?
//if ($USER->IsAdmin()){
//echo "<pre>";
//print_r($arResult['SECTIONS']);
//echo "</pre>";
//}
?>
<h2 class="title">Популярные группы товаров</h2>
<div class="category-menu-icon">
	<ul>
		<?
		foreach ($arResult['SECTIONS'] as &$arSection)
		{
			$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
			$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);

				if($arSection["SECTION_PAGE_URL"]=="/catalog/aktsii/"){
					$arSection["SECTION_PAGE_URL"]="/stock/";
				}

				if($arSection["SECTION_PAGE_URL"]=="/catalog/novinki/"){
					$arSection["SECTION_PAGE_URL"]="/novinki/";
				}
			if($arSection["UF_SHOW_INDEX"]==1){
                $arSection["NAME"] = str_replace("Задвижки. Затворы.","Задвижки.&nbsp;Затворы.",$arSection["NAME"]);
                $name = $arSection['NAME'];
                if(!empty($arSection["UF_SHORT_NAME"])){
                    $name = $arSection["UF_SHORT_NAME"];
                }
			?>
				<li id="<? echo $this->GetEditAreaId($arSection['ID']); ?>">
					<a href="<?=$arSection['SECTION_PAGE_URL']?>"><?if($arSection['UF_ICON_CLASS']):?><i class="demo-icon <?=$arSection['UF_ICON_CLASS']?>"></i><?elseif(trim($arSection['PICTURE']['SRC']) != ""):?><div class="image-catalog-onmain"><img src="<?=$arSection['PICTURE']['SRC']?>" /></div><?endif;?><?=$name?></a>
				</li>
			<?
			}
		}
		?>
	</ul>
</div>