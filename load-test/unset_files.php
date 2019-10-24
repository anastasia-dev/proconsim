<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
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

    echo "<pre>";
    print_r($LastModified);
    echo "</pre>";
    
    echo "<pre>";
    print_r($FileName);
    echo "</pre>";


    $countFiles = count($FileName);
    
    if($countFiles>$countDelete){
        $count = $countFiles-$countDelete;
    	for($i=0;$i<$count;$i++){
    		echo "<p>".$i.". ".$FileName[$i]."</p>";
			//unlink($FileName[$i]);
    	}
    }
}
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>