<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);

echo "<h2>Удаление товаров</h2>";


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
    
    for ($i = 0; $i<1000; $i++) {
        $result[$i] = trim(htmlspecialchars($objWorksheet->getCellByColumnAndRow(0, $i)->getValue()));
    }	
    
	return $result;
}
$file = $_SERVER['DOCUMENT_ROOT'].'/import/delete.xlsx';
if (!file_exists($file)) {
	exit("Файл ".$file." не найден!");
}

CModule::IncludeModule('iblock');
$res = parse_excel_file($file);
$count = count($res);

$countDel = 0;
for($i=1;$i<$count;$i++){
    if(!empty($res[$i])){
	// получаем товар по артиклу                
         $arSelect = Array("ID", "IBLOCK_ID", "ACTIVE", "NAME", "PROPERTY_ARTNUMBER");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
         $arFilter = Array(
                     "IBLOCK_ID"=>2,                 
                     "PROPERTY_ARTNUMBER"=>$res[$i]
                     );
         $resProduct = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
         
         if (intval($resProduct->SelectedRowsCount())>0){            
            while($ob = $resProduct->GetNextElement()){ 
                $arFields = $ob->GetFields();  
				//echo "<pre>";
				//print_r($arFields);
				//echo "</pre>";

				if(!CIBlockElement::Delete($arFields["ID"])){
					echo "<p style=\"color:#ff0000;\">Ошибка удаления!</p>";
				}else{
				    $countDel++;
				    echo "<p>Товар ".$res[$i]." - удален.</p>";
				}                   
            }           
         } else {
            echo "<p style=\"color:#ff0000;\">Товара с артикулом  '".$res[$i]."' не найдено</p>";
        } 
    }      
}
echo "<p>Удалено ".$countDel." товаров.</p>";
?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>