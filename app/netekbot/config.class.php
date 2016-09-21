<?php

  class config {

    private $database = array(
      'dbName' => $_ENV['DB_NAME'],
      'dbUserName' => $_ENV['DB_USER_NAME'],
      'dbPassword' => $_ENV['DB_PASSWORD'],
      'dbUrl' => $_ENV['DB_URL']
    );

    private $facebook = array(
      'fbAccessToken' => $_ENV['FB_ACCESS_TOKEN'],
      'fbVerificationToken' => $_ENV['FB_VERIFICATION_TOKEN'],
      'fbSendUrl' => 'https://graph.facebook.com/v2.7/me/messages?access_token='
    );

    private $sendGrid = array(
      'sgUserName' => $_ENV['SG_USER_NAME'],
      'sgPassword' => $_ENV['SG_PASSWORD']
    );
    
    // Blocking the abillity to make instances
    private function __construct() {}

    public function getDatabase($key) {
      self::$database[$key];
    }

    public function getFacebook($key) {
      self::$facebook[$key];
    }

    public function getSendGrid($key) {
      self::$sendGrid[$key];
    }
  }

?>
