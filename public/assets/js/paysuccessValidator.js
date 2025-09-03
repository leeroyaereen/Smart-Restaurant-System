async function checkPaymentSuccess() {
    const params = new URLSearchParams(window.location.search);
    const pidx = params.get('pidx');
    if (!pidx) {
        return false;
    }
    try {
        const response = await fetchDataGet('/api/checkPaymentSuccess' + "?pidx=" + pidx);
        const data = await response.json();
        if (data.success) {
            return true;
        } else {
            alert("Payment failed: " + data.message);
            return false;
        }
    } catch (error) {
        console.error('Error fetching payment status:', error);
        document.getElementById('successMessage').innerText = "An error occurred while checking payment status.";
        return false;
    }
}

async function checkUntilSuccessOrTimeout(retries = 5, delay = 2000) {
    for (let i = 0; i < retries; i++) {
        const success = await checkPaymentSuccess();
        if (success) {
            // Do something if payment is successful
            return true;
        }
        await new Promise(resolve => setTimeout(resolve, delay));
    }
    document.getElementById('successMessage').innerText = "Payment status could not be confirmed. Please try again later.";
    return false;
}

document.addEventListener('DOMContentLoaded', async function() {
    await checkUntilSuccessOrTimeout();
});