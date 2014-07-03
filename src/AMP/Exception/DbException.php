<?php
namespace AMP\Exception;


// DO WE EVEN NEED THESE!?!?! FOOD FOR THOUGHT ON MONDAY!!
// for user friendly messages yes

class DbException extends \PDOException implements \AMP\Exception\ExceptionInterface
{
    use \AMP\Exception\ExceptionTrait;
    public function __construct($message, $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
