<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>

<?    
CModule::IncludeModule('iblock');
$IBLOCK_ID = 2;

/*
S - строка
N - число
L - список
F - файл
G - привязка к разделу
E - привязка к элементу
*/

if($_POST){
	$prop = $_POST["prop"];
	//$prop = "MODEL#S";
    
    $pos = strpos($prop, "#");
    $propCode = substr($prop, 0, $pos);
    $propType =  substr($prop, ($pos+1));
    
    $searchProp = "PROPERTY_".$propCode;
    
    //$pos2 = strpos($prop, "@");
    //$propMultiple =  substr($prop, ($pos2+1));
    $arrProp = array();
    if($propType=="S" || $propType=="N" || $propType=="L"){
        $arrProp[$propCode] = false;
    }
    if($propType=="F"){
        $arrProp[$propCode] = Array("del" => "Y");
    }
    if($propType=="E" || $propType=="G"){
        $arrProp[$propCode] = array("VALUE"=>array());
    }
     
    $arSelect = Array("ID", "IBLOCK_ID", "IBLOCK_SECTION_ID", "IBLOCK_SECTION", "ACTIVE", "NAME", $searchProp);//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
    $arFilter = Array(
                    "IBLOCK_ID"=>$IBLOCK_ID,
                    "!".$searchProp => false           
                    
                );
    $resProduct = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
    
    $count = 0;
    
    while($ob = $resProduct->GetNextElement()){ 
    $count++;
    				  
        $arFields = $ob->GetFields(); 
    	//$arProps = $ob->GetProperties();
        //echo "<pre>";
        //print_r($arFields);
        //echo "</pre>";   
                   
		//echo "<pre>";
		//print_r($arProps);
		//echo "</pre>";   
        echo $arFields["ID"]." ".$searchProp."_VALUE =".$arFields[$searchProp."_VALUE"]." ".$arFields["NAME"]."<br />";
		CIBlockElement::SetPropertyValuesEx($arFields["ID"], $IBLOCK_ID,  $arrProp);

    }  
}
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>