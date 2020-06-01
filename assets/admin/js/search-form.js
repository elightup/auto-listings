/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./assets/admin/js/editor.js":
/*!***********************************!*\
  !*** ./assets/admin/js/editor.js ***!
  \***********************************/
/*! exports provided: editorHTML, editorCSS */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"editorHTML\", function() { return editorHTML; });\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"editorCSS\", function() { return editorCSS; });\nlet editorSettings = _.extend({}, wp.codeEditor.defaultSettings);\n\neditorSettings.codemirror.theme = 'oceanic-next';\nconst editorHTML = wp.codeEditor.initialize('als-post-content', editorSettings).codemirror;\n\nlet cssSettings = _.extend({}, wp.codeEditor.defaultSettings);\n\ncssSettings.codemirror.mode = 'css';\ncssSettings.codemirror.theme = 'oceanic-next';\nconst editorCSS = wp.codeEditor.initialize('als-post-excerpt', cssSettings).codemirror;\n\n//# sourceURL=webpack:///./assets/admin/js/editor.js?");

/***/ }),

/***/ "./assets/admin/js/inserter.js":
/*!*************************************!*\
  !*** ./assets/admin/js/inserter.js ***!
  \*************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _editor_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./editor.js */ \"./assets/admin/js/editor.js\");\n\nconst {\n  useState\n} = wp.element;\nconst btnInsertField = [...document.querySelectorAll('.btn-insert_field')];\nconst btnInsertModal = [...document.querySelectorAll('.btn-insert_modal')];\nbtnInsertField.forEach(btn => btn.addEventListener('click', () => insertTextAtCursor(btn.dataset.field)));\nbtnInsertModal.forEach(btn => btn.addEventListener('click', () => createModal(btn.textContent, btn.dataset.field, btn.dataset.type)));\n\nconst insertTextAtCursor = text => {\n  const doc = _editor_js__WEBPACK_IMPORTED_MODULE_0__[\"editorHTML\"].getDoc();\n  doc.replaceRange(text, doc.getCursor());\n  _editor_js__WEBPACK_IMPORTED_MODULE_0__[\"editorHTML\"].focus();\n};\n\nconst createModal = (text, name, type) => {\n  ReactDOM.render( /*#__PURE__*/React.createElement(Modal, {\n    text: text.trim(),\n    name: name,\n    type: type\n  }), document.getElementById('als-fields'));\n};\n\nconst Modal = props => {\n  const [active, setActive] = useState(true);\n\n  if (!active) {\n    return;\n  }\n\n  const closeModal = () => setActive(false);\n\n  const [values, setValues] = useState({\n    label: '',\n    placeholder: '',\n    prefix: '',\n    suffix: '',\n    type: '',\n    multiple: false\n  });\n\n  const setValue = (attribute, value) => {\n    let newValues = values;\n    newValues[attribute] = value;\n    setValues(newValues);\n  };\n\n  const insert = () => {\n    let shortcode = '';\n    Object.keys(values).forEach(key => {\n      if (values[key]) {\n        shortcode += ` ${key}=\"${values[key]}\"`;\n      }\n    });\n    let name = 'button' === props.type ? '' : ` name=\"${props.name}\"`;\n    shortcode = `[als_${props.type}${name}${shortcode}]`;\n    insertTextAtCursor(shortcode);\n  };\n\n  return /*#__PURE__*/React.createElement(React.Fragment, null, /*#__PURE__*/React.createElement(\"div\", {\n    id: \"modal-bg\",\n    onClick: closeModal\n  }), /*#__PURE__*/React.createElement(\"div\", {\n    className: \"modal\"\n  }, /*#__PURE__*/React.createElement(\"h3\", null, props.text, \" attributes\", /*#__PURE__*/React.createElement(\"span\", {\n    className: \"modal-close\",\n    onClick: closeModal\n  }, \"\\xD7\")), /*#__PURE__*/React.createElement(\"small\", null, /*#__PURE__*/React.createElement(\"i\", null, \"Leave empty to use the default values\")), /*#__PURE__*/React.createElement(FieldAttributes, {\n    data: props.type,\n    setValue: setValue\n  }), /*#__PURE__*/React.createElement(\"div\", {\n    className: \"modal-actions\"\n  }, /*#__PURE__*/React.createElement(Button, {\n    insert: insert,\n    closeModal: closeModal\n  }))));\n};\n\nconst FieldAttributes = props => {\n  if ('button' === props.data) {\n    const options = [{\n      value: 'submit',\n      label: 'Submit'\n    }, {\n      value: 'reset',\n      label: 'Reset'\n    }];\n    return /*#__PURE__*/React.createElement(React.Fragment, null, /*#__PURE__*/React.createElement(\"label\", null, /*#__PURE__*/React.createElement(\"span\", null, \"Label\"), /*#__PURE__*/React.createElement(\"input\", {\n      id: \"als-field_label\",\n      type: \"text\"\n    })), /*#__PURE__*/React.createElement(\"label\", null, /*#__PURE__*/React.createElement(\"span\", null, \"Type\"), /*#__PURE__*/React.createElement(SelectControl, {\n      options: options\n    })));\n  }\n\n  const options = [{\n    value: 'select',\n    label: 'Dropdown'\n  }, {\n    value: 'radio',\n    label: 'Single Choice'\n  }];\n  const [multiple, setMultiple] = useState(true);\n\n  const toggleMultiple = () => setMultiple(!multiple);\n\n  const setValue = props.setValue;\n  return /*#__PURE__*/React.createElement(React.Fragment, null, /*#__PURE__*/React.createElement(\"label\", null, /*#__PURE__*/React.createElement(\"span\", null, \"Label\"), /*#__PURE__*/React.createElement(\"input\", {\n    id: \"als-field_label\",\n    type: \"text\",\n    onChange: e => setValue('label', e.target.value)\n  })), /*#__PURE__*/React.createElement(\"label\", null, /*#__PURE__*/React.createElement(\"span\", null, \"Placeholder\"), /*#__PURE__*/React.createElement(\"input\", {\n    id: \"als-field_placeholder\",\n    type: \"text\",\n    onChange: e => setValue('placeholder', e.target.value)\n  })), /*#__PURE__*/React.createElement(\"label\", null, /*#__PURE__*/React.createElement(\"span\", null, \"Prefix\"), /*#__PURE__*/React.createElement(\"input\", {\n    id: \"als-field_prefix\",\n    type: \"text\",\n    onChange: e => setValue('prefix', e.target.value)\n  })), /*#__PURE__*/React.createElement(\"label\", null, /*#__PURE__*/React.createElement(\"span\", null, \"Suffix\"), /*#__PURE__*/React.createElement(\"input\", {\n    id: \"als-field_suffix\",\n    type: \"text\",\n    onChange: e => setValue('suffix', e.target.value)\n  })), /*#__PURE__*/React.createElement(\"label\", null, /*#__PURE__*/React.createElement(\"span\", null, \"Type\"), /*#__PURE__*/React.createElement(SelectControl, {\n    options: options,\n    toggleMultiple: toggleMultiple,\n    setValue: setValue\n  })), !multiple ? '' : /*#__PURE__*/React.createElement(\"label\", {\n    className: \"modal-checkbox active\"\n  }, /*#__PURE__*/React.createElement(\"input\", {\n    id: \"als-field_multiple\",\n    type: \"checkbox\",\n    onChange: e => setValue('multiple', e.target.checked)\n  }), /*#__PURE__*/React.createElement(\"span\", null, \"Multiple\")));\n};\n\nconst SelectControl = ({\n  options,\n  toggleMultiple,\n  setValue\n}) => {\n  const onChange = e => {\n    if (toggleMultiple) {\n      toggleMultiple();\n    }\n\n    if (setValue) {\n      setValue('type', e.target.value);\n    }\n  };\n\n  return /*#__PURE__*/React.createElement(\"select\", {\n    id: \"als-field_type\",\n    onChange: onChange\n  }, options.map(({\n    value,\n    label\n  }) => /*#__PURE__*/React.createElement(\"option\", {\n    value: value\n  }, label)));\n};\n\nconst Button = ({\n  insert,\n  closeModal\n}) => {\n  const handleClick = () => {\n    insert();\n    setTimeout(() => {\n      closeModal();\n    }, 0);\n  };\n\n  return /*#__PURE__*/React.createElement(\"span\", {\n    class: \"button button-primary button-large\",\n    onClick: handleClick\n  }, \"Insert Field\");\n};\n\n//# sourceURL=webpack:///./assets/admin/js/inserter.js?");

