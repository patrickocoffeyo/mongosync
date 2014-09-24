<?php
/**
 * @file defines an administration page for mongosync.
 */

/**
 * Menu callback for admin/config/mongosync.
 *
 * @see hook_form()
 */
function mongosync_admin_form($form, &$form_state) {

  // MongoDB Server Settings Form.
  $form['mongosync_server'] = array(
    '#type' => 'fieldset',
    '#title' => t('MongoDB Server'),
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
    '#description' => t('Server settings for the MongoDB instance that this module will sync entities to.'),
  );
  $form['mongosync_server']['mongosync_host'] = array(
    '#type' => 'textfield',
    '#title' => t('Host'),
    '#default_value' => variable_get('mongosync_host'),
    '#description' => t('Server url for your MongoDB instance. Do not include "mongodb://". (Example: localhost:3002).'),
  );
  $form['mongosync_server']['mongosync_db'] = array(
    '#type' => 'textfield',
    '#title' => t('Database'),
    '#default_value' => variable_get('mongosync_db', 'drupal'),
    '#description' => t('MongoDB database that this module will push entities to.'),
  );
  $form['mongosync_server']['mongosync_user'] = array(
    '#type' => 'textfield',
    '#title' => t('User'),
    '#default_value' => variable_get('mongosync_user'),
    '#description' => t('Username that should be used when connecting to MongoDB. Leave empty for anonymous.'),
  );
  $form['mongosync_server']['mongosync_pwd'] = array(
    '#type' => 'textfield',
    '#title' => t('Password'),
    '#default_value' => variable_get('mongosync_pwd'),
    '#description' => t('Password that should be used when connecting to MongoDB. Leave empty for anonymous.'),
  );

  // Entity/bundle sync settings form.
  $form['mongosync_entities'] = array(
    '#type' => 'fieldset',
    '#title' => t('Entity Sync Settings'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );

  // Loop through entities/bundles and add form elements.
  foreach (entity_get_info() as $entity_name => $entity) {
    $entity_settings =& $form['mongosync_entities']['mongosync_entity_'.$entity_name];
    $entity_settings = array(
      '#type' => 'fieldset',
      '#title' => t('@entity Sync Settings', array('@entity' => $entity['label'])),
      '#collapsible' => TRUE,
      '#collapsed' => TRUE,
    );
    foreach ($entity['bundles'] as $bundle_name => $bundle) {
      // Labels that can be passed into t().
      $labels = array(
        '@entity' => isset($entity['label']) ? $entity['label'] : $entity_name,
        '@bundle' => isset($bundle['label']) ? $bundle['label'] : $bundle_name,
      );
      // Create settings form fieldset
      $bundle_settings =& $form['mongosync_entities']['mongosync_entity_'.$entity_name]['mongosync_entity_'.$entity_name.'_bundle_'.$bundle_name];
      $bundle_settings = array(
        '#type' => 'fieldset',
        '#title' => t('@entity of Type @bundle Sync Settings', $labels),
        '#collapsible' => TRUE,
        '#collapsed' => TRUE,
      );
      $bundle_settings['mongosync_entity_'.$entity_name.'_bundle_'.$bundle_name.'_sync'] = array(
        '#type' => 'checkbox',
        '#title' => t('Sync @entitys of type @bundle?', $labels),
        '#default_value' => variable_get('mongosync_entity_'.$entity_name.'_bundle_'.$bundle_name.'_sync'),
      );
      $bundle_settings['mongosync_entity_'.$entity_name.'_bundle_'.$bundle_name.'_collection'] = array(
        '#type' => 'textfield',
        '#title' => t('Collection Name'),
        '#default_value' => variable_get('mongosync_entity_'.$entity_name.'_bundle_'.$bundle_name.'_collection'),
        '#description' => t('If syncing is turned on for @entitys of type @bundle, it will be synced to a MongoDB collection with this name. (Example: node)', $labels),
      );
    }
  }
  return system_settings_form($form);
}
