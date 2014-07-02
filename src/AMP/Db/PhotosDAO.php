<?php
namespace AMP\Db;

use AMP\UploadManager;
use AMP\Exception\AddToDatabaseFailedException;
use AMP\Exception\GetUserFailedException;
use AMP\Exception\GetAllUsersFailedException;
use AMP\Exception\UpdateUserFailedException;
use AMP\Exception\DeletingUserFailedException;

class PhotosDAO
{
    private $db;

    public function __construct(\Doctrine\DBAL\Connection $db)
    {
        $this->db = $db;
    }

    public function add(array $data)
    {
        $uploadManager = new UploadManager(__DIR__ . '/../../../web/images/photos');
        $filename = $uploadManager->upload($data['photo']);
        try {
            $sql = 'INSERT INTO photos (filename, caption, category)
                    VALUES (:filename, :caption, :category)';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':filename', $filename);
            $stmt->bindParam(':caption', $data['caption']);
            $stmt->bindParam(':category', $data['category']);
            $stmt->execute();
        } catch (\PDOException $e) {
            throw new AddToDatabaseFailedException($e->getMessage());
        }
    }
    
    public function get($id)
    {
        try {
            $sql = 'SELECT * FROM photos WHERE id = :id';
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
            $sql = 'SELECT * FROM photos';
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
            $sql = 'UPDATE photos
                    SET caption = :caption,
                        category = :category
                    WHERE id = :id';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':caption', $data['caption']);
            $stmt->bindParam(':category', $data['category']);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (\PDOException $e) {
            throw new UpdateUserFailedException($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $original_data = $this->get($id);
            $original_filename = $original_data['filename'];
            $uploadManager = new UploadManager(__DIR__ . '/../../../web/images/photos');
            if (!is_null($original_filename)) {
                $uploadManager->delete($original_filename);
                $uploadManager->deleteThumb($original_filename);
            }
            $sql = 'DELETE from photos WHERE id=:id';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (\PDOException $e) {
            throw new DeletingUserFailedException($e->getMessage());
        }
    }
}
