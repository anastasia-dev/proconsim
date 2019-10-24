<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Title");
?>
<script type="text/javascript" src="load-pdf.js"></script>
<?
   $arRegions = array();
   $arSelectRegions = Array("ID", "IBLOCK_ID", "NAME", "CODE", "PROPERTY_PRICE_ID", "PROPERTY_PHONE_PDF", "PROPERTY_EMAIL_PDF");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
   $arFilterRegions = Array(
                         "IBLOCK_ID"=>6, 
                         "ACTIVE"=> "Y"
   );
   $resRegions = CIBlockElement::GetList(Array("SORT"=>"asc"), $arFilterRegions, false, false, $arSelectRegions);
   while($obRegions = $resRegions->GetNextElement()){ 
        $arRegionsFields = $obRegions->GetFields();               
        $arRegions[$arRegionsFields["ID"]] = array("NAME"     => $arRegionsFields["NAME"], 
                                                   "CODE"     => $arRegionsFields["CODE"], 
                                                   "PRICE_ID" => $arRegionsFields["PROPERTY_PRICE_ID_VALUE"],
                                                   "PHONE"    => $arRegionsFields["PROPERTY_PHONE_PDF_VALUE"],
                                                   "EMAIL"    => $arRegionsFields["PROPERTY_EMAIL_PDF_VALUE"]
                                             );
                    
   }                 
   $arFilter = array('IBLOCK_ID' => 2,'ACTIVE' => 'Y','GLOBAL_ACTIVE' => 'Y', 'SECTION_ID'=>false,'!ID' => array(28,29,30,31,92)); 
   $rsSect = CIBlockSection::GetList(array('SORT' => 'asc'),$arFilter,true,array('ID','NAME','CODE'));
   while ($arSect = $rsSect->GetNext())
   {
	   //echo "<pre>";
	   //print_r($arSect);
	   //echo "</pre>";
	   if($arSect["ELEMENT_CNT"]>0){
	   		echo "<div>".$arSect["NAME"]."</div>";
            foreach($arRegions as $regID=>$region){
                if(empty($region["PHONE"])){
                    $region["PHONE"] = "+7 (495) 988-00-32";
                }
                if(empty($region["EMAIL"])){
                    $region["EMAIL"] = "info@proconsim.ru";
                }
                echo "<div id=\"reg_".$arSect["ID"]."_".$region["PRICE_ID"]."\" data-section=\"".$arSect["ID"]."\" data-regioncode=\"".$region["CODE"]."\" data-phone=\"".$region["PHONE"]."\" data-email=\"".$region["EMAIL"]."\"> - ".$region["NAME"]."</div>";
            }
	   }
   }
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>