const addFoodItemForm = document.querySelector("#AddFoodItemForm");
const addFoodItemFormButton = document.querySelector("#CreateFoodItem");
const addFoodItemFormImage = document.querySelector(
	"#FoodImageContainer input[type='file']"
);
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

const selectCategory = document.querySelectorAll(".selectCategory");

const editFoodItemFormContainer = document.querySelector(
	"#EditFoodItemFormContainer"
);
const EditFoodItemForm =
	editFoodItemFormContainer.querySelector("#EditFoodItemForm");

const editCategoryFormContainer = document.querySelector(
	"#EditCategoryFormContainer"
);
const EditCategoryForm =
	editCategoryFormContainer.querySelector("#EditCategoryForm");

// Live Image Preview
const editItemImgInput = EditFoodItemForm.querySelector("#EditFoodImage");
const addItemImgInput = addFoodItemForm.querySelector("#FoodImage");

const editItemImgPreview = EditFoodItemForm.querySelector(
	"#EditFoodItemImage img"
);
const addItemImgPreview = addFoodItemForm.querySelector(
	"#FoodImageContainer img"
);

addItemImgInput.addEventListener("change", changeAddImgPreview);

function changeAddImgPreview() {
	const file = addItemImgInput.files[0];
	if (file) {
		addFoodItemForm.querySelector("#FoodImageContainer").style.border = "none";
		addFoodItemForm
			.querySelector("#FoodImageContainer #AddFoodItemImage")
			.classList.remove("hidden");
		addFoodItemForm
			.querySelector("#FoodImageContainer svg")
			.classList.add("hidden");
		addFoodItemForm.querySelector("#FoodImageContainer").style.padding = "0";

		console.log("change");
		const reader = new FileReader();
		reader.onload = function (e) {
			addItemImgPreview.src = e.target.result;
		};
		reader.readAsDataURL(file);
	} else {
		addFoodItemForm
			.querySelector("#FoodImageContainer #AddFoodItemImage")
			.classList.add("hidden");
		addFoodItemForm
			.querySelector("#FoodImageContainer svg")
			.classList.remove("hidden");
		addFoodItemForm.querySelector("#FoodImageContainer").style.border =
			"2px dashed #fed7aa";
		addFoodItemForm.querySelector("#FoodImageContainer").style.padding =
			"4rem 0";
	}
}

editItemImgInput.addEventListener("change", changeEditImgPreview);

function changeEditImgPreview() {
	const file = editItemImgInput.files[0];
	if (file) {
		const reader = new FileReader();
		reader.onload = function (e) {
			editItemImgPreview.src = e.target.result;
		};
		reader.readAsDataURL(file);
	}
}

////////////////////////

window.onload = function () {
	CheckIfUserIsAdmin();
	fillCategories();
	fillCategorizedFoodItems();
};

async function CheckIfUserIsAdmin() {
	const response = await fetchDataGet("/api/isUserAdmin");
	if (response.success && response.isAdmin) {
		console.log("Admin is logged in");
	} else {
		alert("You are not authorized to view this page");
		window.location.href = "login";
	}
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
	selectCategory.innerHTML = "";
	editCategoryItems.innerHTML = "";

	const categoriesData = await fetchDataGet("/api/getFoodCategories");
	console.log(categoriesData);

	if (!categoriesData.success) {
		alert("couldn't fetch categories");
		return;
	}

	Object.entries(categoriesData.foodCategories).forEach(([id, category]) => {
		selectCategory.forEach((e) => {
			const option = document.createElement("option");
			option.value = id;
			option.innerText = category;
			e.append(option);
		});
		let EditCategoryTemplateClone = document
			.querySelector("#EditCategoryTemplate")
			.content.cloneNode(true);
		let EditCategory = EditCategoryTemplateClone.querySelector("#EditCategory");
		EditCategory.id = "EditCategory";
		EditCategory.querySelector("#EditCategoryTitle").innerText =
			categoriesData.foodCategories[id];
		EditCategory.dataset.id = id;
		EditCategory.querySelector("#EditCategoryButton").addEventListener(
			"click",
			() => {
				EditCategoryClicked(id);
			}
		);

		EditCategory.querySelector("#DeleteCategoryButton").addEventListener(
			"click",
			async () => {
				DeleteCategoryClicked(id);
			}
		);
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
			const EditFoodItemCategoryItems = document.createElement("div");
			EditFoodItemCategoryItems.id = "EditFoodItemCategoryItems";
			EditFoodItemCategoryContainer.append(EditFoodItemCategory);
			EditFoodItemCategoryContainer.append(EditFoodItemCategoryItems);

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
				EditFoodItem.querySelector(
					"#EditFoodItemPreparationTime span"
				).innerText = item.FoodPreparationTime;
				EditFoodItem.querySelector("#EditFoodItemPrice span").innerText =
					item.FoodPrice;
				EditFoodItem.querySelector("#EditFoodItemImage img").src =
					item.FoodImage;
				EditFoodItem.querySelector("#EditFoodItemButton").addEventListener(
					"click",
					() => {
						EditFoodItemClicked(item.FoodItem_ID);
					}
				);

				EditFoodItem.querySelector("#DeleteFoodItemButton").addEventListener(
					"click",
					async () => {
						DeleteFoodItemClicked(item.FoodItem_ID);
					}
				);
				EditFoodItemCategoryItems.append(EditFoodItem);
			});
			categorizedFoodItems.append(EditFoodItemCategoryContainer);
		}
	);
}

