<?php

namespace Drupal\ns_addthis\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class NsAddThisForm.
 */
class AddThisForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'addthis.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'addthis_settings';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('ns_addthis.settings');

    // Get all Content Types.
    $types = \Drupal::entityTypeManager()
      ->getStorage('node_type')
      ->loadMultiple();

    $content_types = [];
    foreach($types as $type) {
      $content_types[$type->id()] = $type->label();
    }

    $form['add_by_content_type'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Add by Content Type'),
      '#description' => $this->t('AddThis is added to these Content Types'),
      '#options' => $content_types,
      '#default_value' => !empty($config->get('add_by_content_type')) ? $config->get('add_by_content_type') : [],
    ];

    $form['add_by_url'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Add to These Pages'),
      '#description' => $this->t('Add to pages via URL when content type is not enabled. Add pages using new line.'),
      '#default_value' => !empty($config->get('add_by_url')) ? $config->get('add_by_url') : '',
      '#rows' => 10,
    ];


    $form['excluded_urls'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Pages to exclude (AddThis will not be added regardless of other settings if URL is present here.)'),
      '#description' => $this->t('Set what pages are explicitly excluded from AddThis.'),
      '#default_value' => !empty($config->get('excluded_urls')) ? $config->get('excluded_urls') : '',
      '#rows' => 10,
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $this->config('ns_addthis.settings')
      ->set('add_by_url', $form_state->getValue('add_by_url'))
      ->set('add_by_content_type', $form_state->getValue('add_by_content_type'))
      ->set('excluded_urls', $form_state->getValue('excluded_urls'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
