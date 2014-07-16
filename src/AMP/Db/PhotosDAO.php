<?php
namespace AMP\Db;

use \AMP\Exception\DbException;

class PhotosDAO extends AbstractDAO
{
    public function getTableName()
    {
        return 'photos';
    }

    public function add(array $data)
    {
        try {
            $sql = 'INSERT INTO ' . $this->getTableName() . ' (filename, caption, category)
                    VALUES (:filename, :caption, :category)';
            $stmt = $this->getDb()->prepare($sql);
            $stmt->bindParam(':filename', $data['filename']);
            $stmt->bindParam(':caption', $data['caption']);
            $stmt->bindParam(':category', $data['category']);
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

    public function getAll()
    {
        try {
            $sql = 'SELECT * FROM ' . $this->getTableName();
            $stmt = $this->getDb()->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            throw new DbException($e->getMessage());
        }
    }

    public function getCategories()
    {
        try {
            $sql = 'SELECT DISTINCT category FROM ' . $this->getTableName();
            $stmt = $this->getDb()->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            throw new DbException($e->getMessage());
        }
    }

    public function update($id, array $data)
    {
        try {
            $sql = 'UPDATE ' . $this->getTableName() . '
                    SET caption = :caption,
                        category = :category
                    WHERE id = :id';
            $stmt = $this->getDb()->prepare($sql);
            $stmt->bindParam(':caption', $data['caption']);
            $stmt->bindParam(':category', $data['category']);
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
