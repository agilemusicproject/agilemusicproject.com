<?php
namespace AMP\Db;

use \AMP\Exception\DbException;

abstract class AbstractDAO
{
    private $db;

    abstract public function getTableName();
    
    public function __construct(\Doctrine\DBAL\Connection $db)
    {
        $this->db = $db;
    }

    public function getDb()
    {
        return $this->db;
    }
    
    public function getAll()
    {
        try {
            $sql = 'SELECT * FROM ' . $this->getTableName();
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            throw new DbException($e->getMessage());
        }
    }
}
