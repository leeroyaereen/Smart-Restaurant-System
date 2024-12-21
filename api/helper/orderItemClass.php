<?php
    namespace Src\Helpers;
    class OrderItem{
        public $orderId;
        public $orderTrayID;
        public $foodItemID;
        public $quantity;
        public OrderStatus $orderStatus = OrderStatus::InQueue;
        public $note;        
    }

    enum OrderStatus: string {
        case InQueue = "InQueue";
        case Preparing = "Preparing";
        case Ready = "Ready";
        case Served = "Served";
        case Cancelled = "Cancelled";
        case paid = "Paid";
    }
    
?>