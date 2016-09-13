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
        $this->log->info('quering db error occured');
        die('error: '.$activeConnection->connect_error);
      } else {
        $activeConnection->query($sql);
      }

      $this->closeDBConnection($activeConnection);
      $this->log->info('setPhase executed succesfully');
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
        $this->log->info('addUser executed succesfully');
      }

      $this->closeDBConnection($activeConnection);
    }

    public function getCurrentField($uid) {
      $this->log->info('entered getCurrentField with uid '.$uid);

      $activeConnection = $this->openDBConnection('current_sessions');
      $this->log->info('executing query');

      $sql = "SELECT current_field FROM current_sessions WHERE uid = '".$uid."'";
      mysqli_query($activeConnection, $sql);
      $result = $activeConnection->query($sql);

      // If the field found return it. Otherwise set the current_field to empty
      if ($result->num_rows > 0) {
        $this->log->info('the query is not empty');

        $data = $result->fetch_array();
        if($data['current_field'] === null) {
          $this->log->info('current_field is null. setting to empty');
          $data['current_field'] = 'empty';
        }

        $this->closeDBConnection($activeConnection);
        return $data['current_field'];
      } else {
        $this->log->info('the query is empty. no current_field has been set yet');
        $this->closeDBConnection($activeConnection);
        return 'empty';
      }
    }

    public function setCurrentField($uid, $newValue) {
      $activeConnection = $this->openDBConnection('current_sessions');

      // Save the passed field as current_field with related uid
      $sql = "UPDATE current_sessions SET current_field = '".$newValue."'  WHERE uid = '".$uid."'";

      // Kill connection if error occured
      if (!$activeConnection->query($sql)) {
        $this->log->info('quering db error occured');
        die('error: '.$activeConnection->connect_error);
      } else {
        $activeConnection->query($sql);
      }

      $this->closeDBConnection($activeConnection);
      $this->log->info('setCurrentField executed succesfully');
    }

    public function setColumnValue($uid, $columnName, $newValue) {
      $activeConnection = $this->openDBConnection('current_sessions');

      // Save the passed field as current_field with related uid
      $sql = "UPDATE current_sessions SET ".$columnName." = '".$newValue."' WHERE uid = '".$uid."'";

      // Kill connection if error occured
      if (!$activeConnection->query($sql)) {
        $this->log->info('quering db error occured');
        die('error: '.$activeConnection->connect_error);
      } else {
        $activeConnection->query($sql);
      }

      $this->closeDBConnection($activeConnection);
      $this->log->info('setColumnValue executed succesfully');
    }

    public function getColumnValue($uid, $columnName) {
      $activeConnection = $this->openDBConnection('current_sessions');
      $this->log->info('executing getColumnValue query');

      $sql = "SELECT ".$columnName." FROM current_sessions WHERE uid = '".$uid."'";
      mysqli_query($activeConnection, $sql);
      $result = $activeConnection->query($sql);

      // If the field found return it
      if ($result->num_rows > 0) {
        $this->log->info('the query is not empty');

        $data = $result->fetch_array();

        $this->closeDBConnection($activeConnection);
        return $data[$columnName];

      } else {
        $this->log->info('the query is empty');
        $this->closeDBConnection($activeConnection);
        return 'empty';
    }
  }

    public function setServiceProvider($uid, $serviceProvider) {
      $activeConnection = $this->openDBConnection('current_sessions');

      $sql = "UPDATE current_sessions SET service_provider = '".$serviceProvider."' WHERE uid = '".$uid."'";

      // Kill connection if error occured
      if ($activeConnection->query($sql) !== true) {
        $this->log->info('error occured: '.$activeConnection->connect_error);
        die('error: '.$activeConnection->connect_error);
      } else {
        $this->log->info('the query executed succesfully');
      }

      $this->closeDBConnection($activeConnection);
    }

    public function getServiceProvider($uid) {
      $activeConnection = $this->openDBConnection('current_sessions');

      $sql = "SELECT service_provider FROM current_sessions WHERE uid = '".$uid."'";
      mysqli_query($activeConnection, $sql);
      $result = $activeConnection->query($sql);

      // If the field found return it. Otherwise set the current_field to empty
      if ($result->num_rows > 0) {
        $this->log->info('the query is not empty');

        $data = $result->fetch_array();

        $this->closeDBConnection($activeConnection);
        return $data['service_provider'];
      } else {
        $this->log->info('the query is empty. no current_field has been set yet');
        $this->closeDBConnection($activeConnection);
        return 'empty';
      }
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

      // Set charset to UTF8
      mysqli_set_charset($this->connection,"utf8");

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
