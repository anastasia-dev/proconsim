<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Профиль");
?>
<?$APPLICATION->SetAdditionalCSS("/bitrix/templates/prok/components/proc/main.register/registr-new/style.css");?>
<?if ($USER->IsAuthorized()){
    $rsUser = CUser::GetByID($USER->GetID());
    $arUser = $rsUser->Fetch();
    //echo "<pre>"; print_r($_POST); echo "</pre>";
    echo "<div class=\"bx-authform\">\n";
    $send =0;
    $change = "";
    if($_POST){
        if($_POST["form_type"]=="update"){
            $filial = "";
            $managerEmail = "support@procsales.freshdesk.com";
            $myErrors = array(); 
            if(empty($_POST["LOGIN"])){
                $myErrors["LOGIN"] = "Поле \"Логин\" обязательно для заполнения";
            }
            if(empty($_POST["NAME"])){
                $myErrors["NAME"] = "Поле \"Имя\" обязательно для заполнения";
            }
            if(empty($_POST["LAST_NAME"])){
        		$myErrors["LAST_NAME"] = "Поле \"Фамилия\" обязательно для заполнения";
        	}
            if(empty($_POST["EMAIL"])){    		
                $myErrors["EMAIL"] = "Поле \"E-mail\" обязательно для заполнения";
        	}       
        	if(empty($_POST["WORK_COMPANY"])){    		
                $myErrors["WORK_COMPANY"] = "Поле \"Название организации\" обязательно для заполнения";
        	}
        	if(empty($_POST["UF_INN"])){    		
                $myErrors["UF_INN"] = 'Поле "ИНН" обязательно для заполнения';
        	}
        	if(empty($_POST["WORK_PHONE"])){    		
                $myErrors["WORK_PHONE"] = "Поле \"Телефон\" обязательно для заполнения";
        	}   	
        	if(empty($_POST["UF_FILIAL"])){    		
                $myErrors["UF_FILIAL"] = 'Поле "Желаемый филиал обслуживания" обязательно для заполнения';
        	}
        	if(empty($_POST["WORK_STREET"])){        		
                $myErrors["WORK_STREET"] = "Поле \"Адрес\" обязательно для заполнения";
        	}
        	if(!empty($myErrors)){
        	   ShowError(implode("<br />", $myErrors));
        	}else{
        	   if(!empty($_POST["UF_FILIAL"])){ 
        	       // филиал               
                   $res = CIBlockElement::GetByID($_POST["UF_FILIAL"]);
                    if($ar_res = $res->GetNext())
                      $filial = $ar_res["NAME"];  
               }
               //Менеджер
                if(!empty($arUser["UF_MANAGER_ID"])){
                        $rsManagers = CUser::GetList(($by = "NAME"), ($order = "desc"), array('ID' => $arUser["UF_MANAGER_ID"]));
                		$arManager = $rsManagers->Fetch();	
                        //echo "<pre>"; print_r($arManager); echo "</pre>";	
                        $managerEmail = $arManager["EMAIL"];
                }
                $arSendFields = array(   
                                        "USER_ID" => $USER->GetID(),
                                        "LOGIN" => $_POST["LOGIN"],                                    								
                                        "NAME" => $_POST["NAME"], 
                                        "SECOND_NAME" => $_POST["SECOND_NAME"], 
                                        "LAST_NAME" => $_POST["LAST_NAME"],                             
        								"EMAIL"  => $_POST["EMAIL"],
                                        "PERSONAL_MOBILE"  => $_POST["PERSONAL_MOBILE"],
                                        "WORK_PHONE" => $_POST["WORK_PHONE"],
                                        "WORK_COMPANY" => $_POST["WORK_COMPANY"], 
                                        "INN" => $_POST["UF_INN"],
                                        "WORK_PROFILE" => $_POST["WORK_PROFILE"],                                     
                                        "FILIAL"  => $filial, 
                                        "WORK_STREET" => $_POST["WORK_STREET"],
                                        "MANAGER_EMAIL" => $managerEmail 
                                 	); 
               //echo "<pre>2";
       		    //print_r($arSendFields);
       		    //echo "</pre>";   
                $send = CEvent::Send("USER_CHANGE_INFO", "s1", $arSendFields, "N", 65);
                    
        	}
        }
        if($_POST["form_type"]=="change"){
            $myErrors = array(); 
            if(empty($_POST["NEW_PASSWORD"])){
                $myErrors["NEW_PASSWORD"] = "Поле \"Новый пароль\" обязательно для заполнения";
            }
            if(empty($_POST["NEW_PASSWORD_CONFIRM"])){
                $myErrors["NEW_PASSWORD_CONFIRM"] = "Поле \"Подтверждение нового пароля\" обязательно для заполнения";
            }
            if($_POST["NEW_PASSWORD"]!==$_POST["NEW_PASSWORD_CONFIRM"]){
                $myErrors["PASSWORD"] = "Пароли не совпадают";
            }
            if(strlen($_POST["NEW_PASSWORD"])<6){
                $myErrors["PASSWORD"] = "Пароль должен быть не менее 6 символов длиной.";
            }
            if(!empty($myErrors)){
        	   ShowError(implode("<br />", $myErrors));
        	}else{
 	             $user = new CUser;
                 $fields = Array(
                              "LID"               => "ru",
                              "PASSWORD"          => $_POST["NEW_PASSWORD"],                  
                              "CONFIRM_PASSWORD"  => $_POST["NEW_PASSWORD_CONFIRM"]
                 ); 
                 if(!$user->Update($USER->GetID(), $fields)){
                        echo $user->LAST_ERROR;
                 }else{
                    $change = "Пароль изменен.";
                 }
        	}
        }    
    }
    
    
    echo "<div>Дата регистрации: ".$arUser["DATE_REGISTER"]."</div>";
    echo "<div>Дата последней авторизации: ".$arUser["LAST_LOGIN"]."</div>";
    echo "<form method=\"post\" class=\"not-send\" action=\"\" name=\"editform\" enctype=\"multipart/form-data\">\n";
    echo "<input type=\"hidden\" name=\"form_type\" value=\"update\">\n";
    echo "<div class=\"bx-authform-formgroup-container\">\n";
    echo "<div class=\"bx-authform-label-container\">Логин: <span class=\"bx-authform-starrequired\">*</span></div>\n";
    echo "<div class=\"bx-authform-input-container\">\n";
    echo "<input name=\"LOGIN\" maxlength=\"255\" value=\"".(isset($_POST["LOGIN"])?$_POST["LOGIN"]:$arUser["LOGIN"])."\" type=\"text\">\n";
    echo "</div>\n";
    echo "</div>\n";
    
    echo "<div class=\"bx-authform-formgroup-container\">\n";
    echo "<div class=\"bx-authform-label-container\">Имя: <span class=\"bx-authform-starrequired\">*</span></div>\n";
    echo "<div class=\"bx-authform-input-container\">\n";
    echo "<input name=\"NAME\" maxlength=\"255\" value=\"".(isset($_POST["NAME"])?$_POST["NAME"]:$arUser["NAME"])."\" type=\"text\">\n";
    echo "</div>\n";
    echo "</div>\n";
    
    echo "<div class=\"bx-authform-formgroup-container\">\n";
    echo "<div class=\"bx-authform-label-container\">Отчество:</div>\n";
    echo "<div class=\"bx-authform-input-container\">\n";
    echo "<input name=\"SECOND_NAME\" maxlength=\"255\" value=\"".(isset($_POST["SECOND_NAME"])?$_POST["SECOND_NAME"]:$arUser["SECOND_NAME"])."\" type=\"text\">\n";
    echo "</div>\n";
    echo "</div>\n";
    
    echo "<div class=\"bx-authform-formgroup-container\">\n";
    echo "<div class=\"bx-authform-label-container\">Фамилия: <span class=\"bx-authform-starrequired\">*</span></div>\n";
    echo "<div class=\"bx-authform-input-container\">\n";
    echo "<input name=\"LAST_NAME\" maxlength=\"255\" value=\"".(isset($_POST["LAST_NAME"])?$_POST["LAST_NAME"]:$arUser["LAST_NAME"])."\" type=\"text\">\n";
    echo "</div>\n";
    echo "</div>\n";
    
    echo "<div class=\"bx-authform-formgroup-container\">\n";
    echo "<div class=\"bx-authform-label-container\">E-mail: <span class=\"bx-authform-starrequired\">*</span></div>\n";
    echo "<div class=\"bx-authform-input-container\">\n";
    echo "<input name=\"EMAIL\" maxlength=\"255\" value=\"".(isset($_POST["EMAIL"])?$_POST["EMAIL"]:$arUser["EMAIL"])."\" type=\"text\">\n";
    echo "</div>\n";
    echo "</div>\n";
    
    echo "<div class=\"bx-authform-formgroup-container\">\n";
    echo "<div class=\"bx-authform-label-container\">Мобильный телефон:</div>\n";
    echo "<div class=\"bx-authform-input-container\">\n";
    echo "<input name=\"PERSONAL_MOBILE\" maxlength=\"255\" value=\"".(isset($_POST["PERSONAL_MOBILE"])?$_POST["PERSONAL_MOBILE"]:$arUser["PERSONAL_MOBILE"])."\" type=\"text\">\n";
    echo "</div>\n";
    echo "</div>\n";
    
    echo "<div class=\"bx-authform-formgroup-container\">\n";
    echo "<div class=\"bx-authform-label-container\">Название организации: <span class=\"bx-authform-starrequired\">*</span></div>\n";
    echo "<div class=\"bx-authform-input-container\">\n";
    echo "<input name=\"WORK_COMPANY\" maxlength=\"255\" value=\"".(isset($_POST["WORK_COMPANY"])?$_POST["WORK_COMPANY"]:$arUser["WORK_COMPANY"])."\" type=\"text\">\n";
    echo "</div>\n";
    echo "</div>\n";			
    
    echo "<div class=\"bx-authform-formgroup-container\">\n";
    echo "<div class=\"bx-authform-label-container\">ИНН: <span class=\"bx-authform-starrequired\">*</span></div>\n";
    echo "<div class=\"bx-authform-input-container\">\n";
    echo "<input name=\"UF_INN\" maxlength=\"255\" value=\"".(isset($_POST["UF_INN"])?$_POST["UF_INN"]:$arUser["UF_INN"])."\" type=\"text\">\n";
    echo "</div>\n";
    echo "</div>\n";
    
    echo "<div class=\"bx-authform-formgroup-container\">\n";
    echo "<div class=\"bx-authform-label-container\">Телефон: <span class=\"bx-authform-starrequired\">*</span></div>\n";
    echo "<div class=\"bx-authform-input-container\">\n";
    echo "<input name=\"WORK_PHONE\" maxlength=\"255\" value=\"".(isset($_POST["WORK_PHONE"])?$_POST["WORK_PHONE"]:$arUser["WORK_PHONE"])."\" type=\"text\">\n";
    echo "</div>\n";
    echo "</div>\n";
    
    echo "<div class=\"bx-authform-formgroup-container\">\n";
    echo "<div class=\"bx-authform-label-container\">Сфера деятельности компании:</div>\n";
    echo "<div class=\"bx-authform-input-container\">\n";
    echo "<input name=\"WORK_PROFILE\" maxlength=\"255\" value=\"".(isset($_POST["WORK_PROFILE"])?$_POST["WORK_PROFILE"]:$arUser["WORK_PROFILE"])."\" type=\"text\">\n";
    echo "</div>\n";
    echo "</div>\n";
    
    
    $arUserField = array(
    "ID" => 47,
    "ENTITY_ID" => "USER",
    "FIELD_NAME" => "UF_FILIAL",
    "USER_TYPE_ID" => "iblock_element",
    "SORT" => 100,
    "MULTIPLE" => "N",
    "MANDATORY" => "N",
    "SHOW_FILTER" => "N",
    "EDIT_IN_LIST" => "Y",
    "IS_SEARCHABLE" => "N",
    "SETTINGS" => Array
        (
            "DISPLAY" => "LIST",
            "LIST_HEIGHT" => 1,
            "IBLOCK_ID" => 6,
            "DEFAULT_VALUE" => 439,
            "ACTIVE_FILTER" => "Y"
        ),
    "EDIT_FORM_LABEL" => "Филиал",
    "LIST_COLUMN_LABEL" => "Филиал",
    "LIST_FILTER_LABEL" => "Филиал",
    "ERROR_MESSAGE" => "Филиал",
    "HELP_MESSAGE" => "Филиал",
    "USER_TYPE" => Array
        (
            "USER_TYPE_ID" => "iblock_element",
            "CLASS_NAME" => "CUserTypeIBlockElement",
            "DESCRIPTION" => "Привязка к элементам инф. блоков",
            "BASE_TYPE" => "int"
        ),
    "VALUE" => (isset($_POST["UF_FILIAL"])?$_POST["UF_FILIAL"]:$arUser["UF_FILIAL"]),
    "~EDIT_FORM_LABEL" => "Филиал"   
    );
    if(!empty($arUser["UF_FILIAL"]) || isset($_POST["UF_FILIAL"])){
        $arUserField["ENTITY_VALUE_ID"] = 1;
    }
    echo "<div class=\"bx-authform-formgroup-container\">\n";
    echo "<div class=\"bx-authform-label-container\">Желаемый филиал обслуживания: <span class=\"bx-authform-starrequired\">*</span></div>\n";
    echo "<div class=\"bx-authform-input-container\">\n";    
    $APPLICATION->IncludeComponent(
	"bitrix:system.field.edit",
	$arUserField["USER_TYPE"]["USER_TYPE_ID"],
	array(
		"bVarsFromForm" => "",
		"arUserField" => $arUserField,
		"form_name" => "bform"
	),
	null,
	array("HIDE_ICONS"=>"Y")
);
    echo "</div>\n";
    echo "</div>\n";
        
    echo "<div class=\"bx-authform-formgroup-container\">\n";
    echo "<div class=\"bx-authform-label-container\">Адрес: <span class=\"bx-authform-starrequired\">*</span></div>\n";
    echo "<div class=\"bx-authform-input-container\">\n";    
    echo "<textarea cols=\"30\" rows=\"5\" name=\"WORK_STREET\" class=\"register-form\">".(isset($_POST["WORK_STREET"])?$_POST["WORK_STREET"]:$arUser["WORK_STREET"])."</textarea>\n";
    echo "</div>\n";
    echo "</div>\n";
    echo "<input type=\"submit\" class=\"btn-view btn-blue\" name=\"register_submit_button\" value=\"Отправить\" />\n";

    echo "</form>\n";
    
    if(!empty($send)){
        echo "<p>Сообщение отправлено менеджеру.</p>";
    }
    
    echo "<br /><br /><form method=\"post\" class=\"not-send\" action=\"\" name=\"passform\" enctype=\"multipart/form-data\">\n";
    echo "<input type=\"hidden\" name=\"form_type\" value=\"change\">\n";
    echo "<div class=\"bx-authform-formgroup-container\">\n";
    echo "<div class=\"bx-authform-label-container\">Новый пароль: <span class=\"bx-authform-starrequired\">*</span></div>\n";
    echo "<div class=\"bx-authform-input-container\">\n";
    echo "<input name=\"NEW_PASSWORD\" maxlength=\"255\" value=\"".(isset($_POST["NEW_PASSWORD"])?$_POST["NEW_PASSWORD"]:"")."\" type=\"password\">\n";
    echo "</div>\n";
    echo "</div>\n";
    
    echo "<div class=\"bx-authform-formgroup-container\">\n";
    echo "<div class=\"bx-authform-label-container\">Подтверждение нового пароля: <span class=\"bx-authform-starrequired\">*</span></div>\n";
    echo "<div class=\"bx-authform-input-container\">\n";
    echo "<input name=\"NEW_PASSWORD_CONFIRM\" maxlength=\"255\" value=\"".(isset($_POST["NEW_PASSWORD_CONFIRM"])?$_POST["NEW_PASSWORD_CONFIRM"]:"")."\" type=\"password\">\n";
    echo "</div>\n";
    echo "</div>\n";
    
    echo "<div class=\"bx-authform-description-container\">\n";
    echo "<p>Пароль должен быть не менее 6 символов длиной.</p>\n";
    echo "</div>\n";
    
    echo "<input type=\"submit\" class=\"btn-view btn-blue\" name=\"register_submit_button\" value=\"Изменить\" />\n";
    
    echo "</form>\n";
    if(!empty($change)){
        echo "<p>".$change."</p>";
    }
    echo "</div>\n";    
?>
<?}else{?>
    <div>Только для авторизованных пользователей.</div>
<?}?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>