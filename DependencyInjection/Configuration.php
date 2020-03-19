<?php

/*
 * This file is part of the TableBundle.
 *
 * (c) Julien Albinet <julien.albinet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gus\TableBundle\DependencyInjection;

use Gus\TableBundle\Table\Filter\OptionsResolver\FilterOptions;
use Gus\TableBundle\Table\OptionsResolver\TableOptions;
use Gus\TableBundle\Table\Order\OptionsResolver\OrderOptions;
use Gus\TableBundle\Table\Pagination\OptionsResolver\PaginationOptions;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Configuration for the TableBundle.
 * 
 * @author	Julien Albinet <julien.albinet@gmail.com>
 * @since	1.0
 */
class Configuration implements ConfigurationInterface {
  /**
  * {@inheritDoc}
  */
  public function getConfigTreeBuilder()  {
    //throw new \Exception("Ici !");
    //$treeBuilder = new TreeBuilder();
    //$rootNode = $treeBuilder->root('gus_table');
    $treeBuilder = new TreeBuilder('gus_table');

    $treeBuilder->getRootNode()
			->children()

				->arrayNode('columns')
					->prototype('scalar')->end()
				->end()

				->arrayNode('filters')
					->prototype('scalar')->end()
				->end()

				->arrayNode('filter_expressions')
					->prototype('array')
						->prototype('scalar')->end()
					->end()
				->end()

				->arrayNode('default_options')
					->children()
						->scalarNode(TableOptions::TEMPLATE)
							->defaultValue('@GusTable/Blocks/table.html.twig')
						->end()
						->scalarNode(TableOptions::EMPTY_VALUE)
							->defaultValue('table.noresult')
						->end()
						->arrayNode(TableOptions::ATTRIBUTES)
							->prototype('scalar')->end()
						->end()
						->arrayNode(TableOptions::HEAD_ATTRIBUTES)
							->prototype('scalar')->end()
						->end()
						->booleanNode(TableOptions::HIDE_EMPTY_COLUMNS)
							->defaultFalse()
						->end()
						->booleanNode(TableOptions::USE_FILTER)
							->defaultTrue()
						->end()
						->booleanNode(TableOptions::USE_PAGINATION)
							->defaultTrue()
						->end()
						->booleanNode(TableOptions::USE_ORDER)
							->defaultTrue()
						->end()
						->booleanNode(TableOptions::USE_SELECTION)
							->defaultTrue()
						->end()
						->booleanNode(TableOptions::LOAD_DATA)
							->defaultTrue()
						->end()
					->end()
					->addDefaultsIfNotSet()
				->end()

				->arrayNode('filter_default_options')
					->children()
						->scalarNode(FilterOptions::TEMPLATE)
							->defaultValue('@GusTable/Blocks/filter.html.twig')
						->end()
						->scalarNode(FilterOptions::SUBMIT_LABEL)
							->defaultValue('submit')
						->end()
						->arrayNode(FilterOptions::SUBMIT_ATTRIBUTES)
							->prototype('scalar')->end()
						->end()
						->scalarNode(FilterOptions::RESET_LABEL)
							->defaultValue('reset')
						->end()
						->arrayNode(FilterOptions::RESET_ATTRIBUTES)
							->prototype('scalar')->end()
						->end()
					->end()
					->addDefaultsIfNotSet()
				->end()

				->arrayNode('pagination_default_options')
					->children()
						->scalarNode(PaginationOptions::TEMPLATE)
							->defaultValue('@GusTable/Blocks/pagination.html.twig')
						->end()
						->scalarNode(PaginationOptions::PARAM)
							->defaultValue('page')
						->end()
						->integerNode(PaginationOptions::ROWS_PER_PAGE)
							->defaultValue(20)
						->end()
						->booleanNode(PaginationOptions::SHOW_EMPTY)
							->defaultTrue()
						->end()
						->scalarNode(PaginationOptions::UL_CLASS)
							->defaultValue('pagination')
						->end()
						->scalarNode(PaginationOptions::LI_CLASS)
							->defaultValue('page-item')
						->end()
						->scalarNode(PaginationOptions::LI_CLASS_ACTIVE)
							->defaultValue('page-item active')
						->end()
						->scalarNode(PaginationOptions::LI_CLASS_DISABLED)
							->defaultValue('page-item disabled')
						->end()
            ->scalarNode(PaginationOptions::A_CLASS)
              ->defaultValue('page-link')
            ->end()
						->scalarNode(PaginationOptions::PREV_LABEL)
							->defaultValue('&laquo')
						->end()
						->scalarNode(PaginationOptions::NEXT_LABEL)
							->defaultValue('&raquo')
						->end()
						->integerNode(PaginationOptions::MAX_PAGES)
							->defaultValue(null)
						->end()

						->arrayNode(PaginationOptions::OPTION_VALUES)
							->prototype('integer')->end()
						->end()
						->arrayNode(PaginationOptions::OPTION_ATTRIBUTES)
							->prototype('scalar')->end()
						->end()
						->scalarNode(PaginationOptions::OPTION_LABEL)
							->defaultValue('Entries per Page')
						->end()
						->arrayNode(PaginationOptions::OPTION_LABEL_ATTRIBUTES)
							->prototype('scalar')->end()
						->end()
						->scalarNode(PaginationOptions::OPTION_SUBMIT_LABEL)
							->defaultValue('Submit')
						->end()
						->arrayNode(PaginationOptions::OPTION_SUBMIT_ATTRIBUTES)
							->prototype('scalar')->end()
						->end()
					->end()
					->addDefaultsIfNotSet()
				->end()

				->arrayNode('order_default_options')
					->children()
						->scalarNode(OrderOptions::TEMPLATE)
							->defaultValue('@GusTable/Blocks/order.html.twig')
						->end()
						->scalarNode(OrderOptions::PARAM_DIRECTION)
							->defaultValue('direction')
						->end()
						->scalarNode(OrderOptions::PARAM_COLUMN)
							->defaultValue('column')
						->end()
						->scalarNode(OrderOptions::EMPTY_DIRECTION)
							->defaultValue('desc')
						->end()
						->scalarNode(OrderOptions::EMPTY_COLUMN)
							->defaultValue(null)
						->end()
						->scalarNode(OrderOptions::CLASS_ASC)
							->defaultNull()
						->end()
						->scalarNode(OrderOptions::CLASS_DESC)
							->defaultNull()
						->end()
						->scalarNode(OrderOptions::HTML_ASC)
							->defaultValue('&uarr;')
						->end()
						->scalarNode(OrderOptions::HTML_DESC)
							->defaultValue('&darr;')
						->end()
					->end()
					->addDefaultsIfNotSet()
				->end()

			->end();

        return $treeBuilder;
    }

