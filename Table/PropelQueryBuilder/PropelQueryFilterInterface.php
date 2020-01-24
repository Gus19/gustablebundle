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
interface PropelQueryFilterInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getCriteria();

    /**
     * @return string
     */
    public function getValue();
}