const orderContainerTemplate = document.querySelector("#OrderContainerTemplate");
const orderItemTemplate = document.querySelector("#OrderItemTemplate");

window.onload = function () {
    CheckIfUserIsAdmin();
    
}
async function CheckIfUserIsAdmin(){
    const response = await fetchDataGet("/api/isUserAdmin");
    if (response.success && response.isAdmin) {
        fillOngoingOrders();
        console.log("Admin is logged in");
    }else{
        alert("You are not authorized to view this page");
        window.location.href = "login";
    }
}

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
            orderItem.querySelector("#OrderItemQuantity").innerText = "Qty: "+ item.Quantity;
            orderItem.querySelector("#OrderItemNote").innerText = item.Notes;
            orderItem.querySelector("#OrderItemStatus").innerText = item.OrderStatus;
            orderItem.querySelector("#OrderItemStatus").classList.add("OrderStatus-"+item.OrderStatus);

            orderItem.querySelector("#OrderItemStatusDropdown").addEventListener("change", async (e) => {
                const status = e.target.value;
                e.disabled = true;
                if (await updateOrderStatus(item.OrderItem_ID, status)){
                    orderItem.querySelector("#OrderItemStatus").innerText = status;
                    orderItem.querySelector("#OrderItemStatus").classList = `OrderStatusDesign OrderStatus-${status}`;
                }else{
                    alert("couldn't update order status");
                }
                e.disabled = false;
            });

            orderContainer.querySelector("#OrderItemsList").appendChild(orderItem);
        })   
        document.querySelector("#OrderMonitorBody").appendChild(orderContainer);

    })

    await fetchTotalRevenue();

    document.querySelector("#ActiveOrdersCount").innerText = ongoingOrdersData.data.length;
}
async function fetchTotalRevenue(){
    const response = await fetchDataGet("/api/getTotalRevenueOfDay");
    if (response.success) {
        if(response.revenue == null){
            response.revenue = 0;
        }
        document.querySelector("#DayRevenue").innerText = "Rs "+response.revenue;
    }else{
        alert("couldn't fetch total revenue");
    }
}
async function updateOrderStatus(itemId, status){
    console.log(itemId, status);
    const response = await fetchDataPost("/api/changeOrderItemStatus", {
        OrderItem_ID: itemId,
        OrderStatus: status
    });

    if (!response.success) {
        console.log(response);
        return false;
    }
    return true;
}