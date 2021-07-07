<?php

namespace Suite\Suite\Exceptions;

use Exception;

class CustomException extends Exception
{
    private array $_data;

    /**
     * EuroMessageException constructor.
     * @param String $message
     * @param  $data
     */
    public function __construct(string $message, $data)
    {
        $this->_data = $data;
        parent::__construct($message);
    }

    public function getData(): array
    {
        return $this->_data;
    }
}

