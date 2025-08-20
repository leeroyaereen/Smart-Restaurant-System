<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Success</title>
    <link rel="stylesheet" href="assets/css/loginpage.css">
    <style>
        body { font-family: Arial, sans-serif; background: #f8f8f8; text-align: center; padding-top: 60px; }
        .container { background: #fff; padding: 40px 30px; border-radius: 8px; display: inline-block; box-shadow: 0 2px 8px rgba(0,0,0,0.1);}
        .success { color: #27ae60; font-size: 2em; margin-bottom: 20px; }
        .btn { display: inline-block; margin: 10px 15px; padding: 12px 28px; font-size: 1em; border: none; border-radius: 5px; cursor: pointer; }
        .btn-order { background: #27ae60; color: #fff; }
        .btn-exit { background: #e74c3c; color: #fff; }
    </style>
</head>
<body>
    <div class="container">
        <div class="success">&#10004; Payment Successful!</div>
        <p>Your payment has been completed successfully.</p>
        <form action="menu"  style="display:inline;">
            <button class="btn btn-order" type="submit">Order More</button>
        </form>
        <form action="logout" method="post" style="display:inline;">
            <button class="btn btn-exit" type="submit">Log out</button>
        </form>
    </div>
</body>
</html>
