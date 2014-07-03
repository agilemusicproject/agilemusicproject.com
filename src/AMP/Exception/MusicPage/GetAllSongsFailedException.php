<?php
namespace AMP\Exception\MusicPage;

class GetAllSongsFailedException extends \PDOException implements \AMP\Exception\ExceptionInterface
{
    use \AMP\Exception\ExceptionTrait;
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        $this->userMessage = 'Unable to display our music at this moment. Please try again later. ';
        parent::__construct($message, $code, $previous);
    }
}
