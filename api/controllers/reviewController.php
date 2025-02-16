<?php
    require_once __DIR__.'/../models/OrderModel.php';
    require_once __DIR__.'/../helper/orderItemClass.php';
    use Src\Helpers\OrderItem;

    function AddReview(){
        if($_SERVER['REQUEST_METHOD']!=='POST'){
            echo json_encode(['success'=>false,'message'=>'Invalid Request Method']);
            return;
        }
        $data = json_decode(file_get_contents('php://input'), true);
        if(isset($data['OrderItem_ID'],$data['Rating'],$data['Review'])){
            $order = new OrderItem();
            $order->orderId = $data['OrderItem_ID'];
            $order->rating = $data['Rating'];
            $order->review = $data['Review'];

            //
            //user is 1 for now
            //
            $user = 1;

            $res = AddReviewToOrder($order,$user);
            if($res === true){
                echo json_encode(['success'=>true,'message'=>'Review Added Successfully']);
                return;
            }
            echo json_encode(['success'=>false,'message'=>$res]);
        }
    }
?>