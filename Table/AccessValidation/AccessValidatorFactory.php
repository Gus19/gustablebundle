<?php

/*
 * This file is part of the TableBundle.
 *
 * (c) Julien Albinet <julien.albinet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gus\TableBundle\Table\AccessValidation;

/**
 * Factory for creating the right validator,
 * depending on the developers access option.
 *
 * @author	Julien Albinet <julien.albinet@gmail.com>
 * @since	1.3
 */
class AccessValidatorFactory
{
	public static function getValidator($optionValue)
	{
		if($optionValue instanceof AccessValidatorInterface)
		{
			return $optionValue;
		}
		
		if(is_callable($optionValue))
		{
			return new CallableAccessValidator($optionValue);
		}
		
		if(is_string($optionValue) || is_array($optionValue))
		{
			return new RoleAccessValidator($optionValue);
		}
		
		return null;
	}
}
