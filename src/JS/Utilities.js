export function isValidEmail(email){
    var regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    let res = regex.test(email);
    if(!res) alert("Email is not valid");
    return res;
}

export function isValidPhoneNumber(phoneNumber){
    var regex =  /^(\+?\d{1,3}[- ]?)?\d{10}$/;
    var res = regex.test(phoneNumber);
    if(!res) alert("Phone Number is not valid");
    return res;
}

export function isValidPassword(password){
    var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*\W).{6,}$/;
    var res = regex.test(password);
    if(!res) alert("Password is not valid");
    return res;
}

export function isValidWithConfirmPassowrd(password, confirmPassword){
    var res = password===confirmPassword? true: false;
    if(!res) alert("Confirm password doesn't match with the password");
    return res;
}