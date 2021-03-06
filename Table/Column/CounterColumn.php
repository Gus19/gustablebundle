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

/**
 * Shows the row-counter.
 *
 * @author	Julien Albinet <julien.albinet@gmail.com>
 * @since	1.0
 */
class CounterColumn extends AbstractColumn
{	
	public function configureOptions(\Symfony\Component\OptionsResolver\OptionsResolver $optionsResolver)
	{
		parent::configureOptions($optionsResolver);
		
		$optionsResolver->setDefault('prefix', '');
	}
	
	public function getContent(Row $row)
	{
		return $this->options['prefix'] . $row->getCount();
	}
}
