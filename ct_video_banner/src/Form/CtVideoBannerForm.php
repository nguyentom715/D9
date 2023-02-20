<?php

namespace Drupal\ct_video_banner\Form;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure example settings for this site.
 */
class CtVideoBannerForm extends ConfigFormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'ct_video_banner_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'ct_video_banner.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('ct_video_banner.settings');

    // Get all Content Types.
    $types = \Drupal::entityTypeManager()
      ->getStorage('node_type')
      ->loadMultiple();

    foreach($types as $type) {
      $content_types[$type->id()] = $type->label();
    }

    $form['video_banner_enabled_content_types'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Enabled Content Types'),
      '#description' => $this->t('Define what content types will use Video Banner Settings.'),
      '#default_value' => $config->get('video_banner_enabled_content_types'),
      '#options' => $content_types,
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Retrieve the configuration
    $this->configFactory->getEditable('ct_video_banner.settings')
      ->set('video_banner_enabled_content_types', $form_state->getValue('video_banner_enabled_content_types'))
      ->save();

    parent::submitForm($form, $form_state);
  }
}
