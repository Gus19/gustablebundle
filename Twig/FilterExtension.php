<?php

/*
 * This file is part of the TableBundle.
 *
 * (c) Julien Albinet <julien.albinet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gus\TableBundle\Twig;

use Gus\TableBundle\DependencyInjection\Service\TableStopwatchService;
use Gus\TableBundle\Table\Filter\FilterInterface;
use Gus\TableBundle\Table\Filter\OptionsResolver\FilterOptions;
use Gus\TableBundle\Table\TableException;
use Gus\TableBundle\Table\TableView;
use Gus\TableBundle\Table\Utils\UrlHelper;
use \Twig\Environment as Twig_Environment;
use \Twig\TwigFunction as Twig_SimpleFunction;

/**
 * Twig extension for render the table filter views.
 * 
 * @author	Julien Albinet <julien.albinet@gmail.com>
 * @since	1.3
 */
class FilterExtension extends AbstractTwigExtension
{
	/**
	 * Not every filter_* method, called from 
	 * twig template, needs the view. There are
	 * some methods like filter_label, which accepts
	 * the filter interface only. For these methods,
	 * we'll save the tableView, which were passed on
	 * beginning (filter_begin).
	 * 
	 * @var TableView 
	 */
	protected $tableView;
	
	/**
	 * Array for mapping tables and their
	 * need for form environments.
	 * The key of the map is the table name,
	 * the value is a boolean.
	 * 
	 * @var array
	 */
	protected $filterNeedsFormEnvironment;
	
	public function __construct(UrlHelper $urlHelper, TableStopwatchService $stopwatchService)
	{
		parent::__construct($urlHelper, $stopwatchService);
		
		$this->filterNeedsFormEnvironment = array();
	}
	
	public function getName(): string
	{
		return 'filter';
	}

	public function getFunctions(): array
	{
		return array(
			new Twig_SimpleFunction ('filter', array($this, 'getFilterContent'), array('is_safe' => array('html'), 'needs_environment' => true)),
			new Twig_SimpleFunction ('filter_label', array($this, 'getFilterLabelContent'), array('is_safe' => array('html'), 'needs_environment' => true)),
			new Twig_SimpleFunction ('filter_widget', array($this, 'getFilterWidgetContent'), array('is_safe' => array('html'), 'needs_environment' => true)),
			new Twig_SimpleFunction ('filter_row', array($this, 'getFilterRowContent'), array('is_safe' => array('html'), 'needs_environment' => true)),
			new Twig_SimpleFunction ('filter_rows', array($this, 'getFilterRowsContent'), array('is_safe' => array('html'), 'needs_environment' => true)),
			new Twig_SimpleFunction ('filter_begin', array($this, 'getFilterBeginContent'), array('is_safe' => array('html'), 'needs_environment' => true)),
			new Twig_SimpleFunction ('filter_submit_button', array($this, 'getFilterSubmitButtonContent'), array('is_safe' => array('html'), 'needs_environment' => true)),
			new Twig_SimpleFunction ('filter_reset_link', array($this, 'getFilterResetLinkContent'), array('is_safe' => array('html'), 'needs_environment' => true)),
			new Twig_SimpleFunction ('filter_end', array($this, 'getFilterEndContent'), array('is_safe' => array('html'), 'needs_environment' => true)),
			new Twig_SimpleFunction ('filter_url', array($this, 'getFilterUrl'))
		);
	}
	public function getFilterContent(Twig_Environment $environment, TableView $tableView)
	{
		$template = $this->loadTemplate(
			$environment, 
			$tableView->getFilterOption(FilterOptions::TEMPLATE)
		);
		
		return $template->renderBlock('filter', array(
				'view' => $tableView
		));
	}
	
	public function getFilterBeginContent(Twig_Environment $environment, TableView $tableView)
	{
		$this->tableView = $tableView;
		
		$template = $this->loadTemplate(
			$environment, 
			$this->tableView->getFilterOption(FilterOptions::TEMPLATE)
		);
		
		$content = $template->renderBlock('filter_begin', array(
			'needsFormEnviroment' => $this->getFilterNeedsFormEnviroment($tableView),
			'tableName' => $tableView->getName()
		));
		
		return $content;
	}
	
	public function getFilterWidgetContent(Twig_Environment $environment, FilterInterface $filter)
	{
		if($this->tableView === null)
		{
			TableException::filterRenderingNotStarted($filter->getName());
		}
		
		$template = $this->loadTemplate(
			$environment, 
			$this->tableView->getFilterOption(FilterOptions::TEMPLATE)
		);
		
		$content = $template->renderBlock('filter_widget', array(
			'filter' => $filter
		));
		
		return $content;
	}
	
