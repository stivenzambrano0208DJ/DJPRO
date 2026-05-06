<?php
namespace Core;

/**
 * Base Model
 * Provides access to the database
 */
class Model {
    protected $db;

    public function __construct() {
        $this->db = new \Database();
    }
}