addFoodItemFormButton.addEventListener("click", (e) => {
	e.preventDefault();
	submitFoodItemForm(addFoodItemForm);
});

async function submitFoodItemForm(form) {
	const formData = new FormData();
	var foodName = form.querySelector("#FoodName").value;
	if (!isValidName(foodName)) {
		return;
	}

	var foodPrice = form.querySelector("#FoodPrice").value;
	if (!checkPrice(foodPrice)) {
		return;
	}
	formData.append("foodName", foodName);
	formData.append("foodCategory", form.querySelector(".selectCategory").value);
	formData.append("foodType", form.querySelector("#FoodType").value);
	formData.append(
		"foodPreparationTime",
		form.querySelector("#FoodPreparationTime").value
	);
	formData.append("foodPrice", foodPrice);
	formData.append(
		"foodDescription",
		form.querySelector("#FoodDescription").value
	);

	const imageFile = form.querySelector("#FoodImage").files[0];

	if (imageFile) {
		formData.append("foodImage", imageFile);
	}
	for (let [key, value] of formData.entries()) {
		console.log(key, value);
	}
	const addFoodResponse = await fetchFormDataPost("/api/addFoodItem", formData);
	console.log(addFoodResponse);

	if (!addFoodResponse.success) {
		alert("couldn't add food item");
		return;
	}

	alert("Food Item Added Successfully");
	form.reset();
	changeAddImgPreview();
	await fillCategorizedFoodItems();
}

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

var selectedFoodItemId;

function EditFoodItemClicked(FoodItem_ID) {
	document.querySelector(".Body").classList.add("noInteractions");

	editFoodItemFormContainer.classList.remove("hidden");
	selectedFoodItemId = FoodItem_ID;
	const FoodItem = categorizedFoodItems.querySelector(
		`#EditFoodItem[data-id="${FoodItem_ID}"]`
	);
	console.log(selectedFoodItemId);
	EditFoodItemForm.querySelector("#EditFoodName").value =
		FoodItem.querySelector("#EditFoodItemTitle").innerText;
	EditFoodItemForm.querySelector("#EditFoodCategory").value = FoodItem.closest(
		"#EditFoodItemCategoryContainer"
	).querySelector("#EditFoodItemCategory").dataset.id;
	EditFoodItemForm.querySelector("#EditFoodType").value =
		FoodItem.querySelector("#EditFoodItemType").innerText;
	EditFoodItemForm.querySelector("#EditFoodDescription").value =
		FoodItem.querySelector("#EditFoodItemDescription").innerText;
	EditFoodItemForm.querySelector("#EditFoodItemImage img").src =
		FoodItem.querySelector("#EditFoodItemImage img").src;
	console.log(FoodItem.querySelector("#EditFoodItemPrice").innerText);
	EditFoodItemForm.querySelector("#FoodPrice").value = parseFloat(
		FoodItem.querySelector("#EditFoodItemPrice span").innerText
	);
	EditFoodItemForm.querySelector("#FoodPreparationTime").value =
		FoodItem.querySelector("#EditFoodItemPreparationTime span").innerText;
}

