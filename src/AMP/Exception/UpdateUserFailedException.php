<?php
namespace AMP\Exception;

class UpdateUserFailedException extends \PDOException implements ExceptionInterface
{
    protected $userMessage = 'Failed to update your band member information';

    public function __construct($message = null, $code = 0, Exception $previous = null)
    {
        parent::__construct(message, $code, $previous);
    }

    public function getUserFriendlyErrorMessage()
    {
        return $this->userMessage;
    }
}
