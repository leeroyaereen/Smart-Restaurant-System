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
            $order->orderStatus = OrderStatus::Cancelled;

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

        $res = GetAllOrderItemDetailsForTracking( 1);
        if(is_string(value: $res) ){
            echo json_encode(['success'=>false,'message'=>$res]);

            return;
        }
        echo json_encode(['success'=>true,'message'=>'', "OrderedItems"=>$res]);

        

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
        $res = getOrderOnlyStatusData();
    }
?>