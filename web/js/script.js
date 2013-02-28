/* ----- PLUGINS ------------------------------------------------------------- */

// usage: log('inside coolFunc', this, arguments);
// paulirish.com/2009/log-a-lightweight-wrapper-for-consolelog/
window.log = function f(){ log.history = log.history || []; log.history.push(arguments); if(this.console) { var args = arguments, newarr; args.callee = args.callee.caller; newarr = [].slice.call(args); if (typeof console.log === 'object') log.apply.call(console.log, console, newarr); else console.log.apply(console, newarr);}};

// make it safe to use console.log always
(function(a){function b(){}for(var c="assert,count,debug,dir,dirxml,error,exception,group,groupCollapsed,groupEnd,info,log,markTimeline,profile,profileEnd,time,timeEnd,trace,warn".split(","),d;!!(d=c.pop());){a[d]=a[d]||b;}})
(function(){try{console.log();return window.console;}catch(a){return (window.console={});}}());


// place any jQuery/helper plugins in here, instead of separate, slower script files.


/* ===================================================
 * bootstrap-transition.js v2.0.0
 * http://twitter.github.com/bootstrap/javascript.html#transitions
 * ===================================================
 * Copyright 2012 Twitter, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================== */

!function( $ ) {

  $(function () {

    "use strict"

    /* CSS TRANSITION SUPPORT (https://gist.github.com/373874)
     * ======================================================= */

    $.support.transition = (function () {
      var thisBody = document.body || document.documentElement
        , thisStyle = thisBody.style
        , support = thisStyle.transition !== undefined || thisStyle.WebkitTransition !== undefined || thisStyle.MozTransition !== undefined || thisStyle.MsTransition !== undefined || thisStyle.OTransition !== undefined

      return support && {
        end: (function () {
          var transitionEnd = "TransitionEnd"
          if ( $.browser.webkit ) {
          	transitionEnd = "webkitTransitionEnd"
          } else if ( $.browser.mozilla ) {
          	transitionEnd = "transitionend"
          } else if ( $.browser.opera ) {
          	transitionEnd = "oTransitionEnd"
          }
          return transitionEnd
        }())
      }
    })()

  })
  
}( window.jQuery )



/* ============================================================
 * bootstrap-dropdown.js v2.0.0
 * http://twitter.github.com/bootstrap/javascript.html#dropdowns
 * ============================================================
 * Copyright 2012 Twitter, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ============================================================ */


