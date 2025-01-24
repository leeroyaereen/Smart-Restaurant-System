const form = document.querySelector("#AddFoodItemForm");
const formButton = document.querySelector("#CreateFoodItem");
const foodItemToggle = document.querySelector("#FoodItemToggle");
const foodCategoryToggle = document.querySelector("#FoodCategoryToggle");
const foodItemSection = document.querySelector("#FoodItemSection");
const foodCategorySection = document.querySelector("#FoodCategorySection");

const categorizedFoodItems = document.querySelector("#EditFoodItemSectionItems");
const editCategoryItems = document.querySelector("#EditCategorySectionItems");

window.onload = function () {
	fillCategories();
	fillCategorizedFoodItems();
}

foodItemToggle.addEventListener("click", () => {
	foodItemToggle.classList.add("active");
	foodCategoryToggle.classList.remove("active");
	foodItemSection.classList.remove("hidden");
	foodCategorySection.classList.add("hidden");
});

foodCategoryToggle.addEventListener("click", () => {
	foodItemToggle.classList.remove("active");
	foodCategoryToggle.classList.add("active");
	foodItemSection.classList.add("hidden");
	foodCategorySection.classList.remove("hidden");
});

async function fillCategories() {
	console.log("fillFormCategories");
	const categoriesData = await fetchDataGet("/api/getFoodCategories");
	console.log(categoriesData);

	if (!categoriesData.success) {
		alert("couldn't fetch categories");
		return;
	}

	const categories = document.querySelector("select");
	Object.entries(categoriesData.foodCategories).forEach(([id, category]) => {
		const option = document.createElement("option");
		option.value = id;
		option.innerText = category;
		categories.append(option);

		let EditCategoryTemplateClone = document.querySelector("#EditCategoryTemplate").content.cloneNode(true);
		let EditCategory = EditCategoryTemplateClone.querySelector("#EditCategory");
		EditCategory.id = "EditCategory";
		EditCategory.querySelector("#EditCategoryTitle").innerText = categoriesData.foodCategories[id];
		editCategoryItems.append(EditCategory);
	});
}


async function fillCategorizedFoodItems() {
	const categorizedFoodItemsData = await fetchDataGet("/api/getCategorizedFoodItems");
	console.log(categorizedFoodItemsData);

	if (!categorizedFoodItemsData.success) {
		alert("couldn't fetch food items");
		return;
	}
	Object.entries(categorizedFoodItemsData.categorizedFoodItems).forEach(([id, category]) => {
		console.log(id,category);
		if(category["foodItems"].length === 0){
			return;
		}
		const EditFoodItemCategoryContainer = document.createElement("div");
		EditFoodItemCategoryContainer.id = "EditFoodItemCategoryContainer";
		const EditFoodItemCategory = document.createElement("div");
		EditFoodItemCategory.id = "EditFoodItemCategory";
		EditFoodItemCategory.dataset.id = id;
		EditFoodItemCategory.innerText = category["CategoryName"];
		EditFoodItemCategoryContainer.append(EditFoodItemCategory);

		category["foodItems"].forEach((item) => {
			let EditFoodItemTemplateClone = document.querySelector("#EditFoodItemTemplate").content.cloneNode(true);
			let EditFoodItem = EditFoodItemTemplateClone.querySelector("#EditFoodItem");
			EditFoodItem.id = "EditFoodItem";
			EditFoodItem.dataset.id = item.FoodItem_ID;
			EditFoodItemCategoryContainer.append(EditFoodItem);
		});
		categorizedFoodItems.append(EditFoodItemCategoryContainer);
	});
}

// ... other existing variables ...

formButton.addEventListener("click", async (e) => {
    e.preventDefault();
    
    // Create FormData object to handle file upload
    const formData = new FormData();
    
    // Get the file input
    const imageFile = form.querySelector("#FoodImage").files[0];
    if (imageFile) {
        formData.append("foodImage", imageFile);
    }
    
    // Add other form fields
    formData.append("foodName", form.querySelector("#FoodName").value);
    formData.append("foodCategory", form.querySelector("#FoodCategory").value);
    formData.append("foodPreparationTime", form.querySelector("#FoodPreparationTime").value);
    formData.append("foodPrice", form.querySelector("#FoodPrice").value);
    formData.append("foodDescription", form.querySelector("#FoodDescription").value);
    
    try {
        const response = await fetch(BASE_PATH+"/api/addFoodItem", {
			method: "POST",
			headers: {
				"X-Requested-With": "XMLHttpRequest",
			},
			body: formData
		});
        
        const addFoodResponse = await response.json();
        console.log(addFoodResponse);
        
        if (addFoodResponse.success) {
            alert("Food Item Added Successfully");
            await fillCategorizedFoodItems();
        } else {
            alert(addFoodResponse.message || "Failed to add food item");
        }
    } catch (error) {
        console.error("Error adding food item:", error);
        alert("Failed to add food item"+error+" "+ formData.get("foodName"));
    }
});
