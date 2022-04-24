<?php

namespace Drupal\specbee\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\specbee\DateTimeCustomService;

/**
 * Provides a block for Domain menu.
 *
 * @Block(
 *   id = "Specbee_Time_Date_block",
 *   admin_label = @Translation("Timezone based Time Date"),
 * )
 */

class TimeDateBlock extends BlockBase implements ContainerFactoryPluginInterface
{
    /**
     * {@inheritdoc} 
     */

    /** 
     * The Time object.
     *
     * @var Drupal\specbee\DateTimeCustomService
     */
    protected $specbee;

    public function __construct(array $configuration, $plugin_id, $plugin_definition, DateTimeCustomService $specbee) {
        parent::__construct($configuration, $plugin_id, $plugin_definition);
        $this->specbee = $specbee;
    }

  /**
   * {@inheritdoc}
   */

    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
        return new static(
          $configuration,
          $plugin_id,
          $plugin_definition,
          $container->get('specbee.date_time_custom_services'),
        );
    }

    public function build()
    {   
        $data = [
            'Date'=> $this->specbee->getDate(),
            'Timezone'=> $this->specbee->getTimeZone(),
            'Country' => $this->specbee->getCountry(),
            'City' => $this->specbee->getCity(),
        ];
        return [
            '#data' => $data,
            '#theme' => 'specbee_date_time_block',
            '#cache' => array(
                'contexts'=>[],
                'tags' => ['config:specbee.adminsettings'],
                'max-age' => 60 - $this->specbee->getSeconds(),
            ),
        ];
    }
}