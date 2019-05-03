
CKEDITOR.plugins.addExternal( 'base64image',
    '/js/library/ckeditor/plagins/base64image_1.2/base64image/', 'plugin.js');
CKEDITOR.plugins.addExternal( 'linkMephi22',
    '/js/library/ckeditor/plagins/linkMephi22/', 'plugin.js');

CKEDITOR.editorConfig = function( config ) {
    config.extraPlugins = 'linkMephi22, base64image';
    config.removePlugins = "image, iframe, flash, pagebreak, div, save, newpage," +
        "language, print, bidi, wsc, scaytm, link";
    config.disallowedContent = 'h3 h2 h1 ';
    config.language = 'ru';
    config.coreStyles_bold = {
        element: 'font',
        attributes: { 'style': 'font-weight: bold;' },
        overrides: 'strong'
    };
    config.coreStyles_italic = {
        element: 'font',
        attributes: { 'style': 'font-style: italic;' },
        overrides: 'em'
    };
};

