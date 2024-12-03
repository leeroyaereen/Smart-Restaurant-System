<?php
    namespace Src\Helpers;
    class OrderItem{
        public $orderId;
        public $orderTrayID;
        public $foodItemID;
        public $quantity;
        public OrderStatus $orderStatus;
        public $note;
    }

    enum OrderStatus {
        case InQueue;
        case Preparing;
        case Ready;
        case Served;
        case Cancelled;
        case paid;
    }
    
?>