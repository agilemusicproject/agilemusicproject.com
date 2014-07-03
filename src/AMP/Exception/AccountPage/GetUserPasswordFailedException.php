<?php
namespace AMP\Exception\AccountPage;

class GetUserPasswordFailedException extends \PDOException implements \AMP\Exception\ExceptionInterface
{
    use \AMP\Exception\ExceptionTrait;
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        $this->userMessage = 'Unable to change your password. Please try again';
        parent::__construct($message, $code, $previous);
    }
}
