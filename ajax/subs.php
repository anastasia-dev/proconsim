<?require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");
$sub = false;
if($_POST['mail']){
	if (CModule::IncludeModule("catalog"))
	{
		if(CModule::IncludeModule("subscribe")){  
			$rsRubric = CRubric::GetList(array(), array("ACTIVE"=>"Y")); 
			$arRubrics = array(); 
			while($arRubric = $rsRubric->GetNext()) 
			{ 
			  $arRubrics[] = $arRubric['ID'];
			} 
			$arSub = Array(
				"EMAIL" => $_POST['mail'],
				"SEND_CONFIRM" => "Y",
				"ACTIVE" => "Y",
				"RUB_ID" => $$arRubrics
			);
			$subscr = new CSubscription;
			$ID = $subscr->Add($arSub);
			if(intval($ID) != 0){
				$sub = true;
			}
		}
	}
}
if($sub){
	echo "ok";
}else{
	echo "error";
}
?>