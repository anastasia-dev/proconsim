<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Личный кабинет");
?>
<?
if ($USER->IsAuthorized()){
    $rsUser = CUser::GetByID($USER->GetID());
    $arUser = $rsUser->Fetch();
    //echo "<pre>"; print_r($arUser); echo "</pre>";
    
    if(CSite::InGroup (array(12))){
    require($_SERVER["DOCUMENT_ROOT"]."/personal/physical/personal_top_physical.php"); 
?>      

        		  <div class="tab-pane active" id="faq">
                  <div class="user-reg">
                    <form name="faqform" method="post">
                        <input type="text" name="theme" id="theme" placeholder="Тема сообщения" class="personal-input"><br />
                        <textarea name="faqtext" placeholder="Сообщение" class="personal-textarea"></textarea><br />
                        <input type="button" onclick="sendFaq()" class="tender-send" value="Отправить данные">
                    </form>
                  </div>  
                  </div>

    <?
    require($_SERVER["DOCUMENT_ROOT"]."/personal/physical/personal_footer_physical.php");
    }else{?>
        <div>У вас нет доступа к Личному кабинету физического лица. Пожалуйста, <a href="/physical/">зарегистрируйтесь</a>.</div>
    <?}?>
<?}else{?>
    <div>Только для авторизованных пользователей.</div>
<?}?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>