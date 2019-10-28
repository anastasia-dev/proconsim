<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div method="POST"  class="tender-paty">
<input type="text" name="tender-link" class="tender-link" placeholder="Введите ссылку на тендер" />
<input type="button" onclick="sendTender()" class="tender-send" value="Пригласить" />
<div class="success">Данные успешно отправлены</div>
<div class="error">Ошибка в отправке данных, попробуйте позже</div>
</div>

