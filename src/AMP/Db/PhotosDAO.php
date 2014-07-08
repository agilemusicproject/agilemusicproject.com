<?php
namespace AMP\Db;

use \AMP\UploadManager;
use \AMP\Exception\DbException;

class PhotosDAO
{
    private $db;
    private $tableName = 'photos';

    public function __construct(\Doctrine\DBAL\Connection $db)
    {
        $this->db = $db;
    }

    public function add(array $data)
    {
        $filename = $data['photo']->getClientOriginalName();
        try {
            $sql = 'INSERT INTO ' . $this->tableName . ' (filename, caption, category)
                    VALUES (:filename, :caption, :category)';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':filename', $filename);
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
            $sql = 'SELECT * FROM ' . $this->tableName . ' WHERE id = :id';
            $stmt = $this->db->prepare($sql);
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
            $sql = 'SELECT * FROM ' . $this->tableName;
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            throw new DbException($e->getMessage());
        }
    }
    
    public function getCategories()
    {
        try {
            $sql = 'SELECT DISTINCT category FROM ' . $this->tableName;
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            throw new DbException($e->getMessage());
        }
    }
    
    public function update($id, array $data)
    {
        try {
            $sql = 'UPDATE ' . $this->tableName . '
                    SET caption = :caption,
                        category = :category
                    WHERE id = :id';
            $stmt = $this->db->prepare($sql);
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
            $sql = 'DELETE from ' . $this->tableName . ' WHERE id=:id';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (\PDOException $e) {
            throw new DbException($e->getMessage());
        }
    }
}
