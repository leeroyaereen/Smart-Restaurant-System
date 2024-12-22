
<?php
    require_once __DIR__."/../models/OrderModel.php";
    function getMonitorDetails(){
        $res = GetAllOrderDetailsForMonitoring();
        echo json_encode(["success"=>true,"data"=>$res]);
    }
?>