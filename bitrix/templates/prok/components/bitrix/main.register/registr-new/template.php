<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();
?>
<div class="bx-auth-reg">
	<div class="check-inn"></div>
<?if($USER->IsAuthorized()):?>

<p><?echo GetMessage("MAIN_REGISTER_AUTH")?></p>

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
<?$pass = \Bitrix\Main\Authentication\ApplicationPasswordTable::generatePassword();?>
<input size="30" type="hidden" name="REGISTER[PASSWORD]" value="<?=$pass?>" autocomplete="off" class="bx-auth-input" />
<input size="30" type="hidden" name="REGISTER[CONFIRM_PASSWORD]" value="<?=$pass?>" autocomplete="off" />

		
		
		
		
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
			<div class="bx-authform-label-container">E-mail: <span class="bx-authform-starrequired">*</span></div>
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
			<div class="bx-authform-label-container">Адрес: <span class="bx-authform-starrequired">*</span></div>
			<div class="bx-authform-input-container">
				<textarea cols="30" rows="5" name="REGISTER[WORK_STREET]" class="register-form"><?=$arResult["VALUES"]["WORK_STREET"]?></textarea>
			</div>
</div>	

	<div class="form-group kapcha">
<?
/* CAPTCHA */
if ($arResult["USE_CAPTCHA"] == "Y")
{
	?>
	<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />

		<div class="bx-authform-formgroup-container">
			<div class="bx-authform-label-container">
				<span class="bx-authform-starrequired">*</span><?=GetMessage("CAPTCHA_REGF_PROMT")?>
			</div>
			<div class="bx-captcha"><img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" /></div>
			<div class="bx-authform-input-container">
				<input type="text" name="captcha_word" maxlength="50" value="" autocomplete="off"/>
			</div>
		</div>
	<?
}
/* !CAPTCHA */
?>
		<div class="bx-authform-description-container">
			<span class="bx-authform-starrequired">*</span><?=GetMessage("AUTH_REQ")?>
		</div>
</div>
<input type="submit" class="btn-view btn-blue" name="register_submit_button" value="<?=GetMessage("AUTH_REGISTER")?>" />

</form>
<?endif?>
</div>
<script>
  //задаём логин равный INN
  $().ready(function() {  
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
                        $("#inn").val('');
						$("#login").val(''); 
					}else{
                     $("#login").val(inn);  
					   }
                    },
                    error: function(response) { // Данные не отправлены
                            console.log(response); 
        					} 
             }); 





		});
	});  
  </script>