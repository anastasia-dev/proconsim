<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
if($_POST){
    $inn =intval($_POST["inn"]);
    $filter = Array("UF_INN" => $inn);
	$rsUsers = CUser::GetList(($by = "NAME"), ($order = "desc"), $filter);
	if ($arUser = $rsUsers->Fetch()) {
	   echo $arUser["ID"];
	}
}
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>