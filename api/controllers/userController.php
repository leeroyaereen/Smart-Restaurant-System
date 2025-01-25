<?php 
    require_once __DIR__.'/../models/UserModel.php';

    function registerUser(){
        $rawData = file_get_contents("php://input");
        $userData = json_decode($rawData, true);

        if(!$userData){
            echo json_encode(['success'=>false, 'message'=>'Invalid data']);
        }

        $firstName = $userData['firstName'];
        $lastName = $userData['lastName'];
        $email = $userData['email'];
        $phoneNumber = $userData['phoneNumber'];
        $password = $userData['password'];

        $result = UserModel::registerUser($firstName, $lastName, $email, $phoneNumber, $password);

        if($result===true){
            // session_start();//starts session just in case

            $_SESSION['phoneNumber'] = $phoneNumber;
            $_SESSION['firstName'] = $firstName;
            $_SESSION['lastName'] = $lastName;
            echo json_encode(['success'=>true, 'message'=>'User registered successfully']);
        }else{
            echo json_encode(['success'=>false, 'message'=>'User registration failed']);
        }
    }

    function loginUser(){
        $rawData = file_get_contents("php://input");
        $userData = json_decode($rawData, true);

        if(!$userData){
            echo json_encode(['success'=>false, 'message'=>'Invalid data']);
            return;
        }

        $phoneNumber = $userData['phoneNumber'];
        $password = $userData['password'];

        $result = UserModel::loginUser($phoneNumber, $password);

        if($result){
            // session_start(); //starts session just in case
            $_SESSION['phoneNumber'] = $phoneNumber;
            $_SESSION['firstName'] = $result['FirstName'];
            $_SESSION['lastName'] = $result['LastName'];
            echo json_encode(['success'=>true, 'message'=>'User logged in successfully']);
        }else{
            echo json_encode(['success'=>false, 'message'=>'User login failed', 'error'=>$result]);
        }
    }

    function logoutUser(){
        session_unset();
        echo json_encode(['success'=>true, 'message'=>'User logged out successfully']);
    }
?>