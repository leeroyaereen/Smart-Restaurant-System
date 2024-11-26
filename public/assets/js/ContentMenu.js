window.onload = loadMenu;
function loadMenu() {
    fetch(BASE_PATH + '/api/getFoodItems')
    .then(response => response.json())
    .then(data => {
        console.log(data);
    });
}