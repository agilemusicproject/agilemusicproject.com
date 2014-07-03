<?php
namespace AMP\Exception\ContentPage;

class UpdateContentFailedException extends \PDOException implements \AMP\Exception\ExceptionInterface
{
    use \AMP\Exception\ExceptionTrait;
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        $this->userMessage = 'We had trouble updating your content. Please try again.';
        parent::__construct($message, $code, $previous);
    }
}
