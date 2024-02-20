<?php 
    class Connection {
        public $connect; 
        // public $username = "root";
        // public $host = "localhost";
        // public $password = "";
        // public $database = "dom";

        public $username = "u653188733_acaduser";
        public $host = "localhost";
        public $password = "!Acadpassword123";
        public $database = "u653188733_acadrecords";

        public function connects() {
            return $this-> connect = mysqli_connect($this -> host, $this -> username, $this -> password, $this -> database);
        }
    }