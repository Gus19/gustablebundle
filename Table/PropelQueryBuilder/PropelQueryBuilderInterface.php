<?php

/*
 * This file is part of the TableBundle.
 *
 * (c) Julien Albinet <julien.albinet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gus\TableBundle\Table\PropelQueryBuilder;

/**
 * @author	Daniel Purrucker <daniel.purrucker@nordakademie.de>
 * @since	1.3
 */
interface PropelQueryBuilderInterface
{
    /**
     * @return PropelQueryBuilderInterface[]
     */
    public function getUsages();

    /**
     * @param string|array $column
     * @param mixed $value
     * @param mixed $operator
     */
    public function addUsage($column, $value, $operator = null);

    /**
     * @return PropelQueryFilterInterface[]
     */
    public function getFilters();

    /**
     * @param string $string
     * @param mixed $value
     * @param mixed $operator
     */
    public function addFilter($string, $value, $operator = null);

    /**
     * @return string
     */
    public function getTable();

    /**
     * @param \ModelCriteria $query
     * @return \ModelCriteria
     */
    public function applyFilterOnQuery(\ModelCriteria $query);
}