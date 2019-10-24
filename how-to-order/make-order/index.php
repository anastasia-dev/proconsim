<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Оформить заказ инженерного и сантехнического оборудования на нашем сайте очень просто. Для экономии времени Вы можете связаться с нами с помощью контактной формы на данной странице.");
$APPLICATION->SetTitle("Оформить заказ");
?><p>
 <strong><span style="font-size: 12pt;">Сделать заказ различного </span></strong><strong><span style="font-size: 12pt;">сантехнического </span></strong><strong><span style="font-size: 12pt;">обо</span></strong><strong><span style="font-size: 12pt;">рудования на сайте очень просто:</span></strong><span style="font-size: 12pt;"> </span>
</p>
<span style="font-size: 12pt;"> </span>
<p>
	<span style="font-size: 12pt;"> </span><strong><span style="font-size: 12pt;"> </span></strong><span style="font-size: 12pt;"> </span>
</p>
<span style="font-size: 12pt;"> </span>
<p>
	<span style="font-size: 12pt;"> </span><b><span style="font-size: 12pt;">1.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></b><b><span style="font-size: 12pt;">Найти необходимый товар по каталогу;</span></b><span style="font-size: 12pt;"> </span>
</p>
<span style="font-size: 12pt;"> </span>
<p>
	<span style="font-size: 12pt;"> </span><b><span style="font-size: 12pt;">2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></b><b><span style="font-size: 12pt;">Отправить выбранный товар в корзину;</span></b><span style="font-size: 12pt;"> </span>
</p>
<span style="font-size: 12pt;"> </span>
<p>
	<span style="font-size: 12pt;"> </span><b><span style="font-size: 12pt;">3.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></b><b><span style="font-size: 12pt;">Оформить заказ, пройдя простую регистрацию.</span></b><span style="font-size: 12pt;"> </span>
</p>
<span style="font-size: 12pt;"> </span>
<p>
	<span style="font-size: 12pt;"> </span><b><span style="font-size: 12pt;">4.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></b><b><span style="font-size: 12pt;">Подбор товара по вашей спецификации, смете.</span></b><span style="font-size: 12pt;"> </span>
</p>
<span style="font-size: 12pt;"> </span>

<?$APPLICATION->SetAdditionalCSS("/bitrix/templates/prok/components/proc/main.register/registr-new/style.css");?>
<?include_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/classes/general/captcha.php");
	$cpt = new CCaptcha();
	$captchaPass = COption::GetOptionString("main", "captcha_password", "");
	if(strlen($captchaPass) <= 0)
	{
	    $captchaPass = randString(10);
	    COption::SetOptionString("main", "captcha_password", $captchaPass);
	}
	$cpt->SetCodeCrypt($captchaPass);

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
        
  
    if(!$APPLICATION->CaptchaCheckCode($_POST["captcha_word"], $_POST["captcha_code"]))
	{
    // Неправильное значение
        $myErrors["CAPTCHA"] = "Код не совпадает";
	}



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
                    $isSend = "Ваш запрос успешно отправлен! В ближайшее время с Вами свяжется наш менеджер.<script> setTimeout(function() {
		ingEvents.dataLayerPush('dataLayer', {'event': 'make-order'}); 
		}, 4000);</script>";
                }
	}


}
?>
<?
    echo "<div class=\"bx-authform\">\n";
