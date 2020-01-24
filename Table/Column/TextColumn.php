<?php

/*
 * This file is part of the TableBundle.
 *
 * (c) Julien Albinet <julien.albinet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gus\TableBundle\Table\Column;

use Gus\TableBundle\Table\Row\Row;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * This column will only fetch the value of the property,
 * which has the same name like this column.
 *
 * @author	Julien Albinet <julien.albinet@gmail.com>
 * @since	1.0
 */
class TextColumn extends AbstractColumn
{
	protected function configureOptions(OptionsResolver $optionsResolver)
	{
		parent::configureOptions($optionsResolver);
		
		$optionsResolver->setDefaults(array(
			'nl2br' => false,
			'maxlength' => null,
			'after_maxlength' => '...',
			'empty_value' => null
		));
	}
  
	public function getContent(Row $row)
	{
		$value = $this->getValue($row);
		
		if($value === null || strlen($value) === 0)
		{
			return $this->options['empty_value'];
		}
		
		if($this->options['nl2br'] === true)
		{
			$value = nl2br($value);
		}
		
		if($this->options['maxlength'] !== null && strlen($value) > $this->options['maxlength'])
		{
			$value = substr($value, 0, $this->options['maxlength']) . $this->options['after_maxlength'];
		}
		
		return $value;
	}
}
