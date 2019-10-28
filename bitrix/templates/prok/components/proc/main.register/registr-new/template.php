<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

//echo "<pre>";
//print_r($arResult);
//echo "</pre>";

?>
<div class="bx-authform">
<div class="bx-auth-reg">
	<div class="check-inn"></div>
<?if($USER->IsAuthorized()):?>
	<?if (CSite::InGroup(array(9))){?>
		<p>Вы являетесь партнером.</p>
	<p><a href="/personal/">Личный кабинет партнера.</a></p>
	<?}else{?>
	<p>Ваша заявка будет рассмотрена нашими сотрудниками в ближайшее время.</p>
	<script> setTimeout(function() {
		ingEvents.dataLayerPush('dataLayer', {'event': 'register'}); 
		}, 4000);</script>
	
	<?}?>
<?else:?>
<?
if (count($arResult["ERRORS"]) > 0):
	foreach ($arResult["ERRORS"] as $key => $error)
		if (intval($key) == 0 && $key !== 0) 
			$arResult["ERRORS"][$key] = str_replace("#FIELD_NAME#", "&quot;".GetMessage("REGISTER_FIELD_".$key)."&quot;", $error);

	ShowError(implode("<br />", $arResult["ERRORS"]));

elseif($arResult["USE_EMAIL_CONFIRMATION"] === "Y"):
?>
<p><?echo GetMessage("REGISTER_EMAIL_WILL_BE_SENT")?></p>
<?endif?>
<form method="post" class="not-send" action="<?=POST_FORM_ACTION_URI?>" name="regform" enctype="multipart/form-data">
<?
if($arResult["BACKURL"] <> ''):
?>
	<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
<?
endif;
?>

<p class="head">
	 <?=GetMessage("AUTH_REGISTER_HEAD")?>
</p>

	<input id="login" size="30" type="hidden" name="REGISTER[LOGIN]" value="<? if(!empty($arResult["VALUES"]["LOGIN"])){ echo $arResult["VALUES"]["LOGIN"]; }else{ echo "123456";}?>" />
    <input id="fcode" size="30" type="hidden" name="UF_FILIAL_CODE" value="<? if(!empty($arResult["VALUES"]["UF_FILIAL_CODE"])){ echo $arResult["VALUES"]["UF_FILIAL_CODE"]; }else{ echo "МОСКВА";}?>" />
    <input type="hidden" name="group_id" value="11">
		
		
		
<div class="bx-authform-formgroup-container">
			<div class="bx-authform-label-container">Название организации: <span class="bx-authform-starrequired">*</span></div>
			<div class="bx-authform-input-container">
				<input name="REGISTER[WORK_COMPANY]" maxlength="255" value="<?=$arResult["VALUES"]["WORK_COMPANY"]?>" type="text">
			</div>
</div>				
<div class="bx-authform-formgroup-container">
			<div class="bx-authform-label-container">ИНН: <span class="bx-authform-starrequired">*</span></div>
			<div class="bx-authform-input-container">
				<input id="inn" name="UF_INN" maxlength="255" value="<?=$arResult["VALUES"]["UF_INN"]?>" type="text">
			</div>
</div>	
<div class="bx-authform-formgroup-container">
			<div class="bx-authform-label-container">Телефон: <span class="bx-authform-starrequired">*</span></div>
			<div class="bx-authform-input-container">
				<input name="REGISTER[WORK_PHONE]" maxlength="255" value="<?=$arResult["VALUES"]["WORK_PHONE"]?>" type="text">
			</div>
</div>	
<div class="bx-authform-formgroup-container">
			<div class="bx-authform-label-container">E-mail (служит логином для входа в личный кабинет): <span class="bx-authform-starrequired">*</span></div>
			<div class="bx-authform-input-container">
				<input name="REGISTER[EMAIL]" maxlength="255" value="<?=$arResult["VALUES"]["EMAIL"]?>" type="text">
			</div>
</div>	
<div class="bx-authform-formgroup-container">
			<div class="bx-authform-label-container">Контактное лицо: <span class="bx-authform-starrequired">*</span></div>
			<div class="bx-authform-input-container">
				<input name="REGISTER[LAST_NAME]" maxlength="255" value="<?=$arResult["VALUES"]["LAST_NAME"]?>" type="text">
			</div>
</div>	
<div class="bx-authform-formgroup-container">
			<div class="bx-authform-label-container">Сфера деятельности компании:</div>
			<div class="bx-authform-input-container">
				<input name="REGISTER[WORK_PROFILE]" maxlength="255" value="<?=$arResult["VALUES"]["WORK_PROFILE"]?>" type="text">
			</div>
</div>
<div class="bx-authform-formgroup-container">
			<div class="bx-authform-label-container">Желаемый филиал обслуживания: <span class="bx-authform-starrequired">*</span></div>
			<div class="bx-authform-input-container">