echo "<p><strong>Мы хотим сэкономить ваше время!</strong></p>\n";
    echo "<p>С помощью данной формы вы можете отправить нам для расчета смету, список товаров, счет конкурента или другой имеющийся у вас документ и максимально быстро получить ответ по стоимости вашего заказа.</p>\n";
    echo "<form method=\"post\" class=\"not-send\" action=\"\" name=\"editform\" enctype=\"multipart/form-data\">\n";

    echo "<div class=\"bx-authform-formgroup-container\">\n";
    echo "<div class=\"bx-authform-label-container\">ФИО: <span class=\"bx-authform-starrequired\">*</span></div>\n";
    echo "<div class=\"bx-authform-input-container\">\n";
    echo "<input name=\"fio\" maxlength=\"255\" value=\"".(isset($_POST["fio"])?$_POST["fio"]:"")."\" type=\"text\">\n";
    echo "</div>\n";
    echo "</div>\n";

    echo "<div class=\"bx-authform-formgroup-container\">\n";
    echo "<div class=\"bx-authform-label-container\">Контактный телефон: <span class=\"bx-authform-starrequired\">*</span></div>\n";
    echo "<div class=\"bx-authform-input-container\">\n";
    echo "<input name=\"phone\" maxlength=\"255\" value=\"".(isset($_POST["phone"])?$_POST["phone"]:"")."\" type=\"text\">\n";
    echo "</div>\n";
    echo "</div>\n";

    echo "<div class=\"bx-authform-formgroup-container\">\n";
    echo "<div class=\"bx-authform-label-container\">E-mail: <span class=\"bx-authform-starrequired\">*</span></div>\n";
    echo "<div class=\"bx-authform-input-container\">\n";
    echo "<input name=\"email\" maxlength=\"255\" value=\"".(isset($_POST["email"])?$_POST["email"]:"")."\" type=\"text\">\n";
    echo "</div>\n";
    echo "</div>\n";

    echo "<div class=\"bx-authform-formgroup-container\">\n";
    echo "<div class=\"bx-authform-label-container\">Организация</div>\n";
    echo "<div class=\"bx-authform-input-container\">\n";
    echo "<input name=\"company\" maxlength=\"255\" value=\"".(isset($_POST["company"])?$_POST["company"]:"")."\" type=\"text\">\n";
    echo "</div>\n";
    echo "</div>\n";

    echo "<div class=\"bx-authform-formgroup-container\">\n";
    echo "<div class=\"bx-authform-label-container\">Комментарий</div>\n";
    echo "<div class=\"bx-authform-input-container\">\n";    
    echo "<textarea cols=\"30\" rows=\"5\" name=\"comment\" class=\"register-form\">".(isset($_POST["comment"])?$_POST["comment"]:"")."</textarea>\n";
    echo "</div>\n";
    echo "</div>\n";

    echo "<div class=\"bx-authform-formgroup-container\">\n";
echo "<div class=\"bx-authform-label-container\"><b>Загрузите спецификацию, смету, счет конкурента</b> <span class=\"bx-authform-starrequired\">*</span><br />Файл не более 10Мб (XLS, DOC, PDF, JPG, TIFF, PNG)</div>\n";
    echo "<div class=\"bx-authform-input-container\">\n";
    echo "<input name=\"account\" maxlength=\"255\" value=\"\" type=\"file\">\n";
    echo "</div>\n";
    echo "</div>\n";

    echo "<div class=\"bx-authform-formgroup-container\">\n";
echo "<div class=\"bx-authform-label-container\"><b>Загрузите реквизиты</b><br />Файл не более 10Мб (XLS, DOC, PDF, JPG, TIFF, PNG)</div>\n";
    echo "<div class=\"bx-authform-input-container\">\n";
    echo "<input name=\"requisites\" maxlength=\"255\" value=\"\" type=\"file\">\n";
    echo "</div>\n";
    echo "</div>\n";
?>
		<input type="hidden" name="captcha_code" value="<?=htmlspecialchars($cpt->GetCodeCrypt());?>" />

		<div class="bx-authform-formgroup-container">
			<div class="bx-authform-label-container">
				<span class="bx-authform-starrequired">*</span>Введите код
			</div>
			<div class="bx-captcha"><img src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialchars($cpt->GetCodeCrypt());?>" width="180" height="40" alt="CAPTCHA" /></div>
			<div class="bx-authform-input-container">
				<input type="text" name="captcha_word" maxlength="50" value="" autocomplete="off"/>
			</div>
		</div>

<?
    echo "<input type=\"submit\" class=\"btn-view btn-blue\" name=\"register_submit_button\" value=\"Отправить\" />\n";
	echo "</form>\n";
    echo "<p>Отправляя данные, Вы принимаете условия <a href=\"/agreement/\" target=\"_blank\">Пользовательского соглашения</a>.</p>\n";
    if(!empty($isSend)){
        echo "<p>".$isSend."</p>";
    }
	echo "</div>\n";
?>

<p>
	<span style="font-size: 12pt;"> </span><strong><span style="font-size: 12pt;">После регистрации на сайте вы можете пользоваться личным кабинетом и значительно ускорить процесс оформления последующих заказов. </span></strong>
</p><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>