<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Страница авторизации в личном кабинете (только для юридических лиц). Компания Проконсим.");

$APPLICATION->SetTitle("Авторизация в личном кабинете (только для юридических лиц)");
?><!--<button class="btn-view btn-blue"><img src="/bitrix/templates/prok/img/button_icon.png" alt="">СКАЧАТЬ PDF</button> <button class="btn-view btn-blue"><img src="/bitrix/templates/prok/img/button_icon.png" alt="">СКАЧАТЬ DOC</button>-->
<div class="row">
	<div class="col-md-6">
		<br />
		<div class="reg">
<?$APPLICATION->IncludeComponent(
	"bitrix:system.auth.form", 
	"flat", 
	array(
		"COMPONENT_TEMPLATE" => "flat",
		"REGISTER_URL" => "",
		"FORGOT_PASSWORD_URL" => "/forgot-password/",
		"PROFILE_URL" => "/personal/",
		"SHOW_ERRORS" => "Y"
	),
	false
);?>

		</div>
<p>Нет логина и пароля? – <a href="/register/" style="font-size: 13px;font-weight:bold;">Зарегистрируйтесь</a>!
<br /><br />
<!--<input type="button" class="btn btn-primary" style="width:auto;" name="Link" value="Регистрация" onClick="window.location='/register/'">-->
<br /><br />        
<b>Примечание:</b><br />
Регистрация в личном кабинете возможна только для юридических лиц (ОАО, ПАО, ЗАО, ООО) и индивидуальных предпринимателей (ИП).<br />
Активация личного кабинета осуществляется в течение 24 часов с момента регистрации.

<br /><br />
<b>Возможности Личного Кабинета:</b><br />
Формирование заказов на сайте компании, история отгрузок, график платежей по отгрузкам с отсрочкой платежа, кредитный лимит, баланс, форма связи с менеджером и т.д.
</p>        
        
	</div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>