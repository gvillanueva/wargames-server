<?php

namespace Tivoka\Exception;

/**
 * Tivoka UserException
 * @package Tivoka
 */
class UserException extends Exception {
    protected $data;

    public function __construct($message = "", $code = 0, Exception $previous = null, $data = null) {
        parent::__construct($message, $code, $previous);
        $this->data = $data;
    }

    public function getData() {
        return $this->data;
    }
}
?>