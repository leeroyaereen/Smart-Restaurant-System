const orderStatusOrderTemplate = document.querySelector("#OrderStatusOrderNumberContainerTemplate");
const orderStatusItemTemplate = document.querySelector("#OrderStatusItemTemplate");

window.onload = fillOrders;

setInterval(refreshStatus, 5000);

async function fillOrders() {
    // const OrderStatusData = await fetchDataGet("/api/getAllOrderForTracking");
    // console.log(OrderStatusData);

    // if (!OrderStatusData.success) {
    //     alert("couldn't fetch ongoing orders");
    //     return;
    // }

    // OrderStatusData.OrderedItems.forEach((orderItem) => {
    //     const orderStatusItemClone = orderStatusItemTemplate.content.cloneNode(true);
    //     const orderStatusItem = orderStatusItemClone.querySelector("#OrderStatusItem");
    //     orderStatusItem.dataset.id = orderItem.OrderItem_ID;
    //     orderStatusItem.querySelector("#StatusItemName").innerText = orderItem.FoodName;
    //     orderStatusItem.querySelector("#StatusItemType").innerText = orderItem.FoodType;
    //     orderStatusItem.querySelector("#StatusItemPrice").innerText = "Rs " + orderItem.FoodPrice;
    //     orderStatusItem.querySelector("#StatusItemQuantity").innerText = "Qty: " + orderItem.Quantity;
    //     orderStatusItem.querySelector("#StatusItemNote").innerText = orderItem.Note;
    //     orderStatusItem.querySelector("#StatusItemStatus").innerText = orderItem.OrderStatus;
    //     orderStatusItem.querySelector("#StatusItemStatus").classList.add("OrderStatus-" + orderItem.OrderStatus);
    //     if (orderItem.FoodImage) {
    //         orderStatusItem.querySelector("#StatusItemImage img").src = orderItem.FoodImage;
    //     }

    //     document.querySelector("#OrderStatusList").appendChild(orderStatusItem);
    // });
    if(!CheckIfUserIsLoggedIn()){
        alert("You are not logged in to view this page");
        window.location.href = "login";
    }
    if(!isUserCustomer()){
        alert("You are not authorized to view this page");
        window.location.href = "login";
    }
    const OrderStatusData = await fetchDataGet("/api/getUserActiveOrderStatus");
    console.log(OrderStatusData);

    if (!OrderStatusData.success) {
        alert("couldn't fetch ongoing orders");
        return;
    }

    OrderStatusData.OrderTrays.forEach((orderTray) => {
        let TotalPrice = 0;
        let ongoingOrder = false;
        const orderStatusOrderClone = orderStatusOrderTemplate.content.cloneNode(true);
        const orderStatusOrder = orderStatusOrderClone.querySelector("#OrderStatusOrderNumberContainer");
        orderStatusOrder.querySelector("#OrderStatusOrderNumber").innerText = "Order " + orderTray.OrderTray_ID;
        // orderStatusOrder.querySelector("#OrderStatusOrderTotal").innerText = "Total: Rs " + orderTray.TotalPrice;
        orderTray.OrderItems.forEach((orderItem) => {
            if (orderItem.OrderStatus == "InQueue" || orderItem.OrderStatus == "Preparing" || orderItem.OrderStatus == "Ready" || orderItem.OrderStatus == "Served") {
                ongoingOrder = true;
            }
            TotalPrice += orderItem.Price * orderItem.Quantity;
            const orderStatusItemClone = orderStatusItemTemplate.content.cloneNode(true);
            const orderStatusItem = orderStatusItemClone.querySelector("#OrderStatusItem");
            orderStatusItem.dataset.id = orderItem.OrderItem_ID;
            orderStatusItem.querySelector("#StatusItemName").innerText = orderItem.FoodName;
            orderStatusItem.querySelector("#StatusItemType").innerText = orderItem.FoodTypes;
            orderStatusItem.querySelector("#StatusItemPrice").innerText = "Rs " + orderItem.Price;
            orderStatusItem.querySelector("#StatusItemQuantity").innerText = "Qty: " + orderItem.Quantity;
            orderStatusItem.querySelector("#StatusItemNote").innerText = orderItem.Notes;
            let status = orderStatusItem.querySelector("#StatusItemStatus");
            status.innerText = orderItem.OrderStatus;
            status.addEventListener("click", async (e) => {
                let res = confirm("Are you sure you want to cancel this order?");
                if (res) {
                    e.disabled = true;
                    if (await cancelOrder(orderItem.OrderItem_ID)) {
                        status.innerText = "Cancelled";
                        status.classList = `OrderStatusDesign OrderStatus-Cancelled`;
                    } else {
                        alert("couldn't update order status");
                    }
                    e.disabled = false;
                }
            });
            orderStatusItem.querySelector("#StatusItemDuration span").innerText = orderItem.OrderItem_ID + "mins";
            orderStatusItem.querySelector("#StatusItemStatus").classList.add("OrderStatus-" + orderItem.OrderStatus);
            if (orderItem.FoodImage) {
                orderStatusItem.querySelector("#StatusItemImage img").src = orderItem.FoodImage;
            }

            orderStatusOrder.querySelector("#OrderStatusOrderItemList").appendChild(orderStatusItem);
        });
        orderStatusOrder.querySelector("#OrderStatusOrderTotal").innerHTML = "<div>Total:</div> Rs " + TotalPrice;
        if (ongoingOrder) {
            document.querySelector(".OngoingOrdersList").appendChild(orderStatusOrder);
        }
        else{
            document.querySelector(".PreviousOrdersList").appendChild(orderStatusOrder);

        }
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
        if (!orderStatusItem) {
            return;
        }
        orderStatusItem.querySelector("#StatusItemStatus").innerText = orderItem.OrderItemStatus;
        orderStatusItem.querySelector("#StatusItemStatus").classList = `OrderStatusDesign OrderStatus-${orderItem.OrderItemStatus}`;
    });

}

async function cancelOrder(OrderItem_ID) {
    const response = await fetchDataPost(`/api/cancelOrder`, { 'OrderItem_ID': OrderItem_ID });
    if(!response.success){
        alert(response.message);
    }
    return response.success;
}