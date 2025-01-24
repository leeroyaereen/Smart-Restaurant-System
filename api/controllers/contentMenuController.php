<?php
    
    require_once __DIR__.'/../models/FoodItemModel.php';
   
    function getFoodItemsJSON(){   
        //get the objects from the FoodItemModel
        $itemJson = GetAvailableFoodItems();

        //if the object is null then it is regarded as failure
        if($itemJson==null){
            echo json_encode(["success"=>false, "message" => "Can't get any object"]);
            return;
        }
        $message = 'no message';

        //incase the return value is message instead it is regarded as failure of the function
        if(is_string($itemJson)){
            $message = $itemJson;
            echo json_encode(["success"=>false, "message" => $message]);
            return;
        }

        //if there is no problem then the final output is sent with status, message, and fooditem
        echo json_encode(['success'=>true,'message'=>$message,'foodItems'=>$itemJson]);
    }

    function getFoodCategoriesJSON(){ 
        if($_SERVER['REQUEST_METHOD']!=='GET'){

        }
        //get food Categories from foodItemModel        
        $categoriesJson = GetFoodCategories();

        //check if the categoriesJson is null then it is regarded as failure and the funciton is stopped
        if($categoriesJson==null){
            echo json_encode(["success"=>false, "message" => "Can't get the any object"]);
            return;
        }


        $message = 'No message';

        //check if the return message of the object is string data type that makes it consider as failure message
        if(is_string($categoriesJson)){
            $message = $categoriesJson;
            echo json_encode(["success"=>false, "message" => $message]);
            return;
        }
        echo json_encode(['success'=>true,'message'=>$message,'foodCategories'=>$categoriesJson]);
    }

    function getCategorizedFoodItemsJSON(){
        if($_SERVER['REQUEST_METHOD']==='GET'){
            $categorizedFoodItems = [];

            $foodItems = GetAvailableFoodItems();
            if(is_string($foodItems)){
                $message = $foodItems;
                echo json_encode(["success"=>false, "message" => $message]);
                return;
            }

            $foodCategories = GetFoodCategories();
            if(is_string($foodCategories)){
                $message = $foodCategories;
                echo json_encode(["success"=>false, "message" => $message]);
                return;
            }

            if($foodItems==null || $foodCategories==null){
                echo json_encode(["success"=>false, "message" => "Can't get the any of the two requested data"]);
                return;
            }

            $message = 'No message';

            foreach($foodCategories as $key => $value){
                $categoryID = $key;
                $categorizedFoodItems[$categoryID] = [
                        'CategoryName' => $value,
                        'foodItems' => getFoodItemsByCategory($categoryID)
                    ];
            }
            echo json_encode(['success'=>true,'message'=>$message,'categorizedFoodItems'=>$categorizedFoodItems]);
        }else{
            echo json_encode(["success"=>false, "message" => "Can't Handle Request due to invalid method"]);
        }
    }

    // function getFoodItemAndCategoriesJSON(){
    //     if($_SERVER['REQUEST_METHOD']==='POST'){           
    //         $foodItems = GetFoodCategories();
    //         $foodCategories = GetFoodItems();
    //         if($foodItems==null || $foodCategories==null){
    //             echo json_encode(["success"=>false, "message" => "Can't get the any of the two requested data"]);
    //         }
    //         $message = 'No message';
    //         if(is_string($foodItems)){
    //             $message = $foodItems;
    //             echo json_encode(["success"=>false, "message" => $message]);
    //             return;
    //         }
    //         echo json_encode(['success'=>true,'message'=>$message,'foodItem'=>$foodItems,'$foodCategories'=>$foodItems]);
    //     }else{
    //         echo json_encode(["success"=>false, "message" => "Can't Handle Request due to invalid method"]);
    //     }
    // }

    function setTrayItems(){
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $data = json_decode(file_get_contents('php://input'), true);
            if(isset($data['TrayItems'])){
                $TrayItems = $data['TrayItems'];
                $_SESSION['TrayItems'] = $TrayItems;
                echo json_encode(['success'=>true,'message'=>'Tray Items Set Successfully']);
            }else{
                echo json_encode(['success'=>false,'message'=>'Tray Items Not Set']);
            }
        }else{
            echo json_encode(['success'=>false,'message'=>'Invalid Request Method']);
        }
    }

    function getTrayItems() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (isset($_SESSION['TrayItems'])) {
                $TrayItemsDetails = [];
                $TrayItems = $_SESSION['TrayItems'];
    
                foreach ($TrayItems as $trayItem) {
                    // Fetch the food item details by its ID
                    $foodItem = getFoodItemByID($trayItem['FoodItem_ID']);
                    if (!$foodItem || is_string($foodItem)) {
                        continue; // Skip if food item is not found
                    }
    
                    // Format as [Category ID => [Food Item Details, Quantity]]
                    $categoryID = $foodItem->FoodCategory;
                    if (!isset($TrayItemsDetails[$categoryID])) {
                        $TrayItemsDetails[$categoryID] = [
                            'CategoryName' => getCategoryByID($categoryID), // Fetch category name
                            'foodItems' => []
                        ];
                    }
    
                    // Add the food item and its quantity
                    $TrayItemsDetails[$categoryID]['foodItems'][] = [
                        'foodItemDetails' => $foodItem,
                        'Quantity' => $trayItem['Quantity']
                    ];
                }
    
                // Sort by category ID for consistency
                // ksort($TrayItemsDetails);
    
                echo json_encode(['success' => true, 'TrayItems' => $TrayItemsDetails]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Tray Items Not Found']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid Request Method']);
        }
    }
    
?>