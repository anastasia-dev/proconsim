<?php
header("Content-Type: text/html; charset=utf-8");
require_once($_SERVER['DOCUMENT_ROOT'] ."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule('iblock');
$url = "managers.xml";

$xml = simplexml_load_file($url);

$count=0;
//echo "<pre>";
//print_r($xml);
//echo "</pre>";

foreach($xml as $managers)
{
	//echo $managers["ЦФО"]."<br />";
	//echo $managers["Телефон"]."<br />";
	//echo $managers["Email"]."<br />";
	//echo $managers["ФИО"]."<br />";
	//echo $managers["Код"]."<br />";
    $userID = 0;
    $filialID = 0;
	if(!empty($managers["Email"])){
		$rsUsers = CUser::GetList(($by = "NAME"), ($order = "desc"), array('=EMAIL' => $managers["Email"]));
		while ($arUser = $rsUsers->Fetch()) {		
            $userID = $arUser["ID"];
			//echo "!Есть в БД - ".$arUser["EMAIL"]."<br /><br />";
		}
        
        // филиал
        $arSelect = Array("ID", "IBLOCK_ID", "PROPERTY_FILIAL_CODE");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
        $arFilter = Array(
                        "IBLOCK_ID"=>6,
                        "PROPERTY_FILIAL_CODE" => $managers["ЦФО"] 
                    );
        $resProduct = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
        if($ob = $resProduct->GetNextElement()){ 
            $arFields = $ob->GetFields(); 
            $filialID = $arFields["ID"];
        }  
        if(!empty($filialID)){
            if(empty($userID)){ // добавляем
                $new_password = randString(7);
                $user = new CUser;
                $arFields = Array(              
                  "LAST_NAME"         => $managers["ФИО"],  // Фамилия  
                  "EMAIL"             => $managers["Email"],      // E-mail
                  "LOGIN"             => $managers["Email"],      // Логин
                  "LID"               => "ru",                    // Сайт  
                  "ACTIVE"            => "Y",                     // Активность  
                  "GROUP_ID"          => array(5,8),            // Группы  
                  "PASSWORD"          => $new_password,           // Пароль  
                  "CONFIRM_PASSWORD"  => $new_password,           // Подтверждение пароля  
                  "WORK_PHONE"        => $managers["Телефон"],      // Телефон  
                  "UF_USER_CODE"      => $managers["Код"],        // код пользователя
                  "UF_FILIAL_CODE"    => $managers["ЦФО"],         // код филиала
                  "UF_FILIAL"         => $filialID                // id филиала
                );
                
           	//echo "<pre>";
			//print_r($arFields);
			//echo "</pre>";
                $newUserID = $user->Add($arFields);
                if (!intval($newUserID) > 0){
                     echo $user->LAST_ERROR;
                }
            }else{ // редактируем
                $user = new CUser;
                $fields = Array(
                  "LAST_NAME"         => $managers["ФИО"],
                  "EMAIL"             => $managers["Email"],
                  "LOGIN"             => $managers["Email"],
                  "LID"               => "ru",
                  "ACTIVE"            => "Y",
                  "GROUP_ID"          => array(5,8),
                  "WORK_PHONE"        => $managers["Телефон"],      // Телефон  
                  "UF_USER_CODE"      => $managers["Код"],        // код пользователя
                  "UF_FILIAL_CODE"    => $managers["ЦФО"],         // код филиала
                  "UF_FILIAL"         => $filialID                // id филиала
                  );
                if(!$user->Update($userID, $fields)){
                    echo $user->LAST_ERROR;
                }
                
            }
        }else{
            echo "<p>".$managers["ФИО"]." - Филиал не найден!</p>";
        }
	}else{
	   echo "<p>".$managers["ФИО"]." - Поле Email - не заполнено!</p>";
	}
}



require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");
?>