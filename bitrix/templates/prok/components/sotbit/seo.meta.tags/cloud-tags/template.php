<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
//echo "<pre>";
//print_r($arResult['ITEMS']);
//echo "</pre>";
if($arResult['ITEMS'])
{
    $countItems = count($arResult['ITEMS']);
    $count=0;
    ?>
    <h5 style="padding-bottom: 0px;font-size: 14px;-webkit-margin-before: 0.67em;-webkit-margin-after: 0.67em;">Часто ищут </h5>
    <div style="margin-top: 5px;margin-bottom: 5px;">
        <?
        foreach($arResult['ITEMS'] as $Item)
        {
            $count++;
            ?>

            <?
            if($Item['TITLE'] && $Item['URL'])
            {

                echo "<a class=\"sotbit-seometa-tag-link\" href=\"".$Item['URL']."\" title=\"".$Item['TITLE']."\">".$Item['TITLE']."</a>";

                if($count<$countItems){echo ", ";}
            }
            ?>

            <?
        }
        ?>
    </div>
    <?
}

?>