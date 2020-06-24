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

    public static function dd($log) {
        echo "<pre>";
        var_dump($log);
        echo "</pre>";
    }

    public static function getAbsoluteUrl() {
      return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/";
    }
}