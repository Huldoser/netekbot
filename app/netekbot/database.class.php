<?php
  class database {

    private $connection;
    private $dbName;
    private $dbUserName;
    private $dbUrl;
    private $dbPassword;
    private $dbTableName;
    private $log;

    public function __construct($log) {
      $this->log = $log;
    }

    public function getPhase($uid) {
      $this->log->info('entered getPhase with uid '.$uid);

      $activeConnection = $this->openDBConnection('current_sessions');
      $this->log->info('executing query');

      $sql = "SELECT current_phase FROM current_sessions WHERE uid = ".$uid;
      mysqli_query($activeConnection, $sql);
      $result = $activeConnection->query($sql);

      // If the phase found return it. Otherwise set the phase to 0
      if ($result->num_rows > 0) {
        $this->log->info('the query is not empty');

        $data = $result->fetch_array();
        return $data['current_phase'];

        $this->closeDBConnection($activeConnection);
      } else {
        $this->log->info('the query is empty. new user detected. entering addUser');
        $this->closeDBConnection($activeConnection);
        $this->addUser($uid);

        // Execute getPhase again - now it will find the uid
        return $this->getPhase($uid);
      }
    }

    // This function set the phase for existing user
    public function setPhase($uid, $phaseNumber) {
      $activeConnection = $this->openDBConnection('current_sessions');

      // Save the passed phase to db with related uid
      $sql = "UPDATE current_sessions SET current_phase = ".$phaseNumber." WHERE uid = ".$uid;

      // Kill connection if error occured
      if (!$activeConnection->query($sql)) {
        $this->log->info('error occured: '.$activeConnection->connect_error);
        die('error: '.$activeConnection->connect_error);
      } else {
        $activeConnection->query($sql);
      }

      $this->closeDBConnection($activeConnection);
      $this->log->info('setPhase executed seccesfully');
    }

    // this function crates a new user in db and set phase to 0
    private function addUser($uid) {
      $activeConnection = $this->openDBConnection('current_sessions');

      // Save the passed face to db with related uid
      $sql = "INSERT INTO current_sessions (uid, current_phase) VALUES ('".$uid."', 0)";

      // Kill connection if error occured
      if ($activeConnection->query($sql) !== true) {
        $this->log->info('error occured: '.$activeConnection->connect_error);
        die('error: '.$activeConnection->connect_error);
      } else {
        $this->log->info('addUser executed seccesfully');
      }

      $this->closeDBConnection($activeConnection);
    }

    public function getCurrentField($uid) {
      $this->log->info('entered getField with uid '.$uid);

      $activeConnection = $this->openDBConnection('current_sessions');
      $this->log->info('executing query');

      $sql = "SELECT current_field FROM current_sessions WHERE uid = ".$uid;
      mysqli_query($activeConnection, $sql);
      $result = $activeConnection->query($sql);

      // If the field found return it. Otherwise set the stage to 0
      if ($result['current_field'] === null) {
        $this->log->info('the query is not empty');

        $data = $result->fetch_array();
        return $data['current_field'];

        $this->closeDBConnection($activeConnection);
      } else {
        $this->log->info('the query is empty. no current_field has been set yet');
        $this->closeDBConnection($activeConnection);
        return 'empty';
      }
    }

    public function setCurrentField($uid, $fieldName) {
      $activeConnection = $this->openDBConnection('current_sessions');

      // Save the passed field as current_field with related uid
      $sql = "UPDATE current_sessions SET current_field = ".$fieldName." WHERE uid = ".$uid;

      // Kill connection if error occured
      if (!$activeConnection->query($sql)) {
        $this->log->info('error occured: '.$activeConnection->connect_error);
        die('error: '.$activeConnection->connect_error);
      } else {
        $activeConnection->query($sql);
      }

      $this->closeDBConnection($activeConnection);
      $this->log->info('setCurrentField executed seccesfully');
    }

    public function setServiceProvider($uid, $serviceProvider) {
      $activeConnection = $this->openDBConnection('current_sessions');

      $sql = "UPDATE current_sessions SET service_provider = '".$serviceProvider."' WHERE uid = '".$uid."'";

      // Kill connection if error occured
      if ($activeConnection->query($sql) !== true) {
        $this->log->info('error occured: '.$activeConnection->connect_error);
        die('error: '.$activeConnection->connect_error);
      } else {
        $this->log->info('the query executed seccesfully');
      }

      $this->closeDBConnection($activeConnection);
    }

    private function openDBConnection($tableName) {
      // Get envs
      $this->dbName = $_ENV['DB_NAME'];
      $this->dbUserName = $_ENV['DB_USER_NAME'];
      $this->dbUrl = $_ENV['DB_URL'];
      $this->dbPassword = $_ENV['DB_PASSWORD'];
      $this->dbTableName = $tableName;

      // Create connection
      $this->connection = new mysqli($this->dbUrl, $this->dbUserName, $this->dbPassword, $this->dbName);

      // Test connection
      if ($this->connection->connect_error) {
        $this->log->info('the connection to '.$this->dbName.' has been failed');
        die('connection failed: '.$this->connection->connect_error);
      } else {
        $this->log->info('the connection to '.$this->dbName.' was established successfully');
        return $this->connection;
      }
    }

    private function closeDBConnection($theConnection) {
      $this->log->info('closing connection');

      mysqli_close($this->connection);
    }

}

?>
