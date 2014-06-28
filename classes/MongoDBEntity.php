<?php
/**
 * @file
 *
 * Defines a class for pushing/pulling entites to/from a MongoDB
 * @param (string) $host path to the MongoDB instance we should use
 * @param (string) $user username for the MongoDB instance we should use
 * @param (string) $pwd password for the MongoDB instance we should use
 *
 * @property
 */

class MongoDBEntity {
  private $mongo; // MongoClient

  /**
   * Initializes a MongoDBEntity object.
   */
  function __construct($host, $user,$pwd) {
    $this->mongo = new MongoClient("mongodb://{$host}", array('username' => $user, 'password' => $pwd));
  }
}
