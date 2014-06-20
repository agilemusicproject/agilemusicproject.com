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

    public function getCurrentPassword($data)
    {
         try {
            $sql = 'SELECT password FROM users WHERE username = :name';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':name', $data['username']);
            $stmt->execute();
            $currentPassword = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $currentPassword['password'];
        } catch (\PDOException $e) {
            throw new UpdateUserPasswordFailedException($e->getMessage());
        }
    }

    public function updateBandMemberPassword(array $data)
    {
        $oldPasswordCorrect = $this->oldPasswordValidation($data);
        $newPasswordsMatch = strcmp($data['newPassword'], $data['confirmPassword']);
        if( ($oldPasswordCorrect === 0) && ($newPasswordsMatch === 0) )
        {
            try {
                $sql = 'UPDATE users
                        SET password = :hash
                        WHERE username = :name';
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':hash', $data['newPassword']);
                $stmt->bindParam(':name', $data['username']);
                $stmt->execute();
                return true;
            } catch (\PDOException $e) {
                throw new UpdateUserPasswordFailedException($e->getMessage());
            }
        } else {
            throw new UpdateUserPasswordFailedException();
        }
    }
}
