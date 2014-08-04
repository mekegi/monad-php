<?php

namespace MonadPHP;

class Chain extends Maybe {

    public function __set($name, $value) {
        return $this->bind(function($obj) use($name, $value) {
            $obj->$name = $value;
            return $value;
        });
    }

    public function __get($name) {
        return $this->bind(function($obj) use($name) {
            return isset($obj->$name)
                ? $obj->$name
                : null;
        });
    }

    public function __call($name, array $args = array()) {
        return $this->bind(function($obj) use ($name, $args) {
            return is_callable(array($obj, $name))
                ? call_user_func_array(array($obj, $name), $args)
                : null;
        });
    }

}