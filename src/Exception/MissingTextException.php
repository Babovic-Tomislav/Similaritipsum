<?php

namespace App\Exception;

class MissingTextException extends \Exception
{
    public function __construct(string $message = "You need to at least 2 texts to compare them.", int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

