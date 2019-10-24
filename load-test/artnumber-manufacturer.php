<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);

echo "<h2>Артикул производителя</h2>";


function parse_excel_file( $filename ){
	// путь к библиотеки от корня сайта
	//require_once dirname(__FILE__) .'/Classes/PHPExcel.php';
    require_once dirname(__FILE__) .'/../load-catalog/Classes/PHPExcel.php';
	$result = array();
	// получаем тип файла (xls, xlsx), чтобы правильно его обработать
	$file_type = PHPExcel_IOFactory::identify( $filename );
	// создаем объект для чтения
	$objReader = PHPExcel_IOFactory::createReader( $file_type );
	$objPHPExcel = $objReader->load( $filename ); // загружаем данные файла
    $objPHPExcel->setActiveSheetIndex(0);
    $objWorksheet = $objPHPExcel->getActiveSheet();
    $result = $objPHPExcel->getActiveSheet()->toArray(); // выгружаем данные
    //for ($i = 0; $i<1000; $i++) {
        //$result[$i] = trim(htmlspecialchars($objWorksheet->getCellByColumnAndRow(0, $i)->getValue()));
    //}	
    
	return $result;
}

$file = 'artnumber-manufactirer.xlsx';
if (!file_exists($file)) {
	exit("Файл ".$file." не найден!");
}

CModule::IncludeModule('iblock');
$res = parse_excel_file($file);
$count = count($res);

//echo "<pre>";
//print_r($res);
//echo "</pre>";


for($i=2401;$i<$count;$i++){    
    if(!empty($res[$i])){
	// получаем товар по артиклу                
         $arSelect = Array("ID", "IBLOCK_ID", "ACTIVE", "NAME");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
         $arFilter = Array(
                     "IBLOCK_ID"=>2,                 
                     "PROPERTY_ARTNUMBER"=>$res[$i]
                     );
                     
         $resProduct = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
         
         if (intval($resProduct->SelectedRowsCount())>0){
            while($ob = $resProduct->GetNextElement()){ 
                $arFields = $ob->GetFields();      
                $arrProp["ARTNUMBER_MANUFACTURER"] = "";             
				//echo "<p>ID = ".$arFields["ID"]."</p>";
				//echo "<p>Артикул = ".$res[$i][0]."</p>";
				//echo "<p>Артикул производителя = ".$res[$i][2]."</p>";
				if($arFields["ID"]){
                    $arrProp["ARTNUMBER_MANUFACTURER"] = $res[$i][2];
                    CIBlockElement::SetPropertyValuesEx($arFields["ID"], 2, $arrProp);
				}
            }           
        } else {
                    echo "<p style=\"color:#ff0000;\">Товара с артикулом  '".$res[$i][0]."' не найдено!</p>";
        } 
    }      
}

?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>