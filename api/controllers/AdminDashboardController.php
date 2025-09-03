<?php
    use Src\Helpers\FoodItem;
    require_once __DIR__.'/../models/FoodItemModel.php';

    function CreateFoodItem() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Directory to store uploaded images
            $uploadDir = __DIR__ . '/../../public/assets/images/';
            
            // Create directory if it doesn't exist
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            if(!isset($_POST['foodName'])){
                echo json_encode(['success' => false, 'message' => 'Food Name Required!!']);
                    return;
            }
            $foodItem = new FoodItem();
            $foodItem->FoodName = $_POST['foodName'];
            $foodItem->FoodType = $_POST['foodType'];
            $foodItem->FoodPrice = $_POST['foodPrice'];
            $foodItem->FoodPreparationTime = $_POST['foodPreparationTime'];
            $foodItem->FoodDescription = $_POST['foodDescription'];
            
            if(isset($_POST['foodCategory'])){
                $foodItem->FoodCategory = $_POST['foodCategory'];
            }
            
            // Handle image upload
            if (isset($_FILES['foodImage'])) {
                $file = $_FILES['foodImage'];
                
                // Generate unique filename
                $fileName = $foodItem->FoodName . '_' . basename($file['name']);
                $targetPath = $uploadDir . $fileName;
                
                // Allowed Validate file type array
                $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
                if (!in_array($file['type'], $allowedTypes)) {
                    echo json_encode(['success' => false, 'message' => 'Invalid file type. Only JPG, JPEG & PNG files are allowed.']);
                    return;
                }
                
                // Move uploaded file
                if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                    // Store relative path in database
                    $foodItem->FoodImage = BASE_PATH.'/public/assets/images/'.$fileName;
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to upload image']);
                    return;
                }
            }else{
                echo json_encode(['success' => false, 'message' => 'No Image found']);
                return;
            }
            
            $result = AddFoodItem($foodItem);
            if ($result !== true) {
                echo json_encode(['success' => false, 'message' => 'Failed to add food item: ' . $result]);
                return;
            }
            
            echo json_encode(['success' => true, 'message' => 'Food Item added successfully']);
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
        $id = $data['FoodItem_ID'];
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

        ////////////////////////

       
            
            if(!isset($_POST['FoodName'])){
                echo json_encode(['success' => false, 'message' => 'Food Name Required!!']);
                    return;
            }

            if(!isset($_POST['FoodPrice'])){
                echo json_encode(['success' => false, 'message' => 'Food Price Required!!']);
                    return;
            }

            if(!isset($_POST['FoodPreparationTime'])){
                echo json_encode(['success' => false, 'message' => 'Food Preparation Time Required!!']);
                    return;
            }

            if(!isset($_POST["FoodCategory"])){
                echo json_encode(['success' => false, 'message' => 'Food Category Required!!']);
                    return;
            }

            $foodItem = new FoodItem();
            $foodItem->FoodItem_ID = $_POST['FoodItem_ID'];
            $foodItem->FoodName = $_POST['FoodName'];
            $foodItem->FoodType = $_POST['FoodType'];
            $foodItem->FoodPrice = $_POST['FoodPrice'];
            $foodItem->FoodPreparationTime = $_POST['FoodPreparationTime'];
            $foodItem->FoodCategory = $_POST['FoodCategory'];
            $foodItem->FoodDescription = $_POST['FoodDescription'];
            
            if(isset($_POST['foodCategory'])){
                $foodItem->FoodCategory = $_POST['foodCategory'];
            }
            
            // Handle image if uploaded
            if ( isset($_FILES['FoodImage'])) {
                $uploadDir = __DIR__ . '/../../public/assets/images/';
            
                // Create directory if it doesn't exist
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $file = $_FILES['FoodImage'];
                
                // Generate unique filename
                $fileName = $foodItem->FoodName . '_' . basename($file['name']);
                $targetPath = $uploadDir . $fileName;
                
                // Allowed Validate file type array
                $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
                if (!in_array($file['type'], $allowedTypes)) {
                    echo json_encode(['success' => false, 'message' => 'Invalid file type. Only JPG, JPEG & PNG files are allowed.']);
                    return;
                }
                
                // Move uploaded file
                if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                    // Store relative path in database
                    $foodItem->FoodImage = BASE_PATH.'/public/assets/images/'.$fileName;
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to upload image']);
                    return;
                }
            }
            
            
            
        $res = updateFoodItem($foodItem);
        if(is_string($res)){
            echo json_encode(['success'=>false, 'message'=>$res]);

            return ;
        }  
        echo json_encode(['success'=>true, 'message'=>'Edited Successfully']);

        ////////////////////////
        
        


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
        $id = $data['Category_ID'];
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

    function EditCategory(){
        if($_SERVER['REQUEST_METHOD']!=='POST'){
            echo json_encode(['success'=>false, 'message'=>'Failed to remove due to invalid request method']);
            return ;           
        }
        $data =  json_decode(file_get_contents("php://input"), true);
        if(!$data){
            echo json_encode(['success'=>false, 'message'=>'Invalid data format']);
            return;
        }
		
        $id = $data['categoryID'];
        $name = $data['categoryName'];
        $res = EditCategoryData($id,$name);
        if($res){
            echo json_encode(['success'=>true, 'message'=>'Edited Data Successfully']);
        }else{
            echo json_encode(['success'=>false, 'message'=>'Failed to edit data']);

        }
    }
?>