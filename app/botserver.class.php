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

    // Allow to attach the bot to the server
    public function addBot($bot) {
      $this->bot = $bot;

      $this->log->info('added bot to the server');
    }

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

    // This is the webhook verification with facebook
    private function botAuthentication($token, $hubChallenge) {
      if($token === $this->verificationToken) {
        $this->hubChallenge = $hubChallenge;
        $this->log->info('got correct token');
        echo $this->hubChallenge;
      }
    }

    private function readMessage() {
      $data = json_decode(file_get_contents('php://input'), true); // php://input == POST

      $this->log->info(print_r($data, true));

      $messaging_events = $data['entry'][0]['messaging']; // messaging is the event we are getting from facebook

      $event = $messaging_events[0]; // Getting the first message event
      $sender = $event['sender'];
      $recipient = $event['recipient'];

      if (isset($event['message']) && isset($event['message']['text'])) {
        $text = $event['message']['text'];

        $message = new message($text, new user($sender['id']));
        $botMessage = $this->bot->processMessage($message);

        if ($botMessage) {
          $this->log->info('sending the user a message from the bot');

          $this->sendMessage($message);
        }
      } else {
        $this->log->error('error proccessing message');
        $this->sendMessage('בוטים אדירים'.'!'.' נראה שיש לי תקלה'.'!'.chr(10)
          .'בזמן שאני מתקן אותה'.', '.'אולי זה זמן טוב לשתות כוס קפה'.'?'.chr(10)
          .'אני מאוד אשתדל לפתור אותה עד שהקפה יגמר...');
      }
    }

    public function sendMessage($message) {
      $accessToken = config::getFacebook('fbAccessToken');
      $url = config::getFacebook('fbSendUrl').$accessToken;
      $postData = json_encode(array(
        'recipient' => array('id' => $message->getUser()->getUserId()),
        'message' => array('text' => $message->getMessage())
      ));

      $options = array(
        'http' => array(
          'header' => "Content-type: application/json\r\n"
            ."Content-Length: ".strlen($postData)."\r\n",
            'method' => "POST",
            'content' => $postData
        )
      );

      $context = stream_context_create($options);
      $result = file_get_contents($url, false, $context);
    }

  }

?>
