<?php
    function route($request) {
        $parsedRequest = strtok($request, '?');
        switch ($parsedRequest) {
            // case 'getFoodItems':
            //     require_once __DIR__ . '/controllers/getFoodItemList.php';
            //     retrieveFoodItems($connection); // Example function in UserController.php
            //     break;
    
            // case 'v1/create-user':
            //     require_once __DIR__ . '/controllers/UserController.php';
            //     createUser(); // Another example function
            //     break;

            case 'addFoodItem':
                require_once __DIR__ . '/controllers/AdminDashboardController.php';
                CreateFoodItem();
                break;
                
            case 'getFoodItems':
                require_once __DIR__ . '/controllers/contentMenuController.php';
                getFoodItemsJSON();
                break;
            
            case 'getFoodItemsByCategory':
                require_once __DIR__ . '/controllers/contentMenuController.php';
                getFoodItemsByCategoryParameter();
                break;

            case 'getFoodCategories':
                require_once __DIR__ . '/controllers/contentMenuController.php';
                getFoodCategoriesJSON();
                break;

            case 'getCategorizedFoodItems':
                require_once __DIR__ . '/controllers/contentMenuController.php';
                getCategorizedFoodItemsJSON();
                break;

            case 'setTrayItems':
                require_once __DIR__ . '/controllers/contentMenuController.php';
                setTrayItems();
                break;

            case 'getTrayItems':
                require_once __DIR__ . '/controllers/contentMenuController.php';
                getTrayItems();
                break;

            case 'registerUser':
                require_once __DIR__ . '/controllers/userController.php';
                registerUser();
                break;

            case 'loginUser':
                require_once __DIR__ . '/controllers/userController.php';
                loginUser();
                break;
                
            case 'placeOrder':
                require_once __DIR__ . '/controllers/orderPlacementController.php';
                PlaceOrder();
                break;

            case 'getAllMonitorOrderDetail':
                require_once __DIR__ . '/controllers/orderMonitorController.php';
                getMonitorDetails();
                break;

            case 'getAllOrderForTracking':
                require_once __DIR__ . '/controllers/orderTrackingController.php';
                getAllOrderStatus();
                break;
            
            case 'getUpdatedItemStatus':
                require_once __DIR__ . '/controllers/orderTrackingController.php';
                getOnlyStatus();
                break;

            case 'cancelOrder':
                require_once __DIR__ . '/controllers/orderTrackingController.php';
                CancelOrder();
                break;

            case 'changeOrderItemStatus':
                require_once __DIR__.'/controllers/orderMonitorController.php';
                ChangeState();
                break;

            case 'editFoodItem':
                require_once __DIR__ . '/controllers/AdminDashboardController.php';
                EditFoodItem();
                break;

            case 'removeFoodItem':
                require_once __DIR__ . '/controllers/AdminDashboardController.php';
                RemoveFoodItem();
                break;

            case 'removeCategory':
                require_once __DIR__ . '/controllers/AdminDashboardController.php';
                RemoveCategory();
                break;

            case 'addCategory':
                require_once __DIR__ . '/controllers/AdminDashboardController.php';
                AddCategory();
                break;
            case 'editCategory':
                require_once __DIR__ . '/controllers/AdminDashboardController.php';
                EditCategory();
                break;
            
            case 'isUserAdmin':
                require_once __DIR__ . '/controllers/userController.php';
                isUserAdmin();
                break;
            case 'getUserActiveOrderStatus':
                require_once __DIR__ . '/controllers/orderTrackingController.php';
                getAllUserActiveOrderStatus();
                break;
            case 'getTotalRevenueOfDay':
                require_once __DIR__ . '/controllers/orderMonitorController.php';
                GetTotalRevenueOfDay();
                break;

            case 'checkIfUserIsLoggedIn':
                require_once __DIR__ . '/controllers/userController.php';
                checkIfUserIsLoggedIn();
                break;
            case 'checkIfUserIsCustomer':
                require_once __DIR__ . '/controllers/userController.php';
                checkIfUserIsCustomer();
                break;
            default:
                http_response_code(404);
                echo json_encode(['error' => 'Endpoint not found']);
                break;
        }
    }
    
?>