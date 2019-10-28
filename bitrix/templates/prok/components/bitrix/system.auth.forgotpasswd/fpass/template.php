<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$APPLICATION->SetAdditionalCSS("/bitrix/css/main/system.auth/flat/style.css");


ShowMessage($arParams["~AUTH_RESULT"]);

?>
 
<div class="bx-authform">
    <h3 class="bx-title"><?=GetMessage("AUTH_GET_CHECK_STRING")?></h3>

    <p class="bx-authform-content-container"><?=GetMessage("AUTH_FORGOT_PASSWORD_1")?></p>


    <form name="bform" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
<?
if (strlen($arResult["BACKURL"]) > 0)
{
?>
	<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
<?
}
?>
		<input type="hidden" name="AUTH_FORM" value="Y">
		<input type="hidden" name="TYPE" value="SEND_PWD">

		<div class="bx-authform-formgroup-container">
			<div class="bx-authform-label-container"><?=GetMessage("AUTH_LOGIN")?></div>
			<div class="bx-authform-input-container">
				<input type="text" name="USER_LOGIN" maxlength="255" value="<?=$arResult["LAST_LOGIN"]?>">
				<input type="hidden" name="USER_EMAIL">
			</div>
		</div>


		<div class="bx-authform-formgroup-container">
			<input type="submit" class="btn btn-primary" name="send_account_info" value="<?=GetMessage("AUTH_SEND")?>">
		</div>

		<div class="bx-authform-link-container">
			<a href="/authorize/"><b><?=GetMessage("AUTH_AUTH")?></b></a>
		</div>

	</form>
</div>
<script type="text/javascript">
document.bform.USER_LOGIN.focus();
</script>
