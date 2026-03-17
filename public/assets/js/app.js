const page = document.body.dataset.page;

if (page === 'add-book') {
    import('./pages/add-book.js').then(module => module.init());
}
