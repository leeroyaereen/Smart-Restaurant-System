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
            $TrayItems = $data['TrayItems'];
            
            $user = 1;
            $newOrderTray = new OrderTray;
            $newOrderTray->userID = $user;
            $newOrderTray->kitchenOrderTime = date("Y-m-d H:i:s");//current time stamp
            $res = RegisterNewTrayData($newOrderTray);
            if($res !==true){
                echo json_encode(['success'=>false,'message'=>'Tray Items Not Set'.$res]);
                return;
            }
            foreach($TrayItems as $order){
                $newOrder = new OrderItem;
                $newOrder->foodItemID = $order['FoodItem_ID'];
                $newOrder->quantity = $order['Quantity'];
                $newOrder->note = $order['Note'];
                $newOrder->orderTrayID = $newOrderTray->orderTrayID;
                $newOrder->orderStatus = OrderStatus::InQueue;
                $res = RegisterNewOrder($newOrder);
                if($res !== true){
                    echo json_encode(['success'=>false,'message'=>'Tray Items Not Set'.$res]);
                    return;
                }
            }

            echo json_encode(['success'=>true,'message'=>'Tray Items Set Successfully']);
        }else{
            echo json_encode(['success'=>false,'message'=>'Tray Items Not Set because of emty data']);
        }
    }
?>