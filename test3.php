<?php
ini_set("display_errors","1");
error_reporting(E_ALL);

$userName="web";
$password="dpcQP0WrnB"; 
$token = "8eb6a811-353d-440c-8476-34ec7cabef42";
$instanceName = "TEST"; //название экземпляра процесса
$data="Test data";
 
// Массив параметров необходимых для запуска процесса
$parameters = array(
                    "userName"=>$userName,
                    "password"=>$password,
                    "token"=>$token,
                    "instanceName"=>$instanceName,
                    "data"=>$data);
 

// Создание SOAP-клиента по WSDL
$url="http://www.cbr.ru/DailyInfoWebServ/DailyInfo.asmx?WSDL";
//$url="https://213.184.131.70:8043/Modules/EleWise.ELMA.Workflow.Processes.Web/WFPWebService.asmx?WSDL";
$client = new SoapClient($url);
$curs = $client->GetCursOnDate("2019-03-25"); 
print_r ($curs);
//Вызов метода Run для запуска экземпляра процесса
//$client->Run($parameters);
echo "Спасибо за заказ! В ближайшее время с Вами свяжется наш специалист.";

?>