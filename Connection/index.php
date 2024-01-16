<?php 
    class Connection {
        public $connect; 
        public $username = "root";
        public $host = "localhost";
        public $password = "";
        public $database = "dom";

        public function connects() {
            return $this-> connect = mysqli_connect($this -> host, $this -> username, $this -> password, $this -> database);
        }
    }