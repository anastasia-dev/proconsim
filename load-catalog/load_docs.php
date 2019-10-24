<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);

echo "<h2>Загрузка документов</h2>";

// Получаем значение типов
$arTypes = array();
$arrLinks = array();

$obEnum = new CUserFieldEnum;
$rsEnum = $obEnum->GetList(array(), array("USER_FIELD_ID" => 38));
while($arEnum = $rsEnum->GetNext()){
   $arTypes[$arEnum["ID"]] = $arEnum["VALUE"];
}

//echo "<pre>";
//print_r($arTypes);
//echo "</pre>";

if (CModule::IncludeModule('highloadblock'))
{
$arHLBlockDocs = Bitrix\Highloadblock\HighloadBlockTable::getById(3)->fetch();
$obEntityDocs = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($arHLBlockDocs);
$strEntityDataClassDocs = $obEntityDocs->getDataClass();
$rsDataDocs = $strEntityDataClassDocs::getList(array(
                      'select' => array('*'),                     
));
while ($arItemDocs = $rsDataDocs->Fetch()) {                       
    //$arrLinks[$arItemDocs["ID"]] = array("TYPE" => $arItemDocs["UF_DOC_TYPES"], "LINK" => $arItemDocs["UF_LINK"]); 
    $arrLinks[$arItemDocs["UF_DOC_TYPES"]][$arItemDocs["ID"]] = $arItemDocs["UF_XML_ID"];  
    //echo $arItemDocs["UF_LINK"]."<br />"; 
    //echo $arItemDocs["UF_DOC_TYPES"]."<br />";  
}

//echo "<pre>";
//print_r($arrLinks);
//echo "</pre>";
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
	$result = $objPHPExcel->getActiveSheet()->toArray(); // выгружаем данные

	return $result;
}

$res = parse_excel_file($_SERVER['DOCUMENT_ROOT'].'/import/docs.xlsx' );
$count = count($res);
for($i=0;$i<$count;$i++){
	if(empty($res[$i][0])){
      unset($res[$i]);
	}
}

// колонка 0 - артикул
// строка 3 - типы

//echo "<pre>";
//print_r($res[3]);
//echo "</pre>";

// Проверка типов с $res[3][1]
$countTypes = count($res[3]);

$artTypeId = array();

for($i=1;$i<$countTypes;$i++){
	//echo $i." = ". $res[3][$i]."<br />";
    
    $typeID = array_search($res[3][$i],$arTypes);    
    
    if($typeID){
        //echo $typeID."<br />";
        $artTypeId[$i] = $typeID;
    }else{
        // если типа нет - добавляем
        echo "No<br />"; 
        $obEnum->SetEnumValues(38, array(
        "n0" => array(
            "VALUE" => $res[3][$i],
        ),
        ));  
        
        $rsEnum = CUserFieldEnum::GetList(array(), array("USER_FIELD_ID" => 38, "VALUE" =>$res[3][$i])); 
        $arEnum = $rsEnum->GetNext();  
        $artTypeId[$i] = $arEnum['ID'];
    }
}

//echo "<pre>";
//print_r($artTypeId);
//echo "</pre>";


