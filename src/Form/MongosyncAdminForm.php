<?php

/**
 * @file
 * Contains \Drupal\mongosync\Form\MongosyncAdminForm.
 */

namespace Drupal\mongosync\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element;

class MongosyncAdminForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'mongosync_admin_form';
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('mongosync.settings');

    foreach (Element::children($form) as $variable) {
      $config->set($variable, $form_state->getValue($form[$variable]['#parents']));
    }
    $config->save();

    if (method_exists($this, '_submitForm')) {
      $this->_submitForm($form, $form_state);
    }

    parent::submitForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['mongosync.settings'];
  }

  public function buildForm(array $form, \Drupal\Core\Form\FormStateInterface $form_state) {

    // MongoDB Server Settings Form.
    $form['mongosync_server'] = [
      '#type' => 'fieldset',
      '#title' => t('MongoDB Server'),
      '#collapsible' => TRUE,
      '#collapsed' => TRUE,
      '#description' => t('Server settings for the MongoDB instance that this module will sync entities to.'),
    ];
    $form['mongosync_server']['mongosync_host'] = [
      '#type' => 'textfield',
      '#title' => t('Host'),
      '#default_value' => \Drupal::config('mongosync.settings')->get('mongosync_host'),
      '#description' => t('Server url for your MongoDB instance. Do not include "mongodb://". (Example: localhost:3002).'),
    ];
    $form['mongosync_server']['mongosync_db'] = [
      '#type' => 'textfield',
      '#title' => t('Database'),
      '#default_value' => \Drupal::config('mongosync.settings')->get('mongosync_db'),
      '#description' => t('MongoDB database that this module will push entities to.'),
    ];
    $form['mongosync_server']['mongosync_user'] = [
      '#type' => 'textfield',
      '#title' => t('User'),
      '#default_value' => \Drupal::config('mongosync.settings')->get('mongosync_user'),
      '#description' => t('Username that should be used when connecting to MongoDB. Leave empty for anonymous.'),
    ];
    $form['mongosync_server']['mongosync_pwd'] = [
      '#type' => 'textfield',
      '#title' => t('Password'),
      '#default_value' => \Drupal::config('mongosync.settings')->get('mongosync_pwd'),
      '#description' => t('Password that should be used when connecting to MongoDB. Leave empty for anonymous.'),
    ];

    // Entity/bundle sync settings form.
    $form['mongosync_entities'] = [
      '#type' => 'fieldset',
      '#title' => t('Entity Sync Settings'),
      '#collapsible' => TRUE,
      '#collapsed' => FALSE,
    ];

    // Loop through entities/bundles and add form elements.
    foreach(\Drupal::entityManager()->getAllBundleInfo() as $entity_name => $entity) {
      $entity_settings = & $form['mongosync_entities']['mongosync_entity_' . $entity_name];
      $entity_settings = [
        '#type' => 'fieldset',
        '#title' => t('@entity settings', [
          '@entity' => $entity_name,
        ]),
        '#collapsible' => TRUE,
        '#collapsed' => TRUE,
      ];
      foreach ($entity as $bundle_name => $bundle) {
        // Labels that can be passed into t().
        $labels = [
          '@entity' => $entity_name,
          '@bundle' => $bundle_name,
        ];
        // Create settings form fieldset
        $bundle_settings = & $form['mongosync_entities']['mongosync_entity_' . $entity_name]['mongosync_entity_' . $entity_name . '_bundle_' . $bundle_name];
        $bundle_settings = [
          '#type' => 'fieldset',
          '#title' => t('@entity of Type @bundle Sync Settings', $labels),
          '#collapsible' => TRUE,
          '#collapsed' => TRUE,
        ];
        $bundle_settings['mongosync_entity_' . $entity_name . '_bundle_' . $bundle_name . '_sync'] = array(
          '#type' => 'checkbox',
          '#title' => t('Sync @entitys of type @bundle?', $labels),
          '#default_value' => \Drupal::config('mongosync.settings')->get('mongosync_entity_' . $entity_name . '_bundle_' . $bundle_name . '_sync'),
        );
        $bundle_settings['mongosync_entity_' . $entity_name . '_bundle_' . $bundle_name . '_collection'] = array(
          '#type' => 'textfield',
          '#title' => t('Collection Name'),
          '#default_value' => \Drupal::config('mongosync.settings')->get('mongosync_entity_'.$entity_name.'_bundle_'.$bundle_name.'_collection'),
          '#description' => t('If syncing is turned on for @entitys of type @bundle, it will be synced to a MongoDB collection with this name. (Example: node)', $labels),
        );
      }
    }
    return parent::buildForm($form, $form_state);
  }

}
