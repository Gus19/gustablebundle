<?php

/*
 * This file is part of the TableBundle.
 *
 * (c) Julien Albinet <julien.albinet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gus\TableBundle\Table\Filter\ValueManipulator;

/**
 * Value Manipulator Interface, which can manipulate a filter given value.
 */
interface ValueManipulatorInterface
{
	public function getValue($originalValue);
}
