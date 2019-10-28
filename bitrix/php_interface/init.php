<?
@require_once 'include/autoload.php';
define("RE_SITE_KEY","6LdlxI8UAAAAAPhkWoO5FGdlQWvpm31KTKbnFq8S");
define("RE_SEC_KEY","6LdlxI8UAAAAAIGku9xXqFfwmCDDJh9P4j-EU4xr"); 


AddEventHandler("main", "OnBeforeUserRegister", "OnBeforeUserUpdateHandler");
AddEventHandler("main", "OnBeforeUserUpdate", "OnBeforeUserUpdateHandler");
AddEventHandler("main", "OnBeforeUserSimpleRegister", "OnBeforeUserUpdateHandler");
function OnBeforeUserUpdateHandler(&$arFields)
{
	global $USER;
    
	//AddMessage2Log("eventFields = ".var_export($arFields,true), true);
    $arGroups = CUser::GetUserGroup($arFields["ID"]);
    $idGroupAdmins = 1;
    if(!in_array($idGroupAdmins,$arGroups)){
        $arFields["LOGIN"] = $arFields["EMAIL"];
	}
    return $arFields;
}


AddEventHandler("main", "OnBeforeUserAdd", "OnBeforeUserAddHandler");
function OnBeforeUserAddHandler(&$arFields)
{
	//AddMessage2Log("user = ".var_export($arFields,true), true); 
    if($arFields["EXTERNAL_AUTH_ID"]=="socservices"){        
        $arFields["GROUP_ID"][]=12;
		if(!empty($arFields["EMAIL"])){
        	$arFields["LOGIN"] = $arFields["EMAIL"];
		}
    } 
    return $arFields;  
}

// при создании нового отзыва отсылать письмо  
AddEventHandler('iblock', 'OnAfterIBlockElementAdd', 'IBElementCreateAfterHandler');
function IBElementCreateAfterHandler(&$arFields) {
	if($arFields['IBLOCK_ID'] == 13) {
		//AddMessage2Log("Fields = ".var_export($arFields,true), true);
         $arSendFields = array(
                                    "SUBJECT" => $arFields["NAME"],    								
                                    "NAME" => $arFields["PROPERTY_VALUES"][42],                             
    								"EMAIL"  => $arFields["PROPERTY_VALUES"][41],
                                    "MARK" => $arFields["PROPERTY_VALUES"][43],
                                    "REVIEW" => $arFields["PREVIEW_TEXT"]
                             	);  
         $send = CEvent::Send("ADD_REVIEW", "s1", $arSendFields, "N", 62);
	}
}


include $_SERVER['DOCUMENT_ROOT']."/bitrix/php_interface/include/SetMinPrice.php";

AddEventHandler("catalog", "OnGetOptimalPrice", "recalculateBasketPrice");

function recalculateBasketPrice($productID, $quantity = 1, $arUserGroups = array(), $renewal = "N", $arPrices = array(), $siteID = false, $arDiscountCoupons = false){
    global $USER;
    $discount_price = 0;
	$catalog_group_id = $_SESSION['PRICE_REGION_NUMER'];
	$arOptPrices = CCatalogProduct::GetByIDEx($productID);
	//AddMessage2Log("PRICES = ".var_export($arOptPrices['PRICES'],true), true);
	$price = $arOptPrices['PRICES'][$catalog_group_id]['PRICE'];
    $currency_code = $arOptPrices['PRICES'][$catalog_group_id]['CURRENCY'];
    $arDiscounts = CCatalogDiscount::GetDiscountByProduct(
        $productID,
        $USER->GetUserGroupArray(),
        "N",
        $catalog_group_id,
        "s1"
    );
	if(is_array($arDiscounts) && sizeof($arDiscounts) > 0) {
            $discount_price = CCatalogProduct::CountPriceWithDiscount($price, $currency_code, $arDiscounts);
	}
	$returnResult = array(
		'PRICE' => array(
			"ID" => $productID,
			'CATALOG_GROUP_ID' => $catalog_group_id,
			'PRICE' => $price,
			'CURRENCY' => "RUB",
			'ELEMENT_IBLOCK_ID' => $productID,
			'VAT_INCLUDED' => "Y",
		),
   		'DISCOUNT_PRICE' => $discount_price,
   		'RESULT_PRICE' => array(
            'BASE_PRICE' => $price,
            'DISCOUNT_PRICE' => $discount_price,
            'DISCOUNT' => $arDiscounts[0]["VALUE"],
            'PERCENT' => $arDiscounts[0]["VALUE"],
            'CURRENCY' => $currency_code,
             ),
        'DISCOUNT_LIST'=> $arDiscounts,
    );
	//AddMessage2Log("Result = ".var_export($returnResult,true), true);
    return $returnResult;
}