<?
$arUserField = ($arResult["USER_PROPERTIES"]["DATA"]["UF_FILIAL"]); 
$APPLICATION->IncludeComponent(
	"bitrix:system.field.edit",
	$arUserField["USER_TYPE"]["USER_TYPE_ID"],
	array(
		"bVarsFromForm" => $arResult["bVarsFromForm"],
		"arUserField" => $arUserField,
		"form_name" => "bform"
	),
	null,
	array("HIDE_ICONS"=>"Y")
);
?>
			</div>
</div>	
<div class="bx-authform-formgroup-container">
			<div class="bx-authform-label-container">Адрес: <span class="bx-authform-starrequired">*</span></div>
			<div class="bx-authform-input-container">
				<textarea cols="30" rows="5" name="REGISTER[WORK_STREET]" class="register-form"><?=$arResult["VALUES"]["WORK_STREET"]?></textarea>
			</div>
</div>	
<div class="bx-authform-formgroup-container">
			<div class="bx-authform-label-container">Пароль: <span class="bx-authform-starrequired">*</span></div>
			<div class="bx-authform-input-container">
				<input name="REGISTER[PASSWORD]" maxlength="255" value="<?=$arResult["VALUES"]["PASSWORD"]?>" type="password">
			</div>
</div>	
<div class="bx-authform-formgroup-container">
			<div class="bx-authform-label-container">Подтверждение пароля: <span class="bx-authform-starrequired">*</span></div>
			<div class="bx-authform-input-container">
				<input name="REGISTER[CONFIRM_PASSWORD]" maxlength="255" value="<?=$arResult["VALUES"]["PASSWORD"]?>" type="password">
			</div>
</div>	

	<div class="form-group kapcha">
<?
/* CAPTCHA */
if ($arResult["USE_CAPTCHA"] == "Y")
{
	?>
	<div class="bx-authform-formgroup-container">
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <div class="g-recaptcha" data-sitekey="<?=RE_SITE_KEY?>"></div>
</div>
	<?
}
/* !CAPTCHA */
?>
		<div class="bx-authform-description-container">
			<span class="bx-authform-starrequired">*</span><?=GetMessage("AUTH_REQ")?>
            <p><?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?></p>
		</div>
        <div class="bx-authform-description-container">
			Отправляя данные, Вы принимаете условия <a href="/agreement/">Пользовательского соглашения</a>
		</div>
</div>
<input type="submit" class="btn-view btn-blue" name="register_submit_button" value="<?=GetMessage("AUTH_REGISTER")?>" />

</form>
<br /><br />        
<b>Примечание:</b><br />
Регистрация в личном кабинете возможна только для юридических лиц (ОАО, ПАО, ЗАО, ООО) и индивидуальных предпринимателей (ИП).<br />
Активация личного кабинета осуществляется в течение 24 часов с момента регистрации.

<br /><br />
<b>Возможности Личного Кабинета:</b><br />
Формирование заказов на сайте компании, история отгрузок, график платежей по отгрузкам с отсрочкой платежа, кредитный лимит, баланс, форма связи с менеджером и т.д.

<?endif?>
</div>
</div>
<script>  
  $().ready(function() { 
    //задаём логин равный INN
	 $("#inn").change( function() {
     $(".check-inn").html('');
     var inn = $("#inn").val();
 				$.ajax({  
                    async: false,
                    url: '<?=SITE_TEMPLATE_PATH?>/components/bitrix/main.register/registr-new/ajax_check_inn.php',  
                    type: "POST",
                    data: "inn="+inn,
                    success: function(data){       
					//console.log("data = "+data);

				if(data!="" && parseInt(data)>0){
					$(".check-inn").html('Организация с данным ИНН ( '+inn+' ) уже зарегистрирована на нашем сайте.<br />Пожалуйста, свяжитесь с нашими менеджерами для предоставления доступа.');
					//$("#inn").val('');
					//$("#login").val(''); 
					//}else{
					//$("#login").val(inn);  
					   }
                    },
                    error: function(response) { // Данные не отправлены
		 //console.log(response); 
        					} 
             }); 
    });
    //код филиала
    $("select[name=UF_FILIAL]").change( function() {
        var filialID = $(this).val();
		//console.log(filialID);
        if(filialID.length>0){ 
            $.ajax({  
                    async: false,
                    url: '<?=SITE_TEMPLATE_PATH?>/components/proc/main.register/registr-new/ajax_filial_code.php',
                    type: "POST",
                    data: "filialid="+filialID,
                    success: function(data){       
						//console.log("data = "+data);
						$("#fcode").val(data);
                    },
                    error: function(response) { // Данные не отправлены
				//console.log(response); 
        					} 
             }); 
    	}else{
           $('select[name=UF_FILIAL]').val("439"); 
           $("#fcode").val("МОСКВА");  
        }    
	});  
 });
  </script>