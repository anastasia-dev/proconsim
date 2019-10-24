<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<script type="text/javascript" src="/bitrix/js/main/jquery/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="props.js"></script>
<?    
CModule::IncludeModule('iblock');
$IBLOCK_ID = 2;
$checkedProps = array(12,45,46,48,49,50,51,53,55,59,62,63,64,66,67,68,69,70,71,72,73,74,76,77,79,80,81,82,86,93,94,96,97,98,99,100,102,103,104,105,106,110,114,115,116,117,118,119,120,123,124,125,126,128,129,131);
$properties = CIBlockProperty::GetList(Array("id"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$IBLOCK_ID));
echo "<h3>Свойства инфоблока:</h3>";
echo "<form method=\"post\">";
while ($props = $properties->GetNext())
{
	//echo "<pre>";
	//print_r($props);
	//echo "</pre>";  
	echo "<div style=\"margin-bottom:10px;\"><input type=\"checkbox\" name=\"props[]\" value=\"".$props["CODE"]."#".$props["PROPERTY_TYPE"]."\"";
    if(in_array($props["ID"],$checkedProps)){
        echo " checked";
    }
    echo ">".$props["NAME"]." (".$props["ID"].") ".$props["PROPERTY_TYPE"]."</div>";
}
	echo "<div><input type=\"button\" id=\"sendProps\" value=\"Очистить значения, выбранных свойств, у всех товаров каталога\"></div>";
echo "</form>";
echo "<div id=\"resClear\"></div>";
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>