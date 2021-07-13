<?php

namespace Rockads\Suite\Exceptions;

use Exception;

class SuiteException extends Exception
{
    protected array $_data;

    protected $code;

    /**
     * SuiteException constructor.
     *
     * @param string $message
     * @param $data
     * @param $exceptionCode
     */
    public function __construct(string $message, $data, $exceptionCode)
    {
        $this->_data = $data;
        parent::__construct($message);
        if (400 <= $exceptionCode && $exceptionCode <= 600)
            $this->code = $exceptionCode;
    }

    public function getData(): array
    {
        return $this->_data;
    }
}

