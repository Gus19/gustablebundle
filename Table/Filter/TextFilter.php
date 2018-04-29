<?php

/*
 * This file is part of the TableBundle.
 *
 * (c) Julien Albinet <julien.albinet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JGM\TableBundle\Table\Filter;

/**
 * Simple filter for filtering text.
 *
 * @author	Jan Mühlig <mail@jamuehlig.de>
 * @since	1.0
 */
class TextFilter extends AbstractFilter
{
	public function needsFormEnviroment()
	{
		return true;
	}

	public function getWidgetBlockName()
	{
		return 'text_widget';
	}
}
