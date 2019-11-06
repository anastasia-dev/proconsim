<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Адрес и время работы центрального офиса и склада в Москве. Телефон: 8 (495) 988-00-32.");
$APPLICATION->SetPageProperty("title", "Контакты - Проконсим");
$APPLICATION->SetTitle("Контакты");
?><?$city_id = $APPLICATION->get_cookie('USER_CITY');?> <?$city = $APPLICATION->get_cookie('USER_CITY_NAME');?>
<?
if(intval($city_id) == 0){
    $city = "moskva";
    $city_id = 439;
}
?>
<?
$arSelectRegions = Array("ID", "IBLOCK_ID", "NAME", "CODE", "PROPERTY_YANDEX_LAT", "PROPERTY_YANDEX_LON", "PROPERTY_CONTACTS_ADDRESS", "PROPERTY_CONTACTS_EMAIL", "PROPERTY_CONTACTS_PHONE", "PROPERTY_CONTACTS_MAP");
$arFilterRegions = Array(
    "IBLOCK_ID"=>6,
    "ACTIVE"=> "Y",
    "ID" => $city_id
);
$resRegions = CIBlockElement::GetList(Array("SORT"=>"asc"), $arFilterRegions, false, false, $arSelectRegions);
while($obRegions = $resRegions->GetNextElement()){
    $arRegionsFields = $obRegions->GetFields();
    //echo "<pre>";
//print_r($arRegionsFields);
//echo "</pre>";
}
?>
    <div class="col-md-6">
        <?if(!empty($arRegionsFields["PROPERTY_YANDEX_LAT_VALUE"]) && !empty($arRegionsFields["PROPERTY_YANDEX_LON_VALUE"])){?>
            <?$APPLICATION->IncludeComponent(
                "bitrix:map.yandex.view",
                "yamap",
                array(
                    "COMPONENT_TEMPLATE" => "yamap",
                    "CONTROLS" => array(
                        0 => "ZOOM",
                        1 => "MINIMAP",
                        2 => "TYPECONTROL",
                        3 => "SCALELINE",
                    ),
                    "INIT_MAP_TYPE" => "MAP",
                    "MAP_DATA" => "a:4:{s:10:\"yandex_lat\";d:".$arRegionsFields["PROPERTY_YANDEX_LAT_VALUE"].";s:10:\"yandex_lon\";d:".$arRegionsFields["PROPERTY_YANDEX_LON_VALUE"].";s:12:\"yandex_scale\";i:17;s:10:\"PLACEMARKS\";a:1:{i:0;a:3:{s:3:\"LON\";d:".$arRegionsFields["PROPERTY_YANDEX_LON_VALUE"].";s:3:\"LAT\";d:".$arRegionsFields["PROPERTY_YANDEX_LAT_VALUE"].";s:4:\"TEXT\";s:0:\"\";}}}",
                    "MAP_HEIGHT" => "400",
                    "MAP_ID" => "",
                    "MAP_WIDTH" => "100%",
                    "OPTIONS" => array(
                        0 => "ENABLE_SCROLL_ZOOM",
                        1 => "ENABLE_DBLCLICK_ZOOM",
                        2 => "ENABLE_DRAGGING",
                    )
                ),
                false
            );?>
        <?}?>
        <?if(!empty($arRegionsFields["~PROPERTY_CONTACTS_MAP_VALUE"]["TEXT"])){?>
            <div style="margin-top: 20px;"><?=$arRegionsFields["~PROPERTY_CONTACTS_MAP_VALUE"]["TEXT"]?></div>
        <?}?>
    </div>
    <div itemscope itemtype="http://schema.org/LocalBusiness" class="col-xs-12 col-md-6 txt-box">
        <h1 class="title-h2">КОНТАКТЫ</h1>
        <span itemprop="name" style="display: none;">ЗАО фирма «ПРОКОНСИМ»</span>
        <div class="item">
            <div class="contacts-icon">
                <img src="/bitrix/templates/prok/img/ico-marker.png" alt="">
            </div>
            <div class="contacts-text"><?=$arRegionsFields["~PROPERTY_CONTACTS_ADDRESS_VALUE"]["TEXT"]?></div>
        </div>
        <div class="item">
            <div class="contacts-icon">
                <img src="/bitrix/templates/prok/img/ico-envelope.png" alt="">
            </div>
            <div class="contacts-text"><?=$arRegionsFields["~PROPERTY_CONTACTS_EMAIL_VALUE"]["TEXT"]?></div>
        </div>
        <div class="item">
            <div class="contacts-icon">
                <img src="/bitrix/templates/prok/img/ico-phone-2.png" alt="">
            </div>
            <div class="contacts-text"><?=$arRegionsFields["~PROPERTY_CONTACTS_PHONE_VALUE"]["TEXT"]?></div>
        </div>

    </div>
    <div class="col-xs-12 col-md-12 form-box">
        <h2 class="" style="font-size: 2em; margin: 0.67em 0; text-align: center;">НАПИШИТЕ НАМ</h2>
        <?$APPLICATION->SetAdditionalCSS("/bitrix/templates/prok/components/proc/main.register/registr-new/style.css");?>
        <?include_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/classes/general/captcha.php");
        /*$cpt = new CCaptcha();
        $captchaPass = COption::GetOptionString("main", "captcha_password", "");
        if(strlen($captchaPass) <= 0)
        {
            $captchaPass = randString(10);
            COption::SetOptionString("main", "captcha_password", $captchaPass);
        }*/
        /*$cpt->SetCodeCrypt($captchaPass);*/

        if($_POST){

            //echo "<pre>";
            //print_r($_POST);
            //echo "</pre>";

            //echo "<pre>";
            //print_r($_FILES);
            //echo "</pre>";
            $myErrors = array();
            $fileSizeLimit = 1024 * 1024 * 10;
            $fileTypes =  array('png','jpg','jpeg','pdf','xls','xlsx','doc','docx','tiff');
            $uploaddir = $_SERVER["DOCUMENT_ROOT"].'/upload/selection/';
            $uploadRequisitesFile = "";
            $arSendFiles = array();
            $isSend = "";


            if(empty($_POST["fio"])){
                $myErrors["FIO"] = "Поле \"ФИО\" обязательно для заполнения";
            }
            /*            if(empty($_POST["phone"])){
                            $myErrors["PHONE"] = "Поле \"Контактный телефон\" обязательно для заполнения";
                        }*/
            if(empty($_POST["email"])){
                $myErrors["EMAIL"] = "Поле \"E-mail\" обязательно для заполнения";
            }
            if(empty($_POST["comment"])){
                $myErrors["EMAIL"] = "Поле \"Ваш вопрос\" обязательно для заполнения";
            }
            if($_FILES["account"]["error"]>0){
                $myErrors["ACCOUNT"] = "Поле \"Приложите файл\" обязательно для заполнения";
            }else{
                if($_FILES["account"]["size"]>$fileSizeLimit){
                    $myErrors["ACCOUNT_SIZE"] = "Файл \"Загрузите спецификацию, смету, счет конкурента\". Превышен допустимый размер файла. Разрешены файлы не более 10Mb.";
                }
                $ext = pathinfo($_FILES["account"]["name"], PATHINFO_EXTENSION);
                if(!in_array($ext, $fileTypes)){
                    $myErrors["ACCOUNT_TYPE"] = "Файл \"Загрузите спецификацию, смету, счет конкурента\". Прикрепить можно только файлы изображений (jpg, jpeg, png, tiff) и документов (pdf, xls, xlsx, doc, docx)";
                }
                $uploadAccountFile = $uploaddir . basename($_FILES['account']['name']);
                //echo $uploadAccountFile;
                if(!move_uploaded_file($_FILES['account']['tmp_name'], $uploadAccountFile)){
                    $myErrors["ACCOUNT_UPLOAD"] = "Ошибка загрузки файла ".$_FILES['account']['name'];
                }else{
                    $arSendFiles[] = $uploadAccountFile;
                }

            }
            /*            if(empty($_FILES["requisites"]["error"])){
                            if($_FILES["requisites"]["size"]>$fileSizeLimit){
                                $myErrors["REQUISITES_SIZE"] = "Файл \"Загрузите реквизиты\". Превышен допустимый размер файла. Разрешены файлы не более 10Mb.";
                            }
                            $ext = pathinfo($_FILES["requisites"]["name"], PATHINFO_EXTENSION);
                            if(!in_array($ext, $fileTypes)){
                                $myErrors["REQUISITES_TYPE"] = "Файл \"Загрузите реквизиты\". Прикрепить можно только файлы изображений (jpg, jpeg, png, tiff) и документов (pdf, xls, xlsx, doc, docx)";
                            }
                            $uploadRequisitesFile = $uploaddir . basename($_FILES['requisites']['name']);
                            //echo $uploadRequisitesFile;
                            if(!move_uploaded_file($_FILES['requisites']['tmp_name'], $uploadRequisitesFile)){
                                $myErrors["REQUISITES_UPLOAD"] = "Ошибка загрузки файла ".$_FILES['requisites']['name'];
                            }else{
                                $arSendFiles[] = $uploadRequisitesFile;
                            }
                        }*/


            /*  if(!$APPLICATION->CaptchaCheckCode($_POST["captcha_word"], $_POST["captcha_code"]))
              {
                  // Неправильное значение
                  $myErrors["CAPTCHA"] = "Код не совпадает";
              }*/



            if(!empty($myErrors)){
                ShowError(implode("<br />", $myErrors));
            }else{
                $arSendFields = array(
                    "FIO" => $_POST["fio"],
                    "PHONE" => $_POST["phone"],
                    "EMAIL"  => $_POST["email"],
                    "COMPANY"  => $_POST["company"],
                    "COMMENT" => $_POST["comment"],
                );
                //echo "<pre>2";
                //print_r($arSendFields);
                //echo "</pre>";
                $send = CEvent::Send("SELECTION_INFO", "s1", $arSendFields, "N", 66, $arSendFiles);
                if($send){
                    // удаляем файлы
                    foreach($arSendFiles as $delFile){
                        unlink($delFile);
                    }
                    $isSend = "Ваш запрос успешно отправлен! В ближайшее время с Вами свяжется наш менеджер.";
                }
            }


        }
        ?>
        <?
        echo "<div class=\"bx-authform contacts-form\" style='max-width: unset;'>\n";
        /*echo "<p><strong>Мы хотим сэкономить ваше время!</strong></p>\n";
        echo "<p>С помощью данной формы вы можете отправить нам для расчета смету, список товаров, счет конкурента или другой имеющийся у вас документ и максимально быстро получить ответ по стоимости вашего заказа.</p>\n";
       */
        echo "<form method=\"post\" class=\"not-send\" action=\"\" name=\"editform\" enctype=\"multipart/form-data\">\n";

        echo "<div class=\"row\"><div class=\"col-xs-12 col-md-6\"><div class=\"bx-authform-formgroup-container\">\n";
        echo "<div class=\"bx-authform-label-container\">Контактное лицо: <span class=\"bx-authform-starrequired\">*</span></div>\n";
        echo "<div class=\"bx-authform-input-container\">\n";
        echo "<input name=\"fio\" maxlength=\"255\" value=\"".(isset($_POST["fio"])?$_POST["fio"]:"")."\" type=\"text\">\n";
        echo "</div>\n";
        echo "</div>\n";

        /*        echo "<div class=\"bx-authform-formgroup-container\">\n";
                echo "<div class=\"bx-authform-label-container\">Контактный телефон: <span class=\"bx-authform-starrequired\">*</span></div>\n";
                echo "<div class=\"bx-authform-input-container\">\n";
                echo "<input name=\"phone\" maxlength=\"255\" value=\"".(isset($_POST["phone"])?$_POST["phone"]:"")."\" type=\"text\">\n";
                echo "</div>\n";
                echo "</div>\n";*/

        echo "<div class=\"bx-authform-formgroup-container\">\n";
        echo "<div class=\"bx-authform-label-container\">E-mail: <span class=\"bx-authform-starrequired\">*</span></div>\n";
        echo "<div class=\"bx-authform-input-container\">\n";
        echo "<input name=\"email\" maxlength=\"255\" value=\"".(isset($_POST["email"])?$_POST["email"]:"")."\" type=\"text\">\n";
        echo "</div>\n";
        echo "</div></div>\n";

        /*        echo "<div class=\"bx-authform-formgroup-container\">\n";
                echo "<div class=\"bx-authform-label-container\">Организация</div>\n";
                echo "<div class=\"bx-authform-input-container\">\n";
                echo "<input name=\"company\" maxlength=\"255\" value=\"".(isset($_POST["company"])?$_POST["company"]:"")."\" type=\"text\">\n";
                echo "</div>\n";
                echo "</div>\n";*/

        echo "<div class=\"col-xs-12 col-md-6\"><div class=\"row\"><div class=\"col-xs-12 col-md-6\"><div class=\"bx-authform-formgroup-container\">\n";
        echo "<div class=\"bx-authform-label-container\">Ваш вопрос <span class=\"bx-authform-starrequired\">*</span></div>\n";
        echo "<div class=\"bx-authform-input-container\">\n";
        echo "<textarea cols=\"30\" rows=\"5\" name=\"comment\" class=\"register-form\">".(isset($_POST["comment"])?$_POST["comment"]:"")."</textarea>\n";
        echo "</div>\n";
        echo "</div></div>\n";

        echo "<div class=\"col-xs-12 col-md-6\"><div class=\"bx-authform-formgroup-container\">\n";
        echo "<div class=\"bx-authform-label-container\">Приложите файл <span class=\"bx-authform-starrequired\">*</span></div>\n";
        echo "<div class=\"bx-authform-input-container\">\n";
        echo "<input name=\"account\" maxlength=\"255\" value=\"\" type=\"file\">\n";
        echo "</div>\n";
        echo "</div></div></div></div></div>\n";

        /* echo "<div class=\"bx-authform-formgroup-container\">\n";
         echo "<div class=\"bx-authform-label-container\"><b>Загрузите реквизиты</b><br />Файл не более 10Мб (XLS, DOC, PDF, JPG, TIFF, PNG)</div>\n";
         echo "<div class=\"bx-authform-input-container\">\n";
         echo "<input name=\"requisites\" maxlength=\"255\" value=\"\" type=\"file\">\n";
         echo "</div>\n";
         echo "</div>\n";*/
        ?>
        <?/* <input type="hidden" name="captcha_code" value="<?=htmlspecialchars($cpt->GetCodeCrypt());?>" />

        <div class="bx-authform-formgroup-container">
            <div class="bx-authform-label-container">
                <span class="bx-authform-starrequired">*</span>Введите код
            </div>
            <div class="bx-captcha"><img src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialchars($cpt->GetCodeCrypt());?>" width="180" height="40" alt="CAPTCHA" /></div>
            <div class="bx-authform-input-container">
                <input type="text" name="captcha_word" maxlength="50" value="" autocomplete="off"/>
            </div>
        </div>*/
        ?>
        <?
        echo "<div class=\"bx-authform-label-container\"><span class=\"bx-authform-starrequired\">*</span>Обязательные для заполнения поля </div>\n";
        echo "<div class=\"checkbox\" style='text-align: center;'><label>
                <input id=\"agreement\" name=\"agreement\" type=\"checkbox\" required checked > Я принимаю условия <a href=\"/agreement/\" target=\"_blank\">политики обработки персональных данных</a>
                </label></div>";
        echo "<input type=\"submit\" class=\"btn-view btn-blue\" name=\"register_submit_button\" value=\"Отправить\" style='margin: 10px auto; display: block;'/>\n";
        echo "</form>\n";/*
        echo "<p>Отправляя данные, Вы принимаете условия <a href=\"/agreement/\" target=\"_blank\">Пользовательского соглашения</a>.</p>\n";*/
        if(!empty($isSend)){
            echo "<p>".$isSend."</p>";
        }
        echo "</div>\n";
        ?>
    </div>
    <div class="col-xs-12 col-md-12 txt-box">
        <h5 class="h5InText">Региональные филиалы</h5>
        <div class="big-map">
            <img src="<?=SITE_TEMPLATE_PATH?>/img/branches-map.png" alt="" class="img-responsive">
        </div>
        <div class="branches_list">
            <div class="row">
                <?$APPLICATION->IncludeComponent("bitrix:news.list", "regional-office", Array(
                    "COMPONENT_TEMPLATE" => ".default",
                    "IBLOCK_TYPE" => "references",	// Тип информационного блока (используется только для проверки)
                    "IBLOCK_ID" => "6",	// Код информационного блока
                    "NEWS_COUNT" => "100",	// Количество новостей на странице
                    "SORT_BY1" => "SORT",	// Поле для первой сортировки новостей
                    "SORT_ORDER1" => "ASC",	// Направление для первой сортировки новостей
                    "SORT_BY2" => "NAME",	// Поле для второй сортировки новостей
                    "SORT_ORDER2" => "ASC",	// Направление для второй сортировки новостей
                    "FILTER_NAME" => "",	// Фильтр
                    "FIELD_CODE" => array(	// Поля
                        0 => "DETAIL_TEXT",
                        1 => "",
                    ),
                    "PROPERTY_CODE" => array(	// Свойства
                        0 => "",
                        1 => "",
                    ),
                    "CHECK_DATES" => "Y",	// Показывать только активные на данный момент элементы
                    "DETAIL_URL" => "",	// URL страницы детального просмотра (по умолчанию - из настроек инфоблока)
                    "AJAX_MODE" => "N",	// Включить режим AJAX
                    "AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
                    "AJAX_OPTION_STYLE" => "Y",	// Включить подгрузку стилей
                    "AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
                    "AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
                    "CACHE_TYPE" => "A",	// Тип кеширования
                    "CACHE_TIME" => "36000000",	// Время кеширования (сек.)
                    "CACHE_FILTER" => "N",	// Кешировать при установленном фильтре
                    "CACHE_GROUPS" => "Y",	// Учитывать права доступа
                    "PREVIEW_TRUNCATE_LEN" => "",	// Максимальная длина анонса для вывода (только для типа текст)
                    "ACTIVE_DATE_FORMAT" => "d.m.Y",	// Формат показа даты
                    "SET_TITLE" => "N",	// Устанавливать заголовок страницы
                    "SET_BROWSER_TITLE" => "N",	// Устанавливать заголовок окна браузера
                    "SET_META_KEYWORDS" => "N",	// Устанавливать ключевые слова страницы
                    "SET_META_DESCRIPTION" => "N",	// Устанавливать описание страницы
                    "SET_LAST_MODIFIED" => "N",	// Устанавливать в заголовках ответа время модификации страницы
                    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",	// Включать инфоблок в цепочку навигации
                    "ADD_SECTIONS_CHAIN" => "N",	// Включать раздел в цепочку навигации
                    "HIDE_LINK_WHEN_NO_DETAIL" => "N",	// Скрывать ссылку, если нет детального описания
                    "PARENT_SECTION" => "",	// ID раздела
                    "PARENT_SECTION_CODE" => "",	// Код раздела
                    "INCLUDE_SUBSECTIONS" => "Y",	// Показывать элементы подразделов раздела
                    "DISPLAY_DATE" => "Y",	// Выводить дату элемента
                    "DISPLAY_NAME" => "Y",	// Выводить название элемента
                    "DISPLAY_PICTURE" => "Y",	// Выводить изображение для анонса
                    "DISPLAY_PREVIEW_TEXT" => "N",	// Выводить текст анонса
                    "PAGER_TEMPLATE" => ".default",	// Шаблон постраничной навигации
                    "DISPLAY_TOP_PAGER" => "N",	// Выводить над списком
                    "DISPLAY_BOTTOM_PAGER" => "Y",	// Выводить под списком
                    "PAGER_TITLE" => "Новости",	// Название категорий
                    "PAGER_SHOW_ALWAYS" => "N",	// Выводить всегда
                    "PAGER_DESC_NUMBERING" => "N",	// Использовать обратную навигацию
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// Время кеширования страниц для обратной навигации
                    "PAGER_SHOW_ALL" => "N",	// Показывать ссылку "Все"
                    "PAGER_BASE_LINK_ENABLE" => "N",	// Включить обработку ссылок
                    "SET_STATUS_404" => "N",	// Устанавливать статус 404
                    "SHOW_404" => "N",	// Показ специальной страницы
                    "MESSAGE_404" => "",	// Сообщение для показа (по умолчанию из компонента)
                ),
                    false
                );?>
            </div>
        </div>
    </div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>