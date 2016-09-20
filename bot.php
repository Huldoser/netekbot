<?php

  require_once('autoload.php');
  require_once('logger.php');

  // Init bot server
  $botServer = new BotServer($log, new Config()->getFacebookConfigs()['fbVerificationToken']);

  // Init bot and add to server
  $netekbot = new Netekbot($log);
  $botServer->addBot($netekbot);

  // Handle request
  $botServer->processRequest();

?>
