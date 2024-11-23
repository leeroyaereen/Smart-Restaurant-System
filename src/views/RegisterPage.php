<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register</title>
    <script type="module" src="../JS/RegistrationValidator.js"></script>
    <link rel="stylesheet" href="../CSS/RegisterPage.css">

</head>
<body>
    <div class="login-container">
        <div class="login-box">
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
                
                <button type="submit" class="login-button">Register</button>
            </form>
        </div>
    </div>
</body>
</html>