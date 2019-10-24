<?php
header("Content-Type: text/html; charset=utf-8");
require_once($_SERVER['DOCUMENT_ROOT'] ."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule('iblock');
$url = $_SERVER['DOCUMENT_ROOT'] ."/import/clients.xml";

$xml = simplexml_load_file($url);

$count=0;
//echo "<pre>1";
//print_r($xml);
//echo "</pre>";

foreach($xml as $clients)
{	
    $filialID =0;  
    $filial = ""; 
    $managerID =0;  
    $manager = "";
    $firstUpdate =0;    
    if(!empty($clients["CA_BitrixID"])){
        //Обновление
        $rsUserUp = CUser::GetList(($by = "NAME"), ($order = "desc"), array('ID' => $clients["CA_BitrixID"]), array("SELECT"=>array("UF_FIRST_UPDATE")));
		while ($arUserUp = $rsUserUp->Fetch()) {		
            $firstUpdate = $arUserUp["UF_FIRST_UPDATE"];			
		} 
       // филиал
        $arSelect = Array("ID", "IBLOCK_ID", "NAME", "PROPERTY_FILIAL_CODE");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
        $arFilter = Array(
                        "IBLOCK_ID"=>6,
                        "PROPERTY_FILIAL_CODE" => $clients["ЦФО"] 
                    );
        $resProduct = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
        if($ob = $resProduct->GetNextElement()){ 
            $arFields = $ob->GetFields(); 
            $filialID = $arFields["ID"];
            $filial = $arFields["NAME"];            
        } 
        //Менеджер
        $rsManagers = CUser::GetList(($by = "NAME"), ($order = "desc"), array('=UF_USER_CODE' => (string)$clients["МенеджерКод"]));
		while ($arUser = $rsManagers->Fetch()) {		
            $managerID = $arUser["ID"];
            $manager = $arUser["LAST_NAME"];
		} 
        if(!empty($filialID)){
             $user = new CUser;
             $fields = Array(
                          "LID"               => "ru",
                          "ACTIVE"            => "Y",                  
                          "WORK_PHONE"        => $clients["Телефон"],      // Телефон  
                          "WORK_COMPANY"      => $clients["Наименование"], 
                          "UF_USER_CODE"      => $clients["Код"],        // код пользователя
                          "UF_FILIAL_CODE"    => $clients["ЦФО"],         // код филиала
                          "UF_FILIAL"         => $filialID,                // id филиала
                          "UF_INN"            => $clients["ИНН"],
                          "UF_KPP"            => $clients["КПП"],
                          "UF_OGRN"           => $clients["ОГРН"],                              
                          "UF_KR_LIMIT"       => $clients["КР_ЛИМИТ"],
                          "UF_BALANCE"        => $clients["БАЛАНС"],
                          "UF_PDZ"            => $clients["ПДЗ"],
             ); 
             if(!empty($managerID)){
                $fields["UF_MANAGER_ID"] = $managerID;
             }
             if(empty($firstUpdate)){
                $fields["UF_FIRST_UPDATE"] = 1;
             }
            $sendName = ""; 
            foreach($clients->Контакт_ЛК as $lk){              
               $fields["LAST_NAME"] = $lk["Фамилия"];
               $fields["NAME"] = $lk["Имя"];
               $fields["SECOND_NAME"] = $lk["Отчество"];
               if(!empty($lk["Email"])){
                   $fields["EMAIL"] = $lk["Email"];
               }              
               $fields["PERSONAL_MOBILE"] = $lk["Моб_телефон"];
               if(!empty($lk["Имя"])){
                 $sendName .= $lk["Имя"]." ";
               }
               if(!empty($lk["Отчество"])){
                 $sendName .= $lk["Отчество"]." ";
               }
               if(!empty($lk["Фамилия"])){
                 $sendName .= " ".$lk["Фамилия"]." ";
               }
               if(!empty($sendName)){
                 $sendName= substr($sendName,0,-1);
               }
  	         }
                //echo "<pre>2";
        		//print_r($fields);
        		//echo "</pre>";      
                    if(!$user->Update($clients["CA_BitrixID"], $fields)){
                        echo $user->LAST_ERROR;
                    }else{
                        // отправка пиьсма
                        if(empty($firstUpdate)){
                                $arSendFields = array(                                       								
                                    "NAME" => $sendName,                             
    								"EMAIL"  => $fields["EMAIL"],
                                    "WORK_PHONE" => $fields["WORK_PHONE"],
                                    "WORK_COMPANY" => $fields["WORK_COMPANY"],
                                    "USER_CODE"  => $fields["UF_USER_CODE"],
                                    "FILIAL"  => $filial,
                                    "INN"  => $fields["UF_INN"],
                                    "KPP"  => $fields["UF_KPP"],
                                    "OGRN"  => $fields["UF_OGRN"],
                                    "KR_LIMIT"  => $fields["UF_KR_LIMIT"],
                                    "BALANCE"  => $fields["UF_BALANCE"],
                                    "PDZ"  => $fields["UF_PDZ"],
                                    "MANAGER"  => $manager,
                                    "PERSONAL_MOBILE"  => $fields["PERSONAL_MOBILE"]
                             	); 
                                //echo "<pre>2";
                        		//print_r($arSendFields);
                        		//echo "</pre>";   
                                $send = CEvent::Send("USER_FIRST_UPDATE", "s1", $arSendFields, "N", 63);                            
                        }
                    }  
       }else{
           echo "<p>".$clients["CA_BitrixID"]." - Филиал не найден!</p>";
       }               
    }
}



require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");
?>