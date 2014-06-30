<?php
/**
 * @file
 *
 * Defines a class for pushing/pulling entites to/from a MongoDB
 * @param (string) $host path to the MongoDB instance we should use
 * @param (string) $db database we should push entities too
 * @param (string) $user username for the MongoDB instance we should use
 * @param (string) $pwd password for the MongoDB instance we should use
 *
 * @property
 */

class MongoDBEntity {
  private $mongo;  // MongoClient
  private $db;     // Database as specified in the __construct

  /**
   * Initializes a MongoDBEntity object.
   */
  function __construct($host, $db, $user, $pwd) {
    $options = array(
      'username' => $user,
      'password' => $pwd
    );

    $this->mongo = new MongoClient("mongodb://{$host}", $options);
    $this->db = $this->mongo->{$db};
  }

  /**
   * Pushes an entity to a MongoDB Collection
   * @param (object) $entity entity that we will send to the mongo collection
   * @param (string) $collection collection that we will send the entity to
   */
  public function pushEntity($entity, $collection) {
    $collection = $this->db->{$collection};
    $collection->insert($entity);
  }
}