function getYMLfooter(){
    $return = '</offers>
      </shop>
    </yml_catalog>';
    return $return;
}

function getYMLhead(){
    $category = "";
    $BID = "2";

    $date = date("Y-m-d H:i");
    $return = '<?xml version="1.0" encoding="UTF-8"?>
        <yml_catalog date="'.$date.'">
        <shop>
        <name>ПРОКОНСИМ</name>
        <company>ПРОКОНСИМ</company>
        <url>https://proconsim.ru</url>
<currencies>
<currency id="RUB" rate="1"/>
<currency id="USD" rate="64.81"/>
<currency id="EUR" rate="71.71"/>
<currency id="UAH" rate="2.604"/>
<currency id="BYN" rate="32.34"/>
</currencies>
        <categories>';

    $arFilterCat = Array('IBLOCK_ID'=>$BID, 'ACTIVE' => 'Y', 'GLOBAL_ACTIVE'=>'Y');
    $db_list_cat = CIBlockSection::GetList(Array( "id" => "asc" ), $arFilterCat, true);
    while($arSec= $db_list_cat->fetch()){

        if(!empty($arSec["IBLOCK_SECTION_ID"])){
            $parent=" parentId=\"".$arSec["IBLOCK_SECTION_ID"]."\"";
        }
        else{
            $parent="";
        }
        $cat  = '<category id="'.$arSec["ID"].'"'.$parent.'>';
        $cat .= yandex_text2xml_customizedUnicode( $arSec["NAME"], true );
        $cat .= '</category>';
        $category .= $cat;

    }
    $return .= $category;
    $return .= '</categories>
        <delivery-options>
          <option cost="1000" days="1-3"/>
        </delivery-options>
        <cpa>1</cpa>
        <offers>';
    return $return;
}

