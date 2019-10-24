<?include ($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");?>
<?
$intSKUIBlock = IBLOCK_SKU_ID;
$IBLOCK_PROD_ID = IBLOCK_PRODUCT_ID;
$intSKUProperty = 31;
if(CModule::IncludeModule('iblock') and CModule::IncludeModule("catalog")){
	$ID = $_POST['id'];
	$Price = $_POST['price'];
	//$arPriceCode = explode(";",$_POST['pricecode']);
	//$arCount = explode(";",$_POST['count']);
	
	//foreach($arPrice as $key => $value):		
		$arFields = Array(
		"PRODUCT_ID" => $ID,
		"CATALOG_GROUP_ID" => 15,
		"PRICE" => $Price,
		"CURRENCY" => "RUB");
		$res = CPrice::GetList(array(),	array("PRODUCT_ID" => $ID, "CATALOG_GROUP_ID" => 15));

		if ($arr = $res->Fetch()){
			CPrice::Update($arr["ID"], $arFields);
		}
		else{
			CPrice::Add($arFields);
		}	
	//endforeach;
}
echo "ok";?>				
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>	