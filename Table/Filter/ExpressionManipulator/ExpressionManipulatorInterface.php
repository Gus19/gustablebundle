<?php

/*
 * This file is part of the TableBundle.
 *
 * (c) Julien Albinet <julien.albinet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gus\TableBundle\Table\Filter\ExpressionManipulator;

/**
 * Interface for manipulators, which can manipulate
 * an expression for a column filter.
 * 
 * @author	Julien Albinet <julien.albinet@gmail.com>
 * @since	1.0
 */
interface ExpressionManipulatorInterface
{
	/**
	 * Name of the column, thats expression
	 * will be manipulated.
	 * 
	 * @return string
	 */
	public function getName();
	
	/**
	 * Returns the manipulated expression
	 * of the given columns name and value,
	 * if the value is known.
	 * 
	 * @return mixed
	 */
	public function getExpression($columnName, $columnValue = null);
}