if (CModule::IncludeModule('iblock')) {     
    
    $count = count($res);
    if(isset($_GET["start"])){
        $startRow = intval($_GET["start"]);
        $endRow = $startRow+500;
    }else{
        if($count>500){
            $startRow = 4;
            $endRow = 500;
        }else{
             $startRow = 4;
             $endRow = $count;
        }
    }
    if($endRow>$count){$endRow = $count;}
    
    if($endRow == $count){
        echo "<h2>Загрузка завершена!</h2>";
        echo "<div>Обработано ".$count." записей.</div>";
    }else{
        echo "<h3>Продолжите загрузку</h3>";
        echo "<div>Обработано ".$endRow." записей из ".$count.".</div>";
        echo "<div style=\"margin:15px 0;\"><a href=\"/load-catalog/load_docs.php?start=".$endRow."\" style=\"font-size:18px;\">Дальше</a></div>";
    }
    
    
    $arDocs = array();    
    $recordXML_ID = "";
    for($i=$startRow;$i< $endRow;$i++){
        $countCurRes = count($res[$i]);
        
         // получаем товар по артиклу                
         $arSelect = Array("ID", "IBLOCK_ID", "NAME","PROPERTY_*");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
         $arFilter = Array(
                     "IBLOCK_ID"=>2,                 
                     "PROPERTY_ARTNUMBER"=>$res[$i][0],
                     );
         $resProduct = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
         
         if (intval($resProduct->SelectedRowsCount())>0){
                  
                 while($ob = $resProduct->GetNextElement()){ 
                    $arFields = $ob->GetFields(); 
                                 //echo "<pre>"; 
                                 //print_r($arFields);
                                 //echo "</pre>";
                   
                    $arProps = $ob->GetProperties();
                    //echo "<pre>";
                    //print_r($arProps["DOCS"]);
                    //echo "</pre>"; 
                     if(is_array($arProps["DOCS"]["VALUE"])){
                        $arPropsUp = $arProps["DOCS"]["VALUE"];
                     }else{
                        $arPropsUp = array();
                     }
                                           
                                         
                 } 
                    $recordID = 0; 
                    $recordXML_ID = "";
                    for($j=1;$j<$countCurRes;$j++){
                       if(!empty($res[$i][$j])) {
                           //echo $j." = " . $res[$i][$j] ."<br />";
                           //echo "translit = ". Cutil::translit($res[$i][$j],"ru")."<br />";
                           
                          // echo "<hr>Артикул: ".$res[$i][0] ."<br />";   
                              //echo "Товар: ".$arFields["NAME"] ."<br />"; 
                              //echo "ID: ".$arFields["ID"] ."<br />";     
                           
                           $file_translit = Cutil::translit($res[$i][$j],"ru");
                           $full_path = $_SERVER["DOCUMENT_ROOT"]."/upload/docs/".$res[$i][$j];
                           $path = "/upload/docs/".$res[$i][$j];
                           //echo "full_path = ".$full_path ."<br />"; 
                           
                           // файл есть на сервере  
                           if (file_exists($full_path)) {
                                    //echo "файл есть!<br />";
                                    if(!in_array($full_path, $arDocs[$artTypeId[$j]])){
                                        $arDocs[$artTypeId[$j]][] = $full_path;               
                                       
                                       // проверка есть ли запись в таблице
                                       $insertID = 0;
                                       $countLinks = count($arrLinks);
                                       if($countLinks>0){
                                            //echo "file_translit = ".$file_translit ."<br />";
                                            //echo "arrLinks[artTypeId[j]] = ".$arrLinks[$artTypeId[$j]] ."<br />"; 
                                            //echo "artTypeId[j] = ".$artTypeId[$j] ."<br />"; 
                                            $key = array_search($file_translit, $arrLinks[$artTypeId[$j]]);
                                            //echo "key = ".$key ."<br />"; 
                                            if($key===false || empty($key)) {
                                                 //echo "нет записи<br />"; 
                                                 
                                                 // добавляем запись в таблицу 
                                                    $arData = Array(
                                                                    'UF_XML_ID' => $file_translit,
                                                                    'UF_DOC_TYPES' => $artTypeId[$j],
                                                                    'UF_NAME' => $res[$i][$j],
                                                                    'UF_LINK' => $path,
                                                                );
                                                    $result = $strEntityDataClassDocs::add($arData);
                                                     
                                                    if ($result->isSuccess()) {
                                                      echo 'ID: ' . $result->getId() . "<br />";
                                                      $insertID = $result->getId();
                                                    } else {
                                                      echo 'ERROR: ' . implode(', ', $result->getErrors()) . "<br />";
                                                    }   
                                              
                                                 
                                            }else{                         
                                                 //echo "есть запись!<br />"; 
                                                 //echo "ID = ".$arrLinks[$artTypeId[$j]][$key]["ID"]."<br />"; 
                                                 $recordID = $key;
                                                 $recordXML_ID = $arrLinks[$artTypeId[$j]][$key];
                                            } 
                                          
                                       } else{
                                            // добавляем запись в таблицу
                                                //echo "нет<br />";
                                                
                                                $arData = Array(
                                                                'UF_XML_ID' => $file_translit, 
                                                                'UF_DOC_TYPES' => $artTypeId[$j],
                                                                'UF_NAME' => $res[$i][$j],
                                                                'UF_LINK' => $path,
                                                            );
                                                $result = $strEntityDataClassDocs::add($arData);
                                                 
                                                if ($result->isSuccess()) {
                                                  echo 'ID: ' . $result->getId() . "<br />";
                                                  $insertID = $result->getId();
                                                } else {
                                                  echo 'ERROR: ' . implode(', ', $result->getErrors()) . "<br />";
                                                }
                                               
                                       }
                                   } else{
                                        $key = array_search($file_translit, $arrLinks[$artTypeId[$j]]);
                                        if($key===false) {
                                        }else{
                                            $recordID = $key;
                                            $recordXML_ID = $arrLinks[$artTypeId[$j]][$key];
                                        }    
                                   }
                                   //echo "recordID = ".$recordID ."<br />";  
                                   //echo "recordXML_ID = ".$recordXML_ID ."<br />";  
                                   if(!empty($recordXML_ID)){
                                           //if(is_array($arPropsUp))
                                           //{
                                                       if(!in_array($recordXML_ID,$arPropsUp)){
                                                            //echo "Добавляем ".$recordXML_ID."<br />";
                                                            $arPropsUp[] = $recordXML_ID;                                                
                                                        }
                                           //}else{
                                                           //echo "Добавляем пусто ".$recordXML_ID."<br />";
                                                            //$arPropsUp[] = $recordXML_ID;    
                                                            //$addNew = 1;                                            
                                           //}     
                                         
                                   }  
                           }else{
                              $recordID = 0; 
                              $recordXML_ID = "";
                              //$arPropsUp = "";
                              echo "<hr>Артикул: ".$res[$i][0] ."<br />";   
                              echo "Товар: ".$arFields["NAME"] ."<br />"; 
                              echo "ID: ".$arFields["ID"] ."<br />";     
                              echo "<p style=\"color:#ff0000;\">Файла '".$res[$i][$j]."' не существует в папке /upload/docs/</p>";
                           }
                           
                       }
                    }
                    
                    // Добавляем свойства инфоблока
                    if(!empty($arPropsUp)){
                        
                        //$resultDiff = array_diff($arPropsUp, $arProps["DOCS"]["VALUE"]);
                        //$countDiff = count($resultDiff);
                        //$countValues = count($arProps["DOCS"]["VALUE"]);
                        
                        //echo "countDiff = ".$countDiff."<br />";
                        //echo "addNew = ".$addNew."<br />";
                        
                        //if($countDiff>0 || $addNew==1){
                            //echo "Обновляем!<br />";
                            CIBlockElement::SetPropertyValuesEx(
                                $arFields["ID"],
                                $arFields["IBLOCK_ID"],
                                array('DOCS' => $arPropsUp)
                            );
                            //echo "<pre>PropsUp<br />";
                            //print_r($arPropsUp);
                            //echo "</pre>";
                        //}
                        //echo "<pre> VALUE<br />";
                        //print_r($arProps["DOCS"]["VALUE"]);
                        //echo "</pre>";
                        
                        
                        //echo "<pre>PropsUp<br />";
                        //print_r($arPropsUp);
                        //echo "</pre>";
                        
                        //echo "<pre>Diff<br />";
                        //print_r($resultDiff);
                        //echo "</pre>";
                        
                    } 
         
        } else {
                    echo "<p style=\"color:#ff0000;\">Товара с артикулом  '".$res[$i][0]."' не найдено</p>";
        }
    }    
}



//echo "<pre>";
//print_r($arDocs);
//echo "</pre>";


//echo "<pre>";
//print_r($res);
//echo "</pre>";

?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>