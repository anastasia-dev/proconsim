<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);

echo "<h2>Загрузка товаров</h2>";


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
    
	return $result;
}

//$file = $_SERVER['DOCUMENT_ROOT'].'/import/refs.xlsx';
$file = 'for_export.xlsx';
if (!file_exists($file)) {
	exit("Файл ".$file." не найден!");
}

CModule::IncludeModule('iblock');
$res = parse_excel_file($file);
//$count = count($res);
//for($i=0;$i<$count;$i++){
	//if(empty($res[$i][1])){
      //unset($res[$i]);
	//}
//}

echo "<pre>";
print_r($res);
echo "</pre>";




?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>