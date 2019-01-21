/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
    config.extraPlugins = 'base64image,htmlwriter';
    config.removePlugins = "image, iframe, flash, pagebreak, div, save, newpage," +
        "language, print, bidi, wsc, scayt";
   // config.pasteFromWordRemoveFontStyles=true;
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

CKEDITOR.on('instanceReady', function( ev ) {
    var blockTags = ['div','h1','h2','h3','h4','h5','h6','p','pre','li','blockquote','ul','ol',
        'table','thead','tbody','tfoot','td','th'];

    for (var i = 0; i < blockTags.length; i++)
    {
        ev.editor.dataProcessor.writer.setRules( blockTags[i], {
            indent : false,
            breakBeforeOpen : true,
            breakAfterOpen : false,
            breakBeforeClose : false,
            breakAfterClose : true
        });
    }
});
