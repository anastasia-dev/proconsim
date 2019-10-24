<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Личный кабинет");
?>
<?
if ($USER->IsAuthorized()){
    $rsUser = CUser::GetByID($USER->GetID());
    $arUser = $rsUser->Fetch();
	//echo "<pre>"; print_r($arUser); echo "</pre>";
    
    if(CSite::InGroup (array(11,12))){
    require("personal_top_physical.php"); 
?>      
					<div class="tab-pane active" id="profile">
        			  <div class="row">
        				  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="personal-tab-content-col-name">Ваши данные</div>
                            <div class="personal-tab-content-col-sub-name">Имя:</div>
                            <div><?echo $arUser["NAME"];?></div>
                            <div class="personal-tab-content-col-sub-name">Отчество:</div>
                            <div><?echo $arUser["SECOND_NAME"];?></div>
                            <div class="personal-tab-content-col-sub-name">Фамилия:</div>
                            <div><?echo $arUser["LAST_NAME"];?></div>
                            <div class="personal-tab-content-col-sub-name">Телефон:</div>
                            <div><?echo $arUser["PERSONAL_PHONE"];?></div>
                            <div class="personal-tab-content-col-sub-name">Моб. телефон:</div>
                            <div><?echo $arUser["PERSONAL_MOBILE"];?></div>
                            <div class="personal-tab-content-col-sub-name">Эл. почта:</div>
                            <div><a href="mailto:<?echo $arUser["EMAIL"];?>"><?echo $arUser["EMAIL"];?></a></div>
                            
							  <a href="/personal/physical/profile/" class="btn btn-default personal-tab-content-btn-edit">Редактировать данные</a>
                          </div>                          
        			  </div>	  
                  </div>
<?
    require("personal_footer_physical.php");
    }else{?>
        <div>У вас нет доступа к Личному кабинету для физического лица. Пожалуйста, <a href="/physical/">зарегистрируйтесь</a>.</div>
    <?}?>
<?}else{?>
    <div>Только для авторизованных пользователей.</div>
<?}?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>