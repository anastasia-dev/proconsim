<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<?if ($arResult["isFormErrors"] == "Y"):?><?=$arResult["FORM_ERRORS_TEXT"];?><?endif;?>

<?if ($arResult["isFormNote"] != "Y")
{
?>
    <pre>
<? /*print_r($arResult); */?>
</pre>
<?=$arResult["FORM_HEADER"]?>
    <?
    if ($arResult["isFormDescription"] == "Y" || $arResult["isFormTitle"] == "Y" )
    {
        ?>

        <?
/***********************************************************************************
					form header
***********************************************************************************/
        if ($arResult["isFormTitle"])
        {
            ?>
            <h2 class="formH2"><?=$arResult["FORM_TITLE"]?></h2>
            <?
        } else { ?>
            <h2 class="formH2">Оставьте заявку на расчет</h2>

        <? } ?>
        <p><?=$arResult["FORM_DESCRIPTION"]?></p>
        <?
    }
    ?>
    <?
/***********************************************************************************
						form questions
***********************************************************************************/
?>

    <div class="row">
        <div class="col-xs-12 col-md-6">
            <div class="bx-authform-formgroup-container">
                <div class="bx-authform-label-container"><span class="bx-authform-starrequired">*</span><?=$arResult["QUESTIONS"]["name"]["CAPTION"]?> </div>
                <div class="bx-authform-input-container"><?=$arResult["QUESTIONS"]["name"]["HTML_CODE"];?></div>
            </div>

            <div class="bx-authform-formgroup-container">
                <div class="bx-authform-label-container"><span class="bx-authform-starrequired">*</span> <?=$arResult["QUESTIONS"]["email"]["CAPTION"]?> </div>
                <div class="bx-authform-input-container"><?=$arResult["QUESTIONS"]["email"]["HTML_CODE"];?></div>
            </div>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <div class="bx-authform-formgroup-container">
                        <div class="bx-authform-label-container"><span class="bx-authform-starrequired">*</span> <?=$arResult["QUESTIONS"]["message"]["CAPTION"]?> </div>
                        <div class="bx-authform-input-container"><?=$arResult["QUESTIONS"]["message"]["HTML_CODE"];?></div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-6">
                    <div class="bx-authform-formgroup-container">
                        <div class="bx-authform-label-container"><?=$arResult["QUESTIONS"]["file"]["CAPTION"]?></div>
                        <div class="bx-authform-input-container" id="drop-area-cont"><label for="uploadCont" class="addFileInput"><?=$arResult["QUESTIONS"]["file"]["HTML_CODE"];?><span class="fileLabelLinkStyle">Выбрать файл</span></label></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


                <div class="bx-authform-label-container"><span class="bx-authform-starrequired">*</span>Обязательные для заполнения поля </div>
                <div class="checkbox" style="text-align: center;">
                    <label><span class="bx-authform-starrequired">*&nbsp;</span><?=$arResult["QUESTIONS"]["agreement"]["HTML_CODE"];?> Я принимаю условия <a href="/agreement/" target="_blank">политики обработки персональных данных</a></label>
                </div>
                <? /* <input type="submit" class="btn-view btn-blue" name="register_submit_button" value="Отправить" style='margin: 10px auto; display: block;'/> */ ?>
                <input class="btn-view btn-blue" <?=(intval($arResult["F_RIGHT"]) < 10 ? "disabled=\"disabled\"" : "");?> type="submit" name="web_form_submit" value="Отправить запрос" />
<?=$arResult["FORM_FOOTER"]?>
    </div>
<?
} else { ?>
    <div class="bx-authform-success">
        <p>Спасибо! Ваша заявка принята!</p>
    </div>
<? } ?>

