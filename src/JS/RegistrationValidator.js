var username = document.getElementById(usn).value;
var phoneNumber = document.getElementById(pn).value;
var password = document.getElementById(pwd).value;
var confirmPassword = document.getElementById(cpwd).value;

    //CheckEmail();
    checkPasswordLength();
    //CheckPasswordConfirm();
    

    function CheckPasswordConfirm() {
        
        var regexPassword = new RegExp(password);

       
        var passCorrect = regexPassword.test(confirmPassword);

        if (!passCorrect) {
            alert("Both passwords align");
        }
    }

    function CheckEmail(){
        var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        var emailRegex = new RegExp(emailPattern);

        if(!emailRegex.test(username)){
            alert("Incorrect");
        }
    }

    function checkPasswordLength(){
        var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*\W).{6,}$/;

        if(!regex.test(password)){
            alert("Error in password" + password);
        }else{
            alert("Successful");
        }
    }