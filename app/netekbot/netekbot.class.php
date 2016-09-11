<?php

  class netekbot {

    private $log;

    public function __construct($log) {
      $this->log = $log;
    }

    public function processMessage($message) {
      $this->log->info('processing the message');

      // Declerations and Initializations
      $backend = new backend($this->log);
      $db = new database($this->log);

      // Get the current phase for the current user
      $this->log->info('before getPhase');
      $phase = $db->getPhase($message->getUser()->getUserId());
      $this->log->info('after getPhase. the current phase for uid '.$message->getUser()->getUserId().' is '.$phase);

      switch ($phase) {
        // Checking for service provider validity
        case 0:
          $serviceProvider = $message->getMessage();
          $serviceProvider = $backend->matchProvider($serviceProvider);

          if ($serviceProvider === 'not_found') {
            $message->setMessage('אני לא מכיר את הספק '.$message->getMessage().' וודא שהקלדת את השם תקין');
            break;
          } else {
            $message->setMessage('על מנת לנתק אותך מ'.$message->getMessage()
              .' אצטרך ממך מספר פרטים.'.chr(10).chr(10).'חשוב לי לציין שהפרטיות שלך חשובה לי מאוד ולכן אני מתחייב לא לשמור ולא לשתף את הפרטים המזהים שלך עם אף גורם צד ג.');
          }
      }

      return $message;

      // $message->setMessage('We are good to go! check server logs for more information');
      // return $message;
    }

  }

?>
