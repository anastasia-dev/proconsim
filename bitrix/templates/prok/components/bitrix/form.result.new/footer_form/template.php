<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<?if ($arResult["isFormErrors"] == "Y"):?><?=$arResult["FORM_ERRORS_TEXT"];?><?endif;?>

<?if ($arResult["isFormNote"] != "Y")
{
?>


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
                            <div class="bx-authform-label-container"><?=$arResult["QUESTIONS"]["SIMPLE_QUESTION_886"]["CAPTION"]?>: <span class="bx-authform-starrequired">*</span></div>
                            <div class="bx-authform-input-container"><?=$arResult["QUESTIONS"]["SIMPLE_QUESTION_886"]["HTML_CODE"];?></div>
                         </div>

                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                <div class="bx-authform-formgroup-container">
                                    <div class="bx-authform-label-container"><?=$arResult["QUESTIONS"]["SIMPLE_QUESTION_239"]["CAPTION"]?>: <span class="bx-authform-starrequired">*</span></div>
                                    <div class="bx-authform-input-container"><?=$arResult["QUESTIONS"]["SIMPLE_QUESTION_239"]["HTML_CODE"];?></div>
                                 </div>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <div class="bx-authform-formgroup-container">
                                    <div class="bx-authform-label-container"><?=$arResult["QUESTIONS"]["SIMPLE_QUESTION_430"]["CAPTION"]?>: <span class="bx-authform-starrequired">*</span></div>
                                    <div class="bx-authform-input-container"><?=$arResult["QUESTIONS"]["SIMPLE_QUESTION_430"]["HTML_CODE"];?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="col-xs-12 col-md-6">
                         <div class="row">
                             <div class="col-xs-12 col-md-6">
                                 <div class="bx-authform-formgroup-container">
                                                <div class="bx-authform-label-container"><?=$arResult["QUESTIONS"]["SIMPLE_QUESTION_332"]["CAPTION"]?></div>
                                                <div class="bx-authform-input-container"><?=$arResult["QUESTIONS"]["SIMPLE_QUESTION_332"]["HTML_CODE"];?></div>
                                 </div>
                             </div>

                             <div class="col-xs-12 col-md-6">
                                 <div class="bx-authform-formgroup-container">
                                     <div class="bx-authform-label-container"><?=$arResult["QUESTIONS"]["SIMPLE_QUESTION_581"]["CAPTION"]?><img class="labelIcon" src="/bitrix/templates/prok/components/bitrix/form.result.new/footer_form/images/paper-clips.png"></div>
                                     <div class="bx-authform-input-container" id="drop-area"><label for="upload" class="addFileInput"><span class="fileLabelLinkStyle">Выбрать файл</span></label><?=$arResult["QUESTIONS"]["SIMPLE_QUESTION_581"]["HTML_CODE"];?></div>
                                 </div>
                             </div>
                         </div>
                     </div>
                </div>


                <div class="bx-authform-label-container"><span class="bx-authform-starrequired">*</span>Обязательные для заполнения поля </div>
                <div class="checkbox" style="text-align: center;">
                    <label><?=$arResult["QUESTIONS"]["SIMPLE_QUESTION_327"]["HTML_CODE"];?> Я принимаю условия <a href="/agreement/" target="_blank">политики обработки персональных данных</a></label>
                </div>
                <? /* <input type="submit" class="btn-view btn-blue" name="register_submit_button" value="Отправить" style='margin: 10px auto; display: block;'/> */ ?>
                <input class="btn-view btn-blue" <?=(intval($arResult["F_RIGHT"]) < 10 ? "disabled=\"disabled\"" : "");?> type="submit" name="web_form_submit" value="Жду предложение!" />
<?=$arResult["FORM_FOOTER"]?>
    </div>
<?
} else { ?>
    <div class="bx-authform-success">
        <p>Менеджер очень рад, что получил Вашу заявку! Как только он успокоится – сразу свяжется в Вами!</p>
    </div>
<? } ?>

