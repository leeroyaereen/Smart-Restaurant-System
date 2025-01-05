const orderStatusItemTemplate = document.querySelector("#OrderStatusItemTemplate");

window.onload = fillOrders;

async function fillOrders() {
    const OrderStatusData = await fetchDataGet("/api/getAllOrderForTracking");
    console.log(OrderStatusData);

    if (!OrderStatusData.success) {
        alert("couldn't fetch ongoing orders");
        return;
    }

    OrderStatusData.OrderedItems.forEach((orderItem) => {
        const orderStatusItemClone = orderStatusItemTemplate.content.cloneNode(true);
        const orderStatusItem = orderStatusItemClone.querySelector("#OrderStatusItem");
        orderStatusItem.querySelector("#StatusItemName").innerText = orderItem.FoodName;
        orderStatusItem.querySelector("#StatusItemType").innerText = orderItem.FoodType;
        orderStatusItem.querySelector("#StatusItemPrice").innerText = "Rs " + orderItem.FoodPrice;
        orderStatusItem.querySelector("#StatusItemQuantity").innerText = "Qty: " + orderItem.Quantity;
        orderStatusItem.querySelector("#StatusItemNote").innerText = orderItem.Note;
        orderStatusItem.querySelector("#StatusItemStatus").innerText = orderItem.OrderStatus;

        document.querySelector("#OrderStatusList").appendChild(orderStatusItem);
    });
}