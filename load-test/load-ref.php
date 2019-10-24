<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);

echo "<h2>Загрузка описания товаров</h2>";


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
$file = 'refs.xlsx';
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


$count = count($res);
 echo   "count = ".$count."<br />";
$arRefs = "";
$el = new CIBlockElement;
for($i=2;$i<3;$i++){    
    if(!empty($res[$i][1])){         
         if(!empty($res[$i][2])){
			 //$arRefs = $res[$i][2];
             $arRefs = str_replace(array("\r\n", "\r", "\n"), '<br>', $res[$i][2]);
         }
         // получаем товар по артиклу                
         $arSelect = Array("ID", "IBLOCK_ID", "ACTIVE", "NAME");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
         $arFilter = Array(
                     "IBLOCK_ID"=>2,                 
                     "PROPERTY_ARTNUMBER"=>$res[$i][1]
                     );
                     
         $resProduct = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
         
         if (intval($resProduct->SelectedRowsCount())>0){
            while($ob = $resProduct->GetNextElement()){ 
                $arFields = $ob->GetFields(); 
            } 
            
            if($arFields["ID"]){
                echo   $res[$i][1]." - ".$arFields["ID"]." - ".$arFields["NAME"]."<br />";
                echo   $arRefs."<br /><br />";
                $arLoadProductArray = Array(
                                               "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
                                               "DETAIL_TEXT_TYPE" =>"html",
                                               "DETAIL_TEXT" => html_entity_decode($arRefs), 
                                            );
                $resUp = $el->Update($arFields["ID"], $arLoadProductArray);  
                if(!$resUp){
                    echo  $el->LAST_ERROR;
                }                                          
            }                  
        } else {
                    echo "<p style=\"color:#ff0000;\">Товара с артикулом  '".$res[$i][1]."' не найдено!</p>";
        } 
    }      
}

?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>