<?php
    require "../PHP/DatabaseUtilities.php";
    function AddCategory(){
        if(isset($_POST['categoryName']) ){
            
            if($_POST['categoryName']){
                DatabaseUtility::CreateCategory($_POST['categoryName']);
            }else{
                echo "<script>alert('The form has been aborted due to missing data in the form, recheck and submit the form again')</script>";

            }
        }
    }

    function AddFoodItem(){
        //check if the form submission has required data or not
        if(isset($_POST['foodName'],$_POST['foodType'],$_POST['foodCategory'],$_POST['foodPreparationTime'],$_POST['foodPrice'],$_POST['foodImage'],$_POST['foodDescription'])){
            //check if the data from the form fulfills the requirement
            if($_POST['foodName'] && $_POST['foodCategory'] && $_POST['foodPreparationTime'] && $_POST['foodPrice'] /*&& $_POST['foodImage']*/&& $_POST['foodDescription']){
                $newFood = new FoodItem();
                $newFood->FoodName = $_POST['foodName'];
                $newFood->FoodType = $_POST['foodType'];
                $newFood->FoodCategory = $_POST['foodCategory'];
                $newFood->FoodPreparationTime = $_POST['foodPreparationTime'];
                $newFood->FoodPrice = $_POST['foodPrice'];
                $newFood->FoodImage = $_POST['foodImage'];
                $newFood->FoodDescription = $_POST['foodDescription'];
                $newFood->FoodReview = "No Reviews Yet";
                $newFood->FoodAvailability = true;
                $newFood->FoodRating = 0;        
                
                $res = DatabaseUtility::CreateItems($newFood);

                if($res){
                    echo "<script>alert('Food Item Added');</script>";
                }else{
                    echo "<script>alert('Food Item Couldnt be Added');</script>";
                }
   
            }else{
                echo "<script>".$_POST['foodName'].$_POST['foodCategory'].$_POST['foodPreparationTime'].$_POST['foodPrice'].$_POST['foodDescription']."</script>";
                echo "<script>alert('The form has been aborted due to missing data in the form, recheck and submit the form again')</script>";
            }
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        DatabaseUtility::ChangeRestaurant('ACHS Canteen');
        if (isset($_POST["categoryName"])) {
            AddCategory();
        } else if (isset($_POST["foodName"])) {
            AddFoodItem();
        } else {
            echo "<script>alert('Please Enter the Data');</script>";
        }            

    }
    
?>

<html>
    <head>
    
    </head>
    <body>
        <!-- Form for adding a category -->
        <form method="POST" action="">
            <label for="categoryName">Category Name</label>
            <input type="text" id="categoryName" name="categoryName"/>
            <button type="submit">Add Category</button>
        </form>

        <!-- Form for adding a food item -->
        <form method="POST" action="">
            <div class="input-group">
                <label for="foodName">Food Name</label>
                <input type="text" id="foodName" name="foodName"/>
            </div>
            <div class="input-group">
                <label for="foodType">Food Type</label>
                <input type="text" id="foodType" name="foodType" list="foodTypeLists"/>
                <datalist id="foodTypeLists">
                    <!-- <option value="Normal">System Analysis and Design</option> -->
                </datalist>
            </div>
            <div class="input-group">
                <label for="foodCategory">Set in Category</label>
                <select name="foodCategory">

                <?php
                    $sql = "SELECT Category_ID, CategoryName FROM FoodCategory";
                    $conn = DatabaseUtility::GetRestaurantConnectionWithName('ACHS Canteen');
                    if(!$conn){
                        echo "<script>alert('There was null')</script>";

                    }
                    $res = $conn->query($sql);

                    if ($res) {
                        while ($row = mysqli_fetch_assoc($res)) {
                            echo "<option value='" . $row['Category_ID'] . "'>" . $row['CategoryName'] . "</option>";
                        }
                    } else {
                        echo "<script>alert('There was an error adding category')</script>";
                    }
                ?>

                    
                </select>
            </div>
            <div class="input-group">
                <label for="foodPreparationTime">Time For Preparation</label>
                <input type="number" id="foodPreparationTime" name="foodPreparationTime"/>
            </div>
            <div class="input-group">
                <label for="foodDescription">Description of food</label>
                <textarea id="foodDescription" name="foodDescription"></textarea>
            </div>
            <div class="input-group">
                <label for="foodPrice">Price</label>
                <input type="number" step="0.01" name="foodPrice" id="foodPrice"/>
            </div>
            <div class="input-group">
                <label for="foodImage">Food Image</label>
                <input type="file" id="foodImage" name="foodImage"/>
            </div>
            <button type="submit">Add Food Item</button>
        </form>
    </body>
</html>
