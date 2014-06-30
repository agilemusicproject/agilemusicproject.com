<?php
namespace AMP\Db;

//need to create these
use AMP\Exception\AddToDatabaseFailedException;
use AMP\Exception\GetUserFailedException;
use AMP\Exception\GetAllUsersFailedException;
use AMP\Exception\UpdateUserFailedException;
use AMP\Exception\DeletingUserFailedException;

class MusicContentDAO
{
    private $db;

    public function __construct(\Doctrine\DBAL\Connection $db)
    {
        $this->db = $db;
    }

    public function add(array $data)
    {
        try {
            $sql = 'INSERT INTO songs (embed, song_order)
                    VALUES (:embed, :order)';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':embed', $data['embed']);
            $stmt->bindParam(':order', $data['order']);
            $stmt->execute();
        } catch (\PDOException $e) {
            throw new AddToDatabaseFailedException($e->getMessage());
        }
    }

    public function get($id)
    {
        try {
            $sql = 'SELECT * FROM songs WHERE id = :id';
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
            $sql = 'SELECT * FROM songs';
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
            $sql = 'UPDATE songs
                    SET embed = :embed,
                    order = :order
                    WHERE id = :id';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':embed', $data['embed']);
            $stmt->bindParam(':order', $data['order']);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (\PDOException $e) {
            throw new UpdateUserFailedException($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $sql = 'DELETE from songs WHERE id=:id';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (\PDOException $e) {
            throw new DeletingUserFailedException($e->getMessage());
        }
    }
}
