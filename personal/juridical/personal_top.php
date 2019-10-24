<?
     
        $filialID = 0;
        $filial = "";
        $filialPhone = "";
        $filialPriceID = 0;
        $arManager = array();
        //Филиал        
        if(!empty($arUser["UF_FILIAL_CODE"])){
                $arFilialSelect = Array("ID", "IBLOCK_ID", "NAME", "PROPERTY_PHONE_PDF", "PROPERTY_PRICE_ID");
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
                    $filialPriceID = $arFilialFields["PROPERTY_PRICE_ID_VALUE"];
                    //echo "<pre>"; print_r($arFilialFields); echo "</pre>";            
                } 
        }
        //Менеджер
        if(!empty($arUser["UF_MANAGER_ID"])){
                $rsManagers = CUser::GetList(($by = "NAME"), ($order = "desc"), array('ID' => $arUser["UF_MANAGER_ID"]));
        		$arManager = $rsManagers->Fetch();	
                //echo "<pre>"; print_r($arManager); echo "</pre>";	
        }        
               
        $dir = $APPLICATION->GetCurDir();  
        //echo $dir;   
        ?>
        <link rel="stylesheet" href="/bitrix/templates/prok/libs/bootstrap/css/bootstrap-nav.css">
        <link rel="stylesheet" href="/bitrix/templates/prok/css/personal.css">
        <script src="/bitrix/templates/prok/libs/bootstrap/js/bootstrap.min.js"></script>
        
                
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
        		  <li<?if($dir=="/personal/juridical/"){?> class="active"<?}?>><a href="/personal/juridical/">Профиль <span class="glyphicon glyphicon-chevron-right pull-right visible-xs"></span></a></li>
        		  <li<?if($dir=="/personal/juridical/orders/"){?> class="active"<?}?>><a href="/personal/juridical/orders/">История заказов<span class="glyphicon glyphicon-chevron-right pull-right visible-xs"></span></a></li>	
                  <li<?if($dir=="/personal/juridical/shipments/"){?> class="active"<?}?>><a href="/personal/juridical/shipments/">Отгрузки<span class="glyphicon glyphicon-chevron-right pull-right visible-xs"></span></a></li>	
                  <li<?if($dir=="/personal/juridical/payments/"){?> class="active"<?}?>><a href="/personal/juridical/payments/">График платежей<span class="glyphicon glyphicon-chevron-right pull-right visible-xs"></span></a></li>
                  <li<?if($dir=="/personal/juridical/selection/"){?> class="active"<?}?>><a href="/personal/juridical/selection/">Подбор товаров по смете или по заявке<span class="glyphicon glyphicon-chevron-right pull-right visible-xs"></span></a></li>	  
        		  <li<?if($dir=="/personal/juridical/faq/"){?> class="active"<?}?>><a href="/personal/juridical/faq/">Обратная связь<span class="glyphicon glyphicon-chevron-right pull-right visible-xs"></span></a></li>
                  <li<?if($dir=="/personal/juridical/complaints/" || $dir=="/personal/juridical/complaints/new/"){?> class="active"<?}?>><a href="/personal/juridical/complaints/">Рекламации<span class="glyphicon glyphicon-chevron-right pull-right visible-xs"></span></a></li>                  
        		</ul>