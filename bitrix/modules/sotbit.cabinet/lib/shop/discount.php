<?php
/**
 * Copyright (c) 2017. Sergey Danilkin.
 */

/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 10/26/2017
 * Time: 10:32 AM
 */

namespace Sotbit\Cabinet\Shop;


use Bitrix\Main\Loader;

/**
 * Class Discount
 * @package Sotbit\Cabinet\Shop
 * @author Sergey Danilkin <s.danilkin@sotbit.ru>
 */
class Discount extends \SotbitCabinet
{
	/**
	 * @var string
	 */
	protected $name = '';
	/**
	 * @var string
	 */
	protected $description = '';

	/**
	 * Discount constructor.
	 * @param array $filter
	 */
	public function __construct($filter = array())
	{
		if(!\SotbitCabinet::getInstance()->isDemo() && Loader::includeModule('catalog'))
		{
			$discount = \Bitrix\Catalog\DiscountTable::getList(
				array(
					'filter' => $filter,
					'select' => array(
						'ID',
						'NAME',
						'NOTES'
					),
					'limit' => 1
				)
			)->fetch();
			if($discount['ID'] > 0)
			{
				$this->name = $discount['NAME'];
				$this->description = $discount['NOTES'];
			}
		}
	}
	/**
	 * @param string $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * @param string $description
	 */
	public function setDescription($description)
	{
		$this->description = $description;
	}
	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @return string
	 */
	public function getDescription()
	{
		return $this->description;
	}
}