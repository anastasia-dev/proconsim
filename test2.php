<?php
ini_set("display_errors","1");
error_reporting(E_ALL);

// Создание SOAP-клиента по WSDL
// options for ssl in php 5.6.5
$opts = array(
    'ssl' => array(
        'ciphers' => 'RC4-SHA',
        'verify_peer' => false,
        'verify_peer_name' => false
    )
);

// SOAP 1.2 client
//$url="https://213.184.131.70:8043/Modules/EleWise.ELMA.Workflow.Processes.Web/WFPWebService.asmx";
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


$client = new SoapClient($url."?WSDL", $params);
//Вызов метода Run для запуска экземпляра процесса
//var_dump($data);


$userName="web";
$password="dpcQP0WrnB"; 
$token = "4945fdee-7421-436b-b0c0-ec2e51842ced";
$instanceName = date("d.m.Y")."-КЛ_0001-121100043"; //название экземпляра процесса


$file_to_code = $_SERVER["DOCUMENT_ROOT"]."/upload/test.docx";
$file = file_get_contents($file_to_code, FILE_USE_INCLUDE_PATH);

$file_to_code2 = $_SERVER["DOCUMENT_ROOT"]."/img/logo-temp.png";
//$file_to_code2 = $_SERVER["DOCUMENT_ROOT"]."/images/map1.jpg";
$file2 = file_get_contents($file_to_code2, FILE_USE_INCLUDE_PATH);

$file_to_code3 = $_SERVER["DOCUMENT_ROOT"]."/images/maket.jpg";
$file3 = file_get_contents($file_to_code3, FILE_USE_INCLUDE_PATH);

$file_xml_string = "<?xml version=\"1.0\" encoding=\"UTF-16\"?><Files>";
$file_xml_string .= "<ActFile><Name>".basename($file_to_code)."</Name><Data>".base64_encode($file)."</Data></ActFile>";
$file_xml_string .= "<PhotoFiles>";
$file_xml_string .= "<PhotoFile><Name>".basename($file_to_code2)."</Name><Data>".base64_encode($file2)."</Data></PhotoFile>";
$file_xml_string .= "<PhotoFile><Name>".basename($file_to_code2)."-2</Name><Data>".base64_encode($file2)."</Data></PhotoFile>";
$file_xml_string .= "<PhotoFile><Name>".basename($file_to_code2)."-3</Name><Data>".base64_encode($file2)."</Data></PhotoFile>";
$file_xml_string .= "<PhotoFile><Name>".basename($file_to_code3)."</Name><Data>".base64_encode($file3)."</Data></PhotoFile>";
$file_xml_string .= "<PhotoFile><Name>".basename($file_to_code3)."-4</Name><Data>".base64_encode($file3)."</Data></PhotoFile>";
$file_xml_string .= "</PhotoFiles>";
$file_xml_string .= "</Files>";

//echo $file_xml_string;





$data = new stdClass();
$data->Items = new stdClass();
$data->Items->WebDataItem = array(); // Формируем массив контекстных переменных.
$data->Items->WebDataItem[0] = array("Name"=>"ArtikulTovara", "Value"=>"121100043");
$data->Items->WebDataItem[1] = array("Name"=>"KolichestvoTovara", "Value"=>"10");
$data->Items->WebDataItem[2] = array("Name"=>"Dostavka", "Value"=>"Доставка Проконсим");
$data->Items->WebDataItem[3] = array("Name"=>"OpisanieNeispravnosti", "Value"=>"Тест. Описание неисправности.");
$data->Items->WebDataItem[4] = array("Name"=>"ProizvoditeljTovaraPoPasportu", "Value"=>"PR");
$data->Items->WebDataItem[5] = array("Name"=>"NomerPlombyIliSeriynyy", "Value"=>"12121212");
$data->Items->WebDataItem[6] = array("Name"=>"TrebovaniyaPokupatelya", "Value"=>"Тест. Требования покупателя.");
$data->Items->WebDataItem[7] = array("Name"=>"FaylReklamacii", "Value"=>"");
$data->Items->WebDataItem[8] = array("Name"=>"DataOtgruzki", "Value"=>"30.12.2018");
$data->Items->WebDataItem[9] = array("Name"=>"DopolnyteljnyeFayly", "Value"=>"");
$data->Items->WebDataItem[10] = array("Name"=>"KodKlientaNAV", "Value"=>"КЛ_11111");
$data->Items->WebDataItem[11] = array("Name"=>"Cena", "Value"=>"2224.84");
$data->Items->WebDataItem[12] = array("Name"=>"PodachaCherezLKWEB", "Value"=>"true");
$data->Items->WebDataItem[13] = array("Name"=>"FilesString", "Value"=>$file_xml_string);
 
// Массив параметров необходимых для запуска процесса
$parameters = array(
                    "userName"=>$userName,
                    "password"=>$password,
                    "token"=>$token,
                    "instanceName"=>$instanceName,
                    "data"=>$data);
//echo "<pre>";
//print_r($client->__getFunctions());
//echo "</pre>";

$client->Run($parameters);
//$res = $client->__getLastResponse(); 
//var_dump($res);

echo $client->__getLastRequestHeaders();
//echo "Спасибо за заказ! В ближайшее время с Вами свяжется наш специалист.";


?>