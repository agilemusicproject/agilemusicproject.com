<?php
namespace AMP\Db;

use AMP\Exception\AccountPage\UpdateUserPasswordFailedException;
use AMP\Exception\AccountPage\GetUserPasswordFailedException;

class AccountManagerDAO
{
    private $db;

    public function __construct(\Doctrine\DBAL\Connection $db)
    {
        $this->db = $db;
    }

    public function getCurrentPassword($username)
    {
        try {
            $sql = 'SELECT password FROM users WHERE username = :name';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':name', $username);
            $stmt->execute();
            $currentPassword = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $currentPassword['password'];
        } catch (\Exception $e) {
            throw new GetUserPasswordFailedException($e->getMessage());
        }
    }

    public function updateBandMemberPassword(array $data)
    {
        try {
            $sql = 'UPDATE users
                        SET password = :hash
                        WHERE username = :name';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':hash', $data['newPassword']);
            $stmt->bindParam(':name', $data['username']);
            $stmt->execute();
        } catch (\Exception $e) {
            throw new UpdateUserPasswordFailedException($e->getMessage());
        }
    }
}
