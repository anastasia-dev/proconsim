<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Загрузка Цен Ярославль");

?>
<?
if(CModule::IncludeModule('iblock')){
	$TEK_ARRAY = array();
	$SKU_ARRAY = array();
	$arFilter = Array('IBLOCK_ID'=>IBLOCK_PRODUCT_ID);
	$db_list = CIBlockSection::GetList(Array(), $arFilter, false, array('ID','UF_EXPORT_ID'));
	$arSectionId = array();
	while($ar_result = $db_list->GetNext())
	{
		$arSectionId[$ar_result['UF_EXPORT_ID']] = $ar_result['ID'];
	}
	$arSelect = Array("ID", "NAME", "IBLOCK_ID", "CODE", "PROPERTY_ARTNUMBER");
	$arFilter = Array("IBLOCK_ID"=>IBLOCK_PRODUCT_ID, "CATALOG_GROUP_ID" => "TMN");
	$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
	while($ob = $res->GetNextElement())
	{
		$arFields = $ob->GetFields();
		$TEK_ARRAY[$arFields['~PROPERTY_ARTNUMBER_VALUE']]['ID'] = $arFields['ID'];
		$TEK_ARRAY[$arFields['~PROPERTY_ARTNUMBER_VALUE']]['CODE'] = $arFields['CODE'];
		$TEK_ARRAY[$arFields['~PROPERTY_ARTNUMBER_VALUE']]['NAME'] = $arFields['~NAME'];
	}
	
	$Region[334] = "ФИЛИАЛ-ЯР"; // Код региона в выгрузке
	$regPrice[334]['ID'] = 15; // Номер цены
	$regPrice[334]['CODE'] = "YAR"; // Код цены

	//$countProducts = count($TEK_ARRAY);
	//echo $countProducts;
}

function parse_excel_file( $filename ){
	// путь к библиотеки от корня сайта
	require_once dirname(__FILE__) .'/Classes/PHPExcel.php';
	$result = array();
	// получаем тип файла (xls, xlsx), чтобы правильно его обработать
	$file_type = PHPExcel_IOFactory::identify( $filename );
	// создаем объект для чтения
	$objReader = PHPExcel_IOFactory::createReader( $file_type );
	$objPHPExcel = $objReader->load( $filename ); // загружаем данные файла
    $objPHPExcel->setActiveSheetIndex(0);
    $objWorksheet = $objPHPExcel->getActiveSheet();
    $result = $objPHPExcel->getActiveSheet()->toArray(); // выгружаем данные
    //for ($i = 0; $i<200000; $i++) {
        //$result[$i] = trim(htmlspecialchars($objWorksheet->getCellByColumnAndRow(0, $i)->getValue()));
    //}	
    
	return $result;
}

$file = $_SERVER['DOCUMENT_ROOT'].'/import/yar-price.xlsx';
if (!file_exists($file)) {
	exit("Файл ".$file." не найден!");
}

$res = parse_excel_file($file);
$count = count($res);

$num = 0;
$base = 0;
$max = 200000;
$emptyCount = 0;
echo "<div class=\"first\">\n";
for($i=0;$i<$count;$i++){ 
    if(!empty($res[$i][0])){
        
        
        if (intval($TEK_ARRAY[intval($res[$i][0])]['ID']) != 0){
		?><input type="hidden" data-numer="<?=$base?>" 
		data-pricecode="15" class="product product_<?=$base?>" 
		data-price="<?=$res[$i][1]?>" 
		value="<?=$TEK_ARRAY[intval($res[$i][0])]['ID']?>"><?
		$base ++;
        //}else{
            //$emptyCount++;
            //echo $emptyCount.". Товар ".$res[$i][0]." не найден<br />";
	    }
    } 
    $num ++;
}    
echo "</div>\n";  

?>

<div class="col-xs-12">
В выгрузке цены по <?=$num?> товарам. Из них в каталоге <?=$base?> товаров.
<button onclick="StartPriceLoadYa();" class="catalog-wzaim">Начать обновление цен</button>
<div class="progress-window progress-price">
	<div class="progress-bar"><div class="green-bar"></div></div>
	
	<div class="progress-description"></div>
