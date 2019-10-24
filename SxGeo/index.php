<?php
include($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
function geturl($url)
    {
        if( $curl = curl_init() )
        {
            curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2228.0 Safari/537.36');
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT,1000);
            $out = curl_exec($curl);
            curl_close($curl);
        }
        return $out;
}

//$regdata=geturl('http://api.sypexgeo.net/json/'.$_SERVER['REMOTE_ADDR']);
include($_SERVER['DOCUMENT_ROOT']."/SxGeo/SxGeo.php");
mb_internal_encoding("8bit");
$SxGeo = new SxGeo('SxGeoCity.dat');
$ip = $_SERVER['REMOTE_ADDR'];
echo $ip;
$country = $SxGeo->getCityFull($ip);
print_r($country);
$regdata=json_decode($regdata);
//$city = $regdata->city->name_ru;
$city = $country['city']['name_ru'];
$count = 0;
if(CModule::IncludeModule('iblock')):
	$arSelect = Array("ID", "NAME", "CODE");
	$arFilter = Array("IBLOCK_ID"=>6,  "ACTIVE"=>"Y", "NAME" => $city);
	$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
	
	while($ob = $res->GetNextElement())
	{
		$arFields = $ob->GetFields();
		$id = $arFields['ID'];
		$code = $arFields['CODE'];
		$count ++;
	}
endif;
if($count == 1):
else:
	$id = 439;
	$code = 'moskva';
endif;
$APPLICATION->set_cookie("USER_CITY", $id, time()+60*60*24*365*1000, "/");
$APPLICATION->set_cookie("USER_CITY_NAME", $code, time()+60*60*24*365*1000, "/");
echo $id;
?>