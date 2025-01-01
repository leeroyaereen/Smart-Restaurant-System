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

    namespace Src\Helpers;
    enum OrderStatus: string {
        case InQueue = "InQueue";
        case Preparing = "Preparing";
        case Ready = "Ready";
        case Served = "Served";
        case Cancelled = "Cancelled";
        case Paid = "Paid";

        case Closed = "Closed";

        public static function fromString(string $status): ?OrderStatus {
            return OrderStatus::tryFrom($status);
        }
    }
    
?>