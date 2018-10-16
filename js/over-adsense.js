/*
* Plugin Name Over Adsense
* Version 1.0.0
* Author Genki Okada
*/

"use strict";
var object = {}
object.extend = function(self, Object) {
    for(var key in Object) {
        self[key] = Object[key];
    }
};
/*
====================
■ Controller
====================
*/
function Controller(Object) {
	//extend
    object.extend(this, Object);
   	//method
   	this.init();
   	this.event();
}
Controller.prototype.init = function() { //init
    if(this.root.overType.pc == 1 && this.root.overType.sp == 1) {
        this.root.element.$overAdsenseWrapper.css("display", "block");
    }
    if(this.root.overType.pc == 0 && this.root.overType.sp == 1 && this.root.device.isSp() == 1) {
        this.root.element.$overAdsenseWrapper.css("display", "block");
    }
};
Controller.prototype.event = function() { //event
	var self = this;
	this.root.element.$closeButton.click(function() {
		self.root.element.$overAdsenseWrapper.fadeOut();
	});
    this.root.element.$overAdsense.click(function() {
        self.root.element.$overAdsenseWrapper.fadeOut();
    });
};

/*
====================
■ Window
====================
*/
function Window(Object) {
    //extend
    object.extend(this, Object);
    //property
    this.scroll = this.root.element.$window.scrollTop();
    this.width = this.root.element.$window.width();
    this.height = this.root.element.$window.height();
    this.brekPoint = {
        first: 769
    };
    //method
    this.event();
}
Window.prototype.event = function() { //event
    var self = this;
    this.root.element.$window.resize(function() {
        self.root.element.update();
        self.sizeUpdate();
    });
    this.root.element.$window.scroll(function() {
        self.root.element.update();
        self.windowScroll();
    });
};
Window.prototype.sizeUpdate = function() { //sizeUpdate
    this.width = this.root.element.$window.width();
    this.height = this.root.element.$window.height();
};
Window.prototype.windowScroll = function() { //windowScroll
    this.scroll = this.root.element.$window.scrollTop();
};

/*
====================
■ Element
====================
*/
function Element(Object) {
    //extend
    object.extend(this, Object);
    //method
    this.init();
}
Element.prototype.init = function() { //init
    this.get();
};
Element.prototype.get = function(Object = null) { //get
    //common
    this.$window = $(window);
    this.$html_$body = $("html, body");
    this.$body = $("body");
    //over-adsense
    this.$overAdsenseWrapper = $(".over-adsense-wrapper");
    this.$overAdsense = $(".over-adsense");
    this.$closeButton = $(".close-button");
    //extend
    if(Object != null) {
        object.extend(this, Object);
    }
    return this;
};
Element.prototype.update = function() { //update
    this.init();
};

/*
====================
■ Device
====================
*/
function Device(Object) {
    //extend
    object.extend(this, Object);
    //property
    this.userAgent = navigator.userAgent;
}
Device.prototype.isSp = function() { //isSp
    if(this.userAgent.indexOf("iPhone") != -1 || this.userAgent.indexOf("Android") != -1) {
        return true;
    } else {
        return false;
    }
};
Device.prototype.isPc = function() { //isPc
    if(this.userAgent.indexOf("iPhone") != -1 || this.userAgent.indexOf("Android") != -1) {
        return false;
    } else {
        return true;
    }
};

/*
====================
■ OverAdsense
====================
*/
var OverAdsense = function(overType) {
    var self = {};
    self.overType = overType;
    self.init = function() {
        var rootObject = {root: self};
        self.device = new Device({rootObject});
        self.element = new Element(rootObject);
        self.window = new Window(rootObject);
        self.controller = new Controller(rootObject);
    };
    self.init();
    return self;
}