<?php
namespace AMP\Db;

use AMP\Exception\ContentPage\AddContentToDatabaseFailedException;
use AMP\Exception\ContentPage\DeletingContentFailedException;
use AMP\Exception\ContentPage\GetAllPageContentFailedException;
use AMP\Exception\ContentPage\GetContentFailedException;
use AMP\Exception\ContentPage\UpdateContentFailedException;

class NewsContentDAO
{
    private $db;

    public function __construct(\Doctrine\DBAL\Connection $db)
    {
        $this->db = $db;
    }

    public function add(array $data)
    {
        try {
            $sql = 'INSERT INTO stories (content, date)
                    VALUES (:content, now())';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':content', $data['content']);
            $stmt->execute();
        } catch (\Exception $e) {
            throw new AddContentToDatabaseFailedException($e->getMessage());
        }
    }

    public function get($id)
    {
        try {
            $sql = 'SELECT * FROM stories WHERE id = :id';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(0);
        } catch (\Exception $e) {
            throw new GetContentFailedException($e->getMessage());
        }
    }

    public function getAll()
    {
        try {
            $sql = 'SELECT * FROM stories';
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\Exception $e) {
            throw new GetAllPageContentFailedException($e->getMessage());
        }
    }

    public function update($id, array $data)
    {
        try {
            $sql = 'UPDATE stories
                    SET content = :content,
                    date = now()
                    WHERE id = :id';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':content', $data['content']);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (\Exception $e) {
            throw new UpdateContentFailedException($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $sql = 'DELETE from stories WHERE id=:id';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (\Exception $e) {
            throw new DeletingContentFailedException($e->getMessage());
        }
    }
}