</div>
<input type="hidden" value="<?=$base?>" id="all-count">
</div>

<div class="col-xs-12">
<?
   $arRegions = array();
   $arSelectRegions = Array("ID", "IBLOCK_ID", "NAME", "CODE", "PROPERTY_PRICE_ID", "PROPERTY_PHONE_PDF", "PROPERTY_EMAIL_PDF");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
   $arFilterRegions = Array(
                         "IBLOCK_ID"=>6, 
                         "ID"=>334,
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
   $rsSect = CIBlockSection::GetList(array('SORT' => 'asc'),$arFilter,true,array('ID','NAME','CODE','LEFT_MARGIN','RIGHT_MARGIN','DEPTH_LEVEL'));
   while ($arSect = $rsSect->GetNext())
   {
	   //echo "<pre>";
	   //print_r($arSect);
	   //echo "</pre>";
	   if($arSect["ELEMENT_CNT"]>0){
	   		//echo "<div>".$arSect["NAME"]."</div>";
            foreach($arRegions as $regID=>$region){
                if(empty($region["PHONE"])){
                    $region["PHONE"] = "+7 (495) 988-00-32";
                }
                if(empty($region["EMAIL"])){
                    $region["EMAIL"] = "info@proconsim.ru";
                }
                //echo "<div id=\"reg_".$arSect["ID"]."_".$region["PRICE_ID"]."\" data-section=\"".$arSect["ID"]."\" data-regioncode=\"".$region["CODE"]."\" data-phone=\"".$region["PHONE"]."\" data-email=\"".$region["EMAIL"]."\">".$arSect["NAME"]."</div>";
                echo "<div id=\"reg_".$arSect["ID"]."_".$region["PRICE_ID"]."\" data-section=\"".$arSect["ID"]."\" data-regioncode=\"".$region["CODE"]."\" data-phone=\"".$region["PHONE"]."\" data-email=\"".$region["EMAIL"]."\">".$arSect["NAME"]."<span id=\"res_".$arSect["ID"]."_".$region["PRICE_ID"]."\"></span></div>";
            }
			$arSubFilterCount = Array(
			"IBLOCK_ID"=>$arSect["IBLOCK_ID"],
			"SECTION_ID"=>$arSect["ID"]
			);
	        $countSub = CIBlockSection::GetCount($arSubFilterCount);
		   //echo "<div>".$countSub."</div>";
		   if($countSub>0){
               $arFilterSub = array('IBLOCK_ID' => $arSect['IBLOCK_ID'],'ACTIVE' => 'Y','GLOBAL_ACTIVE' => 'Y','>LEFT_MARGIN' => $arSect['LEFT_MARGIN'],'<RIGHT_MARGIN' => $arSect['RIGHT_MARGIN'],'>DEPTH_LEVEL' => $arSect['DEPTH_LEVEL']); 
			   $rsSectSub = CIBlockSection::GetList(array('left_margin' => 'asc'),$arFilterSub,true,array('ID','NAME','CODE'));
			   while ($arSectSub = $rsSectSub->GetNext())
			   {
				   //echo "<pre>";
				   //print_r($arSectSub);
				   //echo "</pre>";
				   //echo "<div>".$arSectSub["NAME"]."</div>";
					foreach($arRegions as $regID=>$region){
						if(empty($region["PHONE"])){
							$region["PHONE"] = "+7 (495) 988-00-32";
						}
						if(empty($region["EMAIL"])){
							$region["EMAIL"] = "info@proconsim.ru";
						}
						echo "<div id=\"reg_".$arSectSub["ID"]."_".$region["PRICE_ID"]."\" data-section=\"".$arSectSub["ID"]."\" data-regioncode=\"".$region["CODE"]."\" data-phone=\"".$region["PHONE"]."\" data-email=\"".$region["EMAIL"]."\"> - ".$arSectSub["NAME"]."<span id=\"res_".$arSectSub["ID"]."_".$region["PRICE_ID"]."\"></span></div>";
					}
			   }
		   }

	   }
   } 
  //echo "<pre>";
  //print_r($arRegions);
  //echo "</pre>";
?>
</div>
<div id="res"></div>



<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>