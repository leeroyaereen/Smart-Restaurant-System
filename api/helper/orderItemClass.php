<?php
    namespace Src\Helpers;
    class OrderItem{
        public $orderId;
        public $orderTrayID;
        public $foodItemID;
        public $quantity;
        public OrderStatus $orderStatus = OrderStatus::InQueue;
        public $note;     
        public $review;
        public $rating;   
    }

    namespace Src\Helpers;
    enum OrderStatus: string {
        case InQueue = "InQueue";
        case Preparing = "Preparing";
        case Ready = "Ready";
        case Served = "Served";
        case Cancelled = "Cancelled";
        case Closed = "Closed";
        case Paid = "Paid";

        public static function fromString(string $status): ?OrderStatus {
            return OrderStatus::tryFrom($status);
        }
    }
    
?>