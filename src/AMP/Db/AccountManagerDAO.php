<?php
namespace AMP\Db;

class AccountManagerDAO
{
    private $db;

    public function __construct(\Doctrine\DBAL\Connection $db)
    {
        $this->db = $db;
    }

    public function updateBandMemberPassword(array $data)
    {
        try {
            $sql = 'UPDATE users
                    SET password = :hash,
                    WHERE username = :name';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':hash', $data['newPassword']);
            $stmt->bindParam(':name', $data['username']);
            $stmt->execute();
        } catch (\PDOException $e) {
        }
    }
}
