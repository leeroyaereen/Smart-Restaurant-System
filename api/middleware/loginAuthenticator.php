<?php

use Src\Helpers\UserClass;
    require_once '../../config/databaseConnector.php';
    require_once '../models/UserModel.php';
    //check from database if the phoneNumber and password align based on the database's stored data
    function checkIfLoginDataMatches($userModel, $phoneNumber, $password){
        $conn = getConnection();

        if(!$conn) return "Database connection error";

        $user = $userModel->getUserDetailsWithPhoneNumber($phoneNumber);
        if($user instanceof UserClass) {
            if($user->password===$password) {
                $_SESSION['phoneNumber'] = $user->phoneNumber;
                $_SESSION['firstName'] = $user->firstName;
                $_SESSION['lastName'] = $user->lastName;
                return true;
            }
            else return "Incorrect Password";
        }return "Invalid Returned Datatype";
    }

    
?>