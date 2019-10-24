<?            
        $dir = $APPLICATION->GetCurDir();  
        //echo $dir;   
        ?>
        <link rel="stylesheet" href="/bitrix/templates/prok/libs/bootstrap/css/bootstrap-nav.css">
        <link rel="stylesheet" href="/bitrix/templates/prok/css/personal.css">
        <script src="/bitrix/templates/prok/libs/bootstrap/js/bootstrap.min.js"></script>
        
                
        <div class="row personal-new">

        	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding-left">
            
            <!-- Nav tabs -->
        		<ul class="nav nav-tabs">
					<li<?if($dir=="/personal/physical/"){?> class="active"<?}?>><a href="/personal/physical/">Профиль <span class="glyphicon glyphicon-chevron-right pull-right visible-xs"></span></a></li>
					<li<?if($dir=="/personal/physical/orders/"){?> class="active"<?}?>><a href="/personal/physical/orders/">История заказов<span class="glyphicon glyphicon-chevron-right pull-right visible-xs"></span></a></li>	
					<li<?if($dir=="/personal/physical/faq/"){?> class="active"<?}?>><a href="/personal/physical/faq/">Обратная связь<span class="glyphicon glyphicon-chevron-right pull-right visible-xs"></span></a></li>
                </ul>

            <div class="tab-content"> 