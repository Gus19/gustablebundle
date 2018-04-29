<?php

/*
 * This file is part of the TableBundle.
 *
 * (c) Julien Albinet <julien.albinet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JGM\TableBundle\Table\Column;

use JGM\TableBundle\Table\Row\Row;
use JGM\TableBundle\Table\Utils\ReflectionHelper;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Abstract column, helpfull for the most options.
 * 
 * If you want to implement your own column,
 * you can - but don't have to - extend these
 * abstract column.
 *
 * @author	Julien Albinet <julien.albinet@gmail.com>
 * @since	1.0
 */
abstract class AbstractColumn implements ColumnInterface
{
	/**
	 * Resolver for the options.
	 * 
	 * @var OptionsResolver
	 */
	protected $optionsResolver;
	
	/**
	 * Resolved options.
	 * 
	 * @var array
	 */
	protected $options;
	
	/**
	 * @var string
	 */
	protected $name;
	
	/**
	 * {@inheritdoc}
	 */
	public function getAttributes()
	{
		return $this->options['attr'];
	}

	/**
	 * {@inheritdoc}
	 */
	public function getHeadAttributes()
	{
		return $this->options['head_attr'];
	}

	/**
	 * {@inheritdoc}
	 */
	public function getLabel()
	{
		return $this->options['label'];
	}

	/**
	 * {@inheritdoc}
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * {@inheritdoc}
	 */
	public function isSortable()
	{
		return $this->options['sortable'];
	}

	/**
	 * {@inheritdoc}
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setOptions(array $options)
	{
		$this->optionsResolver = new OptionsResolver();
		$this->configureOptions($this->optionsResolver);
		
		$this->options = $this->optionsResolver->resolve($options);
	}
  
  public function getColumns() {
    return $this->options['columns'];
  }
  
  public function isTrans() {
    return $this->options['trans'];
  }
	
	protected function configureOptions(OptionsResolver $optionsResolver)
	{
		$optionsResolver->setDefaults(array(
			'attr' => array(),
			'head_attr' => array(),
			'sortable' => true,
			'label' => $this->getName(),
      'columns' => null,
      'trans' => false
		));
	}
	
	/**
	 * Returns the value of the property.
	 * 
	 * @param Row $row
	 * @param string $columnName
	 * @return mixed
	 */
	protected function getValue(Row $row, $columnName = null)
	{
		if($columnName === null)
		{
			$columnName = $this->getName();
		}
		
		$properties = explode(".", $columnName);
		$value = $row->get($properties[0]);
		$countProperties = count($properties);
		for($i = 1; $i < $countProperties; $i++)
		{
			if($value === null)
			{
				return null;
			}
			
			$value = ReflectionHelper::getPropertyOfEntity($value, $properties[$i]);
		}

		return $value;
	}
}
