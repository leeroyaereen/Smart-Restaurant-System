window.onload = loadTrayItems;

const trayCategoryTemplate = document.querySelector("#TrayCategoryTemplate");
const trayItemsList = document.querySelector("#TrayItemsList");
const subTotal = document.querySelector('#subTotalValue');
const discount = document.querySelector('#discountValue');
const total = document.querySelector('#totalValue');
const confirmationButton = document.querySelector('#ConfirmationButton Button');

let FoodItemList;
let discountPercentage = 10;

async function loadTrayItems(){
    const TrayItemsData = await fetchDataGet("/api/getTrayItems");
    console.log(TrayItemsData);

    if (!TrayItemsData.success) {
        alert(TrayItemsData.message);
        return;
    }

    fillTrayItems(TrayItemsData.TrayItems);
}

function fillTrayItems(data) {
    Object.entries(data).forEach(([id, category]) => {
        let categoryTemplateClone = trayCategoryTemplate.content.cloneNode(true);
        let trayCategory = categoryTemplateClone.querySelector("#TrayCategory");

        trayCategory.dataset.id = id;
        trayCategory.querySelector('#TrayCategoryTitle').innerText = category["CategoryName"];

        let categoryItems = trayCategory.querySelector("#TrayCategoryItems");

        category["foodItems"].forEach((item) => {
            let itemDetails = item["foodItemDetails"];
            let trayItemTemplateClone = categoryItems.querySelector("#TrayItemTemplate").content.cloneNode(true);
            let trayItem = trayItemTemplateClone.querySelector("#TrayItem");    

            console.log(itemDetails);
            console.log(item.Quantity);
            trayItem.dataset.id = itemDetails.FoodItem_ID;

            trayItem.querySelector("#TrayItemName").innerText = itemDetails.FoodName;
            trayItem.querySelector("#TrayItemSubCategory").innerText = itemDetails.FoodType;
            trayItem.querySelector("#TrayItemPrice span").innerText = Math.floor(itemDetails.FoodPrice);

            let trayItemQuantity = trayItem.querySelector(".ItemQuantity");
            trayItemQuantity.querySelector("span").innerText = formatNumber(item.Quantity);
            addQuantityCounter(trayItemQuantity);
            observer.observe(trayItemQuantity.querySelector("span"), {childList: true});
            categoryItems.appendChild(trayItem);

        });

        trayItemsList.appendChild(trayCategory);
    });
    FoodItemList = document.querySelectorAll('#TrayItem');
    calculateTotal();
}

function calculateTotal(){
    let subTotalPrice = calculateOrderCost(FoodItemList);
    subTotal.innerText = subTotalPrice;
    let discountPrice = Math.floor(subTotalPrice * (discountPercentage / 100));
    discount.innerText = discountPrice;
    total.innerText = subTotalPrice - discountPrice;
}

// Initialize the MutationObserver
const observer = new MutationObserver(() => {
    calculateTotal();
});

confirmationButton.onclick = () => {
    let orderItems = [];

    FoodItemList.forEach((item) => {
        let orderItem = {
            "FoodItem_ID": parseInt(item.dataset.id),
            "Quantity": parseInt(item.querySelector('.ItemQuantity span').innerText),
            "Note": item.querySelector('#TrayItemNote textarea').value
        }
        orderItems.push(orderItem)
    })
    storeOrder(orderItems);
}

async function storeOrder(orderItems){

    const OrderItemsResponse = await fetchDataPOST("/api/placeOrder", orderItems);
    if (OrderItemsResponse.success){
        alert("order placed successfully");
    }else{
        alert("some error occured")
    }
    
}


