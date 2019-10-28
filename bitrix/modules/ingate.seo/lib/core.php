<?php
namespace Ingate\Seo;

use Bitrix\Main\Config\Option;
use \Bitrix\Main\Loader;
use \Bitrix\Main\HttpApplication;
use \Bitrix\Main\Application;

class Core
{
	const MODULE_ID = INGATE_SEO_MODULE_ID;

	public static function getCurrentUrlFromTableByField($table = '', $where = '')
	{
		if (
			empty($where) ||
			!class_exists($table) ||
			!Loader::includeModule(self::MODULE_ID)
		) {
			return false;
		}

        $request = HttpApplication::getInstance()->getContext()->getRequest();
		$server = HttpApplication::getInstance()->getContext()->getServer();

		$requestUri = $request->getRequestUri();

		if (empty($requestUri)) {
			return false;
		}

		$arPattern = array(
			'\'',
			'[',
			']',
			'(',
			')',
			'|',
			'*',
			'%5B',
			'%5D',
			'%7C',
			'%2a',
			'%27',
			'%28',
			'%29',
			'%2B',
			'%3A',
			'?',
		);

		$arReplace = array(
			'[\'\']',
			'\\\\[',
			'\\\\]',
			'[(]',
			'[)]',
			'[|]',
			'[*]',
			'\\\\%5B',
			'\\\\%5D',
			'[%7C]',
			'[%2a]',
			'[%27]',
			'[%28]',
			'[%29]',
			'[%2B]',
			'[%3A]',
			'[?]',
		);

        $page = $requestUri;

        if ($exlusions = Option::get(self::MODULE_ID, INGATE_SEO_OPTION_EXCLUSIONS)) {
            $arUri = explode('?', $requestUri);
            $page = $arUri[0];

            $arExlusions = explode(PHP_EOL, $exlusions);
            $patternExlusions = '/(&|\?)('.implode('|', $arExlusions).')[^&]*/i';

            if ($arUri[1]) {
                $query = trim(
                    preg_replace($patternExlusions, '', '?'.$arUri[1]),
                    '&'
                );

                if (!empty($query))
                    $page .= '?'.trim($query, '?');
            }
        }

		$uri = str_replace($arPattern, $arReplace, $page);

        $domain = $server->getServerName();
		$uriDecoded = str_replace("'", "''", urldecode($uri));

		$connection = Application::getConnection();

		$sql = "SELECT * FROM ".$table::getTableName()
			." WHERE `".$where."` REGEXP '^(http(s)?:\/\/)?("
			.$domain.preg_replace('/(%20|\s|\+)/iu', '[+]', $uri)
			."|".$domain.preg_replace('/\s/iu', '[+]', $uriDecoded)
			.")$'"
			." AND `ACTIVE` = 'Y' ORDER BY `id` LIMIT 1";

		$recordset = $connection->query($sql);

		return $recordset->fetch();
	}
}
