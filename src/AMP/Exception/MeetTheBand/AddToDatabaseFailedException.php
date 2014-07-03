<?php
namespace AMP\Exception\MeetTheBand;

class AddToDatabaseFailedException extends \PDOException implements \AMP\Exception\ExceptionInterface
{
    use \AMP\Exception\ExceptionTrait;
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        $this->userMessage = 'We had trouble sending your infomation. Please try again.';
        parent::__construct($message, $code, $previous);
    }
}
