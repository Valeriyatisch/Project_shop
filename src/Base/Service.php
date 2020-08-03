<?php


namespace Val\SweetsShop\Base;

use Val\SweetsShop\Base\DBConnection;

abstract class Service
{
    protected $dbConnection;

    public function __construct() {
        $this->dbConnection = DBConnection::getInstance();
    }
}