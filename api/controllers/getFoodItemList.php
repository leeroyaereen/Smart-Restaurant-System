<?php
	// require_once "../middleware/databaseConnector.php";

	// $foodItems = array();

    // $query = "SELECT * FROM fooditems";

    // $result = mysqli_query($connection, $query);

    // if ($result && mysqli_num_rows($result) > 0) {
    //     while ($row = mysqli_fetch_assoc($result)) {
    //         $foodItems[] = $row;
    //     }
    //     return ["foodItems" => $foodItems, "success" => true];
    // } else {
    //     echo "No food items found in the database.";
    //     return ["success" => false, "message" => "No food items found in the database."];
    // }
    function retrieveFooditems(){
        echo "Hello from retrieveFooditems";
        return ["success" => false, "message" => "No food items found in the database."];
    }
?>