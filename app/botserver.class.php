<?php

  class BotServer {

    private $bot;
    private $log;
    private $verificationToken;
    private $hubChallenge;

    public function __construct($log, $verificationToken) {
      $this->log = $log;
      $this->verificationToken = $verificationToken;

      $this->log->info('bot server constructed');
    }


    // Associate the bot with the server
    public function addBot($bot) {
      $this->bot = $bot;

      $this->log->info('added bot to the server');
    }


    // Checking authentication and processing the message
    public function processRequest() {
      $this->log->info('proccessing request');

      if(isset($_GET['hub_verify_token'])) {
        $this->log->info('authenticating the bot');

        $this->botAuthentication($_GET['hub_verify_token'], $_GET['hub_challenge']);

      } else {
        $this->log->info('the bot is authenticated');

        $this->readMessage();
      }
    }


    // This is the authentication with facebook
    private function botAuthentication($token, $hubChallenge) {
      if($token === $this->verificationToken) {
        $this->log->info('the token is correct');

        $this->hubChallenge = $hubChallenge;
        echo $this->hubChallenge;

      // Terminate server on authentication error
      } else {
        $this->log->error('incorrect token');

        exit();
      }
    }


    // Decode the message and reply accordingly
    private function readMessage() {
      $data = json_decode(file_get_contents('php://input'), true); // php://input == POST

      $this->log->info(print_r($data, true));

      $messaging_events = $data['entry'][0]['messaging']; // messaging is an event we are getting from facebook
      $event = $messaging_events[0]; // Extracting the first event
      $sender = $event['sender']; // Extracting the sender
      $recipient = $event['recipient']; // Extracting the recipient

      // Making sure we got a valid message
      if (isset($event['message']) && isset($event['message']['text'])) {
        $text = $event['message']['text'];

        $message = new message($text, new user($sender['id']));
        $botMessage = $this->bot->processMessage($message);

        $this->log->info('sending the user a message from the bot');

        $this->sendMessage($message);

      // Check if we got the event but there is no message
      } else if (isset($event['message']) && !isset($event['message']['text'])) {
        $this->log->info('the message is invalid');

        $text = 'מאוד ניסיתי אבל אני לא מצליח להבין את מה ששלחת לי.'.chr(10).chr(10)
          .'אני בוט צעיר וכרגע ואני מבין רק מילים'.'...';

        $message = new message($text, new user($sender['id']));
        $this->sendMessage($message);

      // If both of the above have been failed, something gone wrong
      } else {
        $this->log->error('error proccessing message');

        $text = 'בוטים אדירים'.'!'.' נראה שיש לי תקלה'.'!'.chr(10)
          .'בזמן שאני מתקן אותה'.', '.'אולי זה זמן טוב לשתות כוס קפה'.'?'.chr(10)
          .'אני מאוד אשתדל לפתור אותה עד שהקפה יגמר...';

        $message = new message($text, new user($sender['id']));
        $this->sendMessage($message);

        exit();

      }
    }


    // Sending a message to the user
    public function sendMessage($message) {
      $this->log->info('sending a message');

      $accessToken = config::getFacebook('fbAccessToken');
      $url = config::getFacebook('fbSendUrl').$accessToken;

      $postData = json_encode(array(
        'recipient' => array('id' => $message->getUser()->getUserId()),
        'message' => array('text' => $message->getMessage())
      ));

      $options = array(
        'http' => array(
          'header' => "Content-type: application/json".chr(10)
            ."Content-Length: ".strlen($postData).chr(10),
            'method' => "POST",
            'content' => $postData
        )
      );

      $context = stream_context_create($options);
      //$result = file_get_contents($url, false, $context);
    }


  }

?>
