<?php

    require '../middleware/databaseConnector.php';
    require_once '../helpers/foodItemClass.php'; 

    use Src\Helpers\FoodItem;

   function GetFoodItems(){
        global $connection;
        $foodItems = [];

        // if (!class_exists('FoodItem')) {
        //     return json_encode(["success" => false, "message" => "Still class doesnot exist"]);
        // }
        
        $sqlFoodItems = "SELECT * FROM FoodItems";
        $resFoodItems = $connection->query($sqlFoodItems);

        //incase the query doesnt work
        if(!$resFoodItems){

            return  "Query Not Working";
        }
        //incase there are no datas available
        if(!$resFoodItems->num_rows>0){
            
            return "No food item data in database";
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

        return $foodItems;
    }

    function GetFoodCategoriess(){
        global $connection;
        $foodCategories=[];

        $sqlFoodCategories = "SELECT * FROM FoodCategory";
        $resFoodCategories = $connection->query($sqlFoodCategories);
    
        //incase the query doesnt work
        if(!$resFoodCategories){
            return  "Query Not Working";
;
        }
      
        if(!$resFoodCategories->num_rows>0){
            return "No food item data in database";
        }
    
        // Fetching all food categories
        while ($category = mysqli_fetch_assoc($resFoodCategories)) {
            $foodCategories[$category['Category_ID']] = $category['CategoryName'];
        }
    
        return $foodCategories;
    }

    function AddCategory($categoryName){
        global $connection;
        if (!$connection) {
            return "There is no connection with the database";
        }
        
        $sql = "INSERT INTO foodcategory (CategoryName) VALUES ('$categoryName')";
        $res = mysqli_query($connection,$sql);
        if($res){
            return true;
        }else{
            return "Error in executing the insert command";

        }
    }

    function RemoveCategoryData($categoryId){
        global $connection;
        if($connection){
            return "There is no connection with the database";

        }

        $sql = "DELETE FROM FoodCategory
            WHERE Category_ID = ".$categoryId/*." OR CategoryName = ".$categoryId.";"*/;

        $res=$connection->query($sql);
        if($res){
            return true;
        }else{
            return "Error in executing the query";
        }

    }

    function AddFoodItem($newFood){
        global $connection;   
        if($newFood instanceof FoodItem){
            //Check if the connection is valid
            if (!$connection) {
                return "Not connected to the restaurant database.";
            }
            

            $sql = "INSERT INTO FoodItems (FoodName, FoodType, Category_ID, FoodRating, FoodPreparationTime, FoodReview, FoodDescription, FoodImage, FoodPrice, FoodAvailability, TotalOrders) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            //compiles the structure without defining parameters without executing it.
            $statement = self::$restuarantDatabaseConnection->prepare($sql);

            //check if the sql statment was prepared for execution 
            if($statement===FALSE){
                echo "There was error preparing statement";
            }
            //set variables of the sql
            //s represents string type
            //d represents double type
            //i represents integer type
            //b represents blob (objects like image and files that are heavy in size)
            $statement->bind_param('ssidisssdii',
                $newFood->FoodName,
                $newFood->FoodType,
                $newFood->FoodCategory,
                $newFood->FoodRating,
                $newFood->FoodPreparationTime,
                $newFood->FoodReview,
                $newFood->FoodDescription, 
                $newFood->FoodImage, 
                $newFood->FoodPrice, 
                $newFood->FoodAvailability, 
                $newFood->TotalOrders
            );

            $res = $statement->execute();

            //check if the statement execution was successfull or not
            if($res){
                return true; 
            }
            else{
                $statement->close();
                return "There was error executing statement";
            }
        }else{
        
            return "The referenced type doesnt match";
        }
    }

    function RemoveFoodItemData($foodItem_ID){
        global $connection;
        $sql = "DELETE FROM foodItems WHERE 'FoodItem_ID' ==".$foodItem_ID;
        $res = $connection->query($sql);
        if(!$connection){
            return "Error Connecting to the database".$connection->error;
            
        }

        if($res){
            return true;
        }
        else{
            return "Error Executing the query".$connection->error;
        }


    }
?> 