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
      $uid = $message->getUser()->getUserId();

      // Get the current phase for the current user
      $this->log->info('before getPhase');
      $phase = $db->getPhase($uid);
      $this->log->info('after getPhase. the current phase for uid '.$uid.' is '.$phase);

      switch ($phase) {
        // Checking for service provider validity if found savinf to db and updating phase to 1
        case 0:
          $serviceProvider = $message->getMessage();
          $serviceProvider = $backend->matchProvider($serviceProvider);

          $this->log->info('matching service provider');

          if ($serviceProvider === 'not_found') {
            $message->setMessage('אני לא מכיר את הספק '.$message->getMessage().' וודא שהקלדת את השם תקין');

            $this->log->info('requested service provider was not found');
            break;
          } else {
            $this->log->info('requested service provider was found. saving to db');

            $db->setServiceProvider($uid, $serviceProvider);
            $db->setPhase($uid, 1);

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
