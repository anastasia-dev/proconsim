<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$SECTION = array();
$arFilter = array('IBLOCK_ID' => 2); // выберет потомков без учета активности
$rsSect = CIBlockSection::GetList(array('depth_level' => 'asc'),$arFilter,false,array('ID', "IBLOCK_SECTION_ID","SECTION_PAGE_URL","DEPTH_LEVEL"));
while ($arSect = $rsSect->GetNext())
{
	if($arSect['DEPTH_LEVEL'] == 1):
		$SECTION[$arSect['ID']] = $arSect['SECTION_PAGE_URL'];
	else:
		$SECTION[$arSect['ID']] = $SECTION[$arSect['IBLOCK_SECTION_ID']];
	endif;

}
$arSelect = Array("ID", "NAME", 'IBCLOCK_ID', "PROPERTY_BRANDS", "IBLOCK_SECTION_ID");
$arFilter = Array("IBLOCK_ID"=>2, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
while($ob = $res->GetNextElement())
{
	$arFields = $ob->GetFields();
	if(intval($arFields['PROPERTY_BRANDS_VALUE']) != 0):
		$arResult['BRAND_LINK'][$arFields['PROPERTY_BRANDS_VALUE']] = $SECTION[$arFields['IBLOCK_SECTION_ID']];
	endif;
	
}?>