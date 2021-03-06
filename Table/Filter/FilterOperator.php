<?php

/*
 * This file is part of the TableBundle.
 *
 * (c) Julien Albinet <julien.albinet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gus\TableBundle\Table\Filter;

use Gus\TableBundle\Table\TableException;

/**
 * Available filter operators.
 * 
 * @author	Julien Albinet <julien.albinet@gmail.com>
 * @since	1.0
 */
class FilterOperator
{
	const EQ		= 0;
	const LIKE		= 1;
	const LT		= 2;
	const GT		= 3;
	const LEQ		= 4;
	const GEQ		= 5;
	const NOT_EQ	= 6;
	const NOT_LIKE	= 7;
	const IN = 8;
	const NOT_IN = 9;
	
	/**
	 * Ensures that the $operator is a valid filter operator.
	 * 
	 * @param int $operator
	 */
	public static function validate($operator)
	{
		$validOperators = array(self::EQ, self::LIKE, self::LT, self::GT, self::LEQ, self::GEQ, self::NOT_EQ, self::NOT_LIKE, self::IN, self::NOT_IN);
		if(!in_array($operator, $validOperators))
		{
			TableException::operatorNotValid($operator, $validOperators);
		}
	}
}
