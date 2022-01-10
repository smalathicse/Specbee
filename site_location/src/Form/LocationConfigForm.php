<?php

namespace Drupal\site_location\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure example settings for this site.
 */
class LocationConfigForm extends ConfigFormBase {

  /**
   * Config settings.
   *
   * @var string
   */
  const SETTINGS = 'site_location.settings';

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'location_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      static::SETTINGS,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config(static::SETTINGS);

    $form['locationinfo'] = [
      '#type' => 'details',
      '#title' => $this->t('Informations'),
      '#open' => TRUE,
    ];

    $form['locationinfo']['site_country'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Country'),
      '#maxlength' => 50,
      '#default_value' => $config->get('site_country'),
    ];

    $form['locationinfo']['site_city'] = [
      '#type' => 'textfield',
      '#title' => $this->t('City'),
      '#maxlength' => 50,
      '#default_value' => $config->get('site_city'),
    ];
    $form['locationinfo']['site_timezone'] = [
      '#title' => t('Timezone'),
      '#type' => 'select',
      '#maxlength' => 50,
      '#options' => [t('SELECT'),
        'America/Chicago' => t('America/Chicago'),
        'America/New_York' => t('America/New_York'),
        'Asia/Tokyo' => t('Asia/Tokyo'),
        'Asia/Dubai' => t('Asia/Dubai'),
        'Asia/Kolkata' => t('Asia/Kolkata'),
        'Europe/Amsterdam' => t('Europe/Amsterdam'),
        'Europe/Oslo' => t('Europe/Oslo'),
        'Europe/London' => t('Europe/London'),
      ],
      '#default_value' => $config->get('site_timezone'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Retrieve the configuration.
    $this->configFactory->getEditable(static::SETTINGS)
      ->set('site_country', $form_state->getValue('site_country'))
      ->set('site_city', $form_state->getValue('site_city'))
      ->set('site_timezone', $form_state->getValue('site_timezone'))
      ->save();

    parent::submitForm($form, $form_state);

  }

}
