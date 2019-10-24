<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Личный кабинет");
?>
<?
if ($USER->IsAuthorized()){
    $rsUser = CUser::GetByID($USER->GetID());
    $arUser = $rsUser->Fetch();
    //echo "<pre>"; print_r($arUser); echo "</pre>";
    
    if(!empty($arUser["UF_USER_CODE"])){
    require($_SERVER["DOCUMENT_ROOT"]."/personal/juridical/personal_top.php"); 
?>      
<script src="script.js"></script>        		
        		
                                
        		<!-- Tab panes -->
        		<div class="tab-content">
                  
        		  <div class="tab-pane active" id="complaints">
                  <a href="/personal/juridical/complaints/new/" class="btn btn-default personal-tab-content-btn-edit">Создать новую рекламацию</a>
                  </div>
                  <br /><br />
                  
                  <?
                  $arComplaints = array();
                  $arComplaintsSelect = Array("ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM", "DATE_ACTIVE_TO", "PROPERTY_*");
                  $arComplaintsFilter = Array(
                                "IBLOCK_ID"=>24,
                                "PROPERTY_USER_ID" => $USER->GetID()
                            );
                  $resComplaints = CIBlockElement::GetList(Array("ID"=>"DESC"), $arComplaintsFilter, false, false, $arComplaintsSelect);
                  while($ob = $resComplaints->GetNextElement()){ 
                    $arComplaintsFields = $ob->GetFields(); 
                    //echo "<pre>"; print_r($arComplaintsFields); echo "</pre>";
                    $arComplaints[$arComplaintsFields["ID"]]["DATE_ACTIVE_FROM"] = $arComplaintsFields["DATE_ACTIVE_FROM"];
                    $arComplaints[$arComplaintsFields["ID"]]["DATE_ACTIVE_TO"] = $arComplaintsFields["DATE_ACTIVE_TO"];
                    $arProps = $ob->GetProperties();
                    //echo "<pre>"; print_r($arProps); echo "</pre>";
                    //$arComplaints[$arComplaintsFields["ID"]]["PRODUCTS"] = $arProps["PRODUCTS"]["VALUE"];
                    
                    foreach($arProps["PRODUCTS"]["VALUE"] as $product){
                        $arProductSelect = Array("ID", "IBLOCK_ID", "NAME", "PROPERTY_ARTNUMBER");
                        $arProductFilter = Array(
                                "IBLOCK_ID"=>2,
                                "ID" => $product
                            );
                        $resProduct = CIBlockElement::GetList(Array(), $arProductFilter, false, false, $arProductSelect);  
                        if($obPr = $resProduct->GetNextElement()){ 
                            $arProductFields = $obPr->GetFields(); 
                            //echo "<pre>"; print_r($arProductFields); echo "</pre>";
                            $arComplaints[$arComplaintsFields["ID"]]["PRODUCTS"][$arProductFields["ID"]] = array("NAME" => $arProductFields["NAME"], "ARTNUMBER" => $arProductFields["PROPERTY_ARTNUMBER_VALUE"]);
                        }    
                    }
                    $arComplaints[$arComplaintsFields["ID"]]["STATUS"] = $arProps["STATUS"]["VALUE"];

                    $arHistory = array();
                    $arOrder = array('ID' => 'DESC');
					$arFilterHistory = array(
					   'IBLOCK_ID' => '24', 
					   'WF_PARENT_ELEMENT_ID' => $arComplaintsFields["ID"],
					   'SHOW_HISTORY' => 'Y',
					);
					
					$resHistory = CIBlockElement::GetList($arOrder, $arFilterHistory,Array("ID", "IBLOCK_ID", "NAME", "DATE_CREATE", "TIMESTAMP_X", "DATE_ACTIVE_FROM", "DATE_ACTIVE_TO", "PROPERTY_*"));
					while($obHistory = $resHistory->GetNextElement())
					{
						 $arFieldsHistory = $obHistory->GetFields();
                         $arHistory[$arFieldsHistory["ID"]]["DATE_CREATE"] = $arFieldsHistory["DATE_CREATE"];
                         $arHistory[$arFieldsHistory["ID"]]["TIMESTAMP_X"] = $arFieldsHistory["TIMESTAMP_X"];
						 $arHistory[$arFieldsHistory["ID"]]["DATE_ACTIVE_FROM"] = $arFieldsHistory["DATE_ACTIVE_FROM"];
                         $arHistory[$arFieldsHistory["ID"]]["DATE_ACTIVE_TO"] = $arFieldsHistory["DATE_ACTIVE_TO"];
	
						 $arPropsHistory = $obHistory->GetProperties();
						 foreach($arPropsHistory["PRODUCTS"]["VALUE"] as $product){
							$arProductHSelect = Array("ID", "IBLOCK_ID", "NAME", "PROPERTY_ARTNUMBER");
							$arProductHFilter = Array(
									"IBLOCK_ID"=>2,
									"ID" => $product
								);
							$resHProduct = CIBlockElement::GetList(Array(), $arProductHFilter, false, false, $arProductHSelect);  
							if($obPrH = $resHProduct->GetNextElement()){ 
								$arProductHFields = $obPrH->GetFields(); 
								//echo "<pre>"; print_r($arProductFields); echo "</pre>";
								$arHistory[$arFieldsHistory["ID"]]["PRODUCTS"][$arProductHFields["ID"]] = array("NAME" => $arProductHFields["NAME"], "ARTNUMBER" => $arProductHFields["PROPERTY_ARTNUMBER_VALUE"]);
							}    
						 }
                         $arHistory[$arFieldsHistory["ID"]]["STATUS"] = $arPropsHistory["STATUS"]["VALUE"];

                         $arComplaints[$arComplaintsFields["ID"]]["HISTORY"] = $arHistory;
					}
                  }  
                  $countComplaints = count($arComplaints);
				  //echo "<pre>"; print_r($arComplaints); echo "</pre>";
                  if($countComplaints>0){
                  ?>
                  
                  <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>№ рекламации</th>
                                        <th>Дата начала</th>
                                        <th>Артикул товара</th>
                                        <th>Наименование товара</th>
                                        <th>Статус</th>
                                        <th>Дата завершения</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?foreach($arComplaints as $num=>$complaints){?>
									<tr <?if($complaints["HISTORY"]){?>id="compl<?=$num?>" style="cursor: pointer;" title="Посмотреть изменения"<?}?>>
                                        <td><?=$num?></td>
                                        <td><?=$complaints["DATE_ACTIVE_FROM"]?></td>
                                        <td>
                                        <?
                                        foreach($complaints["PRODUCTS"] as $product){
                                            echo $product["ARTNUMBER"]."<br />";
                                        }
                                        ?>
                                        </td>                                
                                        <td>
                                        <?
                                        foreach($complaints["PRODUCTS"] as $product){
                                            echo $product["NAME"]."<br />";
                                        }
                                        ?>
                                        </td>
                                        <td><?=$complaints["STATUS"]?></td>
                                        <td><?=$complaints["DATE_ACTIVE_TO"]?></td>
                                </tr>
									<?if($complaints["HISTORY"]){?> 
                                      <?foreach($complaints["HISTORY"] as $numH=>$history){?>
										<tr id="h_<?=$num?>_<?=$numH?>" style="display: none;background-color: #f1f1f1;">
											<td><?=$num?></td>
											<td><?=$history["TIMESTAMP_X"]?></td>
											<td>
											<?
											foreach($history["PRODUCTS"] as $product){
												echo $product["ARTNUMBER"]."<br />";
											}
											?>
											</td>                                
											<td>
											<?
											foreach($history["PRODUCTS"] as $product){
												echo $product["NAME"]."<br />";
											}
											?>
											</td>
											<td><?=$history["STATUS"]?></td>
											<td><?=$history["DATE_ACTIVE_TO"]?></td>
                                       </tr>
                                       <?}?>
                                    <?}?>
                               <?}?> 
                                </tbody>
                  </table>
                <?}?> 	  
                </div>
        		
    <?
    require($_SERVER["DOCUMENT_ROOT"]."/personal/juridical/personal_footer.php");
    }else{?>
        <div>У вас нет доступа к Личному кабинету. Пожалуйста, <a href="/register/">зарегистрируйтесь</a>.</div>
    <?}?>
<?}else{?>
    <div>Только для авторизованных пользователей.</div>
<?}?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>