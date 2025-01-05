<?php
    use Src\Helpers\FoodItem;
    require_once __DIR__.'/../models/FoodItemModel.php';

    function CreateFoodItem(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $foodItemDetails = json_decode(file_get_contents("php://input"), true);
            if(!$foodItemDetails){
                echo json_encode(['success'=>false, 'message'=>'Invalid data']);
                return;
            }
            $foodItem = new FoodItem();
            $foodItem->FoodName = $foodItemDetails['foodName'];
            $foodItem->FoodPrice = $foodItemDetails['foodPrice'];
            $foodItem->FoodPreparationTime = $foodItemDetails['foodPreparationTime'];
            $foodItem->FoodCategory = $foodItemDetails['foodCategory'];
            $foodItem->FoodDescription = $foodItemDetails['foodDescription'];
            $result = AddFoodItem($foodItem);
            if($result!==true){
                echo json_encode(['success'=>false, 'message'=>'Failed to add food item'.$result]);
                return;
            }

            echo json_encode(['success'=>true, 'message'=>'Food Item added successfully']);

        }
    }

    function RemoveFoodItem(){
        if($_SERVER['REQUEST_METHOD']!=='POST'){
            echo json_encode(['success'=>false, 'message'=>'Failed to remove due to invalid request method']);
            return ;           
        }
        $data =  json_decode(file_get_contents("php://input"), true);
        if(!$data){
            echo json_encode(['success'=>false, 'message'=>'Invalid data format']);
            return;
        }
        $id = $data['foodItem_ID'];
        $res = RemoveFoodItemData($id);
        if($res){
            echo json_encode(['success'=>true, 'message'=>'Removed Data Successfully']);
            return;
        }
        echo json_encode(['success'=>false, 'message'=>'Failed to remove data']);
    }

    function EditFoodItem(){
        if($_SERVER['REQUEST_METHOD']!=='POST'){
            echo json_encode(['success'=>false, 'message'=>'Failed to remove due to invalid request method']);
            return ;           
        }
        $data =  json_decode(file_get_contents("php://input"), true);
        if(!$data){
            echo json_encode(['success'=>false, 'message'=>'Invalid data format']);
            return;
        }
        $foodItem = new FoodItem();
        $foodItem->FoodItem_ID = $data['foodItem_ID'];
        $foodItem->FoodName = $data['foodName'];
        $foodItem->FoodType = $data['foodType'];
        $foodItem->FoodPrice = $data['foodPrice'];
        $foodItem->FoodPreparationTime = $data['foodPreparationTime'];
        $foodItem->FoodCategory = $data['foodCategory'];
        $foodItem->FoodDescription = $data['foodDescription'];
        $foodItem->FoodImage = $data['foodImage'];

        $res = updateFoodItem($foodItem);
        if(is_string($res)){
            echo json_encode(['success'=>false, 'message'=>$res]);

            return ;
        }  
        echo json_encode(['success'=>true, 'message'=>'Edited Successfully']);

    }

    function RemoveCategory(){
        if($_SERVER['REQUEST_METHOD']!=='POST'){
            echo json_encode(['success'=>false, 'message'=>'Failed to remove due to invalid request method']);
            return ;           
        }
        $data =  json_decode(file_get_contents("php://input"), true);
        if(!$data){
            echo json_encode(['success'=>false, 'message'=>'Invalid data format']);
            return;
        }
        $id = $data['category_ID'];
        $res = RemoveCategoryData($id);
        if($res){
            echo json_encode(['success'=>true, 'message'=>'Removed Data Successfully']);
            return;
        }
        echo json_encode(['success'=>false, 'message'=>'Failed to remove data']);
    }

    function AddCategory(){
        if($_SERVER['REQUEST_METHOD']!=='POST'){
            echo json_encode(['success'=>false, 'message'=>'Failed to remove due to invalid request method']);
            return ;           
        }
        $data =  json_decode(file_get_contents("php://input"), true);
        if(!$data){
            echo json_encode(['success'=>false, 'message'=>'Invalid data format']);
            return;
        }

        $name = $data['categoryName'];
        $res = AddCategoryData($name);
        if($res){
            echo json_encode(['success'=>true, 'message'=>'Added Data Successfully']);
        }else{
            echo json_encode(['success'=>false, 'message'=>'Failed to add data']);

        }
    }
?>