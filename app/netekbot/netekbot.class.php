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
      $this->log->info('before phase');
      $phase = $db->getPhase($message->getUser()->getUserId());
      $this->log->info('after phase');

      // Respond
      $response = 'phase: '.$message->$phase.' '.$message->getUser()->getUserId();
      $this->log->info($response);
      return $response;
    }

  }

?>
