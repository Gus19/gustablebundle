<?php

/*
 * This file is part of the TableBundle.
 *
 * (c) Julien Albinet <julien.albinet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gus\TableBundle\Table\OptionsResolver;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * OptionsResolver for table options, used to resolve
 * options, set at the table type.
 *
 * @author	Julien Albinet <julien.albinet@gmail.com>
 * @since	1.0
 */
class TableOptionsResolver extends OptionsResolver
{
	function __construct(ContainerInterface $container) 
	{
		$globalDefaults = $container->getParameter('gus_table.default_options');
		
		$this->setDefaults(array(
			TableOptions::TEMPLATE => $globalDefaults[TableOptions::TEMPLATE],
			TableOptions::EMPTY_VALUE => $globalDefaults[TableOptions::EMPTY_VALUE],
			TableOptions::ATTRIBUTES => $globalDefaults[TableOptions::ATTRIBUTES],
			TableOptions::HEAD_ATTRIBUTES => $globalDefaults[TableOptions::HEAD_ATTRIBUTES],
			TableOptions::HIDE_EMPTY_COLUMNS => $globalDefaults[TableOptions::HIDE_EMPTY_COLUMNS],
			TableOptions::USE_FILTER => $globalDefaults[TableOptions::USE_FILTER],
			TableOptions::USE_PAGINATION => $globalDefaults[TableOptions::USE_PAGINATION],
			TableOptions::USE_ORDER => $globalDefaults[TableOptions::USE_ORDER],
			TableOptions::USE_SELECTION => $globalDefaults[TableOptions::USE_SELECTION],
			TableOptions::LOAD_DATA => $globalDefaults[TableOptions::LOAD_DATA]
		));
		
		$this->setAllowedTypes(TableOptions::TEMPLATE, 'string');
		$this->setAllowedTypes(TableOptions::EMPTY_VALUE, array('string', 'null'));
		$this->setAllowedTypes(TableOptions::ATTRIBUTES, 'array');
		$this->setAllowedTypes(TableOptions::HEAD_ATTRIBUTES, 'array');
		$this->setAllowedTypes(TableOptions::HIDE_EMPTY_COLUMNS, 'boolean');
		$this->setAllowedTypes(TableOptions::USE_FILTER, 'boolean');
		$this->setAllowedTypes(TableOptions::USE_PAGINATION, 'boolean');
		$this->setAllowedTypes(TableOptions::USE_ORDER, 'boolean');
		$this->setAllowedTypes(TableOptions::USE_SELECTION, 'boolean');
		$this->setAllowedTypes(TableOptions::LOAD_DATA, 'boolean');
	}
}
