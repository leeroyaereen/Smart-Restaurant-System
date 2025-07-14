<?php
    require_once __DIR__."/../models/OrderModel.php";
    require_once __DIR__."/../helper/orderItemClass.php";
    require_once __DIR__."/../models/FoodItemModel.php";
    require_once __DIR__."/../models/UserModel.php";
    require_once __DIR__."/../helper/userClass.php";

    use Src\Helpers\FoodItem;
    use Src\Helpers\OrderItem;
    use Src\Helpers\OrderStatus;
    use Src\Helpers\UserClass;
    
    $error_message = "";
    $khalti_public_key = "cf985e5dadfb45de8b5a6601027e61b5";

    $amount = 0;
    $uniqueProductId = "";
    $uniqueUrl = "";
    $uniqueProductName = "";
    $successRedirect = "/review";


    // ------------------------------------------------------------------------
    // HINT : just change price above and redirect user to this page. It will handel everything automatically.
    // ------------------------------------------------------------------------

    function checkValid($data)
    {
        if((bool)$data["success"] === false){
                    echo json_encode(['success'=>false,'message'=>json_encode($data)]);
                    return;
                }
                    echo json_encode(['success'=>false,'message'=>'Error in checking payment validity.'.json_encode($data)]);

        $orderTrayId = 36; //$_SESSION['currentOrderTrayID']);
        $verifyAmount = getTotalPriceOfOrderTray($orderTrayId); // get amount from database and multiply by 100
        // $data contains khalti response. you can print it to view more details.
        // eg. $data["token] will give token & $data["amount] will give amount and more. see khalti docs for response format
        // $error_message="";
        // show error from above message
        try{
            if ((float) $data["amount"] == $verifyAmount) {
                return 1;
            } else {
                return 0;
            }

        }catch (Exception $e){
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

function sendPaymentDetails() {
    global $price, $amount, $khalti_public_key, $successRedirect;

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(['success' => false, 'message' => 'Invalid Request Method']);
        return;
    }

    $orderTrayId = 36; // TODO: use $_SESSION['currentOrderTrayID'] in production
    $phno = 9863591369; // TODO: use $_SESSION['phoneNumber'] in production

    $user = UserModel::getUserDetailsWithPhoneNumber($phno);
    if (!$user) {
        echo json_encode(['success' => false, 'message' => 'User not found']);
        return;
    }

    $data = json_decode(file_get_contents('php://input'), true);
    if (!isset($data["mobile"]) || !isset($data["mpin"])) {
        echo json_encode(['success' => false, 'message' => 'Required fields missing']);
        return;
    }

    $mobile = $data["mobile"];
    $mpin = $data["mpin"];
    $price = getTotalPriceOfOrderTray($orderTrayId);
    $amount = $price * 100; // Convert to paisa
    $vat = $amount * 0.3;
    $mp = $amount - $vat;

    $payload = [
        "return_url" => "http://localhost/Smartserve.com/api/confirm", // Must be a valid route
        "website_url" => "http://localhost/Smartserve.com/",
        "amount" => $amount,
        "purchase_order_id" => $orderTrayId,
        "purchase_order_name" => "Food Order",
        "customer_info" => [
            "name" => $user->firstName . " " . $user->lastName,
            "email" => $user->email,
            "phone" => $mobile
        ],
        "amount_breakdown" => [
            [
                "label" => "Mark Price",
                "amount" => $mp
            ],
            [
                "label" => "VAT",
                "amount" => $vat
            ]
        ],
        "product_details" => [
            [
                "identity" => "foodorder-$orderTrayId",
                "name" => "Order Tray #$orderTrayId",
                "total_price" => $amount,
                "quantity" => 1,
                "unit_price" => $amount
            ]
        ],
        "merchant_username" => "SmartServe",
        "merchant_extra" => "optional-meta-data",
        "public_key" => $khalti_public_key
    ];

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => 'https://dev.khalti.com/api/v2/epayment/initiate/',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($payload),
        CURLOPT_HTTPHEADER => [
            'Authorization: key live_secret_key_410b2202e0b24404aaaec11386c84b75',
            'Content-Type: application/json'
        ]
    ]);

    $response = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);

    if ($err) {
        echo json_encode(["success" => false, "message" => "cURL Error: $err"]);
        return;
    }

    $parsed = json_decode($response, true);

    if (isset($parsed["token"])) {
        echo json_encode([
            "success" => true,
            "message" => "Initiated successfully",
            "token" => $parsed["token"],
            "pidx" => $parsed["pidx"],
            "payment_url" => $parsed["payment_url"]
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "Khalti initiation failed", "error" => $parsed]);
    }
}



    function sendOTP(){
        global $khalti_public_key, $successRedirect;

        if($_SERVER['REQUEST_METHOD']!=='POST'){
            echo json_encode(['success'=>false,'message'=>'Invalid Request Method']);
            return;
        }

        
        $data = json_decode(file_get_contents('php://input'), true);

        // otp verification
        if (isset($data["otp"]) && isset($data["token"]) && isset($data["mpin"])) {
            try {
                $otp = $data["otp"];
                $token = $data["token"];
                $mpin = $data["mpin"];


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

                if (key_exists("token", $parsed) && key_exists("amount", $parsed) && key_exists("success", $parsed)) {
                    $isvalid = checkValid($parsed);
                    if ($isvalid) {
                        echo json_encode(['success'=>true, 'message'=>"Payment Successful", 'redirect'=>$successRedirect]);
                    }


                } else {
                    $error_message = "couldnot process the transaction at the moment.";
                    
                    echo json_encode(['success'=>false,'message'=>$error_message, 'erroes'=>$parsed]);
                    return;
                }
            } catch (Exception $e) {
                $error_message = "couldnot process the transaction at the moment.";
                echo json_encode(['success'=>false,'message'=>$error_message]);
                return;
            }


        }
    }
?>