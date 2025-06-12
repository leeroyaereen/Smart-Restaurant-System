<html>
    <head>
         <meta charset="UTF-8">
         <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
        <title> Payment</title>
        <script src="assets/js/config.js.php"></script>
        <script src="assets/js/payment.js"></script>
        <script src="assets/js/Utilities.js"></script>
        <link rel="stylesheet" href="assets/css/Payment.css">
    </head>
    <body>
        <div class="payment-container">
            <div class="payment-box" id="paymentForm-box">
                <h2>Payment</h2>

                <form id="paymentForm"  method="POST">
                    <div class="input-group">
                        <label for="esewaID"> Esewa ID </label>
                        <input type="tel" id="esewaID" placeholder="Your Esewa Id" required>
                    </div>
                    
                    <div class="input-group">
                        <label for="MPIN"> MPIN </label>
                        <input type="password" id="MPIN" placeholder="Your Esewa Id" required>
                    </div>
                    
                    <div class="input-group" >
                        <button type="submit" class="payment-button"> Next</button>
                        <button class="back" onclick="CancelPaymentAndReturn()">Cancel</button>
                    </div>
                    
                </form>
            </div>

            <div class="payment-box" id="comfirmPayment-box">
                <table class="">
                    <tr class="tableRow">
                        <td>Esewa ID :</td>
                        <td id="c_esewaID"></td>
                    </tr>
                    <tr class="tableRow">
                        <td>Sender Name :</td>
                        <td id="c_esewaID"></td>
                    </tr>
                    <tr class="tableRow">
                        <td>Reciever Name :</td>
                        <td id="c_esewaID"></td>
                    </tr>
                    <tr class="tableRow">
                        <td>Amount :</td>
                        <td id="c_esewaID"></td>
                    </tr>
                </table>
                <button class="confirm-button">Confirm</button>
            </div>
        </div>
        <!-- <form action="https://rc-epay.esewa.com.np/api/epay/main/v2/form" method="POST">
    <input type="text" id="amount" name="amount" value="100" required>
    <input type="text" id="tax_amount" name="tax_amount" value ="10" required>
    <input type="text" id="total_amount" name="total_amount" value="110" required>
    <input type="text" id="transaction_uuid" name="transaction_uuid" value="241028" required>
    <input type="text" id="product_code" name="product_code" value ="EPAYTEST" required>
    <input type="text" id="product_service_charge" name="product_service_charge" value="0" required>
    <input type="text" id="product_delivery_charge" name="product_delivery_charge" value="0" required>
    <input type="text" id="success_url" name="success_url" value="https://developer.esewa.com.np/success" required>
    <input type="text" id="failure_url" name="failure_url" value="https://developer.esewa.com.np/failure" required>
    <input type="text" id="signed_field_names" name="signed_field_names" value="total_amount,transaction_uuid,product_code" required>
    <input type="text" id="signature" name="signature" value="i94zsd3oXF6ZsSr/kGqT4sSzYQzjj1W/waxjWyRwaME=" required>
    <input value="Submit" type="submit">
    </form> -->
    </body>
</html>
 