<?php

namespace App\Exception;

class AlgorithmNotFound extends \Exception
{
    public function __construct(string $message = "Chosen algorithm not found.", int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

