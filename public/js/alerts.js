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
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
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
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


$(function () {

        var recipient_id = $("#user_messages").data("user-id");

        Echo.private("new-pm." + recipient_id).listen('PrivateMessageSent', function (event) {

                // variables needed
                var message_icon = $("#message_icon");
                var alert_message = $("#alert_message");
                var message_dropdown = $("#message-dropdown");
                var message_html = "<li class='message-preview'>\n                    <a href=\"" + event.link + "\"><div class='media'>\n                    <span class='pull-left'><img class='media-object' height='35' src=\"" + event.image + "\" alt=''>\n                    </span><div class='media-body'><h5 class='media-heading'>\n                    <strong>" + event.author.name + "</strong></h5><p class='small text-muted'>\n                    <i class='fa fa-clock-o'></i> " + event.created_at + "</p><p>" + event.message + "</p></div></div></a></li>";

                // fade in alert
                alert_message.text("You have been sent a new private message from " + event.author.name + ".");
                alert_message.fadeIn(500);
                alert_message.removeProp("hidden").delay(4000);
                alert_message.fadeOut(500);

                // update dropdowns
                $(message_html).prependTo(message_dropdown);

                // update icon on top bar
                message_icon.css("color", "#50D4FD");
        });
});

/***/ })
/******/ ]);