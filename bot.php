<?php

  require_once('autoload.php');
  require_once('logger.php');

  // Init bot server
  $botServer = new BotServer($log, $_ENV['FB_VERIFICATION_TOKEN']);

  // Init bot and add to server
  $echoBot = new EchoBot($log);
  $botServer->addBot($echoBot);

  // Local testing
  //print_r($echoBot->processMessage(new message('test'), new user('123456')));


  // Handle request
  $botServer->processRequest();

?>