function AgentGetForgottenBaskets()
{
    global $DB;
    if(!CModule::IncludeModule('sale'))
      return "AgentGetForgottenBaskets();";
    
    if(!CModule::IncludeModule('iblock'))
      return "AgentGetForgottenBaskets();";
    
    $by = "DATE_UPDATE_MAX";
    $order = "DESC";
    
    $timeStart = time() - 24 * 60 * 60;
    $timeEnd = time() - 1 * 60 * 60;
    $arFilter = array("ORDER_ID"=>"",">=DATE_UPDATE" => date('d.m.Y H:i:s', $timeStart), "<=DATE_UPDATE" => date("d.m.Y H:i:s",$timeEnd), "USER_GROUP_ID"=>array(5));
    
    $dbResultList = CSaleBasket::GetLeave(
    	array($by => $order),
    	$arFilter,
    	false
    );
    
    while ($arBasket = $dbResultList->Fetch())
    {    	
        $filename = $_SERVER['DOCUMENT_ROOT']."/upload/basket/basket_".$arBasket['FUSER_ID'].".txt";
        if (!file_exists($filename)) {
        
        	$EventFields = array();
        	$EventFields['POST_TEXT'] = "Дата создания: ".date('d.m.Y H:i:s', MakeTimeStamp($arBasket["DATE_INSERT_MIN"]));
            $EventFields['POST_TEXT'] .= "\nДата последнего изменения: ".date('d.m.Y H:i:s', MakeTimeStamp($arBasket["DATE_UPDATE_MAX"]));
        
        	if(!empty($arBasket['USER_NAME'])){
           		$EventFields['POST_TEXT'] .= "\n".$arBasket['USER_NAME']; 
        	}
            if(!empty($arBasket['USER_LAST_NAME'])){
           		$EventFields['POST_TEXT'] .= "\n".$arBasket['USER_LAST_NAME']; 
        	}
            if(!empty($arBasket['USER_EMAIL'])){
           		$EventFields['POST_TEXT'] .= "\n".$arBasket['USER_EMAIL']; 
        	}
            $EventFields['POST_TEXT'] .= "\nСтоимость ".$arBasket['PRICE_ALL']." ".$arBasket['CURRENCY'];
        	$EventFields['POST_TEXT'] .= "\n\nТовары:";
        	$arFilterBasket = Array("ORDER_ID" => false, "FUSER_ID" => $arBasket["FUSER_ID"], "LID" => $arBasket["LID"]);
        
        	$arBasketItems = array();
        
        	$dbB = CSaleBasket::GetList(
        		array("ID" => "ASC"),
        		$arFilterBasket,
        		false,
        		false,
        		array("ID", "PRODUCT_ID", "NAME", "QUANTITY", "PRICE", "CURRENCY", "DETAIL_PAGE_URL", "LID", "CAN_BUY", "SUBSCRIBE", "DELAY", "SET_PARENT_ID", "TYPE")
        	);
            $count = 1;
            $text = "";
            $fp = fopen($filename, "w");
        	while($arBasketItems = $dbB->Fetch()){        		
                $EventFields['POST_TEXT'] .= "\n".$count.":";
        		$EventFields['POST_TEXT'] .= "\n".$arBasketItems['NAME'];
        		$arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM", 'PROPERTY_ARTNUMBER');
        		$arFilter = Array("ID"=>$arBasketItems['PRODUCT_ID']);
        		$res_CI = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);	
        		while($ob_CI = $res_CI->GetNextElement())
        		{
        			$arFields_CI = $ob_CI->GetFields();
        			$EventFields['POST_TEXT'] .= " (арт. ".$arFields_CI['PROPERTY_ARTNUMBER_VALUE'].")";
        			$text .= "~".$arFields_CI['PROPERTY_ARTNUMBER_VALUE']."~|~".$arBasketItems['QUANTITY']."~\r\n";        						
        		}        
        		$EventFields['POST_TEXT'] .= "\nВ количестве ".$arBasketItems['QUANTITY']." шт.";
        		$EventFields['POST_TEXT'] .= "\nЦена - ".$arBasketItems['PRICE']." ".$arBasketItems['CURRENCY'];
        		$EventFields['POST_TEXT'] .= "\n\n";
                $count++;
        		
        	}
            fwrite($fp, $text);
            fclose($fp);
            //AddMessage2Log("EventFields = ".var_export($EventFields,true), true);
            $resSend = CEvent::Send("SALE_BASKET", 's1', $EventFields,"N",64,array($filename));            
        }
    }    
    return "AgentGetForgottenBaskets();"; 
}   

