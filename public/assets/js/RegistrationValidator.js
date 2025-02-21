const form = document.querySelector("#registerForm");
const firstName = document.querySelector("#firstName");
const lastName = document.querySelector("#lastName");
const email = document.querySelector("#email");
const phoneNumber = document.querySelector("#phoneNumber");
const password = document.querySelector("#password");
const confirmPassword = document.querySelector("#confirmPassword");


form.addEventListener("submit", function (event) {
	event.preventDefault(); //prevent Submission

	//bool value to track if the form inpust is valid
    let isValidForm = isValidWithConfirmPassowrd(password.value, confirmPassword.value) && isValidPhoneNumber(phoneNumber.value) && isValidPassword(password.value) && isValidEmail(email.value) && isValidName(firstName.value) && isValidName(lastName.value);
	// isValidForm = isValidEmail(email.value) && isValidPhoneNumber(phoneNumber.value) && isValidPassword(password.value) && isValidWithConfirmPassowrd(password.value, confirmPassword.value);

	console.log(isValidForm);

	if (isValidForm) {
        let userData = {
            firstName: firstName.value,
            lastName: lastName.value,
            email: email.value,
            phoneNumber: phoneNumber.value,
            password: password.value,
        };
        registerUser(userData);
	}
});

async function registerUser(userData) {
	const registrationStatus = await fetchDataPost("/api/registerUser", userData);
    if (registrationStatus.success) {
        alert("Registration Successful");
        if(await CheckIfUserIsAdmin()){
            window.location.href = "order-monitor";
            return;
        }
        window.location.href = "menu";
    } else {
        alert("Registration Failed: "+registrationStatus.message);
    }

}
