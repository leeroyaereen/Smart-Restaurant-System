const form = document.querySelector("#loginForm");
const phoneNumber = document.querySelector("#phoneNumber");
const password = document.querySelector("#password");

form.addEventListener("submit", function (event) {
	event.preventDefault(); //prevent Submission

	//bool value to track if the form inpust is valid
	let isValidForm = true;
	isValidForm = isValidPhoneNumber(phoneNumber.value)

	if (isValidForm) {
        let userData = {
            phoneNumber: phoneNumber.value,
            password: password.value,
        };
        loginUser(userData);
	}
});

async function loginUser(userData) {
    console.log(userData);
	const loginStatus = await fetchDataPost("/api/loginUser", userData);
    console.log(loginStatus);
    if (loginStatus.success) {
        console.log("Login Successful");
        window.location.href = "menu";
    } else {
        alert(loginStatus.message);
    }

}
