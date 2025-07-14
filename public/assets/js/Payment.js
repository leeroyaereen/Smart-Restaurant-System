
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
    let khaltiID = document.querySelector("#khaltiID");
    let mpin = document.querySelector("#MPIN");
    let isValidForm = true;
    isValidForm = isValidPhoneNumber(khaltiID.value) && isValidMPIN(mpin.value);
    if(!isValidForm){
        alert("Invalid Khalti ID or MPIN");

        return;
    }   
    let userData = {
        mobile: khaltiID.value,
        mpin: mpin.value,
    }
    userData = JSON.stringify(userData);
    fetchFormDataPost("/api/sendPaymentDetails", userData).then((response) => {
        if (response.success) {
            alert("PaymentSuccess");
            LoadConfirmPaymentBox();        
        } else {
            alert(response.message);
        }
    });

}

async function LoadConfirmPaymentBox() {
    //enable the confirm box div
    confirmPaymentBoxDiv.style.display = "block";

    //find the payment box div and disble it
    let paymentFormBoxDiv = document.querySelector("#paymentForm-box");
    paymentFormBoxDiv.style.display = "none";

    //get reference to 
    //confirm button,
    //Username text html
    //khalti text html
    //restaurantName text Html
    confirmPaymentButton = document.querySelector("#confirmPayment");
    confirmUsername = document.querySelector("c_username");
    confirmKhaltiID = document.querySelector("c_khaltiID");
    confirmRestaurantName = document.querySelector("c_restaurantName");

    const response = await fetchDataGet("/api/getNeccessaryConfimrationDetails");
    
    confirmKhaltiID.innerText = khaltiID.value;

    confirmUsername.innerText = "User"; // Replace with actual username logic
    confirmRestaurantName.innerText = "Smart Restaurant"; // Replace with actual restaurant name logic
    priceAmount.innerText = "1000"; // Example price, replace with actual logic to fetch price

    confirmPaymentButton.addEventListener("click", () => {
        
        fetchFormDataPost("/api/confirmPayment", userData).then((response) => {
            if (response.success) {
                LoadOtpBox();
            } else {
                alert(response.message);
            }
        });
    });

    
}

function LoadOtpBox() {
    otpBox.style.display = "block";
    confirmPaymentBoxDiv.style.display = "none";

    let token = document.querySelector("#khaltiToken");
    let mpin = document.querySelector("#khaltiMpin");
    let otp = document.querySelector("#otpCode");
    confirmOTP = document.querySelector("#confirmOTP");
    userData = {
        otp: otp.value,
        token: token.value,
        mpin: mpin.value,
    };


    confirmOTP.addEventListener("click", () => {
        fetchFormDataPost("/api/sendOTPCode", userData).then((response) => {
            if (response.success) {
                window.location.href = response.reDirectURL;
            
            } else {
                alert(response.message);
            }
        });

    });
}