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

/**
 * Holder class for table options.
 * 
 * @author	Julien Albinet <julien.albinet@gmail.com>
 * @since	1.3
 */
class TableOptions
{
	const TEMPLATE				= 'template';
	const EMPTY_VALUE			= 'empty_value';
	const ATTRIBUTES			= 'attr';
	const HEAD_ATTRIBUTES		= 'head_attr';
	const HIDE_EMPTY_COLUMNS	= 'hide_empty_columns';
	const USE_FILTER			= 'use_filter';
	const USE_SELECTION			= 'use_selection';
	const USE_PAGINATION		= 'use_pagination';
	const USE_ORDER				= 'use_order';
	const LOAD_DATA				= 'load_data';
	const TOTAL_ITEMS			= 'total_items';
}
