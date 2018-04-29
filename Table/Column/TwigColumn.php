<?php

/*
 * This file is part of the TableBundle.
 *
 * (c) Julien Albinet <julien.albinet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JGM\TableBundle\Table\Column;

use JGM\TableBundle\Table\Row\Row;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Column for rendering twig tempaltes.
 * 
 * @author	Julien Albinet <julien.albinet@gmail.com>
 * @since	1.1
 */
class TwigColumn extends AbstractColumn implements ContainerAwareInterface
{
	/**
	 * @var ContainerInterface
	 */
	protected $container;
	
	public function configureOptions(OptionsResolver $optionsResolver)
	{
		parent::configureOptions($optionsResolver);
		
		$optionsResolver->setDefault('view', null);
		$optionsResolver->setRequired('view');
	}
	
	public function setContainer(ContainerInterface $container = null)
	{
		$this->container = $container;
	}
	
	public function getContent(Row $row)
	{	
		return $this
			->container
			->get('templating')
			->render(
				$this->options['view'], 
				array('row' => $row, 'entity' => $row->getEntity())
			);
	}
  
  public function getView() {
    return $this->options['view'];
  }
}
