/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.filebrowserBrowseUrl = '/js/ckeditor/plugins/pdw/pdw_file_browser/index.php?editor=ckeditor';
	config.filebrowserImageBrowseUrl = '/js/ckeditor/plugins/pdw/pdw_file_browser/index.php?editor=ckeditor&filter=image';
	config.filebrowserFlashBrowseUrl = '/js/ckeditor/plugins/pdw/pdw_file_browser/index.php?editor=ckeditor&filter=flash';
	config.baseFloatZIndex = 9000;
};
