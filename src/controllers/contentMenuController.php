<?php
    
    require_once '../models/FoodItemModel.php';
   
    function getFoodItemsJSON(){
            
        if($_SERVER['REQUEST_METHOD']==='POST'){
            //get the objects from the FoodItemModel
            $itemJson = GetFoodItems();

            //if the object is null then it is regarded as failure
            if($itemJson==null){
                echo json_encode(["status"=>'failure', "message" => "Can't get the any object"]);
                return;
            }
            $message = 'No message';

            //incase the return value is message instead it is regarded as failure of the function
            if(is_string($itemJson)){
                $message = $itemJson;
                echo json_encode(["status"=>'failure', "message" => $message]);
                return;
            }

            //if there is no problem then the final output is sent with status, message, and fooditem
            echo json_encode(['status'=>'success','message'=>$message,'foodItems'=>$itemJson]);
        }else{
            echo json_encode(["status"=>'failure', "message" => "Can't Handle Request due to invalid method"]);
            
        }
    }

    function getFoodCategoriesJSON(){
        if($_SERVER['REQUEST_METHOD']==='POST'){   
            //get food Categories from foodItemModel        
            $itemJson = GetFoodCategoriess();

            //check if the itemJson is null then it is regarded as failure and the funciton is stopped
            if($itemJson==null){
                echo json_encode(["status"=>'failure', "message" => "Can't get the any object"]);
                return;
            }


            $message = 'No message';

            //check if the return message of the object is string data type that makes it consider as failure message
            if(is_string($itemJson)){
                $message = $itemJson;
                echo json_encode(["status"=>'failure', "message" => $message]);
                return;
            }
            echo json_encode(['status'=>'success','message'=>$message,'$foodCategories'=>$itemJson]);
        }else{
            echo json_encode(["status"=>'failure', "message" => "Can't Handle Request due to invalid method"]);
            $itemJson = GetFoodCategoriess();
            echo $itemJson;
        }
    }

    function getFoodItemAndCategoriesJSON(){
        if($_SERVER['REQUEST_METHOD']==='POST'){           
            $foodItems = GetFoodCategoriess();
            $foodCategories = GetFoodItems();
            if($foodItems==null || $foodCategories==null){
                echo json_encode(["status"=>'failure', "message" => "Can't get the any of the two requested data"]);
            }
            $message = 'No message';
            if(is_string($foodItems)){
                $message = $foodItems;
                echo json_encode(["status"=>'failure', "message" => $message]);
                return;
            }
            echo json_encode(['status'=>'success','message'=>$message,'foodItem'=>$foodItems,'$foodCategories'=>$foodItems]);
        }else{
            echo json_encode(["status"=>'failure', "message" => "Can't Handle Request due to invalid method"]);
        }
    }
?>