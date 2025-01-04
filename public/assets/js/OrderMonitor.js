const orderContainerTemplate = document.querySelector("#OrderContainerTemplate");
const orderItemTemplate = document.querySelector("#OrderItemTemplate");

window.onload = fillOngoingOrders;

async function fillOngoingOrders(){
    const ongoingOrdersData = await fetchDataGet("/api/getAllMonitorOrderDetail");
    console.log(ongoingOrdersData.data);

    if (!ongoingOrdersData.success) {
        alert("couldn't fetch ongoing orders");
        return;
    }

    ongoingOrdersData.data.forEach((order) => {
        const orderContainerClone = orderContainerTemplate.content.cloneNode(true);
        const orderContainer = orderContainerClone.querySelector("#OrderContainer");
        orderContainer.querySelector("#OrderNumber").innerText =  "Order "+order.OrderTray_ID;
        orderContainer.querySelector("#OrderTime").innerText = formatTime(order.KitchenOrderTime);
        orderContainer.querySelector("#OrderCID").innerText = "CID: "+order.User_ID;

        Object.entries(order.Orders).forEach(([id, item]) => {
            const orderItemClone = orderItemTemplate.content.cloneNode(true);
            const orderItem = orderItemClone.querySelector("#OrderItem");
            orderItem.querySelector("#OrderItemName").innerText = item.FoodName + "-" + item.FoodTypes;
            orderItem.querySelector("#OrderItemPrice").innerText = "Rs "+ item.Price;
            orderItem.querySelector("#OrderItemQuantity").innerText = "Qty: "+ 10;
            orderItem.querySelector("#OrderItemNote").innerText = item.Notes;
            orderItem.querySelector("#OrderItemStatus").innerText = item.OrderStatus;

            orderContainer.querySelector("#OrderItemsList").appendChild(orderItem);
        })   
        document.querySelector("#OrderMonitorBody").appendChild(orderContainer);

    })

    document.querySelector("#ActiveOrdersCount").innerText = ongoingOrdersData.data.length;
}