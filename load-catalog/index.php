<?
//require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
//$APPLICATION->SetTitle("Загрузка Цен");
include ($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");?>
<script type="text/javascript" src="/bitrix/js/main/jquery/jquery-1.8.3.min.js?153596032093637"></script>
<script>
		function StartPropLoad(col){
			var wid, wid_c;
			for(var i = 0; i < Number(col); i++){
				$.ajax({
					async: false,
					url:     '/load-catalog/load_sale.php', 
					type:     "POST", //метод отправки
					data: "str="+i,
					dataType: "html", //формат данных
					success: function(response) { //Данные отправлены успешно
						console.log(response);
						wid = 100*(i+1)/(Number(col));
						wid_c = Math.round(wid);
						$('.progress-prop .green-bar').css('width',wid+'%');
						$('.progress-prop .progress-description').html('Обработано '+(i+1)+' из '+col+'. ('+wid_c+'%)');
					},
					error: function(response) { // Данные не отправлены
					}
				});
			}	
		}
		function StartRecommendLoad(col){
			var wid, wid_c;
			for(var i = 0; i < Number(col); i++){
				$.ajax({
					async: false,
					url:     '/load-catalog/load_recommend.php', 
					type:     "POST", //метод отправки
					data: "str="+i,
					dataType: "html", //формат данных
					success: function(response) { //Данные отправлены успешно
						console.log(response);
						wid = 100*(i+1)/(Number(col));
						wid_c = Math.round(wid);
						$('.progress-recommend .green-bar').css('width',wid+'%');
						$('.progress-recommend .progress-description').html('Обработано '+(i+1)+' из '+col+'. ('+wid_c+'%)');
					},
					error: function(response) { // Данные не отправлены
					}
				});
			}	
		}
		function StartProductLoad(){
			$('.catalog-wzaim').prop('disabled',true);
			var all = $('#all-product').val();
			var id,section,wid,wid_c, sozd=0, obn=0, b_id, b_name;
			b_id = $('#brand-id-array').val();
			b_name = $('#brand-name-array').val();
            var d= new Date();
            var fileName=('0'+d.getDate()).substr(-2,2)+('0'+ parseInt(d.getMonth()+1)).substr(-2,2)+('0'+d.getFullYear()).substr(-2,2)+('0'+d.getHours()).substr(-2,2)+('0'+d.getMinutes()).substr(-2,2)+('0'+d.getSeconds()).substr(-2,2);
			//console.log(fileName);

			for(var i = 0; i < Number(all); i++){	
			//for(var i = 0; i < 10; i++){	
				id = $('#prod_num_'+i).val();
				section = $('#prod_num_'+i).data('section');
				$.ajax({
					async: false,
					url:     '/load-catalog/load_new.php', 
					type:     "POST", //метод отправки
					data: "str="+i+"&id="+id+"&section="+section+"&b_id="+b_id+"&b_name="+b_name+"&fileName="+fileName,
					dataType: "html", //формат данных
					success: function(response) { //Данные отправлены успешно
						if(response != ""){
						console.log(response);
                        $("#resLoadNew").html(response);
						}
						if(response == "ok1"){
							sozd++;
						}else if(response == "ok2"){
							obn ++;
						}
						wid = 100*(i+1)/(Number(all));
						wid_c = Math.round(wid);
						$('.progress-load .green-bar').css('width',wid+'%');
						$('.progress-load .progress-description').html('Обработано '+(i+1)+' из '+all+'. ('+wid_c+'%). Создано - '+sozd+' обновлено - '+obn);
					},
					error: function(response) { // Данные не отправлены
					}
				});
			}
				window.location.href = "https://proconsim.ru/load-catalog/?load=price";
		}

        function StartPriceLoad(){
			$('.catalog-wzaim').prop('disabled',true);
			var id, sklad, price, count, code, name, all, wid, pricecode, nalichie, l_id, l_name;
            l_id = $('#limit-id-array').val();
			l_name = $('#limit-name-array').val();
			all = $('#all-count').val();
			$('.product').each(function(){
				id = $(this).val();
				numer = $(this).data('numer');
				sklad = $(this).data('sklad');
				price = $(this).data('price');
				count = $(this).data('count');
				code = $(this).data('code');
				name = $(this).data('name');
                active = $(this).data('active');
				update = $(this).data('update');
				artnumber = $(this).data('artnumber');
				pricecode = $(this).data('pricecode');
				nalichie = $(this).data('nalichie');
                limit = $(this).data('limit');
                limitOld = $(this).data('limit-old');
				$.ajax({
					async: false,
					url:     '/load-catalog/load_catalog.php', 
					type:     "POST", //метод отправки
					data: "id="+id+"&sklad="+sklad+"&price="+price+"&count="+count+"&code="+code+"&name="+name+"&active="+active+"&artnumber="+artnumber+"&update="+update+"&pricecode="+pricecode+"&nalichie="+nalichie+"&l_id="+l_id+"&l_name="+l_name+"&limit="+limit+"&limitOld="+limitOld,
					dataType: "html", //формат данных
					success: function(response) { //Данные отправлены успешно
						console.log(response);
						wid = 100*Number(numer)/(Number(all)+1);
						wid = Math.round(wid);
						$('.progress-price .green-bar').css('width',wid+'%');
						$('.progress-price .progress-description').html('Обработано '+numer+' из '+all+' ('+wid+'%)');
					},
					error: function(response) { // Данные не отправлены
					}
				});
			});
			loadGroups();
		}

       function loadGroups(){           
            $.ajax({
        					async: false,
        					url:     'groups.php', 
        					type:     "POST", //метод отправки
        					data: "",	                    			
        					success: function(response) { //Данные отправлены успешно
        						//console.log(response);
                                if(response=="err"){
                                    
                                }else{                                    
                                    $("#res").html(response);
                                    createPDF();             
                                }						
        					},
        					error: function(response) { // Данные не отправлены
        					}
            });
        }  
        function createPDF(){            
            $("div[id^='reg_']").each(function(){  
                var divID = this.id; 
                var d_d =divID.replace('reg_','');
                var splitDD = d_d.split("_");
                var priceID = splitDD[1];        
                var sectionID = splitDD[0];
                var regionCode = $(this).attr('data-regioncode');
                var regionPhone = $(this).attr('data-phone');
                var regionEmail = $(this).attr('data-email'); 
                
                $.ajax({
        					async: false,
        					url:     'create-pdf.php', 
        					type:     "POST", //метод отправки
        					data: "sectionid="+sectionID+"&priceid="+priceID+"&code="+regionCode+"&phone="+regionPhone+"&email="+regionEmail,					
        					success: function(response) { //Данные отправлены успешно
					//console.log(response);
                                if(response=="err"){
                                    
                                }else{
                                    //window.open('https://proconsim.ru'+response, '_blank');
                                    $("#res_"+sectionID+"_"+priceID).html(" - "+response);
                                }						
        					},
        					error: function(response) { // Данные не отправлены
        					}
        				});
                
            });    
        } 
        function StartPriceLoadYa(){
			$('.catalog-wzaim').prop('disabled',true);
			var id, numer, price, all, wid;
			all = $('#all-count').val();
            $.ajax({
					async: false,
					url:     '/load-catalog/empty-prices-ya.php', 
				//type:     "POST", //метод отправки
				//data: "id="+id+"&price="+price,
					dataType: "html", //формат данных
					success: function(response) { //Данные отправлены успешно
						console.log(response);
					},
					error: function(response) { // Данные не отправлены
					}
			});
			$('.product').each(function(){
				id = $(this).val();
				numer = $(this).data('numer');		
				price = $(this).data('price');								
							
				$.ajax({
					async: false,
					url:     '/load-catalog/up-prices-ya.php', 
					type:     "POST", //метод отправки
					data: "id="+id+"&price="+price,
					dataType: "html", //формат данных
					success: function(response) { //Данные отправлены успешно
						console.log(response);
						wid = 100*Number(numer)/(Number(all)+1);
						wid = Math.round(wid);
						$('.progress-price .green-bar').css('width',wid+'%');
						$('.progress-price .progress-description').html('Обработано '+numer+' из '+all+' ('+wid+'%)');
					},
					error: function(response) { // Данные не отправлены
					}
				});
			});
			createPDF(); 
		}
</script>

<?
if(CModule::IncludeModule('iblock')){
	$TEK_ARRAY = array();
	$SKU_ARRAY = array();
	$arFilter = Array('IBLOCK_ID'=>IBLOCK_PRODUCT_ID);
	$db_list = CIBlockSection::GetList(Array(), $arFilter, false, array('ID','UF_EXPORT_ID'));
	$arSectionId = array();
	while($ar_result = $db_list->GetNext())
	{
	    if(strlen($ar_result["UF_EXPORT_ID"]) > 0){
		  $arSectionId[$ar_result['UF_EXPORT_ID']] = $ar_result['ID'];
        }
	}
	$arSelect = Array("ID", "ACTIVE", "NAME", "IBLOCK_ID", "CODE", "PROPERTY_ARTNUMBER", "PROPERTY_LIMIT");
	$arFilter = Array("IBLOCK_ID"=>IBLOCK_PRODUCT_ID, "!SECTION_ID"=>130);
	$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
	while($ob = $res->GetNextElement())
	{
		$arFields = $ob->GetFields();

		$TEK_ARRAY[$arFields['~PROPERTY_ARTNUMBER_VALUE']]['ID'] = $arFields['ID'];
		$TEK_ARRAY[$arFields['~PROPERTY_ARTNUMBER_VALUE']]['CODE'] = $arFields['CODE'];
		$TEK_ARRAY[$arFields['~PROPERTY_ARTNUMBER_VALUE']]['NAME'] = $arFields['~NAME'];
        $TEK_ARRAY[$arFields['~PROPERTY_ARTNUMBER_VALUE']]['ACTIVE'] = $arFields['ACTIVE'];
        $TEK_ARRAY[$arFields['~PROPERTY_ARTNUMBER_VALUE']]['LIMIT'] = $arFields['PROPERTY_LIMIT_VALUE'];
	}
	$SKUSelect = Array("ID", "NAME", "IBLOCK_ID", "PROPERTY_REGIONS", "PROPERTY_ARTNUMBER");
	$SKUFilter = Array("IBLOCK_ID"=>IBLOCK_SKU_ID, "ACTIVE"=>"Y");
	$SKUres = CIBlockElement::GetList(Array(), $SKUFilter, false, false, $SKUSelect);
	while($SKUob = $SKUres->GetNextElement())
	{
		$SKUFields = $SKUob->GetFields();
		$SKU_ARRAY[$SKUFields['~PROPERTY_ARTNUMBER_VALUE']][$SKUFields['~PROPERTY_REGIONS_VALUE']]['ID'] = $SKUFields['~ID'];
	}
	/* Коды по регионам */
	$regSelect = array("ID","NAME","IBLOCK_ID","PROPERTY_CODE_IMPORT","PROPERTY_PRICE_ID",'PROPERTY_PRICE_CODE');
	$regFilter = Array("IBLOCK_ID"=>6);
	$regRes = CIBlockElement::GetList(Array(), $regFilter, false, false, $regSelect);
	$regPrice = array();
	while($regOb = $regRes->GetNextElement()){
		$regFields = $regOb->GetFields();
		$Region[$regFields['ID']] = $regFields['~PROPERTY_CODE_IMPORT_VALUE'];
		$regPrice[$regFields['ID']]['ID'] = $regFields['~PROPERTY_PRICE_ID_VALUE'];
		$regPrice[$regFields['ID']]['CODE'] = $regFields['~PROPERTY_PRICE_CODE_VALUE'];
	}
	/* Бренды */
	$brSelect = array("ID","NAME");
	$brFilter = Array("IBLOCK_ID"=>5);
	$brRes = CIBlockElement::GetList(Array(), $brFilter, false, false, $brSelect);
	$Brand_str = "";
	$Brand_str_n = "";
	while($brOb = $brRes->GetNextElement()){
		$brFields = $brOb->GetFields();
		$Brand_str .= $brFields['ID'].",";
		$Brand_str_n .= $brFields['NAME'].",";
	}
	$Brand_str = substr($Brand_str,0,-1);
	$Brand_str_n = substr($Brand_str_n,0,-1);
}

/*Ограничения*/
if (CModule::IncludeModule('highloadblock'))
{
    $arHLBlockLimit = Bitrix\Highloadblock\HighloadBlockTable::getById(5)->fetch();
    $obEntityLimit = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($arHLBlockLimit);
    $strEntityDataClassLimit = $obEntityLimit->getDataClass();
    $rsDataLimit = $strEntityDataClassLimit::getList(array(
                          'select' => array('*'),                     
    ));
    $Limit_str = "";
	$Limit_str_n = "";
    while ($arLimits = $rsDataLimit->Fetch()) {                       
        $Limit_str .= $arLimits["UF_XML_ID"].",";
        $Limit_str_n .= $arLimits["UF_NAME"].",";        
    }    
	$Limit_str = substr($Limit_str,0,-1);
	$Limit_str_n = substr($Limit_str_n,0,-1);
 }   
?>
<h3>Загрузка Цен</h3>
<input type="hidden" value="<?=$Brand_str?>" id="brand-id-array"/><input id="brand-name-array" value="<?=$Brand_str_n?>" type="hidden"/>
<input type="hidden" value="<?=$Limit_str?>" id="limit-id-array"/><input id="limit-name-array" value="<?=$Limit_str_n?>" type="hidden"/>
<?

$url = $_SERVER['DOCUMENT_ROOT']."/import/prices-remains.xml";
$xml = simplexml_load_file($url);
$num = 0;
$base = 0;
$max = 200000;
?><div class="first"><?
foreach($xml->Типоразмер as $Product):
$max --;
	if($max == 0):
		break;
	endif;
	$first = true;
    $nalichie = 0;
//echo "<pre>";
//print_r($Product);
//echo "</pre>";
	foreach($Product->ЦеныИОстатки->Цена as $Cena):
		if($first){
			$first = false;
			$Sklad = "".array_search($Cena['Регион'], $Region);
			$Price = "".str_replace(",",".",$Cena['Сумма']);
			$Count = "".$Cena['Остатки'];
			$Update = "".intval($SKU_ARRAY[intval($Product['Код'])][array_search($Cena['Регион'], $Region)]['ID']);
			$PriceId = "".$regPrice[array_search($Cena['Регион'], $Region)]['ID'];
		}else{
			$Sklad = $Sklad.";".array_search($Cena['Регион'], $Region);
			$Price = $Price.";".str_replace(",",".",$Cena['Сумма']);
			$Count = $Count.";".$Cena['Остатки'];
			$Update = $Update.";".intval($SKU_ARRAY[intval($Product['Код'])][array_search($Cena['Регион'], $Region)]['ID']);
			$PriceId = $PriceId.";".$regPrice[array_search($Cena['Регион'], $Region)]['ID'];
		}
//echo $Cena['Регион']."<br />";
//echo $regPrice[array_search($Cena['Регион'], $Region)]['ID']."<br />";
//echo $PriceId."<br />";
	endforeach;
	if(isset($Product['Наличие'])){
		$nalichie = $Product['Наличие'];
	}
	if (intval($TEK_ARRAY[intval($Product['Код'])]['ID']) != 0):
		?><input type="hidden" data-numer="<?=$base?>" data-update="<?=$Update?>" 
		data-pricecode="<?=$PriceId?>" data-artnumber="<?=$Product['Код']?>" 
		data-code="<?=$TEK_ARRAY[intval($Product['Код'])]['CODE']?>"
        data-name="<?=$TEK_ARRAY[intval($Product['Код'])]['NAME']?>" 
		data-active="<?=$TEK_ARRAY[intval($Product['Код'])]['ACTIVE']?>" class="product product_<?=$base?>" 
		data-price="<?=$Price?>" data-sklad="<?=$Sklad?>" data-count="<?=$Count?>" data-nalichie="<?=$nalichie?>" 
        data-limit="<?=trim($Product['Ограничение'])?>" data-limit-old="<?=$TEK_ARRAY[intval($Product['Код'])]['LIMIT']?>"
		value="<?=$TEK_ARRAY[intval($Product['Код'])]['ID']?>"><?
		$base ++;
	endif;
	$num ++;
endforeach;
?></div><div class="second"><?
$url_c = $_SERVER['DOCUMENT_ROOT']."/import/catalog.xml";
$xml_c = simplexml_load_file($url_c);
$count_product = 0;
foreach($xml_c->offers->offer as $Offer):
	?><input type="hidden" id="prod_num_<?=$count_product?>" value="<?=intval($TEK_ARRAY[intval($Offer['id'])]['ID'])?>" data-section="<?=intval($arSectionId[intval($Offer['modelID'])])?>"><?
	$count_product++;
endforeach;
?>
</div>
<div class="second"><?
$url_l = $_SERVER['DOCUMENT_ROOT']."/import/product-links.xml";
$xml_l = simplexml_load_file($url_l);
$recommend_product = 0;
foreach($xml_l->Типоразмеры->Типоразмер as $Offer):
	$recommend_product++;
endforeach;?>
</div>
<div class="second"><?
$url_p = $_SERVER['DOCUMENT_ROOT']."/import/additemprop.xml";
$xml_p = simplexml_load_file($url_p);
$prop_product = 0;
foreach($xml_p->Типоразмеры->Типоразмер as $Prop):
	$prop_product++;
endforeach;?>
</div>

<div class="col-xs-12">
В выгрузке цены по <?=$num?> товарам. Из них в каталоге <?=$base?> товаров.
<button onclick="StartPriceLoad();" class="catalog-wzaim">Начать обновление цен</button>
<div class="progress-window progress-price">
	<div class="progress-bar"><div class="green-bar"></div></div>
	
	<div class="progress-description"></div>
</div>
<input type="hidden" value="<?=$base?>" id="all-count">
</div>
<div id="res"></div>

<div class="col-xs-12" style="margin-top: 50px;">
	<a href="prices-ya.php" target="_blank"><b>Обновить цены Ярославль</b></a>
	<div>Файл для загрузки <a href="/import/yar-price.xlsx">/import/yar-price.xlsx</a></div>
</div>

<div class="col-xs-12" style="margin-top: 50px;">
В выгрузке <?=$count_product?> товаров. <button onclick="StartProductLoad();" class="catalog-wzaim">Начать обновление товаров</button>
<div class="progress-window progress-load">
	<div class="progress-bar"><div class="green-bar"></div></div>
	
	<div class="progress-description"></div>
</div>
<input type="hidden" value="<?=$count_product?>" id="all-product">
</div>

<div class="col-xs-12" style="margin-top: 50px;">
В выгрузке <?echo $recommend_product;?> товаров с привязкой.<button onclick="StartRecommendLoad(<?echo $recommend_product;?>);" class="catalog-wzaim">Заполнить сопутсвующие товары</button>
<div class="progress-window progress-recommend">
	<div class="progress-bar"><div class="green-bar"></div></div>
	
	<div class="progress-description"></div>
</div>
</div>

<div class="col-xs-12" style="margin-top: 50px;">
В выгрузке <?echo $prop_product;?> товаров со свойствами. <button onclick="StartPropLoad(<?echo $prop_product;?>);" class="catalog-wzaim">Заполнить распродажи/новинки</button>
<div class="progress-window progress-prop">
	<div class="progress-bar"><div class="green-bar"></div></div>
	<div class="progress-description"></div>
</div>
</div>

<div class="col-xs-12" style="margin-top: 50px;">
	<a href="load_docs.php" target="_blank"><b>Загрузка документов к товарам</b></a>
<div>Файл для загрузки документов <a href="/import/docs.xlsx">/import/docs.xlsx</a></div>
<div>Файлы документов в директории /upload/docs/</div>
</div>

<div class="col-xs-12" style="margin-top: 50px;">
	<a href="deactivate.php" target="_blank"><b>Деактивация товаров</b></a>
<div>Файл для загрузки <a href="/import/deactivate.xlsx">/import/deactivate.xlsx</a></div>
</div>

<div class="col-xs-12" style="margin-top: 50px;">
	<a href="delete.php" target="_blank"><b>Удаление товаров</b></a>
<div>Файл для загрузки <a href="/import/delete.xlsx">/import/delete.xlsx</a></div>
</div>

<div class="col-xs-12" style="margin-top: 50px;">
	<a href="all-props.php" target="_blank"><b>Удаление значений свойств</b></a>
</div>


<div id="resLoadNew"></div>
<?if(isset($_GET["load"]) && $_GET["load"]=="price"){
    echo "<script>StartPriceLoad();</script>";
}?>
<?//require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>