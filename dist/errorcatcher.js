!function(e){var t={};function n(r){if(t[r])return t[r].exports;var o=t[r]={i:r,l:!1,exports:{}};return e[r].call(o.exports,o,o.exports,n),o.l=!0,o.exports}n.m=e,n.c=t,n.d=function(e,t,r){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(n.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var o in e)n.d(r,o,function(t){return e[t]}.bind(null,o));return r},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="",n(n.s=3)}({3:function(e,t,n){"use strict";var r=[];!function(){window.addEventListener("error",function(e){r.push(e.error+" | "+event.error.stack),function(e){if(e.length>0){var t="";if((e=e.filter(function(e){return null!=e})).forEach(function(e){e=e.toString(),t+=e+" | "+window.location.href+" | Browser: "+navigator.userAgent}),t.length>0){var n=location.protocol+"//"+window.location.hostname+"/wp-json/chroma/ecollector/",r="client_error="+t,o=new XMLHttpRequest;o.open("POST",n,!0),o.setRequestHeader("Content-type","application/x-www-form-urlencoded; charset=UTF-8"),o.onreadystatechange=function(){4==this.readyState&&this.status},o.send(r)}}}(r)})}()}});