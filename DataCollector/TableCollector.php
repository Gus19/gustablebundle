<?php

/*
 * This file is part of the TableBundle.
 *
 * (c) Julien Albinet <julien.albinet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gus\TableBundle\DataCollector;

use Exception;
use Gus\TableBundle\DependencyInjection\Service\TableContext;
use Gus\TableBundle\DependencyInjection\Service\TableHintService;
use Gus\TableBundle\DependencyInjection\Service\TableStopwatchService;
use Gus\TableBundle\Table\TableException;
use Gus\TableBundle\Version;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollectorInterface;

/**
 * Collector for collecting information of the table bundle
 * and the builded tables.
 * Information will be displayed at the debug toolbar and web profiler.
 *
 * @author	Julien Albinet <julien.albinet@gmail.com>
 * @since	1.2
 */
class TableCollector implements DataCollectorInterface
{
	/**
	 * @var TableContext
	 */
	private $tableContext;
	
	/**
	 * @var TableStopwatchService
	 */
	private $stopwatchService;
	
	/**
	 * @var TableHintService
	 */
	private $hintService;
	
	public function __construct(TableContext $tableContext, TableStopwatchService $stopwatchService, TableHintService $hintService)
	{
		$this->tableContext = $tableContext;
		$this->stopwatchService = $stopwatchService;
		$this->hintService = $hintService;
		$this->data = array();
	}
	
	public function collect(Request $request, Response $response, \Throwable $exception = null)
	{
		$this->data['count'] = count($this->tableContext->getAllRegisteredTables());
		$this->data['duration'] = $this->stopwatchService->getDuration();
		$this->data['table-times'] = $this->stopwatchService->getStopwatchesData();
		$this->data['hints'] = $this->hintService->getHints();
		
		
		if($exception instanceof TableException)
		{
			$this->data['exception'] = $exception;
		}
		else
		{
			$this->data['exception'] = null;
		}
	}
	
	public function getCount()
	{
		return $this->data['count'];
	}
	
	public function getDuration()
	{
		return $this->data['duration'];
	}
	
	public function getTableTimes()
	{
		return $this->data['table-times'];
	}
	
	public function getTables()
	{
		return $this->data['tables'];
	}
	
	public function getException()
	{
		return $this->data['exception'];
	}
	
	public function getHints()
	{
		return $this->data['hints'];
	}

	public function getVersion()
	{
		return Version::getVersion();
	}
	
	public function getName(): string
	{
		return 'gus.table_collector';
	}
	
	protected function formatAttributes(array $attributes)
	{
		$formatedAttributes = array();
		foreach($attributes as $key => $value)
		{
			$formatedAttributes[] = sprintf("%s='%s'", $key, $value);
		}
		
		return $formatedAttributes;
	}

	public function reset() {
  }
}
