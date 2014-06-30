<?php
namespace AMP\Db;

use AMP\Exception\AddToDatabaseFailedException;
use AMP\Exception\GetUserFailedException;
use AMP\Exception\GetAllUsersFailedException;
use AMP\Exception\UpdateUserFailedException;
use AMP\Exception\DeletingUserFailedException;

class AboutContentDAO
{
    private $db;

    public function __construct(\Doctrine\DBAL\Connection $db)
    {
        $this->db = $db;
    }

    public function add(array $data)
    {
        try {
            $sql = 'INSERT INTO about_content (content)
                    VALUES (:content)';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':content', $data['content']);
            $stmt->execute();
        } catch (\PDOException $e) {
            throw new AddToDatabaseFailedException($e->getMessage());
        }
    }

    public function get($id)
    {
        try {
            $sql = 'SELECT * FROM about_content WHERE id = :id';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(0);
        } catch (\PDOException $e) {
            throw new GetUserFailedException($e->getMessage());
        }
    }

    public function getAll()
    {
        try {
            $sql = 'SELECT * FROM about_content';
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            throw new GetAllUsersFailedException($e->getMessage());
        }
    }

    public function update($id, array $data)
    {
        try {
            $sql = 'UPDATE about_content
                    SET content = :content
                    WHERE id = :id';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':content', $data['content']);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

        } catch (\PDOException $e) {
            throw new UpdateUserFailedException($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $sql = 'DELETE from about_content WHERE id=:id';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (\PDOException $e) {
            throw new DeletingUserFailedException($e->getMessage());
        }
    }
}
