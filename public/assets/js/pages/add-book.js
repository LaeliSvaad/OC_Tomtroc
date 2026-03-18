export function init() {
    const titleInput = document.getElementById('input-title');
    const authorInput = document.getElementById('input-author');
    const titleResultsList = document.getElementById('title-results');
    const authorResultsList = document.getElementById('author-results');

    if (!titleInput || !authorInput) return;

    let currentResults = [];

    let timeout = null;

    titleResultsList.addEventListener('click', (e) => {
        const li = e.target.closest('li');
        if (!li) return;

        const index = li.dataset.index;
        const item = currentResults[index];

        insertInputsValues(item);
        titleResultsList.style.display = 'none';
    });
    authorResultsList.addEventListener('click', (e) => {
        const li = e.target.closest('li');
        if (!li) return;

        const index = li.dataset.index;
        const item = currentResults[index];

        insertInputsValues(item);
        authorResultsList.style.display = 'none';
    });
    titleInput.addEventListener('input', () => {
        clearTimeout(timeout);

        timeout = setTimeout(async () => {

            const query = titleInput.value.trim();

            if (query.length < 2) {
                titleResultsList.innerHTML = '';
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

            displayResults(data, titleResultsList);

        }, 300);
    });
    titleInput.addEventListener('input', () => {
        titleResultsList.style.display = 'block';
    });
    authorInput.addEventListener('input', () => {
        clearTimeout(timeout);

        timeout = setTimeout(async () => {

            const query = authorInput.value.trim();

            if (query.length < 2) {
                authorResultsList.innerHTML = '';
                return;
            }

            const res = await fetch('/checkExistingAuthors', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ query })
            });

            const data = await res.json();

            currentResults = data.results;

            displayResults(data, authorResultsList);

        }, 300);
    });
    authorInput.addEventListener('input', () => {
        authorResultsList.style.display = 'block';
    });
    titleInput.addEventListener('input', resetHiddenTitleField);
    authorInput.addEventListener('input', resetHiddenAuthorField);
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.title-container')) {
            titleResultsList.style.display = 'none';
        }
        if (!e.target.closest('.author-container')) {
            authorResultsList.style.display = 'none';
        }
    });
}
function displayResults(data, container) {
    container.innerHTML = '';

    if (!data.results || data.results.length === 0) {
        container.style.display = 'none';
        return;
    }
    if(container.id === "title-results")
    {
        data.results.forEach((item, index) => {
            container.insertAdjacentHTML(
                'beforeend',
                `<li data-index='${index}'>
                <strong>${item.title}</strong>
                <small>${item.author}</small>
            </li>`
            );
        });
    }
    if(container.id === "author-results")
    {
        data.results.forEach((item, index) => {
            container.insertAdjacentHTML(
                'beforeend',
                `<li data-index="${index}">
                <strong>${item.author}</strong>
            </li>`
            );
        });
    }
    container.style.display = 'block';
}

function resetHiddenTitleField() {
    if (isSelectingTitle) return;
    document.getElementById('input-book-id').value = '';
}

function resetHiddenAuthorField(){
    if (isSelectingAuthor) return;
    document.getElementById('input-author-id').value = '';
}

let isSelectingTitle = false;
let isSelectingAuthor = false;
function insertInputsValues(item){


    if(item.title && item.bookId){
        isSelectingTitle = true;
        document.getElementById('input-title').value = item.title;
        document.getElementById('input-book-id').value = item.bookId;
        setTimeout(() => {
            isSelectingTitle = false;
        }, 0);
    }
    if(item.author && item.authorId){
        isSelectingAuthor = true;
        document.getElementById('input-author').value = item.author;
        document.getElementById('input-author-id').value = item.authorId;
        setTimeout(() => {
            isSelectingAuthor = false;
        }, 0);
    }
}