function AgentLoadClients()
{    
    global $USER;    
    
    if(!CModule::IncludeModule('iblock'))
      return "AgentLoadClients();";
    
    $url = $_SERVER['DOCUMENT_ROOT'] ."/import/clients.xml";
    $xml = simplexml_load_file($url);
    //AddMessage2Log("xml = ".var_export($xml,true), true);
	//AddMessage2Log("url = ".var_export($url,true), true);
    
   
    foreach($xml as $clients)
    {	
        $filialID =0;  
        $filial = ""; 
        $managerID =0;  
        $manager = "";
        $firstUpdate =0; 
        $BitrixUserID = (int)$clients["CA_BitrixID"];   
        if(!empty($BitrixUserID)){
            //Обновление
            $rsUserUp = CUser::GetList(($by = "NAME"), ($order = "desc"), array('ID' => $BitrixUserID), array("SELECT"=>array("UF_FIRST_UPDATE")));
    		while ($arUserUp = $rsUserUp->Fetch()) {		
                $firstUpdate = $arUserUp["UF_FIRST_UPDATE"];			
    		} 
           // филиал
            $arSelect = Array("ID", "IBLOCK_ID", "NAME", "PROPERTY_FILIAL_CODE");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
            $arFilter = Array(
                            "IBLOCK_ID"=>6,
                            "PROPERTY_FILIAL_CODE" => $clients["ЦФО"] 
                        );
            $resProduct = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
            if($ob = $resProduct->GetNextElement()){ 
                $arFields = $ob->GetFields(); 
                $filialID = $arFields["ID"];
                $filial = $arFields["NAME"];            
            } 
            //Менеджер
            $rsManagers = CUser::GetList(($by = "NAME"), ($order = "desc"), array('=UF_USER_CODE' => (string)$clients["МенеджерКод"]));
    		while ($arUser = $rsManagers->Fetch()) {		
                $managerID = $arUser["ID"];
                $manager = $arUser["LAST_NAME"];
    		}           
             
			//AddMessage2Log("CA_BitrixID = ".var_export($BitrixUserID,true), true);  
			//AddMessage2Log("firstUpdate = ".var_export($firstUpdate,true), true);  
			//AddMessage2Log("filialID = ".var_export($filialID,true), true);  
			//AddMessage2Log("managerID = ".var_export($managerID,true), true); 
              
            //if(!empty($filialID)){
                 $user = new CUser;
                 
                 if(isset($clients["ЦеноваяГруппа"]) && !empty($clients["ЦеноваяГруппа"])){
                    $clientGroup = $clients["ЦеноваяГруппа"];
                    $arAddGroup = array();
                    $userGroups = CUser::GetUserGroup($BitrixUserID); // Группы пользователя
                    $arPriceGroups = array("13"=>"A1","14"=>"A2","15"=>"B1","16"=>"B2");
                    $arPrices = array_keys($arPriceGroups);
                    $key = array_search($clientGroup, $arPriceGroups);
                    if (false !== $key) {                	
                        $resIntersect = array_intersect($arPrices, $userGroups);
                        $countIntersect = count($resIntersect);
                        if($countIntersect==1 and $key==$resIntersect[0]) {
                            $arAddGroup = array();
                        } elseif (count($resIntersect)==0) {
                             $arAddGroup = array($key); 
                        } else {                            
                        	foreach($resIntersect as $val){
                                if(in_array($val, $userGroups)){  
                                    $arIndex = array_keys($userGroups, $val);              
       						        unset($userGroups[$arIndex[0]]);   
                                }
                            }
                            $arAddGroup = array($key); 
                        }
              			if($arAddGroup){
                            $resUserGroups = array_merge($userGroups, $arAddGroup);
                            CUser::SetUserGroup($BitrixUserID, $resUserGroups);
              			}
          		    }

                 }
                 
                 $fields = Array(
                              "LID"               => "ru",
                              "ACTIVE"            => "Y",                  
                              "WORK_PHONE"        => $clients["Телефон"],      // Телефон  
                              "WORK_COMPANY"      => $clients["Наименование"], 
                              "UF_USER_CODE"      => $clients["Код"],        // код пользователя
                              "UF_FILIAL_CODE"    => $clients["ЦФО"],         // код филиала
                              //"UF_FILIAL"         => $filialID,                // id филиала
                              "UF_INN"            => $clients["ИНН"],
                              "UF_KPP"            => $clients["КПП"],
                              "UF_OGRN"           => $clients["ОГРН"],                              
                              "UF_KR_LIMIT"       => $clients["КР_ЛИМИТ"],
                              "UF_BALANCE"        => $clients["БАЛАНС"],
                              "UF_PDZ"            => $clients["ПДЗ"],
                 ); 
                 if(!empty($filialID)){
                    $fields["UF_FILIAL"] = $filialID;
                 }
                 if(!empty($managerID)){
                    $fields["UF_MANAGER_ID"] = $managerID;
                 }
                 if(empty($firstUpdate)){
                    $fields["UF_FIRST_UPDATE"] = 1;
                 }
                $sendName = ""; 
                foreach($clients->Контакт_ЛК as $lk){              
                   $fields["LAST_NAME"] = $lk["Фамилия"];
                   $fields["NAME"] = $lk["Имя"];
                   $fields["SECOND_NAME"] = $lk["Отчество"];
                   if(!empty($lk["Email"])){
                       $fields["EMAIL"] = $lk["Email"];
                   }              
                   $fields["PERSONAL_MOBILE"] = $lk["Моб_телефон"];
                   if(!empty($lk["Имя"])){
                     $sendName .= $lk["Имя"]." ";
                   }
                   if(!empty($lk["Отчество"])){
                     $sendName .= $lk["Отчество"]." ";
                   }
                   if(!empty($lk["Фамилия"])){
                     $sendName .= " ".$lk["Фамилия"]." ";
                   }
                   if(!empty($sendName)){
                     $sendName= substr($sendName,0,-1);
                   }
      	         }
                
				//AddMessage2Log("fields = ".var_export($fields,true), true);        
                if(!$user->Update($BitrixUserID, $fields)){                            
					//AddMessage2Log("UpdateUserError= ".var_export($user->LAST_ERROR,true), true);
                }else{
                            // отправка пиьсма
                            if(empty($firstUpdate)){
                                    $arSendFields = array(                                       								
                                        "NAME" => $sendName,                             
        								"EMAIL"  => $fields["EMAIL"],
                                        "WORK_PHONE" => $fields["WORK_PHONE"],
                                        "WORK_COMPANY" => $fields["WORK_COMPANY"],
                                        "USER_CODE"  => $fields["UF_USER_CODE"],
                                        "FILIAL"  => $filial,
                                        "INN"  => $fields["UF_INN"],
                                        "KPP"  => $fields["UF_KPP"],
                                        "OGRN"  => $fields["UF_OGRN"],
                                        "KR_LIMIT"  => $fields["UF_KR_LIMIT"],
                                        "BALANCE"  => $fields["UF_BALANCE"],
                                        "PDZ"  => $fields["UF_PDZ"],
                                        "MANAGER"  => $manager,
                                        "PERSONAL_MOBILE"  => $fields["PERSONAL_MOBILE"]
                                 	); 
								//AddMessage2Log("arSendFields = ".var_export($arSendFields,true), true);                                       
                                  $send = CEvent::Send("USER_FIRST_UPDATE", "s1", $arSendFields, "N", 63);                            
                            }
                }  
           //}  
                              
        }
    }
    
    return "AgentLoadClients();";   
}

