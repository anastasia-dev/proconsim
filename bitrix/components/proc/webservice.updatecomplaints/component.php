<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("webservice") || !CModule::IncludeModule("iblock"))
   return;
   
// наш новый класс наследуется от базового IWebService
class CUpdateComplaintsWS extends IWebService
{
   // метод GetWebServiceDesc возвращает описание сервиса и его методов
   function GetWebServiceDesc() 
   {
      $wsdesc = new CWebServiceDesc();
      $wsdesc->wsname = "bitrix.webservice.updatecomplaints"; // название сервиса
      $wsdesc->wsclassname = "CUpdateComplaintsWS"; // название класса
      $wsdesc->wsdlauto = true;
      $wsdesc->wsendpoint = CWebService::GetDefaultEndpoint();
      $wsdesc->wstargetns = CWebService::GetDefaultTargetNS();

      $wsdesc->classTypes = array();
      $wsdesc->structTypes = Array();
      $wsdesc->classes = array(
           "CUpdateComplaintsWS"=> array(
              "UpdateComplaints" => array(
                 "type"      => "public",
                 "input"      => array(
                    "LOGIN" => array("varType" => "string"),
                    "PASSWORD" => array("varType" => "string"),
                    "ELMA_ID" => array("varType" => "integer"),
                    "STATUS" => array("varType" => "string"),
                    "RES_FILE_NAME" => array("varType" => "string"),
                    "RES_FILE_CONTENT" => array("varType" => "string"),
                    ),
                 "output"   => array(
                    "id" => array("varType" => "integer")
                 ),
                 "httpauth" => "Y"
              ),
           )
        );

      return $wsdesc;
   }
   
   function UpdateComplaints($LOGIN, $PASSWORD, $ELMA_ID, $STATUS, $RES_FILE_NAME, $RES_FILE_CONTENT)
   {
    
        if(empty($LOGIN))
            return new CSOAPFault('Server Error', 'Enter Login.');
        
        if(empty($PASSWORD))
            return new CSOAPFault('Server Error', 'Enter Password.');
        
        if(empty($ELMA_ID))
            return new CSOAPFault('Server Error', 'Enter ELMA_ID.');
        
        
        $UserAuthTry = new CUser();
		$authTry = $UserAuthTry->Login($LOGIN, $PASSWORD);
		if ($authTry === true)
		{
			$unode = $UserAuthTry->GetByLogin($user);
			$uinfo = $unode->Fetch();
			$userID = $uinfo["ID"];
            
            $iblock_permission = CIBlock::GetPermission(24,$userID);   
            if ($iblock_permission < "W")
            {
              $GLOBALS["USER"]->RequiredHTTPAuthBasic();
              return new CSOAPFault('Server Error', 'Unable to authorize user.');
            }
            
		}else{
		    return new CSOAPFault( 'Server Error', 'Unable to authorize user.' );  
		}
        	
        $ELEMENT_ID = 0; 
        $arFilter = Array(
         "IBLOCK_ID"=>24,        
         "PROPERTY_ELMA_ID"=>intval($ELMA_ID)
         );
        $res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, Array("ID"));
        while($ar_fields = $res->GetNext())
        {         
           $ELEMENT_ID = $ar_fields["ID"];
        }
        if(empty($ELEMENT_ID))
            return new CSOAPFault( 'Server Error', 'Not object.' ); 
         
           
        $arPROPS = Array(
             "STATUS"=>$STATUS,             
          );
          
        $tmp_name="";  
        if(strlen($RES_FILE_NAME)>0 && strlen($RES_FILE_CONTENT)>0)
        {
            $RES_FILE_CONTENT = base64_decode($RES_FILE_CONTENT);
            if(strlen($RES_FILE_CONTENT)>0)
            {
                $tmp_name = $_SERVER['DOCUMENT_ROOT'].'/bitrix/tmp/'.$RES_FILE_NAME;
                CheckDirPath($tmp_name);
                $f = fopen($tmp_name, "wb");
                fwrite($f, $RES_FILE_CONTENT);
                fclose($f);                
                $arPROPS["RES_FILE"] = CFile::MakeFileArray($tmp_name);
            }
        }   
        
        CIBlockElement::SetPropertyValuesEx($ELEMENT_ID, 24, $arPROPS);
        if(!empty($tmp_name))
            unlink($tmp_name);
        
        return Array("id"=>$ELEMENT_ID);
    
        
    }
}

$arParams["WEBSERVICE_NAME"] = "bitrix.webservice.updatecomplaints";
$arParams["WEBSERVICE_CLASS"] = "CUpdateComplaintsWS";
$arParams["WEBSERVICE_MODULE"] = "";

// передаем в компонент описание веб-сервиса
$APPLICATION->IncludeComponent(
   "bitrix:webservice.server",
   "",
   $arParams
   );

die();
?>