<?php

    require '../middleware/databaseConnector.php';
    function CreateNewDatabaseForRestaurant($restaurantName){
        global $connection;    
        if ($connection) {
            //sql statement to search if there is any database named same as the parametered name
            $checkQuery = "SELECT SCHEMA_NAME FROM information_schema.SCHEMATA WHERE SCHEMA_NAME = '$restaurantName'";
            $checkDB_Result = mysqli_query(self::$mainConnection,$checkQuery);

            //if there exists any other database with the same name the count rises to 1 and the creation of database is restricted
            if(mysqli_num_rows($checkDB_Result)>0){
                return "Database you tried to create already exists";
            }
            // Correct the SQL syntax
            $sql = "CREATE DATABASE `$restaurantName`";
            $res = mysqli_query(self::$mainConnection, $sql); // Using mysqli_query with the connection resource

            if ($res === true) {
                return true;
            } else {
                return "Error Creating Database" . mysqli_error(self::$mainConnection);
            }
        }
    }

    function CreateTablesForRestaurant($restaurantName){
        global $mainServername, $mainUsername,$mainPassword;
        $conn = mysqli_connect($mainServername,$mainUsername, $mainPassword,$restaurantName);
        if(!$conn){
            return "Unable to connect to the database";
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
        $sqlAddDefaultCategory = "INSERT INTO FoodCategory (CategoryName) VALUE ('Others')";
        $sqlFoodItem = "CREATE TABLE FoodItems (
            FoodItem_ID INT PRIMARY KEY AUTO_INCREMENT,
            FoodName VARCHAR(100) NOT NULL,
            FoodType VARCHAR(30),
            Category_ID INT NOT NULL DEFAULT 1,
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

        $sqlOrderTray = "CREATE TABLE OrderTray (
            OrderTray_ID INT PRIMARY KEY AUTO_INCREMENT,
            User_ID INT,
            KitchenOrderTime TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (User_ID) REFERENCES USER(User_ID)
        );";
        $sqlOrderItem = "CREATE TABLE OrderItem (
            OrderItem_ID INT PRIMARY KEY AUTO_INCREMENT,
            OrderTray_ID INT,
            FoodItem_ID INT,
            Quantity INT NOT NULL,
            OrderStatus VARCHAR(50) NOT NULL,
            Note TEXT,
            FOREIGN KEY (OrderTray_ID) REFERENCES OrderTray(OrderTray_ID),
            FOREIGN KEY (FoodItem_ID) REFERENCES FoodItems(FoodItem_ID)
        );";
        $sqlReview = "    CREATE TABLE Review (
            Review_ID INT PRIMARY KEY AUTO_INCREMENT,
            FoodItem_ID INT,
            User_ID INT,
            Rating INT CHECK (Rating >= 1 AND Rating <= 5),
            ReviewText TEXT,
            ReviewDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (FoodItem_ID) REFERENCES FoodItems(FoodItem_ID),
            FOREIGN KEY (User_ID) REFERENCES User(User_ID)
        );";

        //add all the sql commands in array and executing one by one
        $queries = [$sqlFoodCategoryTable,$sqlAddDefaultCategory,$sqlFoodItem,$sqlMenuTable,$sqlRoleTable,$sqlUserTable,$sqlOrderTray,$sqlOrderItem,$sqlReview];
        foreach($queries as $sql){
            $res = self::$restuarantDatabaseConnection->query($sql);
            if(!$res){
                return "Error Inserting $res";
            }
        }                    
        return true;

    }

    function CreateTriggerForRatingUpdate(){
        $sql = "DELIMITER $$

            CREATE TRIGGER `onRating` AFTER INSERT ON `review`
            FOR EACH ROW BEGIN 
                DECLARE averageRating FLOAT;
                
                SELECT AVG(Rating) INTO averageRating
                FROM review
                WHERE FoodItem_ID = NEW.FoodItem_ID;
                
                UPDATE fooditems
                SET FoodRating = averageRating
                WHERE FoodItem_ID = NEW.FoodItem_ID;
            END$$

            DELIMITER ;
        ";
    }

    function CreateCategoryDeletionTrigger(){
        $sql = "DELIMITER $$

            CREATE TRIGGER `onCategoryDelete` 
            BEFORE 
            DELETE ON `foodcategory`
            FOR EACH ROW BEGIN
                DECLARE categoryID INT;
                DECLARE defaultCategoryID INT;
                
                SELECT Category_ID INTO categoryID
                FROM foodcategory
                WHERE CategoryName = 'Others';
                
                SELECT Category_ID INTO defaultCategoryID
                FROM fooditems
                WHERE Category_ID = OLD.Category_ID
                LIMIT 1;
                
                IF defaultCategoryID IS NULL THEN
                    UPDATE fooditems
                    SET Category_ID = categoryID
                    WHERE Category_ID = OLD.Category_ID;
                ELSE
                    UPDATE fooditems
                    SET Category_ID = categoryID
                    WHERE Category_ID = OLD.Category_ID;
                END IF;
            END$$

            DELIMITER ;
        ";
    }
    function CreateOrderItemTable(){
        $sql = 'CREATE TABLE ORDER (
            Order_ID INT PRIMARY KEY AUTO_INCREMENT,
            OrderTray_ID INT,
            FoodItem_ID VARCHAR(50),
            Quantity INT NOT NULL,
            OrderStatus VARCHAR(50) NOT NULL,
            Note TEXT,
            FOREIGN KEY (OrderTray_ID) REFERENCES OrderTray(OrderTray_ID),
            FOREIGN KEY (FoodItem_ID) REFERENCES FOOD(FoodItem_ID)
        );';
    }

    function EnableDayBasedOrderClosingSystem(){
        $sql = "SET GLOBAL event_scheduler = ON;";

        $sql = "DELIMITER $$

                CREATE EVENT CloseDailyOrders
                ON SCHEDULE EVERY 1 DAY
                STARTS TIMESTAMP(CURRENT_DATE + INTERVAL 1 DAY) -- Starts at midnight
                DO
                BEGIN
                    UPDATE orderitem 
                    SET OrderStatus = 'Closed' 
                    WHERE OrderStatus != 'Closed';
                END $$

                DELIMITER ;
            ";
    }

    function CreateOrderTrayTable(){
        $sql = 'CREATE TABLE OrderTray (
            OrderTray_ID INT PRIMARY KEY AUTO_INCREMENT,
            User_ID INT,
            OrderDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (User_ID) REFERENCES USER(User_ID)
        );';
    }

    function CreateReviewTable(){
        $sql = 'CREATE TABLE REVIEW (
            Review_ID INT PRIMARY KEY AUTO_INCREMENT,
            FoodItem_ID INT,
            User_ID INT,
            Rating INT CHECK (Rating >= 1 AND Rating <= 5),
            ReviewText TEXT,
            ReviewDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (FoodItem_ID) REFERENCES FOOD(FoodItem_ID),
            FOREIGN KEY (User_ID) REFERENCES USER(User_ID)
        );';
    }
?>