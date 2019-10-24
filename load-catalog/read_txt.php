<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Title");
?>
<?
$lines = file('load-new-res-230818122854.txt');
//echo "<pre>";
//print_r($lines);
//echo "</pre>";
$arIDs = array();
$lastID =0;
foreach ($lines as $k => $v) {
	if (strripos($v, "PRODUCT_ID =") !== false)
	{
		//echo "<p>".$v."</p>";
        $lastID = intval(substr($v, 13));
		//echo "<p>".$lastID."</p>";
		//$arIDs[$lastID]= $k;

	}
    $pos = strripos($v, "ARTNUMBER");
	if($pos!==false){
		//echo $pos;
		//echo "<p>".$v."</p>";
		if($lastID>0){
        	$arIDs[$lastID]=substr($v, ($pos+16),9);
		}
		//echo "<p>".$lastID." = ".substr($v, ($pos+16),9)."</p>";
	}
	/*
	if($k % 6 == 0) {
		echo "<p>".$v."</p>";
       $arIDs[]= $k;
    }
    if($k % 3 == 0 && !in_array($k,$arIDs)) {
        $vals = unserialize($v);
		echo "<p>".$v."</p>";
		//echo "<pre>";
		//print_r($vals);
		//echo "</pre>"; 
    }		
*/
}
echo "<pre>";
print_r($arIDs);
echo "</pre>";

echo count($arIDs);
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>