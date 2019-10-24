<?
$_SERVER["DOCUMENT_ROOT"] = "/home/webmaster/web/proconsim.ru/public_html";
$DOCUMENT_ROOT = $_SERVER["DOCUMENT_ROOT"];

define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

set_time_limit(0);
ini_set('display_errors', '1');
error_reporting(E_ALL ^ E_NOTICE);
ini_set('default_socket_timeout', 180);

CModule::IncludeModule("iblock");
CModule::IncludeModule("catalog");

$for_report = "";
$text = "";
$fileName = date("YmdHis");
$fp = fopen($_SERVER["DOCUMENT_ROOT"]."/cron/load-price-ya-res-".$fileName.".txt", "a");
selectRecords();
$text .= "\r\n\r\n";
fwrite($fp, $text);
fclose($fp);

function selectRecords(){    
    $connection = Bitrix\Main\Application::getConnection();
	$sqlHelper = $connection->getSqlHelper();
    $limit = 100;
    
    $arPrices = array();
    
    $sql = "SELECT id,record FROM load_prices";
    $recordset = $connection->query($sql, $limit);
    while ($recordrow = $recordset->fetch())
    {                
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
	global $text; 
    global $fp;   
    
    
    
    foreach($prices as $price){
        if($price["id"]){
            $arProduct = getProductID($price["id"]);
            $ID = $arProduct["ID"];
            if($ID){
                $Price = str_replace(",",".",$price["price"]);
                
                $arFields = Array(
        		"PRODUCT_ID" => $ID,
        		"CATALOG_GROUP_ID" => 15,
        		"PRICE" => $Price,
        		"CURRENCY" => "RUB");
        		$res = CPrice::GetList(array(),	array("PRODUCT_ID" => $ID, "CATALOG_GROUP_ID" => 15));
                
                if ($arr = $res->Fetch()){
        			CPrice::Update($arr["ID"], $arFields);
                    $text .= iconv("UTF-8", "Windows-1251","Обновляем цену ".$arr["ID"])."\r\n";
                    $text .= iconv("UTF-8", "Windows-1251", serialize($arFields))."\r\n\r\n";
        		}
        		else{
        			CPrice::Add($arFields);
                    $text .= iconv("UTF-8", "Windows-1251","Добавляем")."\r\n";
                    $text .= iconv("UTF-8", "Windows-1251", serialize($arFields))."\r\n";
        		}
                          
                $text .= "\r\n\r\n";  
            } else{
                $text .= iconv("UTF-8", "Windows-1251","Товар с артикулом ".$price["id"]." - не найден!")."\r\n"; 
            }             
        }else{
            $text .= iconv("UTF-8", "Windows-1251","Не указан артикул!")."\r\n"; 
        }
    }    
    fwrite($fp, $text);
    $text = "";
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

function getID(){
    $connection = Bitrix\Main\Application::getConnection();
    $sqlHelper = $connection->getSqlHelper();
    $sql = "SELECT id FROM cron_loads WHERE LoadTYpe=4 ORDER BY id DESC";
        $recordset = $connection->query($sql, 1);
        if ($recordrow = $recordset->fetch())
        {        
            $ID = $recordrow["id"]; 
            return $ID;
        }
    return false;       
}

if(!empty($for_report))
{  
   $file_report = "report_step9.txt";
   if ($frp = fopen($_SERVER["DOCUMENT_ROOT"]."/cron/".$file_report, "w")){
	fwrite($frp, $for_report);
	fclose($frp);
        //exit();
	//DIE("WRITE ERR FILE");
   } else {
	exit();
	//DIE("ERR FILE NOTH OPRN");
   }
}else{
    if($id = getID()){
        $connection = Bitrix\Main\Application::getConnection();
        $sqlHelper = $connection->getSqlHelper();
        $connection->queryExecute("UPDATE cron_loads SET Status='1' WHERE id=".$id);
    }
}




require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>
