<?php

  class echobot {

    private $log;

    function __construct($log) {
      $this->log = $log;
    }

    public function processMessage($message) {
      $this->log->info('processing the message');

      // Respond
      $message->setMessage('Did you say '.$message->getMessage().'?');
      return $message;
    }

  }

?>
