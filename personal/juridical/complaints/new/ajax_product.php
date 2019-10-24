<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?> 
<?
CModule::IncludeModule("catalog");
if ($_POST)
{ 
    $artikul = intval($_POST["artikul"]);  
    $filialPriceID = intval($_POST["filialPriceID"]); 
    
    if(empty($filialPriceID)){$filialPriceID=2;}
    
    $json = array();   
    $arSelect = Array("ID", "IBLOCK_ID", "NAME");
    $arFilter = Array(
                     "IBLOCK_ID"=>2,                 
                     "PROPERTY_ARTNUMBER"=>$artikul
                     );
                     
    $resProduct = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
    if (intval($resProduct->SelectedRowsCount())>0){
        while($ob = $resProduct->GetNextElement()){ 
                $arFields = $ob->GetFields(); 
        }
        $json['ID'] = $arFields["ID"];
        $json['NAME'] = $arFields["NAME"];
        
        $db_res = CPrice::GetList(
                array(),
                array(
                        "PRODUCT_ID" => $arFields["ID"],
                        "CATALOG_GROUP_ID" => $filialPriceID
                    )
            );
        if ($ar_res = $db_res->Fetch())
        {
            $json['PRICE'] = $ar_res["PRICE"];
        }
        else
        {
            $json['err'] = 2;
        }
    }else{
        $json['err'] = 1;
    }    
    echo json_encode($json);
    
}                
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>