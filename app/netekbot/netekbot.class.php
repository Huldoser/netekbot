<?php

  class netekbot {

    private $log;

    public function __construct($log) {
      $this->log = $log;
    }

    public function processMessage($message) {
      $this->log->info('processing the message');

      // Declerations and Initializations
      $field;
      $fieldName;
      $backend = new backend($this->log);
      $db = new database($this->log);
      $usersMessage = $message->getMessage();
      $sameMessage = false;
      $uid = $message->getUser()->getUserId();

      // Get the current phase for the current user
      $this->log->info('before getPhase');
      $phase = $db->getPhase($uid);
      $this->log->info('after getPhase. the current phase for uid '.$uid.' is '.$phase);

      switch ($phase) {
        // Checking for service provider validity if found savinf to db and updating phase to 1
        case 0:
          $this->log->info('entered phase 0');

          $serviceProvider = $message->getMessage();
          $serviceProvider = $backend->matchProvider($serviceProvider);

          $this->log->info('matching service provider');

          if ($serviceProvider === 'not_found') {
            $message->setMessage('אני לא מכיר את הספק '.$usersMessage.' וודא שהקלדת את השם תקין');

            $this->log->info('requested service provider was not found');
            break;
          } else {
            $this->log->info('requested service provider was found. saving to db');

            $db->setServiceProvider($uid, $serviceProvider);
            $db->setPhase($uid, 1);

            $message->setMessage('על מנת לנתק אותך מ'.$usersMessage
              .' אצטרך ממך מספר פרטים.'.chr(10).chr(10).'חשוב לי לציין שהפרטיות שלך חשובה לי מאוד ולכן אני מתחייב לא לשמור ולא לשתף את הפרטים המזהים שלך עם אף גורם צד ג.');

            $sameMessage = true;
            // NOTICE! No break here for the fall-through behavior.
          }

        // Loop throgh all the needed fields
        case 1:
          $this->log->info('entered phase 1');

          // Check if its the same message set bofore. If it is add two new lines and instructions
          if ($sameMessage) {
            $message->setMessage($message->getMessage().chr(10).chr(10)
              .'להלן הפרטים שאני צריך על מנת לנסח את המכתב לספק'.' ');
          }

          // Check if the current field is empty or not done
          $field = $db->getCurrentField($uid);
          if ($field === 'empty') {
            $this->log->info('the field is empty');

            if ($sameMessage) {
              $message->setMessage($backend->getHebrewTranslation($message->getMessage().$backend->getNextField($field)).'?');
            } else {
              $message->setMessage($backend->getHebrewTranslation($backend->getNextField($field)).'?');
            }
            $db->setCurrentField($uid, $backend->getNextField($field));
            $db->setColumnValue($uid, 'first_name', $usersMessage);

          } else if ($field !== 'done') {
            $this->log->info('the field is '.$field);

            if ($field !== 'last_digits') {
              $message->setMessage($backend->getHebrewTranslation($backend->getNextField($field)).'?');
            }

            $db->setCurrentField($uid, $backend->getNextField($field));
            $db->setColumnValue($uid, $field, $usersMessage);

          } else {

            $this->log->info('the field is done');
            $db->setPhase($uid, 2);
          }

          break;

        case 2:
          $message->setMessage('אוקי, קיבלתי ממך את כל מה שאני צריך. לפני שאשלח את הודעת הדואר האלקטרוני ארצה רק לוודא שכל הפרטים נכוניםֿ');
      }

      return $message;

      // $message->setMessage('We are good to go! check server logs for more information');
      // return $message;
    }

  }

?>
