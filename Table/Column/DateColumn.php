<?php

/*
 * This file is part of the TableBundle.
 *
 * (c) Julien Albinet <julien.albinet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JGM\TableBundle\Table\Column;

use DateTime;
use JGM\TableBundle\Table\Row\Row;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Column for rendering date in format you like.
 *
 * @author	Julien Albinet <julien.albinet@gmail.com>
 * @since	1.0
 */
class DateColumn extends AbstractColumn
{
	public function configureOptions(OptionsResolver $optionsResolver)
	{
		parent::configureOptions($optionsResolver);
		
		$optionsResolver->setDefaults(array(
			'format' => 'd.m.Y H:i',
			'empty_value' => null
		));
	}


	public function getContent(Row $row)
	{
		$value = $this->getValue($row);
		
		if($value === null || (is_string($value) && strlen($value) === 0))
		{
			return $this->options['empty_value'];
		}
		
		if($value instanceof DateTime)
		{
			return $value->format($this->options['format']);
		}
		else
		{
			return date($this->options['format'], strtotime($value));
		}
	}
}
