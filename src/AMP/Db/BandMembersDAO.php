<?php
namespace AMP\Db;

class BandMembersDAO
{
    private $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    public function add(array $data)
    {
        $filename = null;
        if (!is_null($data['photo'])) {
            $image = $data['photo'];
            $filename =  $image->getClientOriginalName();
            $image->move($app['upload_folder'], $filename);
        }
        try {
            $sql = "INSERT INTO band_members (first_name, last_name, roles, photo_filename, bio)
                    VALUES (:first_name, :last_name, :roles, :filename, :bio)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':first_name', $data['first_name']);
            $stmt->bindParam(':last_name', $data['last_name']);
            $stmt->bindParam(':roles', $data['roles']);
            $stmt->bindParam(':filename', $filename);
            $stmt->bindParam(':bio', $data['bio']);
            $stmt->execute();
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function getAll()
    {
        try {
            $sql = "SELECT * FROM band_members";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
}
