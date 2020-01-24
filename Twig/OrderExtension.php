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
use Gus\TableBundle\Table\Order\Model\Order;
use Gus\TableBundle\Table\Utils\UrlHelper;
use \Twig\TwigFunction as Twig_SimpleFunction;
use \Twig\Environment as Twig_Environment;

/**
 * Twig extension implementing helper methods
 * for the order component. The rendering
 * is part of the TableExtension
 * 
 * @author	Julien Albinet <julien.albinet@gmail.com>
 * @since	1.3
 */
class OrderExtension extends AbstractTwigExtension
{
	public function __construct(UrlHelper $urlHelper, TableStopwatchService $stopwatchService)
	{
		parent::__construct($urlHelper, $stopwatchService);
	}
	
	public function getName()
	{
		return 'order';
	}
	
	public function getFunctions()
	{
		return array(
			new Twig_SimpleFunction ('order_url', array($this, 'getOrderUrl')),
		);
	}
	
	public function getOrderUrl($parameterColumnName, $columnName, $parameterDirection, $currentDirection, $currentColumnName, $parameterPagination = null)
	{
		$parameters = array($parameterColumnName => $columnName);
		if($currentColumnName == $columnName && $currentDirection == Order::DIRECTION_ASC)
		{
			$parameters[$parameterDirection] = Order::DIRECTION_DESC;
		}
		else
		{
			$parameters[$parameterDirection] = Order::DIRECTION_ASC;
		}
		
		// Start at first page.
		if($parameterPagination !== null && empty($parameterPagination) === false)
		{
			$parameters[$parameterPagination] = 1;
		}
		
		return $this->urlHelper->getUrlForParameters($parameters);
	}
}
