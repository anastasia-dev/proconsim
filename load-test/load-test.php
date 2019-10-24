<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Title");
?>
<?


if(CModule::IncludeModule('iblock')){
   $arSelect = Array();
   $arFilter = Array('IBLOCK_ID'=>2);
   $res = CIBlockSection::GetList(Array('SORT'=>'ASC'), $arFilter, true, $arSelect);
   while($ob = $res->GetNext())
   {
	   if($ob['ELEMENT_CNT']>0){
            echo '<b>'.$ob['ID'].'-'.$ob['NAME'].'</b><br />';
            $arrayFilter = array('IBLOCK_ID' => 2, 'SECTION_ID'=>$ob['ID']);

	 $dbItems = CIBlockElement::GetList(array(), $arrayFilter, array('PROPERTY_ARTNUMBER'),false, array()); 

	 while($arItem = $dbItems->GetNext(true, false)) { 

		 if($arItem['CNT']>1){
			 echo '<p style="color:#ff0000;">'.$arItem['PROPERTY_ARTNUMBER_VALUE']."</p>";
			 //echo $arItem['NAME']."<br /><br />";
		 }
		 //echo "<pre>";
		 //print_r($arItem);
		 //echo "</pre>";
	 }

	   } 

	   //echo "<pre>";
	   //print_r($ob);
	   //echo "</pre>";
   }
}
/*
//пример выборки дерева подразделов для раздела 
$rsParentSection = CIBlockSection::GetByID(ID_необходимой_секции);
if ($arParentSection = $rsParentSection->GetNext())
{
   $arFilter = array('IBLOCK_ID' => $arParentSection['IBLOCK_ID'],'>LEFT_MARGIN' => $arParentSection['LEFT_MARGIN'],'<RIGHT_MARGIN' => $arParentSection['RIGHT_MARGIN'],'>DEPTH_LEVEL' => $arParentSection['DEPTH_LEVEL']); // выберет потомков без учета активности
   $rsSect = CIBlockSection::GetList(array('left_margin' => 'asc'),$arFilter);
   while ($arSect = $rsSect->GetNext())
   {
       // получаем подразделы
   }
}
*/
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>