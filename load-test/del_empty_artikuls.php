<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Пустые артиккулы");
?>
<?    

$arSelect = Array("ID", "IBLOCK_ID", "IBLOCK_SECTION_ID", "IBLOCK_SECTION", "ACTIVE", "NAME", "PROPERTY_ARTNUMBER");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
$arFilter = Array(
                "IBLOCK_ID"=>2,
                "PROPERTY_ARTNUMBER" => false           
                
            );
$resProduct = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);

$count = 0;
echo "Свойство Наименование: Артикул:<br />";
while($ob = $resProduct->GetNextElement()){ 
$count++;

    $arFields = $ob->GetFields(); 
                
                    echo "<pre>";
                    print_r($arFields);
                    echo "</pre>";   
					//echo $arFields["PROPERTY_ARTNUMBER_VALUE"]." ".$arFields["NAME"]."<br />";
					if($count<501){
						$DB->StartTransaction();
						if(!CIBlockElement::Delete($arFields["ID"] ))
						{
							$strWarning .= 'Error!';
							$DB->Rollback();
						}
						else
							$DB->Commit();
					
					
					
					}  
}
echo $count;
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>        