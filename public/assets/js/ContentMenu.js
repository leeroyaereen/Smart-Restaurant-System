const menuItemList = document.querySelector("#MenuItemList");
const menuItemTemplate = document.querySelector("#MenuItemTemplate");
let menuItems;

window.onload = loadMenu;

function loadMenu() {
	fetch(BASE_PATH + "/api/getFoodItems")
		.then((response) => response.json())
		.then((data) => {
			fillMenu(data.foodItems);
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
