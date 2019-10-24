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
    require($_SERVER["DOCUMENT_ROOT"]."/personal/juridical/personal_top.php"); 
?>      
        		
        		
                                
        		<!-- Tab panes -->
        		<div class="tab-content">
                  
        		  <div class="tab-pane active" id="shipments">Содержание вкладки Отгрузки</div>
                 	  
                </div>
        		
    <?
    require($_SERVER["DOCUMENT_ROOT"]."/personal/juridical/personal_footer.php");
    }else{?>
        <div>У вас нет доступа к Личному кабинету. Пожалуйста, <a href="/register/">зарегистрируйтесь</a>.</div>
    <?}?>
<?}else{?>
    <div>Только для авторизованных пользователей.</div>
<?}?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>