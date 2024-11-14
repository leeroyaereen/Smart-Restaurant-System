itemQuantity = document.querySelectorAll('.ItemQuantity');
itemQuantity.forEach(element => {
    element.querySelector('.icon-tabler-circle-plus').addEventListener('click', function() {
        addQuantity(element);
    });

    element.querySelector('.icon-tabler-circle-minus').addEventListener('click', function() {
        subtractQuantity(element);
    });
});

function addQuantity(element) {
    var quantity = parseInt(element.querySelector('span').innerText);
    if (quantity < 99){
        quantity++;
        element.querySelector('span').innerText = formatNumber(quantity);
    }
}

function subtractQuantity(element) {
    var quantity = parseInt(element.querySelector('span').innerText);
    if (quantity > 1) {
        quantity--;
        element.querySelector('span').innerText = formatNumber(quantity);
    }
}

function formatNumber(number){
    let formattedNumber = new Intl.NumberFormat('en-US', { minimumIntegerDigits: 2 }).format(number);
    return formattedNumber;
}
