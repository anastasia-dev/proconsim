<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Title");
?>

<?
echo "<div id=\"resPDF\"></div>";
echo "<div id=\"res\"></div>";
?>
<script type="text/javascript" src="load-pdf.js"></script>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>