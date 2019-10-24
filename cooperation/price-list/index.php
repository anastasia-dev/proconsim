<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Прайс-лист по разделам каталога компании Проконсим");
$APPLICATION->SetTitle("Прайс-лист по разделам");
?><?
   echo "<table>";
   $regionCode= $_SESSION['REGION_CODE'];               
   $arFilter = array('IBLOCK_ID' => 2,'ACTIVE' => 'Y','GLOBAL_ACTIVE' => 'Y', 'SECTION_ID'=>false,'!ID' => array(28,29,30,31,92)); 
   $rsSect = CIBlockSection::GetList(array('SORT' => 'asc'),$arFilter,true,array('ID','NAME','CODE'));
   while ($arSect = $rsSect->GetNext())
   {	   
	   if($arSect["ELEMENT_CNT"]>0){
	       $filename = $_SERVER['DOCUMENT_ROOT'].'/upload/pdf/'.$arSect["CODE"].'-'.$regionCode.'.pdf';
	       echo "<tr>";
    		   echo "<td class=\"price-list-group-td\"><div class=\"price-list-group\">".$arSect["NAME"]."</div></td>";
               echo "<td class=\"price-list-btn-td\">";
                          if(file_exists($filename)){
                               //echo "<div class=\"price-list-btn\">";
        						   echo "<a href=\"/upload/pdf/".$arSect["CODE"]."-".$regionCode.".pdf\" target=\"_blank\" class=\"price-list-btn-link\">";
            						   //echo "<div class=\"price-list-btn-icon\"><i class=\"fa fa-angle-double-down\" aria-hidden=\"true\"></i></div>";
            						   //echo "<div class=\"price-list-btn-text\">СКАЧАТЬ</div>";
                                       echo "<img src=\"".SITE_TEMPLATE_PATH."/img/icon-load-files.gif\" alt=\"СКАЧАТЬ\">";
                                   echo "</a>";
                               //echo "</div>";
                           }
              echo "</td>";             
          echo "</tr>";              
	   }
   }
   echo "</table>";
?>
<div style="margin-top:20px;font-size:12pt;">
	<p>
		 На сайте компании «Проконсим» есть удобно структурированные прайс-листы для каждой категории продукции от регулирующих клапанов до систем канализации. Прайс-листы постоянно обновляются, для использования крупными поставщиками и небольшими индивидуальными предпринимателями. Прайс-листы созданы для полной комплектации строительных объектов и удовлетворения желания оперативно купить трубопроводную арматуру любого вида. Наши прайс-листы значительно упрощают управление ассортиментом и поиском необходимой позиции.
	</p>
	<p>
		 Практически каждая компания, которая занимается комплектацией строительных объектов и закупкой различной водопроводной арматуры, имеет прайс-листы нашей компании. Они являются простым и удобным способом донести наиболее полную информацию об ассортименте сантехнического оборудования. Прайс-листы представлены для скачивания в любое время потенциальным покупателям и их можно отправлять по почте своим партнерам. На рынке трубопроводного оборудования наша компания делает практически все для увеличения объема продаж наших партнеров. Благодаря уникальной системе обновления прайс-листов актуальной информацией об изменении цен на трубопроводную арматуру, отопительное оборудование, пластиковые трубопроводы и многое другое, наши партнеры имеют возможность оперативно делать заказ с минимальными затратами времени и получают конкурентное преимущество по срокам исполнения заказа, что является важным торговым преимуществом.
	</p>
</div>
 <br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>