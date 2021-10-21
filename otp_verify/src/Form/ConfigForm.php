<?php

namespace Drupal\otp_verify\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Implement configuration form.
 *
 * @package Drupal\otp_verify\Form.
 */
class ConfigForm extends ConfigFormBase {
  const CONFIG_NAME = 'otp_verify.settings';

  /**
   * Get configuration settings.
   *
   * {@inheritdoc}
   */
  public function getEditableConfigNames() {
    return [self::CONFIG_NAME];
  }

  /**
   * Returns this modules configuration object.
   */
  protected function getConfig() {
    return $this->config(self::CONFIG_NAME);
  }

  /**
   * Get unique form id.
   *
   * (@Inheritdoc)
   */
  public function getFormId() {
    return 'otp_verify_settings_form';
  }

  /**
   * Build form structure.
   *
   * (@inheritdoc)
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->getConfig();

    $form['sender_id'] = [
      '#type' => 'key_select',
      '#title' => $this->t('Sender ID'),
      '#default_value' => $config->get('sender_id'),
      '#description' => $this->t('Your Account Sender ID.'),
      '#required' => TRUE,
      '#empty_option' => $this->t('- Select -'),
    ];

    $form['token'] = [
      '#type' => 'key_select',
      '#title' => $this->t('Your Auth Token'),
      '#default_value' => $config->get('token'),
      '#description' => $this->t('Your Auth Token.'),
      '#required' => TRUE,
      '#empty_option' => $this->t('- Select -'),
    ];

    $form['verification_message_text'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Verification Message'),
      '#default_value' => $config->get('verification_message_text'),
      '#description' => $this->t('This is a verification message will send with code.'),
      '#required' => TRUE,
      '#empty_option' => $this->t('- Select -'),
    ];

    $form['provider_number'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Provider phone number'),
      '#default_value' => $config->get('provider_number'),
      '#description' => $this->t('This is a provider phone number.'),
      '#required' => TRUE,
      '#empty_option' => $this->t('- Select -'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * Validate form values.
   *
   * (@inheritdoc)
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // Code...
  }

  /**
   * Submit form data.
   *
   * (@inheritdoc)
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $config = $this->getConfig();
    $values = $form_state->getValues();
    $config->set('sender_id', $values['sender_id']);
    $config->set('token', $values['token']);
    $config->set('provider_number', $values['provider_number']);
    $config->set('verification_message_text', $values['verification_message_text']);
    $config->save();
  }

}
