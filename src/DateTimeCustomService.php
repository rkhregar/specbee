<?php

namespace Drupal\specbee;

use Drupal\Component\Datetime\Time;
use Drupal\Core\Datetime\DateFormatter;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Class CustomService
 * @package Drupal\specbee\Services
 */
class DateTimeCustomService {

  /**
   * The Date Formatter.
   *
   * @var Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $config_factory;

  /**
   * The Time.
   *
   * @var Drupal\Component\Datetime\Time
   */
  protected $time;

  /**
   * The Date Formatter.
   *
   * @var Drupal\Core\Datetime\DateFormatter
   */
  protected $dateFormatter;

  public function __construct(ConfigFactoryInterface $config_factory, Time $time, DateFormatter $dateFormatter) {
    $this->config_factory = $config_factory;
    $this->time = $time;
    $this->dateFormatter = $dateFormatter;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('datetime.time'),
      $container->get('date.formatter'),
    );
  }

  public function getDate() {
    $specbee_settings = $this->config_factory->getEditable('specbee.adminsettings');
    $timeZone = $specbee_settings->get('specbee_timezone');
    $timestamp = $this->time->getCurrentTime();
    $type = 'specbee_custom_date';
    $format = 'dS M Y - h:i A';
    $date = $this->dateFormatter->format($timestamp, $type, $format, $timeZone);
    return $date;
  }

  Public function getTimeZone(){
    $specbee_settings = $this->config_factory->getEditable('specbee.adminsettings');
    $timeZone = $specbee_settings->get('specbee_timezone');
    //show system timezone in case the timezone is not selected
    if(empty($timeZone)){
      $timeZone = \Drupal::config('system.date')->get('timezone')['default'];
    }
    return $timeZone;
  }

  public function getCountry(){
    $specbee_settings = $this->config_factory->getEditable('specbee.adminsettings');
    $country = $specbee_settings->get('specbee_country');
    // Shows system cuntry if not set 
    if(empty($country)){
      $country =  \Drupal::config('system.date')->get('country')['default']; 
    }
    return $country;
  }

  public function getCity(){
    $specbee_settings = $this->config_factory->getEditable('specbee.adminsettings');
    $city = $specbee_settings->get('specbee_city');
    // shows City as unknown if not set
    if(empty($city)){
      $city = 'Unknown';
    }
    return $city;
  }

  public function getSeconds(){
    $timestamp = $this->time->getCurrentTime();
    $type = 'specbee_seconds';
    $format = 's';
    $seconds = $this->dateFormatter->format($timestamp, $type, $format);
    return (int)$seconds;
  }
}