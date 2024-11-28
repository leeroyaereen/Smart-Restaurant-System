const menuItemList = document.querySelector("#MenuItemList");
const menuItemTemplate = document.querySelector("#MenuItemTemplate");

window.onload = loadMenu;

document.querySelector("#OrderButton Button").onclick = () => {
	window.location.href = "confirm-order";
};

function loadMenu() {
	fetch(BASE_PATH + "/api/getFoodItems")
		.then((response) => response.json())
		.then((data) => {
			fillMenu(data);
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
		menuItemList.appendChild(menuItem);
	});
}
