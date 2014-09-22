<?php
/**
 * @file
 * Contains default hook implementations for mongosync.
 */

/**
 * Impliments hook_mongosync_entity_insert().
 *
 * @param stdClass $entity
 *   Entity object that is being inserted into MongoDB.
 * @param string $type
 *   Type of entity that is being inserted into MongoDB.
 * @param string $bundle
 *   Bundle of entity that is being inserted into MongoDB.
 *
 * @return stdClass
 *   Final object that will be inserted into MongoDB.
 *   Must contain entity_id propery.
 */
function mongosync_mongosync_entity_insert($entity, $type, $bundle) {
  return $entity;
}
