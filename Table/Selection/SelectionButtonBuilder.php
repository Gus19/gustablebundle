<?php

/*
 * This file is part of the TableBundle.
 *
 * (c) Julien Albinet <julien.albinet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gus\TableBundle\Table\Selection;

use Gus\TableBundle\Table\AccessValidation\AccessValidatorFactory;
use Gus\TableBundle\Table\Selection\Button\SubmitButton;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Builder for buttons, used for submitting selected 
 * rows of the table.
 * 
 * @author	Julien Albinet <julien.albinet@gmail.com>
 * @since	1.3
 */
class SelectionButtonBuilder
{
	/**
	 * @var AuthorizationCheckerInterface
	 */
	private $authorizationChecker;

	/**
	 * @var array
	 */
	private $buttons;
	
	public function __construct(AuthorizationCheckerInterface $authorizationChecker)
	{
		$this->authorizationChecker = $authorizationChecker;
		$this->buttons = array();
	}
	
	public function add($name, array $options = array())
	{
		if(array_key_exists('access', $options))
		{
			if($this->isAccessGranted($options['access']) === false)
			{
				return $this;
			}
			
			unset($options['access']);
		}
		
		$this->buttons[$name] = new SubmitButton($name, $options);
		
		return $this;
	}
	
	public function getButtons()
	{
		return $this->buttons;
	}
	
	private function isAccessGranted($access)
	{
		$validator = AccessValidatorFactory::getValidator($access);
		if($validator === null)
		{
			return false;
		}
		
		return $validator->isAccessGranted($this->authorizationChecker);
	}
}
