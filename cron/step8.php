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


$file_report = $_SERVER["DOCUMENT_ROOT"]."/cron/report_step8.txt";
if (file_exists($file_report)) {
    unlink($file_report);
}   
$for_report = "";

clearTable();
$filename = $_SERVER['DOCUMENT_ROOT'].'/import/yar-price.xlsx';

$newID = checkLoad($filename);
if(isset($newID["err"])){ 
	$for_report .= "checkLoad ERROR: ".$newID["err"]."\r\n";
}else{
    $res = parse_excel_file($filename);
    if($res["err"]){ 
    	$for_report .= "parse_excel_file ERROR: ".$res["err"]."\r\n";
        $connection = Bitrix\Main\Application::getConnection();
	    $sqlHelper = $connection->getSqlHelper();
        $connection->queryExecute("UPDATE cron_loads SET TextErr='parse_excel_file ERROR: ".$res["err"]."' WHERE id=".$newID);
    }else{    
    	$countRec = getRecords($res);    
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
        
        $connection->queryExecute("INSERT INTO cron_loads (LoadDate,LoadTYpe,FileDateUnix,FileDate,Status) VALUES (NOW(),'4','".$fileData."','".date("Y-m-d H:i:s", $fileData)."','0')");
        
        $sql = "SELECT id FROM cron_loads WHERE id = LAST_INSERT_ID();";
        
        $recordset = $connection->query($sql);
        if ($recordrow = $recordset->fetch())
        {        
            $newID = $recordrow["id"];            
        }
        
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
            
        $sql2 = "SELECT FileDateUnix FROM cron_loads WHERE LoadTYpe=4 AND Status=1 AND id<>".$newID." ORDER BY id DESC";
        $dateset = $connection->query($sql2, 1);
        if ($daterow = $dateset->fetch())
        {        
            $dbFileDateUnix = $daterow["FileDateUnix"];   
            if($fileData<=$dbFileDateUnix){
                $return["err"] = "Old file yar-price.xlsx";
                $connection->queryExecute("UPDATE cron_loads SET TextErr='checkLoad ERROR: Old file yar-price.xlsx' WHERE id=".$newID);
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
    for($i=0;$i<$count;$i++){ 
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


require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");
?>
