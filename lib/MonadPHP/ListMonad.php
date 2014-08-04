<?php

namespace MonadPHP;

use InvalidArgumentException;
use Traversable;

class ListMonad extends Monad {

    public function __construct($value) {
        if (!is_array($value) && !$value instanceof Traversable) {
            throw new InvalidArgumentException('Must be traversable');
        }
        return parent::__construct($value);
    }

    public function bind($function, array $args = array()) {
        $result = array();
        foreach ($this->value as $value) {
            $result[] = $this->runCallback($function, $value, $args);
        }
        return static::unit($result);
    }

    public function extract() {
        return array_map([get_called_class(), 'extractValue'], $this->value);
    }

}
