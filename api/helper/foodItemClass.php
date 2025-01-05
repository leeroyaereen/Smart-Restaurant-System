<?php

    namespace Src\Helpers;
    class FoodItem{
        public $FoodItem_ID = 00000;
        public $FoodName = "Unnamed";
        public $FoodType = "";
        public $FoodCategory = 1;
        public $FoodRating = 0.0;
        public $FoodPreparationTime = 30;
        public $FoodReview = "No Food Review";
        public $FoodDescription = "No Description";
        public $FoodImage = "";
        public $FoodPrice = 0;
        public $FoodAvailability = true;
        public $TotalOrders = 0;

        public function SetImageAddress(){
            $this->FoodImage = BASE_PATH . "/public/assets/images/". $this->FoodName.$this->FoodType.$this->FoodItem_ID;
        }
    }
?>