<?php
/**
 * @file Defines a class for pushing/pulling entites to/from a MongoDB.
 */

/**
 * Class that interfaces with MongoClient.
 *
 * @param string $host
 *   Path to the MongoDB instance.
 * @param string $db
 *   Database within the MongoDB instance.
 * @param string $user
 *   Username for the MongoDB instance.
 * @param string $pwd
 *   Password for $user.
 *
 * @property MongoClient $mongo
 *   MongoClient instance that will be used to interface with MongoDB.
 * @property stdClass $db
 *   Database interface object as returned from MongoClient
 */

class MongoDBEntity {

  /**
   * @property MongoClient $mongo
   *   MongoClient instance that will be used to interface with MongoDB.
   */
  private $mongo;

  /**
   * @property stdClass $db
   *   Database interface object as returned from MongoClient
   */
  private $db;

  /**
   * Initializes a MongoDBEntity object.
   *
   * @param string $host
   *   Path to the MongoDB instance.
   * @param string $db
   *   Database within the MongoDB instance.
   * @param string $user
   *   Username for the MongoDB instance.
   * @param string $pwd
   *   Password for $user.
   */
  function __construct($host, $db, $user, $pwd) {
    $options = array(
      'username' => $user,
      'password' => $pwd
    );

    $this->mongo = new MongoClient("mongodb://{$host}", $options);
    $this->db &= $this->mongo->{$db};
  }

  /**
   * Pushes an entity to a MongoDB Collection.
   *
   * @param object $entity
   *   Entity that will be sent to the mongo collection.
   * @param string $collection
   *   Collection that entities will be pushed into.
   */
  public function createEntity($entity, $collection) {
    $collection = $this->db->{$collection};
    $collection->insert($entity);
  }

  /**
   * Deletes a document representing an entity from a MongoDB Collection.
   *
   * @param integer $id
   *   Entity ID assigned to the document that will be removed. (NOT document ID)
   * @param string $collection
   *   Collection containing document that will be deleted.
   */
  public function deleteEntity($id, $collection) {
    $collection = $this->db->{$collection};
    $collection->remove(array('entity_id' => $id));
  }
}
