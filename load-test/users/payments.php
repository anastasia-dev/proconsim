<?php
header("Content-Type: text/html; charset=utf-8");
require_once($_SERVER['DOCUMENT_ROOT'] ."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule('iblock');
$url = "payments_test.xml";

if (CModule::IncludeModule('highloadblock')) {
               $arHLBlock = Bitrix\Highloadblock\HighloadBlockTable::getById(4)->fetch();
               $obEntity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($arHLBlock);
               $strEntityDataClass = $obEntity->getDataClass(); 
}


$xml = simplexml_load_file($url);

$count=0;
//echo "<pre>1";
//print_r($xml);
//echo "</pre>";

foreach($xml->Клиент as $clients)
{    
    if(!empty($clients["CA_BitrixID"])){
    
        foreach($clients->Документы->Документ as $doc)
        {
            $UserDocID = 0;
            $err =0;
            if (CModule::IncludeModule('highloadblock')) {
                   $rsUserDocs = $strEntityDataClass::getList(array(
                      'select' => array('*'),
                      'filter' => array('UF_WAYBILL' => (string)$doc["Накладная_Но"], 'UF_USER_ID' => (integer)$clients["CA_BitrixID"]),
                      'order' => array('ID' => 'ASC'),
                      'limit' => '50',
                   ));
                   if ($arItemUserDocs = $rsUserDocs->Fetch()) {                       
                       $UserDocID = $arItemUserDocs["ID"];              
                   }
            } 
            if(!empty($doc["Срок_оплаты"])){
                $arDate = explode(".",$doc["Срок_оплаты"]);  
                //$dueDate = date("d.m.Y", strtotime($arDate[2]."-".$arDate[1]."-".$arDate[0]));
            }
            if(!empty($doc["Дата_отгрузки"])){
                $arShDate = explode(".",$doc["Дата_отгрузки"]);  
                //$dueDate = date("d.m.Y", strtotime($arDate[2]."-".$arDate[1]."-".$arDate[0]));
            }
            $data = array(
                                      
                                      "UF_USER_ID"       => $clients["CA_BitrixID"],
                                      "UF_WAYBILL"       => $doc["Накладная_Но"],
                                      "UF_ORDER"         => $doc["Заказ_Но"],
                                      "UF_INVOICE"       => $doc["СФ_Но"],
                                      "UF_DEBT_SUMM"     => trim(str_replace(chr(194).chr(160), '', html_entity_decode($doc["Сумма_задолженности"]))),
                                      "UF_TOTAL"         => trim(str_replace(chr(194).chr(160), '', html_entity_decode($doc["Сумма_документа"]))),
                                      "UF_DELAY_DAYS"    => $doc["Дней_просрочки"],                                      
                                      "UF_DUE_DATE"      => date("d.m.Y", strtotime($arDate[2]."-".$arDate[1]."-".$arDate[0])),
                                      "UF_SHIPPING_DATE" => date("d.m.Y", strtotime($arShDate[2]."-".$arShDate[1]."-".$arShDate[0])),
                                      
            );
            
            if(empty($UserDocID)){ //добавляем
                
                $result = $strEntityDataClass::add($data);
                $UserDocID = $result->getId();
                
                if(!$result->isSuccess())
                {   
                    echo 'Ошибка добавления записи';
                    echo "<pre>";
                    print_r($result->getErrorMessages());
                    echo "</pre>"; 
                    $err=1;
                } 
            }else{ // редактируем
                $result = $strEntityDataClass::update($UserDocID, $data);
                $UserDocID = $result->getId();
                
                if(!$result->isSuccess())
                {   
                    echo 'Ошибка редактирования записи';
                    echo "<pre>";
                    print_r($result->getErrorMessages());
                    echo "</pre>"; 
                    $err=1;
                } 
            }
        }  
        if(empty($err)){
            $user = new CUser;
            $fields = Array(
                          "LID"               => "ru",
                          "ACTIVE"            => "Y", 
                          "UF_USER_CODE"      => $clients["Код"],
                          "UF_PDZ"            => $clients["ПДЗ"]
             ); 
            if(!$user->Update($clients["CA_BitrixID"], $fields)){
                        echo $user->LAST_ERROR;
            } 
        }  
    }
}    


require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");
?>