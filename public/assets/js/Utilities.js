function isValidEmail(email){
 
    var regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    email.trim();
    alert(email);
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
    var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*\W).{6,15}$/;
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

function isValidName(name){
    var regex = /^[a-zA-Z]+$/;
    name.trim();
    var res = regex.test(name);
    if(!res) alert("Name is not valid");
    return res;
}

function formatNumber(number){
    let formattedNumber = new Intl.NumberFormat('en-US', { minimumIntegerDigits: 2 }).format(number);
    return formattedNumber;
}

function formatTime(dateTimeString) {
    // Replace space with 'T' to make it ISO-compliant
    const date = new Date(dateTimeString.replace(' ', 'T'));

    // Extract hours and minutes
    const hours = date.getHours();
    const minutes = date.getMinutes();

    // Format hours and minutes
    const formattedHours = hours % 12 || 12; // Convert to 12-hour format
    const formattedMinutes = String(minutes).padStart(2, '0'); // Ensure two digits

    // Determine AM/PM
    const period = hours >= 12 ? 'PM' : 'AM';

    // Return the formatted time
    return `${formattedHours}:${formattedMinutes} ${period}`;
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
    try{
        const response = await fetch(BASE_PATH + endpoint, {
            method: "POST",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                "Content-Type": "application/json",
            },
            body: JSON.stringify(body),
        });
        return response.json();
    } catch (error) {
        return error;
    }
}

async function fetchFormDataPost(endpoint, body) {
    try {
        const response = await fetch(BASE_PATH + endpoint, {
            method: "POST",
            body: body,
        });
        return response.json();
    } catch (error) {
        return error;
    }
}