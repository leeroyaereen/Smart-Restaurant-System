const itemQuantity = document.querySelectorAll('.ItemQuantity');

itemQuantity.forEach(element => {
    addQuantityCounter(element);
});

function addQuantityCounter(element)  {
    console.log(element);
    element.querySelector('.icon-tabler-circle-plus').addEventListener('click', function() {
        addQuantity(element);
    });

    element.querySelector('.icon-tabler-circle-minus').addEventListener('click', function() {
        subtractQuantity(element);
    });
}

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

function calculateOrderCost(ItemList){
    let TotalPrice = 0;
    console.log(ItemList);
    ItemList.forEach(element => {
        let ItemPrice = element.querySelector('.ItemPrice span');
        let ItemQuantity = element.querySelector('.ItemQuantity span');
        TotalPrice = TotalPrice + (parseInt(ItemPrice.innerText) * parseInt(ItemQuantity.innerText));
    })
    return TotalPrice;
}