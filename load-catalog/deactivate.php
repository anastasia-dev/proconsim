<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);

echo "<h2>Деактивация товаров</h2>";


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

$file = $_SERVER['DOCUMENT_ROOT'].'/import/deactivate.xlsx';
if (!file_exists($file)) {
	exit("Файл ".$file." не найден!");
}

CModule::IncludeModule('iblock');
$res = parse_excel_file($file);
$count = count($res);

$el = new CIBlockElement;
$arLoadProductArray = Array(
                        "MODIFIED_BY"    => $USER->GetID(),
                        "ACTIVE"         => "N", 
                    );
for($i=1;$i<$count;$i++){    
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
                  if($arFields["ACTIVE"]=="N"){
                    //echo "<p style=\"color:#ff0000;\">Товара с артикулом  '".$res[$i]."' неактивен!</p>";
                  }else{
                    //echo   $res[$i]." ".$arFields["NAME"]."<br />";
                    $resUp = $el->Update($arFields["ID"], $arLoadProductArray);
                    if(!$resUp){
                       echo  $el->LAST_ERROR;
                    }//else{
                        //echo $res[$i]." Деактивирован</br>";
                    //}
                  }
            }           
        } else {
                    echo "<p style=\"color:#ff0000;\">Товара с артикулом  '".$res[$i]."' не найдено!</p>";
        } 
    }      
}

?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>