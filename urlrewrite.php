<?php
$arUrlRewrite=array (
  0 => 
  array (
    'CONDITION' => '#^/catalog/brands/filter/(.+?)/apply/\\??(.*)#',
    'RULE' => 'SMART_FILTER_PATH=$1&$2',
    'ID' => 'bitrix:catalog.smart.filter',
    'PATH' => '/catalog/brands.php',
    'SORT' => 100,
  ),
  1 => 
  array (
    'CONDITION' => '#^/online/([\\.\\-0-9a-zA-Z]+)(/?)([^/]*)#',
    'RULE' => 'alias=$1',
    'ID' => '',
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  27 => 
  array (
    'CONDITION' => '#^/support/product-presentation/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/support/product-presentation/index.php',
    'SORT' => 100,
  ),
  26 => 
  array (
    'CONDITION' => '#^/support/reference-materials/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/support/reference-materials/index.php',
    'SORT' => 100,
  ),
  36 => 
  array (
    'CONDITION' => '#^/how-to-order/dostavka-test/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/how-to-order/dostavka-test/index.php',
    'SORT' => 100,
  ),
  28 => 
  array (
    'CONDITION' => '#^/support/conversion-table/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/support/conversion-table/index.php',
    'SORT' => 100,
  ),
  5 => 
  array (
    'CONDITION' => '#^/bitrix/services/ymarket/#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/bitrix/services/ymarket/index.php',
    'SORT' => 100,
  ),
  31 => 
  array (
    'CONDITION' => '#^/about/information/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/about/information/index.php',
    'SORT' => 100,
  ),
  7 => 
  array (
    'CONDITION' => '#^/online/(/?)([^/]*)#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  8 => 
  array (
    'CONDITION' => '#^/stssync/calendar/#',
    'RULE' => '',
    'ID' => 'bitrix:stssync.server',
    'PATH' => '/bitrix/services/stssync/calendar/index.php',
    'SORT' => 100,
  ),
  9 => 
  array (
    'CONDITION' => '#^/personal/order/#',
    'RULE' => '',
    'ID' => 'bitrix:sale.personal.order',
    'PATH' => '/personal/order/index.php',
    'SORT' => 100,
  ),
  10 => 
  array (
    'CONDITION' => '#^/catalog/brands/#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/catalog/brands.php',
    'SORT' => 100,
  ),
  19 => 
  array (
    'CONDITION' => '#^/about/career/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/about/career/index.php',
    'SORT' => 100,
  ),
  12 => 
  array (
    'CONDITION' => '#^/about/stock/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/about/stock/index.php',
    'SORT' => 100,
  ),
  13 => 
  array (
    'CONDITION' => '#^/novinki/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/novinki/index.php',
    'SORT' => 100,
  ),
  37 => 
  array (
    'CONDITION' => '#^/catalog/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog',
    'PATH' => '/catalog/index.php',
    'SORT' => 100,
  ),
  15 => 
  array (
    'CONDITION' => '#^/store/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog.store',
    'PATH' => '/store/index.php',
    'SORT' => 100,
  ),
  29 => 
  array (
    'CONDITION' => '#^/stock/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/stock/index.php',
    'SORT' => 100,
  ),
  35 => 
  array (
    'CONDITION' => '#^\\??(.*)#',
    'RULE' => '&$1',
    'ID' => 'bitrix:catalog.section',
    'PATH' => '/bitrix/templates/.default/components/bitrix/catalog/proc_v2/bitrix/catalog.element/.default/template.php',
    'SORT' => 100,
  ),
  30 => 
  array (
    'CONDITION' => '#^/news/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/news/index.php',
    'SORT' => 100,
  ),
  33 => 
  array (
    'CONDITION' => '#^/docs/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/docs/index.php',
    'SORT' => 100,
  ),
);
