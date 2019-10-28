<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
if($_POST){
CModule::IncludeModule('iblock');
	$filialid =intval($_POST["filialid"]);

    $arSelect = Array("ID", "IBLOCK_ID", "PROPERTY_FILIAL_CODE");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
    $arFilter = Array(
                    "IBLOCK_ID"=>6,
                    "ID" => $filialid 
                );
    $resProduct = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
    if($ob = $resProduct->GetNextElement()){ 
        $arFields = $ob->GetFields(); 
        echo $arFields["PROPERTY_FILIAL_CODE_VALUE"];
    }    
}
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>