	public function getDefaultColumns()
	{
		return array(
			'array'		=> 'Gus\TableBundle\Table\Column\ArrayColumn',
			'boolean'	=> 'Gus\TableBundle\Table\Column\BooleanColumn',
			'content'	=> 'Gus\TableBundle\Table\Column\ContentColumn',
			'counter'	=> 'Gus\TableBundle\Table\Column\CounterColumn',
			'date'		=> 'Gus\TableBundle\Table\Column\DateColumn',
			'entity'	=> 'Gus\TableBundle\Table\Column\EntityColumn',
			'number'	=> 'Gus\TableBundle\Table\Column\NumberColumn',
			'text'		=> 'Gus\TableBundle\Table\Column\TextColumn',
			'twig'		=> 'Gus\TableBundle\Table\Column\TwigColumn',
			'url'		=> 'Gus\TableBundle\Table\Column\UrlColumn',
			'selection'	=> 'Gus\TableBundle\Table\Selection\Column\SelectionColumn'
		);
	}

	public function getDefaultFilters()
	{
		return array(
			'text'		=> 'Gus\TableBundle\Table\Filter\TextFilter',
			'number'		=> 'Gus\TableBundle\Table\Filter\NumberFilter',
			'entity'	=> 'Gus\TableBundle\Table\Filter\EntityFilter',
			'boolean'	=> 'Gus\TableBundle\Table\Filter\BooleanFilter',
			'valued'	=> 'Gus\TableBundle\Table\Filter\ValuedFilter',
			'date'		=> 'Gus\TableBundle\Table\Filter\DateFilter'
		);
	}

	public function getDefaultFilterExpressionManipulators()
	{
		return array(
			'doctrine'	=> array(
				'Gus\TableBundle\Table\Filter\ExpressionManipulator\DoctrineCountExpressionManipulator',
				'Gus\TableBundle\Table\Filter\ExpressionManipulator\DoctrineSumExpressionManipulator',
				'Gus\TableBundle\Table\Filter\ExpressionManipulator\DoctrineMinExpressionManipulator',
				'Gus\TableBundle\Table\Filter\ExpressionManipulator\DoctrineMaxExpressionManipulator',
				'Gus\TableBundle\Table\Filter\ExpressionManipulator\DoctrineAvgExpressionManipulator'
			)
		);
	}
}
