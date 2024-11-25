<?php

    require '../middleware/databaseConnector.php';
    require_once '../helpers/foodItemClass.php'; 

    use Src\Helpers\FoodItem;

   function GetJSONOfFoodItems(){
        global $connection;
        $foodItems = [];

        // if (!class_exists('FoodItem')) {
        //     return json_encode(["success" => false, "message" => "Still class doesnot exist"]);
        // }
        
        $sqlFoodItems = "SELECT * FROM FoodItems";
        $resFoodItems = $connection->query($sqlFoodItems);

        //incase the query doesnt work
        if(!$resFoodItems){

            return json_encode(["success" => false, "message" => "Query Not Working"]);
        }
        //incase there are no datas available
        if(!$resFoodItems->num_rows>0){
            
            return json_encode(["success" => false, "message" => "No food item data in database"]);
        }
        // Fetching all food items
        while ($item = mysqli_fetch_assoc($resFoodItems)) {
            $foodItem = new FoodItem;
            $foodItem->FoodItem_ID = $item['FoodItem_ID'];
            $foodItem->FoodName = $item['FoodName'];
            $foodItem->FoodType = $item['FoodType'];
            $foodItem->FoodCategory = $item['Category_ID'];
            $foodItem->FoodRating = $item['FoodRating'];
            $foodItem->FoodPreparationTime = $item['FoodPreparationTime'];
            $foodItem->FoodReview = $item['FoodReview'];
            $foodItem->FoodDescription = $item['FoodDescription'];
            $foodItem->FoodImage = $item['FoodImage'];
            $foodItem->FoodPrice = $item['FoodPrice'];
            $foodItem->FoodAvailability = $item['FoodAvailability'];
            $foodItem->TotalOrders = $item['TotalOrders'];

            $foodItems[] = $foodItem;
        }

        return json_encode(["success" => true, "message" => "Working Good","foodItems"=>$foodItems]);

    }

    function GetJSONOfFoodCategoriess(){
        global $connection;
        $foodCategories=[];

        $sqlFoodCategories = "SELECT * FROM FoodCategory";
        $resFoodCategories = $connection->query($sqlFoodCategories);
    
        //incase the query doesnt work
        if(!$resFoodCategories){
            return json_encode(["success" => false, "message" => "Query Not Working"]);
;
        }
      
        if(!$resFoodCategories->num_rows>0){
            return json_encode(["success" => false, "message" => "No food category data in database"]);

        }
    
        // Fetching all food categories
        while ($category = mysqli_fetch_assoc($resFoodCategories)) {
            $foodCategories[$category['Category_ID']] = $category['CategoryName'];
        }
    
        return json_encode(["success" => true, "message" => "Enjoy food categories","foodCategories"=>$foodCategories]);
    }
?>