<?php

    class user {

        private $userId;

        function __construct($userId) {
            $this->userId = $userId;
        }


        public function getUserId() {
            return $this->userId;
        }


    }

?>
