<?php

/*
 * This file is part of the TableBundle.
 *
 * (c) Julien Albinet <julien.albinet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gus\TableBundle\Table\Filter\Type;

use Gus\TableBundle\Table\Filter\FilterBuilder;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * If a table type implements this interface, it marks the table
 * as using filters.
 * The interface provides a method for building the filters, used
 * by the table.
 * 
 * @author	Julien Albinet <julien.albinet@gmail.com>
 * @since	1.0
 */
interface FilterTypeInterface
{
	/**
	 * Builds the filters, by adding some filters to the builder.
	 * 
	 * @param FilterBuilder $filterBuilder	Instance of the filter builder.
	 */
	public function buildFilter(FilterBuilder $filterBuilder);
	
	/**
	 * Configures the options for the filter buttons.
	 * 
	 * @param OptionsResolver $resolver
	 */
	public function configureFilterButtonOptions(OptionsResolver $resolver);
}
