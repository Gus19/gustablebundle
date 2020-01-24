<?php

/*
 * This file is part of the TableBundle.
 *
 * (c) Julien Albinet <horizon@julienalbinet.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JGM\TableBundle\Table\Filter;

/**
 * Simple filter for filtering text.
 *
 * @author	Gus
 * @since	1.0
 */
class NumberFilter extends AbstractFilter
{
    public function needsFormEnviroment()
    {
        return true;
    }

    public function getWidgetBlockName()
    {
        return 'number_widget';
    }
}
