/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./client/javascript/main.js":
/*!***********************************!*\
  !*** ./client/javascript/main.js ***!
  \***********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _src_body__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./src/body */ "./client/javascript/src/body.js");
/* harmony import */ var _src_forms__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./src/forms */ "./client/javascript/src/forms.js");
/* harmony import */ var _src_moods__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./src/moods */ "./client/javascript/src/moods.js");
/* harmony import */ var _src_profile__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./src/profile */ "./client/javascript/src/profile.js");
/* harmony import */ var _src_calendar__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./src/calendar */ "./client/javascript/src/calendar.js");
/* harmony import */ var _src_calendar__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_src_calendar__WEBPACK_IMPORTED_MODULE_4__);





(0,_src_body__WEBPACK_IMPORTED_MODULE_0__["default"])();
(0,_src_forms__WEBPACK_IMPORTED_MODULE_1__["default"])();
(0,_src_moods__WEBPACK_IMPORTED_MODULE_2__["default"])();
(0,_src_profile__WEBPACK_IMPORTED_MODULE_3__["default"])();
// calendar();

/***/ }),

/***/ "./client/javascript/src/body.js":
/*!***************************************!*\
  !*** ./client/javascript/src/body.js ***!
  \***************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
var navbarCollapsible = document.getElementById('mainNav');
var navbarShrink = function navbarShrink() {
  if (window.scrollY <= 10) {
    navbarCollapsible.classList.remove('navbar-shrink');
  } else {
    navbarCollapsible.classList.add('navbar-shrink');
  }
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (function () {
  if (navigator.getEnvironmentIntegrity !== undefined) {
    document.querySelector('body').innerHTML = '<div class="container"><h1>Your browser contains Google DRM</h1>"Web Environment Integrity" is a Google euphemism for a DRM that is designed to prevent ad-blocking. In support of an open web, this website does not function with this DRM. Please install a browser such as <a href="https://www.mozilla.org/en-US/firefox/new/">Firefox</a> that respects your freedom and supports ad blockers.</div>';
  }
  if (navbarCollapsible) {
    navbarShrink();
    document.addEventListener('scroll', navbarShrink);
  }
});

/***/ }),

/***/ "./client/javascript/src/calendar.js":
/*!*******************************************!*\
  !*** ./client/javascript/src/calendar.js ***!
  \*******************************************/
/***/ (() => {

function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }
function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }
function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }
function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }
function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }
function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) arr2[i] = arr[i]; return arr2; }
var popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
var popoverList = _toConsumableArray(popoverTriggerList).map(function (popoverTriggerEl) {
  console.log(popoverTriggerEl);
  new bootstrap.Popover(popoverTriggerEl);
});

/***/ }),

/***/ "./client/javascript/src/forms.js":
/*!****************************************!*\
  !*** ./client/javascript/src/forms.js ***!
  \****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
var actions = Array.from(document.getElementsByClassName('js-formaction'));
var formcontainer = document.getElementById('formcontainer');
var endpoint = 'formhandling/';
var typemap = {
  'application': 'ApplicationForm',
  'note': 'NoteForm',
  'interview': 'InterviewForm',
  'statusupdate': 'StatusUpdateForm'
};
var updateFormContent = function updateFormContent() {
  formcontainer.innerHTML = '';
  formcontainer.insertAdjacentHTML('beforeend', '<div class="text-center">\n' + '  <div class="spinner-border" role="status">\n' + '    <span class="visually-hidden">Loading...</span>\n' + '  </div>\n' + '</div>');
  tinyMCE.remove();
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (function () {
  var myModalEl = document.getElementById('addItemModal');
  myModalEl.addEventListener('hidden.bs.modal', function (event) {
    updateFormContent();
    tinyMCE.remove();
  });
  actions.forEach(function (action) {
    action.addEventListener('click', function () {
      var type = action.getAttribute('data-itemtype').split('-');
      var url = "".concat(endpoint).concat(typemap[type[0]]);
      var id = 0;
      if (type.length > 1) {
        if (type[1] === 'add') {
          id = action.getAttribute('data-application');
        }
        if (type[1] === 'edit') {
          id = action.getAttribute('data-id');
        }
        url = "".concat(url, "/").concat(type[1], "/").concat(id);
      }
      updateFormContent();
      fetch(url, {
        method: 'GET',
        headers: {
          "x-requested-with": "XMLHttpRequest"
        }
      }).then(function (response) {
        return response.json();
      }).then(function (response) {
        formcontainer.innerHTML = '';
        if (response['success'] && response['form'] !== false) {
          formcontainer.insertAdjacentHTML('beforeend', response['form']);
          tinyMCE.init({
            selector: 'textarea.htmleditor',
            skin: 'silverstripe',
            max_height: 250,
            menubar: false,
            statusbar: false
          });
          addFormHook();
        } else {
          updateFormContent();
          setTimeout(function () {
            window.location.reload();
          }, 1000);
        }
      });
    });
  });
});
var addFormHook = function addFormHook() {
  var forms = Array.from(document.getElementsByTagName('form'));
  forms.forEach(function (form) {
    form.addEventListener('submit', function (event) {
      updateFormContent();
      event.preventDefault();
      form.children.find;
      var formData = new FormData(form);
      updateFormContent();
      fetch(form.action, {
        method: form.method,
        body: formData,
        headers: {
          "x-requested-with": "XMLHttpRequest"
        }
      }).then(function (response) {
        return response.json();
      }).then(function (response) {
        if (response['success'] !== false && response['form'] !== false) {
          formcontainer.innerText = '';
          formcontainer.insertAdjacentHTML('beforeend', response['form']);
          tinyMCE.init({
            selector: 'textarea.htmleditor',
            skin: 'silverstripe',
            max_height: 250,
            menubar: false,
            statusbar: false
          });
          addFormHook();
        } else {
          updateFormContent();
          setTimeout(function () {
            window.location.reload();
          }, 500);
        }
      })["catch"](function (error) {
        formcontainer.innerText = "It seems something went wrong. Please try again?";
        setTimeout(function () {
          window.location.reload();
          throw new Error(error);
        }, 5000);
      });
    });
  });
};

/***/ }),

