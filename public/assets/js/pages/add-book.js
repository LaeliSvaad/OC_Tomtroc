export function init() {
    bindEvents();
}

function bindEvents() {
    const inputs = document.querySelectorAll('.js-input');

    inputs.forEach(input => {
        input.addEventListener('change', handleChange);
    });
}

function handleChange(e){
    const val = e.target.value;
    if(e.target.name  === "title")
        sendTitle(val);
    if(e.target.name === "authorName")
        sendAuthorName(val);
}

function sendTitle(val) {
    alert(val);
}

function sendAuthorName(val) {
    alert(val);
}