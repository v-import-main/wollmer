(function(a) {
	var b = function(b) {
			var c = a.extend({
				state: 0,
				toggleCallback: !1,
				settingCallback: !1
			}, b);
			this.toggle = function() {
				c.state = 0 < c.state ? c.state - 1 : c.state + 1, c.toggleCallback && c.toggleCallback(c.state)
			}, this.set = function(a) {
				c.state = 0 == a ? 0 : 1, c.settingCallback && c.settingCallback()
			}, this.get = function() {
				return c.state
			}
		},
		c = function(c) {
			var d = a.extend({
				dimensions: void 0,
				sheetData: void 0,
				toggleCallback: !1,
				settingCallback: !1
			}, c);
			d.cells = [], d.initCells = function() {
				var a = d.dimensions[0],
					c = d.dimensions[1];
				if (2 == d.dimensions.length && 0 < a && 0 < c)
					for (var e = 0, f = []; e < a; ++e) {
						f = [];
						for (var g = 0; g < c; ++g) f.push(new b({
							state: d.sheetData ? d.sheetData[e] ? d.sheetData[e][g] : 0 : 0
						}));
						d.cells.push(f)
					} else throw new Error("CSheet : wrong dimensions")
			}, d.areaOperate = function(b, c) {
				var e = d.cells.length,
					f = d.cells[0] ? d.cells[0].length : 0,
					g = a.extend({
						startCell: [0, 0],
						endCell: [e - 1, f - 1]
					}, b),
					h = 0 <= g.startCell[0] && g.endCell[0] <= e - 1 && 0 <= g.startCell[1] && g.endCell[1] <= f - 1 && g.startCell[0] <= g.endCell[0] && g.startCell[1] <= g.endCell[1];
				if (!h) throw new Error("CSheet : operation area is invalid");
				else if (!(0 == e || 0 == f))
					for (var i = g.startCell[0]; i <= g.endCell[0]; ++i)
						for (var j = g.startCell[1]; j <= g.endCell[1]; ++j) "toggle" == c.type ? d.cells[i][j].toggle() : "set" == c.type && d.cells[i][j].set(c.state)
			}, d.initCells(), this.toggle = function(a) {
				d.areaOperate(a, {
					type: "toggle"
				}), d.toggleCallback && d.toggleCallback()
			}, this.set = function(a, b) {
				d.areaOperate(b, {
					type: "set",
					state: a
				}), d.settingCallback && d.settingCallback()
			}, this.getCellState = function(a) {
				return d.cells[a[0]][a[1]].get()
			}, this.getRowStates = function(a) {
				for (var b = [], c = 0; c < d.dimensions[1]; ++c) b.push(d.cells[a][c].get());
				return b
			}, this.getSheetStates = function() {
				for (var a = [], b = 0, c = []; b < d.dimensions[0]; ++b) {
					c = [];
					for (var e = 0; e < d.dimensions[1]; ++e) c.push(d.cells[b][e].get());
					a.push(c)
				}
				return a
			}
		};
	a.fn.TimeSheet = function(b) {
		var d = a(this);
		if (!d.is("TBODY")) throw new Error("TimeSheet needs to be bound on a TBODY element");
		var e = a.extend({
			data: {},
			sheetClass: "",
			input: null,
			start: !1,
			end: !1,
			remarks: null
		}, b);
		if (!e.data.dimensions || 2 !== e.data.dimensions.length || 0 > e.data.dimensions[0] || 0 > e.data.dimensions[1]) throw new Error("TimeSheet : wrong dimensions");
		var f = {
				startCell: void 0,
				endCell: void 0
			},
			g = new c({
				dimensions: e.data.dimensions,
				sheetData: e.data.sheetData ? e.data.sheetData : void 0,
				targetSheet: void 0
			}),
			h = function() {
				for (var a = "<tr>", b = 0, c = ""; b <= e.data.dimensions[1]; ++b) c = 0 == b ? "<td class=\"TimeSheet-head\" style=\"" + (e.data.sheetHead.style ? e.data.sheetHead.style : "") + "\">" + e.data.sheetHead.name + "</td>" : "<td title=\"" + (e.data.colHead[b - 1].title ? e.data.colHead[b - 1].title : "") + "\" data-col=\"" + (b - 1) + "\" class=\"TimeSheet-colHead " + (b === e.data.dimensions[1] ? "rightMost" : "") + "\" style=\"" + (e.data.colHead[b - 1].style ? e.data.colHead[b - 1].style : "") + "\">" + e.data.colHead[b - 1].name + "</td>", a += c;
				e.remarks && (a += "<td class=\"TimeSheet-remarkHead\">" + e.remarks.title + "</td>"), a += "</tr>", d.append(a)
			},
			i = function() {
				for (var a = 0, b = ""; a < e.data.dimensions[0]; ++a) {
					b = "<tr class=\"TimeSheet-row\">";
					for (var c = 0, f = ""; c <= e.data.dimensions[1]; ++c) f = 0 == c ? "<td title=\"" + (e.data.rowHead[a].title ? e.data.rowHead[a].title : "") + "\"class=\"TimeSheet-rowHead " + (a === e.data.dimensions[0] - 1 ? "bottomMost " : " ") + "\" style=\"" + (e.data.rowHead[a].style ? e.data.rowHead[a].style : "") + "\">" + e.data.rowHead[a].name + "</td>" : "<td class=\"TimeSheet-cell " + (a === e.data.dimensions[0] - 1 ? "bottomMost " : " ") + (c === e.data.dimensions[1] ? "rightMost" : "") + "\" data-row=\"" + a + "\" data-col=\"" + (c - 1) + "\"></td>", b += f;
					e.remarks && (b += "<td class=\"TimeSheet-remark " + (a === e.data.dimensions[0] - 1 ? "bottomMost " : " ") + "\">" + e.remarks.default+"</td>"), b += "</tr>", d.append(b)
				}
			},
			j = function(a, b) {
				var c = a[0] + a[1],
					d = b[0] + b[1];
				return 0 > (a[0] - b[0]) * (a[1] - b[1]) ? {
					topLeft: a[0] < b[0] ? [a[0], b[1]] : [b[0], a[1]],
					bottomRight: a[0] < b[0] ? [b[0], a[1]] : [a[0], b[1]]
				} : {
					topLeft: c <= d ? a : b,
					bottomRight: c > d ? a : b
				}
			},
			l = function() {
				var b = g.getSheetStates();
				d.find(".TimeSheet-row").each(function(c, d) {
					var e = a(d);
					e.find(".TimeSheet-cell").each(function(d, e) {
						var f = a(e);
						1 === b[c][d] ? f.addClass("TimeSheet-cell-selected") : 0 === b[c][d] && f.removeClass("TimeSheet-cell-selected")
					})
				})
			},
			m = function() {
				d.find(".TimeSheet-cell-selecting").removeClass("TimeSheet-cell-selecting")
			},
			n = function() {
				d.find(".TimeSheet-remark").each(function(b, c) {
					var d = a(c);
					d.prop("title", ""), d.html(e.remarks.default)
				})
			},
			o = function(a, b) {
				f.startCell = b, g.targetSheet = g.getCellState(b) ? 0 : 1, e.start && e.start(a)
			},
			p = function(b, c, e) {
				var f = a(b.currentTarget);
				if (r && f.hasClass("TimeSheet-cell") || s && f.hasClass("TimeSheet-colHead")) {
					m();
					for (var g = c[0]; g <= e[0]; ++g)
						for (var h = c[1]; h <= e[1]; ++h) a(a(d.find(".TimeSheet-row")[g]).find(".TimeSheet-cell")[h]).addClass("TimeSheet-cell-selecting")
				}
			},
			q = function(b, c) {
				var d = a(b.currentTarget),
					h = a(b.which),
					i = g.targetSheet;
				r && d.hasClass("TimeSheet-cell") || s && d.hasClass("TimeSheet-colHead") || d.hasClass("TimeSheet") ? (g.set(i, {
					startCell: c.topLeft,
					endCell: c.bottomRight
				}), m(), l(), e.end && e.end(b, c)) : m(), r = !1, s = !1, f = {
					startCell: void 0,
					endCell: void 0
				}, e.input && a(e.input).val(JSON.stringify(g.getSheetStates())) && a(e.input).trigger('input')
			},
			r = !1,
			s = !1,
			t = function() {
				d.undelegate(".umsSheetEvent"), d.delegate(".TimeSheet-cell", "mousedown.umsSheetEvent", function(b) {
					var c = a(b.currentTarget),
						d = [c.data("row"), c.data("col")];
					r = !0, o(b, d)
				}), d.delegate(".TimeSheet-cell", "mouseup.umsSheetEvent", function(b) {
					if (f.startCell) {
						var c = a(b.currentTarget),
							d = [c.data("row"), c.data("col")],
							e = j(f.startCell, d);
						q(b, e)
					}
				}), d.delegate(".TimeSheet-cell", "mouseover.umsSheetEvent", function(b) {
					if (r) {
						var c = a(b.currentTarget),
							d = [c.data("row"), c.data("col")],
							e = j(f.startCell, d);
						f.endCell = d;
						var g = e.topLeft,
							h = e.bottomRight;
						p(b, g, h)
					}
				}), d.delegate(null, "mouseleave.umsSheetEvent", function(a) {
					if (f.startCell && f.endCell) {
						var b = j(f.startCell, f.endCell);
						q(a, b)
					}
				}), d.delegate(".TimeSheet-colHead", "mousedown.umsSheetEvent", function(b) {
					var c = a(b.currentTarget),
						d = [0, c.data("col")];
					s = !0, o(b, d)
				}), d.delegate(".TimeSheet-colHead", "mouseup.umsSheetEvent", function(b) {
					if (f.startCell) {
						var c = a(b.currentTarget),
							d = [e.data.dimensions[0] - 1, c.data("col")],
							g = j(f.startCell, d);
						q(b, g)
					}
				}), d.delegate(".TimeSheet-colHead", "mouseover.umsSheetEvent", function(b) {
					if (s) {
						var c = a(b.currentTarget),
							d = [e.data.dimensions[0] - 1, c.data("col")],
							g = j(f.startCell, d),
							h = g.topLeft,
							i = g.bottomRight;
						p(b, h, i)
					}
				}), e.input && a(e.input).delegate(null, "change", function() {
					var b = a(this).val();
					b && function(a) {
						try {
							a = JSON.parse(a)
						} catch (a) {
							return !1
						}
						return "object" == typeof a && null !== a
					}(b) ? (b = JSON.parse(b), u.setSheetStates(b)) : a(this).attr("data-full") ? u.setFull() : u.clean()
				})
			};
		(function() {
			d.html(""), d.addClass("TimeSheet"), e.sheetClass && d.addClass(e.sheetClass), h(), i(), l()
		})(), t();
		var u = {
			getCellState: function(a) {
				return g.getCellState(a)
			},
			getRowStates: function(a) {
				return g.getRowStates(a)
			},
			getSheetStates: function() {
				return g.getSheetStates()
			},
			setSheetStates: function(a) {
				for (var b = e.data.dimensions, c = 0; c < b[0]; c++)
					for (var d = 0; d < b[1]; d++) g.set(a[c][d], {
						startCell: [c, d],
						endCell: [c, d]
					});
				l(), n()
			},
			setRemark: function(b, c) {
				"" !== a.trim(c) && a(d.find(".TimeSheet-row")[b]).find(".TimeSheet-remark").prop("title", c).html(c)
			},
			clean: function() {
				g.set(0, {}), l(), n()
			},
			setFull: function() {
				g.set(1, {}), l(), n()
			},
			getDefaultRemark: function() {
				return e.remarks.default
			},
			disable: function() {
				d.undelegate(".umsSheetEvent")
			},
			enable: function() {
				t()
			},
			isFull: function() {
				for (var a = 0; a < e.data.dimensions[0]; ++a)
					for (var b = 0; b < e.data.dimensions[1]; ++b)
						if (0 === g.getCellState([a, b])) return !1;
				return !0
			}
		};
		return u
	}
})(jQuery);