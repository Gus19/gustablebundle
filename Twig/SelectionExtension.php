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
class SelectionExtension extends AbstractTwigExtension
{
	public function __construct(UrlHelper $urlHelper, TableStopwatchService $stopwatchService)
	{
		parent::__construct($urlHelper, $stopwatchService);
	}
	
	public function getName(): string
	{
		return 'selection';
	}

	public function getFunctions(): array
	{
		return array(
			new Twig_SimpleFunction ('selection_buttons', array($this, 'getSelectionButtons'), array('is_safe' => array('html'), 'needs_environment' => true)),
			new Twig_SimpleFunction ('selection_button', array($this, 'getSelectionButton'), array('is_safe' => array('html'), 'needs_environment' => true))
		);
	}
	public function getSelectionButtons(Twig_Environment $environment, TableView $tableView)
	{
		$template = $this->loadTemplate($environment, '@GusTable/Blocks/selection.html.twig');
		
		return $template->renderBlock('selection_buttons', array(
			'tableView' => $tableView,
			'buttons' => $tableView->getSelectionButtons()
		));
	}
	
	public function getSelectionButton(Twig_Environment $environment, TableView $tableView, $buttonName)
	{
		$template = $this->loadTemplate($environment, '@GusTable/Blocks/selection.html.twig');
		
		$buttons =  $tableView->getSelectionButtons();
		return $template->renderBlock('selection_button', array(
			'button' => $buttons[$buttonName]
		));
	}
}
