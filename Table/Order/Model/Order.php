<?php

/*
 * This file is part of the TableBundle.
 *
 * (c) Julien Albinet <julien.albinet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gus\TableBundle\Table\Order\Model;

use Gus\TableBundle\Table\Order\OptionsResolver\OrderOptions;

/**
 * Container for the options of the order component.
 *
 * @author		Julien Albinet <julien.albinet@gmail.com>
 * @since		1.0
 */
class Order
{
	const DIRECTION_ASC = 'asc';
	const DIRECTION_DESC = 'desc';
	
	/**
	 * @var array
	 */
	private $options;
	
	public function __construct(array $options)
	{
		$this->options = $options;
	}
	
	public function getTemplate()
	{
		return $this->options[OrderOptions::TEMPLATE];
	}
	
	public function getParamDirectionName()
	{
		return $this->options[OrderOptions::PARAM_DIRECTION];
	}

	public function getParamColumnName()
	{
		return $this->options[OrderOptions::PARAM_COLUMN];
	}
	
	public function getEmptyDirection() 
	{
		return $this->options[OrderOptions::EMPTY_DIRECTION];
	}
	
	public function getEmptyColumnName()
	{
		return $this->options[OrderOptions::EMPTY_COLUMN];
	}

	public function getClasses()
	{
		return array(
			self::DIRECTION_ASC => $this->options[OrderOptions::CLASS_ASC],
			self::DIRECTION_DESC => $this->options[OrderOptions::CLASS_DESC]
		);
	}
	
	public function getHtml()
	{
		return array(
			self::DIRECTION_ASC => $this->options[OrderOptions::HTML_ASC],
			self::DIRECTION_DESC => $this->options[OrderOptions::HTML_DESC]
		);
	}
	
	public function getCurrentDirection()
	{
		return $this->options[OrderOptions::CURRENT_DIRECTION];
	}

	public function getCurrentColumnName()
	{
		return $this->options[OrderOptions::CURRENT_COLUMN];
	}
}
