const addFoodItemForm = document.querySelector("#AddFoodItemForm");
const addFoodItemFormButton = document.querySelector("#CreateFoodItem");
const addCategoryForm = document.querySelector("#AddCategoryForm");
const addCategoryFormButton = document.querySelector("#CreateCategory");

const foodItemToggle = document.querySelector("#FoodItemToggle");
const foodCategoryToggle = document.querySelector("#FoodCategoryToggle");

const foodItemSection = document.querySelector("#FoodItemSection");
const foodCategorySection = document.querySelector("#FoodCategorySection");

const categorizedFoodItems = document.querySelector(
	"#EditFoodItemSectionItems"
);
const editCategoryItems = document.querySelector("#EditCategorySectionItems");

const selectCategory = document.querySelector("#selectCategory");

window.onload = function () {
	fillCategories();
	fillCategorizedFoodItems();
};

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
	selectCategory.innerHTML = "";
	editCategoryItems.innerHTML = "";

	const categoriesData = await fetchDataGet("/api/getFoodCategories");
	console.log(categoriesData);

	if (!categoriesData.success) {
		alert("couldn't fetch categories");
		return;
	}

	Object.entries(categoriesData.foodCategories).forEach(([id, category]) => {
		const option = document.createElement("option");
		option.value = id;
		option.innerText = category;
		selectCategory.append(option);

		let EditCategoryTemplateClone = document
			.querySelector("#EditCategoryTemplate")
			.content.cloneNode(true);
		let EditCategory = EditCategoryTemplateClone.querySelector("#EditCategory");
		EditCategory.id = "EditCategory";
		EditCategory.querySelector("#EditCategoryTitle").innerText =
			categoriesData.foodCategories[id];
		editCategoryItems.append(EditCategory);
	});
}

async function fillCategorizedFoodItems() {
	categorizedFoodItems.innerHTML = "";

	const categorizedFoodItemsData = await fetchDataGet(
		"/api/getCategorizedFoodItems"
	);
	console.log(categorizedFoodItemsData);

	if (!categorizedFoodItemsData.success) {
		alert("couldn't fetch food items");
		return;
	}
	Object.entries(categorizedFoodItemsData.categorizedFoodItems).forEach(
		([id, category]) => {
			console.log(id, category);
			if (category["foodItems"].length === 0) {
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
				let EditFoodItemTemplateClone = document
					.querySelector("#EditFoodItemTemplate")
					.content.cloneNode(true);
				let EditFoodItem =
					EditFoodItemTemplateClone.querySelector("#EditFoodItem");
				EditFoodItem.id = "EditFoodItem";
				EditFoodItem.dataset.id = item.FoodItem_ID;
				EditFoodItem.querySelector("#EditFoodItemTitle").innerText =
					item.FoodName;
				EditFoodItem.querySelector("#EditFoodItemType").innerText =
					item.FoodType;
				EditFoodItem.querySelector("#EditFoodItemDescription").innerText =
					item.FoodDescription;
				EditFoodItem.querySelector("#EditFoodItemPreparationTime").innerText =
					item.FoodPreparationTime + " mins";
				EditFoodItem.querySelector("#EditFoodItemPrice").innerText =
					"Rs " + item.FoodPrice;
				EditFoodItemCategoryContainer.append(EditFoodItem);
			});
			categorizedFoodItems.append(EditFoodItemCategoryContainer);
		}
	);
}

addFoodItemFormButton.addEventListener("click", async (e) => {
	e.preventDefault();

	const formData = new FormData();
	formData.append("foodName", addFoodItemForm.querySelector("#FoodName").value);
	formData.append("foodCategory", selectCategory.value);
	formData.append(
		"foodPreparationTime",
		addFoodItemForm.querySelector("#FoodPreparationTime").value
	);
	formData.append(
		"foodPrice",
		addFoodItemForm.querySelector("#FoodPrice").value
	);
	formData.append(
		"foodDescription",
		addFoodItemForm.querySelector("#FoodDescription").value
	);

	const imageFile = addFoodItemForm.querySelector("#FoodImage").files[0];

	if (imageFile) {
		formData.append("foodImage", imageFile);
	}

	const addFoodResponse = await fetchFormDataPost("/api/addFoodItem", formData);
	console.log(addFoodResponse);

	if (!addFoodResponse.success) {
		alert("couldn't add food item");
		return;
	}

	alert("Food Item Added Successfully");
	addFoodItemForm.reset();
	await fillCategorizedFoodItems();
});

addCategoryFormButton.addEventListener("click", async (e) => {
	e.preventDefault();
	const formData = {
		categoryName: addCategoryForm.querySelector("#CategoryName").value,
	};

	const addCategoryResponse = await fetchDataPost("/api/addCategory", formData);
	console.log(addCategoryResponse);

	if (!addCategoryResponse.success) {
		alert("couldn't add category");
	}

	alert("Category Added Successfully");
	addCategoryForm.reset();
	fillCategories();
});
