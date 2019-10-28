<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Localization\Loc;


if (strlen($arParams["MAIN_CHAIN_NAME"]) > 0)
{
	$APPLICATION->AddChainItem(htmlspecialcharsbx($arParams["MAIN_CHAIN_NAME"]), $arResult['SEF_FOLDER']);
}

$theme = Bitrix\Main\Config\Option::get("main", "wizard_eshop_bootstrap_theme_id", "blue", SITE_ID);

$availablePages = array();

if ($arParams['SHOW_ORDER_PAGE'] === 'Y')
{
	$availablePages[] = array(
		"path" => $arResult['PATH_TO_ORDERS'],
		"name" => Loc::getMessage("SPS_ORDER_PAGE_NAME"),
		"icon" => '<i class="fa fa-calculator"></i>'
	);
}

if ($arParams['SHOW_ACCOUNT_PAGE'] === 'Y')
{
	$availablePages[] = array(
		"path" => $arResult['PATH_TO_ACCOUNT'],
		"name" => Loc::getMessage("SPS_ACCOUNT_PAGE_NAME"),
		"icon" => '<i class="fa fa-credit-card"></i>'
	);
}

if ($arParams['SHOW_PRIVATE_PAGE'] === 'Y')
{
	$availablePages[] = array(
		"path" => $arResult['PATH_TO_PRIVATE'],
		"name" => Loc::getMessage("SPS_PERSONAL_PAGE_NAME"),
		"icon" => '<i class="fa fa-user-secret"></i>'
	);
}

if ($arParams['SHOW_ORDER_PAGE'] === 'Y')
{

	$delimeter = ($arParams['SEF_MODE'] === 'Y') ? "?" : "&";
	$availablePages[] = array(
		"path" => $arResult['PATH_TO_ORDERS'].$delimeter."filter_history=Y",
		"name" => Loc::getMessage("SPS_ORDER_PAGE_HISTORY"),
		"icon" => '<i class="fa fa-list-alt"></i>'
	);
}

if ($arParams['SHOW_PROFILE_PAGE'] === 'Y')
{
	$availablePages[] = array(
		"path" => $arResult['PATH_TO_PROFILE'],
		"name" => Loc::getMessage("SPS_PROFILE_PAGE_NAME"),
		"icon" => '<i class="fa fa-list-ol"></i>'
	);
}

if ($arParams['SHOW_BASKET_PAGE'] === 'Y')
{
	$availablePages[] = array(
		"path" => $arParams['PATH_TO_BASKET'],
		"name" => Loc::getMessage("SPS_BASKET_PAGE_NAME"),
		"icon" => '<i class="fa fa-shopping-cart"></i>'
	);
}

if ($arParams['SHOW_SUBSCRIBE_PAGE'] === 'Y')
{
	$availablePages[] = array(
		"path" => $arResult['PATH_TO_SUBSCRIBE'],
		"name" => Loc::getMessage("SPS_SUBSCRIBE_PAGE_NAME"),
		"icon" => '<i class="fa fa-envelope"></i>'
	);
}

if ($arParams['SHOW_CONTACT_PAGE'] === 'Y')
{
	$availablePages[] = array(
		"path" => $arParams['PATH_TO_CONTACT'],
		"name" => Loc::getMessage("SPS_CONTACT_PAGE_NAME"),
		"icon" => '<i class="fa fa-info-circle"></i>'
	);
}

$customPagesList = CUtil::JsObjectToPhp($arParams['~CUSTOM_PAGES']);
if ($customPagesList)
{
	foreach ($customPagesList as $page)
	{
		$availablePages[] = array(
			"path" => $page[0],
			"name" => $page[1],
			"icon" => (strlen($page[2])) ? '<i class="fa '.htmlspecialcharsbx($page[2]).'"></i>' : ""
		);
	}
}

if (empty($availablePages))
{
	ShowError(Loc::getMessage("SPS_ERROR_NOT_CHOSEN_ELEMENT"));
}
else
{
	?>
<link rel="stylesheet" href="/bitrix/templates/prok/libs/bootstrap/css/bootstrap-nav.css
">
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
}    
</style>


