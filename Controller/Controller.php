<?php

/*
 * This file is part of the TableBundle.
 *
 * (c) Julien Albinet <julien.albinet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gus\TableBundle\Controller;

use Gus\TableBundle\Table\Table;
use Gus\TableBundle\Table\TableTypeBuilder;
use Gus\TableBundle\Table\Type\AbstractTableType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller as SymfonyController;

/**
 * Extending the Symfony Controller with methods
 * for creating tables.
 *
 * @author	Julien Albinet <julien.albinet@gmail.com>
 * @since	1.0
 */
class Controller extends SymfonyController
{
	/**
	 * Builds a table by a table type.
	 * 
	 * @param AbstractTableType $tableType	TableType.
	 * @return	Table
	 */
	protected function createTable(AbstractTableType $tableType, array $options = array())
	{
		return $this->get('gus.table_factory')->createTable($tableType, $options);
	}
	
	/**
	 * Creats a table type builder, which is used to create
	 * tables without implementing a table type.
	 * 
	 * @since	1.2
	 * 
	 * @param string $name	Name of the table.
	 * @param array $options	Options of the table.
	 * 
	 * @return TableTypeBuilder
	 */
	protected function createTableTypeBuilder($name, array $options = array())
	{
		return $this->get('gus.table_factory')->createTableTypeBuilder($name, $options);
	}
}