function AgentLoadManager()
{    
    global $USER;    
    
    if(!CModule::IncludeModule('iblock'))
      return "AgentLoadManager();";
    
    $url = $_SERVER['DOCUMENT_ROOT'] ."/import/managers.xml";
    $xml = simplexml_load_file($url);
    
    foreach($xml as $managers)
    {
        $userID = 0;
        $filialID = 0;
    	if(!empty($managers["Email"])){
    		$rsUsers = CUser::GetList(($by = "NAME"), ($order = "desc"), array('=EMAIL' => $managers["Email"]));
    		while ($arUser = $rsUsers->Fetch()) {		
                $userID = $arUser["ID"];    			
    		}
            
            // филиал
            $arSelect = Array("ID", "IBLOCK_ID", "PROPERTY_FILIAL_CODE");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
            $arFilter = Array(
                            "IBLOCK_ID"=>6,
                            "PROPERTY_FILIAL_CODE" => $managers["ЦФО"] 
                        );
            $resProduct = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
            if($ob = $resProduct->GetNextElement()){ 
                $arFields = $ob->GetFields(); 
                $filialID = $arFields["ID"];
            }  
            if(!empty($filialID)){
                if(empty($userID)){ // добавляем
                    $new_password = randString(7);
                    $user = new CUser;
                    $arFields = Array(              
                      "LAST_NAME"         => $managers["ФИО"],  // Фамилия  
                      "EMAIL"             => $managers["Email"],      // E-mail
                      "LOGIN"             => $managers["Email"],      // Логин
                      "LID"               => "ru",                    // Сайт  
                      "ACTIVE"            => "Y",                     // Активность  
                      "GROUP_ID"          => array(5,8),            // Группы  
                      "PASSWORD"          => $new_password,           // Пароль  
                      "CONFIRM_PASSWORD"  => $new_password,           // Подтверждение пароля  
                      "WORK_PHONE"        => $managers["Телефон"],      // Телефон  
                      "UF_USER_CODE"      => $managers["Код"],        // код пользователя
                      "UF_FILIAL_CODE"    => $managers["ЦФО"],         // код филиала
                      "UF_FILIAL"         => $filialID                // id филиала
                    );                    
               	
                    $newUserID = $user->Add($arFields);
                    if (!intval($newUserID) > 0){                         
                         AddMessage2Log("AddManagerError= ".var_export($user->LAST_ERROR,true), true);
                    }
                }else{ // редактируем
                    $user = new CUser;
                    $fields = Array(
                      "LAST_NAME"         => $managers["ФИО"],
                      "EMAIL"             => $managers["Email"],
                      "LOGIN"             => $managers["Email"],
                      "LID"               => "ru",
                      "ACTIVE"            => "Y",
                      "GROUP_ID"          => array(5,8),
                      "WORK_PHONE"        => $managers["Телефон"],      // Телефон  
                      "UF_USER_CODE"      => $managers["Код"],        // код пользователя
                      "UF_FILIAL_CODE"    => $managers["ЦФО"],         // код филиала
                      "UF_FILIAL"         => $filialID                // id филиала
                      );
                    if(!$user->Update($userID, $fields)){                        
                        AddMessage2Log("UpdateManagerError= ".var_export($user->LAST_ERROR,true), true);
                    }
                    
                }
            }
    	}
    }    
    
    return "AgentLoadManager();"; 
} 

