<?php
    class DatabaseUtility{
         static $mainServername = "localhost";
         static $mainUsername = "root";
         static $mainPassword = "";
         static $mainDatabase = "RestaurantSystem";

        private static $mainConnection;

        private static $restuarantDatabaseConnection;

        public static function connectToMainDatabase(){
            self::$mainConnection = mysqli_connect(self::$mainServername,self::$mainUsername, self::$mainPassword,self:: $mainDatabase);
            if(!self::$mainConnection){
                echo "<script>alert('Error Connection')</script>";
                return false;
            }
            return true;
        }

        public static function CreateDatabase($restaurantName){
            $result = connectToMainDatabase();
            if($result){
                $sql = "CREATE DATABASE '$restaurantName'";
                $res = self::$mainConnection->query($sql);
                if($res === true){
                    echo "<script>alert('Database $restaurantName Created Successfully ')</script>";
                }else{
                    echo "<script>alert('Error Creating Database')</script>";
                }
            }
        }

        public static function CreateTables($databaseName){
            self::$restuarantDatabaseConnection = mysqli_connect(self::$mainServername,self::$mainUsername, self::$mainPassword,$databaseName);
            if(!self::$restuarantDatabaseConnection){
                echo "<script>alert('Error Connection')</script>";
                return false;
            }

            $sqlUserTable = "CREATE TABLE User (
                User_ID INT PRIMARY KEY AUTO_INCREMENT,
                Role_ID INT,
                FirstName VARCHAR(50) NOT NULL,
                LastName VARCHAR(50) NOT NULL,
                Email VARCHAR(100) NOT NULL,
                PhoneNumber VARCHAR(15) NOT NULL,
                Password VARCHAR(255) NOT NULL,
                FOREIGN KEY (Role_ID) REFERENCES Role(Role_ID)
            );";

            $sqlRoleTable = "CREATE TABLE Role(
                Role_ID INT PRIMARY KEY AUTO_INCREMENT,
                RoleName VARCHAR(30) NOT NULL,
                Responsibility VARCHAR(100)
            );";

            $sqlMenuTable = "CREATE TABLE Menu (
                Menu_ID INT PRIMARY KEY AUTO_INCREMENT,
                Category_ID INT,
                CanteenName VARCHAR(100),
                FOREIGN KEY (Category_ID) REFERENCES FoodCategory(Category_ID)
            );";

            $sqlFoodCategoryTable = "CREATE TABLE FoodCategory (
                Category_ID INT PRIMARY KEY AUTO_INCREMENT,
                FoodItem_ID INT,
                CategoryName VARCHAR(100),
                FOREIGN KEY (FoodItem_ID) REFERENCES FoodItems(FoodItem_ID) 
            );";

            $sqlFoodItem = "CREATE TABLE FoodItems (
                FoodItem_ID INT PRIMARY KEY AUTO_INCREMENT,
                FoodName VARCHAR(100) NOT NULL,
                FoodRating DECIMAL(1, 1),
                FoodPreparationTime INT, -- in min
                FoodReview TEXT,
                FoodDescription TEXT,
                FoodImage VARCHAR(255), -- as link
                FoodPrice DECIMAL(10, 2),
                FoodAvailability BOOLEAN DEFAULT TRUE,
                TotalOrders INT DEFAULT 0
            );";

            $sql = $sqlFoodItem+$sqlFoodCategoryTable+$sqlMenuTable+$sqlRoleTable+$sqlUserTable;

            $res = self::$restuarantDatabaseConnection->query($sql);
            if($res){
                echo "<script>alert('Created Table Successfully')</script>";
            }else{
                echo "<script>alert('Error Connection $res')</script>";

            }
        }
        // Creates food item in the menu
        public static function CreateItems($foodItem){
            if($foodItem instanceof FoodItem){
                //Check if the connection is valid
                if (!self::$restuarantDatabaseConnection) {
                    echo "<script>alert('Not connected to the restaurant database.')</script>";
                    return false;
                }
                

                $sql = "INSERT INTO FoodItems (FoodName, FoodRating, FoodPreparationTime, FoodReview, FoodDescription, FoodImage, FoodPrice, FoodAvailability, TotalOrders) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                //compiles the structure without defining parameters without executing it.
                $statement = self::$restuarantDatabaseConnection->prepare($sql);

                //check if the sql statment was prepared for execution 
                if($statement===FALSE){
                    echo "<script>alert('There was error preparing statement')</script>";
                }

                //set variables of the sql
                //s represents string type
                //d represents double type
                //i represents integer type
                //b represents blob (objects like image and files that are heavy in size)
                $statement->bind_param('sdisssdii',
                    $foodItem->FoodName,
                    $foodItem->FoodRating,
                    $foodItem->FoodPreparationTime,
                    $foodItem->FoodReview,
                    $foodItem->FoodDescription, 
                    $foodItem->FoodImage, 
                    $foodItem->FoodPrice, 
                    $foodItem->FoodAvailability, 
                    $foodItem->TotalOrders
                );

                $res = $statement->execute();

                //check if the statement execution was successfull or not
                if($res){
                    echo "<script>alert('Food Item Added Successfully')</script>";
                }
                else{
                    $statement->close();
                    echo "<script>alert('There was error executing statement')</script>";
                    return false;
                }


                //Get the ID of the newly inserted food item
                $newFoodItemId = $statement->insert_id;
                $statement->close();

                // Step 3: Link the food item to the category in the FoodCategory table
                $statementCategory = self::$restuarantDatabaseConnection->prepare(
                    "INSERT INTO FoodCategory (FoodItem_ID, CategoryName) 
                    VALUES ( ?, (SELECT CategoryName FROM FoodCategory WHERE Category_ID = ?))"
                );

                if (!$statementCategory) {
                    echo "<script>alert('Error preparing SQL statement for FoodCategory.')</script>";
                    return false;
                }

                // Bind the parameters
                $statementCategory->bind_param("is", 
                    $newFoodItemId, 
                    $foodItem->FoodCategory
                );

                // Execute the insertion into FoodCategory
                if ($statementCategory->execute()) {
                    echo "<script>alert('Food item and category link created successfully!')</script>";
                    $statementCategory->close();
                    return true;
                } else {
                    echo "<script>alert('Error linking food item to category: " . $$statementCategory->error . "')</script>";
                    $statementCategory->close();
                    return false;
                }
            }else{
                echo "<script>alert('The referenced type doesnt match')</script>";
                return false;
            }
        }
    }

    Class FoodItem{
        public $FoodItem_ID = 00000;
        public $FoodName = "Unnamed";
        public $FoodRating = 0.0;
        public $FoodPreparationTime = 30;
        public $FoodReview = "No Food Review";
        public $FoodDescription = "No Description";
        public $FoodImage = "";
        public $FoodPrice = 0;
        public $FoodAvailability = false;
        public $TotalOrders = 0;
        public $FoodCategory = 'None';
    }
?>