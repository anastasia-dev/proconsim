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

$priceCode = "C";
$loadType = 2;
if(isset($argv[1])){
    $priceCode = $argv[1];
}
if(isset($argv[2])){
    $loadType = intval($argv[2]);
}

$file_report = $_SERVER["DOCUMENT_ROOT"]."/cron/report_step3.txt";
if (file_exists($file_report)) {
    unlink($file_report);
}   
$for_report = "";


clearTable();
$url_c = $_SERVER['DOCUMENT_ROOT']."/import/prices-remains-".$priceCode.".xml";

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
        $EventFields = array("ERROR"=> "Обновление цен.<br /> Файл step3.php.<br />".$xml_c["err"]);
        CEvent::Send("AUTO_LOAD_ERR", 's1', $EventFields,"N",83);
        
    }else{    
    	$countRec = getRecords($xml_c);    
    }
}

if(!empty($for_report))
{  
   //$file_report = "report_step3.txt";
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
    global $loadType;
    global $priceCode;
    
    $return = array();
    if (file_exists($url_c)) {
        $fileData = filemtime($url_c);       
        $connection = Bitrix\Main\Application::getConnection();
	    $sqlHelper = $connection->getSqlHelper();
        
        $connection->queryExecute("INSERT INTO cron_loads (LoadDate,LoadTYpe,FileDateUnix,FileDate,Status) VALUES (NOW(),'".$loadType."','".$fileData."','".date("Y-m-d H:i:s", $fileData)."','0')");
        
        $sql = "SELECT id FROM cron_loads WHERE id = LAST_INSERT_ID();";
        
        $recordset = $connection->query($sql);
        if ($recordrow = $recordset->fetch())
        {        
            $newID = $recordrow["id"];            
        }
        /*
        $sql1 = "SELECT Status FROM cron_loads WHERE LoadTYpe=1 ORDER BY id DESC";
        $productset = $connection->query($sql1, 1);
        $productLoadStatus=0;
        if ($productrow = $productset->fetch())
        {        
            $productLoadStatus = $productrow["Status"];            
        }
        if(empty($productLoadStatus)){
                $return["err"] = "Catalog not update";
                $connection->queryExecute("UPDATE cron_loads SET TextErr='checkLoad ERROR: Catalog not update' WHERE id=".$newID);
                return $return;
        }
        */    
        $sql2 = "SELECT FileDateUnix FROM cron_loads WHERE LoadTYpe=".$loadType." AND Status=1 AND id<>".$newID." ORDER BY id DESC";
        $dateset = $connection->query($sql2, 1);
        if ($daterow = $dateset->fetch())
        {        
            $dbFileDateUnix = $daterow["FileDateUnix"];   
            if($fileData<=$dbFileDateUnix){
                $return["err"] = "Old file prices-remains-".$priceCode.".xml";
                $connection->queryExecute("UPDATE cron_loads SET TextErr='checkLoad ERROR: Old file prices-remains-".$priceCode.".xml' WHERE id=".$newID);
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
        $return["err"] = "Not file ".$url;  
        return $return;      
    }  

}


function getRecords($xml_c){    
	$connection = Bitrix\Main\Application::getConnection();
	$sqlHelper = $connection->getSqlHelper();
    
    $count_product = 0;

    foreach($xml_c->Типоразмер as $Product){
    
    	//if($count_product<10){
          $arProduct = array();    		
          foreach($Product->attributes() as $attributeName=>$attributeValue){    		             
              $arProduct[$attributeName] = (string)$attributeValue;
    	  }
          $num=0;
		  foreach($Product->ЦеныИОстатки->Цена as $Cena){
			  foreach($Cena->attributes() as $attributeName=>$attributeValue){
				  $arProduct["CENA"][$num][$attributeName] = (string)$attributeValue;    	   
			  } 
              $num++;
		  } 
             
           	$connection->queryExecute("INSERT INTO load_prices (record) VALUES ('" . serialize($arProduct) . "')");
            $count_product++;            
    	//}
    	
    }
	return $count_product;

}

function clearTable(){    
    $connection = Bitrix\Main\Application::getConnection();
    $sqlHelper = $connection->getSqlHelper();
    $connection->queryExecute("TRUNCATE TABLE load_prices");    
}


require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>
