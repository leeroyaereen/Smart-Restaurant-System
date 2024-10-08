//Invokes an event after the HTML content gets loaded. So, that the js wont run 
//before the HTML element gets loaded. As it results into NULL value in some contents like 
//form, phoneNumber and pass.

document.addEventListener("DOMContentLoaded", function(){
    var form = document.getElementById("loginForm");
    form.addEventListener('submit',function(event){
        var phoneNumber = document.getElementById('phone').value;
        var password = document.getElementById('password').value;

        event.preventDefault(); //prevents from submitting the form

        checkPhoneNumber(phoneNumber);
        checkPasswordLength();
        

        function checkPasswordLength(){
            var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*\W).{6,}$/;

            if(!regex.test(password)){
                alert("The password you have entered is not valid");
            }
        }

        function checkPhoneNumber(phoneNumber){
            // if(phoneNumber.length < 10) {
            //     alert("The phone number seems to be invalid.");
            // }
            var regex =  /(?=.*[0-9]{10,10})/;
            if(!regex.test(phoneNumber)){
                alert("The Phone Number you have entered is not valid");
            }
        }

        function isValidPhoneNumber(phoneNumber){
            var regex =  /^(\+?\d{1,3}[- ]?)?\d{10}$/;
            return regex.test(phoneNumber);
        }
    });

});
