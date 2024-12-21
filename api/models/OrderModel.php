<?php
require_once __DIR__.'/../helper/OrderItemClass.php';
require_once __DIR__.'/../../config/databaseConnector.php';

use Src\Helpers\OrderItem;
use Src\Helpers\OrderTray;

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

function ChangeOrderStatus($orderItem){
    if($orderItem instanceof OrderItem){
        //set variable data
        $orderItemID = $orderItem->orderId;
        $orderStatus = $orderItem->orderStatus;
        
        $conn = getConnection();
        $sql = "UPDATE orderitem
                SET OrderStatus = ?
                WHERE OrderItem_ID = ? ";
        $stmt =$conn->prepare($sql);
        if(!$stmt){
            return "Failed to change status";
        }
        $stmt->bind_param("si",$orderStatus,$orderItemID);
        $res = $stmt->execute();

        if(!$res){
            return "Failed to change status in records";
        }
        return true;

    }else{
        return "Wrong instance of the class";
    }
}

function GetAllOrderItemDetailsForTracking($orderTrayID){
     $conn = getConnection();
     $sql ="SELECT fooditems.FoodItem_ID,fooditems.FoodName,fooditems.FoodType,orderitem.Quantity,fooditems.FoodPrice,orderitem.Note,fooditems.FoodPreparationTime, orderitem.OrderStatus 
            FROM orderitem
            INNER JOIN fooditems
            ON orderitem.FoodItem_ID = fooditems.FoodItem_ID";
    $res = mysqli_query($conn,$sql);
    if(!$res){
        return "Connection Error";

    }
    $orderDetails = [];
    if($res->num_rows>0){
        $count = 0;
        while($data = mysqli_fetch_assoc($res)){
            $orderDetails[$count]=[
                "FoodItem_ID" => $data["FoodItem_ID"],
                "FoodName" => $data["FoodName"],
                "FoodType" => $data["FoodType"],
                "Quantity" => $data["Quantity"],
                "FoodPrice" => $data["FoodPrice"],
                "Note" => $data["Note"],
                "FoodPreparationTime" => $data["FoodPreparationTime"],
                "OrderStatus" => $data["OrderStatus"]
            ];
        }
    }
    return $orderDetails;
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
                GROUP_CONCAT(orderitem.OrderStatus) AS OrderStatuses
            FROM orderitem
            INNER JOIN fooditems
            ON orderitem.FoodItem_ID = fooditems.FoodItem_ID
            INNER JOIN ordertray
            ON  orderitem.OrderTray_ID = ordertray.OrderTray_ID
            GROUP BY ordertray.OrderTray_ID";
}
?>

SELECT Customers.CustomerName, Orders.Product
FROM Customers
INNER JOIN Orders ON Customers.CustomerID = Orders.CustomerID;