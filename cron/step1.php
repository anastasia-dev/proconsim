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


$file_report = $_SERVER["DOCUMENT_ROOT"]."/cron/report_step1.txt";
if (file_exists($file_report)) {
    unlink($file_report);
}    
$for_report = "";

clearTable();
$url_c = $_SERVER['DOCUMENT_ROOT']."/import/catalog.xml";

$newID = checkLoad($url_c);
if(isset($newID["err"])){ 
	$for_report .= "checkLoad ERROR: ".$newID["err"]."\r\n";
}else{
    $xml_c = getXML($url_c);
    if($xml_c["err"]){ 
    	$for_report .= "getXML ERROR: ".$xml_c["err"]."\r\n";
        $connection = Bitrix\Main\Application::getConnection();
	    $sqlHelper = $connection->getSqlHelper();
        $connection->queryExecute("UPDATE cron_loads SET TextErr='getXML ERROR: ".htmlspecialchars($xml_c["err"], ENT_QUOTES)."' WHERE id=".$newID);
        $EventFields = array("ERROR"=> "Обновление каталога.<br /> Файл step1.php.<br />".$xml_c["err"]);
        CEvent::Send("AUTO_LOAD_ERR", 's1', $EventFields,"N",83);
    }else{	
    	$countRec = getRecords($xml_c);
        //$for_report .= "getRecords. INSERT COUNT: ".$countRec."\r\n";	
    }
}
if(!empty($for_report))
{  
   
   if ($frp = fopen($file_report, "w")){
	fwrite($frp, $for_report);
	fclose($frp);
        //exit();
	//DIE("WRITE ERR FILE");
   } else {
	exit();
	//DIE("ERR FILE NOTH OPRN");
   }
}

function checkLoad($url_c){
    $return = array();
    if (file_exists($url_c)) {
        $fileData = filemtime($url_c);       
        $connection = Bitrix\Main\Application::getConnection();
	    $sqlHelper = $connection->getSqlHelper();
        
        $connection->queryExecute("INSERT INTO cron_loads (LoadDate,LoadTYpe,FileDateUnix,FileDate,Status) VALUES (NOW(),'1','".$fileData."','".date("Y-m-d H:i:s", $fileData)."','0')");
        
        $sql = "SELECT id FROM cron_loads WHERE id = LAST_INSERT_ID();";
        
        $recordset = $connection->query($sql);
        if ($recordrow = $recordset->fetch())
        {        
            $newID = $recordrow["id"];            
        }
        
        $sql2 = "SELECT FileDateUnix FROM cron_loads WHERE LoadTYpe=1 AND Status=1 AND id<>".$newID." ORDER BY id DESC";
        $recordset = $connection->query($sql2, 1);
        if ($recordrow = $recordset->fetch())
        {        
            $dbFileDateUnix = $recordrow["FileDateUnix"];   
            if($fileData<=$dbFileDateUnix){
                $return["err"] = "Old file catalog.xml";
                $connection->queryExecute("UPDATE cron_loads SET TextErr='checkLoad ERROR: Old file catalog.xml' WHERE id=".$newID);
                return $return;
            }else{
               return  $newID;
            }         
        }        
        
    } else {
        $return["err"] = "Not file ".$url_c;  
        return $return;      
    }     
}

function getXML($url){
    $return = array();
    if (file_exists($url)) {

        libxml_use_internal_errors(true);

        $xml = simplexml_load_file($url); 

        if (!$xml) {
            $errors = libxml_get_errors();
        
            foreach ($errors as $error) {
                $return["err"] .= "Ошибка: ".$error->message."<br />"; 
            }
            return $return;
        }else{
            return $xml;
        } 

    } else {
        $return["err"] = "Не удалось открыть файл ".$url;  
        return $return;      
    }  

}

function getRecords($xml_c){
	$connection = Bitrix\Main\Application::getConnection();
	$sqlHelper = $connection->getSqlHelper();
    global $DB;
    $count_product = 0;

    foreach($xml_c->offers->offer as $Offer){
    
    	//if($count_product<5){
          $arProduct = array();    		
          foreach($Offer->attributes() as $attributeName=>$attributeValue){    		             
              $arProduct[$attributeName] = (string)htmlspecialchars($attributeValue, ENT_QUOTES);
    	  }
    	  foreach($Offer->picture->attributes() as $attributeName=>$attributeValue){    		             
              $arProduct["picture"][$attributeName] = (string)$DB->ForSql($attributeValue);
    	  }
          foreach($Offer->propertyValues->propertyValue as $Prop){    
    		  //echo   $Prop["id"]." = ". $Prop->value."<br />";             
    		  $arProduct["props"][] = array((string)$Prop["id"]=>(string)htmlspecialchars($Prop->value, ENT_QUOTES));
    	  }           
    		$connection->queryExecute("INSERT INTO load_products (record) VALUES ('" . serialize($arProduct) . "')");
            $count_product++;
    	//}
    	
    }
	return $count_product;

}

function clearTable(){    
    $connection = Bitrix\Main\Application::getConnection();
    $sqlHelper = $connection->getSqlHelper();
    $connection->queryExecute("TRUNCATE TABLE load_products");    
}


require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>
