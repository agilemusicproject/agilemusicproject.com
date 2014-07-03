<?php
namespace AMP\Exception\MeetTheBand;

class GetAllUsersFailedException extends \PDOException implements \AMP\Exception\ExceptionInterface
{
    use \AMP\Exception\ExceptionTrait;
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        $this->userMessage = 'Unable to get the band member information. Please try again later.';
        parent::__construct($message, $code, $previous);
    }
}
