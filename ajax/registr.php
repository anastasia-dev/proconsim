<?require($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");
$n_o = htmlspecialchars($_POST['n_o']);
$inn = htmlspecialchars($_POST['inn']);
$ogrn = htmlspecialchars($_POST['ogrn']);
$u_a = htmlspecialchars($_POST['u_a']);
$f_a = htmlspecialchars($_POST['f_a']);
$email = htmlspecialchars($_POST['email']);
$phone = htmlspecialchars($_POST['phone']);
$k_l = htmlspecialchars($_POST['k_l']);
 
if(trim($n_o)!= "" and trim($inn)!="" and trim($ogrn)!="" and trim($u_a)!="" and trim($f_a)!="" and trim($email)!="" and trim($phone)!="" and trim($k_l)!=""):
	$arEventFields= array(
		"N_O" =>$n_o,
		"INN" =>$inn,
		"OGRN" =>$ogrn,
		"U_A" =>$u_a,
		"F_A" =>$f_a,
		"EMAIL" =>$email,
		"PHONE" =>$phone,
		"K_L" =>$k_l,
	);
	CEvent::Send("USER_REGISTR", SITE_ID, $arEventFields, "N", 46);
	echo "ok";
else:
	echo "er";
endif;
?>