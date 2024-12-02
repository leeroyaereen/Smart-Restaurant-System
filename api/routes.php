<?php
    function route($request) {
        switch ($request) {
            // case 'getFoodItems':
            //     require_once __DIR__ . '/controllers/getFoodItemList.php';
            //     retrieveFoodItems($connection); // Example function in UserController.php
            //     break;
    
            // case 'v1/create-user':
            //     require_once __DIR__ . '/controllers/UserController.php';
            //     createUser(); // Another example function
            //     break;
            case 'getFoodItems':
                require_once __DIR__ . '/controllers/contentMenuController.php';
                // Example function in UserController.php
                getFoodItemsJSON();
                break;
            case 'getFoodCategories':
                require_once __DIR__ . '/controllers/contentMenuController.php';
                // Example function in UserController.php
                getFoodCategoriesJSON();
                break;

            case 'registerUser':
                require_once __DIR__ . '/controllers/userController.php';
                // Example function in UserController.php
                registerUser();
                break;
            case 'loginUser':
                require_once __DIR__ . '/controllers/userController.php';
                // Example function in UserController.php
                loginUser();
                break;
                
            default:
                http_response_code(404);
                echo json_encode(['error' => 'Endpoint not found']);
                break;
        }
    }
    
?>