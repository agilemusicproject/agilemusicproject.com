<?php
namespace AMP\Db;

use \AMP\Exception\DbException;

class AbstractDAO
{
    private $db;

    public function __construct(\Doctrine\DBAL\Connection $db)
    {
        $this->db = $db;
    }

    public function getTableName()
    {
        return $this->tableName;   
    }
}
