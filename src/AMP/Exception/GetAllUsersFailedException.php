<?php
namespace AMP\Exception;

class GetAllUsersFailedException extends \PDOException implements ExceptionInterface
{
    protected $userMessage = 'Failed to get the band member information from the database.';

    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function getUserFriendlyErrorMessage()
    {
        return $this->userMessage;
    }
}
