<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Личный кабинет");
?>
<?
if ($USER->IsAuthorized()){
    $rsUser = CUser::GetByID($USER->GetID());
    $arUser = $rsUser->Fetch();
    //echo "<pre>"; print_r($arUser); echo "</pre>";
    
    if(!empty($arUser["UF_USER_CODE"])){
    require($_SERVER["DOCUMENT_ROOT"]."/personal/juridical/personal_top.php"); 
?>      
        		
        		
                                
        		<!-- Tab panes -->
        		<div class="tab-content">
                  
        		  <div class="tab-pane active" id="selection">
<?$APPLICATION->SetAdditionalCSS("/bitrix/templates/prok/components/proc/main.register/registr-new/style.css");?>
<?
if($_POST){

	//echo "<pre>";
	//print_r($_POST);
	//echo "</pre>";

	//echo "<pre>";
	//print_r($_FILES);
	//echo "</pre>";
    $myErrors = array(); 
    $fileSizeLimit = 1024 * 1024 * 10;
    $fileTypes =  array('png','jpg','jpeg','pdf','xls','xlsx','doc','docx','tiff');
    $uploaddir = $_SERVER["DOCUMENT_ROOT"].'/upload/selection/';
    $uploadRequisitesFile = "";
    $arSendFiles = array();
    $isSend = "";
    
    
    if(empty($_POST["fio"])){
        $myErrors["FIO"] = "Поле \"ФИО\" обязательно для заполнения";
    }
	if(empty($_POST["phone"])){
        $myErrors["PHONE"] = "Поле \"Контактный телефон\" обязательно для заполнения";
    }
	if(empty($_POST["email"])){
        $myErrors["EMAIL"] = "Поле \"E-mail\" обязательно для заполнения";
    }
	if($_FILES["account"]["error"]>0){
        $myErrors["ACCOUNT"] = "Поле \"Загрузите спецификацию, смету, счет конкурента\" обязательно для заполнения";
    }else{
        if($_FILES["account"]["size"]>$fileSizeLimit){
            $myErrors["ACCOUNT_SIZE"] = "Файл \"Загрузите спецификацию, смету, счет конкурента\". Превышен допустимый размер файла. Разрешены файлы не более 10Mb.";
        }
        $ext = pathinfo($_FILES["account"]["name"], PATHINFO_EXTENSION);
        if(!in_array($ext, $fileTypes)){
            $myErrors["ACCOUNT_TYPE"] = "Файл \"Загрузите спецификацию, смету, счет конкурента\". Прикрепить можно только файлы изображений (jpg, jpeg, png, tiff) и документов (pdf, xls, xlsx, doc, docx)";
        } 
        $uploadAccountFile = $uploaddir . basename($_FILES['account']['name']);
        //echo $uploadAccountFile;
        if(!move_uploaded_file($_FILES['account']['tmp_name'], $uploadAccountFile)){
            $myErrors["ACCOUNT_UPLOAD"] = "Ошибка загрузки файла ".$_FILES['account']['name'];
        }else{
            $arSendFiles[] = $uploadAccountFile;
        }
        
    }
    /*
    if(empty($_FILES["requisites"]["error"])){
        if($_FILES["requisites"]["size"]>$fileSizeLimit){
            $myErrors["REQUISITES_SIZE"] = "Файл \"Загрузите реквизиты\". Превышен допустимый размер файла. Разрешены файлы не более 10Mb.";
        }
        $ext = pathinfo($_FILES["requisites"]["name"], PATHINFO_EXTENSION);
        if(!in_array($ext, $fileTypes)){
            $myErrors["REQUISITES_TYPE"] = "Файл \"Загрузите реквизиты\". Прикрепить можно только файлы изображений (jpg, jpeg, png, tiff) и документов (pdf, xls, xlsx, doc, docx)";
        } 
        $uploadRequisitesFile = $uploaddir . basename($_FILES['requisites']['name']);
        //echo $uploadRequisitesFile;
        if(!move_uploaded_file($_FILES['requisites']['tmp_name'], $uploadRequisitesFile)){
            $myErrors["REQUISITES_UPLOAD"] = "Ошибка загрузки файла ".$_FILES['requisites']['name'];
        }else{
            $arSendFiles[] = $uploadRequisitesFile;
        }
    }
    */
 
    if(!empty($myErrors)){
       ShowError(implode("<br />", $myErrors));
    }else{
                $arSendFields = array(
                                        "FIO" => $_POST["fio"],                                    								
                                        "PHONE" => $_POST["phone"], 
        								"EMAIL"  => $_POST["email"],
                                        "COMPANY"  => $_POST["company"],
                                        "COMMENT" => $_POST["comment"],
                                 	); 
                //echo "<pre>2";
       		    //print_r($arSendFields);
       		    //echo "</pre>";   
		        $send = CEvent::Send("SELECTION_INFO", "s1", $arSendFields, "N", 66, $arSendFiles);
                if($send){
                    // удаляем файлы
                    foreach($arSendFiles as $delFile){
                        unlink($delFile);
                    }
                    $isSend = "Ваш запрос успешно отправлен! В ближайшее время с Вами свяжется наш менеджер.";
                }
	}


}
?>
<?
    echo "<div class=\"bx-authform\">\n";
    echo "<p><strong>Мы хотим сэкономить ваше время!</strong></p>\n";
    echo "<p>С помощью данной формы вы можете отправить нам для расчета смету, список товаров, счет конкурента или другой имеющийся у вас документ и максимально быстро получить ответ по стоимости вашего заказа.</p>\n";
    echo "<form method=\"post\" class=\"not-send\" name=\"editform\" enctype=\"multipart/form-data\">\n";
    
    echo "<input name=\"fio\" maxlength=\"255\" value=\"".$arUser["NAME"]." ".$arUser["SECOND_NAME"]." ".$arUser["LAST_NAME"]."\" type=\"hidden\">\n";
    echo "<input name=\"phone\" maxlength=\"255\" value=\"".$arUser["WORK_PHONE"]."\" type=\"hidden\">\n";
    echo "<input name=\"email\" maxlength=\"255\" value=\"".$arUser["EMAIL"]."\" type=\"hidden\">\n";
    echo "<input name=\"company\" maxlength=\"255\" value=\"".$arUser["WORK_COMPANY"]."\" type=\"hidden\">\n";
   
    echo "<div class=\"bx-authform-formgroup-container\">\n";
    echo "<div class=\"bx-authform-label-container\">Комментарий</div>\n";
    echo "<div class=\"bx-authform-input-container\">\n";    
    echo "<textarea cols=\"30\" rows=\"5\" name=\"comment\" class=\"register-form\">".(isset($_POST["comment"])?$_POST["comment"]:"")."</textarea>\n";
    echo "</div>\n";
    echo "</div>\n";

    echo "<div class=\"bx-authform-formgroup-container\">\n";
    echo "<div class=\"bx-authform-label-container\"><b>Загрузите спецификацию, смету, счет конкурента или <a href=\"/upload/docs/Заявка Проконсим_2018.xls\">заявку по шаблону</a></b> <span class=\"bx-authform-starrequired\">*</span><br />Файл не более 10Мб (XLS, DOC, PDF, JPG, TIFF, PNG)</div>\n";
    echo "<div class=\"bx-authform-input-container\">\n";
    echo "<input name=\"account\" maxlength=\"255\" value=\"\" type=\"file\">\n";
    echo "</div>\n";
    echo "</div>\n";
/*
    echo "<div class=\"bx-authform-formgroup-container\">\n";
    echo "<div class=\"bx-authform-label-container\"><b>Загрузите реквизиты</b><br />Файл не более 10Мб (XLS, DOC, PDF, JPG, TIFF, PNG)</div>\n";
    echo "<div class=\"bx-authform-input-container\">\n";
    echo "<input name=\"requisites\" maxlength=\"255\" value=\"\" type=\"file\">\n";
    echo "</div>\n";
    echo "</div>\n";
*/
    echo "<input type=\"submit\" class=\"btn-view btn-blue\" name=\"register_submit_button\" value=\"Отправить\" />\n";
	echo "</form>\n";
    echo "<p>Отправляя данные, Вы принимаете условия <a href=\"/agreement/\" target=\"_blank\">Пользовательского соглашения</a>.</p>\n";
    if(!empty($isSend)){
        echo "<p>".$isSend."</p>";
    }
	echo "</div>\n";
?>                  
                  </div>
                 	  
                </div>
        		
    <?
    require($_SERVER["DOCUMENT_ROOT"]."/personal/juridical/personal_footer.php");
    }else{?>
        <div>У вас нет доступа к Личному кабинету. Пожалуйста, <a href="/register/">зарегистрируйтесь</a>.</div>
    <?}?>
<?}else{?>
    <div>Только для авторизованных пользователей.</div>
<?}?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>