<?php

namespace MonadPHP;

abstract class Monad {

    protected $value;

    public function __construct($value) {
        $this->value = $value;
    }

    public static function unit($value) {
        return $value instanceof static
            ? $value
            : new static($value);
    }

    public function bind($function, array $args = array()) {
        return static::unit($this->runCallback($function, $this->value, $args));
    }

    public function extract() {
        return static::extractValue($this->value);
    }

    public static function extractValue($value) {
        return $value instanceof self
            ? $value->extract()
            : $value;
    }

    protected function runCallback($function, $value, array $args = array()) {
        if ($value instanceof self) {
            return $value->bind($function, $args);
        }
        array_unshift($args, $value);
        return call_user_func_array($function, $args);
    }

}
