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
use Gus\TableBundle\Table\OptionsResolver\TableOptions;
use Gus\TableBundle\Table\Order\Model\Order;
use Gus\TableBundle\Table\Order\OptionsResolver\OrderOptions;
use Gus\TableBundle\Table\Pagination\OptionsResolver\PaginationOptions;
use Gus\TableBundle\Table\TableView;
use Gus\TableBundle\Table\Utils\UrlHelper;
use \Twig\Environment as Twig_Environment;
use \Twig\TwigFunction as Twig_SimpleFunction;

/**
 * Twig extension for render the table view
 * at twig templates.
 * 
 * @author	Julien Albinet <julien.albinet@gmail.com>
 * @since	1.0
 */
class TableExtension extends AbstractTwigExtension
{
	public function __construct(UrlHelper $urlHelper, TableStopwatchService $stopwatchService)
	{
		parent::__construct($urlHelper, $stopwatchService);
	}
	
	public function getName(): string
	{
		return 'table';
	}
	
	public function getFunctions(): array
	{
		return array(
			new Twig_SimpleFunction('table', array($this, 'getTableContent'), array('is_safe' => array('html'), 'needs_environment' => true)),
			new Twig_SimpleFunction('table_begin', array($this, 'getTableBeginContent'), array('is_safe' => array('html'), 'needs_environment' => true)),
			new Twig_SimpleFunction('table_head', array($this, 'getTableHeadContent'), array('is_safe' => array('html'), 'needs_environment' => true)),
			new Twig_SimpleFunction('table_body', array($this, 'getTableBodyContent'), array('is_safe' => array('html'), 'needs_environment' => true)),
			new Twig_SimpleFunction('table_end', array($this, 'getTableEndContent'), array('is_safe' => array('html'), 'needs_environment' => true)),
		);
	}
	
	public function getTableContent(Twig_Environment $environment, TableView $tableView, $options = array())
	{
		$template = $this->loadTemplate($environment, $tableView->getTableOption(TableOptions::TEMPLATE));
		return $template->renderBlock('table', array(
			'view' => $tableView,
			'isPaginatable' => $tableView->hasPagination(),
      'options' => $options
		));
	}
	
	public function getTableBeginContent(Twig_Environment $environment, TableView $tableView, $options = array())
	{
		$template = $this->loadTemplate($environment, $tableView->getTableOption(TableOptions::TEMPLATE));
		
		$content = $template->renderBlock('table_begin', array(
			'name' => $tableView->getName(),
			'attributes' => $tableView->getTableOption(TableOptions::ATTRIBUTES),
			'isSelectable' => count($tableView->getSelectionButtons()) > 0,
      'options' => $options
		));
		
		return $content;
	}
	
	public function getTableHeadContent(Twig_Environment $environment, TableView $tableView, $options = array())
	{
		$templateName = $tableView->getTableOption(TableOptions::TEMPLATE);
		$viewParameters = array(
      'columns' => $tableView->getColumns(),
      'options' => $options
    );
		if($tableView->hasOrder())
		{
			$templateName = $tableView->getOrderOption(OrderOptions::TEMPLATE);
			$parameters = array(
				'columnName' => $tableView->getOrderOption(OrderOptions::PARAM_COLUMN), 
				'direction' => $tableView->getOrderOption(OrderOptions::PARAM_DIRECTION),
			);
			if($tableView->hasPagination())
			{
				$parameters['pagination'] = $tableView->getPaginationOption(PaginationOptions::PARAM);
			}
			else
			{
				$parameters['pagination'] = null;
			}
			$viewParameters['parameters'] = $parameters;
			$viewParameters['classes'] = array(
				Order::DIRECTION_ASC => $tableView->getOrderOption(OrderOptions::CLASS_ASC),
				Order::DIRECTION_DESC => $tableView->getOrderOption(OrderOptions::CLASS_DESC)
			);
			$viewParameters['orderHtml'] =  array(
				Order::DIRECTION_ASC => $tableView->getOrderOption(OrderOptions::HTML_ASC),
				Order::DIRECTION_DESC => $tableView->getOrderOption(OrderOptions::HTML_DESC)
			);
			$viewParameters['currentDirection'] = $tableView->getOrderOption(OrderOptions::CURRENT_DIRECTION);
			$viewParameters['currentColumnName'] = $tableView->getOrderOption(OrderOptions::CURRENT_COLUMN);
			
			if(!empty($viewParameters['classes'][Order::DIRECTION_ASC]) || !empty($viewParameters['classes'][Order::DIRECTION_DESC]))
			{
				@trigger_error(
					'The oder options "class_asc" and "class_desc" are deprecated since v1.3 and will be removed in 1.4. Use "html_asc" and "html_desc" instead.',
					E_USER_DEPRECATED
				);
			}
		}
		
		$template = $this->loadTemplate($environment, $templateName);
		$content = $template->renderBlock('table_head', $viewParameters);
		
		return $content;
	}
	
	public function getTableBodyContent(Twig_Environment $environment, TableView $tableView, $options = array())
	{
		$template = $this->loadTemplate($environment, $tableView->getTableOption(TableOptions::TEMPLATE));
		$content = $template->renderBlock('table_body', array(
			'columns' => $tableView->getColumns(),
			'rows' => $tableView->getRows(),
			'emptyValue' => $tableView->getTableOption(TableOptions::EMPTY_VALUE),
			'tableView' => $tableView,
      'options' => $options
		));
		
		return $content;
	}
	
	public function getTableEndContent(Twig_Environment $environment, TableView $tableView, $renderSelectionButtons = true, $options = array())
	{
		$template = $this->loadTemplate($environment, $tableView->getTableOption(TableOptions::TEMPLATE));
		$content = $template->renderBlock('table_end', array(
			'tableView' => $tableView,
			'isSelectable' => count($tableView->getSelectionButtons()) > 0,
			'columnsLength' => count($tableView->getColumns()),
			'renderSelectionButtons' => $renderSelectionButtons,
      'options' => $options
		));
		
		return $content;
	}
}
