<?php_ini_loaded_file()
    
?>

<html>
    <head>

    </head>
    <body>
        <form action="">
            <label for="categoryName"> Category Name</label>
            <input type="text" id="categoryName" name="categoryNameTextField"/>

            <button onclick="submit">Add Category</button>
        </form>

        <form>
            <label for="foodName"> Food Name</label>
            <input type="text" id="foodName" name="foodName"/>

            <label for="foodPreparationTime"> Time For Preparation</label>
            <input type="number" id="foodPreparationTime" name="foodPreparationTime"/>

            <label for="foodDescription">Description of food</label>
            <textarea id="foodDescription"></textarea>

            <label for="foodPrice">Price</label>
            <input type="decimal" name="foodPrice" id="foodPrice"/>

            <label for="foodImage">Food Image</label>
            <input type="image" id="foodImage" name="foodImage"/>
                
            <button onclick="submit">Add Food Item</button>
        </form>
    </body>
</html>