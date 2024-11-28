<?php
    function CheckIfLoginCookiesStillExists(){
        
    }
    require_once '../middleware/databaseConnector.php';
    require_once '../middleware/loginAuthenticator.php';

    $cookieDuration = 30;//in terms of days
    if(!$connection){
        echo json_encode(["status"=>'failure', "message" => "Can't Connect to the database"]);
        die();
    }

    //check if the login form has required data
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // echo "<script>alert('Request Recieved')</script>";
        $json = file_get_contents('php://input');
        $data = json_decode($json,true);

        //check error in json invalid format
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode(["success" => false, "message" => "Invalid JSON"]);
            exit;
        }
        
        $phone = $data['phoneNumber']??null;
        $pass = $data['password'] ?? null;

        if($phone!=null && $pass != null){
            if(checkIfLoginDataMatches($phone,$pass)){
                setcookie('phoneNumber',$phone, 86400 * $cookieDuration,"","",true);
                echo json_encode(["status"=>'success', "message" => "Login Successful, Credentials are Valid"]);

            }else{
                echo json_encode(["status"=>'failure', "message" => "Login Failed due to incorrect credentials"]);

            }
        }else{
            echo json_encode(["status"=>'failure', "message" => "Login Failed due to empty values"]);

        }

    }else{
        echo json_encode(["status"=>'failure', "message" => "Login Failed due to different request method"]);
        
    }

    
?>