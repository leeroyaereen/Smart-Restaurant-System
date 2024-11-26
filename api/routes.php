<?php
    function route($request) {
        switch ($request) {
            case 'getFoodItems/a':
                require_once __DIR__ . '/controllers/getFoodItemList.php';
                retrieveFoodItems(); // Example function in UserController.php
                break;
    
            // case 'v1/create-user':
            //     require_once __DIR__ . '/controllers/UserController.php';
            //     createUser(); // Another example function
            //     break;
    
            default:
                http_response_code(404);
                echo json_encode(['error' => 'Endpoint not found']);
                break;
        }
    }
    
?>