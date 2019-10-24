<?require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");

if($_POST){
    $curPrice = "";
    if ($USER->IsAuthorized()){
        $arPriceGroups = array(13,14,15,16);
        $arUserGroups = CUser::GetUserGroup($USER->GetID());        
        $result_intersect = array_intersect($arPriceGroups, $arUserGroups);        
        if($result_intersect){
            $rsGroup = CGroup::GetByID($result_intersect[0]); 
            $arGroup = $rsGroup->Fetch();
            $curPrice = $arGroup["NAME"];
        }        
    }
	$city_id = intval($_POST['city_id']);
    
    $arSelect = Array("ID", "IBLOCK_ID", "NAME", "CODE","PROPERTY_*");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
    $arFilter = Array("IBLOCK_ID"=>6, "ID"=>$city_id);
    $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
    while($ob = $res->GetNextElement()){ 
     $arFields = $ob->GetFields();
     $arProps = $ob->GetProperties();
     $_SESSION['REGION_ID'] =  $arFields['ID'];
     $_SESSION['REGION_NAME'] =  $arFields['NAME'];
     if(!empty($curPrice)){
        $_SESSION['PRICE_REGION_NUMER'] = $arProps['PRICE_ID_'.$curPrice]['~VALUE'];
	    $_SESSION['PRICE_REGION_NAME'] =  $arProps['PRICE_CODE_'.$curPrice]['~VALUE'];
     }else{
        $_SESSION['PRICE_REGION_NUMER'] = $arProps['PRICE_ID']['~VALUE'];
	    $_SESSION['PRICE_REGION_NAME'] =  $arProps['PRICE_CODE']['~VALUE'];
     }
     $_SESSION['REGION_EMAIL'] = $arProps['EMAIL_PDF']['~VALUE'];
	 $_SESSION['REGION_PHONE'] =  $arProps['PHONE_PDF']['~VALUE'];
     $_SESSION['REGION_ADDRESS'] =  $arProps['ADDRESS']['~VALUE'];
     $_SESSION['REGION_MODE'] =  $arProps['MODE']['~VALUE'];
	 $_SESSION['REGION_CODE'] =  $arFields['CODE'];
    }
    echo "ok";
}
 
?>