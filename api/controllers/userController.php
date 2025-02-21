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

        if($result['success']===true){
            // session_start();//starts session just in case
            $_SESSION['User_ID'] = $result['user'];
            $_SESSION['phoneNumber'] = $phoneNumber;
            $_SESSION['firstName'] = $firstName;
            $_SESSION['lastName'] = $lastName;
            echo json_encode(['success'=>true, 'message' => 'User registered successfully']);
        }else{
            echo json_encode(['success'=>false, 'message' =>'User registration failed ' . $result['error']]);
        }
    }

    function loginUser(){
        $rawData = file_get_contents("php://input");
        try{
            $userData = json_decode($rawData, true);
        }catch(Exception $e){
            echo json_encode(['success'=>false, 'message'=>'Invalid data']);
            return;
        }

        if(!$userData){
            echo json_encode(['success'=>false, 'message'=>'Invalid data']);
            return;
        }

        $phoneNumber = $userData['phoneNumber'];
        $password = $userData['password'];

        $result = UserModel::loginUser($phoneNumber, $password);

        if($result['success']===true){
            // session_start(); //starts session just in case
            
            $_SESSION['phoneNumber'] = $phoneNumber;
            $_SESSION['User_ID'] = $result['user']['User_ID'];
            $_SESSION['firstName'] = $result['user']['FirstName'];
            $_SESSION['lastName'] = $result['user']['LastName'];
            $_SESSION['email'] = $result['user']['Email'];
            echo json_encode(['success'=>true, 'message'=>'User logged in successfully', 'user'=>$result]);
        }else{
            echo json_encode(['success'=>false, 'message'=>'User login failed: '.$result['error']]);
        }
    }

    function logoutUser(){
        session_unset();
        echo json_encode(['success'=>true, 'message'=>'User logged out successfully']);
    }

    function isUserAdmin(){
        if(isset($_SESSION['User_ID'])){
            $userID = $_SESSION['User_ID'];
            $result = UserModel::isUserAdmin($userID);
            if($result['success']===true){
                echo json_encode(['success'=>true, 'message'=>'User is admin', 'isAdmin'=>$result['isAdmin']]);
            }else{
                echo json_encode(['success'=>false, 'message'=>'Failed to check if user is admin: '.$result['error']]);
            }
        }else{
            echo json_encode(['success'=>false, 'message'=>'User not logged in']);
        }
    }

    function checkIfUserIsLoggedIn(){
        if(isset($_SESSION['User_ID'])){
            echo json_encode(['success'=>true, 'message'=>'User is logged in']);
        }else{
            echo json_encode(['success'=>false, 'message'=>'User is not logged in']);
        }
    }

    function checkIfUserIsCustomer(){
        if(isset($_SESSION['User_ID'])){
            $userID = $_SESSION['User_ID'];
            $result = UserModel::isUserCustomer($userID);
            if($result['success']===true){
                echo json_encode(['success'=>true, 'message'=>'User is customer', 'isCustomer'=>$result['isCustomer']]);
            }else{
                echo json_encode(['success'=>false, 'message'=>'Failed to check if user is customer: '.$result['error']]);
            }
        }else{
            echo json_encode(['success'=>false, 'message'=>'User not logged in']);
        }
    }
?>