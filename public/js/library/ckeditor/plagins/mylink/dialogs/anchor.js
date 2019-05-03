/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.dialog.add( 'anchor', function( editor ) {
	// Function called in onShow to load selected element.
	var loadElements = function( element ) {
			this._.selectedElement = element;

			var attributeValue = element.data( 'cke-saved-name' );
			var val_data_cke_theme_anchor = element.$.attributes.getNamedItem('data_cke_theme_anchor').value;
			if (val_data_cke_theme_anchor == 'true') {
                this.setValueOf( 'info', 'selectName', attributeValue || '' );
			} else {
                this.setValueOf( 'info', 'txtName', attributeValue || '' );
			}

		};

	function createFakeAnchor( editor, attributes ) {
		return editor.createFakeElement( editor.document.createElement( 'a', {
			attributes: attributes
		} ), 'cke_anchor', 'anchor' );
	}


	function getSelectedAnchor( selection ) {
		var range = selection.getRanges()[ 0 ],
			element = selection.getSelectedElement();

		// In case of table cell selection, we want to shrink selection from td to a element.
		range.shrink( CKEDITOR.SHRINK_ELEMENT );
		element = range.getEnclosedNode();

		if ( element && element.type === CKEDITOR.NODE_ELEMENT &&
			( element.data( 'cke-real-element-type' ) === 'anchor' || element.is( 'a' ) ) ) {
			return element;
		}
	}

	return {
		title: editor.lang.link.anchor.title ,
		minWidth: 300,
		minHeight: 60,
		onOk: function() {
			var usualAnchor = this.getValueOf( 'info', 'txtName' );
			var themeAnchor = this.getValueOf( 'info', 'selectName' );
			var name = CKEDITOR.tools.trim( themeAnchor ? themeAnchor : usualAnchor);
			var attributes = {
				id: name,
				name: name,
				'data-cke-saved-name': name,
				data_cke_theme_anchor: themeAnchor ? 'true' : 'false'
			};

			if ( this._.selectedElement ) {
				if ( this._.selectedElement.data( 'cke-realelement' ) ) {
					var newFake = createFakeAnchor( editor, attributes );
					newFake.replace( this._.selectedElement );

					// Selecting fake element for IE. (https://dev.ckeditor.com/ticket/11377)
					if ( CKEDITOR.env.ie ) {
						editor.getSelection().selectElement( newFake );
					}
				} else {
					this._.selectedElement.setAttributes( attributes );
				}
			} else {
				var sel = editor.getSelection(),
					range = sel && sel.getRanges()[ 0 ];

				// Empty anchor
				if ( range.collapsed ) {
					var anchor = createFakeAnchor( editor, attributes );
					range.insertNode( anchor );
				} else {
					if ( CKEDITOR.env.ie && CKEDITOR.env.version < 9 )
						attributes[ 'class' ] = 'cke_anchor';

					// Apply style.
					var style = new CKEDITOR.style( { element: 'a', attributes: attributes } );
					style.type = CKEDITOR.STYLE_INLINE;
					style.applyToRange( range );
				}
			}
		},

		onHide: function() {
			delete this._.selectedElement;
		},

		onShow: function() {
			var sel = editor.getSelection(),
				fullySelected = getSelectedAnchor( sel ),
				fakeSelected = fullySelected && fullySelected.data( 'cke-realelement' ),
				linkElement = fakeSelected ?
					CKEDITOR.plugins.mylink.tryRestoreFakeAnchor( editor, fullySelected ) :
					CKEDITOR.plugins.mylink.getSelectedLink( editor );

			if ( linkElement ) {
				loadElements.call( this, linkElement );
				!fakeSelected && sel.selectElement( linkElement );

				if ( fullySelected ) {
					this._.selectedElement = fullySelected;
				}
			}

			this.getContentElement( 'info', 'txtName' ).focus();
		},
		contents: [ {
			id: 'info',
			label: editor.lang.link.anchor.title,
			accessKey: 'I',
			elements: [ {
				type: 'text',
				id: 'txtName',
				label: 'Обычный якорь',
				required: true,
				validate: function() {
                    var anchor_array = CKEDITOR.plugins.mylink.getEditorAnchors(editor);
                    var result_search = anchor_array.find(anchor => anchor.name === this.getValue());
                    if (result_search) {
                        alert( 'Якорь с именем "' + result_search.name +  '" в данной лекции уже существует' ); // jshint ignore:line
                        return false;
                    }
					return true;
				}
			},
				{
                    type: 'select',
                    id: 'selectName',
                    label: 'Якоря тем',
                    items : [ ['', ''] ],
                    validate: function() {
                        var anchor_array = CKEDITOR.plugins.mylink.getEditorAnchors(editor);
                        var result_search = anchor_array.find(anchor => anchor.name === this.getValue());
                        if (result_search) {
                            alert( 'Данный якорь темы уже существует' ); // jshint ignore:line
                            return false;
                        }
                        return true;
                    }
				}
				]
		} ]
	};
} );

