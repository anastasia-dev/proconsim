<?require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule("iblock");

$flag = false; // метка, у которое значение true сообщает что товар добавить нельзя

if ($_POST['clear_compare_list'] == 'y') {
	$_SESSION['CATALOG_COMPARE_LIST'][2]['ITEMS'] = array();
}

if ($_POST['action'] == 'ADD_TO_COMPARE_LIST' && (int)$_POST['id'] > 0) {

	$groups = CIBlockElement::GetElementGroups($_POST["id"]);

	$groups_list = array();

	while ($ob = $groups->GetNext()) {
		if ($ob['ID'] != 28) {
			$groups_list[] = $ob['ID'];
		}
		// echo "<pre>";
		// print_r($ob);
		// echo "</pre>";
	}

	

	$res = CIBlockElement::GetByID($_POST["id"]);
	if($ar_res = $res->GetNext()) {
		foreach($_SESSION['CATALOG_COMPARE_LIST'][2]['ITEMS'] as $key => $item) {

			if ($item['IBLOCK_SECTION_ID'] == 28 && count($item['SECTIONS_LIST']) > 0) {
				// echo "id is 28 and count > 0<br>";
				foreach ($item['SECTIONS_LIST'] as $key1 => $id_item) {
					// echo "<br>a $id_item <br>b " . $groups_list[0];
					if ($id_item != 28) {
						if ((int)$id_item != (int)$groups_list[0]) {
							$flag = true;
						}
					}
				}
			} else {
				// echo "id is NOT 28";
				if ($item['IBLOCK_SECTION_ID'] != $ar_res['IBLOCK_SECTION_ID']) {
					$flag = true;
				}
			}

			break;
		}

		$response = array();

		if ($flag) {
			$response['result'] = 'fail';
			$response['html'] = '<div id="warning_compare" role="form" class="popup-form white-popup   animated bounceInDown">
			    <h3>Вы пытаетесь добавить товар другой категории</h3>
			    <div class="show-form">
			        <p>В списке сравнения могут находиться только товары одной категории.</p>
			    </div>

			    <div class="warning_compare_buttons">
			    	<button type="button" onclick="compare_tov('.$_POST['id'].'); setTimeout(function() { rollBackCompareButtons('.$_POST['id'].'); $.magnificPopup.close(); }, 1000);" clear_compare_list="y" class="clear_compare_list">Очистить список</button>
			     	<button title="Close (Esc)" type="button" class="mfp-close cancel_compare">Отменить</button>
			    </div>

				<button title="Close (Esc)" type="button" class="mfp-close">×</button>
			</div>';
		} else {

			$response['result'] = 'true';
		
		}

		echo json_encode($response);
	} else {
		$response['result'] = 'true';
		echo json_encode($response);
	}

} 

?>