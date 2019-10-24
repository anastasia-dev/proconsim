<?require($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");
$name = htmlspecialchars($_POST['name']);
$phone = htmlspecialchars($_POST['phone']);
$question= htmlspecialchars($_POST['question']);


	$arEventFields= array(
		"FIO" =>$name,
        "PHONE" =>$phone,
        "QUESTION" =>$question,
        "REGION" => $_SESSION['REGION_NAME'],
	);
	CEvent::Send("CALLBACK", SITE_ID, $arEventFields, "N", 90);
	echo "ok";

?>