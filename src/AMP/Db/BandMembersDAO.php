<?php
namespace AMP\Db;

use \AMP\Exception\DbException;

class BandMembersDAO
{
    private $db;
    private $tableName = 'band_members';

    public function __construct(\Doctrine\DBAL\Connection $db)
    {
        $this->db = $db;
    }

    public function add(array $data)
    {
        try {
            $sql = 'INSERT INTO ' . $this->tableName . ' (first_name, last_name, roles, photo_filename, bio)
                    VALUES (:first_name, :last_name, :roles, :photo_filename, :bio)';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':first_name', $data['first_name']);
            $stmt->bindParam(':last_name', $data['last_name']);
            $stmt->bindParam(':roles', $data['roles']);
            $stmt->bindParam(':photo_filename', $filename);
            $stmt->bindParam(':bio', $data['bio']);
            $stmt->execute();
        } catch (\Exception $e) {
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
                    SET first_name = :first_name,
                        last_name = :last_name,
                        roles = :roles,
                        photo_filename = :photo_filename,
                        bio = :bio
                    WHERE id = :id';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':first_name', $data['first_name']);
            $stmt->bindParam(':last_name', $data['last_name']);
            $stmt->bindParam(':roles', $data['roles']);
            $stmt->bindParam(':photo_filename', $filename);
            $stmt->bindParam(':bio', $data['bio']);
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
