window.onload = fillOrders;

async function fillOrders() {
    const OrderStatusData = await fetchDataGet("/api/getAllOrderForTracking");
    console.log(OrderStatusData);
}