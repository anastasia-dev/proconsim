<?require($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");
$tender = htmlspecialchars($_POST['tender']);

if(trim($tender) != "" ):
	$arEventFields= array(
		"U_TENDER" =>$tender,
	);
	CEvent::Send("TENDER", SITE_ID, $arEventFields, "N", 45);
	echo "ok";
else:
	echo "er";
endif;
?>