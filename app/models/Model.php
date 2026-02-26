<?php
namespace app\models;
use app\config\Database;

class Model {
    protected $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
}