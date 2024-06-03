/*! For license information please see null.b920a9.js.LICENSE.txt */
(self.webpackChunksage=self.webpackChunksage||[]).push([[642],{702:function(e,t){var n,i,o;!function(r){if("undefined"!=typeof window){var s,a=0,l=!1,u=!1,c="message".length,f="[iFrameSizer]",d=f.length,m=null,h=window.requestAnimationFrame,p={max:1,scroll:1,bodyScroll:1,documentElementScroll:1},g={},y=null,b={autoResize:!0,bodyBackground:null,bodyMargin:null,bodyMarginV1:8,bodyPadding:null,checkOrigin:!0,inPageLinks:!1,enablePublicMethods:!0,heightCalculationMethod:"bodyOffset",id:"iFrameResizer",interval:32,log:!1,maxHeight:1/0,maxWidth:1/0,minHeight:0,minWidth:0,mouseEvents:!0,resizeFrom:"parent",scrolling:!1,sizeHeight:!0,sizeWidth:!1,warningTimeout:5e3,tolerance:0,widthCalculationMethod:"scroll",onClose:function(){return!0},onClosed:function(){},onInit:function(){},onMessage:function(){C("onMessage function not defined")},onMouseEnter:function(){},onMouseLeave:function(){},onResized:function(){},onScroll:function(){return!0}},w={};window.jQuery&&((s=window.jQuery).fn?s.fn.iFrameResize||(s.fn.iFrameResize=function(e){return this.filter("iframe").each((function(t,n){L(n,e)})).end()}):I("","Unable to bind to jQuery, it is not fully loaded.")),i=[],(o="function"==typeof(n=U)?n.apply(t,i):n)===r||(e.exports=o),window.iFrameResize=window.iFrameResize||U()}function v(){return window.MutationObserver||window.WebKitMutationObserver||window.MozMutationObserver}function k(e,t,n){e.addEventListener(t,n,!1)}function T(e,t,n){e.removeEventListener(t,n,!1)}function x(e){return g[e]?g[e].log:l}function O(e,t){M("log",e,t,x(e))}function I(e,t){M("info",e,t,x(e))}function C(e,t){M("warn",e,t,!0)}function M(e,t,n,i){!0===i&&"object"==typeof window.console&&console[e](function(e){return f+"["+function(e){var t="Host page: "+e;return window.top!==window.self&&(t=window.parentIFrame&&window.parentIFrame.getId?window.parentIFrame.getId()+": "+e:"Nested host page: "+e),t}(e)+"]"}(t),n)}function E(e){function t(){n("Height"),n("Width"),N((function(){P(E),A(F),u("onResized",E)}),E,"init")}function n(e){var t=Number(g[F]["max"+e]),n=Number(g[F]["min"+e]),i=e.toLowerCase(),o=Number(E[i]);O(F,"Checking "+i+" is in range "+n+"-"+t),o<n&&(o=n,O(F,"Set "+i+" to min value")),o>t&&(o=t,O(F,"Set "+i+" to max value")),E[i]=""+o}function i(e){return M.substr(M.indexOf(":")+c+e)}function o(e,t){var n,i;n=function(){var n,i;V("Send Page Info","pageInfo:"+(n=document.body.getBoundingClientRect(),i=E.iframe.getBoundingClientRect(),JSON.stringify({iframeHeight:i.height,iframeWidth:i.width,clientHeight:Math.max(document.documentElement.clientHeight,window.innerHeight||0),clientWidth:Math.max(document.documentElement.clientWidth,window.innerWidth||0),offsetTop:parseInt(i.top-n.top,10),offsetLeft:parseInt(i.left-n.left,10),scrollTop:window.pageYOffset,scrollLeft:window.pageXOffset,documentHeight:document.documentElement.clientHeight,documentWidth:document.documentElement.clientWidth,windowHeight:window.innerHeight,windowWidth:window.innerWidth})),e,t)},w[i=t]||(w[i]=setTimeout((function(){w[i]=null,n()}),32))}function r(e){var t=e.getBoundingClientRect();return R(F),{x:Math.floor(Number(t.left)+Number(m.x)),y:Math.floor(Number(t.top)+Number(m.y))}}function s(e){var t=e?r(E.iframe):{x:0,y:0},n={x:Number(E.width)+t.x,y:Number(E.height)+t.y};O(F,"Reposition requested from iFrame (offset x:"+t.x+" y:"+t.y+")"),window.top!==window.self?window.parentIFrame?window.parentIFrame["scrollTo"+(e?"Offset":"")](n.x,n.y):C(F,"Unable to scroll to requested position, window.parentIFrame not found"):(m=n,a(),O(F,"--"))}function a(){!1!==u("onScroll",m)?A(F):W()}function l(e){var t={};if(0===Number(E.width)&&0===Number(E.height)){var n=i(9).split(":");t={x:n[1],y:n[0]}}else t={x:E.width,y:E.height};u(e,{iframe:E.iframe,screenX:Number(t.x),screenY:Number(t.y),type:E.type})}function u(e,t){return S(F,e,t)}var h,p,y,b,v,x,M=e.data,E={},F=null;"[iFrameResizerChild]Ready"===M?function(){for(var e in g)V("iFrame requested init",H(e),g[e].iframe,e)}():f===(""+M).substr(0,d)&&M.substr(d).split(":")[0]in g?(b=(y=M.substr(d).split(":"))[1]?parseInt(y[1],10):0,v=g[y[0]]&&g[y[0]].iframe,x=getComputedStyle(v),E={iframe:v,id:y[0],height:b+function(e){return"border-box"!==e.boxSizing?0:(e.paddingTop?parseInt(e.paddingTop,10):0)+(e.paddingBottom?parseInt(e.paddingBottom,10):0)}(x)+function(e){return"border-box"!==e.boxSizing?0:(e.borderTopWidth?parseInt(e.borderTopWidth,10):0)+(e.borderBottomWidth?parseInt(e.borderBottomWidth,10):0)}(x),width:y[2],type:y[3]},F=E.id,g[F]&&(g[F].loaded=!0),(p=E.type in{true:1,false:1,undefined:1})&&O(F,"Ignoring init message from meta parent page"),!p&&function(e){var t=!0;return g[e]||(t=!1,C(E.type+" No settings for "+e+". Message was: "+M)),t}(F)&&(O(F,"Received: "+M),h=!0,null===E.iframe&&(C(F,"IFrame ("+E.id+") not found"),h=!1),h&&function(){var t,n=e.origin,i=g[F]&&g[F].checkOrigin;if(i&&""+n!="null"&&!(i.constructor===Array?function(){var e=0,t=!1;for(O(F,"Checking connection is from allowed list of origins: "+i);e<i.length;e++)if(i[e]===n){t=!0;break}return t}():(t=g[F]&&g[F].remoteHost,O(F,"Checking connection is from: "+t),n===t)))throw new Error("Unexpected message received from: "+n+" for "+E.iframe.id+". Message was: "+e.data+". This error can be disabled by setting the checkOrigin: false option or by providing of array of trusted domains.");return!0}()&&function(){switch(g[F]&&g[F].firstRun&&g[F]&&(g[F].firstRun=!1),E.type){case"close":z(E.iframe);break;case"message":d=i(6),O(F,"onMessage passed: {iframe: "+E.iframe.id+", message: "+d+"}"),u("onMessage",{iframe:E.iframe,message:JSON.parse(d)}),O(F,"--");break;case"mouseenter":l("onMouseEnter");break;case"mouseleave":l("onMouseLeave");break;case"autoResize":g[F].autoResize=JSON.parse(i(9));break;case"scrollTo":s(!1);break;case"scrollToOffset":s(!0);break;case"pageInfo":o(g[F]&&g[F].iframe,F),function(){function e(e,i){function r(){g[n]?o(g[n].iframe,n):t()}["scroll","resize"].forEach((function(t){O(n,e+t+" listener for sendPageInfo"),i(window,t,r)}))}function t(){e("Remove ",T)}var n=F;e("Add ",k),g[n]&&(g[n].stopPageInfo=t)}();break;case"pageInfoStop":g[F]&&g[F].stopPageInfo&&(g[F].stopPageInfo(),delete g[F].stopPageInfo);break;case"inPageLink":n=i(9).split("#")[1]||"",c=decodeURIComponent(n),(f=document.getElementById(c)||document.getElementsByName(c)[0])?(e=r(f),O(F,"Moving to in page link (#"+n+") at x: "+e.x+" y: "+e.y),m={x:e.x,y:e.y},a(),O(F,"--")):window.top!==window.self?window.parentIFrame?window.parentIFrame.moveToAnchor(n):O(F,"In page link #"+n+" not found and window.parentIFrame not found"):O(F,"In page link #"+n+" not found");break;case"reset":j(E);break;case"init":t(),u("onInit",E.iframe);break;default:0===Number(E.width)&&0===Number(E.height)?C("Unsupported message received ("+E.type+"), this is likely due to the iframe containing a later version of iframe-resizer than the parent page"):t()}var e,n,c,f,d}())):I(F,"Ignored: "+M)}function S(e,t,n){var i=null,o=null;if(g[e]){if("function"!=typeof(i=g[e][t]))throw new TypeError(t+" on iFrame["+e+"] is not a function");o=i(n)}return o}function F(e){var t=e.id;delete g[t]}function z(e){var t=e.id;if(!1!==S(t,"onClose",t)){O(t,"Removing iFrame: "+t);try{e.parentNode&&e.parentNode.removeChild(e)}catch(e){C(e)}S(t,"onClosed",t),O(t,"--"),F(e)}else O(t,"Close iframe cancelled by onClose event")}function R(e){null===m&&O(e,"Get page position: "+(m={x:window.pageXOffset!==r?window.pageXOffset:document.documentElement.scrollLeft,y:window.pageYOffset!==r?window.pageYOffset:document.documentElement.scrollTop}).x+","+m.y)}function A(e){null!==m&&(window.scrollTo(m.x,m.y),O(e,"Set page position: "+m.x+","+m.y),W())}function W(){m=null}function j(e){O(e.id,"Size reset requested by "+("init"===e.type?"host page":"iFrame")),R(e.id),N((function(){P(e),V("reset","reset",e.iframe,e.id)}),e,"reset")}function P(e){function t(t){u||"0"!==e[t]||(u=!0,O(i,"Hidden iFrame detected, creating visibility listener"),function(){function e(){Object.keys(g).forEach((function(e){!function(e){function t(t){return"0px"===(g[e]&&g[e].iframe.style[t])}g[e]&&null!==g[e].iframe.offsetParent&&(t("height")||t("width"))&&V("Visibility change","resize",g[e].iframe,e)}(e)}))}function t(t){O("window","Mutation observed: "+t[0].target+" "+t[0].type),q(e,16)}var n,i=v();i&&(n=document.querySelector("body"),new i(t).observe(n,{attributes:!0,attributeOldValue:!1,characterData:!0,characterDataOldValue:!1,childList:!0,subtree:!0}))}())}function n(n){!function(t){e.id?(e.iframe.style[t]=e[t]+"px",O(e.id,"IFrame ("+i+") "+t+" set to "+e[t]+"px")):O("undefined","messageData id not set")}(n),t(n)}var i=e.iframe.id;g[i]&&(g[i].sizeHeight&&n("height"),g[i].sizeWidth&&n("width"))}function N(e,t,n){n!==t.type&&h&&!window.jasmine?(O(t.id,"Requesting animation frame"),h(e)):e()}function V(e,t,n,i,o){var r,s=!1;i=i||n.id,g[i]&&(n&&"contentWindow"in n&&null!==n.contentWindow?(r=g[i]&&g[i].targetOrigin,O(i,"["+e+"] Sending msg to iframe["+i+"] ("+t+") targetOrigin: "+r),n.contentWindow.postMessage(f+t,r)):C(i,"["+e+"] IFrame("+i+") not found"),o&&g[i]&&g[i].warningTimeout&&(g[i].msgTimeout=setTimeout((function(){!g[i]||g[i].loaded||s||(s=!0,C(i,"IFrame has not responded within "+g[i].warningTimeout/1e3+" seconds. Check iFrameResizer.contentWindow.js has been loaded in iFrame. This message can be ignored if everything is working, or you can set the warningTimeout option to a higher value or zero to suppress this warning."))}),g[i].warningTimeout)))}function H(e){return e+":"+g[e].bodyMarginV1+":"+g[e].sizeWidth+":"+g[e].log+":"+g[e].interval+":"+g[e].enablePublicMethods+":"+g[e].autoResize+":"+g[e].bodyMargin+":"+g[e].heightCalculationMethod+":"+g[e].bodyBackground+":"+g[e].bodyPadding+":"+g[e].tolerance+":"+g[e].inPageLinks+":"+g[e].resizeFrom+":"+g[e].widthCalculationMethod+":"+g[e].mouseEvents}function L(e,t){function n(e){var t=e.split("Callback");if(2===t.length){var n="on"+t[0].charAt(0).toUpperCase()+t[0].slice(1);this[n]=this[e],delete this[e],C(s,"Deprecated: '"+e+"' has been renamed '"+n+"'. The old method will be removed in the next major version.")}}var i,o,s=function(n){var i;return""===n&&(e.id=(i=t&&t.id||b.id+a++,null!==document.getElementById(i)&&(i+=a++),n=i),l=(t||{}).log,O(n,"Added missing iframe ID: "+n+" ("+e.src+")")),n}(e.id);s in g&&"iFrameResizer"in e?C(s,"Ignored iFrame, already setup."):(function(t){var i;t=t||{},g[s]={firstRun:!0,iframe:e,remoteHost:e.src&&e.src.split("/").slice(0,3).join("/")},function(e){if("object"!=typeof e)throw new TypeError("Options is not an object")}(t),Object.keys(t).forEach(n,t),function(e){for(var t in b)Object.prototype.hasOwnProperty.call(b,t)&&(g[s][t]=Object.prototype.hasOwnProperty.call(e,t)?e[t]:b[t])}(t),g[s]&&(g[s].targetOrigin=!0===g[s].checkOrigin?""===(i=g[s].remoteHost)||null!==i.match(/^(about:blank|javascript:|file:\/\/)/)?"*":i:"*")}(t),function(){switch(O(s,"IFrame scrolling "+(g[s]&&g[s].scrolling?"enabled":"disabled")+" for "+s),e.style.overflow=!1===(g[s]&&g[s].scrolling)?"hidden":"auto",g[s]&&g[s].scrolling){case"omit":break;case!0:e.scrolling="yes";break;case!1:e.scrolling="no";break;default:e.scrolling=g[s]?g[s].scrolling:"no"}}(),function(){function t(t){var n=g[s][t];1/0!==n&&0!==n&&(e.style[t]="number"==typeof n?n+"px":n,O(s,"Set "+t+" = "+e.style[t]))}function n(e){if(g[s]["min"+e]>g[s]["max"+e])throw new Error("Value for min"+e+" can not be greater than max"+e)}n("Height"),n("Width"),t("maxHeight"),t("minHeight"),t("maxWidth"),t("minWidth")}(),"number"!=typeof(g[s]&&g[s].bodyMargin)&&"0"!==(g[s]&&g[s].bodyMargin)||(g[s].bodyMarginV1=g[s].bodyMargin,g[s].bodyMargin=g[s].bodyMargin+"px"),i=H(s),(o=v())&&function(t){e.parentNode&&new t((function(t){t.forEach((function(t){Array.prototype.slice.call(t.removedNodes).forEach((function(t){t===e&&z(e)}))}))})).observe(e.parentNode,{childList:!0})}(o),k(e,"load",(function(){var t,n;V("iFrame.onload",i,e,r,!0),t=g[s]&&g[s].firstRun,n=g[s]&&g[s].heightCalculationMethod in p,!t&&n&&j({iframe:e,height:0,width:0,type:"init"})})),V("init",i,e,r,!0),g[s]&&(g[s].iframe.iFrameResizer={close:z.bind(null,g[s].iframe),removeListeners:F.bind(null,g[s].iframe),resize:V.bind(null,"Window resize","resize",g[s].iframe),moveToAnchor:function(e){V("Move to anchor","moveToAnchor:"+e,g[s].iframe,s)},sendMessage:function(e){V("Send Message","message:"+(e=JSON.stringify(e)),g[s].iframe,s)}}))}function q(e,t){null===y&&(y=setTimeout((function(){y=null,e()}),t))}function B(){"hidden"!==document.visibilityState&&(O("document","Trigger event: Visiblity change"),q((function(){D("Tab Visable","resize")}),16))}function D(e,t){Object.keys(g).forEach((function(n){(function(e){return g[e]&&"parent"===g[e].resizeFrom&&g[e].autoResize&&!g[e].firstRun})(n)&&V(e,t,g[n].iframe,n)}))}function U(){function e(e,n){n&&(function(){if(!n.tagName)throw new TypeError("Object is not a valid DOM element");if("IFRAME"!==n.tagName.toUpperCase())throw new TypeError("Expected <IFRAME> tag, found <"+n.tagName+">")}(),L(n,e),t.push(n))}var t;return function(){var e,t=["moz","webkit","o","ms"];for(e=0;e<t.length&&!h;e+=1)h=window[t[e]+"RequestAnimationFrame"];h?h=h.bind(window):O("setup","RequestAnimationFrame not supported")}(),k(window,"message",E),k(window,"resize",(function(){O("window","Trigger event: resize"),q((function(){D("Window resize","resize")}),16)})),k(document,"visibilitychange",B),k(document,"-webkit-visibilitychange",B),function(n,i){switch(t=[],function(e){e&&e.enablePublicMethods&&C("enablePublicMethods option has been removed, public methods are now always available in the iFrame")}(n),typeof i){case"undefined":case"string":Array.prototype.forEach.call(document.querySelectorAll(i||"iframe"),e.bind(r,n));break;case"object":e(n,i);break;default:throw new TypeError("Unexpected data type ("+typeof i+")")}return t}}}()},43:function(e){var t;window,t=function(){return function(e){var t={};function n(i){if(t[i])return t[i].exports;var o=t[i]={i:i,l:!1,exports:{}};return e[i].call(o.exports,o,o.exports,n),o.l=!0,o.exports}return n.m=e,n.c=t,n.d=function(e,t,i){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:i})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var i=Object.create(null);if(n.r(i),Object.defineProperty(i,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var o in e)n.d(i,o,function(t){return e[t]}.bind(null,o));return i},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="",n(n.s=0)}([function(e,t,n){"use strict";n.r(t),n.d(t,"default",(function(){return b}));function i(e,t){for(var n=0;n<t.length;n++){var i=t[n];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}var o=new(function(){function e(){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),this.positions={top:0,bottom:0,height:0}}var t,n;return t=e,(n=[{key:"setViewportTop",value:function(e){return this.positions.top=e?e.scrollTop:window.pageYOffset,this.positions}},{key:"setViewportBottom",value:function(){return this.positions.bottom=this.positions.top+this.positions.height,this.positions}},{key:"setViewportAll",value:function(e){return this.positions.top=e?e.scrollTop:window.pageYOffset,this.positions.height=e?e.clientHeight:document.documentElement.clientHeight,this.positions.bottom=this.positions.top+this.positions.height,this.positions}}])&&i(t.prototype,n),e}()),r=function(e){return NodeList.prototype.isPrototypeOf(e)||HTMLCollection.prototype.isPrototypeOf(e)?Array.from(e):"string"==typeof e||e instanceof String?document.querySelectorAll(e):[e]},s=function(){for(var e,t="transform webkitTransform mozTransform oTransform msTransform".split(" "),n=0;void 0===e;)e=void 0!==document.createElement("div").style[t[n]]?t[n]:void 0,n+=1;return e}();function a(e,t){(null==t||t>e.length)&&(t=e.length);for(var n=0,i=new Array(t);n<t;n++)i[n]=e[n];return i}function l(e,t){for(var n=0;n<t.length;n++){var i=t[n];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}var u=function(){function e(t,n){var i,o=this;!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),this.element=t,this.elementContainer=t,this.settings=n,this.isVisible=!0,this.isInit=!1,this.oldTranslateValue=-1,this.init=this.init.bind(this),this.customWrapper=this.settings.customWrapper&&this.element.closest(this.settings.customWrapper)?this.element.closest(this.settings.customWrapper):null,"img"!==(i=t).tagName.toLowerCase()&&"picture"!==i.tagName.toLowerCase()||i&&i.complete&&(void 0===i.naturalWidth||0!==i.naturalWidth)?this.init():this.element.addEventListener("load",(function(){setTimeout((function(){o.init(!0)}),50)}))}var t,n;return t=e,(n=[{key:"init",value:function(e){var t=this;this.isInit||(e&&(this.rangeMax=null),this.element.closest(".simpleParallax")||(!1===this.settings.overflow&&this.wrapElement(this.element),this.setTransformCSS(),this.getElementOffset(),this.intersectionObserver(),this.getTranslateValue(),this.animate(),this.settings.delay>0?setTimeout((function(){t.setTransitionCSS(),t.elementContainer.classList.add("simple-parallax-initialized")}),10):this.elementContainer.classList.add("simple-parallax-initialized"),this.isInit=!0))}},{key:"wrapElement",value:function(){var e=this.element.closest("picture")||this.element,t=this.customWrapper||document.createElement("div");t.classList.add("simpleParallax"),t.style.overflow="hidden",this.customWrapper||(e.parentNode.insertBefore(t,e),t.appendChild(e)),this.elementContainer=t}},{key:"unWrapElement",value:function(){var e,t=this.elementContainer;this.customWrapper?(t.classList.remove("simpleParallax"),t.style.overflow=""):t.replaceWith.apply(t,function(e){if(Array.isArray(e))return a(e)}(e=t.childNodes)||function(e){if("undefined"!=typeof Symbol&&Symbol.iterator in Object(e))return Array.from(e)}(e)||function(e,t){if(e){if("string"==typeof e)return a(e,t);var n=Object.prototype.toString.call(e).slice(8,-1);return"Object"===n&&e.constructor&&(n=e.constructor.name),"Map"===n||"Set"===n?Array.from(e):"Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)?a(e,t):void 0}}(e)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}())}},{key:"setTransformCSS",value:function(){!1===this.settings.overflow&&(this.element.style[s]="scale(".concat(this.settings.scale,")")),this.element.style.willChange="transform"}},{key:"setTransitionCSS",value:function(){this.element.style.transition="transform ".concat(this.settings.delay,"s ").concat(this.settings.transition)}},{key:"unSetStyle",value:function(){this.element.style.willChange="",this.element.style[s]="",this.element.style.transition=""}},{key:"getElementOffset",value:function(){var e=this.elementContainer.getBoundingClientRect();if(this.elementHeight=e.height,this.elementTop=e.top+o.positions.top,this.settings.customContainer){var t=this.settings.customContainer.getBoundingClientRect();this.elementTop=e.top-t.top+o.positions.top}this.elementBottom=this.elementHeight+this.elementTop}},{key:"buildThresholdList",value:function(){for(var e=[],t=1;t<=this.elementHeight;t++){var n=t/this.elementHeight;e.push(n)}return e}},{key:"intersectionObserver",value:function(){var e={root:null,threshold:this.buildThresholdList()};this.observer=new IntersectionObserver(this.intersectionObserverCallback.bind(this),e),this.observer.observe(this.element)}},{key:"intersectionObserverCallback",value:function(e){var t=this;e.forEach((function(e){e.isIntersecting?t.isVisible=!0:t.isVisible=!1}))}},{key:"checkIfVisible",value:function(){return this.elementBottom>o.positions.top&&this.elementTop<o.positions.bottom}},{key:"getRangeMax",value:function(){var e=this.element.clientHeight;this.rangeMax=e*this.settings.scale-e}},{key:"getTranslateValue",value:function(){var e=((o.positions.bottom-this.elementTop)/((o.positions.height+this.elementHeight)/100)).toFixed(1);return e=Math.min(100,Math.max(0,e)),0!==this.settings.maxTransition&&e>this.settings.maxTransition&&(e=this.settings.maxTransition),this.oldPercentage!==e&&(this.rangeMax||this.getRangeMax(),this.translateValue=(e/100*this.rangeMax-this.rangeMax/2).toFixed(0),this.oldTranslateValue!==this.translateValue&&(this.oldPercentage=e,this.oldTranslateValue=this.translateValue,!0))}},{key:"animate",value:function(){var e,t=0,n=0;(this.settings.orientation.includes("left")||this.settings.orientation.includes("right"))&&(n="".concat(this.settings.orientation.includes("left")?-1*this.translateValue:this.translateValue,"px")),(this.settings.orientation.includes("up")||this.settings.orientation.includes("down"))&&(t="".concat(this.settings.orientation.includes("up")?-1*this.translateValue:this.translateValue,"px")),e=!1===this.settings.overflow?"translate3d(".concat(n,", ").concat(t,", 0) scale(").concat(this.settings.scale,")"):"translate3d(".concat(n,", ").concat(t,", 0)"),this.element.style[s]=e}}])&&l(t.prototype,n),e}();function c(e){return function(e){if(Array.isArray(e))return d(e)}(e)||function(e){if("undefined"!=typeof Symbol&&Symbol.iterator in Object(e))return Array.from(e)}(e)||f(e)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function f(e,t){if(e){if("string"==typeof e)return d(e,t);var n=Object.prototype.toString.call(e).slice(8,-1);return"Object"===n&&e.constructor&&(n=e.constructor.name),"Map"===n||"Set"===n?Array.from(e):"Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)?d(e,t):void 0}}function d(e,t){(null==t||t>e.length)&&(t=e.length);for(var n=0,i=new Array(t);n<t;n++)i[n]=e[n];return i}function m(e,t){for(var n=0;n<t.length;n++){var i=t[n];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}var h,p,g=!1,y=[],b=function(){function e(t,n){if(function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e),t&&Element.prototype.closest&&"IntersectionObserver"in window){if(this.elements=r(t),this.defaults={delay:0,orientation:"up",scale:1.3,overflow:!1,transition:"cubic-bezier(0,0,0,1)",customContainer:"",customWrapper:"",maxTransition:0},this.settings=Object.assign(this.defaults,n),this.settings.customContainer){var i=(o=r(this.settings.customContainer),s=1,function(e){if(Array.isArray(e))return e}(o)||function(e,t){if("undefined"!=typeof Symbol&&Symbol.iterator in Object(e)){var n=[],i=!0,o=!1,r=void 0;try{for(var s,a=e[Symbol.iterator]();!(i=(s=a.next()).done)&&(n.push(s.value),!t||n.length!==t);i=!0);}catch(e){o=!0,r=e}finally{try{i||null==a.return||a.return()}finally{if(o)throw r}}return n}}(o,s)||f(o,s)||function(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}());this.customContainer=i[0]}this.lastPosition=-1,this.resizeIsDone=this.resizeIsDone.bind(this),this.refresh=this.refresh.bind(this),this.proceedRequestAnimationFrame=this.proceedRequestAnimationFrame.bind(this),this.init()}var o,s}var t,n;return t=e,(n=[{key:"init",value:function(){var e=this;o.setViewportAll(this.customContainer),y=[].concat(c(this.elements.map((function(t){return new u(t,e.settings)}))),c(y)),g||(this.proceedRequestAnimationFrame(),window.addEventListener("resize",this.resizeIsDone),g=!0)}},{key:"resizeIsDone",value:function(){clearTimeout(p),p=setTimeout(this.refresh,200)}},{key:"proceedRequestAnimationFrame",value:function(){var e=this;o.setViewportTop(this.customContainer),this.lastPosition!==o.positions.top?(o.setViewportBottom(),y.forEach((function(t){e.proceedElement(t)})),h=window.requestAnimationFrame(this.proceedRequestAnimationFrame),this.lastPosition=o.positions.top):h=window.requestAnimationFrame(this.proceedRequestAnimationFrame)}},{key:"proceedElement",value:function(e){(this.customContainer?e.checkIfVisible():e.isVisible)&&e.getTranslateValue()&&e.animate()}},{key:"refresh",value:function(){o.setViewportAll(this.customContainer),y.forEach((function(e){e.getElementOffset(),e.getRangeMax()})),this.lastPosition=-1}},{key:"destroy",value:function(){var e=this,t=[];y=y.filter((function(n){return e.elements.includes(n.element)?(t.push(n),!1):n})),t.forEach((function(t){t.unSetStyle(),!1===e.settings.overflow&&t.unWrapElement()})),y.length||(window.cancelAnimationFrame(h),window.removeEventListener("resize",this.refresh),g=!1)}}])&&m(t.prototype,n),e}()}]).default},e.exports=t()}}]);