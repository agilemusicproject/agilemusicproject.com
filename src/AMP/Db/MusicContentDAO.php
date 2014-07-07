<?php
namespace AMP\Db;

use \AMP\Exception\DbException;

class MusicContentDAO extends AbstractDAO
{
    private $db;
    private $tableName = 'songs';

    public function __construct(\Doctrine\DBAL\Connection $db)
    {
        $this->db = $db;
    }

    public function add(array $data)
    {
        try {
            $sql = 'SELECT MAX(song_order) FROM ' . $this->tableName;
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $maxSortOrder = $stmt->fetch(\PDO::FETCH_BOTH)[0];
            if (is_null($maxSortOrder)) {
                $maxSortOrder = 0;
            } else {
                $maxSortOrder += 1;
            }
            $sql = 'INSERT INTO ' . $this->tableName . ' (embed, song_order)
                    VALUES (:embed, :order)';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':embed', $data['embed']);
            $stmt->bindParam(':order', $maxSortOrder);
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
            $sql = 'SELECT * FROM ' . $this->tableName . ' Order By song_order';
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\Exception $e) {
            throw new DbException($e->getMessage());
        }
    }

    public function sortUpdate($data)
    {
        $dataArray = array();
        $data = parse_str($data, $dataArray);
        $this->disableUniqueFromSongOrder();
        try {
            $sql = 'UPDATE ' . $this->tableName . ' SET song_order = CASE id ';
            for ($i = 0; $i < count($dataArray['music']); ++$i) {
                $sql .= 'WHEN ' . $dataArray['music'][$i] .' THEN ' . $i . ' ';
            }
            $sql .= 'END';
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
        } catch (\Exception $e) {
            throw new DbException($e->getMessage());
        }
        $this->enableUniqueForSongOrder();
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

    public function disableUniqueFromSongOrder()
    {
        try {
            $sql = 'ALTER TABLE ' . $this->tableName . ' DROP INDEX song_order';
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
        } catch (\Exception $e) {
            throw new DbException($e->getMessage());
        }
    }

    public function enableUniqueForSongOrder()
    {
        try {
            $sql = 'ALTER TABLE ' . $this->tableName . ' ADD UNIQUE(song_order)';
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
        } catch (\Exception $e) {
            throw new DbException($e->getMessage());
        }
    }
}
