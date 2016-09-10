<?php

  class netekbot {

    private $log;

    public function __construct($log) {
      $this->log = $log;
    }

    public function processMessage($message) {
      $this->log->info('processing the message');

      // Declerations and Initializations
      $db = new database('current_sessions', $this->log);


      // Get the current phase for the current user
      $phase = $db->getPhase($message->getUser());

      // Respond
      $response = $message->$phase.' '.$message->getUser();
      return $response;
    }

  }

?>
