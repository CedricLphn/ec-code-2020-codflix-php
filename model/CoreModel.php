<?php

class CoreModel {
    protected function hydrate($data) {
        foreach($data as $key => $value) {
          $method = "set".str_replace('_', '', ucfirst($key));
          if(method_exists($this, $method)) {
            $this->$method($value);
          }
        }
    }
}