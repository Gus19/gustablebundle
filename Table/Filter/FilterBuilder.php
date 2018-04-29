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

use JGM\TableBundle\Table\Filter\FilterInterface;
use JGM\TableBundle\Table\TableException;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Builder for building table filters.
 * 
 * @author	Julien Albinet <julien.albinet@gmail.com>
 * @since	1.0
 */
class FilterBuilder
{
	/**
	 * @var array
	 */
	private $filters;
	
	/**
	 * @var array
	 */
	private $registeredFilters;
	
	/**
	 * @var ContainerInterface
	 */
	private $container;
	
	public function __construct(ContainerInterface $container)
	{
		$this->filters = array();
		
		$this->registeredFilters = $container->getParameter('jgm_table.filters');
		
		$this->container = $container;
	}
	
	public function add($type, $name, array $options = array())
	{
		if(array_key_exists($name, $this->filters))
		{
			TableException::duplicatedFilterName($this->container->get('jgm.table_context')->getCurrentTableName(), $name);
		}
		
		$type = strtolower($type);
		if(!array_key_exists($type, $this->registeredFilters))
		{
			TableException::filterTypeNotAllowed($this->container->get('jgm.table_context')->getCurrentTableName(), $type, array_keys($this->registeredFilters));
		}
		
		$filter = new $this->registeredFilters[$type]($this->container);
		/* @var $filter FilterInterface */
		
		if(!$filter instanceof FilterInterface)
		{
			TableException::filterClassNotImplementingInterface(
				$this->container->get('jgm.table_context')->getCurrentTableName(), 
				$filter
			);
		}
		
		$filter->setName($name);
    
    $defaultOptions = array(
      'label_attr' => array('class' => 'control-label'),
      'attr' => array(
        'class' => 'form-control'
      )
    );              
		$filter->setOptions(array_merge($defaultOptions, $options));		
		$this->filters[$name] = $filter;
		
		return $this;
	}
	
	public function getFilters()
	{
		return $this->filters;
	}
}
