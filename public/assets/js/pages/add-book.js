export function init() {
    const input = document.getElementById('input-title');
    const resultsList = document.getElementById('results');

    if (!input) return;

    let currentResults = [];

    resultsList.addEventListener('click', (e) => {
        const li = e.target.closest('li');
        if (!li) return;

        const index = li.dataset.index;
        const item = currentResults[index];

        insertInputsValues(item);
    });

    let timeout = null;

    input.addEventListener('input', () => {
        clearTimeout(timeout);

        timeout = setTimeout(async () => {

            const query = input.value.trim();

            if (query.length < 2) {
                resultsList.innerHTML = '';
                return;
            }

            const res = await fetch('/checkExistingBooks', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ query })
            });

            const data = await res.json();

            currentResults = data.results;

            displayResults(data, resultsList);

        }, 300);
    });
}
function displayResults(data, container) {
    container.innerHTML = '';

    if (!data.results || data.results.length === 0) {
        container.innerHTML = '<li>Aucun résultat</li>';
        return;
    }

    container.innerHTML = "<span>S'agit-il de l'un de ces livres?</span>";

    data.results.forEach((item, index) => {
        container.insertAdjacentHTML(
            'beforeend',
            `<li data-index="${index}">${item.title}, ${item.author}</li>`
        );
    });
}

function insertInputsValues(item){
    document.getElementById('input-title').value = item.title;
    document.getElementById('input-author').value = item.author;
    document.getElementById('input-book-id').value = item.bookId;
    document.getElementById('input-author-id').value = item.authorId;
}