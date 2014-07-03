<?php
namespace AMP\Db;

use AMP\UploadManager;

use AMP\Exception\MeetTheBand\AddToDatabaseFailedException;
use AMP\Exception\MeetTheBand\GetUserFailedException;
use AMP\Exception\MeetTheBand\GetAllUsersFailedException;
use AMP\Exception\MeetTheBand\UpdateUserFailedException;
use AMP\Exception\MeetTheBand\DeletingUserFailedException;

class BandMembersDAO
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
            $sql = 'INSERT INTO band_members (first_name, last_name, roles, photo_filename, bio)
                    VALUES (:first_name, :last_name, :roles, :photo_filename, :bio)';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':first_name', $data['first_name']);
            $stmt->bindParam(':last_name', $data['last_name']);
            $stmt->bindParam(':roles', $data['roles']);
            $stmt->bindParam(':photo_filename', $filename);
            $stmt->bindParam(':bio', $data['bio']);
            $stmt->execute();
        } catch (\Exception $e) {
            throw new AddToDatabaseFailedException($e->getMessage());
        }
    }

    public function get($id)
    {
        try {
            $sql = 'SELECT * FROM band_members WHERE id = :id';
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
            $sql = 'SELECT * FROM band_members';
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\Exception $e) {
            throw new GetAllUsersFailedException($e->getMessage());
        }
    }

    public function update($id, array $data)
    {
        $original_data = $this->get($id);
        $original_filename = $original_data['photo_filename'];
        $filename = null;
        $uploadManager = new UploadManager(__DIR__ . '/../../../web/images/photos');
        if ($data['photo_actions'] == 'photo_delete') {
            $data['photo'] = null;
            $uploadManager->delete($original_filename);
        } elseif ($data['photo_actions'] == 'photo_change') {
            if (!is_null($original_filename)) {
                $uploadManager->delete($original_filename);
            }
            $filename = $uploadManager->upload($data['photo']);
        } elseif ($data['photo_actions'] == 'photo_nothing') {
            $data['photo'] = null;
            $filename = $original_filename;
        }
        try {
            $sql = 'UPDATE band_members
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
            throw new UpdateUserFailedException($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $sql = 'DELETE from band_members WHERE id=:id';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (\Exception $e) {
            throw new DeletingUserFailedException($e->getMessage());
        }
    }
}
