<?php

/*
 * This file is part of the TableBundle.
 *
 * (c) Julien Albinet <julien.albinet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gus\TableBundle\Table\Type;

use Doctrine\ORM\EntityManager;
use Gus\TableBundle\Table\Row\Row;
use Gus\TableBundle\Table\TableBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * The abstract table type which user defined table types based on.
 * User defined table types have to implement the abstract methods
 * `buildTable`, `getName` and `configureOptions`.
 * Further they can implement optionally the method `getRowAttributes`.
 * 
 * The table type injects the container and the entity manager.
 * 
 * @author	Julien Albinet <julien.albinet@gmail.com>
 * @since	1.0
 */
abstract class AbstractTableType implements TableTypeInterface
{
	/**
	 * Container
	 * 
	 * @var ContainerInterface 
	 */
	protected $container;
	
	/**
	 * EntityManager.
	 * 
	 * @var EntityManager 
	 */
	protected $entityManager;
	
	/**
	 * {@inheritdoc}
	 */
	public final function getContainer()
	{
		return $this->container;
	}

	/**
	 * {@inheritdoc}
	 */
	public final function getEntityManager()
	{
		return $this->entityManager;
	}

	/**
	 * {@inheritdoc}
	 */
	public final function setContainer(ContainerInterface $container = null)
	{
		$this->container = $container;
	}

	/**
	 * {@inheritdoc}
	 */
	public final function setEntityManager(EntityManager $entityManager)
	{
		$this->entityManager = $entityManager;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getRowAttributes(Row $row)
	{
		return array();
	}

	/**
	 * {@inheritdoc}
	 */
	public function buildTable(TableBuilder $builder)
	{
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function configureOptions(OptionsResolver $resolver)
	{
    $resolver->setDefaults(array(
      'attr' => array('class' => 'table table-bordered table-striped table-condensed table-sm')
    ));
	}
}
