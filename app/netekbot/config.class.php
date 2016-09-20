<?php

  class config {

    static $db = array(
      'dbName' => $_ENV['DB_NAME'],
      'dbUserName' => $_ENV['DB_USER_NAME'],
      'dbPassword' => $_ENV['DB_PASSWORD'],
      'dbUrl' => $_ENV['DB_URL']
    );

    static $facebook = array(
      'fbAccessToken' => $_ENV['FB_ACCESS_TOKEN'],
      'fbVerificationToken' => $_ENV['FB_VERIFICATION_TOKEN'],
      'fbSendUrl' => 'https://graph.facebook.com/v2.7/me/messages?access_token='

    );

    static $sendGrid = array(
      'sgUserName' => $_ENV['SG_USER_NAME'],
      'sgPassword' => $_ENV['SG_PASSWORD']
    );
  }

?>
