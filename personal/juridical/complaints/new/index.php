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
        if($_POST){
            
            
            //echo "<pre>";
            //print_r($_FILES);
            //echo "</pre>";


			// options for ssl in php 5.6.5
			$opts = array(
				'ssl' => array(
					'ciphers' => 'RC4-SHA',
					'verify_peer' => false,
					'verify_peer_name' => false
				)
			);
			
			$url="http://213.184.131.70:8081/Modules/EleWise.ELMA.Workflow.Processes.Web/WFPWebService.asmx";
			$params = array(
				'encoding' => 'UTF-8',
				'verifypeer' => false,
				'verifyhost' => false,
				'soap_version' => SOAP_1_2,
				'trace' => 1,
				'exceptions' => 1,
				'connection_timeout' => 180,
				'stream_context' => stream_context_create($opts),
				'location' => $url
			);

            $userName="web";
			$password="dpcQP0WrnB"; 
			$token = "4945fdee-7421-436b-b0c0-ec2e51842ced";

            $EventFields = array();
            $uploaddir = $_SERVER["DOCUMENT_ROOT"].'/upload/complaints/';
            $arSendFiles = array();
            $PROPS = array();

            $data = new stdClass();
            $data->Items = new stdClass();
            $data->Items->WebDataItem = array();

            $data->Items->WebDataItem[] = array("Name"=>"KodKlientaNAV", "Value"=>$arUser["UF_USER_CODE"]);
            $data->Items->WebDataItem[] = array("Name"=>"PodachaCherezLKWEB", "Value"=>"true");

            $EventFields["COMPANY"] = $arUser["WORK_COMPANY"];
            $EventFields["INN"] = $arUser["UF_INN"];            
                    
            $EventFields["TTN"] = htmlspecialchars($_POST["ttn"], ENT_QUOTES, "cp1251", FALSE);

            $EventFields["SHIPMENT_DATE"] = htmlspecialchars($_POST["shipmentDate"], ENT_QUOTES, "cp1251", FALSE);
            $soap_date = strtotime(htmlspecialchars($_POST["shipmentDate"], ENT_QUOTES, "cp1251", FALSE));
            $data->Items->WebDataItem[] = array("Name"=>"DataOtgruzki", "Value"=>date("m.d.Y",$soap_date ));

            $count = intval($_POST["count"]);
            
            $EventFields['POST_TEXT'] = "";
            $EventFields['POST_TEXT'] .= "\n\nНоменклатура:";
            $arProducts = array();
            for($i=1;$i<=$count;$i++){
                $EventFields['POST_TEXT'] .= "\n".$i.":";
                $EventFields['POST_TEXT'] .= "\n".htmlspecialchars($_POST["product_".$i], ENT_QUOTES, "cp1251", FALSE);

                $EventFields['POST_TEXT'] .= " (арт. ".intval($_POST["artikul_".$i]).")";
                $data->Items->WebDataItem[] = array("Name"=>"ArtikulTovara", "Value"=>intval($_POST["artikul_".$i]));
                $instanceName = date("d.m.Y")."-".$arUser["UF_USER_CODE"]."-".intval($_POST["artikul_".$i]); //название экземпляра процесса

                $EventFields['POST_TEXT'] .= "\nВ количестве ".intval($_POST["quantity_".$i])." шт.";
                $data->Items->WebDataItem[] = array("Name"=>"KolichestvoTovara", "Value"=>intval($_POST["quantity_".$i]));

                $EventFields['POST_TEXT'] .= "\nЦена: ".$_POST["price_".$i]." р.";
                $data->Items->WebDataItem[] = array("Name"=>"Cena", "Value"=>$_POST["price_".$i]);

                $EventFields['POST_TEXT'] .= "\nСумма: ".$_POST["summa_".$i]." р.";

                $EventFields['POST_TEXT'] .= "\nДоставка: ".htmlspecialchars($_POST["delivery_".$i], ENT_QUOTES, "cp1251", FALSE);
                $data->Items->WebDataItem[] = array("Name"=>"Dostavka", "Value"=>htmlspecialchars($_POST["delivery_".$i], ENT_QUOTES, "cp1251", FALSE));

                if(!empty($_POST["producer_".$i])){
                    $EventFields['POST_TEXT'] .= "\nПроизводитель: ".htmlspecialchars($_POST["producer_".$i], ENT_QUOTES, "cp1251", FALSE);
                    $data->Items->WebDataItem[] = array("Name"=>"ProizvoditeljTovaraPoPasportu", "Value"=>htmlspecialchars($_POST["producer_".$i], ENT_QUOTES, "cp1251", FALSE)); 
                }

                if(!empty($_POST["serialNumber_".$i])){
                    $EventFields['POST_TEXT'] .= "\nСерийный номер или номер пломбы : ".htmlspecialchars($_POST["serialNumber_".$i], ENT_QUOTES, "cp1251", FALSE);
                    $data->Items->WebDataItem[] = array("Name"=>"NomerPlombyIliSeriynyy", "Value"=>htmlspecialchars($_POST["serialNumber_".$i], ENT_QUOTES, "cp1251", FALSE));
                }

                $EventFields['POST_TEXT'] .= "\nОписание неисправности: ".htmlspecialchars($_POST["defect_".$i], ENT_QUOTES, "cp1251", FALSE);
                $data->Items->WebDataItem[] = array("Name"=>"OpisanieNeispravnosti", "Value"=>htmlspecialchars($_POST["defect_".$i], ENT_QUOTES, "cp1251", FALSE));

                $EventFields['POST_TEXT'] .= "\nТребования к поставщику: ".htmlspecialchars($_POST["requirement_".$i], ENT_QUOTES, "cp1251", FALSE);
                $data->Items->WebDataItem[] = array("Name"=>"TrebovaniyaPokupatelya", "Value"=>htmlspecialchars($_POST["requirement_".$i], ENT_QUOTES, "cp1251", FALSE));

                $EventFields['POST_TEXT'] .= "\n\n";
                $arProducts[] = intval($_POST["productID_".$i]);
            }                   
            
            $PROPS["USER_ID"] = array($USER->GetID());
            $PROPS["PRODUCTS"] = $arProducts;
            $PROPS["STATUS"] = "Ожидает проверки"; 
            
            $el = new CIBlockElement;
            $arLoadArray = Array(                          
                          "IBLOCK_ID"      => 24,
                          "PROPERTY_VALUES"=> $PROPS,                          
                          "NAME"           => "Рекламация ".$arUser["WORK_COMPANY"],
                          "DATE_ACTIVE_FROM" => date("d.m.Y H:i:s"),
                          "ACTIVE"         => "Y",
                          );
           
           if($NEW_ID = $el->Add($arLoadArray)) {       
               $EventFields["BITRIX_ID"] = $NEW_ID;
               
			   $EMAILS = array();
                //$res = CIBlockElement::GetProperty(6, $filialID, "sort", "asc", array("CODE" => "COMPLAINTS_EMAILS"));
                //while ($ob = $res->GetNext())
                //{
                    //$EMAILS[] = $ob['VALUE'];
                //} 
               $EventFields["EMAILS"] = implode(',', $EMAILS);
               $file_xml_string = "<?xml version=\"1.0\" encoding=\"UTF-16\"?><Files>";
			   //echo "<pre>";
			   //print_r($_FILES);
			   //echo "</pre>";
               $count_photo_files = 0;
               foreach($_FILES as $key=>$files){
                 if($files['error']==0){
                    $uploadAccountFile = $uploaddir . basename($files['name']);                
                    if(!move_uploaded_file($files['tmp_name'], $uploadAccountFile)){
                        echo "Ошибка загрузки файла ".$files['name']."<br />";
                    }else{
						if($key=="akt_1"){
							$file_xml_string .= "<ActFile><Name>".basename($files['name'])."</Name><Data>".base64_encode(file_get_contents($uploadAccountFile, FILE_USE_INCLUDE_PATH))."</Data></ActFile>";
						}else{
                            $count_photo_files++;
							if($count_photo_files==1){
                                $file_xml_string .= "<PhotoFiles>"; 
							}
                            $file_xml_string .= "<PhotoFile><Name>".basename($files['name'])."</Name><Data>".base64_encode(file_get_contents($uploadAccountFile, FILE_USE_INCLUDE_PATH))."</Data></PhotoFile>";
						}
                        $arSendFiles[] = $uploadAccountFile;
                    }
                 }   
               }
			   if($count_photo_files>0){ $file_xml_string .= "</PhotoFiles>"; }
               $file_xml_string .= "</Files>";
               $data->Items->WebDataItem[] = array("Name"=>"FilesString", "Value"=>$file_xml_string);
			   //echo "<pre>";
			   //print_r($data->Items->WebDataItem);
			   //echo "</pre>";

               $client = new SoapClient($url."?WSDL", $params);
               $parameters = array(
                    "userName"=>$userName,
                    "password"=>$password,
                    "token"=>$token,
                    "instanceName"=>$instanceName,
                    "data"=>$data);

               $client->Run($parameters);
               $res = $client->__getLastResponse();
			   $xml = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $res);
			   $xml = simplexml_load_string($xml);
			   $json = json_encode($xml);
			   $responseArray = json_decode($json,true); 
               $elmaID = $responseArray["soapbody"]["runresponse"]["runresult"];
			   if(intval($elmaID)>0){
                   CIBlockElement::SetPropertyValuesEx($NEW_ID, 24, array("ELMA_ID" => $elmaID));
			   }
			   //$send = CEvent::Send("COMPLAINTS", "s1", $EventFields, "N", 81, $arSendFiles);
			   //if($send){
                    // удаляем файлы
                    foreach($arSendFiles as $delFile){
                        unlink($delFile);
                    }
					echo "<p>Ваш запрос успешно отправлен! В ближайшее время с Вами свяжется наш менеджер.</p>";
			   //}
               
           } else {               
               echo $el->LAST_ERROR;
           }
        }else{        

             
?>  
<script src="script.js"></script>
        		<!-- Tab panes -->
        		<div class="tab-content">
                  
        		  <div class="tab-pane active" id="complaintsNew">

<?

echo "<form method=\"post\" class=\"not-send\" action=\"\" name=\"complaints\" id=\"complaints\" enctype=\"multipart/form-data\">\n";
echo "<input type=\"hidden\" id=\"filialPriceID\" name=\"filialPriceID\" value=\"".$filialPriceID."\">\n";
echo "<div class=\"row\">\n";
echo "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-5\">\n";
echo "<label for=\"ttn\">Номер УПД, по которой прошла отгрузка* </label>\n";
echo "<input type=\"text\" class=\"form-control required\" id=\"ttn\" name=\"ttn\">\n";
echo "</div>\n"; 
echo "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-3\">\n";
echo "<label for=\"shipmentDate\">Дата отгрузки*</label>\n";
echo "<input type=\"date\" class=\"form-control required\" id=\"shipmentDate\" name=\"shipmentDate\">\n";
echo "</div>\n"; 
echo "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-4\">\n";
echo "<label for=\"delivery_1\">Как осуществлялась доставка*</label>\n";
echo "<select name=\"delivery_1\" id=\"delivery_1\" class=\"required\">\n";
echo "<option value=\"\"></option>\n";
echo "<option value=\"Самовывоз\">Самовывоз</option>\n"; 
echo "<option value=\"Доставка Проконсим\">Доставка Проконсим</option>\n"; 
echo "<option value=\"Доставка Транспортной компанией\">Доставка Транспортной компанией</option>\n"; 
echo "</select>\n"; 
echo "</div>\n"; 
echo "</div>\n"; 

echo "<div class=\"row grey\">\n";
echo "<div class=\"row\">";
echo "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-2\">\n";
echo "<label for=\"artikul_1\">Артикул<br />товара*</label>\n";
echo "<input type=\"text\" class=\"form-control required\" id=\"artikul_1\" name=\"artikul_1\">\n";
echo "<input type=\"hidden\" id=\"productID_1\" name=\"productID_1\">\n";
echo "</div>\n"; 
echo "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-4\">\n";
echo "<label for=\"product_1\">Наименование<br />товара*</label>\n";
echo "<input type=\"text\" class=\"form-control required\" id=\"product_1\" name=\"product_1\" readonly>\n";
echo "</div>\n"; 
echo "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-2\">\n";
echo "<label for=\"quantity_1\">Количество,<br />шт*</label>\n";
echo "<input type=\"text\" class=\"form-control required\" id=\"quantity_1\" name=\"quantity_1\">\n";
echo "</div>\n"; 
echo "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-2\">\n";
echo "<label for=\"price_1\">Цена<br />единицы, руб*</label>\n";
echo "<input type=\"text\" class=\"form-control required\" id=\"price_1\" name=\"price_1\" readonly>\n";
echo "</div>\n";
echo "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-2\">\n";
echo "<label for=\"summa_1\">Сумма,<br />руб*</label>\n";
echo "<input type=\"text\" class=\"form-control required\" id=\"summa_1\" name=\"summa_1\" readonly>\n";
echo "</div>\n";



echo "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-6\">\n";
echo "<label for=\"producer_1\">Производитель товара по паспорту</label>\n";
echo "<input type=\"text\" class=\"form-control\" id=\"producer_1\" name=\"producer_1\">\n";
echo "</div>\n"; 
echo "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-6\">\n";
echo "<label for=\"serialNumber_1\">Серийный номер или номер пломбы </label>\n";
echo "<input type=\"text\" class=\"form-control\" id=\"serialNumber_1\" name=\"serialNumber_1\">\n";
echo "</div>\n"; 
echo "</div>\n";

echo "<div class=\"row\">";
echo "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-8\">\n";
echo "<label for=\"defect_1\">Описание<br />неисправности*</label>\n";
echo "<textarea class=\"form-control required\" id=\"defect_1\" name=\"defect_1\"></textarea>\n";
echo "</div>\n"; 

echo "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-4\">\n";
echo "<label for=\"requirement_1\">Требования к поставщику<br />относительно Товара*</label>\n";
echo "<textarea class=\"form-control required\" id=\"requirement_1\" name=\"requirement_1\"></textarea>\n";
echo "</div>\n"; 
echo "</div>\n"; 

echo "<div class=\"row\">";
echo "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">\n";
echo "<div class=\"load-files\">Загрузки файлов *</div>\n";
echo "<label for=\"akt_1\">Акт рекламации, подписанный контрагентом*</label>\n";
echo "<input type=\"file\" class=\"form-control required\" id=\"akt_1\" name=\"akt_1\">\n";
echo "</div>\n";
echo "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-4\">\n";
echo "<label for=\"photo1_1\">Фото 1</label>\n";
echo "<input type=\"file\" class=\"form-control required\" id=\"photo1_1\" name=\"photo1_1\">\n";
echo "</div>\n";
echo "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-4\">\n";
echo "<label for=\"photo2_1\">Фото 2</label>\n";
echo "<input type=\"file\" class=\"form-control required\" id=\"photo2_1\" name=\"photo2_1\">\n";
echo "</div>\n";
echo "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-4\">\n";
echo "<label for=\"photo3_1\">Фото 3</label>\n";
echo "<input type=\"file\" class=\"form-control required\" id=\"photo3_1\" name=\"photo3_1\">\n";
echo "</div>\n"; 
echo "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-4\">\n";
echo "<label for=\"photo4_1\">Фото 4</label>\n";
echo "<input type=\"file\" class=\"form-control\" id=\"photo4_1\" name=\"photo4_1\">\n";
echo "</div>\n";
echo "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-4\">\n";
echo "<label for=\"photo5_1\">Фото 5</label>\n";
echo "<input type=\"file\" class=\"form-control\" id=\"photo5_1\" name=\"photo5_1\">\n";
echo "</div>\n";
echo "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-4\">\n";
echo "<label for=\"photo6_1\">Фото 6</label>\n";
echo "<input type=\"file\" class=\"form-control\" id=\"photo6_1\" name=\"photo6_1\">\n";
echo "</div>\n"; 
echo "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-4\">\n";
echo "<label for=\"photo7_1\">Фото 7</label>\n";
echo "<input type=\"file\" class=\"form-control\" id=\"photo7_1\" name=\"photo7_1\">\n";
echo "</div>\n";
echo "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-4\">\n";
echo "<label for=\"photo8_1\">Фото 8</label>\n";
echo "<input type=\"file\" class=\"form-control\" id=\"photo8_1\" name=\"photo8_1\">\n";
echo "</div>\n";
echo "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-4\">\n";
echo "<label for=\"photo9_1\">Фото 9</label>\n";
echo "<input type=\"file\" class=\"form-control\" id=\"photo9_1\" name=\"photo9_1\">\n";
echo "</div>\n"; 
echo "</div>\n";
echo "</div>\n"; 



//echo "<div id=\"addForm\">Дополнительная номенклатура</div>\n";
echo "<input type=\"hidden\" name=\"count\" value=\"1\">\n";
echo "<div class=\"col-xs-12 col-sm-6 col-md-6 col-lg-6\">\n";
echo "<input id=\"sendComplaint\" type=\"button\" class=\"btn-view btn-blue\" name=\"register_submit_button\" value=\"Отправить на рассмотрение\" />\n";
echo "</div>\n";
echo "<div class=\"col-xs-12 col-sm-6 col-md-6 col-lg-6\">\n";
echo "<div id=\"resErr\">* - обязательные поля</div>\n";
echo "</div>\n";
echo "</form>\n";

?>
                  
                  </div>
                 	  
                </div>
        		
    <?
    }
    require($_SERVER["DOCUMENT_ROOT"]."/personal/juridical/personal_footer.php");
    }else{?>
        <div>У вас нет доступа к Личному кабинету. Пожалуйста, <a href="/register/">зарегистрируйтесь</a>.</div>
    <?}?>
<?}else{?>
    <div>Только для авторизованных пользователей.</div>
<?}?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>