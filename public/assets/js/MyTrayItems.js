window.onload = calculateTotal;
ItemList = document.querySelectorAll('.ItemContainer');
subTotal = document.querySelector('#subTotalValue');
discount = document.querySelector('#discountValue');
total = document.querySelector('#totalValue');
let discountPercentage = 10;

function calculateSubTotal(){
    let subTotalPrice = 0;
    ItemList.forEach(element => {
        ItemPrice = element.querySelector('.ItemPrice span');
        ItemQuantity = element.querySelector('.ItemQuantity span');
        subTotalPrice = subTotalPrice + (parseInt(ItemPrice.innerText) * parseInt(ItemQuantity.innerText));
    })
    subTotal.innerText = subTotalPrice;
    return subTotalPrice;
}

function calculateTotal(){
    let subTotalPrice = calculateSubTotal();
    let discountPrice = Math.floor(subTotalPrice * (discountPercentage / 100));
    discount.innerText = discountPrice;
    total.innerText = subTotalPrice - discountPrice;
}

// Change total price each time the qunatity is changed
const quantityDisplayBlocks = document.querySelectorAll(".ItemQuantity span");

// Initialize the MutationObserver
const observer = new MutationObserver(() => {
    calculateTotal();
});

quantityDisplayBlocks.forEach(element => {
    // Observe each quantity display block for changes
    observer.observe(element, { childList: true });
});


