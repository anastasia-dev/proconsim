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

clearFiles("load-new-res-*.txt", 7);
clearFiles("load-price-res-*.txt", 14);
clearFiles("load-price-ya-res-*.txt", 7);

function clearFiles($fileMask, $countDelete){
    $dir = $_SERVER['DOCUMENT_ROOT']."/cron/";
    $LastModified = array();
    $FileName = array();
    foreach(glob($dir . $fileMask) as $file) {
        $LastModified[] = filemtime($file); // массив файлов со временем изменения файла 
        $FileName[] = $file; // массив всех файлов
    }  
    
    $files = array_multisort($LastModified, SORT_NUMERIC, SORT_ASC, $FileName);
    
    $countFiles = count($FileName);
    
    if($countFiles>$countDelete){
        $count = $countFiles-$countDelete;
    	for($i=0;$i<$count;$i++){    		
			unlink($FileName[$i]);
    	}
    }
}
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>

