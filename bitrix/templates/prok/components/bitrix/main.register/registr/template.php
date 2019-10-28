<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();
?>
<div class="bx-auth-reg">

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
<div style="display: none;">
<input size="30" type="text" name="REGISTER[LOGIN]" value="123654" />
<input size="30" type="password" name="REGISTER[PASSWORD]" value="123456" autocomplete="off" class="bx-auth-input" />
<input size="30" type="password" name="REGISTER[CONFIRM_PASSWORD]" value="123456" autocomplete="off" />
</div>
		
		
		
		
				
<div class="form-group">
	<label for="">Название организации: *</label> 
	<input size="30" type="text" class="input_box"  name="REGISTER[WORK_COMPANY]" value="" />
</div>
	<div class="fields string" id="main_UF_INN">			<div class="fields string form-group">
 <label for="">ИНН:*</label> 
	<input type="text" class="input_box" name="UF_INN" value="" size="20" class="fields string"></div>
				</div>
				<div class="form-group">
 <label for="">Телефон:*</label> 
 <input size="30" type="text" class="input_box" name="REGISTER[WORK_PHONE]" value="" />
				</div>
				<div class="form-group">
 <label for="">E-mail:*</label> 
 <input  class="input_box" size="30" type="text" name="REGISTER[EMAIL]" value="" />
				</div>
				<div class="form-group">
 <label for="">Контактное лицо:*</label>
<input class="input_box" size="30" type="text" name="REGISTER[TITLE]" value="" />
				</div>
				<div class="form-group">
 <label for="">Адрес доставки:*</label> 
 <input size="30" type="text" name="REGISTER[WORK_STREET]" value="" />
				</div>
				<div class="form-group">
 <label for="">Способ доставки:*</label> <input class="input_box" type="text">
				</div>
				<div class="form-group">
 <label for="">Комментарий к заказу:</label>
 <textarea cols="30" rows="5" name="REGISTER[WORK_NOTES]" class="textarea_box"></textarea>
				</div>
			
				
				


	<div class="form-group kapcha">
<?
/* CAPTCHA */
if ($arResult["USE_CAPTCHA"] == "Y")
{
	?>
	<label for=""><?=GetMessage("REGISTER_CAPTCHA_TITLE")?></label>
		<input class="input_box" type="text" name="captcha_word" maxlength="50" value="" />
		<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
		<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />

	
	<?
}
/* !CAPTCHA */
?>
<p>
	<?=GetMessage('AUTH_REQ')?>
</p>
</div>
<input type="submit" class="btn-view btn-blue" name="register_submit_button" value="<?=GetMessage("AUTH_REGISTER")?>" />

</form>
<?endif?>
</div>