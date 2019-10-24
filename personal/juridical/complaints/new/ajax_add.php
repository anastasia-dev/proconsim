<?
header("Content-Type: text/html; charset=utf-8");
 

if ($_POST)
{ 
    $count = intval($_POST["count"]);     
        
    echo "<div class=\"row grey\">\n";
    echo "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-2\">\n";
    echo "<label for=\"artikul_".$count."\">Артикул<br />товара*</label>\n";
    echo "<input type=\"text\" class=\"form-control required\" id=\"artikul_".$count."\" name=\"artikul_".$count."\">\n";
    echo "<input type=\"hidden\" id=\"productID_".$count."\" name=\"productID_".$count."\">\n";
    echo "</div>\n"; 
    echo "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-4\">\n";
    echo "<label for=\"product_".$count."\">Наименование<br />товара*</label>\n";
    echo "<input type=\"text\" class=\"form-control required\" id=\"product_".$count."\" name=\"product_".$count."\" readonly>\n";
    echo "</div>\n"; 
    echo "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-2\">\n";
    echo "<label for=\"quantity_".$count."\">Количество,<br />шт*</label>\n";
    echo "<input type=\"text\" class=\"form-control required\" id=\"quantity_".$count."\" name=\"quantity_".$count."\">\n";
    echo "</div>\n"; 
    echo "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-2\">\n";
    echo "<label for=\"price_".$count."\">Цена<br />единицы, руб*</label>\n";
    echo "<input type=\"text\" class=\"form-control required\" id=\"price_".$count."\" name=\"price_".$count."\" readonly>\n";
    echo "</div>\n";
    echo "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-2\">\n";
    echo "<label for=\"summa_".$count."\">Сумма,<br />руб*</label>\n";
    echo "<input type=\"text\" class=\"form-control required\" id=\"summa_".$count."\" name=\"summa_".$count."\" readonly>\n";
    echo "</div>\n";
    
    
    echo "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-4\">\n";
    echo "<label for=\"delivery_".$count."\">Как осуществлялась<br />доставка*</label>\n";
    echo "<select name=\"delivery_".$count."\" id=\"delivery_".$count."\" class=\"required\">\n";
    echo "<option value=\"\"></option>\n";
    echo "<option value=\"Самовывоз\">Самовывоз</option>\n"; 
    echo "<option value=\"Доставка Проконсим\">Доставка Проконсим</option>\n"; 
    echo "<option value=\"Доставка Транспортной компанией\">Доставка Транспортной компанией</option>\n"; 
    echo "</select>\n"; 
    echo "</div>\n"; 
    echo "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-4\">\n";
    echo "<label for=\"producer_".$count."\">Производитель товара<br />по паспорту</label>\n";
    echo "<input type=\"text\" class=\"form-control\" id=\"producer_".$count."\" name=\"producer_".$count."\">\n";
    echo "</div>\n"; 
    echo "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-4\">\n";
    echo "<label for=\"serialNumber_".$count."\">Серийный номер<br />или номер пломбы </label>\n";
    echo "<input type=\"text\" class=\"form-control\" id=\"serialNumber_".$count."\" name=\"serialNumber_".$count."\">\n";
    echo "</div>\n"; 
    
    
    
    echo "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-8\">\n";
    echo "<label for=\"defect_".$count."\">Описание<br />неисправности*</label>\n";
    echo "<textarea class=\"form-control required\" id=\"defect_".$count."\" name=\"defect_".$count."\"></textarea>\n";
    echo "</div>\n"; 
    
    echo "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-4\">\n";
    echo "<label for=\"requirement_".$count."\">Требования к поставщику<br />относительно Товара*</label>\n";
    echo "<textarea class=\"form-control required\" id=\"requirement_".$count."\" name=\"requirement_".$count."\"></textarea>\n";
    echo "</div>\n"; 
    
    echo "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\">\n";
    echo "<div class=\"load-files\">Загрузки файлов *</div>\n";
    echo "<label for=\"akt_".$count."\">Акт рекламации, подписанный контрагентом*</label>\n";
    echo "<input type=\"file\" class=\"form-control required\" id=\"akt_".$count."\" name=\"akt_".$count."\">\n";
    echo "</div>\n";
    echo "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-4\">\n";
    echo "<label for=\"photo1_".$count."\">Фото 1</label>\n";
    echo "<input type=\"file\" class=\"form-control\" id=\"photo1_".$count."\" name=\"photo1_".$count."\">\n";
    echo "</div>\n";
    echo "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-4\">\n";
    echo "<label for=\"photo2_".$count."\">Фото 2</label>\n";
    echo "<input type=\"file\" class=\"form-control\" id=\"photo2_".$count."\" name=\"photo2_".$count."\">\n";
    echo "</div>\n";
    echo "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-4\">\n";
    echo "<label for=\"photo3_".$count."\">Фото 3</label>\n";
    echo "<input type=\"file\" class=\"form-control\" id=\"photo3_".$count."\" name=\"photo3_".$count."\">\n";
    echo "</div>\n"; 
    echo "</div>\n";
}                
?>