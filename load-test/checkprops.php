<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Свойства");
?>
<?    

$arSelect = Array("ID", "IBLOCK_ID", "IBLOCK_SECTION_ID", "IBLOCK_SECTION", "ACTIVE", "NAME", "PROPERTY_ARTNUMBER", "PROPERTY_TYPE_KORPUS");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
$arFilter = Array(
                "IBLOCK_ID"=>2,
                "PROPERTY_TYPE_KORPUS" => "Цельносварной"            
                
            );
$resProduct = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);

$count = 0;
echo "Свойство Тип корпуса: Цельносварной:<br />";
while($ob = $resProduct->GetNextElement()){ 
$count++;
				//if($count<5){    
    $arFields = $ob->GetFields(); 
    //$arProps = $ob->GetProperties();
                    //echo "<pre>";
                    //print_r($arFields);
                    //echo "</pre>";   
	if($arFields["PROPERTY_TYPE_KORPUS_VALUE"] == "Цельносварной"){
		//echo "<pre>";
		//print_r($arFields);
		//echo "</pre>";   
	echo $arFields["PROPERTY_ARTNUMBER_VALUE"]." ".$arFields["NAME"]."<br />";
	}     
    
}  
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>        