function AgentLoadPayments()
{    
    global $USER;    
    
    if(!CModule::IncludeModule('iblock'))
      return "AgentLoadPayments();";
    
    if (CModule::IncludeModule('highloadblock')) {
               $arHLBlock = Bitrix\Highloadblock\HighloadBlockTable::getById(4)->fetch();
               $obEntity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($arHLBlock);
               $strEntityDataClass = $obEntity->getDataClass(); 
    }
    
    $url = $_SERVER['DOCUMENT_ROOT'] ."/import/payments.xml";
    $xml = simplexml_load_file($url);
    
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
                }
                if(!empty($doc["Дата_отгрузки"])){
                    $arShDate = explode(".",$doc["Дата_отгрузки"]);                      
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
                        AddMessage2Log("AddPaymentError= ".var_export($result->getErrorMessages(),true), true); 
                        $err=1;
                    } 
                }else{ // редактируем
                    $result = $strEntityDataClass::update($UserDocID, $data);
                    $UserDocID = $result->getId();
                    
                    if(!$result->isSuccess())
                    {  
                        AddMessage2Log("UpdatePaymentError= ".var_export($result->getErrorMessages(),true), true);
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
                            AddMessage2Log("UpdatePaymentError= ".var_export($user->LAST_ERROR,true), true);
                } 
            }  
        }
    }
    
    return "AgentLoadPayments();";
    
}   

function cut_text($html, $size){

    $symbols = strip_tags($html);
    $symbols_len = strlen($symbols);
    
    if(empty($size)){
        $size = strlen($html);
    }
     
    $resArray = array();
    if($symbols_len < strlen($html))
    {    
        $posPclose = strpos($html, "</p>");
        if($posPclose<$size){
            $posPclose = $posPclose+3;
            $posPclose = strpos($html, "</p>", $posPclose);
        }    
        $posPclose = $posPclose-1;    
        $resArray["SHORT_TEXT"] =  trim(substr($html, 0, $posPclose))."...</p>";    
        $posHideText = $posPclose+1;    
        $resArray["HIDE_TEXT"] = substr($html, $posHideText); 
          
     } elseif($symbols_len > $size){
        $resArray["SHORT_TEXT"] = substr($html, 0, $size)."...";
        $resArray["HIDE_TEXT"] = substr($html, $size);
     }else{
        $resArray["SHORT_TEXT"] = $html;
        $resArray["HIDE_TEXT"] = "";
     }   
    return $resArray;
}        
if(file_exists($_SERVER["DOCUMENT_ROOT"]."/seomod/include.php")) @require($_SERVER["DOCUMENT_ROOT"]."/seomod/include.php");
function sitemaprun(){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://proconsim.ru/bitrix/seo_sitemap_run.php");
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$output = curl_exec($ch);
	curl_close($ch);
	return('sitemaprun();');
}
function getCountFavorites($us,$cook) {
	$arFavElements = getFavorites($us,$cook);

	if(empty($arFavElements)) {
		return 0;
	} else {
		return count($arFavElements);
	}
}

function getFavorites($us,$cook) {
	if(!$us->IsAuthorized()){
		$arFavElements = unserialize($cook);
	}
	else{
		$idUser = $us->GetID();
		$rsUser = CUser::GetByID($idUser);
		$arUser = $rsUser->Fetch();
		$arFavElements = unserialize($arUser['UF_FAVORITES']);
	}

	return $arFavElements;
}

?>