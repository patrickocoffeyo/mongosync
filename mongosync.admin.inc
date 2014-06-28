<?php

/**
 * Menu callback for admin/config/mongosync
 */
function mongosync_admin_form($form, &$form_state) {

  // MongoDB Server Settings Form
  $form['mongosync_server'] = array(
    '#type' => 'fieldset',
    '#title' => t('MongoDB Server'),
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
    '#description' => t('Server settings for the MongoDB instance that this module will sync entities to')
  );
  $form['mongosync_server']['mongosync_host'] = array(
    '#type' => 'textfield',
    '#title' => t('Host'),
    '#default_value' => variable_get('mongosync_host'),
    '#description' => t('Server url for your MongoDB instance. Do not include "mongodb://". (Example: localhost)')
  );
  $form['mongosync_server']['mongosync_user'] = array(
    '#type' => 'textfield',
    '#title' => t('User'),
    '#default_value' => variable_get('mongosync_user'),
    '#description' => t('Username that should be used when connecting to MongoDB')
  );
  $form['mongosync_server']['mongosync_pwd'] = array(
    '#type' => 'textfield',
    '#title' => t('Password'),
    '#default_value' => variable_get('mongosync_password'),
    '#description' => t('Password that should be used when connecting to MongoDB')
  );

  // Entity Sync Settings Form
  $form['mongosync_entities'] = array(
    '#type' => 'fieldset',
    '#title' => t('Entity Sync Settings'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE
  );

  foreach (entity_get_info() as $entity_name => $entity) {
    $es =& $form['mongosync_entities']['mongosync_entity_'.$entity_name];
    $es = array(
      '#type' => 'fieldset',
      '#title' => t('@name Sync Settings', array('@name' => $entity_name)),
      '#collapsible' => TRUE,
      '#collapsed' => TRUE
    );
    $es['mongosync_entity_'.$entity_name.'_sync'] = array(
      '#type' => 'checkbox',
      '#title' => t('Sync @entitys?', array('@entity' => $entity_name)),
      '#default_value' => variable_get('mongosync_entity_'.$entity_name.'_sync')
    );
    $es['mongosync_entity_'.$entity_name.'_collection'] = array(
      '#type' => 'textfield',
      '#title' => t('Collection Name'),
      '#default_value' => variable_get('mongosync_entity_'.$entity_name.'_collection'),
      '#description' => t('If syncing is turned on for @entitys, it will be synced to a MongoDB collection with this name. (Example: node)', array('@entity' => $entity_name))
    );
  }
  return system_settings_form($form);

}
