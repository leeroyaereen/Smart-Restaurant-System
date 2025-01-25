const orderStatusItemTemplate = document.querySelector("#OrderStatusItemTemplate");

window.onload = fillOrders;

setInterval(refreshStatus, 5000);

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
        orderStatusItem.dataset.id = orderItem.OrderItem_ID;
        orderStatusItem.querySelector("#StatusItemName").innerText = orderItem.FoodName;
        orderStatusItem.querySelector("#StatusItemType").innerText = orderItem.FoodType;
        orderStatusItem.querySelector("#StatusItemPrice").innerText = "Rs " + orderItem.FoodPrice;
        orderStatusItem.querySelector("#StatusItemQuantity").innerText = "Qty: " + orderItem.Quantity;
        orderStatusItem.querySelector("#StatusItemNote").innerText = orderItem.Note;
        orderStatusItem.querySelector("#StatusItemStatus").innerText = orderItem.OrderStatus;
        orderStatusItem.querySelector("#StatusItemStatus").classList.add("OrderStatus-" + orderItem.OrderStatus);

        document.querySelector("#OrderStatusList").appendChild(orderStatusItem);
    });
}

async function refreshStatus() {
    const UpdatedOrderStatusData = await fetchDataGet("/api/getUpdatedItemStatus");
    console.log(UpdatedOrderStatusData);

    if (!UpdatedOrderStatusData.success) {
        alert("couldn't fetch updated status");
        return;
    }

    UpdatedOrderStatusData.OrderedItems.forEach((orderItem) => {
        const orderStatusItem = document.querySelector(`[data-id="${orderItem.OrderItem_ID}"]`);
        orderStatusItem.querySelector("#StatusItemStatus").innerText = orderItem.OrderItemStatus;
        orderStatusItem.querySelector("#StatusItemStatus").classList = `OrderStatusDesign OrderStatus-${orderItem.OrderItemStatus}`;
    });

}