/***/ "./client/javascript/src/moods.js":
/*!****************************************!*\
  !*** ./client/javascript/src/moods.js ***!
  \****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
var moods = Array.from(document.getElementsByClassName('js-moodtracker'));
var currMood = Array.from(document.getElementsByClassName('js-dayscore'))[0];
var applyMoods = function applyMoods(score) {
  moods.forEach(function (mood) {
    var moodScore = parseInt(mood.getAttribute('data-score'));
    mood.children[0].classList.remove('h3');
    if (moodScore !== score) {
      mood.parentElement.classList.add('opacity-50');
      mood.parentElement.classList.add('text-muted');
      mood.children[0].classList.add('h4');
    } else {
      mood.classList.add('active');
      mood.parentElement.classList.add('p-0');
      mood.children[0].classList.add('h2');
    }
    mood.outerHTML = mood.outerHTML;
  });
};
var postMood = function postMood(mood) {
  var score = mood.getAttribute('data-score');
  fetch('/mood', {
    method: 'POST',
    headers: {
      "x-requested-with": "XMLHttpRequest"
    },
    body: JSON.stringify({
      'mood': score
    })
  }).then(function (response) {
    return response.json();
  }).then(function (response) {
    var score = parseInt(response['mood']);
    applyMoods(score);
  });
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (function () {
  if (currMood && currMood.hasAttribute('data-dayscore')) {
    var dayscore = parseInt(currMood.getAttribute('data-dayscore'));
    applyMoods(dayscore);
  }
  moods.forEach(function (mood) {
    mood.addEventListener('click', mood.moodHandler = function () {
      postMood(mood);
    });
  });
});

/***/ }),

/***/ "./client/javascript/src/profile.js":
/*!******************************************!*\
  !*** ./client/javascript/src/profile.js ***!
  \******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* export default binding */ __WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
var showClick = document.getElementsByClassName('showOnClick')[0];
var container = document.getElementsByClassName('showOnClickContainer')[0];
/* harmony default export */ function __WEBPACK_DEFAULT_EXPORT__() {
  if (showClick) {
    var link = showClick.querySelectorAll('a')[0];
    if (link) {
      link.addEventListener('click', function (e) {
        e.preventDefault();
        var classes = container.classList;
        if (classes.contains('d-none')) {
          classes.remove('d-none');
        } else {
          classes.add('d-none');
        }
      });
    }
  }
}

/***/ }),

/***/ "./client/scss/main.scss":
/*!*******************************!*\
  !*** ./client/scss/main.scss ***!
  \*******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./client/scss/calendar.scss":
/*!***********************************!*\
  !*** ./client/scss/calendar.scss ***!
  \***********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/dist/js/main": 0,
/******/ 			"dist/css/calendar": 0,
/******/ 			"dist/css/main": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunk"] = self["webpackChunk"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["dist/css/calendar","dist/css/main"], () => (__webpack_require__("./client/javascript/main.js")))
/******/ 	__webpack_require__.O(undefined, ["dist/css/calendar","dist/css/main"], () => (__webpack_require__("./client/scss/main.scss")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["dist/css/calendar","dist/css/main"], () => (__webpack_require__("./client/scss/calendar.scss")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;
//# sourceMappingURL=main.js.map