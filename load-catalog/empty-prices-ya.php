<?include ($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");?>
<?
if(CModule::IncludeModule("catalog")){
	$db_res = CPrice::GetList(
        array(),
        array(
              "ELEMENT_IBLOCK_ID" => IBLOCK_PRODUCT_ID, //ID инфоблока с товарами
              "CATALOG_GROUP_ID" => 15, //ID типа цены
              "CURRENCY" => "RUB" // Валюта
        )
    );
    while($ar_res = $db_res->Fetch())
    {
        //echo "<pre>";
        //print_r($ar_res);
        //echo "</pre>";
        CPrice::Update($ar_res["ID"], array("PRICE" => 0));
    }
}
?>	
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>			