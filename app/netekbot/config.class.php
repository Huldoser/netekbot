<?php

  class config {

    private static $array = null;

    // Blocking the abillity to make instances of this class
    private function __construct() {}

    public static function getDatabase($key) {
      self::init('database');
      return self::$array[$key];
    }

    public static function getFacebook($key) {
      self::init('facebook');
      return self::$array[$key];
    }

    public static function getSendGrid($key) {
      self::init('sendGrid');
      return self::$array[$key];
    }

    // Because static variable cannot accept expressions we need to init it
    private function init($arrayName) {
      if ($arrayName == 'database') {
        self::$array = array(
          'dbName' => $_ENV['DB_NAME'],
          'dbUserName' => $_ENV['DB_USER_NAME'],
          'dbPassword' => $_ENV['DB_PASSWORD'],
          'dbUrl' => $_ENV['DB_URL']
        );

      } else if ($arrayName == 'facebook') {
        self::$array = array(
          'fbAccessToken' => $_ENV['FB_ACCESS_TOKEN'],
          'fbVerificationToken' => $_ENV['FB_VERIFICATION_TOKEN'],
          'fbSendUrl' => 'https://graph.facebook.com/v2.7/me/messages?access_token='
        );

      } else if ($arrayName == 'sendGrid') {
        self::$array = array(
          'sgUserName' => $_ENV['SG_USER_NAME'],
          'sgPassword' => $_ENV['SG_PASSWORD']
        );
      }
    }
  }

?>
