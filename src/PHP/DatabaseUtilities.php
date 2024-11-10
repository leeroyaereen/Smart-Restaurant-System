<?php
    class DatabaseUtility{
         static $mainServername = "localhost";
         static $mainUsername = "root";
         static $mainPassword = "";
         static $mainDatabase = "RestaurantSystem";

        private static $mainConnection;

        private static $restuarantDatabaseConnection;

        public static function connectToMainDatabase() {
            self::$mainConnection = mysqli_connect(self::$mainServername, self::$mainUsername, self::$mainPassword, self::$mainDatabase);
            
            if (!self::$mainConnection) {
                echo "<script>alert('Error Connecting to Database')</script>";
                return false;
            }
            return true;
        }
    
        public static function CreateDatabase($restaurantName) {
            //Just for debugging cases
            // echo "<script>alert('Connecting to Database')</script>";
            
            // Ensure to call the function correctly
            $result = self::connectToMainDatabase();
    
            if ($result) {
                //sql statement to search if there is any database named same as the parametered name
                $checkQuery = "SELECT SCHEMA_NAME FROM information_schema.SCHEMATA WHERE SCHEMA_NAME = '$restaurantName'";
                $checkDB_Result = mysqli_query(self::$mainConnection,$checkQuery);

                //if there exists any other database with the same name the count rises to 1 and the creation of database is restricted
                if(mysqli_num_rows($checkDB_Result)>0){
                    echo "<script>alert('Database you tried to create already exists')</script>";
                    return;
                }
                // Correct the SQL syntax
                $sql = "CREATE DATABASE `$restaurantName`";
                $res = mysqli_query(self::$mainConnection, $sql); // Using mysqli_query with the connection resource
    
                if ($res === true) {
                    echo "<script>alert('Database $restaurantName Created Successfully')</script>";
                } else {
                    echo "<script>alert('Error Creating Database: '" . mysqli_error(self::$mainConnection).")</script>";
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
                CategoryName VARCHAR(100) NOT NULL
            );";

            $sqlFoodItem = "CREATE TABLE FoodItems (
                FoodItem_ID INT PRIMARY KEY AUTO_INCREMENT,
                FoodName VARCHAR(100) NOT NULL,
                FoodType VARCHAR(30),
                Category_ID INT NOT NULL,
                FoodRating DECIMAL(2, 1),
                FoodPreparationTime INT,
                FoodReview TEXT,
                FoodDescription TEXT,
                FoodImage VARCHAR(255),
                FoodPrice DECIMAL(10, 2),
                FoodAvailability BOOLEAN DEFAULT TRUE,
                TotalOrders INT DEFAULT 0,
                FOREIGN KEY (Category_ID) REFERENCES FoodCategory(Category_ID)
            );";


            //add all the sql commands in array and executing one by one
            $queries = [$sqlFoodCategoryTable,$sqlFoodItem,$sqlMenuTable,$sqlRoleTable,$sqlUserTable];
            foreach($queries as $sql){
                $res = self::$restuarantDatabaseConnection->query($sql);
                if(!$res){
                    echo "<script>alert('Error Inserting $res')</script>";
                }
            }                    
            echo "<script>alert('Created Table Successfully')</script>";

            
        }
        // Creates food item in the menu
        public static function CreateItems($foodItem){
            if($foodItem instanceof FoodItem){
                //Check if the connection is valid
                if (!self::$restuarantDatabaseConnection) {
                    echo "<script>alert('Not connected to the restaurant database.')</script>";
                    return false;
                }
                

                $sql = "INSERT INTO FoodItems (FoodName, FoodType, Category_ID, FoodRating, FoodPreparationTime, FoodReview, FoodDescription, FoodImage, FoodPrice, FoodAvailability, TotalOrders) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
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
                $statement->bind_param('ssidisssdii',
                    $foodItem->FoodName,
                    $foodItem->FoodType,
                    $foodItem->FoodCategory,
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
                    return true; 
                }
                else{
                    $statement->close();
                    echo "<script>alert('There was error executing statement')</script>";
                    return false;
                }
            }else{
                echo "<script>alert('The referenced type doesnt match')</script>";
                return false;
            }
        }


        public static function CreateCategory($categoryName){
            if (!self::$restuarantDatabaseConnection) {
                echo "<script>alert('Not connected to the restaurant database.')</script>";
                return false;
            }
            
            $sql = "INSERT INTO foodcategory (CategoryName) VALUES ('$categoryName')";
            $res = mysqli_query(self::$restuarantDatabaseConnection,$sql);
            if($res){
                echo "<script>alert('The Category has been added')</script>";
            }else{
                echo "<script>alert('There was error adding category')</script>";

            }
        }
        //##remaining Functions
        //change password
        //change username
        //change restaurantDatabaseConnection.
        public static function ChangeRestaurant($databaseName){
            self::$restuarantDatabaseConnection = mysqli_connect(self::$mainServername,self::$mainUsername, self::$mainPassword,$databaseName);

        }

        public static function GetRestaurantConnection(){
            return self::$restuarantDatabaseConnection;
        }
        public static function GetRestaurantConnectionWithName($databaseName){
            self::$restuarantDatabaseConnection = mysqli_connect(self::$mainServername,self::$mainUsername, self::$mainPassword,$databaseName);
            if(self::$restuarantDatabaseConnection){
                return self::$restuarantDatabaseConnection;
            }        
        }

        public static function RunCommandOnRestaurantDatabase(){

        }
    }

    Class FoodItem{
        public $FoodItem_ID = 00000;
        public $FoodName = "Unnamed";
        public $FoodType = "";
        public $FoodCategory;
        public $FoodRating = 0.0;
        public $FoodPreparationTime = 30;
        public $FoodReview = "No Food Review";
        public $FoodDescription = "No Description";
        public $FoodImage = "";
        public $FoodPrice = 0;
        public $FoodAvailability = false;
        public $TotalOrders = 0;
    }
?>