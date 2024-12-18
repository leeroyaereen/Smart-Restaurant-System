<?php
namespace Src\Helpers;
    class UserClass{
        private $firstName = "";

        private $lastName = "";
        private $userType;
        
        private $email = "";
        private $phoneNumber;
        private $password;

        function __construct($firstName,$lastName,$email,$phoneNumber,$password,$userType = 1){
            $this->$phoneNumber = $phoneNumber; 
            $this->password = $password; 
            $this->firstName = $firstName;
            $this->lastName = $lastName;
            $this->email = $email;
            $this->userType = $userType;
        }

        function __get($name){

        }

        
    }

?>