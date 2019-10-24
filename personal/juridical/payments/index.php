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
        		
        		
                                
        		<!-- Tab panes -->
        		<div class="tab-content">
                  
        		  <div class="tab-pane active" id="payments">
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