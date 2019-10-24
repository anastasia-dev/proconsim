<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Title");
?>
<?
$curpage = $APPLICATION->GetCurDir();

echo preg_match('#.*?\/catalog\/.*?\/filter\/.*?-is-.*?-(is|or)-.*?#', $_SERVER['REQUEST_URI'], $matches);

?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>