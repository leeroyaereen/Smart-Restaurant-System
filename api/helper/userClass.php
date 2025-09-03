<?php
namespace Src\Helpers;
    class UserClass{
        private $firstName = "";

        private $lastName = "";
        private $userType;
        
        private $email = "";
        private $phoneNumber;
        private $password;

        public function getFirstName(){
            return $this->firstName;
        }
        public function getLastName(){
            return $this->lastName;
        }
        public function getEmail(){
            return $this->email;
        }
        public function getPhoneNumber(){
            return $this->phoneNumber;
        }
        public function getPassword(){
            return $this->password;
        }
        public function getUserType(){
            return $this->userType;
        }

        public function getFullName(){
            return $this->firstName . " " . $this->lastName;
        }
           
        
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