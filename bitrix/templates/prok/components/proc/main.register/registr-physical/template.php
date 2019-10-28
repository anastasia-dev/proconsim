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
	<?if (CSite::InGroup(array(12))){?>
		<p>Вы авторизованы.</p>
	<p><a href="/personal/physical/">Личный кабинет физического лица.</a></p>
	<?}else{?>
	<p>Ваша заявка будет рассмотрена нашими сотрудниками в ближайшее время.</p>
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
<?CJSCore::Init(['masked_input']);?>
<form method="post" class="not-send" action="<?=POST_FORM_ACTION_URI?>" name="regform" enctype="multipart/form-data">
<?
if($arResult["BACKURL"] <> ''):
?>
	<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
<?
endif;
?>

	<input id="login" size="30" type="hidden" name="REGISTER[LOGIN]" value="<? if(!empty($arResult["VALUES"]["LOGIN"])){ echo $arResult["VALUES"]["LOGIN"]; }else{ echo "123456";}?>" />    
    <input type="hidden" name="group_id" value="12">
		
		
		
<div class="bx-authform-formgroup-container">
			<div class="bx-authform-label-container">Фамилия: <span class="bx-authform-starrequired">*</span></div>
			<div class="bx-authform-input-container">
				<input name="REGISTER[LAST_NAME]" maxlength="255" value="<?=$arResult["VALUES"]["LAST_NAME"]?>" type="text">
			</div>
</div>				
<div class="bx-authform-formgroup-container">
			<div class="bx-authform-label-container">Имя: <span class="bx-authform-starrequired">*</span></div>
			<div class="bx-authform-input-container">
				<input name="REGISTER[NAME]" maxlength="255" value="<?=$arResult["VALUES"]["NAME"]?>" type="text">
			</div>
</div>	
<div class="bx-authform-formgroup-container">
			<div class="bx-authform-label-container">Телефон: <span class="bx-authform-starrequired">*</span></div>
			<div class="bx-authform-input-container">
				<input id="phone" name="REGISTER[PERSONAL_PHONE]" maxlength="255" value="<?=$arResult["VALUES"]["PERSONAL_PHONE"]?>" type="text" placeholder="Укажите ваш телефон">
			</div>
</div>	
<div class="bx-authform-formgroup-container">
			<div class="bx-authform-label-container">E-mail (служит логином для входа в личный кабинет): <span class="bx-authform-starrequired">*</span></div>
			<div class="bx-authform-input-container">
				<input name="REGISTER[EMAIL]" maxlength="255" value="<?=$arResult["VALUES"]["EMAIL"]?>" type="text">
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
			<input type="checkbox" name="agrreement" value="1" <?if(isset($_REQUEST["agrreement"])){?>checked<?}?>>&nbsp;Я принимаю условия <a href="/agreement/">Пользовательского соглашения</a>
		</div>
</div>
<div class="bx-authform-formgroup-container" style="float: left;margin-bottom: 0;">
<input type="submit" class="btn-view btn-blue" name="register_submit_button" value="<?=GetMessage("AUTH_REGISTER")?>" />
</div>
<noindex>
			<div class="bx-authform-link-container" style="float: left;margin-left: 50px;margin-bottom: 0;">
				<a href="/forgot-password/" rel="nofollow"><b>Забыли свой пароль?</b></a>
			</div>
</noindex>
	<div style="clear:both;"></div>
</form>

<br /><br />
<b>Возможности Личного Кабинета:</b><br />
Формирование заказов на сайте компании, история отгрузок, график платежей по отгрузкам с отсрочкой платежа, кредитный лимит, баланс, форма связи с менеджером и т.д.

<?endif?>
</div>
</div>

<script>
    BX.ready(function() {
        var result = new BX.MaskedInput({
            mask: '+7 (999) 999-99-99', // устанавливаем маску
            input: BX('phone'),
            placeholder: '_' // символ замены +7 ___ ___ __ __
        });

        result.setValue('_________________'); // устанавливаем значение
    });
</script>