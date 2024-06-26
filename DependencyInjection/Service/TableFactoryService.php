<?php

/*
 * This file is part of the TableBundle.
 *
 * (c) Julien Albinet <julien.albinet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gus\TableBundle\DependencyInjection\Service;

use Doctrine\ORM\EntityManager;
use Gus\TableBundle\DependencyInjection\Service\TableStopwatchService;
use Gus\TableBundle\Table\Table;
use Gus\TableBundle\Table\TableTypeBuilder;
use Gus\TableBundle\Table\Type\AbstractTableType;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Service TableFactory for creating tables from controller.
 * 
 * @author	Julien Albinet <julien.albinet@gmail.com>
 * @since	1.0
 */
class TableFactoryService
{	
	/**
	 * Container.
	 * 
	 * @var ContainerInterface
	 */
	private $container;
	
	/**
	 * Current request.
	 * 
	 * @var Request 
	 */
	private $request;
	
	/**
	 * EntityManager.
	 * 
	 * @var EntityManager 
	 */
	private $entityManager;
	
	/**
	 * Router.
	 * 
	 * @var RouterInterface 
	 */
	private $router;
	
	/**
	 * @var TableStopwatchService
	 */
	private $stopwatchService;
	
	/**
	 * @var TableHintService
	 */
	private $hintService;
	
	/**
	 * Are there multiple instances of tables
	 * on this view?
	 * 
	 * @var boolean
	 */
	private $isMulti = false;

	private AuthorizationCheckerInterface $authorizationChecker;
	
	function __construct(ContainerInterface $container, EntityManager $entityManager, RequestStack $requestStack, RouterInterface $router, TableStopwatchService $stopwatchService, TableHintService $hintService, AuthorizationCheckerInterface $authorizationChecker)
	{
		$this->container = $container;
		$this->entityManager = $entityManager;
		$this->request = $requestStack->getCurrentRequest();
		$this->router = $router;
		$this->stopwatchService = $stopwatchService;
		$this->hintService = $hintService;
		$this->authorizationChecker = $authorizationChecker;
	}
	
	/**
	 * Builds a table by a table type.
	 * 
	 * @param AbstractTableType $tableType	TableType.
	 * @param array $options	Options of the table.
	 * @return	Table
	 */
	public function createTable(AbstractTableType $tableType, array $options = array())
	{
		$table = new Table($this->container, $this->entityManager, $this->request, $this->router, $this->isMulti, $this->stopwatchService, $this->hintService, $this->authorizationChecker);
		
		$this->isMulti = true;
		
		return $table->create($tableType, $options);
	}
	
	/**
	 * Creats a table builder, which is used to create
	 * tables without implementing a table type.
	 * 
	 * @param string $name		Name of the table.
	 * @param array $options	Options of the table.
	 * 
	 * @return TableTypeBuilder
	 */
	public function createTableTypeBuilder($name, array $options = array())
	{
		$table = new Table($this->container, $this->entityManager, $this->request, $this->router, $this->logger, $this->isMulti, $this->stopwatchService, $this->authorizationChecker);
		
		$this->isMulti = true;
		
		return new TableTypeBuilder($name, $options, $table);
	}
}
