<?php

/*
 * This file is part of the TableBundle.
 *
 * (c) Julien Albinet <julien.albinet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gus\TableBundle\Table\Order\Type;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * If a table type implements this interface, it marks the table
 * as ordered.
 * The interface provides a method for setting the default options
 * for beeing sortable.
 * 
 * @author	Julien Albinet <julien.albinet@gmail.com>
 * @since	1.0
 */
interface OrderTypeInterface
{
	/**
	 * Configures the default options for the order table type.
	 * 
	 * @param OptionsResolver $resolver
	 */
	public function configureOrderOptions(OptionsResolver $resolver);
}
