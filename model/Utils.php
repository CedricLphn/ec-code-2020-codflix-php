<?php

class Utils {
  /**
   * Tool for debugging a variable
   *
   * @param any $log
   * @return void prettier debug log
   */
    public static function dd($log) {
        echo "<pre>";
        var_dump($log);
        echo "</pre>";
    }

    /**
     * Get absolute url
     *
     * @return string
     */
    public static function getAbsoluteUrl() {
      return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/";
    }

    /**
     * Convert a timestamp to date sql string
     *
     * @param int $timestamp
     * @return string
     */
    public static function toDateString($timestamp) {
      if(!is_numeric($timestamp))
          throw new Exception("Timestamp must be numeric");

      $date = new DateTime();
      $date->setTimestamp($timestamp);

      return $date->format("Y-m-d H:i:s");

  }


}

?>