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


        if ($stmt->execute()) {
            
        } else {
            return "Error: " . $stmt->error;
        }
        $stmt->close();
        return true;
    }
}

?>