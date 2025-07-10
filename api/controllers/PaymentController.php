<?php
    require_once __DIR__."/../models/OrderModel.php";
    require_once __DIR__."/../helper/orderItemClass.php";
    require_once __DIR__."/../models/FoodItemModel.php";

    use Src\Helpers\FoodItem;
    use Src\Helpers\OrderItem;
    use Src\Helpers\OrderStatus;
    
    $error_message = "";
    $khalti_public_key = "your-public-api-key";

    $amount = 0;
    $uniqueProductId = "nike-shoes";
    $uniqueUrl = "http://localhost/product/nike-shoes/";
    $uniqueProductName = "Nike shoes";
    $successRedirect = "/"; // change this url , it will be the page user will be redirected after successful payment


    // ------------------------------------------------------------------------
    // HINT : just change price above and redirect user to this page. It will handel everything automatically.
    // ------------------------------------------------------------------------

    function checkValid($data)
    {
        $verifyAmount = 1000; // get amount from database and multiply by 100
        // $data contains khalti response. you can print it to view more details.
        // eg. $data["token] will give token & $data["amount] will give amount and more. see khalti docs for response format
        // $error_message="";
        // show error from above message
        if ((float) $data["amount"] == $verifyAmount) {
            return 1;
        } else {
            return 0;
        }

        // use your extra function for checking price & all again. You can perform more action here. 
        // 1= success, 0 = error, 

        //
    }
    // ------------------------------------------------------------------------
    // DONOT CHANGE THE CODE BELOW UNLESS YOU KNOW WHAT YOU ARE DOING
    // ------------------------------------------------------------------------



    // declaring some global variables
    $token = "";
    $price = $amount;
    $mpin = "";
    // send otp
    function sendPaymentDetails(){
        global $price,$amount;
        if($_SERVER['REQUEST_METHOD']!=='POST'){
            echo json_encode(['success'=>false,'message'=>'Invalid Request Method']);
            return;
        }

        
        $data = json_decode(file_get_contents('php://input'), true);
        global $khalti_public_key, $uniqueProductId, $uniqueProductName, $uniqueUrl, $successRedirect, $error_message,$token;
        $uniqueProductId = getUniqueProductId($_SESSION['currentOrderTrayID']);
        $uniqueProductName = getUniqueProductName($_SESSION['currentOrderTrayID']);
        if (isset($data["mobile"]) && isset($data["mpin"])) {
            try {
                $mobile = $data["mobile"];
                $mpin = $data["mpin"];
                $price = getTotalPriceOfOrderTray($_SESSION['currentOrderTrayID']);
                $amount = getTotalPriceOfOrderTray($_SESSION['currentOrderTrayID']) * 100;


                $curl = curl_init();

                curl_setopt_array(
                    $curl,
                    array(
                        CURLOPT_URL => 'https://khalti.com/api/v2/payment/initiate/',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => '{
                                "public_key": "' . $khalti_public_key . '",
                                "mobile": ' . $mobile . ',
                                "transaction_pin": ' . $mpin . ',
                                "amount": ' . ($amount) . ',
                                "product_identity": "' . $uniqueProductId . '",
                                "product_name": "' . $uniqueProductName . '",
                                "product_url": "' . $uniqueUrl . '"
                        }',
                        CURLOPT_HTTPHEADER => array(
                            'Content-Type: application/json'
                        ),
                    )
                );

                $response = curl_exec($curl);

                curl_close($curl);
                $parsed = json_decode($response, true);

                if (key_exists("token", $parsed)) {
                    $token = $parsed["token"];
                    echo json_encode(['success'=>true, 'message'=>$parsed]);
                } else {
                    $error_message = "incorrect mobile or mpin";
                    echo json_encode(['success'=>false,'message'=>$error_message]);
                    return;
                }


            } catch (Exception $e) {
                $error_message = "incorrect mobile or mpin";
                echo json_encode(['success'=>false,'message'=>$error_message]);
                return;
            }
        }
    }

    function sendOTP(){
        global $khalti_public_key, $successRedirect;
        // otp verification
        if (isset($_POST["otp"]) && isset($_POST["token"]) && isset($_POST["mpin"])) {
            try {
                $otp = $_POST["otp"];
                $token = $_POST["token"];
                $mpin = $_POST["mpin"];


                $curl = curl_init();

                curl_setopt_array(
                    $curl,
                    array(
                        CURLOPT_URL => 'https://khalti.com/api/v2/payment/confirm/',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => '{
                    "public_key": "' . $khalti_public_key . '",
                    "transaction_pin": ' . $mpin . ',
                    "confirmation_code": ' . $otp . ',
                    "token": "' . $token . '"
            }',
                        CURLOPT_HTTPHEADER => array(
                            'Content-Type: application/json'
                        ),
                    )
                );

                $response = curl_exec($curl);

                curl_close($curl);
                $parsed = json_decode($response, true);

                if (key_exists("token", $parsed)) {
                    $isvalid = checkValid($parsed);
                    if ($isvalid) {
                        $error_message = "<span style='color:green'>payment success</span> <script> window.location='" . $successRedirect . "'; </script>";
                    }


                } else {
                    $error_message = "couldnot process the transaction at the moment.";
                    if (key_exists("detail", $parsed)) {
                        $error_message = $parsed["detail"];
                    }

                }
            } catch (Exception $e) {
                $error_message = "couldnot process the transaction at the moment.";

            }


        }
    }
?>