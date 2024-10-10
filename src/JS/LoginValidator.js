import { isValidPhoneNumber,isValidPassword } from './Utilities.js';

//Invokes an event after the HTML content gets loaded. So, that the js wont run 
//before the HTML element gets loaded. As it results into NULL value in some contents like 
//form, phoneNumber and pass.

document.addEventListener("DOMContentLoaded", function(){
    var form = document.getElementById("loginForm");
    form.addEventListener('submit',function(event){
        var phoneNumber = document.getElementById('phone').value;
        var password = document.getElementById('password').value;

        event.preventDefault(); //prevents from submitting the form
        let isValidForm = false;
        isValidForm = isValidPhoneNumber(phoneNumber) && isValidPassword(password);

        if(isValidForm){
            alert("Your Login is being verified");
        }
    });

});
