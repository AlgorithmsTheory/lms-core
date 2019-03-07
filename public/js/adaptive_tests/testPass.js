// once reload page to ban back to previous question in browser history
window.history.pushState('', null, './');
$(window).on('popstate', function() {
    location.reload(true);
});