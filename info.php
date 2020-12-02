<?php echo phpinfo(); ?>
<script>
    function FastClick(n, t) {
        "use strict";
        function e(n, t) {
            return function () {
                return n.apply(t, arguments)
            }
        }

        var f;
        if (t = t || {}, this.trackingClick = !1, this.trackingClickStart = 0, this.targetElement = null, this.touchStartX = 0, this.touchStartY = 0, this.lastTouchIdentifier = 0, this.touchBoundary = t.touchBoundary || 10, this.layer = n, this.tapDelay = t.tapDelay || 200, !FastClick.notNeeded(n)) {
            for (var r = ["onMouse", "onClick", "onTouchStart", "onTouchMove", "onTouchEnd", "onTouchCancel"], u = this, i = 0, o = r.length; o > i; i++)u[r[i]] = e(u[r[i]], u);
            deviceIsAndroid && (n.addEventListener("mouseover", this.onMouse, !0), n.addEventListener("mousedown", this.onMouse, !0), n.addEventListener("mouseup", this.onMouse, !0));
            n.addEventListener("click", this.onClick, !0);
            n.addEventListener("touchstart", this.onTouchStart, !1);
            n.addEventListener("touchmove", this.onTouchMove, !1);
            n.addEventListener("touchend", this.onTouchEnd, !1);
            n.addEventListener("touchcancel", this.onTouchCancel, !1);
            Event.prototype.stopImmediatePropagation || (n.removeEventListener = function (t, i, r) {
                var u = Node.prototype.removeEventListener;
                "click" === t ? u.call(n, t, i.hijacked || i, r) : u.call(n, t, i, r)
            }, n.addEventListener = function (t, i, r) {
                var u = Node.prototype.addEventListener;
                "click" === t ? u.call(n, t, i.hijacked || (i.hijacked = function (n) {
                        n.propagationStopped || i(n)
                    }), r) : u.call(n, t, i, r)
            });
            "function" == typeof n.onclick && (f = n.onclick, n.addEventListener("click", function (n) {
                f(n)
            }, !1), n.onclick = null)
        }
    }
    function validTel(n) {
        return /^([0-9\s\-\+\/\.()])+$/.test(n)
    }
    function isPostcodeValid(n, t) {
        if (n != 76)return !0;
        return console.log("postcode: ", t), /([A-Za-z])+/.test(t) && /[0-9]/.test(t)
    }
    function ecomData(n) {
        var t = {event: n.event, ecommerce: n.ecommerce};
        return dataLayer.push(t), console.log(t), t
    }
    function reachedConfirmation() {
        ecomData({event: "checkout", ecommerce: {actionField: {step: 7}}})
    }
    function onYouTubeIframeAPIReady() {
        BBay.YouTubeVideo.init()
    }
    var Mailcheck, Address, popUpMenu;
    (function (n) {
        "function" == typeof define && define.amd ? define(["jquery"], n) : n(jQuery)
    })(function (n) {
        function r(t, i) {
            var r, f, e, o = t.nodeName.toLowerCase();
            return "area" === o ? (r = t.parentNode, f = r.name, t.href && f && "map" === r.nodeName.toLowerCase() ? (e = n("img[usemap='#" + f + "']")[0], !!e && u(e)) : !1) : (/input|select|textarea|button|object/.test(o) ? !t.disabled : "a" === o ? t.href || i : i) && u(t)
        }

        function u(t) {
            return n.expr.filters.visible(t) && !n(t).parents().addBack().filter(function () {
                    return "hidden" === n.css(this, "visibility")
                }).length
        }

        var f, i, t;
        n.ui = n.ui || {};
        n.extend(n.ui, {
            version: "1.11.2",
            keyCode: {
                BACKSPACE: 8,
                COMMA: 188,
                DELETE: 46,
                DOWN: 40,
                END: 35,
                ENTER: 13,
                ESCAPE: 27,
                HOME: 36,
                LEFT: 37,
                PAGE_DOWN: 34,
                PAGE_UP: 33,
                PERIOD: 190,
                RIGHT: 39,
                SPACE: 32,
                TAB: 9,
                UP: 38
            }
        });
        n.fn.extend({
            scrollParent: function (t) {
                var i = this.css("position"), u = "absolute" === i, f = t ? /(auto|scroll|hidden)/ : /(auto|scroll)/,
                    r = this.parents().filter(function () {
                        var t = n(this);
                        return u && "static" === t.css("position") ? !1 : f.test(t.css("overflow") + t.css("overflow-y") + t.css("overflow-x"))
                    }).eq(0);
                return "fixed" !== i && r.length ? r : n(this[0].ownerDocument || document)
            }, uniqueId: function () {
                var n = 0;
                return function () {
                    return this.each(function () {
                        this.id || (this.id = "ui-id-" + ++n)
                    })
                }
            }(), removeUniqueId: function () {
                return this.each(function () {
                    /^ui-id-\d+$/.test(this.id) && n(this).removeAttr("id")
                })
            }
        });
        n.extend(n.expr[":"], {
            data: n.expr.createPseudo ? n.expr.createPseudo(function (t) {
                return function (i) {
                    return !!n.data(i, t)
                }
            }) : function (t, i, r) {
                return !!n.data(t, r[3])
            }, focusable: function (t) {
                return r(t, !isNaN(n.attr(t, "tabindex")))
            }, tabbable: function (t) {
                var i = n.attr(t, "tabindex"), u = isNaN(i);
                return (u || i >= 0) && r(t, !u)
            }
        });
        n("<a>").outerWidth(1).jquery || n.each(["Width", "Height"], function (t, i) {
            function r(t, i, r, u) {
                return n.each(e, function () {
                    i -= parseFloat(n.css(t, "padding" + this)) || 0;
                    r && (i -= parseFloat(n.css(t, "border" + this + "Width")) || 0);
                    u && (i -= parseFloat(n.css(t, "margin" + this)) || 0)
                }), i
            }

            var e = "Width" === i ? ["Left", "Right"] : ["Top", "Bottom"], u = i.toLowerCase(), f = {
                innerWidth: n.fn.innerWidth,
                innerHeight: n.fn.innerHeight,
                outerWidth: n.fn.outerWidth,
                outerHeight: n.fn.outerHeight
            };
            n.fn["inner" + i] = function (t) {
                return void 0 === t ? f["inner" + i].call(this) : this.each(function () {
                    n(this).css(u, r(this, t) + "px")
                })
            };
            n.fn["outer" + i] = function (t, e) {
                return "number" != typeof t ? f["outer" + i].call(this, t) : this.each(function () {
                    n(this).css(u, r(this, t, !0, e) + "px")
                })
            }
        });
        n.fn.addBack || (n.fn.addBack = function (n) {
            return this.add(null == n ? this.prevObject : this.prevObject.filter(n))
        });
        n("<a>").data("a-b", "a").removeData("a-b").data("a-b") && (n.fn.removeData = function (t) {
            return function (i) {
                return arguments.length ? t.call(this, n.camelCase(i)) : t.call(this)
            }
        }(n.fn.removeData));
        n.ui.ie = !!/msie [\w.]+/.exec(navigator.userAgent.toLowerCase());
        n.fn.extend({
            focus: function (t) {
                return function (i, r) {
                    return "number" == typeof i ? this.each(function () {
                        var t = this;
                        setTimeout(function () {
                            n(t).focus();
                            r && r.call(t)
                        }, i)
                    }) : t.apply(this, arguments)
                }
            }(n.fn.focus), disableSelection: function () {
                var n = "onselectstart" in document.createElement("div") ? "selectstart" : "mousedown";
                return function () {
                    return this.bind(n + ".ui-disableSelection", function (n) {
                        n.preventDefault()
                    })
                }
            }(), enableSelection: function () {
                return this.unbind(".ui-disableSelection")
            }, zIndex: function (t) {
                if (void 0 !== t)return this.css("zIndex", t);
                if (this.length)for (var r, u, i = n(this[0]); i.length && i[0] !== document;) {
                    if (r = i.css("position"), ("absolute" === r || "relative" === r || "fixed" === r) && (u = parseInt(i.css("zIndex"), 10), !isNaN(u) && 0 !== u))return u;
                    i = i.parent()
                }
                return 0
            }
        });
        n.ui.plugin = {
            add: function (t, i, r) {
                var u, f = n.ui[t].prototype;
                for (u in r)f.plugins[u] = f.plugins[u] || [], f.plugins[u].push([i, r[u]])
            }, call: function (n, t, i, r) {
                var u, f = n.plugins[t];
                if (f && (r || n.element[0].parentNode && 11 !== n.element[0].parentNode.nodeType))for (u = 0; f.length > u; u++)n.options[f[u][0]] && f[u][1].apply(n.element, i)
            }
        };
        f = 0;
        i = Array.prototype.slice;
        n.cleanData = function (t) {
            return function (i) {
                for (var r, u, f = 0; null != (u = i[f]); f++)try {
                    r = n._data(u, "events");
                    r && r.remove && n(u).triggerHandler("remove")
                } catch (n) {
                }
                t(i)
            }
        }(n.cleanData);
        n.widget = function (t, i, r) {
            var s, f, u, o, h = {}, e = t.split(".")[0];
            return t = t.split(".")[1], s = e + "-" + t, r || (r = i, i = n.Widget), n.expr[":"][s.toLowerCase()] = function (t) {
                return !!n.data(t, s)
            }, n[e] = n[e] || {}, f = n[e][t], u = n[e][t] = function (n, t) {
                return this._createWidget ? (arguments.length && this._createWidget(n, t), void 0) : new u(n, t)
            }, n.extend(u, f, {
                version: r.version,
                _proto: n.extend({}, r),
                _childConstructors: []
            }), o = new i, o.options = n.widget.extend({}, o.options), n.each(r, function (t, r) {
                return n.isFunction(r) ? (h[t] = function () {
                    var n = function () {
                        return i.prototype[t].apply(this, arguments)
                    }, u = function (n) {
                        return i.prototype[t].apply(this, n)
                    };
                    return function () {
                        var t, i = this._super, f = this._superApply;
                        return this._super = n, this._superApply = u, t = r.apply(this, arguments), this._super = i, this._superApply = f, t
                    }
                }(), void 0) : (h[t] = r, void 0)
            }), u.prototype = n.widget.extend(o, {widgetEventPrefix: f ? o.widgetEventPrefix || t : t}, h, {
                constructor: u,
                namespace: e,
                widgetName: t,
                widgetFullName: s
            }), f ? (n.each(f._childConstructors, function (t, i) {
                var r = i.prototype;
                n.widget(r.namespace + "." + r.widgetName, u, i._proto)
            }), delete f._childConstructors) : i._childConstructors.push(u), n.widget.bridge(t, u), u
        };
        n.widget.extend = function (t) {
            for (var r, u, e = i.call(arguments, 1), f = 0, o = e.length; o > f; f++)for (r in e[f])u = e[f][r], e[f].hasOwnProperty(r) && void 0 !== u && (t[r] = n.isPlainObject(u) ? n.isPlainObject(t[r]) ? n.widget.extend({}, t[r], u) : n.widget.extend({}, u) : u);
            return t
        };
        n.widget.bridge = function (t, r) {
            var u = r.prototype.widgetFullName || t;
            n.fn[t] = function (f) {
                var s = "string" == typeof f, o = i.call(arguments, 1), e = this;
                return f = !s && o.length ? n.widget.extend.apply(null, [f].concat(o)) : f, s ? this.each(function () {
                    var i, r = n.data(this, u);
                    return "instance" === f ? (e = r, !1) : r ? n.isFunction(r[f]) && "_" !== f.charAt(0) ? (i = r[f].apply(r, o), i !== r && void 0 !== i ? (e = i && i.jquery ? e.pushStack(i.get()) : i, !1) : void 0) : n.error("no such method '" + f + "' for " + t + " widget instance") : n.error("cannot call methods on " + t + " prior to initialization; attempted to call method '" + f + "'")
                }) : this.each(function () {
                    var t = n.data(this, u);
                    t ? (t.option(f || {}), t._init && t._init()) : n.data(this, u, new r(f, this))
                }), e
            }
        };
        n.Widget = function () {
        };
        n.Widget._childConstructors = [];
        n.Widget.prototype = {
            widgetName: "widget",
            widgetEventPrefix: "",
            defaultElement: "<div>",
            options: {disabled: !1, create: null},
            _createWidget: function (t, i) {
                i = n(i || this.defaultElement || this)[0];
                this.element = n(i);
                this.uuid = f++;
                this.eventNamespace = "." + this.widgetName + this.uuid;
                this.bindings = n();
                this.hoverable = n();
                this.focusable = n();
                i !== this && (n.data(i, this.widgetFullName, this), this._on(!0, this.element, {
                    remove: function (n) {
                        n.target === i && this.destroy()
                    }
                }), this.document = n(i.style ? i.ownerDocument : i.document || i), this.window = n(this.document[0].defaultView || this.document[0].parentWindow));
                this.options = n.widget.extend({}, this.options, this._getCreateOptions(), t);
                this._create();
                this._trigger("create", null, this._getCreateEventData());
                this._init()
            },
            _getCreateOptions: n.noop,
            _getCreateEventData: n.noop,
            _create: n.noop,
            _init: n.noop,
            destroy: function () {
                this._destroy();
                this.element.unbind(this.eventNamespace).removeData(this.widgetFullName).removeData(n.camelCase(this.widgetFullName));
                this.widget().unbind(this.eventNamespace).removeAttr("aria-disabled").removeClass(this.widgetFullName + "-disabled ui-state-disabled");
                this.bindings.unbind(this.eventNamespace);
                this.hoverable.removeClass("ui-state-hover");
                this.focusable.removeClass("ui-state-focus")
            },
            _destroy: n.noop,
            widget: function () {
                return this.element
            },
            option: function (t, i) {
                var r, u, f, e = t;
                if (0 === arguments.length)return n.widget.extend({}, this.options);
                if ("string" == typeof t)if (e = {}, r = t.split("."), t = r.shift(), r.length) {
                    for (u = e[t] = n.widget.extend({}, this.options[t]), f = 0; r.length - 1 > f; f++)u[r[f]] = u[r[f]] || {}, u = u[r[f]];
                    if (t = r.pop(), 1 === arguments.length)return void 0 === u[t] ? null : u[t];
                    u[t] = i
                } else {
                    if (1 === arguments.length)return void 0 === this.options[t] ? null : this.options[t];
                    e[t] = i
                }
                return this._setOptions(e), this
            },
            _setOptions: function (n) {
                var t;
                for (t in n)this._setOption(t, n[t]);
                return this
            },
            _setOption: function (n, t) {
                return this.options[n] = t, "disabled" === n && (this.widget().toggleClass(this.widgetFullName + "-disabled", !!t), t && (this.hoverable.removeClass("ui-state-hover"), this.focusable.removeClass("ui-state-focus"))), this
            },
            enable: function () {
                return this._setOptions({disabled: !1})
            },
            disable: function () {
                return this._setOptions({disabled: !0})
            },
            _on: function (t, i, r) {
                var f, u = this;
                "boolean" != typeof t && (r = i, i = t, t = !1);
                r ? (i = f = n(i), this.bindings = this.bindings.add(i)) : (r = i, i = this.element, f = this.widget());
                n.each(r, function (r, e) {
                    function o() {
                        if (t || u.options.disabled !== !0 && !n(this).hasClass("ui-state-disabled"))return ("string" == typeof e ? u[e] : e).apply(u, arguments)
                    }

                    "string" != typeof e && (o.guid = e.guid = e.guid || o.guid || n.guid++);
                    var s = r.match(/^([\w:-]*)\s*(.*)$/), h = s[1] + u.eventNamespace, c = s[2];
                    c ? f.delegate(c, h, o) : i.bind(h, o)
                })
            },
            _off: function (t, i) {
                i = (i || "").split(" ").join(this.eventNamespace + " ") + this.eventNamespace;
                t.unbind(i).undelegate(i);
                this.bindings = n(this.bindings.not(t).get());
                this.focusable = n(this.focusable.not(t).get());
                this.hoverable = n(this.hoverable.not(t).get())
            },
            _delay: function (n, t) {
                function r() {
                    return ("string" == typeof n ? i[n] : n).apply(i, arguments)
                }

                var i = this;
                return setTimeout(r, t || 0)
            },
            _hoverable: function (t) {
                this.hoverable = this.hoverable.add(t);
                this._on(t, {
                    mouseenter: function (t) {
                        n(t.currentTarget).addClass("ui-state-hover")
                    }, mouseleave: function (t) {
                        n(t.currentTarget).removeClass("ui-state-hover")
                    }
                })
            },
            _focusable: function (t) {
                this.focusable = this.focusable.add(t);
                this._on(t, {
                    focusin: function (t) {
                        n(t.currentTarget).addClass("ui-state-focus")
                    }, focusout: function (t) {
                        n(t.currentTarget).removeClass("ui-state-focus")
                    }
                })
            },
            _trigger: function (t, i, r) {
                var u, f, e = this.options[t];
                if (r = r || {}, i = n.Event(i), i.type = (t === this.widgetEventPrefix ? t : this.widgetEventPrefix + t).toLowerCase(), i.target = this.element[0], f = i.originalEvent)for (u in f)u in i || (i[u] = f[u]);
                return this.element.trigger(i, r), !(n.isFunction(e) && e.apply(this.element[0], [i].concat(r)) === !1 || i.isDefaultPrevented())
            }
        };
        n.each({show: "fadeIn", hide: "fadeOut"}, function (t, i) {
            n.Widget.prototype["_" + t] = function (r, u, f) {
                "string" == typeof u && (u = {effect: u});
                var o, e = u ? u === !0 || "number" == typeof u ? i : u.effect || i : t;
                u = u || {};
                "number" == typeof u && (u = {duration: u});
                o = !n.isEmptyObject(u);
                u.complete = f;
                u.delay && r.delay(u.delay);
                o && n.effects && n.effects.effect[e] ? r[t](u) : e !== t && r[e] ? r[e](u.duration, u.easing, f) : r.queue(function (i) {
                    n(this)[t]();
                    f && f.call(r[0]);
                    i()
                })
            }
        });
        n.widget;
        t = !1;
        n(document).mouseup(function () {
            t = !1
        });
        n.widget("ui.mouse", {
            version: "1.11.2",
            options: {cancel: "input,textarea,button,select,option", distance: 1, delay: 0},
            _mouseInit: function () {
                var t = this;
                this.element.bind("mousedown." + this.widgetName, function (n) {
                    return t._mouseDown(n)
                }).bind("click." + this.widgetName, function (i) {
                    if (!0 === n.data(i.target, t.widgetName + ".preventClickEvent"))return (n.removeData(i.target, t.widgetName + ".preventClickEvent"), i.stopImmediatePropagation(), !1)
                });
                this.started = !1
            },
            _mouseDestroy: function () {
                this.element.unbind("." + this.widgetName);
                this._mouseMoveDelegate && this.document.unbind("mousemove." + this.widgetName, this._mouseMoveDelegate).unbind("mouseup." + this.widgetName, this._mouseUpDelegate)
            },
            _mouseDown: function (i) {
                if (!t) {
                    this._mouseMoved = !1;
                    this._mouseStarted && this._mouseUp(i);
                    this._mouseDownEvent = i;
                    var r = this, u = 1 === i.which,
                        f = "string" == typeof this.options.cancel && i.target.nodeName ? n(i.target).closest(this.options.cancel).length : !1;
                    return u && !f && this._mouseCapture(i) ? (this.mouseDelayMet = !this.options.delay, this.mouseDelayMet || (this._mouseDelayTimer = setTimeout(function () {
                        r.mouseDelayMet = !0
                    }, this.options.delay)), this._mouseDistanceMet(i) && this._mouseDelayMet(i) && (this._mouseStarted = this._mouseStart(i) !== !1, !this._mouseStarted) ? (i.preventDefault(), !0) : (!0 === n.data(i.target, this.widgetName + ".preventClickEvent") && n.removeData(i.target, this.widgetName + ".preventClickEvent"), this._mouseMoveDelegate = function (n) {
                        return r._mouseMove(n)
                    }, this._mouseUpDelegate = function (n) {
                        return r._mouseUp(n)
                    }, this.document.bind("mousemove." + this.widgetName, this._mouseMoveDelegate).bind("mouseup." + this.widgetName, this._mouseUpDelegate), i.preventDefault(), t = !0, !0)) : !0
                }
            },
            _mouseMove: function (t) {
                return this._mouseMoved && (n.ui.ie && (!document.documentMode || 9 > document.documentMode) && !t.button || !t.which) ? this._mouseUp(t) : ((t.which || t.button) && (this._mouseMoved = !0), this._mouseStarted ? (this._mouseDrag(t), t.preventDefault()) : (this._mouseDistanceMet(t) && this._mouseDelayMet(t) && (this._mouseStarted = this._mouseStart(this._mouseDownEvent, t) !== !1, this._mouseStarted ? this._mouseDrag(t) : this._mouseUp(t)), !this._mouseStarted))
            },
            _mouseUp: function (i) {
                return this.document.unbind("mousemove." + this.widgetName, this._mouseMoveDelegate).unbind("mouseup." + this.widgetName, this._mouseUpDelegate), this._mouseStarted && (this._mouseStarted = !1, i.target === this._mouseDownEvent.target && n.data(i.target, this.widgetName + ".preventClickEvent", !0), this._mouseStop(i)), t = !1, !1
            },
            _mouseDistanceMet: function (n) {
                return Math.max(Math.abs(this._mouseDownEvent.pageX - n.pageX), Math.abs(this._mouseDownEvent.pageY - n.pageY)) >= this.options.distance
            },
            _mouseDelayMet: function () {
                return this.mouseDelayMet
            },
            _mouseStart: function () {
            },
            _mouseDrag: function () {
            },
            _mouseStop: function () {
            },
            _mouseCapture: function () {
                return !0
            }
        });
        n.widget("ui.sortable", n.ui.mouse, {
            version: "1.11.2",
            widgetEventPrefix: "sort",
            ready: !1,
            options: {
                appendTo: "parent",
                axis: !1,
                connectWith: !1,
                containment: !1,
                cursor: "auto",
                cursorAt: !1,
                dropOnEmpty: !0,
                forcePlaceholderSize: !1,
                forceHelperSize: !1,
                grid: !1,
                handle: !1,
                helper: "original",
                items: "> *",
                opacity: !1,
                placeholder: !1,
                revert: !1,
                scroll: !0,
                scrollSensitivity: 20,
                scrollSpeed: 20,
                scope: "default",
                tolerance: "intersect",
                zIndex: 1e3,
                activate: null,
                beforeStop: null,
                change: null,
                deactivate: null,
                out: null,
                over: null,
                receive: null,
                remove: null,
                sort: null,
                start: null,
                stop: null,
                update: null
            },
            _isOverAxis: function (n, t, i) {
                return n >= t && t + i > n
            },
            _isFloating: function (n) {
                return /left|right/.test(n.css("float")) || /inline|table-cell/.test(n.css("display"))
            },
            _create: function () {
                var n = this.options;
                this.containerCache = {};
                this.element.addClass("ui-sortable");
                this.refresh();
                this.floating = this.items.length ? "x" === n.axis || this._isFloating(this.items[0].item) : !1;
                this.offset = this.element.offset();
                this._mouseInit();
                this._setHandleClassName();
                this.ready = !0
            },
            _setOption: function (n, t) {
                this._super(n, t);
                "handle" === n && this._setHandleClassName()
            },
            _setHandleClassName: function () {
                this.element.find(".ui-sortable-handle").removeClass("ui-sortable-handle");
                n.each(this.items, function () {
                    (this.instance.options.handle ? this.item.find(this.instance.options.handle) : this.item).addClass("ui-sortable-handle")
                })
            },
            _destroy: function () {
                this.element.removeClass("ui-sortable ui-sortable-disabled").find(".ui-sortable-handle").removeClass("ui-sortable-handle");
                this._mouseDestroy();
                for (var n = this.items.length - 1; n >= 0; n--)this.items[n].item.removeData(this.widgetName + "-item");
                return this
            },
            _mouseCapture: function (t, i) {
                var r = null, f = !1, u = this;
                return this.reverting ? !1 : this.options.disabled || "static" === this.options.type ? !1 : (this._refreshItems(t), n(t.target).parents().each(function () {
                    if (n.data(this, u.widgetName + "-item") === u)return (r = n(this), !1)
                }), n.data(t.target, u.widgetName + "-item") === u && (r = n(t.target)), r ? !this.options.handle || i || (n(this.options.handle, r).find("*").addBack().each(function () {
                    this === t.target && (f = !0)
                }), f) ? (this.currentItem = r, this._removeCurrentsFromItems(), !0) : !1 : !1)
            },
            _mouseStart: function (t, i, r) {
                var f, e, u = this.options;
                if (this.currentContainer = this, this.refreshPositions(), this.helper = this._createHelper(t), this._cacheHelperProportions(), this._cacheMargins(), this.scrollParent = this.helper.scrollParent(), this.offset = this.currentItem.offset(), this.offset = {
                        top: this.offset.top - this.margins.top,
                        left: this.offset.left - this.margins.left
                    }, n.extend(this.offset, {
                        click: {left: t.pageX - this.offset.left, top: t.pageY - this.offset.top},
                        parent: this._getParentOffset(),
                        relative: this._getRelativeOffset()
                    }), this.helper.css("position", "absolute"), this.cssPosition = this.helper.css("position"), this.originalPosition = this._generatePosition(t), this.originalPageX = t.pageX, this.originalPageY = t.pageY, u.cursorAt && this._adjustOffsetFromHelper(u.cursorAt), this.domPosition = {
                        prev: this.currentItem.prev()[0],
                        parent: this.currentItem.parent()[0]
                    }, this.helper[0] !== this.currentItem[0] && this.currentItem.hide(), this._createPlaceholder(), u.containment && this._setContainment(), u.cursor && "auto" !== u.cursor && (e = this.document.find("body"), this.storedCursor = e.css("cursor"), e.css("cursor", u.cursor), this.storedStylesheet = n("<style>*{ cursor: " + u.cursor + " !important; }<\/style>").appendTo(e)), u.opacity && (this.helper.css("opacity") && (this._storedOpacity = this.helper.css("opacity")), this.helper.css("opacity", u.opacity)), u.zIndex && (this.helper.css("zIndex") && (this._storedZIndex = this.helper.css("zIndex")), this.helper.css("zIndex", u.zIndex)), this.scrollParent[0] !== document && "HTML" !== this.scrollParent[0].tagName && (this.overflowOffset = this.scrollParent.offset()), this._trigger("start", t, this._uiHash()), this._preserveHelperProportions || this._cacheHelperProportions(), !r)for (f = this.containers.length - 1; f >= 0; f--)this.containers[f]._trigger("activate", t, this._uiHash(this));
                return n.ui.ddmanager && (n.ui.ddmanager.current = this), n.ui.ddmanager && !u.dropBehaviour && n.ui.ddmanager.prepareOffsets(this, t), this.dragging = !0, this.helper.addClass("ui-sortable-helper"), this._mouseDrag(t), !0
            },
            _mouseDrag: function (t) {
                var e, u, f, o, i = this.options, r = !1;
                for (this.position = this._generatePosition(t), this.positionAbs = this._convertPositionTo("absolute"), this.lastPositionAbs || (this.lastPositionAbs = this.positionAbs), this.options.scroll && (this.scrollParent[0] !== document && "HTML" !== this.scrollParent[0].tagName ? (this.overflowOffset.top + this.scrollParent[0].offsetHeight - t.pageY < i.scrollSensitivity ? this.scrollParent[0].scrollTop = r = this.scrollParent[0].scrollTop + i.scrollSpeed : t.pageY - this.overflowOffset.top < i.scrollSensitivity && (this.scrollParent[0].scrollTop = r = this.scrollParent[0].scrollTop - i.scrollSpeed), this.overflowOffset.left + this.scrollParent[0].offsetWidth - t.pageX < i.scrollSensitivity ? this.scrollParent[0].scrollLeft = r = this.scrollParent[0].scrollLeft + i.scrollSpeed : t.pageX - this.overflowOffset.left < i.scrollSensitivity && (this.scrollParent[0].scrollLeft = r = this.scrollParent[0].scrollLeft - i.scrollSpeed)) : (t.pageY - n(document).scrollTop() < i.scrollSensitivity ? r = n(document).scrollTop(n(document).scrollTop() - i.scrollSpeed) : n(window).height() - (t.pageY - n(document).scrollTop()) < i.scrollSensitivity && (r = n(document).scrollTop(n(document).scrollTop() + i.scrollSpeed)), t.pageX - n(document).scrollLeft() < i.scrollSensitivity ? r = n(document).scrollLeft(n(document).scrollLeft() - i.scrollSpeed) : n(window).width() - (t.pageX - n(document).scrollLeft()) < i.scrollSensitivity && (r = n(document).scrollLeft(n(document).scrollLeft() + i.scrollSpeed))), r !== !1 && n.ui.ddmanager && !i.dropBehaviour && n.ui.ddmanager.prepareOffsets(this, t)), this.positionAbs = this._convertPositionTo("absolute"), this.options.axis && "y" === this.options.axis || (this.helper[0].style.left = this.position.left + "px"), this.options.axis && "x" === this.options.axis || (this.helper[0].style.top = this.position.top + "px"), e = this.items.length - 1; e >= 0; e--)if (u = this.items[e], f = u.item[0], o = this._intersectsWithPointer(u), o && u.instance === this.currentContainer && f !== this.currentItem[0] && this.placeholder[1 === o ? "next" : "prev"]()[0] !== f && !n.contains(this.placeholder[0], f) && ("semi-dynamic" === this.options.type ? !n.contains(this.element[0], f) : !0)) {
                    if (this.direction = 1 === o ? "down" : "up", "pointer" !== this.options.tolerance && !this._intersectsWithSides(u))break;
                    this._rearrange(t, u);
                    this._trigger("change", t, this._uiHash());
                    break
                }
                return this._contactContainers(t), n.ui.ddmanager && n.ui.ddmanager.drag(this, t), this._trigger("sort", t, this._uiHash()), this.lastPositionAbs = this.positionAbs, !1
            },
            _mouseStop: function (t, i) {
                if (t) {
                    if (n.ui.ddmanager && !this.options.dropBehaviour && n.ui.ddmanager.drop(this, t), this.options.revert) {
                        var e = this, f = this.placeholder.offset(), r = this.options.axis, u = {};
                        r && "x" !== r || (u.left = f.left - this.offset.parent.left - this.margins.left + (this.offsetParent[0] === document.body ? 0 : this.offsetParent[0].scrollLeft));
                        r && "y" !== r || (u.top = f.top - this.offset.parent.top - this.margins.top + (this.offsetParent[0] === document.body ? 0 : this.offsetParent[0].scrollTop));
                        this.reverting = !0;
                        n(this.helper).animate(u, parseInt(this.options.revert, 10) || 500, function () {
                            e._clear(t)
                        })
                    } else this._clear(t, i);
                    return !1
                }
            },
            cancel: function () {
                if (this.dragging) {
                    this._mouseUp({target: null});
                    "original" === this.options.helper ? this.currentItem.css(this._storedCSS).removeClass("ui-sortable-helper") : this.currentItem.show();
                    for (var t = this.containers.length - 1; t >= 0; t--)this.containers[t]._trigger("deactivate", null, this._uiHash(this)), this.containers[t].containerCache.over && (this.containers[t]._trigger("out", null, this._uiHash(this)), this.containers[t].containerCache.over = 0)
                }
                return this.placeholder && (this.placeholder[0].parentNode && this.placeholder[0].parentNode.removeChild(this.placeholder[0]), "original" !== this.options.helper && this.helper && this.helper[0].parentNode && this.helper.remove(), n.extend(this, {
                    helper: null,
                    dragging: !1,
                    reverting: !1,
                    _noFinalSort: null
                }), this.domPosition.prev ? n(this.domPosition.prev).after(this.currentItem) : n(this.domPosition.parent).prepend(this.currentItem)), this
            },
            serialize: function (t) {
                var r = this._getItemsAsjQuery(t && t.connected), i = [];
                return t = t || {}, n(r).each(function () {
                    var r = (n(t.item || this).attr(t.attribute || "id") || "").match(t.expression || /(.+)[\-=_](.+)/);
                    r && i.push((t.key || r[1] + "[]") + "=" + (t.key && t.expression ? r[1] : r[2]))
                }), !i.length && t.key && i.push(t.key + "="), i.join("&")
            },
            toArray: function (t) {
                var r = this._getItemsAsjQuery(t && t.connected), i = [];
                return t = t || {}, r.each(function () {
                    i.push(n(t.item || this).attr(t.attribute || "id") || "")
                }), i
            },
            _intersectsWith: function (n) {
                var t = this.positionAbs.left, h = t + this.helperProportions.width, i = this.positionAbs.top,
                    c = i + this.helperProportions.height, r = n.left, f = r + n.width, u = n.top, e = u + n.height,
                    o = this.offset.click.top, s = this.offset.click.left,
                    l = "x" === this.options.axis || i + o > u && e > i + o,
                    a = "y" === this.options.axis || t + s > r && f > t + s, v = l && a;
                return "pointer" === this.options.tolerance || this.options.forcePointerForContainers || "pointer" !== this.options.tolerance && this.helperProportions[this.floating ? "width" : "height"] > n[this.floating ? "width" : "height"] ? v : t + this.helperProportions.width / 2 > r && f > h - this.helperProportions.width / 2 && i + this.helperProportions.height / 2 > u && e > c - this.helperProportions.height / 2
            },
            _intersectsWithPointer: function (n) {
                var r = "x" === this.options.axis || this._isOverAxis(this.positionAbs.top + this.offset.click.top, n.top, n.height),
                    u = "y" === this.options.axis || this._isOverAxis(this.positionAbs.left + this.offset.click.left, n.left, n.width),
                    f = r && u, t = this._getDragVerticalDirection(), i = this._getDragHorizontalDirection();
                return f ? this.floating ? i && "right" === i || "down" === t ? 2 : 1 : t && ("down" === t ? 2 : 1) : !1
            },
            _intersectsWithSides: function (n) {
                var r = this._isOverAxis(this.positionAbs.top + this.offset.click.top, n.top + n.height / 2, n.height),
                    u = this._isOverAxis(this.positionAbs.left + this.offset.click.left, n.left + n.width / 2, n.width),
                    t = this._getDragVerticalDirection(), i = this._getDragHorizontalDirection();
                return this.floating && i ? "right" === i && u || "left" === i && !u : t && ("down" === t && r || "up" === t && !r)
            },
            _getDragVerticalDirection: function () {
                var n = this.positionAbs.top - this.lastPositionAbs.top;
                return 0 !== n && (n > 0 ? "down" : "up")
            },
            _getDragHorizontalDirection: function () {
                var n = this.positionAbs.left - this.lastPositionAbs.left;
                return 0 !== n && (n > 0 ? "right" : "left")
            },
            refresh: function (n) {
                return this._refreshItems(n), this._setHandleClassName(), this.refreshPositions(), this
            },
            _connectWith: function () {
                var n = this.options;
                return n.connectWith.constructor === String ? [n.connectWith] : n.connectWith
            },
            _getItemsAsjQuery: function (t) {
                function h() {
                    s.push(this)
                }

                var r, u, e, i, s = [], f = [], o = this._connectWith();
                if (o && t)for (r = o.length - 1; r >= 0; r--)for (e = n(o[r]), u = e.length - 1; u >= 0; u--)i = n.data(e[u], this.widgetFullName), i && i !== this && !i.options.disabled && f.push([n.isFunction(i.options.items) ? i.options.items.call(i.element) : n(i.options.items, i.element).not(".ui-sortable-helper").not(".ui-sortable-placeholder"), i]);
                for (f.push([n.isFunction(this.options.items) ? this.options.items.call(this.element, null, {
                    options: this.options,
                    item: this.currentItem
                }) : n(this.options.items, this.element).not(".ui-sortable-helper").not(".ui-sortable-placeholder"), this]), r = f.length - 1; r >= 0; r--)f[r][0].each(h);
                return n(s)
            },
            _removeCurrentsFromItems: function () {
                var t = this.currentItem.find(":data(" + this.widgetName + "-item)");
                this.items = n.grep(this.items, function (n) {
                    for (var i = 0; t.length > i; i++)if (t[i] === n.item[0])return !1;
                    return !0
                })
            },
            _refreshItems: function (t) {
                this.items = [];
                this.containers = [this];
                var r, u, e, i, o, s, h, l, a = this.items,
                    f = [[n.isFunction(this.options.items) ? this.options.items.call(this.element[0], t, {item: this.currentItem}) : n(this.options.items, this.element), this]],
                    c = this._connectWith();
                if (c && this.ready)for (r = c.length - 1; r >= 0; r--)for (e = n(c[r]), u = e.length - 1; u >= 0; u--)i = n.data(e[u], this.widgetFullName), i && i !== this && !i.options.disabled && (f.push([n.isFunction(i.options.items) ? i.options.items.call(i.element[0], t, {item: this.currentItem}) : n(i.options.items, i.element), i]), this.containers.push(i));
                for (r = f.length - 1; r >= 0; r--)for (o = f[r][1], s = f[r][0], u = 0, l = s.length; l > u; u++)h = n(s[u]), h.data(this.widgetName + "-item", o), a.push({
                    item: h,
                    instance: o,
                    width: 0,
                    height: 0,
                    left: 0,
                    top: 0
                })
            },
            refreshPositions: function (t) {
                this.offsetParent && this.helper && (this.offset.parent = this._getParentOffset());
                for (var r, f, u, i = this.items.length - 1; i >= 0; i--)r = this.items[i], r.instance !== this.currentContainer && this.currentContainer && r.item[0] !== this.currentItem[0] || (f = this.options.toleranceElement ? n(this.options.toleranceElement, r.item) : r.item, t || (r.width = f.outerWidth(), r.height = f.outerHeight()), u = f.offset(), r.left = u.left, r.top = u.top);
                if (this.options.custom && this.options.custom.refreshContainers) this.options.custom.refreshContainers.call(this); else for (i = this.containers.length - 1; i >= 0; i--)u = this.containers[i].element.offset(), this.containers[i].containerCache.left = u.left, this.containers[i].containerCache.top = u.top, this.containers[i].containerCache.width = this.containers[i].element.outerWidth(), this.containers[i].containerCache.height = this.containers[i].element.outerHeight();
                return this
            },
            _createPlaceholder: function (t) {
                t = t || this;
                var r, i = t.options;
                i.placeholder && i.placeholder.constructor !== String || (r = i.placeholder, i.placeholder = {
                    element: function () {
                        var u = t.currentItem[0].nodeName.toLowerCase(),
                            i = n("<" + u + ">", t.document[0]).addClass(r || t.currentItem[0].className + " ui-sortable-placeholder").removeClass("ui-sortable-helper");
                        return "tr" === u ? t.currentItem.children().each(function () {
                            n("<td>&#160;<\/td>", t.document[0]).attr("colspan", n(this).attr("colspan") || 1).appendTo(i)
                        }) : "img" === u && i.attr("src", t.currentItem.attr("src")), r || i.css("visibility", "hidden"), i
                    }, update: function (n, u) {
                        (!r || i.forcePlaceholderSize) && (u.height() || u.height(t.currentItem.innerHeight() - parseInt(t.currentItem.css("paddingTop") || 0, 10) - parseInt(t.currentItem.css("paddingBottom") || 0, 10)), u.width() || u.width(t.currentItem.innerWidth() - parseInt(t.currentItem.css("paddingLeft") || 0, 10) - parseInt(t.currentItem.css("paddingRight") || 0, 10)))
                    }
                });
                t.placeholder = n(i.placeholder.element.call(t.element, t.currentItem));
                t.currentItem.after(t.placeholder);
                i.placeholder.update(t, t.placeholder)
            },
            _contactContainers: function (t) {
                for (var u, c, f, a, v, o, l, s, h, e = null, i = null, r = this.containers.length - 1; r >= 0; r--)if (!n.contains(this.currentItem[0], this.containers[r].element[0]))if (this._intersectsWith(this.containers[r].containerCache)) {
                    if (e && n.contains(this.containers[r].element[0], e.element[0]))continue;
                    e = this.containers[r];
                    i = r
                } else this.containers[r].containerCache.over && (this.containers[r]._trigger("out", t, this._uiHash(this)), this.containers[r].containerCache.over = 0);
                if (e)if (1 === this.containers.length) this.containers[i].containerCache.over || (this.containers[i]._trigger("over", t, this._uiHash(this)), this.containers[i].containerCache.over = 1); else {
                    for (c = 1e4, f = null, s = e.floating || this._isFloating(this.currentItem), a = s ? "left" : "top", v = s ? "width" : "height", h = s ? "clientX" : "clientY", u = this.items.length - 1; u >= 0; u--)n.contains(this.containers[i].element[0], this.items[u].item[0]) && this.items[u].item[0] !== this.currentItem[0] && (o = this.items[u].item.offset()[a], l = !1, t[h] - o > this.items[u][v] / 2 && (l = !0), c > Math.abs(t[h] - o) && (c = Math.abs(t[h] - o), f = this.items[u], this.direction = l ? "up" : "down"));
                    if (!f && !this.options.dropOnEmpty)return;
                    if (this.currentContainer === this.containers[i])return this.currentContainer.containerCache.over || (this.containers[i]._trigger("over", t, this._uiHash()), this.currentContainer.containerCache.over = 1), void 0;
                    f ? this._rearrange(t, f, null, !0) : this._rearrange(t, null, this.containers[i].element, !0);
                    this._trigger("change", t, this._uiHash());
                    this.containers[i]._trigger("change", t, this._uiHash(this));
                    this.currentContainer = this.containers[i];
                    this.options.placeholder.update(this.currentContainer, this.placeholder);
                    this.containers[i]._trigger("over", t, this._uiHash(this));
                    this.containers[i].containerCache.over = 1
                }
            },
            _createHelper: function (t) {
                var r = this.options,
                    i = n.isFunction(r.helper) ? n(r.helper.apply(this.element[0], [t, this.currentItem])) : "clone" === r.helper ? this.currentItem.clone() : this.currentItem;
                return i.parents("body").length || n("parent" !== r.appendTo ? r.appendTo : this.currentItem[0].parentNode)[0].appendChild(i[0]), i[0] === this.currentItem[0] && (this._storedCSS = {
                    width: this.currentItem[0].style.width,
                    height: this.currentItem[0].style.height,
                    position: this.currentItem.css("position"),
                    top: this.currentItem.css("top"),
                    left: this.currentItem.css("left")
                }), (!i[0].style.width || r.forceHelperSize) && i.width(this.currentItem.width()), (!i[0].style.height || r.forceHelperSize) && i.height(this.currentItem.height()), i
            },
            _adjustOffsetFromHelper: function (t) {
                "string" == typeof t && (t = t.split(" "));
                n.isArray(t) && (t = {left: +t[0], top: +t[1] || 0});
                "left" in t && (this.offset.click.left = t.left + this.margins.left);
                "right" in t && (this.offset.click.left = this.helperProportions.width - t.right + this.margins.left);
                "top" in t && (this.offset.click.top = t.top + this.margins.top);
                "bottom" in t && (this.offset.click.top = this.helperProportions.height - t.bottom + this.margins.top)
            },
            _getParentOffset: function () {
                this.offsetParent = this.helper.offsetParent();
                var t = this.offsetParent.offset();
                return "absolute" === this.cssPosition && this.scrollParent[0] !== document && n.contains(this.scrollParent[0], this.offsetParent[0]) && (t.left += this.scrollParent.scrollLeft(), t.top += this.scrollParent.scrollTop()), (this.offsetParent[0] === document.body || this.offsetParent[0].tagName && "html" === this.offsetParent[0].tagName.toLowerCase() && n.ui.ie) && (t = {
                    top: 0,
                    left: 0
                }), {
                    top: t.top + (parseInt(this.offsetParent.css("borderTopWidth"), 10) || 0),
                    left: t.left + (parseInt(this.offsetParent.css("borderLeftWidth"), 10) || 0)
                }
            },
            _getRelativeOffset: function () {
                if ("relative" === this.cssPosition) {
                    var n = this.currentItem.position();
                    return {
                        top: n.top - (parseInt(this.helper.css("top"), 10) || 0) + this.scrollParent.scrollTop(),
                        left: n.left - (parseInt(this.helper.css("left"), 10) || 0) + this.scrollParent.scrollLeft()
                    }
                }
                return {top: 0, left: 0}
            },
            _cacheMargins: function () {
                this.margins = {
                    left: parseInt(this.currentItem.css("marginLeft"), 10) || 0,
                    top: parseInt(this.currentItem.css("marginTop"), 10) || 0
                }
            },
            _cacheHelperProportions: function () {
                this.helperProportions = {width: this.helper.outerWidth(), height: this.helper.outerHeight()}
            },
            _setContainment: function () {
                var t, r, u, i = this.options;
                "parent" === i.containment && (i.containment = this.helper[0].parentNode);
                ("document" === i.containment || "window" === i.containment) && (this.containment = [0 - this.offset.relative.left - this.offset.parent.left, 0 - this.offset.relative.top - this.offset.parent.top, n("document" === i.containment ? document : window).width() - this.helperProportions.width - this.margins.left, (n("document" === i.containment ? document : window).height() || document.body.parentNode.scrollHeight) - this.helperProportions.height - this.margins.top]);
                /^(document|window|parent)$/.test(i.containment) || (t = n(i.containment)[0], r = n(i.containment).offset(), u = "hidden" !== n(t).css("overflow"), this.containment = [r.left + (parseInt(n(t).css("borderLeftWidth"), 10) || 0) + (parseInt(n(t).css("paddingLeft"), 10) || 0) - this.margins.left, r.top + (parseInt(n(t).css("borderTopWidth"), 10) || 0) + (parseInt(n(t).css("paddingTop"), 10) || 0) - this.margins.top, r.left + (u ? Math.max(t.scrollWidth, t.offsetWidth) : t.offsetWidth) - (parseInt(n(t).css("borderLeftWidth"), 10) || 0) - (parseInt(n(t).css("paddingRight"), 10) || 0) - this.helperProportions.width - this.margins.left, r.top + (u ? Math.max(t.scrollHeight, t.offsetHeight) : t.offsetHeight) - (parseInt(n(t).css("borderTopWidth"), 10) || 0) - (parseInt(n(t).css("paddingBottom"), 10) || 0) - this.helperProportions.height - this.margins.top])
            },
            _convertPositionTo: function (t, i) {
                i || (i = this.position);
                var r = "absolute" === t ? 1 : -1,
                    u = "absolute" !== this.cssPosition || this.scrollParent[0] !== document && n.contains(this.scrollParent[0], this.offsetParent[0]) ? this.scrollParent : this.offsetParent,
                    f = /(html|body)/i.test(u[0].tagName);
                return {
                    top: i.top + this.offset.relative.top * r + this.offset.parent.top * r - ("fixed" === this.cssPosition ? -this.scrollParent.scrollTop() : f ? 0 : u.scrollTop()) * r,
                    left: i.left + this.offset.relative.left * r + this.offset.parent.left * r - ("fixed" === this.cssPosition ? -this.scrollParent.scrollLeft() : f ? 0 : u.scrollLeft()) * r
                }
            },
            _generatePosition: function (t) {
                var r, u, i = this.options, f = t.pageX, e = t.pageY,
                    o = "absolute" !== this.cssPosition || this.scrollParent[0] !== document && n.contains(this.scrollParent[0], this.offsetParent[0]) ? this.scrollParent : this.offsetParent,
                    s = /(html|body)/i.test(o[0].tagName);
                return "relative" !== this.cssPosition || this.scrollParent[0] !== document && this.scrollParent[0] !== this.offsetParent[0] || (this.offset.relative = this._getRelativeOffset()), this.originalPosition && (this.containment && (t.pageX - this.offset.click.left < this.containment[0] && (f = this.containment[0] + this.offset.click.left), t.pageY - this.offset.click.top < this.containment[1] && (e = this.containment[1] + this.offset.click.top), t.pageX - this.offset.click.left > this.containment[2] && (f = this.containment[2] + this.offset.click.left), t.pageY - this.offset.click.top > this.containment[3] && (e = this.containment[3] + this.offset.click.top)), i.grid && (r = this.originalPageY + Math.round((e - this.originalPageY) / i.grid[1]) * i.grid[1], e = this.containment ? r - this.offset.click.top >= this.containment[1] && r - this.offset.click.top <= this.containment[3] ? r : r - this.offset.click.top >= this.containment[1] ? r - i.grid[1] : r + i.grid[1] : r, u = this.originalPageX + Math.round((f - this.originalPageX) / i.grid[0]) * i.grid[0], f = this.containment ? u - this.offset.click.left >= this.containment[0] && u - this.offset.click.left <= this.containment[2] ? u : u - this.offset.click.left >= this.containment[0] ? u - i.grid[0] : u + i.grid[0] : u)), {
                    top: e - this.offset.click.top - this.offset.relative.top - this.offset.parent.top + ("fixed" === this.cssPosition ? -this.scrollParent.scrollTop() : s ? 0 : o.scrollTop()),
                    left: f - this.offset.click.left - this.offset.relative.left - this.offset.parent.left + ("fixed" === this.cssPosition ? -this.scrollParent.scrollLeft() : s ? 0 : o.scrollLeft())
                }
            },
            _rearrange: function (n, t, i, r) {
                i ? i[0].appendChild(this.placeholder[0]) : t.item[0].parentNode.insertBefore(this.placeholder[0], "down" === this.direction ? t.item[0] : t.item[0].nextSibling);
                this.counter = this.counter ? ++this.counter : 1;
                var u = this.counter;
                this._delay(function () {
                    u === this.counter && this.refreshPositions(!r)
                })
            },
            _clear: function (n, t) {
                function u(n, t, i) {
                    return function (r) {
                        i._trigger(n, r, t._uiHash(t))
                    }
                }

                this.reverting = !1;
                var i, r = [];
                if (!this._noFinalSort && this.currentItem.parent().length && this.placeholder.before(this.currentItem), this._noFinalSort = null, this.helper[0] === this.currentItem[0]) {
                    for (i in this._storedCSS)("auto" === this._storedCSS[i] || "static" === this._storedCSS[i]) && (this._storedCSS[i] = "");
                    this.currentItem.css(this._storedCSS).removeClass("ui-sortable-helper")
                } else this.currentItem.show();
                for (this.fromOutside && !t && r.push(function (n) {
                    this._trigger("receive", n, this._uiHash(this.fromOutside))
                }), !this.fromOutside && this.domPosition.prev === this.currentItem.prev().not(".ui-sortable-helper")[0] && this.domPosition.parent === this.currentItem.parent()[0] || t || r.push(function (n) {
                    this._trigger("update", n, this._uiHash())
                }), this !== this.currentContainer && (t || (r.push(function (n) {
                    this._trigger("remove", n, this._uiHash())
                }), r.push(function (n) {
                    return function (t) {
                        n._trigger("receive", t, this._uiHash(this))
                    }
                }.call(this, this.currentContainer)), r.push(function (n) {
                    return function (t) {
                        n._trigger("update", t, this._uiHash(this))
                    }
                }.call(this, this.currentContainer)))), i = this.containers.length - 1; i >= 0; i--)t || r.push(u("deactivate", this, this.containers[i])), this.containers[i].containerCache.over && (r.push(u("out", this, this.containers[i])), this.containers[i].containerCache.over = 0);
                if (this.storedCursor && (this.document.find("body").css("cursor", this.storedCursor), this.storedStylesheet.remove()), this._storedOpacity && this.helper.css("opacity", this._storedOpacity), this._storedZIndex && this.helper.css("zIndex", "auto" === this._storedZIndex ? "" : this._storedZIndex), this.dragging = !1, t || this._trigger("beforeStop", n, this._uiHash()), this.placeholder[0].parentNode.removeChild(this.placeholder[0]), this.cancelHelperRemoval || (this.helper[0] !== this.currentItem[0] && this.helper.remove(), this.helper = null), !t) {
                    for (i = 0; r.length > i; i++)r[i].call(this, n);
                    this._trigger("stop", n, this._uiHash())
                }
                return this.fromOutside = !1, !this.cancelHelperRemoval
            },
            _trigger: function () {
                n.Widget.prototype._trigger.apply(this, arguments) === !1 && this.cancel()
            },
            _uiHash: function (t) {
                var i = t || this;
                return {
                    helper: i.helper,
                    placeholder: i.placeholder || n([]),
                    position: i.position,
                    originalPosition: i.originalPosition,
                    offset: i.positionAbs,
                    item: i.currentItem,
                    sender: t ? t.element : null
                }
            }
        });
        n.widget("ui.slider", n.ui.mouse, {
            version: "1.11.2",
            widgetEventPrefix: "slide",
            options: {
                animate: !1,
                distance: 0,
                max: 100,
                min: 0,
                orientation: "horizontal",
                range: !1,
                step: 1,
                value: 0,
                values: null,
                change: null,
                slide: null,
                start: null,
                stop: null
            },
            numPages: 5,
            _create: function () {
                this._keySliding = !1;
                this._mouseSliding = !1;
                this._animateOff = !0;
                this._handleIndex = null;
                this._detectOrientation();
                this._mouseInit();
                this._calculateNewMax();
                this.element.addClass("ui-slider ui-slider-" + this.orientation + " ui-widget ui-widget-content ui-corner-all");
                this._refresh();
                this._setOption("disabled", this.options.disabled);
                this._animateOff = !1
            },
            _refresh: function () {
                this._createRange();
                this._createHandles();
                this._setupEvents();
                this._refreshValue()
            },
            _createHandles: function () {
                var r, i, u = this.options,
                    t = this.element.find(".ui-slider-handle").addClass("ui-state-default ui-corner-all"), f = [];
                for (i = u.values && u.values.length || 1, t.length > i && (t.slice(i).remove(), t = t.slice(0, i)), r = t.length; i > r; r++)f.push("<span class='ui-slider-handle ui-state-default ui-corner-all' tabindex='0'><\/span>");
                this.handles = t.add(n(f.join("")).appendTo(this.element));
                this.handle = this.handles.eq(0);
                this.handles.each(function (t) {
                    n(this).data("ui-slider-handle-index", t)
                })
            },
            _createRange: function () {
                var t = this.options, i = "";
                t.range ? (t.range === !0 && (t.values ? t.values.length && 2 !== t.values.length ? t.values = [t.values[0], t.values[0]] : n.isArray(t.values) && (t.values = t.values.slice(0)) : t.values = [this._valueMin(), this._valueMin()]), this.range && this.range.length ? this.range.removeClass("ui-slider-range-min ui-slider-range-max").css({
                    left: "",
                    bottom: ""
                }) : (this.range = n("<div><\/div>").appendTo(this.element), i = "ui-slider-range ui-widget-header ui-corner-all"), this.range.addClass(i + ("min" === t.range || "max" === t.range ? " ui-slider-range-" + t.range : ""))) : (this.range && this.range.remove(), this.range = null)
            },
            _setupEvents: function () {
                this._off(this.handles);
                this._on(this.handles, this._handleEvents);
                this._hoverable(this.handles);
                this._focusable(this.handles)
            },
            _destroy: function () {
                this.handles.remove();
                this.range && this.range.remove();
                this.element.removeClass("ui-slider ui-slider-horizontal ui-slider-vertical ui-widget ui-widget-content ui-corner-all");
                this._mouseDestroy()
            },
            _mouseCapture: function (t) {
                var s, f, r, i, u, h, e, c, o = this, l = this.options;
                return l.disabled ? !1 : (this.elementSize = {
                    width: this.element.outerWidth(),
                    height: this.element.outerHeight()
                }, this.elementOffset = this.element.offset(), s = {
                    x: t.pageX,
                    y: t.pageY
                }, f = this._normValueFromMouse(s), r = this._valueMax() - this._valueMin() + 1, this.handles.each(function (t) {
                    var e = Math.abs(f - o.values(t));
                    (r > e || r === e && (t === o._lastChangedValue || o.values(t) === l.min)) && (r = e, i = n(this), u = t)
                }), h = this._start(t, u), h === !1 ? !1 : (this._mouseSliding = !0, this._handleIndex = u, i.addClass("ui-state-active").focus(), e = i.offset(), c = !n(t.target).parents().addBack().is(".ui-slider-handle"), this._clickOffset = c ? {
                    left: 0,
                    top: 0
                } : {
                    left: t.pageX - e.left - i.width() / 2,
                    top: t.pageY - e.top - i.height() / 2 - (parseInt(i.css("borderTopWidth"), 10) || 0) - (parseInt(i.css("borderBottomWidth"), 10) || 0) + (parseInt(i.css("marginTop"), 10) || 0)
                }, this.handles.hasClass("ui-state-hover") || this._slide(t, u, f), this._animateOff = !0, !0))
            },
            _mouseStart: function () {
                return !0
            },
            _mouseDrag: function (n) {
                var t = {x: n.pageX, y: n.pageY}, i = this._normValueFromMouse(t);
                return this._slide(n, this._handleIndex, i), !1
            },
            _mouseStop: function (n) {
                return this.handles.removeClass("ui-state-active"), this._mouseSliding = !1, this._stop(n, this._handleIndex), this._change(n, this._handleIndex), this._handleIndex = null, this._clickOffset = null, this._animateOff = !1, !1
            },
            _detectOrientation: function () {
                this.orientation = "vertical" === this.options.orientation ? "vertical" : "horizontal"
            },
            _normValueFromMouse: function (n) {
                var i, r, t, u, f;
                return "horizontal" === this.orientation ? (i = this.elementSize.width, r = n.x - this.elementOffset.left - (this._clickOffset ? this._clickOffset.left : 0)) : (i = this.elementSize.height, r = n.y - this.elementOffset.top - (this._clickOffset ? this._clickOffset.top : 0)), t = r / i, t > 1 && (t = 1), 0 > t && (t = 0), "vertical" === this.orientation && (t = 1 - t), u = this._valueMax() - this._valueMin(), f = this._valueMin() + t * u, this._trimAlignValue(f)
            },
            _start: function (n, t) {
                var i = {handle: this.handles[t], value: this.value()};
                return this.options.values && this.options.values.length && (i.value = this.values(t), i.values = this.values()), this._trigger("start", n, i)
            },
            _slide: function (n, t, i) {
                var r, f, u;
                this.options.values && this.options.values.length ? (r = this.values(t ? 0 : 1), 2 === this.options.values.length && this.options.range === !0 && (0 === t && i > r || 1 === t && r > i) && (i = r), i !== this.values(t) && (f = this.values(), f[t] = i, u = this._trigger("slide", n, {
                    handle: this.handles[t],
                    value: i,
                    values: f
                }), r = this.values(t ? 0 : 1), u !== !1 && this.values(t, i))) : i !== this.value() && (u = this._trigger("slide", n, {
                        handle: this.handles[t],
                        value: i
                    }), u !== !1 && this.value(i))
            },
            _stop: function (n, t) {
                var i = {handle: this.handles[t], value: this.value()};
                this.options.values && this.options.values.length && (i.value = this.values(t), i.values = this.values());
                this._trigger("stop", n, i)
            },
            _change: function (n, t) {
                if (!this._keySliding && !this._mouseSliding) {
                    var i = {handle: this.handles[t], value: this.value()};
                    this.options.values && this.options.values.length && (i.value = this.values(t), i.values = this.values());
                    this._lastChangedValue = t;
                    this._trigger("change", n, i)
                }
            },
            value: function (n) {
                return arguments.length ? (this.options.value = this._trimAlignValue(n), this._refreshValue(), this._change(null, 0), void 0) : this._value()
            },
            values: function (t, i) {
                var u, f, r;
                if (arguments.length > 1)return this.options.values[t] = this._trimAlignValue(i), this._refreshValue(), this._change(null, t), void 0;
                if (!arguments.length)return this._values();
                if (!n.isArray(arguments[0]))return this.options.values && this.options.values.length ? this._values(t) : this.value();
                for (u = this.options.values, f = arguments[0], r = 0; u.length > r; r += 1)u[r] = this._trimAlignValue(f[r]), this._change(null, r);
                this._refreshValue()
            },
            _setOption: function (t, i) {
                var r, u = 0;
                switch ("range" === t && this.options.range === !0 && ("min" === i ? (this.options.value = this._values(0), this.options.values = null) : "max" === i && (this.options.value = this._values(this.options.values.length - 1), this.options.values = null)), n.isArray(this.options.values) && (u = this.options.values.length), "disabled" === t && this.element.toggleClass("ui-state-disabled", !!i), this._super(t, i), t) {
                    case"orientation":
                        this._detectOrientation();
                        this.element.removeClass("ui-slider-horizontal ui-slider-vertical").addClass("ui-slider-" + this.orientation);
                        this._refreshValue();
                        this.handles.css("horizontal" === i ? "bottom" : "left", "");
                        break;
                    case"value":
                        this._animateOff = !0;
                        this._refreshValue();
                        this._change(null, 0);
                        this._animateOff = !1;
                        break;
                    case"values":
                        for (this._animateOff = !0, this._refreshValue(), r = 0; u > r; r += 1)this._change(null, r);
                        this._animateOff = !1;
                        break;
                    case"step":
                    case"min":
                    case"max":
                        this._animateOff = !0;
                        this._calculateNewMax();
                        this._refreshValue();
                        this._animateOff = !1;
                        break;
                    case"range":
                        this._animateOff = !0;
                        this._refresh();
                        this._animateOff = !1
                }
            },
            _value: function () {
                var n = this.options.value;
                return this._trimAlignValue(n)
            },
            _values: function (n) {
                var r, t, i;
                if (arguments.length)return r = this.options.values[n], r = this._trimAlignValue(r);
                if (this.options.values && this.options.values.length) {
                    for (t = this.options.values.slice(), i = 0; t.length > i; i += 1)t[i] = this._trimAlignValue(t[i]);
                    return t
                }
                return []
            },
            _trimAlignValue: function (n) {
                if (this._valueMin() >= n)return this._valueMin();
                if (n >= this._valueMax())return this._valueMax();
                var t = this.options.step > 0 ? this.options.step : 1, i = (n - this._valueMin()) % t, r = n - i;
                return 2 * Math.abs(i) >= t && (r += i > 0 ? t : -t), parseFloat(r.toFixed(5))
            },
            _calculateNewMax: function () {
                var n = (this.options.max - this._valueMin()) % this.options.step;
                this.max = this.options.max - n
            },
            _valueMin: function () {
                return this.options.min
            },
            _valueMax: function () {
                return this.max
            },
            _refreshValue: function () {
                var s, t, c, f, h, e = this.options.range, i = this.options, r = this,
                    u = this._animateOff ? !1 : i.animate, o = {};
                this.options.values && this.options.values.length ? this.handles.each(function (f) {
                    t = 100 * ((r.values(f) - r._valueMin()) / (r._valueMax() - r._valueMin()));
                    o["horizontal" === r.orientation ? "left" : "bottom"] = t + "%";
                    n(this).stop(1, 1)[u ? "animate" : "css"](o, i.animate);
                    r.options.range === !0 && ("horizontal" === r.orientation ? (0 === f && r.range.stop(1, 1)[u ? "animate" : "css"]({left: t + "%"}, i.animate), 1 === f && r.range[u ? "animate" : "css"]({width: t - s + "%"}, {
                        queue: !1,
                        duration: i.animate
                    })) : (0 === f && r.range.stop(1, 1)[u ? "animate" : "css"]({bottom: t + "%"}, i.animate), 1 === f && r.range[u ? "animate" : "css"]({height: t - s + "%"}, {
                        queue: !1,
                        duration: i.animate
                    })));
                    s = t
                }) : (c = this.value(), f = this._valueMin(), h = this._valueMax(), t = h !== f ? 100 * ((c - f) / (h - f)) : 0, o["horizontal" === this.orientation ? "left" : "bottom"] = t + "%", this.handle.stop(1, 1)[u ? "animate" : "css"](o, i.animate), "min" === e && "horizontal" === this.orientation && this.range.stop(1, 1)[u ? "animate" : "css"]({width: t + "%"}, i.animate), "max" === e && "horizontal" === this.orientation && this.range[u ? "animate" : "css"]({width: 100 - t + "%"}, {
                    queue: !1,
                    duration: i.animate
                }), "min" === e && "vertical" === this.orientation && this.range.stop(1, 1)[u ? "animate" : "css"]({height: t + "%"}, i.animate), "max" === e && "vertical" === this.orientation && this.range[u ? "animate" : "css"]({height: 100 - t + "%"}, {
                    queue: !1,
                    duration: i.animate
                }))
            },
            _handleEvents: {
                keydown: function (t) {
                    var e, r, i, u, f = n(t.target).data("ui-slider-handle-index");
                    switch (t.keyCode) {
                        case n.ui.keyCode.HOME:
                        case n.ui.keyCode.END:
                        case n.ui.keyCode.PAGE_UP:
                        case n.ui.keyCode.PAGE_DOWN:
                        case n.ui.keyCode.UP:
                        case n.ui.keyCode.RIGHT:
                        case n.ui.keyCode.DOWN:
                        case n.ui.keyCode.LEFT:
                            if (t.preventDefault(), !this._keySliding && (this._keySliding = !0, n(t.target).addClass("ui-state-active"), e = this._start(t, f), e === !1))return
                    }
                    switch (u = this.options.step, r = i = this.options.values && this.options.values.length ? this.values(f) : this.value(), t.keyCode) {
                        case n.ui.keyCode.HOME:
                            i = this._valueMin();
                            break;
                        case n.ui.keyCode.END:
                            i = this._valueMax();
                            break;
                        case n.ui.keyCode.PAGE_UP:
                            i = this._trimAlignValue(r + (this._valueMax() - this._valueMin()) / this.numPages);
                            break;
                        case n.ui.keyCode.PAGE_DOWN:
                            i = this._trimAlignValue(r - (this._valueMax() - this._valueMin()) / this.numPages);
                            break;
                        case n.ui.keyCode.UP:
                        case n.ui.keyCode.RIGHT:
                            if (r === this._valueMax())return;
                            i = this._trimAlignValue(r + u);
                            break;
                        case n.ui.keyCode.DOWN:
                        case n.ui.keyCode.LEFT:
                            if (r === this._valueMin())return;
                            i = this._trimAlignValue(r - u)
                    }
                    this._slide(t, f, i)
                }, keyup: function (t) {
                    var i = n(t.target).data("ui-slider-handle-index");
                    this._keySliding && (this._keySliding = !1, this._stop(t, i), this._change(t, i), n(t.target).removeClass("ui-state-active"))
                }
            }
        })
    }), function (n, t, i) {
        typeof define == "function" && define.amd ? define(["jquery"], function (r) {
            return i(r, n, t), r.mobile
        }) : i(n.jQuery, n, t)
    }(this, document, function (n, t, i) {
        (function (n, t, i, r) {
            function h(n) {
                while (n && typeof n.originalEvent != "undefined")n = n.originalEvent;
                return n
            }

            function vt(t, i) {
                var u = t.type, e, o, l, f, s, a, v, c, y;
                if (t = n.Event(t), t.type = i, e = t.originalEvent, o = n.event.props, u.search(/^(mouse|click)/) > -1 && (o = gt), e)for (v = o.length, f; v;)f = o[--v], t[f] = e[f];
                if (u.search(/mouse(down|up)|click/) > -1 && !t.which && (t.which = 1), u.search(/^touch/) !== -1 && (l = h(e), u = l.touches, s = l.changedTouches, a = u && u.length ? u[0] : s && s.length ? s[0] : r, a))for (c = 0, y = ct.length; c < y; c++)f = ct[c], t[f] = a[f];
                return t
            }

            function v(t) {
                for (var i = {}, r, u; t;) {
                    r = n.data(t, o);
                    for (u in r)r[u] && (i[u] = i.hasVirtualBinding = !0);
                    t = t.parentNode
                }
                return i
            }

            function yt(t, i) {
                for (var r; t;) {
                    if (r = n.data(t, o), r && (!i || r[i]))return t;
                    t = t.parentNode
                }
                return null
            }

            function pt() {
                l = !1
            }

            function tt() {
                l = !0
            }

            function wt() {
                s = 0;
                y.length = 0;
                d = !1;
                tt()
            }

            function bt() {
                pt()
            }

            function w() {
                it();
                c = setTimeout(function () {
                    c = 0;
                    wt()
                }, n.vmouse.resetTimerDuration)
            }

            function it() {
                c && (clearTimeout(c), c = 0)
            }

            function f(t, i, r) {
                var u;
                return (r && r[t] || !r && yt(i.target, t)) && (u = vt(i, t), n(i.target).trigger(u)), u
            }

            function rt(t) {
                var r = n.data(t.target, b), i;
                d || s && s === r || (i = f("v" + t.type, t), i && (i.isDefaultPrevented() && t.preventDefault(), i.isPropagationStopped() && t.stopPropagation(), i.isImmediatePropagationStopped() && t.stopImmediatePropagation()))
            }

            function ut(t) {
                var o = h(t).touches, r, i, u;
                o && o.length === 1 && (r = t.target, i = v(r), i.hasVirtualBinding && (s = ni++, n.data(r, b, s), it(), bt(), e = !1, u = h(t).touches[0], lt = u.pageX, at = u.pageY, f("vmouseover", t, i), f("vmousedown", t, i)))
            }

            function ft(n) {
                l || (e || f("vmousecancel", n, v(n.target)), e = !0, w())
            }

            function et(t) {
                if (!l) {
                    var i = h(t).touches[0], o = e, r = n.vmouse.moveDistanceThreshold, u = v(t.target);
                    e = e || Math.abs(i.pageX - lt) > r || Math.abs(i.pageY - at) > r;
                    e && !o && f("vmousecancel", t, u);
                    f("vmousemove", t, u);
                    w()
                }
            }

            function ot(n) {
                if (!l) {
                    tt();
                    var t = v(n.target), i, r;
                    f("vmouseup", n, t);
                    e || (i = f("vclick", n, t), i && i.isDefaultPrevented() && (r = h(n).changedTouches[0], y.push({
                        touchID: s,
                        x: r.clientX,
                        y: r.clientY
                    }), d = !0));
                    f("vmouseout", n, t);
                    e = !1;
                    w()
                }
            }

            function st(t) {
                var i = n.data(t, o), r;
                if (i)for (r in i)if (i[r])return !0;
                return !1
            }

            function ht() {
            }

            function kt(t) {
                var i = t.substr(1);
                return {
                    setup: function () {
                        st(this) || n.data(this, o, {});
                        var r = n.data(this, o);
                        r[t] = !0;
                        u[t] = (u[t] || 0) + 1;
                        u[t] === 1 && p.bind(i, rt);
                        n(this).bind(i, ht);
                        g && (u.touchstart = (u.touchstart || 0) + 1, u.touchstart === 1 && p.bind("touchstart", ut).bind("touchend", ot).bind("touchmove", et).bind("scroll", ft))
                    }, teardown: function () {
                        --u[t];
                        u[t] || p.unbind(i, rt);
                        g && (--u.touchstart, u.touchstart || p.unbind("touchstart", ut).unbind("touchmove", et).unbind("touchend", ot).unbind("scroll", ft));
                        var r = n(this), f = n.data(this, o);
                        f && (f[t] = !1);
                        r.unbind(i, ht);
                        st(this) || r.removeData(o)
                    }
                }
            }

            var o = "virtualMouseBindings", b = "virtualTouchID",
                k = "vmouseover vmousedown vmousemove vmouseup vclick vmouseout vmousecancel".split(" "),
                ct = "clientX clientY pageX pageY screenX screenY".split(" "),
                dt = n.event.mouseHooks ? n.event.mouseHooks.props : [], gt = n.event.props.concat(dt), u = {}, c = 0,
                lt = 0, at = 0, e = !1, y = [], d = !1, l = !1, g = "addEventListener" in i, p = n(i), ni = 1, s = 0,
                nt, a;
            for (n.vmouse = {
                moveDistanceThreshold: 10,
                clickDistanceThreshold: 10,
                resetTimerDuration: 1500
            }, a = 0; a < k.length; a++)n.event.special[k[a]] = kt(k[a]);
            g && i.addEventListener("click", function (t) {
                var f = y.length, e = t.target, o, s, i, r, u, h;
                if (f)for (o = t.clientX, s = t.clientY, nt = n.vmouse.clickDistanceThreshold, i = e; i;) {
                    for (r = 0; r < f; r++)if (u = y[r], h = 0, i === e && Math.abs(u.x - o) < nt && Math.abs(u.y - s) < nt || n.data(i, b) === u.touchID) {
                        t.preventDefault();
                        t.stopPropagation();
                        return
                    }
                    i = i.parentNode
                }
            }, !0)
        })(n, t, i), function (n) {
            n.mobile = {}
        }(n), function (n) {
            var t = {touch: "ontouchend" in i};
            n.mobile.support = n.mobile.support || {};
            n.extend(n.support, t);
            n.extend(n.mobile.support, t)
        }(n), function (n, t, r) {
            function f(t, i, u, f) {
                var e = u.type;
                u.type = i;
                f ? n.event.trigger(u, r, t) : n.event.dispatch.call(t, u);
                u.type = e
            }

            var u = n(i), e = n.mobile.support.touch, s = "touchmove scroll", h = e ? "touchstart" : "mousedown",
                c = e ? "touchend" : "mouseup", o = e ? "touchmove" : "mousemove";
            n.each("touchstart touchmove touchend tap taphold swipe swipeleft swiperight scrollstart scrollstop".split(" "), function (t, i) {
                n.fn[i] = function (n) {
                    return n ? this.bind(i, n) : this.trigger(i)
                };
                n.attrFn && (n.attrFn[i] = !0)
            });
            n.event.special.scrollstart = {
                enabled: !0, setup: function () {
                    function i(n, i) {
                        t = i;
                        f(r, t ? "scrollstart" : "scrollstop", n)
                    }

                    var r = this, e = n(r), t, u;
                    e.bind(s, function (r) {
                        n.event.special.scrollstart.enabled && (t || i(r, !0), clearTimeout(u), u = setTimeout(function () {
                            i(r, !1)
                        }, 50))
                    })
                }, teardown: function () {
                    n(this).unbind(s)
                }
            };
            n.event.special.tap = {
                tapholdThreshold: 750, emitTapOnTaphold: !0, setup: function () {
                    var i = this, r = n(i), t = !1;
                    r.bind("vmousedown", function (e) {
                        function o() {
                            clearTimeout(l)
                        }

                        function s() {
                            o();
                            r.unbind("vclick", h).unbind("vmouseup", o);
                            u.unbind("vmousecancel", s)
                        }

                        function h(n) {
                            s();
                            !t && c === n.target ? f(i, "tap", n) : t && n.preventDefault()
                        }

                        if (t = !1, e.which && e.which !== 1)return !1;
                        var c = e.target, l;
                        r.bind("vmouseup", o).bind("vclick", h);
                        u.bind("vmousecancel", s);
                        l = setTimeout(function () {
                            n.event.special.tap.emitTapOnTaphold || (t = !0);
                            f(i, "taphold", n.Event("taphold", {target: c}))
                        }, n.event.special.tap.tapholdThreshold)
                    })
                }, teardown: function () {
                    n(this).unbind("vmousedown").unbind("vclick").unbind("vmouseup");
                    u.unbind("vmousecancel")
                }
            };
            n.event.special.swipe = {
                scrollSupressionThreshold: 30,
                durationThreshold: 1e3,
                horizontalDistanceThreshold: 30,
                verticalDistanceThreshold: 30,
                getLocation: function (n) {
                    var u = t.pageXOffset, f = t.pageYOffset, i = n.clientX, r = n.clientY;
                    return n.pageY === 0 && Math.floor(r) > Math.floor(n.pageY) || n.pageX === 0 && Math.floor(i) > Math.floor(n.pageX) ? (i -= u, r -= f) : (r < n.pageY - f || i < n.pageX - u) && (i = n.pageX - u, r = n.pageY - f), {
                        x: i,
                        y: r
                    }
                },
                start: function (t) {
                    var r = t.originalEvent.touches ? t.originalEvent.touches[0] : t,
                        i = n.event.special.swipe.getLocation(r);
                    return {time: (new Date).getTime(), coords: [i.x, i.y], origin: n(t.target)}
                },
                stop: function (t) {
                    var r = t.originalEvent.touches ? t.originalEvent.touches[0] : t,
                        i = n.event.special.swipe.getLocation(r);
                    return {time: (new Date).getTime(), coords: [i.x, i.y]}
                },
                handleSwipe: function (t, i, r, u) {
                    if (i.time - t.time < n.event.special.swipe.durationThreshold && Math.abs(t.coords[0] - i.coords[0]) > n.event.special.swipe.horizontalDistanceThreshold && Math.abs(t.coords[1] - i.coords[1]) < n.event.special.swipe.verticalDistanceThreshold) {
                        var e = t.coords[0] > i.coords[0] ? "swipeleft" : "swiperight";
                        return f(r, "swipe", n.Event("swipe", {
                            target: u,
                            swipestart: t,
                            swipestop: i
                        }), !0), f(r, e, n.Event(e, {target: u, swipestart: t, swipestop: i}), !0), !0
                    }
                    return !1
                },
                eventInProgress: !1,
                setup: function () {
                    var i, r = this, f = n(r), t = {};
                    i = n.data(this, "mobile-events");
                    i || (i = {length: 0}, n.data(this, "mobile-events", i));
                    i.length++;
                    i.swipe = t;
                    t.start = function (i) {
                        if (!n.event.special.swipe.eventInProgress) {
                            n.event.special.swipe.eventInProgress = !0;
                            var e, s = n.event.special.swipe.start(i), h = i.target, f = !1;
                            t.move = function (t) {
                                s && !t.isDefaultPrevented() && (e = n.event.special.swipe.stop(t), f || (f = n.event.special.swipe.handleSwipe(s, e, r, h), f && (n.event.special.swipe.eventInProgress = !1)), Math.abs(s.coords[0] - e.coords[0]) > n.event.special.swipe.scrollSupressionThreshold && t.preventDefault())
                            };
                            t.stop = function () {
                                f = !0;
                                n.event.special.swipe.eventInProgress = !1;
                                u.off(o, t.move);
                                t.move = null
                            };
                            u.on(o, t.move).one(c, t.stop)
                        }
                    };
                    f.on(h, t.start)
                },
                teardown: function () {
                    var i, t;
                    i = n.data(this, "mobile-events");
                    i && (t = i.swipe, delete i.swipe, i.length--, i.length === 0 && n.removeData(this, "mobile-events"));
                    t && (t.start && n(this).off(h, t.start), t.move && u.off(o, t.move), t.stop && u.off(c, t.stop))
                }
            };
            n.each({
                scrollstop: "scrollstart",
                taphold: "tap",
                swipeleft: "swipe.left",
                swiperight: "swipe.right"
            }, function (t, i) {
                n.event.special[t] = {
                    setup: function () {
                        n(this).bind(i, n.noop)
                    }, teardown: function () {
                        n(this).unbind(i)
                    }
                }
            })
        }(n, this)
    });
    !function (n) {
        function t(n, t) {
            if (!(n.originalEvent.touches.length > 1)) {
                n.preventDefault();
                var i = n.originalEvent.changedTouches[0], r = document.createEvent("MouseEvents");
                r.initMouseEvent(t, !0, !0, window, 1, i.screenX, i.screenY, i.clientX, i.clientY, !1, !1, !1, !1, 0, null);
                n.target.dispatchEvent(r)
            }
        }

        if (n.support.touch = "ontouchend" in document, n.support.touch) {
            var r, i = n.ui.mouse.prototype, u = i._mouseInit, f = i._mouseDestroy;
            i._touchStart = function (n) {
                var i = this;
                !r && i._mouseCapture(n.originalEvent.changedTouches[0]) && (r = !0, i._touchMoved = !1, t(n, "mouseover"), t(n, "mousemove"), t(n, "mousedown"))
            };
            i._touchMove = function (n) {
                r && (this._touchMoved = !0, t(n, "mousemove"))
            };
            i._touchEnd = function (n) {
                r && (t(n, "mouseup"), t(n, "mouseout"), this._touchMoved || t(n, "click"), r = !1)
            };
            i._mouseInit = function () {
                var t = this;
                t.element.bind({
                    touchstart: n.proxy(t, "_touchStart"),
                    touchmove: n.proxy(t, "_touchMove"),
                    touchend: n.proxy(t, "_touchEnd")
                });
                u.call(t)
            };
            i._mouseDestroy = function () {
                var t = this;
                t.element.unbind({
                    touchstart: n.proxy(t, "_touchStart"),
                    touchmove: n.proxy(t, "_touchMove"),
                    touchend: n.proxy(t, "_touchEnd")
                });
                f.call(t)
            }
        }
    }(jQuery);
    var deviceIsAndroid = navigator.userAgent.indexOf("Android") > 0,
        deviceIsIOS = /iP(ad|hone|od)/.test(navigator.userAgent),
        deviceIsIOS4 = deviceIsIOS && /OS 4_\d(_\d)?/.test(navigator.userAgent),
        deviceIsIOSWithBadTarget = deviceIsIOS && /OS ([6-9]|\d{2})_\d/.test(navigator.userAgent),
        deviceIsBlackBerry10 = navigator.userAgent.indexOf("BB10") > 0;
    FastClick.prototype.needsClick = function (n) {
        "use strict";
        switch (n.nodeName.toLowerCase()) {
            case"button":
            case"select":
            case"textarea":
                if (n.disabled)return !0;
                break;
            case"input":
                if (deviceIsIOS && "file" === n.type || n.disabled)return !0;
                break;
            case"label":
            case"video":
                return !0
        }
        return /\bneedsclick\b/.test(n.className)
    };
    FastClick.prototype.needsFocus = function (n) {
        "use strict";
        switch (n.nodeName.toLowerCase()) {
            case"textarea":
                return !0;
            case"select":
                return !deviceIsAndroid;
            case"input":
                switch (n.type) {
                    case"button":
                    case"checkbox":
                    case"file":
                    case"image":
                    case"radio":
                    case"submit":
                        return !1
                }
                return !n.disabled && !n.readOnly;
            default:
                return /\bneedsfocus\b/.test(n.className)
        }
    };
    FastClick.prototype.sendClick = function (n, t) {
        "use strict";
        var r, i;
        document.activeElement && document.activeElement !== n && document.activeElement.blur();
        i = t.changedTouches[0];
        r = document.createEvent("MouseEvents");
        r.initMouseEvent(this.determineEventType(n), !0, !0, window, 1, i.screenX, i.screenY, i.clientX, i.clientY, !1, !1, !1, !1, 0, null);
        r.forwardedTouchEvent = !0;
        n.dispatchEvent(r)
    };
    FastClick.prototype.determineEventType = function (n) {
        "use strict";
        return deviceIsAndroid && "select" === n.tagName.toLowerCase() ? "mousedown" : "click"
    };
    FastClick.prototype.focus = function (n) {
        "use strict";
        var t;
        deviceIsIOS && n.setSelectionRange && 0 !== n.type.indexOf("date") && "time" !== n.type ? (t = n.value.length, n.setSelectionRange(t, t)) : n.focus()
    };
    FastClick.prototype.updateScrollParent = function (n) {
        "use strict";
        var i, t;
        if (i = n.fastClickScrollParent, !i || !i.contains(n)) {
            t = n;
            do {
                if (t.scrollHeight > t.offsetHeight) {
                    i = t;
                    n.fastClickScrollParent = t;
                    break
                }
                t = t.parentElement
            } while (t)
        }
        i && (i.fastClickLastScrollTop = i.scrollTop)
    };
    FastClick.prototype.getTargetElementFromEventTarget = function (n) {
        "use strict";
        return n.nodeType === Node.TEXT_NODE ? n.parentNode : n
    };
    FastClick.prototype.onTouchStart = function (n) {
        "use strict";
        var i, t, r;
        if (n.targetTouches.length > 1)return !0;
        if (i = this.getTargetElementFromEventTarget(n.target), t = n.targetTouches[0], deviceIsIOS) {
            if (r = window.getSelection(), r.rangeCount && !r.isCollapsed)return !0;
            if (!deviceIsIOS4) {
                if (t.identifier && t.identifier === this.lastTouchIdentifier)return n.preventDefault(), !1;
                this.lastTouchIdentifier = t.identifier;
                this.updateScrollParent(i)
            }
        }
        return this.trackingClick = !0, this.trackingClickStart = n.timeStamp, this.targetElement = i, this.touchStartX = t.pageX, this.touchStartY = t.pageY, n.timeStamp - this.lastClickTime < this.tapDelay && n.preventDefault(), !0
    };
    FastClick.prototype.touchHasMoved = function (n) {
        "use strict";
        var t = n.changedTouches[0], i = this.touchBoundary;
        return Math.abs(t.pageX - this.touchStartX) > i || Math.abs(t.pageY - this.touchStartY) > i ? !0 : !1
    };
    FastClick.prototype.onTouchMove = function (n) {
        "use strict";
        return this.trackingClick ? ((this.targetElement !== this.getTargetElementFromEventTarget(n.target) || this.touchHasMoved(n)) && (this.trackingClick = !1, this.targetElement = null), !0) : !0
    };
    FastClick.prototype.findControl = function (n) {
        "use strict";
        return void 0 !== n.control ? n.control : n.htmlFor ? document.getElementById(n.htmlFor) : n.querySelector("button, input:not([type=hidden]), keygen, meter, output, progress, select, textarea")
    };
    FastClick.prototype.onTouchEnd = function (n) {
        "use strict";
        var f, e, i, r, u, t = this.targetElement;
        if (!this.trackingClick)return !0;
        if (n.timeStamp - this.lastClickTime < this.tapDelay)return this.cancelNextClick = !0, !0;
        if (this.cancelNextClick = !1, this.lastClickTime = n.timeStamp, e = this.trackingClickStart, this.trackingClick = !1, this.trackingClickStart = 0, deviceIsIOSWithBadTarget && (u = n.changedTouches[0], t = document.elementFromPoint(u.pageX - window.pageXOffset, u.pageY - window.pageYOffset) || t, t.fastClickScrollParent = this.targetElement.fastClickScrollParent), i = t.tagName.toLowerCase(), "label" === i) {
            if (f = this.findControl(t)) {
                if (this.focus(t), deviceIsAndroid)return !1;
                t = f
            }
        } else if (this.needsFocus(t))return n.timeStamp - e > 100 || deviceIsIOS && window.top !== window && "input" === i ? (this.targetElement = null, !1) : (this.focus(t), this.sendClick(t, n), deviceIsIOS && "select" === i || (this.targetElement = null, n.preventDefault()), !1);
        return deviceIsIOS && !deviceIsIOS4 && (r = t.fastClickScrollParent, r && r.fastClickLastScrollTop !== r.scrollTop) ? !0 : (this.needsClick(t) || (n.preventDefault(), this.sendClick(t, n)), !1)
    };
    FastClick.prototype.onTouchCancel = function () {
        "use strict";
        this.trackingClick = !1;
        this.targetElement = null
    };
    FastClick.prototype.onMouse = function (n) {
        "use strict";
        return this.targetElement ? n.forwardedTouchEvent ? !0 : n.cancelable && (!this.needsClick(this.targetElement) || this.cancelNextClick) ? (n.stopImmediatePropagation ? n.stopImmediatePropagation() : n.propagationStopped = !0, n.stopPropagation(), n.preventDefault(), !1) : !0 : !0
    };
    FastClick.prototype.onClick = function (n) {
        "use strict";
        var t;
        return this.trackingClick ? (this.targetElement = null, this.trackingClick = !1, !0) : "submit" === n.target.type && 0 === n.detail ? !0 : (t = this.onMouse(n), t || (this.targetElement = null), t)
    };
    FastClick.prototype.destroy = function () {
        "use strict";
        var n = this.layer;
        deviceIsAndroid && (n.removeEventListener("mouseover", this.onMouse, !0), n.removeEventListener("mousedown", this.onMouse, !0), n.removeEventListener("mouseup", this.onMouse, !0));
        n.removeEventListener("click", this.onClick, !0);
        n.removeEventListener("touchstart", this.onTouchStart, !1);
        n.removeEventListener("touchmove", this.onTouchMove, !1);
        n.removeEventListener("touchend", this.onTouchEnd, !1);
        n.removeEventListener("touchcancel", this.onTouchCancel, !1)
    };
    FastClick.notNeeded = function (n) {
        "use strict";
        var t, r, i;
        return "undefined" == typeof window.ontouchstart ? !0 : (r = +(/Chrome\/([0-9]+)/.exec(navigator.userAgent) || [, 0])[1]) && (!deviceIsAndroid || (t = document.querySelector("meta[name=viewport]")) && (-1 !== t.content.indexOf("user-scalable=no") || r > 31 && document.documentElement.scrollWidth <= window.outerWidth)) ? !0 : deviceIsBlackBerry10 && (i = navigator.userAgent.match(/Version\/([0-9]*)\.([0-9]*)/), i[1] >= 10 && i[2] >= 3 && (t = document.querySelector("meta[name=viewport]"))) && (-1 !== t.content.indexOf("user-scalable=no") || document.documentElement.scrollWidth <= window.outerWidth) ? !0 : "none" === n.style.msTouchAction ? !0 : !1
    };
    FastClick.attach = function (n, t) {
        "use strict";
        return new FastClick(n, t)
    };
    "function" == typeof define && "object" == typeof define.amd && define.amd ? define(function () {
        "use strict";
        return FastClick
    }) : "undefined" != typeof module && module.exports ? (module.exports = FastClick.attach, module.exports.FastClick = FastClick) : window.FastClick = FastClick, function (n) {
        typeof define == "function" && define.amd ? define(["jquery"], n) : typeof exports == "object" ? n(require("jquery")) : n(jQuery)
    }(function (n) {
        function i(n) {
            return t.raw ? n : encodeURIComponent(n)
        }

        function f(n) {
            return t.raw ? n : decodeURIComponent(n)
        }

        function e(n) {
            return i(t.json ? JSON.stringify(n) : String(n))
        }

        function o(n) {
            n.indexOf('"') === 0 && (n = n.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, "\\"));
            try {
                return n = decodeURIComponent(n.replace(u, " ")), t.json ? JSON.parse(n) : n
            } catch (n) {
            }
        }

        function r(i, r) {
            var u = t.raw ? i : o(i);
            return n.isFunction(r) ? r(u) : u
        }

        var u = /\+/g, t = n.cookie = function (u, o, s) {
            var y, a, h, v, c, p;
            if (o !== undefined && !n.isFunction(o))return s = n.extend({}, t.defaults, s), typeof s.expires == "number" && (y = s.expires, a = s.expires = new Date, a.setTime(+a + y * 864e5)), document.cookie = [i(u), "=", e(o), s.expires ? "; expires=" + s.expires.toUTCString() : "", s.path ? "; path=" + s.path : "", s.domain ? "; domain=" + s.domain : "", s.secure ? "; secure" : ""].join("");
            for (h = u ? undefined : {}, v = document.cookie ? document.cookie.split("; ") : [], c = 0, p = v.length; c < p; c++) {
                var w = v[c].split("="), b = f(w.shift()), l = w.join("=");
                if (u && u === b) {
                    h = r(l, o);
                    break
                }
                u || (l = r(l)) === undefined || (h[b] = l)
            }
            return h
        };
        t.defaults = {};
        n.removeCookie = function (t, i) {
            return n.cookie(t) === undefined ? !1 : (n.cookie(t, "", n.extend({}, i, {expires: -1})), !n.cookie(t))
        }
    }), function () {
        var n, t = [].indexOf || function (n) {
                for (var t = 0, i = this.length; t < i; t++)if (t in this && this[t] === n)return t;
                return -1
            };
        n = jQuery;
        n.fn.validateCreditCard = function (i, r) {
            var f, u, e, c, l, a, v, o, y, s, p, w, h;
            for (e = [{name: "amex", pattern: /^3[47]/, valid_length: [15]}, {
                name: "diners_club_carte_blanche",
                pattern: /^30[0-5]/,
                valid_length: [14]
            }, {name: "diners_club_international", pattern: /^36/, valid_length: [14]}, {
                name: "jcb",
                pattern: /^35(2[89]|[3-8][0-9])/,
                valid_length: [16]
            }, {name: "laser", pattern: /^(6304|670[69]|6771)/, valid_length: [16, 17, 18, 19]}, {
                name: "visa_electron",
                pattern: /^(4026|417500|4508|4844|491(3|7))/,
                valid_length: [16]
            }, {name: "visa", pattern: /^4/, valid_length: [16]}, {
                name: "mastercard",
                pattern: /^5[1-5]/,
                valid_length: [16]
            }, {
                name: "maestro",
                pattern: /^(5018|5020|5038|6304|6759|676[1-3])/,
                valid_length: [12, 13, 14, 15, 16, 17, 18, 19]
            }, {
                name: "discover",
                pattern: /^(6011|622(12[6-9]|1[3-9][0-9]|[2-8][0-9]{2}|9[0-1][0-9]|92[0-5]|64[4-9])|65)/,
                valid_length: [16]
            }], r == null && (r = {}), (w = r.accept) == null && (r.accept = function () {
                var n, i, t;
                for (t = [], n = 0, i = e.length; n < i; n++)f = e[n], t.push(f.name);
                return t
            }()), h = r.accept, s = 0, p = h.length; s < p; s++)if (u = h[s], t.call(function () {
                    var n, i, t;
                    for (t = [], n = 0, i = e.length; n < i; n++)f = e[n], t.push(f.name);
                    return t
                }(), u) < 0)throw"Credit card type '" + u + "' is not supported";
            return c = function (n) {
                var i, s, o;
                for (o = function () {
                    var n, u, o, i;
                    for (i = [], n = 0, u = e.length; n < u; n++)f = e[n], (o = f.name, t.call(r.accept, o) >= 0) && i.push(f);
                    return i
                }(), i = 0, s = o.length; i < s; i++)if (u = o[i], n.match(u.pattern))return u;
                return null
            }, a = function (n) {
                var t, i, r, u, e, f;
                for (r = 0, f = n.split("").reverse(), i = u = 0, e = f.length; u < e; i = ++u)t = f[i], t = +t, i % 2 ? (t *= 2, r += t < 10 ? t : t - 9) : r += t;
                return r % 10 == 0
            }, l = function (n, i) {
                var r;
                return r = n.length, t.call(i.valid_length, r) >= 0
            }, y = function (n) {
                var t, r;
                return u = c(n), r = !1, t = !1, u != null && (r = a(n), t = l(n, u)), i({
                    card_type: u,
                    luhn_valid: r,
                    length_valid: t
                })
            }, o = function () {
                var t;
                return t = v(n(this).val()), y(t)
            }, v = function (n) {
                return n.replace(/[ -]/g, "")
            }, this.bind("input", function () {
                return n(this).unbind("keyup"), o.call(this)
            }), this.bind("keyup", function () {
                return o.call(this)
            }), this.length !== 0 && o.call(this), this
        }
    }.call(this);
    !function (n) {
        function h() {
            var t, i, u = {height: e.innerHeight, width: e.innerWidth};
            return u.height || (t = f.compatMode, (t || !n.support.boxModel) && (i = "CSS1Compat" === t ? r : f.body, u = {
                height: i.clientHeight,
                width: i.clientWidth
            })), u
        }

        function c() {
            return {
                top: e.pageYOffset || r.scrollTop || f.body.scrollTop,
                left: e.pageXOffset || r.scrollLeft || f.body.scrollLeft
            }
        }

        function l() {
            var w, o = n(), s = 0;
            if (n.each(u, function (n, t) {
                    var i = t.data.selector, r = t.$element;
                    o = o.add(i ? r.find(i) : r)
                }), w = o.length)for (i = i || h(), t = t || c(); w > s; s++)if (n.contains(r, o[s])) {
                var a, v, y, e = n(o[s]), l = {height: e.height(), width: e.width()}, f = e.offset(),
                    p = e.data("inview");
                if (!t || !i)return;
                f.top + l.height > t.top && f.top < t.top + i.height && f.left + l.width > t.left && f.left < t.left + i.width ? (a = t.left > f.left ? "right" : t.left + i.width < f.left + l.width ? "left" : "both", v = t.top > f.top ? "bottom" : t.top + i.height < f.top + l.height ? "top" : "both", y = a + "-" + v, p && p === y || e.data("inview", y).trigger("inview", [!0, a, v])) : p && e.data("inview", !1).trigger("inview", [!1])
            }
        }

        var i, t, o, u = {}, f = document, e = window, r = f.documentElement, s = n.expando;
        n.event.special.inview = {
            add: function (t) {
                u[t.guid + "-" + this[s]] = {data: t, $element: n(this)};
                o || n.isEmptyObject(u) || (o = setInterval(l, 250))
            }, remove: function (t) {
                try {
                    delete u[t.guid + "-" + this[s]]
                } catch (n) {
                }
                n.isEmptyObject(u) && (clearInterval(o), o = null)
            }
        };
        n(e).bind("scroll resize scrollstop", function () {
            i = t = null
        });
        !r.addEventListener && r.attachEvent && r.attachEvent("onfocusin", function () {
            t = null
        })
    }(jQuery);
    Mailcheck = {
        domainThreshold: 4,
        topLevelThreshold: 3,
        defaultDomains: "yahoo.com google.com hotmail.com gmail.com me.com aol.com mac.com live.com comcast.net googlemail.com msn.com hotmail.co.uk yahoo.co.uk facebook.com verizon.net sbcglobal.net att.net gmx.com mail.com outlook.com icloud.com".split(" "),
        defaultTopLevelDomains: "co.jp co.uk com net org info edu gov mil ca".split(" "),
        run: function (n) {
            n.domains = n.domains || Mailcheck.defaultDomains;
            n.topLevelDomains = n.topLevelDomains || Mailcheck.defaultTopLevelDomains;
            n.distanceFunction = n.distanceFunction || Mailcheck.sift3Distance;
            var t = function (n) {
                return n
            }, i = n.suggested || t, t = n.empty || t;
            return (n = Mailcheck.suggest(Mailcheck.encodeEmail(n.email), n.domains, n.topLevelDomains, n.distanceFunction)) ? i(n) : t()
        },
        suggest: function (n, t, i, r) {
            if (n = n.toLowerCase(), n = this.splitEmail(n), t = this.findClosestDomain(n.domain, t, r, this.domainThreshold)) {
                if (t != n.domain)return {address: n.address, domain: t, full: n.address + "@" + t}
            } else if (i = this.findClosestDomain(n.topLevelDomain, i, r, this.topLevelThreshold), n.domain && i && i != n.topLevelDomain)return r = n.domain, t = r.substring(0, r.lastIndexOf(n.topLevelDomain)) + i, {
                address: n.address,
                domain: t,
                full: n.address + "@" + t
            };
            return !1
        },
        findClosestDomain: function (n, t, i, r) {
            var o, f, e, u;
            if (r = r || this.topLevelThreshold, f = 99, e = null, !n || !t)return !1;
            for (i || (i = this.sift3Distance), u = 0; u < t.length; u++) {
                if (n === t[u])return n;
                o = i(n, t[u]);
                o < f && (f = o, e = t[u])
            }
            return f <= r && null !== e ? e : !1
        },
        sift3Distance: function (n, t) {
            var r;
            if (null == n || 0 === n.length)return null == t || 0 === t.length ? 0 : t.length;
            if (null == t || 0 === t.length)return n.length;
            for (var i = 0, u = 0, f = 0, e = 0; i + u < n.length && i + f < t.length;) {
                if (n.charAt(i + u) == t.charAt(i + f)) e++; else for (r = f = u = 0; 5 > r; r++) {
                    if (i + r < n.length && n.charAt(i + r) == t.charAt(i)) {
                        u = r;
                        break
                    }
                    if (i + r < t.length && n.charAt(i) == t.charAt(i + r)) {
                        f = r;
                        break
                    }
                }
                i++
            }
            return (n.length + t.length) / 2 - e
        },
        splitEmail: function (n) {
            var t;
            if (n = n.trim().split("@"), 2 > n.length)return !1;
            for (t = 0; t < n.length; t++)if ("" === n[t])return !1;
            var u = n.pop(), i = u.split("."), r = "";
            if (0 == i.length)return !1;
            if (1 == i.length) r = i[0]; else {
                for (t = 1; t < i.length; t++)r += i[t] + ".";
                2 <= i.length && (r = r.substring(0, r.length - 1))
            }
            return {topLevelDomain: r, domain: u, address: n.join("@")}
        },
        encodeEmail: function (n) {
            return n = encodeURI(n), n.replace("%20", " ").replace("%25", "%").replace("%5E", "^").replace("%60", "`").replace("%7B", "{").replace("%7C", "|").replace("%7D", "}")
        }
    };
    "undefined" != typeof module && module.exports && (module.exports = Mailcheck);
    "undefined" != typeof window && window.jQuery && function (n) {
        n.fn.mailcheck = function (n) {
            var t = this, i, r;
            n.suggested && (i = n.suggested, n.suggested = function (n) {
                i(t, n)
            });
            n.empty && (r = n.empty, n.empty = function () {
                r.call(null, t)
            });
            n.email = this.val();
            Mailcheck.run(n)
        }
    }(jQuery), function (n) {
        function e() {
            r && (i(e), n.fx.tick())
        }

        for (var r, t = 0, u = ["webkit", "moz"], i = window.requestAnimationFrame, f = window.cancelAnimationFrame; t < u.length && !i; t++)i = window[u[t] + "RequestAnimationFrame"], f = f || window[u[t] + "CancelAnimationFrame"] || window[u[t] + "CancelRequestAnimationFrame"];
        i ? (window.requestAnimationFrame = i, window.cancelAnimationFrame = f, n.fx.timer = function (t) {
            t() && n.timers.push(t) && !r && (r = !0, e())
        }, n.fx.stop = function () {
            r = !1
        }) : (window.requestAnimationFrame = function (n) {
            var i = (new Date).getTime(), r = Math.max(0, 16 - (i - t)), u = window.setTimeout(function () {
                n(i + r)
            }, r);
            return t = i + r, u
        }, window.cancelAnimationFrame = function (n) {
            clearTimeout(n)
        })
    }(jQuery);
    jQuery.fn.scrollTo = function (n, t, i) {
        var r = typeof i != "undefined" ? i : 0;
        return $(this).animate({scrollTop: $(this).scrollTop() - $(this).offset().top + ($(n).offset().top - r)}, t === undefined ? 1e3 : t), this
    };
    jQuery.fn.serializeObject = function () {
        var n = {}, t = this.serializeArray(), i = /^([^\[\]]+)\[(\d+)\]$/;
        return $.each(t, function () {
            for (var h = this.name, s = this.value, o = h.split("."), t = n, r, f, u, e; o.length;)r = o.shift(), f = i.exec(r), f ? (u = f[1], e = f[2], t[u] || (t[u] = []), t[u][e] || (t[u][e] = {}), t = t[u][e]) : o.length ? (t[r] || (t[r] = {}), t = t[r]) : t[r] ? t[r] && (t[r].push || (t[r] = [t[r]]), t[r].push(s || "")) : t[r] = s || ""
        }), n
    }, function (n) {
        "use strict";
        typeof define == "function" && define.amd ? define(["jquery"], n) : typeof exports != "undefined" ? module.exports = n(require("jquery")) : n(jQuery)
    }(function (n) {
        "use strict";
        var t = window.Slick || {};
        t = function () {
            function i(i, r) {
                var u = this, f;
                u.defaults = {
                    accessibility: !0,
                    adaptiveHeight: !1,
                    appendArrows: n(i),
                    appendDots: n(i),
                    arrows: !0,
                    asNavFor: null,
                    prevArrow: '<button type="button" data-role="none" class="slick-prev" aria-label="Previous" tabindex="0" role="button">Previous<\/button>',
                    nextArrow: '<button type="button" data-role="none" class="slick-next" aria-label="Next" tabindex="0" role="button">Next<\/button>',
                    autoplay: !1,
                    autoplaySpeed: 3e3,
                    centerMode: !1,
                    centerPadding: "50px",
                    cssEase: "ease",
                    customPaging: function (n, t) {
                        return '<button type="button" data-role="none" role="button" aria-required="false" tabindex="0">' + (t + 1) + "<\/button>"
                    },
                    dots: !1,
                    dotsClass: "slick-dots",
                    draggable: !0,
                    easing: "linear",
                    edgeFriction: .35,
                    fade: !1,
                    focusOnSelect: !1,
                    infinite: !0,
                    initialSlide: 0,
                    lazyLoad: "ondemand",
                    lazyLoadBuffer: 2,
                    mobileFirst: !1,
                    pauseOnHover: !0,
                    pauseOnDotsHover: !1,
                    respondTo: "window",
                    responsive: null,
                    rows: 1,
                    rtl: !1,
                    slide: "",
                    slidesPerRow: 1,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    speed: 500,
                    swipe: !0,
                    swipeToSlide: !1,
                    touchMove: !0,
                    touchThreshold: 5,
                    useCSS: !0,
                    variableWidth: !1,
                    vertical: !1,
                    verticalSwiping: !1,
                    waitForAnimate: !0,
                    zIndex: 1e3
                };
                u.initials = {
                    animating: !1,
                    dragging: !1,
                    autoPlayTimer: null,
                    currentDirection: 0,
                    currentLeft: null,
                    currentSlide: 0,
                    direction: 1,
                    $dots: null,
                    listWidth: null,
                    listHeight: null,
                    loadIndex: 0,
                    $nextArrow: null,
                    $prevArrow: null,
                    slideCount: null,
                    slideWidth: null,
                    $slideTrack: null,
                    $slides: null,
                    sliding: !1,
                    slideOffset: 0,
                    swipeLeft: null,
                    $list: null,
                    touchObject: {},
                    transformsEnabled: !1,
                    unslicked: !1
                };
                n.extend(u, u.initials);
                u.activeBreakpoint = null;
                u.animType = null;
                u.animProp = null;
                u.breakpoints = [];
                u.breakpointSettings = [];
                u.cssTransitions = !1;
                u.hidden = "hidden";
                u.paused = !1;
                u.positionProp = null;
                u.respondTo = null;
                u.rowCount = 1;
                u.shouldClick = !0;
                u.$slider = n(i);
                u.$slidesCache = null;
                u.transformType = null;
                u.transitionType = null;
                u.visibilityChange = "visibilitychange";
                u.windowWidth = 0;
                u.windowTimer = null;
                f = n(i).data("slick") || {};
                u.options = n.extend({}, u.defaults, f, r);
                u.currentSlide = u.options.initialSlide;
                u.originalSettings = u.options;
                typeof document.mozHidden != "undefined" ? (u.hidden = "mozHidden", u.visibilityChange = "mozvisibilitychange") : typeof document.webkitHidden != "undefined" && (u.hidden = "webkitHidden", u.visibilityChange = "webkitvisibilitychange");
                u.autoPlay = n.proxy(u.autoPlay, u);
                u.autoPlayClear = n.proxy(u.autoPlayClear, u);
                u.changeSlide = n.proxy(u.changeSlide, u);
                u.clickHandler = n.proxy(u.clickHandler, u);
                u.selectHandler = n.proxy(u.selectHandler, u);
                u.setPosition = n.proxy(u.setPosition, u);
                u.swipeHandler = n.proxy(u.swipeHandler, u);
                u.dragHandler = n.proxy(u.dragHandler, u);
                u.keyHandler = n.proxy(u.keyHandler, u);
                u.autoPlayIterator = n.proxy(u.autoPlayIterator, u);
                u.instanceUid = t++;
                u.htmlExpr = /^(?:\s*(<[\w\W]+>)[^>]*)$/;
                u.registerBreakpoints();
                u.init(!0);
                u.checkResponsive(!0)
            }

            var t = 0;
            return i
        }();
        t.prototype.addSlide = t.prototype.slickAdd = function (t, i, r) {
            var u = this;
            if (typeof i == "boolean") r = i, i = null; else if (i < 0 || i >= u.slideCount)return !1;
            u.unload();
            typeof i == "number" ? i === 0 && u.$slides.length === 0 ? n(t).appendTo(u.$slideTrack) : r ? n(t).insertBefore(u.$slides.eq(i)) : n(t).insertAfter(u.$slides.eq(i)) : r === !0 ? n(t).prependTo(u.$slideTrack) : n(t).appendTo(u.$slideTrack);
            u.$slides = u.$slideTrack.children(this.options.slide);
            u.$slideTrack.children(this.options.slide).detach();
            u.$slideTrack.append(u.$slides);
            u.$slides.each(function (t, i) {
                n(i).attr("data-slick-index", t)
            });
            u.$slidesCache = u.$slides;
            u.reinit()
        };
        t.prototype.animateHeight = function () {
            var n = this, t;
            n.options.slidesToShow === 1 && n.options.adaptiveHeight === !0 && n.options.vertical === !1 && (t = n.$slides.eq(n.currentSlide).outerHeight(!0), n.$list.animate({height: t}, n.options.speed))
        };
        t.prototype.animateSlide = function (t, i) {
            var u = {}, r = this;
            r.animateHeight();
            r.options.rtl === !0 && r.options.vertical === !1 && (t = -t);
            r.transformsEnabled === !1 ? r.options.vertical === !1 ? r.$slideTrack.animate({left: t}, r.options.speed, r.options.easing, i) : r.$slideTrack.animate({top: t}, r.options.speed, r.options.easing, i) : r.cssTransitions === !1 ? (r.options.rtl === !0 && (r.currentLeft = -r.currentLeft), n({animStart: r.currentLeft}).animate({animStart: t}, {
                duration: r.options.speed,
                easing: r.options.easing,
                step: function (n) {
                    n = Math.ceil(n);
                    r.options.vertical === !1 ? (u[r.animType] = "translate(" + n + "px, 0px)", r.$slideTrack.css(u)) : (u[r.animType] = "translate(0px," + n + "px)", r.$slideTrack.css(u))
                },
                complete: function () {
                    i && i.call()
                }
            })) : (r.applyTransition(), t = Math.ceil(t), u[r.animType] = r.options.vertical === !1 ? "translate3d(" + t + "px, 0px, 0px)" : "translate3d(0px," + t + "px, 0px)", r.$slideTrack.css(u), i && setTimeout(function () {
                r.disableTransition();
                i.call()
            }, r.options.speed))
        };
        t.prototype.asNavFor = function (t) {
            var r = this, i = r.options.asNavFor;
            i && i !== null && (i = n(i).not(r.$slider));
            i !== null && typeof i == "object" && i.each(function () {
                var i = n(this).slick("getSlick");
                i.unslicked || i.slideHandler(t, !0)
            })
        };
        t.prototype.applyTransition = function (n) {
            var t = this, i = {};
            i[t.transitionType] = t.options.fade === !1 ? t.transformType + " " + t.options.speed + "ms " + t.options.cssEase : "opacity " + t.options.speed + "ms " + t.options.cssEase;
            t.options.fade === !1 ? t.$slideTrack.css(i) : t.$slides.eq(n).css(i)
        };
        t.prototype.autoPlay = function () {
            var n = this;
            n.autoPlayTimer && clearInterval(n.autoPlayTimer);
            n.slideCount > n.options.slidesToShow && n.paused !== !0 && (n.autoPlayTimer = setInterval(n.autoPlayIterator, n.options.autoplaySpeed))
        };
        t.prototype.autoPlayClear = function () {
            var n = this;
            n.autoPlayTimer && clearInterval(n.autoPlayTimer)
        };
        t.prototype.autoPlayIterator = function () {
            var n = this;
            n.options.infinite === !1 ? n.direction === 1 ? (n.currentSlide + 1 === n.slideCount - 1 && (n.direction = 0), n.slideHandler(n.currentSlide + n.options.slidesToScroll)) : (n.currentSlide - 1 == 0 && (n.direction = 1), n.slideHandler(n.currentSlide - n.options.slidesToScroll)) : n.slideHandler(n.currentSlide + n.options.slidesToScroll)
        };
        t.prototype.buildArrows = function () {
            var t = this;
            t.options.arrows === !0 && (t.$prevArrow = n(t.options.prevArrow).addClass("slick-arrow"), t.$nextArrow = n(t.options.nextArrow).addClass("slick-arrow"), t.slideCount > t.options.slidesToShow ? (t.$prevArrow.removeClass("slick-hidden").removeAttr("aria-hidden tabindex"), t.$nextArrow.removeClass("slick-hidden").removeAttr("aria-hidden tabindex"), t.htmlExpr.test(t.options.prevArrow) && t.$prevArrow.prependTo(t.options.appendArrows), t.htmlExpr.test(t.options.nextArrow) && t.$nextArrow.appendTo(t.options.appendArrows), t.options.infinite !== !0 && t.$prevArrow.addClass("slick-disabled").attr("aria-disabled", "true")) : t.$prevArrow.add(t.$nextArrow).addClass("slick-hidden").attr({
                "aria-disabled": "true",
                tabindex: "-1"
            }))
        };
        t.prototype.buildDots = function () {
            var t = this, i, r;
            if (t.options.dots === !0 && t.slideCount > t.options.slidesToShow) {
                for (r = '<ul class="' + t.options.dotsClass + '">', i = 0; i <= t.getDotCount(); i += 1)r += "<li>" + t.options.customPaging.call(this, t, i) + "<\/li>";
                r += "<\/ul>";
                t.$dots = n(r).appendTo(t.options.appendDots);
                t.$dots.find("li").first().addClass("slick-active").attr("aria-hidden", "false")
            }
        };
        t.prototype.buildOut = function () {
            var t = this;
            t.$slides = t.$slider.children(t.options.slide + ":not(.slick-cloned)").addClass("slick-slide");
            t.slideCount = t.$slides.length;
            t.$slides.each(function (t, i) {
                n(i).attr("data-slick-index", t).data("originalStyling", n(i).attr("style") || "")
            });
            t.$slidesCache = t.$slides;
            t.$slider.addClass("slick-slider");
            t.$slideTrack = t.slideCount === 0 ? n('<div class="slick-track"/>').appendTo(t.$slider) : t.$slides.wrapAll('<div class="slick-track"/>').parent();
            t.$list = t.$slideTrack.wrap('<div aria-live="polite" class="slick-list"/>').parent();
            t.$slideTrack.css("opacity", 0);
            (t.options.centerMode === !0 || t.options.swipeToSlide === !0) && (t.options.slidesToScroll = 1);
            n("img[data-lazy]", t.$slider).not("[src]").addClass("slick-loading");
            t.setupInfinite();
            t.buildArrows();
            t.buildDots();
            t.updateDots();
            t.setSlideClasses(typeof t.currentSlide == "number" ? t.currentSlide : 0);
            t.options.draggable === !0 && t.$list.addClass("draggable")
        };
        t.prototype.buildRows = function () {
            var n = this, t, i, r, f, c, u, e, o, s, h;
            if (f = document.createDocumentFragment(), u = n.$slider.children(), n.options.rows > 1) {
                for (e = n.options.slidesPerRow * n.options.rows, c = Math.ceil(u.length / e), t = 0; t < c; t++) {
                    for (o = document.createElement("div"), i = 0; i < n.options.rows; i++) {
                        for (s = document.createElement("div"), r = 0; r < n.options.slidesPerRow; r++)h = t * e + (i * n.options.slidesPerRow + r), u.get(h) && s.appendChild(u.get(h));
                        o.appendChild(s)
                    }
                    f.appendChild(o)
                }
                n.$slider.html(f);
                n.$slider.children().children().children().css({
                    width: 100 / n.options.slidesPerRow + "%",
                    display: "inline-block"
                })
            }
        };
        t.prototype.checkResponsive = function (t, i) {
            var r = this, f, u, e, o = !1, s = r.$slider.width(), h = window.innerWidth || n(window).width();
            if (r.respondTo === "window" ? e = h : r.respondTo === "slider" ? e = s : r.respondTo === "min" && (e = Math.min(h, s)), r.options.responsive && r.options.responsive.length && r.options.responsive !== null) {
                u = null;
                for (f in r.breakpoints)r.breakpoints.hasOwnProperty(f) && (r.originalSettings.mobileFirst === !1 ? e < r.breakpoints[f] && (u = r.breakpoints[f]) : e > r.breakpoints[f] && (u = r.breakpoints[f]));
                u !== null ? r.activeBreakpoint !== null ? (u !== r.activeBreakpoint || i) && (r.activeBreakpoint = u, r.breakpointSettings[u] === "unslick" ? r.unslick(u) : (r.options = n.extend({}, r.originalSettings, r.breakpointSettings[u]), t === !0 && (r.currentSlide = r.options.initialSlide), r.refresh(t)), o = u) : (r.activeBreakpoint = u, r.breakpointSettings[u] === "unslick" ? r.unslick(u) : (r.options = n.extend({}, r.originalSettings, r.breakpointSettings[u]), t === !0 && (r.currentSlide = r.options.initialSlide), r.refresh(t)), o = u) : r.activeBreakpoint !== null && (r.activeBreakpoint = null, r.options = r.originalSettings, t === !0 && (r.currentSlide = r.options.initialSlide), r.refresh(t), o = u);
                t || o === !1 || r.$slider.trigger("breakpoint", [r, o])
            }
        };
        t.prototype.changeSlide = function (t, i) {
            var r = this, u = n(t.target), f, e, o, s;
            u.is("a") && t.preventDefault();
            u.is("li") || (u = u.closest("li"));
            o = r.slideCount % r.options.slidesToScroll != 0;
            f = o ? 0 : (r.slideCount - r.currentSlide) % r.options.slidesToScroll;
            switch (t.data.message) {
                case"previous":
                    e = f === 0 ? r.options.slidesToScroll : r.options.slidesToShow - f;
                    r.slideCount > r.options.slidesToShow && r.slideHandler(r.currentSlide - e, !1, i);
                    break;
                case"next":
                    e = f === 0 ? r.options.slidesToScroll : f;
                    r.slideCount > r.options.slidesToShow && r.slideHandler(r.currentSlide + e, !1, i);
                    break;
                case"index":
                    s = t.data.index === 0 ? 0 : t.data.index || u.index() * r.options.slidesToScroll;
                    r.slideHandler(r.checkNavigable(s), !1, i);
                    u.children().trigger("focus");
                    break;
                default:
                    return
            }
        };
        t.prototype.checkNavigable = function (n) {
            var u = this, t, i, r;
            if (t = u.getNavigableIndexes(), i = 0, n > t[t.length - 1]) n = t[t.length - 1]; else for (r in t) {
                if (n < t[r]) {
                    n = i;
                    break
                }
                i = t[r]
            }
            return n
        };
        t.prototype.cleanUpEvents = function () {
            var t = this;
            t.options.dots && t.$dots !== null && (n("li", t.$dots).off("click.slick", t.changeSlide), t.options.pauseOnDotsHover === !0 && t.options.autoplay === !0 && n("li", t.$dots).off("mouseenter.slick", n.proxy(t.setPaused, t, !0)).off("mouseleave.slick", n.proxy(t.setPaused, t, !1)));
            t.options.arrows === !0 && t.slideCount > t.options.slidesToShow && (t.$prevArrow && t.$prevArrow.off("click.slick", t.changeSlide), t.$nextArrow && t.$nextArrow.off("click.slick", t.changeSlide));
            t.$list.off("touchstart.slick mousedown.slick", t.swipeHandler);
            t.$list.off("touchmove.slick mousemove.slick", t.swipeHandler);
            t.$list.off("touchend.slick mouseup.slick", t.swipeHandler);
            t.$list.off("touchcancel.slick mouseleave.slick", t.swipeHandler);
            t.$list.off("click.slick", t.clickHandler);
            n(document).off(t.visibilityChange, t.visibility);
            t.$list.off("mouseenter.slick", n.proxy(t.setPaused, t, !0));
            t.$list.off("mouseleave.slick", n.proxy(t.setPaused, t, !1));
            t.options.accessibility === !0 && t.$list.off("keydown.slick", t.keyHandler);
            t.options.focusOnSelect === !0 && n(t.$slideTrack).children().off("click.slick", t.selectHandler);
            n(window).off("orientationchange.slick.slick-" + t.instanceUid, t.orientationChange);
            n(window).off("resize.slick.slick-" + t.instanceUid, t.resize);
            n("[draggable!=true]", t.$slideTrack).off("dragstart", t.preventDefault);
            n(window).off("load.slick.slick-" + t.instanceUid, t.setPosition);
            n(document).off("ready.slick.slick-" + t.instanceUid, t.setPosition)
        };
        t.prototype.cleanUpRows = function () {
            var n = this, t;
            n.options.rows > 1 && (t = n.$slides.children().children(), t.removeAttr("style"), n.$slider.html(t))
        };
        t.prototype.clickHandler = function (n) {
            var t = this;
            t.shouldClick === !1 && (n.stopImmediatePropagation(), n.stopPropagation(), n.preventDefault())
        };
        t.prototype.destroy = function (t) {
            var i = this;
            i.autoPlayClear();
            i.touchObject = {};
            i.cleanUpEvents();
            n(".slick-cloned", i.$slider).detach();
            i.$dots && i.$dots.remove();
            i.$prevArrow && i.$prevArrow.length && (i.$prevArrow.removeClass("slick-disabled slick-arrow slick-hidden").removeAttr("aria-hidden aria-disabled tabindex").css("display", ""), i.htmlExpr.test(i.options.prevArrow) && i.$prevArrow.remove());
            i.$nextArrow && i.$nextArrow.length && (i.$nextArrow.removeClass("slick-disabled slick-arrow slick-hidden").removeAttr("aria-hidden aria-disabled tabindex").css("display", ""), i.htmlExpr.test(i.options.nextArrow) && i.$nextArrow.remove());
            i.$slides && (i.$slides.removeClass("slick-slide slick-active slick-center slick-visible slick-current").removeAttr("aria-hidden").removeAttr("data-slick-index").each(function () {
                n(this).attr("style", n(this).data("originalStyling"))
            }), i.$slideTrack.children(this.options.slide).detach(), i.$slideTrack.detach(), i.$list.detach(), i.$slider.append(i.$slides));
            i.cleanUpRows();
            i.$slider.removeClass("slick-slider");
            i.$slider.removeClass("slick-initialized");
            i.unslicked = !0;
            t || i.$slider.trigger("destroy", [i])
        };
        t.prototype.disableTransition = function (n) {
            var t = this, i = {};
            i[t.transitionType] = "";
            t.options.fade === !1 ? t.$slideTrack.css(i) : t.$slides.eq(n).css(i)
        };
        t.prototype.fadeSlide = function (n, t) {
            var i = this;
            i.cssTransitions === !1 ? (i.$slides.eq(n).css({zIndex: i.options.zIndex}), i.$slides.eq(n).animate({opacity: 1}, i.options.speed, i.options.easing, t)) : (i.applyTransition(n), i.$slides.eq(n).css({
                opacity: 1,
                zIndex: i.options.zIndex
            }), t && setTimeout(function () {
                i.disableTransition(n);
                t.call()
            }, i.options.speed))
        };
        t.prototype.fadeSlideOut = function (n) {
            var t = this;
            t.cssTransitions === !1 ? t.$slides.eq(n).animate({
                opacity: 0,
                zIndex: t.options.zIndex - 2
            }, t.options.speed, t.options.easing) : (t.applyTransition(n), t.$slides.eq(n).css({
                opacity: 0,
                zIndex: t.options.zIndex - 2
            }))
        };
        t.prototype.filterSlides = t.prototype.slickFilter = function (n) {
            var t = this;
            n !== null && (t.unload(), t.$slideTrack.children(this.options.slide).detach(), t.$slidesCache.filter(n).appendTo(t.$slideTrack), t.reinit())
        };
        t.prototype.getCurrent = t.prototype.slickCurrentSlide = function () {
            var n = this;
            return n.currentSlide
        };
        t.prototype.getDotCount = function () {
            var n = this, t = 0, i = 0, r = 0;
            if (n.options.infinite === !0)while (t < n.slideCount)++r, t = i + n.options.slidesToShow, i += n.options.slidesToScroll <= n.options.slidesToShow ? n.options.slidesToScroll : n.options.slidesToShow; else if (n.options.centerMode === !0) r = n.slideCount; else while (t < n.slideCount)++r, t = i + n.options.slidesToShow, i += n.options.slidesToScroll <= n.options.slidesToShow ? n.options.slidesToScroll : n.options.slidesToShow;
            return r - 1
        };
        t.prototype.getLeft = function (n) {
            var t = this, f, r, u = 0, i;
            return t.slideOffset = 0, r = t.$slides.first().outerHeight(!0), t.options.infinite === !0 ? (t.slideCount > t.options.slidesToShow && (t.slideOffset = t.slideWidth * t.options.slidesToShow * -1, u = r * t.options.slidesToShow * -1), t.slideCount % t.options.slidesToScroll != 0 && n + t.options.slidesToScroll > t.slideCount && t.slideCount > t.options.slidesToShow && (n > t.slideCount ? (t.slideOffset = (t.options.slidesToShow - (n - t.slideCount)) * t.slideWidth * -1, u = (t.options.slidesToShow - (n - t.slideCount)) * r * -1) : (t.slideOffset = t.slideCount % t.options.slidesToScroll * t.slideWidth * -1, u = t.slideCount % t.options.slidesToScroll * r * -1))) : n + t.options.slidesToShow > t.slideCount && (t.slideOffset = (n + t.options.slidesToShow - t.slideCount) * t.slideWidth, u = (n + t.options.slidesToShow - t.slideCount) * r), t.slideCount <= t.options.slidesToShow && (t.slideOffset = 0, u = 0), t.options.centerMode === !0 && t.options.infinite === !0 ? t.slideOffset += t.slideWidth * Math.floor(t.options.slidesToShow / 2) - t.slideWidth : t.options.centerMode === !0 && (t.slideOffset = 0, t.slideOffset += t.slideWidth * Math.floor(t.options.slidesToShow / 2)), f = t.options.vertical === !1 ? n * t.slideWidth * -1 + t.slideOffset : n * r * -1 + u, t.options.variableWidth === !0 && (i = t.slideCount <= t.options.slidesToShow || t.options.infinite === !1 ? t.$slideTrack.children(".slick-slide").eq(n) : t.$slideTrack.children(".slick-slide").eq(n + t.options.slidesToShow), f = i[0] ? i[0].offsetLeft * -1 : 0, t.options.centerMode === !0 && (i = t.options.infinite === !1 ? t.$slideTrack.children(".slick-slide").eq(n) : t.$slideTrack.children(".slick-slide").eq(n + t.options.slidesToShow + 1), f = (i[0] ? i[0].offsetLeft * -1 : 0) + (t.$list.width() - i.outerWidth()) / 2)), f
        };
        t.prototype.getOption = t.prototype.slickGetOption = function (n) {
            var t = this;
            return t.options[n]
        };
        t.prototype.getNavigableIndexes = function () {
            var n = this, t = 0, i = 0, u = [], r;
            for (n.options.infinite === !1 ? r = n.slideCount : (t = n.options.slidesToScroll * -1, i = n.options.slidesToScroll * -1, r = n.slideCount * 2); t < r;)u.push(t), t = i + n.options.slidesToScroll, i += n.options.slidesToScroll <= n.options.slidesToShow ? n.options.slidesToScroll : n.options.slidesToShow;
            return u
        };
        t.prototype.getSlick = function () {
            return this
        };
        t.prototype.getSlideCount = function () {
            var t = this, i, r;
            return r = t.options.centerMode === !0 ? t.slideWidth * Math.floor(t.options.slidesToShow / 2) : 0, t.options.swipeToSlide === !0 ? (t.$slideTrack.find(".slick-slide").each(function (u, f) {
                if (f.offsetLeft - r + n(f).outerWidth() / 2 > t.swipeLeft * -1)return i = f, !1
            }), Math.abs(n(i).attr("data-slick-index") - t.currentSlide) || 1) : t.options.slidesToScroll
        };
        t.prototype.goTo = t.prototype.slickGoTo = function (n, t) {
            var i = this;
            i.changeSlide({data: {message: "index", index: parseInt(n)}}, t)
        };
        t.prototype.init = function (t) {
            var i = this;
            n(i.$slider).hasClass("slick-initialized") || (n(i.$slider).addClass("slick-initialized"), i.buildRows(), i.buildOut(), i.setProps(), i.startLoad(), i.loadSlider(), i.initializeEvents(), i.updateArrows(), i.updateDots());
            t && i.$slider.trigger("init", [i]);
            i.options.accessibility === !0 && i.initADA()
        };
        t.prototype.initArrowEvents = function () {
            var n = this;
            if (n.options.arrows === !0 && n.slideCount > n.options.slidesToShow) {
                n.$prevArrow.on("click.slick", {message: "previous"}, n.changeSlide);
                n.$nextArrow.on("click.slick", {message: "next"}, n.changeSlide)
            }
        };
        t.prototype.initDotEvents = function () {
            var t = this;
            if (t.options.dots === !0 && t.slideCount > t.options.slidesToShow) n("li", t.$dots).on("click.slick", {message: "index"}, t.changeSlide);
            if (t.options.dots === !0 && t.options.pauseOnDotsHover === !0 && t.options.autoplay === !0) n("li", t.$dots).on("mouseenter.slick", n.proxy(t.setPaused, t, !0)).on("mouseleave.slick", n.proxy(t.setPaused, t, !1))
        };
        t.prototype.initializeEvents = function () {
            var t = this;
            t.initArrowEvents();
            t.initDotEvents();
            t.$list.on("touchstart.slick mousedown.slick", {action: "start"}, t.swipeHandler);
            t.$list.on("touchmove.slick mousemove.slick", {action: "move"}, t.swipeHandler);
            t.$list.on("touchend.slick mouseup.slick", {action: "end"}, t.swipeHandler);
            t.$list.on("touchcancel.slick mouseleave.slick", {action: "end"}, t.swipeHandler);
            t.$list.on("click.slick", t.clickHandler);
            n(document).on(t.visibilityChange, n.proxy(t.visibility, t));
            t.$list.on("mouseenter.slick", n.proxy(t.setPaused, t, !0));
            t.$list.on("mouseleave.slick", n.proxy(t.setPaused, t, !1));
            if (t.options.accessibility === !0) t.$list.on("keydown.slick", t.keyHandler);
            if (t.options.focusOnSelect === !0) n(t.$slideTrack).children().on("click.slick", t.selectHandler);
            n(window).on("orientationchange.slick.slick-" + t.instanceUid, n.proxy(t.orientationChange, t));
            n(window).on("resize.slick.slick-" + t.instanceUid, n.proxy(t.resize, t));
            n("[draggable!=true]", t.$slideTrack).on("dragstart", t.preventDefault);
            n(window).on("load.slick.slick-" + t.instanceUid, t.setPosition);
            n(document).on("ready.slick.slick-" + t.instanceUid, t.setPosition)
        };
        t.prototype.initUI = function () {
            var n = this;
            n.options.arrows === !0 && n.slideCount > n.options.slidesToShow && (n.$prevArrow.show(), n.$nextArrow.show());
            n.options.dots === !0 && n.slideCount > n.options.slidesToShow && n.$dots.show();
            n.options.autoplay === !0 && n.autoPlay()
        };
        t.prototype.keyHandler = function (n) {
            var t = this;
            n.target.tagName.match("TEXTAREA|INPUT|SELECT") || (n.keyCode === 37 && t.options.accessibility === !0 ? t.changeSlide({data: {message: "previous"}}) : n.keyCode === 39 && t.options.accessibility === !0 && t.changeSlide({data: {message: "next"}}))
        };
        t.prototype.lazyLoad = function () {
            function f(t) {
                n("img[data-lazy]", t).each(function () {
                    var t = n(this), i = n(this).attr("data-lazy"), r = document.createElement("img");
                    r.onload = function () {
                        t.animate({opacity: 0}, 100, function () {
                            t.attr("src", i).animate({opacity: 1}, 200, function () {
                                t.removeAttr("data-lazy").removeClass("slick-loading")
                            })
                        })
                    };
                    r.src = i
                })
            }

            var t = this, e, r, i, u;
            t.options.centerMode === !0 ? t.options.infinite === !0 ? (i = t.currentSlide + (t.options.slidesToShow / 2 + 1), u = i + t.options.slidesToShow + 2) : (i = Math.max(0, t.currentSlide - (t.options.slidesToShow / 2 + 1)), u = 2 + (t.options.slidesToShow / 2 + 1) + t.currentSlide) : (i = t.options.infinite ? t.options.slidesToShow + t.currentSlide : t.currentSlide, u = i + t.options.lazyLoadBuffer, t.options.fade === !0 && i > 0 && i--);
            e = t.$slider.find(".slick-slide").slice(i, u);
            f(e);
            t.slideCount <= t.options.slidesToShow ? (r = t.$slider.find(".slick-slide"), f(r)) : t.currentSlide >= t.slideCount - t.options.slidesToShow ? (r = t.$slider.find(".slick-cloned").slice(0, t.options.slidesToShow), f(r)) : t.currentSlide === 0 && (r = t.$slider.find(".slick-cloned").slice(t.options.slidesToShow * -1), f(r))
        };
        t.prototype.loadSlider = function () {
            var n = this;
            n.setPosition();
            n.$slideTrack.css({opacity: 1});
            n.$slider.removeClass("slick-loading");
            n.initUI();
            n.options.lazyLoad === "progressive" && n.progressiveLazyLoad()
        };
        t.prototype.next = t.prototype.slickNext = function () {
            var n = this;
            n.changeSlide({data: {message: "next"}})
        };
        t.prototype.orientationChange = function () {
            var n = this;
            n.checkResponsive();
            n.setPosition()
        };
        t.prototype.pause = t.prototype.slickPause = function () {
            var n = this;
            n.autoPlayClear();
            n.paused = !0
        };
        t.prototype.play = t.prototype.slickPlay = function () {
            var n = this;
            n.paused = !1;
            n.autoPlay()
        };
        t.prototype.postSlide = function (n) {
            var t = this;
            t.$slider.trigger("afterChange", [t, n]);
            t.animating = !1;
            t.setPosition();
            t.swipeLeft = null;
            t.options.autoplay === !0 && t.paused === !1 && t.autoPlay();
            t.options.accessibility === !0 && t.initADA()
        };
        t.prototype.prev = t.prototype.slickPrev = function () {
            var n = this;
            n.changeSlide({data: {message: "previous"}})
        };
        t.prototype.preventDefault = function (n) {
            n.preventDefault()
        };
        t.prototype.progressiveLazyLoad = function () {
            var t = this, r, i;
            r = n("img[data-lazy]", t.$slider).length;
            r > 0 && (i = n("img[data-lazy]", t.$slider).first(), i.attr("src", i.attr("data-lazy")).removeClass("slick-loading").load(function () {
                i.removeAttr("data-lazy");
                t.progressiveLazyLoad();
                t.options.adaptiveHeight === !0 && t.setPosition()
            }).error(function () {
                i.removeAttr("data-lazy");
                t.progressiveLazyLoad()
            }))
        };
        t.prototype.refresh = function (t) {
            var i = this, r, u;
            u = i.slideCount - i.options.slidesToShow;
            i.options.infinite || (i.slideCount <= i.options.slidesToShow ? i.currentSlide = 0 : i.currentSlide > u && (i.currentSlide = u));
            r = i.currentSlide;
            i.destroy(!0);
            n.extend(i, i.initials, {currentSlide: r});
            i.init();
            t || i.changeSlide({data: {message: "index", index: r}}, !1)
        };
        t.prototype.registerBreakpoints = function () {
            var t = this, u, f, i, r = t.options.responsive || null;
            if (n.type(r) === "array" && r.length) {
                t.respondTo = t.options.respondTo || "window";
                for (u in r)if (i = t.breakpoints.length - 1, f = r[u].breakpoint, r.hasOwnProperty(u)) {
                    while (i >= 0)t.breakpoints[i] && t.breakpoints[i] === f && t.breakpoints.splice(i, 1), i--;
                    t.breakpoints.push(f);
                    t.breakpointSettings[f] = r[u].settings
                }
                t.breakpoints.sort(function (n, i) {
                    return t.options.mobileFirst ? n - i : i - n
                })
            }
        };
        t.prototype.reinit = function () {
            var t = this;
            if (t.$slides = t.$slideTrack.children(t.options.slide).addClass("slick-slide"), t.slideCount = t.$slides.length, t.currentSlide >= t.slideCount && t.currentSlide !== 0 && (t.currentSlide = t.currentSlide - t.options.slidesToScroll), t.slideCount <= t.options.slidesToShow && (t.currentSlide = 0), t.registerBreakpoints(), t.setProps(), t.setupInfinite(), t.buildArrows(), t.updateArrows(), t.initArrowEvents(), t.buildDots(), t.updateDots(), t.initDotEvents(), t.checkResponsive(!1, !0), t.options.focusOnSelect === !0) n(t.$slideTrack).children().on("click.slick", t.selectHandler);
            t.setSlideClasses(0);
            t.setPosition();
            t.$slider.trigger("reInit", [t]);
            t.options.autoplay === !0 && t.focusHandler()
        };
        t.prototype.resize = function () {
            var t = this;
            n(window).width() !== t.windowWidth && (clearTimeout(t.windowDelay), t.windowDelay = window.setTimeout(function () {
                t.windowWidth = n(window).width();
                t.checkResponsive();
                t.unslicked || t.setPosition()
            }, 50))
        };
        t.prototype.removeSlide = t.prototype.slickRemove = function (n, t, i) {
            var r = this;
            if (typeof n == "boolean" ? (t = n, n = t === !0 ? 0 : r.slideCount - 1) : n = t === !0 ? --n : n, r.slideCount < 1 || n < 0 || n > r.slideCount - 1)return !1;
            r.unload();
            i === !0 ? r.$slideTrack.children().remove() : r.$slideTrack.children(this.options.slide).eq(n).remove();
            r.$slides = r.$slideTrack.children(this.options.slide);
            r.$slideTrack.children(this.options.slide).detach();
            r.$slideTrack.append(r.$slides);
            r.$slidesCache = r.$slides;
            r.reinit()
        };
        t.prototype.setCSS = function (n) {
            var t = this, i = {}, r, u;
            t.options.rtl === !0 && (n = -n);
            r = t.positionProp == "left" ? Math.ceil(n) + "px" : "0px";
            u = t.positionProp == "top" ? Math.ceil(n) + "px" : "0px";
            i[t.positionProp] = n;
            t.transformsEnabled === !1 ? t.$slideTrack.css(i) : (i = {}, t.cssTransitions === !1 ? (i[t.animType] = "translate(" + r + ", " + u + ")", t.$slideTrack.css(i)) : (i[t.animType] = "translate3d(" + r + ", " + u + ", 0px)", t.$slideTrack.css(i)))
        };
        t.prototype.setDimensions = function () {
            var n = this, t;
            n.options.vertical === !1 ? n.options.centerMode === !0 && n.$list.css({padding: "0px " + n.options.centerPadding}) : (n.$list.height(n.$slides.first().outerHeight(!0) * n.options.slidesToShow), n.options.centerMode === !0 && n.$list.css({padding: n.options.centerPadding + " 0px"}));
            n.listWidth = n.$list.width();
            n.listHeight = n.$list.height();
            n.options.vertical === !1 && n.options.variableWidth === !1 ? (n.slideWidth = Math.ceil(n.listWidth / n.options.slidesToShow), n.$slideTrack.width(Math.ceil(n.slideWidth * n.$slideTrack.children(".slick-slide").length))) : n.options.variableWidth === !0 ? n.$slideTrack.width(5e3 * n.slideCount) : (n.slideWidth = Math.ceil(n.listWidth), n.$slideTrack.height(Math.ceil(n.$slides.first().outerHeight(!0) * n.$slideTrack.children(".slick-slide").length)));
            t = n.$slides.first().outerWidth(!0) - n.$slides.first().width();
            n.options.variableWidth === !1 && n.$slideTrack.children(".slick-slide").width(n.slideWidth - t)
        };
        t.prototype.setFade = function () {
            var t = this, i;
            t.$slides.each(function (r, u) {
                i = t.slideWidth * r * -1;
                t.options.rtl === !0 ? n(u).css({
                    position: "relative",
                    right: i,
                    top: 0,
                    zIndex: t.options.zIndex - 2,
                    opacity: 0
                }) : n(u).css({position: "relative", left: i, top: 0, zIndex: t.options.zIndex - 2, opacity: 0})
            });
            t.$slides.eq(t.currentSlide).css({zIndex: t.options.zIndex - 1, opacity: 1})
        };
        t.prototype.setHeight = function () {
            var n = this, t;
            n.options.slidesToShow === 1 && n.options.adaptiveHeight === !0 && n.options.vertical === !1 && (t = n.$slides.eq(n.currentSlide).outerHeight(!0), n.$list.css("height", t))
        };
        t.prototype.setOption = t.prototype.slickSetOption = function (t, i, r) {
            var u = this, f, e;
            if (t === "responsive" && n.type(i) === "array")for (e in i)if (n.type(u.options.responsive) !== "array") u.options.responsive = [i[e]]; else {
                for (f = u.options.responsive.length - 1; f >= 0;)u.options.responsive[f].breakpoint === i[e].breakpoint && u.options.responsive.splice(f, 1), f--;
                u.options.responsive.push(i[e])
            } else u.options[t] = i;
            r === !0 && (u.unload(), u.reinit())
        };
        t.prototype.setPosition = function () {
            var n = this;
            n.setDimensions();
            n.setHeight();
            n.options.fade === !1 ? n.setCSS(n.getLeft(n.currentSlide)) : n.setFade();
            n.$slider.trigger("setPosition", [n])
        };
        t.prototype.setProps = function () {
            var n = this, t = document.body.style;
            n.positionProp = n.options.vertical === !0 ? "top" : "left";
            n.positionProp === "top" ? n.$slider.addClass("slick-vertical") : n.$slider.removeClass("slick-vertical");
            (t.WebkitTransition !== undefined || t.MozTransition !== undefined || t.msTransition !== undefined) && n.options.useCSS === !0 && (n.cssTransitions = !0);
            n.options.fade && (typeof n.options.zIndex == "number" ? n.options.zIndex < 3 && (n.options.zIndex = 3) : n.options.zIndex = n.defaults.zIndex);
            t.OTransform !== undefined && (n.animType = "OTransform", n.transformType = "-o-transform", n.transitionType = "OTransition", t.perspectiveProperty === undefined && t.webkitPerspective === undefined && (n.animType = !1));
            t.MozTransform !== undefined && (n.animType = "MozTransform", n.transformType = "-moz-transform", n.transitionType = "MozTransition", t.perspectiveProperty === undefined && t.MozPerspective === undefined && (n.animType = !1));
            t.webkitTransform !== undefined && (n.animType = "webkitTransform", n.transformType = "-webkit-transform", n.transitionType = "webkitTransition", t.perspectiveProperty === undefined && t.webkitPerspective === undefined && (n.animType = !1));
            t.msTransform !== undefined && (n.animType = "msTransform", n.transformType = "-ms-transform", n.transitionType = "msTransition", t.msTransform === undefined && (n.animType = !1));
            t.transform !== undefined && n.animType !== !1 && (n.animType = "transform", n.transformType = "transform", n.transitionType = "transition");
            n.transformsEnabled = n.animType !== null && n.animType !== !1
        };
        t.prototype.setSlideClasses = function (n) {
            var t = this, u, i, r, f;
            i = t.$slider.find(".slick-slide").removeClass("slick-active slick-center slick-current").attr("aria-hidden", "true");
            t.$slides.eq(n).addClass("slick-current");
            t.options.centerMode === !0 ? (u = Math.floor(t.options.slidesToShow / 2), t.options.infinite === !0 && (n >= u && n <= t.slideCount - 1 - u ? t.$slides.slice(n - u, n + u + 1).addClass("slick-active").attr("aria-hidden", "false") : (r = t.options.slidesToShow + n, i.slice(r - u + 1, r + u + 2).addClass("slick-active").attr("aria-hidden", "false")), n === 0 ? i.eq(i.length - 1 - t.options.slidesToShow).addClass("slick-center") : n === t.slideCount - 1 && i.eq(t.options.slidesToShow).addClass("slick-center")), t.$slides.eq(n).addClass("slick-center")) : n >= 0 && n <= t.slideCount - t.options.slidesToShow ? t.$slides.slice(n, n + t.options.slidesToShow).addClass("slick-active").attr("aria-hidden", "false") : i.length <= t.options.slidesToShow ? i.addClass("slick-active").attr("aria-hidden", "false") : (f = t.slideCount % t.options.slidesToShow, r = t.options.infinite === !0 ? t.options.slidesToShow + n : n, t.options.slidesToShow == t.options.slidesToScroll && t.slideCount - n < t.options.slidesToShow ? i.slice(r - (t.options.slidesToShow - f), r + f).addClass("slick-active").attr("aria-hidden", "false") : i.slice(r, r + t.options.slidesToShow).addClass("slick-active").attr("aria-hidden", "false"));
            t.options.lazyLoad === "ondemand" && t.lazyLoad()
        };
        t.prototype.setupInfinite = function () {
            var t = this, i, r, u;
            if (t.options.fade === !0 && (t.options.centerMode = !1), t.options.infinite === !0 && t.options.fade === !1 && (r = null, t.slideCount > t.options.slidesToShow)) {
                for (u = t.options.centerMode === !0 ? t.options.slidesToShow + 1 : t.options.slidesToShow, i = t.slideCount; i > t.slideCount - u; i -= 1)r = i - 1, n(t.$slides[r]).clone(!0).attr("id", "").attr("data-slick-index", r - t.slideCount).prependTo(t.$slideTrack).addClass("slick-cloned");
                for (i = 0; i < u; i += 1)r = i, n(t.$slides[r]).clone(!0).attr("id", "").attr("data-slick-index", r + t.slideCount).appendTo(t.$slideTrack).addClass("slick-cloned");
                t.$slideTrack.find(".slick-cloned").find("[id]").each(function () {
                    n(this).attr("id", "")
                })
            }
        };
        t.prototype.setPaused = function (n) {
            var t = this;
            t.options.autoplay === !0 && t.options.pauseOnHover === !0 && (t.paused = n, n ? t.autoPlayClear() : t.autoPlay())
        };
        t.prototype.selectHandler = function (t) {
            var i = this, u = n(t.target).is(".slick-slide") ? n(t.target) : n(t.target).parents(".slick-slide"),
                r = parseInt(u.attr("data-slick-index"));
            if (r || (r = 0), i.slideCount <= i.options.slidesToShow) {
                i.setSlideClasses(r);
                i.asNavFor(r);
                return
            }
            i.slideHandler(r)
        };
        t.prototype.slideHandler = function (n, t, i) {
            var u, f, o, e, s = null, r = this;
            if ((t = t || !1, r.animating !== !0 || r.options.waitForAnimate !== !0) && (r.options.fade !== !0 || r.currentSlide !== n) && !(r.slideCount <= r.options.slidesToShow)) {
                if (t === !1 && r.asNavFor(n), u = n, s = r.getLeft(u), e = r.getLeft(r.currentSlide), r.currentLeft = r.swipeLeft === null ? e : r.swipeLeft, r.options.infinite === !1 && r.options.centerMode === !1 && (n < 0 || n > r.getDotCount() * r.options.slidesToScroll)) {
                    r.options.fade === !1 && (u = r.currentSlide, i !== !0 ? r.animateSlide(e, function () {
                        r.postSlide(u)
                    }) : r.postSlide(u));
                    return
                }
                if (r.options.infinite === !1 && r.options.centerMode === !0 && (n < 0 || n > r.slideCount - r.options.slidesToScroll)) {
                    r.options.fade === !1 && (u = r.currentSlide, i !== !0 ? r.animateSlide(e, function () {
                        r.postSlide(u)
                    }) : r.postSlide(u));
                    return
                }
                if (r.options.autoplay === !0 && clearInterval(r.autoPlayTimer), f = u < 0 ? r.slideCount % r.options.slidesToScroll != 0 ? r.slideCount - r.slideCount % r.options.slidesToScroll : r.slideCount + u : u >= r.slideCount ? r.slideCount % r.options.slidesToScroll != 0 ? 0 : u - r.slideCount : u, r.animating = !0, r.$slider.trigger("beforeChange", [r, r.currentSlide, f]), o = r.currentSlide, r.currentSlide = f, r.setSlideClasses(r.currentSlide), r.updateDots(), r.updateArrows(), r.options.fade === !0) {
                    i !== !0 ? (r.fadeSlideOut(o), r.fadeSlide(f, function () {
                        r.postSlide(f)
                    })) : r.postSlide(f);
                    r.animateHeight();
                    return
                }
                i !== !0 ? r.animateSlide(s, function () {
                    r.postSlide(f)
                }) : r.postSlide(f)
            }
        };
        t.prototype.startLoad = function () {
            var n = this;
            n.options.arrows === !0 && n.slideCount > n.options.slidesToShow && (n.$prevArrow.hide(), n.$nextArrow.hide());
            n.options.dots === !0 && n.slideCount > n.options.slidesToShow && n.$dots.hide();
            n.$slider.addClass("slick-loading")
        };
        t.prototype.swipeDirection = function () {
            var i, r, u, n, t = this;
            return (i = t.touchObject.startX - t.touchObject.curX, r = t.touchObject.startY - t.touchObject.curY, u = Math.atan2(r, i), n = Math.round(u * 180 / Math.PI), n < 0 && (n = 360 - Math.abs(n)), n <= 45 && n >= 0) ? t.options.rtl === !1 ? "left" : "right" : n <= 360 && n >= 315 ? t.options.rtl === !1 ? "left" : "right" : n >= 135 && n <= 225 ? t.options.rtl === !1 ? "right" : "left" : t.options.verticalSwiping === !0 ? n >= 35 && n <= 135 ? "left" : "right" : "vertical"
        };
        t.prototype.swipeEnd = function () {
            var n = this, t;
            if (n.dragging = !1, n.shouldClick = n.touchObject.swipeLength > 10 ? !1 : !0, n.touchObject.curX === undefined)return !1;
            if (n.touchObject.edgeHit === !0 && n.$slider.trigger("edge", [n, n.swipeDirection()]), n.touchObject.swipeLength >= n.touchObject.minSwipe)switch (n.swipeDirection()) {
                case"left":
                    t = n.options.swipeToSlide ? n.checkNavigable(n.currentSlide + n.getSlideCount()) : n.currentSlide + n.getSlideCount();
                    n.slideHandler(t);
                    n.currentDirection = 0;
                    n.touchObject = {};
                    n.$slider.trigger("swipe", [n, "left"]);
                    break;
                case"right":
                    t = n.options.swipeToSlide ? n.checkNavigable(n.currentSlide - n.getSlideCount()) : n.currentSlide - n.getSlideCount();
                    n.slideHandler(t);
                    n.currentDirection = 1;
                    n.touchObject = {};
                    n.$slider.trigger("swipe", [n, "right"])
            } else n.touchObject.startX !== n.touchObject.curX && (n.slideHandler(n.currentSlide), n.touchObject = {})
        };
        t.prototype.swipeHandler = function (n) {
            var t = this;
            if (t.options.swipe !== !1 && (!("ontouchend" in document) || t.options.swipe !== !1) && (t.options.draggable !== !1 || n.type.indexOf("mouse") === -1)) {
                t.touchObject.fingerCount = n.originalEvent && n.originalEvent.touches !== undefined ? n.originalEvent.touches.length : 1;
                t.touchObject.minSwipe = t.listWidth / t.options.touchThreshold;
                t.options.verticalSwiping === !0 && (t.touchObject.minSwipe = t.listHeight / t.options.touchThreshold);
                switch (n.data.action) {
                    case"start":
                        t.swipeStart(n);
                        break;
                    case"move":
                        t.swipeMove(n);
                        break;
                    case"end":
                        t.swipeEnd(n)
                }
            }
        };
        t.prototype.swipeMove = function (n) {
            var t = this, f, e, r, u, i;
            if (i = n.originalEvent !== undefined ? n.originalEvent.touches : null, !t.dragging || i && i.length !== 1)return !1;
            if (f = t.getLeft(t.currentSlide), t.touchObject.curX = i !== undefined ? i[0].pageX : n.clientX, t.touchObject.curY = i !== undefined ? i[0].pageY : n.clientY, t.touchObject.swipeLength = Math.round(Math.sqrt(Math.pow(t.touchObject.curX - t.touchObject.startX, 2))), t.options.verticalSwiping === !0 && (t.touchObject.swipeLength = Math.round(Math.sqrt(Math.pow(t.touchObject.curY - t.touchObject.startY, 2)))), e = t.swipeDirection(), e !== "vertical") {
                if (n.originalEvent !== undefined && t.touchObject.swipeLength > 4 && n.preventDefault(), u = (t.options.rtl === !1 ? 1 : -1) * (t.touchObject.curX > t.touchObject.startX ? 1 : -1), t.options.verticalSwiping === !0 && (u = t.touchObject.curY > t.touchObject.startY ? 1 : -1), r = t.touchObject.swipeLength, t.touchObject.edgeHit = !1, t.options.infinite === !1 && (t.currentSlide === 0 && e === "right" || t.currentSlide >= t.getDotCount() && e === "left") && (r = t.touchObject.swipeLength * t.options.edgeFriction, t.touchObject.edgeHit = !0), t.swipeLeft = t.options.vertical === !1 ? f + r * u : f + r * (t.$list.height() / t.listWidth) * u, t.options.verticalSwiping === !0 && (t.swipeLeft = f + r * u), t.options.fade === !0 || t.options.touchMove === !1)return !1;
                if (t.animating === !0)return t.swipeLeft = null, !1;
                t.setCSS(t.swipeLeft)
            }
        };
        t.prototype.swipeStart = function (n) {
            var t = this, i;
            if (t.touchObject.fingerCount !== 1 || t.slideCount <= t.options.slidesToShow)return t.touchObject = {}, !1;
            n.originalEvent !== undefined && n.originalEvent.touches !== undefined && (i = n.originalEvent.touches[0]);
            t.touchObject.startX = t.touchObject.curX = i !== undefined ? i.pageX : n.clientX;
            t.touchObject.startY = t.touchObject.curY = i !== undefined ? i.pageY : n.clientY;
            t.dragging = !0
        };
        t.prototype.unfilterSlides = t.prototype.slickUnfilter = function () {
            var n = this;
            n.$slidesCache !== null && (n.unload(), n.$slideTrack.children(this.options.slide).detach(), n.$slidesCache.appendTo(n.$slideTrack), n.reinit())
        };
        t.prototype.unload = function () {
            var t = this;
            n(".slick-cloned", t.$slider).remove();
            t.$dots && t.$dots.remove();
            t.$prevArrow && t.htmlExpr.test(t.options.prevArrow) && t.$prevArrow.remove();
            t.$nextArrow && t.htmlExpr.test(t.options.nextArrow) && t.$nextArrow.remove();
            t.$slides.removeClass("slick-slide slick-active slick-visible slick-current").attr("aria-hidden", "true").css("width", "")
        };
        t.prototype.unslick = function (n) {
            var t = this;
            t.$slider.trigger("unslick", [t, n]);
            t.destroy()
        };
        t.prototype.updateArrows = function () {
            var n = this, t;
            t = Math.floor(n.options.slidesToShow / 2);
            n.options.arrows === !0 && n.slideCount > n.options.slidesToShow && !n.options.infinite && (n.$prevArrow.removeClass("slick-disabled").attr("aria-disabled", "false"), n.$nextArrow.removeClass("slick-disabled").attr("aria-disabled", "false"), n.currentSlide === 0 ? (n.$prevArrow.addClass("slick-disabled").attr("aria-disabled", "true"), n.$nextArrow.removeClass("slick-disabled").attr("aria-disabled", "false")) : n.currentSlide >= n.slideCount - n.options.slidesToShow && n.options.centerMode === !1 ? (n.$nextArrow.addClass("slick-disabled").attr("aria-disabled", "true"), n.$prevArrow.removeClass("slick-disabled").attr("aria-disabled", "false")) : n.currentSlide >= n.slideCount - 1 && n.options.centerMode === !0 && (n.$nextArrow.addClass("slick-disabled").attr("aria-disabled", "true"), n.$prevArrow.removeClass("slick-disabled").attr("aria-disabled", "false")))
        };
        t.prototype.updateDots = function () {
            var n = this;
            n.$dots !== null && (n.$dots.find("li").removeClass("slick-active").attr("aria-hidden", "true"), n.$dots.find("li").eq(Math.floor(n.currentSlide / n.options.slidesToScroll)).addClass("slick-active").attr("aria-hidden", "false"))
        };
        t.prototype.visibility = function () {
            var n = this;
            document[n.hidden] ? (n.paused = !0, n.autoPlayClear()) : n.options.autoplay === !0 && (n.paused = !1, n.autoPlay())
        };
        t.prototype.initADA = function () {
            var t = this;
            t.$slides.add(t.$slideTrack.find(".slick-cloned")).attr({
                "aria-hidden": "true",
                tabindex: "-1"
            }).find("a, input, button, select").attr({tabindex: "-1"});
            t.$slideTrack.attr("role", "listbox");
            t.$slides.not(t.$slideTrack.find(".slick-cloned")).each(function (i) {
                n(this).attr({role: "option", "aria-describedby": "slick-slide" + t.instanceUid + i + ""})
            });
            t.$dots !== null && t.$dots.attr("role", "tablist").find("li").each(function (i) {
                n(this).attr({
                    role: "presentation",
                    "aria-selected": "false",
                    "aria-controls": "navigation" + t.instanceUid + i + "",
                    id: "slick-slide" + t.instanceUid + i + ""
                })
            }).first().attr("aria-selected", "true").end().find("button").attr("role", "button").end().closest("div").attr("role", "toolbar");
            t.activateADA()
        };
        t.prototype.activateADA = function () {
            var n = this, t = n.$slider.find("*").is(":focus");
            n.$slideTrack.find(".slick-active").attr({
                "aria-hidden": "false",
                tabindex: "0"
            }).find("a, input, button, select").attr({tabindex: "0"});
            t && n.$slideTrack.find(".slick-active").focus()
        };
        t.prototype.focusHandler = function () {
            var t = this;
            t.$slider.on("focus.slick blur.slick", "*", function (i) {
                i.stopImmediatePropagation();
                var r = n(this);
                setTimeout(function () {
                    t.isPlay && (r.is(":focus") ? (t.autoPlayClear(), t.paused = !0) : (t.paused = !1, t.autoPlay()))
                }, 0)
            })
        };
        n.fn.slick = function () {
            var i = this, r = arguments[0], f = Array.prototype.slice.call(arguments, 1), e = i.length, n = 0, u;
            for (n; n < e; n++)if (typeof r == "object" || typeof r == "undefined" ? i[n].slick = new t(i[n], r) : u = i[n].slick[r].apply(i[n].slick, f), typeof u != "undefined")return u;
            return i
        }
    }), function (n) {
        n.fn.unveil = function (t, i) {
            function o() {
                var t = u.filter(function () {
                    var t = n(this);
                    if (!t.is(":hidden")) {
                        var i = r.scrollTop(), e = i + r.height(), u = t.offset().top, o = u + t.height();
                        return o >= i - f && u <= e + f
                    }
                });
                e = t.trigger("unveil");
                u = u.not(e)
            }

            var r = n(window), f = t || 0, s = window.devicePixelRatio > 1, h = s ? "data-src-retina" : "data-src",
                u = this, e;
            this.one("unveil", function () {
                var n = this.getAttribute(h);
                n = n || this.getAttribute("data-src");
                n && (this.setAttribute("src", n), typeof i == "function" && i.call(this))
            });
            r.on("scroll.unveil resize.unveil lookup.unveil", o);
            return o(), this
        }
    }(window.jQuery || window.Zepto);
    !function (n) {
        "function" == typeof define && define.amd ? define(["jquery"], n) : n(jQuery)
    }(function (n) {
        n.extend(n.fn, {
            validate: function (t) {
                if (!this.length)return void(t && t.debug && window.console && console.warn("Nothing selected, can't validate, returning nothing."));
                var i = n.data(this[0], "validator");
                return i ? i : (this.attr("novalidate", "novalidate"), i = new n.validator(t, this[0]), n.data(this[0], "validator", i), i.settings.onsubmit && (this.validateDelegate(":submit", "click", function (t) {
                    i.settings.submitHandler && (i.submitButton = t.target);
                    n(t.target).hasClass("cancel") && (i.cancelSubmit = !0);
                    void 0 !== n(t.target).attr("formnovalidate") && (i.cancelSubmit = !0)
                }), this.submit(function (t) {
                    function r() {
                        var u, r;
                        return i.settings.submitHandler ? (i.submitButton && (u = n("<input type='hidden'/>").attr("name", i.submitButton.name).val(n(i.submitButton).val()).appendTo(i.currentForm)), r = i.settings.submitHandler.call(i, i.currentForm, t), i.submitButton && u.remove(), void 0 !== r ? r : !1) : !0
                    }

                    return i.settings.debug && t.preventDefault(), i.cancelSubmit ? (i.cancelSubmit = !1, r()) : i.form() ? i.pendingRequest ? (i.formSubmitted = !0, !1) : r() : (i.focusInvalid(), !1)
                })), i)
            }, valid: function () {
                var t, i;
                return n(this[0]).is("form") ? t = this.validate().form() : (t = !0, i = n(this[0].form).validate(), this.each(function () {
                    t = i.element(this) && t
                })), t
            }, removeAttrs: function (t) {
                var i = {}, r = this;
                return n.each(t.split(/\s/), function (n, t) {
                    i[t] = r.attr(t);
                    r.removeAttr(t)
                }), i
            }, rules: function (t, i) {
                var e, s, f, u, o, h, r = this[0];
                if (t)switch (e = n.data(r.form, "validator").settings, s = e.rules, f = n.validator.staticRules(r), t) {
                    case"add":
                        n.extend(f, n.validator.normalizeRule(i));
                        delete f.messages;
                        s[r.name] = f;
                        i.messages && (e.messages[r.name] = n.extend(e.messages[r.name], i.messages));
                        break;
                    case"remove":
                        return i ? (h = {}, n.each(i.split(/\s/), function (t, i) {
                            h[i] = f[i];
                            delete f[i];
                            "required" === i && n(r).removeAttr("aria-required")
                        }), h) : (delete s[r.name], f)
                }
                return u = n.validator.normalizeRules(n.extend({}, n.validator.classRules(r), n.validator.attributeRules(r), n.validator.dataRules(r), n.validator.staticRules(r)), r), u.required && (o = u.required, delete u.required, u = n.extend({required: o}, u), n(r).attr("aria-required", "true")), u.remote && (o = u.remote, delete u.remote, u = n.extend(u, {remote: o})), u
            }
        });
        n.extend(n.expr[":"], {
            blank: function (t) {
                return !n.trim("" + n(t).val())
            }, filled: function (t) {
                return !!n.trim("" + n(t).val())
            }, unchecked: function (t) {
                return !n(t).prop("checked")
            }
        });
        n.validator = function (t, i) {
            this.settings = n.extend(!0, {}, n.validator.defaults, t);
            this.currentForm = i;
            this.init()
        };
        n.validator.format = function (t, i) {
            return 1 === arguments.length ? function () {
                var i = n.makeArray(arguments);
                return i.unshift(t), n.validator.format.apply(this, i)
            } : (arguments.length > 2 && i.constructor !== Array && (i = n.makeArray(arguments).slice(1)), i.constructor !== Array && (i = [i]), n.each(i, function (n, i) {
                t = t.replace(new RegExp("\\{" + n + "\\}", "g"), function () {
                    return i
                })
            }), t)
        };
        n.extend(n.validator, {
            defaults: {
                messages: {},
                groups: {},
                rules: {},
                errorClass: "error",
                validClass: "valid",
                errorElement: "label",
                focusCleanup: !1,
                focusInvalid: !0,
                errorContainer: n([]),
                errorLabelContainer: n([]),
                onsubmit: !0,
                ignore: ":hidden",
                ignoreTitle: !1,
                onfocusin: function (n) {
                    this.lastActive = n;
                    this.settings.focusCleanup && (this.settings.unhighlight && this.settings.unhighlight.call(this, n, this.settings.errorClass, this.settings.validClass), this.hideThese(this.errorsFor(n)))
                },
                onfocusout: function (n) {
                    !this.checkable(n) && (n.name in this.submitted || !this.optional(n)) && this.element(n)
                },
                onkeyup: function (n, t) {
                    (9 !== t.which || "" !== this.elementValue(n)) && (n.name in this.submitted || n === this.lastElement) && this.element(n)
                },
                onclick: function (n) {
                    n.name in this.submitted ? this.element(n) : n.parentNode.name in this.submitted && this.element(n.parentNode)
                },
                highlight: function (t, i, r) {
                    "radio" === t.type ? this.findByName(t.name).addClass(i).removeClass(r) : n(t).addClass(i).removeClass(r)
                },
                unhighlight: function (t, i, r) {
                    "radio" === t.type ? this.findByName(t.name).removeClass(i).addClass(r) : n(t).removeClass(i).addClass(r)
                }
            },
            setDefaults: function (t) {
                n.extend(n.validator.defaults, t)
            },
            messages: {
                required: "This field is required.",
                remote: "Please fix this field.",
                email: "Please enter a valid email address.",
                url: "Please enter a valid URL.",
                date: "Please enter a valid date.",
                dateISO: "Please enter a valid date ( ISO ).",
                number: "Please enter a valid number.",
                digits: "Please enter only digits.",
                creditcard: "Please enter a valid credit card number.",
                equalTo: "Please enter the same value again.",
                maxlength: n.validator.format("Please enter no more than {0} characters."),
                minlength: n.validator.format("Please enter at least {0} characters."),
                rangelength: n.validator.format("Please enter a value between {0} and {1} characters long."),
                range: n.validator.format("Please enter a value between {0} and {1}."),
                max: n.validator.format("Please enter a value less than or equal to {0}."),
                min: n.validator.format("Please enter a value greater than or equal to {0}.")
            },
            autoCreateRanges: !1,
            prototype: {
                init: function () {
                    function i(t) {
                        var r = n.data(this[0].form, "validator"), u = "on" + t.type.replace(/^validate/, ""),
                            i = r.settings;
                        i[u] && !this.is(i.ignore) && i[u].call(r, this[0], t)
                    }

                    this.labelContainer = n(this.settings.errorLabelContainer);
                    this.errorContext = this.labelContainer.length && this.labelContainer || n(this.currentForm);
                    this.containers = n(this.settings.errorContainer).add(this.settings.errorLabelContainer);
                    this.submitted = {};
                    this.valueCache = {};
                    this.pendingRequest = 0;
                    this.pending = {};
                    this.invalid = {};
                    this.reset();
                    var t, r = this.groups = {};
                    n.each(this.settings.groups, function (t, i) {
                        "string" == typeof i && (i = i.split(/\s/));
                        n.each(i, function (n, i) {
                            r[i] = t
                        })
                    });
                    t = this.settings.rules;
                    n.each(t, function (i, r) {
                        t[i] = n.validator.normalizeRule(r)
                    });
                    n(this.currentForm).validateDelegate(":text, [type='password'], [type='file'], select, textarea, [type='number'], [type='search'] ,[type='tel'], [type='url'], [type='email'], [type='datetime'], [type='date'], [type='month'], [type='week'], [type='time'], [type='datetime-local'], [type='range'], [type='color'], [type='radio'], [type='checkbox']", "focusin focusout keyup", i).validateDelegate("select, option, [type='radio'], [type='checkbox']", "click", i);
                    this.settings.invalidHandler && n(this.currentForm).bind("invalid-form.validate", this.settings.invalidHandler);
                    n(this.currentForm).find("[required], [data-rule-required], .required").attr("aria-required", "true")
                }, form: function () {
                    return this.checkForm(), n.extend(this.submitted, this.errorMap), this.invalid = n.extend({}, this.errorMap), this.valid() || n(this.currentForm).triggerHandler("invalid-form", [this]), this.showErrors(), this.valid()
                }, checkForm: function () {
                    this.prepareForm();
                    for (var n = 0, t = this.currentElements = this.elements(); t[n]; n++)this.check(t[n]);
                    return this.valid()
                }, element: function (t) {
                    var u = this.clean(t), i = this.validationTargetFor(u), r = !0;
                    return this.lastElement = i, void 0 === i ? delete this.invalid[u.name] : (this.prepareElement(i), this.currentElements = n(i), r = this.check(i) !== !1, r ? delete this.invalid[i.name] : this.invalid[i.name] = !0), n(t).attr("aria-invalid", !r), this.numberOfInvalids() || (this.toHide = this.toHide.add(this.containers)), this.showErrors(), r
                }, showErrors: function (t) {
                    if (t) {
                        n.extend(this.errorMap, t);
                        this.errorList = [];
                        for (var i in t)this.errorList.push({message: t[i], element: this.findByName(i)[0]});
                        this.successList = n.grep(this.successList, function (n) {
                            return !(n.name in t)
                        })
                    }
                    this.settings.showErrors ? this.settings.showErrors.call(this, this.errorMap, this.errorList) : this.defaultShowErrors()
                }, resetForm: function () {
                    n.fn.resetForm && n(this.currentForm).resetForm();
                    this.submitted = {};
                    this.lastElement = null;
                    this.prepareForm();
                    this.hideErrors();
                    this.elements().removeClass(this.settings.errorClass).removeData("previousValue").removeAttr("aria-invalid")
                }, numberOfInvalids: function () {
                    return this.objectLength(this.invalid)
                }, objectLength: function (n) {
                    var i, t = 0;
                    for (i in n)t++;
                    return t
                }, hideErrors: function () {
                    this.hideThese(this.toHide)
                }, hideThese: function (n) {
                    n.not(this.containers).text("");
                    this.addWrapper(n).hide()
                }, valid: function () {
                    return 0 === this.size()
                }, size: function () {
                    return this.errorList.length
                }, focusInvalid: function () {
                    if (this.settings.focusInvalid)try {
                        n(this.findLastActive() || this.errorList.length && this.errorList[0].element || []).filter(":visible").focus().trigger("focusin")
                    } catch (n) {
                    }
                }, findLastActive: function () {
                    var t = this.lastActive;
                    return t && 1 === n.grep(this.errorList, function (n) {
                            return n.element.name === t.name
                        }).length && t
                }, elements: function () {
                    var t = this, i = {};
                    return n(this.currentForm).find("input, select, textarea").not(":submit, :reset, :image, [disabled], [readonly]").not(this.settings.ignore).filter(function () {
                        return !this.name && t.settings.debug && window.console && console.error("%o has no name assigned", this), this.name in i || !t.objectLength(n(this).rules()) ? !1 : (i[this.name] = !0, !0)
                    })
                }, clean: function (t) {
                    return n(t)[0]
                }, errors: function () {
                    var t = this.settings.errorClass.split(" ").join(".");
                    return n(this.settings.errorElement + "." + t, this.errorContext)
                }, reset: function () {
                    this.successList = [];
                    this.errorList = [];
                    this.errorMap = {};
                    this.toShow = n([]);
                    this.toHide = n([]);
                    this.currentElements = n([])
                }, prepareForm: function () {
                    this.reset();
                    this.toHide = this.errors().add(this.containers)
                }, prepareElement: function (n) {
                    this.reset();
                    this.toHide = this.errorsFor(n)
                }, elementValue: function (t) {
                    var i, u = n(t), r = t.type;
                    return "radio" === r || "checkbox" === r ? n("input[name='" + t.name + "']:checked").val() : "number" === r && "undefined" != typeof t.validity ? t.validity.badInput ? !1 : u.val() : (i = u.val(), "string" == typeof i ? i.replace(/\r/g, "") : i)
                }, check: function (t) {
                    t = this.validationTargetFor(this.clean(t));
                    var i, r, u, f = n(t).rules(), o = n.map(f, function (n, t) {
                        return t
                    }).length, e = !1, s = this.elementValue(t);
                    for (r in f) {
                        u = {method: r, parameters: f[r]};
                        try {
                            if (i = n.validator.methods[r].call(this, s, t, u.parameters), "dependency-mismatch" === i && 1 === o) {
                                e = !0;
                                continue
                            }
                            if (e = !1, "pending" === i)return void(this.toHide = this.toHide.not(this.errorsFor(t)));
                            if (!i)return this.formatAndAdd(t, u), !1
                        } catch (n) {
                            throw this.settings.debug && window.console && console.log("Exception occurred when checking element " + t.id + ", check the '" + u.method + "' method.", n), n;
                        }
                    }
                    if (!e)return this.objectLength(f) && this.successList.push(t), !0
                }, customDataMessage: function (t, i) {
                    return n(t).data("msg" + i.charAt(0).toUpperCase() + i.substring(1).toLowerCase()) || n(t).data("msg")
                }, customMessage: function (n, t) {
                    var i = this.settings.messages[n];
                    return i && (i.constructor === String ? i : i[t])
                }, findDefined: function () {
                    for (var n = 0; n < arguments.length; n++)if (void 0 !== arguments[n])return arguments[n];
                    return void 0
                }, defaultMessage: function (t, i) {
                    return this.findDefined(this.customMessage(t.name, i), this.customDataMessage(t, i), !this.settings.ignoreTitle && t.title || void 0, n.validator.messages[i], "<strong>Warning: No message defined for " + t.name + "<\/strong>")
                }, formatAndAdd: function (t, i) {
                    var r = this.defaultMessage(t, i.method), u = /\$?\{(\d+)\}/g;
                    "function" == typeof r ? r = r.call(this, i.parameters, t) : u.test(r) && (r = n.validator.format(r.replace(u, "{$1}"), i.parameters));
                    this.errorList.push({message: r, element: t, method: i.method});
                    this.errorMap[t.name] = r;
                    this.submitted[t.name] = r
                }, addWrapper: function (n) {
                    return this.settings.wrapper && (n = n.add(n.parent(this.settings.wrapper))), n
                }, defaultShowErrors: function () {
                    for (var i, t, n = 0; this.errorList[n]; n++)t = this.errorList[n], this.settings.highlight && this.settings.highlight.call(this, t.element, this.settings.errorClass, this.settings.validClass), this.showLabel(t.element, t.message);
                    if (this.errorList.length && (this.toShow = this.toShow.add(this.containers)), this.settings.success)for (n = 0; this.successList[n]; n++)this.showLabel(this.successList[n]);
                    if (this.settings.unhighlight)for (n = 0, i = this.validElements(); i[n]; n++)this.settings.unhighlight.call(this, i[n], this.settings.errorClass, this.settings.validClass);
                    this.toHide = this.toHide.not(this.toShow);
                    this.hideErrors();
                    this.addWrapper(this.toShow).show()
                }, validElements: function () {
                    return this.currentElements.not(this.invalidElements())
                }, invalidElements: function () {
                    return n(this.errorList).map(function () {
                        return this.element
                    })
                }, showLabel: function (t, i) {
                    var u, o, e, r = this.errorsFor(t), s = this.idOrName(t), f = n(t).attr("aria-describedby");
                    r.length ? (r.removeClass(this.settings.validClass).addClass(this.settings.errorClass), r.html(i)) : (r = n("<" + this.settings.errorElement + ">").attr("id", s + "-error").addClass(this.settings.errorClass).html(i || ""), u = r, this.settings.wrapper && (u = r.hide().show().wrap("<" + this.settings.wrapper + "/>").parent()), this.labelContainer.length ? this.labelContainer.append(u) : this.settings.errorPlacement ? this.settings.errorPlacement(u, n(t)) : u.insertAfter(t), r.is("label") ? r.attr("for", s) : 0 === r.parents("label[for='" + s + "']").length && (e = r.attr("id").replace(/(:|\.|\[|\])/g, "\\$1"), f ? f.match(new RegExp("\\b" + e + "\\b")) || (f += " " + e) : f = e, n(t).attr("aria-describedby", f), o = this.groups[t.name], o && n.each(this.groups, function (t, i) {
                            i === o && n("[name='" + t + "']", this.currentForm).attr("aria-describedby", r.attr("id"))
                        })));
                    !i && this.settings.success && (r.text(""), "string" == typeof this.settings.success ? r.addClass(this.settings.success) : this.settings.success(r, t));
                    this.toShow = this.toShow.add(r)
                }, errorsFor: function (t) {
                    var r = this.idOrName(t), u = n(t).attr("aria-describedby"),
                        i = "label[for='" + r + "'], label[for='" + r + "'] *";
                    return u && (i = i + ", #" + u.replace(/\s+/g, ", #")), this.errors().filter(i)
                }, idOrName: function (n) {
                    return this.groups[n.name] || (this.checkable(n) ? n.name : n.id || n.name)
                }, validationTargetFor: function (t) {
                    return this.checkable(t) && (t = this.findByName(t.name)), n(t).not(this.settings.ignore)[0]
                }, checkable: function (n) {
                    return /radio|checkbox/i.test(n.type)
                }, findByName: function (t) {
                    return n(this.currentForm).find("[name='" + t + "']")
                }, getLength: function (t, i) {
                    switch (i.nodeName.toLowerCase()) {
                        case"select":
                            return n("option:selected", i).length;
                        case"input":
                            if (this.checkable(i))return this.findByName(i.name).filter(":checked").length
                    }
                    return t.length
                }, depend: function (n, t) {
                    return this.dependTypes[typeof n] ? this.dependTypes[typeof n](n, t) : !0
                }, dependTypes: {
                    boolean: function (n) {
                        return n
                    }, string: function (t, i) {
                        return !!n(t, i.form).length
                    }, "function": function (n, t) {
                        return n(t)
                    }
                }, optional: function (t) {
                    var i = this.elementValue(t);
                    return !n.validator.methods.required.call(this, i, t) && "dependency-mismatch"
                }, startRequest: function (n) {
                    this.pending[n.name] || (this.pendingRequest++, this.pending[n.name] = !0)
                }, stopRequest: function (t, i) {
                    this.pendingRequest--;
                    this.pendingRequest < 0 && (this.pendingRequest = 0);
                    delete this.pending[t.name];
                    i && 0 === this.pendingRequest && this.formSubmitted && this.form() ? (n(this.currentForm).submit(), this.formSubmitted = !1) : !i && 0 === this.pendingRequest && this.formSubmitted && (n(this.currentForm).triggerHandler("invalid-form", [this]), this.formSubmitted = !1)
                }, previousValue: function (t) {
                    return n.data(t, "previousValue") || n.data(t, "previousValue", {
                            old: null,
                            valid: !0,
                            message: this.defaultMessage(t, "remote")
                        })
                }
            },
            classRuleSettings: {
                required: {required: !0},
                email: {email: !0},
                url: {url: !0},
                date: {date: !0},
                dateISO: {dateISO: !0},
                number: {number: !0},
                digits: {digits: !0},
                creditcard: {creditcard: !0}
            },
            addClassRules: function (t, i) {
                t.constructor === String ? this.classRuleSettings[t] = i : n.extend(this.classRuleSettings, t)
            },
            classRules: function (t) {
                var i = {}, r = n(t).attr("class");
                return r && n.each(r.split(" "), function () {
                    this in n.validator.classRuleSettings && n.extend(i, n.validator.classRuleSettings[this])
                }), i
            },
            attributeRules: function (t) {
                var r, i, u = {}, e = n(t), f = t.getAttribute("type");
                for (r in n.validator.methods)"required" === r ? (i = t.getAttribute(r), "" === i && (i = !0), i = !!i) : i = e.attr(r), /min|max/.test(r) && (null === f || /number|range|text/.test(f)) && (i = Number(i)), i || 0 === i ? u[r] = i : f === r && "range" !== f && (u[r] = !0);
                return u.maxlength && /-1|2147483647|524288/.test(u.maxlength) && delete u.maxlength, u
            },
            dataRules: function (t) {
                var i, r, u = {}, f = n(t);
                for (i in n.validator.methods)r = f.data("rule" + i.charAt(0).toUpperCase() + i.substring(1).toLowerCase()), void 0 !== r && (u[i] = r);
                return u
            },
            staticRules: function (t) {
                var i = {}, r = n.data(t.form, "validator");
                return r.settings.rules && (i = n.validator.normalizeRule(r.settings.rules[t.name]) || {}), i
            },
            normalizeRules: function (t, i) {
                return n.each(t, function (r, u) {
                    if (u === !1)return void delete t[r];
                    if (u.param || u.depends) {
                        var f = !0;
                        switch (typeof u.depends) {
                            case"string":
                                f = !!n(u.depends, i.form).length;
                                break;
                            case"function":
                                f = u.depends.call(i, i)
                        }
                        f ? t[r] = void 0 !== u.param ? u.param : !0 : delete t[r]
                    }
                }), n.each(t, function (r, u) {
                    t[r] = n.isFunction(u) ? u(i) : u
                }), n.each(["minlength", "maxlength"], function () {
                    t[this] && (t[this] = Number(t[this]))
                }), n.each(["rangelength", "range"], function () {
                    var i;
                    t[this] && (n.isArray(t[this]) ? t[this] = [Number(t[this][0]), Number(t[this][1])] : "string" == typeof t[this] && (i = t[this].replace(/[\[\]]/g, "").split(/[\s,]+/), t[this] = [Number(i[0]), Number(i[1])]))
                }), n.validator.autoCreateRanges && (null != t.min && null != t.max && (t.range = [t.min, t.max], delete t.min, delete t.max), null != t.minlength && null != t.maxlength && (t.rangelength = [t.minlength, t.maxlength], delete t.minlength, delete t.maxlength)), t
            },
            normalizeRule: function (t) {
                if ("string" == typeof t) {
                    var i = {};
                    n.each(t.split(/\s/), function () {
                        i[this] = !0
                    });
                    t = i
                }
                return t
            },
            addMethod: function (t, i, r) {
                n.validator.methods[t] = i;
                n.validator.messages[t] = void 0 !== r ? r : n.validator.messages[t];
                i.length < 3 && n.validator.addClassRules(t, n.validator.normalizeRule(t))
            },
            methods: {
                required: function (t, i, r) {
                    if (!this.depend(r, i))return "dependency-mismatch";
                    if ("select" === i.nodeName.toLowerCase()) {
                        var u = n(i).val();
                        return u && u.length > 0
                    }
                    return this.checkable(i) ? this.getLength(t, i) > 0 : n.trim(t).length > 0
                }, email: function (n, t) {
                    return this.optional(t) || /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/.test(n)
                }, url: function (n, t) {
                    return this.optional(t) || /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(n)
                }, date: function (n, t) {
                    return this.optional(t) || !/Invalid|NaN/.test(new Date(n).toString())
                }, dateISO: function (n, t) {
                    return this.optional(t) || /^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$/.test(n)
                }, number: function (n, t) {
                    return this.optional(t) || /^-?(?:\d+|\d{1,3}(?:,\d{3})+)?(?:\.\d+)?$/.test(n)
                }, digits: function (n, t) {
                    return this.optional(t) || /^\d+$/.test(n)
                }, creditcard: function (n, t) {
                    if (this.optional(t))return "dependency-mismatch";
                    if (/[^0-9 \-]+/.test(n))return !1;
                    var i, f, e = 0, r = 0, u = !1;
                    if (n = n.replace(/\D/g, ""), n.length < 13 || n.length > 19)return !1;
                    for (i = n.length - 1; i >= 0; i--)f = n.charAt(i), r = parseInt(f, 10), u && (r *= 2) > 9 && (r -= 9), e += r, u = !u;
                    return e % 10 == 0
                }, minlength: function (t, i, r) {
                    var u = n.isArray(t) ? t.length : this.getLength(t, i);
                    return this.optional(i) || u >= r
                }, maxlength: function (t, i, r) {
                    var u = n.isArray(t) ? t.length : this.getLength(t, i);
                    return this.optional(i) || r >= u
                }, rangelength: function (t, i, r) {
                    var u = n.isArray(t) ? t.length : this.getLength(t, i);
                    return this.optional(i) || u >= r[0] && u <= r[1]
                }, min: function (n, t, i) {
                    return this.optional(t) || n >= i
                }, max: function (n, t, i) {
                    return this.optional(t) || i >= n
                }, range: function (n, t, i) {
                    return this.optional(t) || n >= i[0] && n <= i[1]
                }, equalTo: function (t, i, r) {
                    var u = n(r);
                    return this.settings.onfocusout && u.unbind(".validate-equalTo").bind("blur.validate-equalTo", function () {
                        n(i).valid()
                    }), t === u.val()
                }, remote: function (t, i, r) {
                    if (this.optional(i))return "dependency-mismatch";
                    var u, e, f = this.previousValue(i);
                    return this.settings.messages[i.name] || (this.settings.messages[i.name] = {}), f.originalMessage = this.settings.messages[i.name].remote, this.settings.messages[i.name].remote = f.message, r = "string" == typeof r && {url: r} || r, f.old === t ? f.valid : (f.old = t, u = this, this.startRequest(i), e = {}, e[i.name] = t, n.ajax(n.extend(!0, {
                        url: r,
                        mode: "abort",
                        port: "validate" + i.name,
                        dataType: "json",
                        data: e,
                        context: u.currentForm,
                        success: function (r) {
                            var o, e, h, s = r === !0 || "true" === r;
                            u.settings.messages[i.name].remote = f.originalMessage;
                            s ? (h = u.formSubmitted, u.prepareElement(i), u.formSubmitted = h, u.successList.push(i), delete u.invalid[i.name], u.showErrors()) : (o = {}, e = r || u.defaultMessage(i, "remote"), o[i.name] = f.message = n.isFunction(e) ? e(t) : e, u.invalid[i.name] = !0, u.showErrors(o));
                            f.valid = s;
                            u.stopRequest(i, s)
                        }
                    }, r)), "pending")
                }
            }
        });
        n.format = function () {
            throw"$.format has been deprecated. Please use $.validator.format instead.";
        };
        var i, t = {};
        n.ajaxPrefilter ? n.ajaxPrefilter(function (n, i, r) {
            var u = n.port;
            "abort" === n.mode && (t[u] && t[u].abort(), t[u] = r)
        }) : (i = n.ajax, n.ajax = function (r) {
            var f = ("mode" in r ? r : n.ajaxSettings).mode, u = ("port" in r ? r : n.ajaxSettings).port;
            return "abort" === f ? (t[u] && t[u].abort(), t[u] = i.apply(this, arguments), t[u]) : i.apply(this, arguments)
        });
        n.extend(n.fn, {
            validateDelegate: function (t, i, r) {
                return this.bind(i, function (i) {
                    var u = n(i.target);
                    if (u.is(t))return r.apply(u, arguments)
                })
            }
        })
    });
    Array.prototype.indexOf || (Array.prototype.indexOf = function (n, t) {
        for (var i = t || 0, r = this.length; i < r; i++)if (this[i] === n)return i;
        return -1
    }), function () {
        for (var n, u = function () {
        }, t = ["assert", "clear", "count", "debug", "dir", "dirxml", "error", "exception", "group", "groupCollapsed", "groupEnd", "info", "log", "markTimeline", "profile", "profileEnd", "table", "time", "timeEnd", "timeStamp", "trace", "warn"], i = t.length, r = window.console = window.console || {}; i--;)n = t[i], r[n] || (r[n] = u)
    }();
    var UNIT_TESTING = !1, BBay = BBay || {}, Modernizr = Modernizr || {};
    window.__gCrWeb || (window.__gCrWeb = {});
    BBay.IS_MOBILE = $("html").hasClass("mobile"), function () {
        var n = window.navigator.userAgent, t = n.indexOf("MSIE ");
        (t > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) && $.ajaxSetup({cache: !1})
    }();
    BBay.Util = function () {
        var u = function (n) {
            var t = "";
            return $.each(n, function (n, i) {
                var r = i.Selected === !0 ? " selected" : "",
                    u = i.Value === undefined ? "" : 'value="' + i.Value + '"';
                t += "<option " + u + r + ">" + i.OptionText + "<\/option>\n"
            }), t
        }, f = function (n, t) {
            if (Modernizr.localstorage) {
                if (arguments.length > 1)return localStorage.setItem(n, JSON.stringify(t));
                var i = localStorage.getItem(n);
                return i && JSON.parse(i) || []
            }
            return !1
        }, e = function (n, t) {
            var i = $("form [name=" + n + "]"), u, r;
            if (typeof i.prop("tagName") != "undefined")if (u = i.prop("tagName").toLowerCase(), r = u.match("select|textarea"), r !== null) {
                if (r[0] === "select" && i.find("option[value=" + t + "]").length === 0)return;
                i.val(t).trigger("change")
            } else i.attr("type").match("text|tel|email|hidden") ? i.val(t) : i.attr("type") === "checkbox" && i.prop("checked", t).trigger("change")
        }, t = function (n, i) {
            var u, r, f;
            console.time("mapObjectToForm");
            u = $.Deferred();
            typeof i != "undefined" ? i += "." : i = "";
            for (r in n)n[r] !== "" && (typeof n[r] == "string" || typeof n[r] == "boolean" ? e(i + r, n[r]) : typeof n[r] == "object" && (f = r, t(n[f], i + f)));
            return u.resolve(), console.timeEnd("mapObjectToForm"), u
        }, o = function (n) {
            var t = n;
            if (typeof t != "undefined" && t.length > 0) {
                var i = $("#header"), f = t.offset().top, r = "fixed", u = jQuery(window);
                u.on("scroll", function () {
                    if (u.scrollTop() - 1 > f) {
                        i.addClass(r);
                        return
                    }
                    i.removeClass(r)
                })
            }
        }, i = function () {
            console.log("BBay.Util.scrollToId");
            var n = $(this), t = $(".sticky-container"), i = n.attr("href").match(/#.+/)[0], r = $(i).offset().top;
            return $("html, body").animate({scrollTop: r - t.height() - 25}, 250), !1
        }, n, r;
        $(document).on("click", "#scroll-up", i);
        n = function () {
            console.log("BBay.Util.toggleSlider");
            var n = $(this), t = $("#" + n.data("panel"));
            return t.slideToggle(), !1
        };
        $(document).on("click", ".js-slide-toggle", n);
        r = function () {
            var n = $(this);
            n.parent().parent().find(".child-option").addClass("hidden");
            n.parent().hasClass("parent-option") && n.parent().next().removeClass("hidden")
        };
        $(document).on("click change", ".group-list input", r);
        $.each($(".group-list .parent-option input:checked"), function (n, t) {
            $(t).trigger("click")
        });
        var s = function (n, t, i) {
            var r = new RegExp("([?|&])" + t + "=.*?(&|$)", "i"), u = n.indexOf("?") !== -1 ? "&" : "?";
            return n.match(r) ? n.replace(r, "$1" + t + "=" + i + "$2") : n + u + t + "=" + i
        }, h = function (n) {
            n = n.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
            var i = new RegExp("[\\?&]" + n + "=([^&#]*)"), t = i.exec(location.search);
            return t === null ? "" : decodeURIComponent(t[1].replace(/\+/g, " "))
        }, c = function (n, t) {
            console.log("loadUSStates");
            $.getJSON("/loaddeliverystates/", {state: t}, function (t) {
                var i = $(n),
                    r = '<select name="' + i.attr("name") + '" id="' + i.attr("id") + '" class="' + i.attr("class") + '">';
                r += BBay.Util.renderSelectHtml(t);
                r += "<\/select>";
                i.replaceWith(r)
            })
        };
        return {
            createSticky: o,
            mapObjectToForm: t,
            renderSelectHtml: u,
            scrollToId: i,
            store: f,
            toggleSlider: n,
            updateQueryStringParameter: s,
            getParameterByName: h,
            loadUSStates: c
        }
    }();
    Number.prototype.formatMoney = function (n, t, i) {
        var u = this, e = isNaN(n = Math.abs(n)) ? 2 : n, s = t === undefined ? "." : t, o = i === undefined ? "," : i,
            h = u < 0 ? "-" : "", f = parseInt(u = Math.abs(+u || 0).toFixed(e), 10) + "",
            r = (r = f.length) > 3 ? r % 3 : 0;
        return h + (r ? f.substr(0, r) + o : "") + f.substr(r).replace(/(\d{3})(?=\d)/g, "$1" + o) + (e ? s + Math.abs(u - f).toFixed(e).slice(2) : "")
    };
    $(document).on("click", ".skiplink", function () {
        $("#main").attr("tabindex", 0).focus()
    });
    (function () {
        function r() {
            var n = $(this), t = "checked", i;
            return n.is(":checked") ? (i = n.attr("name"), $("input[name=" + i + "]").parent().removeClass(t), n.parent().addClass(t), !0) : !1
        }

        function u() {
            $(this).prev().trigger("change")
        }

        var n = [".radio-button", ".inline-button-group"], t, i;
        if ($(n.join(", ")).length !== 0) {
            t = n.join(" input, ") + " input";
            i = n.join(" label, ") + " label";
            $(document).on("change", t, r);
            $(document).on("click", i, u)
        }
    })(), function () {
        function n(n, t, i) {
            return typeof i == "undefined" || +i == 0 ? Math[n](t) : (t = +t, i = +i, isNaN(t) || !(typeof i == "number" && i % 1 == 0)) ? NaN : (t = t.toString().split("e"), t = Math[n](+(t[0] + "e" + (t[1] ? +t[1] - i : -i))), t = t.toString().split("e"), +(t[0] + "e" + (t[1] ? +t[1] + i : i)))
        }

        Math.round10 || (Math.round10 = function (t, i) {
            return n("round", t, i)
        });
        Math.floor10 || (Math.floor10 = function (t, i) {
            return n("floor", t, i)
        });
        Math.ceil10 || (Math.ceil10 = function (t, i) {
            return n("ceil", t, i)
        })
    }(), function () {
        $("#l1scroll > .o-menu__section").each(function (n, t) {
            var r = new RegExp(/blackout/i), i = $(t);
            r.test(i.text()) && i.addClass("bf-menu")
        })
    }();
    $(window).bind("popstate", function () {
        if (window.history.state) {
            console.log("Popping History API");
            console.log(window.history.state);
            switch (window.history.state.pageid) {
                case"product-grid":
                    BBay.InfiniteScrolling.injectHistory(history.state);
                    break;
                case"checkout":
                    BBay.Checkout.displayEditableStep(undefined, window.history.state)
            }
        }
    });
    BBay.initValidation = function (n) {
        $.validator.setDefaults({ignore: []});
        var t = function (n, t) {
            var u = t.numberOfInvalids(), r, f, s, e, i, o;
            u && (r = u === 1 ? "There is an issue with 1 field below." : "There are issues with " + u + " fields below.", r += " Please check your entry and try again.", f = "", $.each(t.errorList, function (n, t) {
                f += t.element.name + ", "
            }), s = '<div class="alert alert-error">' + r + "<\/div>", e = $(t.currentForm), e.find(".alert.alert-error").remove(), i = e.find("label:first"), i.parents("ul").length > 0 && (i = i.closest("ul")), i.parents("ol").length > 0 && (i = i.closest("ol")), i.before(s), o = $("#header").height() + 90, BBay.IS_MOBILE || (o = $(".sticky-container").height() + 90), $("html,body").scrollTo(t.currentForm, 200, o), console.log(r + ": " + f))
        };
        BBay.pageForms[n] = $(n).validate({
            debug: !1,
            focusInvalid: !1,
            rules: {
                Email: {required: !0, email: !0},
                EmailConfirm: {required: !0, email: !0, equalTo: "#Email"},
                Password: {required: !0, minlength: 6},
                ConfirmPassword: {required: !0, minlength: 6, equalTo: "#Password"}
            },
            ignore: ".ignore",
            messages: {
                AddressComplete: {required: "Please complete a full address before proceeding."},
                Password: {
                    required: "Please provide a password.",
                    minlength: "Your password must be at least 6 characters long."
                },
                ConfirmPassword: {
                    required: "Please provide a password.",
                    minlength: "Your password must be at least 6 characters long.",
                    equalTo: "Please enter a matching password."
                },
                Email: {required: "Please enter a valid email address."},
                EmailConfirm: {
                    required: "Please provide an email address.",
                    equalTo: "Please enter a matching email address."
                },
                premier: {required: "Please choose a FREE DELUXE gift from above."}
            },
            invalidHandler: t
        });
        n === "#user-login" && $(n + " #login-password").rules("remove")
    };
    $.validator.addMethod("splitpin", function (n, t) {
        return this.optional(t) || /^([0-9\s\-])+$/.test(n)
    }, "Please add a valid voucher code");
    $.validator.addMethod("radio-empty", function (n, t) {
        var i = $(t).attr("name");
        return typeof n == "undefined" ? ($("input[name=" + i + "]").parent().addClass("invalid"), !1) : ($("input[name=" + i + "]").parent().removeClass("invalid"), !0)
    }, "Please make a selection");
    $.validator.addMethod("js-tel", function (n, t) {
        return this.optional(t) || validTel(n)
    }, "Please enter a valid contact number");
    $.validator.addMethod("postcode", function (n, t) {
        if (t.id === "DeliveryZipPostalCode" && !$(t).hasClass("required"))return !0;
        var i = $(t).closest("fieldset"), r = i.siblings("fieldset.country"), u = r.find("select"), f = u.val();
        return isPostcodeValid(f, n)
    }, "Please enter a valid postcode.");
    BBay.pageForms = {};
    $(function () {
        $(".bbay-form").map(function (n, t) {
            var i = $(t);
            i.attr("id") !== undefined ? BBay.initValidation("#" + i.attr("id")) : console.log(i.attr("action") + " requires an id for validation")
        })
    }), function () {
        var n = function () {
            var i = $(this).closest(".accordion"), n, t;
            return $("#react-product-page").length > 0 ? !1 : (n = $(this).parent(), n.hasClass("open") ? (n.removeClass("open"), n.next().removeClass("open")) : (n.addClass("open"), n.next().addClass("open")), $(this).data("partial") && (t = $(n.next()), $.trim(t.html()) === "" && t.addClass("loading").load($(this).data("partial"), function () {
                t.removeClass("loading")
            })), !1)
        };
        $(document).on("click", ".accordion dt a:not(.follow)", n)
    }();
    Address = {
        COUNTRY_IOM: 241, COUNTRY_IRL: 100, COUNTRY_UK: 76, COUNTRY_USA: 223, searchPostcode: function (n, t) {
            console.log("Address.searchPostcode");
            t = t || {};
            var i = $(this), u = i.parentsUntil("[data-addresstype]").parent().attr("id"),
                r = u !== undefined ? "#" + u + " " : "";
            return (t.countryId = t.countryId || parseInt($(r + ".country select").val(), 10), t.postcode = t.postcode || $(r + ".uk-postcode input").val(), t.countryId === "" || t.postcode === "") ? !1 : (t.countryId === Address.COUNTRY_UK && $.getJSON("/checkout/searchbypostcode/", t).success(function (t) {
                var u = $(r + ".address-lookup-dropdown"), f, i;
                t.AddressSearches.length === 1 ? (f = {id: t.AddressSearches[0].Id}, u.hide(), Address.get(n, f)) : (i = [{
                    OptionText: "Please select your address below...",
                    Value: ""
                }], $.each(t.AddressSearches, function (n, t) {
                    i.push({Value: t.Id, OptionText: t.Street + ", " + t.Place})
                }), u.slideDown().find("select").removeClass("ignore").html(BBay.Util.renderSelectHtml(i)));
                $(r + " .state").hide()
            }).error(function () {
                var n = "#" + i.closest("form").attr("id"), f = $(n).validate(), t = $(n + " .postcode").attr("name"),
                    r = {}, u;
                i.closest("[data-addresstype]").attr("id") !== undefined && (u = i.closest("[data-addresstype]").attr("id"), t = $("#" + u + " .postcode").attr("name"));
                r[t] = "Invalid postcode, please try again or use the enter manually option";
                f.showErrors(r)
            }), !1)
        }, get: function (n, t) {
            var i, u, f, r;
            return console.log("Address.get"), i = t || {}, n && (r = $(n.currentTarget), u = r.parentsUntil("[data-addresstype]").parent().attr("id"), f = u !== undefined ? "#" + u + " " : "", i.countryId = i.countryId || $(f + " .js-countryid").val(), i.id = i.id || r.val()), i.id !== "" && $.getJSON("/checkout/getaddress/", i).success(function (t) {
                console.log(t[0]);
                n && (Address.injectData(r, t[0]), $(f + ".address-lookup").slideDown(), $("#addressComplete").val(!0))
            }), !1
        }, display: function (n, t) {
            var i = t !== undefined ? "#" + t + " " : "",
                r = n !== undefined ? parseInt(n, 10) : parseInt($("#CountryId").val(), 10);
            console.log("Address.display - countryCode: " + r);
            $(i + " .state-dropdown").rules("remove");
            r !== this.COUNTRY_UK ? ($(i + ".uk-address, " + i + ".address-lookup-dropdown").hide(), $(i + ".address-lookup").show(), $(i + ".js-select-address").addClass("ignore"), $(i + ".county label").text("State / Province / Region:"), r === this.COUNTRY_IRL ? (console.log("removing ireland"), $(i + ".uk-postcode label em").hide(), $(i + ".uk-postcode input").removeClass("required")) : ($(i + ".uk-postcode label em").show(), $(i + ".uk-postcode input").addClass("required")), r === this.COUNTRY_USA ? ($(i + ".state-dropdown option").length === 0 && BBay.Util.loadUSStates(i + ".state-dropdown", $(i + "#County").val()), $(i + " .state-dropdown").addClass("required"), $(i + " .state").show(), $(i + " .county").hide()) : ($(i + " .state-dropdown").removeClass("required"), $(i + " .state").hide(), $(i + " .county").show())) : ($(i + ".uk-address, " + i + ".uk-postcode").show(), $(i + ".address-lookup").hide(), $(i + " .state-dropdown").removeClass("required"), $(i + ".county label").text("County:"))
        }, getAddAddressForm: function () {
            return console.log("Address.getCreateAddressForm"), $.get("/createaddress/")
        }, changeCountry: function () {
            console.log("Address.changeCountry");
            var n = $(this), t = n.parentsUntil("[data-addresstype]").parent().attr("id");
            Address.display(n.val(), t)
        }, injectData: function (n, t) {
            console.log("Address.injectData");
            var u = $(n), r = u.closest("[data-addresstype]").data("addresstype"),
                i = r === undefined ? "" : r.charAt(0).toUpperCase() + r.slice(1);
            i === "Billing" && (i = "");
            $("#" + i + "Company").val(t.Company);
            $("#" + i + "Address1").val(t.Line1);
            $("#" + i + "Address2").val(t.Line2);
            $("#" + i + "Address3").val(t.Line3);
            $("#" + i + "City").val(t.City);
            $("#" + i + "ZipPostalCode").val(t.PostalCode);
            t.State !== null && t.State.length > 0 && $("#" + i + "City").val(t.State);
            $("#" + i + "County").val(t.County).parent().show()
        }, manualEntry: function () {
            console.log("Address.manualEntry");
            var n = $(this), t = n.parentsUntil("[data-addresstype]").parent().attr("id");
            return Address.display(0, t), !1
        }, init: function () {
            $(document).on("change", ".js-countryid", Address.changeCountry);
            $(document).on("change", ".js-select-address", Address.get);
            $(document).on("click", ".js-find-address", Address.searchPostcode);
            $(document).on("click", ".js-manual", Address.manualEntry);
            $(document).on("blur", ".uk-postcode input", function () {
                var n = $(this).parent();
                setTimeout(function () {
                    if (!n.find(".js-manual").is(":hidden")) {
                        console.log("manual entry not hidden");
                        var t = n.find(".js-find-address");
                        !t.is(":hidden") && $(".js-select-address").is(":hidden") && t.trigger("click")
                    }
                }, 250)
            });
            $(".js-countryid:first").trigger("change");
            $("#edit-address").length === 1 && $(".js-manual").trigger("click")
        }
    };
    $(function () {
        Address.init()
    }), function () {
        function h(n) {
            var t = $(window).scrollTop(), r = t + $(window).height(), i = $(n).offset().top, u = i + $(n).height();
            return u <= r && i >= t
        }

        function c() {
            t = setInterval(function () {
                if (n < s && u ? n = n + 1 : (n = n - 1, u = !1, f = !1, r = i.find(".img"), n === 1 && (u = !0)), f) {
                    var t = e.match(/(\d+)(\.\w{3})/);
                    t[1] = n;
                    $("<img>", {"class": "img", src: e.replace(/(\d+)\.\w{3}/, t[1] + t[2])}).appendTo(i)
                } else r.addClass("hidden"), $(r[n - 1]).removeClass("hidden")
            }, o)
        }

        var t = null, n = 1, o = 100, s = 18, u = !0, f = !0, i = $(".animated-image"), r = i.find(".img"),
            e = r.attr("src");
        i.length > 0 && $(window).scroll(function () {
            h(".animated-image") ? t === null && c() : (clearInterval(t), t = null)
        })
    }(), function () {
        function i() {
            t = setInterval(function () {
                var t = n.find("li.active").index() + 1, i = 1;
                n.find("li").removeClass("active");
                n.find("li").length >= t + 1 && (i = t + 1);
                n.find("li:nth-child(" + i + ")").addClass("active")
            }, r)
        }

        var n = $(".menu-carousel"), t, r = n.data("rotation");
        if (!BBay.IS_MOBILE && n.length) {
            i();
            $(document).on("mouseover", ".menu-carousel", function () {
                clearInterval(t)
            });
            $(document).on("mouseout", ".menu-carousel", function () {
                i()
            });
            $(document).on("mouseover", ".menu-carousel li:not(.search)", function () {
                n.find("li").removeClass("active");
                $(this).addClass("active")
            })
        }
    }(), function () {
        var t = $("#brand-search-input"), n = $(".brand-list a"), i = $(".brand-list h3"), r = $(".az-index"), u = 40,
            o = 27, f = 13, s = 38, h = function (t) {
                var o = $(this), e = o.val().toLowerCase();
                return n.removeClass("hidden"), i.removeClass("hidden"), $(".no-brands").hide(), e.length >= 2 ? (i.addClass("hidden"), r.slideUp(), n.each(function () {
                    var n = $(this), t = n.text().toLowerCase();
                    t.indexOf(e) === -1 && n.addClass("hidden")
                }), [u, f].indexOf(t.keyCode) !== -1 && (n.hasClass("selected") || $(".brand-list a:not(.hidden):first").addClass("selected"), $(".brand-list a.selected").focus()), $(".brand-list a:not(.hidden)").length === 0 && ($(".no-brands").show(), $(".brand-list .hidden").removeClass("hidden"))) : r.slideDown(), !1
            }, e = function () {
                t.focus()
            }, c = function (n) {
                var i = $(".brand-list a:not(.hidden)"), t, r = i.index($(".selected"));
                if (i.removeClass("selected"), n.keyCode === u) t = r + 1, t >= i.length && (t = 0), $(i[t]).addClass("selected").focus(); else if (n.keyCode === s) t = r - 1, t < 0 ? e() : $(i[t]).addClass("selected").focus(); else if (n.keyCode === o) i.removeClass("selected"), e(); else if (n.keyCode === f)return !0;
                n.preventDefault()
            };
        if ($("#baz-search").length === 0) {
            t.on("keyup", h);
            n.on("focus keydown", c)
        }
    }();
    BBay.Carousel = function () {
        function t(n) {
            var i = $("#" + n), u = "#" + n + " .container ", f = 3, e = i.attr("class").match(/scroll-([0-9])/), t = {
                arrows: !0,
                autoplay: !1,
                autoplaySpeed: 7500,
                lazyLoadBuffer: 4,
                slidesToShow: parseInt(f, 10),
                slidesToScroll: parseInt(f, 10),
                zIndex: 10
            }, r;
            i.hasClass("auto") && (t.autoplay = !0);
            i.hasClass("large") && (t.slidesToShow = 1, t.autoplay = !0, t.dots = !0, t.lazyload = "ondemand", t.lazyLoadBuffer = 1, t.fade = !0);
            i.hasClass("recent") && (t.slidesToShow = 6);
            i.hasClass("large") || (t.responsive = [{breakpoint: 650, settings: {slidesToShow: 2, slidesToScroll: 2}}]);
            i.hasClass("gallery") && (t.autoplay = !1);
            (i.hasClass("wedding") || i.hasClass("show-4")) && (t.slidesToShow = 4);
            t.slidesToScroll = t.slidesToShow;
            e !== null && (r = parseInt(e[1], 10), t.slidesToShow = r, t.slidesToScroll = r, t.lazyLoadBuffer = r);
            console.group("enabling carousel: " + u);
            console.dir(t);
            console.groupEnd();
            $(u).slick(t)
        }

        function n() {
            $.map($(".carousel"), function (n, i) {
                $(n).attr("id", "carousel" + i);
                t("carousel" + i)
            })
        }

        return n(), {init: n}
    }();
    BBay.Checkout = function () {
        var u = [], y = function () {
            console.log("click signIn");
            var t = this, n = $(t), i = n.attr("href").split("#")[1];
            return n.toggleClass("open"), $("#" + i).slideToggle(function () {
                window.scrollTo(0, n.offset().top - 10)
            }), !1
        }, p = function () {
            console.log("Checkout.signInSubmit");
            var n = $(this);
            return n.find("input[type=submit]").attr("disabled", "disabled").addClass("loading"), $.ajax({
                data: n.serializeObject(),
                type: n.attr("method"),
                url: n.attr("action")
            }).done(function (i) {
                i.success === !0 ? ($("#address-container").html(i.html), $("#billing-address").trigger("change"), $("#addressComplete").val(i.validAddress), $(".js-signin-slider").slideUp(function () {
                    $("#addresses").find(".js-chk-frm").slideDown(function () {
                        $(this).parent().addClass("open");
                        t("addresses");
                        $("#sign-in").addClass("complete");
                        $(".group-list .parent-option input:checked").trigger("click")
                    })
                })) : (n.find("input[type=submit]").removeAttr("disabled").removeClass("loading"), $("#login-password").after('<label class="error">' + i.error + "<\/label>"))
            }), !1
        }, w = function () {
            console.log("Checkout.guestPassword");
            $(".express-signup").toggleClass("hidden");
            $(this).is(":checked") ? ($("#NewUserPassword").rules("add", {
                required: !0,
                minlength: 6
            }), $("#ConfirmNewUserPassword").rules("add", {
                required: !0,
                minlength: 6,
                equalTo: "#NewUserPassword"
            })) : ($("#NewUserPassword").rules("remove"), $("#ConfirmNewUserPassword").rules("remove"))
        }, s = function (n) {
            $("#DeliveryFirstName").val(n.FirstName);
            $("#DeliveryLastName").val(n.LastName)
        }, b = function () {
            var n, i;
            return console.log("Checkout.guestSubmit"), n = $(this), n.find("input[type=submit]").attr("disabled", "disabled").addClass("loading"), i = n.serializeObject(), s(i), $.ajax({
                data: i,
                type: n.attr("method"),
                url: n.attr("action")
            }).done(function () {
                $(".js-signin-slider").slideUp(function () {
                    $("#addresses").find(".js-chk-frm").slideDown(function () {
                        $(this).parent().addClass("open");
                        t("addresses");
                        $("#sign-in").addClass("complete")
                    })
                })
            }), !1
        }, f = !1, h = "", e = "", k = function () {
            console.log("Checkout.customerExists");
            var n = $(this), t = $("#ExpressNext"), i = {username: n.val()};
            h = e;
            n.hasClass("valid") && (e = n.val(), $.get("/customerexists/", i, function (n) {
                n !== !0 ? ($("fieldset.emailcheck.error").length !== 0 || f || ($(".js-express-field").before('<fieldset class="alert alert-message">' + n.toString() + "<\/fieldset>"), $("[data-guest-checkout]").removeAttr("disabled"), $("[data-guest-checkout]").removeClass("loading"), f = !0), t.attr("disabled", "disabled").removeAttr("checked"), $(".express-signup").addClass("hidden")) : ($(".error.emailcheck").remove(), $(".alert-message").remove(), e != h ? (t.removeAttr("disabled"), f = !1) : t.disabled = !0)
            }))
        }, c = function (n, i) {
            var u = $(this);
            i && (u = $("#" + i.step));
            u.hasClass("editable") && $(".open .js-chk-frm").slideUp(function () {
                $(".js-step").removeClass("open");
                u.find(".js-chk-frm").slideDown(function () {
                    $(this).parent().addClass("open");
                    r();
                    $("body").scrollTo("#addresses", 200);
                    i || t($(this).parent().attr("id"));
                    $(".js-chk-frm").removeAttr("style")
                })
            })
        }, d = function () {
            var n = $(this), i = n.find("input[type=submit]");
            return l() ? (i.attr("disabled", "disabled").addClass("loading"), n.attr("id") === "frm-payment") ? !0 : (v(), $.post(n.attr("action"), n.serialize(), function (r) {
                nt(r) && (Modernizr.history && window.history.state === null && t(n.parent().attr("id")), g(n.parent().attr("id")));
                i.removeAttr("disabled").removeClass("loading");
                r === !1 && (alert("We're sorry. Your session has timed out so we have to restart the checkout process."), window.location = "/bag/")
            }), !1) : ($("#frm-delivery-details").valid(), !1)
        }, g = function (n) {
            return $("#" + n + " .js-chk-frm").slideUp(function () {
                var u = $(this).parentsUntil("js-step").first(), n = u.nextAll(".js-step").first(), i = n.attr("id");
                $(".js-step.open").removeClass("open");
                $(".alert.alert-error:not(.hidden)").remove();
                n.find(".js-chk-frm").slideDown(function () {
                    n.addClass("open");
                    r();
                    $("#" + i + " .group-list input:checked").trigger("click");
                    $("body").scrollTo("#" + i, 200)
                });
                t(i)
            }), !1
        }, nt = function (t) {
            var r = $("#chk--delivery-opts"), u = $(".js-payment-details"), f = $("#chk--gift-opts"),
                e = $("#order-confirmation"), i;
            if (t.StockLevels)for (i = 0; i < t.StockLevels.length; i++)if (t.StockLevels[i].Quantity <= 0) {
                window.location.replace("/bag/");
                return
            }
            return t.OrderConfirmation !== !1 && (e.html(t.OrderConfirmation), n()), t.Valid === !0 ? (t.DeliveryMethod !== !1 && r.replaceWith(t.DeliveryMethod), t.PaymentOptions !== !1 && (u.html(t.PaymentOptions), BBay.Payment.load(), BBay.Payment.display()), t.GiftWrapping !== !1 && t.GiftWrapping !== undefined && f.replaceWith(t.GiftWrapping), n(), !0) : ($("#order-confirmation").find(".alert--restricted-item").length !== 0 && $("#restricted-item-error").removeClass("hidden"), !1)
        }, l = function () {
            var n = !0, t = "";
            return $("#address-container").find(".required").each(function (t, i) {
                $(i).val() === "" && (n = !1)
            }), n === !0 && (t = n), $("#deliver-to-parcelshop").is(":checked") && $("#pudo-name").val() === "" && (t = "", n = !1), $("#addressComplete").val(t), n
        }, tt = function () {
            var t = $(this).attr("maxlength"), n = $(this).val(), i = t - n.length;
            i >= 0 ? $("#counter").html(i) : $(this).val(n.substring(0, t));
            $("#summary-gift-msg").text(n)
        }, i = function (n) {
            n = typeof n == "undefined" ? "" : n;
            var r = $.trim($("#" + n + "Company").val()), s = $.trim($("#" + n + "Address1").val()),
                u = $.trim($("#" + n + "Address2").val()), f = $.trim($("#" + n + "Address3").val()),
                h = $.trim($("#" + n + "City").val()), e = $.trim($("#" + n + "County").val()),
                o = $.trim($("#" + n + "ZipPostalCode").val()), c = $("#" + n + "CountryId option:selected").text(),
                i = ", ", t = "";
            return r !== "" && (t += r + i), t += s + i, u !== "" && (t += u + i), f !== "" && (t += f + i), t += h + i, e !== "" && (t += e + i), o !== "" && (t += o + i), t + c
        }, n = function () {
            var n, u, t = $("#billing-address"), r = $("address.billing"), e = $("#delivery-address"),
                f = $("address.delivery"), o = $("#addressComplete");
            switch (parseInt($("#chk--delivery-address").find("input:checked").val(), 10)) {
                case 1:
                    e.length > 0 ? (n = t.find(":selected").text(), u = e.find(":selected").text(), o.val(!0)) : (n = i().replace(/ , /g, "").replace(/,, /, ""), u = i("Delivery").replace(/ , /g, "").replace(/,, /, ""));
                    r.text(n);
                    f.text(u);
                    break;
                case 2:
                    n = t.length > 0 ? t.find(":selected").text() : i().replace(/ , /g, "").replace(/,, /, "");
                    r.text(n);
                    $("#chk--pudo-shops").find("input:checked").trigger("change");
                    break;
                default:
                    t.length > 0 ? (n = t.find(":selected").text(), o.val(!0)) : n = i().replace(/ , /g, "").replace(/,, /, "");
                    r.text(n);
                    f.text(n)
            }
            return r.parent().removeClass("hidden"), f.parent().removeClass("hidden"), !1
        }, a = function () {
            var t, n;
            u.length === 0 && (t = $(".js-different-delivery-address .required"), $(".js-different-delivery-address .required").each(function (n, i) {
                u.push($(i).attr("id"));
                t.removeClass("required")
            }));
            n = $(".js-different-delivery-address");
            $("#deliver-to-other").is(":checked") ? ($.each(u, function (n, t) {
                $("#" + t).addClass("required")
            }), n.removeClass("hidden")) : n.find(".required").removeClass("required")
        }, it = function () {
            var r = $(this), t = $("#pudo-container"), i = $("#pudo-loader");
            t.addClass("hidden");
            i.removeClass("loading");
            $("#address-submit").removeAttr("disabled");
            $("#pudo-error").remove();
            switch (parseInt(r.val(), 10)) {
                case 1:
                    $("#delivery").find(".js-countryid").trigger("change");
                    break;
                case 2:
                    $("#shop-options").is(":empty") && $("#address-submit").attr("disabled", "disabled");
                    typeof google == "undefined" ? (BBay.Pudo.initPUDO(), i.addClass("loading")) : typeof google != "undefined" && (t.removeClass("hidden"), $("#chk--pudo-shops").find("input:checked").trigger("change"));
                    $("#addressComplete").val("");
                    break;
                default:
                    $("#addressComplete").val(!0)
            }
            return a(), n(), !0
        }, rt = function () {
            return console.log("click changeAddress"), $(".open .js-chk-frm").slideUp(function () {
                $(".js-step.open").removeClass("open");
                $("#addresses").find(".js-chk-frm").slideDown(function () {
                    $(this).parent().addClass("open");
                    r();
                    window.scroll(0, $("#addresses").offset().top);
                    t($(".js-step.open").attr("id"))
                })
            }), !1
        }, ut = function () {
            console.log("change switchVoucherPayment");
            var t = $(this), i = {status: !1};
            t.is(":checked") && (i.status = !0);
            $.get("/checkout/updategiftvoucherpaymentoption", i, function (i) {
                $(".js-payment-details").html(i.creditCardViewHtml);
                BBay.Payment.load();
                BBay.Payment.display();
                $("#order-confirmation").html(i.orderConfirmationHtml);
                var r = $("#gc-deduction");
                r.hide();
                t.is(":checked") && r.show();
                n()
            })
        }, ft = function () {
            console.log("change keyup validateCreditCard");
            var n = $("#cardnumber");
            $(".js-change-address").addClass("hidden");
            n.validateCreditCard(function (t) {
                $(".credit-cards li.fade").removeClass("fade");
                n.removeClass("valid-card");
                t.card_type !== null && $(".credit-cards li:not(." + t.card_type.name + ")").addClass("fade");
                t.length_valid === !0 && n.addClass("valid-card")
            })
        }, et = function () {
            console.log("change paypalPayment");
            var n = $(".js-card-information");
            n.slideToggle();
            $(this).val() === "Paypal" ? n.find("input").attr("disabled", "disabled") : n.find("input").removeAttr("disabled")
        }, ot = function () {
            var n = $(".js-card-information"), t;
            n.slideToggle();
            t = $(".js-paypal-information");
            t.slideToggle();
            $(this).val() === "Paypal" ? (n.find("input").attr("disabled", "disabled"), $("[data-braintree-submit]").addClass("hidden")) : (n.find("input").removeAttr("disabled"), $("[data-braintree-submit]").removeClass("hidden"))
        }, st = function () {
            return $("#cvv-more-info").toggle(), window.location.href = "#cvv-more-info", !1
        }, ht = function () {
            var t, i;
            console.log("displaySectionOnReload");
            t = window.location.hash.substring(2);
            t !== "" && window.location.href.match(/\/#\//) !== null && (t = t.match(/[a-z\-]+/)[0], i = $("#" + t), i.length > 0 && ($(".js-step.open").removeClass("open"), $(".sign-in").removeClass("open").addClass("complete"), i.addClass("open")), r(), n())
        }, t = function (n) {
            if (Modernizr.history) {
                var t = "/checkout/#/" + n,
                    i = JSON.parse(JSON.stringify({step: n, html: "", pageid: "checkout", url: t}));
                history.pushState(i, null, t)
            }
        }, r = function () {
            $(".js-step").removeClass("complete editable");
            $.each($(".js-step"), function (n, t) {
                var i = $(t);
                if (i.hasClass("open"))return !1;
                i.addClass("complete editable")
            })
        }, v = function () {
            var t = !1, n;
            typeof window.matchMedia != "undefined" && (t = window.matchMedia("(max-width:950px)"));
            n = $("#summary");
            t.matches ? n.addClass("js-step") : (n.removeClass("js-step"), n.find(".js-chk-frm").removeAttr("style"))
        }, ct = function () {
            console.log("click closeCreateAddress");
            $(".checkout").slideDown(function () {
                window.scrollTo(0, 0);
                $(".create-address").fadeOut(function () {
                    $(".create-address").remove();
                    $("#add-address-container").addClass("hidden");
                    $("body").scrollTo(".step.addresses", 200);
                    $(".js-addressid").trigger("change");
                    $(".group-list .parent-option input:checked").trigger("click")
                })
            })
        }, o;
        if ($("body#checkout").length) {
            v();
            a();
            ht();
            $(document).on("submit", ".js-chk-frm", d);
            $(document).on("click", ".editable:not(.open)", c);
            $(document).on("blur", ".emailcheck", k);
            $(document).on("change", ".js-express", w);
            $(document).on("click", ".sign-in .option", y);
            $(document).on("submit", "#guest-checkout", b);
            $(document).on("submit", "#user-login", p);
            $(document).on("change", ".js-addressid", n);
            $(document).on("change", "#address-container .required", l);
            $(document).on("change", "#chk--delivery-address input", it);
            $(document).on("click keydown keyup change blur focus", "#giftDescription", tt);
            $(document).on("click", ".js-change-address", rt);
            $(document).on("change", "#card-payment, #paypal-payment", et);
            $(document).on("change", "#braintree-card-payment, #braintree-paypal-payment", ot);
            $(document).on("change", "#UseGiftVoucherAsPayment", ut);
            $(document).on("click", "#cvv-more, #cvv-more-info .js-close", st);
            $(document).one("change keyup", "#cardnumber", ft)
        }
        return o = {displayEditableStep: c, closeCreateAddress: ct}, UNIT_TESTING && (o.injectDeliveryName = s), o
    }(), function () {
        var n = function () {
            return console.log("click .js-add-address"), $.ajax({
                dataType: "html",
                url: $(this).attr("href")
            }).done(function (n) {
                var t = $("#add-address-container");
                t.text().length === 0 && (t.html($.trim(n)), t.removeClass("hidden"));
                BBay.initValidation("#create-address");
                Address.display($(".js-countryid:first").val())
            }), !1
        }, t = function () {
            console.log("submitting create address");
            var n = $(this);
            return $.ajax({
                data: n.serializeObject(),
                dataType: "html",
                type: n.attr("method"),
                url: n.attr("action")
            }).done(function (n) {
                $("#address-container").html(n);
                BBay.Checkout.closeCreateAddress()
            }), !1
        }, i = function () {
            return console.log("click #create-address .js-cancel"), BBay.Checkout.closeCreateAddress(), !1
        };
        if ($("body#checkout").length) {
            $(document).on("click", ".js-add-address", n);
            $(document).on("submit", "#create-address", t);
            $(document).on("click", "#create-address .js-cancel", i)
        }
    }();
    $(".panel:not(.disabled) h2").click(function () {
        console.log("change basket panel");
        $(".panel").removeClass("open");
        $(this).parent().addClass("open")
    });
    $(document).on("click", ".js-show-voucher", function () {
        return console.log("click .js-show-voucher"), $("#voucher-code").find("fieldset").toggleClass("hidden"), !1
    });
    BBay.ContentLoader = function () {
        $searchCatCart = $(".c-search-cathdr");
        $("[data-content-key]").length !== 0 && $searchCatCart.length !== 0 && $.get(contentLocation + "/api/content/" + $("[data-content-key]").data("content-key"), function (n) {
            $searchCatCart.find("h1").text(n.title);
            $searchCatCart.find(".c-search-cathdr__desc").html(n.description)
        })
    }(), function () {
        var n = $("#cookie-msg"), t, i;
        if (n.length !== 0) {
            t = "c-ups--cookie--open";
            n.addClass(t);
            i = function () {
                return Modernizr.csstransforms3d ? (n.removeClass(t), !1) : (n.remove(), !1)
            };
            $("#cookie-msg-close").on("click", i)
        }
    }();
    $(document).on("click", ".faqs .question", function () {
        $(this).next().slideToggle()
    });
    $(document).on("change", "select#Reason", function () {
        var t = $(this), n = parseInt(t.val(), 10);
        $("#manual-order").addClass("hidden").find("input").removeClass("required");
        n !== 0 && n !== 1 && n !== 5 ? ($(".js-ordernumber").fadeIn(), $("#OrderNumber").addClass("required")) : ($(".js-ordernumber").fadeOut(), $("#OrderNumber").removeClass("required"))
    });
    $(document).on("change", "#OrderNumber", function () {
        $(this).val() === "other" && ($(this).removeClass("required"), $(".js-ordernumber").removeAttr("style"), $("#manual-order").removeClass("hidden").find("input").addClass("required"))
    });
    $(document).on("click", ".js-btn-checkout", function () {
        var n = $(this);
        ecomData({
            event: "checkout",
            ecommerce: {actionField: {step: n.parentsUntil("[data-ga-step]").parent().data("ga-step")}}
        })
    });
    if (function () {
            function n(n, t) {
                var i = t ? $(".options li:first-child img").data("bg") : $(n.currentTarget).data("bg"),
                    r = $("#nail-tester").data("cdnpath") ? $("#nail-tester").data("cdnpath") : "//img.bb-cdn.com/assets/staticcontent/image/swatches/",
                    u = i.substring(0, 1) === "#" ? i : "url(" + r + i + ")";
                $(".colour").css("background", u)
            }

            if ($("#nail-tester").length) {
                console.log("Essie Try It On Page");
                $(document).on("click", "#nail-tester .bottle", n);
                n(!1, !0)
            }
        }(), function () {
            var i;
            $(document).on("click", ".js-facet-display", function () {
                var t = $(this), r = t.data("facetid"), i = !1, n = $("#facet-" + r);
                if (t.toggleClass("closed"), BBay.IS_MOBILE) $("#filter-container").hide(), $("#filter-selected").html(n.html()).show(); else {
                    if (n.css("display") === "none" ? (i = !0, n.slideDown()) : n.slideUp(), $("#listerContainer").length > 0)return !1;
                    $.get("/facetnav/", {id: t.text(), showStatus: i})
                }
                return !1
            });
            if (i = $("#slider-range"), jQuery.ui && i.length) {
                var n = $("#facets"), u = $("#lowerAmount"), f = $("#higherAmount"), r = n.data("currency"),
                    t = n.data("conversion"), e = Math.round(n.data("selectedmin") * t) - 1,
                    o = Math.round(n.data("selectedmax") * t) + 1, s = Math.round(.5 + n.data("min") * t) - 1,
                    h = Math.round(-.5 + n.data("max") * t) + 1;
                i.slider({
                    range: !0, min: s, max: h, values: [e, o], slide: function (n, t) {
                        u.val(r + t.values[0]);
                        f.val(r + t.values[1])
                    }, stop: function (n, i) {
                        var r = Math.round(i.values[0] / t), u = Math.round(i.values[1] / t),
                            f = $.post("/typeahead/sliderproductcountsearch", {
                                minValue: r,
                                maxValue: u,
                                url: document.URL
                            });
                        f.done(function (n) {
                            if (!isNaN(parseInt(n, 10)) && parseInt(n, 10) !== 0) {
                                var f = r, e = u, o = f + "|" + e,
                                    t = BBay.Util.updateQueryStringParameter(document.URL, "Rn", o),
                                    i = t.indexOf("No-"), s = t.indexOf("?");
                                i > -1 && (t = t.substring(0, i) + t.substring(s, t.length));
                                window.location = t
                            }
                        })
                    }
                });
                u.val(r + i.slider("values", 0));
                f.val(r + i.slider("values", 1))
            }
            var c = $(".facet.scrollable"), l = function (n, t) {
                var i = n.offset().top + n.outerHeight(), r = t;
                return {min: i - r, max: i}
            }, a = function (n, t) {
                return n >= t.min && n <= t.max
            };
            c.on("click", function (n) {
                var t = $(this), i = l(t, 66);
                a(n.pageY, i) && t.toggleClass("is-open")
            });
            $(".js-filter-trigger").on("click", function () {
                return $(".js-aside-slider").toggleClass("is-open"), !1
            });
            $(document).on("click", ".facet", function (n) {
                if ($("#listerContainer").length > 0)return n.preventDefault(), !1
            })
        }(), function () {
            FastClick.attach(document.body)
        }(), function () {
            var n = document.getElementById("feefo--customer-reviews");
            n !== null && $.get("/feeforeviews/", {count: 6}, function (t) {
                n.innerHTML = t.html
            })
        }(), function () {
            function i() {
                console.log("BBay.login.requestForm");
                var i = $(this);
                return t || (t = !0, $.get(i.attr("href"), function (t) {
                    $("#user-login").after('<div class="forgot-password slider hidden" />');
                    $(".forgot-password").html(t).slideDown(function () {
                        $("#forgot-email").val($("#login-email").val());
                        $("body").scrollTo(n, 200);
                        BBay.initValidation(n)
                    })
                })), !1
            }

            function r() {
                console.log("BBay.login.submitForm");
                var t = $(this);
                return $.ajax({
                    data: t.serializeObject(),
                    type: t.attr("method"),
                    url: t.attr("action")
                }).done(function (t) {
                    $(n).html('<div class="alert alert-message">' + t + "<\/div>")
                }), !1
            }

            var n = "#forgot-password-form", t = !1;
            $(document).on("submit", "#forgot-password-form", r);
            $(document).on("click", "#load-forgot", i)
        }(), popUpMenu = function () {
            var n = function () {
                return console.log("popUpMenu.closeMenu"), $(".nav-item-active .nav-dd, .nav-item-active .bbay-form").fadeOut("fast", function () {
                    return $(".nav-item-active").removeClass("nav-item-active"), $(this).removeAttr("style"), !0
                }), !1
            };
            $(document).on("click", ".nav-tab", function () {
                var t = $(this).parent();
                if (t.hasClass("nav-item-active")) t.removeClass("nav-item-active"); else {
                    $(".nav-item-active").removeClass("nav-item-active");
                    $(document).one("click", "html", n);
                    t.addClass("nav-item-active")
                }
                return $("input:focus").blur(), !1
            });
            $(document).on("click", ".nav-item-active .nav-dd", function (n) {
                n.stopPropagation()
            });
            return {close: n}
        }(), BBay.GiftCards = function () {
            function r(n) {
                return n.ctrlKey === !0 || n.metaKey === !0 ? !0 : !1
            }

            function p(n) {
                if (n.val().length >= t) {
                    var i = n.attr("maxlength"), r = new RegExp(".{1," + t + "}", "g"),
                        u = n.val().replace(/\D/g, "").match(r).join(" ").substring(0, i);
                    return $.trim(u)
                }
                return n.val()
            }

            function w(n, t) {
                var i = [8, 9, 27, 46];
                return (typeof t != "undefined" && (i = i.concat(t)), $.inArray(n.keyCode, i) !== -1 || n.keyCode === 65 && r(n) || n.keyCode === 88 && r(n) || n.keyCode === 67 && r(n) || n.keyCode === 86 && r(n) || n.keyCode >= 35 && n.keyCode <= 40) ? !0 : !1
            }

            function d(n) {
                return (n.shiftKey || n.keyCode < 48 || n.keyCode > 57) && (n.keyCode < 96 || n.keyCode > 105) ? !1 : !0
            }

            function g(n) {
                var i = $(this), u = i.val().length % t, r;
                if (n.type === "keydown")if (w(n, [13])) s = !0; else {
                    if (!d(n))return n.preventDefault(), !1;
                    s = !1
                }
                if (n.type === "focusout") {
                    i.val(p(i));
                    return
                }
                if (n.type === "keyup" && i.val().length > 0 && !s) {
                    r = i[0].selectionStart;
                    i.val(p(i));
                    i.val().length % t !== u && (r += 1);
                    i[0].selectionStart = r;
                    i[0].selectionEnd = r;
                    return
                }
            }

            function nt(n) {
                var r = $(this), u = r.attr("rows"), f = r.attr("maxlength"),
                    t = r.val().replace(/\r/g, "").split("\n"), e, o, i;
                if (n.type === "keydown" && (u && t.length > u && (t = t.slice(0, u), e = 1), f)) {
                    for (i = t.length; i-- > 0;)t[i].length > f && (t[i] = t[i].slice(0, f), o = 1);
                    if ((o || e) && (r.value = t.join("\n"), !w(n)))return n.preventDefault(), !1
                }
            }

            function u(n) {
                var t = Math.round10(k * n, -1), i = y + t.formatMoney(2, ".", "");
                if ($(".js-conversion-value").text(i), y !== "£") {
                    $(".js-conversion").addClass("show");
                    return
                }
                $(".js-conversion").removeClass("show");
                return
            }

            function f() {
                var n = $("#gc--other-amount-field");
                h.trigger("keyup");
                c.is(":checked") ? (n.addClass("open"), n.find("input").removeClass("ignore"), u(h.val())) : (n.removeClass("open"), n.find("input").addClass("ignore"), u($("input[name=Amount]:checked").val()))
            }

            function tt() {
                var n = parseFloat(h.val());
                u(n)
            }

            function b(n) {
                return $.each(n[0].data(), function (n) {
                    var t = n.replace("label", "").toLowerCase();
                    t !== "" && e.push(t)
                }), e
            }

            function it(n, t, i) {
                var u = {}, f = "label", r;
                for (i.indexOf(n) !== -1 && (f += "-" + n), r = 0; r < t.length; r++)u[t[r].attr("id")] = t[r].data(f);
                return u
            }

            function a(n, t, i) {
                for (var u = it(n, t, i), f, r = 0; r < t.length; r++)f = u[t[r].attr("id")], t[r].text(f);
                return u
            }

            function rt() {
                var n = $("#Email"), t = $("#EmailConfirm"), i = $("#gc--form-details"), r = $("#form-details"),
                    u = $("#FromName");
                r.hasClass("hidden") && (r.slideDown(), c.is(":checked") && f());
                $("#gc--print").is(":checked") ? (i.slideUp(), n.val() === "" && n.val(n.data("autofill")), t.val() === "" && t.val(t.data("autofill")), u.addClass("ignore"), a("print", l, e)) : (i.slideDown(), u.removeClass("ignore"), n.val() === n.data("autofill") && n.val(""), t.val() === t.data("autofill") && t.val(""), a("", l, e))
            }

            function ut() {
                var t, r;
                if ($(".gc--product-page").length !== 0) {
                    if (t = $("#add-product").serializeObject(), typeof t.SendOption == "undefined") {
                        $("input[name=SendOption]").parent().addClass("invalid");
                        r = $(".radio-button.invalid");
                        r.on("change", function () {
                            r.removeClass("invalid")
                        })
                    }
                    var u = n.attr("rows"), f = n.attr("maxlength"),
                        e = t.Message.replace(/\r/g, "").split("\n").slice(0, u).join("\n");
                    n.val(e.substring(0, f));
                    n.val() === i && (n.val(""), n.removeClass("default"))
                }
            }

            function ft(n) {
                var t = $(this);
                t.val() === i && n.type === "focusin" ? (t.val(""), t.removeClass("default")) : t.val() === "" && n.type === "focusout" && (t.val(i), t.addClass("default"))
            }

            var s = !1, t = 4, h = $("#VariableAmount"), c = $("#gc--other-amount"), v = $(".gc--buy-form"),
                y = v.data("symbol"), k = parseFloat(v.data("currency")),
                i = "To You,\nBuy something beautiful!\nLove Me x", n = $("#gv--message"),
                l = [$("#label-email"), $("#label-cemail")], e = [], o;
            if ($(".gc--product-page").length !== 0) {
                console.log("init gift card page");
                f();
                b(l);
                u($("input[name=Amount]:checked").val());
                $(document).on("change", "#gc--delivery-method input", rt);
                $(document).on("change", "#gc--values input", f);
                $(document).on("keydown keyup", "#gv--message", nt);
                $(document).on("keyup", "#VariableAmount", tt);
                $(document).on("submit", "#add-product", ut);
                if ($("input[name=SendOption]").is(":checked") && $("#gc--delivery-method").find("input").trigger("change"), c.is(":checked") && f(), n.length !== 0) {
                    n.addClass("default").val(i);
                    $(document).on("focus blur", "#gv--message", ft)
                }
            }
            $(document).on("keydown keyup focus blur", "#PanNumber, #PinNumber", g);
            return o = {}, UNIT_TESTING && (o.populateLabelList = b, o.renderLabels = a), o
        }(), BBay.gTranslate = function () {
            var t = "google-translate", i = function () {
                console.log("google translate callback");
                new google.translate.TranslateElement({
                    pageLanguage: "en",
                    autoDisplay: !0,
                    gaTrack: !0,
                    gaId: "UA-775038-1"
                }, t)
            }, n = function () {
                if ($("#" + t).text().length === 0) {
                    console.log("inject google translate to page");
                    return $.getScript("//translate.google.com/translate_a/element.js?cb=BBay.gTranslate.cb"), !0
                }
                return !1
            };
            $.cookie("googtrans") && n();
            window.location.hash !== undefined && window.location.hash.match("googtrans") !== null && n();
            $(document).on("click", ".translate .nav-tab", n);
            return {init: n, cb: i}
        }(), function () {
            var u = "#nav-account", t = "#nav-account-menu", i = $(u), n = $(t), r = function () {
                n.addClass("is-closed").attr("aria-expanded", "false").attr("aria-hidden", "true");
                i.attr("aria-expanded", "false").blur();
                $(document).unbind("click.closeAccount keyup.closeAccount keydown.closeAccount")
            }, f = function (n) {
                (n.type === "keydown" || n.type === "click") && (n.type === "click" && $(n.target).closest(u).length === 0 || n.which === 27) && r();
                n.type === "keyup" && n.which === 9 && $(n.target).closest(t).length === 0 && r()
            }, e = function (t) {
                if (n.hasClass("is-closed")) {
                    n.removeClass("is-closed").attr("aria-expanded", "true").attr("aria-hidden", "false").focus();
                    i.attr("aria-expanded", "true");
                    t.type === "keydown" && n.find("a:first").focus();
                    $(document).on("click.closeAccount keyup.closeAccount keydown.closeAccount", f);
                    return !1
                }
                return r(), !1
            };
            i.on("click", e);
            $(t + " a").on("keydown", function (n) {
                return n.which === 40 ? ($(this).parent().next().find("a").focus(), !1) : n.which === 38 ? ($(this).parent().prev().find("a").focus(), !1) : void 0
            })
        }(), BBay.Bag = function () {
            var r = $("#nav-bag"), u = $(".js-bag-qty"), t = $("#basket-items"), n = $("#nav-bag-menu"),
                v = $("#bag-qty"), y = $("#bag-qty2"), f = !1, e, o, h = function () {
                    return window.location.pathname.match("/bag") !== null || r.hasClass("is-open") ? !0 : !1
                }, p = function () {
                    var n = $("#nav-bag").attr("href");
                    $.get(n, e)
                }, c = function () {
                    var i, r, u;
                    if (h())return !1;
                    i = parseInt(v.text(), 10);
                    r = parseInt(y.text(), 10);
                    t.text().length !== 0 && (isNaN(i) || isNaN(r) || i === r) || p();
                    f !== !1 ? u = setInterval(function () {
                        n.hasClass("is-closing") || (n.addClass("is-open"), clearInterval(u))
                    }, 100) : n.addClass("is-open");
                    $(document).on("click.closeBag keyup.closeBag keydown.closeBag", o);
                    return !1
                }, w = function (n) {
                    var t = $("#item-" + n.sku), i = "o-bag-item--new", r = 2e3;
                    c();
                    t.data("qty") === 1 ? (t.hide(), r = 3750, setTimeout(function () {
                        t.slideDown(function () {
                            t.addClass(i)
                        })
                    }, 750)) : t.addClass(i);
                    setTimeout(function () {
                        $("." + i).addClass(i + "--off")
                    }, r)
                }, l = function (n) {
                    return u.text(parseInt(n, 10)), u.first().text()
                }, i, s, a;
            e = function (n) {
                if (n !== undefined && n.html !== "")return l(n.qty), t.html(n.html), w(n), !0;
                return t.html('<div class="alert alert-error"><strong>Sorry!<\/strong> We are unable to currently display the contents of your bag.<\/div>'), !1
            };
            i = function () {
                return n.removeClass("is-open").addClass("is-closing"), $(document).off("click.closeBag keyup.closeBag keydown.closeBag", o), f = setTimeout(function () {
                    n.removeClass("is-closing");
                    f = !1
                }, 400), !1
            };
            o = function (n) {
                (n.type === "keydown" || n.type === "click") && (n.type === "click" && $(n.target).closest("#nav-bag-menu").length === 0 || n.which === 27) && i();
                n.type === "keyup" && n.which === 9 && $(n.target).closest("#nav-bag-menu").length === 0 && i()
            };
            s = function (n) {
                $.get(n, function (n) {
                    t.html(n.html);
                    u.text(n.qty)
                })
            };
            a = function () {
                var i = $(this), n = i.attr("href"), r = n.split("/").pop(), t = $("#item-" + r), u = t.data("qty");
                return u === 1 ? (t.slideUp(function () {
                    s(n)
                }), !1) : (s(n), !1)
            };
            h() && r.addClass("is-open");
            r.on("click", c);
            $("#bag-close").on("click", i);
            $(document).on("click", ".js-bag-remove", a);
            return {update: e, updateBagQty: l}
        }(), function () {
            var t = $("#brand-search-input"), n = $(".alpha-group a"), i = $("#brand-az-scrollpanel").find("h3"),
                r = $("#baz-letter-jump"), u = 40, o = 27, f = 13, s = 38, e = function () {
                    t.focus()
                }, h = function (n) {
                    console.log("keyboard access mode");
                    var i = $(".brand-list a:not(.hidden)"), t, r = i.index($(".selected"));
                    if (i.removeClass("selected"), n.keyCode === u) t = r + 1, t >= i.length && (t = 0), $(i[t]).addClass("selected").focus(); else if (n.keyCode === s) t = r - 1, t < 0 ? e() : $(i[t]).addClass("selected").focus(); else if (n.keyCode === o) i.removeClass("selected"), e(); else if (n.keyCode === f)return !0;
                    n.preventDefault()
                }, c = function (t) {
                    var o = $(this), e = o.val().toLowerCase();
                    if (n.removeClass("hidden"), i.removeClass("hidden"), $(".no-brands").hide(), e.length >= 2) {
                        i.addClass("hidden");
                        r.slideUp();
                        n.each(function () {
                            var n = $(this), t = n.text().toLowerCase();
                            t.indexOf(e) === -1 && n.addClass("hidden")
                        });
                        [u, f].indexOf(t.keyCode) !== -1 && (n.hasClass("selected") || $(".js-brand-list a:not(.hidden):first").addClass("selected"), $(".js-brand-list a.selected").focus());
                        $(".js-brand-list a:not(.hidden)").length === 0 && ($(".no-brands").show(), $(".js-brand-list .hidden").removeClass("hidden"));
                        n.on("focus keydown", h)
                    } else r.slideDown();
                    return !1
                };
            if ($("#baz-search").length === 1) t.on("keyup", c)
        }(), function () {
            var n = $("#brand-az-scrollpanel"), t = function (t) {
                n.scrollTo("#baz-search", 250);
                t.preventDefault()
            }, i = function (t) {
                n.scrollTo($(this).attr("href"), 250);
                t.preventDefault()
            };
            $(".js-baz-top").on("click", t);
            $("#baz-letter-jump").find("a").on("click", i)
        }(), function () {
            var n = "#nav-shop-menu", l = $("#nav-shop"), t = $(n), u = 13, a = 27, v = 37, y = 39, f = 32, p = 9,
                i = function (n) {
                    var t = null;
                    n.type === "mousewheel" ? t = n.originalEvent.wheelDelta * -1 : n.type === "DOMMouseScroll" && (t = 40 * n.originalEvent.detail);
                    t && (n.preventDefault(), $(this).scrollTop(t + $(this).scrollTop()))
                }, e = $("#l1scroll"), o = ".o-menu--sub-container.is-open-sub .js-menu-scroll";
            e.on("mousewheel DOMMouseScroll", i);
            $("#nav-bag-menu .js-menu-scroll").on("mousewheel DOMMouseScroll", i);
            $(document).on("mouseover", o, function () {
                e.off("mousewheel DOMMouseScroll");
                $(document).on("mousewheel.l2 DOMMouseScroll.l2", o, i)
            });
            $(document).on("mouseout", o, function () {
                e.on("mousewheel DOMMouseScroll", i);
                $(document).off("mousewheel.l2 DOMMouseScroll.l2")
            });
            var w = $("#shop-close, #l1scroll > ul > li > a"), s = function (n) {
                w.attr("tabindex", n)
            }, h = function (n) {
                var t = $(".is-open-sub .js-menu-scroll a, .is-open-sub .js-close-sub, .is-open-sub #brand-search-input");
                t.attr("tabindex", n)
            }, c = function () {
                var n = $(".o-menu--sub [tabindex=0]");
                n.length > 0 && n.attr("tabindex", -1)
            }, r = function () {
                return $(".is-open-sub").removeClass("is-open-sub"), t.removeClass("is-open o-menu--sub-block"), $("#l1scroll").scrollTop(0), s(-1), c(), $(document).off("click.closeShop keyup.closeShop keydown.closeShop"), !1
            }, b = function (t) {
                (t.type === "keydown" || t.type === "click") && (t.type === "click" && $(t.target).closest(n).length === 0 && r(), t.which === a && (r(), l.focus()));
                t.type === "keyup" && t.which === p && $(t.target).closest(n).length === 0 && r()
            }, k = function (n) {
                return n.which === 40 ? ($(this).parent().next().find("a").focus(), !1) : n.which === 38 ? ($(this).parent().prev().find("a").focus(), !1) : void 0
            }, d = function (n) {
                if (n.type === "click" || n.type === "keydown" && [u, f, y].indexOf(n.which) !== -1) {
                    var t = $(this);
                    return $("#l1scroll").removeClass("native"), c(), setTimeout(function () {
                        $(".is-open-sub").removeClass("is-open-sub").find(".o-menu__scroll").scrollTop(0);
                        t.parent().addClass("is-open-sub opened");
                        n.type === "keydown" && h(0)
                    }, 50), !1
                }
            }, g = function (n) {
                if (n.type === "click" || [u, f, v].indexOf(n.which) !== -1)return n.type === "keydown" && h(-1), $(".is-open-sub .o-menu__scroll").scrollTop(0), $(this).parent().parent().removeClass("is-open-sub").focus(), !1
            }, nt = function (n) {
                if (n.type === "click" || n.type === "keydown" && [u, f].indexOf(n.which) !== -1) {
                    t.addClass("is-open").focus();
                    n.type === "keydown" && s(0);
                    setTimeout(function () {
                        t.addClass("o-menu--sub-block")
                    }, 500);
                    $(document).on("click.closeShop keyup.closeShop keydown.closeShop", b);
                    return !1
                }
            }, tt = function () {
                var t = $(this), n = t.attr("href");
                return $("body").scrollTo(n, 250), $(n).focus(), !1
            };
            $("#header").removeClass("js-loading");
            $($(":focus")[0]).attr("id") === "nav-shop" && (t.addClass("is-open"), $(".js-sub-container:hover").addClass("is-open-sub"));
            $(".js-menu-sub").on("click keydown", d);
            $(".js-close-sub").on("click keydown", g);
            $("#nav-shop").on("click keydown", nt);
            $("#shop-close").on("click", r);
            $(n + " a").on("keydown", k);
            $(".c-skip").on("click", tt)
        }(), $("#home-content").length !== 0) {
        $(document).on("focus", ".js-secondary", function () {
            $(this).closest(".c-product").addClass("is-focus")
        });
        $(document).on("blur", ".js-secondary", function () {
            $(this).closest(".c-product").removeClass("is-focus")
        });
        $(document).on("mouseover", ".c-product", function () {
            var t = $(this).find(".js-hover"), n = t.next(), i = n.data("src");
            n.attr("src", i);
            n.on("load", function () {
                t.css({opacity: 0})
            })
        }).on("mouseout", ".c-product", function () {
            var n = $(this).find(".js-hover");
            n.css({opacity: 1})
        })
    }
    $(document).on("blur", "input[name=Email]", function () {
        if (typeof Kicksend != "undefined") {
            var n = $(this);
            n.mailcheck({
                suggested: function (t, i) {
                    var r = $("<div/>", {
                        "class": "error suggest-email",
                        "for": "Email",
                        html: "Did you mean <span>" + i.address + "@<strong>" + i.domain + "<\/strong><\/span>?",
                        id: "suggest-email"
                    });
                    $("#suggest-email").remove();
                    n.after(r);
                    $(document).one("click", "#suggest-email", function () {
                        n.val(i.full);
                        $("#suggest-email").remove()
                    })
                }, empty: function () {
                    $("#suggest-email").remove()
                }
            })
        }
    });
    BBay.lazyLoadImage = function () {
        function n() {
            $(this).load(function () {
                this.style.opacity = 1
            })
        }

        function t() {
            var n = $(this);
            n.load(function () {
                n.parent().addClass("lzyloaded")
            })
        }

        return init = function () {
            $(".img-lz").unveil(400, n);
            $(".js-lzy").find("img").unveil(400, t)
        }, init(), {init: init}
    }();
    BBay.ProductGrid = function () {
        var n;
        $(document).on("click", ".facet-option.disabled", function () {
            return !1
        });
        $(document).on("click", ".facet-option", function () {
            if ($(this).attr("id") === "facet-refine" && ($(".refining-list").removeAttr("style").css("height", $(document).height()), $(this).hasClass("selected")))return $("#facet-refine-close").trigger("click"), !0;
            $(".facet-option").removeClass("selected");
            n !== $(this).attr("id") ? (n = $(this).attr("id"), $(this).addClass("selected")) : n = ""
        });
        $(document).on("click", "#facet-refine-close", function (t) {
            $("#facet-refine").removeClass("selected");
            $("#filter-container").show();
            $("#filter-selected").hide();
            n = "";
            t.stopPropagation();
            t.preventDefault()
        });
        $(document).on("click", ".js-dropdown-trigger", function (n) {
            console.log("click .js-dropdown-trigger");
            var t = $(this).parent();
            t.toggleClass("selected");
            n.preventDefault()
        })
    }();
    BBay.Modal = function () {
        var t, n = [], i, e = $(document), s = 27, r = !1, u = !1, f = function (r) {
            (r.which === s || r.type === "click") && (t.removeClass("has-modal"), n.blur(), i.off("click"), e.off("keydown.dialog"))
        }, h = function (n) {
            $(n.target).closest("#dialog-container").length === 0 && f(n)
        }, c = function () {
            t = $("body");
            n = $("#dialog");
            i = $("#dialog-close")
        }, o = function () {
            n.length === 0 && c();
            t.addClass("has-modal");
            n.focus();
            n.on("click", h);
            i.on("click", f);
            e.on("keydown.dialog", f);
            return !1
        }, l = function () {
            n.remove();
            n = []
        }, a = function (t, i) {
            return r ? !1 : (n.length === 1 && t !== u && l(), n.length === 0 || u !== t) ? (r = !0, $.get(t, function (n) {
                $("body").append(n);
                u = t;
                r = !1;
                i();
                o()
            }), !1) : (i(), o(), !1)
        };
        return {open: a}
    }();
    BBay.Basket = function () {
        function u(n) {
            var t = $("#basket-table");
            $.post(t.attr("action"), t.serialize(), r);
            n.preventDefault()
        }

        function f() {
            var n = $(this).attr("href");
            return $.get(n, r), !1
        }

        function e() {
            var t = $("#selected-premier-img"), i = $(this).find(":selected").data("image");
            i ? t.css("display", "block") : t.css("display", "none");
            t.attr("src", i);
            n = $(this).val();
            $("#premier-error").remove()
        }

        function i(n) {
            var t = $("#premier-select");
            return t.val(n).trigger("change"), (n === null || n === "nothankyou" || t.find("option[value=" + n + "]").length === 0) && t.prop("selectedIndex", 0), t.val()
        }

        function r(t) {
            console.log("My Bag: update");
            $("#basket-update").html(t.html);
            BBay.Bag.updateBagQty(t.totalBasketItems);
            BBay.initValidation("#basket-table");
            BBay.pageForms["#basket-table"].resetForm();
            i(n)
        }

        var n, t;
        if ($("body#bag-page").length) {
            $(document).on("change", "#premier-select", e);
            $(document).on("change", ".js-basket-select", u);
            $(document).on("click", ".js-basket-remove, .js-basket-undo", f);
            n = $("#premier-select").val()
        }
        return t = {}, UNIT_TESTING && (t.selectCorrectPremierItem = i), t
    }(), function () {
        function n(n) {
            function r(n) {
                t.find(".error").length ? t.find(".error").html(n) : t.find("fieldset").append('<p class="error">' + n + "<\/p>")
            }

            n.preventDefault();
            var t = $("#signup-email"), i = $("#emailscription").val();
            return t.valid() && (i.length ? $.getJSON("/subscription/?email=" + i, function (n) {
                if (n.EmailValid) t.html('<div class="alert alert-success">Your email address has been successfully submitted. Look out for the next Beauty Bay Bulletin with offers, news and much more.<\/div>'); else r("Please enter a valid email address.")
            }) : r("Please enter a valid email address.")), !1
        }

        $(document).on("keyup", "#emailscription", function (t) {
            if (t.keyCode === 13)return n(t)
        });
        $(document).on("click", ".newsLetterSignup", function (t) {
            return n(t)
        })
    }();
    BBay.Payment = function () {
        "use strict";
        var i, r = !1, n, l = function () {
            $.ajax({
                url: "/api/payment/clienttoken", method: "GET", success: function (t) {
                    n = t.clientToken
                }
            })
        }, f = function () {
            $.ajax({
                url: "/api/payment/clienttoken", method: "GET", success: function (t) {
                    n = t.clientToken;
                    u();
                    c()
                }
            })
        }, y = function (i) {
            braintree.setup(n, "dropin", {
                container: "dropin-container",
                form: "braintree-checkout-form",
                onPaymentMethodReceived: function (r) {
                    r.type === "PayPalAccount" ? t(r.nonce) : s(r.nonce, n, i)
                },
                onReady: e,
                onError: o
            })
        }, a = function (i) {
            if ($(".hosted-paypal").length) {
                var r = i.address;
                braintree.setup(n, "custom", {
                    paypal: {container: "hosted-paypal"},
                    onPaymentMethodReceived: function (n) {
                        t(n.nonce)
                    }
                })
            }
        }, v = function (i) {
            braintree.setup(n, "custom", {
                id: "braintree-checkout-form", hostedFields: {
                    onFieldEvent: function (n) {
                        if (n.type === "fieldStateChange") {
                            var t = $(".credit-cards li");
                            n.card !== null ? (console.log(n.card.type), t.removeClass("fade"), $(".credit-cards li:not(.paypal, .radio, ." + n.card.type + ")").addClass("fade")) : t.removeClass("fade")
                        }
                    },
                    styles: {
                        input: {"font-size": "18px", "line-height": "51px", "font-family": "sans-serif"},
                        ":focus": {},
                        ".valid": {color: "#2f993e"},
                        ".invalid": {color: "#c00"}
                    },
                    number: {selector: "#hosted-number", placeholder: "•••• •••• •••• ••••"},
                    expirationDate: {selector: "#hosted-date", placeholder: "MMYY"},
                    cvv: {selector: "#hosted-cvv", placeholder: "•••"}
                }, onPaymentMethodReceived: function (r) {
                    r.type === "PayPalAccount" ? t(r.nonce) : s(r.nonce, n, i)
                }, onReady: e, onError: o
            })
        }, e = function (n) {
            i = n;
            $("[data-braintree-submit]").attr("disabled", !1);
            $("[data-braintree-checkout-form]").on("submit", function () {
                console.log("form submitted");
                $("[data-braintree-submit]").attr("disabled", !0).addClass("loading")
            })
        }, o = function (n) {
            console.log(n);
            $("[data-braintree-submit]").attr("disabled", !1).removeClass("loading")
        }, u = function () {
            typeof braintree != "undefined" && $(".card-information").length ? (i = null, $.ajax({
                url: "/checkout/getorderdetails",
                method: "GET",
                success: function (n) {
                    $("[data-threedsecure-message]").addClass("hidden");
                    v(n.totalOrderValue);
                    a(n)
                },
                error: function (n) {
                    console.log(n)
                }
            })) : $("[data-braintree-submit]").attr("disabled", !1)
        }, s = function (n, i, u) {
            var f = new braintree.api.Client({clientToken: i});
            r = !1;
            f.verify3DS({amount: u, creditCard: n, onUserClose: h}, function (n, i) {
                console.log(n);
                console.log(i);
                console.log(i.verificationDetails);
                n || i.verificationDetails.liabilityShifted !== i.verificationDetails.liabilityShiftPossible ? ($("[data-threedsecure-message]").text("Payment card added security protection has failed, please try again.").removeClass("hidden"), $("[data-braintree-submit]").attr("disabled", !1).removeClass("loading")) : t(i.nonce)
            })
        }, t = function (n) {
            $("[data-braintree-nonce]").val(n);
            $("[data-braintree-checkout-form]").submit()
        }, h = function () {
            r || ($("[data-braintree-submit]").attr("disabled", !1).removeClass("loading"), r = !0, i.teardown(u))
        }, c = function () {
            $("[data-payment-form]").removeClass("hidden");
            $("[data-card-holder]").removeClass("hidden")
        };
        return $("#hasAuthfailed").length !== 0 && f(), typeof braintree != "undefined" && l(), $(document).ready(function () {
            var n = $("#" + window.location.hash.substring(2));
            n.selector === "#payment" && f()
        }), {display: c, load: u, teardown: h}
    }();
    BBay.ProductGallery = function () {
        var n = 0, i = function (t) {
            if ($("#react-product-page").length > 0)return !1;
            var r = $("#product-gallery"), i = t.Gallery, u = "", f = "contentful";
            i && (i[0].IsVideo || $("#selected-image").attr("href", i[0].Large).find("img").attr("src", i[0].Large), i.length > 1 ? ($.each(i, function (n) {
                var t = $(this)[0], i = "", r = t.Large, e = t.Medium, o = t.Thumbnail;
                t.IsVideo && (i = ' class="video-thumb"', r = t.VideoUrl, e = t.VideoEmbed, f = "");
                u += '<li><a class="' + f + '" href="' + r + '" data-pos="' + n + '" data-src="' + e + '"' + i + '><img src="' + o + '" width="70" height="70"><\/a><\/li>\n'
            }), r.html(u), r.find("a[data-pos=" + n + "]").addClass("selected").trigger("click")) : r.empty())
        }, t = function () {
            var s, h;
            if ($("#react-product-page").length > 0)return !1;
            var r = $("#selected-image"), u = $("#selected-video"), f = $(".js-media"), i = $(this), e = $(".zoom"),
                t = {}, o = "image-container__inner--video";
            return $("#product-gallery").find("a").removeClass("selected"), i.addClass("selected"), e.fadeIn(), s = i.hasClass("contentful"), t.large = i.attr("href"), t.medium = i.data("src"), n = i.data("pos"), u.length && u.remove(), t.large.match(/productimage/) || s ? (r.attr("href", t.large).find("img").attr("src", t.large), r.show(), f.removeClass(o)) : (h = $("<iframe/>", {
                "class": "iframe-video",
                id: "selected-video",
                src: t.medium,
                allowfullscreen: "allowfullscreen"
            }), f.addClass(o), r.hide().after(h), e.fadeOut()), !1
        };
        $("#react-product-page").length === 0 && $("#product-gallery").find("a:first").addClass("selected");
        $(document).on("click", "#product-gallery a", t);
        return {enable: t, render: i}
    }(), function () {
        function n() {
            var n = $(this), t = n.data("sku");
            return $("#react-product-page").length > 0 ? !1 : ($("#group-sku").val(t).trigger("change"), !1)
        }

        $(document).on("click", "#product-page .swatch-list img", n)
    }(), function (n) {
        var t = {
            init: function (i) {
                var r = n.extend({
                    currentPage: 1,
                    itemsOnPage: 5,
                    prevText: "Prev",
                    nextText: "Next",
                    pagerClass: "pagination",
                    selectedClass: "current"
                }, i || {}), u = this;
                return r.numberOfPages = Math.ceil(u.length / r.itemsOnPage), u.data("pager", r), r.numberOfPages > 1 && t._render.call(u), u.length !== 0 && this.pagination("selectPage", 1), this
            }, selectPage: function (n) {
                var t = this.data("pager");
                return t.currentPage = (n - 1) * t.itemsOnPage, this.hide(), this.slice(t.currentPage, t.currentPage + t.itemsOnPage).show(), this
            }, _render: function () {
                var i = this.data("pager"), h = n("<ul/>", {"class": "clearfix " + i.pagerClass}), r, s;
                n("." + i.pagerClass).length === 0 && (n(this.selector + ":last").after(h), t._events.call(this));
                var f = '<li class="prev js-prev">' + i.prevText + "<\/li>", e = 5, u = i.currentPage + e,
                    o = i.currentPage - e;
                for (o <= 1 && (o = 1), i.currentPage <= e && (u = 11), u > i.numberOfPages && (u = i.numberOfPages), i.numberOfPages <= 10 && (u = i.numberOfPages), r = o; r <= u; r++)s = "", r === i.currentPage && (s = " " + i.selectedClass), f += '<li class="page js-page' + s + '" data-page="' + r + '">' + r + "<\/li>";
                return f += '<li class="next js-next">' + i.nextText + "<\/li>", n("." + i.pagerClass).html(f), this
            }, _events: function () {
                var i = this.data("pager"), r = this;
                n(document).on("click", ".js-page", function (u) {
                    i.currentPage = n(this).data("page");
                    t._render.call(r);
                    r.pagination("selectPage", i.currentPage);
                    u.preventDefault()
                });
                n(document).on("click", ".js-prev", function (u) {
                    i.currentPage !== 0 && (i.currentPage = n("." + i.selectedClass).data("page") - 1, t._render.call(r), r.pagination("selectPage", i.currentPage));
                    u.preventDefault()
                });
                n(document).on("click", ".js-next", function (u) {
                    i.currentPage < (i.numberOfPages - 1) * i.itemsOnPage && (i.currentPage = n("." + i.selectedClass).data("page") + 1, t._render.call(r), r.pagination("selectPage", i.currentPage));
                    u.preventDefault()
                });
                return this
            }
        };
        n.fn.pagination = function (i) {
            if (t[i] && i.charAt(0) !== "_")return t[i].apply(this, Array.prototype.slice.call(arguments, 1));
            if (typeof i != "object" && i) n.error("Method " + i + " does not exist on pagination object"); else return t.init.apply(this, arguments)
        }
    }(jQuery);
    BBay.ProductPageGroup = function () {
        "use strict";
        return {
            init: function () {
                this.cacheElements()
            }, cacheElements: function () {
                this.$sellPrice = $("#product-sell-price");
                this.$countryRestriction = $("#product-country-restriction");
                this.$productThumbnailImage = $("#product-thumbnail-image");
                this.$productSmallImage = $("#product-small-image");
                this.$productTitle = $("#product-title");
                this.$restrictedFromAirDelivery = $("#restricted-from-air-delivery");
                this.$KeyGuid1 = $("#key-guid1");
                this.$KeyGuid2 = $("#key-guid2");
                this.$maxPerCustomer = $("#maximum-qty")
            }, mapItemsToForm: function (n) {
                var t = "", i = "", r = "", u = "", f = "", h = "", e = "", o = "", s = "";
                typeof n != "undefined" && (t = n.ProductDetail.sellPrice, i = n.ProductDetail.countryRestriction, r = n.ProductDetail.productThumbnailImage, u = n.ProductDetail.productSmallImage, f = n.ProductDetail.FullTitle, h = n.ProductDetail.restrictedFromAirDelivery, e = n.KeyGuid1, o = n.KeyGuid2, s = n.ProductDetail.MaxPerCustomer);
                this.$sellPrice.val(t);
                this.$countryRestriction.val(i);
                this.$productThumbnailImage.val(r);
                this.$productSmallImage.val(u);
                this.$productTitle.val(f);
                this.$KeyGuid1.val(e);
                this.$KeyGuid2.val(o);
                this.$maxPerCustomer.val(s)
            }
        }
    }(), function () {
        var n, i = !1, r;
        $(".review-container").pagination({prevText: "<<", nextText: ">>"});
        r = function () {
            return $(this).closest("#react-product-page").length > 0 ? (console.log("Disabled jquery social icon click"), !1) : (window.open($(this).attr("href"), "", "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600"), !1)
        };
        $("#social-media").find("a").on("click", r);
        var f = function (n, t) {
            console.log("track item added to bag: " + n);
            t === !0 ? dataLayer.push({
                event: "Quick Buy",
                eventAction: "Quick Buy",
                eventCategory: "Results Grid",
                eventLabel: n
            }) : dataLayer.push({
                event: "Add to Bag",
                eventAction: "Add to Bag",
                eventCategory: "Product Page",
                eventLabel: n
            })
        }, t = !1, u = function (n) {
            var i = $(n.currentTarget), e = i.attr("href"), r = {}, o, u, s = !1;
            return i.closest("#react-product-page").length > 0 ? (console.log("Disabled jquery add to bag"), !1) : t !== !1 ? !1 : (e !== undefined ? (r.Sku = e.split("/")[3], o = e, u = i, s = !0) : (r = i.serializeObject(), o = i.attr("action"), u = i.find("input[type=submit]")), r.Sku !== "" && r.Sku !== undefined ? (u.addClass("loading"), t = $.ajax({
                data: r,
                type: i.attr("method"),
                url: o
            }).done(function (n) {
                if (u.removeClass("loading"), t = !1, n === !1) alert("Item is out of stock"); else {
                    if (n.errors) {
                        var i = "<li>";
                        return $("#submission-errors").length === 0 && $("<ul/>", {
                            "class": "submission-errors",
                            id: "submission-errors"
                        }).insertAfter(".js-errors-after"), i += n.errors.join("<\/li><li>"), $("#submission-errors").html(i + "<\/li>"), !1
                    }
                    n.StockAlert === !0 && alert(n.StockMessage);
                    f(n.sku, s);
                    BBay.Bag.update(n)
                }
            })) : alert("Please select from the product options before adding to the bag."), n.preventDefault(), !1)
        }, e = function (n) {
            var t = "", i = "";
            n.ProductDetail.InStock ? (t += "in-stock", i += "In Stock") : n.ProductDetail.AvailableForBackOrder ? (t += "back-order", i += n.ProductDetail.LeadTime + " days") : n.ProductDetail.ProductCode !== "" && (t += "no-stock", i += "Out of Stock");
            n.ProductDetail.IsLowStock && (t = "last-few", i = "Last Few Remaining");
            $("#availability").attr("class", "product-availability").addClass(t);
            $("#availability").html(i)
        }, o = function (n) {
            if (console.log("render item badges", n), $("#badge-new, #badge-sale, #badge-low, #badge-reduced").addClass("hidden").removeClass("invisible"), n.ProductDetail.IsNewProduct && $("#badge-new").fadeIn(), n.ProductDetail.IsOnSale && $("#badge-sale").fadeIn(), n.ProductDetail.IsLowStock && $("#badge-low").fadeIn(), n.ProductDetail.IsReduced && $("#badge-reduced").fadeIn(), n.ProductDetail.StickerMessage !== "") {
                var t = '<div class="sticker-message">' + n.ProductDetail.StickerMessage + "<\/div>";
                $(".sticker-message-container").html(t)
            } else $(".sticker-message-container").html("")
        }, s = function (n) {
            console.log("render product offers");
            var t = $("#availability");
            return ($(".c-offer").remove(), typeof n.Offers != "undefined") ? (t.after(n.Offers), !0) : !1
        }, l = function () {
            var t;
            if (console.log("lazy load content"), t = $(".js-injection:first"), t.length) {
                var n = t, i = n.data("brand"), r = n.data("group"), u = n.data("product"), f = n.data("sku"),
                    e = n.data("url");
                $.get(e + i + "/" + u + "/" + r + "/" + f, function (n) {
                    $("#yml-container").html(n.ymlhtml);
                    $("#recent-items").html(n.recentlyviewedhtml);
                    var t = $(".js-recent-items"), r = t.find("a").length, i = t.find("a").outerWidth();
                    t.css({width: r * i + i + "px"})
                })
            }
        }, h = function () {
            var i = $("#group-selection"), t = $("#group-sku");
            return $("#react-product-page").length > 0 ? !1 : (n !== t.val() && ($(".badge").fadeOut(), $("#selected-video").hide(), n = t.val(), $("#sku, #review-sku").val(n), t.addClass("loading"), console.log("_groupSelectChange Selected SKU: " + n), $.ajax({
                data: i.serializeObject(),
                type: i.attr("method"),
                url: i.attr("action")
            }).done(function (i) {
                t.removeClass("loading");
                typeof i == "object" && (BBay.ProductPageGroup.mapItemsToForm(i), n !== "" && (e(i), o(i), $(".js-price").text(i.Price), $(".js-was-price").text(i.WasPrice), $("#delivery-msg").text(i.DeliveryMessage)), s(i), BBay.ProductGallery.render(i))
            })), !1)
        }, c = function () {
            if (!i) {
                console.log("initalising product page");
                i = !0;
                BBay.ProductPageGroup.init();
                $("#selected-image .img-lz").trigger("unveil");
                $("#group-sku").on("change", h);
                $("#selected-image").on("click", function () {
                    return console.log("prevent link from opening"), !1
                });
                if ($("#group-sku").val() !== "") {
                    console.log("render gallery when sku selected");
                    var n = $("#group-selection");
                    console.log("render gallery action", n.attr("action"));
                    $.ajax({
                        data: n.serializeObject(),
                        type: n.attr("method"),
                        url: n.attr("action")
                    }).done(function (n) {
                        BBay.ProductGallery.render(n)
                    })
                }
                $("#tracked-accordion dt a").on("click", function () {
                    var t = $(this), n = $(this).text();
                    t.parent().hasClass("open") && (console.log("track accordion open: " + n), dataLayer.push({
                        event: "Accordion Opened",
                        eventAction: "Accordion Opened",
                        eventCategory: "Product Page",
                        eventLabel: n
                    }))
                });
                $("#add-product-review").on("submit", function () {
                    console.log("track review submission: " + $("#review-sku").val());
                    dataLayer.push({
                        event: "Submit Review",
                        eventAction: "Submit Review",
                        eventCategory: "Product Page",
                        eventLabel: $("#review-sku").val()
                    })
                });
                $("#ymal").find("a").on("click", function () {
                    console.log("track YMAL: " + $(this).find(".item-product").text());
                    dataLayer.push({
                        event: "You May Also Like",
                        eventAction: "You May Also Like",
                        eventCategory: "Product Page",
                        eventLabel: $(this).find(".item-product").text()
                    })
                });
                $(document).on("click", ".add-product-wishlist .checkbox:not(.disabled)", function () {
                    console.log("track wishlist: " + $(".wishlist-sku").val());
                    dataLayer.push({
                        event: "Add To Wish List",
                        eventAction: "Add To Wish List",
                        eventCategory: "Product Page",
                        eventLabel: $(".wishlist-sku").val()
                    })
                })
            }
        };
        $("#product-page").length !== 0 && $("#react-product-page").length === 0 && c();
        $(document).on("click", ".js-quick-buy", u);
        $(document).on("submit", "#add-product", u)
    }(), function () {
        var n = function () {
            return (console.log("Address Book: Delete"), confirm($(this).data("confirm"))) ? !0 : !1
        };
        $(document).on("click", ".js-deleteaddress", n)
    }(), function () {
        var n;
        $(document).on("click", "#profile-menu", function () {
            var n = $(this);
            n.parent().toggleClass("open")
        });
        $(document).on("click", ".profile-menu a", function () {
            var t = $(this);
            t.addClass("throbber");
            n = setInterval(function () {
                t.hasClass("throbber") || ($(".profile-menu").removeClass("open"), clearInterval(n))
            }, 100)
        })
    }();
    $(document).on("click", "#promo-msg-close", function (n) {
        var t = $(this).parent();
        return t.slideUp(), $.cookie("promotional-message", "closed", {expires: 30, path: "/"}), n.preventDefault(), !1
    });
    BBay.Pudo = function () {
        var s = $("#geolocate"), r = $("#pudo-search"), u = $("#location"), h = $("#map-container"),
            l = $("#pudo-container"), n, t, a = "", b = 5e3, f, e, i = [], o = [], v, k = function () {
                console.log("Google map loaded");
                l.removeClass("hidden");
                $("#pudo-loader").removeClass("loading");
                $("#addressComplete").val("");
                clearInterval(f)
            }, d = function () {
                var t, n, r, u, f;
                if (e !== undefined) {
                    for (t = new google.maps.LatLngBounds, n = 0; n < i.length; n++)r = new google.maps.LatLng(i[n][1], i[n][2]), t.extend(r), u = String.fromCharCode("A".charCodeAt(0) + n), f = new google.maps.Marker({
                        position: r,
                        icon: "//maps.google.com/mapfiles/marker" + u + ".png",
                        map: e,
                        title: i[n][0],
                        animation: google.maps.Animation.DROP
                    }), o.push(f), e.fitBounds(t);
                    return !0
                }
                return !1
            }, g = function () {
                for (var n = 0; n < o.length; n++)o[n].setMap(null);
                o = [];
                i = []
            }, nt = function () {
                var i = {center: {lat: n, lng: t}, zoom: 12, scrollwheel: !1, mapTypeControl: !1};
                e = new google.maps.Map(document.getElementById("map-canvas"), i);
                d()
            }, tt = function () {
                var r = "//maps.googleapis.com/maps/api/staticmap?", u = h.width(), e = Math.round(u / 2), f;
                r += "size=" + u + "x" + e + "&";
                r += "center=" + n + "," + t + "&markers=" + n + "," + t;
                $.each(i, function (n, t) {
                    var i = String.fromCharCode("A".charCodeAt(0) + n);
                    r += "&markers=label:" + i + "|" + t[1] + "," + t[2]
                });
                f = $("<img/>", {src: r, "class": "static-map"});
                $("#map-canvas").html(f).removeAttr("style")
            }, it = function () {
                var n = !1;
                if (typeof window.matchMedia != "undefined" && (n = window.matchMedia("(max-width: 640px)")), n.matches)return tt(), !0;
                nt()
            }, rt = function (n) {
                console.log(n);
                v = n.data;
                g();
                var t = "";
                n.data.length !== 0 ? (t += '<ol class="group-list chk--pudo-shops" id="chk--pudo-shops">', $.each(n.data, function (n, r) {
                    var u = "";
                    n === 0 && (u = " checked");
                    t += '<li><input type="radio" name="BillingDeliveryAddress.ShopId" value="' + r.parcelShopNumber + '" id="shop' + r.parcelShopNumber + '"' + u + '><label for="shop' + r.parcelShopNumber + '"><div class="shop">' + r.description + "<\/div><address>" + r.address.street + "<br>" + r.address.city + ", " + r.address.postCode + '<\/address><div class="distance">' + (r.dist * .00062137).toFixed(2) + " Miles<\/div><\/label><\/li>";
                    i.push([r.description, r.lat, r.lng])
                }), t += "<\/ol>", $("#address-submit").removeAttr("disabled")) : t += '<p class="alert alert-error">No collection points available in this area.<\/p>';
                r.removeClass("loading");
                s.removeClass("loading");
                h.removeClass("hidden");
                $("html, body").animate({scrollTop: h.offset().top}, 500);
                $("#shop-options").html(t);
                $("#chk--pudo-shops").find("input:checked").trigger("change");
                clearInterval(f);
                it()
            }, ut = function () {
                var n = $("#chk--delivery-address");
                return n.next().hasClass("error") || n.after('<p class="content error" id="pudo-error">Oh no. There was a problem loading our Collection service. Would you mind trying again soon?<\/p>'), l.addClass("hidden"), r.removeClass("loading"), s.removeClass("loading"), $("#pudo-loader").removeClass("loading"), dataLayer.push({
                    event: "PUDO",
                    eventAction: "API Timeout: " + a,
                    eventCategory: "Checkout"
                }), !1
            }, c = function (n) {
                f = setTimeout(ut, b);
                a = n
            }, ft = function () {
                c("findParcelShopsByLocation");
                return $.ajax({
                    data: {lat: n, lng: t},
                    type: "get",
                    url: "/checkout/findParcelShopsByLocation"
                }).done(function (n) {
                    var t = {};
                    t.data = $.parseJSON(n);
                    BBay.Pudo.renderShops(t)
                })
            }, et = function () {
                var n = $(this).val();
                $.each(v, function (t, i) {
                    if (i.parcelShopNumber === parseInt(n, 10))return $("address.delivery").text(i.description + ", " + i.address.street + ", " + i.address.city + ", " + i.address.postCode), $("#pudo-name").val(i.description), $("#pudo-street").val(i.address.street), $("#pudo-city").val(i.address.city), $("#pudo-postcode").val(i.address.postCode), $("#addressComplete").val(!0), !0
                })
            }, y = function (i, r) {
                var o = new google.maps.Geocoder, e = {address: i};
                return i.match(/^(\-?\d+(\.\d+)?),\s*(\-?\d+(\.\d+)?)$/) === null && (e.componentRestrictions = {country: "GB"}), c("google.geocoder"), o.geocode(e, function (i, e) {
                    if (e === google.maps.GeocoderStatus.OK) {
                        if (console.log(i), n = i[0].geometry.location.lat(), t = i[0].geometry.location.lng(), r) {
                            var s = i[0].formatted_address, o = s.match(/[A-Z]{1,2}[0-9][0-9A-Z]?\s?[0-9][A-Z]{2}/g);
                            o = o === null ? s : o[0];
                            u.val(o)
                        }
                        clearInterval(f);
                        ft()
                    } else alert("Geocode was not successful for the following reason: " + e)
                }), !1
            }, ot = function (i) {
                if (Modernizr.geolocation) {
                    var f = $(this);
                    f.addClass("loading");
                    navigator.geolocation.getCurrentPosition(function (i) {
                        n = i.coords.latitude;
                        t = i.coords.longitude;
                        y(n + "," + t, !0)
                    }, function (n) {
                        console.log(n);
                        switch (n.code) {
                            case 1:
                                alert("You have blocked our location request. Please enter a postcode to continue.");
                                break;
                            case 2:
                                alert("Your location is unavailable at this time. Please enter a postcode to continue.");
                                break;
                            default:
                                alert("We did not receive your location. Please enter a postcode to continue.")
                        }
                        s.removeClass("loading");
                        r.removeClass("loading");
                        u.removeAttr("placeholder").focus()
                    })
                }
                return i.preventDefault(), !1
            }, p = function (n) {
                if (n.type === "keydown" && n.keyCode === 13 || n.type === "click") {
                    if (u.val() === "")return !1;
                    r.addClass("loading");
                    y(u.val(), !1);
                    n.preventDefault()
                }
            }, st = function (n) {
                var t = $(this);
                t.text().match(/hide/i) !== null ? t.text("Show Map") : t.text("Hide Map");
                $("#map-canvas").toggleClass("hidden");
                n.preventDefault()
            }, w = function () {
                var n = document.createElement("script");
                n.src = "//maps.googleapis.com/maps/api/js?callback=BBay.Pudo.gMapLoaded";
                document.body.appendChild(n);
                c("maps.googleapis");
                $("#shop-options").is(":empty") && $("#address-submit").attr("disabled", "disabled");
                $("#geolocate").on("click", ot);
                $("#pudo-search").on("click", p);
                $("#toggle-map").on("click", st);
                $("#location").on("keydown", p);
                $(document).on("change", "#chk--pudo-shops input", et)
            };
        return $("body#checkout").length && parseInt($("#chk--delivery-address").find("input:checked").val(), 10) === 2 && ($("#pudo-loader").addClass("loading"), w()), {
            initPUDO: w,
            gMapLoaded: k,
            renderShops: rt
        }
    }();
    BBay.RegionSettings = function () {
        var n = "Currency cannot be changed when shipping to ${country}", t = function (n) {
            var t = $(n.currentTarget).find(":selected");
            return t.data("lock-currency") === undefined ? !1 : t.text()
        }, i = function (i) {
            var r = $("#region-setting-currency"), e = "region-locked-msg", u = $("#" + e), o = t(i), f;
            if (o !== !1) {
                r.addClass("hidden");
                f = n.replace(/\${.*}/, o);
                u.length === 0 ? r.after('<small id="' + e + '" class="c-region-settings__lock-msg u-serif">' + f + "<\/small>") : u.text(f);
                return
            }
            r.removeClass("hidden");
            u.remove()
        }, r = function () {
            var n = $(this);
            return n.addClass("loading"), BBay.Modal.open(n.attr("href"), BBay.RegionSettings.init), !1
        }, u = function () {
            $("#region-delivery").trigger("change");
            BBay.gTranslate.init();
            $(".loading").removeClass("loading")
        };
        $(document).on("click", ".js-region-settings", r);
        $(document).on("change", "#region-delivery", i);
        return {init: u}
    }();
    BBay.saveForLater = function () {
        function n(n) {
            var t = $("#basket-update");
            t.length && $(this).closest(".o-bag-item").fadeOut(function () {
                t.html(n.html)
            });
            BBay.Bag.updateBagQty(n.totalBasketItems)
        }

        function t() {
            return $.get($(this).attr("href"), n.bind(this)), !1
        }

        $(document).on("click", ".js-save-later", t)
    }();
    BBay.Search = function () {
        function o(n) {
            return $.trim(n.replace(/\*|<|>/g, ""))
        }

        function y(n) {
            var t = new RegExp(/[A-Za-z0-9]/);
            return n === 8 || n === 46 ? !0 : t.test(String.fromCharCode(n))
        }

        var b = $("body"), k = $("#main"), i = $("#search-input"), n = $("#nav-search"), t = $("#search-page"),
            u = $("#search-results"), d = 27, s = $("#search-brands"), h = $("#results-brands"),
            c = $("#search-products"), l = $("#results-products"), g = 2, a, nt = 250, f, e = function (i) {
                if (i.which === d || i.which === 1) {
                    if (t.hasClass("is-open"))return Modernizr.history ? ($(document).off("keydown.search", e), window.history.back()) : (t.removeClass("is-open"), n.removeClass("is-open")), n.blur(), !1;
                    Modernizr.history && window.location.pathname.match("/search") === null && window.history.pushState({id: "search"}, "Beauty Bay | Search", "/search");
                    f();
                    i.preventDefault()
                }
            }, v, r;
        f = function () {
            $(document).on("keydown.search", e);
            t.addClass("is-open");
            n.addClass("is-open");
            b.scrollTop(0);
            i.focus()
        };
        Modernizr.history && window.location.pathname.match("/search") === null && window.history.replaceState({id: "page"}, null, window.location.href);
        window.location.pathname.match("/search") !== null && f();
        v = function (n) {
            var r = '<a href="{{#url}}">{{#keyword}}<\/a>',
                f = '<a href="{{#url}}" class="cf"><img src="{{#image}}" alt="" class="img"><span class="details"><span class="brand">{{#brand}}<\/span><span class="description">{{#title}}<\/span><span class="price">{{#price}}<\/span><\/span><\/a>',
                t = "", i = "";
            if (n === "")return !1;
            n.Keywords.length > 0 || n.SearchResults.length > 0 ? (u.addClass("is-open"), n.Keywords.length > 0 ? ($.map(n.Keywords, function (n) {
                i += r.replace(/{{#url}}/g, n.Url).replace(/{{#keyword}}/g, n.Title)
            }), s.show(), h.html(i)) : (s.hide(), h.empty()), n.SearchResults.length > 0 ? ($.map(n.SearchResults, function (n) {
                t += f.replace(/{{#url}}/g, n.Url).replace(/{{#image}}/g, n.Image).replace(/{{#brand}}/g, n.BrandName).replace(/{{#title}}/g, n.Title).replace(/{{#price}}/g, n.Price)
            }), c.show(), l.html(t)) : (c.hide(), l.empty())) : u.removeClass("is-open")
        };
        var p = function () {
            var n = o(i.val());
            return n.length >= g ? n : !1
        }, tt = function (n) {
            if (clearInterval(a), n.type === "keyup" && y(n.which)) {
                var t = p();
                if (t) {
                    a = setTimeout(function () {
                        var n = {query: t};
                        $.post("/typeahead/typeaheadrecordsearchgrouped", n, v)
                    }, nt);
                    return
                }
                u.removeClass("is-open")
            }
        }, it = function () {
            return p() ? (i.val(o(i.val())), !0) : !1
        }, w = !1;
        if (typeof window.matchMedia != "undefined" && (w = window.matchMedia("(min-width: 500px)")), w.matches && i.attr("placeholder", "products, brands etc."), !$("#react-search").length) {
            $(document).on("submit", "#search-form", it);
            $(document).on("click", "#nav-search", e);
            $(document).on("focus blur keyup", "#search-input", tt);
            $(document).on("click", "#search-view-all", function () {
                $("#search-form").submit()
            })
        }
        return window.onpopstate = function (i) {
            if (i.state !== null)switch (i.state.id) {
                case"search":
                    t.addClass("is-open");
                    n.addClass("is-open");
                    break;
                default:
                    window.history.replaceState({id: "page"}, null, document.location);
                    $.trim(k.text()).length === 0 ? (t.addClass("is-open"), n.addClass("is-open"), location.reload()) : (t.removeClass("is-open"), n.removeClass("is-open"))
            }
        }, r = {}, UNIT_TESTING && (r.validateInput = o, r.validRequestKey = y), r
    }();
    $(document).on("change", ".autosubmit select", function () {
        $(this).closest("form").submit()
    });
    BBay.StickyTacs = function () {
        var l = $("html").hasClass("lt-ie9"), u, t, f = !1, e, o = window.orientation, r = 0, s = "beautybay.com",
            i = !1, h = function () {
                return !i && !f && !l ? !1 : !0
            }, n = function () {
                var n = i.width();
                return {width: n, height: n * 1 + 29}
            }, c = function () {
                var f;
                if (h()) {
                    var e = $("#st_app_" + t), u = n().height, i = n().width;
                    r !== n().width + " " + n().height && (r = n().width + " " + n().height, f = "//ir.stickytacs.com/?f=6&aid=" + t + "&w=" + i + "&st=0&embeddedURL=" + s, e.css({
                        height: u,
                        width: i
                    }).html('<iframe src="' + f + '" style="border:0px; width:' + i + "px;height:" + u + 'px;overflow:hidden;" scrolling="no"><\/iframe>'))
                }
            }, a = function () {
                window.orientation !== o && (o = window.orientation, c())
            }, v = function () {
                clearInterval(e);
                e = setTimeout(function () {
                    c()
                }, 100)
            }, y = function (e) {
                var o, c;
                if (console.log("BBay.StickyTacs.init"), i = $(e.container), h() && i.length !== 0) {
                    t = e.gameid;
                    u = "embeddedStickyTacsApp_" + t;
                    o = i.find("div").last();
                    o.attr("id") === undefined && o.attr("id", "st_app_" + t);
                    c = "//ir.stickytacs.com/embedJS.php?width=" + n().width + "&height=" + n().height + "&em_url=" + s + "&aid=" + t;
                    $.getScript(c, function () {
                        window[u]();
                        r = n().width + " " + n().height;
                        f = !0
                    });
                    $(window).on("orientationchange", a);
                    $(window).on("resize", v)
                }
            };
        return {init: y}
    }(), function () {
        var t = $("#submenu-handle"), n = t.parent(), i = function () {
            return n.hasClass("is-open") ? (n.removeClass("is-open"), !1) : (n.addClass("is-open"), !0)
        };
        t.on("click", i)
    }();
    $(document).ready(function () {
        if (!Modernizr.svg) {
            var n = $(' <img class="c-beautybay-logo__png" src="//images.contentful.com/eoaaqxyywn6o/1XyP3I08vKuqMCCiuKQsYm/58384dda646e0533ab4cab2a5c47be31/bbayLogo.png" alt="Beautybay logo" />\n');
            $("a.c-beautybay-logo").addClass("c-beautybay-logo__png__container").empty().append(n)
        }
    }), function () {
        "use strict";
        var n = $(".expander"), r = $(".expander.fade"), i = n.height(), t = function () {
            var t = n.removeClass("expander").height();
            return n.addClass("expander"), {height: t}
        };
        n.addClass("expander");
        t().height < i && ($(".js-read-more").css("display", "none"), n.removeClass("fade"));
        $(document).on("click", ".js-read-more", function () {
            var i = $(".expander"), n = $(".expander.fade");
            return n.animate({"max-height": t().height + "px"}, function () {
                i.toggleClass("fade");
                n.css({"max-height": "100%"});
                $(".js-read-more").css("display", "none")
            }), !1
        })
    }(), function () {
        var n = $("body").data("abtest");
        typeof n != "undefined" && n.indexOf("/") !== -1 && (n = n.split("/"), dataLayer.push({
            splitTest: n[0],
            splitTestVariant: n[1]
        }), console.log("A/B testing enabled: splitTest=" + n[0] + " splitTestVariant=" + n[1]))
    }(), function () {
        var n = $("#usp-bar"), a = $("#usp-close"), i = $("#usp-counter"), f = "", e = 0, v = 8e3, y = 500, o, s,
            t = [], r = !1, p = function () {
                $.each(t, function (n) {
                    var t = "";
                    n === 0 && (t = ' class="is-active"');
                    t += ' id="usp-counter-' + n + '"';
                    f += "<button" + t + "><\/button>"
                });
                var n = document.getElementById("usp-counter");
                n !== null && (n.innerHTML = f)
            }, w = function (n) {
                var i = parseInt(n, 10);
                return i === t.length - 1 ? 0 : i + 1
            }, h = function () {
                n.find(".is-next").addClass("is-open").removeClass("is-next");
                n.find(".is-closing").removeClass("is-open is-closing")
            }, c = function (t) {
                clearTimeout(s);
                n.find(".is-open").addClass("is-closing");
                $("#usp-message-" + t).addClass("is-next");
                e = parseInt(t, 10);
                i.find("button").removeClass("is-active");
                $("#usp-counter-" + t).addClass("is-active");
                s = setTimeout(h, y)
            }, b = function () {
                c(parseInt($(this).attr("id").match(/\d+/), 10));
                h()
            }, u = function () {
                clearInterval(o);
                r = !1
            }, l = function () {
                r || (o = setInterval(function () {
                    c(w(e))
                }, v), r = !0)
            }, k = function () {
                Modernizr.csstransforms3d ? n.addClass("is-hidden") : n.remove()
            }, d = function () {
                return k(), u(), $.cookie("usp-bar", n.children().attr("id"), {expires: 30, path: "/"}), !1
            };
        if (n && n.length && (t = n.find(".js-message"), t.length > 1 && (p(), l())), t.length > 1) {
            n.on("mouseover", u);
            n.on("mouseout", l);
            i.on("click", "button:not(.is-active)", b);
            i.on("focus", "button", u)
        }
        a.on("click", d)
    }();
    BBay.YouTubeVideo = function () {
        var r = navigator.userAgent.match(/Android|BlackBerry|iPhone|iPad|iPod|Opera Mini|IEMobile/i), n = [], t = {},
            i = function () {
                $.map($(".video-container:not(.preload):not(.loaded)"), function (t, i) {
                    var u = $(t), r = "video" + i;
                    u.addClass("preload");
                    $("<div/>", {id: r}).appendTo(t);
                    n.push(r);
                    setTimeout(function () {
                        BBay.YouTubeVideo.embedIframe()
                    }, 500)
                })
            }, u = function () {
                typeof YT == "undefined" ? $.getScript("https://www.youtube.com/player_api") : i()
            }, f = function () {
                var n = $(this), i = n.find("iframe").attr("id"), u = t[i];
                r || u.playVideo();
                n.find(".cover").remove();
                n.removeClass("preload")
            }, e = function (n) {
                $("#" + n).parent().addClass("loaded")
            }, o = function () {
                $.map(n, function (n) {
                    typeof YT == "undefined" || $("#" + n).parent().hasClass("loaded") || (t[n] = new YT.Player(n, {
                        videoId: $("#" + n).parent().data("videoid"),
                        playerVars: {enablejsapi: 1, modestbranding: 1, rel: 0, showinfo: 0, wmode: "opaque"},
                        events: {
                            onReady: function () {
                                e(n)
                            }
                        }
                    }))
                })
            };
        $(document).on("click", ".video-container.loaded", f);
        return {embedIframe: o, init: u, initPlaceholders: i}
    }();
    $("#list").find("dt").on("click", function () {
        var n = $(this);
        n.next().slideToggle();
        n.toggleClass("open")
    });
    (function () {
        function r(n, t) {
            var i = {
                    confirmed: function (t) {
                        n.removeClass("js-confirm");
                        n.trigger("click");
                        $(".modal-container").remove();
                        t && t.preventDefault()
                    }, cancel: function (n) {
                        return $(".modal-container").remove(), n && n.preventDefault(), !1
                    }
                },
                r = '<div class="modal-container"><div class="modal"><div class="md-content"><p>' + t + '<\/p><button class="btn action confirm">Yes<\/button><button class="btn reject">No<\/button><\/div><\/div><\/div>';
            $("body").append(r);
            $(".modal").addClass("appear");
            $(document).on("click", ".confirm", i.confirmed);
            $(document).on("click", ".reject", i.cancel)
        }

        var i = 10, t = !1, n = {
            loadPage: function () {
                console.log("wishList.loadPage")
            }, createList: function (n) {
                var t, r;
                if (console.log("wishList.createList"), t = $(".list-container"), $(".js-wl-create-name").val(""), t.length) t.append(n), $("#empty-list").remove(), t.find(">li").length === 1 && $("#empty-list").length === 0 && $(".create-wishlist").length === 0 && t.after($("#create-list").html()), t.find(">li").length >= i && location.reload(); else return r = $(".wish-list .wishlist-add").attr("href"), $.get(r, function () {
                    $(".modal-container .add-item").hide();
                    $(".modal-container .confirm").show()
                }), !1
            }, updateList: function (n) {
                console.log("wishList.updateList");
                $("#wl-name").html(n.Name)
            }, deleteList: function () {
                console.log("wishList.deleteList");
                window.location = "/account/wishlist/"
            }, updateItem: function () {
                console.log("wishList.updateItem");
                var n = $(this), t = $("#wishlist-edit-item-form").html();
                n.after(t.replace(/{{sku}}/g, n.data("sku")))
            }, deleteItem: function (n) {
                console.log("wishList.deleteItem");
                $("#item-" + n).fadeOut(function () {
                    $(this).remove()
                })
            }, addItemToList: function () {
                console.log("wishList.addItemToList");
                var t = $(this).find("input");
                t.parent().addClass("disabled");
                t.attr("checked", "checked");
                t.is(":checked") && (n.ajaxFormSubmit(t.closest(".bbay-form")), t.attr("disabled", "disabled"))
            }, submitAction: function (t) {
                console.log("wishList.submitAction");
                var i = $(this);
                $(".nav-item-active").removeClass("nav-item-active");
                $("input:focus").blur();
                n.ajaxFormSubmit(i);
                t.preventDefault()
            }, ajaxFormSubmit: function (t) {
                console.log("wishList.ajaxFormSubmit");
                var i = t, r = i.serialize(), u = r.match(/wishListId=([^&]*)/);
                $("#wishlistAdded").val() != "Added" && $.ajax({
                    cache: !1,
                    data: r,
                    type: i.attr("method"),
                    url: i.attr("action")
                }).done(function (t) {
                    $("#wishlistAdded").val("Added");
                    n.actions(i.attr("action"), t)
                }).fail(function (n) {
                    console.log("request failed");
                    console.log(n)
                })
            }, getApiRequest: function (t) {
                var f;
                console.log("wishList.getApiRequest");
                var i = $(this), e = i.next(), u = i.attr("href");
                if (u.match(/delete/) && i.hasClass("js-confirm"))return f = "Are you sure you want to <strong>Delete<\/strong> the " + i.data("modal"), r(i, f), t.preventDefault(), t.stopPropagation(), !1;
                $.get(u, function (t) {
                    u.match(/delete/) && t === !0 ? n.actions(u, u.split("/").pop()) : (i.after(t), i.next().find("input:first").focus())
                });
                e.find("input:first").focus();
                t.preventDefault()
            }, displayModal: function () {
                var n = $(".modal-container");
                n.show(function () {
                    n.find(".modal").addClass("appear")
                })
            }, addViaGridModal: function (i) {
                var e;
                if (console.log("wishList.addViaGridModal"), $(this).closest("#react-product-page").length > 0)return console.log("Disabled jquery add to wishlist"), !1;
                var u = $(this), r = u.attr("href").split("?")[0], f = u.data("img"), o = u.data("name"), s = $("#sku");
                if (s.length !== 0) {
                    if (e = s.val(), e === "")return alert("Please select from the product options before adding to your wish lists."), !1;
                    r = r.split("/");
                    r[r.length - 1] = e;
                    r = r.join("/")
                }
                return u.addClass("loading"), $.get(r, function (i) {
                    function e() {
                        console.log("auto close triggered");
                        t = setTimeout(function () {
                            r.find(".close").trigger("click")
                        }, 5e3)
                    }

                    $("body").append(i);
                    var r = $(".modal-container");
                    u.removeClass("loading");
                    f === "/assets/" && (f = $(".zoom-img img").attr("src"));
                    r.find(".js-wl-item-name").text(o);
                    r.find(".product-image").attr("src", f).attr("alt", o);
                    n.displayModal();
                    $(document).on("click", ".add-product-wishlist .checkbox:not(.disabled)", function () {
                        $(".modal h1").text("Added To Wishlist");
                        r.find(".add-item").hide();
                        r.find(".confirm").show();
                        e()
                    });
                    $(document).on("submit", ".bbay-form.wishlist.create", function () {
                        console.log("auto close modal on new list creation");
                        e()
                    })
                }), i.preventDefault(), !1
            }, actions: function (n, t) {
                console.log("wishList.actions");
                var i = n.match(/create|delete|update|move|item/g);
                if (i === null)return !1;
                i = i.toString();
                switch (i) {
                    case"create":
                        this.createList(t);
                        break;
                    case"update":
                        this.updateList(t);
                        break;
                    case"delete":
                        this.deleteList(t);
                        break;
                    case"move,item":
                        this.deleteItem(t);
                        break;
                    case"delete,item":
                        this.deleteItem(t);
                        break;
                    default:
                        return !1
                }
            }
        };
        $(document).on("click", ".page-load", n.loadPage);
        $(document).on("click", "a.api", n.getApiRequest);
        $(document).on("click", ".js-edit-wishlist", n.updateItem);
        $(document).on("click", ".add-product-wishlist .checkbox:not(.disabled)", n.addItemToList);
        $(document).on("click", ".js-modal-add", n.addViaGridModal);
        $(document).on("submit", ".bbay-form.wishlist", n.submitAction);
        $(document).on("submit", ".js-wishlist", function () {
            var n = $(this);
            return $.post(n.attr("action"), $("#wl-rename").serialize(), function () {
                $("#wl-name").html(n.find("#Name").val())
            }), !1
        });
        n.displayModal();
        $(document).on("click", "#wl-edit", function (n) {
            $(n.target).hasClass("action") || n.preventDefault()
        });
        $(document).on("submit", ".js-wl-list .quick-buy", function (n) {
            n.preventDefault();
            $.post($(this).attr("action"), $(this).serialize(), function () {
                location.reload()
            })
        });
        $(document).on("click", "#hide-show-wishlist-create", function () {
            console.log("create and new wishlist");
            $("#create-wishlist-fields").toggleClass("hidden")
        });
        $(document).on("click", ".modal-container", function () {
            $(".modal-container .close").trigger("click");
            clearInterval(t)
        });
        $(document).on("click", ".modal", function (n) {
            n.stopPropagation()
        });
        $(document).on("click", ".modal-container .close, .modal-container #btn-cancel", function (n) {
            console.log("closing wishlist modal");
            console.log(n);
            var i = $(".modal-container");
            return i.find(".modal").addClass("disappear"), i.delay(500).fadeOut(function () {
                $(".js-login").length && $(this).remove();
                i.remove();
                var n = BBay.Util.getParameterByName("url");
                n !== "" && window.location.assign(n)
            }), clearInterval(t), !1
        })
    })(), function () {
        var n = $("#sp-index");
        n.length !== 0 && (BBay.StickyTacs.init({
            container: ".game-container",
            gameid: 4077
        }), $(".img").unveil(400, function () {
            $(this).load(function () {
                this.style.opacity = 1
            })
        }), $(".video-container").bind("inview", function () {
            console.log('video container "inview"');
            BBay.YouTubeVideo.init()
        }))
    }()
</script>