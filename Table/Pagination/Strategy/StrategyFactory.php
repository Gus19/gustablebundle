<?php

/*
 * This file is part of the TableBundle.
 *
 * (c) Julien Albinet <julien.albinet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JGM\TableBundle\Table\Pagination\Strategy;

/**
 * The StrategyFactory will choose the right pagination
 * strategy in dependency of total pages and maximal pages.
 *
 * @author	Julien Albinet <julien.albinet@gmail.com>
 * @since	1.0
 */
class StrategyFactory 
{
	/**
	 * Creates the proper strategy considered by total and maximal pages.
	 * 
	 * @param int $totalPages		Number of total pages.
	 * @param int $maxPages			Number of maximal pages.
	 * 
	 * @return StrategyInterface	Proper strategy.
	 */
	public static function getStrategy($totalPages, $maxPages)
	{
		if($maxPages !== null && $totalPages > $maxPages)
		{
			return new SimpleLimitStrategy();
		}
		else
		{
			return new AllPagesStrategy();
		}
	}
}
