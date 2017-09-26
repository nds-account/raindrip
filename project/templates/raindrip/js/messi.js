/*
 * jQuery Messi Plugin 1.3
 * https://github.com/marcosesperon/jquery-messi
 *
 * Copyright 2012, Marcos Esperón
 * http://marcosesperon.es
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

// Clase principal
function Messi(data, options) {

  var _this = this;
  _this.options = jQuery.extend({}, Messi.prototype.options, options || {});

  // preparamos el elemento
  _this.messi = jQuery(_this.template);
  _this.setContent(data);

  // ajustamos el título
  if(_this.options.title == null) {

    jQuery('.messi-titlebox', _this.messi).remove();

  } else {

    jQuery('.messi-title', _this.messi).append(_this.options.title);

    if(_this.options.buttons.length === 0 && !_this.options.autoclose) {

      if(_this.options.closeButton) {
        var close = jQuery('<span class="messi-closebtn"></span>');
        close.bind('click', function() {
          _this.hide();
        });

        jQuery('.messi-titlebox', this.messi).prepend(close);

      };

    };

    if(_this.options.titleClass != null) jQuery('.messi-titlebox', this.messi).addClass(_this.options.titleClass);

  };

  // ajustamos el ancho
  if(_this.options.width != null) jQuery('.messi-box', _this.messi).css('width', _this.options.width);

  // preparamos los botones
  if(_this.options.buttons.length > 0) {

    for (var i = 0; i < _this.options.buttons.length; i++) {

      var cls = (_this.options.buttons[i]["class"]) ? _this.options.buttons[i]["class"] : '';
      var btn = jQuery('<div class="btnbox"><button class="btn ' + cls + '" href="#">' + _this.options.buttons[i].label + '</button></div>').data('value', _this.options.buttons[i].val);
      btn.on('click', 'button', function() {
        var value = jQuery.data(this, 'value');
        var after = (_this.options.callback != null) ? function() { _this.options.callback(value); } : null;
        _this.hide(after);
      });

      jQuery('.messi-actions', this.messi).append(btn);

    };

  } else {

    jQuery('.messi-footbox', this.messi).remove();

  };

  // preparamos el botón de cerrar automáticamente
  if(_this.options.buttons.length === 0 && _this.options.title == null && !_this.options.autoclose) {

    if(_this.options.closeButton) {
      var close = jQuery('<span class="messi-closebtn"></span>');
      close.bind('click', function() {
        _this.hide();
      });

      jQuery('.messi-content', this.messi).prepend(close);

    };

  };

  // activamos la pantalla modal
  _this.modal = (_this.options.modal) ? jQuery('<div class="messi-modal"></div>').css({opacity: _this.options.modalOpacity, width: jQuery(document).width(), height: jQuery(document).height(), 'z-index': _this.options.zIndex + jQuery('.messi').length}).appendTo(document.body) : null;

  // mostramos el mensaje
  if(_this.options.show) _this.show();

  // controlamos el redimensionamiento de la pantalla
  jQuery(window).bind('resize', function(){ _this.resize(); });

  // configuramos el cierre automático
  if(_this.options.autoclose != null) {
    setTimeout(function(_this) {
      _this.hide();
    }, _this.options.autoclose, this);
  };

  return _this;

};

Messi.prototype = {

  options: {
    autoclose: null,                         // autoclose message after 'x' miliseconds, i.e: 5000
    buttons: [],                             // array of buttons, i.e: [{id: 'ok', label: 'OK', val: 'OK'}]
    callback: null,                          // callback function after close message
    center: true,                            // center message on screen
    closeButton: true,                       // show close button in header title (or content if buttons array is empty).
    height: 'auto',                          // content height
    title: null,                             // message title
    titleClass: null,                        // title style: info, warning, success, error
    modal: false,                            // shows message in modal (loads background)
    modalOpacity: .2,                        // modal background opacity
    padding: '10px',                         // content padding
    show: true,                              // show message after load
    unload: true,                            // unload message after hide
    viewport: {top: '0px', left: '0px'},     // if not center message, sets X and Y position
    width: '500px',                          // message width
    zIndex: 99999                            // message z-index
  },
  template: '<div class="messi"><div class="messi-box"><div class="messi-wrapper"><div class="messi-titlebox"><span class="messi-title"></span></div><div class="messi-content"></div><div class="messi-footbox"><div class="messi-actions"></div></div></div></div></div>',
  content: '<div></div>',
  visible: false,

  setContent: function(data) {
    jQuery('.messi-content', this.messi).css({padding: this.options.padding, height: this.options.height}).empty().append(data);
  },

  viewport: function() {

    return {
      top: ((jQuery(window).height() - this.messi.height()) / 2) +  jQuery(window).scrollTop() + "px",
      left: ((jQuery(window).width() - this.messi.width()) / 2) + jQuery(window).scrollLeft() + "px"
    };

  },

  show: function() {

    if(this.visible) return;

    if(this.options.modal && this.modal != null) this.modal.show();
    this.messi.appendTo(document.body);

    // obtenemos el centro de la pantalla si la opción de centrar está activada
    if(this.options.center) this.options.viewport = this.viewport(jQuery('.messi-box', this.messi));

    this.messi.css({top: this.options.viewport.top, left: this.options.viewport.left, 'z-index': this.options.zIndex + jQuery('.messi').length}).show().animate({opacity: 1}, 300);

    // cancelamos el scroll
    //document.documentElement.style.overflow = "hidden";

    this.visible = true;

  },

  hide: function(after) {

    if (!this.visible) return;
    var _this = this;

    this.messi.animate({opacity: 0}, 300, function() {
      if(_this.options.modal && _this.modal != null) _this.modal.remove();
      _this.messi.css({display: 'none'}).remove();
      // reactivamos el scroll
      //document.documentElement.style.overflow = "visible";
      _this.visible = false;
      if (after) after.call();
      if(_this.options.unload) _this.unload();
    });

    return this;

  },

  resize: function() {
    if(this.options.modal) {
      jQuery('.messi-modal').css({width: jQuery(document).width(), height: jQuery(document).height()});
    };
    if(this.options.center) {
      this.options.viewport = this.viewport(jQuery('.messi-box', this.messi));
      this.messi.css({top: this.options.viewport.top, left: this.options.viewport.left});
    };
  },

  toggle: function() {
    this[this.visible ? 'hide' : 'show']();
    return this;
  },

  unload: function() {
    if (this.visible) this.hide();
    jQuery(window).unbind('resize', function () { this.resize(); });
    this.messi.remove();
  }

};

// llamadas especiales
jQuery.extend(Messi, {

  alert: function(data, callback, options) {

      var buttons = [{id: 'ok', label: 'OK', val: 'OK'}];

      options = jQuery.extend({closeButton: false, buttons: buttons, callback:function() {}}, options || {}, {show: true, unload: true, callback: callback});

      return new Messi(data, options);

  },

  ask: function(data, callback, options) {

    var buttons = [
      {id: 'yes', label: 'Yes', val: 'Y', "class": 'btn-success'},
      {id: 'no', label: 'No', val: 'N', "class": 'btn-danger'},
    ];

    options = jQuery.extend({closeButton: false, modal: true, buttons: buttons, callback:function() {}}, options || {}, {show: true, unload: true, callback: callback});

    return new Messi(data, options);

  },

  img: function(src, options) {

    var img = new Image();

    jQuery(img).load(function() {

      var vp = {width: jQuery(window).width() - 50, height: jQuery(window).height() - 50};
      var ratio = (this.width > vp.width || this.height > vp.height) ? Math.min(vp.width / this.width, vp.height / this.height) : 1;

      jQuery(img).css({width: this.width * ratio, height: this.height * ratio});

      options = jQuery.extend(options || {}, {show: true, unload: true, closeButton: true, width: this.width * ratio, height: this.height * ratio, padding: 0});
      new Messi(img, options);

    }).error(function() {

      console.log('Error loading ' + src);

    }).attr('src', src);

  },

  load: function(url, options) {

    options = jQuery.extend(options || {}, {show: true, unload: true, params: {}});

    var request = {
      url: url,
      data: options.params,
      dataType: 'html',
      cache: false,
      error: function (request, status, error) {
        console.log(request.responseText);
      },
      success: function(html) {
        //html = jQuery(html);
        new Messi(html, options);
      }
    };

    jQuery.ajax(request);

  }

});




/*! Backstretch - v2.0.4 - 2013-06-19
* http://srobbin.com/jquery-plugins/backstretch/
* Copyright (c) 2013 Scott Robbin; Licensed MIT */
(function(a,d,p){a.fn.backstretch=function(c,b){(c===p||0===c.length)&&a.error("No images were supplied for Backstretch");0===a(d).scrollTop()&&d.scrollTo(0,0);return this.each(function(){var d=a(this),g=d.data("backstretch");if(g){if("string"==typeof c&&"function"==typeof g[c]){g[c](b);return}b=a.extend(g.options,b);g.destroy(!0)}g=new q(this,c,b);d.data("backstretch",g)})};a.backstretch=function(c,b){return a("body").backstretch(c,b).data("backstretch")};a.expr[":"].backstretch=function(c){return a(c).data("backstretch")!==p};a.fn.backstretch.defaults={centeredX:!0,centeredY:!0,duration:5E3,fade:0};var r={left:0,top:0,overflow:"hidden",margin:0,padding:0,height:"100%",width:"100%",zIndex:-999999},s={position:"absolute",display:"none",margin:0,padding:0,border:"none",width:"auto",height:"auto",maxHeight:"none",maxWidth:"none",zIndex:-999999},q=function(c,b,e){this.options=a.extend({},a.fn.backstretch.defaults,e||{});this.images=a.isArray(b)?b:[b];a.each(this.images,function(){a("<img />")[0].src=this});this.isBody=c===document.body;this.$container=a(c);this.$root=this.isBody?l?a(d):a(document):this.$container;c=this.$container.children(".backstretch").first();this.$wrap=c.length?c:a('<div class="backstretch"></div>').css(r).appendTo(this.$container);this.isBody||(c=this.$container.css("position"),b=this.$container.css("zIndex"),this.$container.css({position:"static"===c?"relative":c,zIndex:"auto"===b?0:b,background:"none"}),this.$wrap.css({zIndex:-999998}));this.$wrap.css({position:this.isBody&&l?"fixed":"absolute"});this.index=0;this.show(this.index);a(d).on("resize.backstretch",a.proxy(this.resize,this)).on("orientationchange.backstretch",a.proxy(function(){this.isBody&&0===d.pageYOffset&&(d.scrollTo(0,1),this.resize())},this))};q.prototype={resize:function(){try{var a={left:0,top:0},b=this.isBody?this.$root.width():this.$root.innerWidth(),e=b,g=this.isBody?d.innerHeight?d.innerHeight:this.$root.height():this.$root.innerHeight(),j=e/this.$img.data("ratio"),f;j>=g?(f=(j-g)/2,this.options.centeredY&&(a.top="-"+f+"px")):(j=g,e=j*this.$img.data("ratio"),f=(e-b)/2,this.options.centeredX&&(a.left="-"+f+"px"));this.$wrap.css({width:b,height:g}).find("img:not(.deleteable)").css({width:e,height:j}).css(a)}catch(h){}return this},show:function(c){if(!(Math.abs(c)>this.images.length-1)){var b=this,e=b.$wrap.find("img").addClass("deleteable"),d={relatedTarget:b.$container[0]};b.$container.trigger(a.Event("backstretch.before",d),[b,c]);this.index=c;clearInterval(b.interval);b.$img=a("<img />").css(s).bind("load",function(f){var h=this.width||a(f.target).width();f=this.height||a(f.target).height();a(this).data("ratio",h/f);a(this).fadeIn(b.options.speed||b.options.fade,function(){e.remove();b.paused||b.cycle();a(["after","show"]).each(function(){b.$container.trigger(a.Event("backstretch."+this,d),[b,c])})});b.resize()}).appendTo(b.$wrap);b.$img.attr("src",b.images[c]);return b}},next:function(){return this.show(this.index<this.images.length-1?this.index+1:0)},prev:function(){return this.show(0===this.index?this.images.length-1:this.index-1)},pause:function(){this.paused=!0;return this},resume:function(){this.paused=!1;this.next();return this},cycle:function(){1<this.images.length&&(clearInterval(this.interval),this.interval=setInterval(a.proxy(function(){this.paused||this.next()},this),this.options.duration));return this},destroy:function(c){a(d).off("resize.backstretch orientationchange.backstretch");clearInterval(this.interval);c||this.$wrap.remove();this.$container.removeData("backstretch")}};var l,f=navigator.userAgent,m=navigator.platform,e=f.match(/AppleWebKit\/([0-9]+)/),e=!!e&&e[1],h=f.match(/Fennec\/([0-9]+)/),h=!!h&&h[1],n=f.match(/Opera Mobi\/([0-9]+)/),t=!!n&&n[1],k=f.match(/MSIE ([0-9]+)/),k=!!k&&k[1];l=!((-1<m.indexOf("iPhone")||-1<m.indexOf("iPad")||-1<m.indexOf("iPod"))&&e&&534>e||d.operamini&&"[object OperaMini]"==={}.toString.call(d.operamini)||n&&7458>t||-1<f.indexOf("Android")&&e&&533>e||h&&6>h||"palmGetResource"in d&&e&&534>e||-1<f.indexOf("MeeGo")&&-1<f.indexOf("NokiaBrowser/8.5.0")||k&&6>=k)})(jQuery,window);