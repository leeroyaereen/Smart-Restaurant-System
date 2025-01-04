<?php

    require_once __DIR__.'/../../config/databaseConnector.php';
    require_once __DIR__.'/../helper/foodItemClass.php'; 

    use Src\Helpers\FoodItem;

    $connection = getConnection();
    function GetFoodItems(){
        global $connection;
        $foodItems = [];

        // if (!class_exists('FoodItem')) {
        //     return "Still class doesnot exist".class_exists('FoodItem');
        // }
        if(!$connection){
            $connection = changeDatabaseConnection('ACHS canteen');
            if(!$connection){
                return "Null connection";
            }
        }
        
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
    function GetAvailableFoodItems(){
        global $connection;
        $foodItems = [];

        // if (!class_exists('FoodItem')) {
        //     return "Still class doesnot exist".class_exists('FoodItem');
        // }
        if(!$connection){
            $connection = changeDatabaseConnection('ACHS canteen');
            if(!$connection){
                return "Null connection";
            }
        }
        
        $sqlFoodItems = "SELECT * FROM FoodItems WHERE FoodAvailability = '1'";
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

    function GetFoodCategories(){
        global $connection;
        $foodCategories=[];
        

        if(!$connection){
            $connection = changeDatabaseConnection('ACHS canteen');
            if(!$connection){
                return "Null connection";
            }
        }
        
        $sqlFoodCategories = "SELECT * FROM FoodCategory";
        $resFoodCategories = $connection->query($sqlFoodCategories);
    
        //incase the query doesnt work
        if(!$resFoodCategories){
            return  "Query Not Working";
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
        if(!$connection){
            $connection = changeDatabaseConnection('ACHS canteen');
            if(!$connection){
                return "Null connection";
            }
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
        if(!$connection){
            $connection = changeDatabaseConnection('ACHS canteen');
            if(!$connection){
                return "Null connection";
            }
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
                $connection = changeDatabaseConnection('achs canteen');
                if (!$connection) return "Not connected to the restaurant database.";
            }
            

            $sql = "INSERT INTO FoodItems (FoodName, FoodType, Category_ID, FoodRating, FoodPreparationTime, FoodReview, FoodDescription, FoodImage, FoodPrice, FoodAvailability, TotalOrders) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            //compiles the structure without defining parameters without executing it.
            $statement = $connection->prepare($sql);

            //check if the sql statment was prepared for execution 
            if($statement===FALSE){
                return "There was error preparing statement";
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

    function getFoodItemByID($foodItem_ID){
        global $connection;

        $foodItem = new FoodItem;

        if(!$connection){
            $connection = changeDatabaseConnection('ACHS canteen');
            if(!$connection){
                return "Null connection";
            }
        }

        $sql = "SELECT * FROM foodItems WHERE FoodItem_ID = ".$foodItem_ID;
        $res = $connection->query($sql);
        if($res){
            $item = mysqli_fetch_assoc($res);
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
            return $foodItem;
        }
        else{
            return "Can't get the any object";
        }
    }

    function getCategoryByID($category_ID){
        global $connection;

        if(!$connection){
            $connection = changeDatabaseConnection('ACHS canteen');
            if(!$connection){
                return "Null connection";
            }
        }

        $sql = "SELECT * FROM foodCategory WHERE Category_ID = ".$category_ID;
        $res = $connection->query($sql);
        if($res){
            $category = mysqli_fetch_assoc($res);
            return $category['CategoryName'];
        }
        else{
            return "Can't get the any object";
        }
    }
    
    function getFoodItemsByCategory($category_ID){
        global $connection;
        $foodItems = [];

        if(!$connection){
            $connection = changeDatabaseConnection('ACHS canteen');
            if(!$connection){
                return "Null connection";
            }
        }

        $sql = "SELECT * FROM foodItems WHERE Category_ID = ".$category_ID;
        $res = $connection->query($sql);
        if($res){
            while($item = mysqli_fetch_assoc($res)){
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
        else{
            return [];
        }
    }

    function updateFoodItem($foodItem){

        global $connection;
        if(!($foodItem instanceof FoodItem)){
            return "Invalid Class Type of the instance";
        }

        if(!$foodItem){
            return "Cant Process with Null Value";
        }

        if(!$foodItem->FoodItem_ID){
            return "The Id of the fooditem is not referenced";
        }

        if(!$connection){
            $connection = getConnection();
            if(!$connection){
        
                return "Error connecting to the database";
            }
        }
        if(!is_numeric($foodItem->FoodCategory)){
            $sql = "SELECT Category_ID FROM foodCategory WHERE CategoryName = ?";
            $stmt = $connection->prepare($sql);
            if(!$stmt){
                return "Failed to prepare query";
            }
            $stmt->bind_param("s",$foodItem->FoodCategory);
            $res = $stmt->execute();
            if(!$res){
                return " Failed to execute the query";
            }
            $res = $stmt->get_result();
            if($res->num_rows<1){
                return "No Any Category Based on the provided name found";
            }
            $catId = $res->fetch_assoc();
            $foodItem->FoodCategory = $catId['Category_ID'];
            $stmt->close();
        }
        $sql = "UPDATE fooditems 
                SET FoodName = ?, FoodType = ?, Category_ID = ?, FoodPreparationTime = ?, FoodDescription = ?, FoodImage = ?, FoodPrice = ?
                WHERE FoodItem_ID = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ssiissii", 
            $foodItem->FoodName, 
            $foodItem->FoodType, 
            $foodItem->FoodCategory, 
            $foodItem->FoodPreparationTime, 
            $foodItem->FoodDescription, 
            $foodItem->FoodImage, 
            $foodItem->FoodPrice, 
            $foodItem->FoodItem_ID
        );
        $res = $stmt->execute();
        $stmt->close();
        return $res;
    }
?> 