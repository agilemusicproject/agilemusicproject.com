<?php
namespace AMP\Db;

use \AMP\Exception\DbException;

class AccountManagerDAO extends AbstractDAO
{   
    public function getTableName()
    {
        return 'users';   
    }

    public function getCurrentPassword($username)
    {
        try {
            $sql = 'SELECT password FROM ' . $this->getTableName() . ' WHERE username = :name';
            $stmt = $this->getDb()->prepare($sql);
            $stmt->bindParam(':name', $username);
            $stmt->execute();
            $currentPassword = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $currentPassword['password'];
        } catch (\PDOException $e) {
            throw new DbException($e->getMessage());
        }
    }

    public function updateBandMemberPassword(array $data)
    {
        try {
            $sql = 'UPDATE ' . $this->getTableName() . '
                        SET password = :hash
                        WHERE username = :name';
            $stmt = $this->getDb()->prepare($sql);
            $stmt->bindParam(':hash', $data['newPassword']);
            $stmt->bindParam(':name', $data['username']);
            $stmt->execute();
        } catch (\PDOException $e) {
            throw new DbException($e->getMessage());
        }
    }
}
