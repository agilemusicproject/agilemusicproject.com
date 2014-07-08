<?php
namespace AMP\Db;

use AMP\Exception\MusicPage\AddSongToDatabaseFailedException;
use AMP\Exception\MusicPage\DeletingSongFailedException;
use AMP\Exception\MusicPage\DisableUniqueConstraintFailedException;
use AMP\Exception\MusicPage\EnableUniqueConstraintFailedException;
use AMP\Exception\MusicPage\GetAllSongsFailedException;
use AMP\Exception\MusicPage\GetSongFailedException;
use AMP\Exception\MusicPage\SortingFailedException;

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
            $sql = 'SELECT MAX(song_order) FROM songs';
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $maxSortOrder = $stmt->fetchColumn();
            if (is_null($maxSortOrder)) {
                $maxSortOrder = 0;
            } else {
                $maxSortOrder += 1;
            }
            $sql = 'INSERT INTO songs (embed, song_order)
                    VALUES (:embed, :order)';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':embed', $data['embed']);
            $stmt->bindParam(':order', $maxSortOrder);
            $stmt->execute();
        } catch (\Exception $e) {
            throw new \AMP\Exception\DbException($e->getMessage());
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
        } catch (\Exception $e) {
            throw new \AMP\Exception\DbException($e->getMessage());
        }
    }

    public function getAll()
    {
        try {
            $sql = 'SELECT * FROM songs ORDER BY song_order';
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\Exception $e) {
            throw new \AMP\Exception\DbException($e->getMessage());
        }
    }

    public function sortUpdate($data)
    {
        $dataArray = array();
        $data = parse_str($data, $dataArray);
        $this->disableUniqueFromSongOrder();
        try {
            $sql = 'UPDATE songs SET song_order = CASE id';
            for ($i = 0; $i < count($dataArray['music']); $i++) {
                $sql .= ' WHEN ' . $dataArray['music'][$i] .' THEN ' . $i;
            }
            $sql .= ' END';
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
        } catch (\Exception $e) {
            throw new \AMP\Exception\DbException($e->getMessage());
        }
        $this->enableUniqueForSongOrder();
    }

    public function delete($id)
    {
        try {
            $sql = 'DELETE from songs WHERE id=:id';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (\Exception $e) {
            throw new \AMP\Exception\DbException($e->getMessage());
        }
    }

    public function disableUniqueFromSongOrder()
    {
        try {
            $sql = 'ALTER TABLE songs DROP INDEX song_order';
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
        } catch (\Exception $e) {
            throw new \AMP\Exception\DbException($e->getMessage());
        }
    }

    public function enableUniqueForSongOrder()
    {
        try {
            $sql = 'ALTER TABLE songs ADD UNIQUE(song_order)';
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
        } catch (\Exception $e) {
            throw new \AMP\Exception\DbException($e->getMessage());
        }
    }
}
