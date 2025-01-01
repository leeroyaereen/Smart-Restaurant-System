
<?php
    require_once __DIR__."/../models/OrderModel.php";
    require_once __DIR__."/../helper/orderItemClass.php";

    use Src\Helpers\OrderItem;
    use Src\Helpers\OrderStatus;

    function getMonitorDetails(){
        $res = GetAllOrderDetailsForMonitoring();
        if(is_string($res)){
            echo json_encode(["success"=>false,"message"=>$res]);
            return;
        }
        echo json_encode(["success"=>true,"data"=>$res]);
    }
    function ChangeState(){
        // if($_SERVER['REQUEST_METHOD']!=='POST'){
        //     echo json_encode(['success'=>false,'message'=>'Invalid Request Method']);
        //     return;
        // }
        //sets data in variables associatively
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
?>