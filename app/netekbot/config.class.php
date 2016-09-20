<?php

  class config {

    static $db = array(
      'dbName' => $ENV_['DB_NAME'],
      'dbUserName' => $ENV_['DB_USER_NAME'],
      'dbPassword' => $ENV_['DB_PASSWORD'],
      'dbUrl' => $ENV_['DB_URL']
    );

    static $facebook = array(
      'fbAccessToken' => $ENV_['FB_ACCESS_TOKEN'],
      'fbVerificationToken' => $ENV_['FB_VERIFICATION_TOKEN'],
      'fbSendUrl' => 'https://graph.facebook.com/v2.7/me/messages?access_token='

    );

    static $sendGrid = array(
      'sgUserName' => $ENV_['SG_USER_NAME'],
      'sgPassword' => $ENV_['SG_PASSWORD']
    );
  }

?>
