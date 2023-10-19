(() => {
  var __create = Object.create;
  var __defProp = Object.defineProperty;
  var __getOwnPropDesc = Object.getOwnPropertyDescriptor;
  var __getOwnPropNames = Object.getOwnPropertyNames;
  var __getProtoOf = Object.getPrototypeOf;
  var __hasOwnProp = Object.prototype.hasOwnProperty;
  var __markAsModule = (target) => __defProp(target, "__esModule", { value: true });
  var __commonJS = (cb, mod) => function __require() {
    return mod || (0, cb[Object.keys(cb)[0]])((mod = { exports: {} }).exports, mod), mod.exports;
  };
  var __reExport = (target, module, desc) => {
    if (module && typeof module === "object" || typeof module === "function") {
      for (let key of __getOwnPropNames(module))
        if (!__hasOwnProp.call(target, key) && key !== "default")
          __defProp(target, key, { get: () => module[key], enumerable: !(desc = __getOwnPropDesc(module, key)) || desc.enumerable });
    }
    return target;
  };
  var __toModule = (module) => {
    return __reExport(__markAsModule(__defProp(module != null ? __create(__getProtoOf(module)) : {}, "default", module && module.__esModule && "default" in module ? { get: () => module.default, enumerable: true } : { value: module, enumerable: true })), module);
  };

  // node_modules/Inputmask/dist/inputmask.js
  var require_inputmask = __commonJS({
    "node_modules/Inputmask/dist/inputmask.js"(exports, module) {
      !function(e4, t4) {
        if (typeof exports == "object" && typeof module == "object")
          module.exports = t4();
        else if (typeof define == "function" && define.amd)
          define([], t4);
        else {
          var i4 = t4();
          for (var a4 in i4)
            (typeof exports == "object" ? exports : e4)[a4] = i4[a4];
        }
      }(self, function() {
        return function() {
          "use strict";
          var e4 = {
            8741: function(e5, t5) {
              Object.defineProperty(t5, "__esModule", {
                value: true
              }), t5.default = void 0;
              var i5 = !(typeof window == "undefined" || !window.document || !window.document.createElement);
              t5.default = i5;
            },
            3976: function(e5, t5, i5) {
              Object.defineProperty(t5, "__esModule", {
                value: true
              }), t5.default = void 0;
              var a5, n4 = (a5 = i5(5581)) && a5.__esModule ? a5 : {
                default: a5
              };
              var r4 = {
                _maxTestPos: 500,
                placeholder: "_",
                optionalmarker: ["[", "]"],
                quantifiermarker: ["{", "}"],
                groupmarker: ["(", ")"],
                alternatormarker: "|",
                escapeChar: "\\",
                mask: null,
                regex: null,
                oncomplete: function() {
                },
                onincomplete: function() {
                },
                oncleared: function() {
                },
                repeat: 0,
                greedy: false,
                autoUnmask: false,
                removeMaskOnSubmit: false,
                clearMaskOnLostFocus: true,
                insertMode: true,
                insertModeVisual: true,
                clearIncomplete: false,
                alias: null,
                onKeyDown: function() {
                },
                onBeforeMask: null,
                onBeforePaste: function(e6, t6) {
                  return typeof t6.onBeforeMask == "function" ? t6.onBeforeMask.call(this, e6, t6) : e6;
                },
                onBeforeWrite: null,
                onUnMask: null,
                showMaskOnFocus: true,
                showMaskOnHover: true,
                onKeyValidation: function() {
                },
                skipOptionalPartCharacter: " ",
                numericInput: false,
                rightAlign: false,
                undoOnEscape: true,
                radixPoint: "",
                _radixDance: false,
                groupSeparator: "",
                keepStatic: null,
                positionCaretOnTab: true,
                tabThrough: false,
                supportsInputType: ["text", "tel", "url", "password", "search"],
                ignorables: [n4.default.BACKSPACE, n4.default.TAB, n4.default["PAUSE/BREAK"], n4.default.ESCAPE, n4.default.PAGE_UP, n4.default.PAGE_DOWN, n4.default.END, n4.default.HOME, n4.default.LEFT, n4.default.UP, n4.default.RIGHT, n4.default.DOWN, n4.default.INSERT, n4.default.DELETE, 93, 112, 113, 114, 115, 116, 117, 118, 119, 120, 121, 122, 123, 0, 229],
                isComplete: null,
                preValidation: null,
                postValidation: null,
                staticDefinitionSymbol: void 0,
                jitMasking: false,
                nullable: true,
                inputEventOnly: false,
                noValuePatching: false,
                positionCaretOnClick: "lvp",
                casing: null,
                inputmode: "text",
                importDataAttributes: true,
                shiftPositions: true,
                usePrototypeDefinitions: true,
                validationEventTimeOut: 3e3,
                substitutes: {}
              };
              t5.default = r4;
            },
            7392: function(e5, t5) {
              Object.defineProperty(t5, "__esModule", {
                value: true
              }), t5.default = void 0;
              t5.default = {
                9: {
                  validator: "[0-9\uFF10-\uFF19]",
                  definitionSymbol: "*"
                },
                a: {
                  validator: "[A-Za-z\u0410-\u044F\u0401\u0451\xC0-\xFF\xB5]",
                  definitionSymbol: "*"
                },
                "*": {
                  validator: "[0-9\uFF10-\uFF19A-Za-z\u0410-\u044F\u0401\u0451\xC0-\xFF\xB5]"
                }
              };
            },
            253: function(e5, t5) {
              Object.defineProperty(t5, "__esModule", {
                value: true
              }), t5.default = function(e6, t6, i5) {
                if (i5 === void 0)
                  return e6.__data ? e6.__data[t6] : null;
                e6.__data = e6.__data || {}, e6.__data[t6] = i5;
              };
            },
            3776: function(e5, t5, i5) {
              Object.defineProperty(t5, "__esModule", {
                value: true
              }), t5.Event = void 0, t5.off = function(e6, t6) {
                var i6, a6;
                function n5(e7, t7, n6) {
                  if (e7 in i6 == true)
                    if (a6.removeEventListener ? a6.removeEventListener(e7, n6, false) : a6.detachEvent && a6.detachEvent("on" + e7, n6), t7 === "global")
                      for (var r6 in i6[e7])
                        i6[e7][r6].splice(i6[e7][r6].indexOf(n6), 1);
                    else
                      i6[e7][t7].splice(i6[e7][t7].indexOf(n6), 1);
                }
                function r5(e7, a7) {
                  var n6, r6, o6 = [];
                  if (e7.length > 0)
                    if (t6 === void 0)
                      for (n6 = 0, r6 = i6[e7][a7].length; n6 < r6; n6++)
                        o6.push({
                          ev: e7,
                          namespace: a7 && a7.length > 0 ? a7 : "global",
                          handler: i6[e7][a7][n6]
                        });
                    else
                      o6.push({
                        ev: e7,
                        namespace: a7 && a7.length > 0 ? a7 : "global",
                        handler: t6
                      });
                  else if (a7.length > 0) {
                    for (var l6 in i6)
                      for (var s6 in i6[l6])
                        if (s6 === a7)
                          if (t6 === void 0)
                            for (n6 = 0, r6 = i6[l6][s6].length; n6 < r6; n6++)
                              o6.push({
                                ev: l6,
                                namespace: s6,
                                handler: i6[l6][s6][n6]
                              });
                          else
                            o6.push({
                              ev: l6,
                              namespace: s6,
                              handler: t6
                            });
                  }
                  return o6;
                }
                if (u4(this[0]) && e6) {
                  i6 = this[0].eventRegistry, a6 = this[0];
                  for (var o5 = e6.split(" "), l5 = 0; l5 < o5.length; l5++)
                    for (var s5 = o5[l5].split("."), c4 = r5(s5[0], s5[1]), f3 = 0, d4 = c4.length; f3 < d4; f3++)
                      n5(c4[f3].ev, c4[f3].namespace, c4[f3].handler);
                }
                return this;
              }, t5.on = function(e6, t6) {
                function i6(e7, i7) {
                  n5.addEventListener ? n5.addEventListener(e7, t6, false) : n5.attachEvent && n5.attachEvent("on" + e7, t6), a6[e7] = a6[e7] || {}, a6[e7][i7] = a6[e7][i7] || [], a6[e7][i7].push(t6);
                }
                if (u4(this[0]))
                  for (var a6 = this[0].eventRegistry, n5 = this[0], r5 = e6.split(" "), o5 = 0; o5 < r5.length; o5++) {
                    var l5 = r5[o5].split("."), s5 = l5[0], c4 = l5[1] || "global";
                    i6(s5, c4);
                  }
                return this;
              }, t5.trigger = function(e6) {
                if (u4(this[0]))
                  for (var t6 = this[0].eventRegistry, i6 = this[0], a6 = typeof e6 == "string" ? e6.split(" ") : [e6.type], r5 = 0; r5 < a6.length; r5++) {
                    var l5 = a6[r5].split("."), s5 = l5[0], c4 = l5[1] || "global";
                    if (document !== void 0 && c4 === "global") {
                      var f3, d4, p4 = {
                        bubbles: true,
                        cancelable: true,
                        detail: arguments[1]
                      };
                      if (document.createEvent) {
                        try {
                          if (s5 === "input")
                            p4.inputType = "insertText", f3 = new InputEvent(s5, p4);
                          else
                            f3 = new CustomEvent(s5, p4);
                        } catch (e7) {
                          (f3 = document.createEvent("CustomEvent")).initCustomEvent(s5, p4.bubbles, p4.cancelable, p4.detail);
                        }
                        e6.type && (0, n4.default)(f3, e6), i6.dispatchEvent(f3);
                      } else
                        (f3 = document.createEventObject()).eventType = s5, f3.detail = arguments[1], e6.type && (0, n4.default)(f3, e6), i6.fireEvent("on" + f3.eventType, f3);
                    } else if (t6[s5] !== void 0)
                      if (arguments[0] = arguments[0].type ? arguments[0] : o4.default.Event(arguments[0]), arguments[0].detail = arguments.slice(1), c4 === "global")
                        for (var h4 in t6[s5])
                          for (d4 = 0; d4 < t6[s5][h4].length; d4++)
                            t6[s5][h4][d4].apply(i6, arguments);
                      else
                        for (d4 = 0; d4 < t6[s5][c4].length; d4++)
                          t6[s5][c4][d4].apply(i6, arguments);
                  }
                return this;
              };
              var a5, n4 = s4(i5(600)), r4 = s4(i5(9380)), o4 = s4(i5(4963)), l4 = s4(i5(8741));
              function s4(e6) {
                return e6 && e6.__esModule ? e6 : {
                  default: e6
                };
              }
              function u4(e6) {
                return e6 instanceof Element;
              }
              t5.Event = a5, typeof r4.default.CustomEvent == "function" ? t5.Event = a5 = r4.default.CustomEvent : l4.default && (t5.Event = a5 = function(e6, t6) {
                t6 = t6 || {
                  bubbles: false,
                  cancelable: false,
                  detail: void 0
                };
                var i6 = document.createEvent("CustomEvent");
                return i6.initCustomEvent(e6, t6.bubbles, t6.cancelable, t6.detail), i6;
              }, a5.prototype = r4.default.Event.prototype);
            },
            600: function(e5, t5) {
              function i5(e6) {
                return i5 = typeof Symbol == "function" && typeof Symbol.iterator == "symbol" ? function(e7) {
                  return typeof e7;
                } : function(e7) {
                  return e7 && typeof Symbol == "function" && e7.constructor === Symbol && e7 !== Symbol.prototype ? "symbol" : typeof e7;
                }, i5(e6);
              }
              Object.defineProperty(t5, "__esModule", {
                value: true
              }), t5.default = function e6() {
                var t6, a5, n4, r4, o4, l4, s4 = arguments[0] || {}, u4 = 1, c4 = arguments.length, f3 = false;
                typeof s4 == "boolean" && (f3 = s4, s4 = arguments[u4] || {}, u4++);
                i5(s4) !== "object" && typeof s4 != "function" && (s4 = {});
                for (; u4 < c4; u4++)
                  if ((t6 = arguments[u4]) != null)
                    for (a5 in t6)
                      n4 = s4[a5], r4 = t6[a5], s4 !== r4 && (f3 && r4 && (Object.prototype.toString.call(r4) === "[object Object]" || (o4 = Array.isArray(r4))) ? (o4 ? (o4 = false, l4 = n4 && Array.isArray(n4) ? n4 : []) : l4 = n4 && Object.prototype.toString.call(n4) === "[object Object]" ? n4 : {}, s4[a5] = e6(f3, l4, r4)) : r4 !== void 0 && (s4[a5] = r4));
                return s4;
              };
            },
            4963: function(e5, t5, i5) {
              Object.defineProperty(t5, "__esModule", {
                value: true
              }), t5.default = void 0;
              var a5 = l4(i5(600)), n4 = l4(i5(9380)), r4 = l4(i5(253)), o4 = i5(3776);
              function l4(e6) {
                return e6 && e6.__esModule ? e6 : {
                  default: e6
                };
              }
              var s4 = n4.default.document;
              function u4(e6) {
                return e6 instanceof u4 ? e6 : this instanceof u4 ? void (e6 != null && e6 !== n4.default && (this[0] = e6.nodeName ? e6 : e6[0] !== void 0 && e6[0].nodeName ? e6[0] : s4.querySelector(e6), this[0] !== void 0 && this[0] !== null && (this[0].eventRegistry = this[0].eventRegistry || {}))) : new u4(e6);
              }
              u4.prototype = {
                on: o4.on,
                off: o4.off,
                trigger: o4.trigger
              }, u4.extend = a5.default, u4.data = r4.default, u4.Event = o4.Event;
              var c4 = u4;
              t5.default = c4;
            },
            9845: function(e5, t5, i5) {
              Object.defineProperty(t5, "__esModule", {
                value: true
              }), t5.ua = t5.mobile = t5.iphone = t5.iemobile = t5.ie = void 0;
              var a5, n4 = (a5 = i5(9380)) && a5.__esModule ? a5 : {
                default: a5
              };
              var r4 = n4.default.navigator && n4.default.navigator.userAgent || "", o4 = r4.indexOf("MSIE ") > 0 || r4.indexOf("Trident/") > 0, l4 = "ontouchstart" in n4.default, s4 = /iemobile/i.test(r4), u4 = /iphone/i.test(r4) && !s4;
              t5.iphone = u4, t5.iemobile = s4, t5.mobile = l4, t5.ie = o4, t5.ua = r4;
            },
            7184: function(e5, t5) {
              Object.defineProperty(t5, "__esModule", {
                value: true
              }), t5.default = function(e6) {
                return e6.replace(i5, "\\$1");
              };
              var i5 = new RegExp("(\\" + ["/", ".", "*", "+", "?", "|", "(", ")", "[", "]", "{", "}", "\\", "$", "^"].join("|\\") + ")", "gim");
            },
            6030: function(e5, t5, i5) {
              Object.defineProperty(t5, "__esModule", {
                value: true
              }), t5.EventHandlers = void 0;
              var a5, n4 = i5(8711), r4 = (a5 = i5(5581)) && a5.__esModule ? a5 : {
                default: a5
              }, o4 = i5(9845), l4 = i5(7215), s4 = i5(7760), u4 = i5(4713);
              function c4(e6, t6) {
                var i6 = typeof Symbol != "undefined" && e6[Symbol.iterator] || e6["@@iterator"];
                if (!i6) {
                  if (Array.isArray(e6) || (i6 = function(e7, t7) {
                    if (!e7)
                      return;
                    if (typeof e7 == "string")
                      return f3(e7, t7);
                    var i7 = Object.prototype.toString.call(e7).slice(8, -1);
                    i7 === "Object" && e7.constructor && (i7 = e7.constructor.name);
                    if (i7 === "Map" || i7 === "Set")
                      return Array.from(e7);
                    if (i7 === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(i7))
                      return f3(e7, t7);
                  }(e6)) || t6 && e6 && typeof e6.length == "number") {
                    i6 && (e6 = i6);
                    var a6 = 0, n5 = function() {
                    };
                    return {
                      s: n5,
                      n: function() {
                        return a6 >= e6.length ? {
                          done: true
                        } : {
                          done: false,
                          value: e6[a6++]
                        };
                      },
                      e: function(e7) {
                        throw e7;
                      },
                      f: n5
                    };
                  }
                  throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
                }
                var r5, o5 = true, l5 = false;
                return {
                  s: function() {
                    i6 = i6.call(e6);
                  },
                  n: function() {
                    var e7 = i6.next();
                    return o5 = e7.done, e7;
                  },
                  e: function(e7) {
                    l5 = true, r5 = e7;
                  },
                  f: function() {
                    try {
                      o5 || i6.return == null || i6.return();
                    } finally {
                      if (l5)
                        throw r5;
                    }
                  }
                };
              }
              function f3(e6, t6) {
                (t6 == null || t6 > e6.length) && (t6 = e6.length);
                for (var i6 = 0, a6 = new Array(t6); i6 < t6; i6++)
                  a6[i6] = e6[i6];
                return a6;
              }
              var d4 = {
                keydownEvent: function(e6) {
                  var t6 = this.inputmask, i6 = t6.opts, a6 = t6.dependencyLib, c5 = t6.maskset, f4 = this, d5 = a6(f4), p4 = e6.keyCode, h4 = n4.caret.call(t6, f4), v3 = i6.onKeyDown.call(this, e6, n4.getBuffer.call(t6), h4, i6);
                  if (v3 !== void 0)
                    return v3;
                  if (p4 === r4.default.BACKSPACE || p4 === r4.default.DELETE || o4.iphone && p4 === r4.default.BACKSPACE_SAFARI || e6.ctrlKey && p4 === r4.default.X && !("oncut" in f4))
                    e6.preventDefault(), l4.handleRemove.call(t6, f4, p4, h4), (0, s4.writeBuffer)(f4, n4.getBuffer.call(t6, true), c5.p, e6, f4.inputmask._valueGet() !== n4.getBuffer.call(t6).join(""));
                  else if (p4 === r4.default.END || p4 === r4.default.PAGE_DOWN) {
                    e6.preventDefault();
                    var m3 = n4.seekNext.call(t6, n4.getLastValidPosition.call(t6));
                    n4.caret.call(t6, f4, e6.shiftKey ? h4.begin : m3, m3, true);
                  } else
                    p4 === r4.default.HOME && !e6.shiftKey || p4 === r4.default.PAGE_UP ? (e6.preventDefault(), n4.caret.call(t6, f4, 0, e6.shiftKey ? h4.begin : 0, true)) : i6.undoOnEscape && p4 === r4.default.ESCAPE && e6.altKey !== true ? ((0, s4.checkVal)(f4, true, false, t6.undoValue.split("")), d5.trigger("click")) : p4 !== r4.default.INSERT || e6.shiftKey || e6.ctrlKey || t6.userOptions.insertMode !== void 0 ? i6.tabThrough === true && p4 === r4.default.TAB ? e6.shiftKey === true ? (h4.end = n4.seekPrevious.call(t6, h4.end, true), u4.getTest.call(t6, h4.end - 1).match.static === true && h4.end--, h4.begin = n4.seekPrevious.call(t6, h4.end, true), h4.begin >= 0 && h4.end > 0 && (e6.preventDefault(), n4.caret.call(t6, f4, h4.begin, h4.end))) : (h4.begin = n4.seekNext.call(t6, h4.begin, true), h4.end = n4.seekNext.call(t6, h4.begin, true), h4.end < c5.maskLength && h4.end--, h4.begin <= c5.maskLength && (e6.preventDefault(), n4.caret.call(t6, f4, h4.begin, h4.end))) : e6.shiftKey || i6.insertModeVisual && i6.insertMode === false && (p4 === r4.default.RIGHT ? setTimeout(function() {
                      var e7 = n4.caret.call(t6, f4);
                      n4.caret.call(t6, f4, e7.begin);
                    }, 0) : p4 === r4.default.LEFT && setTimeout(function() {
                      var e7 = n4.translatePosition.call(t6, f4.inputmask.caretPos.begin);
                      n4.translatePosition.call(t6, f4.inputmask.caretPos.end);
                      t6.isRTL ? n4.caret.call(t6, f4, e7 + (e7 === c5.maskLength ? 0 : 1)) : n4.caret.call(t6, f4, e7 - (e7 === 0 ? 0 : 1));
                    }, 0)) : l4.isSelection.call(t6, h4) ? i6.insertMode = !i6.insertMode : (i6.insertMode = !i6.insertMode, n4.caret.call(t6, f4, h4.begin, h4.begin));
                  t6.ignorable = i6.ignorables.includes(p4);
                },
                keypressEvent: function(e6, t6, i6, a6, o5) {
                  var u5 = this.inputmask || this, c5 = u5.opts, f4 = u5.dependencyLib, d5 = u5.maskset, p4 = u5.el, h4 = f4(p4), v3 = e6.keyCode;
                  if (!(t6 === true || e6.ctrlKey && e6.altKey) && (e6.ctrlKey || e6.metaKey || u5.ignorable))
                    return v3 === r4.default.ENTER && u5.undoValue !== u5._valueGet(true) && (u5.undoValue = u5._valueGet(true), setTimeout(function() {
                      h4.trigger("change");
                    }, 0)), u5.skipInputEvent = true, true;
                  if (v3) {
                    v3 !== 44 && v3 !== 46 || e6.location !== 3 || c5.radixPoint === "" || (v3 = c5.radixPoint.charCodeAt(0));
                    var m3, g3 = t6 ? {
                      begin: o5,
                      end: o5
                    } : n4.caret.call(u5, p4), k3 = String.fromCharCode(v3);
                    k3 = c5.substitutes[k3] || k3, d5.writeOutBuffer = true;
                    var y3 = l4.isValid.call(u5, g3, k3, a6, void 0, void 0, void 0, t6);
                    if (y3 !== false && (n4.resetMaskSet.call(u5, true), m3 = y3.caret !== void 0 ? y3.caret : n4.seekNext.call(u5, y3.pos.begin ? y3.pos.begin : y3.pos), d5.p = m3), m3 = c5.numericInput && y3.caret === void 0 ? n4.seekPrevious.call(u5, m3) : m3, i6 !== false && (setTimeout(function() {
                      c5.onKeyValidation.call(p4, v3, y3);
                    }, 0), d5.writeOutBuffer && y3 !== false)) {
                      var b3 = n4.getBuffer.call(u5);
                      (0, s4.writeBuffer)(p4, b3, m3, e6, t6 !== true);
                    }
                    if (e6.preventDefault(), t6)
                      return y3 !== false && (y3.forwardPosition = m3), y3;
                  }
                },
                keyupEvent: function(e6) {
                  var t6 = this.inputmask;
                  !t6.isComposing || e6.keyCode !== r4.default.KEY_229 && e6.keyCode !== r4.default.ENTER || t6.$el.trigger("input");
                },
                pasteEvent: function(e6) {
                  var t6, i6 = this.inputmask, a6 = i6.opts, r5 = i6._valueGet(true), o5 = n4.caret.call(i6, this);
                  i6.isRTL && (t6 = o5.end, o5.end = n4.translatePosition.call(i6, o5.begin), o5.begin = n4.translatePosition.call(i6, t6));
                  var l5 = r5.substr(0, o5.begin), u5 = r5.substr(o5.end, r5.length);
                  if (l5 == (i6.isRTL ? n4.getBufferTemplate.call(i6).slice().reverse() : n4.getBufferTemplate.call(i6)).slice(0, o5.begin).join("") && (l5 = ""), u5 == (i6.isRTL ? n4.getBufferTemplate.call(i6).slice().reverse() : n4.getBufferTemplate.call(i6)).slice(o5.end).join("") && (u5 = ""), window.clipboardData && window.clipboardData.getData)
                    r5 = l5 + window.clipboardData.getData("Text") + u5;
                  else {
                    if (!e6.clipboardData || !e6.clipboardData.getData)
                      return true;
                    r5 = l5 + e6.clipboardData.getData("text/plain") + u5;
                  }
                  var f4 = r5;
                  if (i6.isRTL) {
                    f4 = f4.split("");
                    var d5, p4 = c4(n4.getBufferTemplate.call(i6));
                    try {
                      for (p4.s(); !(d5 = p4.n()).done; ) {
                        var h4 = d5.value;
                        f4[0] === h4 && f4.shift();
                      }
                    } catch (e7) {
                      p4.e(e7);
                    } finally {
                      p4.f();
                    }
                    f4 = f4.join("");
                  }
                  if (typeof a6.onBeforePaste == "function") {
                    if ((f4 = a6.onBeforePaste.call(i6, f4, a6)) === false)
                      return false;
                    f4 || (f4 = r5);
                  }
                  (0, s4.checkVal)(this, true, false, f4.toString().split(""), e6), e6.preventDefault();
                },
                inputFallBackEvent: function(e6) {
                  var t6 = this.inputmask, i6 = t6.opts, a6 = t6.dependencyLib;
                  var l5 = this, c5 = l5.inputmask._valueGet(true), f4 = (t6.isRTL ? n4.getBuffer.call(t6).slice().reverse() : n4.getBuffer.call(t6)).join(""), p4 = n4.caret.call(t6, l5, void 0, void 0, true);
                  if (f4 !== c5) {
                    c5 = function(e7, i7, a7) {
                      if (o4.iemobile) {
                        var r5 = i7.replace(n4.getBuffer.call(t6).join(""), "");
                        if (r5.length === 1) {
                          var l6 = i7.split("");
                          l6.splice(a7.begin, 0, r5), i7 = l6.join("");
                        }
                      }
                      return i7;
                    }(0, c5, p4);
                    var h4 = function(e7, a7, r5) {
                      for (var o5, l6, s5, c6 = e7.substr(0, r5.begin).split(""), f5 = e7.substr(r5.begin).split(""), d5 = a7.substr(0, r5.begin).split(""), p5 = a7.substr(r5.begin).split(""), h5 = c6.length >= d5.length ? c6.length : d5.length, v4 = f5.length >= p5.length ? f5.length : p5.length, m3 = "", g3 = [], k3 = "~"; c6.length < h5; )
                        c6.push(k3);
                      for (; d5.length < h5; )
                        d5.push(k3);
                      for (; f5.length < v4; )
                        f5.unshift(k3);
                      for (; p5.length < v4; )
                        p5.unshift(k3);
                      var y3 = c6.concat(f5), b3 = d5.concat(p5);
                      for (l6 = 0, o5 = y3.length; l6 < o5; l6++)
                        switch (s5 = u4.getPlaceholder.call(t6, n4.translatePosition.call(t6, l6)), m3) {
                          case "insertText":
                            b3[l6 - 1] === y3[l6] && r5.begin == y3.length - 1 && g3.push(y3[l6]), l6 = o5;
                            break;
                          case "insertReplacementText":
                          case "deleteContentBackward":
                            y3[l6] === k3 ? r5.end++ : l6 = o5;
                            break;
                          default:
                            y3[l6] !== b3[l6] && (y3[l6 + 1] !== k3 && y3[l6 + 1] !== s5 && y3[l6 + 1] !== void 0 || (b3[l6] !== s5 || b3[l6 + 1] !== k3) && b3[l6] !== k3 ? b3[l6 + 1] === k3 && b3[l6] === y3[l6 + 1] ? (m3 = "insertText", g3.push(y3[l6]), r5.begin--, r5.end--) : y3[l6] !== s5 && y3[l6] !== k3 && (y3[l6 + 1] === k3 || b3[l6] !== y3[l6] && b3[l6 + 1] === y3[l6 + 1]) ? (m3 = "insertReplacementText", g3.push(y3[l6]), r5.begin--) : y3[l6] === k3 ? (m3 = "deleteContentBackward", (n4.isMask.call(t6, n4.translatePosition.call(t6, l6), true) || b3[l6] === i6.radixPoint) && r5.end++) : l6 = o5 : (m3 = "insertText", g3.push(y3[l6]), r5.begin--, r5.end--));
                        }
                      return {
                        action: m3,
                        data: g3,
                        caret: r5
                      };
                    }(c5, f4, p4);
                    switch ((l5.inputmask.shadowRoot || l5.ownerDocument).activeElement !== l5 && l5.focus(), (0, s4.writeBuffer)(l5, n4.getBuffer.call(t6)), n4.caret.call(t6, l5, p4.begin, p4.end, true), h4.action) {
                      case "insertText":
                      case "insertReplacementText":
                        h4.data.forEach(function(e7, i7) {
                          var n5 = new a6.Event("keypress");
                          n5.keyCode = e7.charCodeAt(0), t6.ignorable = false, d4.keypressEvent.call(l5, n5);
                        }), setTimeout(function() {
                          t6.$el.trigger("keyup");
                        }, 0);
                        break;
                      case "deleteContentBackward":
                        var v3 = new a6.Event("keydown");
                        v3.keyCode = r4.default.BACKSPACE, d4.keydownEvent.call(l5, v3);
                        break;
                      default:
                        (0, s4.applyInputValue)(l5, c5);
                    }
                    e6.preventDefault();
                  }
                },
                compositionendEvent: function(e6) {
                  var t6 = this.inputmask;
                  t6.isComposing = false, t6.$el.trigger("input");
                },
                setValueEvent: function(e6) {
                  var t6 = this.inputmask, i6 = this, a6 = e6 && e6.detail ? e6.detail[0] : arguments[1];
                  a6 === void 0 && (a6 = i6.inputmask._valueGet(true)), (0, s4.applyInputValue)(i6, a6), (e6.detail && e6.detail[1] !== void 0 || arguments[2] !== void 0) && n4.caret.call(t6, i6, e6.detail ? e6.detail[1] : arguments[2]);
                },
                focusEvent: function(e6) {
                  var t6 = this.inputmask, i6 = t6.opts, a6 = this, r5 = a6.inputmask._valueGet();
                  i6.showMaskOnFocus && r5 !== n4.getBuffer.call(t6).join("") && (0, s4.writeBuffer)(a6, n4.getBuffer.call(t6), n4.seekNext.call(t6, n4.getLastValidPosition.call(t6))), i6.positionCaretOnTab !== true || t6.mouseEnter !== false || l4.isComplete.call(t6, n4.getBuffer.call(t6)) && n4.getLastValidPosition.call(t6) !== -1 || d4.clickEvent.apply(a6, [e6, true]), t6.undoValue = t6._valueGet(true);
                },
                invalidEvent: function(e6) {
                  this.inputmask.validationEvent = true;
                },
                mouseleaveEvent: function() {
                  var e6 = this.inputmask, t6 = e6.opts, i6 = this;
                  e6.mouseEnter = false, t6.clearMaskOnLostFocus && (i6.inputmask.shadowRoot || i6.ownerDocument).activeElement !== i6 && (0, s4.HandleNativePlaceholder)(i6, e6.originalPlaceholder);
                },
                clickEvent: function(e6, t6) {
                  var i6 = this.inputmask, a6 = this;
                  if ((a6.inputmask.shadowRoot || a6.ownerDocument).activeElement === a6) {
                    var r5 = n4.determineNewCaretPosition.call(i6, n4.caret.call(i6, a6), t6);
                    r5 !== void 0 && n4.caret.call(i6, a6, r5);
                  }
                },
                cutEvent: function(e6) {
                  var t6 = this.inputmask, i6 = t6.maskset, a6 = this, o5 = n4.caret.call(t6, a6), u5 = t6.isRTL ? n4.getBuffer.call(t6).slice(o5.end, o5.begin) : n4.getBuffer.call(t6).slice(o5.begin, o5.end), c5 = t6.isRTL ? u5.reverse().join("") : u5.join("");
                  window.navigator.clipboard ? window.navigator.clipboard.writeText(c5) : window.clipboardData && window.clipboardData.getData && window.clipboardData.setData("Text", c5), l4.handleRemove.call(t6, a6, r4.default.DELETE, o5), (0, s4.writeBuffer)(a6, n4.getBuffer.call(t6), i6.p, e6, t6.undoValue !== t6._valueGet(true));
                },
                blurEvent: function(e6) {
                  var t6 = this.inputmask, i6 = t6.opts, a6 = (0, t6.dependencyLib)(this), r5 = this;
                  if (r5.inputmask) {
                    (0, s4.HandleNativePlaceholder)(r5, t6.originalPlaceholder);
                    var o5 = r5.inputmask._valueGet(), u5 = n4.getBuffer.call(t6).slice();
                    o5 !== "" && (i6.clearMaskOnLostFocus && (n4.getLastValidPosition.call(t6) === -1 && o5 === n4.getBufferTemplate.call(t6).join("") ? u5 = [] : s4.clearOptionalTail.call(t6, u5)), l4.isComplete.call(t6, u5) === false && (setTimeout(function() {
                      a6.trigger("incomplete");
                    }, 0), i6.clearIncomplete && (n4.resetMaskSet.call(t6), u5 = i6.clearMaskOnLostFocus ? [] : n4.getBufferTemplate.call(t6).slice())), (0, s4.writeBuffer)(r5, u5, void 0, e6)), t6.undoValue !== t6._valueGet(true) && (t6.undoValue = t6._valueGet(true), a6.trigger("change"));
                  }
                },
                mouseenterEvent: function() {
                  var e6 = this.inputmask, t6 = e6.opts, i6 = this;
                  if (e6.mouseEnter = true, (i6.inputmask.shadowRoot || i6.ownerDocument).activeElement !== i6) {
                    var a6 = (e6.isRTL ? n4.getBufferTemplate.call(e6).slice().reverse() : n4.getBufferTemplate.call(e6)).join("");
                    e6.placeholder !== a6 && i6.placeholder !== e6.originalPlaceholder && (e6.originalPlaceholder = i6.placeholder), t6.showMaskOnHover && (0, s4.HandleNativePlaceholder)(i6, a6);
                  }
                },
                submitEvent: function() {
                  var e6 = this.inputmask, t6 = e6.opts;
                  e6.undoValue !== e6._valueGet(true) && e6.$el.trigger("change"), n4.getLastValidPosition.call(e6) === -1 && e6._valueGet && e6._valueGet() === n4.getBufferTemplate.call(e6).join("") && e6._valueSet(""), t6.clearIncomplete && l4.isComplete.call(e6, n4.getBuffer.call(e6)) === false && e6._valueSet(""), t6.removeMaskOnSubmit && (e6._valueSet(e6.unmaskedvalue(), true), setTimeout(function() {
                    (0, s4.writeBuffer)(e6.el, n4.getBuffer.call(e6));
                  }, 0));
                },
                resetEvent: function() {
                  var e6 = this.inputmask;
                  e6.refreshValue = true, setTimeout(function() {
                    (0, s4.applyInputValue)(e6.el, e6._valueGet(true));
                  }, 0);
                }
              };
              t5.EventHandlers = d4;
            },
            9716: function(e5, t5, i5) {
              Object.defineProperty(t5, "__esModule", {
                value: true
              }), t5.EventRuler = void 0;
              var a5 = l4(i5(2394)), n4 = l4(i5(5581)), r4 = i5(8711), o4 = i5(7760);
              function l4(e6) {
                return e6 && e6.__esModule ? e6 : {
                  default: e6
                };
              }
              var s4 = {
                on: function(e6, t6, i6) {
                  var l5 = e6.inputmask.dependencyLib, s5 = function(t7) {
                    t7.originalEvent && (t7 = t7.originalEvent || t7, arguments[0] = t7);
                    var s6, u4 = this, c4 = u4.inputmask, f3 = c4 ? c4.opts : void 0;
                    if (c4 === void 0 && this.nodeName !== "FORM") {
                      var d4 = l5.data(u4, "_inputmask_opts");
                      l5(u4).off(), d4 && new a5.default(d4).mask(u4);
                    } else {
                      if (["submit", "reset", "setvalue"].includes(t7.type) || this.nodeName === "FORM" || !(u4.disabled || u4.readOnly && !(t7.type === "keydown" && t7.ctrlKey && t7.keyCode === 67 || f3.tabThrough === false && t7.keyCode === n4.default.TAB))) {
                        switch (t7.type) {
                          case "input":
                            if (c4.skipInputEvent === true || t7.inputType && t7.inputType === "insertCompositionText")
                              return c4.skipInputEvent = false, t7.preventDefault();
                            break;
                          case "keydown":
                            c4.skipKeyPressEvent = false, c4.skipInputEvent = c4.isComposing = t7.keyCode === n4.default.KEY_229;
                            break;
                          case "keyup":
                          case "compositionend":
                            c4.isComposing && (c4.skipInputEvent = false);
                            break;
                          case "keypress":
                            if (c4.skipKeyPressEvent === true)
                              return t7.preventDefault();
                            c4.skipKeyPressEvent = true;
                            break;
                          case "click":
                          case "focus":
                            return c4.validationEvent ? (c4.validationEvent = false, e6.blur(), (0, o4.HandleNativePlaceholder)(e6, (c4.isRTL ? r4.getBufferTemplate.call(c4).slice().reverse() : r4.getBufferTemplate.call(c4)).join("")), setTimeout(function() {
                              e6.focus();
                            }, f3.validationEventTimeOut), false) : (s6 = arguments, setTimeout(function() {
                              e6.inputmask && i6.apply(u4, s6);
                            }, 0), false);
                        }
                        var p4 = i6.apply(u4, arguments);
                        return p4 === false && (t7.preventDefault(), t7.stopPropagation()), p4;
                      }
                      t7.preventDefault();
                    }
                  };
                  ["submit", "reset"].includes(t6) ? (s5 = s5.bind(e6), e6.form !== null && l5(e6.form).on(t6, s5)) : l5(e6).on(t6, s5), e6.inputmask.events[t6] = e6.inputmask.events[t6] || [], e6.inputmask.events[t6].push(s5);
                },
                off: function(e6, t6) {
                  if (e6.inputmask && e6.inputmask.events) {
                    var i6 = e6.inputmask.dependencyLib, a6 = e6.inputmask.events;
                    for (var n5 in t6 && ((a6 = [])[t6] = e6.inputmask.events[t6]), a6) {
                      for (var r5 = a6[n5]; r5.length > 0; ) {
                        var o5 = r5.pop();
                        ["submit", "reset"].includes(n5) ? e6.form !== null && i6(e6.form).off(n5, o5) : i6(e6).off(n5, o5);
                      }
                      delete e6.inputmask.events[n5];
                    }
                  }
                }
              };
              t5.EventRuler = s4;
            },
            219: function(e5, t5, i5) {
              var a5 = d4(i5(2394)), n4 = d4(i5(5581)), r4 = d4(i5(7184)), o4 = i5(8711), l4 = i5(4713);
              function s4(e6) {
                return s4 = typeof Symbol == "function" && typeof Symbol.iterator == "symbol" ? function(e7) {
                  return typeof e7;
                } : function(e7) {
                  return e7 && typeof Symbol == "function" && e7.constructor === Symbol && e7 !== Symbol.prototype ? "symbol" : typeof e7;
                }, s4(e6);
              }
              function u4(e6, t6) {
                return function(e7) {
                  if (Array.isArray(e7))
                    return e7;
                }(e6) || function(e7, t7) {
                  var i6 = e7 == null ? null : typeof Symbol != "undefined" && e7[Symbol.iterator] || e7["@@iterator"];
                  if (i6 == null)
                    return;
                  var a6, n5, r5 = [], o5 = true, l5 = false;
                  try {
                    for (i6 = i6.call(e7); !(o5 = (a6 = i6.next()).done) && (r5.push(a6.value), !t7 || r5.length !== t7); o5 = true)
                      ;
                  } catch (e8) {
                    l5 = true, n5 = e8;
                  } finally {
                    try {
                      o5 || i6.return == null || i6.return();
                    } finally {
                      if (l5)
                        throw n5;
                    }
                  }
                  return r5;
                }(e6, t6) || function(e7, t7) {
                  if (!e7)
                    return;
                  if (typeof e7 == "string")
                    return c4(e7, t7);
                  var i6 = Object.prototype.toString.call(e7).slice(8, -1);
                  i6 === "Object" && e7.constructor && (i6 = e7.constructor.name);
                  if (i6 === "Map" || i6 === "Set")
                    return Array.from(e7);
                  if (i6 === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(i6))
                    return c4(e7, t7);
                }(e6, t6) || function() {
                  throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
                }();
              }
              function c4(e6, t6) {
                (t6 == null || t6 > e6.length) && (t6 = e6.length);
                for (var i6 = 0, a6 = new Array(t6); i6 < t6; i6++)
                  a6[i6] = e6[i6];
                return a6;
              }
              function f3(e6, t6) {
                for (var i6 = 0; i6 < t6.length; i6++) {
                  var a6 = t6[i6];
                  a6.enumerable = a6.enumerable || false, a6.configurable = true, "value" in a6 && (a6.writable = true), Object.defineProperty(e6, a6.key, a6);
                }
              }
              function d4(e6) {
                return e6 && e6.__esModule ? e6 : {
                  default: e6
                };
              }
              var p4 = a5.default.dependencyLib, h4 = function() {
                function e6(t7, i7, a7) {
                  !function(e7, t8) {
                    if (!(e7 instanceof t8))
                      throw new TypeError("Cannot call a class as a function");
                  }(this, e6), this.mask = t7, this.format = i7, this.opts = a7, this._date = new Date(1, 0, 1), this.initDateObject(t7, this.opts);
                }
                var t6, i6, a6;
                return t6 = e6, (i6 = [{
                  key: "date",
                  get: function() {
                    return this._date === void 0 && (this._date = new Date(1, 0, 1), this.initDateObject(void 0, this.opts)), this._date;
                  }
                }, {
                  key: "initDateObject",
                  value: function(e7, t7) {
                    var i7;
                    for (P3(t7).lastIndex = 0; i7 = P3(t7).exec(this.format); ) {
                      var a7 = new RegExp("\\d+$").exec(i7[0]), n5 = a7 ? i7[0][0] + "x" : i7[0], r5 = void 0;
                      if (e7 !== void 0) {
                        if (a7) {
                          var o5 = P3(t7).lastIndex, l5 = O3(i7.index, t7);
                          P3(t7).lastIndex = o5, r5 = e7.slice(0, e7.indexOf(l5.nextMatch[0]));
                        } else
                          r5 = e7.slice(0, n5.length);
                        e7 = e7.slice(r5.length);
                      }
                      Object.prototype.hasOwnProperty.call(g3, n5) && this.setValue(this, r5, n5, g3[n5][2], g3[n5][1]);
                    }
                  }
                }, {
                  key: "setValue",
                  value: function(e7, t7, i7, a7, n5) {
                    if (t7 !== void 0 && (e7[a7] = a7 === "ampm" ? t7 : t7.replace(/[^0-9]/g, "0"), e7["raw" + a7] = t7.replace(/\s/g, "_")), n5 !== void 0) {
                      var r5 = e7[a7];
                      (a7 === "day" && parseInt(r5) === 29 || a7 === "month" && parseInt(r5) === 2) && (parseInt(e7.day) !== 29 || parseInt(e7.month) !== 2 || e7.year !== "" && e7.year !== void 0 || e7._date.setFullYear(2012, 1, 29)), a7 === "day" && (m3 = true, parseInt(r5) === 0 && (r5 = 1)), a7 === "month" && (m3 = true), a7 === "year" && (m3 = true, r5.length < 4 && (r5 = _2(r5, 4, true))), r5 === "" || isNaN(r5) || n5.call(e7._date, r5), a7 === "ampm" && n5.call(e7._date, r5);
                    }
                  }
                }, {
                  key: "reset",
                  value: function() {
                    this._date = new Date(1, 0, 1);
                  }
                }, {
                  key: "reInit",
                  value: function() {
                    this._date = void 0, this.date;
                  }
                }]) && f3(t6.prototype, i6), a6 && f3(t6, a6), Object.defineProperty(t6, "prototype", {
                  writable: false
                }), e6;
              }(), v3 = new Date().getFullYear(), m3 = false, g3 = {
                d: ["[1-9]|[12][0-9]|3[01]", Date.prototype.setDate, "day", Date.prototype.getDate],
                dd: ["0[1-9]|[12][0-9]|3[01]", Date.prototype.setDate, "day", function() {
                  return _2(Date.prototype.getDate.call(this), 2);
                }],
                ddd: [""],
                dddd: [""],
                m: ["[1-9]|1[012]", function(e6) {
                  var t6 = e6 ? parseInt(e6) : 0;
                  return t6 > 0 && t6--, Date.prototype.setMonth.call(this, t6);
                }, "month", function() {
                  return Date.prototype.getMonth.call(this) + 1;
                }],
                mm: ["0[1-9]|1[012]", function(e6) {
                  var t6 = e6 ? parseInt(e6) : 0;
                  return t6 > 0 && t6--, Date.prototype.setMonth.call(this, t6);
                }, "month", function() {
                  return _2(Date.prototype.getMonth.call(this) + 1, 2);
                }],
                mmm: [""],
                mmmm: [""],
                yy: ["[0-9]{2}", Date.prototype.setFullYear, "year", function() {
                  return _2(Date.prototype.getFullYear.call(this), 2);
                }],
                yyyy: ["[0-9]{4}", Date.prototype.setFullYear, "year", function() {
                  return _2(Date.prototype.getFullYear.call(this), 4);
                }],
                h: ["[1-9]|1[0-2]", Date.prototype.setHours, "hours", Date.prototype.getHours],
                hh: ["0[1-9]|1[0-2]", Date.prototype.setHours, "hours", function() {
                  return _2(Date.prototype.getHours.call(this), 2);
                }],
                hx: [function(e6) {
                  return "[0-9]{".concat(e6, "}");
                }, Date.prototype.setHours, "hours", function(e6) {
                  return Date.prototype.getHours;
                }],
                H: ["1?[0-9]|2[0-3]", Date.prototype.setHours, "hours", Date.prototype.getHours],
                HH: ["0[0-9]|1[0-9]|2[0-3]", Date.prototype.setHours, "hours", function() {
                  return _2(Date.prototype.getHours.call(this), 2);
                }],
                Hx: [function(e6) {
                  return "[0-9]{".concat(e6, "}");
                }, Date.prototype.setHours, "hours", function(e6) {
                  return function() {
                    return _2(Date.prototype.getHours.call(this), e6);
                  };
                }],
                M: ["[1-5]?[0-9]", Date.prototype.setMinutes, "minutes", Date.prototype.getMinutes],
                MM: ["0[0-9]|1[0-9]|2[0-9]|3[0-9]|4[0-9]|5[0-9]", Date.prototype.setMinutes, "minutes", function() {
                  return _2(Date.prototype.getMinutes.call(this), 2);
                }],
                s: ["[1-5]?[0-9]", Date.prototype.setSeconds, "seconds", Date.prototype.getSeconds],
                ss: ["0[0-9]|1[0-9]|2[0-9]|3[0-9]|4[0-9]|5[0-9]", Date.prototype.setSeconds, "seconds", function() {
                  return _2(Date.prototype.getSeconds.call(this), 2);
                }],
                l: ["[0-9]{3}", Date.prototype.setMilliseconds, "milliseconds", function() {
                  return _2(Date.prototype.getMilliseconds.call(this), 3);
                }],
                L: ["[0-9]{2}", Date.prototype.setMilliseconds, "milliseconds", function() {
                  return _2(Date.prototype.getMilliseconds.call(this), 2);
                }],
                t: ["[ap]", y3, "ampm", b3, 1],
                tt: ["[ap]m", y3, "ampm", b3, 2],
                T: ["[AP]", y3, "ampm", b3, 1],
                TT: ["[AP]M", y3, "ampm", b3, 2],
                Z: [".*", void 0, "Z", function() {
                  var e6 = this.toString().match(/\((.+)\)/)[1];
                  e6.includes(" ") && (e6 = (e6 = e6.replace("-", " ").toUpperCase()).split(" ").map(function(e7) {
                    return u4(e7, 1)[0];
                  }).join(""));
                  return e6;
                }],
                o: [""],
                S: [""]
              }, k3 = {
                isoDate: "yyyy-mm-dd",
                isoTime: "HH:MM:ss",
                isoDateTime: "yyyy-mm-dd'T'HH:MM:ss",
                isoUtcDateTime: "UTC:yyyy-mm-dd'T'HH:MM:ss'Z'"
              };
              function y3(e6) {
                var t6 = this.getHours();
                e6.toLowerCase().includes("p") ? this.setHours(t6 + 12) : e6.toLowerCase().includes("a") && t6 >= 12 && this.setHours(t6 - 12);
              }
              function b3() {
                var e6 = this.getHours();
                return (e6 = e6 || 12) >= 12 ? "PM" : "AM";
              }
              function x3(e6) {
                var t6 = new RegExp("\\d+$").exec(e6[0]);
                if (t6 && t6[0] !== void 0) {
                  var i6 = g3[e6[0][0] + "x"].slice("");
                  return i6[0] = i6[0](t6[0]), i6[3] = i6[3](t6[0]), i6;
                }
                if (g3[e6[0]])
                  return g3[e6[0]];
              }
              function P3(e6) {
                if (!e6.tokenizer) {
                  var t6 = [], i6 = [];
                  for (var a6 in g3)
                    if (/\.*x$/.test(a6)) {
                      var n5 = a6[0] + "\\d+";
                      i6.indexOf(n5) === -1 && i6.push(n5);
                    } else
                      t6.indexOf(a6[0]) === -1 && t6.push(a6[0]);
                  e6.tokenizer = "(" + (i6.length > 0 ? i6.join("|") + "|" : "") + t6.join("+|") + ")+?|.", e6.tokenizer = new RegExp(e6.tokenizer, "g");
                }
                return e6.tokenizer;
              }
              function E3(e6, t6, i6) {
                if (!m3)
                  return true;
                if (e6.rawday === void 0 || !isFinite(e6.rawday) && new Date(e6.date.getFullYear(), isFinite(e6.rawmonth) ? e6.month : e6.date.getMonth() + 1, 0).getDate() >= e6.day || e6.day == "29" && (!isFinite(e6.rawyear) || e6.rawyear === void 0 || e6.rawyear === "") || new Date(e6.date.getFullYear(), isFinite(e6.rawmonth) ? e6.month : e6.date.getMonth() + 1, 0).getDate() >= e6.day)
                  return t6;
                if (e6.day == "29") {
                  var a6 = O3(t6.pos, i6);
                  if (a6.targetMatch[0] === "yyyy" && t6.pos - a6.targetMatchIndex == 2)
                    return t6.remove = t6.pos + 1, t6;
                } else if (e6.month == "02" && e6.day == "30" && t6.c !== void 0)
                  return e6.day = "03", e6.date.setDate(3), e6.date.setMonth(1), t6.insert = [{
                    pos: t6.pos,
                    c: "0"
                  }, {
                    pos: t6.pos + 1,
                    c: t6.c
                  }], t6.caret = o4.seekNext.call(this, t6.pos + 1), t6;
                return false;
              }
              function S3(e6, t6, i6, a6) {
                var n5, o5, l5 = "";
                for (P3(i6).lastIndex = 0; n5 = P3(i6).exec(e6); ) {
                  if (t6 === void 0)
                    if (o5 = x3(n5))
                      l5 += "(" + o5[0] + ")";
                    else
                      switch (n5[0]) {
                        case "[":
                          l5 += "(";
                          break;
                        case "]":
                          l5 += ")?";
                          break;
                        default:
                          l5 += (0, r4.default)(n5[0]);
                      }
                  else if (o5 = x3(n5))
                    if (a6 !== true && o5[3])
                      l5 += o5[3].call(t6.date);
                    else
                      o5[2] ? l5 += t6["raw" + o5[2]] : l5 += n5[0];
                  else
                    l5 += n5[0];
                }
                return l5;
              }
              function _2(e6, t6, i6) {
                for (e6 = String(e6), t6 = t6 || 2; e6.length < t6; )
                  e6 = i6 ? e6 + "0" : "0" + e6;
                return e6;
              }
              function w3(e6, t6, i6) {
                return typeof e6 == "string" ? new h4(e6, t6, i6) : e6 && s4(e6) === "object" && Object.prototype.hasOwnProperty.call(e6, "date") ? e6 : void 0;
              }
              function M3(e6, t6) {
                return S3(t6.inputFormat, {
                  date: e6
                }, t6);
              }
              function O3(e6, t6) {
                var i6, a6, n5 = 0, r5 = 0;
                for (P3(t6).lastIndex = 0; a6 = P3(t6).exec(t6.inputFormat); ) {
                  var o5 = new RegExp("\\d+$").exec(a6[0]);
                  if ((n5 += r5 = o5 ? parseInt(o5[0]) : a6[0].length) >= e6 + 1) {
                    i6 = a6, a6 = P3(t6).exec(t6.inputFormat);
                    break;
                  }
                }
                return {
                  targetMatchIndex: n5 - r5,
                  nextMatch: a6,
                  targetMatch: i6
                };
              }
              a5.default.extendAliases({
                datetime: {
                  mask: function(e6) {
                    return e6.numericInput = false, g3.S = e6.i18n.ordinalSuffix.join("|"), e6.inputFormat = k3[e6.inputFormat] || e6.inputFormat, e6.displayFormat = k3[e6.displayFormat] || e6.displayFormat || e6.inputFormat, e6.outputFormat = k3[e6.outputFormat] || e6.outputFormat || e6.inputFormat, e6.placeholder = e6.placeholder !== "" ? e6.placeholder : e6.inputFormat.replace(/[[\]]/, ""), e6.regex = S3(e6.inputFormat, void 0, e6), e6.min = w3(e6.min, e6.inputFormat, e6), e6.max = w3(e6.max, e6.inputFormat, e6), null;
                  },
                  placeholder: "",
                  inputFormat: "isoDateTime",
                  displayFormat: null,
                  outputFormat: null,
                  min: null,
                  max: null,
                  skipOptionalPartCharacter: "",
                  i18n: {
                    dayNames: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
                    monthNames: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                    ordinalSuffix: ["st", "nd", "rd", "th"]
                  },
                  preValidation: function(e6, t6, i6, a6, n5, r5, o5, l5) {
                    if (l5)
                      return true;
                    if (isNaN(i6) && e6[t6] !== i6) {
                      var s5 = O3(t6, n5);
                      if (s5.nextMatch && s5.nextMatch[0] === i6 && s5.targetMatch[0].length > 1) {
                        var u5 = g3[s5.targetMatch[0]][0];
                        if (new RegExp(u5).test("0" + e6[t6 - 1]))
                          return e6[t6] = e6[t6 - 1], e6[t6 - 1] = "0", {
                            fuzzy: true,
                            buffer: e6,
                            refreshFromBuffer: {
                              start: t6 - 1,
                              end: t6 + 1
                            },
                            pos: t6 + 1
                          };
                      }
                    }
                    return true;
                  },
                  postValidation: function(e6, t6, i6, a6, n5, r5, o5, s5) {
                    var u5, c5;
                    if (o5)
                      return true;
                    if (a6 === false && (((u5 = O3(t6 + 1, n5)).targetMatch && u5.targetMatchIndex === t6 && u5.targetMatch[0].length > 1 && g3[u5.targetMatch[0]] !== void 0 || (u5 = O3(t6 + 2, n5)).targetMatch && u5.targetMatchIndex === t6 + 1 && u5.targetMatch[0].length > 1 && g3[u5.targetMatch[0]] !== void 0) && (c5 = g3[u5.targetMatch[0]][0]), c5 !== void 0 && (r5.validPositions[t6 + 1] !== void 0 && new RegExp(c5).test(i6 + "0") ? (e6[t6] = i6, e6[t6 + 1] = "0", a6 = {
                      pos: t6 + 2,
                      caret: t6
                    }) : new RegExp(c5).test("0" + i6) && (e6[t6] = "0", e6[t6 + 1] = i6, a6 = {
                      pos: t6 + 2
                    })), a6 === false))
                      return a6;
                    if (a6.fuzzy && (e6 = a6.buffer, t6 = a6.pos), (u5 = O3(t6, n5)).targetMatch && u5.targetMatch[0] && g3[u5.targetMatch[0]] !== void 0) {
                      var f4 = g3[u5.targetMatch[0]];
                      c5 = f4[0];
                      var d5 = e6.slice(u5.targetMatchIndex, u5.targetMatchIndex + u5.targetMatch[0].length);
                      if (new RegExp(c5).test(d5.join("")) === false && u5.targetMatch[0].length === 2 && r5.validPositions[u5.targetMatchIndex] && r5.validPositions[u5.targetMatchIndex + 1] && (r5.validPositions[u5.targetMatchIndex + 1].input = "0"), f4[2] == "year")
                        for (var p5 = l4.getMaskTemplate.call(this, false, 1, void 0, true), h5 = t6 + 1; h5 < e6.length; h5++)
                          e6[h5] = p5[h5], delete r5.validPositions[h5];
                    }
                    var m4 = a6, k4 = w3(e6.join(""), n5.inputFormat, n5);
                    return m4 && k4.date.getTime() == k4.date.getTime() && (n5.prefillYear && (m4 = function(e7, t7, i7) {
                      if (e7.year !== e7.rawyear) {
                        var a7 = v3.toString(), n6 = e7.rawyear.replace(/[^0-9]/g, ""), r6 = a7.slice(0, n6.length), o6 = a7.slice(n6.length);
                        if (n6.length === 2 && n6 === r6) {
                          var l5 = new Date(v3, e7.month - 1, e7.day);
                          e7.day == l5.getDate() && (!i7.max || i7.max.date.getTime() >= l5.getTime()) && (e7.date.setFullYear(v3), e7.year = a7, t7.insert = [{
                            pos: t7.pos + 1,
                            c: o6[0]
                          }, {
                            pos: t7.pos + 2,
                            c: o6[1]
                          }]);
                        }
                      }
                      return t7;
                    }(k4, m4, n5)), m4 = function(e7, t7, i7, a7, n6) {
                      if (!t7)
                        return t7;
                      if (t7 && i7.min && i7.min.date.getTime() == i7.min.date.getTime()) {
                        var r6;
                        for (e7.reset(), P3(i7).lastIndex = 0; r6 = P3(i7).exec(i7.inputFormat); ) {
                          var o6;
                          if ((o6 = x3(r6)) && o6[3]) {
                            for (var l5 = o6[1], s6 = e7[o6[2]], u6 = i7.min[o6[2]], c6 = i7.max ? i7.max[o6[2]] : u6, f5 = [], d6 = false, p6 = 0; p6 < u6.length; p6++)
                              a7.validPositions[p6 + r6.index] !== void 0 || d6 ? (f5[p6] = s6[p6], d6 = d6 || s6[p6] > u6[p6]) : (f5[p6] = u6[p6], o6[2] === "year" && s6.length - 1 == p6 && u6 != c6 && (f5 = (parseInt(f5.join("")) + 1).toString().split("")), o6[2] === "ampm" && u6 != c6 && i7.min.date.getTime() > e7.date.getTime() && (f5[p6] = c6[p6]));
                            l5.call(e7._date, f5.join(""));
                          }
                        }
                        t7 = i7.min.date.getTime() <= e7.date.getTime(), e7.reInit();
                      }
                      return t7 && i7.max && i7.max.date.getTime() == i7.max.date.getTime() && (t7 = i7.max.date.getTime() >= e7.date.getTime()), t7;
                    }(k4, m4 = E3.call(this, k4, m4, n5), n5, r5)), t6 !== void 0 && m4 && a6.pos !== t6 ? {
                      buffer: S3(n5.inputFormat, k4, n5).split(""),
                      refreshFromBuffer: {
                        start: t6,
                        end: a6.pos
                      },
                      pos: a6.caret || a6.pos
                    } : m4;
                  },
                  onKeyDown: function(e6, t6, i6, a6) {
                    e6.ctrlKey && e6.keyCode === n4.default.RIGHT && (this.inputmask._valueSet(M3(new Date(), a6)), p4(this).trigger("setvalue"));
                  },
                  onUnMask: function(e6, t6, i6) {
                    return t6 ? S3(i6.outputFormat, w3(e6, i6.inputFormat, i6), i6, true) : t6;
                  },
                  casing: function(e6, t6, i6, a6) {
                    return t6.nativeDef.indexOf("[ap]") == 0 ? e6.toLowerCase() : t6.nativeDef.indexOf("[AP]") == 0 ? e6.toUpperCase() : e6;
                  },
                  onBeforeMask: function(e6, t6) {
                    return Object.prototype.toString.call(e6) === "[object Date]" && (e6 = M3(e6, t6)), e6;
                  },
                  insertMode: false,
                  shiftPositions: false,
                  keepStatic: false,
                  inputmode: "numeric",
                  prefillYear: true
                }
              });
            },
            3851: function(e5, t5, i5) {
              var a5, n4 = (a5 = i5(2394)) && a5.__esModule ? a5 : {
                default: a5
              }, r4 = i5(8711), o4 = i5(4713);
              n4.default.extendDefinitions({
                A: {
                  validator: "[A-Za-z\u0410-\u044F\u0401\u0451\xC0-\xFF\xB5]",
                  casing: "upper"
                },
                "&": {
                  validator: "[0-9A-Za-z\u0410-\u044F\u0401\u0451\xC0-\xFF\xB5]",
                  casing: "upper"
                },
                "#": {
                  validator: "[0-9A-Fa-f]",
                  casing: "upper"
                }
              });
              var l4 = new RegExp("25[0-5]|2[0-4][0-9]|[01][0-9][0-9]");
              function s4(e6, t6, i6, a6, n5) {
                return i6 - 1 > -1 && t6.buffer[i6 - 1] !== "." ? (e6 = t6.buffer[i6 - 1] + e6, e6 = i6 - 2 > -1 && t6.buffer[i6 - 2] !== "." ? t6.buffer[i6 - 2] + e6 : "0" + e6) : e6 = "00" + e6, l4.test(e6);
              }
              n4.default.extendAliases({
                cssunit: {
                  regex: "[+-]?[0-9]+\\.?([0-9]+)?(px|em|rem|ex|%|in|cm|mm|pt|pc)"
                },
                url: {
                  regex: "(https?|ftp)://.*",
                  autoUnmask: false,
                  keepStatic: false,
                  tabThrough: true
                },
                ip: {
                  mask: "i{1,3}.j{1,3}.k{1,3}.l{1,3}",
                  definitions: {
                    i: {
                      validator: s4
                    },
                    j: {
                      validator: s4
                    },
                    k: {
                      validator: s4
                    },
                    l: {
                      validator: s4
                    }
                  },
                  onUnMask: function(e6, t6, i6) {
                    return e6;
                  },
                  inputmode: "decimal",
                  substitutes: {
                    ",": "."
                  }
                },
                email: {
                  mask: function(e6) {
                    var t6 = "*{1,64}[.*{1,64}][.*{1,64}][.*{1,63}]@-{1,63}.-{1,63}[.-{1,63}][.-{1,63}]", i6 = t6;
                    if (e6.separator)
                      for (var a6 = 0; a6 < e6.quantifier; a6++)
                        i6 += "[".concat(e6.separator).concat(t6, "]");
                    return i6;
                  },
                  greedy: false,
                  casing: "lower",
                  separator: null,
                  quantifier: 5,
                  skipOptionalPartCharacter: "",
                  onBeforePaste: function(e6, t6) {
                    return (e6 = e6.toLowerCase()).replace("mailto:", "");
                  },
                  definitions: {
                    "*": {
                      validator: "[0-9\uFF11-\uFF19A-Za-z\u0410-\u044F\u0401\u0451\xC0-\xFF\xB5!#$%&'*+/=?^_`{|}~-]"
                    },
                    "-": {
                      validator: "[0-9A-Za-z-]"
                    }
                  },
                  onUnMask: function(e6, t6, i6) {
                    return e6;
                  },
                  inputmode: "email"
                },
                mac: {
                  mask: "##:##:##:##:##:##"
                },
                vin: {
                  mask: "V{13}9{4}",
                  definitions: {
                    V: {
                      validator: "[A-HJ-NPR-Za-hj-npr-z\\d]",
                      casing: "upper"
                    }
                  },
                  clearIncomplete: true,
                  autoUnmask: true
                },
                ssn: {
                  mask: "999-99-9999",
                  postValidation: function(e6, t6, i6, a6, n5, l5, s5) {
                    var u4 = o4.getMaskTemplate.call(this, true, r4.getLastValidPosition.call(this), true, true);
                    return /^(?!219-09-9999|078-05-1120)(?!666|000|9.{2}).{3}-(?!00).{2}-(?!0{4}).{4}$/.test(u4.join(""));
                  }
                }
              });
            },
            207: function(e5, t5, i5) {
              var a5 = l4(i5(2394)), n4 = l4(i5(5581)), r4 = l4(i5(7184)), o4 = i5(8711);
              function l4(e6) {
                return e6 && e6.__esModule ? e6 : {
                  default: e6
                };
              }
              var s4 = a5.default.dependencyLib;
              function u4(e6, t6) {
                for (var i6 = "", n5 = 0; n5 < e6.length; n5++)
                  a5.default.prototype.definitions[e6.charAt(n5)] || t6.definitions[e6.charAt(n5)] || t6.optionalmarker[0] === e6.charAt(n5) || t6.optionalmarker[1] === e6.charAt(n5) || t6.quantifiermarker[0] === e6.charAt(n5) || t6.quantifiermarker[1] === e6.charAt(n5) || t6.groupmarker[0] === e6.charAt(n5) || t6.groupmarker[1] === e6.charAt(n5) || t6.alternatormarker === e6.charAt(n5) ? i6 += "\\" + e6.charAt(n5) : i6 += e6.charAt(n5);
                return i6;
              }
              function c4(e6, t6, i6, a6) {
                if (e6.length > 0 && t6 > 0 && (!i6.digitsOptional || a6)) {
                  var n5 = e6.indexOf(i6.radixPoint), r5 = false;
                  i6.negationSymbol.back === e6[e6.length - 1] && (r5 = true, e6.length--), n5 === -1 && (e6.push(i6.radixPoint), n5 = e6.length - 1);
                  for (var o5 = 1; o5 <= t6; o5++)
                    isFinite(e6[n5 + o5]) || (e6[n5 + o5] = "0");
                }
                return r5 && e6.push(i6.negationSymbol.back), e6;
              }
              function f3(e6, t6) {
                var i6 = 0;
                if (e6 === "+") {
                  for (i6 in t6.validPositions)
                    ;
                  i6 = o4.seekNext.call(this, parseInt(i6));
                }
                for (var a6 in t6.tests)
                  if ((a6 = parseInt(a6)) >= i6) {
                    for (var n5 = 0, r5 = t6.tests[a6].length; n5 < r5; n5++)
                      if ((t6.validPositions[a6] === void 0 || e6 === "-") && t6.tests[a6][n5].match.def === e6)
                        return a6 + (t6.validPositions[a6] !== void 0 && e6 !== "-" ? 1 : 0);
                  }
                return i6;
              }
              function d4(e6, t6) {
                var i6 = -1;
                for (var a6 in t6.validPositions) {
                  var n5 = t6.validPositions[a6];
                  if (n5 && n5.match.def === e6) {
                    i6 = parseInt(a6);
                    break;
                  }
                }
                return i6;
              }
              function p4(e6, t6, i6, a6, n5) {
                var r5 = t6.buffer ? t6.buffer.indexOf(n5.radixPoint) : -1, o5 = (r5 !== -1 || a6 && n5.jitMasking) && new RegExp(n5.definitions[9].validator).test(e6);
                return n5._radixDance && r5 !== -1 && o5 && t6.validPositions[r5] == null ? {
                  insert: {
                    pos: r5 === i6 ? r5 + 1 : r5,
                    c: n5.radixPoint
                  },
                  pos: i6
                } : o5;
              }
              a5.default.extendAliases({
                numeric: {
                  mask: function(e6) {
                    e6.repeat = 0, e6.groupSeparator === e6.radixPoint && e6.digits && e6.digits !== "0" && (e6.radixPoint === "." ? e6.groupSeparator = "," : e6.radixPoint === "," ? e6.groupSeparator = "." : e6.groupSeparator = ""), e6.groupSeparator === " " && (e6.skipOptionalPartCharacter = void 0), e6.placeholder.length > 1 && (e6.placeholder = e6.placeholder.charAt(0)), e6.positionCaretOnClick === "radixFocus" && e6.placeholder === "" && (e6.positionCaretOnClick = "lvp");
                    var t6 = "0", i6 = e6.radixPoint;
                    e6.numericInput === true && e6.__financeInput === void 0 ? (t6 = "1", e6.positionCaretOnClick = e6.positionCaretOnClick === "radixFocus" ? "lvp" : e6.positionCaretOnClick, e6.digitsOptional = false, isNaN(e6.digits) && (e6.digits = 2), e6._radixDance = false, i6 = e6.radixPoint === "," ? "?" : "!", e6.radixPoint !== "" && e6.definitions[i6] === void 0 && (e6.definitions[i6] = {}, e6.definitions[i6].validator = "[" + e6.radixPoint + "]", e6.definitions[i6].placeholder = e6.radixPoint, e6.definitions[i6].static = true, e6.definitions[i6].generated = true)) : (e6.__financeInput = false, e6.numericInput = true);
                    var a6, n5 = "[+]";
                    if (n5 += u4(e6.prefix, e6), e6.groupSeparator !== "" ? (e6.definitions[e6.groupSeparator] === void 0 && (e6.definitions[e6.groupSeparator] = {}, e6.definitions[e6.groupSeparator].validator = "[" + e6.groupSeparator + "]", e6.definitions[e6.groupSeparator].placeholder = e6.groupSeparator, e6.definitions[e6.groupSeparator].static = true, e6.definitions[e6.groupSeparator].generated = true), n5 += e6._mask(e6)) : n5 += "9{+}", e6.digits !== void 0 && e6.digits !== 0) {
                      var o5 = e6.digits.toString().split(",");
                      isFinite(o5[0]) && o5[1] && isFinite(o5[1]) ? n5 += i6 + t6 + "{" + e6.digits + "}" : (isNaN(e6.digits) || parseInt(e6.digits) > 0) && (e6.digitsOptional || e6.jitMasking ? (a6 = n5 + i6 + t6 + "{0," + e6.digits + "}", e6.keepStatic = true) : n5 += i6 + t6 + "{" + e6.digits + "}");
                    } else
                      e6.inputmode = "numeric";
                    return n5 += u4(e6.suffix, e6), n5 += "[-]", a6 && (n5 = [a6 + u4(e6.suffix, e6) + "[-]", n5]), e6.greedy = false, function(e7) {
                      e7.parseMinMaxOptions === void 0 && (e7.min !== null && (e7.min = e7.min.toString().replace(new RegExp((0, r4.default)(e7.groupSeparator), "g"), ""), e7.radixPoint === "," && (e7.min = e7.min.replace(e7.radixPoint, ".")), e7.min = isFinite(e7.min) ? parseFloat(e7.min) : NaN, isNaN(e7.min) && (e7.min = Number.MIN_VALUE)), e7.max !== null && (e7.max = e7.max.toString().replace(new RegExp((0, r4.default)(e7.groupSeparator), "g"), ""), e7.radixPoint === "," && (e7.max = e7.max.replace(e7.radixPoint, ".")), e7.max = isFinite(e7.max) ? parseFloat(e7.max) : NaN, isNaN(e7.max) && (e7.max = Number.MAX_VALUE)), e7.parseMinMaxOptions = "done");
                    }(e6), e6.radixPoint !== "" && (e6.substitutes[e6.radixPoint == "." ? "," : "."] = e6.radixPoint), n5;
                  },
                  _mask: function(e6) {
                    return "(" + e6.groupSeparator + "999){+|1}";
                  },
                  digits: "*",
                  digitsOptional: true,
                  enforceDigitsOnBlur: false,
                  radixPoint: ".",
                  positionCaretOnClick: "radixFocus",
                  _radixDance: true,
                  groupSeparator: "",
                  allowMinus: true,
                  negationSymbol: {
                    front: "-",
                    back: ""
                  },
                  prefix: "",
                  suffix: "",
                  min: null,
                  max: null,
                  SetMaxOnOverflow: false,
                  step: 1,
                  inputType: "text",
                  unmaskAsNumber: false,
                  roundingFN: Math.round,
                  inputmode: "decimal",
                  shortcuts: {
                    k: "1000",
                    m: "1000000"
                  },
                  placeholder: "0",
                  greedy: false,
                  rightAlign: true,
                  insertMode: true,
                  autoUnmask: false,
                  skipOptionalPartCharacter: "",
                  usePrototypeDefinitions: false,
                  stripLeadingZeroes: true,
                  definitions: {
                    0: {
                      validator: p4
                    },
                    1: {
                      validator: p4,
                      definitionSymbol: "9"
                    },
                    9: {
                      validator: "[0-9\uFF10-\uFF19\u0660-\u0669\u06F0-\u06F9]",
                      definitionSymbol: "*"
                    },
                    "+": {
                      validator: function(e6, t6, i6, a6, n5) {
                        return n5.allowMinus && (e6 === "-" || e6 === n5.negationSymbol.front);
                      }
                    },
                    "-": {
                      validator: function(e6, t6, i6, a6, n5) {
                        return n5.allowMinus && e6 === n5.negationSymbol.back;
                      }
                    }
                  },
                  preValidation: function(e6, t6, i6, a6, n5, r5, o5, l5) {
                    if (n5.__financeInput !== false && i6 === n5.radixPoint)
                      return false;
                    var s5 = e6.indexOf(n5.radixPoint), u5 = t6;
                    if (t6 = function(e7, t7, i7, a7, n6) {
                      return n6._radixDance && n6.numericInput && t7 !== n6.negationSymbol.back && e7 <= i7 && (i7 > 0 || t7 == n6.radixPoint) && (a7.validPositions[e7 - 1] === void 0 || a7.validPositions[e7 - 1].input !== n6.negationSymbol.back) && (e7 -= 1), e7;
                    }(t6, i6, s5, r5, n5), i6 === "-" || i6 === n5.negationSymbol.front) {
                      if (n5.allowMinus !== true)
                        return false;
                      var c5 = false, p5 = d4("+", r5), h4 = d4("-", r5);
                      return p5 !== -1 && (c5 = [p5, h4]), c5 !== false ? {
                        remove: c5,
                        caret: u5 - n5.negationSymbol.back.length
                      } : {
                        insert: [{
                          pos: f3.call(this, "+", r5),
                          c: n5.negationSymbol.front,
                          fromIsValid: true
                        }, {
                          pos: f3.call(this, "-", r5),
                          c: n5.negationSymbol.back,
                          fromIsValid: void 0
                        }],
                        caret: u5 + n5.negationSymbol.back.length
                      };
                    }
                    if (i6 === n5.groupSeparator)
                      return {
                        caret: u5
                      };
                    if (l5)
                      return true;
                    if (s5 !== -1 && n5._radixDance === true && a6 === false && i6 === n5.radixPoint && n5.digits !== void 0 && (isNaN(n5.digits) || parseInt(n5.digits) > 0) && s5 !== t6)
                      return {
                        caret: n5._radixDance && t6 === s5 - 1 ? s5 + 1 : s5
                      };
                    if (n5.__financeInput === false) {
                      if (a6) {
                        if (n5.digitsOptional)
                          return {
                            rewritePosition: o5.end
                          };
                        if (!n5.digitsOptional) {
                          if (o5.begin > s5 && o5.end <= s5)
                            return i6 === n5.radixPoint ? {
                              insert: {
                                pos: s5 + 1,
                                c: "0",
                                fromIsValid: true
                              },
                              rewritePosition: s5
                            } : {
                              rewritePosition: s5 + 1
                            };
                          if (o5.begin < s5)
                            return {
                              rewritePosition: o5.begin - 1
                            };
                        }
                      } else if (!n5.showMaskOnHover && !n5.showMaskOnFocus && !n5.digitsOptional && n5.digits > 0 && this.__valueGet.call(this.el) === "")
                        return {
                          rewritePosition: s5
                        };
                    }
                    return {
                      rewritePosition: t6
                    };
                  },
                  postValidation: function(e6, t6, i6, a6, n5, r5, o5) {
                    if (a6 === false)
                      return a6;
                    if (o5)
                      return true;
                    if (n5.min !== null || n5.max !== null) {
                      var l5 = n5.onUnMask(e6.slice().reverse().join(""), void 0, s4.extend({}, n5, {
                        unmaskAsNumber: true
                      }));
                      if (n5.min !== null && l5 < n5.min && (l5.toString().length > n5.min.toString().length || l5 < 0))
                        return false;
                      if (n5.max !== null && l5 > n5.max)
                        return !!n5.SetMaxOnOverflow && {
                          refreshFromBuffer: true,
                          buffer: c4(n5.max.toString().replace(".", n5.radixPoint).split(""), n5.digits, n5).reverse()
                        };
                    }
                    return a6;
                  },
                  onUnMask: function(e6, t6, i6) {
                    if (t6 === "" && i6.nullable === true)
                      return t6;
                    var a6 = e6.replace(i6.prefix, "");
                    return a6 = (a6 = a6.replace(i6.suffix, "")).replace(new RegExp((0, r4.default)(i6.groupSeparator), "g"), ""), i6.placeholder.charAt(0) !== "" && (a6 = a6.replace(new RegExp(i6.placeholder.charAt(0), "g"), "0")), i6.unmaskAsNumber ? (i6.radixPoint !== "" && a6.indexOf(i6.radixPoint) !== -1 && (a6 = a6.replace(r4.default.call(this, i6.radixPoint), ".")), a6 = (a6 = a6.replace(new RegExp("^" + (0, r4.default)(i6.negationSymbol.front)), "-")).replace(new RegExp((0, r4.default)(i6.negationSymbol.back) + "$"), ""), Number(a6)) : a6;
                  },
                  isComplete: function(e6, t6) {
                    var i6 = (t6.numericInput ? e6.slice().reverse() : e6).join("");
                    return i6 = (i6 = (i6 = (i6 = (i6 = i6.replace(new RegExp("^" + (0, r4.default)(t6.negationSymbol.front)), "-")).replace(new RegExp((0, r4.default)(t6.negationSymbol.back) + "$"), "")).replace(t6.prefix, "")).replace(t6.suffix, "")).replace(new RegExp((0, r4.default)(t6.groupSeparator) + "([0-9]{3})", "g"), "$1"), t6.radixPoint === "," && (i6 = i6.replace((0, r4.default)(t6.radixPoint), ".")), isFinite(i6);
                  },
                  onBeforeMask: function(e6, t6) {
                    var i6 = t6.radixPoint || ",";
                    isFinite(t6.digits) && (t6.digits = parseInt(t6.digits)), typeof e6 != "number" && t6.inputType !== "number" || i6 === "" || (e6 = e6.toString().replace(".", i6));
                    var a6 = e6.charAt(0) === "-" || e6.charAt(0) === t6.negationSymbol.front, n5 = e6.split(i6), o5 = n5[0].replace(/[^\-0-9]/g, ""), l5 = n5.length > 1 ? n5[1].replace(/[^0-9]/g, "") : "", s5 = n5.length > 1;
                    e6 = o5 + (l5 !== "" ? i6 + l5 : l5);
                    var u5 = 0;
                    if (i6 !== "" && (u5 = t6.digitsOptional ? t6.digits < l5.length ? t6.digits : l5.length : t6.digits, l5 !== "" || !t6.digitsOptional)) {
                      var f4 = Math.pow(10, u5 || 1);
                      e6 = e6.replace((0, r4.default)(i6), "."), isNaN(parseFloat(e6)) || (e6 = (t6.roundingFN(parseFloat(e6) * f4) / f4).toFixed(u5)), e6 = e6.toString().replace(".", i6);
                    }
                    if (t6.digits === 0 && e6.indexOf(i6) !== -1 && (e6 = e6.substring(0, e6.indexOf(i6))), t6.min !== null || t6.max !== null) {
                      var d5 = e6.toString().replace(i6, ".");
                      t6.min !== null && d5 < t6.min ? e6 = t6.min.toString().replace(".", i6) : t6.max !== null && d5 > t6.max && (e6 = t6.max.toString().replace(".", i6));
                    }
                    return a6 && e6.charAt(0) !== "-" && (e6 = "-" + e6), c4(e6.toString().split(""), u5, t6, s5).join("");
                  },
                  onBeforeWrite: function(e6, t6, i6, a6) {
                    function n5(e7, t7) {
                      if (a6.__financeInput !== false || t7) {
                        var i7 = e7.indexOf(a6.radixPoint);
                        i7 !== -1 && e7.splice(i7, 1);
                      }
                      if (a6.groupSeparator !== "")
                        for (; (i7 = e7.indexOf(a6.groupSeparator)) !== -1; )
                          e7.splice(i7, 1);
                      return e7;
                    }
                    var o5, l5;
                    if (a6.stripLeadingZeroes && (l5 = function(e7, t7) {
                      var i7 = new RegExp("(^" + (t7.negationSymbol.front !== "" ? (0, r4.default)(t7.negationSymbol.front) + "?" : "") + (0, r4.default)(t7.prefix) + ")(.*)(" + (0, r4.default)(t7.suffix) + (t7.negationSymbol.back != "" ? (0, r4.default)(t7.negationSymbol.back) + "?" : "") + "$)").exec(e7.slice().reverse().join("")), a7 = i7 ? i7[2] : "", n6 = false;
                      return a7 && (a7 = a7.split(t7.radixPoint.charAt(0))[0], n6 = new RegExp("^[0" + t7.groupSeparator + "]*").exec(a7)), !(!n6 || !(n6[0].length > 1 || n6[0].length > 0 && n6[0].length < a7.length)) && n6;
                    }(t6, a6)))
                      for (var u5 = t6.join("").lastIndexOf(l5[0].split("").reverse().join("")) - (l5[0] == l5.input ? 0 : 1), f4 = l5[0] == l5.input ? 1 : 0, d5 = l5[0].length - f4; d5 > 0; d5--)
                        delete this.maskset.validPositions[u5 + d5], delete t6[u5 + d5];
                    if (e6)
                      switch (e6.type) {
                        case "blur":
                        case "checkval":
                          if (a6.min !== null) {
                            var p5 = a6.onUnMask(t6.slice().reverse().join(""), void 0, s4.extend({}, a6, {
                              unmaskAsNumber: true
                            }));
                            if (a6.min !== null && p5 < a6.min)
                              return {
                                refreshFromBuffer: true,
                                buffer: c4(a6.min.toString().replace(".", a6.radixPoint).split(""), a6.digits, a6).reverse()
                              };
                          }
                          if (t6[t6.length - 1] === a6.negationSymbol.front) {
                            var h4 = new RegExp("(^" + (a6.negationSymbol.front != "" ? (0, r4.default)(a6.negationSymbol.front) + "?" : "") + (0, r4.default)(a6.prefix) + ")(.*)(" + (0, r4.default)(a6.suffix) + (a6.negationSymbol.back != "" ? (0, r4.default)(a6.negationSymbol.back) + "?" : "") + "$)").exec(n5(t6.slice(), true).reverse().join(""));
                            (h4 ? h4[2] : "") == 0 && (o5 = {
                              refreshFromBuffer: true,
                              buffer: [0]
                            });
                          } else if (a6.radixPoint !== "") {
                            t6.indexOf(a6.radixPoint) === a6.suffix.length && (o5 && o5.buffer ? o5.buffer.splice(0, 1 + a6.suffix.length) : (t6.splice(0, 1 + a6.suffix.length), o5 = {
                              refreshFromBuffer: true,
                              buffer: n5(t6)
                            }));
                          }
                          if (a6.enforceDigitsOnBlur) {
                            var v3 = (o5 = o5 || {}) && o5.buffer || t6.slice().reverse();
                            o5.refreshFromBuffer = true, o5.buffer = c4(v3, a6.digits, a6, true).reverse();
                          }
                      }
                    return o5;
                  },
                  onKeyDown: function(e6, t6, i6, a6) {
                    var r5, o5, l5 = s4(this), u5 = String.fromCharCode(e6.keyCode).toLowerCase();
                    if ((o5 = a6.shortcuts && a6.shortcuts[u5]) && o5.length > 1)
                      return this.inputmask.__valueSet.call(this, parseFloat(this.inputmask.unmaskedvalue()) * parseInt(o5)), l5.trigger("setvalue"), false;
                    if (e6.ctrlKey)
                      switch (e6.keyCode) {
                        case n4.default.UP:
                          return this.inputmask.__valueSet.call(this, parseFloat(this.inputmask.unmaskedvalue()) + parseInt(a6.step)), l5.trigger("setvalue"), false;
                        case n4.default.DOWN:
                          return this.inputmask.__valueSet.call(this, parseFloat(this.inputmask.unmaskedvalue()) - parseInt(a6.step)), l5.trigger("setvalue"), false;
                      }
                    if (!e6.shiftKey && (e6.keyCode === n4.default.DELETE || e6.keyCode === n4.default.BACKSPACE || e6.keyCode === n4.default.BACKSPACE_SAFARI) && i6.begin !== t6.length) {
                      if (t6[e6.keyCode === n4.default.DELETE ? i6.begin - 1 : i6.end] === a6.negationSymbol.front)
                        return r5 = t6.slice().reverse(), a6.negationSymbol.front !== "" && r5.shift(), a6.negationSymbol.back !== "" && r5.pop(), l5.trigger("setvalue", [r5.join(""), i6.begin]), false;
                      if (a6._radixDance === true) {
                        var f4 = t6.indexOf(a6.radixPoint);
                        if (a6.digitsOptional) {
                          if (f4 === 0)
                            return (r5 = t6.slice().reverse()).pop(), l5.trigger("setvalue", [r5.join(""), i6.begin >= r5.length ? r5.length : i6.begin]), false;
                        } else if (f4 !== -1 && (i6.begin < f4 || i6.end < f4 || e6.keyCode === n4.default.DELETE && i6.begin === f4))
                          return i6.begin !== i6.end || e6.keyCode !== n4.default.BACKSPACE && e6.keyCode !== n4.default.BACKSPACE_SAFARI || i6.begin++, (r5 = t6.slice().reverse()).splice(r5.length - i6.begin, i6.begin - i6.end + 1), r5 = c4(r5, a6.digits, a6).join(""), l5.trigger("setvalue", [r5, i6.begin >= r5.length ? f4 + 1 : i6.begin]), false;
                      }
                    }
                  }
                },
                currency: {
                  prefix: "",
                  groupSeparator: ",",
                  alias: "numeric",
                  digits: 2,
                  digitsOptional: false
                },
                decimal: {
                  alias: "numeric"
                },
                integer: {
                  alias: "numeric",
                  inputmode: "numeric",
                  digits: 0
                },
                percentage: {
                  alias: "numeric",
                  min: 0,
                  max: 100,
                  suffix: " %",
                  digits: 0,
                  allowMinus: false
                },
                indianns: {
                  alias: "numeric",
                  _mask: function(e6) {
                    return "(" + e6.groupSeparator + "99){*|1}(" + e6.groupSeparator + "999){1|1}";
                  },
                  groupSeparator: ",",
                  radixPoint: ".",
                  placeholder: "0",
                  digits: 2,
                  digitsOptional: false
                }
              });
            },
            9380: function(e5, t5, i5) {
              var a5;
              Object.defineProperty(t5, "__esModule", {
                value: true
              }), t5.default = void 0;
              var n4 = ((a5 = i5(8741)) && a5.__esModule ? a5 : {
                default: a5
              }).default ? window : {};
              t5.default = n4;
            },
            7760: function(e5, t5, i5) {
              Object.defineProperty(t5, "__esModule", {
                value: true
              }), t5.HandleNativePlaceholder = function(e6, t6) {
                var i6 = e6 ? e6.inputmask : this;
                if (s4.ie) {
                  if (e6.inputmask._valueGet() !== t6 && (e6.placeholder !== t6 || e6.placeholder === "")) {
                    var a6 = o4.getBuffer.call(i6).slice(), n5 = e6.inputmask._valueGet();
                    if (n5 !== t6) {
                      var r5 = o4.getLastValidPosition.call(i6);
                      r5 === -1 && n5 === o4.getBufferTemplate.call(i6).join("") ? a6 = [] : r5 !== -1 && f3.call(i6, a6), p4(e6, a6);
                    }
                  }
                } else
                  e6.placeholder !== t6 && (e6.placeholder = t6, e6.placeholder === "" && e6.removeAttribute("placeholder"));
              }, t5.applyInputValue = c4, t5.checkVal = d4, t5.clearOptionalTail = f3, t5.unmaskedvalue = function(e6) {
                var t6 = e6 ? e6.inputmask : this, i6 = t6.opts, a6 = t6.maskset;
                if (e6) {
                  if (e6.inputmask === void 0)
                    return e6.value;
                  e6.inputmask && e6.inputmask.refreshValue && c4(e6, e6.inputmask._valueGet(true));
                }
                var n5 = [], r5 = a6.validPositions;
                for (var l5 in r5)
                  r5[l5] && r5[l5].match && (r5[l5].match.static != 1 || Array.isArray(a6.metadata) && r5[l5].generatedInput !== true) && n5.push(r5[l5].input);
                var s5 = n5.length === 0 ? "" : (t6.isRTL ? n5.reverse() : n5).join("");
                if (typeof i6.onUnMask == "function") {
                  var u5 = (t6.isRTL ? o4.getBuffer.call(t6).slice().reverse() : o4.getBuffer.call(t6)).join("");
                  s5 = i6.onUnMask.call(t6, u5, s5, i6);
                }
                return s5;
              }, t5.writeBuffer = p4;
              var a5, n4 = (a5 = i5(5581)) && a5.__esModule ? a5 : {
                default: a5
              }, r4 = i5(4713), o4 = i5(8711), l4 = i5(7215), s4 = i5(9845), u4 = i5(6030);
              function c4(e6, t6) {
                var i6 = e6 ? e6.inputmask : this, a6 = i6.opts;
                e6.inputmask.refreshValue = false, typeof a6.onBeforeMask == "function" && (t6 = a6.onBeforeMask.call(i6, t6, a6) || t6), d4(e6, true, false, t6 = t6.toString().split("")), i6.undoValue = i6._valueGet(true), (a6.clearMaskOnLostFocus || a6.clearIncomplete) && e6.inputmask._valueGet() === o4.getBufferTemplate.call(i6).join("") && o4.getLastValidPosition.call(i6) === -1 && e6.inputmask._valueSet("");
              }
              function f3(e6) {
                e6.length = 0;
                for (var t6, i6 = r4.getMaskTemplate.call(this, true, 0, true, void 0, true); (t6 = i6.shift()) !== void 0; )
                  e6.push(t6);
                return e6;
              }
              function d4(e6, t6, i6, a6, n5) {
                var s5 = e6 ? e6.inputmask : this, c5 = s5.maskset, f4 = s5.opts, d5 = s5.dependencyLib, h4 = a6.slice(), v3 = "", m3 = -1, g3 = void 0, k3 = f4.skipOptionalPartCharacter;
                f4.skipOptionalPartCharacter = "", o4.resetMaskSet.call(s5), c5.tests = {}, m3 = f4.radixPoint ? o4.determineNewCaretPosition.call(s5, {
                  begin: 0,
                  end: 0
                }, false, f4.__financeInput === false ? "radixFocus" : void 0).begin : 0, c5.p = m3, s5.caretPos = {
                  begin: m3
                };
                var y3 = [], b3 = s5.caretPos;
                if (h4.forEach(function(e7, t7) {
                  if (e7 !== void 0) {
                    var a7 = new d5.Event("_checkval");
                    a7.keyCode = e7.toString().charCodeAt(0), v3 += e7;
                    var n6 = o4.getLastValidPosition.call(s5, void 0, true);
                    !function(e8, t8) {
                      for (var i7 = r4.getMaskTemplate.call(s5, true, 0).slice(e8, o4.seekNext.call(s5, e8, false, false)).join("").replace(/'/g, ""), a8 = i7.indexOf(t8); a8 > 0 && i7[a8 - 1] === " "; )
                        a8--;
                      var n7 = a8 === 0 && !o4.isMask.call(s5, e8) && (r4.getTest.call(s5, e8).match.nativeDef === t8.charAt(0) || r4.getTest.call(s5, e8).match.static === true && r4.getTest.call(s5, e8).match.nativeDef === "'" + t8.charAt(0) || r4.getTest.call(s5, e8).match.nativeDef === " " && (r4.getTest.call(s5, e8 + 1).match.nativeDef === t8.charAt(0) || r4.getTest.call(s5, e8 + 1).match.static === true && r4.getTest.call(s5, e8 + 1).match.nativeDef === "'" + t8.charAt(0)));
                      if (!n7 && a8 > 0 && !o4.isMask.call(s5, e8, false, true)) {
                        var l5 = o4.seekNext.call(s5, e8);
                        s5.caretPos.begin < l5 && (s5.caretPos = {
                          begin: l5
                        });
                      }
                      return n7;
                    }(m3, v3) ? (g3 = u4.EventHandlers.keypressEvent.call(s5, a7, true, false, i6, s5.caretPos.begin)) && (m3 = s5.caretPos.begin + 1, v3 = "") : g3 = u4.EventHandlers.keypressEvent.call(s5, a7, true, false, i6, n6 + 1), g3 ? (g3.pos !== void 0 && c5.validPositions[g3.pos] && c5.validPositions[g3.pos].match.static === true && c5.validPositions[g3.pos].alternation === void 0 && (y3.push(g3.pos), s5.isRTL || (g3.forwardPosition = g3.pos + 1)), p4.call(s5, void 0, o4.getBuffer.call(s5), g3.forwardPosition, a7, false), s5.caretPos = {
                      begin: g3.forwardPosition,
                      end: g3.forwardPosition
                    }, b3 = s5.caretPos) : c5.validPositions[t7] === void 0 && h4[t7] === r4.getPlaceholder.call(s5, t7) && o4.isMask.call(s5, t7, true) ? s5.caretPos.begin++ : s5.caretPos = b3;
                  }
                }), y3.length > 0) {
                  var x3, P3, E3 = o4.seekNext.call(s5, -1, void 0, false);
                  if (!l4.isComplete.call(s5, o4.getBuffer.call(s5)) && y3.length <= E3 || l4.isComplete.call(s5, o4.getBuffer.call(s5)) && y3.length > 0 && y3.length !== E3 && y3[0] === 0)
                    for (var S3 = E3; (x3 = y3.shift()) !== void 0; ) {
                      var _2 = new d5.Event("_checkval");
                      if ((P3 = c5.validPositions[x3]).generatedInput = true, _2.keyCode = P3.input.charCodeAt(0), (g3 = u4.EventHandlers.keypressEvent.call(s5, _2, true, false, i6, S3)) && g3.pos !== void 0 && g3.pos !== x3 && c5.validPositions[g3.pos] && c5.validPositions[g3.pos].match.static === true)
                        y3.push(g3.pos);
                      else if (!g3)
                        break;
                      S3++;
                    }
                }
                t6 && p4.call(s5, e6, o4.getBuffer.call(s5), g3 ? g3.forwardPosition : s5.caretPos.begin, n5 || new d5.Event("checkval"), n5 && (n5.type === "input" && s5.undoValue !== o4.getBuffer.call(s5).join("") || n5.type === "paste")), f4.skipOptionalPartCharacter = k3;
              }
              function p4(e6, t6, i6, a6, r5) {
                var s5 = e6 ? e6.inputmask : this, u5 = s5.opts, c5 = s5.dependencyLib;
                if (a6 && typeof u5.onBeforeWrite == "function") {
                  var f4 = u5.onBeforeWrite.call(s5, a6, t6, i6, u5);
                  if (f4) {
                    if (f4.refreshFromBuffer) {
                      var d5 = f4.refreshFromBuffer;
                      l4.refreshFromBuffer.call(s5, d5 === true ? d5 : d5.start, d5.end, f4.buffer || t6), t6 = o4.getBuffer.call(s5, true);
                    }
                    i6 !== void 0 && (i6 = f4.caret !== void 0 ? f4.caret : i6);
                  }
                }
                if (e6 !== void 0 && (e6.inputmask._valueSet(t6.join("")), i6 === void 0 || a6 !== void 0 && a6.type === "blur" || o4.caret.call(s5, e6, i6, void 0, void 0, a6 !== void 0 && a6.type === "keydown" && (a6.keyCode === n4.default.DELETE || a6.keyCode === n4.default.BACKSPACE)), r5 === true)) {
                  var p5 = c5(e6), h4 = e6.inputmask._valueGet();
                  e6.inputmask.skipInputEvent = true, p5.trigger("input"), setTimeout(function() {
                    h4 === o4.getBufferTemplate.call(s5).join("") ? p5.trigger("cleared") : l4.isComplete.call(s5, t6) === true && p5.trigger("complete");
                  }, 0);
                }
              }
            },
            2394: function(e5, t5, i5) {
              Object.defineProperty(t5, "__esModule", {
                value: true
              }), t5.default = void 0, i5(7149), i5(3194);
              var a5 = i5(157), n4 = m3(i5(4963)), r4 = m3(i5(9380)), o4 = i5(2391), l4 = i5(4713), s4 = i5(8711), u4 = i5(7215), c4 = i5(7760), f3 = i5(9716), d4 = m3(i5(7392)), p4 = m3(i5(3976)), h4 = m3(i5(8741));
              function v3(e6) {
                return v3 = typeof Symbol == "function" && typeof Symbol.iterator == "symbol" ? function(e7) {
                  return typeof e7;
                } : function(e7) {
                  return e7 && typeof Symbol == "function" && e7.constructor === Symbol && e7 !== Symbol.prototype ? "symbol" : typeof e7;
                }, v3(e6);
              }
              function m3(e6) {
                return e6 && e6.__esModule ? e6 : {
                  default: e6
                };
              }
              var g3 = r4.default.document, k3 = "_inputmask_opts";
              function y3(e6, t6, i6) {
                if (h4.default) {
                  if (!(this instanceof y3))
                    return new y3(e6, t6, i6);
                  this.dependencyLib = n4.default, this.el = void 0, this.events = {}, this.maskset = void 0, i6 !== true && (Object.prototype.toString.call(e6) === "[object Object]" ? t6 = e6 : (t6 = t6 || {}, e6 && (t6.alias = e6)), this.opts = n4.default.extend(true, {}, this.defaults, t6), this.noMasksCache = t6 && t6.definitions !== void 0, this.userOptions = t6 || {}, b3(this.opts.alias, t6, this.opts)), this.refreshValue = false, this.undoValue = void 0, this.$el = void 0, this.skipKeyPressEvent = false, this.skipInputEvent = false, this.validationEvent = false, this.ignorable = false, this.maxLength, this.mouseEnter = false, this.originalPlaceholder = void 0, this.isComposing = false;
                }
              }
              function b3(e6, t6, i6) {
                var a6 = y3.prototype.aliases[e6];
                return a6 ? (a6.alias && b3(a6.alias, void 0, i6), n4.default.extend(true, i6, a6), n4.default.extend(true, i6, t6), true) : (i6.mask === null && (i6.mask = e6), false);
              }
              y3.prototype = {
                dataAttribute: "data-inputmask",
                defaults: p4.default,
                definitions: d4.default,
                aliases: {},
                masksCache: {},
                get isRTL() {
                  return this.opts.isRTL || this.opts.numericInput;
                },
                mask: function(e6) {
                  var t6 = this;
                  return typeof e6 == "string" && (e6 = g3.getElementById(e6) || g3.querySelectorAll(e6)), (e6 = e6.nodeName ? [e6] : Array.isArray(e6) ? e6 : Array.from(e6)).forEach(function(e7, i6) {
                    var l5 = n4.default.extend(true, {}, t6.opts);
                    if (function(e8, t7, i7, a6) {
                      function o5(t8, n5) {
                        var o6 = a6 === "" ? t8 : a6 + "-" + t8;
                        (n5 = n5 !== void 0 ? n5 : e8.getAttribute(o6)) !== null && (typeof n5 == "string" && (t8.indexOf("on") === 0 ? n5 = r4.default[n5] : n5 === "false" ? n5 = false : n5 === "true" && (n5 = true)), i7[t8] = n5);
                      }
                      if (t7.importDataAttributes === true) {
                        var l6, s6, u5, c5, f4 = e8.getAttribute(a6);
                        if (f4 && f4 !== "" && (f4 = f4.replace(/'/g, '"'), s6 = JSON.parse("{" + f4 + "}")), s6) {
                          for (c5 in u5 = void 0, s6)
                            if (c5.toLowerCase() === "alias") {
                              u5 = s6[c5];
                              break;
                            }
                        }
                        for (l6 in o5("alias", u5), i7.alias && b3(i7.alias, i7, t7), t7) {
                          if (s6) {
                            for (c5 in u5 = void 0, s6)
                              if (c5.toLowerCase() === l6.toLowerCase()) {
                                u5 = s6[c5];
                                break;
                              }
                          }
                          o5(l6, u5);
                        }
                      }
                      n4.default.extend(true, t7, i7), (e8.dir === "rtl" || t7.rightAlign) && (e8.style.textAlign = "right");
                      (e8.dir === "rtl" || t7.numericInput) && (e8.dir = "ltr", e8.removeAttribute("dir"), t7.isRTL = true);
                      return Object.keys(i7).length;
                    }(e7, l5, n4.default.extend(true, {}, t6.userOptions), t6.dataAttribute)) {
                      var s5 = (0, o4.generateMaskSet)(l5, t6.noMasksCache);
                      s5 !== void 0 && (e7.inputmask !== void 0 && (e7.inputmask.opts.autoUnmask = true, e7.inputmask.remove()), e7.inputmask = new y3(void 0, void 0, true), e7.inputmask.opts = l5, e7.inputmask.noMasksCache = t6.noMasksCache, e7.inputmask.userOptions = n4.default.extend(true, {}, t6.userOptions), e7.inputmask.el = e7, e7.inputmask.$el = (0, n4.default)(e7), e7.inputmask.maskset = s5, n4.default.data(e7, k3, t6.userOptions), a5.mask.call(e7.inputmask));
                    }
                  }), e6 && e6[0] && e6[0].inputmask || this;
                },
                option: function(e6, t6) {
                  return typeof e6 == "string" ? this.opts[e6] : v3(e6) === "object" ? (n4.default.extend(this.userOptions, e6), this.el && t6 !== true && this.mask(this.el), this) : void 0;
                },
                unmaskedvalue: function(e6) {
                  if (this.maskset = this.maskset || (0, o4.generateMaskSet)(this.opts, this.noMasksCache), this.el === void 0 || e6 !== void 0) {
                    var t6 = (typeof this.opts.onBeforeMask == "function" && this.opts.onBeforeMask.call(this, e6, this.opts) || e6).split("");
                    c4.checkVal.call(this, void 0, false, false, t6), typeof this.opts.onBeforeWrite == "function" && this.opts.onBeforeWrite.call(this, void 0, s4.getBuffer.call(this), 0, this.opts);
                  }
                  return c4.unmaskedvalue.call(this, this.el);
                },
                remove: function() {
                  if (this.el) {
                    n4.default.data(this.el, k3, null);
                    var e6 = this.opts.autoUnmask ? (0, c4.unmaskedvalue)(this.el) : this._valueGet(this.opts.autoUnmask);
                    e6 !== s4.getBufferTemplate.call(this).join("") ? this._valueSet(e6, this.opts.autoUnmask) : this._valueSet(""), f3.EventRuler.off(this.el), Object.getOwnPropertyDescriptor && Object.getPrototypeOf ? Object.getOwnPropertyDescriptor(Object.getPrototypeOf(this.el), "value") && this.__valueGet && Object.defineProperty(this.el, "value", {
                      get: this.__valueGet,
                      set: this.__valueSet,
                      configurable: true
                    }) : g3.__lookupGetter__ && this.el.__lookupGetter__("value") && this.__valueGet && (this.el.__defineGetter__("value", this.__valueGet), this.el.__defineSetter__("value", this.__valueSet)), this.el.inputmask = void 0;
                  }
                  return this.el;
                },
                getemptymask: function() {
                  return this.maskset = this.maskset || (0, o4.generateMaskSet)(this.opts, this.noMasksCache), s4.getBufferTemplate.call(this).join("");
                },
                hasMaskedValue: function() {
                  return !this.opts.autoUnmask;
                },
                isComplete: function() {
                  return this.maskset = this.maskset || (0, o4.generateMaskSet)(this.opts, this.noMasksCache), u4.isComplete.call(this, s4.getBuffer.call(this));
                },
                getmetadata: function() {
                  if (this.maskset = this.maskset || (0, o4.generateMaskSet)(this.opts, this.noMasksCache), Array.isArray(this.maskset.metadata)) {
                    var e6 = l4.getMaskTemplate.call(this, true, 0, false).join("");
                    return this.maskset.metadata.forEach(function(t6) {
                      return t6.mask !== e6 || (e6 = t6, false);
                    }), e6;
                  }
                  return this.maskset.metadata;
                },
                isValid: function(e6) {
                  if (this.maskset = this.maskset || (0, o4.generateMaskSet)(this.opts, this.noMasksCache), e6) {
                    var t6 = (typeof this.opts.onBeforeMask == "function" && this.opts.onBeforeMask.call(this, e6, this.opts) || e6).split("");
                    c4.checkVal.call(this, void 0, true, false, t6);
                  } else
                    e6 = this.isRTL ? s4.getBuffer.call(this).slice().reverse().join("") : s4.getBuffer.call(this).join("");
                  for (var i6 = s4.getBuffer.call(this), a6 = s4.determineLastRequiredPosition.call(this), n5 = i6.length - 1; n5 > a6 && !s4.isMask.call(this, n5); n5--)
                    ;
                  return i6.splice(a6, n5 + 1 - a6), u4.isComplete.call(this, i6) && e6 === (this.isRTL ? s4.getBuffer.call(this).slice().reverse().join("") : s4.getBuffer.call(this).join(""));
                },
                format: function(e6, t6) {
                  this.maskset = this.maskset || (0, o4.generateMaskSet)(this.opts, this.noMasksCache);
                  var i6 = (typeof this.opts.onBeforeMask == "function" && this.opts.onBeforeMask.call(this, e6, this.opts) || e6).split("");
                  c4.checkVal.call(this, void 0, true, false, i6);
                  var a6 = this.isRTL ? s4.getBuffer.call(this).slice().reverse().join("") : s4.getBuffer.call(this).join("");
                  return t6 ? {
                    value: a6,
                    metadata: this.getmetadata()
                  } : a6;
                },
                setValue: function(e6) {
                  this.el && (0, n4.default)(this.el).trigger("setvalue", [e6]);
                },
                analyseMask: o4.analyseMask
              }, y3.extendDefaults = function(e6) {
                n4.default.extend(true, y3.prototype.defaults, e6);
              }, y3.extendDefinitions = function(e6) {
                n4.default.extend(true, y3.prototype.definitions, e6);
              }, y3.extendAliases = function(e6) {
                n4.default.extend(true, y3.prototype.aliases, e6);
              }, y3.format = function(e6, t6, i6) {
                return y3(t6).format(e6, i6);
              }, y3.unmask = function(e6, t6) {
                return y3(t6).unmaskedvalue(e6);
              }, y3.isValid = function(e6, t6) {
                return y3(t6).isValid(e6);
              }, y3.remove = function(e6) {
                typeof e6 == "string" && (e6 = g3.getElementById(e6) || g3.querySelectorAll(e6)), (e6 = e6.nodeName ? [e6] : e6).forEach(function(e7) {
                  e7.inputmask && e7.inputmask.remove();
                });
              }, y3.setValue = function(e6, t6) {
                typeof e6 == "string" && (e6 = g3.getElementById(e6) || g3.querySelectorAll(e6)), (e6 = e6.nodeName ? [e6] : e6).forEach(function(e7) {
                  e7.inputmask ? e7.inputmask.setValue(t6) : (0, n4.default)(e7).trigger("setvalue", [t6]);
                });
              }, y3.dependencyLib = n4.default, r4.default.Inputmask = y3;
              var x3 = y3;
              t5.default = x3;
            },
            5296: function(e5, t5, i5) {
              function a5(e6) {
                return a5 = typeof Symbol == "function" && typeof Symbol.iterator == "symbol" ? function(e7) {
                  return typeof e7;
                } : function(e7) {
                  return e7 && typeof Symbol == "function" && e7.constructor === Symbol && e7 !== Symbol.prototype ? "symbol" : typeof e7;
                }, a5(e6);
              }
              var n4 = h4(i5(9380)), r4 = h4(i5(2394)), o4 = h4(i5(8741));
              function l4(e6, t6) {
                for (var i6 = 0; i6 < t6.length; i6++) {
                  var a6 = t6[i6];
                  a6.enumerable = a6.enumerable || false, a6.configurable = true, "value" in a6 && (a6.writable = true), Object.defineProperty(e6, a6.key, a6);
                }
              }
              function s4(e6, t6) {
                if (t6 && (a5(t6) === "object" || typeof t6 == "function"))
                  return t6;
                if (t6 !== void 0)
                  throw new TypeError("Derived constructors may only return object or undefined");
                return function(e7) {
                  if (e7 === void 0)
                    throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
                  return e7;
                }(e6);
              }
              function u4(e6) {
                var t6 = typeof Map == "function" ? new Map() : void 0;
                return u4 = function(e7) {
                  if (e7 === null || (i6 = e7, Function.toString.call(i6).indexOf("[native code]") === -1))
                    return e7;
                  var i6;
                  if (typeof e7 != "function")
                    throw new TypeError("Super expression must either be null or a function");
                  if (t6 !== void 0) {
                    if (t6.has(e7))
                      return t6.get(e7);
                    t6.set(e7, a6);
                  }
                  function a6() {
                    return c4(e7, arguments, p4(this).constructor);
                  }
                  return a6.prototype = Object.create(e7.prototype, {
                    constructor: {
                      value: a6,
                      enumerable: false,
                      writable: true,
                      configurable: true
                    }
                  }), d4(a6, e7);
                }, u4(e6);
              }
              function c4(e6, t6, i6) {
                return c4 = f3() ? Reflect.construct : function(e7, t7, i7) {
                  var a6 = [null];
                  a6.push.apply(a6, t7);
                  var n5 = new (Function.bind.apply(e7, a6))();
                  return i7 && d4(n5, i7.prototype), n5;
                }, c4.apply(null, arguments);
              }
              function f3() {
                if (typeof Reflect == "undefined" || !Reflect.construct)
                  return false;
                if (Reflect.construct.sham)
                  return false;
                if (typeof Proxy == "function")
                  return true;
                try {
                  return Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function() {
                  })), true;
                } catch (e6) {
                  return false;
                }
              }
              function d4(e6, t6) {
                return d4 = Object.setPrototypeOf || function(e7, t7) {
                  return e7.__proto__ = t7, e7;
                }, d4(e6, t6);
              }
              function p4(e6) {
                return p4 = Object.setPrototypeOf ? Object.getPrototypeOf : function(e7) {
                  return e7.__proto__ || Object.getPrototypeOf(e7);
                }, p4(e6);
              }
              function h4(e6) {
                return e6 && e6.__esModule ? e6 : {
                  default: e6
                };
              }
              var v3 = n4.default.document;
              if (o4.default && v3 && v3.head && v3.head.attachShadow && n4.default.customElements && n4.default.customElements.get("input-mask") === void 0) {
                var m3 = function(e6) {
                  !function(e7, t7) {
                    if (typeof t7 != "function" && t7 !== null)
                      throw new TypeError("Super expression must either be null or a function");
                    Object.defineProperty(e7, "prototype", {
                      value: Object.create(t7 && t7.prototype, {
                        constructor: {
                          value: e7,
                          writable: true,
                          configurable: true
                        }
                      }),
                      writable: false
                    }), t7 && d4(e7, t7);
                  }(c5, e6);
                  var t6, i6, a6, n5, o5, u5 = (t6 = c5, i6 = f3(), function() {
                    var e7, a7 = p4(t6);
                    if (i6) {
                      var n6 = p4(this).constructor;
                      e7 = Reflect.construct(a7, arguments, n6);
                    } else
                      e7 = a7.apply(this, arguments);
                    return s4(this, e7);
                  });
                  function c5() {
                    var e7;
                    !function(e8, t8) {
                      if (!(e8 instanceof t8))
                        throw new TypeError("Cannot call a class as a function");
                    }(this, c5);
                    var t7 = (e7 = u5.call(this)).getAttributeNames(), i7 = e7.attachShadow({
                      mode: "closed"
                    }), a7 = v3.createElement("input");
                    for (var n6 in a7.type = "text", i7.appendChild(a7), t7)
                      Object.prototype.hasOwnProperty.call(t7, n6) && a7.setAttribute(t7[n6], e7.getAttribute(t7[n6]));
                    var o6 = new r4.default();
                    return o6.dataAttribute = "", o6.mask(a7), a7.inputmask.shadowRoot = i7, e7;
                  }
                  return a6 = c5, n5 && l4(a6.prototype, n5), o5 && l4(a6, o5), Object.defineProperty(a6, "prototype", {
                    writable: false
                  }), a6;
                }(u4(HTMLElement));
                n4.default.customElements.define("input-mask", m3);
              }
            },
            2391: function(e5, t5, i5) {
              Object.defineProperty(t5, "__esModule", {
                value: true
              }), t5.analyseMask = function(e6, t6, i6) {
                var a6, o5, l4, s4, u4, c4, f3 = /(?:[?*+]|\{[0-9+*]+(?:,[0-9+*]*)?(?:\|[0-9+*]*)?\})|[^.?*+^${[]()|\\]+|./g, d4 = /\[\^?]?(?:[^\\\]]+|\\[\S\s]?)*]?|\\(?:0(?:[0-3][0-7]{0,2}|[4-7][0-7]?)?|[1-9][0-9]*|x[0-9A-Fa-f]{2}|u[0-9A-Fa-f]{4}|c[A-Za-z]|[\S\s]?)|\((?:\?[:=!]?)?|(?:[?*+]|\{[0-9]+(?:,[0-9]*)?\})\??|[^.?*+^${[()|\\]+|./g, p4 = false, h4 = new n4.default(), v3 = [], m3 = [], g3 = false;
                function k3(e7, a7, n5) {
                  n5 = n5 !== void 0 ? n5 : e7.matches.length;
                  var o6 = e7.matches[n5 - 1];
                  if (t6)
                    a7.indexOf("[") === 0 || p4 && /\\d|\\s|\\w/i.test(a7) || a7 === "." ? e7.matches.splice(n5++, 0, {
                      fn: new RegExp(a7, i6.casing ? "i" : ""),
                      static: false,
                      optionality: false,
                      newBlockMarker: o6 === void 0 ? "master" : o6.def !== a7,
                      casing: null,
                      def: a7,
                      placeholder: void 0,
                      nativeDef: a7
                    }) : (p4 && (a7 = a7[a7.length - 1]), a7.split("").forEach(function(t7, a8) {
                      o6 = e7.matches[n5 - 1], e7.matches.splice(n5++, 0, {
                        fn: /[a-z]/i.test(i6.staticDefinitionSymbol || t7) ? new RegExp("[" + (i6.staticDefinitionSymbol || t7) + "]", i6.casing ? "i" : "") : null,
                        static: true,
                        optionality: false,
                        newBlockMarker: o6 === void 0 ? "master" : o6.def !== t7 && o6.static !== true,
                        casing: null,
                        def: i6.staticDefinitionSymbol || t7,
                        placeholder: i6.staticDefinitionSymbol !== void 0 ? t7 : void 0,
                        nativeDef: (p4 ? "'" : "") + t7
                      });
                    })), p4 = false;
                  else {
                    var l5 = i6.definitions && i6.definitions[a7] || i6.usePrototypeDefinitions && r4.default.prototype.definitions[a7];
                    l5 && !p4 ? e7.matches.splice(n5++, 0, {
                      fn: l5.validator ? typeof l5.validator == "string" ? new RegExp(l5.validator, i6.casing ? "i" : "") : new function() {
                        this.test = l5.validator;
                      }() : new RegExp("."),
                      static: l5.static || false,
                      optionality: l5.optional || false,
                      newBlockMarker: o6 === void 0 || l5.optional ? "master" : o6.def !== (l5.definitionSymbol || a7),
                      casing: l5.casing,
                      def: l5.definitionSymbol || a7,
                      placeholder: l5.placeholder,
                      nativeDef: a7,
                      generated: l5.generated
                    }) : (e7.matches.splice(n5++, 0, {
                      fn: /[a-z]/i.test(i6.staticDefinitionSymbol || a7) ? new RegExp("[" + (i6.staticDefinitionSymbol || a7) + "]", i6.casing ? "i" : "") : null,
                      static: true,
                      optionality: false,
                      newBlockMarker: o6 === void 0 ? "master" : o6.def !== a7 && o6.static !== true,
                      casing: null,
                      def: i6.staticDefinitionSymbol || a7,
                      placeholder: i6.staticDefinitionSymbol !== void 0 ? a7 : void 0,
                      nativeDef: (p4 ? "'" : "") + a7
                    }), p4 = false);
                  }
                }
                function y3() {
                  if (v3.length > 0) {
                    if (k3(s4 = v3[v3.length - 1], o5), s4.isAlternator) {
                      u4 = v3.pop();
                      for (var e7 = 0; e7 < u4.matches.length; e7++)
                        u4.matches[e7].isGroup && (u4.matches[e7].isGroup = false);
                      v3.length > 0 ? (s4 = v3[v3.length - 1]).matches.push(u4) : h4.matches.push(u4);
                    }
                  } else
                    k3(h4, o5);
                }
                function b3(e7) {
                  var t7 = new n4.default(true);
                  return t7.openGroup = false, t7.matches = e7, t7;
                }
                function x3() {
                  if ((l4 = v3.pop()).openGroup = false, l4 !== void 0)
                    if (v3.length > 0) {
                      if ((s4 = v3[v3.length - 1]).matches.push(l4), s4.isAlternator) {
                        for (var e7 = (u4 = v3.pop()).matches[0].matches ? u4.matches[0].matches.length : 1, t7 = 0; t7 < u4.matches.length; t7++)
                          u4.matches[t7].isGroup = false, u4.matches[t7].alternatorGroup = false, i6.keepStatic === null && e7 < (u4.matches[t7].matches ? u4.matches[t7].matches.length : 1) && (i6.keepStatic = true), e7 = u4.matches[t7].matches ? u4.matches[t7].matches.length : 1;
                        v3.length > 0 ? (s4 = v3[v3.length - 1]).matches.push(u4) : h4.matches.push(u4);
                      }
                    } else
                      h4.matches.push(l4);
                  else
                    y3();
                }
                function P3(e7) {
                  var t7 = e7.pop();
                  return t7.isQuantifier && (t7 = b3([e7.pop(), t7])), t7;
                }
                t6 && (i6.optionalmarker[0] = void 0, i6.optionalmarker[1] = void 0);
                for (; a6 = t6 ? d4.exec(e6) : f3.exec(e6); ) {
                  if (o5 = a6[0], t6) {
                    switch (o5.charAt(0)) {
                      case "?":
                        o5 = "{0,1}";
                        break;
                      case "+":
                      case "*":
                        o5 = "{" + o5 + "}";
                        break;
                      case "|":
                        if (v3.length === 0) {
                          var E3 = b3(h4.matches);
                          E3.openGroup = true, v3.push(E3), h4.matches = [], g3 = true;
                        }
                    }
                    if (o5 === "\\d")
                      o5 = "[0-9]";
                  }
                  if (p4)
                    y3();
                  else
                    switch (o5.charAt(0)) {
                      case "$":
                      case "^":
                        t6 || y3();
                        break;
                      case i6.escapeChar:
                        p4 = true, t6 && y3();
                        break;
                      case i6.optionalmarker[1]:
                      case i6.groupmarker[1]:
                        x3();
                        break;
                      case i6.optionalmarker[0]:
                        v3.push(new n4.default(false, true));
                        break;
                      case i6.groupmarker[0]:
                        v3.push(new n4.default(true));
                        break;
                      case i6.quantifiermarker[0]:
                        var S3 = new n4.default(false, false, true), _2 = (o5 = o5.replace(/[{}?]/g, "")).split("|"), w3 = _2[0].split(","), M3 = isNaN(w3[0]) ? w3[0] : parseInt(w3[0]), O3 = w3.length === 1 ? M3 : isNaN(w3[1]) ? w3[1] : parseInt(w3[1]), T3 = isNaN(_2[1]) ? _2[1] : parseInt(_2[1]);
                        M3 !== "*" && M3 !== "+" || (M3 = O3 === "*" ? 0 : 1), S3.quantifier = {
                          min: M3,
                          max: O3,
                          jit: T3
                        };
                        var C3 = v3.length > 0 ? v3[v3.length - 1].matches : h4.matches;
                        if ((a6 = C3.pop()).isAlternator) {
                          C3.push(a6), C3 = a6.matches;
                          var A3 = new n4.default(true), D3 = C3.pop();
                          C3.push(A3), C3 = A3.matches, a6 = D3;
                        }
                        a6.isGroup || (a6 = b3([a6])), C3.push(a6), C3.push(S3);
                        break;
                      case i6.alternatormarker:
                        if (v3.length > 0) {
                          var j3 = (s4 = v3[v3.length - 1]).matches[s4.matches.length - 1];
                          c4 = s4.openGroup && (j3.matches === void 0 || j3.isGroup === false && j3.isAlternator === false) ? v3.pop() : P3(s4.matches);
                        } else
                          c4 = P3(h4.matches);
                        if (c4.isAlternator)
                          v3.push(c4);
                        else if (c4.alternatorGroup ? (u4 = v3.pop(), c4.alternatorGroup = false) : u4 = new n4.default(false, false, false, true), u4.matches.push(c4), v3.push(u4), c4.openGroup) {
                          c4.openGroup = false;
                          var B2 = new n4.default(true);
                          B2.alternatorGroup = true, v3.push(B2);
                        }
                        break;
                      default:
                        y3();
                    }
                }
                g3 && x3();
                for (; v3.length > 0; )
                  l4 = v3.pop(), h4.matches.push(l4);
                h4.matches.length > 0 && (!function e7(a7) {
                  a7 && a7.matches && a7.matches.forEach(function(n5, r5) {
                    var o6 = a7.matches[r5 + 1];
                    (o6 === void 0 || o6.matches === void 0 || o6.isQuantifier === false) && n5 && n5.isGroup && (n5.isGroup = false, t6 || (k3(n5, i6.groupmarker[0], 0), n5.openGroup !== true && k3(n5, i6.groupmarker[1]))), e7(n5);
                  });
                }(h4), m3.push(h4));
                (i6.numericInput || i6.isRTL) && function e7(t7) {
                  for (var a7 in t7.matches = t7.matches.reverse(), t7.matches)
                    if (Object.prototype.hasOwnProperty.call(t7.matches, a7)) {
                      var n5 = parseInt(a7);
                      if (t7.matches[a7].isQuantifier && t7.matches[n5 + 1] && t7.matches[n5 + 1].isGroup) {
                        var r5 = t7.matches[a7];
                        t7.matches.splice(a7, 1), t7.matches.splice(n5 + 1, 0, r5);
                      }
                      t7.matches[a7].matches !== void 0 ? t7.matches[a7] = e7(t7.matches[a7]) : t7.matches[a7] = ((o6 = t7.matches[a7]) === i6.optionalmarker[0] ? o6 = i6.optionalmarker[1] : o6 === i6.optionalmarker[1] ? o6 = i6.optionalmarker[0] : o6 === i6.groupmarker[0] ? o6 = i6.groupmarker[1] : o6 === i6.groupmarker[1] && (o6 = i6.groupmarker[0]), o6);
                    }
                  var o6;
                  return t7;
                }(m3[0]);
                return m3;
              }, t5.generateMaskSet = function(e6, t6) {
                var i6;
                function n5(e7, i7, n6) {
                  var o6, l4, s4 = false;
                  if (e7 !== null && e7 !== "" || ((s4 = n6.regex !== null) ? e7 = (e7 = n6.regex).replace(/^(\^)(.*)(\$)$/, "$2") : (s4 = true, e7 = ".*")), e7.length === 1 && n6.greedy === false && n6.repeat !== 0 && (n6.placeholder = ""), n6.repeat > 0 || n6.repeat === "*" || n6.repeat === "+") {
                    var u4 = n6.repeat === "*" ? 0 : n6.repeat === "+" ? 1 : n6.repeat;
                    e7 = n6.groupmarker[0] + e7 + n6.groupmarker[1] + n6.quantifiermarker[0] + u4 + "," + n6.repeat + n6.quantifiermarker[1];
                  }
                  return l4 = s4 ? "regex_" + n6.regex : n6.numericInput ? e7.split("").reverse().join("") : e7, n6.keepStatic !== null && (l4 = "ks_" + n6.keepStatic + l4), r4.default.prototype.masksCache[l4] === void 0 || t6 === true ? (o6 = {
                    mask: e7,
                    maskToken: r4.default.prototype.analyseMask(e7, s4, n6),
                    validPositions: {},
                    _buffer: void 0,
                    buffer: void 0,
                    tests: {},
                    excludes: {},
                    metadata: i7,
                    maskLength: void 0,
                    jitOffset: {}
                  }, t6 !== true && (r4.default.prototype.masksCache[l4] = o6, o6 = a5.default.extend(true, {}, r4.default.prototype.masksCache[l4]))) : o6 = a5.default.extend(true, {}, r4.default.prototype.masksCache[l4]), o6;
                }
                typeof e6.mask == "function" && (e6.mask = e6.mask(e6));
                if (Array.isArray(e6.mask)) {
                  if (e6.mask.length > 1) {
                    e6.keepStatic === null && (e6.keepStatic = true);
                    var o5 = e6.groupmarker[0];
                    return (e6.isRTL ? e6.mask.reverse() : e6.mask).forEach(function(t7) {
                      o5.length > 1 && (o5 += e6.alternatormarker), t7.mask !== void 0 && typeof t7.mask != "function" ? o5 += t7.mask : o5 += t7;
                    }), n5(o5 += e6.groupmarker[1], e6.mask, e6);
                  }
                  e6.mask = e6.mask.pop();
                }
                i6 = e6.mask && e6.mask.mask !== void 0 && typeof e6.mask.mask != "function" ? n5(e6.mask.mask, e6.mask, e6) : n5(e6.mask, e6.mask, e6);
                e6.keepStatic === null && (e6.keepStatic = false);
                return i6;
              };
              var a5 = o4(i5(4963)), n4 = o4(i5(9695)), r4 = o4(i5(2394));
              function o4(e6) {
                return e6 && e6.__esModule ? e6 : {
                  default: e6
                };
              }
            },
            157: function(e5, t5, i5) {
              Object.defineProperty(t5, "__esModule", {
                value: true
              }), t5.mask = function() {
                var e6 = this, t6 = this.opts, i6 = this.el, a6 = this.dependencyLib;
                l4.EventRuler.off(i6);
                var f3 = function(t7, i7) {
                  t7.tagName.toLowerCase() !== "textarea" && i7.ignorables.push(n4.default.ENTER);
                  var s5 = t7.getAttribute("type"), u5 = t7.tagName.toLowerCase() === "input" && i7.supportsInputType.includes(s5) || t7.isContentEditable || t7.tagName.toLowerCase() === "textarea";
                  if (!u5)
                    if (t7.tagName.toLowerCase() === "input") {
                      var c5 = document.createElement("input");
                      c5.setAttribute("type", s5), u5 = c5.type === "text", c5 = null;
                    } else
                      u5 = "partial";
                  return u5 !== false ? function(t8) {
                    var n5, s6;
                    function u6() {
                      return this.inputmask ? this.inputmask.opts.autoUnmask ? this.inputmask.unmaskedvalue() : r4.getLastValidPosition.call(e6) !== -1 || i7.nullable !== true ? (this.inputmask.shadowRoot || this.ownerDocument).activeElement === this && i7.clearMaskOnLostFocus ? (e6.isRTL ? o4.clearOptionalTail.call(e6, r4.getBuffer.call(e6).slice()).reverse() : o4.clearOptionalTail.call(e6, r4.getBuffer.call(e6).slice())).join("") : n5.call(this) : "" : n5.call(this);
                    }
                    function c6(e7) {
                      s6.call(this, e7), this.inputmask && (0, o4.applyInputValue)(this, e7);
                    }
                    if (!t8.inputmask.__valueGet) {
                      if (i7.noValuePatching !== true) {
                        if (Object.getOwnPropertyDescriptor) {
                          var f4 = Object.getPrototypeOf ? Object.getOwnPropertyDescriptor(Object.getPrototypeOf(t8), "value") : void 0;
                          f4 && f4.get && f4.set ? (n5 = f4.get, s6 = f4.set, Object.defineProperty(t8, "value", {
                            get: u6,
                            set: c6,
                            configurable: true
                          })) : t8.tagName.toLowerCase() !== "input" && (n5 = function() {
                            return this.textContent;
                          }, s6 = function(e7) {
                            this.textContent = e7;
                          }, Object.defineProperty(t8, "value", {
                            get: u6,
                            set: c6,
                            configurable: true
                          }));
                        } else
                          document.__lookupGetter__ && t8.__lookupGetter__("value") && (n5 = t8.__lookupGetter__("value"), s6 = t8.__lookupSetter__("value"), t8.__defineGetter__("value", u6), t8.__defineSetter__("value", c6));
                        t8.inputmask.__valueGet = n5, t8.inputmask.__valueSet = s6;
                      }
                      t8.inputmask._valueGet = function(t9) {
                        return e6.isRTL && t9 !== true ? n5.call(this.el).split("").reverse().join("") : n5.call(this.el);
                      }, t8.inputmask._valueSet = function(t9, i8) {
                        s6.call(this.el, t9 == null ? "" : i8 !== true && e6.isRTL ? t9.split("").reverse().join("") : t9);
                      }, n5 === void 0 && (n5 = function() {
                        return this.value;
                      }, s6 = function(e7) {
                        this.value = e7;
                      }, function(t9) {
                        if (a6.valHooks && (a6.valHooks[t9] === void 0 || a6.valHooks[t9].inputmaskpatch !== true)) {
                          var n6 = a6.valHooks[t9] && a6.valHooks[t9].get ? a6.valHooks[t9].get : function(e7) {
                            return e7.value;
                          }, l5 = a6.valHooks[t9] && a6.valHooks[t9].set ? a6.valHooks[t9].set : function(e7, t10) {
                            return e7.value = t10, e7;
                          };
                          a6.valHooks[t9] = {
                            get: function(t10) {
                              if (t10.inputmask) {
                                if (t10.inputmask.opts.autoUnmask)
                                  return t10.inputmask.unmaskedvalue();
                                var a7 = n6(t10);
                                return r4.getLastValidPosition.call(e6, void 0, void 0, t10.inputmask.maskset.validPositions) !== -1 || i7.nullable !== true ? a7 : "";
                              }
                              return n6(t10);
                            },
                            set: function(e7, t10) {
                              var i8 = l5(e7, t10);
                              return e7.inputmask && (0, o4.applyInputValue)(e7, t10), i8;
                            },
                            inputmaskpatch: true
                          };
                        }
                      }(t8.type), function(t9) {
                        l4.EventRuler.on(t9, "mouseenter", function() {
                          var t10 = this.inputmask._valueGet(true);
                          t10 !== (e6.isRTL ? r4.getBuffer.call(e6).reverse() : r4.getBuffer.call(e6)).join("") && (0, o4.applyInputValue)(this, t10);
                        });
                      }(t8));
                    }
                  }(t7) : t7.inputmask = void 0, u5;
                }(i6, t6);
                if (f3 !== false) {
                  e6.originalPlaceholder = i6.placeholder, e6.maxLength = i6 !== void 0 ? i6.maxLength : void 0, e6.maxLength === -1 && (e6.maxLength = void 0), "inputMode" in i6 && i6.getAttribute("inputmode") === null && (i6.inputMode = t6.inputmode, i6.setAttribute("inputmode", t6.inputmode)), f3 === true && (t6.showMaskOnFocus = t6.showMaskOnFocus && ["cc-number", "cc-exp"].indexOf(i6.autocomplete) === -1, s4.iphone && (t6.insertModeVisual = false), l4.EventRuler.on(i6, "submit", c4.EventHandlers.submitEvent), l4.EventRuler.on(i6, "reset", c4.EventHandlers.resetEvent), l4.EventRuler.on(i6, "blur", c4.EventHandlers.blurEvent), l4.EventRuler.on(i6, "focus", c4.EventHandlers.focusEvent), l4.EventRuler.on(i6, "invalid", c4.EventHandlers.invalidEvent), l4.EventRuler.on(i6, "click", c4.EventHandlers.clickEvent), l4.EventRuler.on(i6, "mouseleave", c4.EventHandlers.mouseleaveEvent), l4.EventRuler.on(i6, "mouseenter", c4.EventHandlers.mouseenterEvent), l4.EventRuler.on(i6, "paste", c4.EventHandlers.pasteEvent), l4.EventRuler.on(i6, "cut", c4.EventHandlers.cutEvent), l4.EventRuler.on(i6, "complete", t6.oncomplete), l4.EventRuler.on(i6, "incomplete", t6.onincomplete), l4.EventRuler.on(i6, "cleared", t6.oncleared), t6.inputEventOnly !== true && (l4.EventRuler.on(i6, "keydown", c4.EventHandlers.keydownEvent), l4.EventRuler.on(i6, "keypress", c4.EventHandlers.keypressEvent), l4.EventRuler.on(i6, "keyup", c4.EventHandlers.keyupEvent)), (s4.mobile || t6.inputEventOnly) && i6.removeAttribute("maxLength"), l4.EventRuler.on(i6, "input", c4.EventHandlers.inputFallBackEvent), l4.EventRuler.on(i6, "compositionend", c4.EventHandlers.compositionendEvent)), l4.EventRuler.on(i6, "setvalue", c4.EventHandlers.setValueEvent), r4.getBufferTemplate.call(e6).join(""), e6.undoValue = e6._valueGet(true);
                  var d4 = (i6.inputmask.shadowRoot || i6.ownerDocument).activeElement;
                  if (i6.inputmask._valueGet(true) !== "" || t6.clearMaskOnLostFocus === false || d4 === i6) {
                    (0, o4.applyInputValue)(i6, i6.inputmask._valueGet(true), t6);
                    var p4 = r4.getBuffer.call(e6).slice();
                    u4.isComplete.call(e6, p4) === false && t6.clearIncomplete && r4.resetMaskSet.call(e6), t6.clearMaskOnLostFocus && d4 !== i6 && (r4.getLastValidPosition.call(e6) === -1 ? p4 = [] : o4.clearOptionalTail.call(e6, p4)), (t6.clearMaskOnLostFocus === false || t6.showMaskOnFocus && d4 === i6 || i6.inputmask._valueGet(true) !== "") && (0, o4.writeBuffer)(i6, p4), d4 === i6 && r4.caret.call(e6, i6, r4.seekNext.call(e6, r4.getLastValidPosition.call(e6)));
                  }
                }
              };
              var a5, n4 = (a5 = i5(5581)) && a5.__esModule ? a5 : {
                default: a5
              }, r4 = i5(8711), o4 = i5(7760), l4 = i5(9716), s4 = i5(9845), u4 = i5(7215), c4 = i5(6030);
            },
            9695: function(e5, t5) {
              Object.defineProperty(t5, "__esModule", {
                value: true
              }), t5.default = function(e6, t6, i5, a5) {
                this.matches = [], this.openGroup = e6 || false, this.alternatorGroup = false, this.isGroup = e6 || false, this.isOptional = t6 || false, this.isQuantifier = i5 || false, this.isAlternator = a5 || false, this.quantifier = {
                  min: 1,
                  max: 1
                };
              };
            },
            3194: function() {
              Array.prototype.includes || Object.defineProperty(Array.prototype, "includes", {
                value: function(e5, t5) {
                  if (this == null)
                    throw new TypeError('"this" is null or not defined');
                  var i5 = Object(this), a5 = i5.length >>> 0;
                  if (a5 === 0)
                    return false;
                  for (var n4 = 0 | t5, r4 = Math.max(n4 >= 0 ? n4 : a5 - Math.abs(n4), 0); r4 < a5; ) {
                    if (i5[r4] === e5)
                      return true;
                    r4++;
                  }
                  return false;
                }
              });
            },
            7149: function() {
              function e5(t5) {
                return e5 = typeof Symbol == "function" && typeof Symbol.iterator == "symbol" ? function(e6) {
                  return typeof e6;
                } : function(e6) {
                  return e6 && typeof Symbol == "function" && e6.constructor === Symbol && e6 !== Symbol.prototype ? "symbol" : typeof e6;
                }, e5(t5);
              }
              typeof Object.getPrototypeOf != "function" && (Object.getPrototypeOf = e5("test".__proto__) === "object" ? function(e6) {
                return e6.__proto__;
              } : function(e6) {
                return e6.constructor.prototype;
              });
            },
            8711: function(e5, t5, i5) {
              Object.defineProperty(t5, "__esModule", {
                value: true
              }), t5.caret = function(e6, t6, i6, a6, n5) {
                var r5, o5 = this, l5 = this.opts;
                if (t6 === void 0)
                  return "selectionStart" in e6 && "selectionEnd" in e6 ? (t6 = e6.selectionStart, i6 = e6.selectionEnd) : window.getSelection ? (r5 = window.getSelection().getRangeAt(0)).commonAncestorContainer.parentNode !== e6 && r5.commonAncestorContainer !== e6 || (t6 = r5.startOffset, i6 = r5.endOffset) : document.selection && document.selection.createRange && (r5 = document.selection.createRange(), t6 = 0 - r5.duplicate().moveStart("character", -e6.inputmask._valueGet().length), i6 = t6 + r5.text.length), {
                    begin: a6 ? t6 : u4.call(o5, t6),
                    end: a6 ? i6 : u4.call(o5, i6)
                  };
                if (Array.isArray(t6) && (i6 = o5.isRTL ? t6[0] : t6[1], t6 = o5.isRTL ? t6[1] : t6[0]), t6.begin !== void 0 && (i6 = o5.isRTL ? t6.begin : t6.end, t6 = o5.isRTL ? t6.end : t6.begin), typeof t6 == "number") {
                  t6 = a6 ? t6 : u4.call(o5, t6), i6 = typeof (i6 = a6 ? i6 : u4.call(o5, i6)) == "number" ? i6 : t6;
                  var s5 = parseInt(((e6.ownerDocument.defaultView || window).getComputedStyle ? (e6.ownerDocument.defaultView || window).getComputedStyle(e6, null) : e6.currentStyle).fontSize) * i6;
                  if (e6.scrollLeft = s5 > e6.scrollWidth ? s5 : 0, e6.inputmask.caretPos = {
                    begin: t6,
                    end: i6
                  }, l5.insertModeVisual && l5.insertMode === false && t6 === i6 && (n5 || i6++), e6 === (e6.inputmask.shadowRoot || e6.ownerDocument).activeElement)
                    if ("setSelectionRange" in e6)
                      e6.setSelectionRange(t6, i6);
                    else if (window.getSelection) {
                      if (r5 = document.createRange(), e6.firstChild === void 0 || e6.firstChild === null) {
                        var c4 = document.createTextNode("");
                        e6.appendChild(c4);
                      }
                      r5.setStart(e6.firstChild, t6 < e6.inputmask._valueGet().length ? t6 : e6.inputmask._valueGet().length), r5.setEnd(e6.firstChild, i6 < e6.inputmask._valueGet().length ? i6 : e6.inputmask._valueGet().length), r5.collapse(true);
                      var f3 = window.getSelection();
                      f3.removeAllRanges(), f3.addRange(r5);
                    } else
                      e6.createTextRange && ((r5 = e6.createTextRange()).collapse(true), r5.moveEnd("character", i6), r5.moveStart("character", t6), r5.select());
                }
              }, t5.determineLastRequiredPosition = function(e6) {
                var t6, i6, r5 = this, l5 = this.maskset, s5 = this.dependencyLib, u5 = a5.getMaskTemplate.call(r5, true, o4.call(r5), true, true), c4 = u5.length, f3 = o4.call(r5), d4 = {}, p4 = l5.validPositions[f3], h4 = p4 !== void 0 ? p4.locator.slice() : void 0;
                for (t6 = f3 + 1; t6 < u5.length; t6++)
                  i6 = a5.getTestTemplate.call(r5, t6, h4, t6 - 1), h4 = i6.locator.slice(), d4[t6] = s5.extend(true, {}, i6);
                var v3 = p4 && p4.alternation !== void 0 ? p4.locator[p4.alternation] : void 0;
                for (t6 = c4 - 1; t6 > f3 && (((i6 = d4[t6]).match.optionality || i6.match.optionalQuantifier && i6.match.newBlockMarker || v3 && (v3 !== d4[t6].locator[p4.alternation] && i6.match.static != 1 || i6.match.static === true && i6.locator[p4.alternation] && n4.checkAlternationMatch.call(r5, i6.locator[p4.alternation].toString().split(","), v3.toString().split(",")) && a5.getTests.call(r5, t6)[0].def !== "")) && u5[t6] === a5.getPlaceholder.call(r5, t6, i6.match)); t6--)
                  c4--;
                return e6 ? {
                  l: c4,
                  def: d4[c4] ? d4[c4].match : void 0
                } : c4;
              }, t5.determineNewCaretPosition = function(e6, t6, i6) {
                var n5 = this, u5 = this.maskset, c4 = this.opts;
                t6 && (n5.isRTL ? e6.end = e6.begin : e6.begin = e6.end);
                if (e6.begin === e6.end) {
                  switch (i6 = i6 || c4.positionCaretOnClick) {
                    case "none":
                      break;
                    case "select":
                      e6 = {
                        begin: 0,
                        end: r4.call(n5).length
                      };
                      break;
                    case "ignore":
                      e6.end = e6.begin = s4.call(n5, o4.call(n5));
                      break;
                    case "radixFocus":
                      if (function(e7) {
                        if (c4.radixPoint !== "" && c4.digits !== 0) {
                          var t7 = u5.validPositions;
                          if (t7[e7] === void 0 || t7[e7].input === a5.getPlaceholder.call(n5, e7)) {
                            if (e7 < s4.call(n5, -1))
                              return true;
                            var i7 = r4.call(n5).indexOf(c4.radixPoint);
                            if (i7 !== -1) {
                              for (var o5 in t7)
                                if (t7[o5] && i7 < o5 && t7[o5].input !== a5.getPlaceholder.call(n5, o5))
                                  return false;
                              return true;
                            }
                          }
                        }
                        return false;
                      }(e6.begin)) {
                        var f3 = r4.call(n5).join("").indexOf(c4.radixPoint);
                        e6.end = e6.begin = c4.numericInput ? s4.call(n5, f3) : f3;
                        break;
                      }
                    default:
                      var d4 = e6.begin, p4 = o4.call(n5, d4, true), h4 = s4.call(n5, p4 !== -1 || l4.call(n5, 0) ? p4 : -1);
                      if (d4 <= h4)
                        e6.end = e6.begin = l4.call(n5, d4, false, true) ? d4 : s4.call(n5, d4);
                      else {
                        var v3 = u5.validPositions[p4], m3 = a5.getTestTemplate.call(n5, h4, v3 ? v3.match.locator : void 0, v3), g3 = a5.getPlaceholder.call(n5, h4, m3.match);
                        if (g3 !== "" && r4.call(n5)[h4] !== g3 && m3.match.optionalQuantifier !== true && m3.match.newBlockMarker !== true || !l4.call(n5, h4, c4.keepStatic, true) && m3.match.def === g3) {
                          var k3 = s4.call(n5, h4);
                          (d4 >= k3 || d4 === h4) && (h4 = k3);
                        }
                        e6.end = e6.begin = h4;
                      }
                  }
                  return e6;
                }
              }, t5.getBuffer = r4, t5.getBufferTemplate = function() {
                var e6 = this.maskset;
                e6._buffer === void 0 && (e6._buffer = a5.getMaskTemplate.call(this, false, 1), e6.buffer === void 0 && (e6.buffer = e6._buffer.slice()));
                return e6._buffer;
              }, t5.getLastValidPosition = o4, t5.isMask = l4, t5.resetMaskSet = function(e6) {
                var t6 = this.maskset;
                t6.buffer = void 0, e6 !== true && (t6.validPositions = {}, t6.p = 0);
              }, t5.seekNext = s4, t5.seekPrevious = function(e6, t6) {
                var i6 = this, n5 = e6 - 1;
                if (e6 <= 0)
                  return 0;
                for (; n5 > 0 && (t6 === true && (a5.getTest.call(i6, n5).match.newBlockMarker !== true || !l4.call(i6, n5, void 0, true)) || t6 !== true && !l4.call(i6, n5, void 0, true)); )
                  n5--;
                return n5;
              }, t5.translatePosition = u4;
              var a5 = i5(4713), n4 = i5(7215);
              function r4(e6) {
                var t6 = this.maskset;
                return t6.buffer !== void 0 && e6 !== true || (t6.buffer = a5.getMaskTemplate.call(this, true, o4.call(this), true), t6._buffer === void 0 && (t6._buffer = t6.buffer.slice())), t6.buffer;
              }
              function o4(e6, t6, i6) {
                var a6 = this.maskset, n5 = -1, r5 = -1, o5 = i6 || a6.validPositions;
                for (var l5 in e6 === void 0 && (e6 = -1), o5) {
                  var s5 = parseInt(l5);
                  o5[s5] && (t6 || o5[s5].generatedInput !== true) && (s5 <= e6 && (n5 = s5), s5 >= e6 && (r5 = s5));
                }
                return n5 === -1 || n5 == e6 ? r5 : r5 == -1 || e6 - n5 < r5 - e6 ? n5 : r5;
              }
              function l4(e6, t6, i6) {
                var n5 = this, r5 = this.maskset, o5 = a5.getTestTemplate.call(n5, e6).match;
                if (o5.def === "" && (o5 = a5.getTest.call(n5, e6).match), o5.static !== true)
                  return o5.fn;
                if (i6 === true && r5.validPositions[e6] !== void 0 && r5.validPositions[e6].generatedInput !== true)
                  return true;
                if (t6 !== true && e6 > -1) {
                  if (i6) {
                    var l5 = a5.getTests.call(n5, e6);
                    return l5.length > 1 + (l5[l5.length - 1].match.def === "" ? 1 : 0);
                  }
                  var s5 = a5.determineTestTemplate.call(n5, e6, a5.getTests.call(n5, e6)), u5 = a5.getPlaceholder.call(n5, e6, s5.match);
                  return s5.match.def !== u5;
                }
                return false;
              }
              function s4(e6, t6, i6) {
                var n5 = this;
                i6 === void 0 && (i6 = true);
                for (var r5 = e6 + 1; a5.getTest.call(n5, r5).match.def !== "" && (t6 === true && (a5.getTest.call(n5, r5).match.newBlockMarker !== true || !l4.call(n5, r5, void 0, true)) || t6 !== true && !l4.call(n5, r5, void 0, i6)); )
                  r5++;
                return r5;
              }
              function u4(e6) {
                var t6 = this.opts, i6 = this.el;
                return !this.isRTL || typeof e6 != "number" || t6.greedy && t6.placeholder === "" || !i6 || (e6 = Math.abs(this._valueGet().length - e6)), e6;
              }
            },
            4713: function(e5, t5, i5) {
              Object.defineProperty(t5, "__esModule", {
                value: true
              }), t5.determineTestTemplate = u4, t5.getDecisionTaker = o4, t5.getMaskTemplate = function(e6, t6, i6, a6, n5) {
                var r5 = this, o5 = this.opts, c5 = this.maskset, f4 = o5.greedy;
                n5 && o5.greedy && (o5.greedy = false, r5.maskset.tests = {});
                t6 = t6 || 0;
                var p4, h4, v3, m3, g3 = [], k3 = 0;
                do {
                  if (e6 === true && c5.validPositions[k3])
                    v3 = n5 && c5.validPositions[k3].match.optionality && c5.validPositions[k3 + 1] === void 0 && (c5.validPositions[k3].generatedInput === true || c5.validPositions[k3].input == o5.skipOptionalPartCharacter && k3 > 0) ? u4.call(r5, k3, d4.call(r5, k3, p4, k3 - 1)) : c5.validPositions[k3], h4 = v3.match, p4 = v3.locator.slice(), g3.push(i6 === true ? v3.input : i6 === false ? h4.nativeDef : l4.call(r5, k3, h4));
                  else {
                    v3 = s4.call(r5, k3, p4, k3 - 1), h4 = v3.match, p4 = v3.locator.slice();
                    var y3 = a6 !== true && (o5.jitMasking !== false ? o5.jitMasking : h4.jit);
                    (m3 = (m3 && h4.static && h4.def !== o5.groupSeparator && h4.fn === null || c5.validPositions[k3 - 1] && h4.static && h4.def !== o5.groupSeparator && h4.fn === null) && c5.tests[k3] && c5.tests[k3].length === 1) || y3 === false || y3 === void 0 || typeof y3 == "number" && isFinite(y3) && y3 > k3 ? g3.push(i6 === false ? h4.nativeDef : l4.call(r5, k3, h4)) : m3 = false;
                  }
                  k3++;
                } while (h4.static !== true || h4.def !== "" || t6 > k3);
                g3[g3.length - 1] === "" && g3.pop();
                i6 === false && c5.maskLength !== void 0 || (c5.maskLength = k3 - 1);
                return o5.greedy = f4, g3;
              }, t5.getPlaceholder = l4, t5.getTest = c4, t5.getTestTemplate = s4, t5.getTests = d4, t5.isSubsetOf = f3;
              var a5, n4 = (a5 = i5(2394)) && a5.__esModule ? a5 : {
                default: a5
              };
              function r4(e6, t6) {
                var i6 = (e6.alternation != null ? e6.mloc[o4(e6)] : e6.locator).join("");
                if (i6 !== "")
                  for (; i6.length < t6; )
                    i6 += "0";
                return i6;
              }
              function o4(e6) {
                var t6 = e6.locator[e6.alternation];
                return typeof t6 == "string" && t6.length > 0 && (t6 = t6.split(",")[0]), t6 !== void 0 ? t6.toString() : "";
              }
              function l4(e6, t6, i6) {
                var a6 = this.opts, n5 = this.maskset;
                if ((t6 = t6 || c4.call(this, e6).match).placeholder !== void 0 || i6 === true)
                  return typeof t6.placeholder == "function" ? t6.placeholder(a6) : t6.placeholder;
                if (t6.static === true) {
                  if (e6 > -1 && n5.validPositions[e6] === void 0) {
                    var r5, o5 = d4.call(this, e6), l5 = [];
                    if (o5.length > 1 + (o5[o5.length - 1].match.def === "" ? 1 : 0)) {
                      for (var s5 = 0; s5 < o5.length; s5++)
                        if (o5[s5].match.def !== "" && o5[s5].match.optionality !== true && o5[s5].match.optionalQuantifier !== true && (o5[s5].match.static === true || r5 === void 0 || o5[s5].match.fn.test(r5.match.def, n5, e6, true, a6) !== false) && (l5.push(o5[s5]), o5[s5].match.static === true && (r5 = o5[s5]), l5.length > 1 && /[0-9a-bA-Z]/.test(l5[0].match.def)))
                          return a6.placeholder.charAt(e6 % a6.placeholder.length);
                    }
                  }
                  return t6.def;
                }
                return a6.placeholder.charAt(e6 % a6.placeholder.length);
              }
              function s4(e6, t6, i6) {
                return this.maskset.validPositions[e6] || u4.call(this, e6, d4.call(this, e6, t6 ? t6.slice() : t6, i6));
              }
              function u4(e6, t6) {
                var i6 = this.opts, a6 = function(e7, t7) {
                  var i7 = 0, a7 = false;
                  t7.forEach(function(e8) {
                    e8.match.optionality && (i7 !== 0 && i7 !== e8.match.optionality && (a7 = true), (i7 === 0 || i7 > e8.match.optionality) && (i7 = e8.match.optionality));
                  }), i7 && (e7 == 0 || t7.length == 1 ? i7 = 0 : a7 || (i7 = 0));
                  return i7;
                }(e6, t6);
                e6 = e6 > 0 ? e6 - 1 : 0;
                var n5, o5, l5, s5 = r4(c4.call(this, e6));
                i6.greedy && t6.length > 1 && t6[t6.length - 1].match.def === "" && t6.pop();
                for (var u5 = 0; u5 < t6.length; u5++) {
                  var f4 = t6[u5];
                  n5 = r4(f4, s5.length);
                  var d5 = Math.abs(n5 - s5);
                  (o5 === void 0 || n5 !== "" && d5 < o5 || l5 && !i6.greedy && l5.match.optionality && l5.match.optionality - a6 > 0 && l5.match.newBlockMarker === "master" && (!f4.match.optionality || f4.match.optionality - a6 < 1 || !f4.match.newBlockMarker) || l5 && !i6.greedy && l5.match.optionalQuantifier && !f4.match.optionalQuantifier) && (o5 = d5, l5 = f4);
                }
                return l5;
              }
              function c4(e6, t6) {
                var i6 = this.maskset;
                return i6.validPositions[e6] ? i6.validPositions[e6] : (t6 || d4.call(this, e6))[0];
              }
              function f3(e6, t6, i6) {
                function a6(e7) {
                  for (var t7, i7 = [], a7 = -1, n5 = 0, r5 = e7.length; n5 < r5; n5++)
                    if (e7.charAt(n5) === "-")
                      for (t7 = e7.charCodeAt(n5 + 1); ++a7 < t7; )
                        i7.push(String.fromCharCode(a7));
                    else
                      a7 = e7.charCodeAt(n5), i7.push(e7.charAt(n5));
                  return i7.join("");
                }
                return e6.match.def === t6.match.nativeDef || !(!(i6.regex || e6.match.fn instanceof RegExp && t6.match.fn instanceof RegExp) || e6.match.static === true || t6.match.static === true) && a6(t6.match.fn.toString().replace(/[[\]/]/g, "")).indexOf(a6(e6.match.fn.toString().replace(/[[\]/]/g, ""))) !== -1;
              }
              function d4(e6, t6, i6) {
                var a6, r5, o5 = this, l5 = this.dependencyLib, s5 = this.maskset, c5 = this.opts, d5 = this.el, p4 = s5.maskToken, h4 = t6 ? i6 : 0, v3 = t6 ? t6.slice() : [0], m3 = [], g3 = false, k3 = t6 ? t6.join("") : "";
                function y3(t7, i7, r6, o6) {
                  function l6(r7, o7, u6) {
                    function p6(e7, t8) {
                      var i8 = t8.matches.indexOf(e7) === 0;
                      return i8 || t8.matches.every(function(a7, n5) {
                        return a7.isQuantifier === true ? i8 = p6(e7, t8.matches[n5 - 1]) : Object.prototype.hasOwnProperty.call(a7, "matches") && (i8 = p6(e7, a7)), !i8;
                      }), i8;
                    }
                    function v4(e7, t8, i8) {
                      var a7, n5;
                      if ((s5.tests[e7] || s5.validPositions[e7]) && (s5.tests[e7] || [s5.validPositions[e7]]).every(function(e8, r9) {
                        if (e8.mloc[t8])
                          return a7 = e8, false;
                        var o8 = i8 !== void 0 ? i8 : e8.alternation, l7 = e8.locator[o8] !== void 0 ? e8.locator[o8].toString().indexOf(t8) : -1;
                        return (n5 === void 0 || l7 < n5) && l7 !== -1 && (a7 = e8, n5 = l7), true;
                      }), a7) {
                        var r8 = a7.locator[a7.alternation];
                        return (a7.mloc[t8] || a7.mloc[r8] || a7.locator).slice((i8 !== void 0 ? i8 : a7.alternation) + 1);
                      }
                      return i8 !== void 0 ? v4(e7, t8) : void 0;
                    }
                    function b4(e7, t8) {
                      var i8 = e7.alternation, a7 = t8 === void 0 || i8 === t8.alternation && e7.locator[i8].toString().indexOf(t8.locator[i8]) === -1;
                      if (!a7 && i8 > t8.alternation) {
                        for (var n5 = t8.alternation; n5 < i8; n5++)
                          if (e7.locator[n5] !== t8.locator[n5]) {
                            i8 = n5, a7 = true;
                            break;
                          }
                      }
                      if (a7) {
                        e7.mloc = e7.mloc || {};
                        var r8 = e7.locator[i8];
                        if (r8 !== void 0) {
                          if (typeof r8 == "string" && (r8 = r8.split(",")[0]), e7.mloc[r8] === void 0 && (e7.mloc[r8] = e7.locator.slice()), t8 !== void 0) {
                            for (var o8 in t8.mloc)
                              typeof o8 == "string" && (o8 = o8.split(",")[0]), e7.mloc[o8] === void 0 && (e7.mloc[o8] = t8.mloc[o8]);
                            e7.locator[i8] = Object.keys(e7.mloc).join(",");
                          }
                          return true;
                        }
                        e7.alternation = void 0;
                      }
                      return false;
                    }
                    function x4(e7, t8) {
                      if (e7.locator.length !== t8.locator.length)
                        return false;
                      for (var i8 = e7.alternation + 1; i8 < e7.locator.length; i8++)
                        if (e7.locator[i8] !== t8.locator[i8])
                          return false;
                      return true;
                    }
                    if (h4 > e6 + c5._maxTestPos)
                      throw "Inputmask: There is probably an error in your mask definition or in the code. Create an issue on github with an example of the mask you are using. " + s5.mask;
                    if (h4 === e6 && r7.matches === void 0) {
                      if (m3.push({
                        match: r7,
                        locator: o7.reverse(),
                        cd: k3,
                        mloc: {}
                      }), !r7.optionality || u6 !== void 0 || !(c5.definitions && c5.definitions[r7.nativeDef] && c5.definitions[r7.nativeDef].optional || n4.default.prototype.definitions[r7.nativeDef] && n4.default.prototype.definitions[r7.nativeDef].optional))
                        return true;
                      g3 = true, h4 = e6;
                    } else if (r7.matches !== void 0) {
                      if (r7.isGroup && u6 !== r7) {
                        if (r7 = l6(t7.matches[t7.matches.indexOf(r7) + 1], o7, u6))
                          return true;
                      } else if (r7.isOptional) {
                        var P4 = r7, E3 = m3.length;
                        if (r7 = y3(r7, i7, o7, u6)) {
                          if (m3.forEach(function(e7, t8) {
                            t8 >= E3 && (e7.match.optionality = e7.match.optionality ? e7.match.optionality + 1 : 1);
                          }), a6 = m3[m3.length - 1].match, u6 !== void 0 || !p6(a6, P4))
                            return true;
                          g3 = true, h4 = e6;
                        }
                      } else if (r7.isAlternator) {
                        var S3, _2 = r7, w3 = [], M3 = m3.slice(), O3 = o7.length, T3 = false, C3 = i7.length > 0 ? i7.shift() : -1;
                        if (C3 === -1 || typeof C3 == "string") {
                          var A3, D3 = h4, j3 = i7.slice(), B2 = [];
                          if (typeof C3 == "string")
                            B2 = C3.split(",");
                          else
                            for (A3 = 0; A3 < _2.matches.length; A3++)
                              B2.push(A3.toString());
                          if (s5.excludes[e6] !== void 0) {
                            for (var R3 = B2.slice(), L3 = 0, I3 = s5.excludes[e6].length; L3 < I3; L3++) {
                              var F3 = s5.excludes[e6][L3].toString().split(":");
                              o7.length == F3[1] && B2.splice(B2.indexOf(F3[0]), 1);
                            }
                            B2.length === 0 && (delete s5.excludes[e6], B2 = R3);
                          }
                          (c5.keepStatic === true || isFinite(parseInt(c5.keepStatic)) && D3 >= c5.keepStatic) && (B2 = B2.slice(0, 1));
                          for (var N2 = 0; N2 < B2.length; N2++) {
                            A3 = parseInt(B2[N2]), m3 = [], i7 = typeof C3 == "string" && v4(h4, A3, O3) || j3.slice();
                            var V2 = _2.matches[A3];
                            if (V2 && l6(V2, [A3].concat(o7), u6))
                              r7 = true;
                            else if (N2 === 0 && (T3 = true), V2 && V2.matches && V2.matches.length > _2.matches[0].matches.length)
                              break;
                            S3 = m3.slice(), h4 = D3, m3 = [];
                            for (var G2 = 0; G2 < S3.length; G2++) {
                              var H3 = S3[G2], K2 = false;
                              H3.match.jit = H3.match.jit || T3, H3.alternation = H3.alternation || O3, b4(H3);
                              for (var U2 = 0; U2 < w3.length; U2++) {
                                var $4 = w3[U2];
                                if (typeof C3 != "string" || H3.alternation !== void 0 && B2.includes(H3.locator[H3.alternation].toString())) {
                                  if (H3.match.nativeDef === $4.match.nativeDef) {
                                    K2 = true, b4($4, H3);
                                    break;
                                  }
                                  if (f3(H3, $4, c5)) {
                                    b4(H3, $4) && (K2 = true, w3.splice(w3.indexOf($4), 0, H3));
                                    break;
                                  }
                                  if (f3($4, H3, c5)) {
                                    b4($4, H3);
                                    break;
                                  }
                                  if (Z2 = $4, (Q2 = H3).match.static === true && Z2.match.static !== true && Z2.match.fn.test(Q2.match.def, s5, e6, false, c5, false)) {
                                    x4(H3, $4) || d5.inputmask.userOptions.keepStatic !== void 0 ? b4(H3, $4) && (K2 = true, w3.splice(w3.indexOf($4), 0, H3)) : c5.keepStatic = true;
                                    break;
                                  }
                                }
                              }
                              K2 || w3.push(H3);
                            }
                          }
                          m3 = M3.concat(w3), h4 = e6, g3 = m3.length > 0, r7 = w3.length > 0, i7 = j3.slice();
                        } else
                          r7 = l6(_2.matches[C3] || t7.matches[C3], [C3].concat(o7), u6);
                        if (r7)
                          return true;
                      } else if (r7.isQuantifier && u6 !== t7.matches[t7.matches.indexOf(r7) - 1])
                        for (var q2 = r7, z3 = i7.length > 0 ? i7.shift() : 0; z3 < (isNaN(q2.quantifier.max) ? z3 + 1 : q2.quantifier.max) && h4 <= e6; z3++) {
                          var W2 = t7.matches[t7.matches.indexOf(q2) - 1];
                          if (r7 = l6(W2, [z3].concat(o7), W2)) {
                            if ((a6 = m3[m3.length - 1].match).optionalQuantifier = z3 >= q2.quantifier.min, a6.jit = (z3 + 1) * (W2.matches.indexOf(a6) + 1) > q2.quantifier.jit, a6.optionalQuantifier && p6(a6, W2)) {
                              g3 = true, h4 = e6;
                              break;
                            }
                            return a6.jit && (s5.jitOffset[e6] = W2.matches.length - W2.matches.indexOf(a6)), true;
                          }
                        }
                      else if (r7 = y3(r7, i7, o7, u6))
                        return true;
                    } else
                      h4++;
                    var Q2, Z2;
                  }
                  for (var u5 = i7.length > 0 ? i7.shift() : 0; u5 < t7.matches.length; u5++)
                    if (t7.matches[u5].isQuantifier !== true) {
                      var p5 = l6(t7.matches[u5], [u5].concat(r6), o6);
                      if (p5 && h4 === e6)
                        return p5;
                      if (h4 > e6)
                        break;
                    }
                }
                if (e6 > -1) {
                  if (t6 === void 0) {
                    for (var b3, x3 = e6 - 1; (b3 = s5.validPositions[x3] || s5.tests[x3]) === void 0 && x3 > -1; )
                      x3--;
                    b3 !== void 0 && x3 > -1 && (v3 = function(e7, t7) {
                      var i7, a7 = [];
                      return Array.isArray(t7) || (t7 = [t7]), t7.length > 0 && (t7[0].alternation === void 0 || c5.keepStatic === true ? (a7 = u4.call(o5, e7, t7.slice()).locator.slice()).length === 0 && (a7 = t7[0].locator.slice()) : t7.forEach(function(e8) {
                        e8.def !== "" && (a7.length === 0 ? (i7 = e8.alternation, a7 = e8.locator.slice()) : e8.locator[i7] && a7[i7].toString().indexOf(e8.locator[i7]) === -1 && (a7[i7] += "," + e8.locator[i7]));
                      })), a7;
                    }(x3, b3), k3 = v3.join(""), h4 = x3);
                  }
                  if (s5.tests[e6] && s5.tests[e6][0].cd === k3)
                    return s5.tests[e6];
                  for (var P3 = v3.shift(); P3 < p4.length; P3++) {
                    if (y3(p4[P3], v3, [P3]) && h4 === e6 || h4 > e6)
                      break;
                  }
                }
                return (m3.length === 0 || g3) && m3.push({
                  match: {
                    fn: null,
                    static: true,
                    optionality: false,
                    casing: null,
                    def: "",
                    placeholder: ""
                  },
                  locator: [],
                  mloc: {},
                  cd: k3
                }), t6 !== void 0 && s5.tests[e6] ? r5 = l5.extend(true, [], m3) : (s5.tests[e6] = l5.extend(true, [], m3), r5 = s5.tests[e6]), m3.forEach(function(e7) {
                  e7.match.optionality = false;
                }), r5;
              }
            },
            7215: function(e5, t5, i5) {
              Object.defineProperty(t5, "__esModule", {
                value: true
              }), t5.alternate = s4, t5.checkAlternationMatch = function(e6, t6, i6) {
                for (var a6, n5 = this.opts.greedy ? t6 : t6.slice(0, 1), r5 = false, o5 = i6 !== void 0 ? i6.split(",") : [], l5 = 0; l5 < o5.length; l5++)
                  (a6 = e6.indexOf(o5[l5])) !== -1 && e6.splice(a6, 1);
                for (var s5 = 0; s5 < e6.length; s5++)
                  if (n5.includes(e6[s5])) {
                    r5 = true;
                    break;
                  }
                return r5;
              }, t5.handleRemove = function(e6, t6, i6, a6, l5) {
                var u5 = this, c5 = this.maskset, f4 = this.opts;
                if ((f4.numericInput || u5.isRTL) && (t6 === r4.default.BACKSPACE ? t6 = r4.default.DELETE : t6 === r4.default.DELETE && (t6 = r4.default.BACKSPACE), u5.isRTL)) {
                  var d5 = i6.end;
                  i6.end = i6.begin, i6.begin = d5;
                }
                var p5, h5 = o4.getLastValidPosition.call(u5, void 0, true);
                i6.end >= o4.getBuffer.call(u5).length && h5 >= i6.end && (i6.end = h5 + 1);
                t6 === r4.default.BACKSPACE ? i6.end - i6.begin < 1 && (i6.begin = o4.seekPrevious.call(u5, i6.begin)) : t6 === r4.default.DELETE && i6.begin === i6.end && (i6.end = o4.isMask.call(u5, i6.end, true, true) ? i6.end + 1 : o4.seekNext.call(u5, i6.end) + 1);
                if ((p5 = m3.call(u5, i6)) !== false) {
                  if (a6 !== true && f4.keepStatic !== false || f4.regex !== null && n4.getTest.call(u5, i6.begin).match.def.indexOf("|") !== -1) {
                    var v4 = s4.call(u5, true);
                    if (v4) {
                      var g3 = v4.caret !== void 0 ? v4.caret : v4.pos ? o4.seekNext.call(u5, v4.pos.begin ? v4.pos.begin : v4.pos) : o4.getLastValidPosition.call(u5, -1, true);
                      (t6 !== r4.default.DELETE || i6.begin > g3) && i6.begin;
                    }
                  }
                  a6 !== true && (c5.p = t6 === r4.default.DELETE ? i6.begin + p5 : i6.begin, c5.p = o4.determineNewCaretPosition.call(u5, {
                    begin: c5.p,
                    end: c5.p
                  }, false, f4.insertMode === false && t6 === r4.default.BACKSPACE ? "none" : void 0).begin);
                }
              }, t5.isComplete = c4, t5.isSelection = f3, t5.isValid = d4, t5.refreshFromBuffer = h4, t5.revalidateMask = m3;
              var a5, n4 = i5(4713), r4 = (a5 = i5(5581)) && a5.__esModule ? a5 : {
                default: a5
              }, o4 = i5(8711), l4 = i5(6030);
              function s4(e6, t6, i6, a6, r5, l5) {
                var u5, c5, f4, p5, h5, v4, m4, g3, k3, y3, b3, x3 = this, P3 = this.dependencyLib, E3 = this.opts, S3 = x3.maskset, _2 = P3.extend(true, {}, S3.validPositions), w3 = P3.extend(true, {}, S3.tests), M3 = false, O3 = false, T3 = r5 !== void 0 ? r5 : o4.getLastValidPosition.call(x3);
                if (l5 && (y3 = l5.begin, b3 = l5.end, l5.begin > l5.end && (y3 = l5.end, b3 = l5.begin)), T3 === -1 && r5 === void 0)
                  u5 = 0, c5 = (p5 = n4.getTest.call(x3, u5)).alternation;
                else
                  for (; T3 >= 0; T3--)
                    if ((f4 = S3.validPositions[T3]) && f4.alternation !== void 0) {
                      if (p5 && p5.locator[f4.alternation] !== f4.locator[f4.alternation])
                        break;
                      u5 = T3, c5 = S3.validPositions[u5].alternation, p5 = f4;
                    }
                if (c5 !== void 0) {
                  m4 = parseInt(u5), S3.excludes[m4] = S3.excludes[m4] || [], e6 !== true && S3.excludes[m4].push((0, n4.getDecisionTaker)(p5) + ":" + p5.alternation);
                  var C3 = [], A3 = -1;
                  for (h5 = m4; h5 < o4.getLastValidPosition.call(x3, void 0, true) + 1; h5++)
                    A3 === -1 && e6 <= h5 && t6 !== void 0 && (C3.push(t6), A3 = C3.length - 1), (v4 = S3.validPositions[h5]) && v4.generatedInput !== true && (l5 === void 0 || h5 < y3 || h5 >= b3) && C3.push(v4.input), delete S3.validPositions[h5];
                  for (A3 === -1 && t6 !== void 0 && (C3.push(t6), A3 = C3.length - 1); S3.excludes[m4] !== void 0 && S3.excludes[m4].length < 10; ) {
                    for (S3.tests = {}, o4.resetMaskSet.call(x3, true), M3 = true, h5 = 0; h5 < C3.length && (g3 = M3.caret || o4.getLastValidPosition.call(x3, void 0, true) + 1, k3 = C3[h5], M3 = d4.call(x3, g3, k3, false, a6, true)); h5++)
                      h5 === A3 && (O3 = M3), e6 == 1 && M3 && (O3 = {
                        caretPos: h5
                      });
                    if (M3)
                      break;
                    if (o4.resetMaskSet.call(x3), p5 = n4.getTest.call(x3, m4), S3.validPositions = P3.extend(true, {}, _2), S3.tests = P3.extend(true, {}, w3), !S3.excludes[m4]) {
                      O3 = s4.call(x3, e6, t6, i6, a6, m4 - 1, l5);
                      break;
                    }
                    var D3 = (0, n4.getDecisionTaker)(p5);
                    if (S3.excludes[m4].indexOf(D3 + ":" + p5.alternation) !== -1) {
                      O3 = s4.call(x3, e6, t6, i6, a6, m4 - 1, l5);
                      break;
                    }
                    for (S3.excludes[m4].push(D3 + ":" + p5.alternation), h5 = m4; h5 < o4.getLastValidPosition.call(x3, void 0, true) + 1; h5++)
                      delete S3.validPositions[h5];
                  }
                }
                return O3 && E3.keepStatic === false || delete S3.excludes[m4], O3;
              }
              function u4(e6, t6, i6) {
                var a6 = this.opts, n5 = this.maskset;
                switch (a6.casing || t6.casing) {
                  case "upper":
                    e6 = e6.toUpperCase();
                    break;
                  case "lower":
                    e6 = e6.toLowerCase();
                    break;
                  case "title":
                    var o5 = n5.validPositions[i6 - 1];
                    e6 = i6 === 0 || o5 && o5.input === String.fromCharCode(r4.default.SPACE) ? e6.toUpperCase() : e6.toLowerCase();
                    break;
                  default:
                    if (typeof a6.casing == "function") {
                      var l5 = Array.prototype.slice.call(arguments);
                      l5.push(n5.validPositions), e6 = a6.casing.apply(this, l5);
                    }
                }
                return e6;
              }
              function c4(e6) {
                var t6 = this, i6 = this.opts, a6 = this.maskset;
                if (typeof i6.isComplete == "function")
                  return i6.isComplete(e6, i6);
                if (i6.repeat !== "*") {
                  var r5 = false, l5 = o4.determineLastRequiredPosition.call(t6, true), s5 = o4.seekPrevious.call(t6, l5.l);
                  if (l5.def === void 0 || l5.def.newBlockMarker || l5.def.optionality || l5.def.optionalQuantifier) {
                    r5 = true;
                    for (var u5 = 0; u5 <= s5; u5++) {
                      var c5 = n4.getTestTemplate.call(t6, u5).match;
                      if (c5.static !== true && a6.validPositions[u5] === void 0 && c5.optionality !== true && c5.optionalQuantifier !== true || c5.static === true && e6[u5] !== n4.getPlaceholder.call(t6, u5, c5)) {
                        r5 = false;
                        break;
                      }
                    }
                  }
                  return r5;
                }
              }
              function f3(e6) {
                var t6 = this.opts.insertMode ? 0 : 1;
                return this.isRTL ? e6.begin - e6.end > t6 : e6.end - e6.begin > t6;
              }
              function d4(e6, t6, i6, a6, r5, l5, p5) {
                var g3 = this, k3 = this.dependencyLib, y3 = this.opts, b3 = g3.maskset;
                i6 = i6 === true;
                var x3 = e6;
                function P3(e7) {
                  if (e7 !== void 0) {
                    if (e7.remove !== void 0 && (Array.isArray(e7.remove) || (e7.remove = [e7.remove]), e7.remove.sort(function(e8, t8) {
                      return t8.pos - e8.pos;
                    }).forEach(function(e8) {
                      m3.call(g3, {
                        begin: e8,
                        end: e8 + 1
                      });
                    }), e7.remove = void 0), e7.insert !== void 0 && (Array.isArray(e7.insert) || (e7.insert = [e7.insert]), e7.insert.sort(function(e8, t8) {
                      return e8.pos - t8.pos;
                    }).forEach(function(e8) {
                      e8.c !== "" && d4.call(g3, e8.pos, e8.c, e8.strict === void 0 || e8.strict, e8.fromIsValid !== void 0 ? e8.fromIsValid : a6);
                    }), e7.insert = void 0), e7.refreshFromBuffer && e7.buffer) {
                      var t7 = e7.refreshFromBuffer;
                      h4.call(g3, t7 === true ? t7 : t7.start, t7.end, e7.buffer), e7.refreshFromBuffer = void 0;
                    }
                    e7.rewritePosition !== void 0 && (x3 = e7.rewritePosition, e7 = true);
                  }
                  return e7;
                }
                function E3(t7, i7, r6) {
                  var l6 = false;
                  return n4.getTests.call(g3, t7).every(function(s5, c5) {
                    var d5 = s5.match;
                    if (o4.getBuffer.call(g3, true), (l6 = (!d5.jit || b3.validPositions[o4.seekPrevious.call(g3, t7)] !== void 0) && (d5.fn != null ? d5.fn.test(i7, b3, t7, r6, y3, f3.call(g3, e6)) : (i7 === d5.def || i7 === y3.skipOptionalPartCharacter) && d5.def !== "" && {
                      c: n4.getPlaceholder.call(g3, t7, d5, true) || d5.def,
                      pos: t7
                    })) !== false) {
                      var p6 = l6.c !== void 0 ? l6.c : i7, h5 = t7;
                      return p6 = p6 === y3.skipOptionalPartCharacter && d5.static === true ? n4.getPlaceholder.call(g3, t7, d5, true) || d5.def : p6, (l6 = P3(l6)) !== true && l6.pos !== void 0 && l6.pos !== t7 && (h5 = l6.pos), l6 !== true && l6.pos === void 0 && l6.c === void 0 ? false : (m3.call(g3, e6, k3.extend({}, s5, {
                        input: u4.call(g3, p6, d5, h5)
                      }), a6, h5) === false && (l6 = false), false);
                    }
                    return true;
                  }), l6;
                }
                e6.begin !== void 0 && (x3 = g3.isRTL ? e6.end : e6.begin);
                var S3 = true, _2 = k3.extend(true, {}, b3.validPositions);
                if (y3.keepStatic === false && b3.excludes[x3] !== void 0 && r5 !== true && a6 !== true)
                  for (var w3 = x3; w3 < (g3.isRTL ? e6.begin : e6.end); w3++)
                    b3.excludes[w3] !== void 0 && (b3.excludes[w3] = void 0, delete b3.tests[w3]);
                if (typeof y3.preValidation == "function" && a6 !== true && l5 !== true && (S3 = P3(S3 = y3.preValidation.call(g3, o4.getBuffer.call(g3), x3, t6, f3.call(g3, e6), y3, b3, e6, i6 || r5))), S3 === true) {
                  if (S3 = E3(x3, t6, i6), (!i6 || a6 === true) && S3 === false && l5 !== true) {
                    var M3 = b3.validPositions[x3];
                    if (!M3 || M3.match.static !== true || M3.match.def !== t6 && t6 !== y3.skipOptionalPartCharacter) {
                      if (y3.insertMode || b3.validPositions[o4.seekNext.call(g3, x3)] === void 0 || e6.end > x3) {
                        var O3 = false;
                        if (b3.jitOffset[x3] && b3.validPositions[o4.seekNext.call(g3, x3)] === void 0 && (S3 = d4.call(g3, x3 + b3.jitOffset[x3], t6, true, true)) !== false && (r5 !== true && (S3.caret = x3), O3 = true), e6.end > x3 && (b3.validPositions[x3] = void 0), !O3 && !o4.isMask.call(g3, x3, y3.keepStatic && x3 === 0)) {
                          for (var T3 = x3 + 1, C3 = o4.seekNext.call(g3, x3, false, x3 !== 0); T3 <= C3; T3++)
                            if ((S3 = E3(T3, t6, i6)) !== false) {
                              S3 = v3.call(g3, x3, S3.pos !== void 0 ? S3.pos : T3) || S3, x3 = T3;
                              break;
                            }
                        }
                      }
                    } else
                      S3 = {
                        caret: o4.seekNext.call(g3, x3)
                      };
                  }
                  S3 !== false || !y3.keepStatic || !c4.call(g3, o4.getBuffer.call(g3)) && x3 !== 0 || i6 || r5 === true ? f3.call(g3, e6) && b3.tests[x3] && b3.tests[x3].length > 1 && y3.keepStatic && !i6 && r5 !== true && (S3 = s4.call(g3, true)) : S3 = s4.call(g3, x3, t6, i6, a6, void 0, e6), S3 === true && (S3 = {
                    pos: x3
                  });
                }
                if (typeof y3.postValidation == "function" && a6 !== true && l5 !== true) {
                  var A3 = y3.postValidation.call(g3, o4.getBuffer.call(g3, true), e6.begin !== void 0 ? g3.isRTL ? e6.end : e6.begin : e6, t6, S3, y3, b3, i6, p5);
                  A3 !== void 0 && (S3 = A3 === true ? S3 : A3);
                }
                S3 && S3.pos === void 0 && (S3.pos = x3), S3 === false || l5 === true ? (o4.resetMaskSet.call(g3, true), b3.validPositions = k3.extend(true, {}, _2)) : v3.call(g3, void 0, x3, true);
                var D3 = P3(S3);
                g3.maxLength !== void 0 && (o4.getBuffer.call(g3).length > g3.maxLength && !a6 && (o4.resetMaskSet.call(g3, true), b3.validPositions = k3.extend(true, {}, _2), D3 = false));
                return D3;
              }
              function p4(e6, t6, i6) {
                for (var a6 = this.maskset, r5 = false, o5 = n4.getTests.call(this, e6), l5 = 0; l5 < o5.length; l5++) {
                  if (o5[l5].match && (o5[l5].match.nativeDef === t6.match[i6.shiftPositions ? "def" : "nativeDef"] && (!i6.shiftPositions || !t6.match.static) || o5[l5].match.nativeDef === t6.match.nativeDef || i6.regex && !o5[l5].match.static && o5[l5].match.fn.test(t6.input))) {
                    r5 = true;
                    break;
                  }
                  if (o5[l5].match && o5[l5].match.def === t6.match.nativeDef) {
                    r5 = void 0;
                    break;
                  }
                }
                return r5 === false && a6.jitOffset[e6] !== void 0 && (r5 = p4.call(this, e6 + a6.jitOffset[e6], t6, i6)), r5;
              }
              function h4(e6, t6, i6) {
                var a6, n5, r5 = this, s5 = this.maskset, u5 = this.opts, c5 = this.dependencyLib, f4 = u5.skipOptionalPartCharacter, d5 = r5.isRTL ? i6.slice().reverse() : i6;
                if (u5.skipOptionalPartCharacter = "", e6 === true)
                  o4.resetMaskSet.call(r5), s5.tests = {}, e6 = 0, t6 = i6.length, n5 = o4.determineNewCaretPosition.call(r5, {
                    begin: 0,
                    end: 0
                  }, false).begin;
                else {
                  for (a6 = e6; a6 < t6; a6++)
                    delete s5.validPositions[a6];
                  n5 = e6;
                }
                var p5 = new c5.Event("keypress");
                for (a6 = e6; a6 < t6; a6++) {
                  p5.keyCode = d5[a6].toString().charCodeAt(0), r5.ignorable = false;
                  var h5 = l4.EventHandlers.keypressEvent.call(r5, p5, true, false, false, n5);
                  h5 !== false && h5 !== void 0 && (n5 = h5.forwardPosition);
                }
                u5.skipOptionalPartCharacter = f4;
              }
              function v3(e6, t6, i6) {
                var a6 = this, r5 = this.maskset, l5 = this.dependencyLib;
                if (e6 === void 0)
                  for (e6 = t6 - 1; e6 > 0 && !r5.validPositions[e6]; e6--)
                    ;
                for (var s5 = e6; s5 < t6; s5++) {
                  if (r5.validPositions[s5] === void 0 && !o4.isMask.call(a6, s5, false)) {
                    if (s5 == 0 ? n4.getTest.call(a6, s5) : r5.validPositions[s5 - 1]) {
                      var u5 = n4.getTests.call(a6, s5).slice();
                      u5[u5.length - 1].match.def === "" && u5.pop();
                      var c5, f4 = n4.determineTestTemplate.call(a6, s5, u5);
                      if (f4 && (f4.match.jit !== true || f4.match.newBlockMarker === "master" && (c5 = r5.validPositions[s5 + 1]) && c5.match.optionalQuantifier === true) && ((f4 = l5.extend({}, f4, {
                        input: n4.getPlaceholder.call(a6, s5, f4.match, true) || f4.match.def
                      })).generatedInput = true, m3.call(a6, s5, f4, true), i6 !== true)) {
                        var p5 = r5.validPositions[t6].input;
                        return r5.validPositions[t6] = void 0, d4.call(a6, t6, p5, true, true);
                      }
                    }
                  }
                }
              }
              function m3(e6, t6, i6, a6) {
                var r5 = this, l5 = this.maskset, s5 = this.opts, u5 = this.dependencyLib;
                function c5(e7, t7, i7) {
                  var a7 = t7[e7];
                  if (a7 !== void 0 && a7.match.static === true && a7.match.optionality !== true && (t7[0] === void 0 || t7[0].alternation === void 0)) {
                    var n5 = i7.begin <= e7 - 1 ? t7[e7 - 1] && t7[e7 - 1].match.static === true && t7[e7 - 1] : t7[e7 - 1], r6 = i7.end > e7 + 1 ? t7[e7 + 1] && t7[e7 + 1].match.static === true && t7[e7 + 1] : t7[e7 + 1];
                    return n5 && r6;
                  }
                  return false;
                }
                var f4 = 0, h5 = e6.begin !== void 0 ? e6.begin : e6, v4 = e6.end !== void 0 ? e6.end : e6, m4 = true;
                if (e6.begin > e6.end && (h5 = e6.end, v4 = e6.begin), a6 = a6 !== void 0 ? a6 : h5, h5 !== v4 || s5.insertMode && l5.validPositions[a6] !== void 0 && i6 === void 0 || t6 === void 0 || t6.match.optionalQuantifier || t6.match.optionality) {
                  var g3, k3 = u5.extend(true, {}, l5.validPositions), y3 = o4.getLastValidPosition.call(r5, void 0, true);
                  for (l5.p = h5, g3 = y3; g3 >= h5; g3--)
                    delete l5.validPositions[g3], t6 === void 0 && delete l5.tests[g3 + 1];
                  var b3, x3, P3 = a6, E3 = P3;
                  for (t6 && (l5.validPositions[a6] = u5.extend(true, {}, t6), E3++, P3++), g3 = t6 ? v4 : v4 - 1; g3 <= y3; g3++) {
                    if ((b3 = k3[g3]) !== void 0 && b3.generatedInput !== true && (g3 >= v4 || g3 >= h5 && c5(g3, k3, {
                      begin: h5,
                      end: v4
                    }))) {
                      for (; n4.getTest.call(r5, E3).match.def !== ""; ) {
                        if ((x3 = p4.call(r5, E3, b3, s5)) !== false || b3.match.def === "+") {
                          b3.match.def === "+" && o4.getBuffer.call(r5, true);
                          var S3 = d4.call(r5, E3, b3.input, b3.match.def !== "+", true);
                          if (m4 = S3 !== false, P3 = (S3.pos || E3) + 1, !m4 && x3)
                            break;
                        } else
                          m4 = false;
                        if (m4) {
                          t6 === void 0 && b3.match.static && g3 === e6.begin && f4++;
                          break;
                        }
                        if (!m4 && o4.getBuffer.call(r5), E3 > l5.maskLength)
                          break;
                        E3++;
                      }
                      n4.getTest.call(r5, E3).match.def == "" && (m4 = false), E3 = P3;
                    }
                    if (!m4)
                      break;
                  }
                  if (!m4)
                    return l5.validPositions = u5.extend(true, {}, k3), o4.resetMaskSet.call(r5, true), false;
                } else
                  t6 && n4.getTest.call(r5, a6).match.cd === t6.match.cd && (l5.validPositions[a6] = u5.extend(true, {}, t6));
                return o4.resetMaskSet.call(r5, true), f4;
              }
            },
            5581: function(e5) {
              e5.exports = JSON.parse('{"BACKSPACE":8,"BACKSPACE_SAFARI":127,"DELETE":46,"DOWN":40,"END":35,"ENTER":13,"ESCAPE":27,"HOME":36,"INSERT":45,"LEFT":37,"PAGE_DOWN":34,"PAGE_UP":33,"RIGHT":39,"SPACE":32,"TAB":9,"UP":38,"X":88,"Z":90,"CONTROL":17,"PAUSE/BREAK":19,"WINDOWS_LEFT":91,"WINDOWS_RIGHT":92,"KEY_229":229}');
            }
          }, t4 = {};
          function i4(a5) {
            var n4 = t4[a5];
            if (n4 !== void 0)
              return n4.exports;
            var r4 = t4[a5] = {
              exports: {}
            };
            return e4[a5](r4, r4.exports, i4), r4.exports;
          }
          var a4 = {};
          return function() {
            var e5, t5 = a4;
            Object.defineProperty(t5, "__esModule", {
              value: true
            }), t5.default = void 0, i4(3851), i4(219), i4(207), i4(5296);
            var n4 = ((e5 = i4(2394)) && e5.__esModule ? e5 : {
              default: e5
            }).default;
            t5.default = n4;
          }(), a4;
        }();
      });
    }
  });

  // node_modules/@fancyapps/ui/dist/carousel/carousel.esm.js
  var t = (t4, e4 = 1e4) => (t4 = parseFloat(t4 + "") || 0, Math.round((t4 + Number.EPSILON) * e4) / e4);
  var e = function(t4, i4) {
    return !(!t4 || t4 === document.body || i4 && t4 === i4) && (function(t5) {
      if (!(t5 && t5 instanceof Element && t5.offsetParent))
        return false;
      const e4 = t5.scrollHeight > t5.clientHeight, i5 = window.getComputedStyle(t5).overflowY, s4 = i5.indexOf("hidden") !== -1, n4 = i5.indexOf("visible") !== -1;
      return e4 && !s4 && !n4;
    }(t4) ? t4 : e(t4.parentElement, i4));
  };
  var i = function(t4) {
    var e4 = new DOMParser().parseFromString(t4, "text/html").body;
    if (e4.childElementCount > 1) {
      for (var i4 = document.createElement("div"); e4.firstChild; )
        i4.appendChild(e4.firstChild);
      return i4;
    }
    return e4.firstChild;
  };
  var s = (t4) => `${t4 || ""}`.split(" ").filter((t5) => !!t5);
  var n = (t4, e4, i4) => {
    s(e4).forEach((e5) => {
      t4 && t4.classList.toggle(e5, i4 || false);
    });
  };
  var o = class {
    constructor(t4) {
      Object.defineProperty(this, "pageX", { enumerable: true, configurable: true, writable: true, value: void 0 }), Object.defineProperty(this, "pageY", { enumerable: true, configurable: true, writable: true, value: void 0 }), Object.defineProperty(this, "clientX", { enumerable: true, configurable: true, writable: true, value: void 0 }), Object.defineProperty(this, "clientY", { enumerable: true, configurable: true, writable: true, value: void 0 }), Object.defineProperty(this, "id", { enumerable: true, configurable: true, writable: true, value: void 0 }), Object.defineProperty(this, "time", { enumerable: true, configurable: true, writable: true, value: void 0 }), Object.defineProperty(this, "nativePointer", { enumerable: true, configurable: true, writable: true, value: void 0 }), this.nativePointer = t4, this.pageX = t4.pageX, this.pageY = t4.pageY, this.clientX = t4.clientX, this.clientY = t4.clientY, this.id = self.Touch && t4 instanceof Touch ? t4.identifier : -1, this.time = Date.now();
    }
  };
  var a = { passive: false };
  var r = class {
    constructor(t4, { start: e4 = () => true, move: i4 = () => {
    }, end: s4 = () => {
    } }) {
      Object.defineProperty(this, "element", { enumerable: true, configurable: true, writable: true, value: void 0 }), Object.defineProperty(this, "startCallback", { enumerable: true, configurable: true, writable: true, value: void 0 }), Object.defineProperty(this, "moveCallback", { enumerable: true, configurable: true, writable: true, value: void 0 }), Object.defineProperty(this, "endCallback", { enumerable: true, configurable: true, writable: true, value: void 0 }), Object.defineProperty(this, "currentPointers", { enumerable: true, configurable: true, writable: true, value: [] }), Object.defineProperty(this, "startPointers", { enumerable: true, configurable: true, writable: true, value: [] }), this.element = t4, this.startCallback = e4, this.moveCallback = i4, this.endCallback = s4;
      for (const t5 of ["onPointerStart", "onTouchStart", "onMove", "onTouchEnd", "onPointerEnd", "onWindowBlur"])
        this[t5] = this[t5].bind(this);
      this.element.addEventListener("mousedown", this.onPointerStart, a), this.element.addEventListener("touchstart", this.onTouchStart, a), this.element.addEventListener("touchmove", this.onMove, a), this.element.addEventListener("touchend", this.onTouchEnd), this.element.addEventListener("touchcancel", this.onTouchEnd);
    }
    onPointerStart(t4) {
      if (!t4.buttons || t4.button !== 0)
        return;
      const e4 = new o(t4);
      this.currentPointers.some((t5) => t5.id === e4.id) || this.triggerPointerStart(e4, t4) && (window.addEventListener("mousemove", this.onMove), window.addEventListener("mouseup", this.onPointerEnd), window.addEventListener("blur", this.onWindowBlur));
    }
    onTouchStart(t4) {
      for (const e4 of Array.from(t4.changedTouches || []))
        this.triggerPointerStart(new o(e4), t4);
      window.addEventListener("blur", this.onWindowBlur);
    }
    onMove(t4) {
      const e4 = this.currentPointers.slice(), i4 = "changedTouches" in t4 ? Array.from(t4.changedTouches || []).map((t5) => new o(t5)) : [new o(t4)], s4 = [];
      for (const t5 of i4) {
        const e5 = this.currentPointers.findIndex((e6) => e6.id === t5.id);
        e5 < 0 || (s4.push(t5), this.currentPointers[e5] = t5);
      }
      s4.length && this.moveCallback(t4, this.currentPointers.slice(), e4);
    }
    onPointerEnd(t4) {
      t4.buttons > 0 && t4.button !== 0 || (this.triggerPointerEnd(t4, new o(t4)), window.removeEventListener("mousemove", this.onMove), window.removeEventListener("mouseup", this.onPointerEnd), window.removeEventListener("blur", this.onWindowBlur));
    }
    onTouchEnd(t4) {
      for (const e4 of Array.from(t4.changedTouches || []))
        this.triggerPointerEnd(t4, new o(e4));
    }
    triggerPointerStart(t4, e4) {
      return !!this.startCallback(e4, t4, this.currentPointers.slice()) && (this.currentPointers.push(t4), this.startPointers.push(t4), true);
    }
    triggerPointerEnd(t4, e4) {
      const i4 = this.currentPointers.findIndex((t5) => t5.id === e4.id);
      i4 < 0 || (this.currentPointers.splice(i4, 1), this.startPointers.splice(i4, 1), this.endCallback(t4, e4, this.currentPointers.slice()));
    }
    onWindowBlur() {
      this.clear();
    }
    clear() {
      for (; this.currentPointers.length; ) {
        const t4 = this.currentPointers[this.currentPointers.length - 1];
        this.currentPointers.splice(this.currentPointers.length - 1, 1), this.startPointers.splice(this.currentPointers.length - 1, 1), this.endCallback(new Event("touchend", { bubbles: true, cancelable: true, clientX: t4.clientX, clientY: t4.clientY }), t4, this.currentPointers.slice());
      }
    }
    stop() {
      this.element.removeEventListener("mousedown", this.onPointerStart, a), this.element.removeEventListener("touchstart", this.onTouchStart, a), this.element.removeEventListener("touchmove", this.onMove, a), this.element.removeEventListener("touchend", this.onTouchEnd), this.element.removeEventListener("touchcancel", this.onTouchEnd), window.removeEventListener("mousemove", this.onMove), window.removeEventListener("mouseup", this.onPointerEnd), window.removeEventListener("blur", this.onWindowBlur);
    }
  };
  function l(t4, e4) {
    return e4 ? Math.sqrt(Math.pow(e4.clientX - t4.clientX, 2) + Math.pow(e4.clientY - t4.clientY, 2)) : 0;
  }
  function h(t4, e4) {
    return e4 ? { clientX: (t4.clientX + e4.clientX) / 2, clientY: (t4.clientY + e4.clientY) / 2 } : t4;
  }
  var c = (t4) => typeof t4 == "object" && t4 !== null && t4.constructor === Object && Object.prototype.toString.call(t4) === "[object Object]";
  var d = (t4, ...e4) => {
    const i4 = e4.length;
    for (let s4 = 0; s4 < i4; s4++) {
      const i5 = e4[s4] || {};
      Object.entries(i5).forEach(([e5, i6]) => {
        const s5 = Array.isArray(i6) ? [] : {};
        t4[e5] || Object.assign(t4, { [e5]: s5 }), c(i6) ? Object.assign(t4[e5], d(s5, i6)) : Array.isArray(i6) ? Object.assign(t4, { [e5]: [...i6] }) : Object.assign(t4, { [e5]: i6 });
      });
    }
    return t4;
  };
  var u = function(t4, e4) {
    return t4.split(".").reduce((t5, e5) => typeof t5 == "object" ? t5[e5] : void 0, e4);
  };
  var g = class {
    constructor(t4 = {}) {
      Object.defineProperty(this, "options", { enumerable: true, configurable: true, writable: true, value: t4 }), Object.defineProperty(this, "events", { enumerable: true, configurable: true, writable: true, value: new Map() }), this.setOptions(t4);
      for (const t5 of Object.getOwnPropertyNames(Object.getPrototypeOf(this)))
        t5.startsWith("on") && typeof this[t5] == "function" && (this[t5] = this[t5].bind(this));
    }
    setOptions(t4) {
      this.options = t4 ? d({}, this.constructor.defaults, t4) : {};
      for (const [t5, e4] of Object.entries(this.option("on") || {}))
        this.on(t5, e4);
    }
    option(t4, ...e4) {
      let i4 = u(t4, this.options);
      return i4 && typeof i4 == "function" && (i4 = i4.call(this, this, ...e4)), i4;
    }
    optionFor(t4, e4, i4, ...s4) {
      let n4 = u(e4, t4);
      var o4;
      typeof (o4 = n4) != "string" || isNaN(o4) || isNaN(parseFloat(o4)) || (n4 = parseFloat(n4)), n4 === "true" && (n4 = true), n4 === "false" && (n4 = false), n4 && typeof n4 == "function" && (n4 = n4.call(this, this, t4, ...s4));
      let a4 = u(e4, this.options);
      return a4 && typeof a4 == "function" ? n4 = a4.call(this, this, t4, ...s4, n4) : n4 === void 0 && (n4 = a4), n4 === void 0 ? i4 : n4;
    }
    cn(t4) {
      const e4 = this.options.classes;
      return e4 && e4[t4] || "";
    }
    localize(t4, e4 = []) {
      t4 = String(t4).replace(/\{\{(\w+).?(\w+)?\}\}/g, (t5, e5, i4) => {
        let s4 = "";
        return i4 ? s4 = this.option(`${e5[0] + e5.toLowerCase().substring(1)}.l10n.${i4}`) : e5 && (s4 = this.option(`l10n.${e5}`)), s4 || (s4 = t5), s4;
      });
      for (let i4 = 0; i4 < e4.length; i4++)
        t4 = t4.split(e4[i4][0]).join(e4[i4][1]);
      return t4 = t4.replace(/\{\{(.*?)\}\}/g, (t5, e5) => e5);
    }
    on(t4, e4) {
      let i4 = [];
      typeof t4 == "string" ? i4 = t4.split(" ") : Array.isArray(t4) && (i4 = t4), this.events || (this.events = new Map()), i4.forEach((t5) => {
        let i5 = this.events.get(t5);
        i5 || (this.events.set(t5, []), i5 = []), i5.includes(e4) || i5.push(e4), this.events.set(t5, i5);
      });
    }
    off(t4, e4) {
      let i4 = [];
      typeof t4 == "string" ? i4 = t4.split(" ") : Array.isArray(t4) && (i4 = t4), i4.forEach((t5) => {
        const i5 = this.events.get(t5);
        if (Array.isArray(i5)) {
          const t6 = i5.indexOf(e4);
          t6 > -1 && i5.splice(t6, 1);
        }
      });
    }
    emit(t4, ...e4) {
      [...this.events.get(t4) || []].forEach((t5) => t5(this, ...e4)), t4 !== "*" && this.emit("*", t4, ...e4);
    }
  };
  Object.defineProperty(g, "version", { enumerable: true, configurable: true, writable: true, value: "5.0.19" }), Object.defineProperty(g, "defaults", { enumerable: true, configurable: true, writable: true, value: {} });
  var p = class extends g {
    constructor(t4 = {}) {
      super(t4), Object.defineProperty(this, "plugins", { enumerable: true, configurable: true, writable: true, value: {} });
    }
    attachPlugins(t4 = {}) {
      const e4 = new Map();
      for (const [i4, s4] of Object.entries(t4)) {
        const t5 = this.option(i4), n4 = this.plugins[i4];
        n4 || t5 === false ? n4 && t5 === false && (n4.detach(), delete this.plugins[i4]) : e4.set(i4, new s4(this, t5 || {}));
      }
      for (const [t5, i4] of e4)
        this.plugins[t5] = i4, i4.attach();
      this.emit("attachPlugins");
    }
    detachPlugins(t4) {
      t4 = t4 || Object.keys(this.plugins);
      for (const e4 of t4) {
        const t5 = this.plugins[e4];
        t5 && t5.detach(), delete this.plugins[e4];
      }
      return this.emit("detachPlugins"), this;
    }
  };
  var f;
  !function(t4) {
    t4[t4.Init = 0] = "Init", t4[t4.Error = 1] = "Error", t4[t4.Ready = 2] = "Ready", t4[t4.Panning = 3] = "Panning", t4[t4.Mousemove = 4] = "Mousemove", t4[t4.Destroy = 5] = "Destroy";
  }(f || (f = {}));
  var m = ["a", "b", "c", "d", "e", "f"];
  var b = {
    content: null,
    width: "auto",
    height: "auto",
    panMode: "drag",
    touch: true,
    dragMinThreshold: 3,
    lockAxis: false,
    mouseMoveFactor: 1,
    mouseMoveFriction: 0.12,
    zoom: true,
    pinchToZoom: true,
    panOnlyZoomed: "auto",
    minScale: 1,
    maxScale: 2,
    friction: 0.25,
    dragFriction: 0.35,
    decelFriction: 0.05,
    click: "toggleZoom",
    dblClick: false,
    wheel: "zoom",
    wheelLimit: 70,
    spinner: true,
    bounds: "auto",
    infinite: true,
    // loop: true,
    slidesToShow: 5,
    rubberband: true,
    bounce: true,
    maxVelocity: 75,
    transformParent: false,
    classes: {
      content: "f-panzoom__content",
      isLoading: "is-loading",
      canZoomIn: "can-zoom_in",
      canZoomOut: "can-zoom_out",
      isDraggable: "is-draggable",
      isDragging: "is-dragging",
      inFullscreen: "in-fullscreen",
      htmlHasFullscreen: "with-panzoom-in-fullscreen"
    },
    l10n: {
      PANUP: "Move up",
      PANDOWN: "Move down",
      PANLEFT: "Move left",
      PANRIGHT: "Move right",
      ZOOMIN: "Zoom in",
      ZOOMOUT: "Zoom out",
      TOGGLEZOOM: "Toggle zoom level",
      TOGGLE1TO1: "Toggle zoom level",
      ITERATEZOOM: "Toggle zoom level",
      ROTATECCW: "Rotate counterclockwise",
      ROTATECW: "Rotate clockwise",
      FLIPX: "Flip horizontally",
      FLIPY: "Flip vertically",
      FITX: "Fit horizontally",
      FITY: "Fit vertically",
      RESET: "Reset",
      TOGGLEFS: "Toggle fullscreen"
    }
  };
  var v = '<div class="f-spinner"><svg viewBox="0 0 50 50"><circle cx="25" cy="25" r="20"></circle><circle cx="25" cy="25" r="20"></circle></svg></div>';
  var y = (t4) => t4 && t4 !== null && t4 instanceof Element && "nodeType" in t4;
  var x = (t4, e4) => {
    t4 && s(e4).forEach((e5) => {
      t4.classList.remove(e5);
    });
  };
  var w = (t4, e4) => {
    t4 && s(e4).forEach((e5) => {
      t4.classList.add(e5);
    });
  };
  var P = { a: 1, b: 0, c: 0, d: 1, e: 0, f: 0 };
  var T = null;
  var S = null;
  var M = class extends p {
    get isTouchDevice() {
      return S === null && (S = window.matchMedia("(hover: none)").matches), S;
    }
    get isMobile() {
      return T === null && (T = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent)), T;
    }
    get panMode() {
      return this.options.panMode !== "mousemove" || this.isTouchDevice ? "drag" : "mousemove";
    }
    get panOnlyZoomed() {
      const t4 = this.options.panOnlyZoomed;
      return t4 === "auto" ? this.isTouchDevice : t4;
    }
    get isInfinite() {
      return this.option("infinite");
    }
    get angle() {
      return 180 * Math.atan2(this.current.b, this.current.a) / Math.PI || 0;
    }
    get targetAngle() {
      return 180 * Math.atan2(this.target.b, this.target.a) / Math.PI || 0;
    }
    get scale() {
      const { a: t4, b: e4 } = this.current;
      return Math.sqrt(t4 * t4 + e4 * e4) || 1;
    }
    get targetScale() {
      const { a: t4, b: e4 } = this.target;
      return Math.sqrt(t4 * t4 + e4 * e4) || 1;
    }
    get minScale() {
      return this.option("minScale") || 1;
    }
    get fullScale() {
      const { contentRect: t4 } = this;
      return t4.fullWidth / t4.fitWidth || 1;
    }
    get maxScale() {
      return this.fullScale * (this.option("maxScale") || 1) || 1;
    }
    get coverScale() {
      const { containerRect: t4, contentRect: e4 } = this, i4 = Math.max(t4.height / e4.fitHeight, t4.width / e4.fitWidth) || 1;
      return Math.min(this.fullScale, i4);
    }
    get isScaling() {
      return Math.abs(this.targetScale - this.scale) > 1e-5 && !this.isResting;
    }
    get isContentLoading() {
      const t4 = this.content;
      return !!(t4 && t4 instanceof HTMLImageElement) && !t4.complete;
    }
    get isResting() {
      if (this.isBouncingX || this.isBouncingY)
        return false;
      for (const t4 of m) {
        const e4 = t4 == "e" || t4 === "f" ? 1e-3 : 1e-5;
        if (Math.abs(this.target[t4] - this.current[t4]) > e4)
          return false;
      }
      return !(!this.ignoreBounds && !this.checkBounds().inBounds);
    }
    constructor(t4, e4 = {}, s4 = {}) {
      var n4;
      if (super(e4), Object.defineProperty(this, "pointerTracker", { enumerable: true, configurable: true, writable: true, value: null }), Object.defineProperty(this, "resizeObserver", { enumerable: true, configurable: true, writable: true, value: null }), Object.defineProperty(this, "updateTimer", { enumerable: true, configurable: true, writable: true, value: null }), Object.defineProperty(this, "clickTimer", { enumerable: true, configurable: true, writable: true, value: null }), Object.defineProperty(this, "rAF", { enumerable: true, configurable: true, writable: true, value: null }), Object.defineProperty(this, "isTicking", { enumerable: true, configurable: true, writable: true, value: false }), Object.defineProperty(this, "friction", { enumerable: true, configurable: true, writable: true, value: 0 }), Object.defineProperty(this, "ignoreBounds", { enumerable: true, configurable: true, writable: true, value: false }), Object.defineProperty(this, "isBouncingX", { enumerable: true, configurable: true, writable: true, value: false }), Object.defineProperty(this, "isBouncingY", { enumerable: true, configurable: true, writable: true, value: false }), Object.defineProperty(this, "clicks", { enumerable: true, configurable: true, writable: true, value: 0 }), Object.defineProperty(this, "trackingPoints", { enumerable: true, configurable: true, writable: true, value: [] }), Object.defineProperty(this, "pwt", { enumerable: true, configurable: true, writable: true, value: 0 }), Object.defineProperty(this, "cwd", { enumerable: true, configurable: true, writable: true, value: 0 }), Object.defineProperty(this, "pmme", { enumerable: true, configurable: true, writable: true, value: void 0 }), Object.defineProperty(this, "state", { enumerable: true, configurable: true, writable: true, value: f.Init }), Object.defineProperty(this, "isDragging", { enumerable: true, configurable: true, writable: true, value: false }), Object.defineProperty(this, "container", { enumerable: true, configurable: true, writable: true, value: void 0 }), Object.defineProperty(this, "content", { enumerable: true, configurable: true, writable: true, value: void 0 }), Object.defineProperty(this, "spinner", { enumerable: true, configurable: true, writable: true, value: null }), Object.defineProperty(this, "containerRect", { enumerable: true, configurable: true, writable: true, value: { width: 0, height: 0, innerWidth: 0, innerHeight: 0 } }), Object.defineProperty(this, "contentRect", { enumerable: true, configurable: true, writable: true, value: { top: 0, right: 0, bottom: 0, left: 0, fullWidth: 0, fullHeight: 0, fitWidth: 0, fitHeight: 0, width: 0, height: 0 } }), Object.defineProperty(this, "dragStart", { enumerable: true, configurable: true, writable: true, value: { x: 0, y: 0, top: 0, left: 0, time: 0 } }), Object.defineProperty(this, "dragOffset", { enumerable: true, configurable: true, writable: true, value: { x: 0, y: 0, time: 0 } }), Object.defineProperty(this, "current", { enumerable: true, configurable: true, writable: true, value: Object.assign({}, P) }), Object.defineProperty(this, "target", { enumerable: true, configurable: true, writable: true, value: Object.assign({}, P) }), Object.defineProperty(this, "velocity", { enumerable: true, configurable: true, writable: true, value: { a: 0, b: 0, c: 0, d: 0, e: 0, f: 0 } }), Object.defineProperty(this, "lockedAxis", { enumerable: true, configurable: true, writable: true, value: false }), !t4)
        throw new Error("Container Element Not Found");
      this.container = t4, this.initContent(), this.attachPlugins(Object.assign(Object.assign({}, M.Plugins), s4)), this.emit("init");
      const o4 = this.content;
      if (o4.addEventListener("load", this.onLoad), o4.addEventListener("error", this.onError), this.isContentLoading) {
        if (this.option("spinner")) {
          t4.classList.add(this.cn("isLoading"));
          const e5 = i(v);
          !t4.contains(o4) || o4.parentElement instanceof HTMLPictureElement ? this.spinner = t4.appendChild(e5) : this.spinner = ((n4 = o4.parentElement) === null || n4 === void 0 ? void 0 : n4.insertBefore(e5, o4)) || null;
        }
        this.emit("beforeLoad");
      } else
        queueMicrotask(() => {
          this.enable();
        });
    }
    initContent() {
      const { container: t4 } = this, e4 = this.cn("content");
      let i4 = this.option("content") || t4.querySelector(`.${e4}`);
      if (i4 || (i4 = t4.querySelector("img,picture") || t4.firstElementChild, i4 && w(i4, e4)), i4 instanceof HTMLPictureElement && (i4 = i4.querySelector("img")), !i4)
        throw new Error("No content found");
      this.content = i4;
    }
    onLoad() {
      this.spinner && (this.spinner.remove(), this.spinner = null), this.option("spinner") && this.container.classList.remove(this.cn("isLoading")), this.emit("afterLoad"), this.state === f.Init ? this.enable() : this.updateMetrics();
    }
    onError() {
      this.state !== f.Destroy && (this.spinner && (this.spinner.remove(), this.spinner = null), this.stop(), this.detachEvents(), this.state = f.Error, this.emit("error"));
    }
    attachObserver() {
      var t4;
      const e4 = () => Math.abs(this.containerRect.width - this.container.getBoundingClientRect().width) > 0.1 || Math.abs(this.containerRect.height - this.container.getBoundingClientRect().height) > 0.1;
      this.resizeObserver || window.ResizeObserver === void 0 || (this.resizeObserver = new ResizeObserver(() => {
        this.updateTimer || (e4() ? (this.onResize(), this.isMobile && (this.updateTimer = setTimeout(() => {
          e4() && this.onResize(), this.updateTimer = null;
        }, 500))) : this.updateTimer && (clearTimeout(this.updateTimer), this.updateTimer = null));
      })), (t4 = this.resizeObserver) === null || t4 === void 0 || t4.observe(this.container);
    }
    detachObserver() {
      var t4;
      (t4 = this.resizeObserver) === null || t4 === void 0 || t4.disconnect();
    }
    attachEvents() {
      const { container: t4 } = this;
      t4.addEventListener("click", this.onClick, { passive: false, capture: false }), t4.addEventListener("wheel", this.onWheel, { passive: false }), this.pointerTracker = new r(t4, { start: this.onPointerDown, move: this.onPointerMove, end: this.onPointerUp }), document.addEventListener("mousemove", this.onMouseMove);
    }
    detachEvents() {
      var t4;
      const { container: e4 } = this;
      e4.removeEventListener("click", this.onClick, { passive: false, capture: false }), e4.removeEventListener("wheel", this.onWheel, { passive: false }), (t4 = this.pointerTracker) === null || t4 === void 0 || t4.stop(), this.pointerTracker = null, document.removeEventListener("mousemove", this.onMouseMove), document.removeEventListener("keydown", this.onKeydown, true), this.clickTimer && (clearTimeout(this.clickTimer), this.clickTimer = null), this.updateTimer && (clearTimeout(this.updateTimer), this.updateTimer = null);
    }
    animate() {
      const t4 = this.friction;
      this.setTargetForce();
      const e4 = this.option("maxVelocity");
      for (const i4 of m)
        t4 ? (this.velocity[i4] *= 1 - t4, e4 && !this.isScaling && (this.velocity[i4] = Math.max(Math.min(this.velocity[i4], e4), -1 * e4)), this.current[i4] += this.velocity[i4]) : this.current[i4] = this.target[i4];
      this.setTransform(), this.setEdgeForce(), !this.isResting || this.isDragging ? this.rAF = requestAnimationFrame(() => this.animate()) : this.stop("current");
    }
    setTargetForce() {
      for (const t4 of m)
        t4 === "e" && this.isBouncingX || t4 === "f" && this.isBouncingY || (this.velocity[t4] = (1 / (1 - this.friction) - 1) * (this.target[t4] - this.current[t4]));
    }
    checkBounds(t4 = 0, e4 = 0) {
      const { current: i4 } = this, s4 = i4.e + t4, n4 = i4.f + e4, o4 = this.getBounds(), { x: a4, y: r4 } = o4, l4 = a4.min, h4 = a4.max, c4 = r4.min, d4 = r4.max;
      let u4 = 0, g3 = 0;
      return l4 !== 1 / 0 && s4 < l4 ? u4 = l4 - s4 : h4 !== 1 / 0 && s4 > h4 && (u4 = h4 - s4), c4 !== 1 / 0 && n4 < c4 ? g3 = c4 - n4 : d4 !== 1 / 0 && n4 > d4 && (g3 = d4 - n4), Math.abs(u4) < 1e-3 && (u4 = 0), Math.abs(g3) < 1e-3 && (g3 = 0), Object.assign(Object.assign({}, o4), { xDiff: u4, yDiff: g3, inBounds: !u4 && !g3 });
    }
    clampTargetBounds() {
      const { target: t4 } = this, { x: e4, y: i4 } = this.getBounds();
      e4.min !== 1 / 0 && (t4.e = Math.max(t4.e, e4.min)), e4.max !== 1 / 0 && (t4.e = Math.min(t4.e, e4.max)), i4.min !== 1 / 0 && (t4.f = Math.max(t4.f, i4.min)), i4.max !== 1 / 0 && (t4.f = Math.min(t4.f, i4.max));
    }
    calculateContentDim(t4 = this.current) {
      const { content: e4, contentRect: i4 } = this, { fitWidth: s4, fitHeight: n4, fullWidth: o4, fullHeight: a4 } = i4;
      let r4 = o4, l4 = a4;
      if (this.option("zoom") || this.angle !== 0) {
        const i5 = !(e4 instanceof HTMLImageElement) && (window.getComputedStyle(e4).maxWidth === "none" || window.getComputedStyle(e4).maxHeight === "none"), h4 = i5 ? o4 : s4, c4 = i5 ? a4 : n4, d4 = this.getMatrix(t4), u4 = new DOMPoint(0, 0).matrixTransform(d4), g3 = new DOMPoint(0 + h4, 0).matrixTransform(d4), p4 = new DOMPoint(0 + h4, 0 + c4).matrixTransform(d4), f3 = new DOMPoint(0, 0 + c4).matrixTransform(d4), m3 = Math.abs(p4.x - u4.x), b3 = Math.abs(p4.y - u4.y), v3 = Math.abs(f3.x - g3.x), y3 = Math.abs(f3.y - g3.y);
        r4 = Math.max(m3, v3), l4 = Math.max(b3, y3);
      }
      return { contentWidth: r4, contentHeight: l4 };
    }
    setEdgeForce() {
      if (this.ignoreBounds || this.isDragging || this.panMode === "mousemove" || this.targetScale < this.scale)
        return this.isBouncingX = false, void (this.isBouncingY = false);
      const { target: t4 } = this, { x: e4, y: i4, xDiff: s4, yDiff: n4 } = this.checkBounds();
      const o4 = this.option("maxVelocity");
      let a4 = this.velocity.e, r4 = this.velocity.f;
      s4 !== 0 ? (this.isBouncingX = true, s4 * a4 <= 0 ? a4 += 0.14 * s4 : (a4 = 0.14 * s4, e4.min !== 1 / 0 && (this.target.e = Math.max(t4.e, e4.min)), e4.max !== 1 / 0 && (this.target.e = Math.min(t4.e, e4.max))), o4 && (a4 = Math.max(Math.min(a4, o4), -1 * o4))) : this.isBouncingX = false, n4 !== 0 ? (this.isBouncingY = true, n4 * r4 <= 0 ? r4 += 0.14 * n4 : (r4 = 0.14 * n4, i4.min !== 1 / 0 && (this.target.f = Math.max(t4.f, i4.min)), i4.max !== 1 / 0 && (this.target.f = Math.min(t4.f, i4.max))), o4 && (r4 = Math.max(Math.min(r4, o4), -1 * o4))) : this.isBouncingY = false, this.isBouncingX && (this.velocity.e = a4), this.isBouncingY && (this.velocity.f = r4);
    }
    enable() {
      const { content: t4 } = this, e4 = new DOMMatrixReadOnly(window.getComputedStyle(t4).transform);
      for (const t5 of m)
        this.current[t5] = this.target[t5] = e4[t5];
      this.updateMetrics(), this.attachObserver(), this.attachEvents(), this.state = f.Ready, this.emit("ready");
    }
    onClick(t4) {
      var e4;
      this.isDragging && ((e4 = this.pointerTracker) === null || e4 === void 0 || e4.clear(), this.trackingPoints = [], this.startDecelAnim());
      const i4 = t4.target;
      if (!i4 || t4.defaultPrevented)
        return;
      if (i4 && i4.hasAttribute("disabled"))
        return t4.preventDefault(), void t4.stopPropagation();
      if ((() => {
        const t5 = window.getSelection();
        return t5 && t5.type === "Range";
      })() && !i4.closest("button"))
        return;
      const s4 = i4.closest("[data-panzoom-action]"), n4 = i4.closest("[data-panzoom-change]"), o4 = s4 || n4, a4 = o4 && y(o4) ? o4.dataset : null;
      if (a4) {
        const e5 = a4.panzoomChange, i5 = a4.panzoomAction;
        if ((e5 || i5) && t4.preventDefault(), e5) {
          let t5 = {};
          try {
            t5 = JSON.parse(e5);
          } catch (t6) {
            console && console.warn("The given data was not valid JSON");
          }
          return void this.applyChange(t5);
        }
        if (i5)
          return void (this[i5] && this[i5]());
      }
      if (Math.abs(this.dragOffset.x) > 3 || Math.abs(this.dragOffset.y) > 3)
        return t4.preventDefault(), void t4.stopPropagation();
      const r4 = this.content.getBoundingClientRect();
      if (this.dragStart.time && !this.canZoomOut() && (Math.abs(r4.x - this.dragStart.x) > 2 || Math.abs(r4.y - this.dragStart.y) > 2))
        return;
      this.dragStart.time = 0;
      const l4 = (e5) => {
        this.option("zoom") && e5 && typeof e5 == "string" && /(iterateZoom)|(toggle(Zoom|Full|Cover|Max)|(zoomTo(Fit|Cover|Max)))/.test(e5) && typeof this[e5] == "function" && (t4.preventDefault(), this[e5]({ event: t4 }));
      }, h4 = this.option("click", t4), c4 = this.option("dblClick", t4);
      c4 ? (this.clicks++, this.clicks == 1 && (this.clickTimer = setTimeout(() => {
        this.clicks === 1 ? (this.emit("click", t4), !t4.defaultPrevented && h4 && l4(h4)) : (this.emit("dblClick", t4), t4.defaultPrevented || l4(c4)), this.clicks = 0, this.clickTimer = null;
      }, 350))) : (this.emit("click", t4), !t4.defaultPrevented && h4 && l4(h4));
    }
    addTrackingPoint(t4) {
      const e4 = this.trackingPoints.filter((t5) => t5.time > Date.now() - 100);
      e4.push(t4), this.trackingPoints = e4;
    }
    onPointerDown(t4, e4, i4) {
      var s4;
      this.pwt = 0, this.dragOffset = { x: 0, y: 0, time: 0 }, this.trackingPoints = [];
      const n4 = this.content.getBoundingClientRect();
      if (this.dragStart = { x: n4.x, y: n4.y, top: n4.top, left: n4.left, time: Date.now() }, this.clickTimer)
        return false;
      if (this.panMode === "mousemove" && this.targetScale > 1)
        return t4.preventDefault(), t4.stopPropagation(), false;
      if (!i4.length) {
        const e5 = t4.composedPath()[0];
        if (["A", "TEXTAREA", "OPTION", "INPUT", "SELECT", "VIDEO"].includes(e5.nodeName) || e5.closest("[contenteditable]") || e5.closest("[data-selectable]") || e5.closest("[data-draggable]") || e5.closest("[data-panzoom-change]") || e5.closest("[data-panzoom-action]"))
          return false;
        (s4 = window.getSelection()) === null || s4 === void 0 || s4.removeAllRanges();
      }
      if (t4.type === "mousedown")
        t4.preventDefault();
      else if (Math.abs(this.velocity.a) > 0.3)
        return false;
      return this.target.e = this.current.e, this.target.f = this.current.f, this.stop(), this.isDragging || (this.isDragging = true, this.addTrackingPoint(e4), this.emit("touchStart", t4)), true;
    }
    onPointerMove(i4, s4, n4) {
      if (this.option("touch", i4) === false)
        return;
      if (!this.isDragging)
        return;
      if (s4.length < 2 && this.panOnlyZoomed && t(this.targetScale) <= t(this.minScale))
        return;
      if (this.emit("touchMove", i4), i4.defaultPrevented)
        return;
      this.addTrackingPoint(s4[0]);
      const { content: o4 } = this, a4 = h(n4[0], n4[1]), r4 = h(s4[0], s4[1]);
      let c4 = 0, d4 = 0;
      if (s4.length > 1) {
        const t4 = o4.getBoundingClientRect();
        c4 = a4.clientX - t4.left - 0.5 * t4.width, d4 = a4.clientY - t4.top - 0.5 * t4.height;
      }
      const u4 = l(n4[0], n4[1]), g3 = l(s4[0], s4[1]);
      let p4 = u4 ? g3 / u4 : 1, f3 = r4.clientX - a4.clientX, m3 = r4.clientY - a4.clientY;
      this.dragOffset.x += f3, this.dragOffset.y += m3, this.dragOffset.time = Date.now() - this.dragStart.time;
      let b3 = t(this.targetScale) === t(this.minScale) && this.option("lockAxis");
      if (b3 && !this.lockedAxis)
        if (b3 === "xy" || b3 === "y" || i4.type === "touchmove") {
          if (Math.abs(this.dragOffset.x) < 6 && Math.abs(this.dragOffset.y) < 6)
            return void i4.preventDefault();
          const t4 = Math.abs(180 * Math.atan2(this.dragOffset.y, this.dragOffset.x) / Math.PI);
          this.lockedAxis = t4 > 45 && t4 < 135 ? "y" : "x", this.dragOffset.x = 0, this.dragOffset.y = 0, f3 = 0, m3 = 0;
        } else
          this.lockedAxis = b3;
      if (e(i4.target, this.content) && (b3 = "x", this.dragOffset.y = 0), b3 && b3 !== "xy" && this.lockedAxis !== b3 && t(this.targetScale) === t(this.minScale))
        return;
      i4.cancelable && i4.preventDefault(), this.container.classList.add(this.cn("isDragging"));
      const v3 = this.checkBounds(f3, m3);
      this.option("rubberband") ? (this.isInfinite !== "x" && (v3.xDiff > 0 && f3 < 0 || v3.xDiff < 0 && f3 > 0) && (f3 *= Math.max(0, 0.5 - Math.abs(0.75 / this.contentRect.fitWidth * v3.xDiff))), this.isInfinite !== "y" && (v3.yDiff > 0 && m3 < 0 || v3.yDiff < 0 && m3 > 0) && (m3 *= Math.max(0, 0.5 - Math.abs(0.75 / this.contentRect.fitHeight * v3.yDiff)))) : (v3.xDiff && (f3 = 0), v3.yDiff && (m3 = 0));
      const y3 = this.targetScale, x3 = this.minScale, w3 = this.maxScale;
      y3 < 0.5 * x3 && (p4 = Math.max(p4, x3)), y3 > 1.5 * w3 && (p4 = Math.min(p4, w3)), this.lockedAxis === "y" && t(y3) === t(x3) && (f3 = 0), this.lockedAxis === "x" && t(y3) === t(x3) && (m3 = 0), this.applyChange({ originX: c4, originY: d4, panX: f3, panY: m3, scale: p4, friction: this.option("dragFriction"), ignoreBounds: true });
    }
    onPointerUp(t4, i4, s4) {
      if (s4.length)
        return this.dragOffset.x = 0, this.dragOffset.y = 0, void (this.trackingPoints = []);
      this.container.classList.remove(this.cn("isDragging")), this.isDragging && (this.addTrackingPoint(i4), this.panOnlyZoomed && this.contentRect.width - this.contentRect.fitWidth < 1 && this.contentRect.height - this.contentRect.fitHeight < 1 && (this.trackingPoints = []), e(t4.target, this.content) && this.lockedAxis === "y" && (this.trackingPoints = []), this.emit("touchEnd", t4), this.isDragging = false, this.lockedAxis = false, this.state !== f.Destroy && (t4.defaultPrevented || this.startDecelAnim()));
    }
    startDecelAnim() {
      var e4;
      const i4 = this.isScaling;
      this.rAF && (cancelAnimationFrame(this.rAF), this.rAF = null), this.isBouncingX = false, this.isBouncingY = false;
      for (const t4 of m)
        this.velocity[t4] = 0;
      this.target.e = this.current.e, this.target.f = this.current.f, x(this.container, "is-scaling"), x(this.container, "is-animating"), this.isTicking = false;
      const { trackingPoints: s4 } = this, n4 = s4[0], o4 = s4[s4.length - 1];
      let a4 = 0, r4 = 0, l4 = 0;
      o4 && n4 && (a4 = o4.clientX - n4.clientX, r4 = o4.clientY - n4.clientY, l4 = o4.time - n4.time);
      const h4 = ((e4 = window.visualViewport) === null || e4 === void 0 ? void 0 : e4.scale) || 1;
      h4 !== 1 && (a4 *= h4, r4 *= h4);
      let c4 = 0, d4 = 0, u4 = 0, g3 = 0, p4 = this.option("decelFriction");
      const f3 = this.targetScale;
      if (l4 > 0) {
        u4 = Math.abs(a4) > 3 ? a4 / (l4 / 30) : 0, g3 = Math.abs(r4) > 3 ? r4 / (l4 / 30) : 0;
        const t4 = this.option("maxVelocity");
        t4 && (u4 = Math.max(Math.min(u4, t4), -1 * t4), g3 = Math.max(Math.min(g3, t4), -1 * t4));
      }
      u4 && (c4 = u4 / (1 / (1 - p4) - 1)), g3 && (d4 = g3 / (1 / (1 - p4) - 1)), (this.option("lockAxis") === "y" || this.option("lockAxis") === "xy" && this.lockedAxis === "y" && t(f3) === this.minScale) && (c4 = u4 = 0), (this.option("lockAxis") === "x" || this.option("lockAxis") === "xy" && this.lockedAxis === "x" && t(f3) === this.minScale) && (d4 = g3 = 0);
      const b3 = this.dragOffset.x, v3 = this.dragOffset.y, y3 = this.option("dragMinThreshold") || 0;
      Math.abs(b3) < y3 && Math.abs(v3) < y3 && (c4 = d4 = 0, u4 = g3 = 0), (f3 < this.minScale - 1e-5 || f3 > this.maxScale + 1e-5 || i4 && !c4 && !d4) && (p4 = 0.35), this.applyChange({ panX: c4, panY: d4, friction: p4 }), this.emit("decel", u4, g3, b3, v3);
    }
    onWheel(t4) {
      var e4 = [-t4.deltaX || 0, -t4.deltaY || 0, -t4.detail || 0].reduce(function(t5, e5) {
        return Math.abs(e5) > Math.abs(t5) ? e5 : t5;
      });
      const i4 = Math.max(-1, Math.min(1, e4));
      if (this.emit("wheel", t4, i4), this.panMode === "mousemove")
        return;
      if (t4.defaultPrevented)
        return;
      const s4 = this.option("wheel");
      s4 === "pan" ? (t4.preventDefault(), this.panOnlyZoomed && !this.canZoomOut() || this.applyChange({ panX: 2 * -t4.deltaX, panY: 2 * -t4.deltaY, bounce: false })) : s4 === "zoom" && this.option("zoom") !== false && this.zoomWithWheel(t4);
    }
    onMouseMove(t4) {
      this.panWithMouse(t4);
    }
    onKeydown(t4) {
      t4.key === "Escape" && this.toggleFS();
    }
    onResize() {
      this.updateMetrics(), this.checkBounds().inBounds || this.requestTick();
    }
    setTransform() {
      this.emit("beforeTransform");
      const { current: e4, target: i4, content: s4, contentRect: n4 } = this, o4 = Object.assign({}, P);
      for (const s5 of m) {
        const n5 = s5 == "e" || s5 === "f" ? 1e3 : 1e5;
        o4[s5] = t(e4[s5], n5), Math.abs(i4[s5] - e4[s5]) < (s5 == "e" || s5 === "f" ? 0.51 : 1e-3) && (e4[s5] = i4[s5]);
      }
      let { a: a4, b: r4, c: l4, d: h4, e: c4, f: d4 } = o4, u4 = `matrix(${a4}, ${r4}, ${l4}, ${h4}, ${c4}, ${d4})`, g3 = s4.parentElement instanceof HTMLPictureElement ? s4.parentElement : s4;
      if (this.option("transformParent") && (g3 = g3.parentElement || g3), g3.style.transform === u4)
        return;
      g3.style.transform = u4;
      const { contentWidth: p4, contentHeight: f3 } = this.calculateContentDim();
      n4.width = p4, n4.height = f3, this.emit("afterTransform");
    }
    updateMetrics(e4 = false) {
      var i4;
      if (!this || this.state === f.Destroy)
        return;
      if (this.isContentLoading)
        return;
      const s4 = Math.max(1, ((i4 = window.visualViewport) === null || i4 === void 0 ? void 0 : i4.scale) || 1), { container: n4, content: o4 } = this, a4 = o4 instanceof HTMLImageElement, r4 = n4.getBoundingClientRect(), l4 = getComputedStyle(this.container);
      let h4 = r4.width * s4, c4 = r4.height * s4;
      const d4 = parseFloat(l4.paddingTop) + parseFloat(l4.paddingBottom), u4 = h4 - (parseFloat(l4.paddingLeft) + parseFloat(l4.paddingRight)), g3 = c4 - d4;
      this.containerRect = { width: h4, height: c4, innerWidth: u4, innerHeight: g3 };
      let p4 = this.option("width") || "auto", m3 = this.option("height") || "auto";
      p4 === "auto" && (p4 = parseFloat(o4.dataset.width || "") || ((t4) => {
        let e5 = 0;
        return e5 = t4 instanceof HTMLImageElement ? t4.naturalWidth : t4 instanceof SVGElement ? t4.width.baseVal.value : Math.max(t4.offsetWidth, t4.scrollWidth), e5 || 0;
      })(o4)), m3 === "auto" && (m3 = parseFloat(o4.dataset.height || "") || ((t4) => {
        let e5 = 0;
        return e5 = t4 instanceof HTMLImageElement ? t4.naturalHeight : t4 instanceof SVGElement ? t4.height.baseVal.value : Math.max(t4.offsetHeight, t4.scrollHeight), e5 || 0;
      })(o4));
      let b3 = o4.parentElement instanceof HTMLPictureElement ? o4.parentElement : o4;
      this.option("transformParent") && (b3 = b3.parentElement || b3);
      const v3 = b3.getAttribute("style") || "";
      b3.style.setProperty("transform", "none", "important"), a4 && (b3.style.width = "", b3.style.height = ""), b3.offsetHeight;
      const y3 = o4.getBoundingClientRect();
      let x3 = y3.width * s4, w3 = y3.height * s4, P3 = 0, T3 = 0;
      a4 && (Math.abs(p4 - x3) > 1 || Math.abs(m3 - w3) > 1) && ({ width: x3, height: w3, top: P3, left: T3 } = ((t4, e5, i5, s5) => {
        const n5 = i5 / s5;
        return n5 > t4 / e5 ? (i5 = t4, s5 = t4 / n5) : (i5 = e5 * n5, s5 = e5), { width: i5, height: s5, top: 0.5 * (e5 - s5), left: 0.5 * (t4 - i5) };
      })(x3, w3, p4, m3)), this.contentRect = Object.assign(Object.assign({}, this.contentRect), { top: y3.top - r4.top + P3, bottom: r4.bottom - y3.bottom + P3, left: y3.left - r4.left + T3, right: r4.right - y3.right + T3, fitWidth: x3, fitHeight: w3, width: x3, height: w3, fullWidth: p4, fullHeight: m3 }), b3.style.cssText = v3, a4 && (b3.style.width = `${x3}px`, b3.style.height = `${w3}px`), this.setTransform(), e4 !== true && this.emit("refresh"), this.ignoreBounds || (t(this.targetScale) < t(this.minScale) ? this.zoomTo(this.minScale, { friction: 0 }) : this.targetScale > this.maxScale ? this.zoomTo(this.maxScale, { friction: 0 }) : this.state === f.Init || this.checkBounds().inBounds || this.requestTick()), this.updateControls();
    }
    getBounds() {
      const e4 = this.option("bounds");
      if (e4 !== "auto")
        return e4;
      const { contentWidth: i4, contentHeight: s4 } = this.calculateContentDim(this.target);
      let n4 = 0, o4 = 0, a4 = 0, r4 = 0;
      const l4 = this.option("infinite");
      if (l4 === true || this.lockedAxis && l4 === this.lockedAxis)
        n4 = -1 / 0, a4 = 1 / 0, o4 = -1 / 0, r4 = 1 / 0;
      else {
        let { containerRect: e5, contentRect: l5 } = this, h4 = t(this.contentRect.fitWidth * this.targetScale, 1e3), c4 = t(this.contentRect.fitHeight * this.targetScale, 1e3), { innerWidth: d4, innerHeight: u4 } = e5;
        if (this.containerRect.width === h4 && (d4 = e5.width), this.containerRect.width === c4 && (u4 = e5.height), i4 > d4) {
          a4 = 0.5 * (i4 - d4), n4 = -1 * a4;
          let t4 = 0.5 * (l5.right - l5.left);
          n4 += t4, a4 += t4;
        }
        if (this.contentRect.fitWidth > d4 && i4 < d4 && (n4 -= 0.5 * (this.contentRect.fitWidth - d4), a4 -= 0.5 * (this.contentRect.fitWidth - d4)), s4 > u4) {
          r4 = 0.5 * (s4 - u4), o4 = -1 * r4;
          let t4 = 0.5 * (l5.bottom - l5.top);
          o4 += t4, r4 += t4;
        }
        this.contentRect.fitHeight > u4 && s4 < u4 && (n4 -= 0.5 * (this.contentRect.fitHeight - u4), a4 -= 0.5 * (this.contentRect.fitHeight - u4));
      }
      return { x: { min: n4, max: a4 }, y: { min: o4, max: r4 } };
    }
    updateControls() {
      const e4 = this, i4 = e4.container, { panMode: s4, contentRect: o4, fullScale: a4, targetScale: r4, coverScale: l4, maxScale: h4, minScale: c4 } = e4;
      let d4 = { toggleMax: r4 - c4 < 0.5 * (h4 - c4) ? h4 : c4, toggleCover: r4 - c4 < 0.5 * (l4 - c4) ? l4 : c4, toggleZoom: r4 - c4 < 0.5 * (a4 - c4) ? a4 : c4 }[e4.option("click") || ""] || c4, u4 = e4.canZoomIn(), g3 = e4.canZoomOut(), p4 = g3 && s4 === "drag";
      t(r4) < t(c4) && !this.panOnlyZoomed && (p4 = true), (t(o4.width, 1) > t(o4.fitWidth, 1) || t(o4.height, 1) > t(o4.fitHeight, 1)) && (p4 = true), t(o4.width * r4, 1) < t(o4.fitWidth, 1) && (p4 = false), s4 === "mousemove" && (p4 = false);
      let f3 = u4 && t(d4) > t(r4), m3 = !f3 && !p4 && g3 && t(d4) < t(r4);
      n(i4, this.cn("canZoomIn"), f3), n(i4, this.cn("canZoomOut"), m3), n(i4, this.cn("isDraggable"), p4);
      for (const t4 of i4.querySelectorAll('[data-panzoom-action="zoomIn"]'))
        u4 ? (t4.removeAttribute("disabled"), t4.removeAttribute("tabindex")) : (t4.setAttribute("disabled", ""), t4.setAttribute("tabindex", "-1"));
      for (const t4 of i4.querySelectorAll('[data-panzoom-action="zoomOut"]'))
        g3 ? (t4.removeAttribute("disabled"), t4.removeAttribute("tabindex")) : (t4.setAttribute("disabled", ""), t4.setAttribute("tabindex", "-1"));
      for (const t4 of i4.querySelectorAll('[data-panzoom-action="toggleZoom"],[data-panzoom-action="iterateZoom"]')) {
        u4 || g3 ? (t4.removeAttribute("disabled"), t4.removeAttribute("tabindex")) : (t4.setAttribute("disabled", ""), t4.setAttribute("tabindex", "-1"));
        const e5 = t4.querySelector("g");
        e5 && (e5.style.display = u4 ? "" : "none");
      }
    }
    panTo({ x: t4 = this.target.e, y: e4 = this.target.f, scale: i4 = this.targetScale, friction: s4 = this.option("friction"), angle: n4 = 0, originX: o4 = 0, originY: a4 = 0, flipX: r4 = false, flipY: l4 = false, ignoreBounds: h4 = false }) {
      this.state !== f.Destroy && this.applyChange({ panX: t4 - this.target.e, panY: e4 - this.target.f, scale: i4 / this.targetScale, angle: n4, originX: o4, originY: a4, friction: s4, flipX: r4, flipY: l4, ignoreBounds: h4 });
    }
    applyChange({ panX: e4 = 0, panY: i4 = 0, scale: s4 = 1, angle: n4 = 0, originX: o4 = -this.current.e, originY: a4 = -this.current.f, friction: r4 = this.option("friction"), flipX: l4 = false, flipY: h4 = false, ignoreBounds: c4 = false, bounce: d4 = this.option("bounce") }) {
      if (this.state === f.Destroy)
        return;
      this.rAF && (cancelAnimationFrame(this.rAF), this.rAF = null), this.friction = r4 || 0, this.ignoreBounds = c4;
      const { current: u4 } = this, g3 = u4.e, p4 = u4.f, b3 = this.getMatrix(this.target);
      let v3 = new DOMMatrix().translate(g3, p4).translate(o4, a4).translate(e4, i4);
      if (this.option("zoom")) {
        if (!c4) {
          const t4 = this.targetScale, e5 = this.minScale, i5 = this.maxScale;
          t4 * s4 < e5 && (s4 = e5 / t4), t4 * s4 > i5 && (s4 = i5 / t4);
        }
        v3 = v3.scale(s4);
      }
      v3 = v3.translate(-o4, -a4).translate(-g3, -p4).multiply(b3), n4 && (v3 = v3.rotate(n4)), l4 && (v3 = v3.scale(-1, 1)), h4 && (v3 = v3.scale(1, -1));
      for (const e5 of m)
        e5 !== "e" && e5 !== "f" && (v3[e5] > this.minScale + 1e-5 || v3[e5] < this.minScale - 1e-5) ? this.target[e5] = v3[e5] : this.target[e5] = t(v3[e5], 1e3);
      (this.targetScale < this.scale || Math.abs(s4 - 1) > 0.1 || this.panMode === "mousemove" || d4 === false) && !c4 && this.clampTargetBounds(), this.isResting || (this.state = f.Panning, this.requestTick());
    }
    stop(t4 = false) {
      if (this.state === f.Init || this.state === f.Destroy)
        return;
      const e4 = this.isTicking;
      this.rAF && (cancelAnimationFrame(this.rAF), this.rAF = null), this.isBouncingX = false, this.isBouncingY = false;
      for (const e5 of m)
        this.velocity[e5] = 0, t4 === "current" ? this.current[e5] = this.target[e5] : t4 === "target" && (this.target[e5] = this.current[e5]);
      this.setTransform(), x(this.container, "is-scaling"), x(this.container, "is-animating"), this.isTicking = false, this.state = f.Ready, e4 && (this.emit("endAnimation"), this.updateControls());
    }
    requestTick() {
      this.isTicking || (this.emit("startAnimation"), this.updateControls(), w(this.container, "is-animating"), this.isScaling && w(this.container, "is-scaling")), this.isTicking = true, this.rAF || (this.rAF = requestAnimationFrame(() => this.animate()));
    }
    panWithMouse(e4, i4 = this.option("mouseMoveFriction")) {
      if (this.pmme = e4, this.panMode !== "mousemove" || !e4)
        return;
      if (t(this.targetScale) <= t(this.minScale))
        return;
      this.emit("mouseMove", e4);
      const { container: s4, containerRect: n4, contentRect: o4 } = this, a4 = n4.width, r4 = n4.height, l4 = s4.getBoundingClientRect(), h4 = (e4.clientX || 0) - l4.left, c4 = (e4.clientY || 0) - l4.top;
      let { contentWidth: d4, contentHeight: u4 } = this.calculateContentDim(this.target);
      const g3 = this.option("mouseMoveFactor");
      g3 > 1 && (d4 !== a4 && (d4 *= g3), u4 !== r4 && (u4 *= g3));
      let p4 = 0.5 * (d4 - a4) - h4 / a4 * 100 / 100 * (d4 - a4);
      p4 += 0.5 * (o4.right - o4.left);
      let f3 = 0.5 * (u4 - r4) - c4 / r4 * 100 / 100 * (u4 - r4);
      f3 += 0.5 * (o4.bottom - o4.top), this.applyChange({ panX: p4 - this.target.e, panY: f3 - this.target.f, friction: i4 });
    }
    zoomWithWheel(e4) {
      if (this.state === f.Destroy || this.state === f.Init)
        return;
      const i4 = Date.now();
      if (i4 - this.pwt < 45)
        return void e4.preventDefault();
      this.pwt = i4;
      var s4 = [-e4.deltaX || 0, -e4.deltaY || 0, -e4.detail || 0].reduce(function(t4, e5) {
        return Math.abs(e5) > Math.abs(t4) ? e5 : t4;
      });
      const n4 = Math.max(-1, Math.min(1, s4)), { targetScale: o4, maxScale: a4, minScale: r4 } = this;
      let l4 = o4 * (100 + 45 * n4) / 100;
      t(l4) < t(r4) && t(o4) <= t(r4) ? (this.cwd += Math.abs(n4), l4 = r4) : t(l4) > t(a4) && t(o4) >= t(a4) ? (this.cwd += Math.abs(n4), l4 = a4) : (this.cwd = 0, l4 = Math.max(Math.min(l4, a4), r4)), this.cwd > this.option("wheelLimit") || (e4.preventDefault(), t(l4) !== t(o4) && this.zoomTo(l4, { event: e4 }));
    }
    canZoomIn() {
      return this.option("zoom") && (t(this.contentRect.width, 1) < t(this.contentRect.fitWidth, 1) || t(this.targetScale) < t(this.maxScale));
    }
    canZoomOut() {
      return this.option("zoom") && t(this.targetScale) > t(this.minScale);
    }
    zoomIn(t4 = 1.25, e4) {
      this.zoomTo(this.targetScale * t4, e4);
    }
    zoomOut(t4 = 0.8, e4) {
      this.zoomTo(this.targetScale * t4, e4);
    }
    zoomToFit(t4) {
      this.zoomTo("fit", t4);
    }
    zoomToCover(t4) {
      this.zoomTo("cover", t4);
    }
    zoomToFull(t4) {
      this.zoomTo("full", t4);
    }
    zoomToMax(t4) {
      this.zoomTo("max", t4);
    }
    toggleZoom(t4) {
      this.zoomTo(this.targetScale - this.minScale < 0.5 * (this.fullScale - this.minScale) ? "full" : "fit", t4);
    }
    toggleMax(t4) {
      this.zoomTo(this.targetScale - this.minScale < 0.5 * (this.maxScale - this.minScale) ? "max" : "fit", t4);
    }
    toggleCover(t4) {
      this.zoomTo(this.targetScale - this.minScale < 0.5 * (this.coverScale - this.minScale) ? "cover" : "fit", t4);
    }
    iterateZoom(t4) {
      this.zoomTo("next", t4);
    }
    zoomTo(t4 = 1, { friction: e4 = "auto", originX: i4 = 0, originY: s4 = 0, event: n4 } = {}) {
      if (this.isContentLoading || this.state === f.Destroy)
        return;
      const { targetScale: o4 } = this;
      this.stop();
      let a4 = 1;
      if (this.panMode === "mousemove" && (n4 = this.pmme || n4), n4) {
        const t5 = this.content.getBoundingClientRect(), e5 = n4.clientX || 0, o5 = n4.clientY || 0;
        i4 = e5 - t5.left - 0.5 * t5.width, s4 = o5 - t5.top - 0.5 * t5.height;
      }
      const r4 = this.fullScale, l4 = this.maxScale;
      let h4 = this.coverScale;
      typeof t4 == "number" ? a4 = t4 / o4 : (t4 === "next" && (r4 - h4 < 0.2 && (h4 = r4), t4 = o4 < r4 - 1e-5 ? "full" : o4 < l4 - 1e-5 ? "max" : "fit"), a4 = t4 === "full" ? r4 / o4 || 1 : t4 === "cover" ? h4 / o4 || 1 : t4 === "max" ? l4 / o4 || 1 : 1 / o4 || 1), e4 = e4 === "auto" ? a4 > 1 ? 0.15 : 0.25 : e4, this.applyChange({ scale: a4, originX: i4, originY: s4, friction: e4 }), n4 && this.panMode === "mousemove" && this.panWithMouse(n4, e4);
    }
    rotateCCW() {
      this.applyChange({ angle: -90 });
    }
    rotateCW() {
      this.applyChange({ angle: 90 });
    }
    flipX() {
      this.applyChange({ flipX: true });
    }
    flipY() {
      this.applyChange({ flipY: true });
    }
    fitX() {
      this.stop("target");
      const { containerRect: t4, contentRect: e4, target: i4 } = this;
      this.applyChange({ panX: 0.5 * t4.width - (e4.left + 0.5 * e4.fitWidth) - i4.e, panY: 0.5 * t4.height - (e4.top + 0.5 * e4.fitHeight) - i4.f, scale: t4.width / e4.fitWidth / this.targetScale, originX: 0, originY: 0, ignoreBounds: true });
    }
    fitY() {
      this.stop("target");
      const { containerRect: t4, contentRect: e4, target: i4 } = this;
      this.applyChange({ panX: 0.5 * t4.width - (e4.left + 0.5 * e4.fitWidth) - i4.e, panY: 0.5 * t4.innerHeight - (e4.top + 0.5 * e4.fitHeight) - i4.f, scale: t4.height / e4.fitHeight / this.targetScale, originX: 0, originY: 0, ignoreBounds: true });
    }
    toggleFS() {
      const { container: t4 } = this, e4 = this.cn("inFullscreen"), i4 = this.cn("htmlHasFullscreen");
      t4.classList.toggle(e4);
      const s4 = t4.classList.contains(e4);
      s4 ? (document.documentElement.classList.add(i4), document.addEventListener("keydown", this.onKeydown, true)) : (document.documentElement.classList.remove(i4), document.removeEventListener("keydown", this.onKeydown, true)), this.updateMetrics(), this.emit(s4 ? "enterFS" : "exitFS");
    }
    getMatrix(t4 = this.current) {
      const { a: e4, b: i4, c: s4, d: n4, e: o4, f: a4 } = t4;
      return new DOMMatrix([e4, i4, s4, n4, o4, a4]);
    }
    reset(t4) {
      if (this.state !== f.Init && this.state !== f.Destroy) {
        this.stop("current");
        for (const t5 of m)
          this.target[t5] = P[t5];
        this.target.a = this.minScale, this.target.d = this.minScale, this.clampTargetBounds(), this.isResting || (this.friction = t4 === void 0 ? this.option("friction") : t4, this.state = f.Panning, this.requestTick());
      }
    }
    destroy() {
      this.stop(), this.state = f.Destroy, this.detachEvents(), this.detachObserver();
      const { container: t4, content: e4 } = this, i4 = this.option("classes") || {};
      for (const e5 of Object.values(i4))
        t4.classList.remove(e5 + "");
      e4 && (e4.removeEventListener("load", this.onLoad), e4.removeEventListener("error", this.onError)), this.detachPlugins();
    }
  };
  Object.defineProperty(M, "defaults", { enumerable: true, configurable: true, writable: true, value: b }), Object.defineProperty(M, "Plugins", { enumerable: true, configurable: true, writable: true, value: {} });
  var O = function(t4, e4) {
    let i4 = true;
    return (...s4) => {
      i4 && (i4 = false, t4(...s4), setTimeout(() => {
        i4 = true;
      }, e4));
    };
  };
  var E = (t4, e4) => {
    let i4 = [];
    return t4.childNodes.forEach((t5) => {
      t5.nodeType !== Node.ELEMENT_NODE || e4 && !t5.matches(e4) || i4.push(t5);
    }), i4;
  };
  var z = { viewport: null, track: null, enabled: true, slides: [], axis: "x", transition: "fade", preload: 1, slidesPerPage: "auto", initialPage: 0, friction: 0.12, Panzoom: { decelFriction: 0.12 }, center: true, infinite: true, fill: true, dragFree: false, adaptiveHeight: false, direction: "ltr", classes: { container: "f-carousel", viewport: "f-carousel__viewport", track: "f-carousel__track", slide: "f-carousel__slide", isLTR: "is-ltr", isRTL: "is-rtl", isHorizontal: "is-horizontal", isVertical: "is-vertical", inTransition: "in-transition", isSelected: "is-selected" }, l10n: { NEXT: "Next slide", PREV: "Previous slide", GOTO: "Go to slide #%d" } };
  var k;
  !function(t4) {
    t4[t4.Init = 0] = "Init", t4[t4.Ready = 1] = "Ready", t4[t4.Destroy = 2] = "Destroy";
  }(k || (k = {}));
  var R = (t4) => {
    if (typeof t4 == "string" && (t4 = { html: t4 }), !(t4 instanceof String || t4 instanceof HTMLElement)) {
      const e4 = t4.thumb;
      e4 !== void 0 && (typeof e4 == "string" && (t4.thumbSrc = e4), e4 instanceof HTMLImageElement && (t4.thumbEl = e4, t4.thumbElSrc = e4.src, t4.thumbSrc = e4.src), delete t4.thumb);
    }
    return Object.assign({ html: "", el: null, isDom: false, class: "", index: -1, dim: 0, gap: 0, pos: 0, transition: false }, t4);
  };
  var L = (t4 = {}) => Object.assign({ index: -1, slides: [], dim: 0, pos: -1 }, t4);
  var A = class extends g {
    constructor(t4, e4) {
      super(e4), Object.defineProperty(this, "instance", { enumerable: true, configurable: true, writable: true, value: t4 });
    }
    attach() {
    }
    detach() {
    }
  };
  var D = { classes: { list: "f-carousel__dots", isDynamic: "is-dynamic", hasDots: "has-dots", dot: "f-carousel__dot", isBeforePrev: "is-before-prev", isPrev: "is-prev", isCurrent: "is-current", isNext: "is-next", isAfterNext: "is-after-next" }, dotTpl: '<button type="button" data-carousel-page="%i" aria-label="{{GOTO}}"><span class="f-carousel__dot" aria-hidden="true"></span></button>', dynamicFrom: 11, maxCount: 1 / 0, minCount: 2 };
  var C = class extends A {
    constructor() {
      super(...arguments), Object.defineProperty(this, "isDynamic", { enumerable: true, configurable: true, writable: true, value: false }), Object.defineProperty(this, "list", { enumerable: true, configurable: true, writable: true, value: null });
    }
    onRefresh() {
      this.refresh();
    }
    build() {
      let t4 = this.list;
      return t4 || (t4 = document.createElement("ul"), w(t4, this.cn("list")), t4.setAttribute("role", "tablist"), this.instance.container.appendChild(t4), w(this.instance.container, this.cn("hasDots")), this.list = t4), t4;
    }
    refresh() {
      var t4;
      const e4 = this.instance.pages.length, i4 = Math.min(2, this.option("minCount")), s4 = Math.max(2e3, this.option("maxCount")), o4 = this.option("dynamicFrom");
      if (e4 < i4 || e4 > s4)
        return void this.cleanup();
      const a4 = typeof o4 == "number" && e4 > 5 && e4 >= o4, r4 = !this.list || this.isDynamic !== a4 || this.list.children.length !== e4;
      r4 && this.cleanup();
      const l4 = this.build();
      if (n(l4, this.cn("isDynamic"), !!a4), r4)
        for (let t5 = 0; t5 < e4; t5++)
          l4.append(this.createItem(t5));
      let h4, c4 = 0;
      for (const e5 of [...l4.children]) {
        const i5 = c4 === this.instance.page;
        i5 && (h4 = e5), n(e5, this.cn("isCurrent"), i5), (t4 = e5.children[0]) === null || t4 === void 0 || t4.setAttribute("aria-selected", i5 ? "true" : "false");
        for (const t5 of ["isBeforePrev", "isPrev", "isNext", "isAfterNext"])
          x(e5, this.cn(t5));
        c4++;
      }
      if (h4 = h4 || l4.firstChild, a4 && h4) {
        const t5 = h4.previousElementSibling, e5 = t5 && t5.previousElementSibling;
        w(t5, this.cn("isPrev")), w(e5, this.cn("isBeforePrev"));
        const i5 = h4.nextElementSibling, s5 = i5 && i5.nextElementSibling;
        w(i5, this.cn("isNext")), w(s5, this.cn("isAfterNext"));
      }
      this.isDynamic = a4;
    }
    createItem(t4 = 0) {
      var e4;
      const s4 = document.createElement("li");
      s4.setAttribute("role", "presentation");
      const n4 = i(this.instance.localize(this.option("dotTpl"), [["%d", t4 + 1]]).replace(/\%i/g, t4 + ""));
      return s4.appendChild(n4), (e4 = s4.children[0]) === null || e4 === void 0 || e4.setAttribute("role", "tab"), s4;
    }
    cleanup() {
      this.list && (this.list.remove(), this.list = null), this.isDynamic = false, x(this.instance.container, this.cn("hasDots"));
    }
    attach() {
      this.instance.on(["refresh", "change"], this.onRefresh);
    }
    detach() {
      this.instance.off(["refresh", "change"], this.onRefresh), this.cleanup();
    }
  };
  Object.defineProperty(C, "defaults", { enumerable: true, configurable: true, writable: true, value: D });
  var j = class extends A {
    constructor() {
      super(...arguments), Object.defineProperty(this, "container", { enumerable: true, configurable: true, writable: true, value: null }), Object.defineProperty(this, "prev", { enumerable: true, configurable: true, writable: true, value: null }), Object.defineProperty(this, "next", { enumerable: true, configurable: true, writable: true, value: null });
    }
    onRefresh() {
      const t4 = this.instance, e4 = t4.pages.length, i4 = t4.page;
      if (e4 < 2)
        return void this.cleanup();
      this.build();
      let s4 = this.prev, n4 = this.next;
      s4 && n4 && (s4.removeAttribute("disabled"), n4.removeAttribute("disabled"), t4.isInfinite || (i4 <= 0 && s4.setAttribute("disabled", ""), i4 >= e4 - 1 && n4.setAttribute("disabled", "")));
    }
    createButton(t4) {
      const e4 = this.instance, i4 = document.createElement("button");
      i4.setAttribute("tabindex", "0"), i4.setAttribute("title", e4.localize(`{{${t4.toUpperCase()}}}`)), w(i4, this.cn("button") + " " + this.cn(t4 === "next" ? "isNext" : "isPrev"));
      const s4 = e4.isRTL ? t4 === "next" ? "prev" : "next" : t4;
      var n4;
      return i4.innerHTML = e4.localize(this.option(`${s4}Tpl`)), i4.dataset[`carousel${n4 = t4, n4 ? n4.match("^[a-z]") ? n4.charAt(0).toUpperCase() + n4.substring(1) : n4 : ""}`] = "true", i4;
    }
    build() {
      let t4 = this.container;
      t4 || (this.container = t4 = document.createElement("div"), w(t4, this.cn("container")), this.instance.container.appendChild(t4)), this.next || (this.next = t4.appendChild(this.createButton("next"))), this.prev || (this.prev = t4.appendChild(this.createButton("prev")));
    }
    cleanup() {
      this.prev && this.prev.remove(), this.next && this.next.remove(), this.container && this.container.remove(), this.prev = null, this.next = null, this.container = null;
    }
    attach() {
      this.instance.on(["refresh", "change"], this.onRefresh);
    }
    detach() {
      this.instance.off(["refresh", "change"], this.onRefresh), this.cleanup();
    }
  };
  Object.defineProperty(j, "defaults", { enumerable: true, configurable: true, writable: true, value: { classes: { container: "f-carousel__nav", button: "f-button", isNext: "is-next", isPrev: "is-prev" }, nextTpl: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" tabindex="-1"><path d="M9 3l9 9-9 9"/></svg>', prevTpl: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" tabindex="-1"><path d="M15 3l-9 9 9 9"/></svg>' } });
  var F = class extends A {
    constructor() {
      super(...arguments), Object.defineProperty(this, "selectedIndex", { enumerable: true, configurable: true, writable: true, value: null }), Object.defineProperty(this, "target", { enumerable: true, configurable: true, writable: true, value: null }), Object.defineProperty(this, "nav", { enumerable: true, configurable: true, writable: true, value: null });
    }
    addAsTargetFor(t4) {
      this.target = this.instance, this.nav = t4, this.attachEvents();
    }
    addAsNavFor(t4) {
      this.nav = this.instance, this.target = t4, this.attachEvents();
    }
    attachEvents() {
      this.nav && this.target && (this.nav.options.initialSlide = this.target.options.initialPage, this.nav.on("ready", this.onNavReady), this.nav.state === k.Ready && this.onNavReady(this.nav), this.target.on("ready", this.onTargetReady), this.target.state === k.Ready && this.onTargetReady(this.target));
    }
    onNavReady(t4) {
      t4.on("createSlide", this.onNavCreateSlide), t4.on("Panzoom.click", this.onNavClick), t4.on("Panzoom.touchEnd", this.onNavTouch), this.onTargetChange();
    }
    onTargetReady(t4) {
      t4.on("change", this.onTargetChange), t4.on("Panzoom.refresh", this.onTargetChange), this.onTargetChange();
    }
    onNavClick(t4, e4, i4) {
      i4.pointerType || this.onNavTouch(t4, t4.panzoom, i4);
    }
    onNavTouch(t4, e4, i4) {
      var s4, n4;
      if (Math.abs(e4.dragOffset.x) > 3 || Math.abs(e4.dragOffset.y) > 3)
        return;
      const o4 = i4.target, { nav: a4, target: r4 } = this;
      if (!a4 || !r4 || !o4)
        return;
      const l4 = o4.closest("[data-index]");
      if (i4.stopPropagation(), i4.preventDefault(), !l4)
        return;
      const h4 = parseInt(l4.dataset.index || "", 10) || 0, c4 = r4.getPageForSlide(h4), d4 = a4.getPageForSlide(h4);
      a4.slideTo(d4), r4.slideTo(c4, { friction: ((n4 = (s4 = this.nav) === null || s4 === void 0 ? void 0 : s4.plugins) === null || n4 === void 0 ? void 0 : n4.Sync.option("friction")) || 0 }), this.markSelectedSlide(h4);
    }
    onNavCreateSlide(t4, e4) {
      e4.index === this.selectedIndex && this.markSelectedSlide(e4.index);
    }
    onTargetChange() {
      const { target: t4, nav: e4 } = this;
      if (!t4 || !e4)
        return;
      if (e4.state !== k.Ready || t4.state !== k.Ready)
        return;
      const i4 = t4.pages[t4.page].slides[0].index, s4 = e4.getPageForSlide(i4);
      this.markSelectedSlide(i4), e4.slideTo(s4);
    }
    markSelectedSlide(t4) {
      const e4 = this.nav;
      e4 && e4.state === k.Ready && (this.selectedIndex = t4, [...e4.slides].map((e5) => {
        e5.el && e5.el.classList[e5.index === t4 ? "add" : "remove"]("is-nav-selected");
      }));
    }
    attach() {
      const t4 = this;
      let e4 = t4.options.target, i4 = t4.options.nav;
      e4 ? t4.addAsNavFor(e4) : i4 && t4.addAsTargetFor(i4);
    }
    detach() {
      const t4 = this, e4 = t4.nav, i4 = t4.target;
      e4 && (e4.off("ready", t4.onNavReady), e4.off("createSlide", t4.onNavCreateSlide), e4.off("Panzoom.click", t4.onNavClick), e4.off("Panzoom.touchEnd", t4.onNavTouch)), t4.nav = null, i4 && (i4.off("ready", t4.onTargetReady), i4.off("refresh", t4.onTargetChange), i4.off("change", t4.onTargetChange)), t4.target = null;
    }
  };
  Object.defineProperty(F, "defaults", { enumerable: true, configurable: true, writable: true, value: { friction: 0.35 } });
  var I = { Navigation: j, Dots: C, Sync: F };
  var H = class extends p {
    get axis() {
      return this.isHorizontal ? "e" : "f";
    }
    get isEnabled() {
      return this.state === k.Ready;
    }
    get isInfinite() {
      let t4 = false;
      const { contentDim: e4, viewportDim: i4, pages: s4, slides: n4 } = this;
      return s4.length >= 2 && e4 + n4[0].dim >= i4 && (t4 = this.option("infinite")), t4;
    }
    get isRTL() {
      return this.option("direction") === "rtl";
    }
    get isHorizontal() {
      return this.option("axis") === "x";
    }
    constructor(t4, e4 = {}, i4 = {}) {
      if (super(), Object.defineProperty(this, "userOptions", { enumerable: true, configurable: true, writable: true, value: {} }), Object.defineProperty(this, "userPlugins", { enumerable: true, configurable: true, writable: true, value: {} }), Object.defineProperty(this, "bp", { enumerable: true, configurable: true, writable: true, value: "" }), Object.defineProperty(this, "lp", { enumerable: true, configurable: true, writable: true, value: 0 }), Object.defineProperty(this, "state", { enumerable: true, configurable: true, writable: true, value: k.Init }), Object.defineProperty(this, "page", { enumerable: true, configurable: true, writable: true, value: 0 }), Object.defineProperty(this, "prevPage", { enumerable: true, configurable: true, writable: true, value: null }), Object.defineProperty(this, "container", { enumerable: true, configurable: true, writable: true, value: void 0 }), Object.defineProperty(this, "viewport", { enumerable: true, configurable: true, writable: true, value: null }), Object.defineProperty(this, "track", { enumerable: true, configurable: true, writable: true, value: null }), Object.defineProperty(this, "slides", { enumerable: true, configurable: true, writable: true, value: [] }), Object.defineProperty(this, "pages", { enumerable: true, configurable: true, writable: true, value: [] }), Object.defineProperty(this, "panzoom", { enumerable: true, configurable: true, writable: true, value: null }), Object.defineProperty(this, "inTransition", { enumerable: true, configurable: true, writable: true, value: new Set() }), Object.defineProperty(this, "contentDim", { enumerable: true, configurable: true, writable: true, value: 0 }), Object.defineProperty(this, "viewportDim", { enumerable: true, configurable: true, writable: true, value: 0 }), typeof t4 == "string" && (t4 = document.querySelector(t4)), !t4 || !y(t4))
        throw new Error("No Element found");
      this.container = t4, this.slideNext = O(this.slideNext.bind(this), 150), this.slidePrev = O(this.slidePrev.bind(this), 150), this.userOptions = e4, this.userPlugins = i4, queueMicrotask(() => {
        this.processOptions();
      });
    }
    processOptions() {
      const t4 = d({}, H.defaults, this.userOptions);
      let e4 = "";
      const i4 = t4.breakpoints;
      if (i4 && c(i4))
        for (const [s4, n4] of Object.entries(i4))
          window.matchMedia(s4).matches && c(n4) && (e4 += s4, d(t4, n4));
      e4 === this.bp && this.state !== k.Init || (this.bp = e4, this.state === k.Ready && (t4.initialSlide = this.pages[this.page].slides[0].index), this.state !== k.Init && this.destroy(), super.setOptions(t4), this.option("enabled") === false ? this.attachEvents() : setTimeout(() => {
        this.init();
      }, 0));
    }
    init() {
      this.state = k.Init, this.emit("init"), this.attachPlugins(Object.assign(Object.assign({}, H.Plugins), this.userPlugins)), this.initLayout(), this.initSlides(), this.updateMetrics(), this.setInitialPosition(), this.initPanzoom(), this.attachEvents(), this.state = k.Ready, this.emit("ready");
    }
    initLayout() {
      const { container: t4 } = this, e4 = this.option("classes");
      w(t4, this.cn("container")), n(t4, e4.isLTR, !this.isRTL), n(t4, e4.isRTL, this.isRTL), n(t4, e4.isVertical, !this.isHorizontal), n(t4, e4.isHorizontal, this.isHorizontal);
      let i4 = this.option("viewport") || t4.querySelector(`.${e4.viewport}`);
      i4 || (i4 = document.createElement("div"), w(i4, e4.viewport), i4.append(...E(t4, `.${e4.slide}`)), t4.prepend(i4));
      let s4 = this.option("track") || t4.querySelector(`.${e4.track}`);
      s4 || (s4 = document.createElement("div"), w(s4, e4.track), s4.append(...Array.from(i4.childNodes))), s4.setAttribute("aria-live", "polite"), i4.contains(s4) || i4.prepend(s4), this.viewport = i4, this.track = s4, this.emit("initLayout");
    }
    initSlides() {
      const { track: t4 } = this;
      if (t4) {
        this.slides = [], [...E(t4, `.${this.cn("slide")}`)].forEach((t5) => {
          if (y(t5)) {
            const e4 = R({ el: t5, isDom: true, index: this.slides.length });
            this.slides.push(e4), this.emit("initSlide", e4, this.slides.length);
          }
        });
        for (let t5 of this.option("slides", [])) {
          const e4 = R(t5);
          e4.index = this.slides.length, this.slides.push(e4), this.emit("initSlide", e4, this.slides.length);
        }
        this.emit("initSlides");
      }
    }
    setInitialPage() {
      let t4 = 0;
      const e4 = this.option("initialSlide");
      t4 = typeof e4 == "number" ? this.getPageForSlide(e4) : parseInt(this.option("initialPage", 0) + "", 10) || 0, this.page = t4;
    }
    setInitialPosition() {
      if (!this.track || !this.pages.length)
        return;
      const t4 = this.isHorizontal;
      let e4 = this.page;
      this.pages[e4] || (this.page = e4 = 0);
      const i4 = this.pages[e4].pos * (this.isRTL && t4 ? 1 : -1), s4 = t4 ? `${i4}px` : "0", n4 = t4 ? "0" : `${i4}px`;
      this.track.style.transform = `translate3d(${s4}, ${n4}, 0) scale(1)`, this.option("adaptiveHeight") && this.setViewportHeight();
    }
    initPanzoom() {
      this.panzoom && (this.panzoom.destroy(), this.panzoom = null);
      const t4 = this.option("Panzoom") || {};
      this.panzoom = new M(this.viewport, d({}, { content: this.track, zoom: false, panOnlyZoomed: false, lockAxis: this.isHorizontal ? "x" : "y", infinite: this.isInfinite, click: false, dblClick: false, touch: (t5) => !(this.pages.length < 2 && !t5.options.infinite), bounds: () => this.getBounds(), maxVelocity: (t5) => Math.abs(t5.target[this.axis] - t5.current[this.axis]) < 2 * this.viewportDim ? 100 : 0 }, t4)), this.panzoom.on("*", (t5, e4, ...i4) => {
        this.emit(`Panzoom.${e4}`, t5, ...i4);
      }), this.panzoom.on("decel", this.onDecel), this.panzoom.on("refresh", this.onRefresh), this.panzoom.on("beforeTransform", this.onBeforeTransform), this.panzoom.on("endAnimation", this.onEndAnimation);
    }
    attachEvents() {
      const t4 = this.container;
      t4 && (t4.addEventListener("click", this.onClick, { passive: false, capture: false }), t4.addEventListener("slideTo", this.onSlideTo)), window.addEventListener("resize", this.onResize);
    }
    createPages() {
      let t4 = [];
      const { contentDim: e4, viewportDim: i4 } = this;
      let s4 = this.option("slidesPerPage");
      (typeof s4 != "number" || e4 <= i4) && (s4 = 1 / 0);
      let n4 = 0, o4 = 0, a4 = 0;
      for (const e5 of this.slides)
        (!t4.length || o4 + e5.dim > i4 || a4 === s4) && (t4.push(L()), n4 = t4.length - 1, o4 = 0, a4 = 0), t4[n4].slides.push(e5), o4 += e5.dim + e5.gap, a4++;
      return t4;
    }
    processPages() {
      const e4 = this.pages, { contentDim: i4, viewportDim: s4 } = this, n4 = this.option("center"), o4 = this.option("fill"), a4 = o4 && n4 && i4 > s4 && !this.isInfinite;
      if (e4.forEach((t4, e5) => {
        t4.index = e5, t4.pos = t4.slides[0].pos, t4.dim = 0;
        for (const [e6, i5] of t4.slides.entries())
          t4.dim += i5.dim, e6 < t4.slides.length - 1 && (t4.dim += i5.gap);
        a4 && t4.pos + 0.5 * t4.dim < 0.5 * s4 ? t4.pos = 0 : a4 && t4.pos + 0.5 * t4.dim >= i4 - 0.5 * s4 ? t4.pos = i4 - s4 : n4 && (t4.pos += -0.5 * (s4 - t4.dim));
      }), e4.forEach((e5, n5) => {
        o4 && !this.isInfinite && i4 > s4 && (e5.pos = Math.max(e5.pos, 0), e5.pos = Math.min(e5.pos, i4 - s4)), e5.pos = t(e5.pos, 1e3), e5.dim = t(e5.dim, 1e3), e5.pos < 0.1 && e5.pos > -0.1 && (e5.pos = 0);
      }), this.isInfinite)
        return e4;
      const r4 = [];
      let l4;
      return e4.forEach((t4) => {
        const e5 = Object.assign({}, t4);
        l4 && e5.pos === l4.pos ? (l4.dim += e5.dim, l4.slides = [...l4.slides, ...e5.slides]) : (e5.index = r4.length, l4 = e5, r4.push(e5));
      }), r4;
    }
    getPageFromIndex(t4 = 0) {
      const e4 = this.pages.length;
      let i4;
      return t4 = parseInt((t4 || 0).toString()) || 0, i4 = this.isInfinite ? (t4 % e4 + e4) % e4 : Math.max(Math.min(t4, e4 - 1), 0), i4;
    }
    getSlideMetrics(e4) {
      var i4;
      const s4 = this.isHorizontal ? "width" : "height";
      let n4 = 0, o4 = 0, a4 = e4.el;
      if (a4 ? n4 = parseFloat(a4.dataset[s4] || "") || 0 : (a4 = document.createElement("div"), a4.style.visibility = "hidden", w(a4, this.cn("slide") + " " + e4.class), (this.track || document.body).prepend(a4)), n4)
        a4.style[s4] = `${n4}px`, a4.style[s4 === "width" ? "height" : "width"] = "";
      else {
        const t4 = Math.max(1, ((i4 = window.visualViewport) === null || i4 === void 0 ? void 0 : i4.scale) || 1);
        n4 = a4.getBoundingClientRect()[s4] * t4;
      }
      const r4 = getComputedStyle(a4);
      return r4.boxSizing === "content-box" && (this.isHorizontal ? (n4 += parseFloat(r4.paddingLeft) || 0, n4 += parseFloat(r4.paddingRight) || 0) : (n4 += parseFloat(r4.paddingTop) || 0, n4 += parseFloat(r4.paddingBottom) || 0)), o4 = parseFloat(r4[this.isHorizontal ? "marginRight" : "marginBottom"]) || 0, e4.el || a4.remove(), { dim: t(n4, 1e3), gap: t(o4, 1e3) };
    }
    getBounds() {
      const { isInfinite: t4, isRTL: e4, isHorizontal: i4, pages: s4 } = this;
      let n4 = { min: 0, max: 0 };
      if (t4)
        n4 = { min: -1 / 0, max: 1 / 0 };
      else if (s4.length) {
        const t5 = s4[0].pos, o4 = s4[s4.length - 1].pos;
        n4 = e4 && i4 ? { min: t5, max: o4 } : { min: -1 * o4, max: -1 * t5 };
      }
      return { x: i4 ? n4 : { min: 0, max: 0 }, y: i4 ? { min: 0, max: 0 } : n4 };
    }
    repositionSlides() {
      let e4, { isHorizontal: i4, isRTL: s4, isInfinite: n4, viewport: o4, viewportDim: a4, contentDim: r4, page: l4, pages: h4, slides: c4, panzoom: d4 } = this, u4 = 0, g3 = 0, p4 = 0, f3 = 0;
      d4 ? f3 = -1 * d4.current[this.axis] : h4[l4] && (f3 = h4[l4].pos || 0), e4 = i4 ? s4 ? "right" : "left" : "top", s4 && i4 && (f3 *= -1);
      for (const i5 of c4)
        i5.el ? (e4 === "top" ? (i5.el.style.right = "", i5.el.style.left = "") : i5.el.style.top = "", i5.index !== u4 ? i5.el.style[e4] = g3 === 0 ? "" : `${t(g3, 1e3)}px` : i5.el.style[e4] = "", p4 += i5.dim + i5.gap, u4++) : g3 += i5.dim + i5.gap;
      if (n4 && p4 && o4) {
        let s5 = getComputedStyle(o4), n5 = "padding", l5 = i4 ? "Right" : "Bottom", h5 = parseFloat(s5[n5 + (i4 ? "Left" : "Top")]);
        f3 -= h5, a4 += h5, a4 += parseFloat(s5[n5 + l5]);
        for (const i5 of c4)
          i5.el && (t(i5.pos) < t(a4) && t(i5.pos + i5.dim + i5.gap) < t(f3) && t(f3) > t(r4 - a4) && (i5.el.style[e4] = `${t(g3 + p4, 1e3)}px`), t(i5.pos + i5.gap) >= t(r4 - a4) && t(i5.pos) > t(f3 + a4) && t(f3) < t(a4) && (i5.el.style[e4] = `-${t(p4, 1e3)}px`));
      }
      let m3, b3, v3 = [...this.inTransition];
      if (v3.length > 1 && (m3 = h4[v3[0]], b3 = h4[v3[1]]), m3 && b3) {
        let i5 = 0;
        for (const s5 of c4)
          s5.el ? this.inTransition.has(s5.index) && m3.slides.indexOf(s5) < 0 && (s5.el.style[e4] = `${t(i5 + (m3.pos - b3.pos), 1e3)}px`) : i5 += s5.dim + s5.gap;
      }
    }
    createSlideEl(t4) {
      const { track: e4, slides: i4 } = this;
      if (!e4 || !t4)
        return;
      if (t4.el)
        return;
      const s4 = document.createElement("div");
      w(s4, this.cn("slide")), w(s4, t4.class), w(s4, t4.customClass), t4.html && (s4.innerHTML = t4.html);
      const n4 = [];
      i4.forEach((t5, e5) => {
        t5.el && n4.push(e5);
      });
      const o4 = t4.index;
      let a4 = null;
      if (n4.length) {
        a4 = i4[n4.reduce((t5, e5) => Math.abs(e5 - o4) < Math.abs(t5 - o4) ? e5 : t5)];
      }
      const r4 = a4 && a4.el ? a4.index < t4.index ? a4.el.nextSibling : a4.el : null;
      e4.insertBefore(s4, e4.contains(r4) ? r4 : null), t4.el = s4, this.emit("createSlide", t4);
    }
    removeSlideEl(t4, e4 = false) {
      const i4 = t4.el;
      if (!i4)
        return;
      if (x(i4, this.cn("isSelected")), t4.isDom && !e4)
        return i4.removeAttribute("aria-hidden"), i4.removeAttribute("data-index"), x(i4, this.cn("isSelected")), void (i4.style.left = "");
      this.emit("removeSlide", t4);
      const s4 = new CustomEvent("animationend");
      i4.dispatchEvent(s4), t4.el && t4.el.remove(), t4.el = null;
    }
    transitionTo(e4 = 0, i4 = this.option("transition")) {
      if (!i4)
        return false;
      const { pages: s4, panzoom: n4 } = this;
      e4 = parseInt((e4 || 0).toString()) || 0;
      const o4 = this.getPageFromIndex(e4);
      if (!n4 || !s4[o4] || s4.length < 2 || Math.abs(s4[this.page].slides[0].dim - this.viewportDim) > 1)
        return false;
      const a4 = e4 > this.page ? 1 : -1, r4 = this.pages[o4].pos * (this.isRTL ? 1 : -1);
      if (this.page === o4 && t(r4, 1e3) === t(n4.target[this.axis], 1e3))
        return false;
      this.clearTransitions();
      const l4 = n4.isResting;
      w(this.container, this.cn("inTransition"));
      const h4 = this.pages[this.page].slides[0], c4 = this.pages[o4].slides[0];
      this.inTransition.add(c4.index), this.createSlideEl(c4);
      let d4 = h4.el, u4 = c4.el;
      l4 || i4 === "slide" || (i4 = "fadeFast", d4 = null);
      const g3 = this.isRTL ? "next" : "prev", p4 = this.isRTL ? "prev" : "next";
      return d4 && (this.inTransition.add(h4.index), h4.transition = i4, d4.addEventListener("animationend", this.onAnimationEnd), d4.classList.add(`f-${i4}Out`, `to-${a4 > 0 ? p4 : g3}`)), u4 && (c4.transition = i4, u4.addEventListener("animationend", this.onAnimationEnd), u4.classList.add(`f-${i4}In`, `from-${a4 > 0 ? g3 : p4}`)), n4.panTo({ x: this.isHorizontal ? r4 : 0, y: this.isHorizontal ? 0 : r4, friction: 0 }), this.onChange(o4), true;
    }
    manageSlideVisiblity() {
      const t4 = new Set(), e4 = new Set(), i4 = this.getVisibleSlides(parseFloat(this.option("preload", 0) + "") || 0);
      for (const s4 of this.slides)
        i4.has(s4) ? t4.add(s4) : e4.add(s4);
      for (const e5 of this.inTransition)
        t4.add(this.slides[e5]);
      for (const e5 of t4)
        this.createSlideEl(e5), this.lazyLoadSlide(e5);
      for (const i5 of e4)
        t4.has(i5) || this.removeSlideEl(i5);
      this.markSelectedSlides(), this.repositionSlides();
    }
    markSelectedSlides() {
      if (!this.pages[this.page] || !this.pages[this.page].slides)
        return;
      const t4 = "aria-hidden";
      let e4 = this.cn("isSelected");
      if (e4)
        for (const i4 of this.slides)
          i4.el && (i4.el.dataset.index = `${i4.index}`, this.pages[this.page].slides.includes(i4) ? (i4.el.classList.contains(e4) || (w(i4.el, e4), this.emit("selectSlide", i4)), i4.el.removeAttribute(t4)) : (i4.el.classList.contains(e4) && (x(i4.el, e4), this.emit("unselectSlide", i4)), i4.el.setAttribute(t4, "true")));
    }
    flipInfiniteTrack() {
      const t4 = this.panzoom;
      if (!t4 || !this.isInfinite)
        return;
      const e4 = this.option("axis") === "x" ? "e" : "f", { viewportDim: i4, contentDim: s4 } = this;
      let n4 = t4.current[e4], o4 = t4.target[e4] - n4, a4 = 0, r4 = 0.5 * i4, l4 = s4;
      this.isRTL && this.isHorizontal ? (n4 < -r4 && (a4 = -1, n4 += l4), n4 > l4 - r4 && (a4 = 1, n4 -= l4)) : (n4 > r4 && (a4 = 1, n4 -= l4), n4 < -l4 + r4 && (a4 = -1, n4 += l4)), a4 && (t4.current[e4] = n4, t4.target[e4] = n4 + o4);
    }
    lazyLoadSlide(t4) {
      const e4 = this, s4 = t4 && t4.el;
      if (!s4)
        return;
      const n4 = new Set(), o4 = "f-fadeIn";
      s4.querySelectorAll("[data-lazy-srcset]").forEach((t5) => {
        t5 instanceof HTMLImageElement && n4.add(t5);
      });
      let a4 = Array.from(s4.querySelectorAll("[data-lazy-src]"));
      s4.dataset.lazySrc && a4.push(s4), a4.map((t5) => {
        t5 instanceof HTMLImageElement ? n4.add(t5) : y(t5) && (t5.style.backgroundImage = `url('${t5.dataset.lazySrc || ""}')`, delete t5.dataset.lazySrc);
      });
      const r4 = (t5, i4, s5) => {
        s5 && (s5.remove(), s5 = null), i4.complete && (i4.classList.add(o4), setTimeout(() => {
          i4.classList.remove(o4);
        }, 350), i4.style.display = ""), this.option("adaptiveHeight") && t5.el && this.pages[this.page].slides.indexOf(t5) > -1 && (e4.updateMetrics(), e4.setViewportHeight()), this.emit("load", t5);
      };
      for (const e5 of n4) {
        let s5 = null;
        e5.src = e5.dataset.lazySrcset || e5.dataset.lazySrc || "", delete e5.dataset.lazySrc, delete e5.dataset.lazySrcset, e5.style.display = "none", e5.addEventListener("error", () => {
          r4(t4, e5, s5);
        }), e5.addEventListener("load", () => {
          r4(t4, e5, s5);
        }), setTimeout(() => {
          e5.parentNode && t4.el && (e5.complete ? r4(t4, e5, s5) : (s5 = i(v), e5.parentNode.insertBefore(s5, e5)));
        }, 300);
      }
    }
    onAnimationEnd(t4) {
      var e4;
      const i4 = t4.target, s4 = i4 ? parseInt(i4.dataset.index || "", 10) || 0 : -1, n4 = this.slides[s4], o4 = t4.animationName;
      if (!i4 || !n4 || !o4)
        return;
      const a4 = !!this.inTransition.has(s4) && n4.transition;
      a4 && o4.substring(0, a4.length + 2) === `f-${a4}` && this.inTransition.delete(s4), this.inTransition.size || this.clearTransitions(), s4 === this.page && ((e4 = this.panzoom) === null || e4 === void 0 ? void 0 : e4.isResting) && this.emit("settle");
    }
    onDecel(t4, e4 = 0, i4 = 0, s4 = 0, n4 = 0) {
      const { isRTL: o4, isHorizontal: a4, axis: r4, pages: l4 } = this, h4 = l4.length, c4 = Math.abs(Math.atan2(i4, e4) / (Math.PI / 180));
      let d4 = 0;
      if (d4 = c4 > 45 && c4 < 135 ? a4 ? 0 : i4 : a4 ? e4 : 0, !h4)
        return;
      const u4 = this.option("dragFree");
      let g3 = this.page, p4 = o4 && a4 ? 1 : -1;
      const f3 = t4.target[r4] * p4, m3 = t4.current[r4] * p4;
      let { pageIndex: b3 } = this.getPageFromPosition(f3), { pageIndex: v3 } = this.getPageFromPosition(m3);
      u4 ? this.onChange(b3) : (Math.abs(d4) > 5 ? (l4[g3].dim < document.documentElement["client" + (this.isHorizontal ? "Width" : "Height")] - 1 && (g3 = v3), g3 = o4 && a4 ? d4 < 0 ? g3 - 1 : g3 + 1 : d4 < 0 ? g3 + 1 : g3 - 1) : g3 = s4 === 0 && n4 === 0 ? g3 : v3, this.slideTo(g3, { transition: false, friction: t4.option("decelFriction") }));
    }
    onClick(t4) {
      const e4 = t4.target, i4 = e4 && y(e4) ? e4.dataset : null;
      let s4, n4;
      i4 && (i4.carouselPage !== void 0 ? (n4 = "slideTo", s4 = i4.carouselPage) : i4.carouselNext !== void 0 ? n4 = "slideNext" : i4.carouselPrev !== void 0 && (n4 = "slidePrev")), n4 ? (t4.preventDefault(), t4.stopPropagation(), e4 && !e4.hasAttribute("disabled") && this[n4](s4)) : this.emit("click", t4);
    }
    onSlideTo(t4) {
      const e4 = t4.detail || 0;
      this.slideTo(this.getPageForSlide(e4), { friction: 0 });
    }
    onChange(t4, e4 = 0) {
      const i4 = this.page;
      this.prevPage = i4, this.page = t4, this.option("adaptiveHeight") && this.setViewportHeight(), t4 !== i4 && (this.markSelectedSlides(), this.emit("change", t4, i4, e4));
    }
    onRefresh() {
      let t4 = this.contentDim, e4 = this.viewportDim;
      this.updateMetrics(), this.contentDim === t4 && this.viewportDim === e4 || this.slideTo(this.page, { friction: 0, transition: false });
    }
    onResize() {
      this.option("breakpoints") && this.processOptions();
    }
    onBeforeTransform(t4) {
      this.lp !== t4.current[this.axis] && (this.flipInfiniteTrack(), this.manageSlideVisiblity()), this.lp = t4.current.e;
    }
    onEndAnimation() {
      this.inTransition.size || this.emit("settle");
    }
    reInit(t4 = null, e4 = null) {
      this.destroy(), this.state = k.Init, this.userOptions = t4 || this.userOptions, this.userPlugins = e4 || this.userPlugins, this.processOptions();
    }
    slideTo(t4 = 0, { friction: e4 = this.option("friction"), transition: i4 = this.option("transition") } = {}) {
      if (this.state === k.Destroy)
        return;
      const { axis: s4, isHorizontal: n4, isRTL: o4, pages: a4, panzoom: r4 } = this, l4 = a4.length, h4 = o4 && n4 ? 1 : -1;
      if (!r4 || !l4)
        return;
      if (this.transitionTo(t4, i4))
        return;
      const c4 = this.getPageFromIndex(t4);
      let d4 = a4[c4].pos;
      if (this.isInfinite) {
        const e5 = this.contentDim, i5 = r4.target[s4] * h4;
        if (l4 === 2)
          d4 += e5 * Math.floor(parseFloat(t4 + "") / 2);
        else {
          const t5 = i5;
          d4 = [d4, d4 - e5, d4 + e5].reduce(function(e6, i6) {
            return Math.abs(i6 - t5) < Math.abs(e6 - t5) ? i6 : e6;
          });
        }
      }
      d4 *= h4, Math.abs(r4.target[s4] - d4) < 0.1 || (r4.panTo({ x: n4 ? d4 : 0, y: n4 ? 0 : d4, friction: e4 }), this.onChange(c4));
    }
    slideToClosest(t4) {
      if (this.panzoom) {
        const { pageIndex: e4 } = this.getPageFromPosition(this.panzoom.current[this.isHorizontal ? "e" : "f"]);
        this.slideTo(e4, t4);
      }
    }
    slideNext() {
      this.slideTo(this.page + 1);
    }
    slidePrev() {
      this.slideTo(this.page - 1);
    }
    clearTransitions() {
      this.inTransition.clear(), x(this.container, this.cn("inTransition"));
      const t4 = ["to-prev", "to-next", "from-prev", "from-next"];
      for (const e4 of this.slides) {
        const i4 = e4.el;
        if (i4) {
          i4.removeEventListener("animationend", this.onAnimationEnd), i4.classList.remove(...t4);
          const s4 = e4.transition;
          s4 && i4.classList.remove(`f-${s4}Out`, `f-${s4}In`);
        }
      }
      this.manageSlideVisiblity();
    }
    prependSlide(t4) {
      var e4, i4;
      let s4 = Array.isArray(t4) ? t4 : [t4];
      for (const t5 of s4.reverse())
        this.slides.unshift(R(t5));
      for (let t5 = 0; t5 < this.slides.length; t5++)
        this.slides[t5].index = t5;
      const n4 = ((e4 = this.pages[this.page]) === null || e4 === void 0 ? void 0 : e4.pos) || 0;
      this.page += s4.length, this.updateMetrics();
      const o4 = ((i4 = this.pages[this.page]) === null || i4 === void 0 ? void 0 : i4.pos) || 0;
      if (this.panzoom) {
        const t5 = this.isRTL ? n4 - o4 : o4 - n4;
        this.panzoom.target.e -= t5, this.panzoom.current.e -= t5, this.panzoom.requestTick();
      }
    }
    appendSlide(t4) {
      let e4 = Array.isArray(t4) ? t4 : [t4];
      for (const t5 of e4) {
        const e5 = R(t5);
        e5.index = this.slides.length, this.slides.push(e5), this.emit("initSlide", t5, this.slides.length);
      }
      this.updateMetrics();
    }
    removeSlide(t4) {
      const e4 = this.slides.length;
      t4 = (t4 % e4 + e4) % e4, this.removeSlideEl(this.slides[t4], true), this.slides.splice(t4, 1);
      for (let t5 = 0; t5 < this.slides.length; t5++)
        this.slides[t5].index = t5;
      this.updateMetrics(), this.slideTo(this.page, { friction: 0, transition: false });
    }
    updateMetrics() {
      const { panzoom: e4, viewport: i4, track: s4, isHorizontal: n4 } = this;
      if (!s4)
        return;
      const o4 = n4 ? "width" : "height", a4 = n4 ? "offsetWidth" : "offsetHeight";
      if (i4) {
        let e5 = Math.max(i4[a4], t(i4.getBoundingClientRect()[o4], 1e3)), s5 = getComputedStyle(i4), r5 = "padding", l5 = n4 ? "Right" : "Bottom";
        e5 -= parseFloat(s5[r5 + (n4 ? "Left" : "Top")]) + parseFloat(s5[r5 + l5]), this.viewportDim = e5;
      }
      let r4, l4 = this.pages.length, h4 = 0;
      for (const [e5, i5] of this.slides.entries()) {
        let s5 = 0, n5 = 0;
        !i5.el && r4 ? (s5 = r4.dim, n5 = r4.gap) : ({ dim: s5, gap: n5 } = this.getSlideMetrics(i5), r4 = i5), s5 = t(s5, 1e3), n5 = t(n5, 1e3), i5.dim = s5, i5.gap = n5, i5.pos = h4, h4 += s5, (this.isInfinite || e5 < this.slides.length - 1) && (h4 += n5);
      }
      const c4 = this.contentDim;
      h4 = t(h4, 1e3), this.contentDim = h4, e4 && (e4.contentRect[o4] = h4, e4.contentRect[this.axis === "e" ? "fullWidth" : "fullHeight"] = h4), this.pages = this.createPages(), this.pages = this.processPages(), this.state === k.Init && this.setInitialPage(), this.page = Math.max(0, Math.min(this.page, this.pages.length - 1)), e4 && l4 === this.pages.length && Math.abs(h4 - c4) > 0.5 && (e4.target[this.axis] = -1 * this.pages[this.page].pos, e4.current[this.axis] = -1 * this.pages[this.page].pos, e4.stop()), this.manageSlideVisiblity(), this.emit("refresh");
    }
    getProgress(e4, i4 = false) {
      e4 === void 0 && (e4 = this.page);
      const s4 = this, n4 = s4.panzoom, o4 = s4.pages[e4] || 0;
      if (!o4 || !n4)
        return 0;
      let a4 = -1 * n4.current.e, r4 = s4.contentDim;
      var l4 = [t((a4 - o4.pos) / (1 * o4.dim), 1e3), t((a4 + r4 - o4.pos) / (1 * o4.dim), 1e3), t((a4 - r4 - o4.pos) / (1 * o4.dim), 1e3)].reduce(function(t4, e5) {
        return Math.abs(e5) < Math.abs(t4) ? e5 : t4;
      });
      return i4 ? l4 : Math.max(-1, Math.min(1, l4));
    }
    setViewportHeight() {
      const { page: t4, pages: e4, viewport: i4, isHorizontal: s4 } = this;
      if (!i4 || !e4[t4])
        return;
      let n4 = 0;
      s4 && this.track && (this.track.style.height = "auto", e4[t4].slides.forEach((t5) => {
        t5.el && (n4 = Math.max(n4, t5.el.offsetHeight));
      })), i4.style.height = n4 ? `${n4}px` : "";
    }
    getPageForSlide(t4) {
      for (const e4 of this.pages)
        for (const i4 of e4.slides)
          if (i4.index === t4)
            return e4.index;
      return -1;
    }
    getVisibleSlides(t4 = 0) {
      var e4;
      const i4 = new Set();
      let { contentDim: s4, viewportDim: n4, pages: o4, page: a4 } = this;
      s4 = s4 + ((e4 = this.slides[this.slides.length - 1]) === null || e4 === void 0 ? void 0 : e4.gap) || 0;
      let r4 = 0;
      r4 = this.panzoom ? -1 * this.panzoom.current[this.axis] : o4[a4] && o4[a4].pos || 0, this.isInfinite && (r4 -= Math.floor(r4 / s4) * s4), this.isRTL && this.isHorizontal && (r4 *= -1);
      const l4 = r4 - n4 * t4, h4 = r4 + n4 * (t4 + 1), c4 = this.isInfinite ? [-1, 0, 1] : [0];
      for (const t5 of this.slides)
        for (const e5 of c4) {
          const n5 = t5.pos + e5 * s4, o5 = t5.pos + t5.dim + t5.gap + e5 * s4;
          n5 < h4 && o5 > l4 && i4.add(t5);
        }
      return i4;
    }
    getPageFromPosition(t4) {
      const { viewportDim: e4, contentDim: i4 } = this, s4 = this.pages.length, n4 = this.slides.length, o4 = this.slides[n4 - 1];
      let a4 = 0, r4 = 0, l4 = 0;
      const h4 = this.option("center");
      h4 && (t4 += 0.5 * e4), this.isInfinite || (t4 = Math.max(this.slides[0].pos, Math.min(t4, o4.pos)));
      const c4 = i4 + o4.gap;
      l4 = Math.floor(t4 / c4) || 0, t4 -= l4 * c4;
      let d4 = o4, u4 = this.slides.find((e5) => {
        const i5 = t4 + (d4 && !h4 ? 0.5 * d4.dim : 0);
        return d4 = e5, e5.pos <= i5 && e5.pos + e5.dim + e5.gap > i5;
      });
      return u4 || (u4 = o4), r4 = this.getPageForSlide(u4.index), a4 = r4 + l4 * s4, { page: a4, pageIndex: r4 };
    }
    destroy() {
      if ([k.Destroy].includes(this.state))
        return;
      this.state = k.Destroy;
      const { container: t4, viewport: e4, track: i4, slides: s4, panzoom: n4 } = this, o4 = this.option("classes");
      t4.removeEventListener("click", this.onClick, { passive: false, capture: false }), t4.removeEventListener("slideTo", this.onSlideTo), window.removeEventListener("resize", this.onResize), n4 && (n4.destroy(), this.panzoom = null), s4 && s4.forEach((t5) => {
        this.removeSlideEl(t5);
      }), this.detachPlugins(), e4 && e4.offsetParent && i4 && i4.offsetParent && e4.replaceWith(...i4.childNodes);
      for (const [e5, i5] of Object.entries(o4))
        e5 !== "container" && i5 && t4.classList.remove(i5);
      this.track = null, this.viewport = null, this.page = 0, this.slides = [];
      const a4 = this.events.get("ready");
      this.events = new Map(), a4 && this.events.set("ready", a4);
    }
  };
  Object.defineProperty(H, "Panzoom", { enumerable: true, configurable: true, writable: true, value: M }), Object.defineProperty(H, "defaults", { enumerable: true, configurable: true, writable: true, value: z }), Object.defineProperty(H, "Plugins", { enumerable: true, configurable: true, writable: true, value: I });

  // node_modules/@fancyapps/ui/dist/fancybox/fancybox.esm.js
  var t2 = (t4, e4 = 1e4) => (t4 = parseFloat(t4 + "") || 0, Math.round((t4 + Number.EPSILON) * e4) / e4);
  var e2 = function(t4) {
    if (!(t4 && t4 instanceof Element && t4.offsetParent))
      return false;
    const e4 = t4.scrollHeight > t4.clientHeight, i4 = window.getComputedStyle(t4).overflowY, n4 = i4.indexOf("hidden") !== -1, s4 = i4.indexOf("visible") !== -1;
    return e4 && !n4 && !s4;
  };
  var i2 = function(t4, n4) {
    return !(!t4 || t4 === document.body || n4 && t4 === n4) && (e2(t4) ? t4 : i2(t4.parentElement, n4));
  };
  var n2 = function(t4) {
    var e4 = new DOMParser().parseFromString(t4, "text/html").body;
    if (e4.childElementCount > 1) {
      for (var i4 = document.createElement("div"); e4.firstChild; )
        i4.appendChild(e4.firstChild);
      return i4;
    }
    return e4.firstChild;
  };
  var s2 = (t4) => `${t4 || ""}`.split(" ").filter((t5) => !!t5);
  var o2 = (t4, e4, i4) => {
    s2(e4).forEach((e5) => {
      t4 && t4.classList.toggle(e5, i4 || false);
    });
  };
  var a2 = class {
    constructor(t4) {
      Object.defineProperty(this, "pageX", { enumerable: true, configurable: true, writable: true, value: void 0 }), Object.defineProperty(this, "pageY", { enumerable: true, configurable: true, writable: true, value: void 0 }), Object.defineProperty(this, "clientX", { enumerable: true, configurable: true, writable: true, value: void 0 }), Object.defineProperty(this, "clientY", { enumerable: true, configurable: true, writable: true, value: void 0 }), Object.defineProperty(this, "id", { enumerable: true, configurable: true, writable: true, value: void 0 }), Object.defineProperty(this, "time", { enumerable: true, configurable: true, writable: true, value: void 0 }), Object.defineProperty(this, "nativePointer", { enumerable: true, configurable: true, writable: true, value: void 0 }), this.nativePointer = t4, this.pageX = t4.pageX, this.pageY = t4.pageY, this.clientX = t4.clientX, this.clientY = t4.clientY, this.id = self.Touch && t4 instanceof Touch ? t4.identifier : -1, this.time = Date.now();
    }
  };
  var r2 = { passive: false };
  var l2 = class {
    constructor(t4, { start: e4 = () => true, move: i4 = () => {
    }, end: n4 = () => {
    } }) {
      Object.defineProperty(this, "element", { enumerable: true, configurable: true, writable: true, value: void 0 }), Object.defineProperty(this, "startCallback", { enumerable: true, configurable: true, writable: true, value: void 0 }), Object.defineProperty(this, "moveCallback", { enumerable: true, configurable: true, writable: true, value: void 0 }), Object.defineProperty(this, "endCallback", { enumerable: true, configurable: true, writable: true, value: void 0 }), Object.defineProperty(this, "currentPointers", { enumerable: true, configurable: true, writable: true, value: [] }), Object.defineProperty(this, "startPointers", { enumerable: true, configurable: true, writable: true, value: [] }), this.element = t4, this.startCallback = e4, this.moveCallback = i4, this.endCallback = n4;
      for (const t5 of ["onPointerStart", "onTouchStart", "onMove", "onTouchEnd", "onPointerEnd", "onWindowBlur"])
        this[t5] = this[t5].bind(this);
      this.element.addEventListener("mousedown", this.onPointerStart, r2), this.element.addEventListener("touchstart", this.onTouchStart, r2), this.element.addEventListener("touchmove", this.onMove, r2), this.element.addEventListener("touchend", this.onTouchEnd), this.element.addEventListener("touchcancel", this.onTouchEnd);
    }
    onPointerStart(t4) {
      if (!t4.buttons || t4.button !== 0)
        return;
      const e4 = new a2(t4);
      this.currentPointers.some((t5) => t5.id === e4.id) || this.triggerPointerStart(e4, t4) && (window.addEventListener("mousemove", this.onMove), window.addEventListener("mouseup", this.onPointerEnd), window.addEventListener("blur", this.onWindowBlur));
    }
    onTouchStart(t4) {
      for (const e4 of Array.from(t4.changedTouches || []))
        this.triggerPointerStart(new a2(e4), t4);
      window.addEventListener("blur", this.onWindowBlur);
    }
    onMove(t4) {
      const e4 = this.currentPointers.slice(), i4 = "changedTouches" in t4 ? Array.from(t4.changedTouches || []).map((t5) => new a2(t5)) : [new a2(t4)], n4 = [];
      for (const t5 of i4) {
        const e5 = this.currentPointers.findIndex((e6) => e6.id === t5.id);
        e5 < 0 || (n4.push(t5), this.currentPointers[e5] = t5);
      }
      n4.length && this.moveCallback(t4, this.currentPointers.slice(), e4);
    }
    onPointerEnd(t4) {
      t4.buttons > 0 && t4.button !== 0 || (this.triggerPointerEnd(t4, new a2(t4)), window.removeEventListener("mousemove", this.onMove), window.removeEventListener("mouseup", this.onPointerEnd), window.removeEventListener("blur", this.onWindowBlur));
    }
    onTouchEnd(t4) {
      for (const e4 of Array.from(t4.changedTouches || []))
        this.triggerPointerEnd(t4, new a2(e4));
    }
    triggerPointerStart(t4, e4) {
      return !!this.startCallback(e4, t4, this.currentPointers.slice()) && (this.currentPointers.push(t4), this.startPointers.push(t4), true);
    }
    triggerPointerEnd(t4, e4) {
      const i4 = this.currentPointers.findIndex((t5) => t5.id === e4.id);
      i4 < 0 || (this.currentPointers.splice(i4, 1), this.startPointers.splice(i4, 1), this.endCallback(t4, e4, this.currentPointers.slice()));
    }
    onWindowBlur() {
      this.clear();
    }
    clear() {
      for (; this.currentPointers.length; ) {
        const t4 = this.currentPointers[this.currentPointers.length - 1];
        this.currentPointers.splice(this.currentPointers.length - 1, 1), this.startPointers.splice(this.currentPointers.length - 1, 1), this.endCallback(new Event("touchend", { bubbles: true, cancelable: true, clientX: t4.clientX, clientY: t4.clientY }), t4, this.currentPointers.slice());
      }
    }
    stop() {
      this.element.removeEventListener("mousedown", this.onPointerStart, r2), this.element.removeEventListener("touchstart", this.onTouchStart, r2), this.element.removeEventListener("touchmove", this.onMove, r2), this.element.removeEventListener("touchend", this.onTouchEnd), this.element.removeEventListener("touchcancel", this.onTouchEnd), window.removeEventListener("mousemove", this.onMove), window.removeEventListener("mouseup", this.onPointerEnd), window.removeEventListener("blur", this.onWindowBlur);
    }
  };
  function c2(t4, e4) {
    return e4 ? Math.sqrt(Math.pow(e4.clientX - t4.clientX, 2) + Math.pow(e4.clientY - t4.clientY, 2)) : 0;
  }
  function h2(t4, e4) {
    return e4 ? { clientX: (t4.clientX + e4.clientX) / 2, clientY: (t4.clientY + e4.clientY) / 2 } : t4;
  }
  var d2 = (t4) => typeof t4 == "object" && t4 !== null && t4.constructor === Object && Object.prototype.toString.call(t4) === "[object Object]";
  var u2 = (t4, ...e4) => {
    const i4 = e4.length;
    for (let n4 = 0; n4 < i4; n4++) {
      const i5 = e4[n4] || {};
      Object.entries(i5).forEach(([e5, i6]) => {
        const n5 = Array.isArray(i6) ? [] : {};
        t4[e5] || Object.assign(t4, { [e5]: n5 }), d2(i6) ? Object.assign(t4[e5], u2(n5, i6)) : Array.isArray(i6) ? Object.assign(t4, { [e5]: [...i6] }) : Object.assign(t4, { [e5]: i6 });
      });
    }
    return t4;
  };
  var p2 = function(t4, e4) {
    return t4.split(".").reduce((t5, e5) => typeof t5 == "object" ? t5[e5] : void 0, e4);
  };
  var f2 = class {
    constructor(t4 = {}) {
      Object.defineProperty(this, "options", { enumerable: true, configurable: true, writable: true, value: t4 }), Object.defineProperty(this, "events", { enumerable: true, configurable: true, writable: true, value: new Map() }), this.setOptions(t4);
      for (const t5 of Object.getOwnPropertyNames(Object.getPrototypeOf(this)))
        t5.startsWith("on") && typeof this[t5] == "function" && (this[t5] = this[t5].bind(this));
    }
    setOptions(t4) {
      this.options = t4 ? u2({}, this.constructor.defaults, t4) : {};
      for (const [t5, e4] of Object.entries(this.option("on") || {}))
        this.on(t5, e4);
    }
    option(t4, ...e4) {
      let i4 = p2(t4, this.options);
      return i4 && typeof i4 == "function" && (i4 = i4.call(this, this, ...e4)), i4;
    }
    optionFor(t4, e4, i4, ...n4) {
      let s4 = p2(e4, t4);
      var o4;
      typeof (o4 = s4) != "string" || isNaN(o4) || isNaN(parseFloat(o4)) || (s4 = parseFloat(s4)), s4 === "true" && (s4 = true), s4 === "false" && (s4 = false), s4 && typeof s4 == "function" && (s4 = s4.call(this, this, t4, ...n4));
      let a4 = p2(e4, this.options);
      return a4 && typeof a4 == "function" ? s4 = a4.call(this, this, t4, ...n4, s4) : s4 === void 0 && (s4 = a4), s4 === void 0 ? i4 : s4;
    }
    cn(t4) {
      const e4 = this.options.classes;
      return e4 && e4[t4] || "";
    }
    localize(t4, e4 = []) {
      t4 = String(t4).replace(/\{\{(\w+).?(\w+)?\}\}/g, (t5, e5, i4) => {
        let n4 = "";
        return i4 ? n4 = this.option(`${e5[0] + e5.toLowerCase().substring(1)}.l10n.${i4}`) : e5 && (n4 = this.option(`l10n.${e5}`)), n4 || (n4 = t5), n4;
      });
      for (let i4 = 0; i4 < e4.length; i4++)
        t4 = t4.split(e4[i4][0]).join(e4[i4][1]);
      return t4 = t4.replace(/\{\{(.*?)\}\}/g, (t5, e5) => e5);
    }
    on(t4, e4) {
      let i4 = [];
      typeof t4 == "string" ? i4 = t4.split(" ") : Array.isArray(t4) && (i4 = t4), this.events || (this.events = new Map()), i4.forEach((t5) => {
        let i5 = this.events.get(t5);
        i5 || (this.events.set(t5, []), i5 = []), i5.includes(e4) || i5.push(e4), this.events.set(t5, i5);
      });
    }
    off(t4, e4) {
      let i4 = [];
      typeof t4 == "string" ? i4 = t4.split(" ") : Array.isArray(t4) && (i4 = t4), i4.forEach((t5) => {
        const i5 = this.events.get(t5);
        if (Array.isArray(i5)) {
          const t6 = i5.indexOf(e4);
          t6 > -1 && i5.splice(t6, 1);
        }
      });
    }
    emit(t4, ...e4) {
      [...this.events.get(t4) || []].forEach((t5) => t5(this, ...e4)), t4 !== "*" && this.emit("*", t4, ...e4);
    }
  };
  Object.defineProperty(f2, "version", { enumerable: true, configurable: true, writable: true, value: "5.0.19" }), Object.defineProperty(f2, "defaults", { enumerable: true, configurable: true, writable: true, value: {} });
  var m2 = class extends f2 {
    constructor(t4 = {}) {
      super(t4), Object.defineProperty(this, "plugins", { enumerable: true, configurable: true, writable: true, value: {} });
    }
    attachPlugins(t4 = {}) {
      const e4 = new Map();
      for (const [i4, n4] of Object.entries(t4)) {
        const t5 = this.option(i4), s4 = this.plugins[i4];
        s4 || t5 === false ? s4 && t5 === false && (s4.detach(), delete this.plugins[i4]) : e4.set(i4, new n4(this, t5 || {}));
      }
      for (const [t5, i4] of e4)
        this.plugins[t5] = i4, i4.attach();
      this.emit("attachPlugins");
    }
    detachPlugins(t4) {
      t4 = t4 || Object.keys(this.plugins);
      for (const e4 of t4) {
        const t5 = this.plugins[e4];
        t5 && t5.detach(), delete this.plugins[e4];
      }
      return this.emit("detachPlugins"), this;
    }
  };
  var g2;
  !function(t4) {
    t4[t4.Init = 0] = "Init", t4[t4.Error = 1] = "Error", t4[t4.Ready = 2] = "Ready", t4[t4.Panning = 3] = "Panning", t4[t4.Mousemove = 4] = "Mousemove", t4[t4.Destroy = 5] = "Destroy";
  }(g2 || (g2 = {}));
  var b2 = ["a", "b", "c", "d", "e", "f"];
  var v2 = { PANUP: "Move up", PANDOWN: "Move down", PANLEFT: "Move left", PANRIGHT: "Move right", ZOOMIN: "Zoom in", ZOOMOUT: "Zoom out", TOGGLEZOOM: "Toggle zoom level", TOGGLE1TO1: "Toggle zoom level", ITERATEZOOM: "Toggle zoom level", ROTATECCW: "Rotate counterclockwise", ROTATECW: "Rotate clockwise", FLIPX: "Flip horizontally", FLIPY: "Flip vertically", FITX: "Fit horizontally", FITY: "Fit vertically", RESET: "Reset", TOGGLEFS: "Toggle fullscreen" };
  var y2 = { content: null, width: "auto", height: "auto", panMode: "drag", touch: true, dragMinThreshold: 3, lockAxis: false, mouseMoveFactor: 1, mouseMoveFriction: 0.12, zoom: true, pinchToZoom: true, panOnlyZoomed: "auto", minScale: 1, maxScale: 2, friction: 0.25, dragFriction: 0.35, decelFriction: 0.05, click: "toggleZoom", dblClick: false, wheel: "zoom", wheelLimit: 7, spinner: true, bounds: "auto", infinite: false, rubberband: true, bounce: true, maxVelocity: 75, transformParent: false, classes: { content: "f-panzoom__content", isLoading: "is-loading", canZoomIn: "can-zoom_in", canZoomOut: "can-zoom_out", isDraggable: "is-draggable", isDragging: "is-dragging", inFullscreen: "in-fullscreen", htmlHasFullscreen: "with-panzoom-in-fullscreen" }, l10n: v2 };
  var w2 = '<div class="f-spinner"><svg viewBox="0 0 50 50"><circle cx="25" cy="25" r="20"></circle><circle cx="25" cy="25" r="20"></circle></svg></div>';
  var x2 = (t4) => t4 && t4 !== null && t4 instanceof Element && "nodeType" in t4;
  var S2 = (t4, e4) => {
    t4 && s2(e4).forEach((e5) => {
      t4.classList.remove(e5);
    });
  };
  var E2 = (t4, e4) => {
    t4 && s2(e4).forEach((e5) => {
      t4.classList.add(e5);
    });
  };
  var P2 = { a: 1, b: 0, c: 0, d: 1, e: 0, f: 0 };
  var C2 = null;
  var M2 = null;
  var T2 = class extends m2 {
    get isTouchDevice() {
      return M2 === null && (M2 = window.matchMedia("(hover: none)").matches), M2;
    }
    get isMobile() {
      return C2 === null && (C2 = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent)), C2;
    }
    get panMode() {
      return this.options.panMode !== "mousemove" || this.isTouchDevice ? "drag" : "mousemove";
    }
    get panOnlyZoomed() {
      const t4 = this.options.panOnlyZoomed;
      return t4 === "auto" ? this.isTouchDevice : t4;
    }
    get isInfinite() {
      return this.option("infinite");
    }
    get angle() {
      return 180 * Math.atan2(this.current.b, this.current.a) / Math.PI || 0;
    }
    get targetAngle() {
      return 180 * Math.atan2(this.target.b, this.target.a) / Math.PI || 0;
    }
    get scale() {
      const { a: t4, b: e4 } = this.current;
      return Math.sqrt(t4 * t4 + e4 * e4) || 1;
    }
    get targetScale() {
      const { a: t4, b: e4 } = this.target;
      return Math.sqrt(t4 * t4 + e4 * e4) || 1;
    }
    get minScale() {
      return this.option("minScale") || 1;
    }
    get fullScale() {
      const { contentRect: t4 } = this;
      return t4.fullWidth / t4.fitWidth || 1;
    }
    get maxScale() {
      return this.fullScale * (this.option("maxScale") || 1) || 1;
    }
    get coverScale() {
      const { containerRect: t4, contentRect: e4 } = this, i4 = Math.max(t4.height / e4.fitHeight, t4.width / e4.fitWidth) || 1;
      return Math.min(this.fullScale, i4);
    }
    get isScaling() {
      return Math.abs(this.targetScale - this.scale) > 1e-5 && !this.isResting;
    }
    get isContentLoading() {
      const t4 = this.content;
      return !!(t4 && t4 instanceof HTMLImageElement) && !t4.complete;
    }
    get isResting() {
      if (this.isBouncingX || this.isBouncingY)
        return false;
      for (const t4 of b2) {
        const e4 = t4 == "e" || t4 === "f" ? 1e-3 : 1e-5;
        if (Math.abs(this.target[t4] - this.current[t4]) > e4)
          return false;
      }
      return !(!this.ignoreBounds && !this.checkBounds().inBounds);
    }
    constructor(t4, e4 = {}, i4 = {}) {
      var s4;
      if (super(e4), Object.defineProperty(this, "pointerTracker", { enumerable: true, configurable: true, writable: true, value: null }), Object.defineProperty(this, "resizeObserver", { enumerable: true, configurable: true, writable: true, value: null }), Object.defineProperty(this, "updateTimer", { enumerable: true, configurable: true, writable: true, value: null }), Object.defineProperty(this, "clickTimer", { enumerable: true, configurable: true, writable: true, value: null }), Object.defineProperty(this, "rAF", { enumerable: true, configurable: true, writable: true, value: null }), Object.defineProperty(this, "isTicking", { enumerable: true, configurable: true, writable: true, value: false }), Object.defineProperty(this, "friction", { enumerable: true, configurable: true, writable: true, value: 0 }), Object.defineProperty(this, "ignoreBounds", { enumerable: true, configurable: true, writable: true, value: false }), Object.defineProperty(this, "isBouncingX", { enumerable: true, configurable: true, writable: true, value: false }), Object.defineProperty(this, "isBouncingY", { enumerable: true, configurable: true, writable: true, value: false }), Object.defineProperty(this, "clicks", { enumerable: true, configurable: true, writable: true, value: 0 }), Object.defineProperty(this, "trackingPoints", { enumerable: true, configurable: true, writable: true, value: [] }), Object.defineProperty(this, "pwt", { enumerable: true, configurable: true, writable: true, value: 0 }), Object.defineProperty(this, "cwd", { enumerable: true, configurable: true, writable: true, value: 0 }), Object.defineProperty(this, "pmme", { enumerable: true, configurable: true, writable: true, value: void 0 }), Object.defineProperty(this, "state", { enumerable: true, configurable: true, writable: true, value: g2.Init }), Object.defineProperty(this, "isDragging", { enumerable: true, configurable: true, writable: true, value: false }), Object.defineProperty(this, "container", { enumerable: true, configurable: true, writable: true, value: void 0 }), Object.defineProperty(this, "content", { enumerable: true, configurable: true, writable: true, value: void 0 }), Object.defineProperty(this, "spinner", { enumerable: true, configurable: true, writable: true, value: null }), Object.defineProperty(this, "containerRect", { enumerable: true, configurable: true, writable: true, value: { width: 0, height: 0, innerWidth: 0, innerHeight: 0 } }), Object.defineProperty(this, "contentRect", { enumerable: true, configurable: true, writable: true, value: { top: 0, right: 0, bottom: 0, left: 0, fullWidth: 0, fullHeight: 0, fitWidth: 0, fitHeight: 0, width: 0, height: 0 } }), Object.defineProperty(this, "dragStart", { enumerable: true, configurable: true, writable: true, value: { x: 0, y: 0, top: 0, left: 0, time: 0 } }), Object.defineProperty(this, "dragOffset", { enumerable: true, configurable: true, writable: true, value: { x: 0, y: 0, time: 0 } }), Object.defineProperty(this, "current", { enumerable: true, configurable: true, writable: true, value: Object.assign({}, P2) }), Object.defineProperty(this, "target", { enumerable: true, configurable: true, writable: true, value: Object.assign({}, P2) }), Object.defineProperty(this, "velocity", { enumerable: true, configurable: true, writable: true, value: { a: 0, b: 0, c: 0, d: 0, e: 0, f: 0 } }), Object.defineProperty(this, "lockedAxis", { enumerable: true, configurable: true, writable: true, value: false }), !t4)
        throw new Error("Container Element Not Found");
      this.container = t4, this.initContent(), this.attachPlugins(Object.assign(Object.assign({}, T2.Plugins), i4)), this.emit("init");
      const o4 = this.content;
      if (o4.addEventListener("load", this.onLoad), o4.addEventListener("error", this.onError), this.isContentLoading) {
        if (this.option("spinner")) {
          t4.classList.add(this.cn("isLoading"));
          const e5 = n2(w2);
          !t4.contains(o4) || o4.parentElement instanceof HTMLPictureElement ? this.spinner = t4.appendChild(e5) : this.spinner = ((s4 = o4.parentElement) === null || s4 === void 0 ? void 0 : s4.insertBefore(e5, o4)) || null;
        }
        this.emit("beforeLoad");
      } else
        queueMicrotask(() => {
          this.enable();
        });
    }
    initContent() {
      const { container: t4 } = this, e4 = this.cn("content");
      let i4 = this.option("content") || t4.querySelector(`.${e4}`);
      if (i4 || (i4 = t4.querySelector("img,picture") || t4.firstElementChild, i4 && E2(i4, e4)), i4 instanceof HTMLPictureElement && (i4 = i4.querySelector("img")), !i4)
        throw new Error("No content found");
      this.content = i4;
    }
    onLoad() {
      this.spinner && (this.spinner.remove(), this.spinner = null), this.option("spinner") && this.container.classList.remove(this.cn("isLoading")), this.emit("afterLoad"), this.state === g2.Init ? this.enable() : this.updateMetrics();
    }
    onError() {
      this.state !== g2.Destroy && (this.spinner && (this.spinner.remove(), this.spinner = null), this.stop(), this.detachEvents(), this.state = g2.Error, this.emit("error"));
    }
    attachObserver() {
      var t4;
      const e4 = () => Math.abs(this.containerRect.width - this.container.getBoundingClientRect().width) > 0.1 || Math.abs(this.containerRect.height - this.container.getBoundingClientRect().height) > 0.1;
      this.resizeObserver || window.ResizeObserver === void 0 || (this.resizeObserver = new ResizeObserver(() => {
        this.updateTimer || (e4() ? (this.onResize(), this.isMobile && (this.updateTimer = setTimeout(() => {
          e4() && this.onResize(), this.updateTimer = null;
        }, 500))) : this.updateTimer && (clearTimeout(this.updateTimer), this.updateTimer = null));
      })), (t4 = this.resizeObserver) === null || t4 === void 0 || t4.observe(this.container);
    }
    detachObserver() {
      var t4;
      (t4 = this.resizeObserver) === null || t4 === void 0 || t4.disconnect();
    }
    attachEvents() {
      const { container: t4 } = this;
      t4.addEventListener("click", this.onClick, { passive: false, capture: false }), t4.addEventListener("wheel", this.onWheel, { passive: false }), this.pointerTracker = new l2(t4, { start: this.onPointerDown, move: this.onPointerMove, end: this.onPointerUp }), document.addEventListener("mousemove", this.onMouseMove);
    }
    detachEvents() {
      var t4;
      const { container: e4 } = this;
      e4.removeEventListener("click", this.onClick, { passive: false, capture: false }), e4.removeEventListener("wheel", this.onWheel, { passive: false }), (t4 = this.pointerTracker) === null || t4 === void 0 || t4.stop(), this.pointerTracker = null, document.removeEventListener("mousemove", this.onMouseMove), document.removeEventListener("keydown", this.onKeydown, true), this.clickTimer && (clearTimeout(this.clickTimer), this.clickTimer = null), this.updateTimer && (clearTimeout(this.updateTimer), this.updateTimer = null);
    }
    animate() {
      const t4 = this.friction;
      this.setTargetForce();
      const e4 = this.option("maxVelocity");
      for (const i4 of b2)
        t4 ? (this.velocity[i4] *= 1 - t4, e4 && !this.isScaling && (this.velocity[i4] = Math.max(Math.min(this.velocity[i4], e4), -1 * e4)), this.current[i4] += this.velocity[i4]) : this.current[i4] = this.target[i4];
      this.setTransform(), this.setEdgeForce(), !this.isResting || this.isDragging ? this.rAF = requestAnimationFrame(() => this.animate()) : this.stop("current");
    }
    setTargetForce() {
      for (const t4 of b2)
        t4 === "e" && this.isBouncingX || t4 === "f" && this.isBouncingY || (this.velocity[t4] = (1 / (1 - this.friction) - 1) * (this.target[t4] - this.current[t4]));
    }
    checkBounds(t4 = 0, e4 = 0) {
      const { current: i4 } = this, n4 = i4.e + t4, s4 = i4.f + e4, o4 = this.getBounds(), { x: a4, y: r4 } = o4, l4 = a4.min, c4 = a4.max, h4 = r4.min, d4 = r4.max;
      let u4 = 0, p4 = 0;
      return l4 !== 1 / 0 && n4 < l4 ? u4 = l4 - n4 : c4 !== 1 / 0 && n4 > c4 && (u4 = c4 - n4), h4 !== 1 / 0 && s4 < h4 ? p4 = h4 - s4 : d4 !== 1 / 0 && s4 > d4 && (p4 = d4 - s4), Math.abs(u4) < 1e-3 && (u4 = 0), Math.abs(p4) < 1e-3 && (p4 = 0), Object.assign(Object.assign({}, o4), { xDiff: u4, yDiff: p4, inBounds: !u4 && !p4 });
    }
    clampTargetBounds() {
      const { target: t4 } = this, { x: e4, y: i4 } = this.getBounds();
      e4.min !== 1 / 0 && (t4.e = Math.max(t4.e, e4.min)), e4.max !== 1 / 0 && (t4.e = Math.min(t4.e, e4.max)), i4.min !== 1 / 0 && (t4.f = Math.max(t4.f, i4.min)), i4.max !== 1 / 0 && (t4.f = Math.min(t4.f, i4.max));
    }
    calculateContentDim(t4 = this.current) {
      const { content: e4, contentRect: i4 } = this, { fitWidth: n4, fitHeight: s4, fullWidth: o4, fullHeight: a4 } = i4;
      let r4 = o4, l4 = a4;
      if (this.option("zoom") || this.angle !== 0) {
        const i5 = !(e4 instanceof HTMLImageElement) && (window.getComputedStyle(e4).maxWidth === "none" || window.getComputedStyle(e4).maxHeight === "none"), c4 = i5 ? o4 : n4, h4 = i5 ? a4 : s4, d4 = this.getMatrix(t4), u4 = new DOMPoint(0, 0).matrixTransform(d4), p4 = new DOMPoint(0 + c4, 0).matrixTransform(d4), f3 = new DOMPoint(0 + c4, 0 + h4).matrixTransform(d4), m3 = new DOMPoint(0, 0 + h4).matrixTransform(d4), g3 = Math.abs(f3.x - u4.x), b3 = Math.abs(f3.y - u4.y), v3 = Math.abs(m3.x - p4.x), y3 = Math.abs(m3.y - p4.y);
        r4 = Math.max(g3, v3), l4 = Math.max(b3, y3);
      }
      return { contentWidth: r4, contentHeight: l4 };
    }
    setEdgeForce() {
      if (this.ignoreBounds || this.isDragging || this.panMode === "mousemove" || this.targetScale < this.scale)
        return this.isBouncingX = false, void (this.isBouncingY = false);
      const { target: t4 } = this, { x: e4, y: i4, xDiff: n4, yDiff: s4 } = this.checkBounds();
      const o4 = this.option("maxVelocity");
      let a4 = this.velocity.e, r4 = this.velocity.f;
      n4 !== 0 ? (this.isBouncingX = true, n4 * a4 <= 0 ? a4 += 0.14 * n4 : (a4 = 0.14 * n4, e4.min !== 1 / 0 && (this.target.e = Math.max(t4.e, e4.min)), e4.max !== 1 / 0 && (this.target.e = Math.min(t4.e, e4.max))), o4 && (a4 = Math.max(Math.min(a4, o4), -1 * o4))) : this.isBouncingX = false, s4 !== 0 ? (this.isBouncingY = true, s4 * r4 <= 0 ? r4 += 0.14 * s4 : (r4 = 0.14 * s4, i4.min !== 1 / 0 && (this.target.f = Math.max(t4.f, i4.min)), i4.max !== 1 / 0 && (this.target.f = Math.min(t4.f, i4.max))), o4 && (r4 = Math.max(Math.min(r4, o4), -1 * o4))) : this.isBouncingY = false, this.isBouncingX && (this.velocity.e = a4), this.isBouncingY && (this.velocity.f = r4);
    }
    enable() {
      const { content: t4 } = this, e4 = new DOMMatrixReadOnly(window.getComputedStyle(t4).transform);
      for (const t5 of b2)
        this.current[t5] = this.target[t5] = e4[t5];
      this.updateMetrics(), this.attachObserver(), this.attachEvents(), this.state = g2.Ready, this.emit("ready");
    }
    onClick(t4) {
      var e4;
      this.isDragging && ((e4 = this.pointerTracker) === null || e4 === void 0 || e4.clear(), this.trackingPoints = [], this.startDecelAnim());
      const i4 = t4.target;
      if (!i4 || t4.defaultPrevented)
        return;
      if (i4 && i4.hasAttribute("disabled"))
        return t4.preventDefault(), void t4.stopPropagation();
      if ((() => {
        const t5 = window.getSelection();
        return t5 && t5.type === "Range";
      })() && !i4.closest("button"))
        return;
      const n4 = i4.closest("[data-panzoom-action]"), s4 = i4.closest("[data-panzoom-change]"), o4 = n4 || s4, a4 = o4 && x2(o4) ? o4.dataset : null;
      if (a4) {
        const e5 = a4.panzoomChange, i5 = a4.panzoomAction;
        if ((e5 || i5) && t4.preventDefault(), e5) {
          let t5 = {};
          try {
            t5 = JSON.parse(e5);
          } catch (t6) {
            console && console.warn("The given data was not valid JSON");
          }
          return void this.applyChange(t5);
        }
        if (i5)
          return void (this[i5] && this[i5]());
      }
      if (Math.abs(this.dragOffset.x) > 3 || Math.abs(this.dragOffset.y) > 3)
        return t4.preventDefault(), void t4.stopPropagation();
      const r4 = this.content.getBoundingClientRect();
      if (this.dragStart.time && !this.canZoomOut() && (Math.abs(r4.x - this.dragStart.x) > 2 || Math.abs(r4.y - this.dragStart.y) > 2))
        return;
      this.dragStart.time = 0;
      const l4 = (e5) => {
        this.option("zoom") && e5 && typeof e5 == "string" && /(iterateZoom)|(toggle(Zoom|Full|Cover|Max)|(zoomTo(Fit|Cover|Max)))/.test(e5) && typeof this[e5] == "function" && (t4.preventDefault(), this[e5]({ event: t4 }));
      }, c4 = this.option("click", t4), h4 = this.option("dblClick", t4);
      h4 ? (this.clicks++, this.clicks == 1 && (this.clickTimer = setTimeout(() => {
        this.clicks === 1 ? (this.emit("click", t4), !t4.defaultPrevented && c4 && l4(c4)) : (this.emit("dblClick", t4), t4.defaultPrevented || l4(h4)), this.clicks = 0, this.clickTimer = null;
      }, 350))) : (this.emit("click", t4), !t4.defaultPrevented && c4 && l4(c4));
    }
    addTrackingPoint(t4) {
      const e4 = this.trackingPoints.filter((t5) => t5.time > Date.now() - 100);
      e4.push(t4), this.trackingPoints = e4;
    }
    onPointerDown(t4, e4, i4) {
      var n4;
      this.pwt = 0, this.dragOffset = { x: 0, y: 0, time: 0 }, this.trackingPoints = [];
      const s4 = this.content.getBoundingClientRect();
      if (this.dragStart = { x: s4.x, y: s4.y, top: s4.top, left: s4.left, time: Date.now() }, this.clickTimer)
        return false;
      if (this.panMode === "mousemove" && this.targetScale > 1)
        return t4.preventDefault(), t4.stopPropagation(), false;
      if (!i4.length) {
        const e5 = t4.composedPath()[0];
        if (["A", "TEXTAREA", "OPTION", "INPUT", "SELECT", "VIDEO"].includes(e5.nodeName) || e5.closest("[contenteditable]") || e5.closest("[data-selectable]") || e5.closest("[data-draggable]") || e5.closest("[data-panzoom-change]") || e5.closest("[data-panzoom-action]"))
          return false;
        (n4 = window.getSelection()) === null || n4 === void 0 || n4.removeAllRanges();
      }
      if (t4.type === "mousedown")
        t4.preventDefault();
      else if (Math.abs(this.velocity.a) > 0.3)
        return false;
      return this.target.e = this.current.e, this.target.f = this.current.f, this.stop(), this.isDragging || (this.isDragging = true, this.addTrackingPoint(e4), this.emit("touchStart", t4)), true;
    }
    onPointerMove(e4, n4, s4) {
      if (this.option("touch", e4) === false)
        return;
      if (!this.isDragging)
        return;
      if (n4.length < 2 && this.panOnlyZoomed && t2(this.targetScale) <= t2(this.minScale))
        return;
      if (this.emit("touchMove", e4), e4.defaultPrevented)
        return;
      this.addTrackingPoint(n4[0]);
      const { content: o4 } = this, a4 = h2(s4[0], s4[1]), r4 = h2(n4[0], n4[1]);
      let l4 = 0, d4 = 0;
      if (n4.length > 1) {
        const t4 = o4.getBoundingClientRect();
        l4 = a4.clientX - t4.left - 0.5 * t4.width, d4 = a4.clientY - t4.top - 0.5 * t4.height;
      }
      const u4 = c2(s4[0], s4[1]), p4 = c2(n4[0], n4[1]);
      let f3 = u4 ? p4 / u4 : 1, m3 = r4.clientX - a4.clientX, g3 = r4.clientY - a4.clientY;
      this.dragOffset.x += m3, this.dragOffset.y += g3, this.dragOffset.time = Date.now() - this.dragStart.time;
      let b3 = t2(this.targetScale) === t2(this.minScale) && this.option("lockAxis");
      if (b3 && !this.lockedAxis)
        if (b3 === "xy" || b3 === "y" || e4.type === "touchmove") {
          if (Math.abs(this.dragOffset.x) < 6 && Math.abs(this.dragOffset.y) < 6)
            return void e4.preventDefault();
          const t4 = Math.abs(180 * Math.atan2(this.dragOffset.y, this.dragOffset.x) / Math.PI);
          this.lockedAxis = t4 > 45 && t4 < 135 ? "y" : "x", this.dragOffset.x = 0, this.dragOffset.y = 0, m3 = 0, g3 = 0;
        } else
          this.lockedAxis = b3;
      if (i2(e4.target, this.content) && (b3 = "x", this.dragOffset.y = 0), b3 && b3 !== "xy" && this.lockedAxis !== b3 && t2(this.targetScale) === t2(this.minScale))
        return;
      e4.cancelable && e4.preventDefault(), this.container.classList.add(this.cn("isDragging"));
      const v3 = this.checkBounds(m3, g3);
      this.option("rubberband") ? (this.isInfinite !== "x" && (v3.xDiff > 0 && m3 < 0 || v3.xDiff < 0 && m3 > 0) && (m3 *= Math.max(0, 0.5 - Math.abs(0.75 / this.contentRect.fitWidth * v3.xDiff))), this.isInfinite !== "y" && (v3.yDiff > 0 && g3 < 0 || v3.yDiff < 0 && g3 > 0) && (g3 *= Math.max(0, 0.5 - Math.abs(0.75 / this.contentRect.fitHeight * v3.yDiff)))) : (v3.xDiff && (m3 = 0), v3.yDiff && (g3 = 0));
      const y3 = this.targetScale, w3 = this.minScale, x3 = this.maxScale;
      y3 < 0.5 * w3 && (f3 = Math.max(f3, w3)), y3 > 1.5 * x3 && (f3 = Math.min(f3, x3)), this.lockedAxis === "y" && t2(y3) === t2(w3) && (m3 = 0), this.lockedAxis === "x" && t2(y3) === t2(w3) && (g3 = 0), this.applyChange({ originX: l4, originY: d4, panX: m3, panY: g3, scale: f3, friction: this.option("dragFriction"), ignoreBounds: true });
    }
    onPointerUp(t4, e4, n4) {
      if (n4.length)
        return this.dragOffset.x = 0, this.dragOffset.y = 0, void (this.trackingPoints = []);
      this.container.classList.remove(this.cn("isDragging")), this.isDragging && (this.addTrackingPoint(e4), this.panOnlyZoomed && this.contentRect.width - this.contentRect.fitWidth < 1 && this.contentRect.height - this.contentRect.fitHeight < 1 && (this.trackingPoints = []), i2(t4.target, this.content) && this.lockedAxis === "y" && (this.trackingPoints = []), this.emit("touchEnd", t4), this.isDragging = false, this.lockedAxis = false, this.state !== g2.Destroy && (t4.defaultPrevented || this.startDecelAnim()));
    }
    startDecelAnim() {
      var e4;
      const i4 = this.isScaling;
      this.rAF && (cancelAnimationFrame(this.rAF), this.rAF = null), this.isBouncingX = false, this.isBouncingY = false;
      for (const t4 of b2)
        this.velocity[t4] = 0;
      this.target.e = this.current.e, this.target.f = this.current.f, S2(this.container, "is-scaling"), S2(this.container, "is-animating"), this.isTicking = false;
      const { trackingPoints: n4 } = this, s4 = n4[0], o4 = n4[n4.length - 1];
      let a4 = 0, r4 = 0, l4 = 0;
      o4 && s4 && (a4 = o4.clientX - s4.clientX, r4 = o4.clientY - s4.clientY, l4 = o4.time - s4.time);
      const c4 = ((e4 = window.visualViewport) === null || e4 === void 0 ? void 0 : e4.scale) || 1;
      c4 !== 1 && (a4 *= c4, r4 *= c4);
      let h4 = 0, d4 = 0, u4 = 0, p4 = 0, f3 = this.option("decelFriction");
      const m3 = this.targetScale;
      if (l4 > 0) {
        u4 = Math.abs(a4) > 3 ? a4 / (l4 / 30) : 0, p4 = Math.abs(r4) > 3 ? r4 / (l4 / 30) : 0;
        const t4 = this.option("maxVelocity");
        t4 && (u4 = Math.max(Math.min(u4, t4), -1 * t4), p4 = Math.max(Math.min(p4, t4), -1 * t4));
      }
      u4 && (h4 = u4 / (1 / (1 - f3) - 1)), p4 && (d4 = p4 / (1 / (1 - f3) - 1)), (this.option("lockAxis") === "y" || this.option("lockAxis") === "xy" && this.lockedAxis === "y" && t2(m3) === this.minScale) && (h4 = u4 = 0), (this.option("lockAxis") === "x" || this.option("lockAxis") === "xy" && this.lockedAxis === "x" && t2(m3) === this.minScale) && (d4 = p4 = 0);
      const g3 = this.dragOffset.x, v3 = this.dragOffset.y, y3 = this.option("dragMinThreshold") || 0;
      Math.abs(g3) < y3 && Math.abs(v3) < y3 && (h4 = d4 = 0, u4 = p4 = 0), (m3 < this.minScale - 1e-5 || m3 > this.maxScale + 1e-5 || i4 && !h4 && !d4) && (f3 = 0.35), this.applyChange({ panX: h4, panY: d4, friction: f3 }), this.emit("decel", u4, p4, g3, v3);
    }
    onWheel(t4) {
      var e4 = [-t4.deltaX || 0, -t4.deltaY || 0, -t4.detail || 0].reduce(function(t5, e5) {
        return Math.abs(e5) > Math.abs(t5) ? e5 : t5;
      });
      const i4 = Math.max(-1, Math.min(1, e4));
      if (this.emit("wheel", t4, i4), this.panMode === "mousemove")
        return;
      if (t4.defaultPrevented)
        return;
      const n4 = this.option("wheel");
      n4 === "pan" ? (t4.preventDefault(), this.panOnlyZoomed && !this.canZoomOut() || this.applyChange({ panX: 2 * -t4.deltaX, panY: 2 * -t4.deltaY, bounce: false })) : n4 === "zoom" && this.option("zoom") !== false && this.zoomWithWheel(t4);
    }
    onMouseMove(t4) {
      this.panWithMouse(t4);
    }
    onKeydown(t4) {
      t4.key === "Escape" && this.toggleFS();
    }
    onResize() {
      this.updateMetrics(), this.checkBounds().inBounds || this.requestTick();
    }
    setTransform() {
      this.emit("beforeTransform");
      const { current: e4, target: i4, content: n4, contentRect: s4 } = this, o4 = Object.assign({}, P2);
      for (const n5 of b2) {
        const s5 = n5 == "e" || n5 === "f" ? 1e3 : 1e5;
        o4[n5] = t2(e4[n5], s5), Math.abs(i4[n5] - e4[n5]) < (n5 == "e" || n5 === "f" ? 0.51 : 1e-3) && (e4[n5] = i4[n5]);
      }
      let { a: a4, b: r4, c: l4, d: c4, e: h4, f: d4 } = o4, u4 = `matrix(${a4}, ${r4}, ${l4}, ${c4}, ${h4}, ${d4})`, p4 = n4.parentElement instanceof HTMLPictureElement ? n4.parentElement : n4;
      if (this.option("transformParent") && (p4 = p4.parentElement || p4), p4.style.transform === u4)
        return;
      p4.style.transform = u4;
      const { contentWidth: f3, contentHeight: m3 } = this.calculateContentDim();
      s4.width = f3, s4.height = m3, this.emit("afterTransform");
    }
    updateMetrics(e4 = false) {
      var i4;
      if (!this || this.state === g2.Destroy)
        return;
      if (this.isContentLoading)
        return;
      const n4 = Math.max(1, ((i4 = window.visualViewport) === null || i4 === void 0 ? void 0 : i4.scale) || 1), { container: s4, content: o4 } = this, a4 = o4 instanceof HTMLImageElement, r4 = s4.getBoundingClientRect(), l4 = getComputedStyle(this.container);
      let c4 = r4.width * n4, h4 = r4.height * n4;
      const d4 = parseFloat(l4.paddingTop) + parseFloat(l4.paddingBottom), u4 = c4 - (parseFloat(l4.paddingLeft) + parseFloat(l4.paddingRight)), p4 = h4 - d4;
      this.containerRect = { width: c4, height: h4, innerWidth: u4, innerHeight: p4 };
      let f3 = this.option("width") || "auto", m3 = this.option("height") || "auto";
      f3 === "auto" && (f3 = parseFloat(o4.dataset.width || "") || ((t4) => {
        let e5 = 0;
        return e5 = t4 instanceof HTMLImageElement ? t4.naturalWidth : t4 instanceof SVGElement ? t4.width.baseVal.value : Math.max(t4.offsetWidth, t4.scrollWidth), e5 || 0;
      })(o4)), m3 === "auto" && (m3 = parseFloat(o4.dataset.height || "") || ((t4) => {
        let e5 = 0;
        return e5 = t4 instanceof HTMLImageElement ? t4.naturalHeight : t4 instanceof SVGElement ? t4.height.baseVal.value : Math.max(t4.offsetHeight, t4.scrollHeight), e5 || 0;
      })(o4));
      let b3 = o4.parentElement instanceof HTMLPictureElement ? o4.parentElement : o4;
      this.option("transformParent") && (b3 = b3.parentElement || b3);
      const v3 = b3.getAttribute("style") || "";
      b3.style.setProperty("transform", "none", "important"), a4 && (b3.style.width = "", b3.style.height = ""), b3.offsetHeight;
      const y3 = o4.getBoundingClientRect();
      let w3 = y3.width * n4, x3 = y3.height * n4, S3 = 0, E3 = 0;
      a4 && (Math.abs(f3 - w3) > 1 || Math.abs(m3 - x3) > 1) && ({ width: w3, height: x3, top: S3, left: E3 } = ((t4, e5, i5, n5) => {
        const s5 = i5 / n5;
        return s5 > t4 / e5 ? (i5 = t4, n5 = t4 / s5) : (i5 = e5 * s5, n5 = e5), { width: i5, height: n5, top: 0.5 * (e5 - n5), left: 0.5 * (t4 - i5) };
      })(w3, x3, f3, m3)), this.contentRect = Object.assign(Object.assign({}, this.contentRect), { top: y3.top - r4.top + S3, bottom: r4.bottom - y3.bottom + S3, left: y3.left - r4.left + E3, right: r4.right - y3.right + E3, fitWidth: w3, fitHeight: x3, width: w3, height: x3, fullWidth: f3, fullHeight: m3 }), b3.style.cssText = v3, a4 && (b3.style.width = `${w3}px`, b3.style.height = `${x3}px`), this.setTransform(), e4 !== true && this.emit("refresh"), this.ignoreBounds || (t2(this.targetScale) < t2(this.minScale) ? this.zoomTo(this.minScale, { friction: 0 }) : this.targetScale > this.maxScale ? this.zoomTo(this.maxScale, { friction: 0 }) : this.state === g2.Init || this.checkBounds().inBounds || this.requestTick()), this.updateControls();
    }
    getBounds() {
      const e4 = this.option("bounds");
      if (e4 !== "auto")
        return e4;
      const { contentWidth: i4, contentHeight: n4 } = this.calculateContentDim(this.target);
      let s4 = 0, o4 = 0, a4 = 0, r4 = 0;
      const l4 = this.option("infinite");
      if (l4 === true || this.lockedAxis && l4 === this.lockedAxis)
        s4 = -1 / 0, a4 = 1 / 0, o4 = -1 / 0, r4 = 1 / 0;
      else {
        let { containerRect: e5, contentRect: l5 } = this, c4 = t2(this.contentRect.fitWidth * this.targetScale, 1e3), h4 = t2(this.contentRect.fitHeight * this.targetScale, 1e3), { innerWidth: d4, innerHeight: u4 } = e5;
        if (this.containerRect.width === c4 && (d4 = e5.width), this.containerRect.width === h4 && (u4 = e5.height), i4 > d4) {
          a4 = 0.5 * (i4 - d4), s4 = -1 * a4;
          let t4 = 0.5 * (l5.right - l5.left);
          s4 += t4, a4 += t4;
        }
        if (this.contentRect.fitWidth > d4 && i4 < d4 && (s4 -= 0.5 * (this.contentRect.fitWidth - d4), a4 -= 0.5 * (this.contentRect.fitWidth - d4)), n4 > u4) {
          r4 = 0.5 * (n4 - u4), o4 = -1 * r4;
          let t4 = 0.5 * (l5.bottom - l5.top);
          o4 += t4, r4 += t4;
        }
        this.contentRect.fitHeight > u4 && n4 < u4 && (s4 -= 0.5 * (this.contentRect.fitHeight - u4), a4 -= 0.5 * (this.contentRect.fitHeight - u4));
      }
      return { x: { min: s4, max: a4 }, y: { min: o4, max: r4 } };
    }
    updateControls() {
      const e4 = this, i4 = e4.container, { panMode: n4, contentRect: s4, fullScale: a4, targetScale: r4, coverScale: l4, maxScale: c4, minScale: h4 } = e4;
      let d4 = { toggleMax: r4 - h4 < 0.5 * (c4 - h4) ? c4 : h4, toggleCover: r4 - h4 < 0.5 * (l4 - h4) ? l4 : h4, toggleZoom: r4 - h4 < 0.5 * (a4 - h4) ? a4 : h4 }[e4.option("click") || ""] || h4, u4 = e4.canZoomIn(), p4 = e4.canZoomOut(), f3 = p4 && n4 === "drag";
      t2(r4) < t2(h4) && !this.panOnlyZoomed && (f3 = true), (t2(s4.width, 1) > t2(s4.fitWidth, 1) || t2(s4.height, 1) > t2(s4.fitHeight, 1)) && (f3 = true), t2(s4.width * r4, 1) < t2(s4.fitWidth, 1) && (f3 = false), n4 === "mousemove" && (f3 = false);
      let m3 = u4 && t2(d4) > t2(r4), g3 = !m3 && !f3 && p4 && t2(d4) < t2(r4);
      o2(i4, this.cn("canZoomIn"), m3), o2(i4, this.cn("canZoomOut"), g3), o2(i4, this.cn("isDraggable"), f3);
      for (const t4 of i4.querySelectorAll('[data-panzoom-action="zoomIn"]'))
        u4 ? (t4.removeAttribute("disabled"), t4.removeAttribute("tabindex")) : (t4.setAttribute("disabled", ""), t4.setAttribute("tabindex", "-1"));
      for (const t4 of i4.querySelectorAll('[data-panzoom-action="zoomOut"]'))
        p4 ? (t4.removeAttribute("disabled"), t4.removeAttribute("tabindex")) : (t4.setAttribute("disabled", ""), t4.setAttribute("tabindex", "-1"));
      for (const t4 of i4.querySelectorAll('[data-panzoom-action="toggleZoom"],[data-panzoom-action="iterateZoom"]')) {
        u4 || p4 ? (t4.removeAttribute("disabled"), t4.removeAttribute("tabindex")) : (t4.setAttribute("disabled", ""), t4.setAttribute("tabindex", "-1"));
        const e5 = t4.querySelector("g");
        e5 && (e5.style.display = u4 ? "" : "none");
      }
    }
    panTo({ x: t4 = this.target.e, y: e4 = this.target.f, scale: i4 = this.targetScale, friction: n4 = this.option("friction"), angle: s4 = 0, originX: o4 = 0, originY: a4 = 0, flipX: r4 = false, flipY: l4 = false, ignoreBounds: c4 = false }) {
      this.state !== g2.Destroy && this.applyChange({ panX: t4 - this.target.e, panY: e4 - this.target.f, scale: i4 / this.targetScale, angle: s4, originX: o4, originY: a4, friction: n4, flipX: r4, flipY: l4, ignoreBounds: c4 });
    }
    applyChange({ panX: e4 = 0, panY: i4 = 0, scale: n4 = 1, angle: s4 = 0, originX: o4 = -this.current.e, originY: a4 = -this.current.f, friction: r4 = this.option("friction"), flipX: l4 = false, flipY: c4 = false, ignoreBounds: h4 = false, bounce: d4 = this.option("bounce") }) {
      if (this.state === g2.Destroy)
        return;
      this.rAF && (cancelAnimationFrame(this.rAF), this.rAF = null), this.friction = r4 || 0, this.ignoreBounds = h4;
      const { current: u4 } = this, p4 = u4.e, f3 = u4.f, m3 = this.getMatrix(this.target);
      let v3 = new DOMMatrix().translate(p4, f3).translate(o4, a4).translate(e4, i4);
      if (this.option("zoom")) {
        if (!h4) {
          const t4 = this.targetScale, e5 = this.minScale, i5 = this.maxScale;
          t4 * n4 < e5 && (n4 = e5 / t4), t4 * n4 > i5 && (n4 = i5 / t4);
        }
        v3 = v3.scale(n4);
      }
      v3 = v3.translate(-o4, -a4).translate(-p4, -f3).multiply(m3), s4 && (v3 = v3.rotate(s4)), l4 && (v3 = v3.scale(-1, 1)), c4 && (v3 = v3.scale(1, -1));
      for (const e5 of b2)
        e5 !== "e" && e5 !== "f" && (v3[e5] > this.minScale + 1e-5 || v3[e5] < this.minScale - 1e-5) ? this.target[e5] = v3[e5] : this.target[e5] = t2(v3[e5], 1e3);
      (this.targetScale < this.scale || Math.abs(n4 - 1) > 0.1 || this.panMode === "mousemove" || d4 === false) && !h4 && this.clampTargetBounds(), this.isResting || (this.state = g2.Panning, this.requestTick());
    }
    stop(t4 = false) {
      if (this.state === g2.Init || this.state === g2.Destroy)
        return;
      const e4 = this.isTicking;
      this.rAF && (cancelAnimationFrame(this.rAF), this.rAF = null), this.isBouncingX = false, this.isBouncingY = false;
      for (const e5 of b2)
        this.velocity[e5] = 0, t4 === "current" ? this.current[e5] = this.target[e5] : t4 === "target" && (this.target[e5] = this.current[e5]);
      this.setTransform(), S2(this.container, "is-scaling"), S2(this.container, "is-animating"), this.isTicking = false, this.state = g2.Ready, e4 && (this.emit("endAnimation"), this.updateControls());
    }
    requestTick() {
      this.isTicking || (this.emit("startAnimation"), this.updateControls(), E2(this.container, "is-animating"), this.isScaling && E2(this.container, "is-scaling")), this.isTicking = true, this.rAF || (this.rAF = requestAnimationFrame(() => this.animate()));
    }
    panWithMouse(e4, i4 = this.option("mouseMoveFriction")) {
      if (this.pmme = e4, this.panMode !== "mousemove" || !e4)
        return;
      if (t2(this.targetScale) <= t2(this.minScale))
        return;
      this.emit("mouseMove", e4);
      const { container: n4, containerRect: s4, contentRect: o4 } = this, a4 = s4.width, r4 = s4.height, l4 = n4.getBoundingClientRect(), c4 = (e4.clientX || 0) - l4.left, h4 = (e4.clientY || 0) - l4.top;
      let { contentWidth: d4, contentHeight: u4 } = this.calculateContentDim(this.target);
      const p4 = this.option("mouseMoveFactor");
      p4 > 1 && (d4 !== a4 && (d4 *= p4), u4 !== r4 && (u4 *= p4));
      let f3 = 0.5 * (d4 - a4) - c4 / a4 * 100 / 100 * (d4 - a4);
      f3 += 0.5 * (o4.right - o4.left);
      let m3 = 0.5 * (u4 - r4) - h4 / r4 * 100 / 100 * (u4 - r4);
      m3 += 0.5 * (o4.bottom - o4.top), this.applyChange({ panX: f3 - this.target.e, panY: m3 - this.target.f, friction: i4 });
    }
    zoomWithWheel(e4) {
      if (this.state === g2.Destroy || this.state === g2.Init)
        return;
      const i4 = Date.now();
      if (i4 - this.pwt < 45)
        return void e4.preventDefault();
      this.pwt = i4;
      var n4 = [-e4.deltaX || 0, -e4.deltaY || 0, -e4.detail || 0].reduce(function(t4, e5) {
        return Math.abs(e5) > Math.abs(t4) ? e5 : t4;
      });
      const s4 = Math.max(-1, Math.min(1, n4)), { targetScale: o4, maxScale: a4, minScale: r4 } = this;
      let l4 = o4 * (100 + 45 * s4) / 100;
      t2(l4) < t2(r4) && t2(o4) <= t2(r4) ? (this.cwd += Math.abs(s4), l4 = r4) : t2(l4) > t2(a4) && t2(o4) >= t2(a4) ? (this.cwd += Math.abs(s4), l4 = a4) : (this.cwd = 0, l4 = Math.max(Math.min(l4, a4), r4)), this.cwd > this.option("wheelLimit") || (e4.preventDefault(), t2(l4) !== t2(o4) && this.zoomTo(l4, { event: e4 }));
    }
    canZoomIn() {
      return this.option("zoom") && (t2(this.contentRect.width, 1) < t2(this.contentRect.fitWidth, 1) || t2(this.targetScale) < t2(this.maxScale));
    }
    canZoomOut() {
      return this.option("zoom") && t2(this.targetScale) > t2(this.minScale);
    }
    zoomIn(t4 = 1.25, e4) {
      this.zoomTo(this.targetScale * t4, e4);
    }
    zoomOut(t4 = 0.8, e4) {
      this.zoomTo(this.targetScale * t4, e4);
    }
    zoomToFit(t4) {
      this.zoomTo("fit", t4);
    }
    zoomToCover(t4) {
      this.zoomTo("cover", t4);
    }
    zoomToFull(t4) {
      this.zoomTo("full", t4);
    }
    zoomToMax(t4) {
      this.zoomTo("max", t4);
    }
    toggleZoom(t4) {
      this.zoomTo(this.targetScale - this.minScale < 0.5 * (this.fullScale - this.minScale) ? "full" : "fit", t4);
    }
    toggleMax(t4) {
      this.zoomTo(this.targetScale - this.minScale < 0.5 * (this.maxScale - this.minScale) ? "max" : "fit", t4);
    }
    toggleCover(t4) {
      this.zoomTo(this.targetScale - this.minScale < 0.5 * (this.coverScale - this.minScale) ? "cover" : "fit", t4);
    }
    iterateZoom(t4) {
      this.zoomTo("next", t4);
    }
    zoomTo(t4 = 1, { friction: e4 = "auto", originX: i4 = 0, originY: n4 = 0, event: s4 } = {}) {
      if (this.isContentLoading || this.state === g2.Destroy)
        return;
      const { targetScale: o4 } = this;
      this.stop();
      let a4 = 1;
      if (this.panMode === "mousemove" && (s4 = this.pmme || s4), s4) {
        const t5 = this.content.getBoundingClientRect(), e5 = s4.clientX || 0, o5 = s4.clientY || 0;
        i4 = e5 - t5.left - 0.5 * t5.width, n4 = o5 - t5.top - 0.5 * t5.height;
      }
      const r4 = this.fullScale, l4 = this.maxScale;
      let c4 = this.coverScale;
      typeof t4 == "number" ? a4 = t4 / o4 : (t4 === "next" && (r4 - c4 < 0.2 && (c4 = r4), t4 = o4 < r4 - 1e-5 ? "full" : o4 < l4 - 1e-5 ? "max" : "fit"), a4 = t4 === "full" ? r4 / o4 || 1 : t4 === "cover" ? c4 / o4 || 1 : t4 === "max" ? l4 / o4 || 1 : 1 / o4 || 1), e4 = e4 === "auto" ? a4 > 1 ? 0.15 : 0.25 : e4, this.applyChange({ scale: a4, originX: i4, originY: n4, friction: e4 }), s4 && this.panMode === "mousemove" && this.panWithMouse(s4, e4);
    }
    rotateCCW() {
      this.applyChange({ angle: -90 });
    }
    rotateCW() {
      this.applyChange({ angle: 90 });
    }
    flipX() {
      this.applyChange({ flipX: true });
    }
    flipY() {
      this.applyChange({ flipY: true });
    }
    fitX() {
      this.stop("target");
      const { containerRect: t4, contentRect: e4, target: i4 } = this;
      this.applyChange({ panX: 0.5 * t4.width - (e4.left + 0.5 * e4.fitWidth) - i4.e, panY: 0.5 * t4.height - (e4.top + 0.5 * e4.fitHeight) - i4.f, scale: t4.width / e4.fitWidth / this.targetScale, originX: 0, originY: 0, ignoreBounds: true });
    }
    fitY() {
      this.stop("target");
      const { containerRect: t4, contentRect: e4, target: i4 } = this;
      this.applyChange({ panX: 0.5 * t4.width - (e4.left + 0.5 * e4.fitWidth) - i4.e, panY: 0.5 * t4.innerHeight - (e4.top + 0.5 * e4.fitHeight) - i4.f, scale: t4.height / e4.fitHeight / this.targetScale, originX: 0, originY: 0, ignoreBounds: true });
    }
    toggleFS() {
      const { container: t4 } = this, e4 = this.cn("inFullscreen"), i4 = this.cn("htmlHasFullscreen");
      t4.classList.toggle(e4);
      const n4 = t4.classList.contains(e4);
      n4 ? (document.documentElement.classList.add(i4), document.addEventListener("keydown", this.onKeydown, true)) : (document.documentElement.classList.remove(i4), document.removeEventListener("keydown", this.onKeydown, true)), this.updateMetrics(), this.emit(n4 ? "enterFS" : "exitFS");
    }
    getMatrix(t4 = this.current) {
      const { a: e4, b: i4, c: n4, d: s4, e: o4, f: a4 } = t4;
      return new DOMMatrix([e4, i4, n4, s4, o4, a4]);
    }
    reset(t4) {
      if (this.state !== g2.Init && this.state !== g2.Destroy) {
        this.stop("current");
        for (const t5 of b2)
          this.target[t5] = P2[t5];
        this.target.a = this.minScale, this.target.d = this.minScale, this.clampTargetBounds(), this.isResting || (this.friction = t4 === void 0 ? this.option("friction") : t4, this.state = g2.Panning, this.requestTick());
      }
    }
    destroy() {
      this.stop(), this.state = g2.Destroy, this.detachEvents(), this.detachObserver();
      const { container: t4, content: e4 } = this, i4 = this.option("classes") || {};
      for (const e5 of Object.values(i4))
        t4.classList.remove(e5 + "");
      e4 && (e4.removeEventListener("load", this.onLoad), e4.removeEventListener("error", this.onError)), this.detachPlugins();
    }
  };
  Object.defineProperty(T2, "defaults", { enumerable: true, configurable: true, writable: true, value: y2 }), Object.defineProperty(T2, "Plugins", { enumerable: true, configurable: true, writable: true, value: {} });
  var O2 = function(t4, e4) {
    let i4 = true;
    return (...n4) => {
      i4 && (i4 = false, t4(...n4), setTimeout(() => {
        i4 = true;
      }, e4));
    };
  };
  var A2 = (t4, e4) => {
    let i4 = [];
    return t4.childNodes.forEach((t5) => {
      t5.nodeType !== Node.ELEMENT_NODE || e4 && !t5.matches(e4) || i4.push(t5);
    }), i4;
  };
  var z2 = { viewport: null, track: null, enabled: true, slides: [], axis: "x", transition: "fade", preload: 1, slidesPerPage: "auto", initialPage: 0, friction: 0.12, Panzoom: { decelFriction: 0.12 }, center: true, infinite: true, fill: true, dragFree: false, adaptiveHeight: false, direction: "ltr", classes: { container: "f-carousel", viewport: "f-carousel__viewport", track: "f-carousel__track", slide: "f-carousel__slide", isLTR: "is-ltr", isRTL: "is-rtl", isHorizontal: "is-horizontal", isVertical: "is-vertical", inTransition: "in-transition", isSelected: "is-selected" }, l10n: { NEXT: "Next slide", PREV: "Previous slide", GOTO: "Go to slide #%d" } };
  var L2;
  !function(t4) {
    t4[t4.Init = 0] = "Init", t4[t4.Ready = 1] = "Ready", t4[t4.Destroy = 2] = "Destroy";
  }(L2 || (L2 = {}));
  var R2 = (t4) => {
    if (typeof t4 == "string" && (t4 = { html: t4 }), !(t4 instanceof String || t4 instanceof HTMLElement)) {
      const e4 = t4.thumb;
      e4 !== void 0 && (typeof e4 == "string" && (t4.thumbSrc = e4), e4 instanceof HTMLImageElement && (t4.thumbEl = e4, t4.thumbElSrc = e4.src, t4.thumbSrc = e4.src), delete t4.thumb);
    }
    return Object.assign({ html: "", el: null, isDom: false, class: "", index: -1, dim: 0, gap: 0, pos: 0, transition: false }, t4);
  };
  var k2 = (t4 = {}) => Object.assign({ index: -1, slides: [], dim: 0, pos: -1 }, t4);
  var I2 = class extends f2 {
    constructor(t4, e4) {
      super(e4), Object.defineProperty(this, "instance", { enumerable: true, configurable: true, writable: true, value: t4 });
    }
    attach() {
    }
    detach() {
    }
  };
  var D2 = { classes: { list: "f-carousel__dots", isDynamic: "is-dynamic", hasDots: "has-dots", dot: "f-carousel__dot", isBeforePrev: "is-before-prev", isPrev: "is-prev", isCurrent: "is-current", isNext: "is-next", isAfterNext: "is-after-next" }, dotTpl: '<button type="button" data-carousel-page="%i" aria-label="{{GOTO}}"><span class="f-carousel__dot" aria-hidden="true"></span></button>', dynamicFrom: 11, maxCount: 1 / 0, minCount: 2 };
  var F2 = class extends I2 {
    constructor() {
      super(...arguments), Object.defineProperty(this, "isDynamic", { enumerable: true, configurable: true, writable: true, value: false }), Object.defineProperty(this, "list", { enumerable: true, configurable: true, writable: true, value: null });
    }
    onRefresh() {
      this.refresh();
    }
    build() {
      let t4 = this.list;
      return t4 || (t4 = document.createElement("ul"), E2(t4, this.cn("list")), t4.setAttribute("role", "tablist"), this.instance.container.appendChild(t4), E2(this.instance.container, this.cn("hasDots")), this.list = t4), t4;
    }
    refresh() {
      var t4;
      const e4 = this.instance.pages.length, i4 = Math.min(2, this.option("minCount")), n4 = Math.max(2e3, this.option("maxCount")), s4 = this.option("dynamicFrom");
      if (e4 < i4 || e4 > n4)
        return void this.cleanup();
      const a4 = typeof s4 == "number" && e4 > 5 && e4 >= s4, r4 = !this.list || this.isDynamic !== a4 || this.list.children.length !== e4;
      r4 && this.cleanup();
      const l4 = this.build();
      if (o2(l4, this.cn("isDynamic"), !!a4), r4)
        for (let t5 = 0; t5 < e4; t5++)
          l4.append(this.createItem(t5));
      let c4, h4 = 0;
      for (const e5 of [...l4.children]) {
        const i5 = h4 === this.instance.page;
        i5 && (c4 = e5), o2(e5, this.cn("isCurrent"), i5), (t4 = e5.children[0]) === null || t4 === void 0 || t4.setAttribute("aria-selected", i5 ? "true" : "false");
        for (const t5 of ["isBeforePrev", "isPrev", "isNext", "isAfterNext"])
          S2(e5, this.cn(t5));
        h4++;
      }
      if (c4 = c4 || l4.firstChild, a4 && c4) {
        const t5 = c4.previousElementSibling, e5 = t5 && t5.previousElementSibling;
        E2(t5, this.cn("isPrev")), E2(e5, this.cn("isBeforePrev"));
        const i5 = c4.nextElementSibling, n5 = i5 && i5.nextElementSibling;
        E2(i5, this.cn("isNext")), E2(n5, this.cn("isAfterNext"));
      }
      this.isDynamic = a4;
    }
    createItem(t4 = 0) {
      var e4;
      const i4 = document.createElement("li");
      i4.setAttribute("role", "presentation");
      const s4 = n2(this.instance.localize(this.option("dotTpl"), [["%d", t4 + 1]]).replace(/\%i/g, t4 + ""));
      return i4.appendChild(s4), (e4 = i4.children[0]) === null || e4 === void 0 || e4.setAttribute("role", "tab"), i4;
    }
    cleanup() {
      this.list && (this.list.remove(), this.list = null), this.isDynamic = false, S2(this.instance.container, this.cn("hasDots"));
    }
    attach() {
      this.instance.on(["refresh", "change"], this.onRefresh);
    }
    detach() {
      this.instance.off(["refresh", "change"], this.onRefresh), this.cleanup();
    }
  };
  Object.defineProperty(F2, "defaults", { enumerable: true, configurable: true, writable: true, value: D2 });
  var j2 = class extends I2 {
    constructor() {
      super(...arguments), Object.defineProperty(this, "container", { enumerable: true, configurable: true, writable: true, value: null }), Object.defineProperty(this, "prev", { enumerable: true, configurable: true, writable: true, value: null }), Object.defineProperty(this, "next", { enumerable: true, configurable: true, writable: true, value: null });
    }
    onRefresh() {
      const t4 = this.instance, e4 = t4.pages.length, i4 = t4.page;
      if (e4 < 2)
        return void this.cleanup();
      this.build();
      let n4 = this.prev, s4 = this.next;
      n4 && s4 && (n4.removeAttribute("disabled"), s4.removeAttribute("disabled"), t4.isInfinite || (i4 <= 0 && n4.setAttribute("disabled", ""), i4 >= e4 - 1 && s4.setAttribute("disabled", "")));
    }
    createButton(t4) {
      const e4 = this.instance, i4 = document.createElement("button");
      i4.setAttribute("tabindex", "0"), i4.setAttribute("title", e4.localize(`{{${t4.toUpperCase()}}}`)), E2(i4, this.cn("button") + " " + this.cn(t4 === "next" ? "isNext" : "isPrev"));
      const n4 = e4.isRTL ? t4 === "next" ? "prev" : "next" : t4;
      var s4;
      return i4.innerHTML = e4.localize(this.option(`${n4}Tpl`)), i4.dataset[`carousel${s4 = t4, s4 ? s4.match("^[a-z]") ? s4.charAt(0).toUpperCase() + s4.substring(1) : s4 : ""}`] = "true", i4;
    }
    build() {
      let t4 = this.container;
      t4 || (this.container = t4 = document.createElement("div"), E2(t4, this.cn("container")), this.instance.container.appendChild(t4)), this.next || (this.next = t4.appendChild(this.createButton("next"))), this.prev || (this.prev = t4.appendChild(this.createButton("prev")));
    }
    cleanup() {
      this.prev && this.prev.remove(), this.next && this.next.remove(), this.container && this.container.remove(), this.prev = null, this.next = null, this.container = null;
    }
    attach() {
      this.instance.on(["refresh", "change"], this.onRefresh);
    }
    detach() {
      this.instance.off(["refresh", "change"], this.onRefresh), this.cleanup();
    }
  };
  Object.defineProperty(j2, "defaults", { enumerable: true, configurable: true, writable: true, value: { classes: { container: "f-carousel__nav", button: "f-button", isNext: "is-next", isPrev: "is-prev" }, nextTpl: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" tabindex="-1"><path d="M9 3l9 9-9 9"/></svg>', prevTpl: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" tabindex="-1"><path d="M15 3l-9 9 9 9"/></svg>' } });
  var H2 = class extends I2 {
    constructor() {
      super(...arguments), Object.defineProperty(this, "selectedIndex", { enumerable: true, configurable: true, writable: true, value: null }), Object.defineProperty(this, "target", { enumerable: true, configurable: true, writable: true, value: null }), Object.defineProperty(this, "nav", { enumerable: true, configurable: true, writable: true, value: null });
    }
    addAsTargetFor(t4) {
      this.target = this.instance, this.nav = t4, this.attachEvents();
    }
    addAsNavFor(t4) {
      this.nav = this.instance, this.target = t4, this.attachEvents();
    }
    attachEvents() {
      this.nav && this.target && (this.nav.options.initialSlide = this.target.options.initialPage, this.nav.on("ready", this.onNavReady), this.nav.state === L2.Ready && this.onNavReady(this.nav), this.target.on("ready", this.onTargetReady), this.target.state === L2.Ready && this.onTargetReady(this.target));
    }
    onNavReady(t4) {
      t4.on("createSlide", this.onNavCreateSlide), t4.on("Panzoom.click", this.onNavClick), t4.on("Panzoom.touchEnd", this.onNavTouch), this.onTargetChange();
    }
    onTargetReady(t4) {
      t4.on("change", this.onTargetChange), t4.on("Panzoom.refresh", this.onTargetChange), this.onTargetChange();
    }
    onNavClick(t4, e4, i4) {
      i4.pointerType || this.onNavTouch(t4, t4.panzoom, i4);
    }
    onNavTouch(t4, e4, i4) {
      var n4, s4;
      if (Math.abs(e4.dragOffset.x) > 3 || Math.abs(e4.dragOffset.y) > 3)
        return;
      const o4 = i4.target, { nav: a4, target: r4 } = this;
      if (!a4 || !r4 || !o4)
        return;
      const l4 = o4.closest("[data-index]");
      if (i4.stopPropagation(), i4.preventDefault(), !l4)
        return;
      const c4 = parseInt(l4.dataset.index || "", 10) || 0, h4 = r4.getPageForSlide(c4), d4 = a4.getPageForSlide(c4);
      a4.slideTo(d4), r4.slideTo(h4, { friction: ((s4 = (n4 = this.nav) === null || n4 === void 0 ? void 0 : n4.plugins) === null || s4 === void 0 ? void 0 : s4.Sync.option("friction")) || 0 }), this.markSelectedSlide(c4);
    }
    onNavCreateSlide(t4, e4) {
      e4.index === this.selectedIndex && this.markSelectedSlide(e4.index);
    }
    onTargetChange() {
      const { target: t4, nav: e4 } = this;
      if (!t4 || !e4)
        return;
      if (e4.state !== L2.Ready || t4.state !== L2.Ready)
        return;
      const i4 = t4.pages[t4.page].slides[0].index, n4 = e4.getPageForSlide(i4);
      this.markSelectedSlide(i4), e4.slideTo(n4);
    }
    markSelectedSlide(t4) {
      const e4 = this.nav;
      e4 && e4.state === L2.Ready && (this.selectedIndex = t4, [...e4.slides].map((e5) => {
        e5.el && e5.el.classList[e5.index === t4 ? "add" : "remove"]("is-nav-selected");
      }));
    }
    attach() {
      const t4 = this;
      let e4 = t4.options.target, i4 = t4.options.nav;
      e4 ? t4.addAsNavFor(e4) : i4 && t4.addAsTargetFor(i4);
    }
    detach() {
      const t4 = this, e4 = t4.nav, i4 = t4.target;
      e4 && (e4.off("ready", t4.onNavReady), e4.off("createSlide", t4.onNavCreateSlide), e4.off("Panzoom.click", t4.onNavClick), e4.off("Panzoom.touchEnd", t4.onNavTouch)), t4.nav = null, i4 && (i4.off("ready", t4.onTargetReady), i4.off("refresh", t4.onTargetChange), i4.off("change", t4.onTargetChange)), t4.target = null;
    }
  };
  Object.defineProperty(H2, "defaults", { enumerable: true, configurable: true, writable: true, value: { friction: 0.35 } });
  var B = { Navigation: j2, Dots: F2, Sync: H2 };
  var _ = class extends m2 {
    get axis() {
      return this.isHorizontal ? "e" : "f";
    }
    get isEnabled() {
      return this.state === L2.Ready;
    }
    get isInfinite() {
      let t4 = false;
      const { contentDim: e4, viewportDim: i4, pages: n4, slides: s4 } = this;
      return n4.length >= 2 && e4 + s4[0].dim >= i4 && (t4 = this.option("infinite")), t4;
    }
    get isRTL() {
      return this.option("direction") === "rtl";
    }
    get isHorizontal() {
      return this.option("axis") === "x";
    }
    constructor(t4, e4 = {}, i4 = {}) {
      if (super(), Object.defineProperty(this, "userOptions", { enumerable: true, configurable: true, writable: true, value: {} }), Object.defineProperty(this, "userPlugins", { enumerable: true, configurable: true, writable: true, value: {} }), Object.defineProperty(this, "bp", { enumerable: true, configurable: true, writable: true, value: "" }), Object.defineProperty(this, "lp", { enumerable: true, configurable: true, writable: true, value: 0 }), Object.defineProperty(this, "state", { enumerable: true, configurable: true, writable: true, value: L2.Init }), Object.defineProperty(this, "page", { enumerable: true, configurable: true, writable: true, value: 0 }), Object.defineProperty(this, "prevPage", { enumerable: true, configurable: true, writable: true, value: null }), Object.defineProperty(this, "container", { enumerable: true, configurable: true, writable: true, value: void 0 }), Object.defineProperty(this, "viewport", { enumerable: true, configurable: true, writable: true, value: null }), Object.defineProperty(this, "track", { enumerable: true, configurable: true, writable: true, value: null }), Object.defineProperty(this, "slides", { enumerable: true, configurable: true, writable: true, value: [] }), Object.defineProperty(this, "pages", { enumerable: true, configurable: true, writable: true, value: [] }), Object.defineProperty(this, "panzoom", { enumerable: true, configurable: true, writable: true, value: null }), Object.defineProperty(this, "inTransition", { enumerable: true, configurable: true, writable: true, value: new Set() }), Object.defineProperty(this, "contentDim", { enumerable: true, configurable: true, writable: true, value: 0 }), Object.defineProperty(this, "viewportDim", { enumerable: true, configurable: true, writable: true, value: 0 }), typeof t4 == "string" && (t4 = document.querySelector(t4)), !t4 || !x2(t4))
        throw new Error("No Element found");
      this.container = t4, this.slideNext = O2(this.slideNext.bind(this), 150), this.slidePrev = O2(this.slidePrev.bind(this), 150), this.userOptions = e4, this.userPlugins = i4, queueMicrotask(() => {
        this.processOptions();
      });
    }
    processOptions() {
      const t4 = u2({}, _.defaults, this.userOptions);
      let e4 = "";
      const i4 = t4.breakpoints;
      if (i4 && d2(i4))
        for (const [n4, s4] of Object.entries(i4))
          window.matchMedia(n4).matches && d2(s4) && (e4 += n4, u2(t4, s4));
      e4 === this.bp && this.state !== L2.Init || (this.bp = e4, this.state === L2.Ready && (t4.initialSlide = this.pages[this.page].slides[0].index), this.state !== L2.Init && this.destroy(), super.setOptions(t4), this.option("enabled") === false ? this.attachEvents() : setTimeout(() => {
        this.init();
      }, 0));
    }
    init() {
      this.state = L2.Init, this.emit("init"), this.attachPlugins(Object.assign(Object.assign({}, _.Plugins), this.userPlugins)), this.initLayout(), this.initSlides(), this.updateMetrics(), this.setInitialPosition(), this.initPanzoom(), this.attachEvents(), this.state = L2.Ready, this.emit("ready");
    }
    initLayout() {
      const { container: t4 } = this, e4 = this.option("classes");
      E2(t4, this.cn("container")), o2(t4, e4.isLTR, !this.isRTL), o2(t4, e4.isRTL, this.isRTL), o2(t4, e4.isVertical, !this.isHorizontal), o2(t4, e4.isHorizontal, this.isHorizontal);
      let i4 = this.option("viewport") || t4.querySelector(`.${e4.viewport}`);
      i4 || (i4 = document.createElement("div"), E2(i4, e4.viewport), i4.append(...A2(t4, `.${e4.slide}`)), t4.prepend(i4));
      let n4 = this.option("track") || t4.querySelector(`.${e4.track}`);
      n4 || (n4 = document.createElement("div"), E2(n4, e4.track), n4.append(...Array.from(i4.childNodes))), n4.setAttribute("aria-live", "polite"), i4.contains(n4) || i4.prepend(n4), this.viewport = i4, this.track = n4, this.emit("initLayout");
    }
    initSlides() {
      const { track: t4 } = this;
      if (t4) {
        this.slides = [], [...A2(t4, `.${this.cn("slide")}`)].forEach((t5) => {
          if (x2(t5)) {
            const e4 = R2({ el: t5, isDom: true, index: this.slides.length });
            this.slides.push(e4), this.emit("initSlide", e4, this.slides.length);
          }
        });
        for (let t5 of this.option("slides", [])) {
          const e4 = R2(t5);
          e4.index = this.slides.length, this.slides.push(e4), this.emit("initSlide", e4, this.slides.length);
        }
        this.emit("initSlides");
      }
    }
    setInitialPage() {
      let t4 = 0;
      const e4 = this.option("initialSlide");
      t4 = typeof e4 == "number" ? this.getPageForSlide(e4) : parseInt(this.option("initialPage", 0) + "", 10) || 0, this.page = t4;
    }
    setInitialPosition() {
      if (!this.track || !this.pages.length)
        return;
      const t4 = this.isHorizontal;
      let e4 = this.page;
      this.pages[e4] || (this.page = e4 = 0);
      const i4 = this.pages[e4].pos * (this.isRTL && t4 ? 1 : -1), n4 = t4 ? `${i4}px` : "0", s4 = t4 ? "0" : `${i4}px`;
      this.track.style.transform = `translate3d(${n4}, ${s4}, 0) scale(1)`, this.option("adaptiveHeight") && this.setViewportHeight();
    }
    initPanzoom() {
      this.panzoom && (this.panzoom.destroy(), this.panzoom = null);
      const t4 = this.option("Panzoom") || {};
      this.panzoom = new T2(this.viewport, u2({}, { content: this.track, zoom: false, panOnlyZoomed: false, lockAxis: this.isHorizontal ? "x" : "y", infinite: this.isInfinite, click: false, dblClick: false, touch: (t5) => !(this.pages.length < 2 && !t5.options.infinite), bounds: () => this.getBounds(), maxVelocity: (t5) => Math.abs(t5.target[this.axis] - t5.current[this.axis]) < 2 * this.viewportDim ? 100 : 0 }, t4)), this.panzoom.on("*", (t5, e4, ...i4) => {
        this.emit(`Panzoom.${e4}`, t5, ...i4);
      }), this.panzoom.on("decel", this.onDecel), this.panzoom.on("refresh", this.onRefresh), this.panzoom.on("beforeTransform", this.onBeforeTransform), this.panzoom.on("endAnimation", this.onEndAnimation);
    }
    attachEvents() {
      const t4 = this.container;
      t4 && (t4.addEventListener("click", this.onClick, { passive: false, capture: false }), t4.addEventListener("slideTo", this.onSlideTo)), window.addEventListener("resize", this.onResize);
    }
    createPages() {
      let t4 = [];
      const { contentDim: e4, viewportDim: i4 } = this;
      let n4 = this.option("slidesPerPage");
      (typeof n4 != "number" || e4 <= i4) && (n4 = 1 / 0);
      let s4 = 0, o4 = 0, a4 = 0;
      for (const e5 of this.slides)
        (!t4.length || o4 + e5.dim > i4 || a4 === n4) && (t4.push(k2()), s4 = t4.length - 1, o4 = 0, a4 = 0), t4[s4].slides.push(e5), o4 += e5.dim + e5.gap, a4++;
      return t4;
    }
    processPages() {
      const e4 = this.pages, { contentDim: i4, viewportDim: n4 } = this, s4 = this.option("center"), o4 = this.option("fill"), a4 = o4 && s4 && i4 > n4 && !this.isInfinite;
      if (e4.forEach((t4, e5) => {
        t4.index = e5, t4.pos = t4.slides[0].pos, t4.dim = 0;
        for (const [e6, i5] of t4.slides.entries())
          t4.dim += i5.dim, e6 < t4.slides.length - 1 && (t4.dim += i5.gap);
        a4 && t4.pos + 0.5 * t4.dim < 0.5 * n4 ? t4.pos = 0 : a4 && t4.pos + 0.5 * t4.dim >= i4 - 0.5 * n4 ? t4.pos = i4 - n4 : s4 && (t4.pos += -0.5 * (n4 - t4.dim));
      }), e4.forEach((e5, s5) => {
        o4 && !this.isInfinite && i4 > n4 && (e5.pos = Math.max(e5.pos, 0), e5.pos = Math.min(e5.pos, i4 - n4)), e5.pos = t2(e5.pos, 1e3), e5.dim = t2(e5.dim, 1e3), e5.pos < 0.1 && e5.pos > -0.1 && (e5.pos = 0);
      }), this.isInfinite)
        return e4;
      const r4 = [];
      let l4;
      return e4.forEach((t4) => {
        const e5 = Object.assign({}, t4);
        l4 && e5.pos === l4.pos ? (l4.dim += e5.dim, l4.slides = [...l4.slides, ...e5.slides]) : (e5.index = r4.length, l4 = e5, r4.push(e5));
      }), r4;
    }
    getPageFromIndex(t4 = 0) {
      const e4 = this.pages.length;
      let i4;
      return t4 = parseInt((t4 || 0).toString()) || 0, i4 = this.isInfinite ? (t4 % e4 + e4) % e4 : Math.max(Math.min(t4, e4 - 1), 0), i4;
    }
    getSlideMetrics(e4) {
      var i4;
      const n4 = this.isHorizontal ? "width" : "height";
      let s4 = 0, o4 = 0, a4 = e4.el;
      if (a4 ? s4 = parseFloat(a4.dataset[n4] || "") || 0 : (a4 = document.createElement("div"), a4.style.visibility = "hidden", E2(a4, this.cn("slide") + " " + e4.class), (this.track || document.body).prepend(a4)), s4)
        a4.style[n4] = `${s4}px`, a4.style[n4 === "width" ? "height" : "width"] = "";
      else {
        const t4 = Math.max(1, ((i4 = window.visualViewport) === null || i4 === void 0 ? void 0 : i4.scale) || 1);
        s4 = a4.getBoundingClientRect()[n4] * t4;
      }
      const r4 = getComputedStyle(a4);
      return r4.boxSizing === "content-box" && (this.isHorizontal ? (s4 += parseFloat(r4.paddingLeft) || 0, s4 += parseFloat(r4.paddingRight) || 0) : (s4 += parseFloat(r4.paddingTop) || 0, s4 += parseFloat(r4.paddingBottom) || 0)), o4 = parseFloat(r4[this.isHorizontal ? "marginRight" : "marginBottom"]) || 0, e4.el || a4.remove(), { dim: t2(s4, 1e3), gap: t2(o4, 1e3) };
    }
    getBounds() {
      const { isInfinite: t4, isRTL: e4, isHorizontal: i4, pages: n4 } = this;
      let s4 = { min: 0, max: 0 };
      if (t4)
        s4 = { min: -1 / 0, max: 1 / 0 };
      else if (n4.length) {
        const t5 = n4[0].pos, o4 = n4[n4.length - 1].pos;
        s4 = e4 && i4 ? { min: t5, max: o4 } : { min: -1 * o4, max: -1 * t5 };
      }
      return { x: i4 ? s4 : { min: 0, max: 0 }, y: i4 ? { min: 0, max: 0 } : s4 };
    }
    repositionSlides() {
      let e4, { isHorizontal: i4, isRTL: n4, isInfinite: s4, viewport: o4, viewportDim: a4, contentDim: r4, page: l4, pages: c4, slides: h4, panzoom: d4 } = this, u4 = 0, p4 = 0, f3 = 0, m3 = 0;
      d4 ? m3 = -1 * d4.current[this.axis] : c4[l4] && (m3 = c4[l4].pos || 0), e4 = i4 ? n4 ? "right" : "left" : "top", n4 && i4 && (m3 *= -1);
      for (const i5 of h4)
        i5.el ? (e4 === "top" ? (i5.el.style.right = "", i5.el.style.left = "") : i5.el.style.top = "", i5.index !== u4 ? i5.el.style[e4] = p4 === 0 ? "" : `${t2(p4, 1e3)}px` : i5.el.style[e4] = "", f3 += i5.dim + i5.gap, u4++) : p4 += i5.dim + i5.gap;
      if (s4 && f3 && o4) {
        let n5 = getComputedStyle(o4), s5 = "padding", l5 = i4 ? "Right" : "Bottom", c5 = parseFloat(n5[s5 + (i4 ? "Left" : "Top")]);
        m3 -= c5, a4 += c5, a4 += parseFloat(n5[s5 + l5]);
        for (const i5 of h4)
          i5.el && (t2(i5.pos) < t2(a4) && t2(i5.pos + i5.dim + i5.gap) < t2(m3) && t2(m3) > t2(r4 - a4) && (i5.el.style[e4] = `${t2(p4 + f3, 1e3)}px`), t2(i5.pos + i5.gap) >= t2(r4 - a4) && t2(i5.pos) > t2(m3 + a4) && t2(m3) < t2(a4) && (i5.el.style[e4] = `-${t2(f3, 1e3)}px`));
      }
      let g3, b3, v3 = [...this.inTransition];
      if (v3.length > 1 && (g3 = c4[v3[0]], b3 = c4[v3[1]]), g3 && b3) {
        let i5 = 0;
        for (const n5 of h4)
          n5.el ? this.inTransition.has(n5.index) && g3.slides.indexOf(n5) < 0 && (n5.el.style[e4] = `${t2(i5 + (g3.pos - b3.pos), 1e3)}px`) : i5 += n5.dim + n5.gap;
      }
    }
    createSlideEl(t4) {
      const { track: e4, slides: i4 } = this;
      if (!e4 || !t4)
        return;
      if (t4.el)
        return;
      const n4 = document.createElement("div");
      E2(n4, this.cn("slide")), E2(n4, t4.class), E2(n4, t4.customClass), t4.html && (n4.innerHTML = t4.html);
      const s4 = [];
      i4.forEach((t5, e5) => {
        t5.el && s4.push(e5);
      });
      const o4 = t4.index;
      let a4 = null;
      if (s4.length) {
        a4 = i4[s4.reduce((t5, e5) => Math.abs(e5 - o4) < Math.abs(t5 - o4) ? e5 : t5)];
      }
      const r4 = a4 && a4.el ? a4.index < t4.index ? a4.el.nextSibling : a4.el : null;
      e4.insertBefore(n4, e4.contains(r4) ? r4 : null), t4.el = n4, this.emit("createSlide", t4);
    }
    removeSlideEl(t4, e4 = false) {
      const i4 = t4.el;
      if (!i4)
        return;
      if (S2(i4, this.cn("isSelected")), t4.isDom && !e4)
        return i4.removeAttribute("aria-hidden"), i4.removeAttribute("data-index"), S2(i4, this.cn("isSelected")), void (i4.style.left = "");
      this.emit("removeSlide", t4);
      const n4 = new CustomEvent("animationend");
      i4.dispatchEvent(n4), t4.el && t4.el.remove(), t4.el = null;
    }
    transitionTo(e4 = 0, i4 = this.option("transition")) {
      if (!i4)
        return false;
      const { pages: n4, panzoom: s4 } = this;
      e4 = parseInt((e4 || 0).toString()) || 0;
      const o4 = this.getPageFromIndex(e4);
      if (!s4 || !n4[o4] || n4.length < 2 || Math.abs(n4[this.page].slides[0].dim - this.viewportDim) > 1)
        return false;
      const a4 = e4 > this.page ? 1 : -1, r4 = this.pages[o4].pos * (this.isRTL ? 1 : -1);
      if (this.page === o4 && t2(r4, 1e3) === t2(s4.target[this.axis], 1e3))
        return false;
      this.clearTransitions();
      const l4 = s4.isResting;
      E2(this.container, this.cn("inTransition"));
      const c4 = this.pages[this.page].slides[0], h4 = this.pages[o4].slides[0];
      this.inTransition.add(h4.index), this.createSlideEl(h4);
      let d4 = c4.el, u4 = h4.el;
      l4 || i4 === "slide" || (i4 = "fadeFast", d4 = null);
      const p4 = this.isRTL ? "next" : "prev", f3 = this.isRTL ? "prev" : "next";
      return d4 && (this.inTransition.add(c4.index), c4.transition = i4, d4.addEventListener("animationend", this.onAnimationEnd), d4.classList.add(`f-${i4}Out`, `to-${a4 > 0 ? f3 : p4}`)), u4 && (h4.transition = i4, u4.addEventListener("animationend", this.onAnimationEnd), u4.classList.add(`f-${i4}In`, `from-${a4 > 0 ? p4 : f3}`)), s4.panTo({ x: this.isHorizontal ? r4 : 0, y: this.isHorizontal ? 0 : r4, friction: 0 }), this.onChange(o4), true;
    }
    manageSlideVisiblity() {
      const t4 = new Set(), e4 = new Set(), i4 = this.getVisibleSlides(parseFloat(this.option("preload", 0) + "") || 0);
      for (const n4 of this.slides)
        i4.has(n4) ? t4.add(n4) : e4.add(n4);
      for (const e5 of this.inTransition)
        t4.add(this.slides[e5]);
      for (const e5 of t4)
        this.createSlideEl(e5), this.lazyLoadSlide(e5);
      for (const i5 of e4)
        t4.has(i5) || this.removeSlideEl(i5);
      this.markSelectedSlides(), this.repositionSlides();
    }
    markSelectedSlides() {
      if (!this.pages[this.page] || !this.pages[this.page].slides)
        return;
      const t4 = "aria-hidden";
      let e4 = this.cn("isSelected");
      if (e4)
        for (const i4 of this.slides)
          i4.el && (i4.el.dataset.index = `${i4.index}`, this.pages[this.page].slides.includes(i4) ? (i4.el.classList.contains(e4) || (E2(i4.el, e4), this.emit("selectSlide", i4)), i4.el.removeAttribute(t4)) : (i4.el.classList.contains(e4) && (S2(i4.el, e4), this.emit("unselectSlide", i4)), i4.el.setAttribute(t4, "true")));
    }
    flipInfiniteTrack() {
      const t4 = this.panzoom;
      if (!t4 || !this.isInfinite)
        return;
      const e4 = this.option("axis") === "x" ? "e" : "f", { viewportDim: i4, contentDim: n4 } = this;
      let s4 = t4.current[e4], o4 = t4.target[e4] - s4, a4 = 0, r4 = 0.5 * i4, l4 = n4;
      this.isRTL && this.isHorizontal ? (s4 < -r4 && (a4 = -1, s4 += l4), s4 > l4 - r4 && (a4 = 1, s4 -= l4)) : (s4 > r4 && (a4 = 1, s4 -= l4), s4 < -l4 + r4 && (a4 = -1, s4 += l4)), a4 && (t4.current[e4] = s4, t4.target[e4] = s4 + o4);
    }
    lazyLoadSlide(t4) {
      const e4 = this, i4 = t4 && t4.el;
      if (!i4)
        return;
      const s4 = new Set(), o4 = "f-fadeIn";
      i4.querySelectorAll("[data-lazy-srcset]").forEach((t5) => {
        t5 instanceof HTMLImageElement && s4.add(t5);
      });
      let a4 = Array.from(i4.querySelectorAll("[data-lazy-src]"));
      i4.dataset.lazySrc && a4.push(i4), a4.map((t5) => {
        t5 instanceof HTMLImageElement ? s4.add(t5) : x2(t5) && (t5.style.backgroundImage = `url('${t5.dataset.lazySrc || ""}')`, delete t5.dataset.lazySrc);
      });
      const r4 = (t5, i5, n4) => {
        n4 && (n4.remove(), n4 = null), i5.complete && (i5.classList.add(o4), setTimeout(() => {
          i5.classList.remove(o4);
        }, 350), i5.style.display = ""), this.option("adaptiveHeight") && t5.el && this.pages[this.page].slides.indexOf(t5) > -1 && (e4.updateMetrics(), e4.setViewportHeight()), this.emit("load", t5);
      };
      for (const e5 of s4) {
        let i5 = null;
        e5.src = e5.dataset.lazySrcset || e5.dataset.lazySrc || "", delete e5.dataset.lazySrc, delete e5.dataset.lazySrcset, e5.style.display = "none", e5.addEventListener("error", () => {
          r4(t4, e5, i5);
        }), e5.addEventListener("load", () => {
          r4(t4, e5, i5);
        }), setTimeout(() => {
          e5.parentNode && t4.el && (e5.complete ? r4(t4, e5, i5) : (i5 = n2(w2), e5.parentNode.insertBefore(i5, e5)));
        }, 300);
      }
    }
    onAnimationEnd(t4) {
      var e4;
      const i4 = t4.target, n4 = i4 ? parseInt(i4.dataset.index || "", 10) || 0 : -1, s4 = this.slides[n4], o4 = t4.animationName;
      if (!i4 || !s4 || !o4)
        return;
      const a4 = !!this.inTransition.has(n4) && s4.transition;
      a4 && o4.substring(0, a4.length + 2) === `f-${a4}` && this.inTransition.delete(n4), this.inTransition.size || this.clearTransitions(), n4 === this.page && ((e4 = this.panzoom) === null || e4 === void 0 ? void 0 : e4.isResting) && this.emit("settle");
    }
    onDecel(t4, e4 = 0, i4 = 0, n4 = 0, s4 = 0) {
      const { isRTL: o4, isHorizontal: a4, axis: r4, pages: l4 } = this, c4 = l4.length, h4 = Math.abs(Math.atan2(i4, e4) / (Math.PI / 180));
      let d4 = 0;
      if (d4 = h4 > 45 && h4 < 135 ? a4 ? 0 : i4 : a4 ? e4 : 0, !c4)
        return;
      const u4 = this.option("dragFree");
      let p4 = this.page, f3 = o4 && a4 ? 1 : -1;
      const m3 = t4.target[r4] * f3, g3 = t4.current[r4] * f3;
      let { pageIndex: b3 } = this.getPageFromPosition(m3), { pageIndex: v3 } = this.getPageFromPosition(g3);
      u4 ? this.onChange(b3) : (Math.abs(d4) > 5 ? (l4[p4].dim < document.documentElement["client" + (this.isHorizontal ? "Width" : "Height")] - 1 && (p4 = v3), p4 = o4 && a4 ? d4 < 0 ? p4 - 1 : p4 + 1 : d4 < 0 ? p4 + 1 : p4 - 1) : p4 = n4 === 0 && s4 === 0 ? p4 : v3, this.slideTo(p4, { transition: false, friction: t4.option("decelFriction") }));
    }
    onClick(t4) {
      const e4 = t4.target, i4 = e4 && x2(e4) ? e4.dataset : null;
      let n4, s4;
      i4 && (i4.carouselPage !== void 0 ? (s4 = "slideTo", n4 = i4.carouselPage) : i4.carouselNext !== void 0 ? s4 = "slideNext" : i4.carouselPrev !== void 0 && (s4 = "slidePrev")), s4 ? (t4.preventDefault(), t4.stopPropagation(), e4 && !e4.hasAttribute("disabled") && this[s4](n4)) : this.emit("click", t4);
    }
    onSlideTo(t4) {
      const e4 = t4.detail || 0;
      this.slideTo(this.getPageForSlide(e4), { friction: 0 });
    }
    onChange(t4, e4 = 0) {
      const i4 = this.page;
      this.prevPage = i4, this.page = t4, this.option("adaptiveHeight") && this.setViewportHeight(), t4 !== i4 && (this.markSelectedSlides(), this.emit("change", t4, i4, e4));
    }
    onRefresh() {
      let t4 = this.contentDim, e4 = this.viewportDim;
      this.updateMetrics(), this.contentDim === t4 && this.viewportDim === e4 || this.slideTo(this.page, { friction: 0, transition: false });
    }
    onResize() {
      this.option("breakpoints") && this.processOptions();
    }
    onBeforeTransform(t4) {
      this.lp !== t4.current[this.axis] && (this.flipInfiniteTrack(), this.manageSlideVisiblity()), this.lp = t4.current.e;
    }
    onEndAnimation() {
      this.inTransition.size || this.emit("settle");
    }
    reInit(t4 = null, e4 = null) {
      this.destroy(), this.state = L2.Init, this.userOptions = t4 || this.userOptions, this.userPlugins = e4 || this.userPlugins, this.processOptions();
    }
    slideTo(t4 = 0, { friction: e4 = this.option("friction"), transition: i4 = this.option("transition") } = {}) {
      if (this.state === L2.Destroy)
        return;
      const { axis: n4, isHorizontal: s4, isRTL: o4, pages: a4, panzoom: r4 } = this, l4 = a4.length, c4 = o4 && s4 ? 1 : -1;
      if (!r4 || !l4)
        return;
      if (this.transitionTo(t4, i4))
        return;
      const h4 = this.getPageFromIndex(t4);
      let d4 = a4[h4].pos;
      if (this.isInfinite) {
        const e5 = this.contentDim, i5 = r4.target[n4] * c4;
        if (l4 === 2)
          d4 += e5 * Math.floor(parseFloat(t4 + "") / 2);
        else {
          const t5 = i5;
          d4 = [d4, d4 - e5, d4 + e5].reduce(function(e6, i6) {
            return Math.abs(i6 - t5) < Math.abs(e6 - t5) ? i6 : e6;
          });
        }
      }
      d4 *= c4, Math.abs(r4.target[n4] - d4) < 0.1 || (r4.panTo({ x: s4 ? d4 : 0, y: s4 ? 0 : d4, friction: e4 }), this.onChange(h4));
    }
    slideToClosest(t4) {
      if (this.panzoom) {
        const { pageIndex: e4 } = this.getPageFromPosition(this.panzoom.current[this.isHorizontal ? "e" : "f"]);
        this.slideTo(e4, t4);
      }
    }
    slideNext() {
      this.slideTo(this.page + 1);
    }
    slidePrev() {
      this.slideTo(this.page - 1);
    }
    clearTransitions() {
      this.inTransition.clear(), S2(this.container, this.cn("inTransition"));
      const t4 = ["to-prev", "to-next", "from-prev", "from-next"];
      for (const e4 of this.slides) {
        const i4 = e4.el;
        if (i4) {
          i4.removeEventListener("animationend", this.onAnimationEnd), i4.classList.remove(...t4);
          const n4 = e4.transition;
          n4 && i4.classList.remove(`f-${n4}Out`, `f-${n4}In`);
        }
      }
      this.manageSlideVisiblity();
    }
    prependSlide(t4) {
      var e4, i4;
      let n4 = Array.isArray(t4) ? t4 : [t4];
      for (const t5 of n4.reverse())
        this.slides.unshift(R2(t5));
      for (let t5 = 0; t5 < this.slides.length; t5++)
        this.slides[t5].index = t5;
      const s4 = ((e4 = this.pages[this.page]) === null || e4 === void 0 ? void 0 : e4.pos) || 0;
      this.page += n4.length, this.updateMetrics();
      const o4 = ((i4 = this.pages[this.page]) === null || i4 === void 0 ? void 0 : i4.pos) || 0;
      if (this.panzoom) {
        const t5 = this.isRTL ? s4 - o4 : o4 - s4;
        this.panzoom.target.e -= t5, this.panzoom.current.e -= t5, this.panzoom.requestTick();
      }
    }
    appendSlide(t4) {
      let e4 = Array.isArray(t4) ? t4 : [t4];
      for (const t5 of e4) {
        const e5 = R2(t5);
        e5.index = this.slides.length, this.slides.push(e5), this.emit("initSlide", t5, this.slides.length);
      }
      this.updateMetrics();
    }
    removeSlide(t4) {
      const e4 = this.slides.length;
      t4 = (t4 % e4 + e4) % e4, this.removeSlideEl(this.slides[t4], true), this.slides.splice(t4, 1);
      for (let t5 = 0; t5 < this.slides.length; t5++)
        this.slides[t5].index = t5;
      this.updateMetrics(), this.slideTo(this.page, { friction: 0, transition: false });
    }
    updateMetrics() {
      const { panzoom: e4, viewport: i4, track: n4, isHorizontal: s4 } = this;
      if (!n4)
        return;
      const o4 = s4 ? "width" : "height", a4 = s4 ? "offsetWidth" : "offsetHeight";
      if (i4) {
        let e5 = Math.max(i4[a4], t2(i4.getBoundingClientRect()[o4], 1e3)), n5 = getComputedStyle(i4), r5 = "padding", l5 = s4 ? "Right" : "Bottom";
        e5 -= parseFloat(n5[r5 + (s4 ? "Left" : "Top")]) + parseFloat(n5[r5 + l5]), this.viewportDim = e5;
      }
      let r4, l4 = this.pages.length, c4 = 0;
      for (const [e5, i5] of this.slides.entries()) {
        let n5 = 0, s5 = 0;
        !i5.el && r4 ? (n5 = r4.dim, s5 = r4.gap) : ({ dim: n5, gap: s5 } = this.getSlideMetrics(i5), r4 = i5), n5 = t2(n5, 1e3), s5 = t2(s5, 1e3), i5.dim = n5, i5.gap = s5, i5.pos = c4, c4 += n5, (this.isInfinite || e5 < this.slides.length - 1) && (c4 += s5);
      }
      const h4 = this.contentDim;
      c4 = t2(c4, 1e3), this.contentDim = c4, e4 && (e4.contentRect[o4] = c4, e4.contentRect[this.axis === "e" ? "fullWidth" : "fullHeight"] = c4), this.pages = this.createPages(), this.pages = this.processPages(), this.state === L2.Init && this.setInitialPage(), this.page = Math.max(0, Math.min(this.page, this.pages.length - 1)), e4 && l4 === this.pages.length && Math.abs(c4 - h4) > 0.5 && (e4.target[this.axis] = -1 * this.pages[this.page].pos, e4.current[this.axis] = -1 * this.pages[this.page].pos, e4.stop()), this.manageSlideVisiblity(), this.emit("refresh");
    }
    getProgress(e4, i4 = false) {
      e4 === void 0 && (e4 = this.page);
      const n4 = this, s4 = n4.panzoom, o4 = n4.pages[e4] || 0;
      if (!o4 || !s4)
        return 0;
      let a4 = -1 * s4.current.e, r4 = n4.contentDim;
      var l4 = [t2((a4 - o4.pos) / (1 * o4.dim), 1e3), t2((a4 + r4 - o4.pos) / (1 * o4.dim), 1e3), t2((a4 - r4 - o4.pos) / (1 * o4.dim), 1e3)].reduce(function(t4, e5) {
        return Math.abs(e5) < Math.abs(t4) ? e5 : t4;
      });
      return i4 ? l4 : Math.max(-1, Math.min(1, l4));
    }
    setViewportHeight() {
      const { page: t4, pages: e4, viewport: i4, isHorizontal: n4 } = this;
      if (!i4 || !e4[t4])
        return;
      let s4 = 0;
      n4 && this.track && (this.track.style.height = "auto", e4[t4].slides.forEach((t5) => {
        t5.el && (s4 = Math.max(s4, t5.el.offsetHeight));
      })), i4.style.height = s4 ? `${s4}px` : "";
    }
    getPageForSlide(t4) {
      for (const e4 of this.pages)
        for (const i4 of e4.slides)
          if (i4.index === t4)
            return e4.index;
      return -1;
    }
    getVisibleSlides(t4 = 0) {
      var e4;
      const i4 = new Set();
      let { contentDim: n4, viewportDim: s4, pages: o4, page: a4 } = this;
      n4 = n4 + ((e4 = this.slides[this.slides.length - 1]) === null || e4 === void 0 ? void 0 : e4.gap) || 0;
      let r4 = 0;
      r4 = this.panzoom ? -1 * this.panzoom.current[this.axis] : o4[a4] && o4[a4].pos || 0, this.isInfinite && (r4 -= Math.floor(r4 / n4) * n4), this.isRTL && this.isHorizontal && (r4 *= -1);
      const l4 = r4 - s4 * t4, c4 = r4 + s4 * (t4 + 1), h4 = this.isInfinite ? [-1, 0, 1] : [0];
      for (const t5 of this.slides)
        for (const e5 of h4) {
          const s5 = t5.pos + e5 * n4, o5 = t5.pos + t5.dim + t5.gap + e5 * n4;
          s5 < c4 && o5 > l4 && i4.add(t5);
        }
      return i4;
    }
    getPageFromPosition(t4) {
      const { viewportDim: e4, contentDim: i4 } = this, n4 = this.pages.length, s4 = this.slides.length, o4 = this.slides[s4 - 1];
      let a4 = 0, r4 = 0, l4 = 0;
      const c4 = this.option("center");
      c4 && (t4 += 0.5 * e4), this.isInfinite || (t4 = Math.max(this.slides[0].pos, Math.min(t4, o4.pos)));
      const h4 = i4 + o4.gap;
      l4 = Math.floor(t4 / h4) || 0, t4 -= l4 * h4;
      let d4 = o4, u4 = this.slides.find((e5) => {
        const i5 = t4 + (d4 && !c4 ? 0.5 * d4.dim : 0);
        return d4 = e5, e5.pos <= i5 && e5.pos + e5.dim + e5.gap > i5;
      });
      return u4 || (u4 = o4), r4 = this.getPageForSlide(u4.index), a4 = r4 + l4 * n4, { page: a4, pageIndex: r4 };
    }
    destroy() {
      if ([L2.Destroy].includes(this.state))
        return;
      this.state = L2.Destroy;
      const { container: t4, viewport: e4, track: i4, slides: n4, panzoom: s4 } = this, o4 = this.option("classes");
      t4.removeEventListener("click", this.onClick, { passive: false, capture: false }), t4.removeEventListener("slideTo", this.onSlideTo), window.removeEventListener("resize", this.onResize), s4 && (s4.destroy(), this.panzoom = null), n4 && n4.forEach((t5) => {
        this.removeSlideEl(t5);
      }), this.detachPlugins(), e4 && e4.offsetParent && i4 && i4.offsetParent && e4.replaceWith(...i4.childNodes);
      for (const [e5, i5] of Object.entries(o4))
        e5 !== "container" && i5 && t4.classList.remove(i5);
      this.track = null, this.viewport = null, this.page = 0, this.slides = [];
      const a4 = this.events.get("ready");
      this.events = new Map(), a4 && this.events.set("ready", a4);
    }
  };
  Object.defineProperty(_, "Panzoom", { enumerable: true, configurable: true, writable: true, value: T2 }), Object.defineProperty(_, "defaults", { enumerable: true, configurable: true, writable: true, value: z2 }), Object.defineProperty(_, "Plugins", { enumerable: true, configurable: true, writable: true, value: B });
  var N = function(t4) {
    const e4 = window.pageYOffset, i4 = window.pageYOffset + window.innerHeight;
    if (!x2(t4))
      return 0;
    const n4 = t4.getBoundingClientRect(), s4 = n4.y + window.pageYOffset, o4 = n4.y + n4.height + window.pageYOffset;
    if (e4 > o4 || i4 < s4)
      return 0;
    if (e4 < s4 && i4 > o4)
      return 100;
    if (s4 < e4 && o4 > i4)
      return 100;
    let a4 = n4.height;
    s4 < e4 && (a4 -= window.pageYOffset - s4), o4 > i4 && (a4 -= o4 - i4);
    const r4 = a4 / window.innerHeight * 100;
    return Math.round(r4);
  };
  var W = !(typeof window == "undefined" || !window.document || !window.document.createElement);
  var $2;
  var X = ["a[href]", "area[href]", 'input:not([disabled]):not([type="hidden"]):not([aria-hidden])', "select:not([disabled]):not([aria-hidden])", "textarea:not([disabled]):not([aria-hidden])", "button:not([disabled]):not([aria-hidden]):not(.fancybox-focus-guard)", "iframe", "object", "embed", "video", "audio", "[contenteditable]", '[tabindex]:not([tabindex^="-"]):not([disabled]):not([aria-hidden])'].join(",");
  var Y = (t4) => {
    if (t4 && W) {
      $2 === void 0 && document.createElement("div").focus({ get preventScroll() {
        return $2 = true, false;
      } });
      try {
        if ($2)
          t4.focus({ preventScroll: true });
        else {
          const e4 = window.pageXOffset || document.body.scrollTop, i4 = window.pageYOffset || document.body.scrollLeft;
          t4.focus(), document.body.scrollTo({ top: e4, left: i4, behavior: "auto" });
        }
      } catch (t5) {
      }
    }
  };
  var q = { dragToClose: true, hideScrollbar: true, Carousel: { classes: { container: "fancybox__carousel", viewport: "fancybox__viewport", track: "fancybox__track", slide: "fancybox__slide" } }, contentClick: "toggleZoom", contentDblClick: false, backdropClick: "close", animated: true, idle: 3500, showClass: "f-zoomInUp", hideClass: "f-fadeOut", commonCaption: false, parentEl: null, startIndex: 0, l10n: Object.assign(Object.assign({}, v2), { CLOSE: "Close", NEXT: "Next", PREV: "Previous", MODAL: "You can close this modal content with the ESC key", ERROR: "Something Went Wrong, Please Try Again Later", IMAGE_ERROR: "Image Not Found", ELEMENT_NOT_FOUND: "HTML Element Not Found", AJAX_NOT_FOUND: "Error Loading AJAX : Not Found", AJAX_FORBIDDEN: "Error Loading AJAX : Forbidden", IFRAME_ERROR: "Error Loading Page", TOGGLE_ZOOM: "Toggle zoom level", TOGGLE_THUMBS: "Toggle thumbnails", TOGGLE_SLIDESHOW: "Toggle slideshow", TOGGLE_FULLSCREEN: "Toggle full-screen mode", DOWNLOAD: "Download" }), tpl: { closeButton: '<button data-fancybox-close class="f-button is-close-btn" title="{{CLOSE}}"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" tabindex="-1"><path d="M20 20L4 4m16 0L4 20"/></svg></button>', main: '<div class="fancybox__container" role="dialog" aria-modal="true" aria-label="{{MODAL}}" tabindex="-1">\n    <div class="fancybox__backdrop"></div>\n    <div class="fancybox__carousel"></div>\n    <div class="fancybox__footer"></div>\n  </div>' }, groupAll: false, groupAttr: "data-fancybox", defaultType: "image", defaultDisplay: "block", autoFocus: true, trapFocus: true, placeFocusBack: true, closeButton: "auto", keyboard: { Escape: "close", Delete: "close", Backspace: "close", PageUp: "next", PageDown: "prev", ArrowUp: "prev", ArrowDown: "next", ArrowRight: "next", ArrowLeft: "prev" }, Fullscreen: { autoStart: false }, compact: () => window.matchMedia("(max-width: 578px), (max-height: 578px)").matches, wheel: "zoom" };
  var V;
  var Z;
  !function(t4) {
    t4[t4.Init = 0] = "Init", t4[t4.Ready = 1] = "Ready", t4[t4.Closing = 2] = "Closing", t4[t4.CustomClosing = 3] = "CustomClosing", t4[t4.Destroy = 4] = "Destroy";
  }(V || (V = {})), function(t4) {
    t4[t4.Loading = 0] = "Loading", t4[t4.Opening = 1] = "Opening", t4[t4.Ready = 2] = "Ready", t4[t4.Closing = 3] = "Closing";
  }(Z || (Z = {}));
  var G = () => {
    queueMicrotask(() => {
      (() => {
        const { slug: t4, index: e4 } = U.parseURL(), i4 = xt.getInstance();
        if (i4 && i4.option("Hash") !== false) {
          const n4 = i4.carousel;
          if (t4 && n4) {
            for (let e5 of n4.slides)
              if (e5.slug && e5.slug === t4)
                return n4.slideTo(e5.index);
            if (t4 === i4.option("slug"))
              return n4.slideTo(e4 - 1);
            const s4 = i4.getSlide(), o4 = s4 && s4.triggerEl && s4.triggerEl.dataset;
            if (o4 && o4.fancybox === t4)
              return n4.slideTo(e4 - 1);
          }
          U.hasSilentClose = true, i4.close();
        }
        U.startFromUrl();
      })();
    });
  };
  var U = class extends I2 {
    constructor() {
      super(...arguments), Object.defineProperty(this, "origHash", { enumerable: true, configurable: true, writable: true, value: "" }), Object.defineProperty(this, "timer", { enumerable: true, configurable: true, writable: true, value: null });
    }
    onChange() {
      const t4 = this.instance, e4 = t4.carousel;
      this.timer && clearTimeout(this.timer);
      const i4 = t4.getSlide();
      if (!e4 || !i4)
        return;
      const n4 = t4.isOpeningSlide(i4), s4 = new URL(document.URL).hash;
      let o4, a4 = i4.slug || void 0, r4 = i4.triggerEl || void 0;
      o4 = a4 || this.instance.option("slug"), !o4 && r4 && r4.dataset && (o4 = r4.dataset.fancybox);
      let l4 = "";
      o4 && o4 !== "true" && (l4 = "#" + o4 + (!a4 && e4.slides.length > 1 ? "-" + (i4.index + 1) : "")), n4 && (this.origHash = s4 !== l4 ? s4 : ""), l4 && s4 !== l4 && (this.timer = setTimeout(() => {
        try {
          t4.state === V.Ready && window.history[n4 ? "pushState" : "replaceState"]({}, document.title, window.location.pathname + window.location.search + l4);
        } catch (t5) {
        }
      }, 300));
    }
    onClose() {
      if (this.timer && clearTimeout(this.timer), U.hasSilentClose !== true)
        try {
          window.history.replaceState({}, document.title, window.location.pathname + window.location.search + (this.origHash || ""));
        } catch (t4) {
        }
    }
    attach() {
      const t4 = this.instance;
      t4.on("Carousel.ready", this.onChange), t4.on("Carousel.change", this.onChange), t4.on("close", this.onClose);
    }
    detach() {
      const t4 = this.instance;
      t4.off("Carousel.ready", this.onChange), t4.off("Carousel.change", this.onChange), t4.off("close", this.onClose);
    }
    static parseURL() {
      const t4 = window.location.hash.slice(1), e4 = t4.split("-"), i4 = e4[e4.length - 1], n4 = i4 && /^\+?\d+$/.test(i4) && parseInt(e4.pop() || "1", 10) || 1;
      return { hash: t4, slug: e4.join("-"), index: n4 };
    }
    static startFromUrl() {
      if (U.hasSilentClose = false, xt.getInstance() || xt.defaults.Hash === false)
        return;
      const { hash: t4, slug: e4, index: i4 } = U.parseURL();
      if (!e4)
        return;
      let n4 = document.querySelector(`[data-slug="${t4}"]`);
      if (n4 && n4.dispatchEvent(new CustomEvent("click", { bubbles: true, cancelable: true })), xt.getInstance())
        return;
      const s4 = document.querySelectorAll(`[data-fancybox="${e4}"]`);
      s4.length && (n4 = s4[i4 - 1], n4 && n4.dispatchEvent(new CustomEvent("click", { bubbles: true, cancelable: true })));
    }
    static destroy() {
      window.removeEventListener("hashchange", G, false);
    }
  };
  function K() {
    window.addEventListener("hashchange", G, false), setTimeout(() => {
      U.startFromUrl();
    }, 500);
  }
  Object.defineProperty(U, "defaults", { enumerable: true, configurable: true, writable: true, value: {} }), Object.defineProperty(U, "hasSilentClose", { enumerable: true, configurable: true, writable: true, value: false }), W && (/complete|interactive|loaded/.test(document.readyState) ? K() : document.addEventListener("DOMContentLoaded", K));
  var J = class extends I2 {
    onCreateSlide(t4, e4, i4) {
      const n4 = this.instance.optionFor(i4, "src") || "";
      i4.el && i4.type === "image" && typeof n4 == "string" && this.setImage(i4, n4);
    }
    onRemoveSlide(t4, e4, i4) {
      i4.panzoom && i4.panzoom.destroy(), i4.panzoom = void 0, i4.imageEl = void 0;
    }
    onChange(t4, e4, i4, n4) {
      for (const t5 of e4.slides) {
        const e5 = t5.panzoom;
        e5 && t5.index !== i4 && e5.reset(0.35);
      }
    }
    onClose() {
      var t4;
      const e4 = this.instance, i4 = e4.container, n4 = e4.getSlide();
      if (!i4 || !i4.parentElement || !n4)
        return;
      const { el: s4, contentEl: o4, panzoom: a4 } = n4, r4 = n4.thumbElSrc;
      if (!s4 || !r4 || !o4 || !a4 || a4.isContentLoading || a4.state === g2.Init || a4.state === g2.Destroy)
        return;
      a4.updateMetrics();
      let l4 = this.getZoomInfo(n4);
      if (!l4)
        return;
      this.instance.state = V.CustomClosing, i4.classList.remove("is-zooming-in"), i4.classList.add("is-zooming-out"), o4.style.backgroundImage = `url('${r4}')`;
      const c4 = i4.getBoundingClientRect();
      (((t4 = window.visualViewport) === null || t4 === void 0 ? void 0 : t4.scale) || 1) === 1 && Object.assign(i4.style, { position: "absolute", top: `${window.pageYOffset}px`, left: `${window.pageXOffset}px`, bottom: "auto", right: "auto", width: `${c4.width}px`, height: `${c4.height}px`, overflow: "hidden" });
      const { x: h4, y: d4, scale: u4, opacity: p4 } = l4;
      if (p4) {
        const t5 = ((t6, e5, i5, n5) => {
          const s5 = e5 - t6, o5 = n5 - i5;
          return (e6) => i5 + ((e6 - t6) / s5 * o5 || 0);
        })(a4.scale, u4, 1, 0);
        a4.on("afterTransform", () => {
          o4.style.opacity = t5(a4.scale) + "";
        });
      }
      a4.on("endAnimation", () => {
        e4.destroy();
      }), a4.target.a = u4, a4.target.b = 0, a4.target.c = 0, a4.target.d = u4, a4.panTo({ x: h4, y: d4, scale: u4, friction: p4 ? 0.2 : 0.33, ignoreBounds: true }), a4.isResting && e4.destroy();
    }
    setImage(t4, e4) {
      const i4 = this.instance;
      t4.src = e4, this.process(t4, e4).then((e5) => {
        var n4;
        const s4 = t4.contentEl, o4 = t4.imageEl, a4 = t4.thumbElSrc;
        if (i4.isClosing() || !s4 || !o4)
          return;
        s4.offsetHeight;
        const r4 = !!i4.isOpeningSlide(t4) && this.getZoomInfo(t4);
        if (this.option("protected")) {
          (n4 = t4.el) === null || n4 === void 0 || n4.addEventListener("contextmenu", (t5) => {
            t5.preventDefault();
          });
          const e6 = document.createElement("div");
          E2(e6, "fancybox-protected"), s4.appendChild(e6);
        }
        if (a4 && r4) {
          const n5 = e5.contentRect, o5 = Math.max(n5.fullWidth, n5.fullHeight);
          let c4 = null;
          !r4.opacity && o5 > 1200 && (c4 = document.createElement("img"), E2(c4, "fancybox-ghost"), c4.src = a4, s4.appendChild(c4));
          const h4 = () => {
            c4 && (E2(c4, "f-fadeFastOut"), setTimeout(() => {
              c4 && (c4.remove(), c4 = null);
            }, 200));
          };
          (l4 = a4, new Promise((t5, e6) => {
            const i5 = new Image();
            i5.onload = t5, i5.onerror = e6, i5.src = l4;
          })).then(() => {
            t4.state = Z.Opening, this.instance.emit("reveal", t4), this.zoomIn(t4).then(() => {
              h4(), this.instance.done(t4);
            }, () => {
              i4.hideLoading(t4);
            }), c4 && setTimeout(() => {
              h4();
            }, o5 > 2500 ? 800 : 200);
          }, () => {
            i4.hideLoading(t4), i4.revealContent(t4);
          });
        } else {
          const n5 = this.optionFor(t4, "initialSize"), s5 = this.optionFor(t4, "zoom"), o5 = { event: i4.prevMouseMoveEvent || i4.options.event, friction: s5 ? 0.12 : 0 };
          let a5 = i4.optionFor(t4, "showClass") || void 0, r5 = true;
          i4.isOpeningSlide(t4) && (n5 === "full" ? e5.zoomToFull(o5) : n5 === "cover" ? e5.zoomToCover(o5) : n5 === "max" ? e5.zoomToMax(o5) : r5 = false, e5.stop("current")), r5 && a5 && (a5 = e5.isDragging ? "f-fadeIn" : ""), i4.revealContent(t4, a5);
        }
        var l4;
      }, () => {
        i4.setError(t4, "{{IMAGE_ERROR}}");
      });
    }
    process(t4, e4) {
      return new Promise((i4, s4) => {
        var o4, a4;
        const r4 = this.instance, l4 = t4.el;
        r4.clearContent(t4), r4.showLoading(t4);
        let c4 = this.optionFor(t4, "content");
        typeof c4 == "string" && (c4 = n2(c4)), c4 && x2(c4) || (c4 = document.createElement("img"), c4 instanceof HTMLImageElement && (c4.src = e4 || "", c4.alt = ((o4 = t4.caption) === null || o4 === void 0 ? void 0 : o4.replace(/<[^>]+>/gi, "").substring(0, 1e3)) || `Image ${t4.index + 1} of ${(a4 = r4.carousel) === null || a4 === void 0 ? void 0 : a4.pages.length}`, c4.draggable = false, t4.srcset && c4.setAttribute("srcset", t4.srcset)), t4.sizes && c4.setAttribute("sizes", t4.sizes)), c4.classList.add("fancybox-image"), t4.imageEl = c4, r4.setContent(t4, c4, false);
        t4.panzoom = new T2(l4, u2({}, this.option("Panzoom") || {}, { content: c4, width: r4.optionFor(t4, "width", "auto"), height: r4.optionFor(t4, "height", "auto"), wheel: () => {
          const t5 = r4.option("wheel");
          return (t5 === "zoom" || t5 == "pan") && t5;
        }, click: (e5, i5) => {
          var n4, s5;
          if (r4.isCompact || r4.isClosing())
            return false;
          if (t4.index !== ((n4 = r4.getSlide()) === null || n4 === void 0 ? void 0 : n4.index))
            return false;
          let o5 = !i5 || i5.target && ((s5 = t4.contentEl) === null || s5 === void 0 ? void 0 : s5.contains(i5.target));
          return r4.option(o5 ? "contentClick" : "backdropClick") || false;
        }, dblClick: () => r4.isCompact ? "toggleZoom" : r4.option("contentDblClick") || false, spinner: false, panOnlyZoomed: true, wheelLimit: 1 / 0, transformParent: true, on: { ready: (t5) => {
          i4(t5);
        }, error: () => {
          s4();
        }, destroy: () => {
          s4();
        } } }));
      });
    }
    zoomIn(t4) {
      return new Promise((e4, i4) => {
        const n4 = this.instance, s4 = n4.container, { panzoom: o4, contentEl: a4, el: r4 } = t4;
        o4 && o4.updateMetrics();
        const l4 = this.getZoomInfo(t4);
        if (!(l4 && r4 && a4 && o4 && s4))
          return void i4();
        const { x: c4, y: h4, scale: d4, opacity: u4 } = l4, p4 = () => {
          t4.state !== Z.Closing && (u4 && (a4.style.opacity = Math.max(Math.min(1, 1 - (1 - o4.scale) / (1 - d4)), 0) + ""), o4.scale >= 1 && o4.scale > o4.targetScale - 0.1 && e4(o4));
        }, f3 = (t5) => {
          S2(s4, "is-zooming-in"), t5.scale < 0.99 || t5.scale > 1.01 || (a4.style.opacity = "", t5.off("endAnimation", f3), t5.off("touchStart", f3), t5.off("afterTransform", p4), e4(t5));
        };
        o4.on("endAnimation", f3), o4.on("touchStart", f3), o4.on("afterTransform", p4), o4.on(["error", "destroy"], () => {
          i4();
        }), o4.panTo({ x: c4, y: h4, scale: d4, friction: 0, ignoreBounds: true }), o4.stop("current");
        const m3 = { event: o4.panMode === "mousemove" ? n4.prevMouseMoveEvent || n4.options.event : void 0 }, g3 = this.optionFor(t4, "initialSize");
        E2(s4, "is-zooming-in"), n4.hideLoading(t4), g3 === "full" ? o4.zoomToFull(m3) : g3 === "cover" ? o4.zoomToCover(m3) : g3 === "max" ? o4.zoomToMax(m3) : o4.reset(0.172);
      });
    }
    getZoomInfo(t4) {
      var e4;
      const { el: i4, imageEl: n4, thumbEl: s4, panzoom: o4 } = t4;
      if (!i4 || !n4 || !s4 || !o4 || N(s4) < 3 || !this.optionFor(t4, "zoom") || this.instance.state === V.Destroy)
        return false;
      if ((((e4 = window.visualViewport) === null || e4 === void 0 ? void 0 : e4.scale) || 1) !== 1)
        return false;
      let { top: a4, left: r4, width: l4, height: c4 } = s4.getBoundingClientRect(), { top: h4, left: d4, fitWidth: u4, fitHeight: p4 } = o4.contentRect;
      if (!(l4 && c4 && u4 && p4))
        return false;
      const f3 = o4.container.getBoundingClientRect();
      d4 += f3.left, h4 += f3.top;
      const m3 = -1 * (d4 + 0.5 * u4 - (r4 + 0.5 * l4)), g3 = -1 * (h4 + 0.5 * p4 - (a4 + 0.5 * c4)), b3 = l4 / u4;
      let v3 = this.option("zoomOpacity") || false;
      return v3 === "auto" && (v3 = Math.abs(l4 / c4 - u4 / p4) > 0.1), { x: m3, y: g3, scale: b3, opacity: v3 };
    }
    attach() {
      const t4 = this, e4 = t4.instance;
      e4.on("Carousel.change", t4.onChange), e4.on("Carousel.createSlide", t4.onCreateSlide), e4.on("Carousel.removeSlide", t4.onRemoveSlide), e4.on("close", t4.onClose);
    }
    detach() {
      const t4 = this, e4 = t4.instance;
      e4.off("Carousel.change", t4.onChange), e4.off("Carousel.createSlide", t4.onCreateSlide), e4.off("Carousel.removeSlide", t4.onRemoveSlide), e4.off("close", t4.onClose);
    }
  };
  Object.defineProperty(J, "defaults", { enumerable: true, configurable: true, writable: true, value: { initialSize: "fit", Panzoom: { maxScale: 1 }, protected: false, zoom: true, zoomOpacity: "auto" } });
  var Q = (t4, e4 = {}) => {
    const i4 = new URL(t4), n4 = new URLSearchParams(i4.search), s4 = new URLSearchParams();
    for (const [t5, i5] of [...n4, ...Object.entries(e4)]) {
      let e5 = i5.toString();
      t5 === "t" ? s4.set("start", parseInt(e5).toString()) : s4.set(t5, e5);
    }
    let o4 = s4.toString(), a4 = t4.match(/#t=((.*)?\d+s)/);
    return a4 && (o4 += `#t=${a4[1]}`), o4;
  };
  var tt = { ajax: null, autoSize: true, iframeAttr: { allow: "autoplay; fullscreen", scrolling: "auto" }, preload: true, videoAutoplay: true, videoRatio: 16 / 9, videoTpl: `<video class="fancybox__html5video" playsinline controls controlsList="nodownload" poster="{{poster}}">
  <source src="{{src}}" type="{{format}}" />Sorry, your browser doesn't support embedded videos.</video>`, videoFormat: "", vimeo: { byline: 1, color: "00adef", controls: 1, dnt: 1, muted: 0 }, youtube: { controls: 1, enablejsapi: 1, nocookie: 1, rel: 0, fs: 1 } };
  var et = ["image", "html", "ajax", "inline", "clone", "iframe", "map", "pdf", "html5video", "youtube", "vimeo", "video"];
  var it = class extends I2 {
    onInitSlide(t4, e4, i4) {
      this.processType(i4);
    }
    onCreateSlide(t4, e4, i4) {
      this.setContent(i4);
    }
    onRemoveSlide(t4, e4, i4) {
      i4.xhr && (i4.xhr.abort(), i4.xhr = null);
      const n4 = i4.iframeEl;
      n4 && (n4.onload = n4.onerror = null, n4.src = "//about:blank", i4.iframeEl = null);
      const s4 = i4.contentEl, o4 = i4.placeholderEl;
      if (i4.type === "inline" && s4 && o4)
        s4.classList.remove("fancybox__content"), s4.style.display !== "none" && (s4.style.display = "none"), o4.parentNode && o4.parentNode.insertBefore(s4, o4), o4.remove(), i4.contentEl = void 0, i4.placeholderEl = void 0;
      else
        for (; i4.el && i4.el.firstChild; )
          i4.el.removeChild(i4.el.firstChild);
    }
    onSelectSlide(t4, e4, i4) {
      i4.state === Z.Ready && this.playVideo();
    }
    onUnselectSlide(t4, e4, i4) {
      var n4, s4;
      if (i4.type === "html5video") {
        try {
          (s4 = (n4 = i4.el) === null || n4 === void 0 ? void 0 : n4.querySelector("video")) === null || s4 === void 0 || s4.pause();
        } catch (t5) {
        }
        return;
      }
      let o4;
      i4.type === "vimeo" ? o4 = { method: "pause", value: "true" } : i4.type === "youtube" && (o4 = { event: "command", func: "pauseVideo" }), o4 && i4.iframeEl && i4.iframeEl.contentWindow && i4.iframeEl.contentWindow.postMessage(JSON.stringify(o4), "*"), i4.poller && clearTimeout(i4.poller);
    }
    onDone(t4, e4) {
      t4.isCurrentSlide(e4) && !t4.isClosing() && this.playVideo();
    }
    onRefresh(t4, e4) {
      e4.slides.forEach((t5) => {
        t5.el && (this.setAspectRatio(t5), this.resizeIframe(t5));
      });
    }
    onMessage(t4) {
      try {
        let e4 = JSON.parse(t4.data);
        if (t4.origin === "https://player.vimeo.com") {
          if (e4.event === "ready")
            for (let e5 of Array.from(document.getElementsByClassName("fancybox__iframe")))
              e5 instanceof HTMLIFrameElement && e5.contentWindow === t4.source && (e5.dataset.ready = "true");
        } else if (t4.origin.match(/^https:\/\/(www.)?youtube(-nocookie)?.com$/) && e4.event === "onReady") {
          const t5 = document.getElementById(e4.id);
          t5 && (t5.dataset.ready = "true");
        }
      } catch (t5) {
      }
    }
    loadAjaxContent(t4) {
      const e4 = this.instance.optionFor(t4, "src") || "";
      this.instance.showLoading(t4);
      const i4 = this.instance, n4 = new XMLHttpRequest();
      i4.showLoading(t4), n4.onreadystatechange = function() {
        n4.readyState === XMLHttpRequest.DONE && i4.state === V.Ready && (i4.hideLoading(t4), n4.status === 200 ? i4.setContent(t4, n4.responseText) : i4.setError(t4, n4.status === 404 ? "{{AJAX_NOT_FOUND}}" : "{{AJAX_FORBIDDEN}}"));
      };
      const s4 = t4.ajax || null;
      n4.open(s4 ? "POST" : "GET", e4 + ""), n4.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"), n4.setRequestHeader("X-Requested-With", "XMLHttpRequest"), n4.send(s4), t4.xhr = n4;
    }
    setInlineContent(t4) {
      let e4 = null;
      if (x2(t4.src))
        e4 = t4.src;
      else if (typeof t4.src == "string") {
        const i4 = t4.src.split("#", 2).pop();
        e4 = i4 ? document.getElementById(i4) : null;
      }
      if (e4) {
        if (t4.type === "clone" || e4.closest(".fancybox__slide")) {
          e4 = e4.cloneNode(true);
          const i4 = e4.dataset.animationName;
          i4 && (e4.classList.remove(i4), delete e4.dataset.animationName);
          let n4 = e4.getAttribute("id");
          n4 = n4 ? `${n4}--clone` : `clone-${this.instance.id}-${t4.index}`, e4.setAttribute("id", n4);
        } else if (e4.parentNode) {
          const i4 = document.createElement("div");
          i4.classList.add("fancybox-placeholder"), e4.parentNode.insertBefore(i4, e4), t4.placeholderEl = i4;
        }
        this.instance.setContent(t4, e4);
      } else
        this.instance.setError(t4, "{{ELEMENT_NOT_FOUND}}");
    }
    setIframeContent(t4) {
      const { src: e4, el: i4 } = t4;
      if (!e4 || typeof e4 != "string" || !i4)
        return;
      const n4 = this.instance, s4 = document.createElement("iframe");
      s4.className = "fancybox__iframe", s4.setAttribute("id", `fancybox__iframe_${n4.id}_${t4.index}`);
      for (const [e5, i5] of Object.entries(this.optionFor(t4, "iframeAttr") || {}))
        s4.setAttribute(e5, i5);
      s4.onerror = () => {
        n4.setError(t4, "{{IFRAME_ERROR}}");
      }, t4.iframeEl = s4;
      const o4 = this.optionFor(t4, "preload");
      if (i4.classList.add("is-loading"), t4.type !== "iframe" || o4 === false)
        return s4.setAttribute("src", t4.src + ""), this.resizeIframe(t4), void n4.setContent(t4, s4);
      n4.showLoading(t4), s4.onload = () => {
        if (!s4.src.length)
          return;
        const e5 = s4.dataset.ready !== "true";
        s4.dataset.ready = "true", this.resizeIframe(t4), e5 ? n4.revealContent(t4) : n4.hideLoading(t4);
      }, s4.setAttribute("src", e4), n4.setContent(t4, s4, false);
    }
    resizeIframe(t4) {
      const e4 = t4.iframeEl, i4 = e4 == null ? void 0 : e4.parentElement;
      if (!e4 || !i4)
        return;
      let n4 = t4.autoSize, s4 = t4.width || 0, o4 = t4.height || 0;
      s4 && o4 && (n4 = false);
      const a4 = i4 && i4.style;
      if (t4.preload !== false && n4 !== false && a4)
        try {
          const t5 = window.getComputedStyle(i4), n5 = parseFloat(t5.paddingLeft) + parseFloat(t5.paddingRight), r4 = parseFloat(t5.paddingTop) + parseFloat(t5.paddingBottom), l4 = e4.contentWindow;
          if (l4) {
            const t6 = l4.document, e5 = t6.getElementsByTagName("html")[0], i5 = t6.body;
            a4.width = "", i5.style.overflow = "hidden", s4 = s4 || e5.scrollWidth + n5, a4.width = `${s4}px`, i5.style.overflow = "", a4.flex = "0 0 auto", a4.height = `${i5.scrollHeight}px`, o4 = e5.scrollHeight + r4;
          }
        } catch (t5) {
        }
      if (s4 || o4) {
        const t5 = { flex: "0 1 auto", width: "", height: "" };
        s4 && (t5.width = `${s4}px`), o4 && (t5.height = `${o4}px`), Object.assign(a4, t5);
      }
    }
    playVideo() {
      const t4 = this.instance.getSlide();
      if (!t4)
        return;
      const { el: e4 } = t4;
      if (!e4 || !e4.offsetParent)
        return;
      if (!this.optionFor(t4, "videoAutoplay"))
        return;
      if (t4.type === "html5video")
        try {
          const t5 = e4.querySelector("video");
          if (t5) {
            const e5 = t5.play();
            e5 !== void 0 && e5.then(() => {
            }).catch((e6) => {
              t5.muted = true, t5.play();
            });
          }
        } catch (t5) {
        }
      if (t4.type !== "youtube" && t4.type !== "vimeo")
        return;
      const i4 = () => {
        if (t4.iframeEl && t4.iframeEl.contentWindow) {
          let e5;
          if (t4.iframeEl.dataset.ready === "true")
            return e5 = t4.type === "youtube" ? { event: "command", func: "playVideo" } : { method: "play", value: "true" }, e5 && t4.iframeEl.contentWindow.postMessage(JSON.stringify(e5), "*"), void (t4.poller = void 0);
          t4.type === "youtube" && (e5 = { event: "listening", id: t4.iframeEl.getAttribute("id") }, t4.iframeEl.contentWindow.postMessage(JSON.stringify(e5), "*"));
        }
        t4.poller = setTimeout(i4, 250);
      };
      i4();
    }
    processType(t4) {
      if (t4.html)
        return t4.type = "html", t4.src = t4.html, void (t4.html = "");
      const e4 = this.instance.optionFor(t4, "src", "");
      if (!e4 || typeof e4 != "string")
        return;
      let i4 = t4.type, n4 = null;
      if (n4 = e4.match(/(youtube\.com|youtu\.be|youtube\-nocookie\.com)\/(?:watch\?(?:.*&)?v=|v\/|u\/|shorts\/|embed\/?)?(videoseries\?list=(?:.*)|[\w-]{11}|\?listType=(?:.*)&list=(?:.*))(?:.*)/i)) {
        const s4 = this.optionFor(t4, "youtube"), { nocookie: o4 } = s4, a4 = function(t5, e5) {
          var i5 = {};
          for (var n5 in t5)
            Object.prototype.hasOwnProperty.call(t5, n5) && e5.indexOf(n5) < 0 && (i5[n5] = t5[n5]);
          if (t5 != null && typeof Object.getOwnPropertySymbols == "function") {
            var s5 = 0;
            for (n5 = Object.getOwnPropertySymbols(t5); s5 < n5.length; s5++)
              e5.indexOf(n5[s5]) < 0 && Object.prototype.propertyIsEnumerable.call(t5, n5[s5]) && (i5[n5[s5]] = t5[n5[s5]]);
          }
          return i5;
        }(s4, ["nocookie"]), r4 = `www.youtube${o4 ? "-nocookie" : ""}.com`, l4 = Q(e4, a4), c4 = encodeURIComponent(n4[2]);
        t4.videoId = c4, t4.src = `https://${r4}/embed/${c4}?${l4}`, t4.thumbSrc = t4.thumbSrc || `https://i.ytimg.com/vi/${c4}/mqdefault.jpg`, i4 = "youtube";
      } else if (n4 = e4.match(/^.+vimeo.com\/(?:\/)?([\d]+)((\/|\?h=)([a-z0-9]+))?(.*)?/)) {
        const s4 = Q(e4, this.optionFor(t4, "vimeo")), o4 = encodeURIComponent(n4[1]), a4 = n4[4] || "";
        t4.videoId = o4, t4.src = `https://player.vimeo.com/video/${o4}?${a4 ? `h=${a4}${s4 ? "&" : ""}` : ""}${s4}`, i4 = "vimeo";
      }
      if (!i4 && t4.triggerEl) {
        const e5 = t4.triggerEl.dataset.type;
        et.includes(e5) && (i4 = e5);
      }
      i4 || typeof e4 == "string" && (e4.charAt(0) === "#" ? i4 = "inline" : (n4 = e4.match(/\.(mp4|mov|ogv|webm)((\?|#).*)?$/i)) ? (i4 = "html5video", t4.videoFormat = t4.videoFormat || "video/" + (n4[1] === "ogv" ? "ogg" : n4[1])) : e4.match(/(^data:image\/[a-z0-9+\/=]*,)|(\.(jp(e|g|eg)|gif|png|bmp|webp|svg|ico)((\?|#).*)?$)/i) ? i4 = "image" : e4.match(/\.(pdf)((\?|#).*)?$/i) ? i4 = "pdf" : (n4 = e4.match(/(?:maps\.)?google\.([a-z]{2,3}(?:\.[a-z]{2})?)\/(?:(?:(?:maps\/(?:place\/(?:.*)\/)?\@(.*),(\d+.?\d+?)z))|(?:\?ll=))(.*)?/i)) ? (t4.src = `https://maps.google.${n4[1]}/?ll=${(n4[2] ? n4[2] + "&z=" + Math.floor(parseFloat(n4[3])) + (n4[4] ? n4[4].replace(/^\//, "&") : "") : n4[4] + "").replace(/\?/, "&")}&output=${n4[4] && n4[4].indexOf("layer=c") > 0 ? "svembed" : "embed"}`, i4 = "map") : (n4 = e4.match(/(?:maps\.)?google\.([a-z]{2,3}(?:\.[a-z]{2})?)\/(?:maps\/search\/)(.*)/i)) && (t4.src = `https://maps.google.${n4[1]}/maps?q=${n4[2].replace("query=", "q=").replace("api=1", "")}&output=embed`, i4 = "map")), i4 = i4 || this.instance.option("defaultType"), t4.type = i4, i4 === "image" && (t4.thumbSrc = t4.thumbSrc || t4.src);
    }
    setContent(t4) {
      const e4 = this.instance.optionFor(t4, "src") || "";
      if (t4 && t4.type && e4) {
        switch (t4.type) {
          case "html":
            this.instance.setContent(t4, e4);
            break;
          case "html5video":
            const i4 = this.option("videoTpl");
            i4 && this.instance.setContent(t4, i4.replace(/\{\{src\}\}/gi, e4 + "").replace(/\{\{format\}\}/gi, this.optionFor(t4, "videoFormat") || "").replace(/\{\{poster\}\}/gi, t4.poster || t4.thumbSrc || ""));
            break;
          case "inline":
          case "clone":
            this.setInlineContent(t4);
            break;
          case "ajax":
            this.loadAjaxContent(t4);
            break;
          case "pdf":
          case "map":
          case "youtube":
          case "vimeo":
            t4.preload = false;
          case "iframe":
            this.setIframeContent(t4);
        }
        this.setAspectRatio(t4);
      }
    }
    setAspectRatio(t4) {
      var e4;
      const i4 = t4.contentEl, n4 = this.optionFor(t4, "videoRatio"), s4 = (e4 = t4.el) === null || e4 === void 0 ? void 0 : e4.getBoundingClientRect();
      if (!(i4 && s4 && n4 && n4 !== 1 && t4.type && ["video", "youtube", "vimeo", "html5video"].includes(t4.type)))
        return;
      const o4 = s4.width, a4 = s4.height;
      i4.style.aspectRatio = n4 + "", i4.style.width = o4 / a4 > n4 ? "auto" : "", i4.style.height = o4 / a4 > n4 ? "" : "auto";
    }
    attach() {
      const t4 = this, e4 = t4.instance;
      e4.on("Carousel.initSlide", t4.onInitSlide), e4.on("Carousel.createSlide", t4.onCreateSlide), e4.on("Carousel.removeSlide", t4.onRemoveSlide), e4.on("Carousel.selectSlide", t4.onSelectSlide), e4.on("Carousel.unselectSlide", t4.onUnselectSlide), e4.on("Carousel.Panzoom.refresh", t4.onRefresh), e4.on("done", t4.onDone), window.addEventListener("message", t4.onMessage);
    }
    detach() {
      const t4 = this, e4 = t4.instance;
      e4.off("Carousel.initSlide", t4.onInitSlide), e4.off("Carousel.createSlide", t4.onCreateSlide), e4.off("Carousel.removeSlide", t4.onRemoveSlide), e4.off("Carousel.selectSlide", t4.onSelectSlide), e4.off("Carousel.unselectSlide", t4.onUnselectSlide), e4.off("Carousel.Panzoom.refresh", t4.onRefresh), e4.off("done", t4.onDone), window.removeEventListener("message", t4.onMessage);
    }
  };
  Object.defineProperty(it, "defaults", { enumerable: true, configurable: true, writable: true, value: tt });
  var nt = class extends I2 {
    constructor() {
      super(...arguments), Object.defineProperty(this, "state", { enumerable: true, configurable: true, writable: true, value: "ready" }), Object.defineProperty(this, "inHover", { enumerable: true, configurable: true, writable: true, value: false }), Object.defineProperty(this, "timer", { enumerable: true, configurable: true, writable: true, value: null }), Object.defineProperty(this, "progressBar", { enumerable: true, configurable: true, writable: true, value: null });
    }
    get isActive() {
      return this.state !== "ready";
    }
    onReady(t4) {
      this.option("autoStart") && (t4.isInfinite || t4.page < t4.pages.length - 1) && this.start();
    }
    onChange() {
      var t4;
      ((t4 = this.instance.panzoom) === null || t4 === void 0 ? void 0 : t4.isResting) || (this.removeProgressBar(), this.pause());
    }
    onSettle() {
      this.resume();
    }
    onVisibilityChange() {
      document.visibilityState === "visible" ? this.resume() : this.pause();
    }
    onMouseEnter() {
      this.inHover = true, this.pause();
    }
    onMouseLeave() {
      var t4;
      this.inHover = false, ((t4 = this.instance.panzoom) === null || t4 === void 0 ? void 0 : t4.isResting) && this.resume();
    }
    onTimerEnd() {
      const t4 = this.instance;
      this.state === "play" && (t4.isInfinite || t4.page !== t4.pages.length - 1 ? t4.slideNext() : t4.slideTo(0));
    }
    removeProgressBar() {
      this.progressBar && (this.progressBar.remove(), this.progressBar = null);
    }
    createProgressBar() {
      var t4;
      if (!this.option("showProgress"))
        return null;
      this.removeProgressBar();
      const e4 = this.instance, i4 = ((t4 = e4.pages[e4.page]) === null || t4 === void 0 ? void 0 : t4.slides) || [];
      let n4 = this.option("progressParentEl");
      if (n4 || (n4 = (i4.length === 1 ? i4[0].el : null) || e4.viewport), !n4)
        return null;
      const s4 = document.createElement("div");
      return E2(s4, "f-progress"), n4.prepend(s4), this.progressBar = s4, s4.offsetHeight, s4;
    }
    set() {
      const t4 = this, e4 = t4.instance;
      if (e4.pages.length < 2)
        return;
      if (t4.timer)
        return;
      const i4 = t4.option("timeout");
      t4.state = "play", E2(e4.container, "has-autoplay");
      let n4 = t4.createProgressBar();
      n4 && (n4.style.transitionDuration = `${i4}ms`, n4.style.transform = "scaleX(1)"), t4.timer = setTimeout(() => {
        t4.timer = null, t4.inHover || t4.onTimerEnd();
      }, i4), t4.emit("set");
    }
    clear() {
      const t4 = this;
      t4.timer && (clearTimeout(t4.timer), t4.timer = null), t4.removeProgressBar();
    }
    start() {
      const t4 = this;
      if (t4.set(), t4.state !== "ready") {
        if (t4.option("pauseOnHover")) {
          const e4 = t4.instance.container;
          e4.addEventListener("mouseenter", t4.onMouseEnter, false), e4.addEventListener("mouseleave", t4.onMouseLeave, false);
        }
        document.addEventListener("visibilitychange", t4.onVisibilityChange, false), t4.emit("start");
      }
    }
    stop() {
      const t4 = this, e4 = t4.state, i4 = t4.instance.container;
      t4.clear(), t4.state = "ready", i4.removeEventListener("mouseenter", t4.onMouseEnter, false), i4.removeEventListener("mouseleave", t4.onMouseLeave, false), document.removeEventListener("visibilitychange", t4.onVisibilityChange, false), S2(i4, "has-autoplay"), e4 !== "ready" && t4.emit("stop");
    }
    pause() {
      const t4 = this;
      t4.state === "play" && (t4.state = "pause", t4.clear(), t4.emit("pause"));
    }
    resume() {
      const t4 = this, e4 = t4.instance;
      if (e4.isInfinite || e4.page !== e4.pages.length - 1)
        if (t4.state !== "play") {
          if (t4.state === "pause" && !t4.inHover) {
            const e5 = new Event("resume", { bubbles: true, cancelable: true });
            t4.emit("resume", e5), e5.defaultPrevented || t4.set();
          }
        } else
          t4.set();
      else
        t4.stop();
    }
    toggle() {
      this.state === "play" || this.state === "pause" ? this.stop() : this.start();
    }
    attach() {
      const t4 = this, e4 = t4.instance;
      e4.on("ready", t4.onReady), e4.on("Panzoom.startAnimation", t4.onChange), e4.on("Panzoom.endAnimation", t4.onSettle), e4.on("Panzoom.touchMove", t4.onChange);
    }
    detach() {
      const t4 = this, e4 = t4.instance;
      e4.off("ready", t4.onReady), e4.off("Panzoom.startAnimation", t4.onChange), e4.off("Panzoom.endAnimation", t4.onSettle), e4.off("Panzoom.touchMove", t4.onChange), t4.stop();
    }
  };
  Object.defineProperty(nt, "defaults", { enumerable: true, configurable: true, writable: true, value: { autoStart: true, pauseOnHover: true, progressParentEl: null, showProgress: true, timeout: 3e3 } });
  var st = class extends I2 {
    constructor() {
      super(...arguments), Object.defineProperty(this, "ref", { enumerable: true, configurable: true, writable: true, value: null });
    }
    onPrepare(t4) {
      const e4 = t4.carousel;
      if (!e4)
        return;
      const i4 = t4.container;
      i4 && (e4.options.Autoplay = u2({ autoStart: false }, this.option("Autoplay") || {}, { pauseOnHover: false, timeout: this.option("timeout"), progressParentEl: () => this.option("progressParentEl") || null, on: { start: () => {
        t4.emit("startSlideshow");
      }, set: (e5) => {
        var n4;
        i4.classList.add("has-slideshow"), ((n4 = t4.getSlide()) === null || n4 === void 0 ? void 0 : n4.state) !== Z.Ready && e5.pause();
      }, stop: () => {
        i4.classList.remove("has-slideshow"), t4.isCompact || t4.endIdle(), t4.emit("endSlideshow");
      }, resume: (e5, i5) => {
        var n4, s4, o4;
        !i5 || !i5.cancelable || ((n4 = t4.getSlide()) === null || n4 === void 0 ? void 0 : n4.state) === Z.Ready && ((o4 = (s4 = t4.carousel) === null || s4 === void 0 ? void 0 : s4.panzoom) === null || o4 === void 0 ? void 0 : o4.isResting) || i5.preventDefault();
      } } }), e4.attachPlugins({ Autoplay: nt }), this.ref = e4.plugins.Autoplay);
    }
    onReady(t4) {
      const e4 = t4.carousel, i4 = this.ref;
      e4 && i4 && this.option("playOnStart") && (e4.isInfinite || e4.page < e4.pages.length - 1) && i4.start();
    }
    onDone(t4, e4) {
      const i4 = this.ref;
      if (!i4)
        return;
      const n4 = e4.panzoom;
      n4 && n4.on("startAnimation", () => {
        t4.isCurrentSlide(e4) && i4.stop();
      }), t4.isCurrentSlide(e4) && i4.resume();
    }
    onKeydown(t4, e4) {
      var i4;
      const n4 = this.ref;
      n4 && e4 === this.option("key") && ((i4 = document.activeElement) === null || i4 === void 0 ? void 0 : i4.nodeName) !== "BUTTON" && n4.toggle();
    }
    attach() {
      const t4 = this, e4 = t4.instance;
      e4.on("Carousel.init", t4.onPrepare), e4.on("Carousel.ready", t4.onReady), e4.on("done", t4.onDone), e4.on("keydown", t4.onKeydown);
    }
    detach() {
      const t4 = this, e4 = t4.instance;
      e4.off("Carousel.init", t4.onPrepare), e4.off("Carousel.ready", t4.onReady), e4.off("done", t4.onDone), e4.off("keydown", t4.onKeydown);
    }
  };
  Object.defineProperty(st, "defaults", { enumerable: true, configurable: true, writable: true, value: { key: " ", playOnStart: false, progressParentEl: (t4) => {
    var e4;
    return ((e4 = t4.instance.container) === null || e4 === void 0 ? void 0 : e4.querySelector(".fancybox__toolbar [data-fancybox-toggle-slideshow]")) || t4.instance.container;
  }, timeout: 3e3 } });
  var ot = { classes: { container: "f-thumbs f-carousel__thumbs", viewport: "f-thumbs__viewport", track: "f-thumbs__track", slide: "f-thumbs__slide", isResting: "is-resting", isSelected: "is-selected", isLoading: "is-loading", hasThumbs: "has-thumbs" }, minCount: 2, parentEl: null, thumbTpl: '<button class="f-thumbs__slide__button" tabindex="0" type="button" aria-label="{{GOTO}}" data-carousel-index="%i"><img class="f-thumbs__slide__img" data-lazy-src="{{%s}}" alt="" /></button>', type: "modern" };
  var at;
  !function(t4) {
    t4[t4.Init = 0] = "Init", t4[t4.Ready = 1] = "Ready", t4[t4.Hidden = 2] = "Hidden", t4[t4.Disabled = 3] = "Disabled";
  }(at || (at = {}));
  var rt = class extends I2 {
    constructor() {
      super(...arguments), Object.defineProperty(this, "type", { enumerable: true, configurable: true, writable: true, value: "modern" }), Object.defineProperty(this, "container", { enumerable: true, configurable: true, writable: true, value: null }), Object.defineProperty(this, "track", { enumerable: true, configurable: true, writable: true, value: null }), Object.defineProperty(this, "carousel", { enumerable: true, configurable: true, writable: true, value: null }), Object.defineProperty(this, "panzoom", { enumerable: true, configurable: true, writable: true, value: null }), Object.defineProperty(this, "thumbWidth", { enumerable: true, configurable: true, writable: true, value: 0 }), Object.defineProperty(this, "thumbClipWidth", { enumerable: true, configurable: true, writable: true, value: 0 }), Object.defineProperty(this, "thumbHeight", { enumerable: true, configurable: true, writable: true, value: 0 }), Object.defineProperty(this, "thumbGap", { enumerable: true, configurable: true, writable: true, value: 0 }), Object.defineProperty(this, "thumbExtraGap", { enumerable: true, configurable: true, writable: true, value: 0 }), Object.defineProperty(this, "shouldCenter", { enumerable: true, configurable: true, writable: true, value: true }), Object.defineProperty(this, "state", { enumerable: true, configurable: true, writable: true, value: at.Init });
    }
    formatThumb(t4, e4) {
      return this.instance.localize(e4, [["%i", t4.index], ["%d", t4.index + 1], ["%s", t4.thumbSrc || "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"]]);
    }
    getSlides() {
      const t4 = [], e4 = this.option("thumbTpl") || "";
      if (e4)
        for (const i4 of this.instance.slides || []) {
          let n4 = "";
          i4.type && (n4 = `for-${i4.type}`, i4.type && ["video", "youtube", "vimeo", "html5video"].includes(i4.type) && (n4 += " for-video")), t4.push({ html: this.formatThumb(i4, e4), customClass: n4 });
        }
      return t4;
    }
    onInitSlide(t4, e4) {
      const i4 = e4.el;
      i4 && (e4.thumbSrc = i4.dataset.thumbSrc || e4.thumbSrc || "", e4.thumbClipWidth = parseFloat(i4.dataset.thumbClipWidth || "") || e4.thumbClipWidth || 0, e4.thumbHeight = parseFloat(i4.dataset.thumbHeight || "") || e4.thumbHeight || 0);
    }
    onInitSlides() {
      this.state === at.Init && this.build();
    }
    onRefreshM() {
      this.refreshModern();
    }
    onChangeM() {
      this.type === "modern" && (this.shouldCenter = true, this.centerModern());
    }
    onClickModern(t4) {
      t4.preventDefault(), t4.stopPropagation();
      const e4 = this.instance, i4 = e4.page, n4 = (t5) => {
        if (t5) {
          const e5 = t5.closest("[data-carousel-index]");
          if (e5)
            return parseInt(e5.dataset.carouselIndex || "", 10) || 0;
        }
        return -1;
      }, s4 = (t5, e5) => {
        const i5 = document.elementFromPoint(t5, e5);
        return i5 ? n4(i5) : -1;
      };
      let o4 = n4(t4.target);
      o4 < 0 && (o4 = s4(t4.clientX + this.thumbGap, t4.clientY), o4 === i4 && (o4 = i4 - 1)), o4 < 0 && (o4 = s4(t4.clientX - this.thumbGap, t4.clientY), o4 === i4 && (o4 = i4 + 1)), o4 < 0 && (o4 = ((e5) => {
        let n5 = s4(t4.clientX - e5, t4.clientY), a4 = s4(t4.clientX + e5, t4.clientY);
        return o4 < 0 && n5 === i4 && (o4 = i4 + 1), o4 < 0 && a4 === i4 && (o4 = i4 - 1), o4;
      })(this.thumbExtraGap)), o4 === i4 ? this.centerModern() : o4 > -1 && o4 < e4.pages.length && e4.slideTo(o4);
    }
    onTransformM() {
      if (this.type !== "modern")
        return;
      const { instance: t4, container: e4, track: i4 } = this, n4 = t4.panzoom;
      if (!(e4 && i4 && n4 && this.panzoom))
        return;
      o2(e4, this.cn("isResting"), n4.state !== g2.Init && n4.isResting);
      const s4 = this.thumbGap, a4 = this.thumbExtraGap, r4 = this.thumbClipWidth;
      let l4 = 0, c4 = 0, h4 = 0;
      for (const e5 of t4.slides) {
        let i5 = e5.index, n5 = e5.thumbSlideEl;
        if (!n5)
          continue;
        o2(n5, this.cn("isSelected"), i5 === t4.page), c4 = 1 - Math.abs(t4.getProgress(i5)), n5.style.setProperty("--progress", c4 ? c4 + "" : "");
        const d4 = 0.5 * ((e5.thumbWidth || 0) - r4);
        l4 += s4, l4 += d4, c4 && (l4 -= c4 * (d4 + a4)), n5.style.setProperty("--shift", l4 - s4 + ""), l4 += d4, c4 && (l4 -= c4 * (d4 + a4)), l4 -= s4, i5 === 0 && (h4 = a4 * c4);
      }
      i4 && (i4.style.setProperty("--left", h4 + ""), i4.style.setProperty("--width", l4 + h4 + s4 + a4 * c4 + "")), this.shouldCenter && this.centerModern();
    }
    buildClassic() {
      const { container: t4, track: e4 } = this, i4 = this.getSlides();
      if (!t4 || !e4 || !i4)
        return;
      const n4 = new this.instance.constructor(t4, u2({ track: e4, infinite: false, center: true, fill: true, dragFree: true, slidesPerPage: 1, transition: false, Dots: false, Navigation: false, classes: { container: "f-thumbs", viewport: "f-thumbs__viewport", track: "f-thumbs__track", slide: "f-thumbs__slide" } }, this.option("Carousel") || {}, { Sync: { target: this.instance }, slides: i4 }));
      this.carousel = n4, this.track = e4, n4.on("ready", () => {
        this.emit("ready");
      }), n4.on("createSlide", (t5, e5) => {
        this.emit("createSlide", e5, e5.el);
      });
    }
    buildModern() {
      if (this.type !== "modern")
        return;
      const { container: t4, track: e4, instance: i4 } = this, s4 = this.option("thumbTpl") || "";
      if (!t4 || !e4 || !s4)
        return;
      E2(t4, "is-horizontal"), this.updateModern();
      for (const t5 of i4.slides || []) {
        const i5 = document.createElement("div");
        if (E2(i5, this.cn("slide")), t5.type) {
          let e5 = `for-${t5.type}`;
          ["video", "youtube", "vimeo", "html5video"].includes(t5.type) && (e5 += " for-video"), E2(i5, e5);
        }
        i5.appendChild(n2(this.formatThumb(t5, s4))), this.emit("createSlide", t5, i5), t5.thumbSlideEl = i5, e4.appendChild(i5), this.resizeModernSlide(t5);
      }
      const o4 = new i4.constructor.Panzoom(t4, { content: e4, lockAxis: "x", zoom: false, panOnlyZoomed: false, bounds: () => {
        let t5 = 0, e5 = 0, n4 = i4.slides[0], s5 = i4.slides[i4.slides.length - 1], o5 = i4.slides[i4.page];
        return n4 && s5 && o5 && (e5 = -1 * this.getModernThumbPos(0), i4.page !== 0 && (e5 += 0.5 * (n4.thumbWidth || 0)), t5 = -1 * this.getModernThumbPos(i4.slides.length - 1), i4.page !== i4.slides.length - 1 && (t5 += (s5.thumbWidth || 0) - (o5.thumbWidth || 0) - 0.5 * (s5.thumbWidth || 0))), { x: { min: t5, max: e5 }, y: { min: 0, max: 0 } };
      } });
      o4.on("touchStart", (t5, e5) => {
        this.shouldCenter = false;
      }), o4.on("click", (t5, e5) => this.onClickModern(e5)), o4.on("ready", () => {
        this.centerModern(), this.emit("ready");
      }), o4.on(["afterTransform", "refresh"], (t5) => {
        this.lazyLoadModern();
      }), this.panzoom = o4, this.refreshModern();
    }
    updateModern() {
      if (this.type !== "modern")
        return;
      const { container: t4 } = this;
      t4 && (this.thumbGap = parseFloat(getComputedStyle(t4).getPropertyValue("--f-thumb-gap")) || 0, this.thumbExtraGap = parseFloat(getComputedStyle(t4).getPropertyValue("--f-thumb-extra-gap")) || 0, this.thumbWidth = parseFloat(getComputedStyle(t4).getPropertyValue("--f-thumb-width")) || 40, this.thumbClipWidth = parseFloat(getComputedStyle(t4).getPropertyValue("--f-thumb-clip-width")) || 40, this.thumbHeight = parseFloat(getComputedStyle(t4).getPropertyValue("--f-thumb-height")) || 40);
    }
    refreshModern() {
      var t4;
      if (this.type === "modern") {
        this.updateModern();
        for (const t5 of this.instance.slides || [])
          this.resizeModernSlide(t5);
        this.onTransformM(), (t4 = this.panzoom) === null || t4 === void 0 || t4.updateMetrics(true), this.centerModern(0);
      }
    }
    centerModern(e4) {
      const i4 = this.instance, { container: n4, panzoom: s4 } = this;
      if (!n4 || !s4 || s4.state === g2.Init)
        return;
      const o4 = i4.page;
      let a4 = this.getModernThumbPos(o4), r4 = a4;
      for (let t4 = i4.page - 3; t4 < i4.page + 3; t4++) {
        if (t4 < 0 || t4 > i4.pages.length - 1 || t4 === i4.page)
          continue;
        const e5 = 1 - Math.abs(i4.getProgress(t4));
        e5 > 0 && e5 < 1 && (r4 += e5 * (this.getModernThumbPos(t4) - a4));
      }
      let l4 = 100;
      e4 === void 0 && (e4 = 0.2, i4.inTransition.size > 0 && (e4 = 0.12), Math.abs(-1 * s4.current.e - r4) > s4.containerRect.width && (e4 = 0.5, l4 = 0)), s4.options.maxVelocity = l4, s4.applyChange({ panX: t2(-1 * r4 - s4.target.e, 1e3), friction: i4.prevPage === null ? 0 : e4 });
    }
    lazyLoadModern() {
      const { instance: t4, panzoom: e4 } = this;
      if (!e4)
        return;
      const i4 = -1 * e4.current.e || 0;
      let s4 = this.getModernThumbPos(t4.page);
      if (e4.state !== g2.Init || s4 === 0)
        for (const s5 of t4.slides || []) {
          const t5 = s5.thumbSlideEl;
          if (!t5)
            continue;
          const o4 = t5.querySelector("img[data-lazy-src]"), a4 = s5.index, r4 = this.getModernThumbPos(a4), l4 = i4 - 0.5 * e4.containerRect.innerWidth, c4 = l4 + e4.containerRect.innerWidth;
          if (!o4 || r4 < l4 || r4 > c4)
            continue;
          let h4 = o4.dataset.lazySrc;
          if (!h4 || !h4.length)
            continue;
          if (delete o4.dataset.lazySrc, o4.src = h4, o4.complete)
            continue;
          E2(t5, this.cn("isLoading"));
          const d4 = n2(w2);
          t5.appendChild(d4), o4.addEventListener("load", () => {
            t5.offsetParent && (t5.classList.remove(this.cn("isLoading")), d4.remove());
          }, false);
        }
    }
    resizeModernSlide(t4) {
      if (this.type !== "modern")
        return;
      if (!t4.thumbSlideEl)
        return;
      const e4 = t4.thumbClipWidth && t4.thumbHeight ? Math.round(this.thumbHeight * (t4.thumbClipWidth / t4.thumbHeight)) : this.thumbWidth;
      t4.thumbWidth = e4;
    }
    getModernThumbPos(e4) {
      const i4 = this.instance.slides[e4], n4 = this.panzoom;
      if (!n4 || !n4.contentRect.fitWidth)
        return 0;
      let s4 = n4.containerRect.innerWidth, o4 = n4.contentRect.width;
      this.instance.slides.length === 2 && (e4 -= 1, o4 = 2 * this.thumbClipWidth);
      let a4 = e4 * (this.thumbClipWidth + this.thumbGap) + this.thumbExtraGap + 0.5 * (i4.thumbWidth || 0);
      return a4 -= o4 > s4 ? 0.5 * s4 : 0.5 * o4, t2(a4 || 0, 1);
    }
    build() {
      const t4 = this.instance, e4 = t4.container, i4 = this.option("minCount") || 0;
      if (i4) {
        let e5 = 0;
        for (const i5 of t4.slides || [])
          i5.thumbSrc && e5++;
        if (e5 < i4)
          return this.cleanup(), void (this.state = at.Disabled);
      }
      const n4 = this.option("type");
      if (["modern", "classic"].indexOf(n4) < 0)
        return void (this.state = at.Disabled);
      this.type = n4;
      const s4 = document.createElement("div");
      E2(s4, this.cn("container")), E2(s4, `is-${n4}`);
      const o4 = this.option("parentEl");
      o4 ? o4.appendChild(s4) : e4.after(s4), this.container = s4, E2(e4, this.cn("hasThumbs"));
      const a4 = document.createElement("div");
      E2(a4, this.cn("track")), s4.appendChild(a4), this.track = a4, n4 === "classic" ? this.buildClassic() : this.buildModern(), this.state = at.Ready, s4.addEventListener("click", (e5) => {
        setTimeout(() => {
          var e6;
          (e6 = s4 == null ? void 0 : s4.querySelector(`[data-carousel-index="${t4.page}"]`)) === null || e6 === void 0 || e6.focus();
        }, 100);
      });
    }
    cleanup() {
      this.carousel && this.carousel.destroy(), this.carousel = null, this.panzoom && this.panzoom.destroy(), this.panzoom = null, this.container && this.container.remove(), this.container = null, this.track = null, this.state = at.Init, S2(this.instance.container, this.cn("hasThumbs"));
    }
    attach() {
      const t4 = this, e4 = t4.instance;
      e4.on("initSlide", t4.onInitSlide), e4.state === L2.Init ? e4.on("initSlides", t4.onInitSlides) : t4.onInitSlides(), e4.on("Panzoom.afterTransform", t4.onTransformM), e4.on("Panzoom.refresh", t4.onRefreshM), e4.on("change", t4.onChangeM);
    }
    detach() {
      const t4 = this, e4 = t4.instance;
      e4.off("initSlide", t4.onInitSlide), e4.off("initSlides", t4.onInitSlides), e4.off("Panzoom.afterTransform", t4.onTransformM), e4.off("Panzoom.refresh", t4.onRefreshM), e4.off("change", t4.onChangeM), t4.cleanup();
    }
  };
  Object.defineProperty(rt, "defaults", { enumerable: true, configurable: true, writable: true, value: ot });
  var lt = Object.assign(Object.assign({}, ot), { key: "t", showOnStart: true, parentEl: null });
  var ct = class extends I2 {
    constructor() {
      super(...arguments), Object.defineProperty(this, "ref", { enumerable: true, configurable: true, writable: true, value: null }), Object.defineProperty(this, "hidden", { enumerable: true, configurable: true, writable: true, value: false });
    }
    get isEnabled() {
      const t4 = this.ref;
      return t4 && t4.state !== at.Disabled;
    }
    get isHidden() {
      return this.hidden;
    }
    onInit() {
      var t4;
      const e4 = this, i4 = e4.instance, n4 = i4.carousel;
      if (e4.ref || !n4)
        return;
      const s4 = e4.option("parentEl") || i4.footer || i4.container;
      if (!s4)
        return;
      const o4 = u2({}, e4.options, { parentEl: s4, classes: { container: "f-thumbs fancybox__thumbs" }, Carousel: { Sync: { friction: i4.option("Carousel.friction") || 0 } }, on: { ready: (t5) => {
        const i5 = t5.container;
        i5 && this.hidden && (e4.refresh(), i5.style.transition = "none", e4.hide(), i5.offsetHeight, queueMicrotask(() => {
          i5.style.transition = "", e4.show();
        }));
      } } });
      o4.Carousel = o4.Carousel || {}, o4.Carousel.on = u2(((t4 = e4.options.Carousel) === null || t4 === void 0 ? void 0 : t4.on) || {}, { click: (t5, e5) => {
        e5.stopPropagation();
      } }), n4.options.Thumbs = o4, n4.attachPlugins({ Thumbs: rt }), e4.ref = n4.plugins.Thumbs, e4.option("showOnStart") || (e4.ref.state = at.Hidden, e4.hidden = true);
    }
    onResize() {
      var t4;
      const e4 = (t4 = this.ref) === null || t4 === void 0 ? void 0 : t4.container;
      e4 && (e4.style.maxHeight = "");
    }
    onKeydown(t4, e4) {
      const i4 = this.option("key");
      i4 && i4 === e4 && this.toggle();
    }
    toggle() {
      const t4 = this.ref;
      t4 && t4.state !== at.Disabled && (t4.state !== at.Hidden ? this.hidden ? this.show() : this.hide() : t4.build());
    }
    show() {
      const t4 = this.ref, e4 = t4 && t4.state !== at.Disabled && t4.container;
      e4 && (this.refresh(), e4.offsetHeight, e4.removeAttribute("aria-hidden"), e4.classList.remove("is-hidden"), this.hidden = false);
    }
    hide() {
      const t4 = this.ref, e4 = t4 && t4.container;
      e4 && (this.refresh(), e4.offsetHeight, e4.classList.add("is-hidden"), e4.setAttribute("aria-hidden", "true")), this.hidden = true;
    }
    refresh() {
      const t4 = this.ref;
      if (!t4 || t4.state === at.Disabled)
        return;
      const e4 = t4.container, i4 = (e4 == null ? void 0 : e4.firstChild) || null;
      e4 && i4 && i4.childNodes.length && (e4.style.maxHeight = `${i4.getBoundingClientRect().height}px`);
    }
    attach() {
      const t4 = this, e4 = t4.instance;
      e4.state === V.Init ? e4.on("Carousel.init", t4.onInit) : t4.onInit(), e4.on("resize", t4.onResize), e4.on("keydown", t4.onKeydown);
    }
    detach() {
      var t4;
      const e4 = this, i4 = e4.instance;
      i4.off("Carousel.init", e4.onInit), i4.off("resize", e4.onResize), i4.off("keydown", e4.onKeydown), (t4 = i4.carousel) === null || t4 === void 0 || t4.detachPlugins(["Thumbs"]), e4.ref = null;
    }
  };
  Object.defineProperty(ct, "defaults", { enumerable: true, configurable: true, writable: true, value: lt });
  var ht = { panLeft: { icon: '<svg><path d="M5 12h14M5 12l6 6M5 12l6-6"/></svg>', change: { panX: -100 } }, panRight: { icon: '<svg><path d="M5 12h14M13 18l6-6M13 6l6 6"/></svg>', change: { panX: 100 } }, panUp: { icon: '<svg><path d="M12 5v14M18 11l-6-6M6 11l6-6"/></svg>', change: { panY: -100 } }, panDown: { icon: '<svg><path d="M12 5v14M18 13l-6 6M6 13l6 6"/></svg>', change: { panY: 100 } }, zoomIn: { icon: '<svg><circle cx="11" cy="11" r="7.5"/><path d="m21 21-4.35-4.35M11 8v6M8 11h6"/></svg>', action: "zoomIn" }, zoomOut: { icon: '<svg><circle cx="11" cy="11" r="7.5"/><path d="m21 21-4.35-4.35M8 11h6"/></svg>', action: "zoomOut" }, toggle1to1: { icon: '<svg><path d="M3.51 3.07c5.74.02 11.48-.02 17.22.02 1.37.1 2.34 1.64 2.18 3.13 0 4.08.02 8.16 0 12.23-.1 1.54-1.47 2.64-2.79 2.46-5.61-.01-11.24.02-16.86-.01-1.36-.12-2.33-1.65-2.17-3.14 0-4.07-.02-8.16 0-12.23.1-1.36 1.22-2.48 2.42-2.46Z"/><path d="M5.65 8.54h1.49v6.92m8.94-6.92h1.49v6.92M11.5 9.4v.02m0 5.18v0"/></svg>', action: "toggleZoom" }, toggleZoom: { icon: '<svg><g><line x1="11" y1="8" x2="11" y2="14"></line></g><circle cx="11" cy="11" r="7.5"/><path d="m21 21-4.35-4.35M8 11h6"/></svg>', action: "toggleZoom" }, iterateZoom: { icon: '<svg><g><line x1="11" y1="8" x2="11" y2="14"></line></g><circle cx="11" cy="11" r="7.5"/><path d="m21 21-4.35-4.35M8 11h6"/></svg>', action: "iterateZoom" }, rotateCCW: { icon: '<svg><path d="M15 4.55a8 8 0 0 0-6 14.9M9 15v5H4M18.37 7.16v.01M13 19.94v.01M16.84 18.37v.01M19.37 15.1v.01M19.94 11v.01"/></svg>', action: "rotateCCW" }, rotateCW: { icon: '<svg><path d="M9 4.55a8 8 0 0 1 6 14.9M15 15v5h5M5.63 7.16v.01M4.06 11v.01M4.63 15.1v.01M7.16 18.37v.01M11 19.94v.01"/></svg>', action: "rotateCW" }, flipX: { icon: '<svg style="stroke-width: 1.3"><path d="M12 3v18M16 7v10h5L16 7M8 7v10H3L8 7"/></svg>', action: "flipX" }, flipY: { icon: '<svg style="stroke-width: 1.3"><path d="M3 12h18M7 16h10L7 21v-5M7 8h10L7 3v5"/></svg>', action: "flipY" }, fitX: { icon: '<svg><path d="M4 12V6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v6M10 18H3M21 18h-7M6 15l-3 3 3 3M18 15l3 3-3 3"/></svg>', action: "fitX" }, fitY: { icon: '<svg><path d="M12 20H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h6M18 14v7M18 3v7M15 18l3 3 3-3M15 6l3-3 3 3"/></svg>', action: "fitY" }, reset: { icon: '<svg><path d="M20 11A8.1 8.1 0 0 0 4.5 9M4 5v4h4M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4"/></svg>', action: "reset" }, toggleFS: { icon: '<svg><g><path d="M14.5 9.5 21 3m0 0h-6m6 0v6M3 21l6.5-6.5M3 21v-6m0 6h6"/></g><g><path d="m14 10 7-7m-7 7h6m-6 0V4M3 21l7-7m0 0v6m0-6H4"/></g></svg>', action: "toggleFS" } };
  var dt;
  !function(t4) {
    t4[t4.Init = 0] = "Init", t4[t4.Ready = 1] = "Ready", t4[t4.Disabled = 2] = "Disabled";
  }(dt || (dt = {}));
  var ut = { absolute: "auto", display: { left: ["infobar"], middle: [], right: ["iterateZoom", "slideshow", "fullscreen", "thumbs", "close"] }, enabled: "auto", items: { infobar: { tpl: '<div class="fancybox__infobar" tabindex="-1"><span data-fancybox-current-index></span>/<span data-fancybox-count></span></div>' }, download: { tpl: '<a class="f-button" title="{{DOWNLOAD}}" data-fancybox-download href="javasript:;"><svg><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2M7 11l5 5 5-5M12 4v12"/></svg></a>' }, prev: { tpl: '<button class="f-button" title="{{PREV}}" data-fancybox-prev><svg><path d="m15 6-6 6 6 6"/></svg></button>' }, next: { tpl: '<button class="f-button" title="{{NEXT}}" data-fancybox-next><svg><path d="m9 6 6 6-6 6"/></svg></button>' }, slideshow: { tpl: '<button class="f-button" title="{{TOGGLE_SLIDESHOW}}" data-fancybox-toggle-slideshow><svg><g><path d="M8 4v16l13 -8z"></path></g><g><path d="M8 4v15M17 4v15"/></g></svg></button>' }, fullscreen: { tpl: '<button class="f-button" title="{{TOGGLE_FULLSCREEN}}" data-fancybox-toggle-fullscreen><svg><g><path d="M4 8V6a2 2 0 0 1 2-2h2M4 16v2a2 2 0 0 0 2 2h2M16 4h2a2 2 0 0 1 2 2v2M16 20h2a2 2 0 0 0 2-2v-2"/></g><g><path d="M15 19v-2a2 2 0 0 1 2-2h2M15 5v2a2 2 0 0 0 2 2h2M5 15h2a2 2 0 0 1 2 2v2M5 9h2a2 2 0 0 0 2-2V5"/></g></svg></button>' }, thumbs: { tpl: '<button class="f-button" title="{{TOGGLE_THUMBS}}" data-fancybox-toggle-thumbs><svg><circle cx="5.5" cy="5.5" r="1"/><circle cx="12" cy="5.5" r="1"/><circle cx="18.5" cy="5.5" r="1"/><circle cx="5.5" cy="12" r="1"/><circle cx="12" cy="12" r="1"/><circle cx="18.5" cy="12" r="1"/><circle cx="5.5" cy="18.5" r="1"/><circle cx="12" cy="18.5" r="1"/><circle cx="18.5" cy="18.5" r="1"/></svg></button>' }, close: { tpl: '<button class="f-button" title="{{CLOSE}}" data-fancybox-close><svg><path d="m19.5 4.5-15 15M4.5 4.5l15 15"/></svg></button>' } }, parentEl: null };
  var pt = { tabindex: "-1", width: "24", height: "24", viewBox: "0 0 24 24", xmlns: "http://www.w3.org/2000/svg" };
  var ft = class extends I2 {
    constructor() {
      super(...arguments), Object.defineProperty(this, "state", { enumerable: true, configurable: true, writable: true, value: dt.Init }), Object.defineProperty(this, "container", { enumerable: true, configurable: true, writable: true, value: null });
    }
    onReady(t4) {
      var e4;
      if (!t4.carousel)
        return;
      let i4 = this.option("display"), n4 = this.option("absolute"), s4 = this.option("enabled");
      if (s4 === "auto") {
        const t5 = this.instance.carousel;
        let e5 = 0;
        if (t5)
          for (const i5 of t5.slides)
            (i5.panzoom || i5.type === "image") && e5++;
        e5 || (s4 = false);
      }
      s4 || (i4 = void 0);
      let o4 = 0;
      const a4 = { left: [], middle: [], right: [] };
      if (i4)
        for (const t5 of ["left", "middle", "right"])
          for (const n5 of i4[t5]) {
            const i5 = this.createEl(n5);
            i5 && ((e4 = a4[t5]) === null || e4 === void 0 || e4.push(i5), o4++);
          }
      let r4 = null;
      if (o4 && (r4 = this.createContainer()), r4) {
        for (const [t5, e5] of Object.entries(a4)) {
          const i5 = document.createElement("div");
          E2(i5, "fancybox__toolbar__column is-" + t5);
          for (const t6 of e5)
            i5.appendChild(t6);
          n4 !== "auto" || t5 !== "middle" || e5.length || (n4 = true), r4.appendChild(i5);
        }
        n4 === true && E2(r4, "is-absolute"), this.state = dt.Ready, this.onRefresh();
      } else
        this.state = dt.Disabled;
    }
    onClick(t4) {
      var e4, i4;
      const n4 = this.instance, s4 = n4.getSlide(), o4 = s4 == null ? void 0 : s4.panzoom, a4 = t4.target, r4 = a4 && x2(a4) ? a4.dataset : null;
      if (!r4)
        return;
      if (r4.fancyboxToggleThumbs !== void 0)
        return t4.preventDefault(), t4.stopPropagation(), void ((e4 = n4.plugins.Thumbs) === null || e4 === void 0 || e4.toggle());
      if (r4.fancyboxToggleFullscreen !== void 0)
        return t4.preventDefault(), t4.stopPropagation(), void this.instance.toggleFullscreen();
      if (r4.fancyboxToggleSlideshow !== void 0) {
        t4.preventDefault(), t4.stopPropagation();
        const e5 = (i4 = n4.carousel) === null || i4 === void 0 ? void 0 : i4.plugins.Autoplay;
        let s5 = e5.isActive;
        return o4 && o4.panMode === "mousemove" && !s5 && o4.reset(), void (s5 ? e5.stop() : e5.start());
      }
      const l4 = r4.panzoomAction, c4 = r4.panzoomChange;
      if ((c4 || l4) && (t4.preventDefault(), t4.stopPropagation()), c4) {
        let t5 = {};
        try {
          t5 = JSON.parse(c4);
        } catch (t6) {
        }
        o4 && o4.applyChange(t5);
      } else
        l4 && o4 && o4[l4] && o4[l4]();
    }
    onChange() {
      this.onRefresh();
    }
    onRefresh() {
      if (this.instance.isClosing())
        return;
      const t4 = this.container;
      if (!t4)
        return;
      const e4 = this.instance.getSlide();
      if (!e4 || e4.state !== Z.Ready)
        return;
      const i4 = e4 && !e4.error && e4.panzoom;
      for (const e5 of t4.querySelectorAll("[data-panzoom-action]"))
        i4 ? (e5.removeAttribute("disabled"), e5.removeAttribute("tabindex")) : (e5.setAttribute("disabled", ""), e5.setAttribute("tabindex", "-1"));
      let n4 = i4 && i4.canZoomIn(), s4 = i4 && i4.canZoomOut();
      for (const e5 of t4.querySelectorAll('[data-panzoom-action="zoomIn"]'))
        n4 ? (e5.removeAttribute("disabled"), e5.removeAttribute("tabindex")) : (e5.setAttribute("disabled", ""), e5.setAttribute("tabindex", "-1"));
      for (const e5 of t4.querySelectorAll('[data-panzoom-action="zoomOut"]'))
        s4 ? (e5.removeAttribute("disabled"), e5.removeAttribute("tabindex")) : (e5.setAttribute("disabled", ""), e5.setAttribute("tabindex", "-1"));
      for (const e5 of t4.querySelectorAll('[data-panzoom-action="toggleZoom"],[data-panzoom-action="iterateZoom"]')) {
        s4 || n4 ? (e5.removeAttribute("disabled"), e5.removeAttribute("tabindex")) : (e5.setAttribute("disabled", ""), e5.setAttribute("tabindex", "-1"));
        const t5 = e5.querySelector("g");
        t5 && (t5.style.display = n4 ? "" : "none");
      }
    }
    onDone(t4, e4) {
      var i4;
      (i4 = e4.panzoom) === null || i4 === void 0 || i4.on("afterTransform", () => {
        this.instance.isCurrentSlide(e4) && this.onRefresh();
      }), this.instance.isCurrentSlide(e4) && this.onRefresh();
    }
    createContainer() {
      const t4 = this.instance.container;
      if (!t4)
        return null;
      const e4 = this.option("parentEl") || t4, i4 = document.createElement("div");
      return E2(i4, "fancybox__toolbar"), e4.prepend(i4), i4.addEventListener("click", this.onClick, { passive: false, capture: true }), t4 && E2(t4, "has-toolbar"), this.container = i4, i4;
    }
    createEl(t4) {
      const e4 = this.instance, i4 = e4.carousel;
      if (!i4)
        return null;
      if (t4 === "toggleFS")
        return null;
      if (t4 === "fullscreen" && !e4.fsAPI)
        return null;
      let s4 = null;
      const o4 = i4.slides.length || 0;
      let a4 = 0, r4 = 0;
      for (const t5 of i4.slides)
        (t5.panzoom || t5.type === "image") && a4++, (t5.type === "image" || t5.downloadSrc) && r4++;
      if (o4 < 2 && ["infobar", "prev", "next"].includes(t4))
        return s4;
      if (ht[t4] !== void 0 && !a4)
        return null;
      if (t4 === "download" && !r4)
        return null;
      if (t4 === "thumbs") {
        const t5 = e4.plugins.Thumbs;
        if (!t5 || !t5.isEnabled)
          return null;
      }
      if (t4 === "slideshow") {
        if (!i4.plugins.Autoplay || o4 < 2)
          return null;
      }
      if (ht[t4] !== void 0) {
        const e5 = ht[t4];
        s4 = document.createElement("button"), s4.setAttribute("title", this.instance.localize(`{{${t4.toUpperCase()}}}`)), E2(s4, "f-button"), e5.action && (s4.dataset.panzoomAction = e5.action), e5.change && (s4.dataset.panzoomChange = JSON.stringify(e5.change)), s4.appendChild(n2(this.instance.localize(e5.icon)));
      } else {
        const e5 = (this.option("items") || [])[t4];
        e5 && (s4 = n2(this.instance.localize(e5.tpl)), typeof e5.click == "function" && s4.addEventListener("click", (t5) => {
          t5.preventDefault(), t5.stopPropagation(), typeof e5.click == "function" && e5.click.call(this, this, t5);
        }));
      }
      const l4 = s4 == null ? void 0 : s4.querySelector("svg");
      if (l4)
        for (const [t5, e5] of Object.entries(pt))
          l4.getAttribute(t5) || l4.setAttribute(t5, String(e5));
      return s4;
    }
    removeContainer() {
      const t4 = this.container;
      t4 && t4.remove(), this.container = null, this.state = dt.Disabled;
      const e4 = this.instance.container;
      e4 && S2(e4, "has-toolbar");
    }
    attach() {
      const t4 = this, e4 = t4.instance;
      e4.on("Carousel.initSlides", t4.onReady), e4.on("done", t4.onDone), e4.on("reveal", t4.onChange), e4.on("Carousel.change", t4.onChange), t4.onReady(t4.instance);
    }
    detach() {
      const t4 = this, e4 = t4.instance;
      e4.off("Carousel.initSlides", t4.onReady), e4.off("done", t4.onDone), e4.off("reveal", t4.onChange), e4.off("Carousel.change", t4.onChange), t4.removeContainer();
    }
  };
  Object.defineProperty(ft, "defaults", { enumerable: true, configurable: true, writable: true, value: ut });
  var mt = { Hash: U, Html: it, Images: J, Slideshow: st, Thumbs: ct, Toolbar: ft };
  var gt = function() {
    var t4 = window.getSelection();
    return t4 && t4.type === "Range";
  };
  var bt = null;
  var vt = null;
  var yt = new Map();
  var wt = 0;
  var xt = class extends m2 {
    get isIdle() {
      return this.idle;
    }
    get isCompact() {
      return this.option("compact");
    }
    constructor(t4 = [], e4 = {}, i4 = {}) {
      super(e4), Object.defineProperty(this, "userSlides", { enumerable: true, configurable: true, writable: true, value: [] }), Object.defineProperty(this, "userPlugins", { enumerable: true, configurable: true, writable: true, value: {} }), Object.defineProperty(this, "idle", { enumerable: true, configurable: true, writable: true, value: false }), Object.defineProperty(this, "idleTimer", { enumerable: true, configurable: true, writable: true, value: null }), Object.defineProperty(this, "clickTimer", { enumerable: true, configurable: true, writable: true, value: null }), Object.defineProperty(this, "pwt", { enumerable: true, configurable: true, writable: true, value: 0 }), Object.defineProperty(this, "ignoreFocusChange", { enumerable: true, configurable: true, writable: true, value: false }), Object.defineProperty(this, "state", { enumerable: true, configurable: true, writable: true, value: V.Init }), Object.defineProperty(this, "id", { enumerable: true, configurable: true, writable: true, value: 0 }), Object.defineProperty(this, "container", { enumerable: true, configurable: true, writable: true, value: null }), Object.defineProperty(this, "footer", { enumerable: true, configurable: true, writable: true, value: null }), Object.defineProperty(this, "caption", { enumerable: true, configurable: true, writable: true, value: null }), Object.defineProperty(this, "carousel", { enumerable: true, configurable: true, writable: true, value: null }), Object.defineProperty(this, "lastFocus", { enumerable: true, configurable: true, writable: true, value: null }), Object.defineProperty(this, "prevMouseMoveEvent", { enumerable: true, configurable: true, writable: true, value: void 0 }), Object.defineProperty(this, "fsAPI", { enumerable: true, configurable: true, writable: true, value: void 0 }), this.fsAPI = (() => {
        let t5, e5 = "", i5 = "", n4 = "";
        return document.fullscreenEnabled ? (e5 = "requestFullscreen", i5 = "exitFullscreen", n4 = "fullscreenElement") : document.webkitFullscreenEnabled && (e5 = "webkitRequestFullscreen", i5 = "webkitExitFullscreen", n4 = "webkitFullscreenElement"), e5 && (t5 = { request: function(t6) {
          return e5 === "webkitRequestFullscreen" ? t6[e5](Element.ALLOW_KEYBOARD_INPUT) : t6[e5]();
        }, exit: function() {
          return document[n4] && document[i5]();
        }, isFullscreen: function() {
          return document[n4];
        } }), t5;
      })(), this.id = e4.id || ++wt, yt.set(this.id, this), this.userSlides = t4, this.userPlugins = i4, queueMicrotask(() => {
        this.init();
      });
    }
    init() {
      if (this.state === V.Destroy)
        return;
      this.state = V.Init, this.attachPlugins(Object.assign(Object.assign({}, xt.Plugins), this.userPlugins)), this.emit("init"), this.option("hideScrollbar") === true && (() => {
        if (!W)
          return;
        const t5 = document.body;
        if (t5.classList.contains("hide-scrollbar"))
          return;
        let e5 = window.innerWidth - document.documentElement.getBoundingClientRect().width;
        e5 < 0 && (e5 = 0);
        const i4 = t5.currentStyle || window.getComputedStyle(t5), n4 = parseFloat(i4.marginRight);
        document.documentElement.style.setProperty("--fancybox-scrollbar-compensate", `${e5}px`), n4 && t5.style.setProperty("--fancybox-body-margin", `${n4}px`), t5.classList.add("hide-scrollbar");
      })(), this.initLayout(), this.scale();
      const t4 = () => {
        this.initCarousel(this.userSlides), this.state = V.Ready, this.attachEvents(), this.emit("ready"), setTimeout(() => {
          this.container && this.container.setAttribute("aria-hidden", "false");
        }, 16);
      }, e4 = this.fsAPI;
      this.option("Fullscreen.autoStart") && e4 && !e4.isFullscreen() ? e4.request(this.container).then(() => t4()).catch(() => t4()) : t4();
    }
    initLayout() {
      var t4, e4;
      const i4 = this.option("parentEl") || document.body, s4 = n2(this.localize(this.option("tpl.main") || ""));
      s4 && (s4.setAttribute("id", `fancybox-${this.id}`), s4.setAttribute("aria-label", this.localize("{{MODAL}}")), s4.classList.toggle("is-compact", this.isCompact), E2(s4, this.option("mainClass") || ""), this.container = s4, this.footer = s4.querySelector(".fancybox__footer"), i4.appendChild(s4), E2(document.documentElement, "with-fancybox"), bt && vt || (bt = document.createElement("span"), E2(bt, "fancybox-focus-guard"), bt.setAttribute("tabindex", "0"), bt.setAttribute("aria-hidden", "true"), bt.setAttribute("aria-label", "Focus guard"), vt = bt.cloneNode(), (t4 = s4.parentElement) === null || t4 === void 0 || t4.insertBefore(bt, s4), (e4 = s4.parentElement) === null || e4 === void 0 || e4.append(vt)), this.option("animated") && (E2(s4, "is-animated"), setTimeout(() => {
        this.isClosing() || S2(s4, "is-animated");
      }, 350)), this.emit("initLayout"));
    }
    initCarousel(t4) {
      const i4 = this.container;
      if (!i4)
        return;
      const n4 = i4.querySelector(".fancybox__carousel");
      if (!n4)
        return;
      const s4 = this.carousel = new _(n4, u2({}, { slides: t4, transition: "fade", Panzoom: { lockAxis: this.option("dragToClose") ? "xy" : "x", infinite: !!this.option("dragToClose") && "y" }, Dots: false, Navigation: { classes: { container: "fancybox__nav", button: "f-button", isNext: "is-next", isPrev: "is-prev" } }, initialPage: this.option("startIndex"), l10n: this.option("l10n") }, this.option("Carousel") || {}));
      s4.on("*", (t5, e4, ...i5) => {
        this.emit(`Carousel.${e4}`, t5, ...i5);
      }), s4.on(["ready", "change"], () => {
        var t5;
        const e4 = this.getSlide();
        e4 && ((t5 = e4.panzoom) === null || t5 === void 0 || t5.updateControls()), this.manageCaption(e4);
      }), this.on("Carousel.removeSlide", (t5, e4, i5) => {
        i5.contentEl && (i5.contentEl.remove(), i5.contentEl = void 0);
        const n5 = i5.el;
        n5 && (S2(n5, "has-error"), S2(n5, "has-unknown"), S2(n5, `has-${i5.type || "unknown"}`)), i5.closeBtnEl && i5.closeBtnEl.remove(), i5.closeBtnEl = void 0, i5.captionEl && i5.captionEl.remove(), i5.captionEl = void 0, i5.spinnerEl && i5.spinnerEl.remove(), i5.spinnerEl = void 0, i5.state = void 0;
      }), s4.on("Panzoom.touchStart", () => {
        this.isCompact || this.endIdle();
      }), s4.on("settle", () => {
        this.idleTimer || this.isCompact || !this.option("idle") || this.setIdle(), this.option("autoFocus") && this.checkFocus();
      }), this.option("dragToClose") && (s4.on("Panzoom.afterTransform", (t5, i5) => {
        const n5 = this.getSlide();
        if (n5 && e2(n5.el))
          return;
        const s5 = this.container;
        if (s5) {
          const t6 = Math.abs(i5.current.f), e4 = t6 < 1 ? "" : Math.max(0.5, Math.min(1, 1 - t6 / i5.contentRect.fitHeight * 1.5));
          s5.style.setProperty("--fancybox-ts", e4 ? "0s" : ""), s5.style.setProperty("--fancybox-opacity", e4 + "");
        }
      }), s4.on("Panzoom.touchEnd", (t5, i5, n5) => {
        var s5;
        const o4 = this.getSlide();
        if (o4 && e2(o4.el))
          return;
        if (i5.isMobile && document.activeElement && ["TEXTAREA", "INPUT"].indexOf((s5 = document.activeElement) === null || s5 === void 0 ? void 0 : s5.nodeName) !== -1)
          return;
        const a4 = Math.abs(i5.dragOffset.y);
        i5.lockedAxis === "y" && (a4 >= 200 || a4 >= 50 && i5.dragOffset.time < 300) && (n5 && n5.cancelable && n5.preventDefault(), this.close(n5, "f-throwOut" + (i5.current.f < 0 ? "Up" : "Down")));
      })), s4.on("change", (t5) => {
        var e4;
        let i5 = (e4 = this.getSlide()) === null || e4 === void 0 ? void 0 : e4.triggerEl;
        if (i5) {
          const e5 = new CustomEvent("slideTo", { bubbles: true, cancelable: true, detail: t5.page });
          i5.dispatchEvent(e5);
        }
      }), s4.on(["refresh", "change"], (t5) => {
        const e4 = this.container;
        if (!e4)
          return;
        for (const i6 of e4.querySelectorAll("[data-fancybox-current-index]"))
          i6.innerHTML = t5.page + 1;
        for (const i6 of e4.querySelectorAll("[data-fancybox-count]"))
          i6.innerHTML = t5.pages.length;
        if (!t5.isInfinite) {
          for (const i6 of e4.querySelectorAll("[data-fancybox-next]"))
            t5.page < t5.pages.length - 1 ? (i6.removeAttribute("disabled"), i6.removeAttribute("tabindex")) : (i6.setAttribute("disabled", ""), i6.setAttribute("tabindex", "-1"));
          for (const i6 of e4.querySelectorAll("[data-fancybox-prev]"))
            t5.page > 0 ? (i6.removeAttribute("disabled"), i6.removeAttribute("tabindex")) : (i6.setAttribute("disabled", ""), i6.setAttribute("tabindex", "-1"));
        }
        const i5 = this.getSlide();
        if (!i5)
          return;
        let n5 = i5.downloadSrc || "";
        n5 || i5.type !== "image" || i5.error || typeof i5.src != "string" || (n5 = i5.src);
        const s5 = "disabled", o4 = "tabindex", a4 = "download", r4 = "href";
        for (const t6 of e4.querySelectorAll("[data-fancybox-download]")) {
          const e5 = i5.downloadFilename;
          n5 ? (t6.removeAttribute(s5), t6.removeAttribute(o4), t6.setAttribute(r4, n5), t6.setAttribute(a4, e5 || n5), t6.setAttribute("target", "_blank")) : (t6.setAttribute(s5, ""), t6.setAttribute(o4, "-1"), t6.removeAttribute(r4), t6.removeAttribute(a4));
        }
      }), this.emit("initCarousel");
    }
    attachEvents() {
      const t4 = this, e4 = t4.container;
      if (!e4)
        return;
      e4.addEventListener("click", t4.onClick, { passive: false, capture: false }), e4.addEventListener("wheel", t4.onWheel, { passive: false, capture: false }), document.addEventListener("keydown", t4.onKeydown, { passive: false, capture: true }), document.addEventListener("visibilitychange", t4.onVisibilityChange, false), document.addEventListener("mousemove", t4.onMousemove), t4.option("trapFocus") && document.addEventListener("focus", t4.onFocus, true), window.addEventListener("resize", t4.onResize);
      const i4 = window.visualViewport;
      i4 && (i4.addEventListener("scroll", t4.onResize), i4.addEventListener("resize", t4.onResize));
    }
    detachEvents() {
      const t4 = this, e4 = t4.container;
      if (!e4)
        return;
      document.removeEventListener("keydown", t4.onKeydown, { passive: false, capture: true }), e4.removeEventListener("wheel", t4.onWheel, { passive: false, capture: false }), e4.removeEventListener("click", t4.onClick, { passive: false, capture: false }), document.removeEventListener("mousemove", t4.onMousemove), window.removeEventListener("resize", t4.onResize);
      const i4 = window.visualViewport;
      i4 && (i4.removeEventListener("resize", t4.onResize), i4.removeEventListener("scroll", t4.onResize)), document.removeEventListener("visibilitychange", t4.onVisibilityChange, false), document.removeEventListener("focus", t4.onFocus, true);
    }
    scale() {
      const t4 = this.container;
      if (!t4)
        return;
      const e4 = window.visualViewport, i4 = Math.max(1, (e4 == null ? void 0 : e4.scale) || 1);
      let n4 = "", s4 = "", o4 = "";
      if (e4 && i4 > 1) {
        let t5 = `${e4.offsetLeft}px`, a4 = `${e4.offsetTop}px`;
        n4 = e4.width * i4 + "px", s4 = e4.height * i4 + "px", o4 = `translate3d(${t5}, ${a4}, 0) scale(${1 / i4})`;
      }
      t4.style.transform = o4, t4.style.width = n4, t4.style.height = s4;
    }
    onClick(t4) {
      var e4, i4;
      const { container: n4, isCompact: s4 } = this;
      if (!n4 || this.isClosing())
        return;
      !s4 && this.option("idle") && this.resetIdle();
      const o4 = document.activeElement;
      if (gt() && o4 && n4.contains(o4))
        return;
      const a4 = t4.composedPath()[0];
      if (a4 === ((e4 = this.carousel) === null || e4 === void 0 ? void 0 : e4.container))
        return;
      if (a4.closest(".f-spinner") || a4.closest("[data-fancybox-close]"))
        return t4.preventDefault(), void this.close(t4);
      if (a4.closest("[data-fancybox-prev]"))
        return t4.preventDefault(), void this.prev();
      if (a4.closest("[data-fancybox-next]"))
        return t4.preventDefault(), void this.next();
      if (s4 && ((i4 = this.getSlide()) === null || i4 === void 0 ? void 0 : i4.type) === "image")
        return void (this.clickTimer ? (clearTimeout(this.clickTimer), this.clickTimer = null) : this.clickTimer = setTimeout(() => {
          this.toggleIdle(), this.clickTimer = null;
        }, 350));
      if (this.emit("click", t4), t4.defaultPrevented)
        return;
      let r4 = false;
      if (a4.closest(".fancybox__content")) {
        if (o4) {
          if (o4.closest("[contenteditable]"))
            return;
          a4.matches(X) || o4.blur();
        }
        if (gt())
          return;
        r4 = this.option("contentClick");
      } else
        a4.closest(".fancybox__carousel") && !a4.matches(X) && (r4 = this.option("backdropClick"));
      r4 === "close" ? (t4.preventDefault(), this.close(t4)) : r4 === "next" ? (t4.preventDefault(), this.next()) : r4 === "prev" && (t4.preventDefault(), this.prev());
    }
    onWheel(t4) {
      var e4;
      let i4 = this.option("wheel", t4);
      ((e4 = t4.target) === null || e4 === void 0 ? void 0 : e4.closest(".fancybox__thumbs")) && (i4 = "slide");
      const n4 = i4 === "slide", s4 = [-t4.deltaX || 0, -t4.deltaY || 0, -t4.detail || 0].reduce(function(t5, e5) {
        return Math.abs(e5) > Math.abs(t5) ? e5 : t5;
      }), o4 = Math.max(-1, Math.min(1, s4)), a4 = Date.now();
      this.pwt && a4 - this.pwt < 300 ? n4 && t4.preventDefault() : (this.pwt = a4, this.emit("wheel", t4), t4.defaultPrevented || (i4 === "close" ? (t4.preventDefault(), this.close(t4)) : i4 === "slide" && (t4.preventDefault(), this[o4 > 0 ? "prev" : "next"]())));
    }
    onKeydown(t4) {
      if (!this.isTopmost())
        return;
      this.isCompact || !this.option("idle") || this.isClosing() || this.resetIdle();
      const e4 = t4.key, i4 = this.option("keyboard");
      if (!i4 || t4.ctrlKey || t4.altKey || t4.shiftKey)
        return;
      const n4 = t4.composedPath()[0], s4 = document.activeElement && document.activeElement.classList, o4 = s4 && s4.contains("f-button") || n4.dataset.carouselPage || n4.dataset.carouselIndex;
      if (e4 !== "Escape" && !o4 && x2(n4)) {
        if (n4.isContentEditable || ["TEXTAREA", "OPTION", "INPUT", "SELECT", "VIDEO"].indexOf(n4.nodeName) !== -1)
          return;
      }
      this.emit("keydown", e4, t4);
      const a4 = i4[e4];
      typeof this[a4] == "function" && (t4.preventDefault(), this[a4]());
    }
    onResize() {
      const t4 = this.container;
      if (!t4)
        return;
      const e4 = this.isCompact;
      t4.classList.toggle("is-compact", e4), this.manageCaption(this.getSlide()), this.isCompact ? this.clearIdle() : this.endIdle(), this.scale(), this.emit("resize");
    }
    onFocus(t4) {
      this.isTopmost() && this.checkFocus(t4);
    }
    onMousemove(t4) {
      this.prevMouseMoveEvent = t4, !this.isCompact && this.option("idle") && this.resetIdle();
    }
    onVisibilityChange() {
      document.visibilityState === "visible" ? this.checkFocus() : this.endIdle();
    }
    manageCloseBtn(t4) {
      const e4 = this.optionFor(t4, "closeButton") || false;
      if (e4 === "auto") {
        const t5 = this.plugins.Toolbar;
        if (t5 && t5.state === dt.Ready)
          return;
      }
      if (!e4)
        return;
      if (!t4.contentEl || t4.closeBtnEl)
        return;
      const i4 = this.option("tpl.closeButton");
      if (i4) {
        const e5 = n2(this.localize(i4));
        t4.closeBtnEl = t4.contentEl.appendChild(e5), t4.el && E2(t4.el, "has-close-btn");
      }
    }
    manageCaption(t4) {
      var e4, i4;
      const n4 = "fancybox__caption", s4 = "has-caption", o4 = this.container;
      if (!o4)
        return;
      const a4 = this.isCompact || this.option("commonCaption"), r4 = !a4;
      if (this.caption && this.stop(this.caption), r4 && this.caption && (this.caption.remove(), this.caption = null), a4 && !this.caption)
        for (const t5 of ((e4 = this.carousel) === null || e4 === void 0 ? void 0 : e4.slides) || [])
          t5.captionEl && (t5.captionEl.remove(), t5.captionEl = void 0, S2(t5.el, s4), (i4 = t5.el) === null || i4 === void 0 || i4.removeAttribute("aria-labelledby"));
      if (t4 || (t4 = this.getSlide()), !t4 || a4 && !this.isCurrentSlide(t4))
        return;
      const l4 = t4.el;
      let c4 = this.optionFor(t4, "caption", "");
      if (typeof c4 != "string" || !c4.length)
        return void (a4 && this.caption && this.animate(this.caption, "f-fadeOut", () => {
          var t5;
          (t5 = this.caption) === null || t5 === void 0 || t5.remove(), this.caption = null;
        }));
      let h4 = null;
      if (r4) {
        if (h4 = t4.captionEl || null, l4 && !h4) {
          const e5 = `fancybox__caption_${this.id}_${t4.index}`;
          h4 = document.createElement("div"), E2(h4, n4), h4.setAttribute("id", e5), t4.captionEl = l4.appendChild(h4), E2(l4, s4), l4.setAttribute("aria-labelledby", e5);
        }
      } else {
        if (h4 = this.caption, h4 || (h4 = o4.querySelector("." + n4)), !h4) {
          h4 = document.createElement("div"), h4.dataset.fancyboxCaption = "", E2(h4, n4), h4.innerHTML = c4;
          (this.footer || o4).prepend(h4);
        }
        E2(o4, s4), this.caption = h4;
      }
      h4 && (h4.innerHTML = c4);
    }
    checkFocus(t4) {
      var e4;
      const i4 = document.activeElement || null;
      i4 && ((e4 = this.container) === null || e4 === void 0 ? void 0 : e4.contains(i4)) || this.focus(t4);
    }
    focus(t4) {
      var e4;
      if (this.ignoreFocusChange)
        return;
      const i4 = document.activeElement || null, n4 = (t4 == null ? void 0 : t4.target) || null, s4 = this.container, o4 = this.getSlide();
      if (!s4 || !((e4 = this.carousel) === null || e4 === void 0 ? void 0 : e4.viewport))
        return;
      if (!t4 && i4 && s4.contains(i4))
        return;
      const a4 = o4 && o4.state === Z.Ready ? o4.el : null;
      if (!a4 || a4.contains(i4) || s4 === i4)
        return;
      t4 && t4.cancelable && t4.preventDefault(), this.ignoreFocusChange = true;
      const r4 = Array.from(s4.querySelectorAll(X));
      let l4 = [], c4 = null;
      for (let t5 of r4) {
        const e5 = !t5.offsetParent || t5.closest('[aria-hidden="true"]'), i5 = a4 && a4.contains(t5), n5 = !this.carousel.viewport.contains(t5);
        t5 === s4 || (i5 || n5) && !e5 ? (l4.push(t5), t5.dataset.origTabindex !== void 0 && (t5.tabIndex = parseFloat(t5.dataset.origTabindex)), t5.removeAttribute("data-orig-tabindex"), !t5.hasAttribute("autoFocus") && c4 || (c4 = t5)) : (t5.dataset.origTabindex = t5.dataset.origTabindex === void 0 ? t5.getAttribute("tabindex") || void 0 : t5.dataset.origTabindex, t5.tabIndex = -1);
      }
      let h4 = null;
      t4 ? (!n4 || l4.indexOf(n4) < 0) && (h4 = c4 || s4, l4.length && (i4 === vt ? h4 = l4[0] : this.lastFocus !== s4 && i4 !== bt || (h4 = l4[l4.length - 1]))) : h4 = o4 && o4.type === "image" ? s4 : c4 || s4, h4 && Y(h4), this.lastFocus = document.activeElement, this.ignoreFocusChange = false;
    }
    next() {
      const t4 = this.carousel;
      t4 && t4.pages.length > 1 && t4.slideNext();
    }
    prev() {
      const t4 = this.carousel;
      t4 && t4.pages.length > 1 && t4.slidePrev();
    }
    jumpTo(...t4) {
      this.carousel && this.carousel.slideTo(...t4);
    }
    isTopmost() {
      var t4;
      return ((t4 = xt.getInstance()) === null || t4 === void 0 ? void 0 : t4.id) == this.id;
    }
    animate(t4 = null, e4 = "", i4) {
      if (!t4 || !e4)
        return void (i4 && i4());
      this.stop(t4);
      const n4 = (s4) => {
        s4.target === t4 && t4.dataset.animationName && (t4.removeEventListener("animationend", n4), delete t4.dataset.animationName, i4 && i4(), S2(t4, e4));
      };
      t4.dataset.animationName = e4, t4.addEventListener("animationend", n4), E2(t4, e4);
    }
    stop(t4) {
      t4 && t4.dispatchEvent(new CustomEvent("animationend", { bubbles: false, cancelable: true, currentTarget: t4 }));
    }
    setContent(t4, e4 = "", i4 = true) {
      if (this.isClosing())
        return;
      const s4 = t4.el;
      if (!s4)
        return;
      let o4 = null;
      if (x2(e4) ? o4 = e4 : (o4 = n2(e4 + ""), x2(o4) || (o4 = document.createElement("div"), o4.innerHTML = e4 + "")), ["img", "picture", "iframe", "video", "audio"].includes(o4.nodeName.toLowerCase())) {
        const t5 = document.createElement("div");
        t5.appendChild(o4), o4 = t5;
      }
      x2(o4) && t4.filter && !t4.error && (o4 = o4.querySelector(t4.filter)), o4 && x2(o4) ? (E2(o4, "fancybox__content"), t4.id && o4.setAttribute("id", t4.id), o4.style.display !== "none" && getComputedStyle(o4).getPropertyValue("display") !== "none" || (o4.style.display = t4.display || this.option("defaultDisplay") || "flex"), s4.classList.add(`has-${t4.error ? "error" : t4.type || "unknown"}`), s4.prepend(o4), t4.contentEl = o4, i4 && this.revealContent(t4), this.manageCloseBtn(t4), this.manageCaption(t4)) : this.setError(t4, "{{ELEMENT_NOT_FOUND}}");
    }
    revealContent(t4, e4) {
      const i4 = t4.el, n4 = t4.contentEl;
      i4 && n4 && (this.emit("reveal", t4), this.hideLoading(t4), t4.state = Z.Opening, (e4 = this.isOpeningSlide(t4) ? e4 === void 0 ? this.optionFor(t4, "showClass") : e4 : "f-fadeIn") ? this.animate(n4, e4, () => {
        this.done(t4);
      }) : this.done(t4));
    }
    done(t4) {
      this.isClosing() || (t4.state = Z.Ready, this.emit("done", t4), E2(t4.el, "is-done"), this.isCurrentSlide(t4) && this.option("autoFocus") && queueMicrotask(() => {
        this.option("autoFocus") && (this.option("autoFocus") ? this.focus() : this.checkFocus());
      }), this.isOpeningSlide(t4) && !this.isCompact && this.option("idle") && this.setIdle());
    }
    isCurrentSlide(t4) {
      const e4 = this.getSlide();
      return !(!t4 || !e4) && e4.index === t4.index;
    }
    isOpeningSlide(t4) {
      var e4, i4;
      return ((e4 = this.carousel) === null || e4 === void 0 ? void 0 : e4.prevPage) === null && t4.index === ((i4 = this.getSlide()) === null || i4 === void 0 ? void 0 : i4.index);
    }
    showLoading(t4) {
      t4.state = Z.Loading;
      const e4 = t4.el;
      if (!e4)
        return;
      E2(e4, "is-loading"), this.emit("loading", t4), t4.spinnerEl || setTimeout(() => {
        if (!this.isClosing() && !t4.spinnerEl && t4.state === Z.Loading) {
          let i4 = n2(w2);
          t4.spinnerEl = i4, e4.prepend(i4), this.animate(i4, "f-fadeIn");
        }
      }, 250);
    }
    hideLoading(t4) {
      const e4 = t4.el;
      if (!e4)
        return;
      const i4 = t4.spinnerEl;
      this.isClosing() ? i4 == null || i4.remove() : (S2(e4, "is-loading"), i4 && this.animate(i4, "f-fadeOut", () => {
        i4.remove();
      }), t4.state === Z.Loading && (this.emit("loaded", t4), t4.state = Z.Ready));
    }
    setError(t4, e4) {
      if (this.isClosing())
        return;
      const i4 = new Event("error", { bubbles: true, cancelable: true });
      if (this.emit("error", i4, t4), i4.defaultPrevented)
        return;
      t4.error = e4, this.hideLoading(t4), this.clearContent(t4);
      const n4 = document.createElement("div");
      n4.classList.add("fancybox-error"), n4.innerHTML = this.localize(e4 || "<p>{{ERROR}}</p>"), this.setContent(t4, n4);
    }
    clearContent(t4) {
      var e4;
      (e4 = this.carousel) === null || e4 === void 0 || e4.emit("removeSlide", t4);
    }
    getSlide() {
      var t4;
      const e4 = this.carousel;
      return ((t4 = e4 == null ? void 0 : e4.pages[e4 == null ? void 0 : e4.page]) === null || t4 === void 0 ? void 0 : t4.slides[0]) || void 0;
    }
    close(t4, e4) {
      if (this.isClosing())
        return;
      const i4 = new Event("shouldClose", { bubbles: true, cancelable: true });
      if (this.emit("shouldClose", i4, t4), i4.defaultPrevented)
        return;
      t4 && t4.cancelable && (t4.preventDefault(), t4.stopPropagation());
      const n4 = this.fsAPI, s4 = () => {
        this.proceedClose(t4, e4);
      };
      n4 && n4.isFullscreen() ? Promise.resolve(n4.exit()).then(() => s4()) : s4();
    }
    clearIdle() {
      this.idleTimer && clearTimeout(this.idleTimer), this.idleTimer = null;
    }
    setIdle(t4 = false) {
      const e4 = () => {
        this.clearIdle(), this.idle = true, E2(this.container, "is-idle"), this.emit("setIdle");
      };
      if (this.clearIdle(), !this.isClosing())
        if (t4)
          e4();
        else {
          const t5 = this.option("idle");
          t5 && (this.idleTimer = setTimeout(e4, t5));
        }
    }
    endIdle() {
      this.clearIdle(), this.idle && !this.isClosing() && (this.idle = false, S2(this.container, "is-idle"), this.emit("endIdle"));
    }
    resetIdle() {
      this.endIdle(), this.setIdle();
    }
    toggleIdle() {
      this.idle ? this.endIdle() : this.setIdle(true);
    }
    toggleFullscreen() {
      const t4 = this.fsAPI;
      t4 && (t4.isFullscreen() ? t4.exit() : this.container && t4.request(this.container));
    }
    isClosing() {
      return [V.Closing, V.CustomClosing, V.Destroy].includes(this.state);
    }
    proceedClose(t4, e4) {
      var i4, n4;
      this.state = V.Closing, this.clearIdle(), this.detachEvents();
      const s4 = this.container, o4 = this.carousel, a4 = this.getSlide(), r4 = a4 && this.option("placeFocusBack") ? a4.triggerEl || this.option("triggerEl") : null;
      if (r4 && (N(r4) ? Y(r4) : r4.focus()), s4 && (E2(s4, "is-closing"), s4.setAttribute("aria-hidden", "true"), this.option("animated") && E2(s4, "is-animated"), s4.style.pointerEvents = "none"), o4) {
        o4.clearTransitions(), (i4 = o4.panzoom) === null || i4 === void 0 || i4.destroy(), (n4 = o4.plugins.Navigation) === null || n4 === void 0 || n4.detach();
        for (const t5 of o4.slides) {
          t5.state = Z.Closing, this.hideLoading(t5);
          const e5 = t5.contentEl;
          e5 && this.stop(e5);
          const i5 = t5 == null ? void 0 : t5.panzoom;
          i5 && (i5.stop(), i5.detachEvents(), i5.detachObserver()), this.isCurrentSlide(t5) || o4.emit("removeSlide", t5);
        }
      }
      this.emit("close", t4), this.state !== V.CustomClosing ? (e4 === void 0 && a4 && (e4 = this.optionFor(a4, "hideClass")), e4 && a4 ? (this.animate(a4.contentEl, e4, () => {
        o4 && o4.emit("removeSlide", a4);
      }), setTimeout(() => {
        this.destroy();
      }, 500)) : this.destroy()) : setTimeout(() => {
        this.destroy();
      }, 500);
    }
    destroy() {
      var t4;
      if (this.state === V.Destroy)
        return;
      this.state = V.Destroy, (t4 = this.carousel) === null || t4 === void 0 || t4.destroy();
      const e4 = this.container;
      e4 && e4.remove(), yt.delete(this.id);
      const i4 = xt.getInstance();
      i4 ? i4.focus() : (bt && (bt.remove(), bt = null), vt && (vt.remove(), vt = null), S2(document.documentElement, "with-fancybox"), (() => {
        if (!W)
          return;
        const t5 = document, e5 = t5.body;
        e5.classList.remove("hide-scrollbar"), e5.style.setProperty("--fancybox-body-margin", ""), t5.documentElement.style.setProperty("--fancybox-scrollbar-compensate", "");
      })(), this.emit("destroy"));
    }
    static bind(t4, e4, i4) {
      if (!W)
        return;
      let n4, s4 = "", o4 = {};
      if (t4 === void 0 ? n4 = document.body : typeof t4 == "string" ? (n4 = document.body, s4 = t4, typeof e4 == "object" && (o4 = e4 || {})) : (n4 = t4, typeof e4 == "string" && (s4 = e4), typeof i4 == "object" && (o4 = i4 || {})), !n4 || !x2(n4))
        return;
      s4 = s4 || "[data-fancybox]";
      const a4 = xt.openers.get(n4) || new Map();
      a4.set(s4, o4), xt.openers.set(n4, a4), a4.size === 1 && n4.addEventListener("click", xt.fromEvent);
    }
    static unbind(t4, e4) {
      let i4, n4 = "";
      if (typeof t4 == "string" ? (i4 = document.body, n4 = t4) : (i4 = t4, typeof e4 == "string" && (n4 = e4)), !i4)
        return;
      const s4 = xt.openers.get(i4);
      s4 && n4 && s4.delete(n4), n4 && s4 || (xt.openers.delete(i4), i4.removeEventListener("click", xt.fromEvent));
    }
    static destroy() {
      let t4;
      for (; t4 = xt.getInstance(); )
        t4.destroy();
      for (const t5 of xt.openers.keys())
        t5.removeEventListener("click", xt.fromEvent);
      xt.openers = new Map();
    }
    static fromEvent(t4) {
      if (t4.defaultPrevented)
        return;
      if (t4.button && t4.button !== 0)
        return;
      if (t4.ctrlKey || t4.metaKey || t4.shiftKey)
        return;
      let e4 = t4.composedPath()[0];
      const i4 = e4.closest("[data-fancybox-trigger]");
      if (i4) {
        const t5 = i4.dataset.fancyboxTrigger || "", n5 = document.querySelectorAll(`[data-fancybox="${t5}"]`), s5 = parseInt(i4.dataset.fancyboxIndex || "", 10) || 0;
        e4 = n5[s5] || e4;
      }
      if (!(e4 && e4 instanceof Element))
        return;
      let n4, s4, o4, a4;
      if ([...xt.openers].reverse().find(([t5, i5]) => !(!t5.contains(e4) || ![...i5].reverse().find(([i6, r5]) => {
        let l5 = e4.closest(i6);
        return !!l5 && (n4 = t5, s4 = i6, o4 = l5, a4 = r5, true);
      }))), !n4 || !s4 || !o4)
        return;
      a4 = a4 || {}, t4.preventDefault(), e4 = o4;
      let r4 = [], l4 = u2({}, q, a4);
      l4.event = t4, l4.triggerEl = e4, l4.delegate = i4;
      const c4 = l4.groupAll, h4 = l4.groupAttr, d4 = h4 && e4 ? e4.getAttribute(`${h4}`) : "";
      if ((!e4 || d4 || c4) && (r4 = [].slice.call(n4.querySelectorAll(s4))), e4 && !c4 && (r4 = d4 ? r4.filter((t5) => t5.getAttribute(`${h4}`) === d4) : [e4]), !r4.length)
        return;
      const p4 = xt.getInstance();
      return p4 && p4.options.triggerEl && r4.indexOf(p4.options.triggerEl) > -1 ? void 0 : (e4 && (l4.startIndex = r4.indexOf(e4)), xt.fromNodes(r4, l4));
    }
    static fromSelector(t4, e4) {
      let i4 = null, n4 = "";
      if (typeof t4 == "string" ? (i4 = document.body, n4 = t4) : t4 instanceof HTMLElement && typeof e4 == "string" && (i4 = t4, n4 = e4), !i4 || !n4)
        return false;
      const s4 = xt.openers.get(i4);
      if (!s4)
        return false;
      const o4 = s4.get(n4);
      return !!o4 && xt.fromNodes(Array.from(i4.querySelectorAll(n4)), o4);
    }
    static fromNodes(t4, e4) {
      e4 = u2({}, q, e4 || {});
      const i4 = [];
      for (const n4 of t4) {
        const t5 = n4.dataset || {}, s4 = t5.src || n4.getAttribute("href") || n4.getAttribute("currentSrc") || n4.getAttribute("src") || void 0;
        let o4;
        const a4 = e4.delegate;
        let r4;
        a4 && i4.length === e4.startIndex && (o4 = a4 instanceof HTMLImageElement ? a4 : a4.querySelector("img:not([aria-hidden])")), o4 || (o4 = n4 instanceof HTMLImageElement ? n4 : n4.querySelector("img:not([aria-hidden])")), o4 && (r4 = o4.currentSrc || o4.src || void 0, !r4 && o4.dataset && (r4 = o4.dataset.lazySrc || o4.dataset.src || void 0));
        const l4 = { src: s4, triggerEl: n4, thumbEl: o4, thumbElSrc: r4, thumbSrc: r4 };
        for (const e5 in t5)
          e5 !== "fancybox" && (l4[e5] = t5[e5] + "");
        i4.push(l4);
      }
      return new xt(i4, e4);
    }
    static getInstance(t4) {
      if (t4)
        return yt.get(t4);
      return Array.from(yt.values()).reverse().find((t5) => !t5.isClosing() && t5) || null;
    }
    static getSlide() {
      var t4;
      return ((t4 = xt.getInstance()) === null || t4 === void 0 ? void 0 : t4.getSlide()) || null;
    }
    static show(t4 = [], e4 = {}) {
      return new xt(t4, e4);
    }
    static next() {
      const t4 = xt.getInstance();
      t4 && t4.next();
    }
    static prev() {
      const t4 = xt.getInstance();
      t4 && t4.prev();
    }
    static close(t4 = true, ...e4) {
      if (t4)
        for (const t5 of yt.values())
          t5.close(...e4);
      else {
        const t5 = xt.getInstance();
        t5 && t5.close(...e4);
      }
    }
  };
  Object.defineProperty(xt, "version", { enumerable: true, configurable: true, writable: true, value: "5.0.19" }), Object.defineProperty(xt, "defaults", { enumerable: true, configurable: true, writable: true, value: q }), Object.defineProperty(xt, "Plugins", { enumerable: true, configurable: true, writable: true, value: mt }), Object.defineProperty(xt, "openers", { enumerable: true, configurable: true, writable: true, value: new Map() });

  // node_modules/@fancyapps/ui/dist/carousel/carousel.thumbs.esm.js
  var t3 = (e4, ...i4) => {
    const n4 = i4.length;
    for (let s4 = 0; s4 < n4; s4++) {
      const n5 = i4[s4] || {};
      Object.entries(n5).forEach(([i5, n6]) => {
        const s5 = Array.isArray(n6) ? [] : {};
        var r4;
        e4[i5] || Object.assign(e4, { [i5]: s5 }), typeof (r4 = n6) == "object" && r4 !== null && r4.constructor === Object && Object.prototype.toString.call(r4) === "[object Object]" ? Object.assign(e4[i5], t3(s5, n6)) : Array.isArray(n6) ? Object.assign(e4, { [i5]: [...n6] }) : Object.assign(e4, { [i5]: n6 });
      });
    }
    return e4;
  };
  var e3 = function(t4) {
    var e4 = new DOMParser().parseFromString(t4, "text/html").body;
    if (e4.childElementCount > 1) {
      for (var i4 = document.createElement("div"); e4.firstChild; )
        i4.appendChild(e4.firstChild);
      return i4;
    }
    return e4.firstChild;
  };
  var i3 = (t4) => `${t4 || ""}`.split(" ").filter((t5) => !!t5);
  var n3 = (t4, e4) => {
    t4 && i3(e4).forEach((e5) => {
      t4.classList.add(e5);
    });
  };
  var s3 = (t4, e4, n4) => {
    i3(e4).forEach((e5) => {
      t4 && t4.classList.toggle(e5, n4 || false);
    });
  };
  var r3 = function(t4, e4) {
    return t4.split(".").reduce((t5, e5) => typeof t5 == "object" ? t5[e5] : void 0, e4);
  };
  var o3 = class {
    constructor(t4 = {}) {
      Object.defineProperty(this, "options", { enumerable: true, configurable: true, writable: true, value: t4 }), Object.defineProperty(this, "events", { enumerable: true, configurable: true, writable: true, value: new Map() }), this.setOptions(t4);
      for (const t5 of Object.getOwnPropertyNames(Object.getPrototypeOf(this)))
        t5.startsWith("on") && typeof this[t5] == "function" && (this[t5] = this[t5].bind(this));
    }
    setOptions(e4) {
      this.options = e4 ? t3({}, this.constructor.defaults, e4) : {};
      for (const [t4, e5] of Object.entries(this.option("on") || {}))
        this.on(t4, e5);
    }
    option(t4, ...e4) {
      let i4 = r3(t4, this.options);
      return i4 && typeof i4 == "function" && (i4 = i4.call(this, this, ...e4)), i4;
    }
    optionFor(t4, e4, i4, ...n4) {
      let s4 = r3(e4, t4);
      var o4;
      typeof (o4 = s4) != "string" || isNaN(o4) || isNaN(parseFloat(o4)) || (s4 = parseFloat(s4)), s4 === "true" && (s4 = true), s4 === "false" && (s4 = false), s4 && typeof s4 == "function" && (s4 = s4.call(this, this, t4, ...n4));
      let a4 = r3(e4, this.options);
      return a4 && typeof a4 == "function" ? s4 = a4.call(this, this, t4, ...n4, s4) : s4 === void 0 && (s4 = a4), s4 === void 0 ? i4 : s4;
    }
    cn(t4) {
      const e4 = this.options.classes;
      return e4 && e4[t4] || "";
    }
    localize(t4, e4 = []) {
      t4 = String(t4).replace(/\{\{(\w+).?(\w+)?\}\}/g, (t5, e5, i4) => {
        let n4 = "";
        return i4 ? n4 = this.option(`${e5[0] + e5.toLowerCase().substring(1)}.l10n.${i4}`) : e5 && (n4 = this.option(`l10n.${e5}`)), n4 || (n4 = t5), n4;
      });
      for (let i4 = 0; i4 < e4.length; i4++)
        t4 = t4.split(e4[i4][0]).join(e4[i4][1]);
      return t4 = t4.replace(/\{\{(.*?)\}\}/g, (t5, e5) => e5);
    }
    on(t4, e4) {
      let i4 = [];
      typeof t4 == "string" ? i4 = t4.split(" ") : Array.isArray(t4) && (i4 = t4), this.events || (this.events = new Map()), i4.forEach((t5) => {
        let i5 = this.events.get(t5);
        i5 || (this.events.set(t5, []), i5 = []), i5.includes(e4) || i5.push(e4), this.events.set(t5, i5);
      });
    }
    off(t4, e4) {
      let i4 = [];
      typeof t4 == "string" ? i4 = t4.split(" ") : Array.isArray(t4) && (i4 = t4), i4.forEach((t5) => {
        const i5 = this.events.get(t5);
        if (Array.isArray(i5)) {
          const t6 = i5.indexOf(e4);
          t6 > -1 && i5.splice(t6, 1);
        }
      });
    }
    emit(t4, ...e4) {
      [...this.events.get(t4) || []].forEach((t5) => t5(this, ...e4)), t4 !== "*" && this.emit("*", t4, ...e4);
    }
  };
  Object.defineProperty(o3, "version", { enumerable: true, configurable: true, writable: true, value: "5.0.19" }), Object.defineProperty(o3, "defaults", { enumerable: true, configurable: true, writable: true, value: {} });
  var a3 = class extends o3 {
    constructor(t4, e4) {
      super(e4), Object.defineProperty(this, "instance", { enumerable: true, configurable: true, writable: true, value: t4 });
    }
    attach() {
    }
    detach() {
    }
  };
  var l3;
  var h3;
  !function(t4) {
    t4[t4.Init = 0] = "Init", t4[t4.Error = 1] = "Error", t4[t4.Ready = 2] = "Ready", t4[t4.Panning = 3] = "Panning", t4[t4.Mousemove = 4] = "Mousemove", t4[t4.Destroy = 5] = "Destroy";
  }(l3 || (l3 = {})), function(t4) {
    t4[t4.Init = 0] = "Init", t4[t4.Ready = 1] = "Ready", t4[t4.Destroy = 2] = "Destroy";
  }(h3 || (h3 = {}));
  var c3 = (t4, e4 = 1e4) => (t4 = parseFloat(t4 + "") || 0, Math.round((t4 + Number.EPSILON) * e4) / e4);
  var u3 = { classes: { container: "f-thumbs f-carousel__thumbs", viewport: "f-thumbs__viewport", track: "f-thumbs__track", slide: "f-thumbs__slide", isResting: "is-resting", isSelected: "is-selected", isLoading: "is-loading", hasThumbs: "has-thumbs" }, minCount: 2, parentEl: null, thumbTpl: '<button class="f-thumbs__slide__button" tabindex="0" type="button" aria-label="{{GOTO}}" data-carousel-index="%i"><img class="f-thumbs__slide__img" data-lazy-src="{{%s}}" alt="" /></button>', type: "modern" };
  var d3;
  !function(t4) {
    t4[t4.Init = 0] = "Init", t4[t4.Ready = 1] = "Ready", t4[t4.Hidden = 2] = "Hidden", t4[t4.Disabled = 3] = "Disabled";
  }(d3 || (d3 = {}));
  var p3 = class extends a3 {
    constructor() {
      super(...arguments), Object.defineProperty(this, "type", { enumerable: true, configurable: true, writable: true, value: "modern" }), Object.defineProperty(this, "container", { enumerable: true, configurable: true, writable: true, value: null }), Object.defineProperty(this, "track", { enumerable: true, configurable: true, writable: true, value: null }), Object.defineProperty(this, "carousel", { enumerable: true, configurable: true, writable: true, value: null }), Object.defineProperty(this, "panzoom", { enumerable: true, configurable: true, writable: true, value: null }), Object.defineProperty(this, "thumbWidth", { enumerable: true, configurable: true, writable: true, value: 0 }), Object.defineProperty(this, "thumbClipWidth", { enumerable: true, configurable: true, writable: true, value: 0 }), Object.defineProperty(this, "thumbHeight", { enumerable: true, configurable: true, writable: true, value: 0 }), Object.defineProperty(this, "thumbGap", { enumerable: true, configurable: true, writable: true, value: 0 }), Object.defineProperty(this, "thumbExtraGap", { enumerable: true, configurable: true, writable: true, value: 0 }), Object.defineProperty(this, "shouldCenter", { enumerable: true, configurable: true, writable: true, value: true }), Object.defineProperty(this, "state", { enumerable: true, configurable: true, writable: true, value: d3.Init });
    }
    formatThumb(t4, e4) {
      return this.instance.localize(e4, [["%i", t4.index], ["%d", t4.index + 1], ["%s", t4.thumbSrc || "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"]]);
    }
    getSlides() {
      const t4 = [], e4 = this.option("thumbTpl") || "";
      if (e4)
        for (const i4 of this.instance.slides || []) {
          let n4 = "";
          i4.type && (n4 = `for-${i4.type}`, i4.type && ["video", "youtube", "vimeo", "html5video"].includes(i4.type) && (n4 += " for-video")), t4.push({ html: this.formatThumb(i4, e4), customClass: n4 });
        }
      return t4;
    }
    onInitSlide(t4, e4) {
      const i4 = e4.el;
      i4 && (e4.thumbSrc = i4.dataset.thumbSrc || e4.thumbSrc || "", e4.thumbClipWidth = parseFloat(i4.dataset.thumbClipWidth || "") || e4.thumbClipWidth || 0, e4.thumbHeight = parseFloat(i4.dataset.thumbHeight || "") || e4.thumbHeight || 0);
    }
    onInitSlides() {
      this.state === d3.Init && this.build();
    }
    onRefreshM() {
      this.refreshModern();
    }
    onChangeM() {
      this.type === "modern" && (this.shouldCenter = true, this.centerModern());
    }
    onClickModern(t4) {
      t4.preventDefault(), t4.stopPropagation();
      const e4 = this.instance, i4 = e4.page, n4 = (t5) => {
        if (t5) {
          const e5 = t5.closest("[data-carousel-index]");
          if (e5)
            return parseInt(e5.dataset.carouselIndex || "", 10) || 0;
        }
        return -1;
      }, s4 = (t5, e5) => {
        const i5 = document.elementFromPoint(t5, e5);
        return i5 ? n4(i5) : -1;
      };
      let r4 = n4(t4.target);
      r4 < 0 && (r4 = s4(t4.clientX + this.thumbGap, t4.clientY), r4 === i4 && (r4 = i4 - 1)), r4 < 0 && (r4 = s4(t4.clientX - this.thumbGap, t4.clientY), r4 === i4 && (r4 = i4 + 1)), r4 < 0 && (r4 = ((e5) => {
        let n5 = s4(t4.clientX - e5, t4.clientY), o4 = s4(t4.clientX + e5, t4.clientY);
        return r4 < 0 && n5 === i4 && (r4 = i4 + 1), r4 < 0 && o4 === i4 && (r4 = i4 - 1), r4;
      })(this.thumbExtraGap)), r4 === i4 ? this.centerModern() : r4 > -1 && r4 < e4.pages.length && e4.slideTo(r4);
    }
    onTransformM() {
      if (this.type !== "modern")
        return;
      const { instance: t4, container: e4, track: i4 } = this, n4 = t4.panzoom;
      if (!(e4 && i4 && n4 && this.panzoom))
        return;
      s3(e4, this.cn("isResting"), n4.state !== l3.Init && n4.isResting);
      const r4 = this.thumbGap, o4 = this.thumbExtraGap, a4 = this.thumbClipWidth;
      let h4 = 0, c4 = 0, u4 = 0;
      for (const e5 of t4.slides) {
        let i5 = e5.index, n5 = e5.thumbSlideEl;
        if (!n5)
          continue;
        s3(n5, this.cn("isSelected"), i5 === t4.page), c4 = 1 - Math.abs(t4.getProgress(i5)), n5.style.setProperty("--progress", c4 ? c4 + "" : "");
        const l4 = 0.5 * ((e5.thumbWidth || 0) - a4);
        h4 += r4, h4 += l4, c4 && (h4 -= c4 * (l4 + o4)), n5.style.setProperty("--shift", h4 - r4 + ""), h4 += l4, c4 && (h4 -= c4 * (l4 + o4)), h4 -= r4, i5 === 0 && (u4 = o4 * c4);
      }
      i4 && (i4.style.setProperty("--left", u4 + ""), i4.style.setProperty("--width", h4 + u4 + r4 + o4 * c4 + "")), this.shouldCenter && this.centerModern();
    }
    buildClassic() {
      const { container: e4, track: i4 } = this, n4 = this.getSlides();
      if (!e4 || !i4 || !n4)
        return;
      const s4 = new this.instance.constructor(e4, t3({ track: i4, infinite: false, center: true, fill: true, dragFree: true, slidesPerPage: 1, transition: false, Dots: false, Navigation: false, classes: { container: "f-thumbs", viewport: "f-thumbs__viewport", track: "f-thumbs__track", slide: "f-thumbs__slide" } }, this.option("Carousel") || {}, { Sync: { target: this.instance }, slides: n4 }));
      this.carousel = s4, this.track = i4, s4.on("ready", () => {
        this.emit("ready");
      }), s4.on("createSlide", (t4, e5) => {
        this.emit("createSlide", e5, e5.el);
      });
    }
    buildModern() {
      if (this.type !== "modern")
        return;
      const { container: t4, track: i4, instance: s4 } = this, r4 = this.option("thumbTpl") || "";
      if (!t4 || !i4 || !r4)
        return;
      n3(t4, "is-horizontal"), this.updateModern();
      for (const t5 of s4.slides || []) {
        const s5 = document.createElement("div");
        if (n3(s5, this.cn("slide")), t5.type) {
          let e4 = `for-${t5.type}`;
          ["video", "youtube", "vimeo", "html5video"].includes(t5.type) && (e4 += " for-video"), n3(s5, e4);
        }
        s5.appendChild(e3(this.formatThumb(t5, r4))), this.emit("createSlide", t5, s5), t5.thumbSlideEl = s5, i4.appendChild(s5), this.resizeModernSlide(t5);
      }
      const o4 = new s4.constructor.Panzoom(t4, { content: i4, lockAxis: "x", zoom: false, panOnlyZoomed: false, bounds: () => {
        let t5 = 0, e4 = 0, i5 = s4.slides[0], n4 = s4.slides[s4.slides.length - 1], r5 = s4.slides[s4.page];
        return i5 && n4 && r5 && (e4 = -1 * this.getModernThumbPos(0), s4.page !== 0 && (e4 += 0.5 * (i5.thumbWidth || 0)), t5 = -1 * this.getModernThumbPos(s4.slides.length - 1), s4.page !== s4.slides.length - 1 && (t5 += (n4.thumbWidth || 0) - (r5.thumbWidth || 0) - 0.5 * (n4.thumbWidth || 0))), { x: { min: t5, max: e4 }, y: { min: 0, max: 0 } };
      } });
      o4.on("touchStart", (t5, e4) => {
        this.shouldCenter = false;
      }), o4.on("click", (t5, e4) => this.onClickModern(e4)), o4.on("ready", () => {
        this.centerModern(), this.emit("ready");
      }), o4.on(["afterTransform", "refresh"], (t5) => {
        this.lazyLoadModern();
      }), this.panzoom = o4, this.refreshModern();
    }
    updateModern() {
      if (this.type !== "modern")
        return;
      const { container: t4 } = this;
      t4 && (this.thumbGap = parseFloat(getComputedStyle(t4).getPropertyValue("--f-thumb-gap")) || 0, this.thumbExtraGap = parseFloat(getComputedStyle(t4).getPropertyValue("--f-thumb-extra-gap")) || 0, this.thumbWidth = parseFloat(getComputedStyle(t4).getPropertyValue("--f-thumb-width")) || 40, this.thumbClipWidth = parseFloat(getComputedStyle(t4).getPropertyValue("--f-thumb-clip-width")) || 40, this.thumbHeight = parseFloat(getComputedStyle(t4).getPropertyValue("--f-thumb-height")) || 40);
    }
    refreshModern() {
      var t4;
      if (this.type === "modern") {
        this.updateModern();
        for (const t5 of this.instance.slides || [])
          this.resizeModernSlide(t5);
        this.onTransformM(), (t4 = this.panzoom) === null || t4 === void 0 || t4.updateMetrics(true), this.centerModern(0);
      }
    }
    centerModern(t4) {
      const e4 = this.instance, { container: i4, panzoom: n4 } = this;
      if (!i4 || !n4 || n4.state === l3.Init)
        return;
      const s4 = e4.page;
      let r4 = this.getModernThumbPos(s4), o4 = r4;
      for (let t5 = e4.page - 3; t5 < e4.page + 3; t5++) {
        if (t5 < 0 || t5 > e4.pages.length - 1 || t5 === e4.page)
          continue;
        const i5 = 1 - Math.abs(e4.getProgress(t5));
        i5 > 0 && i5 < 1 && (o4 += i5 * (this.getModernThumbPos(t5) - r4));
      }
      let a4 = 100;
      t4 === void 0 && (t4 = 0.2, e4.inTransition.size > 0 && (t4 = 0.12), Math.abs(-1 * n4.current.e - o4) > n4.containerRect.width && (t4 = 0.5, a4 = 0)), n4.options.maxVelocity = a4, n4.applyChange({ panX: c3(-1 * o4 - n4.target.e, 1e3), friction: e4.prevPage === null ? 0 : t4 });
    }
    lazyLoadModern() {
      const { instance: t4, panzoom: i4 } = this;
      if (!i4)
        return;
      const s4 = -1 * i4.current.e || 0;
      let r4 = this.getModernThumbPos(t4.page);
      if (i4.state !== l3.Init || r4 === 0)
        for (const r5 of t4.slides || []) {
          const t5 = r5.thumbSlideEl;
          if (!t5)
            continue;
          const o4 = t5.querySelector("img[data-lazy-src]"), a4 = r5.index, l4 = this.getModernThumbPos(a4), h4 = s4 - 0.5 * i4.containerRect.innerWidth, c4 = h4 + i4.containerRect.innerWidth;
          if (!o4 || l4 < h4 || l4 > c4)
            continue;
          let u4 = o4.dataset.lazySrc;
          if (!u4 || !u4.length)
            continue;
          if (delete o4.dataset.lazySrc, o4.src = u4, o4.complete)
            continue;
          n3(t5, this.cn("isLoading"));
          const d4 = e3('<div class="f-spinner"><svg viewBox="0 0 50 50"><circle cx="25" cy="25" r="20"></circle><circle cx="25" cy="25" r="20"></circle></svg></div>');
          t5.appendChild(d4), o4.addEventListener("load", () => {
            t5.offsetParent && (t5.classList.remove(this.cn("isLoading")), d4.remove());
          }, false);
        }
    }
    resizeModernSlide(t4) {
      if (this.type !== "modern")
        return;
      if (!t4.thumbSlideEl)
        return;
      const e4 = t4.thumbClipWidth && t4.thumbHeight ? Math.round(this.thumbHeight * (t4.thumbClipWidth / t4.thumbHeight)) : this.thumbWidth;
      t4.thumbWidth = e4;
    }
    getModernThumbPos(t4) {
      const e4 = this.instance.slides[t4], i4 = this.panzoom;
      if (!i4 || !i4.contentRect.fitWidth)
        return 0;
      let n4 = i4.containerRect.innerWidth, s4 = i4.contentRect.width;
      this.instance.slides.length === 2 && (t4 -= 1, s4 = 2 * this.thumbClipWidth);
      let r4 = t4 * (this.thumbClipWidth + this.thumbGap) + this.thumbExtraGap + 0.5 * (e4.thumbWidth || 0);
      return r4 -= s4 > n4 ? 0.5 * n4 : 0.5 * s4, c3(r4 || 0, 1);
    }
    build() {
      const t4 = this.instance, e4 = t4.container, i4 = this.option("minCount") || 0;
      if (i4) {
        let e5 = 0;
        for (const i5 of t4.slides || [])
          i5.thumbSrc && e5++;
        if (e5 < i4)
          return this.cleanup(), void (this.state = d3.Disabled);
      }
      const s4 = this.option("type");
      if (["modern", "classic"].indexOf(s4) < 0)
        return void (this.state = d3.Disabled);
      this.type = s4;
      const r4 = document.createElement("div");
      n3(r4, this.cn("container")), n3(r4, `is-${s4}`);
      const o4 = this.option("parentEl");
      o4 ? o4.appendChild(r4) : e4.after(r4), this.container = r4, n3(e4, this.cn("hasThumbs"));
      const a4 = document.createElement("div");
      n3(a4, this.cn("track")), r4.appendChild(a4), this.track = a4, s4 === "classic" ? this.buildClassic() : this.buildModern(), this.state = d3.Ready, r4.addEventListener("click", (e5) => {
        setTimeout(() => {
          var e6;
          (e6 = r4 == null ? void 0 : r4.querySelector(`[data-carousel-index="${t4.page}"]`)) === null || e6 === void 0 || e6.focus();
        }, 100);
      });
    }
    cleanup() {
      var t4, e4;
      this.carousel && this.carousel.destroy(), this.carousel = null, this.panzoom && this.panzoom.destroy(), this.panzoom = null, this.container && this.container.remove(), this.container = null, this.track = null, this.state = d3.Init, t4 = this.instance.container, e4 = this.cn("hasThumbs"), t4 && i3(e4).forEach((e5) => {
        t4.classList.remove(e5);
      });
    }
    attach() {
      const t4 = this, e4 = t4.instance;
      e4.on("initSlide", t4.onInitSlide), e4.state === h3.Init ? e4.on("initSlides", t4.onInitSlides) : t4.onInitSlides(), e4.on("Panzoom.afterTransform", t4.onTransformM), e4.on("Panzoom.refresh", t4.onRefreshM), e4.on("change", t4.onChangeM);
    }
    detach() {
      const t4 = this, e4 = t4.instance;
      e4.off("initSlide", t4.onInitSlide), e4.off("initSlides", t4.onInitSlides), e4.off("Panzoom.afterTransform", t4.onTransformM), e4.off("Panzoom.refresh", t4.onRefreshM), e4.off("change", t4.onChangeM), t4.cleanup();
    }
  };
  Object.defineProperty(p3, "defaults", { enumerable: true, configurable: true, writable: true, value: u3 });

  // node_modules/ssr-window/ssr-window.esm.js
  function isObject(obj) {
    return obj !== null && typeof obj === "object" && "constructor" in obj && obj.constructor === Object;
  }
  function extend(target = {}, src = {}) {
    Object.keys(src).forEach((key) => {
      if (typeof target[key] === "undefined")
        target[key] = src[key];
      else if (isObject(src[key]) && isObject(target[key]) && Object.keys(src[key]).length > 0) {
        extend(target[key], src[key]);
      }
    });
  }
  var ssrDocument = {
    body: {},
    addEventListener() {
    },
    removeEventListener() {
    },
    activeElement: {
      blur() {
      },
      nodeName: ""
    },
    querySelector() {
      return null;
    },
    querySelectorAll() {
      return [];
    },
    getElementById() {
      return null;
    },
    createEvent() {
      return {
        initEvent() {
        }
      };
    },
    createElement() {
      return {
        children: [],
        childNodes: [],
        style: {},
        setAttribute() {
        },
        getElementsByTagName() {
          return [];
        }
      };
    },
    createElementNS() {
      return {};
    },
    importNode() {
      return null;
    },
    location: {
      hash: "",
      host: "",
      hostname: "",
      href: "",
      origin: "",
      pathname: "",
      protocol: "",
      search: ""
    }
  };
  function getDocument() {
    const doc = typeof document !== "undefined" ? document : {};
    extend(doc, ssrDocument);
    return doc;
  }
  var ssrWindow = {
    document: ssrDocument,
    navigator: {
      userAgent: ""
    },
    location: {
      hash: "",
      host: "",
      hostname: "",
      href: "",
      origin: "",
      pathname: "",
      protocol: "",
      search: ""
    },
    history: {
      replaceState() {
      },
      pushState() {
      },
      go() {
      },
      back() {
      }
    },
    CustomEvent: function CustomEvent2() {
      return this;
    },
    addEventListener() {
    },
    removeEventListener() {
    },
    getComputedStyle() {
      return {
        getPropertyValue() {
          return "";
        }
      };
    },
    Image() {
    },
    Date() {
    },
    screen: {},
    setTimeout() {
    },
    clearTimeout() {
    },
    matchMedia() {
      return {};
    },
    requestAnimationFrame(callback) {
      if (typeof setTimeout === "undefined") {
        callback();
        return null;
      }
      return setTimeout(callback, 0);
    },
    cancelAnimationFrame(id) {
      if (typeof setTimeout === "undefined") {
        return;
      }
      clearTimeout(id);
    }
  };
  function getWindow() {
    const win = typeof window !== "undefined" ? window : {};
    extend(win, ssrWindow);
    return win;
  }

  // node_modules/dom7/dom7.esm.js
  function makeReactive(obj) {
    const proto = obj.__proto__;
    Object.defineProperty(obj, "__proto__", {
      get() {
        return proto;
      },
      set(value) {
        proto.__proto__ = value;
      }
    });
  }
  var Dom7 = class extends Array {
    constructor(items) {
      if (typeof items === "number") {
        super(items);
      } else {
        super(...items || []);
        makeReactive(this);
      }
    }
  };
  function arrayFlat(arr = []) {
    const res = [];
    arr.forEach((el) => {
      if (Array.isArray(el)) {
        res.push(...arrayFlat(el));
      } else {
        res.push(el);
      }
    });
    return res;
  }
  function arrayFilter(arr, callback) {
    return Array.prototype.filter.call(arr, callback);
  }
  function arrayUnique(arr) {
    const uniqueArray = [];
    for (let i4 = 0; i4 < arr.length; i4 += 1) {
      if (uniqueArray.indexOf(arr[i4]) === -1)
        uniqueArray.push(arr[i4]);
    }
    return uniqueArray;
  }
  function qsa(selector, context) {
    if (typeof selector !== "string") {
      return [selector];
    }
    const a4 = [];
    const res = context.querySelectorAll(selector);
    for (let i4 = 0; i4 < res.length; i4 += 1) {
      a4.push(res[i4]);
    }
    return a4;
  }
  function $3(selector, context) {
    const window2 = getWindow();
    const document2 = getDocument();
    let arr = [];
    if (!context && selector instanceof Dom7) {
      return selector;
    }
    if (!selector) {
      return new Dom7(arr);
    }
    if (typeof selector === "string") {
      const html2 = selector.trim();
      if (html2.indexOf("<") >= 0 && html2.indexOf(">") >= 0) {
        let toCreate = "div";
        if (html2.indexOf("<li") === 0)
          toCreate = "ul";
        if (html2.indexOf("<tr") === 0)
          toCreate = "tbody";
        if (html2.indexOf("<td") === 0 || html2.indexOf("<th") === 0)
          toCreate = "tr";
        if (html2.indexOf("<tbody") === 0)
          toCreate = "table";
        if (html2.indexOf("<option") === 0)
          toCreate = "select";
        const tempParent = document2.createElement(toCreate);
        tempParent.innerHTML = html2;
        for (let i4 = 0; i4 < tempParent.childNodes.length; i4 += 1) {
          arr.push(tempParent.childNodes[i4]);
        }
      } else {
        arr = qsa(selector.trim(), context || document2);
      }
    } else if (selector.nodeType || selector === window2 || selector === document2) {
      arr.push(selector);
    } else if (Array.isArray(selector)) {
      if (selector instanceof Dom7)
        return selector;
      arr = selector;
    }
    return new Dom7(arrayUnique(arr));
  }
  $3.fn = Dom7.prototype;
  function addClass(...classes) {
    const classNames = arrayFlat(classes.map((c4) => c4.split(" ")));
    this.forEach((el) => {
      el.classList.add(...classNames);
    });
    return this;
  }
  function removeClass(...classes) {
    const classNames = arrayFlat(classes.map((c4) => c4.split(" ")));
    this.forEach((el) => {
      el.classList.remove(...classNames);
    });
    return this;
  }
  function toggleClass(...classes) {
    const classNames = arrayFlat(classes.map((c4) => c4.split(" ")));
    this.forEach((el) => {
      classNames.forEach((className) => {
        el.classList.toggle(className);
      });
    });
  }
  function hasClass(...classes) {
    const classNames = arrayFlat(classes.map((c4) => c4.split(" ")));
    return arrayFilter(this, (el) => {
      return classNames.filter((className) => el.classList.contains(className)).length > 0;
    }).length > 0;
  }
  function attr(attrs, value) {
    if (arguments.length === 1 && typeof attrs === "string") {
      if (this[0])
        return this[0].getAttribute(attrs);
      return void 0;
    }
    for (let i4 = 0; i4 < this.length; i4 += 1) {
      if (arguments.length === 2) {
        this[i4].setAttribute(attrs, value);
      } else {
        for (const attrName in attrs) {
          this[i4][attrName] = attrs[attrName];
          this[i4].setAttribute(attrName, attrs[attrName]);
        }
      }
    }
    return this;
  }
  function removeAttr(attr2) {
    for (let i4 = 0; i4 < this.length; i4 += 1) {
      this[i4].removeAttribute(attr2);
    }
    return this;
  }
  function transform(transform2) {
    for (let i4 = 0; i4 < this.length; i4 += 1) {
      this[i4].style.transform = transform2;
    }
    return this;
  }
  function transition(duration) {
    for (let i4 = 0; i4 < this.length; i4 += 1) {
      this[i4].style.transitionDuration = typeof duration !== "string" ? `${duration}ms` : duration;
    }
    return this;
  }
  function on(...args) {
    let [eventType, targetSelector, listener, capture] = args;
    if (typeof args[1] === "function") {
      [eventType, listener, capture] = args;
      targetSelector = void 0;
    }
    if (!capture)
      capture = false;
    function handleLiveEvent(e4) {
      const target = e4.target;
      if (!target)
        return;
      const eventData = e4.target.dom7EventData || [];
      if (eventData.indexOf(e4) < 0) {
        eventData.unshift(e4);
      }
      if ($3(target).is(targetSelector))
        listener.apply(target, eventData);
      else {
        const parents2 = $3(target).parents();
        for (let k3 = 0; k3 < parents2.length; k3 += 1) {
          if ($3(parents2[k3]).is(targetSelector))
            listener.apply(parents2[k3], eventData);
        }
      }
    }
    function handleEvent(e4) {
      const eventData = e4 && e4.target ? e4.target.dom7EventData || [] : [];
      if (eventData.indexOf(e4) < 0) {
        eventData.unshift(e4);
      }
      listener.apply(this, eventData);
    }
    const events2 = eventType.split(" ");
    let j3;
    for (let i4 = 0; i4 < this.length; i4 += 1) {
      const el = this[i4];
      if (!targetSelector) {
        for (j3 = 0; j3 < events2.length; j3 += 1) {
          const event2 = events2[j3];
          if (!el.dom7Listeners)
            el.dom7Listeners = {};
          if (!el.dom7Listeners[event2])
            el.dom7Listeners[event2] = [];
          el.dom7Listeners[event2].push({
            listener,
            proxyListener: handleEvent
          });
          el.addEventListener(event2, handleEvent, capture);
        }
      } else {
        for (j3 = 0; j3 < events2.length; j3 += 1) {
          const event2 = events2[j3];
          if (!el.dom7LiveListeners)
            el.dom7LiveListeners = {};
          if (!el.dom7LiveListeners[event2])
            el.dom7LiveListeners[event2] = [];
          el.dom7LiveListeners[event2].push({
            listener,
            proxyListener: handleLiveEvent
          });
          el.addEventListener(event2, handleLiveEvent, capture);
        }
      }
    }
    return this;
  }
  function off(...args) {
    let [eventType, targetSelector, listener, capture] = args;
    if (typeof args[1] === "function") {
      [eventType, listener, capture] = args;
      targetSelector = void 0;
    }
    if (!capture)
      capture = false;
    const events2 = eventType.split(" ");
    for (let i4 = 0; i4 < events2.length; i4 += 1) {
      const event2 = events2[i4];
      for (let j3 = 0; j3 < this.length; j3 += 1) {
        const el = this[j3];
        let handlers;
        if (!targetSelector && el.dom7Listeners) {
          handlers = el.dom7Listeners[event2];
        } else if (targetSelector && el.dom7LiveListeners) {
          handlers = el.dom7LiveListeners[event2];
        }
        if (handlers && handlers.length) {
          for (let k3 = handlers.length - 1; k3 >= 0; k3 -= 1) {
            const handler = handlers[k3];
            if (listener && handler.listener === listener) {
              el.removeEventListener(event2, handler.proxyListener, capture);
              handlers.splice(k3, 1);
            } else if (listener && handler.listener && handler.listener.dom7proxy && handler.listener.dom7proxy === listener) {
              el.removeEventListener(event2, handler.proxyListener, capture);
              handlers.splice(k3, 1);
            } else if (!listener) {
              el.removeEventListener(event2, handler.proxyListener, capture);
              handlers.splice(k3, 1);
            }
          }
        }
      }
    }
    return this;
  }
  function trigger(...args) {
    const window2 = getWindow();
    const events2 = args[0].split(" ");
    const eventData = args[1];
    for (let i4 = 0; i4 < events2.length; i4 += 1) {
      const event2 = events2[i4];
      for (let j3 = 0; j3 < this.length; j3 += 1) {
        const el = this[j3];
        if (window2.CustomEvent) {
          const evt = new window2.CustomEvent(event2, {
            detail: eventData,
            bubbles: true,
            cancelable: true
          });
          el.dom7EventData = args.filter((data, dataIndex) => dataIndex > 0);
          el.dispatchEvent(evt);
          el.dom7EventData = [];
          delete el.dom7EventData;
        }
      }
    }
    return this;
  }
  function transitionEnd(callback) {
    const dom = this;
    function fireCallBack(e4) {
      if (e4.target !== this)
        return;
      callback.call(this, e4);
      dom.off("transitionend", fireCallBack);
    }
    if (callback) {
      dom.on("transitionend", fireCallBack);
    }
    return this;
  }
  function outerWidth(includeMargins) {
    if (this.length > 0) {
      if (includeMargins) {
        const styles2 = this.styles();
        return this[0].offsetWidth + parseFloat(styles2.getPropertyValue("margin-right")) + parseFloat(styles2.getPropertyValue("margin-left"));
      }
      return this[0].offsetWidth;
    }
    return null;
  }
  function outerHeight(includeMargins) {
    if (this.length > 0) {
      if (includeMargins) {
        const styles2 = this.styles();
        return this[0].offsetHeight + parseFloat(styles2.getPropertyValue("margin-top")) + parseFloat(styles2.getPropertyValue("margin-bottom"));
      }
      return this[0].offsetHeight;
    }
    return null;
  }
  function offset() {
    if (this.length > 0) {
      const window2 = getWindow();
      const document2 = getDocument();
      const el = this[0];
      const box = el.getBoundingClientRect();
      const body = document2.body;
      const clientTop = el.clientTop || body.clientTop || 0;
      const clientLeft = el.clientLeft || body.clientLeft || 0;
      const scrollTop = el === window2 ? window2.scrollY : el.scrollTop;
      const scrollLeft = el === window2 ? window2.scrollX : el.scrollLeft;
      return {
        top: box.top + scrollTop - clientTop,
        left: box.left + scrollLeft - clientLeft
      };
    }
    return null;
  }
  function styles() {
    const window2 = getWindow();
    if (this[0])
      return window2.getComputedStyle(this[0], null);
    return {};
  }
  function css(props, value) {
    const window2 = getWindow();
    let i4;
    if (arguments.length === 1) {
      if (typeof props === "string") {
        if (this[0])
          return window2.getComputedStyle(this[0], null).getPropertyValue(props);
      } else {
        for (i4 = 0; i4 < this.length; i4 += 1) {
          for (const prop in props) {
            this[i4].style[prop] = props[prop];
          }
        }
        return this;
      }
    }
    if (arguments.length === 2 && typeof props === "string") {
      for (i4 = 0; i4 < this.length; i4 += 1) {
        this[i4].style[props] = value;
      }
      return this;
    }
    return this;
  }
  function each(callback) {
    if (!callback)
      return this;
    this.forEach((el, index2) => {
      callback.apply(el, [el, index2]);
    });
    return this;
  }
  function filter(callback) {
    const result = arrayFilter(this, callback);
    return $3(result);
  }
  function html(html2) {
    if (typeof html2 === "undefined") {
      return this[0] ? this[0].innerHTML : null;
    }
    for (let i4 = 0; i4 < this.length; i4 += 1) {
      this[i4].innerHTML = html2;
    }
    return this;
  }
  function text(text2) {
    if (typeof text2 === "undefined") {
      return this[0] ? this[0].textContent.trim() : null;
    }
    for (let i4 = 0; i4 < this.length; i4 += 1) {
      this[i4].textContent = text2;
    }
    return this;
  }
  function is(selector) {
    const window2 = getWindow();
    const document2 = getDocument();
    const el = this[0];
    let compareWith;
    let i4;
    if (!el || typeof selector === "undefined")
      return false;
    if (typeof selector === "string") {
      if (el.matches)
        return el.matches(selector);
      if (el.webkitMatchesSelector)
        return el.webkitMatchesSelector(selector);
      if (el.msMatchesSelector)
        return el.msMatchesSelector(selector);
      compareWith = $3(selector);
      for (i4 = 0; i4 < compareWith.length; i4 += 1) {
        if (compareWith[i4] === el)
          return true;
      }
      return false;
    }
    if (selector === document2) {
      return el === document2;
    }
    if (selector === window2) {
      return el === window2;
    }
    if (selector.nodeType || selector instanceof Dom7) {
      compareWith = selector.nodeType ? [selector] : selector;
      for (i4 = 0; i4 < compareWith.length; i4 += 1) {
        if (compareWith[i4] === el)
          return true;
      }
      return false;
    }
    return false;
  }
  function index() {
    let child = this[0];
    let i4;
    if (child) {
      i4 = 0;
      while ((child = child.previousSibling) !== null) {
        if (child.nodeType === 1)
          i4 += 1;
      }
      return i4;
    }
    return void 0;
  }
  function eq(index2) {
    if (typeof index2 === "undefined")
      return this;
    const length = this.length;
    if (index2 > length - 1) {
      return $3([]);
    }
    if (index2 < 0) {
      const returnIndex = length + index2;
      if (returnIndex < 0)
        return $3([]);
      return $3([this[returnIndex]]);
    }
    return $3([this[index2]]);
  }
  function append(...els) {
    let newChild;
    const document2 = getDocument();
    for (let k3 = 0; k3 < els.length; k3 += 1) {
      newChild = els[k3];
      for (let i4 = 0; i4 < this.length; i4 += 1) {
        if (typeof newChild === "string") {
          const tempDiv = document2.createElement("div");
          tempDiv.innerHTML = newChild;
          while (tempDiv.firstChild) {
            this[i4].appendChild(tempDiv.firstChild);
          }
        } else if (newChild instanceof Dom7) {
          for (let j3 = 0; j3 < newChild.length; j3 += 1) {
            this[i4].appendChild(newChild[j3]);
          }
        } else {
          this[i4].appendChild(newChild);
        }
      }
    }
    return this;
  }
  function prepend(newChild) {
    const document2 = getDocument();
    let i4;
    let j3;
    for (i4 = 0; i4 < this.length; i4 += 1) {
      if (typeof newChild === "string") {
        const tempDiv = document2.createElement("div");
        tempDiv.innerHTML = newChild;
        for (j3 = tempDiv.childNodes.length - 1; j3 >= 0; j3 -= 1) {
          this[i4].insertBefore(tempDiv.childNodes[j3], this[i4].childNodes[0]);
        }
      } else if (newChild instanceof Dom7) {
        for (j3 = 0; j3 < newChild.length; j3 += 1) {
          this[i4].insertBefore(newChild[j3], this[i4].childNodes[0]);
        }
      } else {
        this[i4].insertBefore(newChild, this[i4].childNodes[0]);
      }
    }
    return this;
  }
  function next(selector) {
    if (this.length > 0) {
      if (selector) {
        if (this[0].nextElementSibling && $3(this[0].nextElementSibling).is(selector)) {
          return $3([this[0].nextElementSibling]);
        }
        return $3([]);
      }
      if (this[0].nextElementSibling)
        return $3([this[0].nextElementSibling]);
      return $3([]);
    }
    return $3([]);
  }
  function nextAll(selector) {
    const nextEls = [];
    let el = this[0];
    if (!el)
      return $3([]);
    while (el.nextElementSibling) {
      const next2 = el.nextElementSibling;
      if (selector) {
        if ($3(next2).is(selector))
          nextEls.push(next2);
      } else
        nextEls.push(next2);
      el = next2;
    }
    return $3(nextEls);
  }
  function prev(selector) {
    if (this.length > 0) {
      const el = this[0];
      if (selector) {
        if (el.previousElementSibling && $3(el.previousElementSibling).is(selector)) {
          return $3([el.previousElementSibling]);
        }
        return $3([]);
      }
      if (el.previousElementSibling)
        return $3([el.previousElementSibling]);
      return $3([]);
    }
    return $3([]);
  }
  function prevAll(selector) {
    const prevEls = [];
    let el = this[0];
    if (!el)
      return $3([]);
    while (el.previousElementSibling) {
      const prev2 = el.previousElementSibling;
      if (selector) {
        if ($3(prev2).is(selector))
          prevEls.push(prev2);
      } else
        prevEls.push(prev2);
      el = prev2;
    }
    return $3(prevEls);
  }
  function parent(selector) {
    const parents2 = [];
    for (let i4 = 0; i4 < this.length; i4 += 1) {
      if (this[i4].parentNode !== null) {
        if (selector) {
          if ($3(this[i4].parentNode).is(selector))
            parents2.push(this[i4].parentNode);
        } else {
          parents2.push(this[i4].parentNode);
        }
      }
    }
    return $3(parents2);
  }
  function parents(selector) {
    const parents2 = [];
    for (let i4 = 0; i4 < this.length; i4 += 1) {
      let parent2 = this[i4].parentNode;
      while (parent2) {
        if (selector) {
          if ($3(parent2).is(selector))
            parents2.push(parent2);
        } else {
          parents2.push(parent2);
        }
        parent2 = parent2.parentNode;
      }
    }
    return $3(parents2);
  }
  function closest(selector) {
    let closest2 = this;
    if (typeof selector === "undefined") {
      return $3([]);
    }
    if (!closest2.is(selector)) {
      closest2 = closest2.parents(selector).eq(0);
    }
    return closest2;
  }
  function find(selector) {
    const foundElements = [];
    for (let i4 = 0; i4 < this.length; i4 += 1) {
      const found = this[i4].querySelectorAll(selector);
      for (let j3 = 0; j3 < found.length; j3 += 1) {
        foundElements.push(found[j3]);
      }
    }
    return $3(foundElements);
  }
  function children(selector) {
    const children2 = [];
    for (let i4 = 0; i4 < this.length; i4 += 1) {
      const childNodes = this[i4].children;
      for (let j3 = 0; j3 < childNodes.length; j3 += 1) {
        if (!selector || $3(childNodes[j3]).is(selector)) {
          children2.push(childNodes[j3]);
        }
      }
    }
    return $3(children2);
  }
  function remove() {
    for (let i4 = 0; i4 < this.length; i4 += 1) {
      if (this[i4].parentNode)
        this[i4].parentNode.removeChild(this[i4]);
    }
    return this;
  }
  var noTrigger = "resize scroll".split(" ");
  function shortcut(name) {
    function eventHandler(...args) {
      if (typeof args[0] === "undefined") {
        for (let i4 = 0; i4 < this.length; i4 += 1) {
          if (noTrigger.indexOf(name) < 0) {
            if (name in this[i4])
              this[i4][name]();
            else {
              $3(this[i4]).trigger(name);
            }
          }
        }
        return this;
      }
      return this.on(name, ...args);
    }
    return eventHandler;
  }
  var click = shortcut("click");
  var blur = shortcut("blur");
  var focus = shortcut("focus");
  var focusin = shortcut("focusin");
  var focusout = shortcut("focusout");
  var keyup = shortcut("keyup");
  var keydown = shortcut("keydown");
  var keypress = shortcut("keypress");
  var submit = shortcut("submit");
  var change = shortcut("change");
  var mousedown = shortcut("mousedown");
  var mousemove = shortcut("mousemove");
  var mouseup = shortcut("mouseup");
  var mouseenter = shortcut("mouseenter");
  var mouseleave = shortcut("mouseleave");
  var mouseout = shortcut("mouseout");
  var mouseover = shortcut("mouseover");
  var touchstart = shortcut("touchstart");
  var touchend = shortcut("touchend");
  var touchmove = shortcut("touchmove");
  var resize = shortcut("resize");
  var scroll = shortcut("scroll");

  // node_modules/swiper/shared/dom.js
  var Methods = {
    addClass,
    removeClass,
    hasClass,
    toggleClass,
    attr,
    removeAttr,
    transform,
    transition,
    on,
    off,
    trigger,
    transitionEnd,
    outerWidth,
    outerHeight,
    styles,
    offset,
    css,
    each,
    html,
    text,
    is,
    index,
    eq,
    append,
    prepend,
    next,
    nextAll,
    prev,
    prevAll,
    parent,
    parents,
    closest,
    find,
    children,
    filter,
    remove
  };
  Object.keys(Methods).forEach((methodName) => {
    Object.defineProperty($3.fn, methodName, {
      value: Methods[methodName],
      writable: true
    });
  });
  var dom_default = $3;

  // node_modules/swiper/shared/utils.js
  function deleteProps(obj) {
    const object = obj;
    Object.keys(object).forEach((key) => {
      try {
        object[key] = null;
      } catch (e4) {
      }
      try {
        delete object[key];
      } catch (e4) {
      }
    });
  }
  function nextTick(callback, delay = 0) {
    return setTimeout(callback, delay);
  }
  function now() {
    return Date.now();
  }
  function getComputedStyle2(el) {
    const window2 = getWindow();
    let style;
    if (window2.getComputedStyle) {
      style = window2.getComputedStyle(el, null);
    }
    if (!style && el.currentStyle) {
      style = el.currentStyle;
    }
    if (!style) {
      style = el.style;
    }
    return style;
  }
  function getTranslate(el, axis = "x") {
    const window2 = getWindow();
    let matrix;
    let curTransform;
    let transformMatrix;
    const curStyle = getComputedStyle2(el, null);
    if (window2.WebKitCSSMatrix) {
      curTransform = curStyle.transform || curStyle.webkitTransform;
      if (curTransform.split(",").length > 6) {
        curTransform = curTransform.split(", ").map((a4) => a4.replace(",", ".")).join(", ");
      }
      transformMatrix = new window2.WebKitCSSMatrix(curTransform === "none" ? "" : curTransform);
    } else {
      transformMatrix = curStyle.MozTransform || curStyle.OTransform || curStyle.MsTransform || curStyle.msTransform || curStyle.transform || curStyle.getPropertyValue("transform").replace("translate(", "matrix(1, 0, 0, 1,");
      matrix = transformMatrix.toString().split(",");
    }
    if (axis === "x") {
      if (window2.WebKitCSSMatrix)
        curTransform = transformMatrix.m41;
      else if (matrix.length === 16)
        curTransform = parseFloat(matrix[12]);
      else
        curTransform = parseFloat(matrix[4]);
    }
    if (axis === "y") {
      if (window2.WebKitCSSMatrix)
        curTransform = transformMatrix.m42;
      else if (matrix.length === 16)
        curTransform = parseFloat(matrix[13]);
      else
        curTransform = parseFloat(matrix[5]);
    }
    return curTransform || 0;
  }
  function isObject2(o4) {
    return typeof o4 === "object" && o4 !== null && o4.constructor && Object.prototype.toString.call(o4).slice(8, -1) === "Object";
  }
  function isNode(node) {
    if (typeof window !== "undefined" && typeof window.HTMLElement !== "undefined") {
      return node instanceof HTMLElement;
    }
    return node && (node.nodeType === 1 || node.nodeType === 11);
  }
  function extend2(...args) {
    const to = Object(args[0]);
    const noExtend = ["__proto__", "constructor", "prototype"];
    for (let i4 = 1; i4 < args.length; i4 += 1) {
      const nextSource = args[i4];
      if (nextSource !== void 0 && nextSource !== null && !isNode(nextSource)) {
        const keysArray = Object.keys(Object(nextSource)).filter((key) => noExtend.indexOf(key) < 0);
        for (let nextIndex = 0, len = keysArray.length; nextIndex < len; nextIndex += 1) {
          const nextKey = keysArray[nextIndex];
          const desc = Object.getOwnPropertyDescriptor(nextSource, nextKey);
          if (desc !== void 0 && desc.enumerable) {
            if (isObject2(to[nextKey]) && isObject2(nextSource[nextKey])) {
              if (nextSource[nextKey].__swiper__) {
                to[nextKey] = nextSource[nextKey];
              } else {
                extend2(to[nextKey], nextSource[nextKey]);
              }
            } else if (!isObject2(to[nextKey]) && isObject2(nextSource[nextKey])) {
              to[nextKey] = {};
              if (nextSource[nextKey].__swiper__) {
                to[nextKey] = nextSource[nextKey];
              } else {
                extend2(to[nextKey], nextSource[nextKey]);
              }
            } else {
              to[nextKey] = nextSource[nextKey];
            }
          }
        }
      }
    }
    return to;
  }
  function setCSSProperty(el, varName, varValue) {
    el.style.setProperty(varName, varValue);
  }
  function animateCSSModeScroll({
    swiper,
    targetPosition,
    side
  }) {
    const window2 = getWindow();
    const startPosition = -swiper.translate;
    let startTime = null;
    let time;
    const duration = swiper.params.speed;
    swiper.wrapperEl.style.scrollSnapType = "none";
    window2.cancelAnimationFrame(swiper.cssModeFrameID);
    const dir = targetPosition > startPosition ? "next" : "prev";
    const isOutOfBound = (current, target) => {
      return dir === "next" && current >= target || dir === "prev" && current <= target;
    };
    const animate = () => {
      time = new Date().getTime();
      if (startTime === null) {
        startTime = time;
      }
      const progress = Math.max(Math.min((time - startTime) / duration, 1), 0);
      const easeProgress = 0.5 - Math.cos(progress * Math.PI) / 2;
      let currentPosition = startPosition + easeProgress * (targetPosition - startPosition);
      if (isOutOfBound(currentPosition, targetPosition)) {
        currentPosition = targetPosition;
      }
      swiper.wrapperEl.scrollTo({
        [side]: currentPosition
      });
      if (isOutOfBound(currentPosition, targetPosition)) {
        swiper.wrapperEl.style.overflow = "hidden";
        swiper.wrapperEl.style.scrollSnapType = "";
        setTimeout(() => {
          swiper.wrapperEl.style.overflow = "";
          swiper.wrapperEl.scrollTo({
            [side]: currentPosition
          });
        });
        window2.cancelAnimationFrame(swiper.cssModeFrameID);
        return;
      }
      swiper.cssModeFrameID = window2.requestAnimationFrame(animate);
    };
    animate();
  }

  // node_modules/swiper/shared/get-support.js
  var support;
  function calcSupport() {
    const window2 = getWindow();
    const document2 = getDocument();
    return {
      smoothScroll: document2.documentElement && "scrollBehavior" in document2.documentElement.style,
      touch: !!("ontouchstart" in window2 || window2.DocumentTouch && document2 instanceof window2.DocumentTouch),
      passiveListener: function checkPassiveListener() {
        let supportsPassive = false;
        try {
          const opts = Object.defineProperty({}, "passive", {
            get() {
              supportsPassive = true;
            }
          });
          window2.addEventListener("testPassiveListener", null, opts);
        } catch (e4) {
        }
        return supportsPassive;
      }(),
      gestures: function checkGestures() {
        return "ongesturestart" in window2;
      }()
    };
  }
  function getSupport() {
    if (!support) {
      support = calcSupport();
    }
    return support;
  }

  // node_modules/swiper/shared/get-device.js
  var deviceCached;
  function calcDevice({
    userAgent
  } = {}) {
    const support2 = getSupport();
    const window2 = getWindow();
    const platform = window2.navigator.platform;
    const ua = userAgent || window2.navigator.userAgent;
    const device = {
      ios: false,
      android: false
    };
    const screenWidth = window2.screen.width;
    const screenHeight = window2.screen.height;
    const android = ua.match(/(Android);?[\s\/]+([\d.]+)?/);
    let ipad = ua.match(/(iPad).*OS\s([\d_]+)/);
    const ipod = ua.match(/(iPod)(.*OS\s([\d_]+))?/);
    const iphone = !ipad && ua.match(/(iPhone\sOS|iOS)\s([\d_]+)/);
    const windows = platform === "Win32";
    let macos = platform === "MacIntel";
    const iPadScreens = ["1024x1366", "1366x1024", "834x1194", "1194x834", "834x1112", "1112x834", "768x1024", "1024x768", "820x1180", "1180x820", "810x1080", "1080x810"];
    if (!ipad && macos && support2.touch && iPadScreens.indexOf(`${screenWidth}x${screenHeight}`) >= 0) {
      ipad = ua.match(/(Version)\/([\d.]+)/);
      if (!ipad)
        ipad = [0, 1, "13_0_0"];
      macos = false;
    }
    if (android && !windows) {
      device.os = "android";
      device.android = true;
    }
    if (ipad || iphone || ipod) {
      device.os = "ios";
      device.ios = true;
    }
    return device;
  }
  function getDevice(overrides = {}) {
    if (!deviceCached) {
      deviceCached = calcDevice(overrides);
    }
    return deviceCached;
  }

  // node_modules/swiper/shared/get-browser.js
  var browser;
  function calcBrowser() {
    const window2 = getWindow();
    function isSafari() {
      const ua = window2.navigator.userAgent.toLowerCase();
      return ua.indexOf("safari") >= 0 && ua.indexOf("chrome") < 0 && ua.indexOf("android") < 0;
    }
    return {
      isSafari: isSafari(),
      isWebView: /(iPhone|iPod|iPad).*AppleWebKit(?!.*Safari)/i.test(window2.navigator.userAgent)
    };
  }
  function getBrowser() {
    if (!browser) {
      browser = calcBrowser();
    }
    return browser;
  }

  // node_modules/swiper/core/modules/resize/resize.js
  function Resize({
    swiper,
    on: on2,
    emit
  }) {
    const window2 = getWindow();
    let observer = null;
    let animationFrame = null;
    const resizeHandler = () => {
      if (!swiper || swiper.destroyed || !swiper.initialized)
        return;
      emit("beforeResize");
      emit("resize");
    };
    const createObserver = () => {
      if (!swiper || swiper.destroyed || !swiper.initialized)
        return;
      observer = new ResizeObserver((entries) => {
        animationFrame = window2.requestAnimationFrame(() => {
          const {
            width,
            height
          } = swiper;
          let newWidth = width;
          let newHeight = height;
          entries.forEach(({
            contentBoxSize,
            contentRect,
            target
          }) => {
            if (target && target !== swiper.el)
              return;
            newWidth = contentRect ? contentRect.width : (contentBoxSize[0] || contentBoxSize).inlineSize;
            newHeight = contentRect ? contentRect.height : (contentBoxSize[0] || contentBoxSize).blockSize;
          });
          if (newWidth !== width || newHeight !== height) {
            resizeHandler();
          }
        });
      });
      observer.observe(swiper.el);
    };
    const removeObserver = () => {
      if (animationFrame) {
        window2.cancelAnimationFrame(animationFrame);
      }
      if (observer && observer.unobserve && swiper.el) {
        observer.unobserve(swiper.el);
        observer = null;
      }
    };
    const orientationChangeHandler = () => {
      if (!swiper || swiper.destroyed || !swiper.initialized)
        return;
      emit("orientationchange");
    };
    on2("init", () => {
      if (swiper.params.resizeObserver && typeof window2.ResizeObserver !== "undefined") {
        createObserver();
        return;
      }
      window2.addEventListener("resize", resizeHandler);
      window2.addEventListener("orientationchange", orientationChangeHandler);
    });
    on2("destroy", () => {
      removeObserver();
      window2.removeEventListener("resize", resizeHandler);
      window2.removeEventListener("orientationchange", orientationChangeHandler);
    });
  }

  // node_modules/swiper/core/modules/observer/observer.js
  function Observer({
    swiper,
    extendParams,
    on: on2,
    emit
  }) {
    const observers = [];
    const window2 = getWindow();
    const attach = (target, options = {}) => {
      const ObserverFunc = window2.MutationObserver || window2.WebkitMutationObserver;
      const observer = new ObserverFunc((mutations) => {
        if (mutations.length === 1) {
          emit("observerUpdate", mutations[0]);
          return;
        }
        const observerUpdate = function observerUpdate2() {
          emit("observerUpdate", mutations[0]);
        };
        if (window2.requestAnimationFrame) {
          window2.requestAnimationFrame(observerUpdate);
        } else {
          window2.setTimeout(observerUpdate, 0);
        }
      });
      observer.observe(target, {
        attributes: typeof options.attributes === "undefined" ? true : options.attributes,
        childList: typeof options.childList === "undefined" ? true : options.childList,
        characterData: typeof options.characterData === "undefined" ? true : options.characterData
      });
      observers.push(observer);
    };
    const init = () => {
      if (!swiper.params.observer)
        return;
      if (swiper.params.observeParents) {
        const containerParents = swiper.$el.parents();
        for (let i4 = 0; i4 < containerParents.length; i4 += 1) {
          attach(containerParents[i4]);
        }
      }
      attach(swiper.$el[0], {
        childList: swiper.params.observeSlideChildren
      });
      attach(swiper.$wrapperEl[0], {
        attributes: false
      });
    };
    const destroy = () => {
      observers.forEach((observer) => {
        observer.disconnect();
      });
      observers.splice(0, observers.length);
    };
    extendParams({
      observer: false,
      observeParents: false,
      observeSlideChildren: false
    });
    on2("init", init);
    on2("destroy", destroy);
  }

  // node_modules/swiper/core/events-emitter.js
  var events_emitter_default = {
    on(events2, handler, priority) {
      const self2 = this;
      if (!self2.eventsListeners || self2.destroyed)
        return self2;
      if (typeof handler !== "function")
        return self2;
      const method = priority ? "unshift" : "push";
      events2.split(" ").forEach((event2) => {
        if (!self2.eventsListeners[event2])
          self2.eventsListeners[event2] = [];
        self2.eventsListeners[event2][method](handler);
      });
      return self2;
    },
    once(events2, handler, priority) {
      const self2 = this;
      if (!self2.eventsListeners || self2.destroyed)
        return self2;
      if (typeof handler !== "function")
        return self2;
      function onceHandler(...args) {
        self2.off(events2, onceHandler);
        if (onceHandler.__emitterProxy) {
          delete onceHandler.__emitterProxy;
        }
        handler.apply(self2, args);
      }
      onceHandler.__emitterProxy = handler;
      return self2.on(events2, onceHandler, priority);
    },
    onAny(handler, priority) {
      const self2 = this;
      if (!self2.eventsListeners || self2.destroyed)
        return self2;
      if (typeof handler !== "function")
        return self2;
      const method = priority ? "unshift" : "push";
      if (self2.eventsAnyListeners.indexOf(handler) < 0) {
        self2.eventsAnyListeners[method](handler);
      }
      return self2;
    },
    offAny(handler) {
      const self2 = this;
      if (!self2.eventsListeners || self2.destroyed)
        return self2;
      if (!self2.eventsAnyListeners)
        return self2;
      const index2 = self2.eventsAnyListeners.indexOf(handler);
      if (index2 >= 0) {
        self2.eventsAnyListeners.splice(index2, 1);
      }
      return self2;
    },
    off(events2, handler) {
      const self2 = this;
      if (!self2.eventsListeners || self2.destroyed)
        return self2;
      if (!self2.eventsListeners)
        return self2;
      events2.split(" ").forEach((event2) => {
        if (typeof handler === "undefined") {
          self2.eventsListeners[event2] = [];
        } else if (self2.eventsListeners[event2]) {
          self2.eventsListeners[event2].forEach((eventHandler, index2) => {
            if (eventHandler === handler || eventHandler.__emitterProxy && eventHandler.__emitterProxy === handler) {
              self2.eventsListeners[event2].splice(index2, 1);
            }
          });
        }
      });
      return self2;
    },
    emit(...args) {
      const self2 = this;
      if (!self2.eventsListeners || self2.destroyed)
        return self2;
      if (!self2.eventsListeners)
        return self2;
      let events2;
      let data;
      let context;
      if (typeof args[0] === "string" || Array.isArray(args[0])) {
        events2 = args[0];
        data = args.slice(1, args.length);
        context = self2;
      } else {
        events2 = args[0].events;
        data = args[0].data;
        context = args[0].context || self2;
      }
      data.unshift(context);
      const eventsArray = Array.isArray(events2) ? events2 : events2.split(" ");
      eventsArray.forEach((event2) => {
        if (self2.eventsAnyListeners && self2.eventsAnyListeners.length) {
          self2.eventsAnyListeners.forEach((eventHandler) => {
            eventHandler.apply(context, [event2, ...data]);
          });
        }
        if (self2.eventsListeners && self2.eventsListeners[event2]) {
          self2.eventsListeners[event2].forEach((eventHandler) => {
            eventHandler.apply(context, data);
          });
        }
      });
      return self2;
    }
  };

  // node_modules/swiper/core/update/updateSize.js
  function updateSize() {
    const swiper = this;
    let width;
    let height;
    const $el = swiper.$el;
    if (typeof swiper.params.width !== "undefined" && swiper.params.width !== null) {
      width = swiper.params.width;
    } else {
      width = $el[0].clientWidth;
    }
    if (typeof swiper.params.height !== "undefined" && swiper.params.height !== null) {
      height = swiper.params.height;
    } else {
      height = $el[0].clientHeight;
    }
    if (width === 0 && swiper.isHorizontal() || height === 0 && swiper.isVertical()) {
      return;
    }
    width = width - parseInt($el.css("padding-left") || 0, 10) - parseInt($el.css("padding-right") || 0, 10);
    height = height - parseInt($el.css("padding-top") || 0, 10) - parseInt($el.css("padding-bottom") || 0, 10);
    if (Number.isNaN(width))
      width = 0;
    if (Number.isNaN(height))
      height = 0;
    Object.assign(swiper, {
      width,
      height,
      size: swiper.isHorizontal() ? width : height
    });
  }

  // node_modules/swiper/core/update/updateSlides.js
  function updateSlides() {
    const swiper = this;
    function getDirectionLabel(property) {
      if (swiper.isHorizontal()) {
        return property;
      }
      return {
        "width": "height",
        "margin-top": "margin-left",
        "margin-bottom ": "margin-right",
        "margin-left": "margin-top",
        "margin-right": "margin-bottom",
        "padding-left": "padding-top",
        "padding-right": "padding-bottom",
        "marginRight": "marginBottom"
      }[property];
    }
    function getDirectionPropertyValue(node, label) {
      return parseFloat(node.getPropertyValue(getDirectionLabel(label)) || 0);
    }
    const params = swiper.params;
    const {
      $wrapperEl,
      size: swiperSize,
      rtlTranslate: rtl,
      wrongRTL
    } = swiper;
    const isVirtual = swiper.virtual && params.virtual.enabled;
    const previousSlidesLength = isVirtual ? swiper.virtual.slides.length : swiper.slides.length;
    const slides = $wrapperEl.children(`.${swiper.params.slideClass}`);
    const slidesLength = isVirtual ? swiper.virtual.slides.length : slides.length;
    let snapGrid = [];
    const slidesGrid = [];
    const slidesSizesGrid = [];
    let offsetBefore = params.slidesOffsetBefore;
    if (typeof offsetBefore === "function") {
      offsetBefore = params.slidesOffsetBefore.call(swiper);
    }
    let offsetAfter = params.slidesOffsetAfter;
    if (typeof offsetAfter === "function") {
      offsetAfter = params.slidesOffsetAfter.call(swiper);
    }
    const previousSnapGridLength = swiper.snapGrid.length;
    const previousSlidesGridLength = swiper.slidesGrid.length;
    let spaceBetween = params.spaceBetween;
    let slidePosition = -offsetBefore;
    let prevSlideSize = 0;
    let index2 = 0;
    if (typeof swiperSize === "undefined") {
      return;
    }
    if (typeof spaceBetween === "string" && spaceBetween.indexOf("%") >= 0) {
      spaceBetween = parseFloat(spaceBetween.replace("%", "")) / 100 * swiperSize;
    }
    swiper.virtualSize = -spaceBetween;
    if (rtl)
      slides.css({
        marginLeft: "",
        marginBottom: "",
        marginTop: ""
      });
    else
      slides.css({
        marginRight: "",
        marginBottom: "",
        marginTop: ""
      });
    if (params.centeredSlides && params.cssMode) {
      setCSSProperty(swiper.wrapperEl, "--swiper-centered-offset-before", "");
      setCSSProperty(swiper.wrapperEl, "--swiper-centered-offset-after", "");
    }
    const gridEnabled = params.grid && params.grid.rows > 1 && swiper.grid;
    if (gridEnabled) {
      swiper.grid.initSlides(slidesLength);
    }
    let slideSize;
    const shouldResetSlideSize = params.slidesPerView === "auto" && params.breakpoints && Object.keys(params.breakpoints).filter((key) => {
      return typeof params.breakpoints[key].slidesPerView !== "undefined";
    }).length > 0;
    for (let i4 = 0; i4 < slidesLength; i4 += 1) {
      slideSize = 0;
      const slide = slides.eq(i4);
      if (gridEnabled) {
        swiper.grid.updateSlide(i4, slide, slidesLength, getDirectionLabel);
      }
      if (slide.css("display") === "none")
        continue;
      if (params.slidesPerView === "auto") {
        if (shouldResetSlideSize) {
          slides[i4].style[getDirectionLabel("width")] = ``;
        }
        const slideStyles = getComputedStyle(slide[0]);
        const currentTransform = slide[0].style.transform;
        const currentWebKitTransform = slide[0].style.webkitTransform;
        if (currentTransform) {
          slide[0].style.transform = "none";
        }
        if (currentWebKitTransform) {
          slide[0].style.webkitTransform = "none";
        }
        if (params.roundLengths) {
          slideSize = swiper.isHorizontal() ? slide.outerWidth(true) : slide.outerHeight(true);
        } else {
          const width = getDirectionPropertyValue(slideStyles, "width");
          const paddingLeft = getDirectionPropertyValue(slideStyles, "padding-left");
          const paddingRight = getDirectionPropertyValue(slideStyles, "padding-right");
          const marginLeft = getDirectionPropertyValue(slideStyles, "margin-left");
          const marginRight = getDirectionPropertyValue(slideStyles, "margin-right");
          const boxSizing = slideStyles.getPropertyValue("box-sizing");
          if (boxSizing && boxSizing === "border-box") {
            slideSize = width + marginLeft + marginRight;
          } else {
            const {
              clientWidth,
              offsetWidth
            } = slide[0];
            slideSize = width + paddingLeft + paddingRight + marginLeft + marginRight + (offsetWidth - clientWidth);
          }
        }
        if (currentTransform) {
          slide[0].style.transform = currentTransform;
        }
        if (currentWebKitTransform) {
          slide[0].style.webkitTransform = currentWebKitTransform;
        }
        if (params.roundLengths)
          slideSize = Math.floor(slideSize);
      } else {
        slideSize = (swiperSize - (params.slidesPerView - 1) * spaceBetween) / params.slidesPerView;
        if (params.roundLengths)
          slideSize = Math.floor(slideSize);
        if (slides[i4]) {
          slides[i4].style[getDirectionLabel("width")] = `${slideSize}px`;
        }
      }
      if (slides[i4]) {
        slides[i4].swiperSlideSize = slideSize;
      }
      slidesSizesGrid.push(slideSize);
      if (params.centeredSlides) {
        slidePosition = slidePosition + slideSize / 2 + prevSlideSize / 2 + spaceBetween;
        if (prevSlideSize === 0 && i4 !== 0)
          slidePosition = slidePosition - swiperSize / 2 - spaceBetween;
        if (i4 === 0)
          slidePosition = slidePosition - swiperSize / 2 - spaceBetween;
        if (Math.abs(slidePosition) < 1 / 1e3)
          slidePosition = 0;
        if (params.roundLengths)
          slidePosition = Math.floor(slidePosition);
        if (index2 % params.slidesPerGroup === 0)
          snapGrid.push(slidePosition);
        slidesGrid.push(slidePosition);
      } else {
        if (params.roundLengths)
          slidePosition = Math.floor(slidePosition);
        if ((index2 - Math.min(swiper.params.slidesPerGroupSkip, index2)) % swiper.params.slidesPerGroup === 0)
          snapGrid.push(slidePosition);
        slidesGrid.push(slidePosition);
        slidePosition = slidePosition + slideSize + spaceBetween;
      }
      swiper.virtualSize += slideSize + spaceBetween;
      prevSlideSize = slideSize;
      index2 += 1;
    }
    swiper.virtualSize = Math.max(swiper.virtualSize, swiperSize) + offsetAfter;
    if (rtl && wrongRTL && (params.effect === "slide" || params.effect === "coverflow")) {
      $wrapperEl.css({
        width: `${swiper.virtualSize + params.spaceBetween}px`
      });
    }
    if (params.setWrapperSize) {
      $wrapperEl.css({
        [getDirectionLabel("width")]: `${swiper.virtualSize + params.spaceBetween}px`
      });
    }
    if (gridEnabled) {
      swiper.grid.updateWrapperSize(slideSize, snapGrid, getDirectionLabel);
    }
    if (!params.centeredSlides) {
      const newSlidesGrid = [];
      for (let i4 = 0; i4 < snapGrid.length; i4 += 1) {
        let slidesGridItem = snapGrid[i4];
        if (params.roundLengths)
          slidesGridItem = Math.floor(slidesGridItem);
        if (snapGrid[i4] <= swiper.virtualSize - swiperSize) {
          newSlidesGrid.push(slidesGridItem);
        }
      }
      snapGrid = newSlidesGrid;
      if (Math.floor(swiper.virtualSize - swiperSize) - Math.floor(snapGrid[snapGrid.length - 1]) > 1) {
        snapGrid.push(swiper.virtualSize - swiperSize);
      }
    }
    if (snapGrid.length === 0)
      snapGrid = [0];
    if (params.spaceBetween !== 0) {
      const key = swiper.isHorizontal() && rtl ? "marginLeft" : getDirectionLabel("marginRight");
      slides.filter((_2, slideIndex) => {
        if (!params.cssMode)
          return true;
        if (slideIndex === slides.length - 1) {
          return false;
        }
        return true;
      }).css({
        [key]: `${spaceBetween}px`
      });
    }
    if (params.centeredSlides && params.centeredSlidesBounds) {
      let allSlidesSize = 0;
      slidesSizesGrid.forEach((slideSizeValue) => {
        allSlidesSize += slideSizeValue + (params.spaceBetween ? params.spaceBetween : 0);
      });
      allSlidesSize -= params.spaceBetween;
      const maxSnap = allSlidesSize - swiperSize;
      snapGrid = snapGrid.map((snap) => {
        if (snap < 0)
          return -offsetBefore;
        if (snap > maxSnap)
          return maxSnap + offsetAfter;
        return snap;
      });
    }
    if (params.centerInsufficientSlides) {
      let allSlidesSize = 0;
      slidesSizesGrid.forEach((slideSizeValue) => {
        allSlidesSize += slideSizeValue + (params.spaceBetween ? params.spaceBetween : 0);
      });
      allSlidesSize -= params.spaceBetween;
      if (allSlidesSize < swiperSize) {
        const allSlidesOffset = (swiperSize - allSlidesSize) / 2;
        snapGrid.forEach((snap, snapIndex) => {
          snapGrid[snapIndex] = snap - allSlidesOffset;
        });
        slidesGrid.forEach((snap, snapIndex) => {
          slidesGrid[snapIndex] = snap + allSlidesOffset;
        });
      }
    }
    Object.assign(swiper, {
      slides,
      snapGrid,
      slidesGrid,
      slidesSizesGrid
    });
    if (params.centeredSlides && params.cssMode && !params.centeredSlidesBounds) {
      setCSSProperty(swiper.wrapperEl, "--swiper-centered-offset-before", `${-snapGrid[0]}px`);
      setCSSProperty(swiper.wrapperEl, "--swiper-centered-offset-after", `${swiper.size / 2 - slidesSizesGrid[slidesSizesGrid.length - 1] / 2}px`);
      const addToSnapGrid = -swiper.snapGrid[0];
      const addToSlidesGrid = -swiper.slidesGrid[0];
      swiper.snapGrid = swiper.snapGrid.map((v3) => v3 + addToSnapGrid);
      swiper.slidesGrid = swiper.slidesGrid.map((v3) => v3 + addToSlidesGrid);
    }
    if (slidesLength !== previousSlidesLength) {
      swiper.emit("slidesLengthChange");
    }
    if (snapGrid.length !== previousSnapGridLength) {
      if (swiper.params.watchOverflow)
        swiper.checkOverflow();
      swiper.emit("snapGridLengthChange");
    }
    if (slidesGrid.length !== previousSlidesGridLength) {
      swiper.emit("slidesGridLengthChange");
    }
    if (params.watchSlidesProgress) {
      swiper.updateSlidesOffset();
    }
    if (!isVirtual && !params.cssMode && (params.effect === "slide" || params.effect === "fade")) {
      const backFaceHiddenClass = `${params.containerModifierClass}backface-hidden`;
      const hasClassBackfaceClassAdded = swiper.$el.hasClass(backFaceHiddenClass);
      if (slidesLength <= params.maxBackfaceHiddenSlides) {
        if (!hasClassBackfaceClassAdded)
          swiper.$el.addClass(backFaceHiddenClass);
      } else if (hasClassBackfaceClassAdded) {
        swiper.$el.removeClass(backFaceHiddenClass);
      }
    }
  }

  // node_modules/swiper/core/update/updateAutoHeight.js
  function updateAutoHeight(speed) {
    const swiper = this;
    const activeSlides = [];
    const isVirtual = swiper.virtual && swiper.params.virtual.enabled;
    let newHeight = 0;
    let i4;
    if (typeof speed === "number") {
      swiper.setTransition(speed);
    } else if (speed === true) {
      swiper.setTransition(swiper.params.speed);
    }
    const getSlideByIndex = (index2) => {
      if (isVirtual) {
        return swiper.slides.filter((el) => parseInt(el.getAttribute("data-swiper-slide-index"), 10) === index2)[0];
      }
      return swiper.slides.eq(index2)[0];
    };
    if (swiper.params.slidesPerView !== "auto" && swiper.params.slidesPerView > 1) {
      if (swiper.params.centeredSlides) {
        (swiper.visibleSlides || dom_default([])).each((slide) => {
          activeSlides.push(slide);
        });
      } else {
        for (i4 = 0; i4 < Math.ceil(swiper.params.slidesPerView); i4 += 1) {
          const index2 = swiper.activeIndex + i4;
          if (index2 > swiper.slides.length && !isVirtual)
            break;
          activeSlides.push(getSlideByIndex(index2));
        }
      }
    } else {
      activeSlides.push(getSlideByIndex(swiper.activeIndex));
    }
    for (i4 = 0; i4 < activeSlides.length; i4 += 1) {
      if (typeof activeSlides[i4] !== "undefined") {
        const height = activeSlides[i4].offsetHeight;
        newHeight = height > newHeight ? height : newHeight;
      }
    }
    if (newHeight || newHeight === 0)
      swiper.$wrapperEl.css("height", `${newHeight}px`);
  }

  // node_modules/swiper/core/update/updateSlidesOffset.js
  function updateSlidesOffset() {
    const swiper = this;
    const slides = swiper.slides;
    for (let i4 = 0; i4 < slides.length; i4 += 1) {
      slides[i4].swiperSlideOffset = swiper.isHorizontal() ? slides[i4].offsetLeft : slides[i4].offsetTop;
    }
  }

  // node_modules/swiper/core/update/updateSlidesProgress.js
  function updateSlidesProgress(translate = this && this.translate || 0) {
    const swiper = this;
    const params = swiper.params;
    const {
      slides,
      rtlTranslate: rtl,
      snapGrid
    } = swiper;
    if (slides.length === 0)
      return;
    if (typeof slides[0].swiperSlideOffset === "undefined")
      swiper.updateSlidesOffset();
    let offsetCenter = -translate;
    if (rtl)
      offsetCenter = translate;
    slides.removeClass(params.slideVisibleClass);
    swiper.visibleSlidesIndexes = [];
    swiper.visibleSlides = [];
    for (let i4 = 0; i4 < slides.length; i4 += 1) {
      const slide = slides[i4];
      let slideOffset = slide.swiperSlideOffset;
      if (params.cssMode && params.centeredSlides) {
        slideOffset -= slides[0].swiperSlideOffset;
      }
      const slideProgress = (offsetCenter + (params.centeredSlides ? swiper.minTranslate() : 0) - slideOffset) / (slide.swiperSlideSize + params.spaceBetween);
      const originalSlideProgress = (offsetCenter - snapGrid[0] + (params.centeredSlides ? swiper.minTranslate() : 0) - slideOffset) / (slide.swiperSlideSize + params.spaceBetween);
      const slideBefore = -(offsetCenter - slideOffset);
      const slideAfter = slideBefore + swiper.slidesSizesGrid[i4];
      const isVisible = slideBefore >= 0 && slideBefore < swiper.size - 1 || slideAfter > 1 && slideAfter <= swiper.size || slideBefore <= 0 && slideAfter >= swiper.size;
      if (isVisible) {
        swiper.visibleSlides.push(slide);
        swiper.visibleSlidesIndexes.push(i4);
        slides.eq(i4).addClass(params.slideVisibleClass);
      }
      slide.progress = rtl ? -slideProgress : slideProgress;
      slide.originalProgress = rtl ? -originalSlideProgress : originalSlideProgress;
    }
    swiper.visibleSlides = dom_default(swiper.visibleSlides);
  }

  // node_modules/swiper/core/update/updateProgress.js
  function updateProgress(translate) {
    const swiper = this;
    if (typeof translate === "undefined") {
      const multiplier = swiper.rtlTranslate ? -1 : 1;
      translate = swiper && swiper.translate && swiper.translate * multiplier || 0;
    }
    const params = swiper.params;
    const translatesDiff = swiper.maxTranslate() - swiper.minTranslate();
    let {
      progress,
      isBeginning,
      isEnd
    } = swiper;
    const wasBeginning = isBeginning;
    const wasEnd = isEnd;
    if (translatesDiff === 0) {
      progress = 0;
      isBeginning = true;
      isEnd = true;
    } else {
      progress = (translate - swiper.minTranslate()) / translatesDiff;
      isBeginning = progress <= 0;
      isEnd = progress >= 1;
    }
    Object.assign(swiper, {
      progress,
      isBeginning,
      isEnd
    });
    if (params.watchSlidesProgress || params.centeredSlides && params.autoHeight)
      swiper.updateSlidesProgress(translate);
    if (isBeginning && !wasBeginning) {
      swiper.emit("reachBeginning toEdge");
    }
    if (isEnd && !wasEnd) {
      swiper.emit("reachEnd toEdge");
    }
    if (wasBeginning && !isBeginning || wasEnd && !isEnd) {
      swiper.emit("fromEdge");
    }
    swiper.emit("progress", progress);
  }

  // node_modules/swiper/core/update/updateSlidesClasses.js
  function updateSlidesClasses() {
    const swiper = this;
    const {
      slides,
      params,
      $wrapperEl,
      activeIndex,
      realIndex
    } = swiper;
    const isVirtual = swiper.virtual && params.virtual.enabled;
    slides.removeClass(`${params.slideActiveClass} ${params.slideNextClass} ${params.slidePrevClass} ${params.slideDuplicateActiveClass} ${params.slideDuplicateNextClass} ${params.slideDuplicatePrevClass}`);
    let activeSlide;
    if (isVirtual) {
      activeSlide = swiper.$wrapperEl.find(`.${params.slideClass}[data-swiper-slide-index="${activeIndex}"]`);
    } else {
      activeSlide = slides.eq(activeIndex);
    }
    activeSlide.addClass(params.slideActiveClass);
    if (params.loop) {
      if (activeSlide.hasClass(params.slideDuplicateClass)) {
        $wrapperEl.children(`.${params.slideClass}:not(.${params.slideDuplicateClass})[data-swiper-slide-index="${realIndex}"]`).addClass(params.slideDuplicateActiveClass);
      } else {
        $wrapperEl.children(`.${params.slideClass}.${params.slideDuplicateClass}[data-swiper-slide-index="${realIndex}"]`).addClass(params.slideDuplicateActiveClass);
      }
    }
    let nextSlide = activeSlide.nextAll(`.${params.slideClass}`).eq(0).addClass(params.slideNextClass);
    if (params.loop && nextSlide.length === 0) {
      nextSlide = slides.eq(0);
      nextSlide.addClass(params.slideNextClass);
    }
    let prevSlide = activeSlide.prevAll(`.${params.slideClass}`).eq(0).addClass(params.slidePrevClass);
    if (params.loop && prevSlide.length === 0) {
      prevSlide = slides.eq(-1);
      prevSlide.addClass(params.slidePrevClass);
    }
    if (params.loop) {
      if (nextSlide.hasClass(params.slideDuplicateClass)) {
        $wrapperEl.children(`.${params.slideClass}:not(.${params.slideDuplicateClass})[data-swiper-slide-index="${nextSlide.attr("data-swiper-slide-index")}"]`).addClass(params.slideDuplicateNextClass);
      } else {
        $wrapperEl.children(`.${params.slideClass}.${params.slideDuplicateClass}[data-swiper-slide-index="${nextSlide.attr("data-swiper-slide-index")}"]`).addClass(params.slideDuplicateNextClass);
      }
      if (prevSlide.hasClass(params.slideDuplicateClass)) {
        $wrapperEl.children(`.${params.slideClass}:not(.${params.slideDuplicateClass})[data-swiper-slide-index="${prevSlide.attr("data-swiper-slide-index")}"]`).addClass(params.slideDuplicatePrevClass);
      } else {
        $wrapperEl.children(`.${params.slideClass}.${params.slideDuplicateClass}[data-swiper-slide-index="${prevSlide.attr("data-swiper-slide-index")}"]`).addClass(params.slideDuplicatePrevClass);
      }
    }
    swiper.emitSlidesClasses();
  }

  // node_modules/swiper/core/update/updateActiveIndex.js
  function updateActiveIndex(newActiveIndex) {
    const swiper = this;
    const translate = swiper.rtlTranslate ? swiper.translate : -swiper.translate;
    const {
      slidesGrid,
      snapGrid,
      params,
      activeIndex: previousIndex,
      realIndex: previousRealIndex,
      snapIndex: previousSnapIndex
    } = swiper;
    let activeIndex = newActiveIndex;
    let snapIndex;
    if (typeof activeIndex === "undefined") {
      for (let i4 = 0; i4 < slidesGrid.length; i4 += 1) {
        if (typeof slidesGrid[i4 + 1] !== "undefined") {
          if (translate >= slidesGrid[i4] && translate < slidesGrid[i4 + 1] - (slidesGrid[i4 + 1] - slidesGrid[i4]) / 2) {
            activeIndex = i4;
          } else if (translate >= slidesGrid[i4] && translate < slidesGrid[i4 + 1]) {
            activeIndex = i4 + 1;
          }
        } else if (translate >= slidesGrid[i4]) {
          activeIndex = i4;
        }
      }
      if (params.normalizeSlideIndex) {
        if (activeIndex < 0 || typeof activeIndex === "undefined")
          activeIndex = 0;
      }
    }
    if (snapGrid.indexOf(translate) >= 0) {
      snapIndex = snapGrid.indexOf(translate);
    } else {
      const skip = Math.min(params.slidesPerGroupSkip, activeIndex);
      snapIndex = skip + Math.floor((activeIndex - skip) / params.slidesPerGroup);
    }
    if (snapIndex >= snapGrid.length)
      snapIndex = snapGrid.length - 1;
    if (activeIndex === previousIndex) {
      if (snapIndex !== previousSnapIndex) {
        swiper.snapIndex = snapIndex;
        swiper.emit("snapIndexChange");
      }
      return;
    }
    const realIndex = parseInt(swiper.slides.eq(activeIndex).attr("data-swiper-slide-index") || activeIndex, 10);
    Object.assign(swiper, {
      snapIndex,
      realIndex,
      previousIndex,
      activeIndex
    });
    swiper.emit("activeIndexChange");
    swiper.emit("snapIndexChange");
    if (previousRealIndex !== realIndex) {
      swiper.emit("realIndexChange");
    }
    if (swiper.initialized || swiper.params.runCallbacksOnInit) {
      swiper.emit("slideChange");
    }
  }

  // node_modules/swiper/core/update/updateClickedSlide.js
  function updateClickedSlide(e4) {
    const swiper = this;
    const params = swiper.params;
    const slide = dom_default(e4).closest(`.${params.slideClass}`)[0];
    let slideFound = false;
    let slideIndex;
    if (slide) {
      for (let i4 = 0; i4 < swiper.slides.length; i4 += 1) {
        if (swiper.slides[i4] === slide) {
          slideFound = true;
          slideIndex = i4;
          break;
        }
      }
    }
    if (slide && slideFound) {
      swiper.clickedSlide = slide;
      if (swiper.virtual && swiper.params.virtual.enabled) {
        swiper.clickedIndex = parseInt(dom_default(slide).attr("data-swiper-slide-index"), 10);
      } else {
        swiper.clickedIndex = slideIndex;
      }
    } else {
      swiper.clickedSlide = void 0;
      swiper.clickedIndex = void 0;
      return;
    }
    if (params.slideToClickedSlide && swiper.clickedIndex !== void 0 && swiper.clickedIndex !== swiper.activeIndex) {
      swiper.slideToClickedSlide();
    }
  }

  // node_modules/swiper/core/update/index.js
  var update_default = {
    updateSize,
    updateSlides,
    updateAutoHeight,
    updateSlidesOffset,
    updateSlidesProgress,
    updateProgress,
    updateSlidesClasses,
    updateActiveIndex,
    updateClickedSlide
  };

  // node_modules/swiper/core/translate/getTranslate.js
  function getSwiperTranslate(axis = this.isHorizontal() ? "x" : "y") {
    const swiper = this;
    const {
      params,
      rtlTranslate: rtl,
      translate,
      $wrapperEl
    } = swiper;
    if (params.virtualTranslate) {
      return rtl ? -translate : translate;
    }
    if (params.cssMode) {
      return translate;
    }
    let currentTranslate = getTranslate($wrapperEl[0], axis);
    if (rtl)
      currentTranslate = -currentTranslate;
    return currentTranslate || 0;
  }

  // node_modules/swiper/core/translate/setTranslate.js
  function setTranslate(translate, byController) {
    const swiper = this;
    const {
      rtlTranslate: rtl,
      params,
      $wrapperEl,
      wrapperEl,
      progress
    } = swiper;
    let x3 = 0;
    let y3 = 0;
    const z3 = 0;
    if (swiper.isHorizontal()) {
      x3 = rtl ? -translate : translate;
    } else {
      y3 = translate;
    }
    if (params.roundLengths) {
      x3 = Math.floor(x3);
      y3 = Math.floor(y3);
    }
    if (params.cssMode) {
      wrapperEl[swiper.isHorizontal() ? "scrollLeft" : "scrollTop"] = swiper.isHorizontal() ? -x3 : -y3;
    } else if (!params.virtualTranslate) {
      $wrapperEl.transform(`translate3d(${x3}px, ${y3}px, ${z3}px)`);
    }
    swiper.previousTranslate = swiper.translate;
    swiper.translate = swiper.isHorizontal() ? x3 : y3;
    let newProgress;
    const translatesDiff = swiper.maxTranslate() - swiper.minTranslate();
    if (translatesDiff === 0) {
      newProgress = 0;
    } else {
      newProgress = (translate - swiper.minTranslate()) / translatesDiff;
    }
    if (newProgress !== progress) {
      swiper.updateProgress(translate);
    }
    swiper.emit("setTranslate", swiper.translate, byController);
  }

  // node_modules/swiper/core/translate/minTranslate.js
  function minTranslate() {
    return -this.snapGrid[0];
  }

  // node_modules/swiper/core/translate/maxTranslate.js
  function maxTranslate() {
    return -this.snapGrid[this.snapGrid.length - 1];
  }

  // node_modules/swiper/core/translate/translateTo.js
  function translateTo(translate = 0, speed = this.params.speed, runCallbacks = true, translateBounds = true, internal) {
    const swiper = this;
    const {
      params,
      wrapperEl
    } = swiper;
    if (swiper.animating && params.preventInteractionOnTransition) {
      return false;
    }
    const minTranslate2 = swiper.minTranslate();
    const maxTranslate2 = swiper.maxTranslate();
    let newTranslate;
    if (translateBounds && translate > minTranslate2)
      newTranslate = minTranslate2;
    else if (translateBounds && translate < maxTranslate2)
      newTranslate = maxTranslate2;
    else
      newTranslate = translate;
    swiper.updateProgress(newTranslate);
    if (params.cssMode) {
      const isH = swiper.isHorizontal();
      if (speed === 0) {
        wrapperEl[isH ? "scrollLeft" : "scrollTop"] = -newTranslate;
      } else {
        if (!swiper.support.smoothScroll) {
          animateCSSModeScroll({
            swiper,
            targetPosition: -newTranslate,
            side: isH ? "left" : "top"
          });
          return true;
        }
        wrapperEl.scrollTo({
          [isH ? "left" : "top"]: -newTranslate,
          behavior: "smooth"
        });
      }
      return true;
    }
    if (speed === 0) {
      swiper.setTransition(0);
      swiper.setTranslate(newTranslate);
      if (runCallbacks) {
        swiper.emit("beforeTransitionStart", speed, internal);
        swiper.emit("transitionEnd");
      }
    } else {
      swiper.setTransition(speed);
      swiper.setTranslate(newTranslate);
      if (runCallbacks) {
        swiper.emit("beforeTransitionStart", speed, internal);
        swiper.emit("transitionStart");
      }
      if (!swiper.animating) {
        swiper.animating = true;
        if (!swiper.onTranslateToWrapperTransitionEnd) {
          swiper.onTranslateToWrapperTransitionEnd = function transitionEnd3(e4) {
            if (!swiper || swiper.destroyed)
              return;
            if (e4.target !== this)
              return;
            swiper.$wrapperEl[0].removeEventListener("transitionend", swiper.onTranslateToWrapperTransitionEnd);
            swiper.$wrapperEl[0].removeEventListener("webkitTransitionEnd", swiper.onTranslateToWrapperTransitionEnd);
            swiper.onTranslateToWrapperTransitionEnd = null;
            delete swiper.onTranslateToWrapperTransitionEnd;
            if (runCallbacks) {
              swiper.emit("transitionEnd");
            }
          };
        }
        swiper.$wrapperEl[0].addEventListener("transitionend", swiper.onTranslateToWrapperTransitionEnd);
        swiper.$wrapperEl[0].addEventListener("webkitTransitionEnd", swiper.onTranslateToWrapperTransitionEnd);
      }
    }
    return true;
  }

  // node_modules/swiper/core/translate/index.js
  var translate_default = {
    getTranslate: getSwiperTranslate,
    setTranslate,
    minTranslate,
    maxTranslate,
    translateTo
  };

  // node_modules/swiper/core/transition/setTransition.js
  function setTransition(duration, byController) {
    const swiper = this;
    if (!swiper.params.cssMode) {
      swiper.$wrapperEl.transition(duration);
    }
    swiper.emit("setTransition", duration, byController);
  }

  // node_modules/swiper/core/transition/transitionEmit.js
  function transitionEmit({
    swiper,
    runCallbacks,
    direction,
    step
  }) {
    const {
      activeIndex,
      previousIndex
    } = swiper;
    let dir = direction;
    if (!dir) {
      if (activeIndex > previousIndex)
        dir = "next";
      else if (activeIndex < previousIndex)
        dir = "prev";
      else
        dir = "reset";
    }
    swiper.emit(`transition${step}`);
    if (runCallbacks && activeIndex !== previousIndex) {
      if (dir === "reset") {
        swiper.emit(`slideResetTransition${step}`);
        return;
      }
      swiper.emit(`slideChangeTransition${step}`);
      if (dir === "next") {
        swiper.emit(`slideNextTransition${step}`);
      } else {
        swiper.emit(`slidePrevTransition${step}`);
      }
    }
  }

  // node_modules/swiper/core/transition/transitionStart.js
  function transitionStart(runCallbacks = true, direction) {
    const swiper = this;
    const {
      params
    } = swiper;
    if (params.cssMode)
      return;
    if (params.autoHeight) {
      swiper.updateAutoHeight();
    }
    transitionEmit({
      swiper,
      runCallbacks,
      direction,
      step: "Start"
    });
  }

  // node_modules/swiper/core/transition/transitionEnd.js
  function transitionEnd2(runCallbacks = true, direction) {
    const swiper = this;
    const {
      params
    } = swiper;
    swiper.animating = false;
    if (params.cssMode)
      return;
    swiper.setTransition(0);
    transitionEmit({
      swiper,
      runCallbacks,
      direction,
      step: "End"
    });
  }

  // node_modules/swiper/core/transition/index.js
  var transition_default = {
    setTransition,
    transitionStart,
    transitionEnd: transitionEnd2
  };

  // node_modules/swiper/core/slide/slideTo.js
  function slideTo(index2 = 0, speed = this.params.speed, runCallbacks = true, internal, initial) {
    if (typeof index2 !== "number" && typeof index2 !== "string") {
      throw new Error(`The 'index' argument cannot have type other than 'number' or 'string'. [${typeof index2}] given.`);
    }
    if (typeof index2 === "string") {
      const indexAsNumber = parseInt(index2, 10);
      const isValidNumber = isFinite(indexAsNumber);
      if (!isValidNumber) {
        throw new Error(`The passed-in 'index' (string) couldn't be converted to 'number'. [${index2}] given.`);
      }
      index2 = indexAsNumber;
    }
    const swiper = this;
    let slideIndex = index2;
    if (slideIndex < 0)
      slideIndex = 0;
    const {
      params,
      snapGrid,
      slidesGrid,
      previousIndex,
      activeIndex,
      rtlTranslate: rtl,
      wrapperEl,
      enabled
    } = swiper;
    if (swiper.animating && params.preventInteractionOnTransition || !enabled && !internal && !initial) {
      return false;
    }
    const skip = Math.min(swiper.params.slidesPerGroupSkip, slideIndex);
    let snapIndex = skip + Math.floor((slideIndex - skip) / swiper.params.slidesPerGroup);
    if (snapIndex >= snapGrid.length)
      snapIndex = snapGrid.length - 1;
    const translate = -snapGrid[snapIndex];
    if (params.normalizeSlideIndex) {
      for (let i4 = 0; i4 < slidesGrid.length; i4 += 1) {
        const normalizedTranslate = -Math.floor(translate * 100);
        const normalizedGrid = Math.floor(slidesGrid[i4] * 100);
        const normalizedGridNext = Math.floor(slidesGrid[i4 + 1] * 100);
        if (typeof slidesGrid[i4 + 1] !== "undefined") {
          if (normalizedTranslate >= normalizedGrid && normalizedTranslate < normalizedGridNext - (normalizedGridNext - normalizedGrid) / 2) {
            slideIndex = i4;
          } else if (normalizedTranslate >= normalizedGrid && normalizedTranslate < normalizedGridNext) {
            slideIndex = i4 + 1;
          }
        } else if (normalizedTranslate >= normalizedGrid) {
          slideIndex = i4;
        }
      }
    }
    if (swiper.initialized && slideIndex !== activeIndex) {
      if (!swiper.allowSlideNext && translate < swiper.translate && translate < swiper.minTranslate()) {
        return false;
      }
      if (!swiper.allowSlidePrev && translate > swiper.translate && translate > swiper.maxTranslate()) {
        if ((activeIndex || 0) !== slideIndex)
          return false;
      }
    }
    if (slideIndex !== (previousIndex || 0) && runCallbacks) {
      swiper.emit("beforeSlideChangeStart");
    }
    swiper.updateProgress(translate);
    let direction;
    if (slideIndex > activeIndex)
      direction = "next";
    else if (slideIndex < activeIndex)
      direction = "prev";
    else
      direction = "reset";
    if (rtl && -translate === swiper.translate || !rtl && translate === swiper.translate) {
      swiper.updateActiveIndex(slideIndex);
      if (params.autoHeight) {
        swiper.updateAutoHeight();
      }
      swiper.updateSlidesClasses();
      if (params.effect !== "slide") {
        swiper.setTranslate(translate);
      }
      if (direction !== "reset") {
        swiper.transitionStart(runCallbacks, direction);
        swiper.transitionEnd(runCallbacks, direction);
      }
      return false;
    }
    if (params.cssMode) {
      const isH = swiper.isHorizontal();
      const t4 = rtl ? translate : -translate;
      if (speed === 0) {
        const isVirtual = swiper.virtual && swiper.params.virtual.enabled;
        if (isVirtual) {
          swiper.wrapperEl.style.scrollSnapType = "none";
          swiper._immediateVirtual = true;
        }
        wrapperEl[isH ? "scrollLeft" : "scrollTop"] = t4;
        if (isVirtual) {
          requestAnimationFrame(() => {
            swiper.wrapperEl.style.scrollSnapType = "";
            swiper._swiperImmediateVirtual = false;
          });
        }
      } else {
        if (!swiper.support.smoothScroll) {
          animateCSSModeScroll({
            swiper,
            targetPosition: t4,
            side: isH ? "left" : "top"
          });
          return true;
        }
        wrapperEl.scrollTo({
          [isH ? "left" : "top"]: t4,
          behavior: "smooth"
        });
      }
      return true;
    }
    swiper.setTransition(speed);
    swiper.setTranslate(translate);
    swiper.updateActiveIndex(slideIndex);
    swiper.updateSlidesClasses();
    swiper.emit("beforeTransitionStart", speed, internal);
    swiper.transitionStart(runCallbacks, direction);
    if (speed === 0) {
      swiper.transitionEnd(runCallbacks, direction);
    } else if (!swiper.animating) {
      swiper.animating = true;
      if (!swiper.onSlideToWrapperTransitionEnd) {
        swiper.onSlideToWrapperTransitionEnd = function transitionEnd3(e4) {
          if (!swiper || swiper.destroyed)
            return;
          if (e4.target !== this)
            return;
          swiper.$wrapperEl[0].removeEventListener("transitionend", swiper.onSlideToWrapperTransitionEnd);
          swiper.$wrapperEl[0].removeEventListener("webkitTransitionEnd", swiper.onSlideToWrapperTransitionEnd);
          swiper.onSlideToWrapperTransitionEnd = null;
          delete swiper.onSlideToWrapperTransitionEnd;
          swiper.transitionEnd(runCallbacks, direction);
        };
      }
      swiper.$wrapperEl[0].addEventListener("transitionend", swiper.onSlideToWrapperTransitionEnd);
      swiper.$wrapperEl[0].addEventListener("webkitTransitionEnd", swiper.onSlideToWrapperTransitionEnd);
    }
    return true;
  }

  // node_modules/swiper/core/slide/slideToLoop.js
  function slideToLoop(index2 = 0, speed = this.params.speed, runCallbacks = true, internal) {
    if (typeof index2 === "string") {
      const indexAsNumber = parseInt(index2, 10);
      const isValidNumber = isFinite(indexAsNumber);
      if (!isValidNumber) {
        throw new Error(`The passed-in 'index' (string) couldn't be converted to 'number'. [${index2}] given.`);
      }
      index2 = indexAsNumber;
    }
    const swiper = this;
    let newIndex = index2;
    if (swiper.params.loop) {
      newIndex += swiper.loopedSlides;
    }
    return swiper.slideTo(newIndex, speed, runCallbacks, internal);
  }

  // node_modules/swiper/core/slide/slideNext.js
  function slideNext(speed = this.params.speed, runCallbacks = true, internal) {
    const swiper = this;
    const {
      animating,
      enabled,
      params
    } = swiper;
    if (!enabled)
      return swiper;
    let perGroup = params.slidesPerGroup;
    if (params.slidesPerView === "auto" && params.slidesPerGroup === 1 && params.slidesPerGroupAuto) {
      perGroup = Math.max(swiper.slidesPerViewDynamic("current", true), 1);
    }
    const increment = swiper.activeIndex < params.slidesPerGroupSkip ? 1 : perGroup;
    if (params.loop) {
      if (animating && params.loopPreventsSlide)
        return false;
      swiper.loopFix();
      swiper._clientLeft = swiper.$wrapperEl[0].clientLeft;
    }
    if (params.rewind && swiper.isEnd) {
      return swiper.slideTo(0, speed, runCallbacks, internal);
    }
    return swiper.slideTo(swiper.activeIndex + increment, speed, runCallbacks, internal);
  }

  // node_modules/swiper/core/slide/slidePrev.js
  function slidePrev(speed = this.params.speed, runCallbacks = true, internal) {
    const swiper = this;
    const {
      params,
      animating,
      snapGrid,
      slidesGrid,
      rtlTranslate,
      enabled
    } = swiper;
    if (!enabled)
      return swiper;
    if (params.loop) {
      if (animating && params.loopPreventsSlide)
        return false;
      swiper.loopFix();
      swiper._clientLeft = swiper.$wrapperEl[0].clientLeft;
    }
    const translate = rtlTranslate ? swiper.translate : -swiper.translate;
    function normalize(val) {
      if (val < 0)
        return -Math.floor(Math.abs(val));
      return Math.floor(val);
    }
    const normalizedTranslate = normalize(translate);
    const normalizedSnapGrid = snapGrid.map((val) => normalize(val));
    let prevSnap = snapGrid[normalizedSnapGrid.indexOf(normalizedTranslate) - 1];
    if (typeof prevSnap === "undefined" && params.cssMode) {
      let prevSnapIndex;
      snapGrid.forEach((snap, snapIndex) => {
        if (normalizedTranslate >= snap) {
          prevSnapIndex = snapIndex;
        }
      });
      if (typeof prevSnapIndex !== "undefined") {
        prevSnap = snapGrid[prevSnapIndex > 0 ? prevSnapIndex - 1 : prevSnapIndex];
      }
    }
    let prevIndex = 0;
    if (typeof prevSnap !== "undefined") {
      prevIndex = slidesGrid.indexOf(prevSnap);
      if (prevIndex < 0)
        prevIndex = swiper.activeIndex - 1;
      if (params.slidesPerView === "auto" && params.slidesPerGroup === 1 && params.slidesPerGroupAuto) {
        prevIndex = prevIndex - swiper.slidesPerViewDynamic("previous", true) + 1;
        prevIndex = Math.max(prevIndex, 0);
      }
    }
    if (params.rewind && swiper.isBeginning) {
      const lastIndex = swiper.params.virtual && swiper.params.virtual.enabled && swiper.virtual ? swiper.virtual.slides.length - 1 : swiper.slides.length - 1;
      return swiper.slideTo(lastIndex, speed, runCallbacks, internal);
    }
    return swiper.slideTo(prevIndex, speed, runCallbacks, internal);
  }

  // node_modules/swiper/core/slide/slideReset.js
  function slideReset(speed = this.params.speed, runCallbacks = true, internal) {
    const swiper = this;
    return swiper.slideTo(swiper.activeIndex, speed, runCallbacks, internal);
  }

  // node_modules/swiper/core/slide/slideToClosest.js
  function slideToClosest(speed = this.params.speed, runCallbacks = true, internal, threshold = 0.5) {
    const swiper = this;
    let index2 = swiper.activeIndex;
    const skip = Math.min(swiper.params.slidesPerGroupSkip, index2);
    const snapIndex = skip + Math.floor((index2 - skip) / swiper.params.slidesPerGroup);
    const translate = swiper.rtlTranslate ? swiper.translate : -swiper.translate;
    if (translate >= swiper.snapGrid[snapIndex]) {
      const currentSnap = swiper.snapGrid[snapIndex];
      const nextSnap = swiper.snapGrid[snapIndex + 1];
      if (translate - currentSnap > (nextSnap - currentSnap) * threshold) {
        index2 += swiper.params.slidesPerGroup;
      }
    } else {
      const prevSnap = swiper.snapGrid[snapIndex - 1];
      const currentSnap = swiper.snapGrid[snapIndex];
      if (translate - prevSnap <= (currentSnap - prevSnap) * threshold) {
        index2 -= swiper.params.slidesPerGroup;
      }
    }
    index2 = Math.max(index2, 0);
    index2 = Math.min(index2, swiper.slidesGrid.length - 1);
    return swiper.slideTo(index2, speed, runCallbacks, internal);
  }

  // node_modules/swiper/core/slide/slideToClickedSlide.js
  function slideToClickedSlide() {
    const swiper = this;
    const {
      params,
      $wrapperEl
    } = swiper;
    const slidesPerView = params.slidesPerView === "auto" ? swiper.slidesPerViewDynamic() : params.slidesPerView;
    let slideToIndex = swiper.clickedIndex;
    let realIndex;
    if (params.loop) {
      if (swiper.animating)
        return;
      realIndex = parseInt(dom_default(swiper.clickedSlide).attr("data-swiper-slide-index"), 10);
      if (params.centeredSlides) {
        if (slideToIndex < swiper.loopedSlides - slidesPerView / 2 || slideToIndex > swiper.slides.length - swiper.loopedSlides + slidesPerView / 2) {
          swiper.loopFix();
          slideToIndex = $wrapperEl.children(`.${params.slideClass}[data-swiper-slide-index="${realIndex}"]:not(.${params.slideDuplicateClass})`).eq(0).index();
          nextTick(() => {
            swiper.slideTo(slideToIndex);
          });
        } else {
          swiper.slideTo(slideToIndex);
        }
      } else if (slideToIndex > swiper.slides.length - slidesPerView) {
        swiper.loopFix();
        slideToIndex = $wrapperEl.children(`.${params.slideClass}[data-swiper-slide-index="${realIndex}"]:not(.${params.slideDuplicateClass})`).eq(0).index();
        nextTick(() => {
          swiper.slideTo(slideToIndex);
        });
      } else {
        swiper.slideTo(slideToIndex);
      }
    } else {
      swiper.slideTo(slideToIndex);
    }
  }

  // node_modules/swiper/core/slide/index.js
  var slide_default = {
    slideTo,
    slideToLoop,
    slideNext,
    slidePrev,
    slideReset,
    slideToClosest,
    slideToClickedSlide
  };

  // node_modules/swiper/core/loop/loopCreate.js
  function loopCreate() {
    const swiper = this;
    const document2 = getDocument();
    const {
      params,
      $wrapperEl
    } = swiper;
    const $selector = $wrapperEl.children().length > 0 ? dom_default($wrapperEl.children()[0].parentNode) : $wrapperEl;
    $selector.children(`.${params.slideClass}.${params.slideDuplicateClass}`).remove();
    let slides = $selector.children(`.${params.slideClass}`);
    if (params.loopFillGroupWithBlank) {
      const blankSlidesNum = params.slidesPerGroup - slides.length % params.slidesPerGroup;
      if (blankSlidesNum !== params.slidesPerGroup) {
        for (let i4 = 0; i4 < blankSlidesNum; i4 += 1) {
          const blankNode = dom_default(document2.createElement("div")).addClass(`${params.slideClass} ${params.slideBlankClass}`);
          $selector.append(blankNode);
        }
        slides = $selector.children(`.${params.slideClass}`);
      }
    }
    if (params.slidesPerView === "auto" && !params.loopedSlides)
      params.loopedSlides = slides.length;
    swiper.loopedSlides = Math.ceil(parseFloat(params.loopedSlides || params.slidesPerView, 10));
    swiper.loopedSlides += params.loopAdditionalSlides;
    if (swiper.loopedSlides > slides.length && swiper.params.loopedSlidesLimit) {
      swiper.loopedSlides = slides.length;
    }
    const prependSlides = [];
    const appendSlides = [];
    slides.each((el, index2) => {
      const slide = dom_default(el);
      slide.attr("data-swiper-slide-index", index2);
    });
    for (let i4 = 0; i4 < swiper.loopedSlides; i4 += 1) {
      const index2 = i4 - Math.floor(i4 / slides.length) * slides.length;
      appendSlides.push(slides.eq(index2)[0]);
      prependSlides.unshift(slides.eq(slides.length - index2 - 1)[0]);
    }
    for (let i4 = 0; i4 < appendSlides.length; i4 += 1) {
      $selector.append(dom_default(appendSlides[i4].cloneNode(true)).addClass(params.slideDuplicateClass));
    }
    for (let i4 = prependSlides.length - 1; i4 >= 0; i4 -= 1) {
      $selector.prepend(dom_default(prependSlides[i4].cloneNode(true)).addClass(params.slideDuplicateClass));
    }
  }

  // node_modules/swiper/core/loop/loopFix.js
  function loopFix() {
    const swiper = this;
    swiper.emit("beforeLoopFix");
    const {
      activeIndex,
      slides,
      loopedSlides,
      allowSlidePrev,
      allowSlideNext,
      snapGrid,
      rtlTranslate: rtl
    } = swiper;
    let newIndex;
    swiper.allowSlidePrev = true;
    swiper.allowSlideNext = true;
    const snapTranslate = -snapGrid[activeIndex];
    const diff = snapTranslate - swiper.getTranslate();
    if (activeIndex < loopedSlides) {
      newIndex = slides.length - loopedSlides * 3 + activeIndex;
      newIndex += loopedSlides;
      const slideChanged = swiper.slideTo(newIndex, 0, false, true);
      if (slideChanged && diff !== 0) {
        swiper.setTranslate((rtl ? -swiper.translate : swiper.translate) - diff);
      }
    } else if (activeIndex >= slides.length - loopedSlides) {
      newIndex = -slides.length + activeIndex + loopedSlides;
      newIndex += loopedSlides;
      const slideChanged = swiper.slideTo(newIndex, 0, false, true);
      if (slideChanged && diff !== 0) {
        swiper.setTranslate((rtl ? -swiper.translate : swiper.translate) - diff);
      }
    }
    swiper.allowSlidePrev = allowSlidePrev;
    swiper.allowSlideNext = allowSlideNext;
    swiper.emit("loopFix");
  }

  // node_modules/swiper/core/loop/loopDestroy.js
  function loopDestroy() {
    const swiper = this;
    const {
      $wrapperEl,
      params,
      slides
    } = swiper;
    $wrapperEl.children(`.${params.slideClass}.${params.slideDuplicateClass},.${params.slideClass}.${params.slideBlankClass}`).remove();
    slides.removeAttr("data-swiper-slide-index");
  }

  // node_modules/swiper/core/loop/index.js
  var loop_default = {
    loopCreate,
    loopFix,
    loopDestroy
  };

  // node_modules/swiper/core/grab-cursor/setGrabCursor.js
  function setGrabCursor(moving) {
    const swiper = this;
    if (swiper.support.touch || !swiper.params.simulateTouch || swiper.params.watchOverflow && swiper.isLocked || swiper.params.cssMode)
      return;
    const el = swiper.params.touchEventsTarget === "container" ? swiper.el : swiper.wrapperEl;
    el.style.cursor = "move";
    el.style.cursor = moving ? "grabbing" : "grab";
  }

  // node_modules/swiper/core/grab-cursor/unsetGrabCursor.js
  function unsetGrabCursor() {
    const swiper = this;
    if (swiper.support.touch || swiper.params.watchOverflow && swiper.isLocked || swiper.params.cssMode) {
      return;
    }
    swiper[swiper.params.touchEventsTarget === "container" ? "el" : "wrapperEl"].style.cursor = "";
  }

  // node_modules/swiper/core/grab-cursor/index.js
  var grab_cursor_default = {
    setGrabCursor,
    unsetGrabCursor
  };

  // node_modules/swiper/core/events/onTouchStart.js
  function closestElement(selector, base = this) {
    function __closestFrom(el) {
      if (!el || el === getDocument() || el === getWindow())
        return null;
      if (el.assignedSlot)
        el = el.assignedSlot;
      const found = el.closest(selector);
      if (!found && !el.getRootNode) {
        return null;
      }
      return found || __closestFrom(el.getRootNode().host);
    }
    return __closestFrom(base);
  }
  function onTouchStart(event2) {
    const swiper = this;
    const document2 = getDocument();
    const window2 = getWindow();
    const data = swiper.touchEventsData;
    const {
      params,
      touches,
      enabled
    } = swiper;
    if (!enabled)
      return;
    if (swiper.animating && params.preventInteractionOnTransition) {
      return;
    }
    if (!swiper.animating && params.cssMode && params.loop) {
      swiper.loopFix();
    }
    let e4 = event2;
    if (e4.originalEvent)
      e4 = e4.originalEvent;
    let $targetEl = dom_default(e4.target);
    if (params.touchEventsTarget === "wrapper") {
      if (!$targetEl.closest(swiper.wrapperEl).length)
        return;
    }
    data.isTouchEvent = e4.type === "touchstart";
    if (!data.isTouchEvent && "which" in e4 && e4.which === 3)
      return;
    if (!data.isTouchEvent && "button" in e4 && e4.button > 0)
      return;
    if (data.isTouched && data.isMoved)
      return;
    const swipingClassHasValue = !!params.noSwipingClass && params.noSwipingClass !== "";
    const eventPath = event2.composedPath ? event2.composedPath() : event2.path;
    if (swipingClassHasValue && e4.target && e4.target.shadowRoot && eventPath) {
      $targetEl = dom_default(eventPath[0]);
    }
    const noSwipingSelector = params.noSwipingSelector ? params.noSwipingSelector : `.${params.noSwipingClass}`;
    const isTargetShadow = !!(e4.target && e4.target.shadowRoot);
    if (params.noSwiping && (isTargetShadow ? closestElement(noSwipingSelector, $targetEl[0]) : $targetEl.closest(noSwipingSelector)[0])) {
      swiper.allowClick = true;
      return;
    }
    if (params.swipeHandler) {
      if (!$targetEl.closest(params.swipeHandler)[0])
        return;
    }
    touches.currentX = e4.type === "touchstart" ? e4.targetTouches[0].pageX : e4.pageX;
    touches.currentY = e4.type === "touchstart" ? e4.targetTouches[0].pageY : e4.pageY;
    const startX = touches.currentX;
    const startY = touches.currentY;
    const edgeSwipeDetection = params.edgeSwipeDetection || params.iOSEdgeSwipeDetection;
    const edgeSwipeThreshold = params.edgeSwipeThreshold || params.iOSEdgeSwipeThreshold;
    if (edgeSwipeDetection && (startX <= edgeSwipeThreshold || startX >= window2.innerWidth - edgeSwipeThreshold)) {
      if (edgeSwipeDetection === "prevent") {
        event2.preventDefault();
      } else {
        return;
      }
    }
    Object.assign(data, {
      isTouched: true,
      isMoved: false,
      allowTouchCallbacks: true,
      isScrolling: void 0,
      startMoving: void 0
    });
    touches.startX = startX;
    touches.startY = startY;
    data.touchStartTime = now();
    swiper.allowClick = true;
    swiper.updateSize();
    swiper.swipeDirection = void 0;
    if (params.threshold > 0)
      data.allowThresholdMove = false;
    if (e4.type !== "touchstart") {
      let preventDefault = true;
      if ($targetEl.is(data.focusableElements)) {
        preventDefault = false;
        if ($targetEl[0].nodeName === "SELECT") {
          data.isTouched = false;
        }
      }
      if (document2.activeElement && dom_default(document2.activeElement).is(data.focusableElements) && document2.activeElement !== $targetEl[0]) {
        document2.activeElement.blur();
      }
      const shouldPreventDefault = preventDefault && swiper.allowTouchMove && params.touchStartPreventDefault;
      if ((params.touchStartForcePreventDefault || shouldPreventDefault) && !$targetEl[0].isContentEditable) {
        e4.preventDefault();
      }
    }
    if (swiper.params.freeMode && swiper.params.freeMode.enabled && swiper.freeMode && swiper.animating && !params.cssMode) {
      swiper.freeMode.onTouchStart();
    }
    swiper.emit("touchStart", e4);
  }

  // node_modules/swiper/core/events/onTouchMove.js
  function onTouchMove(event2) {
    const document2 = getDocument();
    const swiper = this;
    const data = swiper.touchEventsData;
    const {
      params,
      touches,
      rtlTranslate: rtl,
      enabled
    } = swiper;
    if (!enabled)
      return;
    let e4 = event2;
    if (e4.originalEvent)
      e4 = e4.originalEvent;
    if (!data.isTouched) {
      if (data.startMoving && data.isScrolling) {
        swiper.emit("touchMoveOpposite", e4);
      }
      return;
    }
    if (data.isTouchEvent && e4.type !== "touchmove")
      return;
    const targetTouch = e4.type === "touchmove" && e4.targetTouches && (e4.targetTouches[0] || e4.changedTouches[0]);
    const pageX = e4.type === "touchmove" ? targetTouch.pageX : e4.pageX;
    const pageY = e4.type === "touchmove" ? targetTouch.pageY : e4.pageY;
    if (e4.preventedByNestedSwiper) {
      touches.startX = pageX;
      touches.startY = pageY;
      return;
    }
    if (!swiper.allowTouchMove) {
      if (!dom_default(e4.target).is(data.focusableElements)) {
        swiper.allowClick = false;
      }
      if (data.isTouched) {
        Object.assign(touches, {
          startX: pageX,
          startY: pageY,
          currentX: pageX,
          currentY: pageY
        });
        data.touchStartTime = now();
      }
      return;
    }
    if (data.isTouchEvent && params.touchReleaseOnEdges && !params.loop) {
      if (swiper.isVertical()) {
        if (pageY < touches.startY && swiper.translate <= swiper.maxTranslate() || pageY > touches.startY && swiper.translate >= swiper.minTranslate()) {
          data.isTouched = false;
          data.isMoved = false;
          return;
        }
      } else if (pageX < touches.startX && swiper.translate <= swiper.maxTranslate() || pageX > touches.startX && swiper.translate >= swiper.minTranslate()) {
        return;
      }
    }
    if (data.isTouchEvent && document2.activeElement) {
      if (e4.target === document2.activeElement && dom_default(e4.target).is(data.focusableElements)) {
        data.isMoved = true;
        swiper.allowClick = false;
        return;
      }
    }
    if (data.allowTouchCallbacks) {
      swiper.emit("touchMove", e4);
    }
    if (e4.targetTouches && e4.targetTouches.length > 1)
      return;
    touches.currentX = pageX;
    touches.currentY = pageY;
    const diffX = touches.currentX - touches.startX;
    const diffY = touches.currentY - touches.startY;
    if (swiper.params.threshold && Math.sqrt(diffX ** 2 + diffY ** 2) < swiper.params.threshold)
      return;
    if (typeof data.isScrolling === "undefined") {
      let touchAngle;
      if (swiper.isHorizontal() && touches.currentY === touches.startY || swiper.isVertical() && touches.currentX === touches.startX) {
        data.isScrolling = false;
      } else {
        if (diffX * diffX + diffY * diffY >= 25) {
          touchAngle = Math.atan2(Math.abs(diffY), Math.abs(diffX)) * 180 / Math.PI;
          data.isScrolling = swiper.isHorizontal() ? touchAngle > params.touchAngle : 90 - touchAngle > params.touchAngle;
        }
      }
    }
    if (data.isScrolling) {
      swiper.emit("touchMoveOpposite", e4);
    }
    if (typeof data.startMoving === "undefined") {
      if (touches.currentX !== touches.startX || touches.currentY !== touches.startY) {
        data.startMoving = true;
      }
    }
    if (data.isScrolling) {
      data.isTouched = false;
      return;
    }
    if (!data.startMoving) {
      return;
    }
    swiper.allowClick = false;
    if (!params.cssMode && e4.cancelable) {
      e4.preventDefault();
    }
    if (params.touchMoveStopPropagation && !params.nested) {
      e4.stopPropagation();
    }
    if (!data.isMoved) {
      if (params.loop && !params.cssMode) {
        swiper.loopFix();
      }
      data.startTranslate = swiper.getTranslate();
      swiper.setTransition(0);
      if (swiper.animating) {
        swiper.$wrapperEl.trigger("webkitTransitionEnd transitionend");
      }
      data.allowMomentumBounce = false;
      if (params.grabCursor && (swiper.allowSlideNext === true || swiper.allowSlidePrev === true)) {
        swiper.setGrabCursor(true);
      }
      swiper.emit("sliderFirstMove", e4);
    }
    swiper.emit("sliderMove", e4);
    data.isMoved = true;
    let diff = swiper.isHorizontal() ? diffX : diffY;
    touches.diff = diff;
    diff *= params.touchRatio;
    if (rtl)
      diff = -diff;
    swiper.swipeDirection = diff > 0 ? "prev" : "next";
    data.currentTranslate = diff + data.startTranslate;
    let disableParentSwiper = true;
    let resistanceRatio = params.resistanceRatio;
    if (params.touchReleaseOnEdges) {
      resistanceRatio = 0;
    }
    if (diff > 0 && data.currentTranslate > swiper.minTranslate()) {
      disableParentSwiper = false;
      if (params.resistance)
        data.currentTranslate = swiper.minTranslate() - 1 + (-swiper.minTranslate() + data.startTranslate + diff) ** resistanceRatio;
    } else if (diff < 0 && data.currentTranslate < swiper.maxTranslate()) {
      disableParentSwiper = false;
      if (params.resistance)
        data.currentTranslate = swiper.maxTranslate() + 1 - (swiper.maxTranslate() - data.startTranslate - diff) ** resistanceRatio;
    }
    if (disableParentSwiper) {
      e4.preventedByNestedSwiper = true;
    }
    if (!swiper.allowSlideNext && swiper.swipeDirection === "next" && data.currentTranslate < data.startTranslate) {
      data.currentTranslate = data.startTranslate;
    }
    if (!swiper.allowSlidePrev && swiper.swipeDirection === "prev" && data.currentTranslate > data.startTranslate) {
      data.currentTranslate = data.startTranslate;
    }
    if (!swiper.allowSlidePrev && !swiper.allowSlideNext) {
      data.currentTranslate = data.startTranslate;
    }
    if (params.threshold > 0) {
      if (Math.abs(diff) > params.threshold || data.allowThresholdMove) {
        if (!data.allowThresholdMove) {
          data.allowThresholdMove = true;
          touches.startX = touches.currentX;
          touches.startY = touches.currentY;
          data.currentTranslate = data.startTranslate;
          touches.diff = swiper.isHorizontal() ? touches.currentX - touches.startX : touches.currentY - touches.startY;
          return;
        }
      } else {
        data.currentTranslate = data.startTranslate;
        return;
      }
    }
    if (!params.followFinger || params.cssMode)
      return;
    if (params.freeMode && params.freeMode.enabled && swiper.freeMode || params.watchSlidesProgress) {
      swiper.updateActiveIndex();
      swiper.updateSlidesClasses();
    }
    if (swiper.params.freeMode && params.freeMode.enabled && swiper.freeMode) {
      swiper.freeMode.onTouchMove();
    }
    swiper.updateProgress(data.currentTranslate);
    swiper.setTranslate(data.currentTranslate);
  }

  // node_modules/swiper/core/events/onTouchEnd.js
  function onTouchEnd(event2) {
    const swiper = this;
    const data = swiper.touchEventsData;
    const {
      params,
      touches,
      rtlTranslate: rtl,
      slidesGrid,
      enabled
    } = swiper;
    if (!enabled)
      return;
    let e4 = event2;
    if (e4.originalEvent)
      e4 = e4.originalEvent;
    if (data.allowTouchCallbacks) {
      swiper.emit("touchEnd", e4);
    }
    data.allowTouchCallbacks = false;
    if (!data.isTouched) {
      if (data.isMoved && params.grabCursor) {
        swiper.setGrabCursor(false);
      }
      data.isMoved = false;
      data.startMoving = false;
      return;
    }
    if (params.grabCursor && data.isMoved && data.isTouched && (swiper.allowSlideNext === true || swiper.allowSlidePrev === true)) {
      swiper.setGrabCursor(false);
    }
    const touchEndTime = now();
    const timeDiff = touchEndTime - data.touchStartTime;
    if (swiper.allowClick) {
      const pathTree = e4.path || e4.composedPath && e4.composedPath();
      swiper.updateClickedSlide(pathTree && pathTree[0] || e4.target);
      swiper.emit("tap click", e4);
      if (timeDiff < 300 && touchEndTime - data.lastClickTime < 300) {
        swiper.emit("doubleTap doubleClick", e4);
      }
    }
    data.lastClickTime = now();
    nextTick(() => {
      if (!swiper.destroyed)
        swiper.allowClick = true;
    });
    if (!data.isTouched || !data.isMoved || !swiper.swipeDirection || touches.diff === 0 || data.currentTranslate === data.startTranslate) {
      data.isTouched = false;
      data.isMoved = false;
      data.startMoving = false;
      return;
    }
    data.isTouched = false;
    data.isMoved = false;
    data.startMoving = false;
    let currentPos;
    if (params.followFinger) {
      currentPos = rtl ? swiper.translate : -swiper.translate;
    } else {
      currentPos = -data.currentTranslate;
    }
    if (params.cssMode) {
      return;
    }
    if (swiper.params.freeMode && params.freeMode.enabled) {
      swiper.freeMode.onTouchEnd({
        currentPos
      });
      return;
    }
    let stopIndex = 0;
    let groupSize = swiper.slidesSizesGrid[0];
    for (let i4 = 0; i4 < slidesGrid.length; i4 += i4 < params.slidesPerGroupSkip ? 1 : params.slidesPerGroup) {
      const increment2 = i4 < params.slidesPerGroupSkip - 1 ? 1 : params.slidesPerGroup;
      if (typeof slidesGrid[i4 + increment2] !== "undefined") {
        if (currentPos >= slidesGrid[i4] && currentPos < slidesGrid[i4 + increment2]) {
          stopIndex = i4;
          groupSize = slidesGrid[i4 + increment2] - slidesGrid[i4];
        }
      } else if (currentPos >= slidesGrid[i4]) {
        stopIndex = i4;
        groupSize = slidesGrid[slidesGrid.length - 1] - slidesGrid[slidesGrid.length - 2];
      }
    }
    let rewindFirstIndex = null;
    let rewindLastIndex = null;
    if (params.rewind) {
      if (swiper.isBeginning) {
        rewindLastIndex = swiper.params.virtual && swiper.params.virtual.enabled && swiper.virtual ? swiper.virtual.slides.length - 1 : swiper.slides.length - 1;
      } else if (swiper.isEnd) {
        rewindFirstIndex = 0;
      }
    }
    const ratio = (currentPos - slidesGrid[stopIndex]) / groupSize;
    const increment = stopIndex < params.slidesPerGroupSkip - 1 ? 1 : params.slidesPerGroup;
    if (timeDiff > params.longSwipesMs) {
      if (!params.longSwipes) {
        swiper.slideTo(swiper.activeIndex);
        return;
      }
      if (swiper.swipeDirection === "next") {
        if (ratio >= params.longSwipesRatio)
          swiper.slideTo(params.rewind && swiper.isEnd ? rewindFirstIndex : stopIndex + increment);
        else
          swiper.slideTo(stopIndex);
      }
      if (swiper.swipeDirection === "prev") {
        if (ratio > 1 - params.longSwipesRatio) {
          swiper.slideTo(stopIndex + increment);
        } else if (rewindLastIndex !== null && ratio < 0 && Math.abs(ratio) > params.longSwipesRatio) {
          swiper.slideTo(rewindLastIndex);
        } else {
          swiper.slideTo(stopIndex);
        }
      }
    } else {
      if (!params.shortSwipes) {
        swiper.slideTo(swiper.activeIndex);
        return;
      }
      const isNavButtonTarget = swiper.navigation && (e4.target === swiper.navigation.nextEl || e4.target === swiper.navigation.prevEl);
      if (!isNavButtonTarget) {
        if (swiper.swipeDirection === "next") {
          swiper.slideTo(rewindFirstIndex !== null ? rewindFirstIndex : stopIndex + increment);
        }
        if (swiper.swipeDirection === "prev") {
          swiper.slideTo(rewindLastIndex !== null ? rewindLastIndex : stopIndex);
        }
      } else if (e4.target === swiper.navigation.nextEl) {
        swiper.slideTo(stopIndex + increment);
      } else {
        swiper.slideTo(stopIndex);
      }
    }
  }

  // node_modules/swiper/core/events/onResize.js
  function onResize() {
    const swiper = this;
    const {
      params,
      el
    } = swiper;
    if (el && el.offsetWidth === 0)
      return;
    if (params.breakpoints) {
      swiper.setBreakpoint();
    }
    const {
      allowSlideNext,
      allowSlidePrev,
      snapGrid
    } = swiper;
    swiper.allowSlideNext = true;
    swiper.allowSlidePrev = true;
    swiper.updateSize();
    swiper.updateSlides();
    swiper.updateSlidesClasses();
    if ((params.slidesPerView === "auto" || params.slidesPerView > 1) && swiper.isEnd && !swiper.isBeginning && !swiper.params.centeredSlides) {
      swiper.slideTo(swiper.slides.length - 1, 0, false, true);
    } else {
      swiper.slideTo(swiper.activeIndex, 0, false, true);
    }
    if (swiper.autoplay && swiper.autoplay.running && swiper.autoplay.paused) {
      swiper.autoplay.run();
    }
    swiper.allowSlidePrev = allowSlidePrev;
    swiper.allowSlideNext = allowSlideNext;
    if (swiper.params.watchOverflow && snapGrid !== swiper.snapGrid) {
      swiper.checkOverflow();
    }
  }

  // node_modules/swiper/core/events/onClick.js
  function onClick(e4) {
    const swiper = this;
    if (!swiper.enabled)
      return;
    if (!swiper.allowClick) {
      if (swiper.params.preventClicks)
        e4.preventDefault();
      if (swiper.params.preventClicksPropagation && swiper.animating) {
        e4.stopPropagation();
        e4.stopImmediatePropagation();
      }
    }
  }

  // node_modules/swiper/core/events/onScroll.js
  function onScroll() {
    const swiper = this;
    const {
      wrapperEl,
      rtlTranslate,
      enabled
    } = swiper;
    if (!enabled)
      return;
    swiper.previousTranslate = swiper.translate;
    if (swiper.isHorizontal()) {
      swiper.translate = -wrapperEl.scrollLeft;
    } else {
      swiper.translate = -wrapperEl.scrollTop;
    }
    if (swiper.translate === 0)
      swiper.translate = 0;
    swiper.updateActiveIndex();
    swiper.updateSlidesClasses();
    let newProgress;
    const translatesDiff = swiper.maxTranslate() - swiper.minTranslate();
    if (translatesDiff === 0) {
      newProgress = 0;
    } else {
      newProgress = (swiper.translate - swiper.minTranslate()) / translatesDiff;
    }
    if (newProgress !== swiper.progress) {
      swiper.updateProgress(rtlTranslate ? -swiper.translate : swiper.translate);
    }
    swiper.emit("setTranslate", swiper.translate, false);
  }

  // node_modules/swiper/core/events/index.js
  var dummyEventAttached = false;
  function dummyEventListener() {
  }
  var events = (swiper, method) => {
    const document2 = getDocument();
    const {
      params,
      touchEvents,
      el,
      wrapperEl,
      device,
      support: support2
    } = swiper;
    const capture = !!params.nested;
    const domMethod = method === "on" ? "addEventListener" : "removeEventListener";
    const swiperMethod = method;
    if (!support2.touch) {
      el[domMethod](touchEvents.start, swiper.onTouchStart, false);
      document2[domMethod](touchEvents.move, swiper.onTouchMove, capture);
      document2[domMethod](touchEvents.end, swiper.onTouchEnd, false);
    } else {
      const passiveListener = touchEvents.start === "touchstart" && support2.passiveListener && params.passiveListeners ? {
        passive: true,
        capture: false
      } : false;
      el[domMethod](touchEvents.start, swiper.onTouchStart, passiveListener);
      el[domMethod](touchEvents.move, swiper.onTouchMove, support2.passiveListener ? {
        passive: false,
        capture
      } : capture);
      el[domMethod](touchEvents.end, swiper.onTouchEnd, passiveListener);
      if (touchEvents.cancel) {
        el[domMethod](touchEvents.cancel, swiper.onTouchEnd, passiveListener);
      }
    }
    if (params.preventClicks || params.preventClicksPropagation) {
      el[domMethod]("click", swiper.onClick, true);
    }
    if (params.cssMode) {
      wrapperEl[domMethod]("scroll", swiper.onScroll);
    }
    if (params.updateOnWindowResize) {
      swiper[swiperMethod](device.ios || device.android ? "resize orientationchange observerUpdate" : "resize observerUpdate", onResize, true);
    } else {
      swiper[swiperMethod]("observerUpdate", onResize, true);
    }
  };
  function attachEvents() {
    const swiper = this;
    const document2 = getDocument();
    const {
      params,
      support: support2
    } = swiper;
    swiper.onTouchStart = onTouchStart.bind(swiper);
    swiper.onTouchMove = onTouchMove.bind(swiper);
    swiper.onTouchEnd = onTouchEnd.bind(swiper);
    if (params.cssMode) {
      swiper.onScroll = onScroll.bind(swiper);
    }
    swiper.onClick = onClick.bind(swiper);
    if (support2.touch && !dummyEventAttached) {
      document2.addEventListener("touchstart", dummyEventListener);
      dummyEventAttached = true;
    }
    events(swiper, "on");
  }
  function detachEvents() {
    const swiper = this;
    events(swiper, "off");
  }
  var events_default = {
    attachEvents,
    detachEvents
  };

  // node_modules/swiper/core/breakpoints/setBreakpoint.js
  var isGridEnabled = (swiper, params) => {
    return swiper.grid && params.grid && params.grid.rows > 1;
  };
  function setBreakpoint() {
    const swiper = this;
    const {
      activeIndex,
      initialized,
      loopedSlides = 0,
      params,
      $el
    } = swiper;
    const breakpoints = params.breakpoints;
    if (!breakpoints || breakpoints && Object.keys(breakpoints).length === 0)
      return;
    const breakpoint = swiper.getBreakpoint(breakpoints, swiper.params.breakpointsBase, swiper.el);
    if (!breakpoint || swiper.currentBreakpoint === breakpoint)
      return;
    const breakpointOnlyParams = breakpoint in breakpoints ? breakpoints[breakpoint] : void 0;
    const breakpointParams = breakpointOnlyParams || swiper.originalParams;
    const wasMultiRow = isGridEnabled(swiper, params);
    const isMultiRow = isGridEnabled(swiper, breakpointParams);
    const wasEnabled = params.enabled;
    if (wasMultiRow && !isMultiRow) {
      $el.removeClass(`${params.containerModifierClass}grid ${params.containerModifierClass}grid-column`);
      swiper.emitContainerClasses();
    } else if (!wasMultiRow && isMultiRow) {
      $el.addClass(`${params.containerModifierClass}grid`);
      if (breakpointParams.grid.fill && breakpointParams.grid.fill === "column" || !breakpointParams.grid.fill && params.grid.fill === "column") {
        $el.addClass(`${params.containerModifierClass}grid-column`);
      }
      swiper.emitContainerClasses();
    }
    ["navigation", "pagination", "scrollbar"].forEach((prop) => {
      const wasModuleEnabled = params[prop] && params[prop].enabled;
      const isModuleEnabled = breakpointParams[prop] && breakpointParams[prop].enabled;
      if (wasModuleEnabled && !isModuleEnabled) {
        swiper[prop].disable();
      }
      if (!wasModuleEnabled && isModuleEnabled) {
        swiper[prop].enable();
      }
    });
    const directionChanged = breakpointParams.direction && breakpointParams.direction !== params.direction;
    const needsReLoop = params.loop && (breakpointParams.slidesPerView !== params.slidesPerView || directionChanged);
    if (directionChanged && initialized) {
      swiper.changeDirection();
    }
    extend2(swiper.params, breakpointParams);
    const isEnabled = swiper.params.enabled;
    Object.assign(swiper, {
      allowTouchMove: swiper.params.allowTouchMove,
      allowSlideNext: swiper.params.allowSlideNext,
      allowSlidePrev: swiper.params.allowSlidePrev
    });
    if (wasEnabled && !isEnabled) {
      swiper.disable();
    } else if (!wasEnabled && isEnabled) {
      swiper.enable();
    }
    swiper.currentBreakpoint = breakpoint;
    swiper.emit("_beforeBreakpoint", breakpointParams);
    if (needsReLoop && initialized) {
      swiper.loopDestroy();
      swiper.loopCreate();
      swiper.updateSlides();
      swiper.slideTo(activeIndex - loopedSlides + swiper.loopedSlides, 0, false);
    }
    swiper.emit("breakpoint", breakpointParams);
  }

  // node_modules/swiper/core/breakpoints/getBreakpoint.js
  function getBreakpoint(breakpoints, base = "window", containerEl) {
    if (!breakpoints || base === "container" && !containerEl)
      return void 0;
    let breakpoint = false;
    const window2 = getWindow();
    const currentHeight = base === "window" ? window2.innerHeight : containerEl.clientHeight;
    const points = Object.keys(breakpoints).map((point) => {
      if (typeof point === "string" && point.indexOf("@") === 0) {
        const minRatio = parseFloat(point.substr(1));
        const value = currentHeight * minRatio;
        return {
          value,
          point
        };
      }
      return {
        value: point,
        point
      };
    });
    points.sort((a4, b3) => parseInt(a4.value, 10) - parseInt(b3.value, 10));
    for (let i4 = 0; i4 < points.length; i4 += 1) {
      const {
        point,
        value
      } = points[i4];
      if (base === "window") {
        if (window2.matchMedia(`(min-width: ${value}px)`).matches) {
          breakpoint = point;
        }
      } else if (value <= containerEl.clientWidth) {
        breakpoint = point;
      }
    }
    return breakpoint || "max";
  }

  // node_modules/swiper/core/breakpoints/index.js
  var breakpoints_default = {
    setBreakpoint,
    getBreakpoint
  };

  // node_modules/swiper/core/classes/addClasses.js
  function prepareClasses(entries, prefix) {
    const resultClasses = [];
    entries.forEach((item) => {
      if (typeof item === "object") {
        Object.keys(item).forEach((classNames) => {
          if (item[classNames]) {
            resultClasses.push(prefix + classNames);
          }
        });
      } else if (typeof item === "string") {
        resultClasses.push(prefix + item);
      }
    });
    return resultClasses;
  }
  function addClasses() {
    const swiper = this;
    const {
      classNames,
      params,
      rtl,
      $el,
      device,
      support: support2
    } = swiper;
    const suffixes = prepareClasses(["initialized", params.direction, {
      "pointer-events": !support2.touch
    }, {
      "free-mode": swiper.params.freeMode && params.freeMode.enabled
    }, {
      "autoheight": params.autoHeight
    }, {
      "rtl": rtl
    }, {
      "grid": params.grid && params.grid.rows > 1
    }, {
      "grid-column": params.grid && params.grid.rows > 1 && params.grid.fill === "column"
    }, {
      "android": device.android
    }, {
      "ios": device.ios
    }, {
      "css-mode": params.cssMode
    }, {
      "centered": params.cssMode && params.centeredSlides
    }, {
      "watch-progress": params.watchSlidesProgress
    }], params.containerModifierClass);
    classNames.push(...suffixes);
    $el.addClass([...classNames].join(" "));
    swiper.emitContainerClasses();
  }

  // node_modules/swiper/core/classes/removeClasses.js
  function removeClasses() {
    const swiper = this;
    const {
      $el,
      classNames
    } = swiper;
    $el.removeClass(classNames.join(" "));
    swiper.emitContainerClasses();
  }

  // node_modules/swiper/core/classes/index.js
  var classes_default = {
    addClasses,
    removeClasses
  };

  // node_modules/swiper/core/images/loadImage.js
  function loadImage(imageEl, src, srcset, sizes, checkForComplete, callback) {
    const window2 = getWindow();
    let image;
    function onReady() {
      if (callback)
        callback();
    }
    const isPicture = dom_default(imageEl).parent("picture")[0];
    if (!isPicture && (!imageEl.complete || !checkForComplete)) {
      if (src) {
        image = new window2.Image();
        image.onload = onReady;
        image.onerror = onReady;
        if (sizes) {
          image.sizes = sizes;
        }
        if (srcset) {
          image.srcset = srcset;
        }
        if (src) {
          image.src = src;
        }
      } else {
        onReady();
      }
    } else {
      onReady();
    }
  }

  // node_modules/swiper/core/images/preloadImages.js
  function preloadImages() {
    const swiper = this;
    swiper.imagesToLoad = swiper.$el.find("img");
    function onReady() {
      if (typeof swiper === "undefined" || swiper === null || !swiper || swiper.destroyed)
        return;
      if (swiper.imagesLoaded !== void 0)
        swiper.imagesLoaded += 1;
      if (swiper.imagesLoaded === swiper.imagesToLoad.length) {
        if (swiper.params.updateOnImagesReady)
          swiper.update();
        swiper.emit("imagesReady");
      }
    }
    for (let i4 = 0; i4 < swiper.imagesToLoad.length; i4 += 1) {
      const imageEl = swiper.imagesToLoad[i4];
      swiper.loadImage(imageEl, imageEl.currentSrc || imageEl.getAttribute("src"), imageEl.srcset || imageEl.getAttribute("srcset"), imageEl.sizes || imageEl.getAttribute("sizes"), true, onReady);
    }
  }

  // node_modules/swiper/core/images/index.js
  var images_default = {
    loadImage,
    preloadImages
  };

  // node_modules/swiper/core/check-overflow/index.js
  function checkOverflow() {
    const swiper = this;
    const {
      isLocked: wasLocked,
      params
    } = swiper;
    const {
      slidesOffsetBefore
    } = params;
    if (slidesOffsetBefore) {
      const lastSlideIndex = swiper.slides.length - 1;
      const lastSlideRightEdge = swiper.slidesGrid[lastSlideIndex] + swiper.slidesSizesGrid[lastSlideIndex] + slidesOffsetBefore * 2;
      swiper.isLocked = swiper.size > lastSlideRightEdge;
    } else {
      swiper.isLocked = swiper.snapGrid.length === 1;
    }
    if (params.allowSlideNext === true) {
      swiper.allowSlideNext = !swiper.isLocked;
    }
    if (params.allowSlidePrev === true) {
      swiper.allowSlidePrev = !swiper.isLocked;
    }
    if (wasLocked && wasLocked !== swiper.isLocked) {
      swiper.isEnd = false;
    }
    if (wasLocked !== swiper.isLocked) {
      swiper.emit(swiper.isLocked ? "lock" : "unlock");
    }
  }
  var check_overflow_default = {
    checkOverflow
  };

  // node_modules/swiper/core/defaults.js
  var defaults_default = {
    init: true,
    direction: "horizontal",
    touchEventsTarget: "wrapper",
    initialSlide: 0,
    speed: 300,
    cssMode: false,
    updateOnWindowResize: true,
    resizeObserver: true,
    nested: false,
    createElements: false,
    enabled: true,
    focusableElements: "input, select, option, textarea, button, video, label",
    width: null,
    height: null,
    preventInteractionOnTransition: false,
    userAgent: null,
    url: null,
    edgeSwipeDetection: false,
    edgeSwipeThreshold: 20,
    autoHeight: false,
    setWrapperSize: false,
    virtualTranslate: false,
    effect: "slide",
    breakpoints: void 0,
    breakpointsBase: "window",
    spaceBetween: 0,
    slidesPerView: 1,
    slidesPerGroup: 1,
    slidesPerGroupSkip: 0,
    slidesPerGroupAuto: false,
    centeredSlides: false,
    centeredSlidesBounds: false,
    slidesOffsetBefore: 0,
    slidesOffsetAfter: 0,
    normalizeSlideIndex: true,
    centerInsufficientSlides: false,
    watchOverflow: true,
    roundLengths: false,
    touchRatio: 1,
    touchAngle: 45,
    simulateTouch: true,
    shortSwipes: true,
    longSwipes: true,
    longSwipesRatio: 0.5,
    longSwipesMs: 300,
    followFinger: true,
    allowTouchMove: true,
    threshold: 0,
    touchMoveStopPropagation: false,
    touchStartPreventDefault: true,
    touchStartForcePreventDefault: false,
    touchReleaseOnEdges: false,
    uniqueNavElements: true,
    resistance: true,
    resistanceRatio: 0.85,
    watchSlidesProgress: false,
    grabCursor: false,
    preventClicks: true,
    preventClicksPropagation: true,
    slideToClickedSlide: false,
    preloadImages: true,
    updateOnImagesReady: true,
    loop: false,
    loopAdditionalSlides: 0,
    loopedSlides: null,
    loopedSlidesLimit: true,
    loopFillGroupWithBlank: false,
    loopPreventsSlide: true,
    rewind: false,
    allowSlidePrev: true,
    allowSlideNext: true,
    swipeHandler: null,
    noSwiping: true,
    noSwipingClass: "swiper-no-swiping",
    noSwipingSelector: null,
    passiveListeners: true,
    maxBackfaceHiddenSlides: 10,
    containerModifierClass: "swiper-",
    slideClass: "swiper-slide",
    slideBlankClass: "swiper-slide-invisible-blank",
    slideActiveClass: "swiper-slide-active",
    slideDuplicateActiveClass: "swiper-slide-duplicate-active",
    slideVisibleClass: "swiper-slide-visible",
    slideDuplicateClass: "swiper-slide-duplicate",
    slideNextClass: "swiper-slide-next",
    slideDuplicateNextClass: "swiper-slide-duplicate-next",
    slidePrevClass: "swiper-slide-prev",
    slideDuplicatePrevClass: "swiper-slide-duplicate-prev",
    wrapperClass: "swiper-wrapper",
    runCallbacksOnInit: true,
    _emitClasses: false
  };

  // node_modules/swiper/core/moduleExtendParams.js
  function moduleExtendParams(params, allModulesParams) {
    return function extendParams(obj = {}) {
      const moduleParamName = Object.keys(obj)[0];
      const moduleParams = obj[moduleParamName];
      if (typeof moduleParams !== "object" || moduleParams === null) {
        extend2(allModulesParams, obj);
        return;
      }
      if (["navigation", "pagination", "scrollbar"].indexOf(moduleParamName) >= 0 && params[moduleParamName] === true) {
        params[moduleParamName] = {
          auto: true
        };
      }
      if (!(moduleParamName in params && "enabled" in moduleParams)) {
        extend2(allModulesParams, obj);
        return;
      }
      if (params[moduleParamName] === true) {
        params[moduleParamName] = {
          enabled: true
        };
      }
      if (typeof params[moduleParamName] === "object" && !("enabled" in params[moduleParamName])) {
        params[moduleParamName].enabled = true;
      }
      if (!params[moduleParamName])
        params[moduleParamName] = {
          enabled: false
        };
      extend2(allModulesParams, obj);
    };
  }

  // node_modules/swiper/core/core.js
  var prototypes = {
    eventsEmitter: events_emitter_default,
    update: update_default,
    translate: translate_default,
    transition: transition_default,
    slide: slide_default,
    loop: loop_default,
    grabCursor: grab_cursor_default,
    events: events_default,
    breakpoints: breakpoints_default,
    checkOverflow: check_overflow_default,
    classes: classes_default,
    images: images_default
  };
  var extendedDefaults = {};
  var Swiper = class {
    constructor(...args) {
      let el;
      let params;
      if (args.length === 1 && args[0].constructor && Object.prototype.toString.call(args[0]).slice(8, -1) === "Object") {
        params = args[0];
      } else {
        [el, params] = args;
      }
      if (!params)
        params = {};
      params = extend2({}, params);
      if (el && !params.el)
        params.el = el;
      if (params.el && dom_default(params.el).length > 1) {
        const swipers = [];
        dom_default(params.el).each((containerEl) => {
          const newParams = extend2({}, params, {
            el: containerEl
          });
          swipers.push(new Swiper(newParams));
        });
        return swipers;
      }
      const swiper = this;
      swiper.__swiper__ = true;
      swiper.support = getSupport();
      swiper.device = getDevice({
        userAgent: params.userAgent
      });
      swiper.browser = getBrowser();
      swiper.eventsListeners = {};
      swiper.eventsAnyListeners = [];
      swiper.modules = [...swiper.__modules__];
      if (params.modules && Array.isArray(params.modules)) {
        swiper.modules.push(...params.modules);
      }
      const allModulesParams = {};
      swiper.modules.forEach((mod) => {
        mod({
          swiper,
          extendParams: moduleExtendParams(params, allModulesParams),
          on: swiper.on.bind(swiper),
          once: swiper.once.bind(swiper),
          off: swiper.off.bind(swiper),
          emit: swiper.emit.bind(swiper)
        });
      });
      const swiperParams = extend2({}, defaults_default, allModulesParams);
      swiper.params = extend2({}, swiperParams, extendedDefaults, params);
      swiper.originalParams = extend2({}, swiper.params);
      swiper.passedParams = extend2({}, params);
      if (swiper.params && swiper.params.on) {
        Object.keys(swiper.params.on).forEach((eventName) => {
          swiper.on(eventName, swiper.params.on[eventName]);
        });
      }
      if (swiper.params && swiper.params.onAny) {
        swiper.onAny(swiper.params.onAny);
      }
      swiper.$ = dom_default;
      Object.assign(swiper, {
        enabled: swiper.params.enabled,
        el,
        classNames: [],
        slides: dom_default(),
        slidesGrid: [],
        snapGrid: [],
        slidesSizesGrid: [],
        isHorizontal() {
          return swiper.params.direction === "horizontal";
        },
        isVertical() {
          return swiper.params.direction === "vertical";
        },
        activeIndex: 0,
        realIndex: 0,
        isBeginning: true,
        isEnd: false,
        translate: 0,
        previousTranslate: 0,
        progress: 0,
        velocity: 0,
        animating: false,
        allowSlideNext: swiper.params.allowSlideNext,
        allowSlidePrev: swiper.params.allowSlidePrev,
        touchEvents: function touchEvents() {
          const touch = ["touchstart", "touchmove", "touchend", "touchcancel"];
          const desktop = ["pointerdown", "pointermove", "pointerup"];
          swiper.touchEventsTouch = {
            start: touch[0],
            move: touch[1],
            end: touch[2],
            cancel: touch[3]
          };
          swiper.touchEventsDesktop = {
            start: desktop[0],
            move: desktop[1],
            end: desktop[2]
          };
          return swiper.support.touch || !swiper.params.simulateTouch ? swiper.touchEventsTouch : swiper.touchEventsDesktop;
        }(),
        touchEventsData: {
          isTouched: void 0,
          isMoved: void 0,
          allowTouchCallbacks: void 0,
          touchStartTime: void 0,
          isScrolling: void 0,
          currentTranslate: void 0,
          startTranslate: void 0,
          allowThresholdMove: void 0,
          focusableElements: swiper.params.focusableElements,
          lastClickTime: now(),
          clickTimeout: void 0,
          velocities: [],
          allowMomentumBounce: void 0,
          isTouchEvent: void 0,
          startMoving: void 0
        },
        allowClick: true,
        allowTouchMove: swiper.params.allowTouchMove,
        touches: {
          startX: 0,
          startY: 0,
          currentX: 0,
          currentY: 0,
          diff: 0
        },
        imagesToLoad: [],
        imagesLoaded: 0
      });
      swiper.emit("_swiper");
      if (swiper.params.init) {
        swiper.init();
      }
      return swiper;
    }
    enable() {
      const swiper = this;
      if (swiper.enabled)
        return;
      swiper.enabled = true;
      if (swiper.params.grabCursor) {
        swiper.setGrabCursor();
      }
      swiper.emit("enable");
    }
    disable() {
      const swiper = this;
      if (!swiper.enabled)
        return;
      swiper.enabled = false;
      if (swiper.params.grabCursor) {
        swiper.unsetGrabCursor();
      }
      swiper.emit("disable");
    }
    setProgress(progress, speed) {
      const swiper = this;
      progress = Math.min(Math.max(progress, 0), 1);
      const min = swiper.minTranslate();
      const max = swiper.maxTranslate();
      const current = (max - min) * progress + min;
      swiper.translateTo(current, typeof speed === "undefined" ? 0 : speed);
      swiper.updateActiveIndex();
      swiper.updateSlidesClasses();
    }
    emitContainerClasses() {
      const swiper = this;
      if (!swiper.params._emitClasses || !swiper.el)
        return;
      const cls = swiper.el.className.split(" ").filter((className) => {
        return className.indexOf("swiper") === 0 || className.indexOf(swiper.params.containerModifierClass) === 0;
      });
      swiper.emit("_containerClasses", cls.join(" "));
    }
    getSlideClasses(slideEl) {
      const swiper = this;
      if (swiper.destroyed)
        return "";
      return slideEl.className.split(" ").filter((className) => {
        return className.indexOf("swiper-slide") === 0 || className.indexOf(swiper.params.slideClass) === 0;
      }).join(" ");
    }
    emitSlidesClasses() {
      const swiper = this;
      if (!swiper.params._emitClasses || !swiper.el)
        return;
      const updates = [];
      swiper.slides.each((slideEl) => {
        const classNames = swiper.getSlideClasses(slideEl);
        updates.push({
          slideEl,
          classNames
        });
        swiper.emit("_slideClass", slideEl, classNames);
      });
      swiper.emit("_slideClasses", updates);
    }
    slidesPerViewDynamic(view = "current", exact = false) {
      const swiper = this;
      const {
        params,
        slides,
        slidesGrid,
        slidesSizesGrid,
        size: swiperSize,
        activeIndex
      } = swiper;
      let spv = 1;
      if (params.centeredSlides) {
        let slideSize = slides[activeIndex].swiperSlideSize;
        let breakLoop;
        for (let i4 = activeIndex + 1; i4 < slides.length; i4 += 1) {
          if (slides[i4] && !breakLoop) {
            slideSize += slides[i4].swiperSlideSize;
            spv += 1;
            if (slideSize > swiperSize)
              breakLoop = true;
          }
        }
        for (let i4 = activeIndex - 1; i4 >= 0; i4 -= 1) {
          if (slides[i4] && !breakLoop) {
            slideSize += slides[i4].swiperSlideSize;
            spv += 1;
            if (slideSize > swiperSize)
              breakLoop = true;
          }
        }
      } else {
        if (view === "current") {
          for (let i4 = activeIndex + 1; i4 < slides.length; i4 += 1) {
            const slideInView = exact ? slidesGrid[i4] + slidesSizesGrid[i4] - slidesGrid[activeIndex] < swiperSize : slidesGrid[i4] - slidesGrid[activeIndex] < swiperSize;
            if (slideInView) {
              spv += 1;
            }
          }
        } else {
          for (let i4 = activeIndex - 1; i4 >= 0; i4 -= 1) {
            const slideInView = slidesGrid[activeIndex] - slidesGrid[i4] < swiperSize;
            if (slideInView) {
              spv += 1;
            }
          }
        }
      }
      return spv;
    }
    update() {
      const swiper = this;
      if (!swiper || swiper.destroyed)
        return;
      const {
        snapGrid,
        params
      } = swiper;
      if (params.breakpoints) {
        swiper.setBreakpoint();
      }
      swiper.updateSize();
      swiper.updateSlides();
      swiper.updateProgress();
      swiper.updateSlidesClasses();
      function setTranslate2() {
        const translateValue = swiper.rtlTranslate ? swiper.translate * -1 : swiper.translate;
        const newTranslate = Math.min(Math.max(translateValue, swiper.maxTranslate()), swiper.minTranslate());
        swiper.setTranslate(newTranslate);
        swiper.updateActiveIndex();
        swiper.updateSlidesClasses();
      }
      let translated;
      if (swiper.params.freeMode && swiper.params.freeMode.enabled) {
        setTranslate2();
        if (swiper.params.autoHeight) {
          swiper.updateAutoHeight();
        }
      } else {
        if ((swiper.params.slidesPerView === "auto" || swiper.params.slidesPerView > 1) && swiper.isEnd && !swiper.params.centeredSlides) {
          translated = swiper.slideTo(swiper.slides.length - 1, 0, false, true);
        } else {
          translated = swiper.slideTo(swiper.activeIndex, 0, false, true);
        }
        if (!translated) {
          setTranslate2();
        }
      }
      if (params.watchOverflow && snapGrid !== swiper.snapGrid) {
        swiper.checkOverflow();
      }
      swiper.emit("update");
    }
    changeDirection(newDirection, needUpdate = true) {
      const swiper = this;
      const currentDirection = swiper.params.direction;
      if (!newDirection) {
        newDirection = currentDirection === "horizontal" ? "vertical" : "horizontal";
      }
      if (newDirection === currentDirection || newDirection !== "horizontal" && newDirection !== "vertical") {
        return swiper;
      }
      swiper.$el.removeClass(`${swiper.params.containerModifierClass}${currentDirection}`).addClass(`${swiper.params.containerModifierClass}${newDirection}`);
      swiper.emitContainerClasses();
      swiper.params.direction = newDirection;
      swiper.slides.each((slideEl) => {
        if (newDirection === "vertical") {
          slideEl.style.width = "";
        } else {
          slideEl.style.height = "";
        }
      });
      swiper.emit("changeDirection");
      if (needUpdate)
        swiper.update();
      return swiper;
    }
    changeLanguageDirection(direction) {
      const swiper = this;
      if (swiper.rtl && direction === "rtl" || !swiper.rtl && direction === "ltr")
        return;
      swiper.rtl = direction === "rtl";
      swiper.rtlTranslate = swiper.params.direction === "horizontal" && swiper.rtl;
      if (swiper.rtl) {
        swiper.$el.addClass(`${swiper.params.containerModifierClass}rtl`);
        swiper.el.dir = "rtl";
      } else {
        swiper.$el.removeClass(`${swiper.params.containerModifierClass}rtl`);
        swiper.el.dir = "ltr";
      }
      swiper.update();
    }
    mount(el) {
      const swiper = this;
      if (swiper.mounted)
        return true;
      const $el = dom_default(el || swiper.params.el);
      el = $el[0];
      if (!el) {
        return false;
      }
      el.swiper = swiper;
      const getWrapperSelector = () => {
        return `.${(swiper.params.wrapperClass || "").trim().split(" ").join(".")}`;
      };
      const getWrapper = () => {
        if (el && el.shadowRoot && el.shadowRoot.querySelector) {
          const res = dom_default(el.shadowRoot.querySelector(getWrapperSelector()));
          res.children = (options) => $el.children(options);
          return res;
        }
        if (!$el.children) {
          return dom_default($el).children(getWrapperSelector());
        }
        return $el.children(getWrapperSelector());
      };
      let $wrapperEl = getWrapper();
      if ($wrapperEl.length === 0 && swiper.params.createElements) {
        const document2 = getDocument();
        const wrapper = document2.createElement("div");
        $wrapperEl = dom_default(wrapper);
        wrapper.className = swiper.params.wrapperClass;
        $el.append(wrapper);
        $el.children(`.${swiper.params.slideClass}`).each((slideEl) => {
          $wrapperEl.append(slideEl);
        });
      }
      Object.assign(swiper, {
        $el,
        el,
        $wrapperEl,
        wrapperEl: $wrapperEl[0],
        mounted: true,
        rtl: el.dir.toLowerCase() === "rtl" || $el.css("direction") === "rtl",
        rtlTranslate: swiper.params.direction === "horizontal" && (el.dir.toLowerCase() === "rtl" || $el.css("direction") === "rtl"),
        wrongRTL: $wrapperEl.css("display") === "-webkit-box"
      });
      return true;
    }
    init(el) {
      const swiper = this;
      if (swiper.initialized)
        return swiper;
      const mounted = swiper.mount(el);
      if (mounted === false)
        return swiper;
      swiper.emit("beforeInit");
      if (swiper.params.breakpoints) {
        swiper.setBreakpoint();
      }
      swiper.addClasses();
      if (swiper.params.loop) {
        swiper.loopCreate();
      }
      swiper.updateSize();
      swiper.updateSlides();
      if (swiper.params.watchOverflow) {
        swiper.checkOverflow();
      }
      if (swiper.params.grabCursor && swiper.enabled) {
        swiper.setGrabCursor();
      }
      if (swiper.params.preloadImages) {
        swiper.preloadImages();
      }
      if (swiper.params.loop) {
        swiper.slideTo(swiper.params.initialSlide + swiper.loopedSlides, 0, swiper.params.runCallbacksOnInit, false, true);
      } else {
        swiper.slideTo(swiper.params.initialSlide, 0, swiper.params.runCallbacksOnInit, false, true);
      }
      swiper.attachEvents();
      swiper.initialized = true;
      swiper.emit("init");
      swiper.emit("afterInit");
      return swiper;
    }
    destroy(deleteInstance = true, cleanStyles = true) {
      const swiper = this;
      const {
        params,
        $el,
        $wrapperEl,
        slides
      } = swiper;
      if (typeof swiper.params === "undefined" || swiper.destroyed) {
        return null;
      }
      swiper.emit("beforeDestroy");
      swiper.initialized = false;
      swiper.detachEvents();
      if (params.loop) {
        swiper.loopDestroy();
      }
      if (cleanStyles) {
        swiper.removeClasses();
        $el.removeAttr("style");
        $wrapperEl.removeAttr("style");
        if (slides && slides.length) {
          slides.removeClass([params.slideVisibleClass, params.slideActiveClass, params.slideNextClass, params.slidePrevClass].join(" ")).removeAttr("style").removeAttr("data-swiper-slide-index");
        }
      }
      swiper.emit("destroy");
      Object.keys(swiper.eventsListeners).forEach((eventName) => {
        swiper.off(eventName);
      });
      if (deleteInstance !== false) {
        swiper.$el[0].swiper = null;
        deleteProps(swiper);
      }
      swiper.destroyed = true;
      return null;
    }
    static extendDefaults(newDefaults) {
      extend2(extendedDefaults, newDefaults);
    }
    static get extendedDefaults() {
      return extendedDefaults;
    }
    static get defaults() {
      return defaults_default;
    }
    static installModule(mod) {
      if (!Swiper.prototype.__modules__)
        Swiper.prototype.__modules__ = [];
      const modules = Swiper.prototype.__modules__;
      if (typeof mod === "function" && modules.indexOf(mod) < 0) {
        modules.push(mod);
      }
    }
    static use(module) {
      if (Array.isArray(module)) {
        module.forEach((m3) => Swiper.installModule(m3));
        return Swiper;
      }
      Swiper.installModule(module);
      return Swiper;
    }
  };
  Object.keys(prototypes).forEach((prototypeGroup) => {
    Object.keys(prototypes[prototypeGroup]).forEach((protoMethod) => {
      Swiper.prototype[protoMethod] = prototypes[prototypeGroup][protoMethod];
    });
  });
  Swiper.use([Resize, Observer]);
  var core_default = Swiper;

  // node_modules/swiper/shared/create-element-if-not-defined.js
  function createElementIfNotDefined(swiper, originalParams, params, checkProps) {
    const document2 = getDocument();
    if (swiper.params.createElements) {
      Object.keys(checkProps).forEach((key) => {
        if (!params[key] && params.auto === true) {
          let element = swiper.$el.children(`.${checkProps[key]}`)[0];
          if (!element) {
            element = document2.createElement("div");
            element.className = checkProps[key];
            swiper.$el.append(element);
          }
          params[key] = element;
          originalParams[key] = element;
        }
      });
    }
    return params;
  }

  // node_modules/swiper/modules/navigation/navigation.js
  function Navigation({
    swiper,
    extendParams,
    on: on2,
    emit
  }) {
    extendParams({
      navigation: {
        nextEl: null,
        prevEl: null,
        hideOnClick: false,
        disabledClass: "swiper-button-disabled",
        hiddenClass: "swiper-button-hidden",
        lockClass: "swiper-button-lock",
        navigationDisabledClass: "swiper-navigation-disabled"
      }
    });
    swiper.navigation = {
      nextEl: null,
      $nextEl: null,
      prevEl: null,
      $prevEl: null
    };
    function getEl(el) {
      let $el;
      if (el) {
        $el = dom_default(el);
        if (swiper.params.uniqueNavElements && typeof el === "string" && $el.length > 1 && swiper.$el.find(el).length === 1) {
          $el = swiper.$el.find(el);
        }
      }
      return $el;
    }
    function toggleEl($el, disabled) {
      const params = swiper.params.navigation;
      if ($el && $el.length > 0) {
        $el[disabled ? "addClass" : "removeClass"](params.disabledClass);
        if ($el[0] && $el[0].tagName === "BUTTON")
          $el[0].disabled = disabled;
        if (swiper.params.watchOverflow && swiper.enabled) {
          $el[swiper.isLocked ? "addClass" : "removeClass"](params.lockClass);
        }
      }
    }
    function update() {
      if (swiper.params.loop)
        return;
      const {
        $nextEl,
        $prevEl
      } = swiper.navigation;
      toggleEl($prevEl, swiper.isBeginning && !swiper.params.rewind);
      toggleEl($nextEl, swiper.isEnd && !swiper.params.rewind);
    }
    function onPrevClick(e4) {
      e4.preventDefault();
      if (swiper.isBeginning && !swiper.params.loop && !swiper.params.rewind)
        return;
      swiper.slidePrev();
      emit("navigationPrev");
    }
    function onNextClick(e4) {
      e4.preventDefault();
      if (swiper.isEnd && !swiper.params.loop && !swiper.params.rewind)
        return;
      swiper.slideNext();
      emit("navigationNext");
    }
    function init() {
      const params = swiper.params.navigation;
      swiper.params.navigation = createElementIfNotDefined(swiper, swiper.originalParams.navigation, swiper.params.navigation, {
        nextEl: "swiper-button-next",
        prevEl: "swiper-button-prev"
      });
      if (!(params.nextEl || params.prevEl))
        return;
      const $nextEl = getEl(params.nextEl);
      const $prevEl = getEl(params.prevEl);
      if ($nextEl && $nextEl.length > 0) {
        $nextEl.on("click", onNextClick);
      }
      if ($prevEl && $prevEl.length > 0) {
        $prevEl.on("click", onPrevClick);
      }
      Object.assign(swiper.navigation, {
        $nextEl,
        nextEl: $nextEl && $nextEl[0],
        $prevEl,
        prevEl: $prevEl && $prevEl[0]
      });
      if (!swiper.enabled) {
        if ($nextEl)
          $nextEl.addClass(params.lockClass);
        if ($prevEl)
          $prevEl.addClass(params.lockClass);
      }
    }
    function destroy() {
      const {
        $nextEl,
        $prevEl
      } = swiper.navigation;
      if ($nextEl && $nextEl.length) {
        $nextEl.off("click", onNextClick);
        $nextEl.removeClass(swiper.params.navigation.disabledClass);
      }
      if ($prevEl && $prevEl.length) {
        $prevEl.off("click", onPrevClick);
        $prevEl.removeClass(swiper.params.navigation.disabledClass);
      }
    }
    on2("init", () => {
      if (swiper.params.navigation.enabled === false) {
        disable();
      } else {
        init();
        update();
      }
    });
    on2("toEdge fromEdge lock unlock", () => {
      update();
    });
    on2("destroy", () => {
      destroy();
    });
    on2("enable disable", () => {
      const {
        $nextEl,
        $prevEl
      } = swiper.navigation;
      if ($nextEl) {
        $nextEl[swiper.enabled ? "removeClass" : "addClass"](swiper.params.navigation.lockClass);
      }
      if ($prevEl) {
        $prevEl[swiper.enabled ? "removeClass" : "addClass"](swiper.params.navigation.lockClass);
      }
    });
    on2("click", (_s, e4) => {
      const {
        $nextEl,
        $prevEl
      } = swiper.navigation;
      const targetEl = e4.target;
      if (swiper.params.navigation.hideOnClick && !dom_default(targetEl).is($prevEl) && !dom_default(targetEl).is($nextEl)) {
        if (swiper.pagination && swiper.params.pagination && swiper.params.pagination.clickable && (swiper.pagination.el === targetEl || swiper.pagination.el.contains(targetEl)))
          return;
        let isHidden;
        if ($nextEl) {
          isHidden = $nextEl.hasClass(swiper.params.navigation.hiddenClass);
        } else if ($prevEl) {
          isHidden = $prevEl.hasClass(swiper.params.navigation.hiddenClass);
        }
        if (isHidden === true) {
          emit("navigationShow");
        } else {
          emit("navigationHide");
        }
        if ($nextEl) {
          $nextEl.toggleClass(swiper.params.navigation.hiddenClass);
        }
        if ($prevEl) {
          $prevEl.toggleClass(swiper.params.navigation.hiddenClass);
        }
      }
    });
    const enable = () => {
      swiper.$el.removeClass(swiper.params.navigation.navigationDisabledClass);
      init();
      update();
    };
    const disable = () => {
      swiper.$el.addClass(swiper.params.navigation.navigationDisabledClass);
      destroy();
    };
    Object.assign(swiper.navigation, {
      enable,
      disable,
      update,
      init,
      destroy
    });
  }

  // node_modules/swiper/modules/parallax/parallax.js
  function Parallax({
    swiper,
    extendParams,
    on: on2
  }) {
    extendParams({
      parallax: {
        enabled: false
      }
    });
    const setTransform = (el, progress) => {
      const {
        rtl
      } = swiper;
      const $el = dom_default(el);
      const rtlFactor = rtl ? -1 : 1;
      const p4 = $el.attr("data-swiper-parallax") || "0";
      let x3 = $el.attr("data-swiper-parallax-x");
      let y3 = $el.attr("data-swiper-parallax-y");
      const scale = $el.attr("data-swiper-parallax-scale");
      const opacity = $el.attr("data-swiper-parallax-opacity");
      if (x3 || y3) {
        x3 = x3 || "0";
        y3 = y3 || "0";
      } else if (swiper.isHorizontal()) {
        x3 = p4;
        y3 = "0";
      } else {
        y3 = p4;
        x3 = "0";
      }
      if (x3.indexOf("%") >= 0) {
        x3 = `${parseInt(x3, 10) * progress * rtlFactor}%`;
      } else {
        x3 = `${x3 * progress * rtlFactor}px`;
      }
      if (y3.indexOf("%") >= 0) {
        y3 = `${parseInt(y3, 10) * progress}%`;
      } else {
        y3 = `${y3 * progress}px`;
      }
      if (typeof opacity !== "undefined" && opacity !== null) {
        const currentOpacity = opacity - (opacity - 1) * (1 - Math.abs(progress));
        $el[0].style.opacity = currentOpacity;
      }
      if (typeof scale === "undefined" || scale === null) {
        $el.transform(`translate3d(${x3}, ${y3}, 0px)`);
      } else {
        const currentScale = scale - (scale - 1) * (1 - Math.abs(progress));
        $el.transform(`translate3d(${x3}, ${y3}, 0px) scale(${currentScale})`);
      }
    };
    const setTranslate2 = () => {
      const {
        $el,
        slides,
        progress,
        snapGrid
      } = swiper;
      $el.children("[data-swiper-parallax], [data-swiper-parallax-x], [data-swiper-parallax-y], [data-swiper-parallax-opacity], [data-swiper-parallax-scale]").each((el) => {
        setTransform(el, progress);
      });
      slides.each((slideEl, slideIndex) => {
        let slideProgress = slideEl.progress;
        if (swiper.params.slidesPerGroup > 1 && swiper.params.slidesPerView !== "auto") {
          slideProgress += Math.ceil(slideIndex / 2) - progress * (snapGrid.length - 1);
        }
        slideProgress = Math.min(Math.max(slideProgress, -1), 1);
        dom_default(slideEl).find("[data-swiper-parallax], [data-swiper-parallax-x], [data-swiper-parallax-y], [data-swiper-parallax-opacity], [data-swiper-parallax-scale]").each((el) => {
          setTransform(el, slideProgress);
        });
      });
    };
    const setTransition2 = (duration = swiper.params.speed) => {
      const {
        $el
      } = swiper;
      $el.find("[data-swiper-parallax], [data-swiper-parallax-x], [data-swiper-parallax-y], [data-swiper-parallax-opacity], [data-swiper-parallax-scale]").each((parallaxEl) => {
        const $parallaxEl = dom_default(parallaxEl);
        let parallaxDuration = parseInt($parallaxEl.attr("data-swiper-parallax-duration"), 10) || duration;
        if (duration === 0)
          parallaxDuration = 0;
        $parallaxEl.transition(parallaxDuration);
      });
    };
    on2("beforeInit", () => {
      if (!swiper.params.parallax.enabled)
        return;
      swiper.params.watchSlidesProgress = true;
      swiper.originalParams.watchSlidesProgress = true;
    });
    on2("init", () => {
      if (!swiper.params.parallax.enabled)
        return;
      setTranslate2();
    });
    on2("setTranslate", () => {
      if (!swiper.params.parallax.enabled)
        return;
      setTranslate2();
    });
    on2("setTransition", (_swiper, duration) => {
      if (!swiper.params.parallax.enabled)
        return;
      setTransition2(duration);
    });
  }

  // node_modules/swiper/shared/effect-init.js
  function effectInit(params) {
    const {
      effect,
      swiper,
      on: on2,
      setTranslate: setTranslate2,
      setTransition: setTransition2,
      overwriteParams,
      perspective,
      recreateShadows,
      getEffectParams
    } = params;
    on2("beforeInit", () => {
      if (swiper.params.effect !== effect)
        return;
      swiper.classNames.push(`${swiper.params.containerModifierClass}${effect}`);
      if (perspective && perspective()) {
        swiper.classNames.push(`${swiper.params.containerModifierClass}3d`);
      }
      const overwriteParamsResult = overwriteParams ? overwriteParams() : {};
      Object.assign(swiper.params, overwriteParamsResult);
      Object.assign(swiper.originalParams, overwriteParamsResult);
    });
    on2("setTranslate", () => {
      if (swiper.params.effect !== effect)
        return;
      setTranslate2();
    });
    on2("setTransition", (_s, duration) => {
      if (swiper.params.effect !== effect)
        return;
      setTransition2(duration);
    });
    on2("transitionEnd", () => {
      if (swiper.params.effect !== effect)
        return;
      if (recreateShadows) {
        if (!getEffectParams || !getEffectParams().slideShadows)
          return;
        swiper.slides.each((slideEl) => {
          const $slideEl = swiper.$(slideEl);
          $slideEl.find(".swiper-slide-shadow-top, .swiper-slide-shadow-right, .swiper-slide-shadow-bottom, .swiper-slide-shadow-left").remove();
        });
        recreateShadows();
      }
    });
    let requireUpdateOnVirtual;
    on2("virtualUpdate", () => {
      if (swiper.params.effect !== effect)
        return;
      if (!swiper.slides.length) {
        requireUpdateOnVirtual = true;
      }
      requestAnimationFrame(() => {
        if (requireUpdateOnVirtual && swiper.slides && swiper.slides.length) {
          setTranslate2();
          requireUpdateOnVirtual = false;
        }
      });
    });
  }

  // node_modules/swiper/shared/effect-target.js
  function effectTarget(effectParams, $slideEl) {
    if (effectParams.transformEl) {
      return $slideEl.find(effectParams.transformEl).css({
        "backface-visibility": "hidden",
        "-webkit-backface-visibility": "hidden"
      });
    }
    return $slideEl;
  }

  // node_modules/swiper/shared/effect-virtual-transition-end.js
  function effectVirtualTransitionEnd({
    swiper,
    duration,
    transformEl,
    allSlides
  }) {
    const {
      slides,
      activeIndex,
      $wrapperEl
    } = swiper;
    if (swiper.params.virtualTranslate && duration !== 0) {
      let eventTriggered = false;
      let $transitionEndTarget;
      if (allSlides) {
        $transitionEndTarget = transformEl ? slides.find(transformEl) : slides;
      } else {
        $transitionEndTarget = transformEl ? slides.eq(activeIndex).find(transformEl) : slides.eq(activeIndex);
      }
      $transitionEndTarget.transitionEnd(() => {
        if (eventTriggered)
          return;
        if (!swiper || swiper.destroyed)
          return;
        eventTriggered = true;
        swiper.animating = false;
        const triggerEvents = ["webkitTransitionEnd", "transitionend"];
        for (let i4 = 0; i4 < triggerEvents.length; i4 += 1) {
          $wrapperEl.trigger(triggerEvents[i4]);
        }
      });
    }
  }

  // node_modules/swiper/shared/create-shadow.js
  function createShadow(params, $slideEl, side) {
    const shadowClass = `swiper-slide-shadow${side ? `-${side}` : ""}`;
    const $shadowContainer = params.transformEl ? $slideEl.find(params.transformEl) : $slideEl;
    let $shadowEl = $shadowContainer.children(`.${shadowClass}`);
    if (!$shadowEl.length) {
      $shadowEl = dom_default(`<div class="swiper-slide-shadow${side ? `-${side}` : ""}"></div>`);
      $shadowContainer.append($shadowEl);
    }
    return $shadowEl;
  }

  // node_modules/swiper/modules/effect-creative/effect-creative.js
  function EffectCreative({
    swiper,
    extendParams,
    on: on2
  }) {
    extendParams({
      creativeEffect: {
        transformEl: null,
        limitProgress: 1,
        shadowPerProgress: false,
        progressMultiplier: 1,
        perspective: true,
        prev: {
          translate: [0, 0, 0],
          rotate: [0, 0, 0],
          opacity: 1,
          scale: 1
        },
        next: {
          translate: [0, 0, 0],
          rotate: [0, 0, 0],
          opacity: 1,
          scale: 1
        }
      }
    });
    const getTranslateValue = (value) => {
      if (typeof value === "string")
        return value;
      return `${value}px`;
    };
    const setTranslate2 = () => {
      const {
        slides,
        $wrapperEl,
        slidesSizesGrid
      } = swiper;
      const params = swiper.params.creativeEffect;
      const {
        progressMultiplier: multiplier
      } = params;
      const isCenteredSlides = swiper.params.centeredSlides;
      if (isCenteredSlides) {
        const margin = slidesSizesGrid[0] / 2 - swiper.params.slidesOffsetBefore || 0;
        $wrapperEl.transform(`translateX(calc(50% - ${margin}px))`);
      }
      for (let i4 = 0; i4 < slides.length; i4 += 1) {
        const $slideEl = slides.eq(i4);
        const slideProgress = $slideEl[0].progress;
        const progress = Math.min(Math.max($slideEl[0].progress, -params.limitProgress), params.limitProgress);
        let originalProgress = progress;
        if (!isCenteredSlides) {
          originalProgress = Math.min(Math.max($slideEl[0].originalProgress, -params.limitProgress), params.limitProgress);
        }
        const offset2 = $slideEl[0].swiperSlideOffset;
        const t4 = [swiper.params.cssMode ? -offset2 - swiper.translate : -offset2, 0, 0];
        const r4 = [0, 0, 0];
        let custom = false;
        if (!swiper.isHorizontal()) {
          t4[1] = t4[0];
          t4[0] = 0;
        }
        let data = {
          translate: [0, 0, 0],
          rotate: [0, 0, 0],
          scale: 1,
          opacity: 1
        };
        if (progress < 0) {
          data = params.next;
          custom = true;
        } else if (progress > 0) {
          data = params.prev;
          custom = true;
        }
        t4.forEach((value, index2) => {
          t4[index2] = `calc(${value}px + (${getTranslateValue(data.translate[index2])} * ${Math.abs(progress * multiplier)}))`;
        });
        r4.forEach((value, index2) => {
          r4[index2] = data.rotate[index2] * Math.abs(progress * multiplier);
        });
        $slideEl[0].style.zIndex = -Math.abs(Math.round(slideProgress)) + slides.length;
        const translateString = t4.join(", ");
        const rotateString = `rotateX(${r4[0]}deg) rotateY(${r4[1]}deg) rotateZ(${r4[2]}deg)`;
        const scaleString = originalProgress < 0 ? `scale(${1 + (1 - data.scale) * originalProgress * multiplier})` : `scale(${1 - (1 - data.scale) * originalProgress * multiplier})`;
        const opacityString = originalProgress < 0 ? 1 + (1 - data.opacity) * originalProgress * multiplier : 1 - (1 - data.opacity) * originalProgress * multiplier;
        const transform2 = `translate3d(${translateString}) ${rotateString} ${scaleString}`;
        if (custom && data.shadow || !custom) {
          let $shadowEl = $slideEl.children(".swiper-slide-shadow");
          if ($shadowEl.length === 0 && data.shadow) {
            $shadowEl = createShadow(params, $slideEl);
          }
          if ($shadowEl.length) {
            const shadowOpacity = params.shadowPerProgress ? progress * (1 / params.limitProgress) : progress;
            $shadowEl[0].style.opacity = Math.min(Math.max(Math.abs(shadowOpacity), 0), 1);
          }
        }
        const $targetEl = effectTarget(params, $slideEl);
        $targetEl.transform(transform2).css({
          opacity: opacityString
        });
        if (data.origin) {
          $targetEl.css("transform-origin", data.origin);
        }
      }
    };
    const setTransition2 = (duration) => {
      const {
        transformEl
      } = swiper.params.creativeEffect;
      const $transitionElements = transformEl ? swiper.slides.find(transformEl) : swiper.slides;
      $transitionElements.transition(duration).find(".swiper-slide-shadow").transition(duration);
      effectVirtualTransitionEnd({
        swiper,
        duration,
        transformEl,
        allSlides: true
      });
    };
    effectInit({
      effect: "creative",
      swiper,
      on: on2,
      setTranslate: setTranslate2,
      setTransition: setTransition2,
      perspective: () => swiper.params.creativeEffect.perspective,
      overwriteParams: () => ({
        watchSlidesProgress: true,
        virtualTranslate: !swiper.params.cssMode
      })
    });
  }

  // resources/js/app.js
  var import_Inputmask = __toModule(require_inputmask());
  if (document.querySelector(".reels-cat-list")) {
    const reelsCatCarousel = new H(document.querySelector(".reels-cat-list"), {
      Navigation: false,
      Dots: false,
      center: false,
      slidesPerPage: "auto",
      infinite: false
    });
  }
  if (document.querySelector(".news-list")) {
    let newsCarousel = new H(document.querySelector(".news-list"), {
      Navigation: false,
      Dots: true,
      center: false,
      slidesPerPage: 1,
      infinite: false,
      on: {
        refresh: (carousel) => {
          console.log("refreshNews", carousel.pages.length);
        }
      }
    });
  }
  if (document.querySelector("#customer_details")) {
    i_phone = new import_Inputmask.default("+7 (999) 999-99-99");
    i_phone.mask("#billing_phone");
  }
  var i_phone;
  if (document.querySelector(".multicomplex")) {
    let createPostersSlider = function(el) {
      const swiperEl = el.querySelector(".swiper");
      const calcNextOffset = () => {
        const parentWidth = swiperEl.parentElement.offsetWidth;
        const swiperWidth = swiperEl.offsetWidth;
        let nextOffset = (parentWidth - (parentWidth - swiperWidth) / 2) / swiperWidth;
        nextOffset = Math.max(nextOffset, 1);
        return `${nextOffset * -100}%`;
      };
      const postersSwiper = new core_default(swiperEl, {
        modules: [Navigation, Parallax, EffectCreative],
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev"
        },
        effect: "creative",
        speed: 600,
        resistanceRatio: 0,
        grabCursor: true,
        parallax: true,
        creativeEffect: {
          limitProgress: 3,
          perspective: true,
          shadowPerProgress: true,
          prev: {
            shadow: true,
            translate: [calcNextOffset(), 0, 0]
          },
          next: {
            translate: ["15%", 0, -200]
          }
        },
        breakpoints: {
          1440: {
            creativeEffect: {
              limitProgress: 3,
              perspective: true,
              shadowPerProgress: true,
              prev: {
                shadow: true,
                translate: [calcNextOffset(), 0, 0]
              },
              next: {
                translate: ["75%", 0, -200]
              }
            }
          },
          1200: {
            creativeEffect: {
              limitProgress: 3,
              perspective: true,
              shadowPerProgress: true,
              prev: {
                shadow: true,
                translate: [calcNextOffset(), 0, 0]
              },
              next: {
                translate: ["40%", 0, -200]
              }
            }
          }
        }
      });
      return postersSwiper;
    };
    const sliderEl = document.querySelector(".multicomplex");
    createPostersSlider(sliderEl);
  }
  if (document.querySelector(".reels-wrapper")) {
    let reelsCarousel2 = new H(document.querySelector(".reels-wrapper"), {
      Navigation: false,
      Dots: true,
      center: false,
      slidesPerPage: "auto",
      infinite: true,
      clickSlide: true,
      on: {
        refresh: (carousel) => {
          console.log("refreshReels", carousel.pages.length);
          console.log("wtf", carousel);
          if (carousel.pages.length < 6) {
            document.querySelector(".reels-items-list").classList.add("cleared");
          }
        },
        change: (carousel) => {
          console.log("index ", carousel.page);
          if (carousel.page + 1 >= carousel.pages.length) {
            document.querySelector(".reels-items-list").classList.add("end");
          } else {
            document.querySelector(".reels-items-list").classList.remove("end");
          }
        }
      }
    });
  }
  if (document.querySelector("#productMainCarousel")) {
    let mainCarousel;
    if (document.querySelector("#top-product").classList.contains("product-square")) {
      let Axis = document.querySelector("#top-product").classList.contains("product-square") ? "y" : "x";
      mainCarousel = new H(document.querySelector("#productMainCarousel"), {
        Navigation: false,
        Dots: true,
        axis: "x",
        Thumbs: {
          type: "classic",
          Carousel: {
            dragFree: false,
            slidesPerPage: 1,
            Navigation: {
              prevTpl: '<svg width="38" height="18" viewBox="0 0 38 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M37 17L21.0964 2.54315C19.5264 1.11603 17.1153 1.16294 15.6021 2.65005L1 17" stroke="#C2C2C2" stroke-width="2"/></svg>',
              nextTpl: '<svg width="38" height="18" viewBox="0 0 38 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 1L16.9036 15.4568C18.4736 16.884 20.8847 16.8371 22.3979 15.3499L37 1" stroke="#C2C2C2" stroke-width="2"/></svg>'
            },
            axis: Axis
          }
        },
        breakpoints: {
          "(min-width: 768px)": {
            Dots: false,
            axis: Axis
          }
        }
      }, { Thumbs: p3 });
    } else {
      mainCarousel = new H(document.querySelector("#productMainCarousel"), {
        Navigation: false,
        Dots: true,
        preload: 1,
        breakpoints: {
          "(min-width: 768px)": {
            Dots: false
          }
        }
      });
    }
    if (document.querySelector("#productThumbCarousel")) {
      const thumbCarousel = new H(document.querySelector("#productThumbCarousel"), {
        Sync: {
          target: mainCarousel,
          friction: 0
        },
        Dots: false,
        Navigation: false,
        center: false,
        slidesPerPage: "auto",
        infinite: false
      });
    }
  }
  if (document.querySelector("#section-product")) {
    if (document.querySelector("#section-product .product-list").querySelector(".item-product")) {
      const prodCarousel = new H(document.querySelector("#section-product .product-list"), {
        Dots: false,
        Navigation: true,
        slidesPerPage: "auto",
        infinite: true
      });
    }
  }
  if (document.querySelector(".cross-sells")) {
    if (document.querySelector(".cross-sells .products").querySelector(".product")) {
      const crossellsCarousel = new H(document.querySelector(".cross-sells .products"), {
        l10n: {
          CLOSE: "\u0417\u0430\u043A\u0440\u044B\u0442\u044C",
          NEXT: "\u0421\u043B\u0435\u0434\u0443\u044E\u0449\u0438\u0439",
          PREV: "\u041F\u0440\u0435\u0434\u044B\u0434\u0443\u0449\u0438\u0439"
        },
        Dots: false,
        Navigation: true,
        slidesPerPage: 4,
        infinite: true
      });
    }
  }
  if (document.querySelector('[data-fancybox="backordermodal"]')) {
    xt.bind('[data-fancybox="backordermodal"]', {
      Toolbar: false,
      click: false,
      Thumbs: false
    });
  }
  if (document.querySelector('[data-fancybox="backordermodal_bar"]')) {
    xt.bind('[data-fancybox="backordermodal_bar"]', {
      Toolbar: false,
      click: false,
      Thumbs: false
    });
  }
  if (document.querySelector('[data-fancybox="reviews_gallery"]')) {
    xt.bind('[data-fancybox="reviews_gallery"]', {
      Toolbar: false,
      click: false,
      Thumbs: false
    });
  }
  if (document.querySelector('[data-fancybox="video_gallery"]')) {
    xt.bind('[data-fancybox="video_gallery"]', {
      Toolbar: false,
      click: false,
      Thumbs: false,
      Carousel: {
        Dots: true
      },
      closeButton: "top",
      Image: {
        zoom: false,
        click: false
      },
      on: {
        init: (Fancybox) => {
          document.querySelector("body").classList.add("video_gallery_modal");
          document.querySelector("body").classList.remove("reviews_gallery_modal");
        }
      }
    });
  }
  if (document.querySelector('[data-fancybox="reviews_gallery"]')) {
    xt.bind('[data-fancybox="reviews_gallery"]', {
      l10n: {
        CLOSE: "\u0417\u0430\u043A\u0440\u044B\u0442\u044C",
        NEXT: "\u0421\u043B\u0435\u0434\u0443\u044E\u0449\u0438\u0439",
        PREV: "\u041F\u0440\u0435\u0434\u044B\u0434\u0443\u0449\u0438\u0439"
      },
      Toolbar: false,
      click: false,
      Thumbs: false,
      Carousel: {
        Dots: false,
        Navigation: false
      },
      closeButton: "top",
      Image: {
        zoom: false,
        click: false
      },
      on: {
        init: (Fancybox) => {
          document.querySelector("body").classList.add("reviews_gallery_modal");
          document.querySelector("body").classList.remove("video_gallery_modal");
        }
      }
    });
  }
  $ = jQuery;
  $(document).ready(function() {
    console.log("here1");
    if (document.body.clientWidth < 601) {
      console.log("here2");
      $("#product-bar").appendTo("footer");
    }
    $('form[role="search"]').on("submit", function(e4) {
      e4.preventDefault();
      search_suggest($(e4.target).find(".search-input").val());
      return false;
    });
    $('form[role="search"] input.search-input').on("keyup", function(e4) {
      console.log(e4.target.value.length, e4.target.value);
      if (e4.target.value.length > 2) {
        search_suggest(e4.target.value);
      } else {
        $("#modal-suggest").hide();
      }
    });
    $("body").on("click", function(e4) {
      let needle = "";
      console.log($(e4.target));
      if ($(e4.target).hasClass("item-reels-cat")) {
        needle = $(e4.target);
        get_selected_cat_reviews(needle);
      } else if ($(e4.target).parent().hasClass("item-reels-cat")) {
        needle = $(e4.target).parent();
        get_selected_cat_reviews(needle);
      } else if ($(e4.target).parent().parent().hasClass("item-reels-cat")) {
        needle = $(e4.target).parent().parent();
        get_selected_cat_reviews(needle);
      } else if ($(e4.target).hasClass("item-news-cat")) {
        needle = $(e4.target);
        get_selected_cat_videos(needle);
        needle.siblings(".item-news-cat").removeClass("active");
        needle.addClass("active");
      } else if ($(e4.target).parent().hasClass("item-news-cat")) {
        needle = $(e4.target).parent();
        get_selected_cat_videos(needle);
        needle.siblings(".item-news-cat").removeClass("active");
        needle.addClass("active");
      } else if ($(e4.target).parent().parent().hasClass("item-news-cat")) {
        needle = $(e4.target).parent().parent();
        get_selected_cat_videos(needle);
        needle.siblings(".item-news-cat").removeClass("active");
        needle.addClass("active");
      } else if ($(e4.target).hasClass("video-player") || $(e4.target).parent().hasClass("video-player") || $(e4.target).parent().parent().hasClass("video-player")) {
        let video_wrap = document.querySelector("#video-player");
        setupVideo(video_wrap.getAttribute("data-yt"));
        console.log("12", video_wrap.getAttribute("data-yt"));
      } else if ($(e4.target).hasClass("video-list-item")) {
        let video_wrap = $("#video-player");
        video_wrap.attr("data-yt", $(e4.target).data("yt"));
        video_wrap.find("iframe").remove();
        video_wrap.find("img").attr("src", $(e4.target).data("preview"));
      } else if ($(e4.target).parent().parent().parent().hasClass("catalog-nav-toggler") || $(e4.target).parent().parent().hasClass("catalog-nav-toggler") || $(e4.target).parent().hasClass("catalog-nav-toggler") || $(e4.target).hasClass("catalog-nav-toggler")) {
        $("#nav-catalog").toggleClass("active");
        $("body").toggleClass("paused");
      } else if ($(e4.target).hasClass("nav-bg")) {
        $("#nav-catalog").removeClass("active");
        $("#mobile-search").removeClass("active");
        $("body").removeClass("paused");
      } else if (jQuery(e4.target).is("button.one-click-btn")) {
        var i_phone = new import_Inputmask.default("+7 (\\999) 999-99-99");
        i_phone.mask("#oneclick_phone");
      } else if (jQuery(e4.target).is(".showmore-atts") || $(e4.target).parent().is(".showmore-atts")) {
        console.log("shw-mr-tts");
        jQuery(".right-col").find("li").each(function() {
          $(this).removeClass("!hidden");
        });
        jQuery(".right-col").find(".showmore-atts").hide();
      } else if ($(e4.target).hasClass("rank-math-list-item") || $(e4.target).parent().hasClass("rank-math-list-item")) {
        $(e4.target).closest(".rank-math-list-item").toggleClass("active");
      } else if (jQuery(e4.target).is("button.backorder-btn")) {
        var i_phone = new import_Inputmask.default("+7 (999) 999-99-99");
        i_phone.mask("#backorder_phone");
      } else if ($(e4.target).parent().parent().hasClass("search-cross") || $(e4.target).parent().hasClass("search-cross") || $(e4.target).hasClass("search-cross")) {
        $(e4.target).closest(".search-cross").prev(".search-input").val("");
        $("#modal-suggest").hide();
      } else if ($(e4.target).parent().parent().parent().hasClass("search-mobile-toggler") || $(e4.target).parent().parent().hasClass("search-mobile-toggler") || $(e4.target).parent().hasClass("search-mobile-toggler") || $(e4.target).hasClass("search-mobile-toggler")) {
        $("#mobile-search").toggleClass("active");
        $("body").toggleClass("paused");
        $("#bar").toggleClass("frontest");
      } else if ($(e4.target).parent().is(".checkbox_ship")) {
        let type = $(e4.target).attr("id").replace("vis_", "#shipping_method_");
        $(type).click();
        jQuery("body").trigger("update_checkout");
        console.log(type, "clicked");
      } else if ($(e4.target).parent().is(".checkbox")) {
        let type = $(e4.target).attr("id").replace("vis_", "#payment_method_");
        $(type).click();
        console.log(type);
      }
    });
    window.modal_plus = () => {
      var val = parseInt($("#addedmodal").find("input").val()) + 1;
      $(".single_add_to_cart_button").siblings(".quantity").find('input[name="quantity"]').val(val);
      $("#addedmodal").find("input").val(val);
    };
    window.modal_minus = () => {
      var val = $("#addedmodal").find("input").val() - 1;
      $(".single_add_to_cart_button").siblings(".quantity").find('input[name="quantity"]').val(val);
      $("#addedmodal").find("input").val(val);
    };
    window.modal_submit = () => {
      $(".single_add_to_cart_button").click();
      setTimeout(() => {
        window.location.href = "/cart/";
      }, 1e3);
    };
  });
  function get_selected_cat_reviews(cat) {
    console.log(cat.data("reviewCat"));
    jQuery.ajax({
      url: "/wp-admin/admin-ajax.php",
      type: "POST",
      data: {
        dataType: "json",
        action: "get_selected_cat_reviews",
        term_id: cat.data("reviewCat")
      },
      success: function(data) {
        $(".reels-items-list").html(data);
        reelsCarousel = new H(document.querySelector(".reels-wrapper"), {
          Navigation: false,
          Dots: false,
          center: false,
          slidesPerPage: "auto",
          infinite: true,
          on: {
            refresh: (carousel) => {
              console.log("refreshReels2", carousel.pages.length);
            },
            change: (carousel) => {
              console.log("index ", carousel.page);
              if (carousel.page + 1 >= carousel.pages.length) {
                document.querySelector(".reels-items-list").classList.add("end");
              } else {
                document.querySelector(".reels-items-list").classList.remove("end");
              }
            }
          }
        });
      },
      error: function(errorThrown) {
        console.log(errorThrown);
      }
    });
  }
  function get_selected_cat_videos(cat) {
    console.log(cat.data("videoCat"));
    jQuery.ajax({
      url: "/wp-admin/admin-ajax.php",
      type: "POST",
      data: {
        dataType: "json",
        action: "get_selected_cat_videos",
        term_id: cat.data("videoCat")
      },
      success: function(data) {
        console.log(data);
        $(".news-list").html(data);
        let newsCarousel = new H(document.querySelector(".news-list"), {
          Navigation: false,
          Dots: true,
          center: false,
          slidesPerPage: 1,
          infinite: false,
          on: {
            refresh: (carousel) => {
              console.log("refreshVideo", carousel.pages.length);
            }
          }
        });
      },
      error: function(errorThrown) {
        console.log(errorThrown);
      }
    });
  }
  var lastScrollTop = 0;
  $(window).scroll(function(event2) {
    var st2 = $(this).scrollTop();
    if (st2 > 150) {
      if (st2 > lastScrollTop) {
        $("body").removeClass("fixed_header");
      } else {
        $("body").addClass("fixed_header");
      }
      lastScrollTop = st2;
    }
    if (st2 > 550) {
      $("body").addClass("show_subheader");
    } else {
      $("body").removeClass("show_subheader");
    }
  });
  function generateURL(id) {
    let query = "?rel=0&showinfo=0&autoplay=1";
    return "https://www.youtube.com/embed/" + id + query;
  }
  function createIframe(id) {
    let iframe = document.createElement("iframe");
    iframe.setAttribute("allowfullscreen", "");
    iframe.setAttribute("allow", "autoplay");
    iframe.setAttribute("src", generateURL(id));
    return iframe;
  }
  function setupVideo(id) {
    let videoPlayer = document.querySelector("#video-player");
    let iframe = createIframe(id);
    videoPlayer.insertBefore(iframe, videoPlayer.querySelector("picture"));
  }
  $(document).on("change", ".variation-radios input", function() {
    $(".variation-radios input:checked").each(function(index2, element) {
      var $el = $(element);
      $el.parents(".variation-radios").find("input").removeAttr("checked");
      $el.attr("checked", "checked");
      var thisName = $el.attr("name");
      var thisVal = $el.attr("value");
      $('select[name="' + thisName + '"]').val(thisVal).trigger("change");
      var var_price = $(element).siblings("label").find("span.var_price").text();
      var var_name = $(element).siblings("label").find("span.var_name").text();
      $("#addedmodal").find(".regular-price").text(var_price);
      $("#addedmodal").find(".subheadline span").text(var_name);
    });
  });
  $(document).on("woocommerce_update_variation_values", function() {
    $(".variation-radios input").each(function(index2, element) {
      var $el = $(element);
      var thisName = $el.attr("name");
      var thisVal = $el.attr("value");
      $el.removeAttr("disabled");
      if ($('select[name="' + thisName + '"] option[value="' + thisVal + '"]').is(":disabled")) {
        $el.prop("disabled", true);
      }
    });
  });
})();
/*!
 * dist/inputmask
 * https://github.com/RobinHerbots/Inputmask
 * Copyright (c) 2010 - 2021 Robin Herbots
 * Licensed under the MIT license
 * Version: 5.0.7
 */




if (document.documentElement.clientWidth < 768) {
// Выбираем все элементы на странице с классом price
  var priceBlocks = document.querySelectorAll(".pricing-wrap");

// Проходимся по каждому блоку циклом
  priceBlocks.forEach(function(priceBlock) {
    // Проверяем, есть ли внутри блока тег <del>
    if (!priceBlock.querySelector("del")) {
      // Если тег <del> отсутствует, скрываем блок
      priceBlock.style.display = "none";
    }
  });
}

