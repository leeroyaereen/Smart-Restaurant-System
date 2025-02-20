const categoryList = document.querySelector("#foodCategoryList");
const categoryTemplate = document.querySelector("#foodCategoryTemplate");

const menuItemList = document.querySelector("#MenuItemList");
const menuItemTemplate = document.querySelector("#MenuItemTemplate");
let menuItems;

let TrayItems = [];

window.onload = loadPage;

async function loadPage() {
    try {
        await fillCategory();
        await fillMenu(null);
    } catch (error) {
        console.error("Error fetching data:", error);
        alert("An error occurred while loading the page: " + error);
    }
}

async function fillCategory() {
	const categoriesData = await fetchDataGet("/api/getFoodCategories");
	console.log(categoriesData);

	if (!categoriesData.success) {
		alert(categoriesData.message);
		return;
	}

	Object.entries(categoriesData.foodCategories).forEach(([id, category]) => {
		let templateClone = categoryTemplate.content.cloneNode(true);
		let foodCategory = templateClone.querySelector("#foodCategory");
		foodCategory.dataset.id = id;
		foodCategory.innerText = category;
		categoryList.appendChild(foodCategory);
	});

	categoryList.querySelectorAll("#foodCategory").forEach((element) => {
		element.addEventListener("click", () => performFilter(element));
	});
}



async function performFilter(category) {
	if (category.classList.contains("selectedCategory")) {
		return;
	}

	categoryList.querySelectorAll("#foodCategory").forEach((element) => {
		element.classList.remove("selectedCategory");
	});

	category.classList.add("selectedCategory");

	await fillMenu(category.dataset.id);
}
async function fillMenu(categoryID) {
	let foodItemsData;
	menuItemList.innerHTML = "";

	if (!categoryID) {
		foodItemsData = await fetchDataGet("/api/getFoodItems");
		console.log(foodItemsData);
	}
	else {
		foodItemsData = await fetchDataGet(`/api/getFoodItemsByCategory?category=${categoryID}`);
		console.log(foodItemsData);
	}

	if (!foodItemsData.success) {
		alert(foodItemsData.message);
		return;
	}

	foodItemsData.foodItems.forEach((item) => {
		let templateClone = menuItemTemplate.content.cloneNode(true);
		let menuItem = templateClone.querySelector("#MenuItem");
		menuItem.dataset.id = item.FoodItem_ID;
		menuItem.querySelector("#MenuItemName").innerText = item.FoodName;
		menuItem.querySelector("#MenuItemSubCategory").innerText = item.FoodType;
		const descriptionButton = menuItem.querySelector("#descriptionContainer");
		if (descriptionButton) {
			descriptionButton.addEventListener("click", () => {
				if(item.FoodDescription){
					alert(item.FoodDescription);
				}else{
					alert("No Description Available");
				}
			});
		}
		menuItem.querySelector("#MenuItemPrice span").innerText = Math.floor(item.FoodPrice);
		menuItem.querySelector("#MenuItemDuration span").innerText = item.FoodPreparationTime+" min";
		menuItem.querySelector("#MenuItemRating span").innerText = item.FoodRating;
		if(item.FoodImage){
			menuItem.querySelector("#MenuItemImage img").src = item.FoodImage;
		}

		addQuantityCounter(menuItem.querySelector(".ItemQuantity"));
		observer.observe(menuItem.querySelector(".ItemQuantity span"), {childList: true});
		menuItemList.appendChild(menuItem);
	});
	menuItems = document.querySelectorAll('#MenuItem');
}


// Calculate Total Cost of choosen menu items without any discount and display it
const orderCost = document.querySelector("#OrderCost");

// Initialize the MutationObserver
const observer = new MutationObserver(() => {
	let total = calculateOrderCost(menuItems);
	orderCost.innerText = "Rs " + total;
});


document.querySelector("#OrderButton Button").onclick = () => {
	menuItems.forEach((element) => {
		let quantity = parseInt(element.querySelector('.ItemQuantity span').innerText);
		if (quantity > 0) {
			let item = {
				FoodItem_ID: element.dataset.id,
				Quantity: quantity,
				Note : "",
			};
			TrayItems.push(item);
		}
	});
	setTray();
};

async function setTray() {
	const setTrayStatus = await fetchDataPost("/api/setTrayItems", {TrayItems: TrayItems});
	console.log(setTrayStatus);
	if (setTrayStatus.success) {
		window.location.href = "confirm-order";
		console.log("Tray set successfully");
	}else{
		alert(setTrayStatus.message);
	}
}