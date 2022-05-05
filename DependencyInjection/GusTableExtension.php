<?php

namespace Gus\TableBundle\DependencyInjection;

/*
 * This file is part of the TableBundle.
 *
 * (c) Julien Albinet <julien.albinet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Gus\TableBundle\DependencyInjection\Service\TableFactoryService;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Extension for the TableBundle.
 * 
 * @author	Julien Albinet <julien.albinet@gmail.com>
 * @since	1.0
 */
class GusTableExtension extends Extension {
  /**
   * {@inheritDoc}
   */
  public function load(array $configs, ContainerBuilder $container) {
    $this->loadServices($container);
    $this->loadConfig($configs, $container);
  }

  private function loadServices(ContainerBuilder $container) {
    $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
    $loader->load('services.yaml');
    $container->setAlias(TableFactoryService::class, 'gus.table_factory');
  }

  private function loadConfig(array $configs, ContainerBuilder $container) {
    $configuration = new Configuration();
    $config = $this->processConfiguration($configuration, $configs);

    // Columns.
    $container->setParameter('gus_table.columns', array_merge($config['columns'], $configuration->getDefaultColumns()));

    // Filters.
    $container->setParameter('gus_table.filters', array_merge($config['filters'], $configuration->getDefaultFilters()));

    // Filter expression.
    $container->setParameter('gus_table.filter_expressions', array_merge_recursive($config['filter_expressions'], $configuration->getDefaultFilterExpressionManipulators()));

    // Default table options.
    $container->setParameter('gus_table.default_options', $config['default_options']);

    // Default filter options.
    $container->setParameter('gus_table.filter_default_options', $config['filter_default_options']);

    // Default pagination options.
    $container->setParameter('gus_table.pagination_default_options', $config['pagination_default_options']);

    // Default order options.
    $container->setParameter('gus_table.order_default_options', $config['order_default_options']);
  }

  public function getAlias(): string {
    return 'gus_table';
  }
}