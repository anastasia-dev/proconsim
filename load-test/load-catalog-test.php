<?include ($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");?>
<?
$intSKUIBlock = IBLOCK_SKU_ID;
$IBLOCK_PROD_ID = IBLOCK_PRODUCT_ID;
$intSKUProperty = 31;
if(CModule::IncludeModule('iblock') and CModule::IncludeModule("catalog")){
	$ID = 38605;
    $active = "N";
    $strPostPrice = "2352.92;2412;2384;2459;2409;2565;2435;2376;2588;2353;2431;2407;2392;2491;2353;2456;2494;2353";
	$arPrice = explode(";",$strPostPrice);
    $strPostPriceCode = "2;3;4;5;6;7;8;9;10;19;11;12;13;14;;16;17;18"; 
	$arPriceCode = explode(";",$strPostPriceCode);
    $strPostCount = "0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0;0";
	$arCount = explode(";",$strPostCount);
    $strPostSklad = "439;321;322;323;324;325;326;327;328;11941;329;330;320;331;;333;335;332"; 
	$arSklad = explode(";",$strPostSklad);
    $PostNalichie = 0;
    $nalichieAll = intval($PostNalichie);
	$NALICHIE = array();
	foreach($arCount as $key_count => $Count):
		$NALICHIE[$key_count]['VALUE'] = $arSklad[$key_count];
		$NALICHIE[$key_count]['DESCRIPTION'] = $Count;
	endforeach;
    
    echo "<pre>";
    print_r($NALICHIE);
    echo "</pre>";
    
    echo "<pre>";
    print_r($arPrice);
    echo "</pre>";
    
    echo "<pre>";
    print_r($arPriceCode);
    echo "</pre>";
    
	CIBlockElement::SetPropertyValuesEx($ID, $IBLOCK_PROD_ID, array(138 => $NALICHIE, 145 => $nalichieAll));
	//CCatalogProduct::Update($ID,array('QUANTITY' => 100));
	$el = new CIBlockElement;
	foreach($arPrice as $key => $value):
		$CODE = intval($arPriceCode[$key]);
        
        //echo $key . " = ". $value. ", ".$CODE."<br />";
        
	//if($CODE == 0):
	//$CODE = 1;
	//endif;
    
	if($CODE > 0){
	   echo $key . " = ". $value. ", ".$CODE."<br />";
	   
		$arFields = Array(
		"PRODUCT_ID" => $ID,
		"CATALOG_GROUP_ID" => $CODE,
		"PRICE" => $arPrice[$key],
		"CURRENCY" => "RUB");
        
    echo "<pre>";
    print_r($arFields);
    echo "</pre>";    
        
        
		$res = CPrice::GetList(array(),	array("PRODUCT_ID" => $ID, "CATALOG_GROUP_ID" => $CODE));

		if ($arr = $res->Fetch()){
			CPrice::Update($arr["ID"], $arFields);
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
		}
		else{
			CPrice::Add($arFields);
		}
        
		if($CODE == 2):
			$arFields = Array(
			"PRODUCT_ID" => $ID,
			"CATALOG_GROUP_ID" => 1,
			"PRICE" => $value,
			"CURRENCY" => "RUB");
            
    echo "<pre>";
    print_r($arFields);
    echo "</pre>";   
            
			$res = CPrice::GetList(
			array(),
			array(
				"PRODUCT_ID" => $ID,
				"CATALOG_GROUP_ID" => 1
			));
			if ($arr = $res->Fetch()){
				CPrice::Update($arr["ID"], $arFields);
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
			}
			else{
				CPrice::Add($arFields);
			}
            
			if(empty($value)){
			 
                $arUpdateProductArray = Array(
                                          "MODIFIED_BY"    => 1,   // элемент изменен текущим пользователем                                          
                                          "ACTIVE"         => "N", // не активен
                                          );
                                          
                $resUp = $el->Update($ID, $arUpdateProductArray);
                if(!$resUp){
                   echo  $el->LAST_ERROR;
                }                                            
                                                       
            }else{
                if($active=="N"){
                    $arUpdateProductArray = Array(
                                          "MODIFIED_BY"    => 1,   // элемент изменен текущим пользователем                                          
                                          "ACTIVE"         => "Y", // не активен
                                          ); 
                    $resUp = $el->Update($ID, $arUpdateProductArray);
                    if(!$resUp){
                       echo  $el->LAST_ERROR;
                    }                                           
                }
            }
            
              
		endif;
       
    }
	endforeach;
}
echo "ok";?>				