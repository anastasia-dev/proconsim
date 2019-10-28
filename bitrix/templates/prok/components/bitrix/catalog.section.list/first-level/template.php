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
if (0 < $arResult["SECTIONS_COUNT"])
{
	$count = 1;
	$fourth_line = 1;
	$two_line = 1;
	
?>

<div>
<?

			$intCurrentDepth = 1;
			$boolFirst = true;
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

				if ($intCurrentDepth < $arSection['RELATIVE_DEPTH_LEVEL'])
				{
					if (0 < $intCurrentDepth){
						echo "<ul>";
					}
					/*После вывода родительского раздела с подразделами*/
				}
				elseif ($intCurrentDepth == $arSection['RELATIVE_DEPTH_LEVEL'])
				{
					if (!$boolFirst)
						echo '';
					if($arSection['RELATIVE_DEPTH_LEVEL'] == 1):
						echo "</div>";
					endif;
					/*Второй уровень, все кроме последнего*/
				}
				else
				{
					while ($intCurrentDepth > $arSection['RELATIVE_DEPTH_LEVEL'])
					{
						echo "</ul>";
						$intCurrentDepth--;
						/* Второй уровень последний*/
					}
					echo '</div>';
					/* второй уровень тоже последний только хз*/
				}
				if($arSection['RELATIVE_DEPTH_LEVEL'] == 1):?>
					<div id="<?=$this->GetEditAreaId($arSection['ID']);?>" class="cat-box fourth_line_<?=$fourth_line?> second_line_<?=$two_line?>">
						<h3><?if(trim($arSection['UF_ICON_CLASS']) != ""):?><i class="demo-icon <?=$arSection['UF_ICON_CLASS']?>"></i>
						<?elseif(trim($arSection['PICTURE']['SRC']) != ""):?><div class="image-catalog-first-level"><img src="<?=$arSection['PICTURE']['SRC']?>" /></div><?endif;?> 
						<a href="<? echo $arSection["SECTION_PAGE_URL"]; ?>"><? echo $arSection["NAME"]?><?
							if ($arParams["COUNT_ELEMENTS"])
							{
								?> <span>(<? echo $arSection["ELEMENT_CNT"]; ?>)</span><?
							}
							?>
						</a>
						</h3>
				<?
					if($count%2 == 0):
						$two_line ++;
						if($count%4 == 0):
							$fourth_line ++;
						endif;
					endif;
					$count ++;
				?>
				<?else:?>
					<li id="<?=$this->GetEditAreaId($arSection['ID']);?>">
						<a href="<? echo $arSection["SECTION_PAGE_URL"]; ?>"><? echo $arSection["NAME"]?><?
							if ($arParams["COUNT_ELEMENTS"])
							{
								?> <span>(<? echo $arSection["ELEMENT_CNT"]; ?>)</span><?
							}
							?>
						</a>
					</li>
				<?endif;?>

				<?$intCurrentDepth = $arSection['RELATIVE_DEPTH_LEVEL'];
				$boolFirst = false;
			}
			?></div>
			<input type="hidden" id="count_two" value="<?=$two_line?>"/>
			<input type="hidden" id="count_four" value="<?=$fourth_line?>"/>
			<?


?>
<?
}
?>