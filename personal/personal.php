<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Личный кабинет");
?>
<?
if ($USER->IsAuthorized()){
$rsUser = CUser::GetByID($USER->GetID());
$arUser = $rsUser->Fetch();
//echo "<pre>"; print_r($arUser); echo "</pre>";

$filialID = 0;
$filial = "";
$filialPhone = "";
$arManager = array();
//Филиал
if(!empty($arUser["UF_FILIAL_CODE"])){
        $arFilialSelect = Array("ID", "IBLOCK_ID", "NAME", "PROPERTY_PHONE_PDF");
        $arFilialFilter = Array(
                        "IBLOCK_ID"=>6,
                        "PROPERTY_FILIAL_CODE" => $arUser["UF_FILIAL_CODE"] 
                    );
        $resFilial = CIBlockElement::GetList(Array(), $arFilialFilter, false, false, $arFilialSelect);
        if($ob = $resFilial->GetNextElement()){ 
            $arFilialFields = $ob->GetFields(); 
            $filialID = $arFilialFields["ID"];
            $filial = $arFilialFields["NAME"];
            $filialPhone = $arFilialFields["PROPERTY_PHONE_PDF_VALUE"];
            //echo "<pre>"; print_r($arFilialFields); echo "</pre>";            
        } 
}
//Менеджер
if(!empty($arUser["UF_MANAGER_ID"])){
        $rsManagers = CUser::GetList(($by = "NAME"), ($order = "desc"), array('ID' => $arUser["UF_MANAGER_ID"]));
		$arManager = $rsManagers->Fetch();	
        //echo "<pre>"; print_r($arManager); echo "</pre>";	
}        
//Платежи
$overdueArray = array();
$currentArray = array();
if (CModule::IncludeModule('highloadblock')) {
               $arHLBlock = Bitrix\Highloadblock\HighloadBlockTable::getById(4)->fetch();
               $obEntity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($arHLBlock);
               $strEntityDataClass = $obEntity->getDataClass();                
               
                   $rsUserDocs = $strEntityDataClass::getList(array(
                      'select' => array('*'),
                      'filter' => array('UF_USER_ID' => $USER->GetID()),
                      'order' => array('ID' => 'ASC'),
                      'limit' => '50',
                   ));
                   while ($arItemUserDocs = $rsUserDocs->Fetch()) {  
                       if($arItemUserDocs["UF_DELAY_DAYS"]>0){
                           $overdueArray[] = $arItemUserDocs;
                       }else{
                           $currentArray[] = $arItemUserDocs;
                       }            
                   }
             
}        
?>
<link rel="stylesheet" href="/bitrix/templates/prok/libs/bootstrap/css/bootstrap-nav.css">
<script src="/bitrix/templates/prok/libs/bootstrap/js/bootstrap.min.js"></script>
<style>

.no-padding{
    padding-left: 0;
    padding-right: 0;
}
.no-padding-left{    
}
.personal-new{
    font-size: 14px;
    margin-left: 0;
}
.personal-left{
    text-align:center;
    margin-bottom:90px;
}
.personal-left-bg{
    background-color:#f1f1f1;
}
.personal-left-top{
    background-color:#e2e2e2;
    border-bottom: 1px solid #cfcfcf;
    padding-top:30px;
    padding-bottom:90px;    
}
.personal-left-company{
    color:#2e313b;
    font-size:18px;
    font-weight:bold;
    text-transform: uppercase;
    margin-bottom:20px;
}
a.personal-exit{
    display:inline-block;
    background-image: url(<?=SITE_TEMPLATE_PATH?>/img/icon-exit.png);
    background-position: 0;
    background-repeat: no-repeat;
    padding-left: 25px;
    color:#007fbf;
    
}
.personal-left-id{
    margin-top:20px;
    margin-bottom: 35px;
    display:inline-block;
    border:1px solid #cfcfcf;
    border-radius: 3px;
    padding:15px 25px;
    color:#2e313b;
    font-size: 18px;
    font-weight: bold;
}
.personal-left-bottom{
    background-color:#f1f1f1;
    padding-bottom: 90px;
}
.personal-left-manager{
    /*padding-top:35px;*/
}
.personal-left-img{
    margin-top: 15px;
}
.personal-left-manager-name{
    color:#2e313b;
    font-size:18px;
    font-weight:bold;
    margin-top:20px;
}
.personal-left-phone{    
    background-image: url(<?=SITE_TEMPLATE_PATH?>/img/icon-personal-phone.png);
    background-position: top center;
    background-repeat: no-repeat;
    margin: 30px auto 10px auto;
    padding-top: 35px;
}
.personal-left-mail{   
    background-image: url(<?=SITE_TEMPLATE_PATH?>/img/icon-personal-mail.png);
    background-position: top center;
    background-repeat: no-repeat;
    margin: 30px auto 10px auto;
    padding-top: 35px;
}

.tab-pane{
    padding-top: 35px;
}
.nav-tabs>li.active>a, 
.nav-tabs>li.active>a:focus, 
.nav-tabs>li.active>a:hover {
    color: #2e313b;
    cursor: default;
    background-color: #e2e2e2;
    border: 1px solid #ddd;
    border-bottom-color: #cfcfcf;
}
.nav-tabs>li>a {
    margin-right: 2px;
    line-height: 1.42857143;
    border: 1px solid transparent;
    border-radius: 4px 4px 0 0;
    font-weight: bold;
}
.personal-tab-content-col-name{
    font-size: 18px;
    color:#2e313b;
}
.personal-tab-content-col-sub-name{
    margin-top: 25px;
    color:#61636c;
    font-size:12px;
}
.personal-tab-content-col-inn{
    float: left;
    width:50%;
}
.personal-tab-content-btn-edit{
    color:#ffffff;
    background-color: #007fbf;
    background-image: url(<?=SITE_TEMPLATE_PATH?>/img/icon-person-edit-btn.png);
    background-position: 10px;
    background-repeat: no-repeat;
    padding-left: 35px;
    border: 1px solid #007fbf;
    margin-top: 25px;
}
.personal-tab-content-btn-edit:hover,
.personal-tab-content-btn-edit:active,
.personal-tab-content-btn-edit:focus{
    color:#ffffff;
    background-color: #7ab9d8;
}
.personal-tab-content-col-fininfo{   
    background-color: #f1f1f1;
    margin-right: 0;
    margin-left: 0;
    margin-top: 45px;
    padding-top: 20px;
    padding-bottom: 30px;
}
.personal-tab-content-col-name-bold{
    font-size: 18px;
    color:#2e313b;
    font-weight: bold;
    margin-bottom: 20px;
}
.personal-tab-content-col-fininfo-name{
    color:#61636c;
    font-size:12px;
    margin-top: 5px;
}
.personal-tab-content-col-fininfo-value{}
.personal-tab-content-limit{
    width: 32px;
    height: 28px;
    background-image: url(<?=SITE_TEMPLATE_PATH?>/img/icon-personal-limit.png);
    background-position: 0;
    background-repeat: no-repeat;    
}
.personal-tab-content-delay{
    width: 30px;
    height: 29px;
    background-image: url(<?=SITE_TEMPLATE_PATH?>/img/icon-personal-delay.png);
    background-position: 0;
    background-repeat: no-repeat; 
}
.personal-tab-content-saldo{
    width: 38px;
    height: 29px;
    background-image: url(<?=SITE_TEMPLATE_PATH?>/img/icon-personal-saldo.png);
    background-position: 0;
    background-repeat: no-repeat; 
}
.personal-tab-content-indebtedness{
    width: 37px;
    height: 28px;
    background-image: url(<?=SITE_TEMPLATE_PATH?>/img/icon-personal-indebtedness.png);
    background-position: 0;
    background-repeat: no-repeat; 
}
.personal-tab-content-col-requisites{
    margin-top: 40px;
}
input.personal-input{
    width: 78%;
    margin: 2px 3px 2px 0;
}
textarea.personal-textarea{
    width: 78%;
    height: 150px;
    margin: 2px 3px 2px 0;
}

.payments-tab-content-col-name{
    margin-top: 25px;
    margin-bottom: 20px;
    color:#2e313b;
    font-size:18px;
}

.table-bordered {
        border: 1px solid #ddd;
    } 

.table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {
    border: 1px solid #ddd;
}
.table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {
    padding: 8px;
    line-height: 1.42857143;
    vertical-align: top;
    border-top: 1px solid #ddd;
}

td, th {
    padding: 0;
}

@media (max-width: 992px) {
  .no-padding {
    padding-left: 15px;
    padding-right: 15px;
  }
  .no-padding-left{
    padding-left: 0;
  }
  .personal-left{      
      margin-bottom: 40px;
  }
  .personal-left-top{
      display: block;
      padding-bottom: 57px;
  }
  .personal-left-manager-name{
    margin-bottom: 10px;
  }
  .personal-left-phone{
    float: left;
    margin-top: 0;
    margin-right: 15px;
    background-position: top left;
    padding-top: 0;
    padding-left: 30px;
  }
  .personal-left-mail{
    float: left;
    margin-top: 5px;
    margin-right: 15px;
    background-position: top left;
    padding-top: 0;
    padding-left: 30px;
  }
  .personal-left-bottom{
    padding: 20px;
    text-align: left;
  }
  a.personal-exit{
     padding-left: 0;
     background-position: top center;
     padding-top: 20px;
  }
}
@media (max-width: 767px) {
    .nav-tabs {
        border-bottom: 0;
    }
    .nav-tabs > li{
        float: none;
        border-bottom: 1px solid #cfcfcf;
        background-color: #f1f1f1;
        margin-bottom: 0;
    }
    .personal-tab-content-btn-edit{
        margin-bottom: 30px;
    }
    .personal-tab-content-col-fininfo-value{
        margin-bottom: 30px;
    }
    .no-padding{
        padding-left: 0;
    }
    input.personal-input{
        width: 100%;        
   }
   textarea.personal-textarea{
        width: 100%;        
    }   
}    
</style>


<div class="row personal-new">
	<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 personal-left">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12 no-padding no-padding-left">
            <div class="personal-left-bg">
            
				<div class="personal-left-top">
                    <div class="col-lg-12 col-md-12 col-sm-8 col-xs-8 no-padding">
                        <div class="personal-left-company"><?echo $arUser["WORK_COMPANY"]?></div>
                    </div>    
                    <div class="col-lg-12 col-md-12 col-sm-4 col-xs-4">
                        <a href="?logout=yes" class="personal-exit">Выйти</a>
                    </div>    
                </div>
                <?if(!empty($filial)){?>
                <div class="personal-left-id"><?echo $filial;?></div>
                <?}?>
            </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12 no-padding">
            <?if($arManager){?>
            <div class="personal-left-bottom">
                <div class="personal-left-manager">Ваш менеджер</div>
                <div class="row">
                <?if(isset($arManager["PERSONAL_PHOTO"])){?>
                    <div class="col-lg-12 col-md-12 col-sm-4 col-xs-4">
                        <div class="personal-left-img"><img src="<?=CFile::GetPath($arManager["PERSONAL_PHOTO"]);?>" alt="Ваш менеджер <?echo $arManager["LAST_NAME"];?>" class="img-circle img-responsive center-block"></div>
                    </div>
                <?}?>    
                    <div class="col-lg-12 col-md-12 col-sm-8 col-xs-8">
                        <div class="personal-left-manager-name"><?echo $arManager["LAST_NAME"];?></div>
                        <?if(!empty($filialPhone)){?>
                        <div class="personal-left-phone">
                            <div><?echo $filialPhone;?></div>
                            <div>Доб.  <?echo $arManager["WORK_PHONE"];?></div>
                        </div>
                        <?}?>
                        <div class="personal-left-mail">
                            <a href="mailto:<?echo  $arManager["EMAIL"];?>"><?echo  $arManager["EMAIL"];?></a>
                        </div>
                    </div>
                </div> 
            </div> 
            <?}?>                  
            </div>
        </div>
    </div>
	<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 no-padding-left">
		<!-- Nav tabs -->
		<ul class="nav nav-tabs">
		  <li class="active"><a href="#profile" data-toggle="tab">Профиль <span class="glyphicon glyphicon-chevron-right pull-right visible-xs"></span></a></li>
		  <li><a href="#orders" data-toggle="tab">История заказов<span class="glyphicon glyphicon-chevron-right pull-right visible-xs"></span></a></li>	
          <li><a href="#shipments" data-toggle="tab">Отгрузки<span class="glyphicon glyphicon-chevron-right pull-right visible-xs"></span></a></li>	
          <li><a href="#payments" data-toggle="tab">График платежей<span class="glyphicon glyphicon-chevron-right pull-right visible-xs"></span></a></li>	  
		  <li><a href="#faq" data-toggle="tab">Обратная связь<span class="glyphicon glyphicon-chevron-right pull-right visible-xs"></span></a></li>                  
		</ul>
		
        <!--
        <div class="visible-xs" data-toggle="collapse" data-target="#profile">Профиль<span class="caret pull-right"></span></div>
        <div class="visible-xs" data-toggle="collapse" data-target="#orders">История заказов<span class="caret pull-right"></span></div>
        <div class="visible-xs" data-toggle="collapse" data-target="#calculations">Взаиморасчеты<span class="caret pull-right"></span></div>
        <div class="visible-xs" data-toggle="collapse" data-target="#complaints">Рекламации<span class="caret pull-right"></span></div>
        <div class="visible-xs" data-toggle="collapse" data-target="#faq">Обратная связь<span class="caret pull-right"></span></div>
        -->    
        
		<!-- Tab panes -->
		<div class="tab-content">
          
		  <div class="tab-pane active collapse" id="profile">
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
                    
                    <a href="#" class="btn btn-default personal-tab-content-btn-edit">Редактировать данные</a>
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
              <div class="row personal-tab-content-col-fininfo">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="personal-tab-content-col-name-bold">Финансовая информация</div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                    <div class="personal-tab-content-limit"></div>
                    <div class="personal-tab-content-col-fininfo-name">Кредитный лимит:</div>
                    <div class="personal-tab-content-col-fininfo-value"><?echo number_format($arUser["UF_KR_LIMIT"], 2, ',', ' ');?> руб.</div>
                </div>                
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                    <div class="personal-tab-content-saldo"></div>
                    <div class="personal-tab-content-col-fininfo-name">Баланс:</div>
                    <div class="personal-tab-content-col-fininfo-value"><?echo number_format($arUser["UF_BALANCE"], 2, ',', ' ');?> руб.</div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                    <div class="personal-tab-content-indebtedness"></div>
                    <div class="personal-tab-content-col-fininfo-name">Просроченная задолженность:</div>
                    <div class="personal-tab-content-col-fininfo-value"><?echo number_format($arUser["UF_PDZ"], 2, ',', ' ');?> руб.</div>
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
		  <div class="tab-pane collapse" id="orders">Содержание вкладки История заказов</div>
          <div class="tab-pane collapse" id="shipments">Содержание вкладки Отгрузки</div>
          <div class="tab-pane collapse" id="payments">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div>График платежей на <?=date("d.m.Y");?></div>
                    <?if($overdueArray){?>
                    <div class="payments-tab-content-col-name">Просроченная задолженность</div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>№ Накладной</th>
                                <th>Дата отгрузки</th>
                                <th>Срок оплаты</th>
                                <th>Дней просрочки</th>
                                <th>Сумма, руб</th>
                                <th>Задолженность, руб</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?$allDebt = 0;
                        foreach($overdueArray as $payments){
                            $allDebt = $allDebt + $payments["UF_DEBT_SUMM"];     
                        ?>
                            <tr>
                                <td><?echo $payments["UF_WAYBILL"];?></td>
                                <td align="center"><?echo $payments["UF_SHIPPING_DATE"];?></td>
                                <td align="center"><?echo $payments["UF_DUE_DATE"];?></td>
                                <td align="center"><?echo $payments["UF_DELAY_DAYS"];?></td>
                                <td align="right"><?echo number_format($payments["UF_TOTAL"], 2, ',', ' ');?></td>
                                <td align="right"><?echo number_format($payments["UF_DEBT_SUMM"], 2, ',', ' ');?></td>
                            </tr>
                        <?}?> 
                        <tr>
                            <td colspan="6">Просроченная задолженность по оплате составляет: <?echo number_format($allDebt, 2, ',', ' ');?> руб.</td>
                        </tr>   
                        </tbody>
                    </table>
                    <?}?>
                    <?if($currentArray){?>
                    <div class="payments-tab-content-col-name">Текущая задолженность</div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>№ Накладной</th>
                                <th>Дата отгрузки</th>
                                <th>Срок оплаты</th>                                
                                <th>Сумма, руб</th>
                                <th>Задолженность, руб</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?$allDebtCur = 0;
                        foreach($currentArray as $payments){
                            $allDebtCur = $allDebtCur + $payments["UF_DEBT_SUMM"];
                        ?>
                            <tr>
                                <td><?echo $payments["UF_WAYBILL"];?></td>
                                <td align="center"><?echo $payments["UF_SHIPPING_DATE"];?></td>
                                <td align="center"><?echo $payments["UF_DUE_DATE"];?></td>                                
                                <td align="right"><?echo number_format($payments["UF_TOTAL"], 2, ',', ' ');?></td>
                                <td align="right"><?echo number_format($payments["UF_DEBT_SUMM"], 2, ',', ' ');?></td>
                            </tr>
                        <?}?>  
                        <tr>
                            <td colspan="5">Текущая задолженность по оплате составляет: <?echo number_format($allDebtCur, 2, ',', ' ');?> руб.</td>
                        </tr>   
                        </tbody>
                    </table>
                    <?}?>
                </div>
            </div>
          </div>		  
		  <div class="tab-pane collapse" id="faq">
          <div class="user-reg">
            <form name="faqform" method="post">
                <label><input type="text" name="theme" id="theme" placeholder="Тема сообщения" class="personal-input"></label><br />
                <label><textarea name="faqtext" placeholder="Сообщение" class="personal-textarea"></textarea></label><br />
                <input type="button" onclick="sendFaq()" class="tender-send" value="Отправить данные">
            </form>
          </div>  
          </div>
         
		</div>
   </div>
</div>
<?}else{?>
<div>Только для авторизованных пользователей.</div>
<?}?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>