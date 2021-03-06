<?php

namespace Gus\TableBundle\Table;

use Doctrine\ORM\QueryBuilder;
use Gus\TableBundle\Table\DataSource\ArrayDataSource;
use Gus\TableBundle\Table\DataSource\DataSourceInterface;
use Gus\TableBundle\Table\DataSource\EntityDataSource;
use Gus\TableBundle\Table\DataSource\QueryBuilderDataSource;
use Gus\TableBundle\Table\Filter\FilterBuilder;
use Gus\TableBundle\Table\Filter\Type\FilterTypeInterface;
use Gus\TableBundle\Table\Order\Type\OrderTypeInterface;
use Gus\TableBundle\Table\Pagination\Type\PaginationTypeInterface;
use Gus\TableBundle\Table\Type\AbstractTableType;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * TableTypeBuilder for building tables without any table type, 
 * i.e. at the controller.
 * 
 * @author	Julien Albinet <julien.albinet@gmail.com>
 * @since	1.2
 */
class TableTypeBuilder extends AbstractTableType implements PaginationTypeInterface, OrderTypeInterface, FilterTypeInterface
{
	/**
	 * @var string 
	 */
	protected $name;
	
	/**
	 * @var array
	 */
	protected $tableOptions;
	
	/**
	 * @var array
	 */
	protected $filterOptions;
	
	/**
	 * @var array
	 */
	protected $paginationOptions;
	
	/**
	 * @var array
	 */
	protected $orderOptions;
	
	/**
	 * @var Table
	 */
	protected $table;
	
	/**
	 * @var DataSourceInterface
	 */
	protected $dataSource;
	
	/**
	 * @var array
	 */
	protected $columns;
	
	/**
	 * @var array
	 */
	protected $filters;
	
	public function __construct($name, array $options, Table $table)
	{
		$this->name = $name;
		$this->tableOptions = $options;
		$this->table = $table;
		
		$this->columns = array();
		$this->filters = array();
		$this->filterOptions = array();
		$this->orderOptions = array();
		$this->paginationOptions = array();
		
		$this->tableOptions['use_filter'] = false;
		$this->tableOptions['use_order'] = false;
		$this->tableOptions['use_pagination'] = false;
	}
	
	/**
	 * Adds a column to the table.
	 * 
	 * @param string $type			Type of the column.
	 * @param string $name			Name of the column.
	 * @param array $options		Options of the column.
	 * 
	 * @return TableTypeBuilder
	 */
	public function addColumn($type, $name, array $options = array())
	{
		$this->columns[] = array($type, $name, $options);
		
		return $this;
	}
	
	/**
	 * Adds an entity data source to the table for the given entity.
	 * 
	 * @param string $entity		Name of the Entity, i.e. 'AcmeBundle:Car'.
	 * @param string $alias			Alias for the query builder.
	 * @param callback $callback	Callback, which takes a ORM QueryBuilder as parameter, for manipulating the query.
	 * 
	 * @return TableTypeBuilder
	 */
	public function forEntity($entity, $alias = 't', $callback = null)
	{
		$this->setDataSource(new EntityDataSource($entity, $alias, $callback));
		
		return $this;
	}
	
	/**
	 * Adds a query builder data source to the table for the given query builder.
	 * 
	 * @param QueryBuilder $queryBuilder	QueryBuilder.
	 * 
	 * @return TableTypeBuilder
	 */
	public function forQuery(QueryBuilder $queryBuilder)
	{
		$this->setDataSource(new QueryBuilderDataSource($queryBuilder));
		
		return $this;
	}
	
	/**
	 * Adds an array data source to the table for the given array.
	 * 
	 * @param array $data	Data, that will be displayed at the table.
	 * 
	 * @return TableTypeBuilder
	 */
	public function forArray(array $data)
	{
		$this->setDataSource(new ArrayDataSource($data));
		
		return $this;
	}
	
	/**
	 * Sets a given data source.
	 * 
	 * @param DataSourceInterface $dataSource	DataSource, which will organize the data of the table.
	 * 
	 * @return TableTypeBuilder
	 */
	public function setDataSource(DataSourceInterface $dataSource)
	{
		$this->dataSource = $dataSource;
		
		return $this;
	}
	
	/**
	 * Enables pagination with the given options.
	 * 
	 * @param array $options	Options for pagination.
	 * 
	 * @return TableTypeBuilder
	 */
	public function enablePagination(array $options = array())
	{
		$this->tableOptions['use_pagination'] = true;
		$this->paginationOptions = $options;
		
		return $this;
	}
	
	/**
	 * Enables order with the given options.
	 * 
	 * @param array $options	Options for order.
	 * 
	 * @return TableTypeBuilder
	 */
	public function enableOrder(array $options = array())
	{
		$this->tableOptions['use_order'] = true;
		$this->orderOptions = $options;
		
		return $this;
	}
	
	/**
	 * Enables filters with the given options.
	 * 
	 * @param array $options	Options for filters.
	 * 
	 * @return TableTypeBuilder
	 */
	public function enableFilter(array $options = array())
	{
		$this->tableOptions['use_filter'] = true;
		$this->filterOptions = $options;
		
		return $this;
	}
	
	/**
	 * Adds a filter to the table.
	 * 
	 * @param string $type			Type of the filter.
	 * @param string $name			Name of the filter.
	 * @param array $options		Options of the filter.
	 * 
	 * @return TableTypeBuilder
	 */
	public function addFilter($type, $name, array $options = array())
	{
		$this->filters[] = array($type, $name, $options);
		
		return $this;
	}
	
	/**
	 * Returns the table.
	 * 
	 * @return Table
	 */
	public function getTable()
	{
		return $this->table->create($this, $this->tableOptions);
	}

	public function getDataSource(ContainerInterface $container)
	{
		return $this->dataSource;
	}

	public function getName()
	{
		return $this->name;
	}
	
	public function buildTable(TableBuilder $builder)
	{
		foreach($this->columns as $column)
		{
			$builder->add($column[0], $column[1], $column[2]);
		}
	}

	public function buildFilter(FilterBuilder $filterBuilder)
	{
		foreach($this->filters as $filter)
		{
			$filterBuilder->add($filter[0], $filter[1], $filter[2]);
		}
	}

	public function configureFilterButtonOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults($this->filterOptions);
	}

	public function configureOrderOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults($this->orderOptions);
	}

	public function configurePaginationOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults($this->paginationOptions);
	}

}