<div class="row personal-new">
	<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 personal-left">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12 no-padding no-padding-left">
            <div class="personal-left-bg">
            
				<div class="personal-left-top">
                    <div class="col-lg-12 col-md-12 col-sm-8 col-xs-8 no-padding">
                        <div class="personal-left-company">ООО «Ромашка»</div>
                    </div>    
                    <div class="col-lg-12 col-md-12 col-sm-4 col-xs-4">
                        <a href="#" class="personal-exit">Выйти</a>
                    </div>    
                </div>
              
                <div class="personal-left-id">ВАШ НОМЕР: 345</div>
            </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12 no-padding">
            <div class="personal-left-bottom">
                <div class="personal-left-manager">Ваш менеджер</div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-4 col-xs-4">
                        <div class="personal-left-img"><img src="<?=SITE_TEMPLATE_PATH?>/img/manager.jpg" alt="Ваш менеджер Иванова Елена" class="img-circle img-responsive center-block"></div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-8 col-xs-8">
                        <div class="personal-left-manager-name">Иванова Елена</div>
                        <div class="personal-left-phone">
                            <div>+7 495 584-34-65</div>
                            <div>+7 495 358-37-74</div>
                        </div>
                        <div class="personal-left-mail">
                            <a href="mailto:info@mail.ru">info@mail.ru</a>
                        </div>
                    </div>
                </div> 
            </div>                   
            </div>
        </div>
    </div>
	<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 no-padding-left">
		<!-- Nav tabs -->
		<ul class="nav nav-tabs">
		  <li class="active"><a href="#profile" data-toggle="tab">Профиль <span class="glyphicon glyphicon-chevron-right pull-right visible-xs"></span></a></li>
		  <li><a href="#orders" data-toggle="tab">История заказов<span class="glyphicon glyphicon-chevron-right pull-right visible-xs"></span></a></li>
		  <li><a href="#calculations" data-toggle="tab">Взаиморасчеты<span class="glyphicon glyphicon-chevron-right pull-right visible-xs"></span></a></li>
		  <li><a href="#complaints" data-toggle="tab">Рекламации<span class="glyphicon glyphicon-chevron-right pull-right visible-xs"></span></a></li>
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
                    <div class="personal-tab-content-col-name">Контактное лицо</div>
                    <div class="personal-tab-content-col-sub-name">ФИО:</div>
                    <div>Сергей Иванович Смирнов</div>
                    <div class="personal-tab-content-col-sub-name">Телефон:</div>
                    <div>+7 496 739-84-84</div>
                    <div class="personal-tab-content-col-sub-name">Моб. телефон:</div>
                    <div>+7 915 764-93-74</div>
                    <div class="personal-tab-content-col-sub-name">Эл. почта:</div>
                    <div><a href="mailto:romashaka@mail.ru">romashaka@mail.ru</a></div>
                    
                    <a href="#" class="btn btn-default personal-tab-content-btn-edit">Редактировать данные</a>
                  </div>
                  <div class="col-lg-6 col-md-8 col-sm-8 col-xs-12">
                    <div class="personal-tab-content-col-name">Организация</div>
                    <div class="personal-tab-content-col-sub-name">Адрес:</div>
                    <div>160000, Вологодская обл, г Вологда, Окружное ш, д 1, оф 29</div>
                    <div class="personal-tab-content-col-sub-name">Адрес доставки:</div>
                    <div>160000, Вологодская обл, г Вологда, Окружное ш, д 1, оф 29</div>
                    <div class="personal-tab-content-col-inn">
                        <div class="personal-tab-content-col-sub-name">ИНН:</div>
                        <div>12574297547</div>                    
                    </div>
                    <div class="personal-tab-content-col-sub-name">КПП:</div>
                    <div>957387648</div>
                    <div class="personal-tab-content-col-sub-name">ОГРН:</div>
                    <div>5947639875392</div>
                  </div>
			  </div>
              <div class="row personal-tab-content-col-fininfo">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="personal-tab-content-col-name-bold">Финансовая информация</div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                    <div class="personal-tab-content-limit"></div>
                    <div class="personal-tab-content-col-fininfo-name">Кредитный лимит:</div>
                    <div class="personal-tab-content-col-fininfo-value">300 000 руб.</div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                    <div class="personal-tab-content-delay"></div>
                    <div class="personal-tab-content-col-fininfo-name">Срок отсрочки:</div>
                    <div class="personal-tab-content-col-fininfo-value">20 дней</div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                    <div class="personal-tab-content-saldo"></div>
                    <div class="personal-tab-content-col-fininfo-name">Сальдо:</div>
                    <div class="personal-tab-content-col-fininfo-value">20 000 руб.</div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                    <div class="personal-tab-content-indebtedness"></div>
                    <div class="personal-tab-content-col-fininfo-name">Просроченная задолженность:</div>
                    <div class="personal-tab-content-col-fininfo-value">5 000 руб.</div>
                </div>
			  </div>
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
          </div>
		  <div class="tab-pane collapse" id="orders">Содержание вкладки История заказов</div>
		  <div class="tab-pane collapse" id="calculations">Содержание вкладки Взаиморасчеты</div>
		  <div class="tab-pane collapse" id="complaints">Содержание вкладки Рекламации</div>
		  <div class="tab-pane collapse" id="faq">Содержание вкладки Обратная связь</div>
		</div>
   </div>
</div>


	<?
}
?>
