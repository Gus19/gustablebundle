<?php

/*
 * This file is part of the TableBundle.
 *
 * (c) Julien Albinet <julien.albinet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gus\TableBundle\Table\Utils;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Router;
use Symfony\Component\Routing\RouterInterface;

/**
 * Helper for urls, used in the table bundle.
 *
 * @author	Julien Albinet <julien.albinet@gmail.com>
 * @since	1.0
 */
class UrlHelper
{
	/**
	 * @var Request
	 */
	private $request;
	
	/**
	 * @var Router
	 */
	private $router;
	
	public function __construct(RequestStack $requestStack, RouterInterface $router)
	{
		$this->request = $requestStack->getCurrentRequest();
		$this->router = $router;
	}
	
	/**
	 * Generates an url.
	 * Replaces the parameters of the given array or adds them,
	 * if they are not used, yet.
	 * 
	 * @param	array|null $replacedParameters	Parameters to replace in the url.
	 * @return	string							New generated url.
	 */
	public function getUrlForParameters(array $replacedParameters = array(), $anchor = null, $reset = false)
	{
		if(null === $this->request) 
		{
			return '';
		}
		
		$routeName = $this->request->get('_route');
    
    if(!$reset) {
      $currentRouteParams = array_merge(
        $this->request->attributes->get('_route_params'),
        $this->request->query->all()
      );
    }
    else {
      $currentRouteParams = $this->request->attributes->get('_route_params');
    }

		foreach($replacedParameters as $name => $value)
		{
			$currentRouteParams[$name] = $value;
		}
		
		// Cleaning up the parameters.
		foreach($currentRouteParams as $key => $value)
		{
			if($value === null /*|| trim($value) === ''*/)
			{
				unset($currentRouteParams[$key]);
			}
		}
		
		$url = $this->router->generate($routeName, $currentRouteParams);
		
		// Add the anchor, if given.
		if($anchor !== null)
		{
			$url .= sprintf("#%s", $anchor);
		}
		
		return $url;
	}
}
