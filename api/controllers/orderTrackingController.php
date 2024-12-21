<?php
    require_once __DIR__.'/../helper/OrderItemClass.php';
    require_once __DIR__.'/../helper/OrderTrayClass.php';
    require_once __DIR__."/../models/OrderModel.php";

    use Src\Helpers\OrderItem;
    use Src\Helpers\OrderStatus;
    use Src\Helpers\OrderTray;

    function ChangeState(){
        if($_SERVER['REQUEST_METHOD']!=='POST'){
            echo json_encode(['success'=>false,'message'=>'Invalid Request Method']);
            return;
        }
        $data = json_decode(file_get_contents('php://input'), true);
        if(isset($data['OrderItem_ID'],$data['OrderStatus'])){
            //set values in the order item instance.
            $order = new OrderItem();
            $order->orderId = $data['OrderItem_ID'];
            $order->orderStatus = OrderStatus::from($data['OrderStatus']);

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

    function getOrderStatus(){
        //gives message and stops the flow if there is no order tray id
        if(!isset($_SESSION['currentOrderTrayID'])){
            echo json_encode(['success'=>false,'message'=>'No Foods Ordered.']);
            return;
        }
        

    }
?>