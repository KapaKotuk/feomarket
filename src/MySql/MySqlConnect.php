<?php

namespace Feomarket\MySql;

use PDO;

class MySqlConnect
{
    private $pdo;

    /**
     * @return mixed
     */
    public function getPdo()
    {
        return $this->pdo;
    }

    public function __construct()
    {
        $this->pdo = $this->mysqlConnect();
    }

    private function mysqlConnect() {

       require_once __DIR__ . '/../../config/mysql.php';

        $dsn = "mysql:host=$host;dbname=$db_name;charset=$charset";
        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $pdo = new PDO($dsn, $user_name, $user_password, $opt);

        return $pdo;
    }
}
