<?php

  class netekbot {

    private $log;

    public function __construct($log) {
      $this->log = $log;
    }

    public function processMessage($message) {
      $this->log->info('processing the message');

      // Declerations and Initializations
      $backend = new backend($this->$log);
      $db = new database($this->log);

      // Get the current phase for the current user
      $this->log->info('before getPhase');
      $phase = $db->getPhase($message->getUser()->getUserId());
      $this->log->info('after getPhase. the current phase for uid '.$message->getUser()->getUserId().' is '.$phase);

      switch ($phase) {
        // Checking for service provider validity
        case 0:
          $serviceprovider = array('', $message->getMessage());

          if ($backend->matchProvider($serviceprovider) === 'not_found') {
            $message->setMessage('אני לא מכיר את הספק '.$serviceprovider[1].' וודא שהקלדת את השם תקין');
            return $message;
            break;
          } else {
            // save service provider to db
          }



      }

      // $message->setMessage('We are good to go! check server logs for more information');
      // return $message;
    }

  }

?>
