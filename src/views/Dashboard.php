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
