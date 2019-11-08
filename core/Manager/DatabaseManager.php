<?php
namespace Manager;

use Reader\ParameterReader;

class DatabaseManager
{
    /**
     * @var \PDO
     */
    private $connection;

    /**
     * @var ParameterReader
     */
    private $parameterReader;

    public function __construct()
    {
        $this->parameterReader = new ParameterReader();
        $this->createConnection();
    }

    /**
     * @return \PDO
     */
    public function getConnection()
    {
        return $this->connection;
    }

    private function createConnection()
    {
        $dsn = sprintf("%s:host=%s;dbname=%s",
            $this->parameterReader->parameters["db_type"],
            $this->parameterReader->parameters["db_host"],
            $this->parameterReader->parameters["db_name"]
        );
        $user = $this->parameterReader->parameters["db_user"];
        $passwd = $this->parameterReader->parameters["db_password"];
        $options = array(
            \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        );

        $this->connection = new \PDO($dsn, $user, $passwd, $options);
    }
}