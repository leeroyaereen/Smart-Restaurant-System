const form = document.querySelector("#AddFoodItemForm");
const foodItemToggle = document.querySelector("#FoodItemToggle");
const foodCategoryToggle = document.querySelector("#FoodCategoryToggle");
const foodItemSection = document.querySelector("#FoodItemSection");
const foodCategorySection = document.querySelector("#FoodCategorySection");

window.addEventListener("load", fillFormCategories);
window.addEventListener("load", fillCategorizedFoodItems);


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

async function fillFormCategories() {
	
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
	});
}


async function fillCategorizedFoodItems() {
	const categorizedFoodItemsData = await fetchDataGet("/api/getCategorizedFoodItems");
	console.log(categorizedFoodItemsData);

	if (!categorizedFoodItemsData.success) {
		alert("couldn't fetch food items");
		return;
	}

	const categorizedFoodItems = document.querySelector("#EditFoodItemSectionItems");
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
form.addEventListener("submit", (e) => {
	e.preventDefault();
	const formData = {
		foodName: form.querySelector("#FoodName").value,
		foodCategory: form.querySelector("#FoodCategory").value,
		foodPreparationTime: form.querySelector("#FoodPreparationTime").value,
		foodPrice: form.querySelector("#FoodPrice").value,
		foodDescription: form.querySelector("#FoodDescription").value,
	};
	fetch(`${BASE_PATH}/api/addFoodItem`, {
		method: "POST",
		headers: {
			"Content-Type": "application/json",
			"X-Requested-With": "XMLHttpRequest",
		},
		body: JSON.stringify(formData),
	})
		.then((response) => {
			response.json();
		})
		.then((data) => {
			//window.location.href = "dashboard";
			if (data.success) {
				alert("Food item added successfully");
			} else {
				alert("Failed to add food item");
			}
		})
		.catch((error) => {
			console.error("Error:", error);
		});
});
