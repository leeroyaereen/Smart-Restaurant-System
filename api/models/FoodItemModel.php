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

    function AddCategoryData($categoryName){
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

    function RemoveCategoryData($categoryId) {
        global $connection;
    
        if (!$connection) {
            $connection = getConnection();
            if (!$connection) {
                return "Unable to connect to the database.";
            }
        }
    
        $deleteSql = "DELETE FROM FoodCategory WHERE Category_ID = ?";
        $deleteStmt = $connection->prepare($deleteSql);
    
        if (!$deleteStmt) {
            return "Error: Failed to prepare delete query - " . $connection->error;
        }
    
        $deleteStmt->bind_param("i", $categoryId);
        if ($deleteStmt->execute()) {
            if ($deleteStmt->affected_rows > 0) {
                $deleteStmt->close();
                return true;
            } else {
                $deleteStmt->close();
                return "No category found with the provided ID.";
            }
        } else {
            $deleteStmt->close();
            return "Error: Failed to delete category - " . $deleteStmt->error;
        }
    }
    
    function AddFoodItem(FoodItem $newFood) {
        global $connection;   
        if ($newFood instanceof FoodItem) {
            if (!$connection) {
                $connection = changeDatabaseConnection('achs canteen');
                if (!$connection) return "Not connected to the restaurant database.";
            }
            
            $sql = "INSERT INTO FoodItems (FoodName, FoodType, Category_ID, FoodRating, FoodPreparationTime, FoodReview, FoodDescription, FoodPrice, FoodAvailability, TotalOrders) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $statement = $connection->prepare($sql);
    
            if ($statement === false) {
                return "There was an error preparing the statement.";
            }
    
            $statement->bind_param(
                'ssidissdii',
                $newFood->FoodName,
                $newFood->FoodType,
                $newFood->FoodCategory,
                $newFood->FoodRating,
                $newFood->FoodPreparationTime,
                $newFood->FoodReview,
                $newFood->FoodDescription, 
                $newFood->FoodPrice, 
                $newFood->FoodAvailability, 
                $newFood->TotalOrders
            );
    
            $res = $statement->execute();
            if (!$res) {
                $statement->close();
                return "There was an error executing the statement.";
            }
    
            $newFood->FoodItem_ID = $connection->insert_id;
            //$newFood->SetImageAddress();
    
            $sql = "UPDATE FoodItems SET FoodImage = ? WHERE FoodItem_ID = ?";
            $statement = $connection->prepare($sql);
            if (!$statement) {
                return "Error in preparing query for updating FoodImage.";
            }
            $statement->bind_param("si", $newFood->FoodImage, $newFood->FoodItem_ID);
            $res = $statement->execute();
            if (!$res) {
                $statement->close();
                return "Error executing query to update FoodImage.";
            }
            $statement->close();
    
            return true; 
        } else {
            return "The referenced type doesn't match.";
        }
    }
    
    function RemoveFoodItemData($foodItem_ID) {
        global $connection;
    
        // Ensure the connection is active
        if (!$connection) {
            $connection = getConnection();
            if (!$connection) {
                return "Error Connecting to the database: " . $connection->error;
            }
        }
    
        // Starting a transaction so that incase one of the query fails both are reverted back
        $connection->begin_transaction();
    
        try {
            // Update `orderitem` table to handle dependent records
            $sqlUpdate = 'UPDATE orderitem SET FoodItem_ID = NULL WHERE FoodItem_ID = ?';
            $stmtUpdate = $connection->prepare($sqlUpdate);
            if (!$stmtUpdate) {
                throw new Exception("Failed to prepare update query: " . $connection->error);
            }
            $stmtUpdate->bind_param("i", $foodItem_ID);
            if (!$stmtUpdate->execute()) {
                throw new Exception("Failed to execute update query: " . $stmtUpdate->error);
            }
            $stmtUpdate->close();
    
            // Delete the food item from `foodItems` table
            $sqlDelete = 'DELETE FROM foodItems WHERE FoodItem_ID = ?';
            $stmtDelete = $connection->prepare($sqlDelete);
            if (!$stmtDelete) {
                throw new Exception("Failed to prepare delete query: " . $connection->error);
            }
            $stmtDelete->bind_param("i", $foodItem_ID);
            if (!$stmtDelete->execute()) {
                throw new Exception("Failed to execute delete query: " . $stmtDelete->error);
            }
            $stmtDelete->close();
    
            // Commit the transaction
            $connection->commit();
            return true;
        } catch (Exception $e) {
            // Rollback the transaction on error
            $connection->rollback();
            return "Transaction failed: " . $e->getMessage();
        }
    }
    
    function EditCategoryData($category_ID, $categoryName) {
        global $connection;
    
        if (!$connection) {
            $connection = getConnection();
            if (!$connection) {
                return "Unable to connect to the database.";
            }
        }
    
        $updateSql = "UPDATE FoodCategory SET CategoryName = ? WHERE Category_ID = ?";
        $updateStmt = $connection->prepare($updateSql);
    
        if (!$updateStmt) {
            return "Error: Failed to prepare update query - " . $connection->error;
        }
    
        $updateStmt->bind_param("si", $categoryName, $category_ID);
        if ($updateStmt->execute()) {
            if ($updateStmt->affected_rows > 0) {
                $updateStmt->close();
                return true;
            } else {
                $updateStmt->close();
                return "No category found with the provided ID.";
            }
        } else {
            $updateStmt->close();
            return "Error: Failed to update category - " . $updateStmt->error;
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

        //resets the value of food category name with relative food Category id
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

            //sets the resulted output from database to the variable
            $res = $stmt->get_result();
            if($res->num_rows<1){
                return "No Any Category Based on the provided name found";
            }
            $catId = $res->fetch_assoc();
            $foodItem->FoodCategory = $catId['Category_ID'];
            $stmt->close();
        }

        //checking if fooditem with the referenced id exists
        $sql = "SELECT FoodImage FROM fooditems WHERE FoodItem_ID = ".$foodItem->FoodItem_ID;
        $res = $connection->query($sql);
        if(!$res){
            return 'Failed to execute query';
        }
        if($res->num_rows<1){
            return "No Referenced Food Item Available";
        }
        //update foodItem
        $sql = "UPDATE fooditems 
                SET fooditems.FoodName = COALESCE(?,FoodName), 
                    fooditems.FoodType =  COALESCE(?,FoodType), 
                    fooditems.Category_ID =  COALESCE(?,Category_ID), 
                    fooditems.FoodPreparationTime = COALESCE(?,FoodPreparationTime), 
                    fooditems.FoodDescription = COALESCE(?,FoodDescription), 
                    fooditems.FoodPrice = COALESCE(?,FoodPrice)";

/////////////// Updated by shovit
        if (!empty($foodItem->FoodImage)) {
            $sql .= ", fooditems.FoodImage = ?";
        }
        $sql .= " WHERE FoodItem_ID = ?";
        $stmt = $connection->prepare($sql);

        if (!empty($foodItem->FoodImage)) {
            $stmt->bind_param(
                "ssiisisi", 
                $foodItem->FoodName, 
                $foodItem->FoodType, 
                $foodItem->FoodCategory, 
                $foodItem->FoodPreparationTime, 
                $foodItem->FoodDescription, 
                $foodItem->FoodPrice, 
                $foodItem->FoodImage,  // Image included only if provided
                $foodItem->FoodItem_ID
            );
        } else {
            $stmt->bind_param(
                "ssiisii", 
                $foodItem->FoodName, 
                $foodItem->FoodType, 
                $foodItem->FoodCategory, 
                $foodItem->FoodPreparationTime, 
                $foodItem->FoodDescription, 
                $foodItem->FoodPrice, 
                $foodItem->FoodItem_ID
            );
        }
/////////////////////

        $res = $stmt->execute();
        $stmt->close();
        return $res;
    }

    function CountUpTheTotalOrdersOfFoodItem($foodItem_ID){
        $sql = "UPDATE fooditems SET TotalOrders = TotalOrders + 1 WHERE FoodItem_ID =".$foodItem_ID;
        $connection = getConnection();
        if(!$connection){
            return "No Database connection from FOodItem";
        }

        $res  = $connection->query($sql);
        if(!$res ){
            return "Failed to execute the query";
        }
       
        return true;
    }
    function onReview($userid, $foodItem, $rating, $reviewNote){
        $sql = "INSERT INTO review (FoodItem_ID, User_ID, Rating, ReviewText, ReviewDate) VALUES(?,?,?,?,?)";
    }

    
?> 