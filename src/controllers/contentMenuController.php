<?php
    
    require_once '../models/FoodItemModel.php';
   
    function getFoodItems(){
            
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $itemJson = GetJSONOfFoodItems();
            echo $itemJson;
        }else{
            echo json_encode(["status"=>'failure', "message" => "Can't Connect to the database"]);
        }
    }

    function getFoodCategories(){
        if($_SERVER['REQUEST_METHOD']==='POST'){           
            $categoriesJson = GetJSONOfFoodCategoriess();
            echo $categoriesJson;
        }else{
            echo json_encode(["status"=>'failure', "message" => "Can't Connect to the database"]);
        }
    }
?>