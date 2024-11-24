//Imports function from Utilities module
import { isValidPhoneNumber,isValidPassword,isValidEmail,isValidWithConfirmPassowrd } from './Utilities.js';

//invokes the function when the document gets loaded.
document.addEventListener('DOMContentLoaded',function(){
    var form = document.getElementById("registerForm");

    form.addEventListener('submit',function(event){

        //gettig all values from the form
        var firstName = document.getElementById("firstName").value;
        var lastName = document.getElementById("lastName").value;
        var email = document.getElementById("email").value;
        var phoneNumber = document.getElementById("phoneNumber").value;
        var password = document.getElementById("password").value;
        var confirmPassword = document.getElementById("confirmPassword").value;

        event.preventDefault();//prevent Submission

        //bool value to track if the form inpust is valid
        let isValidForm = false;

        isValidForm =isValidEmail(email) && isValidPhoneNumber(phoneNumber) && isValidPassword(password) && isValidWithConfirmPassowrd(password,confirmPassword); 

        console.log(isValidForm);
        if(isValidForm){
            window.location.href = '/src/HTML/LoginPage.html';
            alert("Your Registration is being verified");
        }
    });
});

