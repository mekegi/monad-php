<?php

namespace MonadPHP;

class Maybe extends Monad {

    public function bind($function) {
        return is_null($this->value)
            ? static::unit(null)
            : parent::bind($function);
    }

}
