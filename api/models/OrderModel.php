<?php
require_once __DIR__.'/../helper/OrderItemClass.php';
require_once __DIR__.'/../../config/databaseConnector.php';

use Src\Helpers\OrderItem;
use Src\Helpers\OrderTray;
use Src\Helpers\OrderStatus;

function RegisterNewTrayData($newTray){
    if($newTray instanceof OrderTray){
        $connection = changeDatabaseConnection('ACHS Canteen');
        if(!$connection){
            return "Unable to connect to the database";
        }
        $stmt = $connection->prepare("INSERT INTO ordertray (User_ID, KitchenOrderTime) VALUES (?, ?)");
        $stmt->bind_param("is", $newTray->userID, $newTray->kitchenOrderTime);


        if ($stmt->execute()) {
            //get the id of the recently added tray
            $lastInsertedId = $stmt->insert_id;
            $newTray->orderTrayID = $lastInsertedId;
        } else {
            return "Error: " . $stmt->error;
        }
        $stmt->close();
        return true;
    }
}

function RegisterNewOrder($newOrders){
    if($newOrders instanceof OrderItem){
        $connection = changeDatabaseConnection('ACHS Canteen');
        if(!$connection){
            return "Unable to connect to the database";
        }
        $orderStatus = $newOrders->orderStatus->value;
        $stmt = $connection->prepare("INSERT INTO orderitem (OrderTray_ID, FoodItem_ID, Quantity, OrderStatus, Note) VALUES (?,?,?,?,?)");
        $stmt->bind_param("iiiss", $newOrders->orderTrayID,$newOrders->foodItemID, $newOrders->quantity, $orderStatus , $newOrders->note);


        if (!$stmt->execute()) {
            return "Error: " . $stmt->error;
        }
        $stmt->close();
        return true;
    }
}

function ChangeOrderStatus($orderItem) {
    if ($orderItem instanceof OrderItem) {
        // Set variable data
        $orderItemID = $orderItem->orderId;
        $orderStatus = $orderItem->orderStatus;

        if (!$orderStatus instanceof OrderStatus) {
            return "Invalid OrderStatus enum value".$orderStatus;
        }
        $orderStatusValue = $orderStatus->value;
        $conn = getConnection();
        $checkSql = "SELECT * FROM orderitem WHERE OrderItem_ID = ".$orderItemID." AND OrderStatus = 'Cancelled'";
        $res = $conn->query($checkSql);
        if(!$res){
            return "Failed to execute query";
        }
        if($res->num_rows>0){
            return "The order item is cancelled already";
        }
        $sql = "UPDATE orderitem
                SET OrderStatus = ?
                WHERE OrderItem_ID = ?";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            return "Failed to prepare statement";
        }

        // Use the value of the backed enum
        $stmt->bind_param("si", $orderStatusValue, $orderItemID);
        $res = $stmt->execute();

        if (!$res) {
            return "Failed to change status in records";
        }
        
        return true;
    } else {
        return "Wrong instance of the class";
    }
}

