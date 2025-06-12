const form = document.querySelector('#paymentForm');
const esewaID = document.querySelector("#esewaID");
const mpin = document.querySelector("#MPIN");

document.onload = function(){
    form.addEventListener("submit", OnSubmit(event));
    const confirmPaymentBoxDiv = document.querySelector("#confirmPaymentBox");
    confirmPaymentBoxDiv.style.display = "block";
}
function CancelPaymentAndReturn(){
    window.location.href = "Review";

}

function OnSubmit(event){
    event.preventDefault();
    alert("PaymentSuccess");
    let isValidForm = true;
    isValidForm = isValidPhoneNumber(esewaID.value) && isValidMPIN(mpin.value);
    if(!isValidForm){
        return;
    }   
    window.location.href = "paymentConfirm"; 
    window.location.href = "https:rc-epay.esewa.com.np/api/epay/main/v2/form";
}