!function( $ ){

  "use strict"

 /* DROPDOWN CLASS DEFINITION
  * ========================= */

  var toggle = '[data-toggle="dropdown"]'
    , Dropdown = function ( element ) {
        var $el = $(element).on('click.dropdown.data-api', this.toggle)
        $('html').on('click.dropdown.data-api', function () {
          $el.parent().removeClass('open')
        })
      }

  Dropdown.prototype = {

    constructor: Dropdown

  , toggle: function ( e ) {
      var $this = $(this)
        , selector = $this.attr('data-target')
        , $parent
        , isActive

      if (!selector) {
        selector = $this.attr('href')
        selector = selector && selector.replace(/.*(?=#[^\s]*$)/, '') //strip for ie7
      }

      $parent = $(selector)
      $parent.length || ($parent = $this.parent())

      isActive = $parent.hasClass('open')

      clearMenus()
      !isActive && $parent.toggleClass('open')

      return false
    }

  }

  function clearMenus() {
    $(toggle).parent().removeClass('open')
  }


  /* DROPDOWN PLUGIN DEFINITION
   * ========================== */

  $.fn.dropdown = function ( option ) {
    return this.each(function () {
      var $this = $(this)
        , data = $this.data('dropdown')
      if (!data) $this.data('dropdown', (data = new Dropdown(this)))
      if (typeof option == 'string') data[option].call($this)
    })
  }

  $.fn.dropdown.Constructor = Dropdown


  /* APPLY TO STANDARD DROPDOWN ELEMENTS
   * =================================== */

  $(function () {
    $('html').on('click.dropdown.data-api', clearMenus)
    $('body').on('click.dropdown.data-api', toggle, Dropdown.prototype.toggle)
  })

}( window.jQuery )



/* =============================================================
 * bootstrap-collapse.js v2.0.0
 * http://twitter.github.com/bootstrap/javascript.html#collapse
 * =============================================================
 * Copyright 2012 Twitter, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ============================================================ */

!function( $ ){

  "use strict"

  var Collapse = function ( element, options ) {
  	this.$element = $(element)
    this.options = $.extend({}, $.fn.collapse.defaults, options)

    if (this.options["parent"]) {
      this.$parent = $(this.options["parent"])
    }

    this.options.toggle && this.toggle()
  }

  Collapse.prototype = {

    constructor: Collapse

  , dimension: function () {
      var hasWidth = this.$element.hasClass('width')
      return hasWidth ? 'width' : 'height'
    }

  , show: function () {
      var dimension = this.dimension()
        , scroll = $.camelCase(['scroll', dimension].join('-'))
        , actives = this.$parent && this.$parent.find('.in')
        , hasData

      if (actives && actives.length) {
        hasData = actives.data('collapse')
        actives.collapse('hide')
        hasData || actives.data('collapse', null)
      }

      this.$element[dimension](0)
      this.transition('addClass', 'show', 'shown')
      this.$element[dimension](this.$element[0][scroll])

    }

  , hide: function () {
      var dimension = this.dimension()
      this.reset(this.$element[dimension]())
      this.transition('removeClass', 'hide', 'hidden')
      this.$element[dimension](0)
    }

  , reset: function ( size ) {
      var dimension = this.dimension()

      this.$element
        .removeClass('collapse')
        [dimension](size || 'auto')
        [0].offsetWidth

      this.$element.addClass('collapse')
    }

  , transition: function ( method, startEvent, completeEvent ) {
      var that = this
        , complete = function () {
            if (startEvent == 'show') that.reset()
            that.$element.trigger(completeEvent)
          }

      this.$element
        .trigger(startEvent)
        [method]('in')

      $.support.transition && this.$element.hasClass('collapse') ?
        this.$element.one($.support.transition.end, complete) :
        complete()
  	}

  , toggle: function () {
      this[this.$element.hasClass('in') ? 'hide' : 'show']()
  	}

  }

  /* COLLAPSIBLE PLUGIN DEFINITION
  * ============================== */

  $.fn.collapse = function ( option ) {
    return this.each(function () {
      var $this = $(this)
        , data = $this.data('collapse')
        , options = typeof option == 'object' && option
      if (!data) $this.data('collapse', (data = new Collapse(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  $.fn.collapse.defaults = {
    toggle: true
  }

  $.fn.collapse.Constructor = Collapse


 /* COLLAPSIBLE DATA-API
  * ==================== */

  $(function () {
    $('body').on('click.collapse.data-api', '[data-toggle=collapse]', function ( e ) {
      var $this = $(this), href
        , target = $this.attr('data-target')
          || e.preventDefault()
          || (href = $this.attr('href')) && href.replace(/.*(?=#[^\s]+$)/, '') //strip for ie7
        , option = $(target).data('collapse') ? 'toggle' : $this.data()
      $(target).collapse(option)
    })
  })

}( window.jQuery )


/* ----------------------------------------------------------------------------

Title:		jShowOff: a jQuery Content Rotator Plugin
Author:		Erik Kallevig
Version:	0.1.2
Website:	http://ekallevig.com/jshowoff
License: 	Dual licensed under the MIT and GPL licenses.

*/

(function($){$.fn.jshowoff=function(settings){var config={animatePause:true,autoPlay:true,changeSpeed:600,controls:true,controlText:{play:'Play',pause:'Pause',next:'Next',previous:'Previous'},effect:'fade',hoverPause:true,links:true,speed:3000};if(settings)$.extend(true,config,settings);if(config.speed<(config.changeSpeed+20)){alert('jShowOff: Make speed at least 20ms longer than changeSpeed; the fades aren\'t always right on time.');return this;};this.each(function(i){var $cont=$(this);var gallery=$(this).children().remove();var timer='';var counter=0;var preloadedImg=[];var howManyInstances=$('.jshowoff').length+1;var uniqueClass='jshowoff-'+howManyInstances;var cssClass=config.cssClass!=undefined?config.cssClass:'';$cont.css('position','relative').wrap('<div class="jshowoff '+uniqueClass+'" />');var $wrap=$('.'+uniqueClass);$wrap.css('position','relative').addClass(cssClass);$(gallery[0]).clone().appendTo($cont);preloadImg();if(config.controls){addControls();if(config.autoPlay==false){$('.'+uniqueClass+'-play').addClass(uniqueClass+'-paused jshowoff-paused').text(config.controlText.play);};};if(config.links){addSlideLinks();$('.'+uniqueClass+'-slidelinks a').eq(0).addClass(uniqueClass+'-active jshowoff-active');};if(config.hoverPause){$cont.hover(function(){if(isPlaying())pause('hover');},function(){if(isPlaying())play('hover');});};if(config.autoPlay&&gallery.length>1){timer=setInterval(function(){play();},config.speed);};if(gallery.length<1){$('.'+uniqueClass).append('<p>For jShowOff to work, the container element must have child elements.</p>');};function transitionTo(gallery,index){var oldCounter=counter;if((counter>=gallery.length)||(index>=gallery.length)){counter=0;var e2b=true;}
else if((counter<0)||(index<0)){counter=gallery.length-1;var b2e=true;}
else{counter=index;}
if(config.effect=='slideLeft'){var newSlideDir,oldSlideDir;function slideDir(dir){newSlideDir=dir=='right'?'left':'right';oldSlideDir=dir=='left'?'left':'right';};counter>=oldCounter?slideDir('left'):slideDir('right');$(gallery[counter]).clone().appendTo($cont).slideIt({direction:newSlideDir,changeSpeed:config.changeSpeed});if($cont.children().length>1){$cont.children().eq(0).css('position','absolute').slideIt({direction:oldSlideDir,showHide:'hide',changeSpeed:config.changeSpeed},function(){$(this).remove();});};}else if(config.effect=='fade'){$(gallery[counter]).clone().appendTo($cont).hide().fadeIn(config.changeSpeed,function(){if($.browser.msie)this.style.removeAttribute('filter');});if($cont.children().length>1){$cont.children().eq(0).remove();};}else if(config.effect=='none'){$(gallery[counter]).clone().appendTo($cont);if($cont.children().length>1){$cont.children().eq(0).css('position','absolute').remove();};};if(config.links){$('.'+uniqueClass+'-active').removeClass(uniqueClass+'-active jshowoff-active');$('.'+uniqueClass+'-slidelinks a').eq(counter).addClass(uniqueClass+'-active jshowoff-active');};};function isPlaying(){return $('.'+uniqueClass+'-play').hasClass('jshowoff-paused')?false:true;};function play(src){if(!isBusy()){counter++;transitionTo(gallery,counter);if(src=='hover'||!isPlaying()){timer=setInterval(function(){play();},config.speed);}
if(!isPlaying()){$('.'+uniqueClass+'-play').text(config.controlText.pause).removeClass('jshowoff-paused '+uniqueClass+'-paused');}};};function pause(src){clearInterval(timer);if(!src||src=='playBtn')$('.'+uniqueClass+'-play').text(config.controlText.play).addClass('jshowoff-paused '+uniqueClass+'-paused');if(config.animatePause&&src=='playBtn'){$('<p class="'+uniqueClass+'-pausetext jshowoff-pausetext">'+config.controlText.pause+'</p>').css({fontSize:'62%',textAlign:'center',position:'absolute',top:'40%',lineHeight:'100%',width:'100%'}).appendTo($wrap).addClass(uniqueClass+'pauseText').animate({fontSize:'600%',top:'30%',opacity:0},{duration:500,complete:function(){$(this).remove();}});}};function next(){goToAndPause(counter+1);};function previous(){goToAndPause(counter-1);};function isBusy(){return $cont.children().length>1?true:false;};function goToAndPause(index){$cont.children().stop(true,true);if((counter!=index)||((counter==index)&&isBusy())){if(isBusy())$cont.children().eq(0).remove();transitionTo(gallery,index);pause();};};function preloadImg(){$(gallery).each(function(i){$(this).find('img').each(function(i){preloadedImg[i]=$('<img>').attr('src',$(this).attr('src'));});});};function addControls(){$wrap.append('<p class="jshowoff-controls '+uniqueClass+'-controls"><a class="jshowoff-play '+uniqueClass+'-play" href="#null">'+config.controlText.pause+'</a> <a class="jshowoff-prev '+uniqueClass+'-prev" href="#null">'+config.controlText.previous+'</a> <a class="jshowoff-next '+uniqueClass+'-next" href="#null">'+config.controlText.next+'</a></p>');$('.'+uniqueClass+'-controls a').each(function(){if($(this).hasClass('jshowoff-play'))$(this).click(function(){isPlaying()?pause('playBtn'):play();return false;});if($(this).hasClass('jshowoff-prev'))$(this).click(function(){previous();return false;});if($(this).hasClass('jshowoff-next'))$(this).click(function(){next();return false;});});};function addSlideLinks(){$wrap.append('<p class="jshowoff-slidelinks '+uniqueClass+'-slidelinks"></p>');$.each(gallery,function(i,val){var linktext=$(this).attr('title')!=''?$(this).attr('title'):i+1;$('<a class="jshowoff-slidelink-'+i+' '+uniqueClass+'-slidelink-'+i+'" href="#null">'+linktext+'</a>').bind('click',{index:i},function(e){goToAndPause(e.data.index);return false;}).appendTo('.'+uniqueClass+'-slidelinks');});};});return this;};})(jQuery);(function($){$.fn.slideIt=function(settings,callback){var config={direction:'left',showHide:'show',changeSpeed:600};if(settings)$.extend(config,settings);this.each(function(i){$(this).css({left:'auto',right:'auto',top:'auto',bottom:'auto'});var measurement=(config.direction=='left')||(config.direction=='right')?$(this).outerWidth():$(this).outerHeight();var startStyle={};startStyle['position']=$(this).css('position')=='static'?'relative':$(this).css('position');startStyle[config.direction]=(config.showHide=='show')?'-'+measurement+'px':0;var endStyle={};endStyle[config.direction]=config.showHide=='show'?0:'-'+measurement+'px';$(this).css(startStyle).animate(endStyle,config.changeSpeed,callback);});return this;};})(jQuery);


/* ----------------------------------------------------------------------------
 jQuery Cookie Plugin
 https://github.com/carhartl/jquery-cookie

 Copyright 2011, Klaus Hartl
 Dual licensed under the MIT or GPL Version 2 licenses.
 http://www.opensource.org/licenses/mit-license.php
 http://www.opensource.org/licenses/GPL-2.0
*/

(function($){$.cookie=function(key,value,options){if(arguments.length>1&&(!/Object/.test(Object.prototype.toString.call(value))||value===null||value===undefined)){options=$.extend({},options);if(value===null||value===undefined){options.expires=-1;}
if(typeof options.expires==='number'){var days=options.expires,t=options.expires=new Date();t.setDate(t.getDate()+days);}
value=String(value);return(document.cookie=[encodeURIComponent(key),'=',options.raw?value:encodeURIComponent(value),options.expires?'; expires='+options.expires.toUTCString():'',options.path?'; path='+options.path:'',options.domain?'; domain='+options.domain:'',options.secure?'; secure':''].join(''));}
options=value||{};var decode=options.raw?function(s){return s;}:decodeURIComponent;var pairs=document.cookie.split('; ');for(var i=0,pair;pair=pairs[i]&&pairs[i].split('=');i++){if(decode(pair[0])===key)return decode(pair[1]||'');}
return null;};})(jQuery);



/* ----------------------------------------------------------------------------

	MAIN SCRIPT
	
*/


$(window).resize(function() {
	var welcomeheight = $('#welcome').height();
	welcomeheight -= 50;
	$('.features-wrapper').css({'min-height': welcomeheight});
});

$(document).ready(function () {
	
	if ($.cookie('hidewelcome') === null) {
		$('.features').jshowoff({ controls: false, links: false, speed: 6000 });
		var welcomeheight = $('#welcome').height();
		welcomeheight -= 50;
		$('.features-wrapper').css({'min-height': welcomeheight});
		$('#welcome,.features-wrapper').show();
	} else {
		$('#intro').show();
	}
	
	$('.clear-on-focus').each(function() {
    var default_value = this.value;
    $(this).css('color', '#666');
    $(this).focus(function() {
    	if(this.value == default_value) {
      	this.value = '';
      	$(this).css('color', '#333');
      }
    });
    $(this).blur(function() {
    	if(this.value == '') {
      	this.value = default_value;
   			$(this).css('color', '#666');
    	}
    });
	});
	
	$('#newsletterbox').focus(function() {
		mixpanel.track('Newsletter focus');
	});
	
	$('#newsletterbox2').focus(function() {
		mixpanel.track('Newsletter focus');
	});
	
	mixpanel.track_forms("#newsletterform","Newsletter submit");
	mixpanel.track_forms("#newsletterform2","Newsletter submit");
	
	mixpanel.track("Page loaded");
	
});


function hide_welcome() {
	$('#welcome,.features-wrapper').fadeOut(1000,function() {
		$('#intro').show();	
	});
  //mixpanel.track("Hide welcome message");
  $.cookie('hidewelcome','1',{ expires: 365, path: '/', domain: 'politikportal.eu' });
}



