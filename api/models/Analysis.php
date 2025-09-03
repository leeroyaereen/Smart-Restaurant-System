<?php
    require_once('RestaurantModel.php');
    require_once('FoodItemModel.php');
    require_once('OrderModel.php');
    require_once('UserModel.php');

    require_once __DIR__.'/../../config/databaseConnector.php';

    require_once __DIR__.'/../helper/foodItemClass.php'; 
    require_once __DIR__.'/../helper/orderItemClass.php'; 
    require_once __DIR__.'/../helper/orderTrayClass.php'; 
    require_once __DIR__.'/../helper/userClass.php';

    use Src\Helpers\OrderItem;

    class ManagementSystem{
        function getOrderStatisticsData(){

        }

        function getMostDemandedFoodItem(){
            
        }
    }
?>