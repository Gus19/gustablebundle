<?php

/*
 * This file is part of the TableBundle.
 *
 * (c) Julien Albinet <julien.albinet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gus\TableBundle\DependencyInjection\Listener;

use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

/**
 * Listener for listening response events.
 *
 * @author	Julien Albinet <julien.albinet@gmail.com>
 * @since	1.3
 */
class ResponseListener
{
	public function onKernelResponse(ResponseEvent $event)
	{
		if(!$event->isMainRequest())
		{
			return;
		}
		
		$request = $event->getRequest();
		$response = $event->getResponse();
		
		if($request->isMethod('post') && $request->request->has("table_option_values_table_name"))
		{
			$tableName = $request->get("table_option_values_table_name");
			
			$userItemsPerPage = (int) $request->get(sprintf("%s_option_values", $tableName));
			
			$cookie = new Cookie(sprintf("%s_items_per_page", $tableName), $userItemsPerPage);
			
			$response->headers->setCookie($cookie);
		}
	}
}
