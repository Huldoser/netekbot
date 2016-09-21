<?php

  require_once('autoload.php');
  require_once('logger.php');

  // Init bot server
  $botServer = config::getFacebook('fbVerificationToken');

  // Init bot and add to server
  $netekbot = new Netekbot($log);
  $botServer->addBot($netekbot);

  // Handle request
  $botServer->processRequest();

?>
