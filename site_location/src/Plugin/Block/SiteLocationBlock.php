<?php

namespace Drupal\site_location\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\site_location\Services\LocationServices;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'form' block.
 *
 * @Block(
 *   id = "site_location_block",
 *   admin_label = @Translation("Site Location"),
 *   category = @Translation("Custom")
 * )
 */

class SiteLocationBlock extends BlockBase implements ContainerFactoryPluginInterface {
  
  /**
   * @var customservice\Drupal\site_location\Services\LocationServices
   */
  protected $location_service;
  
  /**
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   Class ContainerInterface.
   * @param array $configuration
   *   The Configuration.
   * @param string $plugin_id
   *   The Plugin ID.
   * @param mixed $plugin_definition
   *   The Plugin Definition.
   *
   * @return static
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('location_service')
    );
  }

  /**
   * @param array $configuration
   *   The Configuration.
   * @param string $plugin_id
   *   The Plugin ID.
   * @param mixed $plugin_definition
   *   The Plugin Definition.
   * @param \Drupal\ac_form\Services\LocationServices $location_Services
   *   Class LocationServices.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, LocationServices $location_Services) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->location_service = $location_Services;
  }
  
  /**
   * {@inheritdoc}
   */
   public function build() {
       
      $location_info = $this->location_service->getSiteLocationSettings();
	  
	  return [
      '#theme' => 'site_location_block',
      '#data' => $location_info,
	  '#cache' => [
	     'tags' => ['config:site_location.settings']
	   ]
     ];
		
  }
  
}