<?php
namespace AMP\Db;

use \AMP\Exception\DbException;

class AboutContentDAO extends AbstractDAO
{
    public function getTableName()
    {
        return 'about_content';
    }

    public function add(array $data)
    {
        try {
            $sql = 'INSERT INTO ' . $this->getTableName() . ' (content)
                    VALUES (:content)';
            $stmt = $this->getDb()->prepare($sql);
            $stmt->bindParam(':content', $data['content']);
            $stmt->execute();
        } catch (\PDOException $e) {
            throw new DbException($e->getMessage());
        }
    }

    public function get($id)
    {
        try {
            $sql = 'SELECT * FROM ' . $this->getTableName() . ' WHERE id = :id';
            $stmt = $this->getDb()->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(0);
        } catch (\PDOException $e) {
            throw new DbException($e->getMessage());
        }
    }

    public function update($id, array $data)
    {
        try {
            $sql = 'UPDATE ' . $this->getTableName() . '
                    SET content = :content
                    WHERE id = :id';
            $stmt = $this->getDb()->prepare($sql);
            $stmt->bindParam(':content', $data['content']);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (\PDOException $e) {
            throw new DbException($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $sql = 'DELETE from ' . $this->getTableName() . ' WHERE id=:id';
            $stmt = $this->getDb()->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (\PDOException $e) {
            throw new DbException($e->getMessage());
        }
    }
}
