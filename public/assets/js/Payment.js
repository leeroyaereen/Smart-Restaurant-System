let priceAmount;
let payButton;
let cancelButton;


document.addEventListener('DOMContentLoaded', function() {
    LoadDetails();    
});

async function LoadDetails() {
    payButton = document.getElementById("PayButton");
    cancelButton = document.getElementById("CancelButton");
    priceAmount = document.getElementById("priceAmount");

    let orderToPay = await fetchDataGet("/api/getOrderTray");

    //--------------------to be worked on later------------------------------ss
    // Object.entries(categoriesData.foodCategories).forEach(([id, category]) => {
	// 	let templateClone = categoryTemplate.content.cloneNode(true);
	// 	let foodCategory = templateClone.querySelector("#foodCategory");
	// 	foodCategory.dataset.id = id;
	// 	foodCategory.innerText = category;
	// 	categoryList.appendChild(foodCategory);
	// });
    

    const totalAmount = await fetchDataGet("/api/getTotalPriceOfOrderTray");
    if (!totalAmount.success) {
        alert("Couldn't fetch total amount"+ totalAmount.message);
        return;
    }
    priceAmount.innerText = totalAmount.TotalAmount; // Example price, replace with actual logic to fetch price

    payButton.addEventListener("click", OnSubmit());
    cancelButton.addEventListener("click", CancelPaymentAndReturn());
}

function CancelPaymentAndReturn(){
    window.location.href = "Review";
}

function OnSubmit(){
    fetchFormDataPost("/api/getPaymentID", "").then((response) => {
        if (response.success) {
            
            let paymentUrl = response.payment_url;
            window.location.href = paymentUrl;
        } else {
            alert(response.message);
        }
    });

}
