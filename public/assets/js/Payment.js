
let form;
let priceAmount;

let confirmPaymentBoxDiv;
let confirmPaymentButton;
let confirmUsername;
let confirmKhaltiID;
let confirmRestaurantName;

let otpBox;
let confirmOTP;



document.addEventListener('DOMContentLoaded', function() {
    form = document.querySelector('#paymentForm');


    confirmOTP = document.querySelector("#confirmOTP");

    LoadPaymentForm();
    confirmPaymentBoxDiv = document.querySelector("#comfirmPayment-box");
    confirmPaymentBoxDiv.style.display = "none";

    otpBox = document.querySelector("#OTP-box");
    if (otpBox) {
        otpBox.style.display = "none";
    }

    
});
async function LoadPaymentForm() {
    priceAmount = document.querySelector("#priceAmount");

    form.addEventListener("submit", (event) => {
        OnSubmit(event);
    });
    const totalAmount = await fetchDataGet("/api/getTotalPriceOfOrderTray");
    if (!totalAmount.success) {
        alert("Couldn't fetch total amount"+ totalAmount.message);
        return;
    }
    priceAmount.innerText = totalAmount.TotalAmount; // Example price, replace with actual logic to fetch price
}

function CancelPaymentAndReturn(){
    window.location.href = "Review";

}

function OnSubmit(event){
    event.preventDefault();
    alert("PaymentSuccess");
    let khaltiID = document.querySelector("#khaltiID");
    let mpin = document.querySelector("#MPIN");
    let isValidForm = true;
    isValidForm = isValidPhoneNumber(khaltiID.value) && isValidMPIN(mpin.value);
    if(!isValidForm){
        return;
    }   
    let userData = {
        mobile: khaltiID.value,
        mpin: mpin.value,
    }
    fetchFormDataPost("/api/sendPaymentDetails", userData).then((response) => {
        if (response.success) {
            LoadConfirmPaymentBox();
            otpBox.style.display = "block";
            confirmPaymentBoxDiv.style.display = "none";
            confirmOTP.addEventListener("click", () => {
                sendOTP(khaltiID.value, response.token, mpin.value);
            });
           
        } else {
            alert(response.message);
        }
        });

    }

    function LoadConfirmPaymentBox() {
        confirmPaymentBoxDiv.style.display = "block";
        
        confirmPaymentButton = document.querySelector("#confirmPayment");
        confirmUsername = document.querySelector("c_username");
        confirmKhaltiID = document.querySelector("c_khaltiID");
        confirmRestaurantName = document.querySelector("c_restaurantName");
        confirmPaymentButton.addEventListener("click", () => {
            confirmPaymentBoxDiv.style.display = "none";
            otpBox.style.display = "block";
        });

        confirmKhaltiID.innerText = khaltiID.value;
        confirmUsername.innerText = "User"; // Replace with actual username logic
        confirmRestaurantName.innerText = "Smart Restaurant"; // Replace with actual restaurant name logic
        priceAmount.innerText = "1000"; // Example price, replace with actual logic to fetch price
        
    
    }

    function LoadOtpBox(){
        otpBox.style.display = "block";
        confirmPaymentBoxDiv.style.display = "none";
        confirmOTP.addEventListener("click", () => {
            sendOTP(khaltiID.value, response.token, mpin.value);
        });
    }