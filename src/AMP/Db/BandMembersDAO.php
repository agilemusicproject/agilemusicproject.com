<?php
namespace AMP\Db;
use AMP\UploadManager;

class BandMembersDAO
{
    private $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    public function add(array $data)
    {
        $uploadManager = new UploadManager(__DIR__ . '/../../../web/images/photos');
        $filename = $uploadManager->upload($data['photo']);
        try {
            // check what the catch does by throwing the exception here
            // then try to handle in a more user friendly way
            $sql = 'INSERT INTO band_members (first_name, last_name, roles, photo_filename, bio)
                    VALUES (:first_name, :last_name, :roles, :photo_filename, :bio)';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':first_name', $data['first_name']);
            $stmt->bindParam(':last_name', $data['last_name']);
            $stmt->bindParam(':roles', $data['roles']);
            $stmt->bindParam(':photo_filename', $filename);
            $stmt->bindParam(':bio', $data['bio']);
            $stmt->execute();
        } catch (\PDOException $e) {
            print 'Error!: ' . $e->getMessage() . '<br/>';
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
        } catch (POException $e) {
            print 'Error!: ' . $e->getMessage() . '<br/>';
            die();
        }
    }

    public function getAll()
    {
        try {
            $sql = 'SELECT * FROM band_members';
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            print 'Error!: ' . $e->getMessage() . '<br/>';
            die();
        }
    }

    public function update($id, array $data)
    {
        // $form->getData()['photo_actions'] == 'photo_delete' | 'photo_change' | 'photo_nothing'
        // if delete remove photo from upload and update database with NULL
        // if change, remove old photo, upload new, and update database with new name
        // if do nothing, then current implementation is fine
        $original_filename = $this->get($id)['photo_filename'];
        $filename = null;
        $uploadManager = new UploadManager(__DIR__ . '/../../../web/images/photos');
        if ($form->getData()['photo_actions'] == 'photo_delete') {
            $data['photo'] = null;
            $uploadManager->delete($original_filename);
        }
        elseif ($form->getData()['photo_actions'] == 'photo_change') {
            $uploadManager->delete($original_filename);
            $filename = $uploadManager->upload($data['photo']);
        }
        elseif (($form->getData()['photo_actions'] == 'photo_nothing')) {
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

        } catch (PDOException $e) {
            print 'Error!: ' . $e->getMessage() . '<br/>';
            die();
        }
    }

    public function delete($id)
    {
        try {
            $sql = 'DELETE from band_members WHERE id=:id';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (PDOException $e) {
            print 'Error!: ' . $e->getMessage() . '<br/>';
            die();
        }
    }
}
