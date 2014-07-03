<?php
namespace AMP\Exception\MeetTheBand;

class UpdateUserFailedException extends \PDOException implements \AMP\Exception\ExceptionInterface
{
    use \AMP\Exception\ExceptionTrait;
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        $this->userMessage = 'Unable to update your band member information. Please try again.';
        parent::__construct($message, $code, $previous);
    }
}
