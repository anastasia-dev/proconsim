<?
if (isset($_REQUEST['work_start']))
{
    define("NO_AGENT_STATISTIC", true);
    define("NO_KEEP_STATISTIC", true);
}
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
CModule::IncludeModule("iblock");
IncludeModuleLangFile(__FILE__);

$POST_RIGHT = $APPLICATION->GetGroupRight("main");
if ($POST_RIGHT == "D")
    $APPLICATION->AuthForm("Доступ запрещен");

$BID = 2; // ид инфоблока каталога
$limit = 500; // шаг выполнения
$GLOBALS["YML_BODY"] = "";


function yandex_replace_special_customized($arg)
{
    if (in_array($arg, array("&quot;", "&amp;", "&lt;", "&gt;")))
        return $arg;
    else
        return " ";
}

function yandex_text2xml_customizedUnicode($text, $bHSC = false, $bDblQuote = false)
{
    global $APPLICATION;

    $bHSC = (true == $bHSC ? true : false);
    $bDblQuote = (true == $bDblQuote ? true: false);

    if ($bHSC)
    {
        $text = htmlspecialcharsbx($text);
        if ($bDblQuote)
            $text = str_replace('&quot;', '"', $text);
    }
    $text = preg_replace("/[\x1-\x8\xB-\xC\xE-\x1F]/", "", $text);
    $text = str_replace("'", "&apos;", $text);
    $text = $APPLICATION->ConvertCharset($text, LANG_CHARSET, 'utf-8');
    return $text;
}

if($_REQUEST['work_start'] && check_bitrix_sessid())
{

    if( $_SESSION["ADD_HEAD_IN_FILE"] != "Y" ){

        $header = getYMLhead();

        file_put_contents("../catalog_yml.xml", "");
        file_put_contents( "../catalog_yml.xml", $header.PHP_EOL , FILE_APPEND | LOCK_EX );

        $_SESSION["ADD_HEAD_IN_FILE"] = "Y";

    }

    $rsSelectFields = array(
        "DETAIL_PAGE_URL",
        "PROPERTY_TOVAR_DNYA",
        "PROPERTY_BREND",
        "PROPERTY_CML2_ARTICLE",
        "IBLOCK_SECTION_ID",
        "PREVIEW_PICTURE",
        "DETAIL_PICTURE",
        "NAME",
        "DETAIL_TEXT",
        "CODE",
        "PROPERTY_TOVAR_DNYA",
        "PROPERTY_KHITY_PRODAZH",
        "PROPERTY_NOVINKI",
        "PROPERTY_AKTSIYA",
        "PROPERTY_SKIDKI"
    );

    $rsEl = CIBlockElement::GetList(
        array(
            "ID" => "ASC"
        ),
        array(
            "ACTIVE" => "Y",
            "IBLOCK_ID" => $BID,
            ">ID" => $_REQUEST["lastid"],
            "!PROPERTY_DID_RESIZED_VALUE"=>"Y"
        ),
        false,
        array(
            "nTopCount" => $limit
        ),
        $rsSelectFields
    );

    while ($arEl = $rsEl->Fetch())
    {
        $elementId = $arEl["ID"];
        $offerElement = CIBlockElement::GetList(
            array(),
            array(
                'IBLOCK_ID' => 2, // ИД инфоблока ТП
                '=PROPERTY_CML2_LINK' => $arEl["ID"],
                'ACTIVE' => 'Y'
            )
        )->Fetch();

        if( isset( $offerElement["ID"] ) && !empty( $offerElement["ID"] ) ){
            $elementId = $offerElement["ID"];
        }

        $db_res = CPrice::GetList(
            array(),
            array(
                "PRODUCT_ID" => $elementId,
                "CATALOG_GROUP_ID" => 1
            )
        );

        if ($ar_res = $db_res->Fetch())
        {
            $price = $ar_res["PRICE"];
            $currency = $ar_res["CURRENCY"];
        } else {
            $price = 0;
            $currency = "RUB";
        }
        if(!$arEl["PREVIEW_PICTURE"]) {
            $pic = CFile::GetPath($arEl["DETAIL_PICTURE"]);
        }
        else{
            $pic = CFile::GetPath($arEl["PREVIEW_PICTURE"]);
        }
        $yml_content = '
        <offer id="'.$arEl["ID"].'" available="true" cbid="90">
        <url>https://'.$_SERVER["SERVER_NAME"].getSectionPath($arEl["IBLOCK_SECTION_ID"]).$arEl["CODE"].'</url>
        <price>'.$price.'</price>
        <currencyId>'.$currency.'</currencyId>
        <categoryId>'.$arEl ["IBLOCK_SECTION_ID"].'</categoryId>
        <picture>https://'.$_SERVER["SERVER_NAME"].$pic.'</picture>
        <store>false</store>
        <delivery>true</delivery>
        <name>'.yandex_text2xml_customizedUnicode( $arEl["NAME"], true ).'</name>
        <vendor>'.yandex_text2xml_customizedUnicode( $arEl["PROPERTY_BREND_VALUE"], true ).'</vendor>
        <description>'.yandex_replace_special_customized( $arEl["DETAIL_TEXT"] ).'</description>
        '.( $arEl["PROPERTY_TOVAR_DNYA_VALUE"] == "Да" ? "<param name=\"badge\">product_day</param>" : "" ).'
        '.( $arEl["PROPERTY_KHITY_PRODAZH_VALUE"] == "Да" ? "<param name=\"badge\">hit</param>" : "" ).'
        '.( $arEl["PROPERTY_NOVINKI_VALUE"] == "Да" ? "<param name=\"badge\">new</param>" : "" ).'
        '.( $arEl["PROPERTY_AKTSIYA_VALUE"] == "Да" ? "<param name=\"badge\">stock</param>" : "" ).'
        '.( $arEl["PROPERTY_SKIDKI_VALUE"] == "Да" ? "<param name=\"badge\">discount</param>" : "" ).'
        <cpa>0</cpa>
        <delivery-options>
          <option cost="1000" days="1-3" order-before="15"/>
        </delivery-options>
        <barcode>'.$arEl['PROPERTY_CML2_ARTICLE_VALUE'].'</barcode>
        <age>0</age>
        <manufacturer_warranty>true</manufacturer_warranty>
      </offer>';

        file_put_contents( "../catalog_yml.xml", $yml_content.PHP_EOL , FILE_APPEND | LOCK_EX );


        $lastID = intval($arEl["ID"]);
    }

    $rsLeftBorder = CIBlockElement::GetList(
        array(
            "ID" => "ASC"
        ),
        array(
            "ACTIVE" => "Y",
            "IBLOCK_ID" => $BID,
            "<=ID" => $lastID
        )
    );

    $leftBorderCnt = $rsLeftBorder->SelectedRowsCount();

    $rsAll = CIBlockElement::GetList(
        array(
            "ID" => "ASC"
        ),
        array(
            "ACTIVE" => "Y",
            "IBLOCK_ID" => $BID
        )
    );

    $allCnt = $rsAll->SelectedRowsCount();

    $p = round(100*$leftBorderCnt/$allCnt, 2);

    echo 'CurrentStatus = Array('.$p.',"'.($p < 100 ? '&lastid='.$lastID : '').'","Обрабатываю запись с ID #'.$lastID.'");';

    if( $p == 100 ){

        $footer = getYMLfooter();

        file_put_contents( "../catalog_yml.xml", $footer.PHP_EOL , FILE_APPEND | LOCK_EX );

        $_SESSION["ADD_HEAD_IN_FILE"] = "N";

    }

    die();
}

