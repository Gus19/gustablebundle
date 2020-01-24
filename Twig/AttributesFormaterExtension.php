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

use Twig\Extension\AbstractExtension as Twig_Extension;
use Twig\TwigFilter as Twig_SimpleFilter;
use \Twig\Environment as Twig_Environment;

/**
 * Twig extension for formatting attributes
 * of an html object.
 * 
 * @author	Julien Albinet <julien.albinet@gmail.com>
 * @since	1.3
 */
class AttributesFormaterExtension extends Twig_Extension
{
	public function getName()
	{
		return 'attributes_format';
	}
	
	public function getFilters()
	{
		return array(
			new Twig_SimpleFilter('format_attributes', array($this, 'format'), array('is_safe' => array('html')))
		);
	}
	
	/**
	 * Formats an array of attributes:
	 *	The $attributes array('width' => '100px', 'class' => 'text-center row-gray')
	 *	will be 'width="100px" class="text-center row-gray"
	 * 
	 * @param array $attributes	List of given attributes.
	 * @return string	Formatted attributes.
	 */
	public function format(array $attributes)
	{
		$formatedAttributes = array();
		foreach($attributes as $attribute => $value) 
		{
			if($value !== null && empty($value) === false)
			{
				$formatedAttributes[] = sprintf("%s=\"%s\"", $attribute, $value);
			}
		}
		
		if(count($formatedAttributes) < 1) 
		{
			return "";
		}
		
		return " " . implode(" ", $formatedAttributes);
	}

}
