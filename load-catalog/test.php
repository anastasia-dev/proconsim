<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Загрузка каталога");
?>
<?
$fp = fopen($_SERVER['DOCUMENT_ROOT']."/upload/order/order_100.txt", "w");
if($fp){
	fwrite($fp, 'test');
	fclose($fp);
}else{
	echo "error";
}
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>