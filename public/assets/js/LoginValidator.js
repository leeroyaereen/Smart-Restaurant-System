import { isValidPhoneNumber,isValidPassword } from './Utilities.js';

//Invokes an event after the HTML content gets loaded. So, that the js wont run 
//before the HTML element gets loaded. As it results into NULL value in some contents like 
//form, phoneNumber and pass.

document.addEventListener("DOMContentLoaded", function(){
    var form = document.getElementById("loginForm");
    form.addEventListener('submit',function(event){
        var phoneNumber = document.getElementById('phone').value;
        var password = document.getElementById('password').value;
        console.log(phoneNumber+ " "+ password);


        event.preventDefault(); //prevents from submitting the form
        let isValidForm = false;
        isValidForm = isValidPhoneNumber(phoneNumber) && isValidPassword(password);

        if(isValidForm){
            SendLoginRequest({phoneNumber: phoneNumber,password: password});
        }
    });

});

async function SendLoginRequest(credentials){
    console.log(credentials.phoneNumber+ " "+ credentials.password);

    try{
        var resp = await fetch('http://localhost/Smart-Restaurant-System/src/routes/checkLoginData.php',{
            method: 'POST',
            headers : {
                'Content-Type': 'application/json',
            },
            body : JSON.stringify(credentials),
        });
        
        if(!resp.ok){
            throw new Error('HTTP ERROR!!! STATUS : ${resp.status}');
        }

        //stores json data in terms of object
        const data = await resp.json();

        //check if the status of the response is success or not as per the login form credentials
        if(data.status === "success"){
            //if the verification is success then shift page to the content menu
            location.href="../../src/views/ContentMenu.php";

        }else{
            //if any failure the message is show cased with reason as per defined
            alert(data.message);
        }
    }catch(e){
        alert('Login Failed'+e.message);
    }
}
