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
 * Expression manipulator, which will
 * implement a count expression for the
 * QueryBuilderDataSource.
 * 
 * @author	Julien Albinet <julien.albinet@gmail.com>
 * @since	1.0
 */
class DoctrineCountExpressionManipulator implements ExpressionManipulatorInterface
{
	public function getExpression($columnName, $columnValue = null)
	{
		return sprintf("count(%s)", $columnName);
	}

	public function getName()
	{
		return 'count';
	}
}
