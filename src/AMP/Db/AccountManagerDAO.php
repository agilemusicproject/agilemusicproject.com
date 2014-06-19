<?php
namespace AMP\Db;

use AMP\Exception\UpdateUserPasswordFailedException;

class AccountManagerDAO
{
    private $db;

    public function __construct(\Doctrine\DBAL\Connection $db)
    {
        $this->db = $db;
    }

    public function updateBandMemberPassword(array $data)
    {
        $oldPasswordCorrect = oldPasswordValidation($data);
        $newPasswordsMatch = compareNewPassword($data['newPassword'], $data['confirmPassword']);
        try {
            $sql = 'UPDATE users
                    SET password = :hash
                    WHERE username = :name';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':hash', $data['newPassword']);
            $stmt->bindParam(':name', $data['username']);
            $stmt->execute();
        } catch (\PDOException $e) {
            throw new UpdateUserPasswordFailedException($e->getMessage());
        }
    }

    public function oldPasswordValidation($data)
    {
         try {
            $sql = 'SELECT password FROM users WHERE username = :name';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':name', $data['username']);
            $stmt->execute();
            $currentPassword = $stmt->fetch(0);
            return strcmp($currentPassword, $data['oldPassword'];
        } catch (\PDOException $e) {
            throw new UpdateUserPasswordFailedException($e->getMessage());
        }
    }
}
