<?php

  class netekbot {

    private $log;

    public function __construct($log) {
      $this->log = $log;
    }

    public function processMessage($message) {
      $this->log->info('processing the message');

      // Declerations and Initializations
      $db = new database($this->log);

      // Get the current phase for the current user
      $this->log->info('before getPhase');
      $phase = $db->getPhase($message->getUser()->getUserId());
      $this->log->info('after getPhase. the current phase for uid '.$message->getUser()->getUserId().' is '.$phase);

      $message->setMessage('Everything is good to go =]');
      return $message;
    }

  }

?>
