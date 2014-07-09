<?php
namespace AMP\Db;

use \AMP\Exception\DbException;

class NewsContentDAO extends AbstractDAO
{
    public function getTableName()
    {
        return 'stories';
    }

    public function __construct(\Doctrine\DBAL\Connection $db)
    {
        $this->db = $db;
    }

    public function add(array $data)
    {
        try {
            $sql = 'INSERT INTO ' . $this->getTableName() . ' (content, date)
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
            $sql = 'SELECT * FROM ' . $this->getTableName() . ' WHERE id = :id';
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
            $sql = 'SELECT * FROM ' . $this->getTableName() . ' ORDER BY id DESC';
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $results = $stmt->fetchAll();
            foreach ($results as &$entry) {
                $date = date_create($entry['date']);
                $entry['date'] = date_format($date, 'F j, Y');
            }
            unset($entry);
            return $results;
        } catch (\Exception $e) {
            throw new GetAllPageContentFailedException($e->getMessage());
        }
    }

    public function update($id, array $data)
    {
        try {
            $sql = 'UPDATE ' . $this->getTableName() . '
                    SET content = :content
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
            $sql = 'DELETE from ' . $this->getTableName() . ' WHERE id=:id';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (\Exception $e) {
            throw new DeletingContentFailedException($e->getMessage());
        }
    }
}
