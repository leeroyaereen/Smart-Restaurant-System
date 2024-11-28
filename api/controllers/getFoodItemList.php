<?php
    function retrieveFooditems($conn){
        $foodItems = array();

        $query = "SELECT * FROM fooditems";
    
        $result = mysqli_query($conn, $query);
    
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $foodItems[] = $row;
            }
            echo json_encode(["foodItems" => $foodItems, "success" => true]);
            return ;
        } else {
            echo json_encode(["message" => "No food items found in the database.", "success" => false]);
            return ;
        }
    }
?>