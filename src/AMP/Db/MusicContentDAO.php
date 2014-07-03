<?php
namespace AMP\Db;

//need to create these
use AMP\Exception\AddToDatabaseFailedException;
use AMP\Exception\GetUserFailedException;
use AMP\Exception\GetAllUsersFailedException;
use AMP\Exception\UpdateUserFailedException;
use AMP\Exception\DeletingUserFailedException;
use AMP\Exception\UpdateMusicFailedException;

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
            $maxSortOrder = $stmt->fetch(\PDO::FETCH_BOTH)[0];
            if(is_null($maxSortOrder)) {
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
        } catch (\Exception $e) {
            throw new GetUserFailedException($e->getMessage());
        }
    }

    public function getAll()
    {
        try {
            $sql = 'SELECT * FROM songs Order By song_order';
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\Exception $e) {
            throw new GetAllUsersFailedException($e->getMessage());
        }
    }

    public function sortUpdate($data)
    {
        $dataArray = array();
        $data = parse_str($data, $dataArray);
        $this->disableUniqueFromSongOrder();
        $ids = implode(',', array_values($dataArray['music']));
        try {
            $sql = 'UPDATE songs SET song_order = CASE id ';
            for($i = 0; $i < count($dataArray['music']); ++$i) {
                $sql .= 'WHEN :id' . $i . ' THEN :order' . $i . ' ';
            }
            $sql .= 'END WHERE id IN ('. $ids .')';
            $stmt = $this->db->prepare($sql);
            for($j = 0; $j < count($dataArray['music']); ++$j){
                $stmt->bindParam(':id'.$j, $dataArray['music'][$j]);
                $stmt->bindParam(':order'.$j, $j);
            }
            $stmt->execute();
        } catch (\Exception $e) {
            throw new UpdateMusicFailedException($e->getMessage());
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
            throw new DeletingUserFailedException($e->getMessage());
        }
    }

    public function disableUniqueFromSongOrder() {
        try {
            $sql = 'ALTER TABLE songs DROP INDEX song_order';
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
        } catch (\Exception $e) {
            throw new UpdateMusicFailedException($e->getMessage());
        }
    }

    public function enableUniqueForSongOrder() {
        try {
            $sql = 'ALTER TABLE songs ADD UNIQUE(song_order)';
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
        } catch (\Exception $e) {
            throw new UpdateMusicFailedException($e->getMessage());
        }
    }
}