function GetAllOrderItemDetailsForTracking($userID){
     $conn = getConnection();
     $sql ="SELECT orderitem.OrderItem_ID,
                    fooditems.FoodItem_ID,
                    fooditems.FoodName,
                    fooditems.FoodType,
                    orderitem.Quantity,
                    fooditems.FoodPrice,
                    orderitem.Note,
                    fooditems.FoodPreparationTime, 
                    orderitem.OrderStatus 
            FROM orderitem
            
            INNER JOIN fooditems
            ON orderitem.FoodItem_ID = fooditems.FoodItem_ID 

            INNER JOIN ordertray
            ON orderitem.OrderTray_ID = ordertray.OrderTray_ID

            
            WHERE ordertray.User_ID = 1 && orderitem.OrderStatus <> 'Cancelled'  && orderitem.OrderStatus <> 'Closed'
            ORDER BY orderitem.OrderItem_ID"
            ;
    $res = mysqli_query($conn,$sql);
    if(!$res){
        return "Connection Error";

    }
    $orderDetails = [];
    if($res->num_rows>0){
        $count = 0;
        while($data = mysqli_fetch_assoc($res)){
            $orderDetails[$count]=[
                "OrderItem_ID" => $data["OrderItem_ID"],
                "FoodItem_ID" => $data["FoodItem_ID"],
                "FoodName" => $data["FoodName"],
                "FoodType" => $data["FoodType"],
                "Quantity" => $data["Quantity"],
                "FoodPrice" => $data["FoodPrice"],
                "Note" => $data["Note"],
                "FoodPreparationTime" => $data["FoodPreparationTime"],
                "OrderStatus" => $data["OrderStatus"]
            ];
            $count++;
        }
        return $orderDetails;

    }else{
        return 'No Food has been ordered';
    }
}
function GetOrderTrayBasedOrderItemDetailsForTracking($orderTrayID){
    $conn = getConnection();
    $sql ="SELECT orderitem.OrderItem_ID,fooditems.FoodItem_ID,fooditems.FoodName,fooditems.FoodType,orderitem.Quantity,fooditems.FoodPrice,orderitem.Note,fooditems.FoodPreparationTime, orderitem.OrderStatus 
           FROM orderitem
           
           INNER JOIN fooditems
           ON orderitem.FoodItem_ID = fooditems.FoodItem_ID WHERE orderitem.orderTray_ID = ".$orderTrayID.""
           ;
   $res = mysqli_query($conn,$sql);
   if(!$res){
       return "Connection Error";

   }
   $orderDetails = [];
   if($res->num_rows>0){
       $count = 0;
       while($data = mysqli_fetch_assoc($res)){
           $orderDetails[$count]=[
               "OrderItem_ID" => $data["OrderItem_ID"],
               "FoodItem_ID" => $data["FoodItem_ID"],
               "FoodName" => $data["FoodName"],
               "FoodType" => $data["FoodType"],
               "Quantity" => $data["Quantity"],
               "FoodPrice" => $data["FoodPrice"],
               "Note" => $data["Note"],
               "FoodPreparationTime" => $data["FoodPreparationTime"],
               "OrderStatus" => $data["OrderStatus"]
           ];
           $count++;
       }
       return $orderDetails;

   }else{
       return 'No Food has been ordered';
   }
}
function GetAllOrderDetailsForMonitoring(){
    $conn = getConnection();
    // $sql = "SELECT ordertray.OrderTray_ID, ordertray.KitchenOrderTime, ordertray.User_ID, 
    //                 orderitem.OrderItem_ID,fooditems.FoodName, fooditems.FoodType, orderitem.Note, fooditems.FoodPrice, orderitem.OrderStatus
    //         FROM orderitem
    //         INNER JOIN fooditems
    //         ON orderitem.FoodItem_ID = fooditems.FoodItem_ID
    //         INNER JOIN ordertray
    //         ON  orderitem.OrderTray_ID = ordertray.OrderTray_ID
    //         GROUP BY ordertray.OrderTray_ID";

    $sql = "SELECT ordertray.OrderTray_ID, ordertray.KitchenOrderTime, ordertray.User_ID, 
                GROUP_CONCAT(orderitem.OrderItem_ID)AS OrderID,
                GROUP_CONCAT(fooditems.FoodName) AS FoodNames,
                GROUP_CONCAT(fooditems.FoodType) AS FoodTypes,
                GROUP_CONCAT(orderitem.Note) AS Notes,
                GROUP_CONCAT(fooditems.FoodPrice) AS Prices,
                GROUP_CONCAT(orderitem.OrderStatus) AS OrderStatuses,
                GROUP_CONCAT(orderitem.Quantity) AS Quantity,
                COUNT(*)
            FROM orderitem
            INNER JOIN fooditems
            ON orderitem.FoodItem_ID = fooditems.FoodItem_ID
            INNER JOIN ordertray
            ON  orderitem.OrderTray_ID = ordertray.OrderTray_ID
            GROUP BY ordertray.OrderTray_ID
            ";
    $res = $conn->query($sql);
    $items = [];
    if($res->num_rows>0){
        while($item = $res->fetch_assoc()){
            $c =$item['COUNT(*)'];
            $arrangedData = [];

            $orderIDs = explode(",",$item['OrderID'],$c);
            $foodNames = explode(",",$item['FoodNames'],$c);
            $foodTypes = explode(",",$item['FoodTypes'],$c);
            $notes = explode(",",$item['Notes'],$c);
            $prices = explode(",",$item['Prices'],$c);
            $orderStatuses = explode(",",$item['OrderStatuses'],$c);
            $quantity = explode(",",$item['Quantity'],$c);
            for($i = 0 ; $i < $c; $i++){
                if(OrderStatus::fromString($orderStatuses[$i])!=OrderStatus::Closed) {
                    $arrangedData[] = ["OrderItem_ID"=>$orderIDs[$i], "FoodName"=>$foodNames[$i], "FoodTypes" => $foodTypes[$i], "Notes" => $notes[$i], "Price" => $prices[$i], "OrderStatus" => $orderStatuses[$i]];
            
                }
            }
            if(count($arrangedData)<1) continue;
            $obj = ["OrderTray_ID" => $item['OrderTray_ID'], "KitchenOrderTime"=> $item["KitchenOrderTime"], "User_ID" => $item['User_ID'], "Orders"=> $arrangedData, "Quantity"=> $quantity];
            $items[] = $obj;
        }
        if(sizeof($items)<1){
            return "No orders pending";
        }
        return $items;
    }else{
        return "No data available";
    }
}

function getOrderOnlyStatusData(){
    
}
?>
