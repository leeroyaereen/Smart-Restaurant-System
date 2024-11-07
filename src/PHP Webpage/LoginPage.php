<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../CSS/LoginPage.css">
  <script type="module" src="../JS/LoginValidator.js"></script>
</head>
<body>

  <div class="login-container">
    <div class="login-box">
      <h2>Login</h2>
      
      <form  id="loginForm">
        <div class="input-group">
          <label for="phone">Phone Number</label>
          <input type="tel" id="phone" placeholder="Your phone number" required>
        </div>

        <div class="input-group">
          <label for="password">Password</label>
          <input type="password" id="password" placeholder="Password" required>
          <!-- <span class="show-password">&#128065;</span> -->
        </div>

        <div class="forgot-password">
          <a href="#">Forgot password?</a>
        </div>

        <button type="submit" class="login-button">LOGIN</button>

        <div class="divider">
          <span>Or</span>
        </div>

        <div class="action-buttons">
          <button type="button" class="sign-up" onclick="window.location.href='/src/HTML/RegisterPage.html'">Sign Up</button>
          <button type="button" class="skip" onclick="window.location.href='/src/HTML/ContentMenu.html'">Skip</button>
        </div>
      </form>
    </div>
  </div>

</body>
</html>
