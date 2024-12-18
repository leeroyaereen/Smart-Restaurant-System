function isValidEmail(email){
 
    var regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    let res = regex.test(email);
    if(!res) alert("Email is not valid");
    return res;
}

function isValidPhoneNumber(phoneNumber){
    var regex =  /^(\+?\d{1,3}[- ]?)?\d{10}$/;
    phoneNumber.trim();
    var res = regex.test(phoneNumber);
    if(!res) alert("Phone Number is not valid");
    return res;
}

function isValidPassword(password){
    var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*\W).{6,}$/;
    password.trim();
    var res = regex.test(password);
    if(!res) alert("Password is not valid");
    return res;
}

function isValidWithConfirmPassowrd(password, confirmPassword){
    var res = password===confirmPassword? true: false;
    if(!res) alert("Confirm password doesn't match with the password");
    return res;
}

function formatNumber(number){
    let formattedNumber = new Intl.NumberFormat('en-US', { minimumIntegerDigits: 2 }).format(number);
    return formattedNumber;
}

async function fetchDataGet(endpoint) {
    const response = await fetch(BASE_PATH + endpoint, {
        method: "GET",
        headers: {
            "X-Requested-With": "XMLHttpRequest",
            "Content-Type": "application/json",
        },
    });
    return response.json();
}

async function fetchDataPost(endpoint, body) {
    const response = await fetch(BASE_PATH + endpoint, {
        method: "POST",
        headers: {
            "X-Requested-With": "XMLHttpRequest",
            "Content-Type": "application/json",
        },
        body: JSON.stringify(body),
    });
    return response.json();
}