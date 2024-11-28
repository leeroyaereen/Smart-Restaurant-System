<?php
    require '../models/FoodItemModel.php';
    require_once '../helpers/foodItemClass.php';
    use Src\Helpers\FoodItem;

    function CreateFoodCategory(){
        //Check if the user has the access to add food Category

        //get the input from the user
        $json = file_get_contents('php://input');
        $data = json_decode($json,true);

        //check error in json invalid format
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode(["status" => "failure", "message" => "Invalid JSON"]);
            return;
        }

        $foodName = $data['foodName']??null;
        if($foodName==null){
            echo json_encode(["status" => "failure", "message" => "the data provided should not be null"]);
 
            return;
        }
        $res = AddCategory($foodName);
        if($res === true){
            echo json_encode(["status" => "success", "message" => "New Food Category has been added"]);
        }else{
            echo json_encode(["status"=>'failure',"message"=>$res]);
        }
   
    }

    function RemoveFoodCategory(){
        //Check if the user has the access to add food Category

        //get the input from the user
        $json = file_get_contents('php://input');
        $data = json_decode($json,true);

        //check error in json invalid format
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode(["status" => "failure", "message" => "Invalid JSON"]);
            return;
        }

        $foodName = $data['foodName']??null;
        if($foodName==null){
            echo json_encode(["status" => "failure", "message" => "the data provided should not be null"]);
            return;
        }
        $res = RemoveCategoryData($foodName);
        if($res === true){
            echo json_encode(["status" => "success", "message" => "New Food Category has been removed succsfully"]);
        }else{
            echo json_encode(["status"=>'failure',"message"=>$res]);
        }
    }

    function CreateNewRestaurant(){
        
        //get the input from the user
        $json = file_get_contents('php://input');
        $data = json_decode($json,true);

        //check error in json invalid format
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode(["status" => "failure", "message" => "Invalid JSON"]);
            return;
        }

        $restuarantName = $data['restaurantName']??null;

        
        if($restuarantName!=null){
            $res = CreateNewDatabaseForRestaurant($restuarantName);
            if($res !== true){
                echo json_encode(["status" => "failure", "message" => $res]);
                return;
            }
            $res = CreateTablesForRestaurant($restuarantName);
            if($res !== true){
                echo json_encode(["status" => "failure", "message" => $res]);
                return;
            }
            echo json_encode(["status" => "success", "message" => "Created New Restaurant Successfully with table"]);
            return;
        }else{
            echo json_encode(["status" => "failure", "message" => "The provided restaurant name should not be empty"]);

        }
    }

    function CreateFoodItem(){ 

        $json = file_get_contents('php://input');
        $data = json_decode($json,true);

        //check error in json invalid format
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode(["status" => "failure", "message" => "Invalid JSON"]);
            return;
        }
        $newFood = new FoodItem();
        $newFood->foodName = $data['foodName']??null;
        $newFood->FoodType = $data['foodType'];
        $newFood->FoodCategory = $data['foodCategory'];
        $newFood->FoodPreparationTime = $data['foodPreparationTime'];
        $newFood->FoodPrice = $data['foodPrice'];
        $newFood->FoodImage = $data['foodImage'];
        $newFood->FoodDescription = $data['foodDescription'];
        $newFood->FoodReview = "No Reviews Yet";
        $newFood->FoodAvailability = true;
        $newFood->FoodRating = 0;        
         if($newFood->FoodName ==null 
            ||
            $newFood->FoodType ==null 
            ||
            $newFood->FoodCategory ==null 
            ||
            $newFood->FoodPreparationTime ==null 
            ||
            $newFood->FoodPrice ==null 
            ||
            $newFood->FoodImage ==null 
            ||
            $newFood->FoodDescription){
            echo json_encode(["status" => "failure", "message" => "The provided data should not be empty"]);
        }
        $res =AddFoodItem($newFood);

        if($res===true){
            echo json_encode(["status" => "success", "message" => "New Food Item has been added to tbe database"]);

        }else{
            echo json_encode(["status" => "failure", "message" => $res]);
        }
    }

    function RemoveFoodItem(){
        $json = file_get_contents('php://input');
        $data = json_decode($json,true);

        //check error in json invalid format
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode(["status" => "failure", "message" => "Invalid JSON"]);
            return;
        }

        $foodItem = $data['FoodItem_ID']??null;
        if($foodItem==null){
            echo json_encode(["status" => "failure", "message" => "No Food Id provided"]);
            return;
        }
        RemoveFoodItemData($foodItem);


        
    }
?>