/***/ }),

/***/ "./assets/admin/js/tabs.js":
/*!*********************************!*\
  !*** ./assets/admin/js/tabs.js ***!
  \*********************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _editor_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./editor.js */ \"./assets/admin/js/editor.js\");\n\nconst tabLinks = [...document.querySelectorAll('.als-tab__link')];\nconst tabPanels = [...document.querySelectorAll('.als-tab__pane')];\nconst insertors = [...document.querySelectorAll('.btn-insert_modal'), ...document.querySelectorAll('.btn-insert_field')];\ntabLinks.forEach(btn => btn.addEventListener('click', e => changeTab(e)));\ninsertors.forEach(btn => btn.addEventListener('click', e => changeTab(e)));\n\nconst changeTab = e => {\n  hide([...tabLinks, ...tabPanels]);\n  show(e.target, tabLinks);\n  show(e.target, tabPanels);\n};\n\nconst hide = (array, className = 'is-active') => {\n  array.forEach(el => el.classList.remove(className));\n};\n\nconst show = (e, array, className = 'is-active') => {\n  if (e.classList.contains('button')) {\n    e.classList.add(className);\n  }\n\n  array.find(el => el.dataset.tab === e.dataset.tab).classList.add(className);\n\n  if ('template-editor' === e.dataset.tab) {\n    _editor_js__WEBPACK_IMPORTED_MODULE_0__[\"editorHTML\"].refresh();\n    _editor_js__WEBPACK_IMPORTED_MODULE_0__[\"editorHTML\"].focus();\n  }\n\n  if ('css-editor' === e.dataset.tab) {\n    _editor_js__WEBPACK_IMPORTED_MODULE_0__[\"editorCSS\"].refresh();\n    _editor_js__WEBPACK_IMPORTED_MODULE_0__[\"editorCSS\"].focus();\n  }\n};\n\n//# sourceURL=webpack:///./assets/admin/js/tabs.js?");

/***/ }),

/***/ 0:
/*!*************************************************************************************************!*\
  !*** multi ./assets/admin/js/editor.js ./assets/admin/js/tabs.js ./assets/admin/js/inserter.js ***!
  \*************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

eval("__webpack_require__(/*! ./assets/admin/js/editor.js */\"./assets/admin/js/editor.js\");\n__webpack_require__(/*! ./assets/admin/js/tabs.js */\"./assets/admin/js/tabs.js\");\nmodule.exports = __webpack_require__(/*! ./assets/admin/js/inserter.js */\"./assets/admin/js/inserter.js\");\n\n\n//# sourceURL=webpack:///multi_./assets/admin/js/editor.js_./assets/admin/js/tabs.js_./assets/admin/js/inserter.js?");

/***/ })

/******/ });