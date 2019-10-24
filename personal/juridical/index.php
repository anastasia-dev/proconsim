<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Личный кабинет");
?>
<?
if ($USER->IsAuthorized()){
    $rsUser = CUser::GetByID($USER->GetID());
    $arUser = $rsUser->Fetch();
    //echo "<pre>"; print_r($arUser); echo "</pre>";
    
    if(!empty($arUser["UF_USER_CODE"])){
    require("personal_top.php"); 
?>      
        		
        		
                                
        		<!-- Tab panes -->
        		<div class="tab-content">
                  
        		  <div class="tab-pane active" id="profile">
        			  <div class="row">
        				  <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
                            <div class="personal-tab-content-col-name">Контакты</div>
                            <div class="personal-tab-content-col-sub-name">Контактное лицо:</div>
                            <div><?echo $arUser["NAME"];?> <?echo $arUser["SECOND_NAME"];?> <?echo $arUser["LAST_NAME"];?></div>
                            <div class="personal-tab-content-col-sub-name">Телефон:</div>
                            <div><?echo $arUser["WORK_PHONE"];?></div>
                            <div class="personal-tab-content-col-sub-name">Моб. телефон:</div>
                            <div><?echo $arUser["PERSONAL_MOBILE"];?></div>
                            <div class="personal-tab-content-col-sub-name">Эл. почта:</div>
                            <div><a href="mailto:<?echo $arUser["EMAIL"];?>"><?echo $arUser["EMAIL"];?></a></div>
                            
							  <a href="/personal/profile/" class="btn btn-default personal-tab-content-btn-edit">Редактировать данные</a>
                          </div>
                          <div class="col-lg-6 col-md-8 col-sm-8 col-xs-12">
                            <div class="personal-tab-content-col-name">Реквизиты</div>
                            <!--<div class="personal-tab-content-col-sub-name">Адрес:</div>
                            <div>160000, Вологодская обл, г Вологда, Окружное ш, д 1, оф 29</div>
                            <div class="personal-tab-content-col-sub-name">Адрес доставки:</div>
                            <div>160000, Вологодская обл, г Вологда, Окружное ш, д 1, оф 29</div>-->
                            <div class="personal-tab-content-col-inn">
                                <div class="personal-tab-content-col-sub-name">ИНН:</div>
                                <div><?echo $arUser["UF_INN"];?></div>                    
                            </div>
                            <div class="personal-tab-content-col-sub-name">КПП:</div>
                            <div><?echo $arUser["UF_KPP"];?></div>
                            <div class="personal-tab-content-col-sub-name">ОГРН:</div>
                            <div><?echo $arUser["UF_OGRN"];?></div>
                          </div>
        			  </div>
<!--
                      <div class="row personal-tab-content-col-fininfo">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="personal-tab-content-col-name-bold">Финансовая информация</div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                            <div class="personal-tab-content-limit"></div>
                            <div class="personal-tab-content-col-fininfo-name">Кредитный лимит:</div>
<div class="personal-tab-content-col-fininfo-value"><?//echo number_format($arUser["UF_KR_LIMIT"], 2, ',', ' ');?> руб.</div>
                        </div>                
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                            <div class="personal-tab-content-saldo"></div>
                            <div class="personal-tab-content-col-fininfo-name">Баланс:</div>
<div class="personal-tab-content-col-fininfo-value"><?//echo number_format($arUser["UF_BALANCE"], 2, ',', ' ');?> руб.</div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                            <div class="personal-tab-content-indebtedness"></div>
                            <div class="personal-tab-content-col-fininfo-name">Просроченная задолженность:</div>
<div class="personal-tab-content-col-fininfo-value"><?//echo number_format($arUser["UF_PDZ"], 2, ',', ' ');?> руб.</div>
                        </div>
        			  </div>
                     <!--
                      <div class="row personal-tab-content-col-requisites">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="personal-tab-content-col-name-bold">Реквизиты бухгалтерия</div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                            <div class="personal-tab-content-col-fininfo-name">Банк:</div>
                            <div class="personal-tab-content-col-fininfo-value">ООО «Прогресс»</div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                            <div class="personal-tab-content-col-fininfo-name">Расчётный счёт:</div>
                            <div class="personal-tab-content-col-fininfo-value">34567867982509807</div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                            <div class="personal-tab-content-col-fininfo-name">Кор счёт:</div>
                            <div class="personal-tab-content-col-fininfo-value">34567867982509807</div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                            <div class="personal-tab-content-col-fininfo-name">Бик:</div>
                            <div class="personal-tab-content-col-fininfo-value">235674782</div>
                        </div>
                      </div>
                  -->	  
                  </div>
        		
    <?
    require("personal_footer.php");
    }else{?>
        <div>У вас нет доступа к Личному кабинету для юридического лица. Пожалуйста, <a href="/register/">зарегистрируйтесь</a>.</div>
    <?}?>
<?}else{?>
    <div>Только для авторизованных пользователей.</div>
<?}?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>