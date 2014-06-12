<?php
namespace AMP\Db;

use AMP\Exception\AddToDatabaseException;

class BandMembersDAO
{
    private $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    public function add(array $data)
    {
        // pull photo stuff into own class maybe
        $filename = null;
        if (!is_null($data['photo'])) {
            $image = $data['photo'];
            $filename =  $image->getClientOriginalName();
            $image->move(__DIR__ . '/../../../web/images/photos', $filename);
        }
        try {
            throw new \PDOException();
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
            throw new AddToDatabaseException($e->getMessage());
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
        $filename = null;
        if (!is_null($data['photo'])) {
            $image = $data['photo'];
            $filename =  $image->getClientOriginalName();
            $image->move(__DIR__ . '/../../../web/images/photos', $filename);
        }
        try {
            if (is_null($data['photo'])) {
                $sql = 'SELECT photo_filename FROM band_members WHERE id = :id';
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                $filename = $stmt->fetchColumn();
            }
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