EditFoodItemForm.onsubmit = async (e) => {
	e.preventDefault();
	const formData = new FormData();
	formData.append("FoodItem_ID", selectedFoodItemId);
	console.log(selectedFoodItemId);
	var foodName = EditFoodItemForm.querySelector("#EditFoodName").value;
	if (!isValidName(foodName)) {
		return;
	}
	formData.append("FoodName", foodName);
	formData.append(
		"FoodCategory",
		EditFoodItemForm.querySelector("#EditFoodCategory").value
	);
	formData.append(
		"FoodType",
		EditFoodItemForm.querySelector("#EditFoodType").value
	);
	formData.append(
		"FoodDescription",
		EditFoodItemForm.querySelector("#EditFoodDescription").value
	);
	var foodPrice = EditFoodItemForm.querySelector("#FoodPrice").value;
	if (!checkPrice(foodPrice)) {
		return;
	}
	formData.append("FoodPrice", foodPrice);
	formData.append(
		"FoodPreparationTime",
		EditFoodItemForm.querySelector("#FoodPreparationTime").value
	);

	if (editItemImgInput.files.length > 0) {
		formData.append("FoodImage", editItemImgInput.files[0]);
	}

	const editFoodItemResponse = await fetchFormDataPost(
		"/api/editFoodItem",
		formData
	);
	console.log(editFoodItemResponse);

	if (!editFoodItemResponse.success) {
		alert("couldn't edit food item");
		return;
	}

	alert("Food Item Edited Successfully");
	editFoodItemFormContainer.classList.add("hidden");
	document.querySelector(".Body").classList.remove("noInteractions");
	fillCategorizedFoodItems();
};

document
	.querySelector("#CancelFoodItemChanges")
	.addEventListener("click", async () => {
		document.querySelector(".Body").classList.remove("noInteractions");
		editFoodItemFormContainer.classList.add("hidden");
	});

let editCategoryID;

function EditCategoryClicked(Category_ID) {
	document.querySelector(".Body").classList.add("noInteractions");

	editCategoryFormContainer.classList.remove("hidden");

	const Category = editCategoryItems.querySelector(
		`#EditCategory[data-id="${Category_ID}"]`
	);
	editCategoryID = Category_ID;
	console.log(Category);
	EditCategoryForm.querySelector("#CategoryName").value =
		Category.querySelector("#EditCategoryTitle").innerText;
}

EditCategoryForm.onsubmit = async (e) => {
	e.preventDefault();
	var catName = EditCategoryForm.querySelector("#CategoryName").value;
	if (!isValidName(catName)) {
		return;
	}
	const formData = {
		categoryName: catName,
		categoryID: editCategoryID,
	};

	const editCategoryResponse = await fetchDataPost(
		"/api/editCategory",
		formData
	);
	console.log(editCategoryResponse);

	if (!editCategoryResponse.success) {
		alert("couldn't edit category");
		return;
	}

	alert("Category Edited Successfully");
	editCategoryFormContainer.classList.add("hidden");
	document.querySelector(".Body").classList.remove("noInteractions");
	fillCategories();
};

async function DeleteCategoryClicked(Category_ID) {
	const deleteCategoryResponse = await fetchDataPost("/api/removeCategory", {
		Category_ID,
	});
	console.log(deleteCategoryResponse);

	if (!deleteCategoryResponse.success) {
		alert("couldn't delete category");
		return;
	}

	alert("Category Deleted Successfully");
	fillCategories();
}

async function DeleteFoodItemClicked(FoodItem_ID) {
	const deleteFoodItemResponse = await fetchDataPost("/api/removeFoodItem", {
		FoodItem_ID,
	});
	console.log(deleteFoodItemResponse);

	if (!deleteFoodItemResponse.success) {
		alert("couldn't delete food item");
		return;
	}

	alert("Food Item Deleted Successfully");
	fillCategorizedFoodItems();
}

document
	.querySelector("#CancelCategoryChanges")
	.addEventListener("click", async () => {
		document.querySelector(".Body").classList.remove("noInteractions");
		editCategoryFormContainer.classList.add("hidden");
	});
