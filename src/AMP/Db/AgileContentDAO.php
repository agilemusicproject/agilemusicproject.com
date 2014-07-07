<?php
namespace AMP\Db;

use \AMP\Exception\DbException;

class AgileContentDAO extends AbstractDAO
{
    private $db;
    private $tableName = 'agile_content';

    public function __construct(\Doctrine\DBAL\Connection $db)
    {
        $this->db = $db;
    }

    public function add(array $data)
    {
        try {
            $sql = 'INSERT INTO ' . $this->tableName . ' (content)
                    VALUES (:content)';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':content', $data['content']);
            $stmt->execute();
        } catch (\Exception $e) {
            throw new \AMP\Exception\DbException($e->getMessage());
        }
    }

    public function get($id)
    {
        try {
            $sql = 'SELECT * FROM ' . $this->tableName . ' WHERE id = :id';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(0);
        } catch (\Exception $e) {
            throw new DbException($e->getMessage());
        }
    }

    public function getAll()
    {
        try {
            $sql = 'SELECT * FROM ' . $this->tableName;
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\Exception $e) {
            throw new DbException($e->getMessage());
        }
    }

    public function update($id, array $data)
    {
        try {
            $sql = 'UPDATE ' . $this->tableName . '
                    SET content = :content
                    WHERE id = :id';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':content', $data['content']);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (\Exception $e) {
            throw new DbException($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $sql = 'DELETE from ' . $this->tableName . ' WHERE id=:id';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (\Exception $e) {
            throw new DbException($e->getMessage());
        }
    }
}
