<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register</title>
    <link rel="stylesheet" href="assets/css/RegisterPage.css">

    <script src="assets/js/config.js.php"></script>
    <script src="assets/js/RegistrationValidator.js" defer></script>
	<script src="assets/js/Utilities.js"></script>
</head>
<body>
    <div class="register-container">
        <div class="register-box">
            <h2>Register</h2>
            <form id="registerForm"> 
                
                <div class="input-group">
                    <label for="firstName">First Name</label>
                    <input type="text" id="firstName" placeholder="First Name"required/>
                </div>

                <div class="input-group">
                    <label for="lastName">Last Name</label>
                    <input type="text" id="lastName" placeholder="Last Name" required/>
                </div>
                
                
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" placeholder="Example@gmail.com" required/>
                </div>
                
                <div class="input-group">
                    <label for="phoneNumber">Mobile Number:</label>
                    <input type="tel" id="phoneNumber" placeholder='9876543210'required/>
                </div>
                
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" placeholder='Example123#'required/>
                </div>
             
                <div class="input-group">
                    <label for="confirmPassword">Confirm Password</label>
                    <input type="password" id="confirmPassword" placeholder='Example123#'required/>
                </div>
                
                <button type="submit" class="register-button">Register</button>
            </form>
        </div>
    </div>
</body>
</html>