<html>
    <head>
         <meta charset="UTF-8">
         <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
        <title> Payment</title>
        <script src="assets/js/config.js.php"></script>
        <script src="assets/js/Payment.js"></script>
        <script src="assets/js/Utilities.js"></script>
        <link rel="stylesheet" href="assets/css/Payment.css">
        <link rel="stylesheet" href="assets/css/PageStructure.css">
    </head>
    <body>
        <div class="payment-container">
            <div class="payment-box" id="paymentForm-box">
                <h2>Payment</h2>

                <form id="paymentForm"  method="POST">
                    <center>
                        <div><img src="/Smart-Restaurant-System/public/assets/images/khalti.png" alt="khalti" width="200"></div>
                    </center>
                    <div class="input-group">
                        <label for="khaltiID"> Khalti ID </label>
                        <input type="tel" id="khaltiID" placeholder="Your Khalti Id" required>
                    </div>
                    
                    <div class="input-group">
                        <label for="MPIN"> MPIN </label>
                        <input type="password" id="MPIN" placeholder="Your Khalti MPIN" required>
                    </div>
                    
                    <div class="input-group" >
                        <button type="submit" class="payment-button"> Pay Rs <b id='priceAmount'></b></button>
                        <button class="back" onclick="CancelPaymentAndReturn()">Cancel</button>
                    </div>
                    
                </form>
            </div>

            <div class="payment-box" id="comfirmPayment-box">
                <h2>Confirm Payment</h2>
                <table class="">
                    <tr class="tableRow">
                        <td>Khalti ID :</td>
                        <td id="c_khaltiID">0000000</td>
                    </tr>
                    <tr class="tableRow">
                        <td>Sender Name :</td>
                        <td id="c_username">abc</td>
                    </tr>
                    <tr class="tableRow">
                        <td>Reciever Name :</td>
                        <td id="c_restaurantName">abc</td>
                    </tr>
                    <tr class="tableRow">
                        <td>Amount :</td>
                        <td> <span id="c_amount">00000</span></td>
                    </tr>
                </table>
                <button class="confirm-button" id="confirmPayment">Confirm</button>
            </div>

            <div class="payment-box" id="OTP-box">
                <form action="pay.php" method="post">
                    <!-- Requires value from backend -->
                    <input type="hidden" name="token" id="khaltiToken">
                    <!-- Requires value from backend -->
                    <input type="hidden" name="mpin" id ="khaltiMpin">
                    <h2>OTP </h2>
                    <div class="input-group">                    
                        <input type="number" value="" name="otp" id="otpCode" placeholder="xxxx">
                    </div>
                    <button id="confirmOTP" class="confirm-button">Confirm OTP</button>
                </form>
            </div>
        </div>
    
    </body>
</html>
 