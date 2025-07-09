
let form;
let khaltiID;
let mpin;
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
    khaltiID = document.querySelector("#khaltiID");
    mpin = document.querySelector("#MPIN");
    priceAmount = document.querySelector("#priceAmount");

    confirmPaymentButton = document.querySelector("#confirmPayment");
    confirmUsername = document.querySelector("c_username");
    confirmKhaltiID = document.querySelector("c_khaltiID");
    confirmRestaurantName = document.querySelector("c_restaurantName");

    confirmOTP = document.querySelector("#confirmOTP");

    form.addEventListener("submit", (event) => {
        OnSubmit(event);
    });
    confirmPaymentBoxDiv = document.querySelector("#comfirmPayment-box");
    confirmPaymentBoxDiv.style.display = "none";

    otpBox = document.querySelector("#OTP-box");
    if (otpBox) {
        otpBox.style.display = "none";
    }
});
function CancelPaymentAndReturn(){
    window.location.href = "Review";

}

function OnSubmit(event){
    event.preventDefault();
    alert("PaymentSuccess");
    let isValidForm = true;
    isValidForm = isValidPhoneNumber(khaltiID.value) && isValidMPIN(mpin.value);
    if(!isValidForm){
        return;
    }   

}
