<?php

    function getConnection(){
        $connection = DatabaseConnector::$connection;
        return $connection;
    }

    function changeDatabaseConnection($dbname){
        
        return DatabaseConnector::ConnectDatabase($dbname);
    }
    class DatabaseConnector{            
        public static $mainServername = "localhost";
        public static $mainUsername = "root";
        public static $mainPassword = "";
        public static $mainDatabase = "ACHS canteen";

        public static $connection;

        public static function Construct(){
            self::$connection = mysqli_connect(self::$mainServername, self::$mainUsername, self::$mainPassword, self::$mainDatabase);

            if (!self::$connection) {
                echo "Error Connecting to Database with :".self::$mainServername.self::$mainUsername. self::$mainPassword.self::$mainDatabase;
                die();
            }
        }

        public static function ConnectDatabase($dbname = 'ACHS canteen'){
            self::$connection = mysqli_connect(self::$mainServername,self::$mainUsername, self::$mainPassword,$dbname);
            if(!self::$connection){
                echo "Error Connecting to Database with :".self::$mainServername.self::$mainUsername. self::$mainPassword.$dbname;
                die();
            }
            return self::$connection;
        }

        
    }
    DatabaseConnector::Construct();

    
?>