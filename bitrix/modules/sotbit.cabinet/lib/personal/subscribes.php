<?php
/**
 * Copyright (c) 2017. Sergey Danilkin.
 */

/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 10/24/2017
 * Time: 10:15 AM
 */

namespace Sotbit\Cabinet\Personal;

/**
 * Class Subscribes
 * @package Sotbit\Cabinet\Personal
 * @author Sergey Danilkin <s.danilkin@sotbit.ru>
 */
class Subscribes extends \SotbitCabinet
{
	protected $email = '';
	/**
	 * @var array
	 */
	protected $filter     = array();
	/**
	 * @var array
	 */
	protected $subscribes = array();

	/**
	 * @var int
	 */
	protected $idSubscriber = 0;
	/**
	 * Subscribes constructor.
	 */
	public function __construct()
	{

	}

	/**
	 * @return array
	 */
	public function getFilter()
	{
		return $this->filter;
	}

	/**
	 * @return array
	 */
	public function getSubscribes()
	{
		return $this->subscribes;
	}

	/**
	 * @param array $filter
	 */
	public function setFilter($filter)
	{
		$this->filter = $filter;
	}

	/**
	 * @return string
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * @param string $email
	 */
	public function setEmail($email)
	{
		$this->email = $email;
	}

	/**
	 * @return int
	 */
	public function getIdSubscriber()
	{
		return $this->idSubscriber;
	}

	/**
	 * @param int $idSubscriber
	 */
	public function setIdSubscriber($idSubscriber)
	{
		$this->idSubscriber = $idSubscriber;
	}

	/**
	 * @param string $email
	 * @param array $subscribes
	 */
	public function updateSubdcribes($email = '', $subscribes = array())
	{
		if (filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			if($this->idSubscriber > 0)
			{
				$UPDATE_EMAIL_SAVE = array('EMAIL_TO'=>$email,'CATEGORIES_ID'=>$subscribes);
				\CSotbitMailingSubscribers::Update($this->idSubscriber, $UPDATE_EMAIL_SAVE);
			}
			else
			{
				\CsotbitMailingSubTools::AddSubscribers($email);
			}
		}
	}

	/**
	 *
	 */
	public function genSubscribes()
	{
		if($this->checkInstalledModules('sotbit.mailing') && !\SotbitCabinet::getInstance()->isDemo())
		{
			$subscriberCategories = array();
			$subscriber = \CSotbitMailingSubscribers::GetList(Array(), $this->filter, false, array('ID','EMAIL_TO'))->Fetch();
			if($subscriber['ID'] > 0)
			{
				$this->idSubscriber = $subscriber['ID'];
				$subscriberCategories = \CSotbitMailingSubscribers::GetCategoriesBySubscribers($subscriber['ID']);
				$this->email = $subscriber['EMAIL_TO'];
			}
			$rsCategories = \CSotbitMailingCategories::GetList(Array(
				'ID' => "ASC"
			), Array(
				'ACTIVE' => 'Y'
			), false, array());
			while ($category = $rsCategories->Fetch())
			{
				$this->subscribes[$category['ID']] = new Subscribe();
				$this->subscribes[$category['ID']]->setId($category['ID']);
				$this->subscribes[$category['ID']]->setName($category['NAME']);
				if(in_array($category['ID'], $subscriberCategories))
				{
					$this->subscribes[$category['ID']]->setSubscribed(true);
				}
			}
		}
	}

}