	public function getFilterLabelContent(Twig_Environment $environment, FilterInterface $filter)
	{
		if($this->tableView === null)
		{
			TableException::filterRenderingNotStarted($filter->getName());
		}
		
		$template = $this->loadTemplate(
			$environment,
			$this->tableView->getFilterOption(FilterOptions::TEMPLATE)
		);
		
		$content = $template->renderBlock('filter_label', array(
			'filter' => $filter
		));
		
		return $content;
	}
	
	public function getFilterRowContent(Twig_Environment $environment, FilterInterface $filter)
	{
		if($this->tableView === null)
		{
			TableException::filterRenderingNotStarted();
		}
		
		$template = $this->loadTemplate(
			$environment, 
			$this->tableView->getFilterOption(FilterOptions::TEMPLATE)
		);
		
		return $template->renderBlock('filter_row', array(
			'filter' => $filter
		));
	}
	
	public function getFilterRowsContent(Twig_Environment $environment, $tableViewOrFilterArray)
	{
		if($this->tableView === null)
		{
			TableException::filterRenderingNotStarted();
		}
		
		$template = $this->loadTemplate(
			$environment, 
			$this->tableView->getFilterOption(FilterOptions::TEMPLATE)
		);
		
		$filters = array();
		if($tableViewOrFilterArray instanceof TableView)
		{
			$filters = $tableViewOrFilterArray->getFilters();
		}
		else if(is_array($tableViewOrFilterArray))
		{
			$filters = $tableViewOrFilterArray;
		}
		else
		{
			TableException::canNotRenderFilter();
		}
		
		return $template->renderBlock('filter_rows', array(
			'filters' => $filters
		));
	}
	
	public function getFilterSubmitButtonContent(Twig_Environment $environment, TableView $tableView)
	{
		if($tableView->hasFilter() === false)
		{
			return;
		}
		
		$template = $this->loadTemplate(
			$environment, 
			$tableView->getFilterOption(FilterOptions::TEMPLATE)
		);
		
		$content = $template->renderBlock('filter_submit_button', array(
		  'form' => $tableView,
			'needsFormEnviroment' => $this->getFilterNeedsFormEnviroment($tableView),
			'submitLabel' => $tableView->getFilterOption(FilterOptions::SUBMIT_LABEL),
			'attributes' => $tableView->getFilterOption(FilterOptions::SUBMIT_ATTRIBUTES)
		));

		return $content;
	}
	
	public function getFilterResetLinkContent(Twig_Environment $environment, TableView $tableView)
	{
		if($tableView->hasFilter() === false)
		{
			return;
		}
		
		$filterParams = array();
		foreach($tableView->getFilters() as $filter)
		{
			$filterParams[$filter->getName()] = null;
		}
		
		$template = $this->loadTemplate(
			$environment, 
			$tableView->getFilterOption(FilterOptions::TEMPLATE)
		);
		
		$content = $template->renderBlock('filter_reset_link', array(
			'needsFormEnviroment' => $this->getFilterNeedsFormEnviroment($tableView),
			'resetLabel' => $tableView->getFilterOption(FilterOptions::RESET_LABEL),
			'attributes' => $tableView->getFilterOption(FilterOptions::RESET_ATTRIBUTES),
			'resetUrl' => $this->urlHelper->getUrlForParameters($filterParams, null, true)
		));
		
		return $content;
	}
	
	public function getFilterEndContent(Twig_Environment $environment, TableView $tableView)
	{
		$this->tableView = null;
		
		$template = $this->loadTemplate(
			$environment, 
			$tableView->getFilterOption(FilterOptions::TEMPLATE)
		);
		
		$content = $template->renderBlock('filter_end', array(
			'needsFormEnviroment' => $this->getFilterNeedsFormEnviroment($tableView)
		));
		
		return $content;
	}
	
	public function getFilterUrl(array $params)
	{		
		return $this->urlHelper->getUrlForParameters($params);
	}

	protected function getFilterNeedsFormEnviroment(TableView $tableView)
	{
		$tableName = $tableView->getName();
		if(array_key_exists($tableName, $this->filterNeedsFormEnvironment) === false)
		{
			$needsForEnvironment = false;
			foreach($tableView->getFilters() as $filter)
			{
				/* @var $filter FilterInterface */
				if($filter->needsFormEnviroment())
				{
					$needsForEnvironment = true;
					break;
				}
			}
			
			$this->filterNeedsFormEnvironment[$tableName] = $needsForEnvironment;
			return $needsForEnvironment;
		}
		
		return $this->filterNeedsFormEnvironment[$tableName];
	}
}
