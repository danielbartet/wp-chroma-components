!function(e){var t={};function n(r){if(t[r])return t[r].exports;var o=t[r]={i:r,l:!1,exports:{}};return e[r].call(o.exports,o,o.exports,n),o.l=!0,o.exports}n.m=e,n.c=t,n.d=function(e,t,r){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(n.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var o in e)n.d(r,o,function(t){return e[t]}.bind(null,o));return r},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="",n(n.s=4)}([function(e,t,n){"use strict";(function(e,r){var o,i=n(1);o="undefined"!=typeof self?self:"undefined"!=typeof window?window:void 0!==e?e:r;var a=Object(i.a)(o);t.a=a}).call(this,n(7),n(8)(e))},function(e,t,n){"use strict";function r(e){var t,n=e.Symbol;return"function"==typeof n?n.observable?t=n.observable:(t=n("observable"),n.observable=t):t="@@observable",t}n.d(t,"a",function(){return r})},,,function(e,t,n){"use strict";n(5);n(6);var r=n(9),o=n(10),i=u(n(11)),a=u(n(12)),c=u(n(13));function u(e){return e&&e.__esModule?e:{default:e}}function s(e){if(null!==e&&void 0!==e)return!0}if(o.cmQuizStore.subscribe(o.render),s(document.querySelector(".cm-quiz-single"))){var l="linear-gradient(335deg,"+["#f0f,blue","#ff512f, #dd2476","#5433ff, #20bdff, #a5fecb","#f79d00, #64f38c","#396afc, #2948ff"][function(e){return Math.floor(Math.random()*Math.floor(e))}(5)]+")";document.querySelector(".cm-quiz-single").style.background=l}var d=function(e){var t=this;if(document.getElementsByClassName("cm-quiz-slide").length>0){var n=e.getAttribute("data-id"),i=(document.getElementsByClassName("cm-quiz-box")[0],document.getElementsByClassName("cm-quiz-slide")),a=document.getElementById("cm-quiz-back"),u=document.getElementById("cm-quiz-fwd"),l=document.getElementById("cm-quiz-prog"),d=i.length,f=Math.round(100/d),p=0,m=0,y={a:0,b:1,c:2,d:3};this.Init=function(){l.innerHTML=p+" / "+d,t.watchSlide(p),(0,c.default)("Views",n)},this.watchSlide=function(){p>=d||t.questionHandler()},this.questionTransition=function(){i[p].style.transform="translateX(-100%)",p++,l.innerHTML=p+" / "+d;var e=i[p];p>=d?t.endQuizSequence():(e.classList.add("is-active"),t.watchSlide())},this.endQuizSequence=function(){(0,c.default)("completed",n);var r=!1;r?t.generateResults():(e.getElementsByClassName("cm-quiz-prompt")[0].classList.add("is-active"),r=!0)},this.generateResults=function(){(0,c.default)("subscribed",n),e.getElementsByClassName("cm-quiz-prompt")[0].style.transform="translateX(-100%)";var t=e.getElementsByClassName("cm-quiz-results")[0],r=document.createElement("ul"),i="<li><span>#</span><span>Question</span><span>Answer</span></li>";o.cmQuizStore.getState().questions.forEach(function(e){i+="<li><span>"+e.index+"</span><span>"+e.title+'</span><span class="'+e.correct+'">'+e.answer+"</span></li>"}),r.innerHTML=i,t.innerHTML="<span class='cm-quiz_finalscore'>Score: "+m+"%</span><span class='cm-quiz_share-cta'>Share your score!</span>",t.appendChild(r),t.classList.add("is-active")},this.questionHandler=function(){var a=i[p],u=a.querySelectorAll(".cm-quiz-slide-ans li"),s=!1;[].forEach.call(u,function(e){e.addEventListener("click",function(t){!1===s&&((0,c.default)("question",n,[a.querySelector(".cm-quiz-slide-q").innerHTML,e.innerHTML]),l(e,t),s=!0)})});var l=function i(s,l){if([].forEach.call(u,function(e){e.removeEventListener("click",i)}),Array.prototype.indexOf.call(u,s)===y[a.getAttribute("data-correct")]){m+=f;var d=document.createElement("div");d.className="cm-quiz-shout",d.innerHTML="+"+f+" Points!",e.appendChild(d),setTimeout(function(){d.remove()},2e3)}var b=Array.prototype.filter.call(u,function(e){return Array.prototype.indexOf.call(u,e)===y[a.getAttribute("data-correct")]})[0],h=Array.prototype.filter.call(u,function(e){return e!==b});b.classList.add("correct"),b.setAttribute("data-correct","correct"),[].forEach.call(h,function(e){e.classList.add("incorrect"),e.setAttribute("data-correct","incorrect")}),o.cmQuizStore.dispatch((0,r.addQuestion)(p,a.querySelector(".cm-quiz-slide-q").innerHTML,s.innerHTML,s.getAttribute("data-correct"))),(0,c.default)("answered",n),t.explanationHandler()}},this.explanationHandler=function(){var e=i[p].querySelector(".cm-quiz-slide-exp");e.classList.add("is-active");var n=e.innerText.split(" ").length/213*60*1e3,r=Math.round(n/1e3);t.displayAd(e);!function e(){if(document.getElementsByClassName("cm-quiz_timer")[0].classList.add("is-active"),r<=0)return document.getElementsByClassName("cm-quiz_timer")[0].classList.remove("is-active"),void clearTimeout(e);document.getElementsByClassName("cm-quiz_timer")[0].innerHTML=r,r--,setTimeout(e,1e3)}();var o=document.createElement("DIV");o.className="cm-quiz_timer-bar",o.style.animationDuration=n+"ms",i[p].append(o),window.setTimeout(function(){t.questionTransition(),o.remove()}.bind(t),n)},this.displayAd=function(e){var t=document.createElement("div"),n=document.createElement("ins");t.classList="cm-quiz_ad",n.classList="adsbygoogle",n.setAttribute("style","display:block"),n.setAttribute("data-ad-client","ca-pub-4229549892174356"),n.setAttribute("data-ad-slot","5741416818"),n.setAttribute("data-ad-format","horizontal"),t.appendChild(n),e.insertBefore(t,e.children[0]),(adsbygoogle=window.adsbygoogle||[]).onload=function(){adsbygoogle.push({})}},this.quizNav=function(){var e=null,t=i[p];a.addEventListener("click",function(n){s((t="back"===e?t.previousElementSibling:i[p]).previousElementSibling)&&(t.classList.remove("is-active"),t.previousElementSibling.style.transform="translateX(0px)",t.previousElementSibling.classList.add("is-active"),e="back",u.classList.add("is-active"),console.log(t))}),u.addEventListener("click",function(n){s((t="fwd"===e?t.nextElementSibling:i[p]).nextElementSibling)&&(t.classList.remove("is-active"),t.nextElementSibling.style.transform="translateX(0px)",t.nextElementSibling.classList.add("is-active"),e="fwd",console.log(t))})},this.quizNav()}};!function(){var e=document.getElementById("cm-quiz");if(s(e)){var t=new d(e);t.Init(),new i.default,new a.default(t.generateResults).init()}}()},function(e,t,n){},function(e,t,n){"use strict";n.r(t),n.d(t,"createStore",function(){return c}),n.d(t,"combineReducers",function(){return s}),n.d(t,"bindActionCreators",function(){return d}),n.d(t,"applyMiddleware",function(){return m}),n.d(t,"compose",function(){return p}),n.d(t,"__DO_NOT_USE__ActionTypes",function(){return i});var r=n(0),o=function(){return Math.random().toString(36).substring(7).split("").join(".")},i={INIT:"@@redux/INIT"+o(),REPLACE:"@@redux/REPLACE"+o(),PROBE_UNKNOWN_ACTION:function(){return"@@redux/PROBE_UNKNOWN_ACTION"+o()}};function a(e){if("object"!=typeof e||null===e)return!1;for(var t=e;null!==Object.getPrototypeOf(t);)t=Object.getPrototypeOf(t);return Object.getPrototypeOf(e)===t}function c(e,t,n){var o;if("function"==typeof t&&"function"==typeof n||"function"==typeof n&&"function"==typeof arguments[3])throw new Error("It looks like you are passing several store enhancers to createStore(). This is not supported. Instead, compose them together to a single function");if("function"==typeof t&&void 0===n&&(n=t,t=void 0),void 0!==n){if("function"!=typeof n)throw new Error("Expected the enhancer to be a function.");return n(c)(e,t)}if("function"!=typeof e)throw new Error("Expected the reducer to be a function.");var u=e,s=t,l=[],d=l,f=!1;function p(){d===l&&(d=l.slice())}function m(){if(f)throw new Error("You may not call store.getState() while the reducer is executing. The reducer has already received the state as an argument. Pass it down from the top reducer instead of reading it from the store.");return s}function y(e){if("function"!=typeof e)throw new Error("Expected the listener to be a function.");if(f)throw new Error("You may not call store.subscribe() while the reducer is executing. If you would like to be notified after the store has been updated, subscribe from a component and invoke store.getState() in the callback to access the latest state. See https://redux.js.org/api-reference/store#subscribe(listener) for more details.");var t=!0;return p(),d.push(e),function(){if(t){if(f)throw new Error("You may not unsubscribe from a store listener while the reducer is executing. See https://redux.js.org/api-reference/store#subscribe(listener) for more details.");t=!1,p();var n=d.indexOf(e);d.splice(n,1)}}}function b(e){if(!a(e))throw new Error("Actions must be plain objects. Use custom middleware for async actions.");if(void 0===e.type)throw new Error('Actions may not have an undefined "type" property. Have you misspelled a constant?');if(f)throw new Error("Reducers may not dispatch actions.");try{f=!0,s=u(s,e)}finally{f=!1}for(var t=l=d,n=0;n<t.length;n++){(0,t[n])()}return e}return b({type:i.INIT}),(o={dispatch:b,subscribe:y,getState:m,replaceReducer:function(e){if("function"!=typeof e)throw new Error("Expected the nextReducer to be a function.");u=e,b({type:i.REPLACE})}})[r.a]=function(){var e,t=y;return(e={subscribe:function(e){if("object"!=typeof e||null===e)throw new TypeError("Expected the observer to be an object.");function n(){e.next&&e.next(m())}return n(),{unsubscribe:t(n)}}})[r.a]=function(){return this},e},o}function u(e,t){var n=t&&t.type;return"Given "+(n&&'action "'+String(n)+'"'||"an action")+', reducer "'+e+'" returned undefined. To ignore an action, you must explicitly return the previous state. If you want this reducer to hold no value, you can return null instead of undefined.'}function s(e){for(var t=Object.keys(e),n={},r=0;r<t.length;r++){var o=t[r];0,"function"==typeof e[o]&&(n[o]=e[o])}var a,c=Object.keys(n);try{!function(e){Object.keys(e).forEach(function(t){var n=e[t];if(void 0===n(void 0,{type:i.INIT}))throw new Error('Reducer "'+t+"\" returned undefined during initialization. If the state passed to the reducer is undefined, you must explicitly return the initial state. The initial state may not be undefined. If you don't want to set a value for this reducer, you can use null instead of undefined.");if(void 0===n(void 0,{type:i.PROBE_UNKNOWN_ACTION()}))throw new Error('Reducer "'+t+"\" returned undefined when probed with a random type. Don't try to handle "+i.INIT+' or other actions in "redux/*" namespace. They are considered private. Instead, you must return the current state for any unknown actions, unless it is undefined, in which case you must return the initial state, regardless of the action type. The initial state may not be undefined, but can be null.')})}(n)}catch(e){a=e}return function(e,t){if(void 0===e&&(e={}),a)throw a;for(var r=!1,o={},i=0;i<c.length;i++){var s=c[i],l=n[s],d=e[s],f=l(d,t);if(void 0===f){var p=u(s,t);throw new Error(p)}o[s]=f,r=r||f!==d}return r?o:e}}function l(e,t){return function(){return t(e.apply(this,arguments))}}function d(e,t){if("function"==typeof e)return l(e,t);if("object"!=typeof e||null===e)throw new Error("bindActionCreators expected an object or a function, instead received "+(null===e?"null":typeof e)+'. Did you write "import ActionCreators from" instead of "import * as ActionCreators from"?');for(var n=Object.keys(e),r={},o=0;o<n.length;o++){var i=n[o],a=e[i];"function"==typeof a&&(r[i]=l(a,t))}return r}function f(e,t,n){return t in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e}function p(){for(var e=arguments.length,t=new Array(e),n=0;n<e;n++)t[n]=arguments[n];return 0===t.length?function(e){return e}:1===t.length?t[0]:t.reduce(function(e,t){return function(){return e(t.apply(void 0,arguments))}})}function m(){for(var e=arguments.length,t=new Array(e),n=0;n<e;n++)t[n]=arguments[n];return function(e){return function(){var n=e.apply(void 0,arguments),r=function(){throw new Error("Dispatching while constructing your middleware is not allowed. Other middleware would not be applied to this dispatch.")},o={getState:n.getState,dispatch:function(){return r.apply(void 0,arguments)}},i=t.map(function(e){return e(o)});return function(e){for(var t=1;t<arguments.length;t++){var n=null!=arguments[t]?arguments[t]:{},r=Object.keys(n);"function"==typeof Object.getOwnPropertySymbols&&(r=r.concat(Object.getOwnPropertySymbols(n).filter(function(e){return Object.getOwnPropertyDescriptor(n,e).enumerable}))),r.forEach(function(t){f(e,t,n[t])})}return e}({},n,{dispatch:r=p.apply(void 0,i)(n.dispatch)})}}}},function(e,t){var n;n=function(){return this}();try{n=n||new Function("return this")()}catch(e){"object"==typeof window&&(n=window)}e.exports=n},function(e,t){e.exports=function(e){if(!e.webpackPolyfill){var t=Object.create(e);t.children||(t.children=[]),Object.defineProperty(t,"loaded",{enumerable:!0,get:function(){return t.l}}),Object.defineProperty(t,"id",{enumerable:!0,get:function(){return t.i}}),Object.defineProperty(t,"exports",{enumerable:!0}),t.webpackPolyfill=1}return t}},function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.addQuestion=function(e,t,n,r){return{type:"question",questions:{index:e,title:t,answer:n,correct:r}}},t.countSlide=function(e){return{type:"count",visibleSlide:e+1}}},function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.render=function(){o.getState()},t.questionTracker=i;var r=t.initState={questions:{},count:1},o=t.cmQuizStore=Redux.createStore(i,r);function i(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:r,t=arguments[1];switch(t.type){case"question":return Object.assign({},e,{questions:[].concat(function(e){if(Array.isArray(e)){for(var t=0,n=Array(e.length);t<e.length;t++)n[t]=e[t];return n}return Array.from(e)}(e.questions),[{index:t.questions.index,title:t.questions.title,answer:t.questions.answer,correct:t.questions.correct}])});case"count":return e.count+t.count;default:return e}}},function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0});t.default=function(){window.fbAsyncInit=function(){FB.init({appId:chromaApp.fbAppID,autoLogAppEvents:!0,xfbml:!0,version:"v3.2"})},function(e,t,n){var r,o=e.getElementsByTagName(t)[0];e.getElementById(n)||((r=e.createElement(t)).id=n,r.src="https://connect.facebook.net/en_US/sdk.js",o.parentNode.insertBefore(r,o))}(document,"script","facebook-jssdk"),this.fbLogin=function(e){FB.login(function(t){!function(e){FB.getLoginStatus(function(t){!function(e,t){"connected"===e.status&&(console.log("user logged in and ready to submit data"),formProceszr.facebookSignup(t))}(t,e)})}(e)},{scope:"email"})}}},function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default=function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:null,t=location.protocol+"//"+window.location.hostname+"/wp-json/chroma/form-processer/",n=encodeURI(window.location);function r(r){var i=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"subscribe";fetch(t,{method:"post",headers:{"Content-type":"application/x-www-form-urlencoded; charset=UTF-8"},body:"&email="+r+"&type="+i+"&currURL="+n}).then(function(e){return e.text()}).then(function(t){o(t)&&null!==e&&e()}).catch(function(e){return console.log("Form submission error: "+e)})}function o(e){if(e=e.split(","),Array.isArray(e)){for(var t=0,n=e.length;t<n;t++)e[t]=e[t].replace(/"/g,""),e[t]=e[t].replace(/]/g,""),e[t]=e[t].replace(/\[/g,"");var r=document.getElementById("errorMessage"),o=document.getElementById("errorMessage2");r.classList.remove("is-active"),r.innerText=e[0],o.innerText=e[1],r.classList.add("is-active")}else{e=e.replace(/"/g,"");var i=document.getElementById("errorMessage");i.classList.remove("is-active"),i.innerText=e,i.classList.add("is-active")}return!0}this.facebookSignup=function(n){console.log(n),FB.api("/me","GET",{fields:"id,name,email"},function(r){window.location.hostname;var i=encodeURI(window.location),a="&email="+r.email+"&type=fblogin&currURL="+i;fetch(t,{method:"post",headers:{"Content-type":"application/x-www-form-urlencoded; charset=UTF-8"},body:a}).then(function(e){return e.text()}).then(function(t){o(t)&&null!==e&&e(),null!==n.getAttribute("data-next")&&-1!==n.getAttribute("data-next").indexOf("http")&&(window.location=n.getAttribute("data-next"))}).catch(function(e){alert("Facebook Login Error. Please try again later."),console.log(r)})})},this.init=function(){try{if(doesExist(document.getElementById("subscribe"))){var e=document.getElementById("subscribe");e.addEventListener("submit",function(t){t.preventDefault();var n=e.getAttribute("data-type");n=null!==n?n:"subscribe",r(document.getElementById("subscribeEmail").value,n)})}document.getElementsByClassName("fb-arrow").length>0&&[].forEach.call(document.getElementsByClassName("fb-arrow"),function(e){e.addEventListener("click",function(t){t.preventDefault(),fbApiInit.fbLogin(e)})}),doesExist(document.getElementById("unsub"))&&document.getElementById("unsub").addEventListener("submit",function(e){e.preventDefault(),r(document.getElementById("unsubEmail").value,"unsubscribe")})}catch(e){console.log(e)}}}},function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0});t.default=function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"",t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"",n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:"";if(null!==e){var r=Array.isArray(n)?{name:e,postID:t,value1:n[0],value2:n[1]}:{name:e,postID:t},o={method:"post",headers:{"Content-type":"application/json"},body:JSON.stringify(r)},i=location.protocol+"//"+window.location.hostname+"/wp-json/chroma/cmevents/";fetch(i,o).then(function(e){return e.text()}).then(function(e){}).catch(function(e){return console.log("Event Error: "+e)})}}}]);