const categoryList = document.querySelector("#foodCategoryList");
const categoryTemplate = document.querySelector("#foodCategoryTemplate");

const menuItemList = document.querySelector("#MenuItemList");
const menuItemTemplate = document.querySelector("#MenuItemTemplate");
let menuItems;

window.onload = loadPage;

async function fetchData(endpoint) {
    const response = await fetch(BASE_PATH + endpoint, {
        method: "GET",
        headers: {
            "X-Requested-With": "XMLHttpRequest",
            "Content-Type": "application/json",
        },
    });
    return response.json();
}

async function loadPage() {
    try {
        // Fetch categories
        const categoriesData = await fetchData("/api/getFoodCategories");
		console.log(categoriesData);
        fillCategory(categoriesData.foodCategories);
        
        // Fetch food items
        const foodItemsData = await fetchData("/api/getFoodItems");
        console.log(foodItemsData);

        if (!foodItemsData.success) {
            alert(foodItemsData.message);
            return;
        }

        fillMenu(foodItemsData.foodItems);
    } catch (error) {
        console.error("Error fetching data:", error);
        alert("An error occurred while loading the page.");
    }
}

function fillCategory(data) {
	Object.entries(data).forEach(([id, category]) => {
		let templateClone = categoryTemplate.content.cloneNode(true);
		let foodCategory = templateClone.querySelector("#foodCategory");
		foodCategory.innerText = category;
		categoryList.appendChild(foodCategory);
	});
}

function fillMenu(data) {
	data.forEach((item) => {
		let templateClone = menuItemTemplate.content.cloneNode(true);
		let menuItem = templateClone.querySelector("#MenuItem");
		menuItem.querySelector("#MenuItemName").innerText = item.FoodName;
		menuItem.querySelector("#MenuItemSubCategory").innerText = item.FoodType;
		menuItem.querySelector("#MenuItemPrice span").innerText = item.FoodPrice;
		menuItem.querySelector("#MenuItemDuration span").innerText = item.FoodPreparationTime+" min";
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
	window.location.href = "confirm-order";
};
