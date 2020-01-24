<?php

/*
 * This file is part of the TableBundle.
 *
 * (c) Julien Albinet <julien.albinet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gus\TableBundle\Table\Order\OptionsResolver;

/**
 * Holder class for order options.
 * 
 * @author	Julien Albinet <julien.albinet@gmail.com>
 * @since	1.3
 */
class OrderOptions
{
	const TEMPLATE			= 'template';
	const PARAM_DIRECTION	= 'param_direction';
	const PARAM_COLUMN		= 'param_column';
	const EMPTY_DIRECTION	= 'empty_direction';
	const EMPTY_COLUMN		= 'empty_column';
	const CLASS_ASC			= 'class_asc';
	const CLASS_DESC		= 'class_desc';
	const HTML_ASC			= 'html_asc';
	const HTML_DESC			= 'html_desc';
	
	const CURRENT_COLUMN	= 'current_column';
	const CURRENT_DIRECTION	= 'current_direction';
}
