<?php

  class BotServer {

    private $log;
    private $verificationToken;
    private $hubChallenge;

    private $bot;

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
        $this->log->info('the bot is authenticted');

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
      $data = json_decode(file_get_contents('php://input'), true); //php://input == POST
      $messaging_events = $data['entry'][0]['messaging'];

      foreach((array) $messaging_events as $key => $value) {

        $event = $value;
        $sender = $event['sender'];
        $recipient = $event['recipient'];

        if (isset($event['message']) && isset($event['message']['text'])) {
          $text = $event['message']['text'];

          // Send message to the bot
          $message = new message($text, new user($sender['id']));
          $botMessage = $this->bot->processMessage($message);
          if ($botMessage) {
            $this->sendMessage($message);
          }
        } else {
          $this->log->error('error proccessing message');
        }
      }
    }

    public function sendMessage($message) {
      $accessToken = $_ENV['FB_ACCESS_TOKEN'];
      $url = 'https://graph.facebook.com/v2.7/me/messages?access_token='.$accessToken.'';
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
