<?php
require_once __DIR__ . "/../models/OrderModel.php";
require_once __DIR__ . "/../helper/orderItemClass.php";
require_once __DIR__ . "/../models/FoodItemModel.php";
require_once __DIR__ . "/../models/UserModel.php";
require_once __DIR__ . "/../helper/userClass.php";

define("KHALTI_PUBLIC_KEY", "key 1b45741c745244a09eee5d86f7764a47");
define("KHALTI_SECRET_KEY", "key 410b2202e0b24404aaaec11386c84b75");

class KhaltiPaymentHandler {
    private $error_message = "";
    private $amount = 0;
    private $uniqueProductId = "";
    private $uniqueUrl = "";
    private $uniqueProductName = "";
    private $successRedirect = "https://smartserve.com/success";
    private $token = "";
    private $price = 0;
    private $mpin = "";

    public function getPaymentID() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid Request Method']);
            return;
        }

        $orderTrayId = 36; // $_SESSION['currentOrderTrayID']
        $phno = 9863591369; // $_SESSION['phoneNumber']

        $user = UserModel::getUserDetailsWithPhoneNumber($phno);

        if (!$user) {
            echo json_encode(['success' => false, 'message' => 'User not found']);
            return;
        }

        // $data = json_decode(file_get_contents('php://input'), true);
        // if (!isset($data["mobile"]) || !isset($data["mpin"])) {
        //     echo json_encode(['success' => false, 'message' => 'Required fields missing']);
        //     return;
        // }

        $this->price = getTotalPriceOfOrderTray($orderTrayId);
        $this->amount = $this->price * 100;
        $vat = $this->amount * 0.3;
        $mp = $this->amount - $vat;

        $payload = [
            "return_url" => $this->successRedirect,
            "website_url" => "https://smartserve.com",
            "amount" => $this->amount,
            "purchase_order_id" => $orderTrayId,
            "purchase_order_name" => "Food Order",
            "customer_info" => [
                "name" => $user->getFullName(),
                "email" => $user->getEmail(),
                "phone" => $phno,
            ],
            "amount_breakdown" => [
                ["label" => "Mark Price", "amount" => $mp],
                ["label" => "VAT", "amount" => $vat]
            ],
            "product_details" => [
                [
                    "identity" => "foodorder-$orderTrayId",
                    "name" => "Order Tray #$orderTrayId",
                    "total_price" => $this->amount,
                    "quantity" => 1,
                    "unit_price" => $this->amount
                ]
            ],
            "merchant_username" => "SmartServe",
            "merchant_extra" => "optional-meta-data",
            "public_key" => KHALTI_PUBLIC_KEY
        ];

        //echo json_encode($payload); // Debug purpose

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => 'https://dev.khalti.com/api/v2/epayment/initiate/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => [
                'Authorization: key 410b2202e0b24404aaaec11386c84b75',
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

        if (isset($parsed["pidx"]) && isset($parsed["payment_url"])) {
            $_SESSION['pidx'] = $parsed["pidx"];
            echo json_encode([
                "success" => true,
                "message" => "Initiated successfully",
                "pidx" => $parsed["pidx"],
                "payment_url" => $parsed["payment_url"],
                "expires_at" => $parsed["expires_at"],
                "expires_in" => $parsed["expires_in"]
            ]);
        } else {
            echo json_encode(["success" => false, "message" => "Khalti initiation failed", "error" => $parsed]);
        }
    }

    public function confirmPayment()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            echo json_encode(['success' => false, 'message' => 'Invalid Request Method']);
            return;
        }

        if (!isset($_GET['pidx'])) {
            echo json_encode(['success' => false, 'message' => 'Missing pidx']);
            return;
        }

        $pidx = $_GET['pidx'];
        $payload = json_encode(['pidx' => $pidx]);

        $ch = curl_init('https://dev.khalti.com/api/v2/epayment/lookup/');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => [
                'Authorization: key ' . KHALTI_SECRET_KEY,
                'Content-Type: application/json'
            ]
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);
        
        switch ($data['status'] ?? '') {
            case 'Completed':
                echo json_encode([
                    'success' => true,
                    'message' => 'Payment verified successfully',
                    'order_id' => $data['purchase_order_id'],
                    'amount' => $data['total_amount'],
                    'transaction_id' => $data['transaction_id']
                ]);
                break;

            case 'Pending':
                echo json_encode([
                    'success' => false,
                    'message' => 'Payment is Pending',
                    'status' => $data['status'],
                    'error_data' => $data
                ]);
                break;

            default:
                echo json_encode([
                    'success' => false,
                    'message' => 'Payment not completed',
                    'status' => $data['status'] ?? 'Unknown',
                    'error_data' => $data
                ]);
        }
    }

    private function checkValid($data)
    {
        if (empty($data["success"])) {
            return false;
        }

        $orderTrayId = 36; // Replace with dynamic order ID retrieval
        $verifyAmount = getTotalPriceOfOrderTray($orderTrayId) * 100;

        return ((float)$data["amount"] === (float)$verifyAmount);
    }
}

$handler = new KhaltiPaymentHandler();
