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
                <center>
                    <div><img src="/Smart-Restaurant-System/public/assets/images/khalti.png" alt="khalti" width="200"></div>
                </center>
                <div>
                    <template class="hidden-template" id="OrderListItemTemplate">
                        <div id="OrderListItemReview">
                            <div id="ItemName"></div>
                            <div id="ItemOrderDetails">
                                <div id="ItemPrice">Rs <span id="ItemPriceValue"></span></div>
                                <div id="ItemQuantity">Qty: <span id="ItemQuantityValue"></span></div>
                                <div id="ItemTotalPrice">Total: Rs <span id="ItemTotalPriceValue"></span></div>
                            </div>
                        </div>
                    </template>
                </div>
                <div class="input-group" >
                    <button type="submit" class="payment-button" id="PayButton"> Pay Rs <b id='priceAmount'></b></button>
                    <button class="back" onclick="CancelPaymentAndReturn()" id="CancelButton">Cancel</button>
                </div>
            </div>
        </div>
    
    </body>
</html>
 