<? 
$getiblock = CIBlockSection::GetList(
   Array("SORT"=>"ASC"),
   Array("IBLOCK_ID"=>$arParams['IBLOCK_ID'])
);
 
while($sectionwhile = $getiblock->GetNext())
{
	$arS[] = $sectionwhile;
}
 
foreach($arS as $arSec){  
	
	foreach($arResult["ITEMS"] as $key=>$arItem){
		
		 if($arItem['IBLOCK_SECTION_ID'] == $arSec['ID']){
			$arSec['ELEMENTS'][] =  $arItem;
		 }
	}
	
	$arElementGroups[] = $arSec;
	
}

$arResult["ITEMS"] = $arElementGroups;
?>