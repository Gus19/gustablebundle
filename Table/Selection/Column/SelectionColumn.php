<?php

/*
 * This file is part of the TableBundle.
 *
 * (c) Julien Albinet <julien.albinet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gus\TableBundle\Table\Selection\Column;

use Gus\TableBundle\Table\Column\AbstractColumn;
use Gus\TableBundle\Table\Row\Row;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Rendering a checkbox for the selection component.
 *
 * @author	Julien Albinet <julien.albinet@gmail.com>
 * @since	1.3
 */
class SelectionColumn extends AbstractColumn
{
	protected function configureOptions(OptionsResolver $optionsResolver)
	{
		parent::configureOptions($optionsResolver);
		
		$optionsResolver->setDefault('label', '');
		$optionsResolver->setDefault('single_selection', false);
		$optionsResolver->setAllowedTypes('single_selection', 'bool');
	}
	
	public function getContent(Row $row)
	{
		$type = $this->options['single_selection'] === true ? "radio" : "checkbox";
		return sprintf(
			"<input type=\"%s\" name=\"selection_column[]\" value=\"%s\" />", 
			$type, 
//			$this->getName(), 
			$row->get('id')
		);
	}
	
	public function isSortable()
	{
		return false;
	}
}
