<?php
namespace AMP\Exception;

class GetSongFailedException extends \PDOException implements ExceptionInterface
{
    use ExceptionTrait;
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        $this->userMessage = 'We were unable to find the song we were looking for. Please try again later ';
        parent::__construct($message, $code, $previous);
    }
}
