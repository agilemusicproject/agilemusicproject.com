<?php
namespace AMP\Exception;

class DbException extends \PDOException implements ExceptionInterface
{
    use ExceptionTrait;
}
