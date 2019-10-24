<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Фото");
?>
<?    

$arSelect = Array("ID", "IBLOCK_ID", "IBLOCK_SECTION_ID", "IBLOCK_SECTION", "ACTIVE", "NAME", "PREVIEW_PICTURE", "PROPERTY_ARTNUMBER", "PROPERTY_MORE_PHOTO", "PROPERTY_IMAGE_PREVIEW");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
$arFilter = Array(
                "IBLOCK_ID"=>2,                 
                //"!PREVIEW_PICTURE" => false,
                //"!PROPERTY_MORE_PHOTO" => false,
                "PROPERTY_IMAGE_PREVIEW" => false
            );
         $resProduct = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);

            $count = 0;
            while($ob = $resProduct->GetNextElement()){ 
                $count++;
				//if($count<5){    
                $arFields = $ob->GetFields();                                   
                  

                //echo "<pre>";
                //print_r($arFields);
                //echo "</pre>";
                
                echo $count.". ".$arFields['PROPERTY_ARTNUMBER_VALUE']." ". $arFields['NAME']."<br />";
                
                   
                
                
                /*
                $arProps = $ob->GetProperties();
                //echo "<pre>";
                //print_r($arProps["MORE_PHOTO"]);
                //echo "</pre>";
                
                if(is_array($arProps["MORE_PHOTO"]["VALUE"]))
                {
                    
                    
            
                    $image = CFile::GetFileArray($arProps["MORE_PHOTO"]["VALUE"][0]);
                   
                    $image_src = $_SERVER['DOCUMENT_ROOT'] . $image['SRC'];
                    $tmp_image = $_SERVER['DOCUMENT_ROOT'] . '/upload/preview/' . $arFields['PROPERTY_ARTNUMBER_VALUE'].".jpg";
                   echo $image_src."<br />";
                   echo $tmp_image."<br /><br />";
                   
                  
                    $newFile = CFile::ResizeImageFile(
                       $image_src, 
                       $tmp_image, 
                       array('width'=>50, 'height'=>50), 
                       BX_RESIZE_IMAGE_PROPORTIONAL
                    );
                    
                    //var_dump($newFile);
                    if($newFile){
                          
                    CIBlockElement::SetPropertyValuesEx(
                                                $arFields["ID"],
                                                $arFields["IBLOCK_ID"],
                                                array('IMAGE_PREVIEW' => "/upload/preview/". $arFields['PROPERTY_ARTNUMBER_VALUE'].".jpg")
                                            );
                    }  else{
                        echo "Файл не создан!";
                        echo "<pre>";
                        print_r($arFields);
                        echo "</pre>";
                    }                      
				//}
                
                }*/
        } 
        
        echo $count;
                     
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>