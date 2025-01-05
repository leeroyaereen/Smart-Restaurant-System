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

formButton.addEventListener("click", async (e) => {
	e.preventDefault();
	const formData = {
		foodName: form.querySelector("#FoodName").value,
		foodCategory: form.querySelector("#FoodCategory").value,
		foodPreparationTime: form.querySelector("#FoodPreparationTime").value,
		foodPrice: form.querySelector("#FoodPrice").value,
		foodDescription: form.querySelector("#FoodDescription").value,
	};
	
	const addFoodResponse = await fetchDataPost("/api/addFoodItem", formData)
	console.log(addFoodResponse);

	if (addFoodResponse.success) {
		alert("Food Item Added Successfully");
	}
});
