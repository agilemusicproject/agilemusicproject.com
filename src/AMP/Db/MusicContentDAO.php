<?php
namespace AMP\Db;

use \AMP\Exception\DbException;

class MusicContentDAO extends AbstractDAO
{
    public function getTableName()
    {
        return 'songs';
    }

    public function add(array $data)
    {
        try {
            $sql = 'SELECT MAX(song_order) FROM ' . $this->getTableName();
            $stmt = $this->getDb()->prepare($sql);
            $stmt->execute();
            $maxSortOrder = $stmt->fetch(\PDO::FETCH_BOTH)[0];
            if (is_null($maxSortOrder)) {
                $maxSortOrder = 0;
            } else {
                $maxSortOrder += 1;
            }
            $sql = 'INSERT INTO ' . $this->getTableName() . ' (embed, song_order)
                    VALUES (:embed, :order)';
            $stmt = $this->getDb()->prepare($sql);
            $stmt->bindParam(':embed', $data['embed']);
            $stmt->bindParam(':order', $maxSortOrder);
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
            $sql = 'SELECT * FROM ' . $this->getTableName() . ' Order By song_order';
            $stmt = $this->getDb()->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            throw new DbException($e->getMessage());
        }
    }

    public function sortUpdate($data)
    {
        $dataArray = array();
        $data = parse_str($data, $dataArray);
        $this->disableUniqueFromSongOrder();
        try {
            $sql = 'UPDATE ' . $this->getTableName() . ' SET song_order = CASE id ';
            for ($i = 0; $i < count($dataArray['music']); ++$i) {
                $sql .= 'WHEN ' . $dataArray['music'][$i] .' THEN ' . $i . ' ';
            }
            $sql .= 'END';
            $stmt = $this->getDb()->prepare($sql);
            $stmt->execute();
        } catch (\PDOException $e) {
            throw new DbException($e->getMessage());
        }
        $this->enableUniqueForSongOrder();
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

    public function disableUniqueFromSongOrder()
    {
        try {
            $sql = 'ALTER TABLE ' . $this->getTableName() . ' DROP INDEX song_order';
            $stmt = $this->getDb()->prepare($sql);
            $stmt->execute();
        } catch (\PDOException $e) {
            throw new DbException($e->getMessage());
        }
    }

    public function enableUniqueForSongOrder()
    {
        try {
            $sql = 'ALTER TABLE ' . $this->getTableName() . ' ADD UNIQUE(song_order)';
            $stmt = $this->getDb()->prepare($sql);
            $stmt->execute();
        } catch (\PDOException $e) {
            throw new DbException($e->getMessage());
        }
    }
}
