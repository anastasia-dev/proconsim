<?
function loadUpdateElement($X = 1)
{
	$X = $X + 1;
	if (($fp = fopen($_SERVER['DOCUMENT_ROOT']."/import/import.csv", "r")) !== FALSE) 
	{
		while (($data = fgetcsv($fp, 0, ";")) !== FALSE) 
		{
			$list[] = $data;
		}
		$IBLOCK_ID = 2;
		CModule::IncludeModule('iblock');
		$arFilter = Array('IBLOCK_ID'=>$IBLOCK_ID, 'GLOBAL_ACTIVE'=>'Y');
		$db_list = CIBlockSection::GetList(Array(), $arFilter, false, array('ID','UF_EXPORT_ID'));
		$arSectionId = array();
		while($ar_result = $db_list->GetNext())
		{
			$arSectionId[$ar_result['UF_EXPORT_ID']] = $ar_result['ID'];
		}
		$arFilter = Array('IBLOCK_ID'=>5, 'GLOBAL_ACTIVE'=>'Y');
		$BrandName = array();
		$res_b = CIBlockElement::GetList(Array(), $arFilter, false, false, array('ID','NAME'));
		while($ob_b = $res_b->GetNextElement())
		{
			$arFields_b = $ob_b->GetFields();
			$BrandName[ToLower($arFields_b['NAME'])] = $arFields_b['ID'];
		}
		CModule::IncludeModule('highloadblock');
		$hlblock_id = 1; // ID вашего Highload-блока
		$hlblock   = Bitrix\Highloadblock\HighloadBlockTable::getById( $hlblock_id )->fetch(); // получаем объект вашего HL блока
		$entity   = Bitrix\Highloadblock\HighloadBlockTable::compileEntity( $hlblock );  // получаем рабочую сущность
		$entity_data_class = $entity->getDataClass(); // получаем экземпляр класса
		$entity_table_name = $hlblock['TABLE_NAME']; // присваиваем переменной название HL таблицы
		$sTableID = 'tbl_'.$entity_table_name;
		$arFilter = array(); // зададим фильтр по ID пользователя
		$arSelect = array('ID',"UF_NAME","UF_XML_ID"); // выбираем все поля
		$rsData = $entity_data_class::getList(array(
			"select" => $arSelect,
			"filter" => $arFilter,
		));
		$ColorName = array();
		$rsData = new CDBResult($rsData, $sTableID); 
		while($arResH = $rsData->Fetch()){
			$ColorName[ToLower($arResH['UF_NAME'])] = $arResH['UF_XML_ID'];
		}

		/*
		0 - Артикул 									- ARTNUMBER
		1 - Название 									- (без свойства) NAME
		2 - Принадлежность к каталогу 					- Веб раздел - каталог
		3 - Принадлежность к разделу					- Веб раздел каталога
		4 - Принадлежность к разделу					- Веб подраздел каталога
		5 - Марка										- BRANDS
		6 - Картинка 1
		7 - Картинка 2
		8 - Картинка 3
		9 - Картинка 4
		10- Материал корпуса							- BODY_MATERIAL
		11- Рабочая среда								- WORKING_ENVIRONMENT
		23- Рабочая среда
		24- Тип присоединения							- CONNECTION_TYPE
		25- Класс герметичности ГОСТ 9544-2005			- TIGHTNESS_CLASS
		26- Максимальная температура рабочей среды, °C 	- MAX_TC_WORKENV
		27- Конструктивные особенности					- DESIGN_FEATURES
		28- Способ управления							- CONTROL_TYPE
		34- Способ управления
		35- Материал уплотнения затвора					- VALVE_PACK_MATERIAL
		36- Уплотнение штока							- STEM_SEAL_MATERIAL
		37- Назначение									- PURPOSE
		38- Нормативный документ						- NORMATIVE_DOCUMENT
		39- Примечание									- NOTE
		40- Чертеж										- DRAWING
		41- DN											- DN
		42- Дн											- DIEN
		43- Двн											- DWN
		44- Длина, мм									- LENGTH
		45- Ширина, мм									- WIDTH
		46- Высота, мм									- HEIGHT
		47- Масса, кг									- WEIGHT
		48- Кол-во штук в упаковке						- QTY_PER_PACK

		49- Цена

		50- PN, кгс/см2									- PN 
		51- SDR											- SDR
		52- Диапазон настройки пружины кгс/см2			- SPRING_ADJ_RANGE
		53- Kv											- KV
		54- Qnom м3/час									- QNOM
		55- Толщина, мм									- THICKNESS
		56- Толщина стенки, мм							- WALL_THICKNESS
		57- Резьба										- SCREW_THREAD
		58- Длина резьбы не менее, мм					- SCREW_THREAD_LENGTH
		59- Длина ножки, мм								- SCREW_THREAD_LENGTH_TWO
		60- Площадь поверхности нагрева, кв.м.			- HEATING_AREA
		61- Межосевое расстояние, мм					- AXLE_BASE
		62- Кол-во крепежных отверстий					- FIXING_HOLES_QTY
		63- Количество секций							- NUMBER_OF_SECTIONS
		64- Напряжение, В								- VOLTAGE
		65- Мощность, кВт								- POWER
		66- Теплоотдача дТ 70, Вт						- HEAT_DISSIPATION
		67- Подача, м3/ч								- HEAT_FEED
		68- Напор, м									- HEAT_HEAD
		69- Частота вращения об/мин						- ROTATIONAL_SPEED
		70- Глубина, мм									- DEPTH
		71- Емкость, л									- CAPACITY
		72- Диаметр отверстий выпуска и перелива, мм    - EXHAUST_OVERFLOW_D
		73- Сетка, мм									- GRID
		74- Конструктивные особенности					- DESIGN_FEATURES_TWO
		75- Применение									- USAGE
		76- Описание									-
		77- Производитель								-
		78- 0 уровень									- LEVEL_NULL
		79- Страна										- COUNTRY
		80- Материал запирающего устройства				- MAT_ZAPIR_USTR
		81- Покрытие									- POKRYTIE
		82- Размер										- SIZE
		83- Тип корпуса									- TYPE_KORPUS
		84- Модель										- MODEL
		85- Тип											- TYPE
		86- Тип запирающего устройства					- TYPE_ZAPIR_USTR
		87- Проход 										- PROKHOD

		88- Цвет 										-

		89- Присоединительный размер					- PRISOED_RAZMR
		90- Исполнение									- ISPOLNENIE
		91- Нагрузка									- NAGRUZKA
		92- Фланец										- FLANETS
		93- Привод (рукоятка)							- PRIVOD_RUKOYATKA
		94- Диапазон измерений							- DIAPAZ_IZMERENIY
		95- Угол										- UGOL
		96- Температура									- TEMPERATURA
		97- Тип трубы									- TYBE_TYPE
		98-
		99- Радиус изгиба								- RADIUS_IZGIBA
		100-Наименование								- NAIMENOVANIE
		101-Диаметр 1									- DIAMETR_1
		102-Диаметр 2									- DIAMETR_2
		103-Армирование									- ARMIROVANIE
		104-Тип выпуска									- TYPE_VIPUSK
		105-Подключение									- PODKLYCHENIE
		106-Механизм слива								- MECHANIZM_SLIVA
		107-Тип сиденья									- TYPE_SIDENYA
		108-Наличие крепежа								- NALICHIE_KREPEZHA
		109-Форма										- FORMA
		110-Диаметр перехода							- DIAMETR_PEREHODA
		111-Диаметр резьбы								- DIAMETR_REZBY
		112-Тип системы отопления						- TYPE_SYS_OTOPLENIYA
		113-Тип конвектора								- TYPE_CONVERTER
		114-Диапазон мощностей							- DIAPAZ_MOSHNOSTEY
		115-Диапазон затяжки							- DIAPAZ_ZATYAZHKI
		116-Резьба шпильки								- REZBA_SHPILKI
		117-Излив										- IZLIV
		118-Комплектация								- KOMPLEKTATSYA
		119-Поставщик									- POSTAVSHIK
		120-Кол-во пластин теплообменника				- KOL_PLASTIN

		*/
		/* Массив с простыми свойствами */
		$SIMPLE_DIGITAL_ARRAY = array(0 => "ARTNUMBER", 10 => "BODY_MATERIAL", 24 => "CONNECTION_TYPE", 
		25 => "TIGHTNESS_CLASS", 26 => "MAX_TC_WORKENV", 27 => "DESIGN_FEATURES",35 => 'VALVE_PACK_MATERIAL',
		36 => "STEM_SEAL_MATERIAL", 37 => "PURPOSE", 38 => "NORMATIVE_DOCUMENT", 39 => 'NOTE', 40 => "DRAWING",
		41 => 'DN', 42 => 'DIEN', 43 => 'DWN', 44 => 'LENGTH', 45 => 'WIDTH', 46 => 'HEIGHT', 47 => 'WEIGHT',
		48 => 'QTY_PER_PACK', 50 => 'PN', 51 => 'SDR', 52 => 'SPRING_ADJ_RANGE', 53 => 'KV', 54 => 'QNOM',
		55 => 'THICKNESS', 56 => 'WALL_THICKNESS', 57 => 'SCREW_THREAD', 58 => 'SCREW_THREAD_LENGTH',
		59 => 'SCREW_THREAD_LENGTH_TWO', 60 => 'HEATING_AREA', 61 => 'AXLE_BASE', 62 => 'FIXING_HOLES_QTY',
		63 => 'NUMBER_OF_SECTIONS', 64 => 'VOLTAGE', 65 => 'POWER', 66 => 'HEAT_DISSIPATION', 67 => 'HEAT_FEED',
		68 => 'HEAT_HEAD', 69 => 'ROTATIONAL_SPEED', 70 => 'DEPTH', 71 => 'CAPACITY', 72 => 'EXHAUST_OVERFLOW_D',
		73 => 'GRID', 74 => 'DESIGN_FEATURES_TWO', 75 => 'USAGE', 77 => 'MANUFACTURER', 78 => 'LEVEL_NULL', 79 => "COUNTRY", 80 => 'MAT_ZAPIR_USTR',
		81 => 'POKRYTIE', 82 => 'SIZE', 83 => 'TYPE_KORPUS', 84 => 'MODEL', 85 => 'TYPE', 86 => 'TYPE_ZAPIR_USTR',
		87 => 'PROKHOD', 89 => 'PRISOED_RAZMR', 90 => 'ISPOLNENIE', 91 => 'NAGRUZKA', 92 => 'FLANETS',
		93 => 'PRIVOD_RUKOYATKA', 94 => 'DIAPAZ_IZMERENIY', 95 => 'UGOL', 96 => 'TEMPERATURA', 99 => 'RADIUS_IZGIBA',
		100 => 'NAIMENOVANIE', 101 => 'DIAMETR_1', 102 => 'DIAMETR_2', 103 => 'ARMIROVANIE', 104 => 'TYPE_VIPUSK',
		105 => 'PODKLYCHENIE', 106 => 'MECHANIZM_SLIVA', 107 => 'TYPE_SIDENYA', 108 => 'NALICHIE_KREPEZHA',
		109 => 'FORMA', 110 => 'DIAMETR_PEREHODA', 111 => 'DIAMETR_REZBY', 112 => 'TYPE_SYS_OTOPLENIYA',
		113 => 'TYPE_CONVERTER', 114 => 'DIAPAZ_MOSHNOSTEY', 115 => 'DIAPAZ_ZATYAZHKI', 116 => 'REZBA_SHPILKI',
		117 => 'IZLIV', 118 => 'KOMPLEKTATSYA', 119 => 'POSTAVSHIK', 120 => 'KOL_PLASTIN');

		fclose($fp);
		$properties = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$IBLOCK_ID));
		while ($prop_fields = $properties->GetNext())
		{
			if(array_search($prop_fields['CODE'],$SIMPLE_DIGITAL_ARRAY) or array_search($prop_fields['CODE'],$SIMPLE_DIGITAL_ARRAY) === 0):
				$SrcPropID[array_search($prop_fields['CODE'],$SIMPLE_DIGITAL_ARRAY)] = $prop_fields['ID'];
			endif;
		}
		$TEK_ARRAY = array();
		$arSelect = Array("ID", "NAME", "IBLOCK_ID", "DATE_ACTIVE_FROM", 'PROPERTY_*');
		$arFilter = Array("IBLOCK_ID"=>IntVal($IBLOCK_ID),"ACTIVE"=>"Y");
		$res = CIBlockElement::GetList(Array(), $arFilter, false, array('nPageSize' => 100,'iNumPage' => $X), $arSelect);

		while($ob = $res->GetNextElement())
		{
			$arFields = $ob->GetFields();
			$arProps = $ob->GetProperties();
			foreach($arProps as $propName => $PropArray):
				if(in_array($propName, $SIMPLE_DIGITAL_ARRAY)):
					$TEK_ARRAY[$arProps['ARTNUMBER']['VALUE']]['PROPS'][$PropArray['ID']] = $PropArray['~VALUE'];
				endif;
			endforeach;
			$TEK_ARRAY[$arProps['ARTNUMBER']['VALUE']]['PROPS'][39] = $arProps['BRANDS']['~VALUE'];
			$TEK_ARRAY[$arProps['ARTNUMBER']['VALUE']]['ID'] = $arFields['ID'];
			$TEK_ARRAY[$arProps['ARTNUMBER']['VALUE']]['NAME'] = $arFields['~NAME'];
			
			$TEK_ARRAY[$arProps['ARTNUMBER']['VALUE']]['PROPS'][12] = $arProps['COLOR']['~VALUE'];
			$TEK_ARRAY[$arProps['ARTNUMBER']['VALUE']]['PROPS'][47] = $arProps['WORKING_ENVIRONMENT']['VALUE_ENUM_ID'];
			$TEK_ARRAY[$arProps['ARTNUMBER']['VALUE']]['PROPS'][52] = $arProps['CONTROL_TYPE']['VALUE_ENUM_ID'];
			$TEK_ARRAY[$arProps['ARTNUMBER']['VALUE']]['PROPS'][109] = $arProps['TYBE_TYPE']['VALUE_ENUM_ID'];
		}
		if($count($TEK_ARRAY) < 100):
			$X = 1;
		endif;
		foreach($list as $key_l => $value_l):
			if(intval($value_l[0]) != 0 and intval($value_l[2]) != 0 and intval($value_l[3]) != 0 and intval($value_l[4]) != 0):
				$update = false;
				
				foreach($SIMPLE_DIGITAL_ARRAY as $key_S => $value_S):
					if(strcmp(trim(iconv('windows-1251',"UTF-8",$value_l[$key_S])),trim($TEK_ARRAY[$value_l[0]]['PROPS'][$SrcPropID[$key_S]]))  !== 0):
						$update = true;
						$TEK_ARRAY[$value_l[0]]['PROPS'][$SrcPropID[$key_S]] = iconv('windows-1251',"UTF-8",$value_l[$key_S]);
					endif;
				endforeach;
				if(strcmp(trim(iconv('windows-1251',"UTF-8",$value_l[1])),trim($TEK_ARRAY[$value_l[0]]['NAME'])) !== 0):
					$TEK_ARRAY[$value_l[0]]['NAME'] = trim(iconv('windows-1251',"UTF-8",$value_l[1]));
					$update = true;
				endif;
				$brand_name = trim(iconv('windows-1251',"UTF-8",$string[5]));
				if($brand_name != ""):
					if($BrandName[ToLower($brand_name)] != $TEK_ARRAY[$value_l[0]]['PROPS'][39]):
						if(array_key_exists(ToLower($brand_name),$BrandName)):
							$TEK_ARRAY[$value_l[0]]['PROPS'][39] = $BrandName[ToLower($brand_name)];
							$update = true;
						endif;
					endif;
				endif;
				if(!$update):
					unset($TEK_ARRAY[$value_l[0]]);
				endif;
				
			endif;
		endforeach;
		$i = 0;
		$el = new CIBlockElement;
		foreach($TEK_ARRAY as $key => $NEW_ELEMENT):
		$arLoadProductArray = Array(
		  "MODIFIED_BY"    => 1, // элемент изменен текущим пользователем
		  "IBLOCK_ID"      => 2,
		  "PROPERTY_VALUES"=> $NEW_ELEMENT['PROPS'],
		  "NAME"           => $NEW_ELEMENT['NAME'],
		  "ACTIVE"         => "Y",            // активен
		  );
		$PRODUCT_ID = $NEW_ELEMENT['ID'];  // изменяем элемент с кодом (ID) 2
		$res = $el->Update($PRODUCT_ID, $arLoadProductArray);
		endforeach;
	}
	return "loadUpdateElement(".$X.");";
}
?>