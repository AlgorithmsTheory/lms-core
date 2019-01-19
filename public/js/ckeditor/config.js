/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
    config.extraPlugins = 'base64image';
    config.removePlugins = "image, iframe, flash, pagebreak, div, save, newpage," +
        "language, print, bidi, wsc, scayt";
    config.pasteFromWordRemoveFontStyles=true;
    config.disallowedContent = 'h3 h2 h1 em';
    config.language = 'ru';
};
