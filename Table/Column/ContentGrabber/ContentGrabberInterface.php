<?php

/*
 * This file is part of the TableBundle.
 *
 * (c) Julien Albinet <julien.albinet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gus\TableBundle\Table\Column\ContentGrabber;

use Gus\TableBundle\Table\Row\Row;
use Gus\TableBundle\Table\Column\ColumnInterface;

/**
 * ContentGrabber interface.
 * A content grabber can create content for
 * a table cell.
 * 
 * @author	Julien Albinet <julien.albinet@gmail.com>
 * @since	1.0
 */
interface ContentGrabberInterface
{
	public function getContent(Row $row, ColumnInterface $column);
}
