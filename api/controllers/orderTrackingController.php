<?php
    require_once __DIR__.'/../helper/OrderItemClass.php';
    require_once __DIR__.'/../helper/OrderTrayClass.php';
    require_once __DIR__."/../models/OrderModel.php";

    use Src\Helpers\OrderItem;
    use Src\Helpers\OrderStatus;
    use Src\Helpers\OrderTray;

    function CancelOrder(){
        // if($_SERVER['REQUEST_METHOD']!=='POST'){
        //     echo json_encode(['success'=>false,'message'=>'Invalid Request Method']);
        //     return;
        // }
        //sets data in variables associatively
        $data = json_decode(file_get_contents('php://input'), true);
        
        if(isset($data['OrderItem_ID'])){
            //set values in the order item instance.
            $order = new OrderItem();
            $order->orderId = $data['OrderItem_ID'];
            $order->orderStatus = OrderStatus::fromString('Cancelled');

            //send to database about the modification
            $res = ChangeOrderStatus($order);
            if($res === true){
                echo json_encode(['success'=>true,'message'=>'Order Item Status Changed Successfully']);
                return;
            }
            echo json_encode(['success'=>false,'message'=>$res]);
        }else{
            echo json_encode(['success'=>false,'message'=>'Tray Items Not Set because of empty data']);
        }
    }

    function getAllOrderStatus(){
        
        //Requires Fetching userid from session

        // function getOrderTrayIDFromClientInput(){
        //     $data = json_decode(file_get_contents('php://input'), true);
        //     if(isset($data['OrderTray_ID'])){
        //         return $data['OrderTray_ID'];
        //     }
        //     return null;
        // }
        // //gives message and stops the flow if there is no order tray id
        // if(!isset($_SESSION['currentOrderTrayID'])){
        //     $orderTrayId = getOrderTrayIDFromClientInput();
        //     if(!$orderTrayId){
        //         echo json_encode(['success'=>false,'message'=>'No Foods Ordered.']);
        //         return;
        //     }
            
            
        // }else{
        //     $orderTrayId = $_SESSION['currentOrderTrayID'];
        // }
        $userID = null;
        if (isset($_SESSION['User_ID'])) {
            $userID = $_SESSION['User_ID'];
        } elseif (isset($userIDFromPayload)) { // Check if payload has phone
             $data = json_decode(file_get_contents('php://input'), true);
             if(isset($data['phone'])){
                 $userID = UserModel::getUserIdByPhoneNumber($data['phone']);
             }
        }
        
        // If still null, try one more time if we haven't decoded input yet
        if(!$userID){
             $data = json_decode(file_get_contents('php://input'), true);
             if(isset($data['phone'])){
                 $userID = UserModel::getUserIdByPhoneNumber($data['phone']);
             }
        }

        if(!$userID){
             echo json_encode(['success'=>false,'message'=>'User Not Logged In']);
             return;
        }

        $res = GetAllOrderItemDetailsForTracking($userID );
        if(is_string(value: $res) ){
            echo json_encode(['success'=>false,'message'=>$res]);

            return;
        }
        echo json_encode(['success'=>true,'message'=>'', "OrderedItems"=>$res]);
    }

    function getAllUserActiveOrderStatus(){
       
        $userID = null;
        if (isset($_SESSION['User_ID'])) {
            $userID = $_SESSION['User_ID'];
        } else {
             $data = json_decode(file_get_contents('php://input'), true);
             if(isset($data['phone'])){
                 $userID = UserModel::getUserIdByPhoneNumber($data['phone']);
             }
        }

        if(!$userID){
             echo json_encode(['success'=>false,'message'=>'User Not Logged In']);
             return;
        }

        $res = GetAllOrderDetailsForStatusOfUser($userID );
        if(is_string(value: $res) ){
            echo json_encode(['success'=>false,'message'=>$res]);

            return;
        }
        echo json_encode(['success'=>true,'message'=>'', "OrderTrays"=>$res]);
    }

    function getAllOrderStatusFromOrderTray(){
        function getOrderTrayIDFromClientInput(){
            $data = json_decode(file_get_contents('php://input'), true);
            if(isset($data['OrderTray_ID'])){
                return $data['OrderTray_ID'];
            }
            return null;
        }
        //gives message and stops the flow if there is no order tray id
        if(!isset($_SESSION['currentOrderTrayID'])){
            $orderTrayId = getOrderTrayIDFromClientInput();
            if(!$orderTrayId){
                echo json_encode(['success'=>false,'message'=>'No Foods Ordered.']);
                return;
            }
            
            
        }else{
            $orderTrayId = $_SESSION['currentOrderTrayID'];
        }

        $res = GetOrderTrayBasedOrderItemDetailsForTracking( $orderTrayId);
        if(is_string(value: $res) ){
            echo json_encode(['success'=>false,'message'=>$res]);

            return;
        }
        echo json_encode(['success'=>true,'message'=>'', "OrderedItems"=>$res]);
    }
    
    function getOnlyStatus(){
        $userID = null;
        if (isset($_SESSION['User_ID'])) {
            $userID = $_SESSION['User_ID'];
        } else {
             $data = json_decode(file_get_contents('php://input'), true);
             if(isset($data['phone'])){
                 $userID = UserModel::getUserIdByPhoneNumber($data['phone']);
             }
        }

        if(!$userID){
             echo json_encode(['success'=>false,'message'=>'User Not Logged In']);
             return;
        }
        $res = getOnlyStatusData($userID);
        if(is_string(value: $res) ){
            echo json_encode(['success'=>false,'message'=>$res]);
            return;
        }
        echo json_encode(['success'=>true,'message'=>'', "OrderedItems"=>$res]);
    }

    function getTotalAmount(){
        $userID = null;
        if (isset($_SESSION['User_ID'])) {
            $userID = $_SESSION['User_ID'];
        } else {
             $data = json_decode(file_get_contents('php://input'), true);
             if(isset($data['phone'])){
                 $userID = UserModel::getUserIdByPhoneNumber($data['phone']);
             }
        }

        if(!$userID){
             echo json_encode(['success'=>false,'message'=>'User Not Logged In']);
             return;
        }
        
        $orderTrayId = null;
        if (isset($_SESSION['currentOrderTrayID'])) {
            $orderTrayId = $_SESSION['currentOrderTrayID'];
        } else {
            $orderTrayId = getActiveOrderTrayIdByUserId($userID);
        }

        if(!$orderTrayId){
             echo json_encode(['success'=>false,'message'=>'Active Order Tray Not Found']);
             return;
        }

        $res = getTotalPriceOfOrderTray($orderTrayId, $userID);
        if(is_string(value: $res) ){
            echo json_encode(['success'=>false,'message'=>$res]);
            return;
        }
        echo json_encode(['success'=>true,'message'=>'', "TotalAmount"=>$res]);
    }

    function getOrderTrayForBilling(){
        $userID = null;
        if (isset($_SESSION['User_ID'])) {
            $userID = $_SESSION['User_ID'];
        } else {
             $data = json_decode(file_get_contents('php://input'), true);
             if(isset($data['phone'])){
                 $userID = UserModel::getUserIdByPhoneNumber($data['phone']);
             }
        }

        if(!$userID){
             echo json_encode(['success'=>false,'message'=>'User Not Logged In']);
             return;
        }

        $orderTrayId = null;
        if (isset($_SESSION['currentOrderTrayID'])) {
            $orderTrayId = $_SESSION['currentOrderTrayID'];
        } else {
            $orderTrayId = getActiveOrderTrayIdByUserId($userID);
        }

        if(!$orderTrayId){
             echo json_encode(['success'=>false,'message'=>'Active Order Tray Not Found']);
             return;
        }

        $res = getOrderTrayDetailForBilling($orderTrayId, $userID);
        if(is_string(value: $res) ){
            echo json_encode(['success'=>false,'message'=>$res]);
            return;
        }
        echo json_encode(['success'=>true,'message'=>'', "OrderTray"=>$res]);
    }
?>