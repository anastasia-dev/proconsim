<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
CModule::IncludeModule('iblock');
CModule::IncludeModule("catalog");


$filename = $_SERVER['DOCUMENT_ROOT'].'/import/yar-price.xlsx';

clearTable();

$res = parse_excel_file($filename);
//echo "<pre>";
	//print_r($res);
	//echo "</pre>";    
getRecords($res);
selectRecords();

function parse_excel_file($filename){
    echo $filename;
    $return = array();
    if (!file_exists($filename)) {
	  $return["err"]="Файл ".$filename." не найден!";
      return $return;
    }
	// путь к библиотеки от корня сайта
	require_once $_SERVER['DOCUMENT_ROOT'] .'/load-catalog/Classes/PHPExcel.php';
	
	// получаем тип файла (xls, xlsx), чтобы правильно его обработать
	$file_type = PHPExcel_IOFactory::identify( $filename );
	// создаем объект для чтения
	$objReader = PHPExcel_IOFactory::createReader( $file_type );
	$objPHPExcel = $objReader->load( $filename ); // загружаем данные файла
    $objPHPExcel->setActiveSheetIndex(0);
    $objWorksheet = $objPHPExcel->getActiveSheet();
    $result = $objPHPExcel->getActiveSheet()->toArray(); // выгружаем данные    
	return $result;
}


function getRecords($res){
	$connection = Bitrix\Main\Application::getConnection();
	$sqlHelper = $connection->getSqlHelper();
    
    $count = count($res);
    echo "<p>count = ".$count."</p>";
    for($i=0;$i<3000;$i++){ 
        if(!empty($res[$i][0])){
            $arProduct = array();
            $arProduct["id"] = $res[$i][0];
            $arProduct["price"] = $res[$i][1];
            $connection->queryExecute("INSERT INTO load_prices (record) VALUES ('" . serialize($arProduct) . "')");
        } 
        
    }    
	return $count;
}

function clearTable(){    
    $connection = Bitrix\Main\Application::getConnection();
    $sqlHelper = $connection->getSqlHelper();
    $connection->queryExecute("TRUNCATE TABLE load_prices");    
}

function selectRecords(){
    $connection = Bitrix\Main\Application::getConnection();
	$sqlHelper = $connection->getSqlHelper();
    $limit = 5;
    
    $arPrices = array();
    
    $sql = "SELECT id,record FROM load_prices";
    $recordset = $connection->query($sql, $limit);
    while ($recordrow = $recordset->fetch())
    {
        echo "<p>id = ".$recordrow["id"]."</p>";
        
        $arPrices[]= unserialize($recordrow["record"]);
        $connection->queryExecute("DELETE FROM load_prices WHERE id='" . $recordrow["id"] . "'");
    }
    $countPrices = count($arPrices);

    if($countPrices>0){
        loadPrices($arPrices);
        selectRecords();
    }	      
}

function loadPrices($prices){
	//echo "<pre>";
	//print_r($prices);
	//echo "</pre>";    
        
    foreach($prices as $price){
        if($price["id"]){
            $arProduct = getProductID($price["id"]);
            $ID = $arProduct["ID"];
            $Price = str_replace(",",".",$price["price"]); 
            
            $arFields = Array(
    		"PRODUCT_ID" => $ID,
    		"CATALOG_GROUP_ID" => 15,
    		"PRICE" => $Price,
    		"CURRENCY" => "RUB");
    		$res = CPrice::GetList(array(),	array("PRODUCT_ID" => $ID, "CATALOG_GROUP_ID" => 15));
    
    echo "<pre>";
	print_r($arFields);
	echo "</pre>";    
    
    		if ($arr = $res->Fetch()){
    			//CPrice::Update($arr["ID"], $arFields);
                echo "<p>Update</p>";
    		}
    		else{
    			//CPrice::Add($arFields);
                echo "<p>Add</p>";
    		}	
            
        }
    }

} 

function getProductID($articul){	
    $arRes = array();
    $arSelect = Array("ID", "IBLOCK_ID", "ACTIVE", "PROPERTY_ARTNUMBER", "PROPERTY_LIMIT");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
    $arFilter = Array(
                     "IBLOCK_ID"=>2,                 
                     "PROPERTY_ARTNUMBER"=>$articul,
                     );
    $resProduct = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
     if($ob = $resProduct->GetNextElement()){ 
       $arFields = $ob->GetFields(); 
          $arRes["ID"] = $arFields["ID"];
          $arRes["ACTIVE"] = $arFields["ACTIVE"];
          $arRes["LIMIT"] = $arFields['PROPERTY_LIMIT_VALUE'];
     }  
     return $arRes;
}


?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>