$clean_test_table = '<table id="result_table" cellpadding="0" cellspacing="0" border="0" width="100%" class="internal">'.
    '<tr class="heading">'.
    '<td>Текущее действие</td>'.
    '<td width="1%">&nbsp;</td>'.
    '</tr>'.
    '</table>';

$aTabs = array(array("DIV" => "edit1", "TAB" => "Генератор"));
$tabControl = new CAdminTabControl("tabControl", $aTabs);

$APPLICATION->SetTitle("Генерация YML файла");

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");

?>
    <script type="text/javascript">

        var bWorkFinished = false;
        var bSubmit;

        function set_start(val)
        {
            document.getElementById('work_start').disabled = val ? 'disabled' : '';
            document.getElementById('work_stop').disabled = val ? '' : 'disabled';
            document.getElementById('progress').style.display = val ? 'block' : 'none';

            if (val)
            {
                ShowWaitWindow();
                document.getElementById('result').innerHTML = '<?=$clean_test_table?>';
                document.getElementById('status').innerHTML = 'Работаю...';

                document.getElementById('percent').innerHTML = '0%';
                document.getElementById('indicator').style.width = '0%';

                CHttpRequest.Action = work_onload;
                CHttpRequest.Send('<?= $_SERVER["PHP_SELF"]?>?work_start=Y&lang=<?=LANGUAGE_ID?>&<?=bitrix_sessid_get()?>');
            }
            else
                CloseWaitWindow();
        }

        function work_onload(result)
        {
            try
            {
                eval(result);

                iPercent = CurrentStatus[0];
                strNextRequest = CurrentStatus[1];
                strCurrentAction = CurrentStatus[2];

                document.getElementById('percent').innerHTML = iPercent + '%';
                document.getElementById('indicator').style.width = iPercent + '%';

                document.getElementById('status').innerHTML = 'Работаю...';

                if (strCurrentAction != 'null')
                {
                    oTable = document.getElementById('result_table');
                    oRow = oTable.insertRow(-1);
                    oCell = oRow.insertCell(-1);
                    oCell.innerHTML = strCurrentAction;
                    oCell = oRow.insertCell(-1);
                    oCell.innerHTML = '';
                }

                if (strNextRequest && document.getElementById('work_start').disabled)
                    CHttpRequest.Send('<?= $_SERVER["PHP_SELF"]?>?work_start=Y&lang=<?=LANGUAGE_ID?>&<?=bitrix_sessid_get()?>' + strNextRequest);
                else
                {
                    set_start(0);
                    bWorkFinished = true;
                }

            }
            catch(e)
            {
                CloseWaitWindow();
                document.getElementById('work_start').disabled = '';
                alert('Сбой в получении данных');
            }
        }

    </script>

    <form method="post" action="<?echo $APPLICATION->GetCurPage()?>" enctype="multipart/form-data" name="post_form" id="post_form">
        <?
        echo bitrix_sessid_post();

        $tabControl->Begin();
        $tabControl->BeginNextTab();
        ?>
        <tr>
            <td colspan="2">

                <input type=button value="Старт" id="work_start" onclick="set_start(1)" />
                <input type=button value="Стоп" disabled id="work_stop" onclick="bSubmit=false;set_start(0)" />
                <div id="progress" style="display:none;" width="100%">
                    <br />
                    <div id="status"></div>
                    <table border="0" cellspacing="0" cellpadding="2" width="100%">
                        <tr>
                            <td height="10">
                                <div style="border:1px solid #B9CBDF">
                                    <div id="indicator" style="height:10px; width:0%; background-color:#B9CBDF"></div>
                                </div>
                            </td>
                            <td width=30>&nbsp;<span id="percent">0%</span></td>
                        </tr>
                    </table>
                </div>
                <div id="result" style="padding-top:10px"></div>

            </td>
        </tr>
        <?
        $tabControl->End();
        ?>
    </form>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");?>