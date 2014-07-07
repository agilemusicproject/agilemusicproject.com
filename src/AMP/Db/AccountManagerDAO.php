<?php
namespace AMP\Db;

use \AMP\Exception\DbException;

class AccountManagerDAO extends AbstractDAO
{
    private $db;
    private $tableName = 'users';

    public function __construct(\Doctrine\DBAL\Connection $db)
    {
        $this->db = $db;
    }

    public function getCurrentPassword($username)
    {
        try {
            $sql = 'SELECT password FROM ' . $this->tableName . ' WHERE username = :name';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':name', $username);
            $stmt->execute();
            $currentPassword = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $currentPassword['password'];
        } catch (\Exception $e) {
            throw new DbException($e->getMessage());
        }
    }

    public function updateBandMemberPassword(array $data)
    {
        try {
            $sql = 'UPDATE ' . $this->tableName . '
                        SET password = :hash
                        WHERE username = :name';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':hash', $data['newPassword']);
            $stmt->bindParam(':name', $data['username']);
            $stmt->execute();
        } catch (\Exception $e) {
            throw new DbException($e->getMessage());
        }
    }
}
