function checkPaymentSuccess() {
    const response = fetch('/api/checkPaymentSuccess', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    });
    response.then(res => res.json())
        .then(data => {
            if (data.success) {
                return true;
            } else {
                alert("Payment failed: " + data.message);
                return false;
            }
        })
        .catch(error => {
            console.error('Error fetching payment status:', error);
            document.getElementById('successMessage').innerText = "An error occurred while checking payment status.";
            return false;
        });
}

document.addEventListener('DOMContentLoaded', function() {
    if(checkPaymentSuccess()){
       
    }
});