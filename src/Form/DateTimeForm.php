<?php  
/**  
 * @file  
 * Contains Drupal\specbee\Form\DateTime.  
 */  
namespace Drupal\specbee\Form;

use Drupal\Core\Form\ConfigFormBase;  
use Drupal\Core\Form\FormStateInterface;
  
class DateTimeForm extends ConfigFormBase {  
   /**  
   * {@inheritdoc}  
   */ 

  protected function getEditableConfigNames() {  
    return [  
      'specbee.adminsettings',  
    ];  
  }  
  
  /**  
   * {@inheritdoc}  
   */  
  public function getFormId() {  
    return 'specbee_form';  
  }  

  /**  
   * {@inheritdoc}  
   */  
  public function buildForm(array $form, FormStateInterface $form_state) {  
    $config = $this->config('specbee.adminsettings');

    $form['specbee_country'] = array(
        '#type' => 'textfield',
        '#title' => t('Country:'),
        '#default_value' => $config->get('specbee_country'),
        '#required' => TRUE,
    );
    $form['specbee_city'] = array(
        '#type' => 'textfield',
        '#title' => t('City:'),
        '#default_value' => $config->get('specbee_city'),
        '#required' => TRUE,
    );
    $form['specbee_timezone'] = array (
        '#type' => 'select',
        '#title' => ('Time zone'),
        '#default_value' => $config->get('specbee_timezone'),
        '#options' => array(
          'America/Chicago' => t('America/Chicago'),
          'America/New_York' => t('America/New_York'),
          'Asia/Tokyo' => t('Asia/Tokyo'),
          'Asia/Dubai' => t('Asia/Dubai'),
          'Asia/Kolkata' => t('Asia/Kolkata'),
          'Europe/Amsterdam' => t('Europe/Amsterdam'),
          'Europe/Oslo' => t('Europe/Oslo'),
          'Europe/London' => t('Europe/London'),
        ),
    );
  
    return parent::buildForm($form, $form_state);  
  }  


  /**  
   * {@inheritdoc}  
   */  
  public function submitForm(array &$form, FormStateInterface $form_state) {  
    parent::submitForm($form, $form_state);  
    $this->config('specbee.adminsettings')  
      ->set('specbee_country', $form_state->getValue('specbee_country'))
      ->set('specbee_city', $form_state->getValue('specbee_city'))
      ->set('specbee_timezone', $form_state->getValue('specbee_timezone'))  
      ->save();  
  } 

}  