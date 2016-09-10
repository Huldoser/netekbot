<?php
  class database {

    private $connection;
    private $dbName;
    private $dbUserName;
    private $dbUrl;
    private $dbPassword;
    private $dbTableName;
    private $log;

    public function __construct($tableName, $log) {
      // Define db
      $this->dbName = $_ENV['DB_NAME'];
      $this->dbUserName = $_ENV['DB_USER_NAME'];
      $this->dbUrl = $_ENV['DB_URL'];
      $this->dbPassword = $_ENV['DB_PASSWORD'];
      $this->dbTableName = $tableName;
      $this->log = $log;

      // Create connection
      $this->connection = new mysqli($this->dbUrl, $this->dbUserName, $this->dbPassword, $this->dbName);

      // Test connection
      if ($this->connection->connect_error) {
        $this->log->info('the connection to '.$this->dbName.' has been failed');
        die('connection failed: '.$this->connection->connect_error);
      }

      $this->log->info('the connection to '.$this->dbName.' was established successfully');

}
    public function getPhase($uid) {
      $sql = "SELECT current_phase FROM `current_sessions` WHERE `uid` = ".$uid;
      mysqli_query($this->connection, $sql);
      $result = $this->connection->query($sql);

      // If the phase found retrun it. Otherwise set the phase to 0
      if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          return $row["current_phase"];
        }
      } else {
        $this->setPhase($uid, 0);
      }
    }

    public function setPhase($uid, $phaseNumber) {
      // Save the passed face to db with related uid
      $sql = "UPDATE `current_sessions` SET `current_phase` = '".$phaseNumber."' WHERE `uid` ".$uid;

      // Kill connection if error occured
      if ($this->connection->query($sql) !== true) {
        die('setPhase has been failed. error: '.$this->connection->connect_error);
      }
    }

}

?>
