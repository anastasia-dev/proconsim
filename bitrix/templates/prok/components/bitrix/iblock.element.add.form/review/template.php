<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(false);

if (!empty($arResult["ERRORS"])):?>
	<?ShowError(implode("<br />", $arResult["ERRORS"]))?>
<?endif;
if (strlen($arResult["MESSAGE"]) > 0):?>
	<?ShowNote($arResult["MESSAGE"])?>
<?endif?>



<form name="iblock_add" action="<?=POST_FORM_ACTION_URI?>" method="post" enctype="multipart/form-data" class="not-send">
	<?=bitrix_sessid_post()?>
	<?if ($arParams["MAX_FILE_SIZE"] > 0):?><input type="hidden" name="MAX_FILE_SIZE" value="<?=$arParams["MAX_FILE_SIZE"]?>" /><?endif?>
	
	<input type="hidden" name="PROPERTY[NAME][0]" size="25" value="Отзыв от <?=date('d.m.Y')?>" />
	
	
	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
 <label for="">Ваше имя: *</label> <input type="text" name="PROPERTY[42][0]" size="25" value="" class="input_box" />
				</div>
				<div class="form-group">
 <label for="">Ваше e-mail: *</label> <input type="text" name="PROPERTY[41][0]" size="25" value="" class="input_box" />
				</div>
				<div class="form-group" style="display: flex;">
 <label for="" style="float: left">Оценка: *</label> <input type="hidden" id="ocenka" name="PROPERTY[43][0]" size="25" value="4" />
 <div class="rating-star">
 <div onmouseover="showStar(1)" onclick="selectStar(1)" class="star blue-star star-1"></div>
 <div onmouseover="showStar(2)" onclick="selectStar(2)" class="star blue-star star-2"></div>
 <div onmouseover="showStar(3)" onclick="selectStar(3)" class="star blue-star star-3"></div>
 <div onmouseover="showStar(4)" onclick="selectStar(4)" class="star blue-star star-4"></div>
 <div onmouseover="showStar(5)" onclick="selectStar(5)" class="star gray-star star-5"></div>
 </div>
				</div>
				
<?if (is_array($arResult["PROPERTY_LIST"]) && !empty($arResult["PROPERTY_LIST"])):?>
			<?if($arParams["USE_CAPTCHA"] == "Y" && $arParams["ID"] <= 0):?>				
				<div class="form-group kapcha">
 <label for="">Защита от роботов: *</label> 
 	<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
	<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" style="float:right;" />
	<input type="text" name="captcha_word" class="input_box" maxlength="50" value="">
					<p>
						 * — поля, отмеченные звездочкой, обязательны к заполнению
					</p>
				</div>
<?endif?>
<?endif?>
 <input type="submit" name="iblock_submit" value="<?=GetMessage("IBLOCK_FORM_SUBMIT")?>" class="btn-view btn-blue hidden-xs" />
			</div>
			<div class="col-md-6 textarea">
 <label for="">Текст отзыва:</label> <textarea cols="30" rows="5" name="PROPERTY[PREVIEW_TEXT][0]"></textarea>
 <input type="submit" name="iblock_submit" value="<?=GetMessage("IBLOCK_FORM_SUBMIT")?>" class="btn-view btn-blue visible-xs" />
			</div>

	</div>
</form>
<script>
function selectStar(num){
	var i;
	for (i = 1; i < 6; i++) {
		if(i<num+1){
			$('.star-'+i).removeClass('gray-star');
			$('.star-'+i).addClass('blue-star');
		}else{
			$('.star-'+i).removeClass('blue-star');
			$('.star-'+i).addClass('gray-star');
		}
		$('#ocenka').val(num);
	}
}
function showStar(num){
	var i;
	for (i = 1; i < 6; i++) {
		if(i<num+1){
			$('.star-'+i).removeClass('gray-star');
			$('.star-'+i).addClass('blue-star');
		}else{
			$('.star-'+i).removeClass('blue-star');
			$('.star-'+i).addClass('gray-star');
		}
		$('#ocenka').val(num);
	}
}
</script>