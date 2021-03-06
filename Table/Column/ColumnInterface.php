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
 * Interface for all columns of the table tool.
 * 
 * If you want to implement your own column,
 * you have to implement this interface.
 * 
 * @author	Julien Albinet <julien.albinet@gmail.com>
 * @since	1.0
 */
interface ColumnInterface
{
	/**
	 * @return string			Label for this column.
	 */
	public function getLabel();
	
	/**
	 * @return string			Name of this column.
	 */
	public function getName();
	
	/**
	 * @return array			Attributes for the head (th).
	 */
	public function getHeadAttributes();
	
	/**
	 * @return array			Attributes for every row (tr).
	 */
	public function getAttributes();
	
	/** 
	 * @param Row $row	Row, for that we want the content.
	 * 
	 * @return string			Content of this column on the given row.
	 */
	public function getContent(Row $row);
	
	/**
	 * @return boolean			True, if this column is sortable.
	 */
	public function isSortable();
	
	/**
	 * Here are your options. 
	 * Do whatever you want with these.
	 * 
	 * @param array $options	Options.
	 */
	public function setOptions(array $options);
	
	/**
	 * This is your name in the table.
	 * 
	 * @param string $name		Name.
	 */
	public function setName($name);
}
