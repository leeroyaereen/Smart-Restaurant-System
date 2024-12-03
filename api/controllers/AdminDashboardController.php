<?php
    use Src\Helpers\FoodItem;
    require_once __DIR__.'/../models/FoodItemModel.php';

    function CreateFoodItem(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $foodItemDetails = json_decode(file_get_contents("php://input"), true);
            if(!$foodItemDetails){
                echo json_encode(['success'=>false, 'message'=>'Invalid data']);
                return;
            }
            if(!$foodItemDetails){
                echo json_encode(['success'=>false, 'message'=>'Invalid data']);
                return;
            }
            $foodItem = new FoodItem();
            $foodItem->FoodName = $foodItemDetails['foodName'];
            $foodItem->FoodPrice = $foodItemDetails['foodPrice'];
            $foodItem->FoodPreparationTime = $foodItemDetails['foodPreparationTime'];
            $foodItem->FoodCategory = $foodItemDetails['foodCategory'];
            $foodItem->FoodDescription = $foodItemDetails['foodDescription'];

            $result = AddFoodItem($foodItem);
            if($result===true){
                echo json_encode(['success'=>true, 'message'=>'Food Item added successfully']);
            }else{
                echo json_encode(['success'=>false, 'message'=>'Failed to add food item'.$result]);
            }
        }
    }
?>