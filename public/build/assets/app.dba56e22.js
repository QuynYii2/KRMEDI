var wo = typeof globalThis != "undefined" ? globalThis : typeof window != "undefined" ? window : typeof global != "undefined" ? global : typeof self != "undefined" ? self : {};

function Lv(C) {
    return C && C.__esModule && Object.prototype.hasOwnProperty.call(C, "default") ? C.default : C
}

var Vu = {exports: {}};
/**
 * @license
 * Lodash <https://lodash.com/>
 * Copyright OpenJS Foundation and other contributors <https://openjsf.org/>
 * Released under MIT license <https://lodash.com/license>
 * Based on Underscore.js 1.8.3 <http://underscorejs.org/LICENSE>
 * Copyright Jeremy Ashkenas, DocumentCloud and Investigative Reporters & Editors
 */(function (C, m) {
    (function () {
        var d, A = "4.17.21", S = 200, I = "Unsupported core-js use. Try https://npms.io/search?q=ponyfill.",
            M = "Expected a function", ie = "Invalid `variable` option passed into `_.template`",
            B = "__lodash_hash_undefined__", qe = 500, Se = "__lodash_placeholder__", ae = 1, re = 2, ee = 4, Q = 1,
            J = 2, G = 1, F = 2, de = 4, Te = 8, Ne = 16, He = 32, et = 64, p = 128, tt = 256, _e = 512, Bt = 30,
            So = "...", Co = 800, Ie = 16, Ft = 1, kr = 2, To = 3, it = 1 / 0, Wt = 9007199254740991,
            Un = 17976931348623157e292, rr = 0 / 0, _t = 4294967295, Yr = _t - 1, Qr = _t >>> 1,
            Ni = [["ary", p], ["bind", G], ["bindKey", F], ["curry", Te], ["curryRight", Ne], ["flip", _e], ["partial", He], ["partialRight", et], ["rearg", tt]],
            mt = "[object Arguments]", Or = "[object Array]", Ao = "[object AsyncFunction]", Be = "[object Boolean]",
            We = "[object Date]", $t = "[object DOMException]", ir = "[object Error]", Je = "[object Function]",
            Bn = "[object GeneratorFunction]", bt = "[object Map]", en = "[object Number]", Pr = "[object Null]",
            wt = "[object Object]", Pt = "[object Promise]", Di = "[object Proxy]", or = "[object RegExp]",
            xt = "[object Set]", st = "[object String]", hn = "[object Symbol]", sr = "[object Undefined]",
            oe = "[object WeakMap]", Ve = "[object WeakSet]", ur = "[object ArrayBuffer]", Pe = "[object DataView]",
            Zr = "[object Float32Array]", Rr = "[object Float64Array]", Lr = "[object Int8Array]",
            kn = "[object Int16Array]", Rt = "[object Int32Array]", tn = "[object Uint8Array]",
            pn = "[object Uint8ClampedArray]", ei = "[object Uint16Array]", Fn = "[object Uint32Array]",
            Ir = /\b__p \+= '';/g, Nr = /\b(__p \+=) '' \+/g, Eo = /(__e\(.*?\)|\b__t\)) \+\n'';/g,
            On = /&(?:amp|lt|gt|quot|#39);/g, Wn = /[&<>"']/g, Mi = RegExp(On.source), qi = RegExp(Wn.source),
            ut = /<%-([\s\S]+?)%>/g, at = /<%([\s\S]+?)%>/g, St = /<%=([\s\S]+?)%>/g,
            ko = /\.|\[(?:[^[\]]*|(["'])(?:(?!\1)[^\\]|\\.)*?\1)\]/, Hi = /^\w*$/,
            ji = /[^.[\]]+|\[(?:(-?\d+(?:\.\d+)?)|(["'])((?:(?!\2)[^\\]|\\.)*?)\2)\]|(?=(?:\.|\[\])(?:\.|\[\]|$))/g,
            dn = /[\\^$.*+?()[\]{}|]/g, Lt = RegExp(dn.source), ar = /^\s+/, fr = /\s/,
            Ui = /\{(?:\n\/\* \[wrapped with .+\] \*\/)?\n?/, Bi = /\{\n\/\* \[wrapped with (.+)\] \*/, Fi = /,? & /,
            Wi = /[^\x00-\x2f\x3a-\x40\x5b-\x60\x7b-\x7f]+/g, Oo = /[()=,{}\[\]\/\s]/, Po = /\\(\\)?/g,
            cr = /\$\{([^\\}]*(?:\\.[^\\}]*)*)\}/g, $i = /\w*$/, Pn = /^[-+]0x[0-9a-f]+$/i, zi = /^0b[01]+$/i,
            ti = /^\[object .+?Constructor\]$/, ni = /^0o[0-7]+$/i, Dr = /^(?:0|[1-9]\d*)$/,
            Xi = /[\xc0-\xd6\xd8-\xf6\xf8-\xff\u0100-\u017f]/g, Mr = /($^)/, lr = /['\n\r\u2028\u2029\\]/g,
            hr = "\\ud800-\\udfff", ri = "\\u0300-\\u036f", gn = "\\ufe20-\\ufe2f", Gi = "\\u20d0-\\u20ff",
            Ji = ri + gn + Gi, qr = "\\u2700-\\u27bf", Vi = "a-z\\xdf-\\xf6\\xf8-\\xff", Ro = "\\xac\\xb1\\xd7\\xf7",
            Ki = "\\x00-\\x2f\\x3a-\\x40\\x5b-\\x60\\x7b-\\xbf", Yi = "\\u2000-\\u206f",
            ii = " \\t\\x0b\\f\\xa0\\ufeff\\n\\r\\u2028\\u2029\\u1680\\u180e\\u2000\\u2001\\u2002\\u2003\\u2004\\u2005\\u2006\\u2007\\u2008\\u2009\\u200a\\u202f\\u205f\\u3000",
            oi = "A-Z\\xc0-\\xd6\\xd8-\\xde", Ke = "\\ufe0e\\ufe0f", Rn = Ro + Ki + Yi + ii, $n = "['\u2019]",
            si = "[" + hr + "]", Qi = "[" + Rn + "]", zn = "[" + Ji + "]", ui = "\\d+", Hr = "[" + qr + "]",
            ai = "[" + Vi + "]", Zi = "[^" + hr + Rn + ui + qr + Vi + oi + "]", fi = "\\ud83c[\\udffb-\\udfff]",
            It = "(?:" + zn + "|" + fi + ")", pr = "[^" + hr + "]", Ln = "(?:\\ud83c[\\udde6-\\uddff]){2}",
            ci = "[\\ud800-\\udbff][\\udc00-\\udfff]", Xn = "[" + oi + "]", vn = "\\u200d",
            yn = "(?:" + ai + "|" + Zi + ")", li = "(?:" + Xn + "|" + Zi + ")",
            eo = "(?:" + $n + "(?:d|ll|m|re|s|t|ve))?", Gn = "(?:" + $n + "(?:D|LL|M|RE|S|T|VE))?", hi = It + "?",
            jr = "[" + Ke + "]?", zt = "(?:" + vn + "(?:" + [pr, Ln, ci].join("|") + ")" + jr + hi + ")*",
            to = "\\d*(?:1st|2nd|3rd|(?![123])\\dth)(?=\\b|[A-Z_])",
            no = "\\d*(?:1ST|2ND|3RD|(?![123])\\dTH)(?=\\b|[a-z_])", pi = jr + hi + zt,
            In = "(?:" + [Hr, Ln, ci].join("|") + ")" + pi,
            Lo = "(?:" + [pr + zn + "?", zn, Ln, ci, si].join("|") + ")", dr = RegExp($n, "g"), Io = RegExp(zn, "g"),
            di = RegExp(fi + "(?=" + fi + ")|" + Lo + pi, "g"),
            No = RegExp([Xn + "?" + ai + "+" + eo + "(?=" + [Qi, Xn, "$"].join("|") + ")", li + "+" + Gn + "(?=" + [Qi, Xn + yn, "$"].join("|") + ")", Xn + "?" + yn + "+" + eo, Xn + "+" + Gn, no, to, ui, In].join("|"), "g"),
            Do = RegExp("[" + vn + hr + Ji + Ke + "]"),
            Mo = /[a-z][A-Z]|[A-Z]{2}[a-z]|[0-9][a-zA-Z]|[a-zA-Z][0-9]|[^a-zA-Z0-9 ]/,
            gi = ["Array", "Buffer", "DataView", "Date", "Error", "Float32Array", "Float64Array", "Function", "Int8Array", "Int16Array", "Int32Array", "Map", "Math", "Object", "Promise", "RegExp", "Set", "String", "Symbol", "TypeError", "Uint8Array", "Uint8ClampedArray", "Uint16Array", "Uint32Array", "WeakMap", "_", "clearTimeout", "isFinite", "parseInt", "setTimeout"],
            qo = -1, De = {};
        De[Zr] = De[Rr] = De[Lr] = De[kn] = De[Rt] = De[tn] = De[pn] = De[ei] = De[Fn] = !0, De[mt] = De[Or] = De[ur] = De[Be] = De[Pe] = De[We] = De[ir] = De[Je] = De[bt] = De[en] = De[wt] = De[or] = De[xt] = De[st] = De[oe] = !1;
        var Re = {};
        Re[mt] = Re[Or] = Re[ur] = Re[Pe] = Re[Be] = Re[We] = Re[Zr] = Re[Rr] = Re[Lr] = Re[kn] = Re[Rt] = Re[bt] = Re[en] = Re[wt] = Re[or] = Re[xt] = Re[st] = Re[hn] = Re[tn] = Re[pn] = Re[ei] = Re[Fn] = !0, Re[ir] = Re[Je] = Re[oe] = !1;
        var ro = {
                \u00C0: "A",
                \u00C1: "A",
                \u00C2: "A",
                \u00C3: "A",
                \u00C4: "A",
                \u00C5: "A",
                \u00E0: "a",
                \u00E1: "a",
                \u00E2: "a",
                \u00E3: "a",
                \u00E4: "a",
                \u00E5: "a",
                \u00C7: "C",
                \u00E7: "c",
                \u00D0: "D",
                \u00F0: "d",
                \u00C8: "E",
                \u00C9: "E",
                \u00CA: "E",
                \u00CB: "E",
                \u00E8: "e",
                \u00E9: "e",
                \u00EA: "e",
                \u00EB: "e",
                \u00CC: "I",
                \u00CD: "I",
                \u00CE: "I",
                \u00CF: "I",
                \u00EC: "i",
                \u00ED: "i",
                \u00EE: "i",
                \u00EF: "i",
                \u00D1: "N",
                \u00F1: "n",
                \u00D2: "O",
                \u00D3: "O",
                \u00D4: "O",
                \u00D5: "O",
                \u00D6: "O",
                \u00D8: "O",
                \u00F2: "o",
                \u00F3: "o",
                \u00F4: "o",
                \u00F5: "o",
                \u00F6: "o",
                \u00F8: "o",
                \u00D9: "U",
                \u00DA: "U",
                \u00DB: "U",
                \u00DC: "U",
                \u00F9: "u",
                \u00FA: "u",
                \u00FB: "u",
                \u00FC: "u",
                \u00DD: "Y",
                \u00FD: "y",
                \u00FF: "y",
                \u00C6: "Ae",
                \u00E6: "ae",
                \u00DE: "Th",
                \u00FE: "th",
                \u00DF: "ss",
                \u0100: "A",
                \u0102: "A",
                \u0104: "A",
                \u0101: "a",
                \u0103: "a",
                \u0105: "a",
                \u0106: "C",
                \u0108: "C",
                \u010A: "C",
                \u010C: "C",
                \u0107: "c",
                \u0109: "c",
                \u010B: "c",
                \u010D: "c",
                \u010E: "D",
                \u0110: "D",
                \u010F: "d",
                \u0111: "d",
                \u0112: "E",
                \u0114: "E",
                \u0116: "E",
                \u0118: "E",
                \u011A: "E",
                \u0113: "e",
                \u0115: "e",
                \u0117: "e",
                \u0119: "e",
                \u011B: "e",
                \u011C: "G",
                \u011E: "G",
                \u0120: "G",
                \u0122: "G",
                \u011D: "g",
                \u011F: "g",
                \u0121: "g",
                \u0123: "g",
                \u0124: "H",
                \u0126: "H",
                \u0125: "h",
                \u0127: "h",
                \u0128: "I",
                \u012A: "I",
                \u012C: "I",
                \u012E: "I",
                \u0130: "I",
                \u0129: "i",
                \u012B: "i",
                \u012D: "i",
                \u012F: "i",
                \u0131: "i",
                \u0134: "J",
                \u0135: "j",
                \u0136: "K",
                \u0137: "k",
                \u0138: "k",
                \u0139: "L",
                \u013B: "L",
                \u013D: "L",
                \u013F: "L",
                \u0141: "L",
                \u013A: "l",
                \u013C: "l",
                \u013E: "l",
                \u0140: "l",
                \u0142: "l",
                \u0143: "N",
                \u0145: "N",
                \u0147: "N",
                \u014A: "N",
                \u0144: "n",
                \u0146: "n",
                \u0148: "n",
                \u014B: "n",
                \u014C: "O",
                \u014E: "O",
                \u0150: "O",
                \u014D: "o",
                \u014F: "o",
                \u0151: "o",
                \u0154: "R",
                \u0156: "R",
                \u0158: "R",
                \u0155: "r",
                \u0157: "r",
                \u0159: "r",
                \u015A: "S",
                \u015C: "S",
                \u015E: "S",
                \u0160: "S",
                \u015B: "s",
                \u015D: "s",
                \u015F: "s",
                \u0161: "s",
                \u0162: "T",
                \u0164: "T",
                \u0166: "T",
                \u0163: "t",
                \u0165: "t",
                \u0167: "t",
                \u0168: "U",
                \u016A: "U",
                \u016C: "U",
                \u016E: "U",
                \u0170: "U",
                \u0172: "U",
                \u0169: "u",
                \u016B: "u",
                \u016D: "u",
                \u016F: "u",
                \u0171: "u",
                \u0173: "u",
                \u0174: "W",
                \u0175: "w",
                \u0176: "Y",
                \u0177: "y",
                \u0178: "Y",
                \u0179: "Z",
                \u017B: "Z",
                \u017D: "Z",
                \u017A: "z",
                \u017C: "z",
                \u017E: "z",
                \u0132: "IJ",
                \u0133: "ij",
                \u0152: "Oe",
                \u0153: "oe",
                \u0149: "'n",
                \u017F: "s"
            }, Jn = {"&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#39;"},
            oo = {"&amp;": "&", "&lt;": "<", "&gt;": ">", "&quot;": '"', "&#39;": "'"},
            Vn = {"\\": "\\", "'": "'", "\n": "n", "\r": "r", "\u2028": "u2028", "\u2029": "u2029"}, vi = parseFloat,
            Ho = parseInt, Kn = typeof wo == "object" && wo && wo.Object === Object && wo,
            jo = typeof self == "object" && self && self.Object === Object && self,
            je = Kn || jo || Function("return this")(), Ur = m && !m.nodeType && m,
            nn = Ur && !0 && C && !C.nodeType && C, so = nn && nn.exports === Ur, yi = so && Kn.process,
            Ct = function () {
                try {
                    var a = nn && nn.require && nn.require("util").types;
                    return a || yi && yi.binding && yi.binding("util")
                } catch {
                }
            }(), n = Ct && Ct.isArrayBuffer, i = Ct && Ct.isDate, f = Ct && Ct.isMap, l = Ct && Ct.isRegExp,
            v = Ct && Ct.isSet, y = Ct && Ct.isTypedArray;

        function b(a, c, g) {
            switch (g.length) {
                case 0:
                    return a.call(c);
                case 1:
                    return a.call(c, g[0]);
                case 2:
                    return a.call(c, g[0], g[1]);
                case 3:
                    return a.call(c, g[0], g[1], g[2])
            }
            return a.apply(c, g)
        }

        function P(a, c, g, E) {
            for (var L = -1, W = a == null ? 0 : a.length; ++L < W;) {
                var j = a[L];
                c(E, j, g(j), a)
            }
            return E
        }

        function k(a, c) {
            for (var g = -1, E = a == null ? 0 : a.length; ++g < E && c(a[g], g, a) !== !1;) ;
            return a
        }

        function N(a, c) {
            for (var g = a == null ? 0 : a.length; g-- && c(a[g], g, a) !== !1;) ;
            return a
        }

        function H(a, c) {
            for (var g = -1, E = a == null ? 0 : a.length; ++g < E;) if (!c(a[g], g, a)) return !1;
            return !0
        }

        function U(a, c) {
            for (var g = -1, E = a == null ? 0 : a.length, L = 0, W = []; ++g < E;) {
                var j = a[g];
                c(j, g, a) && (W[L++] = j)
            }
            return W
        }

        function q(a, c) {
            var g = a == null ? 0 : a.length;
            return !!g && Le(a, c, 0) > -1
        }

        function K(a, c, g) {
            for (var E = -1, L = a == null ? 0 : a.length; ++E < L;) if (g(c, a[E])) return !0;
            return !1
        }

        function ne(a, c) {
            for (var g = -1, E = a == null ? 0 : a.length, L = Array(E); ++g < E;) L[g] = c(a[g], g, a);
            return L
        }

        function ve(a, c) {
            for (var g = -1, E = c.length, L = a.length; ++g < E;) a[L + g] = c[g];
            return a
        }

        function ge(a, c, g, E) {
            var L = -1, W = a == null ? 0 : a.length;
            for (E && W && (g = a[++L]); ++L < W;) g = c(g, a[L], L, a);
            return g
        }

        function Ye(a, c, g, E) {
            var L = a == null ? 0 : a.length;
            for (E && L && (g = a[--L]); L--;) g = c(g, a[L], L, a);
            return g
        }

        function Ue(a, c) {
            for (var g = -1, E = a == null ? 0 : a.length; ++g < E;) if (c(a[g], g, a)) return !0;
            return !1
        }

        var Xt = Nn("length");

        function Nt(a) {
            return a.split("")
        }

        function we(a) {
            return a.match(Wi) || []
        }

        function _n(a, c, g) {
            var E;
            return g(a, function (L, W, j) {
                if (c(L, W, j)) return E = W, !1
            }), E
        }

        function Z(a, c, g, E) {
            for (var L = a.length, W = g + (E ? 1 : -1); E ? W-- : ++W < L;) if (c(a[W], W, a)) return W;
            return -1
        }

        function Le(a, c, g) {
            return c === c ? Fo(a, c, g) : Z(a, Br, g)
        }

        function mn(a, c, g, E) {
            for (var L = g - 1, W = a.length; ++L < W;) if (E(a[L], c)) return L;
            return -1
        }

        function Br(a) {
            return a !== a
        }

        function Dt(a, c) {
            var g = a == null ? 0 : a.length;
            return g ? ft(a, c) / g : rr
        }

        function Nn(a) {
            return function (c) {
                return c == null ? d : c[a]
            }
        }

        function Tt(a) {
            return function (c) {
                return a == null ? d : a[c]
            }
        }

        function Gt(a, c, g, E, L) {
            return L(a, function (W, j, X) {
                g = E ? (E = !1, W) : c(g, W, j, X)
            }), g
        }

        function bn(a, c) {
            var g = a.length;
            for (a.sort(c); g--;) a[g] = a[g].value;
            return a
        }

        function ft(a, c) {
            for (var g, E = -1, L = a.length; ++E < L;) {
                var W = c(a[E]);
                W !== d && (g = g === d ? W : g + W)
            }
            return g
        }

        function gr(a, c) {
            for (var g = -1, E = Array(a); ++g < a;) E[g] = c(g);
            return E
        }

        function rn(a, c) {
            return ne(c, function (g) {
                return [g, a[g]]
            })
        }

        function Jt(a) {
            return a && a.slice(0, uo(a) + 1).replace(ar, "")
        }

        function lt(a) {
            return function (c) {
                return a(c)
            }
        }

        function _i(a, c) {
            return ne(c, function (g) {
                return a[g]
            })
        }

        function vr(a, c) {
            return a.has(c)
        }

        function Oe(a, c) {
            for (var g = -1, E = a.length; ++g < E && Le(c, a[g], 0) > -1;) ;
            return g
        }

        function yr(a, c) {
            for (var g = a.length; g-- && Le(c, a[g], 0) > -1;) ;
            return g
        }

        function nt(a, c) {
            for (var g = a.length, E = 0; g--;) a[g] === c && ++E;
            return E
        }

        var Yn = Tt(ro), Uo = Tt(Jn);

        function Bo(a) {
            return "\\" + Vn[a]
        }

        function mi(a, c) {
            return a == null ? d : a[c]
        }

        function At(a) {
            return Do.test(a)
        }

        function bi(a) {
            return Mo.test(a)
        }

        function wn(a) {
            for (var c, g = []; !(c = a.next()).done;) g.push(c.value);
            return g
        }

        function Fr(a) {
            var c = -1, g = Array(a.size);
            return a.forEach(function (E, L) {
                g[++c] = [L, E]
            }), g
        }

        function Qn(a, c) {
            return function (g) {
                return a(c(g))
            }
        }

        function Mt(a, c) {
            for (var g = -1, E = a.length, L = 0, W = []; ++g < E;) {
                var j = a[g];
                (j === c || j === Se) && (a[g] = Se, W[L++] = g)
            }
            return W
        }

        function Dn(a) {
            var c = -1, g = Array(a.size);
            return a.forEach(function (E) {
                g[++c] = E
            }), g
        }

        function wi(a) {
            var c = -1, g = Array(a.size);
            return a.forEach(function (E) {
                g[++c] = [E, E]
            }), g
        }

        function Fo(a, c, g) {
            for (var E = g - 1, L = a.length; ++E < L;) if (a[E] === c) return E;
            return -1
        }

        function Wr(a, c, g) {
            for (var E = g + 1; E--;) if (a[E] === c) return E;
            return E
        }

        function xn(a) {
            return At(a) ? zr(a) : Xt(a)
        }

        function ht(a) {
            return At(a) ? T(a) : Nt(a)
        }

        function uo(a) {
            for (var c = a.length; c-- && fr.test(a.charAt(c));) ;
            return c
        }

        var $r = Tt(oo);

        function zr(a) {
            for (var c = di.lastIndex = 0; di.test(a);) ++c;
            return c
        }

        function T(a) {
            return a.match(di) || []
        }

        function o(a) {
            return a.match(No) || []
        }

        var s = function a(c) {
            c = c == null ? je : u.defaults(je.Object(), c, u.pick(je, gi));
            var g = c.Array, E = c.Date, L = c.Error, W = c.Function, j = c.Math, X = c.Object, ue = c.RegExp,
                se = c.String, me = c.TypeError, ze = g.prototype, rt = W.prototype, Xe = X.prototype,
                pt = c["__core-js_shared__"], Vt = rt.toString, pe = Xe.hasOwnProperty, Ks = 0, Wo = function () {
                    var e = /[^.]+$/.exec(pt && pt.keys && pt.keys.IE_PROTO || "");
                    return e ? "Symbol(src)_1." + e : ""
                }(), xi = Xe.toString, as = Vt.call(X), $o = je._,
                zo = ue("^" + Vt.call(pe).replace(dn, "\\$&").replace(/hasOwnProperty|(function).*?(?=\\\()| for .+?(?=\\\])/g, "$1.*?") + "$"),
                Si = so ? c.Buffer : d, Zn = c.Symbol, ao = c.Uint8Array, fs = Si ? Si.allocUnsafe : d,
                fo = Qn(X.getPrototypeOf, X), Xo = X.create, ca = Xe.propertyIsEnumerable, cs = ze.splice,
                la = Zn ? Zn.isConcatSpreadable : d, Go = Zn ? Zn.iterator : d, Ci = Zn ? Zn.toStringTag : d,
                ls = function () {
                    try {
                        var e = Oi(X, "defineProperty");
                        return e({}, "", {}), e
                    } catch {
                    }
                }(), Rc = c.clearTimeout !== je.clearTimeout && c.clearTimeout,
                Lc = E && E.now !== je.Date.now && E.now, Ic = c.setTimeout !== je.setTimeout && c.setTimeout,
                hs = j.ceil, ps = j.floor, Ys = X.getOwnPropertySymbols, Nc = Si ? Si.isBuffer : d, ha = c.isFinite,
                Dc = ze.join, Mc = Qn(X.keys, X), ot = j.max, Et = j.min, qc = E.now, Hc = c.parseInt, pa = j.random,
                jc = ze.reverse, Qs = Oi(c, "DataView"), Jo = Oi(c, "Map"), Zs = Oi(c, "Promise"), co = Oi(c, "Set"),
                Vo = Oi(c, "WeakMap"), Ko = Oi(X, "create"), ds = Vo && new Vo, lo = {}, Uc = Pi(Qs), Bc = Pi(Jo),
                Fc = Pi(Zs), Wc = Pi(co), $c = Pi(Vo), gs = Zn ? Zn.prototype : d, Yo = gs ? gs.valueOf : d,
                da = gs ? gs.toString : d;

            function w(e) {
                if (Ge(e) && !ye(e) && !(e instanceof Ee)) {
                    if (e instanceof Sn) return e;
                    if (pe.call(e, "__wrapped__")) return vf(e)
                }
                return new Sn(e)
            }

            var ho = function () {
                function e() {
                }

                return function (t) {
                    if (!$e(t)) return {};
                    if (Xo) return Xo(t);
                    e.prototype = t;
                    var r = new e;
                    return e.prototype = d, r
                }
            }();

            function vs() {
            }

            function Sn(e, t) {
                this.__wrapped__ = e, this.__actions__ = [], this.__chain__ = !!t, this.__index__ = 0, this.__values__ = d
            }

            w.templateSettings = {
                escape: ut,
                evaluate: at,
                interpolate: St,
                variable: "",
                imports: {_: w}
            }, w.prototype = vs.prototype, w.prototype.constructor = w, Sn.prototype = ho(vs.prototype), Sn.prototype.constructor = Sn;

            function Ee(e) {
                this.__wrapped__ = e, this.__actions__ = [], this.__dir__ = 1, this.__filtered__ = !1, this.__iteratees__ = [], this.__takeCount__ = _t, this.__views__ = []
            }

            function zc() {
                var e = new Ee(this.__wrapped__);
                return e.__actions__ = Kt(this.__actions__), e.__dir__ = this.__dir__, e.__filtered__ = this.__filtered__, e.__iteratees__ = Kt(this.__iteratees__), e.__takeCount__ = this.__takeCount__, e.__views__ = Kt(this.__views__), e
            }

            function Xc() {
                if (this.__filtered__) {
                    var e = new Ee(this);
                    e.__dir__ = -1, e.__filtered__ = !0
                } else e = this.clone(), e.__dir__ *= -1;
                return e
            }

            function Gc() {
                var e = this.__wrapped__.value(), t = this.__dir__, r = ye(e), h = t < 0, _ = r ? e.length : 0,
                    x = oh(0, _, this.__views__), O = x.start, R = x.end, D = R - O, $ = h ? R : O - 1,
                    z = this.__iteratees__, V = z.length, te = 0, fe = Et(D, this.__takeCount__);
                if (!r || !h && _ == D && fe == D) return Ha(e, this.__actions__);
                var le = [];
                e:for (; D-- && te < fe;) {
                    $ += t;
                    for (var xe = -1, he = e[$]; ++xe < V;) {
                        var Ae = z[xe], ke = Ae.iteratee, un = Ae.type, jt = ke(he);
                        if (un == kr) he = jt; else if (!jt) {
                            if (un == Ft) continue e;
                            break e
                        }
                    }
                    le[te++] = he
                }
                return le
            }

            Ee.prototype = ho(vs.prototype), Ee.prototype.constructor = Ee;

            function Ti(e) {
                var t = -1, r = e == null ? 0 : e.length;
                for (this.clear(); ++t < r;) {
                    var h = e[t];
                    this.set(h[0], h[1])
                }
            }

            function Jc() {
                this.__data__ = Ko ? Ko(null) : {}, this.size = 0
            }

            function Vc(e) {
                var t = this.has(e) && delete this.__data__[e];
                return this.size -= t ? 1 : 0, t
            }

            function Kc(e) {
                var t = this.__data__;
                if (Ko) {
                    var r = t[e];
                    return r === B ? d : r
                }
                return pe.call(t, e) ? t[e] : d
            }

            function Yc(e) {
                var t = this.__data__;
                return Ko ? t[e] !== d : pe.call(t, e)
            }

            function Qc(e, t) {
                var r = this.__data__;
                return this.size += this.has(e) ? 0 : 1, r[e] = Ko && t === d ? B : t, this
            }

            Ti.prototype.clear = Jc, Ti.prototype.delete = Vc, Ti.prototype.get = Kc, Ti.prototype.has = Yc, Ti.prototype.set = Qc;

            function _r(e) {
                var t = -1, r = e == null ? 0 : e.length;
                for (this.clear(); ++t < r;) {
                    var h = e[t];
                    this.set(h[0], h[1])
                }
            }

            function Zc() {
                this.__data__ = [], this.size = 0
            }

            function el(e) {
                var t = this.__data__, r = ys(t, e);
                if (r < 0) return !1;
                var h = t.length - 1;
                return r == h ? t.pop() : cs.call(t, r, 1), --this.size, !0
            }

            function tl(e) {
                var t = this.__data__, r = ys(t, e);
                return r < 0 ? d : t[r][1]
            }

            function nl(e) {
                return ys(this.__data__, e) > -1
            }

            function rl(e, t) {
                var r = this.__data__, h = ys(r, e);
                return h < 0 ? (++this.size, r.push([e, t])) : r[h][1] = t, this
            }

            _r.prototype.clear = Zc, _r.prototype.delete = el, _r.prototype.get = tl, _r.prototype.has = nl, _r.prototype.set = rl;

            function mr(e) {
                var t = -1, r = e == null ? 0 : e.length;
                for (this.clear(); ++t < r;) {
                    var h = e[t];
                    this.set(h[0], h[1])
                }
            }

            function il() {
                this.size = 0, this.__data__ = {hash: new Ti, map: new (Jo || _r), string: new Ti}
            }

            function ol(e) {
                var t = Os(this, e).delete(e);
                return this.size -= t ? 1 : 0, t
            }

            function sl(e) {
                return Os(this, e).get(e)
            }

            function ul(e) {
                return Os(this, e).has(e)
            }

            function al(e, t) {
                var r = Os(this, e), h = r.size;
                return r.set(e, t), this.size += r.size == h ? 0 : 1, this
            }

            mr.prototype.clear = il, mr.prototype.delete = ol, mr.prototype.get = sl, mr.prototype.has = ul, mr.prototype.set = al;

            function Ai(e) {
                var t = -1, r = e == null ? 0 : e.length;
                for (this.__data__ = new mr; ++t < r;) this.add(e[t])
            }

            function fl(e) {
                return this.__data__.set(e, B), this
            }

            function cl(e) {
                return this.__data__.has(e)
            }

            Ai.prototype.add = Ai.prototype.push = fl, Ai.prototype.has = cl;

            function Mn(e) {
                var t = this.__data__ = new _r(e);
                this.size = t.size
            }

            function ll() {
                this.__data__ = new _r, this.size = 0
            }

            function hl(e) {
                var t = this.__data__, r = t.delete(e);
                return this.size = t.size, r
            }

            function pl(e) {
                return this.__data__.get(e)
            }

            function dl(e) {
                return this.__data__.has(e)
            }

            function gl(e, t) {
                var r = this.__data__;
                if (r instanceof _r) {
                    var h = r.__data__;
                    if (!Jo || h.length < S - 1) return h.push([e, t]), this.size = ++r.size, this;
                    r = this.__data__ = new mr(h)
                }
                return r.set(e, t), this.size = r.size, this
            }

            Mn.prototype.clear = ll, Mn.prototype.delete = hl, Mn.prototype.get = pl, Mn.prototype.has = dl, Mn.prototype.set = gl;

            function ga(e, t) {
                var r = ye(e), h = !r && Ri(e), _ = !r && !h && Kr(e), x = !r && !h && !_ && yo(e),
                    O = r || h || _ || x, R = O ? gr(e.length, se) : [], D = R.length;
                for (var $ in e) (t || pe.call(e, $)) && !(O && ($ == "length" || _ && ($ == "offset" || $ == "parent") || x && ($ == "buffer" || $ == "byteLength" || $ == "byteOffset") || Sr($, D))) && R.push($);
                return R
            }

            function va(e) {
                var t = e.length;
                return t ? e[cu(0, t - 1)] : d
            }

            function vl(e, t) {
                return Ps(Kt(e), Ei(t, 0, e.length))
            }

            function yl(e) {
                return Ps(Kt(e))
            }

            function eu(e, t, r) {
                (r !== d && !qn(e[t], r) || r === d && !(t in e)) && br(e, t, r)
            }

            function Qo(e, t, r) {
                var h = e[t];
                (!(pe.call(e, t) && qn(h, r)) || r === d && !(t in e)) && br(e, t, r)
            }

            function ys(e, t) {
                for (var r = e.length; r--;) if (qn(e[r][0], t)) return r;
                return -1
            }

            function _l(e, t, r, h) {
                return Xr(e, function (_, x, O) {
                    t(h, _, r(_), O)
                }), h
            }

            function ya(e, t) {
                return e && tr(t, ct(t), e)
            }

            function ml(e, t) {
                return e && tr(t, Qt(t), e)
            }

            function br(e, t, r) {
                t == "__proto__" && ls ? ls(e, t, {configurable: !0, enumerable: !0, value: r, writable: !0}) : e[t] = r
            }

            function tu(e, t) {
                for (var r = -1, h = t.length, _ = g(h), x = e == null; ++r < h;) _[r] = x ? d : Du(e, t[r]);
                return _
            }

            function Ei(e, t, r) {
                return e === e && (r !== d && (e = e <= r ? e : r), t !== d && (e = e >= t ? e : t)), e
            }

            function Cn(e, t, r, h, _, x) {
                var O, R = t & ae, D = t & re, $ = t & ee;
                if (r && (O = _ ? r(e, h, _, x) : r(e)), O !== d) return O;
                if (!$e(e)) return e;
                var z = ye(e);
                if (z) {
                    if (O = uh(e), !R) return Kt(e, O)
                } else {
                    var V = kt(e), te = V == Je || V == Bn;
                    if (Kr(e)) return Ba(e, R);
                    if (V == wt || V == mt || te && !_) {
                        if (O = D || te ? {} : uf(e), !R) return D ? Kl(e, ml(O, e)) : Vl(e, ya(O, e))
                    } else {
                        if (!Re[V]) return _ ? e : {};
                        O = ah(e, V, R)
                    }
                }
                x || (x = new Mn);
                var fe = x.get(e);
                if (fe) return fe;
                x.set(e, O), Mf(e) ? e.forEach(function (he) {
                    O.add(Cn(he, t, r, he, e, x))
                }) : Nf(e) && e.forEach(function (he, Ae) {
                    O.set(Ae, Cn(he, t, r, Ae, e, x))
                });
                var le = $ ? D ? wu : bu : D ? Qt : ct, xe = z ? d : le(e);
                return k(xe || e, function (he, Ae) {
                    xe && (Ae = he, he = e[Ae]), Qo(O, Ae, Cn(he, t, r, Ae, e, x))
                }), O
            }

            function bl(e) {
                var t = ct(e);
                return function (r) {
                    return _a(r, e, t)
                }
            }

            function _a(e, t, r) {
                var h = r.length;
                if (e == null) return !h;
                for (e = X(e); h--;) {
                    var _ = r[h], x = t[_], O = e[_];
                    if (O === d && !(_ in e) || !x(O)) return !1
                }
                return !0
            }

            function ma(e, t, r) {
                if (typeof e != "function") throw new me(M);
                return os(function () {
                    e.apply(d, r)
                }, t)
            }

            function Zo(e, t, r, h) {
                var _ = -1, x = q, O = !0, R = e.length, D = [], $ = t.length;
                if (!R) return D;
                r && (t = ne(t, lt(r))), h ? (x = K, O = !1) : t.length >= S && (x = vr, O = !1, t = new Ai(t));
                e:for (; ++_ < R;) {
                    var z = e[_], V = r == null ? z : r(z);
                    if (z = h || z !== 0 ? z : 0, O && V === V) {
                        for (var te = $; te--;) if (t[te] === V) continue e;
                        D.push(z)
                    } else x(t, V, h) || D.push(z)
                }
                return D
            }

            var Xr = Xa(er), ba = Xa(ru, !0);

            function wl(e, t) {
                var r = !0;
                return Xr(e, function (h, _, x) {
                    return r = !!t(h, _, x), r
                }), r
            }

            function _s(e, t, r) {
                for (var h = -1, _ = e.length; ++h < _;) {
                    var x = e[h], O = t(x);
                    if (O != null && (R === d ? O === O && !sn(O) : r(O, R))) var R = O, D = x
                }
                return D
            }

            function xl(e, t, r, h) {
                var _ = e.length;
                for (r = be(r), r < 0 && (r = -r > _ ? 0 : _ + r), h = h === d || h > _ ? _ : be(h), h < 0 && (h += _), h = r > h ? 0 : Hf(h); r < h;) e[r++] = t;
                return e
            }

            function wa(e, t) {
                var r = [];
                return Xr(e, function (h, _, x) {
                    t(h, _, x) && r.push(h)
                }), r
            }

            function dt(e, t, r, h, _) {
                var x = -1, O = e.length;
                for (r || (r = ch), _ || (_ = []); ++x < O;) {
                    var R = e[x];
                    t > 0 && r(R) ? t > 1 ? dt(R, t - 1, r, h, _) : ve(_, R) : h || (_[_.length] = R)
                }
                return _
            }

            var nu = Ga(), xa = Ga(!0);

            function er(e, t) {
                return e && nu(e, t, ct)
            }

            function ru(e, t) {
                return e && xa(e, t, ct)
            }

            function ms(e, t) {
                return U(t, function (r) {
                    return Cr(e[r])
                })
            }

            function ki(e, t) {
                t = Jr(t, e);
                for (var r = 0, h = t.length; e != null && r < h;) e = e[nr(t[r++])];
                return r && r == h ? e : d
            }

            function Sa(e, t, r) {
                var h = t(e);
                return ye(e) ? h : ve(h, r(e))
            }

            function qt(e) {
                return e == null ? e === d ? sr : Pr : Ci && Ci in X(e) ? ih(e) : yh(e)
            }

            function iu(e, t) {
                return e > t
            }

            function Sl(e, t) {
                return e != null && pe.call(e, t)
            }

            function Cl(e, t) {
                return e != null && t in X(e)
            }

            function Tl(e, t, r) {
                return e >= Et(t, r) && e < ot(t, r)
            }

            function ou(e, t, r) {
                for (var h = r ? K : q, _ = e[0].length, x = e.length, O = x, R = g(x), D = 1 / 0, $ = []; O--;) {
                    var z = e[O];
                    O && t && (z = ne(z, lt(t))), D = Et(z.length, D), R[O] = !r && (t || _ >= 120 && z.length >= 120) ? new Ai(O && z) : d
                }
                z = e[0];
                var V = -1, te = R[0];
                e:for (; ++V < _ && $.length < D;) {
                    var fe = z[V], le = t ? t(fe) : fe;
                    if (fe = r || fe !== 0 ? fe : 0, !(te ? vr(te, le) : h($, le, r))) {
                        for (O = x; --O;) {
                            var xe = R[O];
                            if (!(xe ? vr(xe, le) : h(e[O], le, r))) continue e
                        }
                        te && te.push(le), $.push(fe)
                    }
                }
                return $
            }

            function Al(e, t, r, h) {
                return er(e, function (_, x, O) {
                    t(h, r(_), x, O)
                }), h
            }

            function es(e, t, r) {
                t = Jr(t, e), e = lf(e, t);
                var h = e == null ? e : e[nr(An(t))];
                return h == null ? d : b(h, e, r)
            }

            function Ca(e) {
                return Ge(e) && qt(e) == mt
            }

            function El(e) {
                return Ge(e) && qt(e) == ur
            }

            function kl(e) {
                return Ge(e) && qt(e) == We
            }

            function ts(e, t, r, h, _) {
                return e === t ? !0 : e == null || t == null || !Ge(e) && !Ge(t) ? e !== e && t !== t : Ol(e, t, r, h, ts, _)
            }

            function Ol(e, t, r, h, _, x) {
                var O = ye(e), R = ye(t), D = O ? Or : kt(e), $ = R ? Or : kt(t);
                D = D == mt ? wt : D, $ = $ == mt ? wt : $;
                var z = D == wt, V = $ == wt, te = D == $;
                if (te && Kr(e)) {
                    if (!Kr(t)) return !1;
                    O = !0, z = !1
                }
                if (te && !z) return x || (x = new Mn), O || yo(e) ? rf(e, t, r, h, _, x) : nh(e, t, D, r, h, _, x);
                if (!(r & Q)) {
                    var fe = z && pe.call(e, "__wrapped__"), le = V && pe.call(t, "__wrapped__");
                    if (fe || le) {
                        var xe = fe ? e.value() : e, he = le ? t.value() : t;
                        return x || (x = new Mn), _(xe, he, r, h, x)
                    }
                }
                return te ? (x || (x = new Mn), rh(e, t, r, h, _, x)) : !1
            }

            function Pl(e) {
                return Ge(e) && kt(e) == bt
            }

            function su(e, t, r, h) {
                var _ = r.length, x = _, O = !h;
                if (e == null) return !x;
                for (e = X(e); _--;) {
                    var R = r[_];
                    if (O && R[2] ? R[1] !== e[R[0]] : !(R[0] in e)) return !1
                }
                for (; ++_ < x;) {
                    R = r[_];
                    var D = R[0], $ = e[D], z = R[1];
                    if (O && R[2]) {
                        if ($ === d && !(D in e)) return !1
                    } else {
                        var V = new Mn;
                        if (h) var te = h($, z, D, e, t, V);
                        if (!(te === d ? ts(z, $, Q | J, h, V) : te)) return !1
                    }
                }
                return !0
            }

            function Ta(e) {
                if (!$e(e) || hh(e)) return !1;
                var t = Cr(e) ? zo : ti;
                return t.test(Pi(e))
            }

            function Rl(e) {
                return Ge(e) && qt(e) == or
            }

            function Ll(e) {
                return Ge(e) && kt(e) == xt
            }

            function Il(e) {
                return Ge(e) && Ms(e.length) && !!De[qt(e)]
            }

            function Aa(e) {
                return typeof e == "function" ? e : e == null ? Zt : typeof e == "object" ? ye(e) ? Oa(e[0], e[1]) : ka(e) : Vf(e)
            }

            function uu(e) {
                if (!is(e)) return Mc(e);
                var t = [];
                for (var r in X(e)) pe.call(e, r) && r != "constructor" && t.push(r);
                return t
            }

            function Nl(e) {
                if (!$e(e)) return vh(e);
                var t = is(e), r = [];
                for (var h in e) h == "constructor" && (t || !pe.call(e, h)) || r.push(h);
                return r
            }

            function au(e, t) {
                return e < t
            }

            function Ea(e, t) {
                var r = -1, h = Yt(e) ? g(e.length) : [];
                return Xr(e, function (_, x, O) {
                    h[++r] = t(_, x, O)
                }), h
            }

            function ka(e) {
                var t = Su(e);
                return t.length == 1 && t[0][2] ? ff(t[0][0], t[0][1]) : function (r) {
                    return r === e || su(r, e, t)
                }
            }

            function Oa(e, t) {
                return Tu(e) && af(t) ? ff(nr(e), t) : function (r) {
                    var h = Du(r, e);
                    return h === d && h === t ? Mu(r, e) : ts(t, h, Q | J)
                }
            }

            function bs(e, t, r, h, _) {
                e !== t && nu(t, function (x, O) {
                    if (_ || (_ = new Mn), $e(x)) Dl(e, t, O, r, bs, h, _); else {
                        var R = h ? h(Eu(e, O), x, O + "", e, t, _) : d;
                        R === d && (R = x), eu(e, O, R)
                    }
                }, Qt)
            }

            function Dl(e, t, r, h, _, x, O) {
                var R = Eu(e, r), D = Eu(t, r), $ = O.get(D);
                if ($) {
                    eu(e, r, $);
                    return
                }
                var z = x ? x(R, D, r + "", e, t, O) : d, V = z === d;
                if (V) {
                    var te = ye(D), fe = !te && Kr(D), le = !te && !fe && yo(D);
                    z = D, te || fe || le ? ye(R) ? z = R : Qe(R) ? z = Kt(R) : fe ? (V = !1, z = Ba(D, !0)) : le ? (V = !1, z = Fa(D, !0)) : z = [] : ss(D) || Ri(D) ? (z = R, Ri(R) ? z = jf(R) : (!$e(R) || Cr(R)) && (z = uf(D))) : V = !1
                }
                V && (O.set(D, z), _(z, D, h, x, O), O.delete(D)), eu(e, r, z)
            }

            function Pa(e, t) {
                var r = e.length;
                if (!!r) return t += t < 0 ? r : 0, Sr(t, r) ? e[t] : d
            }

            function Ra(e, t, r) {
                t.length ? t = ne(t, function (x) {
                    return ye(x) ? function (O) {
                        return ki(O, x.length === 1 ? x[0] : x)
                    } : x
                }) : t = [Zt];
                var h = -1;
                t = ne(t, lt(ce()));
                var _ = Ea(e, function (x, O, R) {
                    var D = ne(t, function ($) {
                        return $(x)
                    });
                    return {criteria: D, index: ++h, value: x}
                });
                return bn(_, function (x, O) {
                    return Jl(x, O, r)
                })
            }

            function Ml(e, t) {
                return La(e, t, function (r, h) {
                    return Mu(e, h)
                })
            }

            function La(e, t, r) {
                for (var h = -1, _ = t.length, x = {}; ++h < _;) {
                    var O = t[h], R = ki(e, O);
                    r(R, O) && ns(x, Jr(O, e), R)
                }
                return x
            }

            function ql(e) {
                return function (t) {
                    return ki(t, e)
                }
            }

            function fu(e, t, r, h) {
                var _ = h ? mn : Le, x = -1, O = t.length, R = e;
                for (e === t && (t = Kt(t)), r && (R = ne(e, lt(r))); ++x < O;) for (var D = 0, $ = t[x], z = r ? r($) : $; (D = _(R, z, D, h)) > -1;) R !== e && cs.call(R, D, 1), cs.call(e, D, 1);
                return e
            }

            function Ia(e, t) {
                for (var r = e ? t.length : 0, h = r - 1; r--;) {
                    var _ = t[r];
                    if (r == h || _ !== x) {
                        var x = _;
                        Sr(_) ? cs.call(e, _, 1) : pu(e, _)
                    }
                }
                return e
            }

            function cu(e, t) {
                return e + ps(pa() * (t - e + 1))
            }

            function Hl(e, t, r, h) {
                for (var _ = -1, x = ot(hs((t - e) / (r || 1)), 0), O = g(x); x--;) O[h ? x : ++_] = e, e += r;
                return O
            }

            function lu(e, t) {
                var r = "";
                if (!e || t < 1 || t > Wt) return r;
                do t % 2 && (r += e), t = ps(t / 2), t && (e += e); while (t);
                return r
            }

            function Ce(e, t) {
                return ku(cf(e, t, Zt), e + "")
            }

            function jl(e) {
                return va(_o(e))
            }

            function Ul(e, t) {
                var r = _o(e);
                return Ps(r, Ei(t, 0, r.length))
            }

            function ns(e, t, r, h) {
                if (!$e(e)) return e;
                t = Jr(t, e);
                for (var _ = -1, x = t.length, O = x - 1, R = e; R != null && ++_ < x;) {
                    var D = nr(t[_]), $ = r;
                    if (D === "__proto__" || D === "constructor" || D === "prototype") return e;
                    if (_ != O) {
                        var z = R[D];
                        $ = h ? h(z, D, R) : d, $ === d && ($ = $e(z) ? z : Sr(t[_ + 1]) ? [] : {})
                    }
                    Qo(R, D, $), R = R[D]
                }
                return e
            }

            var Na = ds ? function (e, t) {
                return ds.set(e, t), e
            } : Zt, Bl = ls ? function (e, t) {
                return ls(e, "toString", {configurable: !0, enumerable: !1, value: Hu(t), writable: !0})
            } : Zt;

            function Fl(e) {
                return Ps(_o(e))
            }

            function Tn(e, t, r) {
                var h = -1, _ = e.length;
                t < 0 && (t = -t > _ ? 0 : _ + t), r = r > _ ? _ : r, r < 0 && (r += _), _ = t > r ? 0 : r - t >>> 0, t >>>= 0;
                for (var x = g(_); ++h < _;) x[h] = e[h + t];
                return x
            }

            function Wl(e, t) {
                var r;
                return Xr(e, function (h, _, x) {
                    return r = t(h, _, x), !r
                }), !!r
            }

            function ws(e, t, r) {
                var h = 0, _ = e == null ? h : e.length;
                if (typeof t == "number" && t === t && _ <= Qr) {
                    for (; h < _;) {
                        var x = h + _ >>> 1, O = e[x];
                        O !== null && !sn(O) && (r ? O <= t : O < t) ? h = x + 1 : _ = x
                    }
                    return _
                }
                return hu(e, t, Zt, r)
            }

            function hu(e, t, r, h) {
                var _ = 0, x = e == null ? 0 : e.length;
                if (x === 0) return 0;
                t = r(t);
                for (var O = t !== t, R = t === null, D = sn(t), $ = t === d; _ < x;) {
                    var z = ps((_ + x) / 2), V = r(e[z]), te = V !== d, fe = V === null, le = V === V, xe = sn(V);
                    if (O) var he = h || le; else $ ? he = le && (h || te) : R ? he = le && te && (h || !fe) : D ? he = le && te && !fe && (h || !xe) : fe || xe ? he = !1 : he = h ? V <= t : V < t;
                    he ? _ = z + 1 : x = z
                }
                return Et(x, Yr)
            }

            function Da(e, t) {
                for (var r = -1, h = e.length, _ = 0, x = []; ++r < h;) {
                    var O = e[r], R = t ? t(O) : O;
                    if (!r || !qn(R, D)) {
                        var D = R;
                        x[_++] = O === 0 ? 0 : O
                    }
                }
                return x
            }

            function Ma(e) {
                return typeof e == "number" ? e : sn(e) ? rr : +e
            }

            function on(e) {
                if (typeof e == "string") return e;
                if (ye(e)) return ne(e, on) + "";
                if (sn(e)) return da ? da.call(e) : "";
                var t = e + "";
                return t == "0" && 1 / e == -it ? "-0" : t
            }

            function Gr(e, t, r) {
                var h = -1, _ = q, x = e.length, O = !0, R = [], D = R;
                if (r) O = !1, _ = K; else if (x >= S) {
                    var $ = t ? null : eh(e);
                    if ($) return Dn($);
                    O = !1, _ = vr, D = new Ai
                } else D = t ? [] : R;
                e:for (; ++h < x;) {
                    var z = e[h], V = t ? t(z) : z;
                    if (z = r || z !== 0 ? z : 0, O && V === V) {
                        for (var te = D.length; te--;) if (D[te] === V) continue e;
                        t && D.push(V), R.push(z)
                    } else _(D, V, r) || (D !== R && D.push(V), R.push(z))
                }
                return R
            }

            function pu(e, t) {
                return t = Jr(t, e), e = lf(e, t), e == null || delete e[nr(An(t))]
            }

            function qa(e, t, r, h) {
                return ns(e, t, r(ki(e, t)), h)
            }

            function xs(e, t, r, h) {
                for (var _ = e.length, x = h ? _ : -1; (h ? x-- : ++x < _) && t(e[x], x, e);) ;
                return r ? Tn(e, h ? 0 : x, h ? x + 1 : _) : Tn(e, h ? x + 1 : 0, h ? _ : x)
            }

            function Ha(e, t) {
                var r = e;
                return r instanceof Ee && (r = r.value()), ge(t, function (h, _) {
                    return _.func.apply(_.thisArg, ve([h], _.args))
                }, r)
            }

            function du(e, t, r) {
                var h = e.length;
                if (h < 2) return h ? Gr(e[0]) : [];
                for (var _ = -1, x = g(h); ++_ < h;) for (var O = e[_], R = -1; ++R < h;) R != _ && (x[_] = Zo(x[_] || O, e[R], t, r));
                return Gr(dt(x, 1), t, r)
            }

            function ja(e, t, r) {
                for (var h = -1, _ = e.length, x = t.length, O = {}; ++h < _;) {
                    var R = h < x ? t[h] : d;
                    r(O, e[h], R)
                }
                return O
            }

            function gu(e) {
                return Qe(e) ? e : []
            }

            function vu(e) {
                return typeof e == "function" ? e : Zt
            }

            function Jr(e, t) {
                return ye(e) ? e : Tu(e, t) ? [e] : gf(Me(e))
            }

            var $l = Ce;

            function Vr(e, t, r) {
                var h = e.length;
                return r = r === d ? h : r, !t && r >= h ? e : Tn(e, t, r)
            }

            var Ua = Rc || function (e) {
                return je.clearTimeout(e)
            };

            function Ba(e, t) {
                if (t) return e.slice();
                var r = e.length, h = fs ? fs(r) : new e.constructor(r);
                return e.copy(h), h
            }

            function yu(e) {
                var t = new e.constructor(e.byteLength);
                return new ao(t).set(new ao(e)), t
            }

            function zl(e, t) {
                var r = t ? yu(e.buffer) : e.buffer;
                return new e.constructor(r, e.byteOffset, e.byteLength)
            }

            function Xl(e) {
                var t = new e.constructor(e.source, $i.exec(e));
                return t.lastIndex = e.lastIndex, t
            }

            function Gl(e) {
                return Yo ? X(Yo.call(e)) : {}
            }

            function Fa(e, t) {
                var r = t ? yu(e.buffer) : e.buffer;
                return new e.constructor(r, e.byteOffset, e.length)
            }

            function Wa(e, t) {
                if (e !== t) {
                    var r = e !== d, h = e === null, _ = e === e, x = sn(e), O = t !== d, R = t === null, D = t === t,
                        $ = sn(t);
                    if (!R && !$ && !x && e > t || x && O && D && !R && !$ || h && O && D || !r && D || !_) return 1;
                    if (!h && !x && !$ && e < t || $ && r && _ && !h && !x || R && r && _ || !O && _ || !D) return -1
                }
                return 0
            }

            function Jl(e, t, r) {
                for (var h = -1, _ = e.criteria, x = t.criteria, O = _.length, R = r.length; ++h < O;) {
                    var D = Wa(_[h], x[h]);
                    if (D) {
                        if (h >= R) return D;
                        var $ = r[h];
                        return D * ($ == "desc" ? -1 : 1)
                    }
                }
                return e.index - t.index
            }

            function $a(e, t, r, h) {
                for (var _ = -1, x = e.length, O = r.length, R = -1, D = t.length, $ = ot(x - O, 0), z = g(D + $), V = !h; ++R < D;) z[R] = t[R];
                for (; ++_ < O;) (V || _ < x) && (z[r[_]] = e[_]);
                for (; $--;) z[R++] = e[_++];
                return z
            }

            function za(e, t, r, h) {
                for (var _ = -1, x = e.length, O = -1, R = r.length, D = -1, $ = t.length, z = ot(x - R, 0), V = g(z + $), te = !h; ++_ < z;) V[_] = e[_];
                for (var fe = _; ++D < $;) V[fe + D] = t[D];
                for (; ++O < R;) (te || _ < x) && (V[fe + r[O]] = e[_++]);
                return V
            }

            function Kt(e, t) {
                var r = -1, h = e.length;
                for (t || (t = g(h)); ++r < h;) t[r] = e[r];
                return t
            }

            function tr(e, t, r, h) {
                var _ = !r;
                r || (r = {});
                for (var x = -1, O = t.length; ++x < O;) {
                    var R = t[x], D = h ? h(r[R], e[R], R, r, e) : d;
                    D === d && (D = e[R]), _ ? br(r, R, D) : Qo(r, R, D)
                }
                return r
            }

            function Vl(e, t) {
                return tr(e, Cu(e), t)
            }

            function Kl(e, t) {
                return tr(e, of(e), t)
            }

            function Ss(e, t) {
                return function (r, h) {
                    var _ = ye(r) ? P : _l, x = t ? t() : {};
                    return _(r, e, ce(h, 2), x)
                }
            }

            function po(e) {
                return Ce(function (t, r) {
                    var h = -1, _ = r.length, x = _ > 1 ? r[_ - 1] : d, O = _ > 2 ? r[2] : d;
                    for (x = e.length > 3 && typeof x == "function" ? (_--, x) : d, O && Ht(r[0], r[1], O) && (x = _ < 3 ? d : x, _ = 1), t = X(t); ++h < _;) {
                        var R = r[h];
                        R && e(t, R, h, x)
                    }
                    return t
                })
            }

            function Xa(e, t) {
                return function (r, h) {
                    if (r == null) return r;
                    if (!Yt(r)) return e(r, h);
                    for (var _ = r.length, x = t ? _ : -1, O = X(r); (t ? x-- : ++x < _) && h(O[x], x, O) !== !1;) ;
                    return r
                }
            }

            function Ga(e) {
                return function (t, r, h) {
                    for (var _ = -1, x = X(t), O = h(t), R = O.length; R--;) {
                        var D = O[e ? R : ++_];
                        if (r(x[D], D, x) === !1) break
                    }
                    return t
                }
            }

            function Yl(e, t, r) {
                var h = t & G, _ = rs(e);

                function x() {
                    var O = this && this !== je && this instanceof x ? _ : e;
                    return O.apply(h ? r : this, arguments)
                }

                return x
            }

            function Ja(e) {
                return function (t) {
                    t = Me(t);
                    var r = At(t) ? ht(t) : d, h = r ? r[0] : t.charAt(0), _ = r ? Vr(r, 1).join("") : t.slice(1);
                    return h[e]() + _
                }
            }

            function go(e) {
                return function (t) {
                    return ge(Gf(Xf(t).replace(dr, "")), e, "")
                }
            }

            function rs(e) {
                return function () {
                    var t = arguments;
                    switch (t.length) {
                        case 0:
                            return new e;
                        case 1:
                            return new e(t[0]);
                        case 2:
                            return new e(t[0], t[1]);
                        case 3:
                            return new e(t[0], t[1], t[2]);
                        case 4:
                            return new e(t[0], t[1], t[2], t[3]);
                        case 5:
                            return new e(t[0], t[1], t[2], t[3], t[4]);
                        case 6:
                            return new e(t[0], t[1], t[2], t[3], t[4], t[5]);
                        case 7:
                            return new e(t[0], t[1], t[2], t[3], t[4], t[5], t[6])
                    }
                    var r = ho(e.prototype), h = e.apply(r, t);
                    return $e(h) ? h : r
                }
            }

            function Ql(e, t, r) {
                var h = rs(e);

                function _() {
                    for (var x = arguments.length, O = g(x), R = x, D = vo(_); R--;) O[R] = arguments[R];
                    var $ = x < 3 && O[0] !== D && O[x - 1] !== D ? [] : Mt(O, D);
                    if (x -= $.length, x < r) return Za(e, t, Cs, _.placeholder, d, O, $, d, d, r - x);
                    var z = this && this !== je && this instanceof _ ? h : e;
                    return b(z, this, O)
                }

                return _
            }

            function Va(e) {
                return function (t, r, h) {
                    var _ = X(t);
                    if (!Yt(t)) {
                        var x = ce(r, 3);
                        t = ct(t), r = function (R) {
                            return x(_[R], R, _)
                        }
                    }
                    var O = e(t, r, h);
                    return O > -1 ? _[x ? t[O] : O] : d
                }
            }

            function Ka(e) {
                return xr(function (t) {
                    var r = t.length, h = r, _ = Sn.prototype.thru;
                    for (e && t.reverse(); h--;) {
                        var x = t[h];
                        if (typeof x != "function") throw new me(M);
                        if (_ && !O && ks(x) == "wrapper") var O = new Sn([], !0)
                    }
                    for (h = O ? h : r; ++h < r;) {
                        x = t[h];
                        var R = ks(x), D = R == "wrapper" ? xu(x) : d;
                        D && Au(D[0]) && D[1] == (p | Te | He | tt) && !D[4].length && D[9] == 1 ? O = O[ks(D[0])].apply(O, D[3]) : O = x.length == 1 && Au(x) ? O[R]() : O.thru(x)
                    }
                    return function () {
                        var $ = arguments, z = $[0];
                        if (O && $.length == 1 && ye(z)) return O.plant(z).value();
                        for (var V = 0, te = r ? t[V].apply(this, $) : z; ++V < r;) te = t[V].call(this, te);
                        return te
                    }
                })
            }

            function Cs(e, t, r, h, _, x, O, R, D, $) {
                var z = t & p, V = t & G, te = t & F, fe = t & (Te | Ne), le = t & _e, xe = te ? d : rs(e);

                function he() {
                    for (var Ae = arguments.length, ke = g(Ae), un = Ae; un--;) ke[un] = arguments[un];
                    if (fe) var jt = vo(he), an = nt(ke, jt);
                    if (h && (ke = $a(ke, h, _, fe)), x && (ke = za(ke, x, O, fe)), Ae -= an, fe && Ae < $) {
                        var Ze = Mt(ke, jt);
                        return Za(e, t, Cs, he.placeholder, r, ke, Ze, R, D, $ - Ae)
                    }
                    var Hn = V ? r : this, Ar = te ? Hn[e] : e;
                    return Ae = ke.length, R ? ke = _h(ke, R) : le && Ae > 1 && ke.reverse(), z && D < Ae && (ke.length = D), this && this !== je && this instanceof he && (Ar = xe || rs(Ar)), Ar.apply(Hn, ke)
                }

                return he
            }

            function Ya(e, t) {
                return function (r, h) {
                    return Al(r, e, t(h), {})
                }
            }

            function Ts(e, t) {
                return function (r, h) {
                    var _;
                    if (r === d && h === d) return t;
                    if (r !== d && (_ = r), h !== d) {
                        if (_ === d) return h;
                        typeof r == "string" || typeof h == "string" ? (r = on(r), h = on(h)) : (r = Ma(r), h = Ma(h)), _ = e(r, h)
                    }
                    return _
                }
            }

            function _u(e) {
                return xr(function (t) {
                    return t = ne(t, lt(ce())), Ce(function (r) {
                        var h = this;
                        return e(t, function (_) {
                            return b(_, h, r)
                        })
                    })
                })
            }

            function As(e, t) {
                t = t === d ? " " : on(t);
                var r = t.length;
                if (r < 2) return r ? lu(t, e) : t;
                var h = lu(t, hs(e / xn(t)));
                return At(t) ? Vr(ht(h), 0, e).join("") : h.slice(0, e)
            }

            function Zl(e, t, r, h) {
                var _ = t & G, x = rs(e);

                function O() {
                    for (var R = -1, D = arguments.length, $ = -1, z = h.length, V = g(z + D), te = this && this !== je && this instanceof O ? x : e; ++$ < z;) V[$] = h[$];
                    for (; D--;) V[$++] = arguments[++R];
                    return b(te, _ ? r : this, V)
                }

                return O
            }

            function Qa(e) {
                return function (t, r, h) {
                    return h && typeof h != "number" && Ht(t, r, h) && (r = h = d), t = Tr(t), r === d ? (r = t, t = 0) : r = Tr(r), h = h === d ? t < r ? 1 : -1 : Tr(h), Hl(t, r, h, e)
                }
            }

            function Es(e) {
                return function (t, r) {
                    return typeof t == "string" && typeof r == "string" || (t = En(t), r = En(r)), e(t, r)
                }
            }

            function Za(e, t, r, h, _, x, O, R, D, $) {
                var z = t & Te, V = z ? O : d, te = z ? d : O, fe = z ? x : d, le = z ? d : x;
                t |= z ? He : et, t &= ~(z ? et : He), t & de || (t &= ~(G | F));
                var xe = [e, t, _, fe, V, le, te, R, D, $], he = r.apply(d, xe);
                return Au(e) && hf(he, xe), he.placeholder = h, pf(he, e, t)
            }

            function mu(e) {
                var t = j[e];
                return function (r, h) {
                    if (r = En(r), h = h == null ? 0 : Et(be(h), 292), h && ha(r)) {
                        var _ = (Me(r) + "e").split("e"), x = t(_[0] + "e" + (+_[1] + h));
                        return _ = (Me(x) + "e").split("e"), +(_[0] + "e" + (+_[1] - h))
                    }
                    return t(r)
                }
            }

            var eh = co && 1 / Dn(new co([, -0]))[1] == it ? function (e) {
                return new co(e)
            } : Bu;

            function ef(e) {
                return function (t) {
                    var r = kt(t);
                    return r == bt ? Fr(t) : r == xt ? wi(t) : rn(t, e(t))
                }
            }

            function wr(e, t, r, h, _, x, O, R) {
                var D = t & F;
                if (!D && typeof e != "function") throw new me(M);
                var $ = h ? h.length : 0;
                if ($ || (t &= ~(He | et), h = _ = d), O = O === d ? O : ot(be(O), 0), R = R === d ? R : be(R), $ -= _ ? _.length : 0, t & et) {
                    var z = h, V = _;
                    h = _ = d
                }
                var te = D ? d : xu(e), fe = [e, t, r, h, _, z, V, x, O, R];
                if (te && gh(fe, te), e = fe[0], t = fe[1], r = fe[2], h = fe[3], _ = fe[4], R = fe[9] = fe[9] === d ? D ? 0 : e.length : ot(fe[9] - $, 0), !R && t & (Te | Ne) && (t &= ~(Te | Ne)), !t || t == G) var le = Yl(e, t, r); else t == Te || t == Ne ? le = Ql(e, t, R) : (t == He || t == (G | He)) && !_.length ? le = Zl(e, t, r, h) : le = Cs.apply(d, fe);
                var xe = te ? Na : hf;
                return pf(xe(le, fe), e, t)
            }

            function tf(e, t, r, h) {
                return e === d || qn(e, Xe[r]) && !pe.call(h, r) ? t : e
            }

            function nf(e, t, r, h, _, x) {
                return $e(e) && $e(t) && (x.set(t, e), bs(e, t, d, nf, x), x.delete(t)), e
            }

            function th(e) {
                return ss(e) ? d : e
            }

            function rf(e, t, r, h, _, x) {
                var O = r & Q, R = e.length, D = t.length;
                if (R != D && !(O && D > R)) return !1;
                var $ = x.get(e), z = x.get(t);
                if ($ && z) return $ == t && z == e;
                var V = -1, te = !0, fe = r & J ? new Ai : d;
                for (x.set(e, t), x.set(t, e); ++V < R;) {
                    var le = e[V], xe = t[V];
                    if (h) var he = O ? h(xe, le, V, t, e, x) : h(le, xe, V, e, t, x);
                    if (he !== d) {
                        if (he) continue;
                        te = !1;
                        break
                    }
                    if (fe) {
                        if (!Ue(t, function (Ae, ke) {
                            if (!vr(fe, ke) && (le === Ae || _(le, Ae, r, h, x))) return fe.push(ke)
                        })) {
                            te = !1;
                            break
                        }
                    } else if (!(le === xe || _(le, xe, r, h, x))) {
                        te = !1;
                        break
                    }
                }
                return x.delete(e), x.delete(t), te
            }

            function nh(e, t, r, h, _, x, O) {
                switch (r) {
                    case Pe:
                        if (e.byteLength != t.byteLength || e.byteOffset != t.byteOffset) return !1;
                        e = e.buffer, t = t.buffer;
                    case ur:
                        return !(e.byteLength != t.byteLength || !x(new ao(e), new ao(t)));
                    case Be:
                    case We:
                    case en:
                        return qn(+e, +t);
                    case ir:
                        return e.name == t.name && e.message == t.message;
                    case or:
                    case st:
                        return e == t + "";
                    case bt:
                        var R = Fr;
                    case xt:
                        var D = h & Q;
                        if (R || (R = Dn), e.size != t.size && !D) return !1;
                        var $ = O.get(e);
                        if ($) return $ == t;
                        h |= J, O.set(e, t);
                        var z = rf(R(e), R(t), h, _, x, O);
                        return O.delete(e), z;
                    case hn:
                        if (Yo) return Yo.call(e) == Yo.call(t)
                }
                return !1
            }

            function rh(e, t, r, h, _, x) {
                var O = r & Q, R = bu(e), D = R.length, $ = bu(t), z = $.length;
                if (D != z && !O) return !1;
                for (var V = D; V--;) {
                    var te = R[V];
                    if (!(O ? te in t : pe.call(t, te))) return !1
                }
                var fe = x.get(e), le = x.get(t);
                if (fe && le) return fe == t && le == e;
                var xe = !0;
                x.set(e, t), x.set(t, e);
                for (var he = O; ++V < D;) {
                    te = R[V];
                    var Ae = e[te], ke = t[te];
                    if (h) var un = O ? h(ke, Ae, te, t, e, x) : h(Ae, ke, te, e, t, x);
                    if (!(un === d ? Ae === ke || _(Ae, ke, r, h, x) : un)) {
                        xe = !1;
                        break
                    }
                    he || (he = te == "constructor")
                }
                if (xe && !he) {
                    var jt = e.constructor, an = t.constructor;
                    jt != an && "constructor" in e && "constructor" in t && !(typeof jt == "function" && jt instanceof jt && typeof an == "function" && an instanceof an) && (xe = !1)
                }
                return x.delete(e), x.delete(t), xe
            }

            function xr(e) {
                return ku(cf(e, d, mf), e + "")
            }

            function bu(e) {
                return Sa(e, ct, Cu)
            }

            function wu(e) {
                return Sa(e, Qt, of)
            }

            var xu = ds ? function (e) {
                return ds.get(e)
            } : Bu;

            function ks(e) {
                for (var t = e.name + "", r = lo[t], h = pe.call(lo, t) ? r.length : 0; h--;) {
                    var _ = r[h], x = _.func;
                    if (x == null || x == e) return _.name
                }
                return t
            }

            function vo(e) {
                var t = pe.call(w, "placeholder") ? w : e;
                return t.placeholder
            }

            function ce() {
                var e = w.iteratee || ju;
                return e = e === ju ? Aa : e, arguments.length ? e(arguments[0], arguments[1]) : e
            }

            function Os(e, t) {
                var r = e.__data__;
                return lh(t) ? r[typeof t == "string" ? "string" : "hash"] : r.map
            }

            function Su(e) {
                for (var t = ct(e), r = t.length; r--;) {
                    var h = t[r], _ = e[h];
                    t[r] = [h, _, af(_)]
                }
                return t
            }

            function Oi(e, t) {
                var r = mi(e, t);
                return Ta(r) ? r : d
            }

            function ih(e) {
                var t = pe.call(e, Ci), r = e[Ci];
                try {
                    e[Ci] = d;
                    var h = !0
                } catch {
                }
                var _ = xi.call(e);
                return h && (t ? e[Ci] = r : delete e[Ci]), _
            }

            var Cu = Ys ? function (e) {
                return e == null ? [] : (e = X(e), U(Ys(e), function (t) {
                    return ca.call(e, t)
                }))
            } : Fu, of = Ys ? function (e) {
                for (var t = []; e;) ve(t, Cu(e)), e = fo(e);
                return t
            } : Fu, kt = qt;
            (Qs && kt(new Qs(new ArrayBuffer(1))) != Pe || Jo && kt(new Jo) != bt || Zs && kt(Zs.resolve()) != Pt || co && kt(new co) != xt || Vo && kt(new Vo) != oe) && (kt = function (e) {
                var t = qt(e), r = t == wt ? e.constructor : d, h = r ? Pi(r) : "";
                if (h) switch (h) {
                    case Uc:
                        return Pe;
                    case Bc:
                        return bt;
                    case Fc:
                        return Pt;
                    case Wc:
                        return xt;
                    case $c:
                        return oe
                }
                return t
            });

            function oh(e, t, r) {
                for (var h = -1, _ = r.length; ++h < _;) {
                    var x = r[h], O = x.size;
                    switch (x.type) {
                        case"drop":
                            e += O;
                            break;
                        case"dropRight":
                            t -= O;
                            break;
                        case"take":
                            t = Et(t, e + O);
                            break;
                        case"takeRight":
                            e = ot(e, t - O);
                            break
                    }
                }
                return {start: e, end: t}
            }

            function sh(e) {
                var t = e.match(Bi);
                return t ? t[1].split(Fi) : []
            }

            function sf(e, t, r) {
                t = Jr(t, e);
                for (var h = -1, _ = t.length, x = !1; ++h < _;) {
                    var O = nr(t[h]);
                    if (!(x = e != null && r(e, O))) break;
                    e = e[O]
                }
                return x || ++h != _ ? x : (_ = e == null ? 0 : e.length, !!_ && Ms(_) && Sr(O, _) && (ye(e) || Ri(e)))
            }

            function uh(e) {
                var t = e.length, r = new e.constructor(t);
                return t && typeof e[0] == "string" && pe.call(e, "index") && (r.index = e.index, r.input = e.input), r
            }

            function uf(e) {
                return typeof e.constructor == "function" && !is(e) ? ho(fo(e)) : {}
            }

            function ah(e, t, r) {
                var h = e.constructor;
                switch (t) {
                    case ur:
                        return yu(e);
                    case Be:
                    case We:
                        return new h(+e);
                    case Pe:
                        return zl(e, r);
                    case Zr:
                    case Rr:
                    case Lr:
                    case kn:
                    case Rt:
                    case tn:
                    case pn:
                    case ei:
                    case Fn:
                        return Fa(e, r);
                    case bt:
                        return new h;
                    case en:
                    case st:
                        return new h(e);
                    case or:
                        return Xl(e);
                    case xt:
                        return new h;
                    case hn:
                        return Gl(e)
                }
            }

            function fh(e, t) {
                var r = t.length;
                if (!r) return e;
                var h = r - 1;
                return t[h] = (r > 1 ? "& " : "") + t[h], t = t.join(r > 2 ? ", " : " "), e.replace(Ui, `{
/* [wrapped with ` + t + `] */
`)
            }

            function ch(e) {
                return ye(e) || Ri(e) || !!(la && e && e[la])
            }

            function Sr(e, t) {
                var r = typeof e;
                return t = t == null ? Wt : t, !!t && (r == "number" || r != "symbol" && Dr.test(e)) && e > -1 && e % 1 == 0 && e < t
            }

            function Ht(e, t, r) {
                if (!$e(r)) return !1;
                var h = typeof t;
                return (h == "number" ? Yt(r) && Sr(t, r.length) : h == "string" && t in r) ? qn(r[t], e) : !1
            }

            function Tu(e, t) {
                if (ye(e)) return !1;
                var r = typeof e;
                return r == "number" || r == "symbol" || r == "boolean" || e == null || sn(e) ? !0 : Hi.test(e) || !ko.test(e) || t != null && e in X(t)
            }

            function lh(e) {
                var t = typeof e;
                return t == "string" || t == "number" || t == "symbol" || t == "boolean" ? e !== "__proto__" : e === null
            }

            function Au(e) {
                var t = ks(e), r = w[t];
                if (typeof r != "function" || !(t in Ee.prototype)) return !1;
                if (e === r) return !0;
                var h = xu(r);
                return !!h && e === h[0]
            }

            function hh(e) {
                return !!Wo && Wo in e
            }

            var ph = pt ? Cr : Wu;

            function is(e) {
                var t = e && e.constructor, r = typeof t == "function" && t.prototype || Xe;
                return e === r
            }

            function af(e) {
                return e === e && !$e(e)
            }

            function ff(e, t) {
                return function (r) {
                    return r == null ? !1 : r[e] === t && (t !== d || e in X(r))
                }
            }

            function dh(e) {
                var t = Ns(e, function (h) {
                    return r.size === qe && r.clear(), h
                }), r = t.cache;
                return t
            }

            function gh(e, t) {
                var r = e[1], h = t[1], _ = r | h, x = _ < (G | F | p),
                    O = h == p && r == Te || h == p && r == tt && e[7].length <= t[8] || h == (p | tt) && t[7].length <= t[8] && r == Te;
                if (!(x || O)) return e;
                h & G && (e[2] = t[2], _ |= r & G ? 0 : de);
                var R = t[3];
                if (R) {
                    var D = e[3];
                    e[3] = D ? $a(D, R, t[4]) : R, e[4] = D ? Mt(e[3], Se) : t[4]
                }
                return R = t[5], R && (D = e[5], e[5] = D ? za(D, R, t[6]) : R, e[6] = D ? Mt(e[5], Se) : t[6]), R = t[7], R && (e[7] = R), h & p && (e[8] = e[8] == null ? t[8] : Et(e[8], t[8])), e[9] == null && (e[9] = t[9]), e[0] = t[0], e[1] = _, e
            }

            function vh(e) {
                var t = [];
                if (e != null) for (var r in X(e)) t.push(r);
                return t
            }

            function yh(e) {
                return xi.call(e)
            }

            function cf(e, t, r) {
                return t = ot(t === d ? e.length - 1 : t, 0), function () {
                    for (var h = arguments, _ = -1, x = ot(h.length - t, 0), O = g(x); ++_ < x;) O[_] = h[t + _];
                    _ = -1;
                    for (var R = g(t + 1); ++_ < t;) R[_] = h[_];
                    return R[t] = r(O), b(e, this, R)
                }
            }

            function lf(e, t) {
                return t.length < 2 ? e : ki(e, Tn(t, 0, -1))
            }

            function _h(e, t) {
                for (var r = e.length, h = Et(t.length, r), _ = Kt(e); h--;) {
                    var x = t[h];
                    e[h] = Sr(x, r) ? _[x] : d
                }
                return e
            }

            function Eu(e, t) {
                if (!(t === "constructor" && typeof e[t] == "function") && t != "__proto__") return e[t]
            }

            var hf = df(Na), os = Ic || function (e, t) {
                return je.setTimeout(e, t)
            }, ku = df(Bl);

            function pf(e, t, r) {
                var h = t + "";
                return ku(e, fh(h, mh(sh(h), r)))
            }

            function df(e) {
                var t = 0, r = 0;
                return function () {
                    var h = qc(), _ = Ie - (h - r);
                    if (r = h, _ > 0) {
                        if (++t >= Co) return arguments[0]
                    } else t = 0;
                    return e.apply(d, arguments)
                }
            }

            function Ps(e, t) {
                var r = -1, h = e.length, _ = h - 1;
                for (t = t === d ? h : t; ++r < t;) {
                    var x = cu(r, _), O = e[x];
                    e[x] = e[r], e[r] = O
                }
                return e.length = t, e
            }

            var gf = dh(function (e) {
                var t = [];
                return e.charCodeAt(0) === 46 && t.push(""), e.replace(ji, function (r, h, _, x) {
                    t.push(_ ? x.replace(Po, "$1") : h || r)
                }), t
            });

            function nr(e) {
                if (typeof e == "string" || sn(e)) return e;
                var t = e + "";
                return t == "0" && 1 / e == -it ? "-0" : t
            }

            function Pi(e) {
                if (e != null) {
                    try {
                        return Vt.call(e)
                    } catch {
                    }
                    try {
                        return e + ""
                    } catch {
                    }
                }
                return ""
            }

            function mh(e, t) {
                return k(Ni, function (r) {
                    var h = "_." + r[0];
                    t & r[1] && !q(e, h) && e.push(h)
                }), e.sort()
            }

            function vf(e) {
                if (e instanceof Ee) return e.clone();
                var t = new Sn(e.__wrapped__, e.__chain__);
                return t.__actions__ = Kt(e.__actions__), t.__index__ = e.__index__, t.__values__ = e.__values__, t
            }

            function bh(e, t, r) {
                (r ? Ht(e, t, r) : t === d) ? t = 1 : t = ot(be(t), 0);
                var h = e == null ? 0 : e.length;
                if (!h || t < 1) return [];
                for (var _ = 0, x = 0, O = g(hs(h / t)); _ < h;) O[x++] = Tn(e, _, _ += t);
                return O
            }

            function wh(e) {
                for (var t = -1, r = e == null ? 0 : e.length, h = 0, _ = []; ++t < r;) {
                    var x = e[t];
                    x && (_[h++] = x)
                }
                return _
            }

            function xh() {
                var e = arguments.length;
                if (!e) return [];
                for (var t = g(e - 1), r = arguments[0], h = e; h--;) t[h - 1] = arguments[h];
                return ve(ye(r) ? Kt(r) : [r], dt(t, 1))
            }

            var Sh = Ce(function (e, t) {
                return Qe(e) ? Zo(e, dt(t, 1, Qe, !0)) : []
            }), Ch = Ce(function (e, t) {
                var r = An(t);
                return Qe(r) && (r = d), Qe(e) ? Zo(e, dt(t, 1, Qe, !0), ce(r, 2)) : []
            }), Th = Ce(function (e, t) {
                var r = An(t);
                return Qe(r) && (r = d), Qe(e) ? Zo(e, dt(t, 1, Qe, !0), d, r) : []
            });

            function Ah(e, t, r) {
                var h = e == null ? 0 : e.length;
                return h ? (t = r || t === d ? 1 : be(t), Tn(e, t < 0 ? 0 : t, h)) : []
            }

            function Eh(e, t, r) {
                var h = e == null ? 0 : e.length;
                return h ? (t = r || t === d ? 1 : be(t), t = h - t, Tn(e, 0, t < 0 ? 0 : t)) : []
            }

            function kh(e, t) {
                return e && e.length ? xs(e, ce(t, 3), !0, !0) : []
            }

            function Oh(e, t) {
                return e && e.length ? xs(e, ce(t, 3), !0) : []
            }

            function Ph(e, t, r, h) {
                var _ = e == null ? 0 : e.length;
                return _ ? (r && typeof r != "number" && Ht(e, t, r) && (r = 0, h = _), xl(e, t, r, h)) : []
            }

            function yf(e, t, r) {
                var h = e == null ? 0 : e.length;
                if (!h) return -1;
                var _ = r == null ? 0 : be(r);
                return _ < 0 && (_ = ot(h + _, 0)), Z(e, ce(t, 3), _)
            }

            function _f(e, t, r) {
                var h = e == null ? 0 : e.length;
                if (!h) return -1;
                var _ = h - 1;
                return r !== d && (_ = be(r), _ = r < 0 ? ot(h + _, 0) : Et(_, h - 1)), Z(e, ce(t, 3), _, !0)
            }

            function mf(e) {
                var t = e == null ? 0 : e.length;
                return t ? dt(e, 1) : []
            }

            function Rh(e) {
                var t = e == null ? 0 : e.length;
                return t ? dt(e, it) : []
            }

            function Lh(e, t) {
                var r = e == null ? 0 : e.length;
                return r ? (t = t === d ? 1 : be(t), dt(e, t)) : []
            }

            function Ih(e) {
                for (var t = -1, r = e == null ? 0 : e.length, h = {}; ++t < r;) {
                    var _ = e[t];
                    h[_[0]] = _[1]
                }
                return h
            }

            function bf(e) {
                return e && e.length ? e[0] : d
            }

            function Nh(e, t, r) {
                var h = e == null ? 0 : e.length;
                if (!h) return -1;
                var _ = r == null ? 0 : be(r);
                return _ < 0 && (_ = ot(h + _, 0)), Le(e, t, _)
            }

            function Dh(e) {
                var t = e == null ? 0 : e.length;
                return t ? Tn(e, 0, -1) : []
            }

            var Mh = Ce(function (e) {
                var t = ne(e, gu);
                return t.length && t[0] === e[0] ? ou(t) : []
            }), qh = Ce(function (e) {
                var t = An(e), r = ne(e, gu);
                return t === An(r) ? t = d : r.pop(), r.length && r[0] === e[0] ? ou(r, ce(t, 2)) : []
            }), Hh = Ce(function (e) {
                var t = An(e), r = ne(e, gu);
                return t = typeof t == "function" ? t : d, t && r.pop(), r.length && r[0] === e[0] ? ou(r, d, t) : []
            });

            function jh(e, t) {
                return e == null ? "" : Dc.call(e, t)
            }

            function An(e) {
                var t = e == null ? 0 : e.length;
                return t ? e[t - 1] : d
            }

            function Uh(e, t, r) {
                var h = e == null ? 0 : e.length;
                if (!h) return -1;
                var _ = h;
                return r !== d && (_ = be(r), _ = _ < 0 ? ot(h + _, 0) : Et(_, h - 1)), t === t ? Wr(e, t, _) : Z(e, Br, _, !0)
            }

            function Bh(e, t) {
                return e && e.length ? Pa(e, be(t)) : d
            }

            var Fh = Ce(wf);

            function wf(e, t) {
                return e && e.length && t && t.length ? fu(e, t) : e
            }

            function Wh(e, t, r) {
                return e && e.length && t && t.length ? fu(e, t, ce(r, 2)) : e
            }

            function $h(e, t, r) {
                return e && e.length && t && t.length ? fu(e, t, d, r) : e
            }

            var zh = xr(function (e, t) {
                var r = e == null ? 0 : e.length, h = tu(e, t);
                return Ia(e, ne(t, function (_) {
                    return Sr(_, r) ? +_ : _
                }).sort(Wa)), h
            });

            function Xh(e, t) {
                var r = [];
                if (!(e && e.length)) return r;
                var h = -1, _ = [], x = e.length;
                for (t = ce(t, 3); ++h < x;) {
                    var O = e[h];
                    t(O, h, e) && (r.push(O), _.push(h))
                }
                return Ia(e, _), r
            }

            function Ou(e) {
                return e == null ? e : jc.call(e)
            }

            function Gh(e, t, r) {
                var h = e == null ? 0 : e.length;
                return h ? (r && typeof r != "number" && Ht(e, t, r) ? (t = 0, r = h) : (t = t == null ? 0 : be(t), r = r === d ? h : be(r)), Tn(e, t, r)) : []
            }

            function Jh(e, t) {
                return ws(e, t)
            }

            function Vh(e, t, r) {
                return hu(e, t, ce(r, 2))
            }

            function Kh(e, t) {
                var r = e == null ? 0 : e.length;
                if (r) {
                    var h = ws(e, t);
                    if (h < r && qn(e[h], t)) return h
                }
                return -1
            }

            function Yh(e, t) {
                return ws(e, t, !0)
            }

            function Qh(e, t, r) {
                return hu(e, t, ce(r, 2), !0)
            }

            function Zh(e, t) {
                var r = e == null ? 0 : e.length;
                if (r) {
                    var h = ws(e, t, !0) - 1;
                    if (qn(e[h], t)) return h
                }
                return -1
            }

            function ep(e) {
                return e && e.length ? Da(e) : []
            }

            function tp(e, t) {
                return e && e.length ? Da(e, ce(t, 2)) : []
            }

            function np(e) {
                var t = e == null ? 0 : e.length;
                return t ? Tn(e, 1, t) : []
            }

            function rp(e, t, r) {
                return e && e.length ? (t = r || t === d ? 1 : be(t), Tn(e, 0, t < 0 ? 0 : t)) : []
            }

            function ip(e, t, r) {
                var h = e == null ? 0 : e.length;
                return h ? (t = r || t === d ? 1 : be(t), t = h - t, Tn(e, t < 0 ? 0 : t, h)) : []
            }

            function op(e, t) {
                return e && e.length ? xs(e, ce(t, 3), !1, !0) : []
            }

            function sp(e, t) {
                return e && e.length ? xs(e, ce(t, 3)) : []
            }

            var up = Ce(function (e) {
                return Gr(dt(e, 1, Qe, !0))
            }), ap = Ce(function (e) {
                var t = An(e);
                return Qe(t) && (t = d), Gr(dt(e, 1, Qe, !0), ce(t, 2))
            }), fp = Ce(function (e) {
                var t = An(e);
                return t = typeof t == "function" ? t : d, Gr(dt(e, 1, Qe, !0), d, t)
            });

            function cp(e) {
                return e && e.length ? Gr(e) : []
            }

            function lp(e, t) {
                return e && e.length ? Gr(e, ce(t, 2)) : []
            }

            function hp(e, t) {
                return t = typeof t == "function" ? t : d, e && e.length ? Gr(e, d, t) : []
            }

            function Pu(e) {
                if (!(e && e.length)) return [];
                var t = 0;
                return e = U(e, function (r) {
                    if (Qe(r)) return t = ot(r.length, t), !0
                }), gr(t, function (r) {
                    return ne(e, Nn(r))
                })
            }

            function xf(e, t) {
                if (!(e && e.length)) return [];
                var r = Pu(e);
                return t == null ? r : ne(r, function (h) {
                    return b(t, d, h)
                })
            }

            var pp = Ce(function (e, t) {
                return Qe(e) ? Zo(e, t) : []
            }), dp = Ce(function (e) {
                return du(U(e, Qe))
            }), gp = Ce(function (e) {
                var t = An(e);
                return Qe(t) && (t = d), du(U(e, Qe), ce(t, 2))
            }), vp = Ce(function (e) {
                var t = An(e);
                return t = typeof t == "function" ? t : d, du(U(e, Qe), d, t)
            }), yp = Ce(Pu);

            function _p(e, t) {
                return ja(e || [], t || [], Qo)
            }

            function mp(e, t) {
                return ja(e || [], t || [], ns)
            }

            var bp = Ce(function (e) {
                var t = e.length, r = t > 1 ? e[t - 1] : d;
                return r = typeof r == "function" ? (e.pop(), r) : d, xf(e, r)
            });

            function Sf(e) {
                var t = w(e);
                return t.__chain__ = !0, t
            }

            function wp(e, t) {
                return t(e), e
            }

            function Rs(e, t) {
                return t(e)
            }

            var xp = xr(function (e) {
                var t = e.length, r = t ? e[0] : 0, h = this.__wrapped__, _ = function (x) {
                    return tu(x, e)
                };
                return t > 1 || this.__actions__.length || !(h instanceof Ee) || !Sr(r) ? this.thru(_) : (h = h.slice(r, +r + (t ? 1 : 0)), h.__actions__.push({
                    func: Rs,
                    args: [_],
                    thisArg: d
                }), new Sn(h, this.__chain__).thru(function (x) {
                    return t && !x.length && x.push(d), x
                }))
            });

            function Sp() {
                return Sf(this)
            }

            function Cp() {
                return new Sn(this.value(), this.__chain__)
            }

            function Tp() {
                this.__values__ === d && (this.__values__ = qf(this.value()));
                var e = this.__index__ >= this.__values__.length, t = e ? d : this.__values__[this.__index__++];
                return {done: e, value: t}
            }

            function Ap() {
                return this
            }

            function Ep(e) {
                for (var t, r = this; r instanceof vs;) {
                    var h = vf(r);
                    h.__index__ = 0, h.__values__ = d, t ? _.__wrapped__ = h : t = h;
                    var _ = h;
                    r = r.__wrapped__
                }
                return _.__wrapped__ = e, t
            }

            function kp() {
                var e = this.__wrapped__;
                if (e instanceof Ee) {
                    var t = e;
                    return this.__actions__.length && (t = new Ee(this)), t = t.reverse(), t.__actions__.push({
                        func: Rs,
                        args: [Ou],
                        thisArg: d
                    }), new Sn(t, this.__chain__)
                }
                return this.thru(Ou)
            }

            function Op() {
                return Ha(this.__wrapped__, this.__actions__)
            }

            var Pp = Ss(function (e, t, r) {
                pe.call(e, r) ? ++e[r] : br(e, r, 1)
            });

            function Rp(e, t, r) {
                var h = ye(e) ? H : wl;
                return r && Ht(e, t, r) && (t = d), h(e, ce(t, 3))
            }

            function Lp(e, t) {
                var r = ye(e) ? U : wa;
                return r(e, ce(t, 3))
            }

            var Ip = Va(yf), Np = Va(_f);

            function Dp(e, t) {
                return dt(Ls(e, t), 1)
            }

            function Mp(e, t) {
                return dt(Ls(e, t), it)
            }

            function qp(e, t, r) {
                return r = r === d ? 1 : be(r), dt(Ls(e, t), r)
            }

            function Cf(e, t) {
                var r = ye(e) ? k : Xr;
                return r(e, ce(t, 3))
            }

            function Tf(e, t) {
                var r = ye(e) ? N : ba;
                return r(e, ce(t, 3))
            }

            var Hp = Ss(function (e, t, r) {
                pe.call(e, r) ? e[r].push(t) : br(e, r, [t])
            });

            function jp(e, t, r, h) {
                e = Yt(e) ? e : _o(e), r = r && !h ? be(r) : 0;
                var _ = e.length;
                return r < 0 && (r = ot(_ + r, 0)), qs(e) ? r <= _ && e.indexOf(t, r) > -1 : !!_ && Le(e, t, r) > -1
            }

            var Up = Ce(function (e, t, r) {
                var h = -1, _ = typeof t == "function", x = Yt(e) ? g(e.length) : [];
                return Xr(e, function (O) {
                    x[++h] = _ ? b(t, O, r) : es(O, t, r)
                }), x
            }), Bp = Ss(function (e, t, r) {
                br(e, r, t)
            });

            function Ls(e, t) {
                var r = ye(e) ? ne : Ea;
                return r(e, ce(t, 3))
            }

            function Fp(e, t, r, h) {
                return e == null ? [] : (ye(t) || (t = t == null ? [] : [t]), r = h ? d : r, ye(r) || (r = r == null ? [] : [r]), Ra(e, t, r))
            }

            var Wp = Ss(function (e, t, r) {
                e[r ? 0 : 1].push(t)
            }, function () {
                return [[], []]
            });

            function $p(e, t, r) {
                var h = ye(e) ? ge : Gt, _ = arguments.length < 3;
                return h(e, ce(t, 4), r, _, Xr)
            }

            function zp(e, t, r) {
                var h = ye(e) ? Ye : Gt, _ = arguments.length < 3;
                return h(e, ce(t, 4), r, _, ba)
            }

            function Xp(e, t) {
                var r = ye(e) ? U : wa;
                return r(e, Ds(ce(t, 3)))
            }

            function Gp(e) {
                var t = ye(e) ? va : jl;
                return t(e)
            }

            function Jp(e, t, r) {
                (r ? Ht(e, t, r) : t === d) ? t = 1 : t = be(t);
                var h = ye(e) ? vl : Ul;
                return h(e, t)
            }

            function Vp(e) {
                var t = ye(e) ? yl : Fl;
                return t(e)
            }

            function Kp(e) {
                if (e == null) return 0;
                if (Yt(e)) return qs(e) ? xn(e) : e.length;
                var t = kt(e);
                return t == bt || t == xt ? e.size : uu(e).length
            }

            function Yp(e, t, r) {
                var h = ye(e) ? Ue : Wl;
                return r && Ht(e, t, r) && (t = d), h(e, ce(t, 3))
            }

            var Qp = Ce(function (e, t) {
                if (e == null) return [];
                var r = t.length;
                return r > 1 && Ht(e, t[0], t[1]) ? t = [] : r > 2 && Ht(t[0], t[1], t[2]) && (t = [t[0]]), Ra(e, dt(t, 1), [])
            }), Is = Lc || function () {
                return je.Date.now()
            };

            function Zp(e, t) {
                if (typeof t != "function") throw new me(M);
                return e = be(e), function () {
                    if (--e < 1) return t.apply(this, arguments)
                }
            }

            function Af(e, t, r) {
                return t = r ? d : t, t = e && t == null ? e.length : t, wr(e, p, d, d, d, d, t)
            }

            function Ef(e, t) {
                var r;
                if (typeof t != "function") throw new me(M);
                return e = be(e), function () {
                    return --e > 0 && (r = t.apply(this, arguments)), e <= 1 && (t = d), r
                }
            }

            var Ru = Ce(function (e, t, r) {
                var h = G;
                if (r.length) {
                    var _ = Mt(r, vo(Ru));
                    h |= He
                }
                return wr(e, h, t, r, _)
            }), kf = Ce(function (e, t, r) {
                var h = G | F;
                if (r.length) {
                    var _ = Mt(r, vo(kf));
                    h |= He
                }
                return wr(t, h, e, r, _)
            });

            function Of(e, t, r) {
                t = r ? d : t;
                var h = wr(e, Te, d, d, d, d, d, t);
                return h.placeholder = Of.placeholder, h
            }

            function Pf(e, t, r) {
                t = r ? d : t;
                var h = wr(e, Ne, d, d, d, d, d, t);
                return h.placeholder = Pf.placeholder, h
            }

            function Rf(e, t, r) {
                var h, _, x, O, R, D, $ = 0, z = !1, V = !1, te = !0;
                if (typeof e != "function") throw new me(M);
                t = En(t) || 0, $e(r) && (z = !!r.leading, V = "maxWait" in r, x = V ? ot(En(r.maxWait) || 0, t) : x, te = "trailing" in r ? !!r.trailing : te);

                function fe(Ze) {
                    var Hn = h, Ar = _;
                    return h = _ = d, $ = Ze, O = e.apply(Ar, Hn), O
                }

                function le(Ze) {
                    return $ = Ze, R = os(Ae, t), z ? fe(Ze) : O
                }

                function xe(Ze) {
                    var Hn = Ze - D, Ar = Ze - $, Kf = t - Hn;
                    return V ? Et(Kf, x - Ar) : Kf
                }

                function he(Ze) {
                    var Hn = Ze - D, Ar = Ze - $;
                    return D === d || Hn >= t || Hn < 0 || V && Ar >= x
                }

                function Ae() {
                    var Ze = Is();
                    if (he(Ze)) return ke(Ze);
                    R = os(Ae, xe(Ze))
                }

                function ke(Ze) {
                    return R = d, te && h ? fe(Ze) : (h = _ = d, O)
                }

                function un() {
                    R !== d && Ua(R), $ = 0, h = D = _ = R = d
                }

                function jt() {
                    return R === d ? O : ke(Is())
                }

                function an() {
                    var Ze = Is(), Hn = he(Ze);
                    if (h = arguments, _ = this, D = Ze, Hn) {
                        if (R === d) return le(D);
                        if (V) return Ua(R), R = os(Ae, t), fe(D)
                    }
                    return R === d && (R = os(Ae, t)), O
                }

                return an.cancel = un, an.flush = jt, an
            }

            var ed = Ce(function (e, t) {
                return ma(e, 1, t)
            }), td = Ce(function (e, t, r) {
                return ma(e, En(t) || 0, r)
            });

            function nd(e) {
                return wr(e, _e)
            }

            function Ns(e, t) {
                if (typeof e != "function" || t != null && typeof t != "function") throw new me(M);
                var r = function () {
                    var h = arguments, _ = t ? t.apply(this, h) : h[0], x = r.cache;
                    if (x.has(_)) return x.get(_);
                    var O = e.apply(this, h);
                    return r.cache = x.set(_, O) || x, O
                };
                return r.cache = new (Ns.Cache || mr), r
            }

            Ns.Cache = mr;

            function Ds(e) {
                if (typeof e != "function") throw new me(M);
                return function () {
                    var t = arguments;
                    switch (t.length) {
                        case 0:
                            return !e.call(this);
                        case 1:
                            return !e.call(this, t[0]);
                        case 2:
                            return !e.call(this, t[0], t[1]);
                        case 3:
                            return !e.call(this, t[0], t[1], t[2])
                    }
                    return !e.apply(this, t)
                }
            }

            function rd(e) {
                return Ef(2, e)
            }

            var id = $l(function (e, t) {
                t = t.length == 1 && ye(t[0]) ? ne(t[0], lt(ce())) : ne(dt(t, 1), lt(ce()));
                var r = t.length;
                return Ce(function (h) {
                    for (var _ = -1, x = Et(h.length, r); ++_ < x;) h[_] = t[_].call(this, h[_]);
                    return b(e, this, h)
                })
            }), Lu = Ce(function (e, t) {
                var r = Mt(t, vo(Lu));
                return wr(e, He, d, t, r)
            }), Lf = Ce(function (e, t) {
                var r = Mt(t, vo(Lf));
                return wr(e, et, d, t, r)
            }), od = xr(function (e, t) {
                return wr(e, tt, d, d, d, t)
            });

            function sd(e, t) {
                if (typeof e != "function") throw new me(M);
                return t = t === d ? t : be(t), Ce(e, t)
            }

            function ud(e, t) {
                if (typeof e != "function") throw new me(M);
                return t = t == null ? 0 : ot(be(t), 0), Ce(function (r) {
                    var h = r[t], _ = Vr(r, 0, t);
                    return h && ve(_, h), b(e, this, _)
                })
            }

            function ad(e, t, r) {
                var h = !0, _ = !0;
                if (typeof e != "function") throw new me(M);
                return $e(r) && (h = "leading" in r ? !!r.leading : h, _ = "trailing" in r ? !!r.trailing : _), Rf(e, t, {
                    leading: h,
                    maxWait: t,
                    trailing: _
                })
            }

            function fd(e) {
                return Af(e, 1)
            }

            function cd(e, t) {
                return Lu(vu(t), e)
            }

            function ld() {
                if (!arguments.length) return [];
                var e = arguments[0];
                return ye(e) ? e : [e]
            }

            function hd(e) {
                return Cn(e, ee)
            }

            function pd(e, t) {
                return t = typeof t == "function" ? t : d, Cn(e, ee, t)
            }

            function dd(e) {
                return Cn(e, ae | ee)
            }

            function gd(e, t) {
                return t = typeof t == "function" ? t : d, Cn(e, ae | ee, t)
            }

            function vd(e, t) {
                return t == null || _a(e, t, ct(t))
            }

            function qn(e, t) {
                return e === t || e !== e && t !== t
            }

            var yd = Es(iu), _d = Es(function (e, t) {
                return e >= t
            }), Ri = Ca(function () {
                return arguments
            }()) ? Ca : function (e) {
                return Ge(e) && pe.call(e, "callee") && !ca.call(e, "callee")
            }, ye = g.isArray, md = n ? lt(n) : El;

            function Yt(e) {
                return e != null && Ms(e.length) && !Cr(e)
            }

            function Qe(e) {
                return Ge(e) && Yt(e)
            }

            function bd(e) {
                return e === !0 || e === !1 || Ge(e) && qt(e) == Be
            }

            var Kr = Nc || Wu, wd = i ? lt(i) : kl;

            function xd(e) {
                return Ge(e) && e.nodeType === 1 && !ss(e)
            }

            function Sd(e) {
                if (e == null) return !0;
                if (Yt(e) && (ye(e) || typeof e == "string" || typeof e.splice == "function" || Kr(e) || yo(e) || Ri(e))) return !e.length;
                var t = kt(e);
                if (t == bt || t == xt) return !e.size;
                if (is(e)) return !uu(e).length;
                for (var r in e) if (pe.call(e, r)) return !1;
                return !0
            }

            function Cd(e, t) {
                return ts(e, t)
            }

            function Td(e, t, r) {
                r = typeof r == "function" ? r : d;
                var h = r ? r(e, t) : d;
                return h === d ? ts(e, t, d, r) : !!h
            }

            function Iu(e) {
                if (!Ge(e)) return !1;
                var t = qt(e);
                return t == ir || t == $t || typeof e.message == "string" && typeof e.name == "string" && !ss(e)
            }

            function Ad(e) {
                return typeof e == "number" && ha(e)
            }

            function Cr(e) {
                if (!$e(e)) return !1;
                var t = qt(e);
                return t == Je || t == Bn || t == Ao || t == Di
            }

            function If(e) {
                return typeof e == "number" && e == be(e)
            }

            function Ms(e) {
                return typeof e == "number" && e > -1 && e % 1 == 0 && e <= Wt
            }

            function $e(e) {
                var t = typeof e;
                return e != null && (t == "object" || t == "function")
            }

            function Ge(e) {
                return e != null && typeof e == "object"
            }

            var Nf = f ? lt(f) : Pl;

            function Ed(e, t) {
                return e === t || su(e, t, Su(t))
            }

            function kd(e, t, r) {
                return r = typeof r == "function" ? r : d, su(e, t, Su(t), r)
            }

            function Od(e) {
                return Df(e) && e != +e
            }

            function Pd(e) {
                if (ph(e)) throw new L(I);
                return Ta(e)
            }

            function Rd(e) {
                return e === null
            }

            function Ld(e) {
                return e == null
            }

            function Df(e) {
                return typeof e == "number" || Ge(e) && qt(e) == en
            }

            function ss(e) {
                if (!Ge(e) || qt(e) != wt) return !1;
                var t = fo(e);
                if (t === null) return !0;
                var r = pe.call(t, "constructor") && t.constructor;
                return typeof r == "function" && r instanceof r && Vt.call(r) == as
            }

            var Nu = l ? lt(l) : Rl;

            function Id(e) {
                return If(e) && e >= -Wt && e <= Wt
            }

            var Mf = v ? lt(v) : Ll;

            function qs(e) {
                return typeof e == "string" || !ye(e) && Ge(e) && qt(e) == st
            }

            function sn(e) {
                return typeof e == "symbol" || Ge(e) && qt(e) == hn
            }

            var yo = y ? lt(y) : Il;

            function Nd(e) {
                return e === d
            }

            function Dd(e) {
                return Ge(e) && kt(e) == oe
            }

            function Md(e) {
                return Ge(e) && qt(e) == Ve
            }

            var qd = Es(au), Hd = Es(function (e, t) {
                return e <= t
            });

            function qf(e) {
                if (!e) return [];
                if (Yt(e)) return qs(e) ? ht(e) : Kt(e);
                if (Go && e[Go]) return wn(e[Go]());
                var t = kt(e), r = t == bt ? Fr : t == xt ? Dn : _o;
                return r(e)
            }

            function Tr(e) {
                if (!e) return e === 0 ? e : 0;
                if (e = En(e), e === it || e === -it) {
                    var t = e < 0 ? -1 : 1;
                    return t * Un
                }
                return e === e ? e : 0
            }

            function be(e) {
                var t = Tr(e), r = t % 1;
                return t === t ? r ? t - r : t : 0
            }

            function Hf(e) {
                return e ? Ei(be(e), 0, _t) : 0
            }

            function En(e) {
                if (typeof e == "number") return e;
                if (sn(e)) return rr;
                if ($e(e)) {
                    var t = typeof e.valueOf == "function" ? e.valueOf() : e;
                    e = $e(t) ? t + "" : t
                }
                if (typeof e != "string") return e === 0 ? e : +e;
                e = Jt(e);
                var r = zi.test(e);
                return r || ni.test(e) ? Ho(e.slice(2), r ? 2 : 8) : Pn.test(e) ? rr : +e
            }

            function jf(e) {
                return tr(e, Qt(e))
            }

            function jd(e) {
                return e ? Ei(be(e), -Wt, Wt) : e === 0 ? e : 0
            }

            function Me(e) {
                return e == null ? "" : on(e)
            }

            var Ud = po(function (e, t) {
                if (is(t) || Yt(t)) {
                    tr(t, ct(t), e);
                    return
                }
                for (var r in t) pe.call(t, r) && Qo(e, r, t[r])
            }), Uf = po(function (e, t) {
                tr(t, Qt(t), e)
            }), Hs = po(function (e, t, r, h) {
                tr(t, Qt(t), e, h)
            }), Bd = po(function (e, t, r, h) {
                tr(t, ct(t), e, h)
            }), Fd = xr(tu);

            function Wd(e, t) {
                var r = ho(e);
                return t == null ? r : ya(r, t)
            }

            var $d = Ce(function (e, t) {
                e = X(e);
                var r = -1, h = t.length, _ = h > 2 ? t[2] : d;
                for (_ && Ht(t[0], t[1], _) && (h = 1); ++r < h;) for (var x = t[r], O = Qt(x), R = -1, D = O.length; ++R < D;) {
                    var $ = O[R], z = e[$];
                    (z === d || qn(z, Xe[$]) && !pe.call(e, $)) && (e[$] = x[$])
                }
                return e
            }), zd = Ce(function (e) {
                return e.push(d, nf), b(Bf, d, e)
            });

            function Xd(e, t) {
                return _n(e, ce(t, 3), er)
            }

            function Gd(e, t) {
                return _n(e, ce(t, 3), ru)
            }

            function Jd(e, t) {
                return e == null ? e : nu(e, ce(t, 3), Qt)
            }

            function Vd(e, t) {
                return e == null ? e : xa(e, ce(t, 3), Qt)
            }

            function Kd(e, t) {
                return e && er(e, ce(t, 3))
            }

            function Yd(e, t) {
                return e && ru(e, ce(t, 3))
            }

            function Qd(e) {
                return e == null ? [] : ms(e, ct(e))
            }

            function Zd(e) {
                return e == null ? [] : ms(e, Qt(e))
            }

            function Du(e, t, r) {
                var h = e == null ? d : ki(e, t);
                return h === d ? r : h
            }

            function eg(e, t) {
                return e != null && sf(e, t, Sl)
            }

            function Mu(e, t) {
                return e != null && sf(e, t, Cl)
            }

            var tg = Ya(function (e, t, r) {
                t != null && typeof t.toString != "function" && (t = xi.call(t)), e[t] = r
            }, Hu(Zt)), ng = Ya(function (e, t, r) {
                t != null && typeof t.toString != "function" && (t = xi.call(t)), pe.call(e, t) ? e[t].push(r) : e[t] = [r]
            }, ce), rg = Ce(es);

            function ct(e) {
                return Yt(e) ? ga(e) : uu(e)
            }

            function Qt(e) {
                return Yt(e) ? ga(e, !0) : Nl(e)
            }

            function ig(e, t) {
                var r = {};
                return t = ce(t, 3), er(e, function (h, _, x) {
                    br(r, t(h, _, x), h)
                }), r
            }

            function og(e, t) {
                var r = {};
                return t = ce(t, 3), er(e, function (h, _, x) {
                    br(r, _, t(h, _, x))
                }), r
            }

            var sg = po(function (e, t, r) {
                bs(e, t, r)
            }), Bf = po(function (e, t, r, h) {
                bs(e, t, r, h)
            }), ug = xr(function (e, t) {
                var r = {};
                if (e == null) return r;
                var h = !1;
                t = ne(t, function (x) {
                    return x = Jr(x, e), h || (h = x.length > 1), x
                }), tr(e, wu(e), r), h && (r = Cn(r, ae | re | ee, th));
                for (var _ = t.length; _--;) pu(r, t[_]);
                return r
            });

            function ag(e, t) {
                return Ff(e, Ds(ce(t)))
            }

            var fg = xr(function (e, t) {
                return e == null ? {} : Ml(e, t)
            });

            function Ff(e, t) {
                if (e == null) return {};
                var r = ne(wu(e), function (h) {
                    return [h]
                });
                return t = ce(t), La(e, r, function (h, _) {
                    return t(h, _[0])
                })
            }

            function cg(e, t, r) {
                t = Jr(t, e);
                var h = -1, _ = t.length;
                for (_ || (_ = 1, e = d); ++h < _;) {
                    var x = e == null ? d : e[nr(t[h])];
                    x === d && (h = _, x = r), e = Cr(x) ? x.call(e) : x
                }
                return e
            }

            function lg(e, t, r) {
                return e == null ? e : ns(e, t, r)
            }

            function hg(e, t, r, h) {
                return h = typeof h == "function" ? h : d, e == null ? e : ns(e, t, r, h)
            }

            var Wf = ef(ct), $f = ef(Qt);

            function pg(e, t, r) {
                var h = ye(e), _ = h || Kr(e) || yo(e);
                if (t = ce(t, 4), r == null) {
                    var x = e && e.constructor;
                    _ ? r = h ? new x : [] : $e(e) ? r = Cr(x) ? ho(fo(e)) : {} : r = {}
                }
                return (_ ? k : er)(e, function (O, R, D) {
                    return t(r, O, R, D)
                }), r
            }

            function dg(e, t) {
                return e == null ? !0 : pu(e, t)
            }

            function gg(e, t, r) {
                return e == null ? e : qa(e, t, vu(r))
            }

            function vg(e, t, r, h) {
                return h = typeof h == "function" ? h : d, e == null ? e : qa(e, t, vu(r), h)
            }

            function _o(e) {
                return e == null ? [] : _i(e, ct(e))
            }

            function yg(e) {
                return e == null ? [] : _i(e, Qt(e))
            }

            function _g(e, t, r) {
                return r === d && (r = t, t = d), r !== d && (r = En(r), r = r === r ? r : 0), t !== d && (t = En(t), t = t === t ? t : 0), Ei(En(e), t, r)
            }

            function mg(e, t, r) {
                return t = Tr(t), r === d ? (r = t, t = 0) : r = Tr(r), e = En(e), Tl(e, t, r)
            }

            function bg(e, t, r) {
                if (r && typeof r != "boolean" && Ht(e, t, r) && (t = r = d), r === d && (typeof t == "boolean" ? (r = t, t = d) : typeof e == "boolean" && (r = e, e = d)), e === d && t === d ? (e = 0, t = 1) : (e = Tr(e), t === d ? (t = e, e = 0) : t = Tr(t)), e > t) {
                    var h = e;
                    e = t, t = h
                }
                if (r || e % 1 || t % 1) {
                    var _ = pa();
                    return Et(e + _ * (t - e + vi("1e-" + ((_ + "").length - 1))), t)
                }
                return cu(e, t)
            }

            var wg = go(function (e, t, r) {
                return t = t.toLowerCase(), e + (r ? zf(t) : t)
            });

            function zf(e) {
                return qu(Me(e).toLowerCase())
            }

            function Xf(e) {
                return e = Me(e), e && e.replace(Xi, Yn).replace(Io, "")
            }

            function xg(e, t, r) {
                e = Me(e), t = on(t);
                var h = e.length;
                r = r === d ? h : Ei(be(r), 0, h);
                var _ = r;
                return r -= t.length, r >= 0 && e.slice(r, _) == t
            }

            function Sg(e) {
                return e = Me(e), e && qi.test(e) ? e.replace(Wn, Uo) : e
            }

            function Cg(e) {
                return e = Me(e), e && Lt.test(e) ? e.replace(dn, "\\$&") : e
            }

            var Tg = go(function (e, t, r) {
                return e + (r ? "-" : "") + t.toLowerCase()
            }), Ag = go(function (e, t, r) {
                return e + (r ? " " : "") + t.toLowerCase()
            }), Eg = Ja("toLowerCase");

            function kg(e, t, r) {
                e = Me(e), t = be(t);
                var h = t ? xn(e) : 0;
                if (!t || h >= t) return e;
                var _ = (t - h) / 2;
                return As(ps(_), r) + e + As(hs(_), r)
            }

            function Og(e, t, r) {
                e = Me(e), t = be(t);
                var h = t ? xn(e) : 0;
                return t && h < t ? e + As(t - h, r) : e
            }

            function Pg(e, t, r) {
                e = Me(e), t = be(t);
                var h = t ? xn(e) : 0;
                return t && h < t ? As(t - h, r) + e : e
            }

            function Rg(e, t, r) {
                return r || t == null ? t = 0 : t && (t = +t), Hc(Me(e).replace(ar, ""), t || 0)
            }

            function Lg(e, t, r) {
                return (r ? Ht(e, t, r) : t === d) ? t = 1 : t = be(t), lu(Me(e), t)
            }

            function Ig() {
                var e = arguments, t = Me(e[0]);
                return e.length < 3 ? t : t.replace(e[1], e[2])
            }

            var Ng = go(function (e, t, r) {
                return e + (r ? "_" : "") + t.toLowerCase()
            });

            function Dg(e, t, r) {
                return r && typeof r != "number" && Ht(e, t, r) && (t = r = d), r = r === d ? _t : r >>> 0, r ? (e = Me(e), e && (typeof t == "string" || t != null && !Nu(t)) && (t = on(t), !t && At(e)) ? Vr(ht(e), 0, r) : e.split(t, r)) : []
            }

            var Mg = go(function (e, t, r) {
                return e + (r ? " " : "") + qu(t)
            });

            function qg(e, t, r) {
                return e = Me(e), r = r == null ? 0 : Ei(be(r), 0, e.length), t = on(t), e.slice(r, r + t.length) == t
            }

            function Hg(e, t, r) {
                var h = w.templateSettings;
                r && Ht(e, t, r) && (t = d), e = Me(e), t = Hs({}, t, h, tf);
                var _ = Hs({}, t.imports, h.imports, tf), x = ct(_), O = _i(_, x), R, D, $ = 0, z = t.interpolate || Mr,
                    V = "__p += '",
                    te = ue((t.escape || Mr).source + "|" + z.source + "|" + (z === St ? cr : Mr).source + "|" + (t.evaluate || Mr).source + "|$", "g"),
                    fe = "//# sourceURL=" + (pe.call(t, "sourceURL") ? (t.sourceURL + "").replace(/\s/g, " ") : "lodash.templateSources[" + ++qo + "]") + `
`;
                e.replace(te, function (he, Ae, ke, un, jt, an) {
                    return ke || (ke = un), V += e.slice($, an).replace(lr, Bo), Ae && (R = !0, V += `' +
__e(` + Ae + `) +
'`), jt && (D = !0, V += `';
` + jt + `;
__p += '`), ke && (V += `' +
((__t = (` + ke + `)) == null ? '' : __t) +
'`), $ = an + he.length, he
                }), V += `';
`;
                var le = pe.call(t, "variable") && t.variable;
                if (!le) V = `with (obj) {
` + V + `
}
`; else if (Oo.test(le)) throw new L(ie);
                V = (D ? V.replace(Ir, "") : V).replace(Nr, "$1").replace(Eo, "$1;"), V = "function(" + (le || "obj") + `) {
` + (le ? "" : `obj || (obj = {});
`) + "var __t, __p = ''" + (R ? ", __e = _.escape" : "") + (D ? `, __j = Array.prototype.join;
function print() { __p += __j.call(arguments, '') }
` : `;
`) + V + `return __p
}`;
                var xe = Jf(function () {
                    return W(x, fe + "return " + V).apply(d, O)
                });
                if (xe.source = V, Iu(xe)) throw xe;
                return xe
            }

            function jg(e) {
                return Me(e).toLowerCase()
            }

            function Ug(e) {
                return Me(e).toUpperCase()
            }

            function Bg(e, t, r) {
                if (e = Me(e), e && (r || t === d)) return Jt(e);
                if (!e || !(t = on(t))) return e;
                var h = ht(e), _ = ht(t), x = Oe(h, _), O = yr(h, _) + 1;
                return Vr(h, x, O).join("")
            }

            function Fg(e, t, r) {
                if (e = Me(e), e && (r || t === d)) return e.slice(0, uo(e) + 1);
                if (!e || !(t = on(t))) return e;
                var h = ht(e), _ = yr(h, ht(t)) + 1;
                return Vr(h, 0, _).join("")
            }

            function Wg(e, t, r) {
                if (e = Me(e), e && (r || t === d)) return e.replace(ar, "");
                if (!e || !(t = on(t))) return e;
                var h = ht(e), _ = Oe(h, ht(t));
                return Vr(h, _).join("")
            }

            function $g(e, t) {
                var r = Bt, h = So;
                if ($e(t)) {
                    var _ = "separator" in t ? t.separator : _;
                    r = "length" in t ? be(t.length) : r, h = "omission" in t ? on(t.omission) : h
                }
                e = Me(e);
                var x = e.length;
                if (At(e)) {
                    var O = ht(e);
                    x = O.length
                }
                if (r >= x) return e;
                var R = r - xn(h);
                if (R < 1) return h;
                var D = O ? Vr(O, 0, R).join("") : e.slice(0, R);
                if (_ === d) return D + h;
                if (O && (R += D.length - R), Nu(_)) {
                    if (e.slice(R).search(_)) {
                        var $, z = D;
                        for (_.global || (_ = ue(_.source, Me($i.exec(_)) + "g")), _.lastIndex = 0; $ = _.exec(z);) var V = $.index;
                        D = D.slice(0, V === d ? R : V)
                    }
                } else if (e.indexOf(on(_), R) != R) {
                    var te = D.lastIndexOf(_);
                    te > -1 && (D = D.slice(0, te))
                }
                return D + h
            }

            function zg(e) {
                return e = Me(e), e && Mi.test(e) ? e.replace(On, $r) : e
            }

            var Xg = go(function (e, t, r) {
                return e + (r ? " " : "") + t.toUpperCase()
            }), qu = Ja("toUpperCase");

            function Gf(e, t, r) {
                return e = Me(e), t = r ? d : t, t === d ? bi(e) ? o(e) : we(e) : e.match(t) || []
            }

            var Jf = Ce(function (e, t) {
                try {
                    return b(e, d, t)
                } catch (r) {
                    return Iu(r) ? r : new L(r)
                }
            }), Gg = xr(function (e, t) {
                return k(t, function (r) {
                    r = nr(r), br(e, r, Ru(e[r], e))
                }), e
            });

            function Jg(e) {
                var t = e == null ? 0 : e.length, r = ce();
                return e = t ? ne(e, function (h) {
                    if (typeof h[1] != "function") throw new me(M);
                    return [r(h[0]), h[1]]
                }) : [], Ce(function (h) {
                    for (var _ = -1; ++_ < t;) {
                        var x = e[_];
                        if (b(x[0], this, h)) return b(x[1], this, h)
                    }
                })
            }

            function Vg(e) {
                return bl(Cn(e, ae))
            }

            function Hu(e) {
                return function () {
                    return e
                }
            }

            function Kg(e, t) {
                return e == null || e !== e ? t : e
            }

            var Yg = Ka(), Qg = Ka(!0);

            function Zt(e) {
                return e
            }

            function ju(e) {
                return Aa(typeof e == "function" ? e : Cn(e, ae))
            }

            function Zg(e) {
                return ka(Cn(e, ae))
            }

            function ev(e, t) {
                return Oa(e, Cn(t, ae))
            }

            var tv = Ce(function (e, t) {
                return function (r) {
                    return es(r, e, t)
                }
            }), nv = Ce(function (e, t) {
                return function (r) {
                    return es(e, r, t)
                }
            });

            function Uu(e, t, r) {
                var h = ct(t), _ = ms(t, h);
                r == null && !($e(t) && (_.length || !h.length)) && (r = t, t = e, e = this, _ = ms(t, ct(t)));
                var x = !($e(r) && "chain" in r) || !!r.chain, O = Cr(e);
                return k(_, function (R) {
                    var D = t[R];
                    e[R] = D, O && (e.prototype[R] = function () {
                        var $ = this.__chain__;
                        if (x || $) {
                            var z = e(this.__wrapped__), V = z.__actions__ = Kt(this.__actions__);
                            return V.push({func: D, args: arguments, thisArg: e}), z.__chain__ = $, z
                        }
                        return D.apply(e, ve([this.value()], arguments))
                    })
                }), e
            }

            function rv() {
                return je._ === this && (je._ = $o), this
            }

            function Bu() {
            }

            function iv(e) {
                return e = be(e), Ce(function (t) {
                    return Pa(t, e)
                })
            }

            var ov = _u(ne), sv = _u(H), uv = _u(Ue);

            function Vf(e) {
                return Tu(e) ? Nn(nr(e)) : ql(e)
            }

            function av(e) {
                return function (t) {
                    return e == null ? d : ki(e, t)
                }
            }

            var fv = Qa(), cv = Qa(!0);

            function Fu() {
                return []
            }

            function Wu() {
                return !1
            }

            function lv() {
                return {}
            }

            function hv() {
                return ""
            }

            function pv() {
                return !0
            }

            function dv(e, t) {
                if (e = be(e), e < 1 || e > Wt) return [];
                var r = _t, h = Et(e, _t);
                t = ce(t), e -= _t;
                for (var _ = gr(h, t); ++r < e;) t(r);
                return _
            }

            function gv(e) {
                return ye(e) ? ne(e, nr) : sn(e) ? [e] : Kt(gf(Me(e)))
            }

            function vv(e) {
                var t = ++Ks;
                return Me(e) + t
            }

            var yv = Ts(function (e, t) {
                return e + t
            }, 0), _v = mu("ceil"), mv = Ts(function (e, t) {
                return e / t
            }, 1), bv = mu("floor");

            function wv(e) {
                return e && e.length ? _s(e, Zt, iu) : d
            }

            function xv(e, t) {
                return e && e.length ? _s(e, ce(t, 2), iu) : d
            }

            function Sv(e) {
                return Dt(e, Zt)
            }

            function Cv(e, t) {
                return Dt(e, ce(t, 2))
            }

            function Tv(e) {
                return e && e.length ? _s(e, Zt, au) : d
            }

            function Av(e, t) {
                return e && e.length ? _s(e, ce(t, 2), au) : d
            }

            var Ev = Ts(function (e, t) {
                return e * t
            }, 1), kv = mu("round"), Ov = Ts(function (e, t) {
                return e - t
            }, 0);

            function Pv(e) {
                return e && e.length ? ft(e, Zt) : 0
            }

            function Rv(e, t) {
                return e && e.length ? ft(e, ce(t, 2)) : 0
            }

            return w.after = Zp, w.ary = Af, w.assign = Ud, w.assignIn = Uf, w.assignInWith = Hs, w.assignWith = Bd, w.at = Fd, w.before = Ef, w.bind = Ru, w.bindAll = Gg, w.bindKey = kf, w.castArray = ld, w.chain = Sf, w.chunk = bh, w.compact = wh, w.concat = xh, w.cond = Jg, w.conforms = Vg, w.constant = Hu, w.countBy = Pp, w.create = Wd, w.curry = Of, w.curryRight = Pf, w.debounce = Rf, w.defaults = $d, w.defaultsDeep = zd, w.defer = ed, w.delay = td, w.difference = Sh, w.differenceBy = Ch, w.differenceWith = Th, w.drop = Ah, w.dropRight = Eh, w.dropRightWhile = kh, w.dropWhile = Oh, w.fill = Ph, w.filter = Lp, w.flatMap = Dp, w.flatMapDeep = Mp, w.flatMapDepth = qp, w.flatten = mf, w.flattenDeep = Rh, w.flattenDepth = Lh, w.flip = nd, w.flow = Yg, w.flowRight = Qg, w.fromPairs = Ih, w.functions = Qd, w.functionsIn = Zd, w.groupBy = Hp, w.initial = Dh, w.intersection = Mh, w.intersectionBy = qh, w.intersectionWith = Hh, w.invert = tg, w.invertBy = ng, w.invokeMap = Up, w.iteratee = ju, w.keyBy = Bp, w.keys = ct, w.keysIn = Qt, w.map = Ls, w.mapKeys = ig, w.mapValues = og, w.matches = Zg, w.matchesProperty = ev, w.memoize = Ns, w.merge = sg, w.mergeWith = Bf, w.method = tv, w.methodOf = nv, w.mixin = Uu, w.negate = Ds, w.nthArg = iv, w.omit = ug, w.omitBy = ag, w.once = rd, w.orderBy = Fp, w.over = ov, w.overArgs = id, w.overEvery = sv, w.overSome = uv, w.partial = Lu, w.partialRight = Lf, w.partition = Wp, w.pick = fg, w.pickBy = Ff, w.property = Vf, w.propertyOf = av, w.pull = Fh, w.pullAll = wf, w.pullAllBy = Wh, w.pullAllWith = $h, w.pullAt = zh, w.range = fv, w.rangeRight = cv, w.rearg = od, w.reject = Xp, w.remove = Xh, w.rest = sd, w.reverse = Ou,w.sampleSize = Jp,w.set = lg,w.setWith = hg,w.shuffle = Vp,w.slice = Gh,w.sortBy = Qp,w.sortedUniq = ep,w.sortedUniqBy = tp,w.split = Dg,w.spread = ud,w.tail = np,w.take = rp,w.takeRight = ip,w.takeRightWhile = op,w.takeWhile = sp,w.tap = wp,w.throttle = ad,w.thru = Rs,w.toArray = qf,w.toPairs = Wf,w.toPairsIn = $f,w.toPath = gv,w.toPlainObject = jf,w.transform = pg,w.unary = fd,w.union = up,w.unionBy = ap,w.unionWith = fp,w.uniq = cp,w.uniqBy = lp,w.uniqWith = hp,w.unset = dg,w.unzip = Pu,w.unzipWith = xf,w.update = gg,w.updateWith = vg,w.values = _o,w.valuesIn = yg,w.without = pp,w.words = Gf,w.wrap = cd,w.xor = dp,w.xorBy = gp,w.xorWith = vp,w.zip = yp,w.zipObject = _p,w.zipObjectDeep = mp,w.zipWith = bp,w.entries = Wf,w.entriesIn = $f,w.extend = Uf,w.extendWith = Hs,Uu(w, w),w.add = yv,w.attempt = Jf,w.camelCase = wg,w.capitalize = zf,w.ceil = _v,w.clamp = _g,w.clone = hd,w.cloneDeep = dd,w.cloneDeepWith = gd,w.cloneWith = pd,w.conformsTo = vd,w.deburr = Xf,w.defaultTo = Kg,w.divide = mv,w.endsWith = xg,w.eq = qn,w.escape = Sg,w.escapeRegExp = Cg,w.every = Rp,w.find = Ip,w.findIndex = yf,w.findKey = Xd,w.findLast = Np,w.findLastIndex = _f,w.findLastKey = Gd,w.floor = bv,w.forEach = Cf,w.forEachRight = Tf,w.forIn = Jd,w.forInRight = Vd,w.forOwn = Kd,w.forOwnRight = Yd,w.get = Du,w.gt = yd,w.gte = _d,w.has = eg,w.hasIn = Mu,w.head = bf,w.identity = Zt,w.includes = jp,w.indexOf = Nh,w.inRange = mg,w.invoke = rg,w.isArguments = Ri,w.isArray = ye,w.isArrayBuffer = md,w.isArrayLike = Yt,w.isArrayLikeObject = Qe,w.isBoolean = bd,w.isBuffer = Kr,w.isDate = wd,w.isElement = xd,w.isEmpty = Sd,w.isEqual = Cd,w.isEqualWith = Td,w.isError = Iu,w.isFinite = Ad,w.isFunction = Cr,w.isInteger = If,w.isLength = Ms,w.isMap = Nf,w.isMatch = Ed,w.isMatchWith = kd,w.isNaN = Od,w.isNative = Pd,w.isNil = Ld,w.isNull = Rd,w.isNumber = Df,w.isObject = $e,w.isObjectLike = Ge,w.isPlainObject = ss,w.isRegExp = Nu,w.isSafeInteger = Id,w.isSet = Mf,w.isString = qs,w.isSymbol = sn,w.isTypedArray = yo,w.isUndefined = Nd,w.isWeakMap = Dd,w.isWeakSet = Md,w.join = jh,w.kebabCase = Tg,w.last = An,w.lastIndexOf = Uh,w.lowerCase = Ag,w.lowerFirst = Eg,w.lt = qd,w.lte = Hd,w.max = wv,w.maxBy = xv,w.mean = Sv,w.meanBy = Cv,w.min = Tv,w.minBy = Av,w.stubArray = Fu,w.stubFalse = Wu,w.stubObject = lv,w.stubString = hv,w.stubTrue = pv,w.multiply = Ev,w.nth = Bh,w.noConflict = rv,w.noop = Bu,w.now = Is,w.pad = kg,w.padEnd = Og,w.padStart = Pg,w.parseInt = Rg,w.random = bg,w.reduce = $p,w.reduceRight = zp,w.repeat = Lg,w.replace = Ig,w.result = cg,w.round = kv,w.runInContext = a,w.sample = Gp,w.size = Kp,w.snakeCase = Ng,w.some = Yp,w.sortedIndex = Jh,w.sortedIndexBy = Vh,w.sortedIndexOf = Kh,w.sortedLastIndex = Yh,w.sortedLastIndexBy = Qh,w.sortedLastIndexOf = Zh,w.startCase = Mg,w.startsWith = qg,w.subtract = Ov,w.sum = Pv,w.sumBy = Rv,w.template = Hg,w.times = dv,w.toFinite = Tr,w.toInteger = be,w.toLength = Hf,w.toLower = jg,w.toNumber = En,w.toSafeInteger = jd,w.toString = Me,w.toUpper = Ug,w.trim = Bg,w.trimEnd = Fg,w.trimStart = Wg,w.truncate = $g,w.unescape = zg,w.uniqueId = vv,w.upperCase = Xg,w.upperFirst = qu,w.each = Cf,w.eachRight = Tf,w.first = bf,Uu(w, function () {
                var e = {};
                return er(w, function (t, r) {
                    pe.call(w.prototype, r) || (e[r] = t)
                }), e
            }(), {chain: !1}),w.VERSION = A,k(["bind", "bindKey", "curry", "curryRight", "partial", "partialRight"], function (e) {
                w[e].placeholder = w
            }),k(["drop", "take"], function (e, t) {
                Ee.prototype[e] = function (r) {
                    r = r === d ? 1 : ot(be(r), 0);
                    var h = this.__filtered__ && !t ? new Ee(this) : this.clone();
                    return h.__filtered__ ? h.__takeCount__ = Et(r, h.__takeCount__) : h.__views__.push({
                        size: Et(r, _t),
                        type: e + (h.__dir__ < 0 ? "Right" : "")
                    }), h
                }, Ee.prototype[e + "Right"] = function (r) {
                    return this.reverse()[e](r).reverse()
                }
            }),k(["filter", "map", "takeWhile"], function (e, t) {
                var r = t + 1, h = r == Ft || r == To;
                Ee.prototype[e] = function (_) {
                    var x = this.clone();
                    return x.__iteratees__.push({iteratee: ce(_, 3), type: r}), x.__filtered__ = x.__filtered__ || h, x
                }
            }),k(["head", "last"], function (e, t) {
                var r = "take" + (t ? "Right" : "");
                Ee.prototype[e] = function () {
                    return this[r](1).value()[0]
                }
            }),k(["initial", "tail"], function (e, t) {
                var r = "drop" + (t ? "" : "Right");
                Ee.prototype[e] = function () {
                    return this.__filtered__ ? new Ee(this) : this[r](1)
                }
            }),Ee.prototype.compact = function () {
                return this.filter(Zt)
            },Ee.prototype.find = function (e) {
                return this.filter(e).head()
            },Ee.prototype.findLast = function (e) {
                return this.reverse().find(e)
            },Ee.prototype.invokeMap = Ce(function (e, t) {
                return typeof e == "function" ? new Ee(this) : this.map(function (r) {
                    return es(r, e, t)
                })
            }),Ee.prototype.reject = function (e) {
                return this.filter(Ds(ce(e)))
            },Ee.prototype.slice = function (e, t) {
                e = be(e);
                var r = this;
                return r.__filtered__ && (e > 0 || t < 0) ? new Ee(r) : (e < 0 ? r = r.takeRight(-e) : e && (r = r.drop(e)), t !== d && (t = be(t), r = t < 0 ? r.dropRight(-t) : r.take(t - e)), r)
            },Ee.prototype.takeRightWhile = function (e) {
                return this.reverse().takeWhile(e).reverse()
            },Ee.prototype.toArray = function () {
                return this.take(_t)
            },er(Ee.prototype, function (e, t) {
                var r = /^(?:filter|find|map|reject)|While$/.test(t), h = /^(?:head|last)$/.test(t),
                    _ = w[h ? "take" + (t == "last" ? "Right" : "") : t], x = h || /^find/.test(t);
                !_ || (w.prototype[t] = function () {
                    var O = this.__wrapped__, R = h ? [1] : arguments, D = O instanceof Ee, $ = R[0], z = D || ye(O),
                        V = function (Ae) {
                            var ke = _.apply(w, ve([Ae], R));
                            return h && te ? ke[0] : ke
                        };
                    z && r && typeof $ == "function" && $.length != 1 && (D = z = !1);
                    var te = this.__chain__, fe = !!this.__actions__.length, le = x && !te, xe = D && !fe;
                    if (!x && z) {
                        O = xe ? O : new Ee(this);
                        var he = e.apply(O, R);
                        return he.__actions__.push({func: Rs, args: [V], thisArg: d}), new Sn(he, te)
                    }
                    return le && xe ? e.apply(this, R) : (he = this.thru(V), le ? h ? he.value()[0] : he.value() : he)
                })
            }),k(["pop", "push", "shift", "sort", "splice", "unshift"], function (e) {
                var t = ze[e], r = /^(?:push|sort|unshift)$/.test(e) ? "tap" : "thru", h = /^(?:pop|shift)$/.test(e);
                w.prototype[e] = function () {
                    var _ = arguments;
                    if (h && !this.__chain__) {
                        var x = this.value();
                        return t.apply(ye(x) ? x : [], _)
                    }
                    return this[r](function (O) {
                        return t.apply(ye(O) ? O : [], _)
                    })
                }
            }),er(Ee.prototype, function (e, t) {
                var r = w[t];
                if (r) {
                    var h = r.name + "";
                    pe.call(lo, h) || (lo[h] = []), lo[h].push({name: t, func: r})
                }
            }),lo[Cs(d, F).name] = [{
                name: "wrapper",
                func: d
            }],Ee.prototype.clone = zc,Ee.prototype.reverse = Xc,Ee.prototype.value = Gc,w.prototype.at = xp,w.prototype.chain = Sp,w.prototype.commit = Cp,w.prototype.next = Tp,w.prototype.plant = Ep,w.prototype.reverse = kp,w.prototype.toJSON = w.prototype.valueOf = w.prototype.value = Op,w.prototype.first = w.prototype.head,Go && (w.prototype[Go] = Ap),w
        }, u = s();
        nn ? ((nn.exports = u)._ = u, Ur._ = u) : je._ = u
    }).call(wo)
})(Vu, Vu.exports);
var Iv = Vu.exports, ta = {exports: {}}, cc = function (m, d) {
    return function () {
        for (var S = new Array(arguments.length), I = 0; I < S.length; I++) S[I] = arguments[I];
        return m.apply(d, S)
    }
}, Nv = cc, Ii = Object.prototype.toString;

function na(C) {
    return Ii.call(C) === "[object Array]"
}

function Ku(C) {
    return typeof C == "undefined"
}

function Dv(C) {
    return C !== null && !Ku(C) && C.constructor !== null && !Ku(C.constructor) && typeof C.constructor.isBuffer == "function" && C.constructor.isBuffer(C)
}

function Mv(C) {
    return Ii.call(C) === "[object ArrayBuffer]"
}

function qv(C) {
    return typeof FormData != "undefined" && C instanceof FormData
}

function Hv(C) {
    var m;
    return typeof ArrayBuffer != "undefined" && ArrayBuffer.isView ? m = ArrayBuffer.isView(C) : m = C && C.buffer && C.buffer instanceof ArrayBuffer, m
}

function jv(C) {
    return typeof C == "string"
}

function Uv(C) {
    return typeof C == "number"
}

function lc(C) {
    return C !== null && typeof C == "object"
}

function Bs(C) {
    if (Ii.call(C) !== "[object Object]") return !1;
    var m = Object.getPrototypeOf(C);
    return m === null || m === Object.prototype
}

function Bv(C) {
    return Ii.call(C) === "[object Date]"
}

function Fv(C) {
    return Ii.call(C) === "[object File]"
}

function Wv(C) {
    return Ii.call(C) === "[object Blob]"
}

function hc(C) {
    return Ii.call(C) === "[object Function]"
}

function $v(C) {
    return lc(C) && hc(C.pipe)
}

function zv(C) {
    return typeof URLSearchParams != "undefined" && C instanceof URLSearchParams
}

function Xv(C) {
    return C.trim ? C.trim() : C.replace(/^\s+|\s+$/g, "")
}

function Gv() {
    return typeof navigator != "undefined" && (navigator.product === "ReactNative" || navigator.product === "NativeScript" || navigator.product === "NS") ? !1 : typeof window != "undefined" && typeof document != "undefined"
}

function ra(C, m) {
    if (!(C === null || typeof C == "undefined")) if (typeof C != "object" && (C = [C]), na(C)) for (var d = 0, A = C.length; d < A; d++) m.call(null, C[d], d, C); else for (var S in C) Object.prototype.hasOwnProperty.call(C, S) && m.call(null, C[S], S, C)
}

function Yu() {
    var C = {};

    function m(S, I) {
        Bs(C[I]) && Bs(S) ? C[I] = Yu(C[I], S) : Bs(S) ? C[I] = Yu({}, S) : na(S) ? C[I] = S.slice() : C[I] = S
    }

    for (var d = 0, A = arguments.length; d < A; d++) ra(arguments[d], m);
    return C
}

function Jv(C, m, d) {
    return ra(m, function (S, I) {
        d && typeof S == "function" ? C[I] = Nv(S, d) : C[I] = S
    }), C
}

function Vv(C) {
    return C.charCodeAt(0) === 65279 && (C = C.slice(1)), C
}

var fn = {
    isArray: na,
    isArrayBuffer: Mv,
    isBuffer: Dv,
    isFormData: qv,
    isArrayBufferView: Hv,
    isString: jv,
    isNumber: Uv,
    isObject: lc,
    isPlainObject: Bs,
    isUndefined: Ku,
    isDate: Bv,
    isFile: Fv,
    isBlob: Wv,
    isFunction: hc,
    isStream: $v,
    isURLSearchParams: zv,
    isStandardBrowserEnv: Gv,
    forEach: ra,
    merge: Yu,
    extend: Jv,
    trim: Xv,
    stripBOM: Vv
}, mo = fn;

function Yf(C) {
    return encodeURIComponent(C).replace(/%3A/gi, ":").replace(/%24/g, "$").replace(/%2C/gi, ",").replace(/%20/g, "+").replace(/%5B/gi, "[").replace(/%5D/gi, "]")
}

var pc = function (m, d, A) {
    if (!d) return m;
    var S;
    if (A) S = A(d); else if (mo.isURLSearchParams(d)) S = d.toString(); else {
        var I = [];
        mo.forEach(d, function (B, qe) {
            B === null || typeof B == "undefined" || (mo.isArray(B) ? qe = qe + "[]" : B = [B], mo.forEach(B, function (ae) {
                mo.isDate(ae) ? ae = ae.toISOString() : mo.isObject(ae) && (ae = JSON.stringify(ae)), I.push(Yf(qe) + "=" + Yf(ae))
            }))
        }), S = I.join("&")
    }
    if (S) {
        var M = m.indexOf("#");
        M !== -1 && (m = m.slice(0, M)), m += (m.indexOf("?") === -1 ? "?" : "&") + S
    }
    return m
}, Kv = fn;

function Xs() {
    this.handlers = []
}

Xs.prototype.use = function (m, d, A) {
    return this.handlers.push({
        fulfilled: m,
        rejected: d,
        synchronous: A ? A.synchronous : !1,
        runWhen: A ? A.runWhen : null
    }), this.handlers.length - 1
};
Xs.prototype.eject = function (m) {
    this.handlers[m] && (this.handlers[m] = null)
};
Xs.prototype.forEach = function (m) {
    Kv.forEach(this.handlers, function (A) {
        A !== null && m(A)
    })
};
var Yv = Xs, Qv = fn, Zv = function (m, d) {
        Qv.forEach(m, function (S, I) {
            I !== d && I.toUpperCase() === d.toUpperCase() && (m[d] = S, delete m[I])
        })
    }, dc = function (m, d, A, S, I) {
        return m.config = d, A && (m.code = A), m.request = S, m.response = I, m.isAxiosError = !0, m.toJSON = function () {
            return {
                message: this.message,
                name: this.name,
                description: this.description,
                number: this.number,
                fileName: this.fileName,
                lineNumber: this.lineNumber,
                columnNumber: this.columnNumber,
                stack: this.stack,
                config: this.config,
                code: this.code
            }
        }, m
    }, ey = dc, gc = function (m, d, A, S, I) {
        var M = new Error(m);
        return ey(M, d, A, S, I)
    }, ty = gc, ny = function (m, d, A) {
        var S = A.config.validateStatus;
        !A.status || !S || S(A.status) ? m(A) : d(ty("Request failed with status code " + A.status, A.config, null, A.request, A))
    }, js = fn, ry = js.isStandardBrowserEnv() ? function () {
        return {
            write: function (d, A, S, I, M, ie) {
                var B = [];
                B.push(d + "=" + encodeURIComponent(A)), js.isNumber(S) && B.push("expires=" + new Date(S).toGMTString()), js.isString(I) && B.push("path=" + I), js.isString(M) && B.push("domain=" + M), ie === !0 && B.push("secure"), document.cookie = B.join("; ")
            }, read: function (d) {
                var A = document.cookie.match(new RegExp("(^|;\\s*)(" + d + ")=([^;]*)"));
                return A ? decodeURIComponent(A[3]) : null
            }, remove: function (d) {
                this.write(d, "", Date.now() - 864e5)
            }
        }
    }() : function () {
        return {
            write: function () {
            }, read: function () {
                return null
            }, remove: function () {
            }
        }
    }(), iy = function (m) {
        return /^([a-z][a-z\d\+\-\.]*:)?\/\//i.test(m)
    }, oy = function (m, d) {
        return d ? m.replace(/\/+$/, "") + "/" + d.replace(/^\/+/, "") : m
    }, sy = iy, uy = oy, ay = function (m, d) {
        return m && !sy(d) ? uy(m, d) : d
    }, $u = fn,
    fy = ["age", "authorization", "content-length", "content-type", "etag", "expires", "from", "host", "if-modified-since", "if-unmodified-since", "last-modified", "location", "max-forwards", "proxy-authorization", "referer", "retry-after", "user-agent"],
    cy = function (m) {
        var d = {}, A, S, I;
        return m && $u.forEach(m.split(`
`), function (ie) {
            if (I = ie.indexOf(":"), A = $u.trim(ie.substr(0, I)).toLowerCase(), S = $u.trim(ie.substr(I + 1)), A) {
                if (d[A] && fy.indexOf(A) >= 0) return;
                A === "set-cookie" ? d[A] = (d[A] ? d[A] : []).concat([S]) : d[A] = d[A] ? d[A] + ", " + S : S
            }
        }), d
    }, Qf = fn, ly = Qf.isStandardBrowserEnv() ? function () {
        var m = /(msie|trident)/i.test(navigator.userAgent), d = document.createElement("a"), A;

        function S(I) {
            var M = I;
            return m && (d.setAttribute("href", M), M = d.href), d.setAttribute("href", M), {
                href: d.href,
                protocol: d.protocol ? d.protocol.replace(/:$/, "") : "",
                host: d.host,
                search: d.search ? d.search.replace(/^\?/, "") : "",
                hash: d.hash ? d.hash.replace(/^#/, "") : "",
                hostname: d.hostname,
                port: d.port,
                pathname: d.pathname.charAt(0) === "/" ? d.pathname : "/" + d.pathname
            }
        }

        return A = S(window.location.href), function (M) {
            var ie = Qf.isString(M) ? S(M) : M;
            return ie.protocol === A.protocol && ie.host === A.host
        }
    }() : function () {
        return function () {
            return !0
        }
    }(), Us = fn, hy = ny, py = ry, dy = pc, gy = ay, vy = cy, yy = ly, zu = gc, Zf = function (m) {
        return new Promise(function (A, S) {
            var I = m.data, M = m.headers, ie = m.responseType;
            Us.isFormData(I) && delete M["Content-Type"];
            var B = new XMLHttpRequest;
            if (m.auth) {
                var qe = m.auth.username || "", Se = m.auth.password ? unescape(encodeURIComponent(m.auth.password)) : "";
                M.Authorization = "Basic " + btoa(qe + ":" + Se)
            }
            var ae = gy(m.baseURL, m.url);
            B.open(m.method.toUpperCase(), dy(ae, m.params, m.paramsSerializer), !0), B.timeout = m.timeout;

            function re() {
                if (!!B) {
                    var Q = "getAllResponseHeaders" in B ? vy(B.getAllResponseHeaders()) : null,
                        J = !ie || ie === "text" || ie === "json" ? B.responseText : B.response,
                        G = {data: J, status: B.status, statusText: B.statusText, headers: Q, config: m, request: B};
                    hy(A, S, G), B = null
                }
            }

            if ("onloadend" in B ? B.onloadend = re : B.onreadystatechange = function () {
                !B || B.readyState !== 4 || B.status === 0 && !(B.responseURL && B.responseURL.indexOf("file:") === 0) || setTimeout(re)
            }, B.onabort = function () {
                !B || (S(zu("Request aborted", m, "ECONNABORTED", B)), B = null)
            }, B.onerror = function () {
                S(zu("Network Error", m, null, B)), B = null
            }, B.ontimeout = function () {
                var J = "timeout of " + m.timeout + "ms exceeded";
                m.timeoutErrorMessage && (J = m.timeoutErrorMessage), S(zu(J, m, m.transitional && m.transitional.clarifyTimeoutError ? "ETIMEDOUT" : "ECONNABORTED", B)), B = null
            }, Us.isStandardBrowserEnv()) {
                var ee = (m.withCredentials || yy(ae)) && m.xsrfCookieName ? py.read(m.xsrfCookieName) : void 0;
                ee && (M[m.xsrfHeaderName] = ee)
            }
            "setRequestHeader" in B && Us.forEach(M, function (J, G) {
                typeof I == "undefined" && G.toLowerCase() === "content-type" ? delete M[G] : B.setRequestHeader(G, J)
            }), Us.isUndefined(m.withCredentials) || (B.withCredentials = !!m.withCredentials), ie && ie !== "json" && (B.responseType = m.responseType), typeof m.onDownloadProgress == "function" && B.addEventListener("progress", m.onDownloadProgress), typeof m.onUploadProgress == "function" && B.upload && B.upload.addEventListener("progress", m.onUploadProgress), m.cancelToken && m.cancelToken.promise.then(function (J) {
                !B || (B.abort(), S(J), B = null)
            }), I || (I = null), B.send(I)
        })
    }, gt = fn, ec = Zv, _y = dc, my = {"Content-Type": "application/x-www-form-urlencoded"};

function tc(C, m) {
    !gt.isUndefined(C) && gt.isUndefined(C["Content-Type"]) && (C["Content-Type"] = m)
}

function by() {
    var C;
    return (typeof XMLHttpRequest != "undefined" || typeof process != "undefined" && Object.prototype.toString.call(process) === "[object process]") && (C = Zf), C
}

function wy(C, m, d) {
    if (gt.isString(C)) try {
        return (m || JSON.parse)(C), gt.trim(C)
    } catch (A) {
        if (A.name !== "SyntaxError") throw A
    }
    return (d || JSON.stringify)(C)
}

var Gs = {
    transitional: {silentJSONParsing: !0, forcedJSONParsing: !0, clarifyTimeoutError: !1},
    adapter: by(),
    transformRequest: [function (m, d) {
        return ec(d, "Accept"), ec(d, "Content-Type"), gt.isFormData(m) || gt.isArrayBuffer(m) || gt.isBuffer(m) || gt.isStream(m) || gt.isFile(m) || gt.isBlob(m) ? m : gt.isArrayBufferView(m) ? m.buffer : gt.isURLSearchParams(m) ? (tc(d, "application/x-www-form-urlencoded;charset=utf-8"), m.toString()) : gt.isObject(m) || d && d["Content-Type"] === "application/json" ? (tc(d, "application/json"), wy(m)) : m
    }],
    transformResponse: [function (m) {
        var d = this.transitional, A = d && d.silentJSONParsing, S = d && d.forcedJSONParsing,
            I = !A && this.responseType === "json";
        if (I || S && gt.isString(m) && m.length) try {
            return JSON.parse(m)
        } catch (M) {
            if (I) throw M.name === "SyntaxError" ? _y(M, this, "E_JSON_PARSE") : M
        }
        return m
    }],
    timeout: 0,
    xsrfCookieName: "XSRF-TOKEN",
    xsrfHeaderName: "X-XSRF-TOKEN",
    maxContentLength: -1,
    maxBodyLength: -1,
    validateStatus: function (m) {
        return m >= 200 && m < 300
    }
};
Gs.headers = {common: {Accept: "application/json, text/plain, */*"}};
gt.forEach(["delete", "get", "head"], function (m) {
    Gs.headers[m] = {}
});
gt.forEach(["post", "put", "patch"], function (m) {
    Gs.headers[m] = gt.merge(my)
});
var ia = Gs, xy = fn, Sy = ia, Cy = function (m, d, A) {
    var S = this || Sy;
    return xy.forEach(A, function (M) {
        m = M.call(S, m, d)
    }), m
}, vc = function (m) {
    return !!(m && m.__CANCEL__)
}, nc = fn, Xu = Cy, Ty = vc, Ay = ia;

function Gu(C) {
    C.cancelToken && C.cancelToken.throwIfRequested()
}

var Ey = function (m) {
    Gu(m), m.headers = m.headers || {}, m.data = Xu.call(m, m.data, m.headers, m.transformRequest), m.headers = nc.merge(m.headers.common || {}, m.headers[m.method] || {}, m.headers), nc.forEach(["delete", "get", "head", "post", "put", "patch", "common"], function (S) {
        delete m.headers[S]
    });
    var d = m.adapter || Ay.adapter;
    return d(m).then(function (S) {
        return Gu(m), S.data = Xu.call(m, S.data, S.headers, m.transformResponse), S
    }, function (S) {
        return Ty(S) || (Gu(m), S && S.response && (S.response.data = Xu.call(m, S.response.data, S.response.headers, m.transformResponse))), Promise.reject(S)
    })
}, Ot = fn, yc = function (m, d) {
    d = d || {};
    var A = {}, S = ["url", "method", "data"], I = ["headers", "auth", "proxy", "params"],
        M = ["baseURL", "transformRequest", "transformResponse", "paramsSerializer", "timeout", "timeoutMessage", "withCredentials", "adapter", "responseType", "xsrfCookieName", "xsrfHeaderName", "onUploadProgress", "onDownloadProgress", "decompress", "maxContentLength", "maxBodyLength", "maxRedirects", "transport", "httpAgent", "httpsAgent", "cancelToken", "socketPath", "responseEncoding"],
        ie = ["validateStatus"];

    function B(re, ee) {
        return Ot.isPlainObject(re) && Ot.isPlainObject(ee) ? Ot.merge(re, ee) : Ot.isPlainObject(ee) ? Ot.merge({}, ee) : Ot.isArray(ee) ? ee.slice() : ee
    }

    function qe(re) {
        Ot.isUndefined(d[re]) ? Ot.isUndefined(m[re]) || (A[re] = B(void 0, m[re])) : A[re] = B(m[re], d[re])
    }

    Ot.forEach(S, function (ee) {
        Ot.isUndefined(d[ee]) || (A[ee] = B(void 0, d[ee]))
    }), Ot.forEach(I, qe), Ot.forEach(M, function (ee) {
        Ot.isUndefined(d[ee]) ? Ot.isUndefined(m[ee]) || (A[ee] = B(void 0, m[ee])) : A[ee] = B(void 0, d[ee])
    }), Ot.forEach(ie, function (ee) {
        ee in d ? A[ee] = B(m[ee], d[ee]) : ee in m && (A[ee] = B(void 0, m[ee]))
    });
    var Se = S.concat(I).concat(M).concat(ie), ae = Object.keys(m).concat(Object.keys(d)).filter(function (ee) {
        return Se.indexOf(ee) === -1
    });
    return Ot.forEach(ae, qe), A
};
const ky = "axios", Oy = "0.21.4", Py = "Promise based HTTP client for the browser and node.js", Ry = "index.js", Ly = {
        test: "grunt test",
        start: "node ./sandbox/server.js",
        build: "NODE_ENV=production grunt build",
        preversion: "npm test",
        version: "npm run build && grunt version && git add -A dist && git add CHANGELOG.md bower.json package.json",
        postversion: "git push && git push --tags",
        examples: "node ./examples/server.js",
        coveralls: "cat coverage/lcov.info | ./node_modules/coveralls/bin/coveralls.js",
        fix: "eslint --fix lib/**/*.js"
    }, Iy = {type: "git", url: "https://github.com/axios/axios.git"}, Ny = ["xhr", "http", "ajax", "promise", "node"],
    Dy = "Matt Zabriskie", My = "MIT", qy = {url: "https://github.com/axios/axios/issues"},
    Hy = "https://axios-http.com", jy = {
        coveralls: "^3.0.0",
        "es6-promise": "^4.2.4",
        grunt: "^1.3.0",
        "grunt-banner": "^0.6.0",
        "grunt-cli": "^1.2.0",
        "grunt-contrib-clean": "^1.1.0",
        "grunt-contrib-watch": "^1.0.0",
        "grunt-eslint": "^23.0.0",
        "grunt-karma": "^4.0.0",
        "grunt-mocha-test": "^0.13.3",
        "grunt-ts": "^6.0.0-beta.19",
        "grunt-webpack": "^4.0.2",
        "istanbul-instrumenter-loader": "^1.0.0",
        "jasmine-core": "^2.4.1",
        karma: "^6.3.2",
        "karma-chrome-launcher": "^3.1.0",
        "karma-firefox-launcher": "^2.1.0",
        "karma-jasmine": "^1.1.1",
        "karma-jasmine-ajax": "^0.1.13",
        "karma-safari-launcher": "^1.0.0",
        "karma-sauce-launcher": "^4.3.6",
        "karma-sinon": "^1.0.5",
        "karma-sourcemap-loader": "^0.3.8",
        "karma-webpack": "^4.0.2",
        "load-grunt-tasks": "^3.5.2",
        minimist: "^1.2.0",
        mocha: "^8.2.1",
        sinon: "^4.5.0",
        "terser-webpack-plugin": "^4.2.3",
        typescript: "^4.0.5",
        "url-search-params": "^0.10.0",
        webpack: "^4.44.2",
        "webpack-dev-server": "^3.11.0"
    }, Uy = {"./lib/adapters/http.js": "./lib/adapters/xhr.js"}, By = "dist/axios.min.js", Fy = "dist/axios.min.js",
    Wy = "./index.d.ts", $y = {"follow-redirects": "^1.14.0"}, zy = [{path: "./dist/axios.min.js", threshold: "5kB"}];
var Xy = {
    name: ky,
    version: Oy,
    description: Py,
    main: Ry,
    scripts: Ly,
    repository: Iy,
    keywords: Ny,
    author: Dy,
    license: My,
    bugs: qy,
    homepage: Hy,
    devDependencies: jy,
    browser: Uy,
    jsdelivr: By,
    unpkg: Fy,
    typings: Wy,
    dependencies: $y,
    bundlesize: zy
}, _c = Xy, oa = {};
["object", "boolean", "number", "function", "string", "symbol"].forEach(function (C, m) {
    oa[C] = function (A) {
        return typeof A === C || "a" + (m < 1 ? "n " : " ") + C
    }
});
var rc = {}, Gy = _c.version.split(".");

function mc(C, m) {
    for (var d = m ? m.split(".") : Gy, A = C.split("."), S = 0; S < 3; S++) {
        if (d[S] > A[S]) return !0;
        if (d[S] < A[S]) return !1
    }
    return !1
}

oa.transitional = function (m, d, A) {
    var S = d && mc(d);

    function I(M, ie) {
        return "[Axios v" + _c.version + "] Transitional option '" + M + "'" + ie + (A ? ". " + A : "")
    }

    return function (M, ie, B) {
        if (m === !1) throw new Error(I(ie, " has been removed in " + d));
        return S && !rc[ie] && (rc[ie] = !0, console.warn(I(ie, " has been deprecated since v" + d + " and will be removed in the near future"))), m ? m(M, ie, B) : !0
    }
};

function Jy(C, m, d) {
    if (typeof C != "object") throw new TypeError("options must be an object");
    for (var A = Object.keys(C), S = A.length; S-- > 0;) {
        var I = A[S], M = m[I];
        if (M) {
            var ie = C[I], B = ie === void 0 || M(ie, I, C);
            if (B !== !0) throw new TypeError("option " + I + " must be " + B);
            continue
        }
        if (d !== !0) throw Error("Unknown option " + I)
    }
}

var Vy = {isOlderVersion: mc, assertOptions: Jy, validators: oa}, bc = fn, Ky = pc, ic = Yv, oc = Ey, Js = yc, wc = Vy,
    bo = wc.validators;

function us(C) {
    this.defaults = C, this.interceptors = {request: new ic, response: new ic}
}

us.prototype.request = function (m) {
    typeof m == "string" ? (m = arguments[1] || {}, m.url = arguments[0]) : m = m || {}, m = Js(this.defaults, m), m.method ? m.method = m.method.toLowerCase() : this.defaults.method ? m.method = this.defaults.method.toLowerCase() : m.method = "get";
    var d = m.transitional;
    d !== void 0 && wc.assertOptions(d, {
        silentJSONParsing: bo.transitional(bo.boolean, "1.0.0"),
        forcedJSONParsing: bo.transitional(bo.boolean, "1.0.0"),
        clarifyTimeoutError: bo.transitional(bo.boolean, "1.0.0")
    }, !1);
    var A = [], S = !0;
    this.interceptors.request.forEach(function (re) {
        typeof re.runWhen == "function" && re.runWhen(m) === !1 || (S = S && re.synchronous, A.unshift(re.fulfilled, re.rejected))
    });
    var I = [];
    this.interceptors.response.forEach(function (re) {
        I.push(re.fulfilled, re.rejected)
    });
    var M;
    if (!S) {
        var ie = [oc, void 0];
        for (Array.prototype.unshift.apply(ie, A), ie = ie.concat(I), M = Promise.resolve(m); ie.length;) M = M.then(ie.shift(), ie.shift());
        return M
    }
    for (var B = m; A.length;) {
        var qe = A.shift(), Se = A.shift();
        try {
            B = qe(B)
        } catch (ae) {
            Se(ae);
            break
        }
    }
    try {
        M = oc(B)
    } catch (ae) {
        return Promise.reject(ae)
    }
    for (; I.length;) M = M.then(I.shift(), I.shift());
    return M
};
us.prototype.getUri = function (m) {
    return m = Js(this.defaults, m), Ky(m.url, m.params, m.paramsSerializer).replace(/^\?/, "")
};
bc.forEach(["delete", "get", "head", "options"], function (m) {
    us.prototype[m] = function (d, A) {
        return this.request(Js(A || {}, {method: m, url: d, data: (A || {}).data}))
    }
});
bc.forEach(["post", "put", "patch"], function (m) {
    us.prototype[m] = function (d, A, S) {
        return this.request(Js(S || {}, {method: m, url: d, data: A}))
    }
});
var Yy = us;

function sa(C) {
    this.message = C
}

sa.prototype.toString = function () {
    return "Cancel" + (this.message ? ": " + this.message : "")
};
sa.prototype.__CANCEL__ = !0;
var xc = sa, Qy = xc;

function Ws(C) {
    if (typeof C != "function") throw new TypeError("executor must be a function.");
    var m;
    this.promise = new Promise(function (S) {
        m = S
    });
    var d = this;
    C(function (S) {
        d.reason || (d.reason = new Qy(S), m(d.reason))
    })
}

Ws.prototype.throwIfRequested = function () {
    if (this.reason) throw this.reason
};
Ws.source = function () {
    var m, d = new Ws(function (S) {
        m = S
    });
    return {token: d, cancel: m}
};
var Zy = Ws, e0 = function (m) {
    return function (A) {
        return m.apply(null, A)
    }
}, t0 = function (m) {
    return typeof m == "object" && m.isAxiosError === !0
}, sc = fn, n0 = cc, Fs = Yy, r0 = yc, i0 = ia;

function Sc(C) {
    var m = new Fs(C), d = n0(Fs.prototype.request, m);
    return sc.extend(d, Fs.prototype, m), sc.extend(d, m), d
}

var jn = Sc(i0);
jn.Axios = Fs;
jn.create = function (m) {
    return Sc(r0(jn.defaults, m))
};
jn.Cancel = xc;
jn.CancelToken = Zy;
jn.isCancel = vc;
jn.all = function (m) {
    return Promise.all(m)
};
jn.spread = e0;
jn.isAxiosError = t0;
ta.exports = jn;
ta.exports.default = jn;
var o0 = ta.exports;

function Qu(C) {
    return Qu = typeof Symbol == "function" && typeof Symbol.iterator == "symbol" ? function (m) {
        return typeof m
    } : function (m) {
        return m && typeof Symbol == "function" && m.constructor === Symbol && m !== Symbol.prototype ? "symbol" : typeof m
    }, Qu(C)
}

function vt(C, m) {
    if (!(C instanceof m)) throw new TypeError("Cannot call a class as a function")
}

function uc(C, m) {
    for (var d = 0; d < m.length; d++) {
        var A = m[d];
        A.enumerable = A.enumerable || !1, A.configurable = !0, "value" in A && (A.writable = !0), Object.defineProperty(C, A.key, A)
    }
}

function yt(C, m, d) {
    return m && uc(C.prototype, m), d && uc(C, d), Object.defineProperty(C, "prototype", {writable: !1}), C
}

function Zu() {
    return Zu = Object.assign || function (C) {
        for (var m = 1; m < arguments.length; m++) {
            var d = arguments[m];
            for (var A in d) Object.prototype.hasOwnProperty.call(d, A) && (C[A] = d[A])
        }
        return C
    }, Zu.apply(this, arguments)
}

function cn(C, m) {
    if (typeof m != "function" && m !== null) throw new TypeError("Super expression must either be null or a function");
    C.prototype = Object.create(m && m.prototype, {
        constructor: {
            value: C,
            writable: !0,
            configurable: !0
        }
    }), Object.defineProperty(C, "prototype", {writable: !1}), m && ea(C, m)
}

function $s(C) {
    return $s = Object.setPrototypeOf ? Object.getPrototypeOf : function (d) {
        return d.__proto__ || Object.getPrototypeOf(d)
    }, $s(C)
}

function ea(C, m) {
    return ea = Object.setPrototypeOf || function (A, S) {
        return A.__proto__ = S, A
    }, ea(C, m)
}

function s0() {
    if (typeof Reflect == "undefined" || !Reflect.construct || Reflect.construct.sham) return !1;
    if (typeof Proxy == "function") return !0;
    try {
        return Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {
        })), !0
    } catch {
        return !1
    }
}

function u0(C) {
    if (C === void 0) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
    return C
}

function a0(C, m) {
    if (m && (typeof m == "object" || typeof m == "function")) return m;
    if (m !== void 0) throw new TypeError("Derived constructors may only return object or undefined");
    return u0(C)
}

function ln(C) {
    var m = s0();
    return function () {
        var A = $s(C), S;
        if (m) {
            var I = $s(this).constructor;
            S = Reflect.construct(A, arguments, I)
        } else S = A.apply(this, arguments);
        return a0(this, S)
    }
}

var ua = function () {
    function C() {
        vt(this, C)
    }

    return yt(C, [{
        key: "listenForWhisper", value: function (d, A) {
            return this.listen(".client-" + d, A)
        }
    }, {
        key: "notification", value: function (d) {
            return this.listen(".Illuminate\\Notifications\\Events\\BroadcastNotificationCreated", d)
        }
    }, {
        key: "stopListeningForWhisper", value: function (d, A) {
            return this.stopListening(".client-" + d, A)
        }
    }]), C
}(), Cc = function () {
    function C(m) {
        vt(this, C), this.namespace = m
    }

    return yt(C, [{
        key: "format", value: function (d) {
            return d.charAt(0) === "." || d.charAt(0) === "\\" ? d.substr(1) : (this.namespace && (d = this.namespace + "." + d), d.replace(/\./g, "\\"))
        }
    }, {
        key: "setNamespace", value: function (d) {
            this.namespace = d
        }
    }]), C
}(), Vs = function (C) {
    cn(d, C);
    var m = ln(d);

    function d(A, S, I) {
        var M;
        return vt(this, d), M = m.call(this), M.name = S, M.pusher = A, M.options = I, M.eventFormatter = new Cc(M.options.namespace), M.subscribe(), M
    }

    return yt(d, [{
        key: "subscribe", value: function () {
            this.subscription = this.pusher.subscribe(this.name)
        }
    }, {
        key: "unsubscribe", value: function () {
            this.pusher.unsubscribe(this.name)
        }
    }, {
        key: "listen", value: function (S, I) {
            return this.on(this.eventFormatter.format(S), I), this
        }
    }, {
        key: "listenToAll", value: function (S) {
            var I = this;
            return this.subscription.bind_global(function (M, ie) {
                if (!M.startsWith("pusher:")) {
                    var B = I.options.namespace.replace(/\./g, "\\"),
                        qe = M.startsWith(B) ? M.substring(B.length + 1) : "." + M;
                    S(qe, ie)
                }
            }), this
        }
    }, {
        key: "stopListening", value: function (S, I) {
            return I ? this.subscription.unbind(this.eventFormatter.format(S), I) : this.subscription.unbind(this.eventFormatter.format(S)), this
        }
    }, {
        key: "stopListeningToAll", value: function (S) {
            return S ? this.subscription.unbind_global(S) : this.subscription.unbind_global(), this
        }
    }, {
        key: "subscribed", value: function (S) {
            return this.on("pusher:subscription_succeeded", function () {
                S()
            }), this
        }
    }, {
        key: "error", value: function (S) {
            return this.on("pusher:subscription_error", function (I) {
                S(I)
            }), this
        }
    }, {
        key: "on", value: function (S, I) {
            return this.subscription.bind(S, I), this
        }
    }]), d
}(ua), f0 = function (C) {
    cn(d, C);
    var m = ln(d);

    function d() {
        return vt(this, d), m.apply(this, arguments)
    }

    return yt(d, [{
        key: "whisper", value: function (S, I) {
            return this.pusher.channels.channels[this.name].trigger("client-".concat(S), I), this
        }
    }]), d
}(Vs), c0 = function (C) {
    cn(d, C);
    var m = ln(d);

    function d() {
        return vt(this, d), m.apply(this, arguments)
    }

    return yt(d, [{
        key: "whisper", value: function (S, I) {
            return this.pusher.channels.channels[this.name].trigger("client-".concat(S), I), this
        }
    }]), d
}(Vs), l0 = function (C) {
    cn(d, C);
    var m = ln(d);

    function d() {
        return vt(this, d), m.apply(this, arguments)
    }

    return yt(d, [{
        key: "here", value: function (S) {
            return this.on("pusher:subscription_succeeded", function (I) {
                S(Object.keys(I.members).map(function (M) {
                    return I.members[M]
                }))
            }), this
        }
    }, {
        key: "joining", value: function (S) {
            return this.on("pusher:member_added", function (I) {
                S(I.info)
            }), this
        }
    }, {
        key: "whisper", value: function (S, I) {
            return this.pusher.channels.channels[this.name].trigger("client-".concat(S), I), this
        }
    }, {
        key: "leaving", value: function (S) {
            return this.on("pusher:member_removed", function (I) {
                S(I.info)
            }), this
        }
    }]), d
}(Vs), Tc = function (C) {
    cn(d, C);
    var m = ln(d);

    function d(A, S, I) {
        var M;
        return vt(this, d), M = m.call(this), M.events = {}, M.listeners = {}, M.name = S, M.socket = A, M.options = I, M.eventFormatter = new Cc(M.options.namespace), M.subscribe(), M
    }

    return yt(d, [{
        key: "subscribe", value: function () {
            this.socket.emit("subscribe", {channel: this.name, auth: this.options.auth || {}})
        }
    }, {
        key: "unsubscribe", value: function () {
            this.unbind(), this.socket.emit("unsubscribe", {channel: this.name, auth: this.options.auth || {}})
        }
    }, {
        key: "listen", value: function (S, I) {
            return this.on(this.eventFormatter.format(S), I), this
        }
    }, {
        key: "stopListening", value: function (S, I) {
            return this.unbindEvent(this.eventFormatter.format(S), I), this
        }
    }, {
        key: "subscribed", value: function (S) {
            return this.on("connect", function (I) {
                S(I)
            }), this
        }
    }, {
        key: "error", value: function (S) {
            return this
        }
    }, {
        key: "on", value: function (S, I) {
            var M = this;
            return this.listeners[S] = this.listeners[S] || [], this.events[S] || (this.events[S] = function (ie, B) {
                M.name === ie && M.listeners[S] && M.listeners[S].forEach(function (qe) {
                    return qe(B)
                })
            }, this.socket.on(S, this.events[S])), this.listeners[S].push(I), this
        }
    }, {
        key: "unbind", value: function () {
            var S = this;
            Object.keys(this.events).forEach(function (I) {
                S.unbindEvent(I)
            })
        }
    }, {
        key: "unbindEvent", value: function (S, I) {
            this.listeners[S] = this.listeners[S] || [], I && (this.listeners[S] = this.listeners[S].filter(function (M) {
                return M !== I
            })), (!I || this.listeners[S].length === 0) && (this.events[S] && (this.socket.removeListener(S, this.events[S]), delete this.events[S]), delete this.listeners[S])
        }
    }]), d
}(ua), Ac = function (C) {
    cn(d, C);
    var m = ln(d);

    function d() {
        return vt(this, d), m.apply(this, arguments)
    }

    return yt(d, [{
        key: "whisper", value: function (S, I) {
            return this.socket.emit("client event", {channel: this.name, event: "client-".concat(S), data: I}), this
        }
    }]), d
}(Tc), h0 = function (C) {
    cn(d, C);
    var m = ln(d);

    function d() {
        return vt(this, d), m.apply(this, arguments)
    }

    return yt(d, [{
        key: "here", value: function (S) {
            return this.on("presence:subscribed", function (I) {
                S(I.map(function (M) {
                    return M.user_info
                }))
            }), this
        }
    }, {
        key: "joining", value: function (S) {
            return this.on("presence:joining", function (I) {
                return S(I.user_info)
            }), this
        }
    }, {
        key: "whisper", value: function (S, I) {
            return this.socket.emit("client event", {channel: this.name, event: "client-".concat(S), data: I}), this
        }
    }, {
        key: "leaving", value: function (S) {
            return this.on("presence:leaving", function (I) {
                return S(I.user_info)
            }), this
        }
    }]), d
}(Ac), zs = function (C) {
    cn(d, C);
    var m = ln(d);

    function d() {
        return vt(this, d), m.apply(this, arguments)
    }

    return yt(d, [{
        key: "subscribe", value: function () {
        }
    }, {
        key: "unsubscribe", value: function () {
        }
    }, {
        key: "listen", value: function (S, I) {
            return this
        }
    }, {
        key: "listenToAll", value: function (S) {
            return this
        }
    }, {
        key: "stopListening", value: function (S, I) {
            return this
        }
    }, {
        key: "subscribed", value: function (S) {
            return this
        }
    }, {
        key: "error", value: function (S) {
            return this
        }
    }, {
        key: "on", value: function (S, I) {
            return this
        }
    }]), d
}(ua), ac = function (C) {
    cn(d, C);
    var m = ln(d);

    function d() {
        return vt(this, d), m.apply(this, arguments)
    }

    return yt(d, [{
        key: "whisper", value: function (S, I) {
            return this
        }
    }]), d
}(zs), p0 = function (C) {
    cn(d, C);
    var m = ln(d);

    function d() {
        return vt(this, d), m.apply(this, arguments)
    }

    return yt(d, [{
        key: "here", value: function (S) {
            return this
        }
    }, {
        key: "joining", value: function (S) {
            return this
        }
    }, {
        key: "whisper", value: function (S, I) {
            return this
        }
    }, {
        key: "leaving", value: function (S) {
            return this
        }
    }]), d
}(zs), aa = function () {
    function C(m) {
        vt(this, C), this._defaultOptions = {
            auth: {headers: {}},
            authEndpoint: "/broadcasting/auth",
            userAuthentication: {endpoint: "/broadcasting/user-auth", headers: {}},
            broadcaster: "pusher",
            csrfToken: null,
            bearerToken: null,
            host: null,
            key: null,
            namespace: "App.Events"
        }, this.setOptions(m), this.connect()
    }

    return yt(C, [{
        key: "setOptions", value: function (d) {
            this.options = Zu(this._defaultOptions, d);
            var A = this.csrfToken();
            return A && (this.options.auth.headers["X-CSRF-TOKEN"] = A, this.options.userAuthentication.headers["X-CSRF-TOKEN"] = A), A = this.options.bearerToken, A && (this.options.auth.headers.Authorization = "Bearer " + A, this.options.userAuthentication.headers.Authorization = "Bearer " + A), d
        }
    }, {
        key: "csrfToken", value: function () {
            var d;
            return typeof window != "undefined" && window.Laravel && window.Laravel.csrfToken ? window.Laravel.csrfToken : this.options.csrfToken ? this.options.csrfToken : typeof document != "undefined" && typeof document.querySelector == "function" && (d = document.querySelector('meta[name="csrf-token"]')) ? d.getAttribute("content") : null
        }
    }]), C
}(), d0 = function (C) {
    cn(d, C);
    var m = ln(d);

    function d() {
        var A;
        return vt(this, d), A = m.apply(this, arguments), A.channels = {}, A
    }

    return yt(d, [{
        key: "connect", value: function () {
            typeof this.options.client != "undefined" ? this.pusher = this.options.client : this.options.Pusher ? this.pusher = new this.options.Pusher(this.options.key, this.options) : this.pusher = new Pusher(this.options.key, this.options)
        }
    }, {
        key: "signin", value: function () {
            this.pusher.signin()
        }
    }, {
        key: "listen", value: function (S, I, M) {
            return this.channel(S).listen(I, M)
        }
    }, {
        key: "channel", value: function (S) {
            return this.channels[S] || (this.channels[S] = new Vs(this.pusher, S, this.options)), this.channels[S]
        }
    }, {
        key: "privateChannel", value: function (S) {
            return this.channels["private-" + S] || (this.channels["private-" + S] = new f0(this.pusher, "private-" + S, this.options)), this.channels["private-" + S]
        }
    }, {
        key: "encryptedPrivateChannel", value: function (S) {
            return this.channels["private-encrypted-" + S] || (this.channels["private-encrypted-" + S] = new c0(this.pusher, "private-encrypted-" + S, this.options)), this.channels["private-encrypted-" + S]
        }
    }, {
        key: "presenceChannel", value: function (S) {
            return this.channels["presence-" + S] || (this.channels["presence-" + S] = new l0(this.pusher, "presence-" + S, this.options)), this.channels["presence-" + S]
        }
    }, {
        key: "leave", value: function (S) {
            var I = this, M = [S, "private-" + S, "private-encrypted-" + S, "presence-" + S];
            M.forEach(function (ie, B) {
                I.leaveChannel(ie)
            })
        }
    }, {
        key: "leaveChannel", value: function (S) {
            this.channels[S] && (this.channels[S].unsubscribe(), delete this.channels[S])
        }
    }, {
        key: "socketId", value: function () {
            return this.pusher.connection.socket_id
        }
    }, {
        key: "disconnect", value: function () {
            this.pusher.disconnect()
        }
    }]), d
}(aa), g0 = function (C) {
    cn(d, C);
    var m = ln(d);

    function d() {
        var A;
        return vt(this, d), A = m.apply(this, arguments), A.channels = {}, A
    }

    return yt(d, [{
        key: "connect", value: function () {
            var S = this, I = this.getSocketIO();
            return this.socket = I(this.options.host, this.options), this.socket.on("reconnect", function () {
                Object.values(S.channels).forEach(function (M) {
                    M.subscribe()
                })
            }), this.socket
        }
    }, {
        key: "getSocketIO", value: function () {
            if (typeof this.options.client != "undefined") return this.options.client;
            if (typeof io != "undefined") return io;
            throw new Error("Socket.io client not found. Should be globally available or passed via options.client")
        }
    }, {
        key: "listen", value: function (S, I, M) {
            return this.channel(S).listen(I, M)
        }
    }, {
        key: "channel", value: function (S) {
            return this.channels[S] || (this.channels[S] = new Tc(this.socket, S, this.options)), this.channels[S]
        }
    }, {
        key: "privateChannel", value: function (S) {
            return this.channels["private-" + S] || (this.channels["private-" + S] = new Ac(this.socket, "private-" + S, this.options)), this.channels["private-" + S]
        }
    }, {
        key: "presenceChannel", value: function (S) {
            return this.channels["presence-" + S] || (this.channels["presence-" + S] = new h0(this.socket, "presence-" + S, this.options)), this.channels["presence-" + S]
        }
    }, {
        key: "leave", value: function (S) {
            var I = this, M = [S, "private-" + S, "presence-" + S];
            M.forEach(function (ie) {
                I.leaveChannel(ie)
            })
        }
    }, {
        key: "leaveChannel", value: function (S) {
            this.channels[S] && (this.channels[S].unsubscribe(), delete this.channels[S])
        }
    }, {
        key: "socketId", value: function () {
            return this.socket.id
        }
    }, {
        key: "disconnect", value: function () {
            this.socket.disconnect()
        }
    }]), d
}(aa), v0 = function (C) {
    cn(d, C);
    var m = ln(d);

    function d() {
        var A;
        return vt(this, d), A = m.apply(this, arguments), A.channels = {}, A
    }

    return yt(d, [{
        key: "connect", value: function () {
        }
    }, {
        key: "listen", value: function (S, I, M) {
            return new zs
        }
    }, {
        key: "channel", value: function (S) {
            return new zs
        }
    }, {
        key: "privateChannel", value: function (S) {
            return new ac
        }
    }, {
        key: "encryptedPrivateChannel", value: function (S) {
            return new ac
        }
    }, {
        key: "presenceChannel", value: function (S) {
            return new p0
        }
    }, {
        key: "leave", value: function (S) {
        }
    }, {
        key: "leaveChannel", value: function (S) {
        }
    }, {
        key: "socketId", value: function () {
            return "fake-socket-id"
        }
    }, {
        key: "disconnect", value: function () {
        }
    }]), d
}(aa), fa = function () {
    function C(m) {
        vt(this, C), this.options = m, this.connect(), this.options.withoutInterceptors || this.registerInterceptors()
    }

    return yt(C, [{
        key: "channel", value: function (d) {
            return this.connector.channel(d)
        }
    }, {
        key: "connect", value: function () {
            this.options.broadcaster == "pusher" ? this.connector = new d0(this.options) : this.options.broadcaster == "socket.io" ? this.connector = new g0(this.options) : this.options.broadcaster == "null" ? this.connector = new v0(this.options) : typeof this.options.broadcaster == "function" && (this.connector = new this.options.broadcaster(this.options))
        }
    }, {
        key: "disconnect", value: function () {
            this.connector.disconnect()
        }
    }, {
        key: "join", value: function (d) {
            return this.connector.presenceChannel(d)
        }
    }, {
        key: "leave", value: function (d) {
            this.connector.leave(d)
        }
    }, {
        key: "leaveChannel", value: function (d) {
            this.connector.leaveChannel(d)
        }
    }, {
        key: "leaveAllChannels", value: function () {
            for (var d in this.connector.channels) this.leaveChannel(d)
        }
    }, {
        key: "listen", value: function (d, A, S) {
            return this.connector.listen(d, A, S)
        }
    }, {
        key: "private", value: function (d) {
            return this.connector.privateChannel(d)
        }
    }, {
        key: "encryptedPrivate", value: function (d) {
            return this.connector.encryptedPrivateChannel(d)
        }
    }, {
        key: "socketId", value: function () {
            return this.connector.socketId()
        }
    }, {
        key: "registerInterceptors", value: function () {
            typeof Vue == "function" && Vue.http && this.registerVueRequestInterceptor(), typeof axios == "function" && this.registerAxiosRequestInterceptor(), typeof jQuery == "function" && this.registerjQueryAjaxSetup(), (typeof Turbo == "undefined" ? "undefined" : Qu(Turbo)) === "object" && this.registerTurboRequestInterceptor()
        }
    }, {
        key: "registerVueRequestInterceptor", value: function () {
            var d = this;
            Vue.http.interceptors.push(function (A, S) {
                d.socketId() && A.headers.set("X-Socket-ID", d.socketId()), S()
            })
        }
    }, {
        key: "registerAxiosRequestInterceptor", value: function () {
            var d = this;
            axios.interceptors.request.use(function (A) {
                return d.socketId() && (A.headers["X-Socket-Id"] = d.socketId()), A
            })
        }
    }, {
        key: "registerjQueryAjaxSetup", value: function () {
            var d = this;
            typeof jQuery.ajax != "undefined" && jQuery.ajaxPrefilter(function (A, S, I) {
                d.socketId() && I.setRequestHeader("X-Socket-Id", d.socketId())
            })
        }
    }, {
        key: "registerTurboRequestInterceptor", value: function () {
            var d = this;
            document.addEventListener("turbo:before-fetch-request", function (A) {
                A.detail.fetchOptions.headers["X-Socket-Id"] = d.socketId()
            })
        }
    }]), C
}(), Ec = {exports: {}};/*!
 * Pusher JavaScript Library v7.6.0
 * https://pusher.com/
 *
 * Copyright 2020, Pusher
 * Released under the MIT licence.
 */
(function (C, m) {
    (function (A, S) {
        C.exports = S()
    })(window, function () {
        return function (d) {
            var A = {};

            function S(I) {
                if (A[I]) return A[I].exports;
                var M = A[I] = {i: I, l: !1, exports: {}};
                return d[I].call(M.exports, M, M.exports, S), M.l = !0, M.exports
            }

            return S.m = d, S.c = A, S.d = function (I, M, ie) {
                S.o(I, M) || Object.defineProperty(I, M, {enumerable: !0, get: ie})
            }, S.r = function (I) {
                typeof Symbol != "undefined" && Symbol.toStringTag && Object.defineProperty(I, Symbol.toStringTag, {value: "Module"}), Object.defineProperty(I, "__esModule", {value: !0})
            }, S.t = function (I, M) {
                if (M & 1 && (I = S(I)), M & 8 || M & 4 && typeof I == "object" && I && I.__esModule) return I;
                var ie = Object.create(null);
                if (S.r(ie), Object.defineProperty(ie, "default", {
                    enumerable: !0,
                    value: I
                }), M & 2 && typeof I != "string") for (var B in I) S.d(ie, B, function (qe) {
                    return I[qe]
                }.bind(null, B));
                return ie
            }, S.n = function (I) {
                var M = I && I.__esModule ? function () {
                    return I.default
                } : function () {
                    return I
                };
                return S.d(M, "a", M), M
            }, S.o = function (I, M) {
                return Object.prototype.hasOwnProperty.call(I, M)
            }, S.p = "", S(S.s = 2)
        }([function (d, A, S) {
            var I = this && this.__extends || function () {
                var J = function (G, F) {
                    return J = Object.setPrototypeOf || {__proto__: []} instanceof Array && function (de, Te) {
                        de.__proto__ = Te
                    } || function (de, Te) {
                        for (var Ne in Te) Te.hasOwnProperty(Ne) && (de[Ne] = Te[Ne])
                    }, J(G, F)
                };
                return function (G, F) {
                    J(G, F);

                    function de() {
                        this.constructor = G
                    }

                    G.prototype = F === null ? Object.create(F) : (de.prototype = F.prototype, new de)
                }
            }();
            Object.defineProperty(A, "__esModule", {value: !0});
            var M = 256, ie = function () {
                function J(G) {
                    G === void 0 && (G = "="), this._paddingCharacter = G
                }

                return J.prototype.encodedLength = function (G) {
                    return this._paddingCharacter ? (G + 2) / 3 * 4 | 0 : (G * 8 + 5) / 6 | 0
                }, J.prototype.encode = function (G) {
                    for (var F = "", de = 0; de < G.length - 2; de += 3) {
                        var Te = G[de] << 16 | G[de + 1] << 8 | G[de + 2];
                        F += this._encodeByte(Te >>> 3 * 6 & 63), F += this._encodeByte(Te >>> 2 * 6 & 63), F += this._encodeByte(Te >>> 1 * 6 & 63), F += this._encodeByte(Te >>> 0 * 6 & 63)
                    }
                    var Ne = G.length - de;
                    if (Ne > 0) {
                        var Te = G[de] << 16 | (Ne === 2 ? G[de + 1] << 8 : 0);
                        F += this._encodeByte(Te >>> 3 * 6 & 63), F += this._encodeByte(Te >>> 2 * 6 & 63), Ne === 2 ? F += this._encodeByte(Te >>> 1 * 6 & 63) : F += this._paddingCharacter || "", F += this._paddingCharacter || ""
                    }
                    return F
                }, J.prototype.maxDecodedLength = function (G) {
                    return this._paddingCharacter ? G / 4 * 3 | 0 : (G * 6 + 7) / 8 | 0
                }, J.prototype.decodedLength = function (G) {
                    return this.maxDecodedLength(G.length - this._getPaddingLength(G))
                }, J.prototype.decode = function (G) {
                    if (G.length === 0) return new Uint8Array(0);
                    for (var F = this._getPaddingLength(G), de = G.length - F, Te = new Uint8Array(this.maxDecodedLength(de)), Ne = 0, He = 0, et = 0, p = 0, tt = 0, _e = 0, Bt = 0; He < de - 4; He += 4) p = this._decodeChar(G.charCodeAt(He + 0)), tt = this._decodeChar(G.charCodeAt(He + 1)), _e = this._decodeChar(G.charCodeAt(He + 2)), Bt = this._decodeChar(G.charCodeAt(He + 3)), Te[Ne++] = p << 2 | tt >>> 4, Te[Ne++] = tt << 4 | _e >>> 2, Te[Ne++] = _e << 6 | Bt, et |= p & M, et |= tt & M, et |= _e & M, et |= Bt & M;
                    if (He < de - 1 && (p = this._decodeChar(G.charCodeAt(He)), tt = this._decodeChar(G.charCodeAt(He + 1)), Te[Ne++] = p << 2 | tt >>> 4, et |= p & M, et |= tt & M), He < de - 2 && (_e = this._decodeChar(G.charCodeAt(He + 2)), Te[Ne++] = tt << 4 | _e >>> 2, et |= _e & M), He < de - 3 && (Bt = this._decodeChar(G.charCodeAt(He + 3)), Te[Ne++] = _e << 6 | Bt, et |= Bt & M), et !== 0) throw new Error("Base64Coder: incorrect characters for decoding");
                    return Te
                }, J.prototype._encodeByte = function (G) {
                    var F = G;
                    return F += 65, F += 25 - G >>> 8 & 0 - 65 - 26 + 97, F += 51 - G >>> 8 & 26 - 97 - 52 + 48, F += 61 - G >>> 8 & 52 - 48 - 62 + 43, F += 62 - G >>> 8 & 62 - 43 - 63 + 47, String.fromCharCode(F)
                }, J.prototype._decodeChar = function (G) {
                    var F = M;
                    return F += (42 - G & G - 44) >>> 8 & -M + G - 43 + 62, F += (46 - G & G - 48) >>> 8 & -M + G - 47 + 63, F += (47 - G & G - 58) >>> 8 & -M + G - 48 + 52, F += (64 - G & G - 91) >>> 8 & -M + G - 65 + 0, F += (96 - G & G - 123) >>> 8 & -M + G - 97 + 26, F
                }, J.prototype._getPaddingLength = function (G) {
                    var F = 0;
                    if (this._paddingCharacter) {
                        for (var de = G.length - 1; de >= 0 && G[de] === this._paddingCharacter; de--) F++;
                        if (G.length < 4 || F > 2) throw new Error("Base64Coder: incorrect padding")
                    }
                    return F
                }, J
            }();
            A.Coder = ie;
            var B = new ie;

            function qe(J) {
                return B.encode(J)
            }

            A.encode = qe;

            function Se(J) {
                return B.decode(J)
            }

            A.decode = Se;
            var ae = function (J) {
                I(G, J);

                function G() {
                    return J !== null && J.apply(this, arguments) || this
                }

                return G.prototype._encodeByte = function (F) {
                    var de = F;
                    return de += 65, de += 25 - F >>> 8 & 0 - 65 - 26 + 97, de += 51 - F >>> 8 & 26 - 97 - 52 + 48, de += 61 - F >>> 8 & 52 - 48 - 62 + 45, de += 62 - F >>> 8 & 62 - 45 - 63 + 95, String.fromCharCode(de)
                }, G.prototype._decodeChar = function (F) {
                    var de = M;
                    return de += (44 - F & F - 46) >>> 8 & -M + F - 45 + 62, de += (94 - F & F - 96) >>> 8 & -M + F - 95 + 63, de += (47 - F & F - 58) >>> 8 & -M + F - 48 + 52, de += (64 - F & F - 91) >>> 8 & -M + F - 65 + 0, de += (96 - F & F - 123) >>> 8 & -M + F - 97 + 26, de
                }, G
            }(ie);
            A.URLSafeCoder = ae;
            var re = new ae;

            function ee(J) {
                return re.encode(J)
            }

            A.encodeURLSafe = ee;

            function Q(J) {
                return re.decode(J)
            }

            A.decodeURLSafe = Q, A.encodedLength = function (J) {
                return B.encodedLength(J)
            }, A.maxDecodedLength = function (J) {
                return B.maxDecodedLength(J)
            }, A.decodedLength = function (J) {
                return B.decodedLength(J)
            }
        }, function (d, A, S) {
            Object.defineProperty(A, "__esModule", {value: !0});
            var I = "utf8: invalid string", M = "utf8: invalid source encoding";

            function ie(Se) {
                for (var ae = new Uint8Array(B(Se)), re = 0, ee = 0; ee < Se.length; ee++) {
                    var Q = Se.charCodeAt(ee);
                    Q < 128 ? ae[re++] = Q : Q < 2048 ? (ae[re++] = 192 | Q >> 6, ae[re++] = 128 | Q & 63) : Q < 55296 ? (ae[re++] = 224 | Q >> 12, ae[re++] = 128 | Q >> 6 & 63, ae[re++] = 128 | Q & 63) : (ee++, Q = (Q & 1023) << 10, Q |= Se.charCodeAt(ee) & 1023, Q += 65536, ae[re++] = 240 | Q >> 18, ae[re++] = 128 | Q >> 12 & 63, ae[re++] = 128 | Q >> 6 & 63, ae[re++] = 128 | Q & 63)
                }
                return ae
            }

            A.encode = ie;

            function B(Se) {
                for (var ae = 0, re = 0; re < Se.length; re++) {
                    var ee = Se.charCodeAt(re);
                    if (ee < 128) ae += 1; else if (ee < 2048) ae += 2; else if (ee < 55296) ae += 3; else if (ee <= 57343) {
                        if (re >= Se.length - 1) throw new Error(I);
                        re++, ae += 4
                    } else throw new Error(I)
                }
                return ae
            }

            A.encodedLength = B;

            function qe(Se) {
                for (var ae = [], re = 0; re < Se.length; re++) {
                    var ee = Se[re];
                    if (ee & 128) {
                        var Q = void 0;
                        if (ee < 224) {
                            if (re >= Se.length) throw new Error(M);
                            var J = Se[++re];
                            if ((J & 192) !== 128) throw new Error(M);
                            ee = (ee & 31) << 6 | J & 63, Q = 128
                        } else if (ee < 240) {
                            if (re >= Se.length - 1) throw new Error(M);
                            var J = Se[++re], G = Se[++re];
                            if ((J & 192) !== 128 || (G & 192) !== 128) throw new Error(M);
                            ee = (ee & 15) << 12 | (J & 63) << 6 | G & 63, Q = 2048
                        } else if (ee < 248) {
                            if (re >= Se.length - 2) throw new Error(M);
                            var J = Se[++re], G = Se[++re], F = Se[++re];
                            if ((J & 192) !== 128 || (G & 192) !== 128 || (F & 192) !== 128) throw new Error(M);
                            ee = (ee & 15) << 18 | (J & 63) << 12 | (G & 63) << 6 | F & 63, Q = 65536
                        } else throw new Error(M);
                        if (ee < Q || ee >= 55296 && ee <= 57343) throw new Error(M);
                        if (ee >= 65536) {
                            if (ee > 1114111) throw new Error(M);
                            ee -= 65536, ae.push(String.fromCharCode(55296 | ee >> 10)), ee = 56320 | ee & 1023
                        }
                    }
                    ae.push(String.fromCharCode(ee))
                }
                return ae.join("")
            }

            A.decode = qe
        }, function (d, A, S) {
            d.exports = S(3).default
        }, function (d, A, S) {
            S.r(A);
            var I = function () {
                function o(s, u) {
                    this.lastId = 0, this.prefix = s, this.name = u
                }

                return o.prototype.create = function (s) {
                    this.lastId++;
                    var u = this.lastId, a = this.prefix + u, c = this.name + "[" + u + "]", g = !1, E = function () {
                        g || (s.apply(null, arguments), g = !0)
                    };
                    return this[u] = E, {number: u, id: a, name: c, callback: E}
                }, o.prototype.remove = function (s) {
                    delete this[s.number]
                }, o
            }(), M = new I("_pusher_script_", "Pusher.ScriptReceivers"), ie = {
                VERSION: "7.6.0",
                PROTOCOL: 7,
                wsPort: 80,
                wssPort: 443,
                wsPath: "",
                httpHost: "sockjs.pusher.com",
                httpPort: 80,
                httpsPort: 443,
                httpPath: "/pusher",
                stats_host: "stats.pusher.com",
                authEndpoint: "/pusher/auth",
                authTransport: "ajax",
                activityTimeout: 12e4,
                pongTimeout: 3e4,
                unavailableTimeout: 1e4,
                cluster: "mt1",
                userAuthentication: {endpoint: "/pusher/user-auth", transport: "ajax"},
                channelAuthorization: {endpoint: "/pusher/auth", transport: "ajax"},
                cdn_http: "http://js.pusher.com",
                cdn_https: "https://js.pusher.com",
                dependency_suffix: ""
            }, B = ie, qe = function () {
                function o(s) {
                    this.options = s, this.receivers = s.receivers || M, this.loading = {}
                }

                return o.prototype.load = function (s, u, a) {
                    var c = this;
                    if (c.loading[s] && c.loading[s].length > 0) c.loading[s].push(a); else {
                        c.loading[s] = [a];
                        var g = Z.createScriptRequest(c.getPath(s, u)), E = c.receivers.create(function (L) {
                            if (c.receivers.remove(E), c.loading[s]) {
                                var W = c.loading[s];
                                delete c.loading[s];
                                for (var j = function (ue) {
                                    ue || g.cleanup()
                                }, X = 0; X < W.length; X++) W[X](L, j)
                            }
                        });
                        g.send(E)
                    }
                }, o.prototype.getRoot = function (s) {
                    var u, a = Z.getDocument().location.protocol;
                    return s && s.useTLS || a === "https:" ? u = this.options.cdn_https : u = this.options.cdn_http, u.replace(/\/*$/, "") + "/" + this.options.version
                }, o.prototype.getPath = function (s, u) {
                    return this.getRoot(u) + "/" + s + this.options.suffix + ".js"
                }, o
            }(), Se = qe, ae = new I("_pusher_dependencies", "Pusher.DependenciesReceivers"), re = new Se({
                cdn_http: B.cdn_http,
                cdn_https: B.cdn_https,
                version: B.VERSION,
                suffix: B.dependency_suffix,
                receivers: ae
            }), ee = {
                baseUrl: "https://pusher.com",
                urls: {
                    authenticationEndpoint: {path: "/docs/channels/server_api/authenticating_users"},
                    authorizationEndpoint: {path: "/docs/channels/server_api/authorizing-users/"},
                    javascriptQuickStart: {path: "/docs/javascript_quick_start"},
                    triggeringClientEvents: {path: "/docs/client_api_guide/client_events#trigger-events"},
                    encryptedChannelSupport: {fullUrl: "https://github.com/pusher/pusher-js/tree/cc491015371a4bde5743d1c87a0fbac0feb53195#encrypted-channel-support"}
                }
            }, Q = function (o) {
                var s = "See:", u = ee.urls[o];
                if (!u) return "";
                var a;
                return u.fullUrl ? a = u.fullUrl : u.path && (a = ee.baseUrl + u.path), a ? s + " " + a : ""
            }, J = {buildLogSuffix: Q}, G;
            (function (o) {
                o.UserAuthentication = "user-authentication", o.ChannelAuthorization = "channel-authorization"
            })(G || (G = {}));
            var F = function () {
                var o = function (s, u) {
                    return o = Object.setPrototypeOf || {__proto__: []} instanceof Array && function (a, c) {
                        a.__proto__ = c
                    } || function (a, c) {
                        for (var g in c) c.hasOwnProperty(g) && (a[g] = c[g])
                    }, o(s, u)
                };
                return function (s, u) {
                    o(s, u);

                    function a() {
                        this.constructor = s
                    }

                    s.prototype = u === null ? Object.create(u) : (a.prototype = u.prototype, new a)
                }
            }(), de = function (o) {
                F(s, o);

                function s(u) {
                    var a = this.constructor, c = o.call(this, u) || this;
                    return Object.setPrototypeOf(c, a.prototype), c
                }

                return s
            }(Error), Te = function (o) {
                F(s, o);

                function s(u) {
                    var a = this.constructor, c = o.call(this, u) || this;
                    return Object.setPrototypeOf(c, a.prototype), c
                }

                return s
            }(Error), Ne = function (o) {
                F(s, o);

                function s(u) {
                    var a = this.constructor, c = o.call(this, u) || this;
                    return Object.setPrototypeOf(c, a.prototype), c
                }

                return s
            }(Error), He = function (o) {
                F(s, o);

                function s(u) {
                    var a = this.constructor, c = o.call(this, u) || this;
                    return Object.setPrototypeOf(c, a.prototype), c
                }

                return s
            }(Error), et = function (o) {
                F(s, o);

                function s(u) {
                    var a = this.constructor, c = o.call(this, u) || this;
                    return Object.setPrototypeOf(c, a.prototype), c
                }

                return s
            }(Error), p = function (o) {
                F(s, o);

                function s(u) {
                    var a = this.constructor, c = o.call(this, u) || this;
                    return Object.setPrototypeOf(c, a.prototype), c
                }

                return s
            }(Error), tt = function (o) {
                F(s, o);

                function s(u) {
                    var a = this.constructor, c = o.call(this, u) || this;
                    return Object.setPrototypeOf(c, a.prototype), c
                }

                return s
            }(Error), _e = function (o) {
                F(s, o);

                function s(u) {
                    var a = this.constructor, c = o.call(this, u) || this;
                    return Object.setPrototypeOf(c, a.prototype), c
                }

                return s
            }(Error), Bt = function (o) {
                F(s, o);

                function s(u, a) {
                    var c = this.constructor, g = o.call(this, a) || this;
                    return g.status = u, Object.setPrototypeOf(g, c.prototype), g
                }

                return s
            }(Error), So = function (o, s, u, a, c) {
                var g = Z.createXHR();
                g.open("POST", u.endpoint, !0), g.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                for (var E in u.headers) g.setRequestHeader(E, u.headers[E]);
                if (u.headersProvider != null) {
                    var L = u.headersProvider();
                    for (var E in L) g.setRequestHeader(E, L[E])
                }
                return g.onreadystatechange = function () {
                    if (g.readyState === 4) if (g.status === 200) {
                        var W = void 0, j = !1;
                        try {
                            W = JSON.parse(g.responseText), j = !0
                        } catch {
                            c(new Bt(200, "JSON returned from " + a.toString() + " endpoint was invalid, yet status code was 200. Data was: " + g.responseText), null)
                        }
                        j && c(null, W)
                    } else {
                        var X = "";
                        switch (a) {
                            case G.UserAuthentication:
                                X = J.buildLogSuffix("authenticationEndpoint");
                                break;
                            case G.ChannelAuthorization:
                                X = "Clients must be authorized to join private or presence channels. " + J.buildLogSuffix("authorizationEndpoint");
                                break
                        }
                        c(new Bt(g.status, "Unable to retrieve auth string from " + a.toString() + " endpoint - " + ("received status: " + g.status + " from " + u.endpoint + ". " + X)), null)
                    }
                }, g.send(s), g
            }, Co = So;

            function Ie(o) {
                return Un(it(o))
            }

            var Ft = String.fromCharCode, kr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/",
                To = function (o) {
                    var s = o.charCodeAt(0);
                    return s < 128 ? o : s < 2048 ? Ft(192 | s >>> 6) + Ft(128 | s & 63) : Ft(224 | s >>> 12 & 15) + Ft(128 | s >>> 6 & 63) + Ft(128 | s & 63)
                }, it = function (o) {
                    return o.replace(/[^\x00-\x7F]/g, To)
                }, Wt = function (o) {
                    var s = [0, 2, 1][o.length % 3],
                        u = o.charCodeAt(0) << 16 | (o.length > 1 ? o.charCodeAt(1) : 0) << 8 | (o.length > 2 ? o.charCodeAt(2) : 0),
                        a = [kr.charAt(u >>> 18), kr.charAt(u >>> 12 & 63), s >= 2 ? "=" : kr.charAt(u >>> 6 & 63), s >= 1 ? "=" : kr.charAt(u & 63)];
                    return a.join("")
                }, Un = window.btoa || function (o) {
                    return o.replace(/[\s\S]{1,3}/g, Wt)
                }, rr = function () {
                    function o(s, u, a, c) {
                        var g = this;
                        this.clear = u, this.timer = s(function () {
                            g.timer && (g.timer = c(g.timer))
                        }, a)
                    }

                    return o.prototype.isRunning = function () {
                        return this.timer !== null
                    }, o.prototype.ensureAborted = function () {
                        this.timer && (this.clear(this.timer), this.timer = null)
                    }, o
                }(), _t = rr, Yr = function () {
                    var o = function (s, u) {
                        return o = Object.setPrototypeOf || {__proto__: []} instanceof Array && function (a, c) {
                            a.__proto__ = c
                        } || function (a, c) {
                            for (var g in c) c.hasOwnProperty(g) && (a[g] = c[g])
                        }, o(s, u)
                    };
                    return function (s, u) {
                        o(s, u);

                        function a() {
                            this.constructor = s
                        }

                        s.prototype = u === null ? Object.create(u) : (a.prototype = u.prototype, new a)
                    }
                }();

            function Qr(o) {
                window.clearTimeout(o)
            }

            function Ni(o) {
                window.clearInterval(o)
            }

            var mt = function (o) {
                Yr(s, o);

                function s(u, a) {
                    return o.call(this, setTimeout, Qr, u, function (c) {
                        return a(), null
                    }) || this
                }

                return s
            }(_t), Or = function (o) {
                Yr(s, o);

                function s(u, a) {
                    return o.call(this, setInterval, Ni, u, function (c) {
                        return a(), c
                    }) || this
                }

                return s
            }(_t), Ao = {
                now: function () {
                    return Date.now ? Date.now() : new Date().valueOf()
                }, defer: function (o) {
                    return new mt(0, o)
                }, method: function (o) {
                    var s = Array.prototype.slice.call(arguments, 1);
                    return function (u) {
                        return u[o].apply(u, s.concat(arguments))
                    }
                }
            }, Be = Ao;

            function We(o) {
                for (var s = [], u = 1; u < arguments.length; u++) s[u - 1] = arguments[u];
                for (var a = 0; a < s.length; a++) {
                    var c = s[a];
                    for (var g in c) c[g] && c[g].constructor && c[g].constructor === Object ? o[g] = We(o[g] || {}, c[g]) : o[g] = c[g]
                }
                return o
            }

            function $t() {
                for (var o = ["Pusher"], s = 0; s < arguments.length; s++) typeof arguments[s] == "string" ? o.push(arguments[s]) : o.push(Ve(arguments[s]));
                return o.join(" : ")
            }

            function ir(o, s) {
                var u = Array.prototype.indexOf;
                if (o === null) return -1;
                if (u && o.indexOf === u) return o.indexOf(s);
                for (var a = 0, c = o.length; a < c; a++) if (o[a] === s) return a;
                return -1
            }

            function Je(o, s) {
                for (var u in o) Object.prototype.hasOwnProperty.call(o, u) && s(o[u], u, o)
            }

            function Bn(o) {
                var s = [];
                return Je(o, function (u, a) {
                    s.push(a)
                }), s
            }

            function bt(o) {
                var s = [];
                return Je(o, function (u) {
                    s.push(u)
                }), s
            }

            function en(o, s, u) {
                for (var a = 0; a < o.length; a++) s.call(u || window, o[a], a, o)
            }

            function Pr(o, s) {
                for (var u = [], a = 0; a < o.length; a++) u.push(s(o[a], a, o, u));
                return u
            }

            function wt(o, s) {
                var u = {};
                return Je(o, function (a, c) {
                    u[c] = s(a)
                }), u
            }

            function Pt(o, s) {
                s = s || function (c) {
                    return !!c
                };
                for (var u = [], a = 0; a < o.length; a++) s(o[a], a, o, u) && u.push(o[a]);
                return u
            }

            function Di(o, s) {
                var u = {};
                return Je(o, function (a, c) {
                    (s && s(a, c, o, u) || Boolean(a)) && (u[c] = a)
                }), u
            }

            function or(o) {
                var s = [];
                return Je(o, function (u, a) {
                    s.push([a, u])
                }), s
            }

            function xt(o, s) {
                for (var u = 0; u < o.length; u++) if (s(o[u], u, o)) return !0;
                return !1
            }

            function st(o, s) {
                for (var u = 0; u < o.length; u++) if (!s(o[u], u, o)) return !1;
                return !0
            }

            function hn(o) {
                return wt(o, function (s) {
                    return typeof s == "object" && (s = Ve(s)), encodeURIComponent(Ie(s.toString()))
                })
            }

            function sr(o) {
                var s = Di(o, function (a) {
                    return a !== void 0
                }), u = Pr(or(hn(s)), Be.method("join", "=")).join("&");
                return u
            }

            function oe(o) {
                var s = [], u = [];
                return function a(c, g) {
                    var E, L, W;
                    switch (typeof c) {
                        case"object":
                            if (!c) return null;
                            for (E = 0; E < s.length; E += 1) if (s[E] === c) return {$ref: u[E]};
                            if (s.push(c), u.push(g), Object.prototype.toString.apply(c) === "[object Array]") for (W = [], E = 0; E < c.length; E += 1) W[E] = a(c[E], g + "[" + E + "]"); else {
                                W = {};
                                for (L in c) Object.prototype.hasOwnProperty.call(c, L) && (W[L] = a(c[L], g + "[" + JSON.stringify(L) + "]"))
                            }
                            return W;
                        case"number":
                        case"string":
                        case"boolean":
                            return c
                    }
                }(o, "$")
            }

            function Ve(o) {
                try {
                    return JSON.stringify(o)
                } catch {
                    return JSON.stringify(oe(o))
                }
            }

            var ur = function () {
                function o() {
                    this.globalLog = function (s) {
                        window.console && window.console.log && window.console.log(s)
                    }
                }

                return o.prototype.debug = function () {
                    for (var s = [], u = 0; u < arguments.length; u++) s[u] = arguments[u];
                    this.log(this.globalLog, s)
                }, o.prototype.warn = function () {
                    for (var s = [], u = 0; u < arguments.length; u++) s[u] = arguments[u];
                    this.log(this.globalLogWarn, s)
                }, o.prototype.error = function () {
                    for (var s = [], u = 0; u < arguments.length; u++) s[u] = arguments[u];
                    this.log(this.globalLogError, s)
                }, o.prototype.globalLogWarn = function (s) {
                    window.console && window.console.warn ? window.console.warn(s) : this.globalLog(s)
                }, o.prototype.globalLogError = function (s) {
                    window.console && window.console.error ? window.console.error(s) : this.globalLogWarn(s)
                }, o.prototype.log = function (s) {
                    var u = $t.apply(this, arguments);
                    if (zr.log) zr.log(u); else if (zr.logToConsole) {
                        var a = s.bind(this);
                        a(u)
                    }
                }, o
            }(), Pe = new ur, Zr = function (o, s, u, a, c) {
                (u.headers !== void 0 || u.headersProvider != null) && Pe.warn("To send headers with the " + a.toString() + " request, you must use AJAX, rather than JSONP.");
                var g = o.nextAuthCallbackID.toString();
                o.nextAuthCallbackID++;
                var E = o.getDocument(), L = E.createElement("script");
                o.auth_callbacks[g] = function (X) {
                    c(null, X)
                };
                var W = "Pusher.auth_callbacks['" + g + "']";
                L.src = u.endpoint + "?callback=" + encodeURIComponent(W) + "&" + s;
                var j = E.getElementsByTagName("head")[0] || E.documentElement;
                j.insertBefore(L, j.firstChild)
            }, Rr = Zr, Lr = function () {
                function o(s) {
                    this.src = s
                }

                return o.prototype.send = function (s) {
                    var u = this, a = "Error loading " + u.src;
                    u.script = document.createElement("script"), u.script.id = s.id, u.script.src = u.src, u.script.type = "text/javascript", u.script.charset = "UTF-8", u.script.addEventListener ? (u.script.onerror = function () {
                        s.callback(a)
                    }, u.script.onload = function () {
                        s.callback(null)
                    }) : u.script.onreadystatechange = function () {
                        (u.script.readyState === "loaded" || u.script.readyState === "complete") && s.callback(null)
                    }, u.script.async === void 0 && document.attachEvent && /opera/i.test(navigator.userAgent) ? (u.errorScript = document.createElement("script"), u.errorScript.id = s.id + "_error", u.errorScript.text = s.name + "('" + a + "');", u.script.async = u.errorScript.async = !1) : u.script.async = !0;
                    var c = document.getElementsByTagName("head")[0];
                    c.insertBefore(u.script, c.firstChild), u.errorScript && c.insertBefore(u.errorScript, u.script.nextSibling)
                }, o.prototype.cleanup = function () {
                    this.script && (this.script.onload = this.script.onerror = null, this.script.onreadystatechange = null), this.script && this.script.parentNode && this.script.parentNode.removeChild(this.script), this.errorScript && this.errorScript.parentNode && this.errorScript.parentNode.removeChild(this.errorScript), this.script = null, this.errorScript = null
                }, o
            }(), kn = Lr, Rt = function () {
                function o(s, u) {
                    this.url = s, this.data = u
                }

                return o.prototype.send = function (s) {
                    if (!this.request) {
                        var u = sr(this.data), a = this.url + "/" + s.number + "?" + u;
                        this.request = Z.createScriptRequest(a), this.request.send(s)
                    }
                }, o.prototype.cleanup = function () {
                    this.request && this.request.cleanup()
                }, o
            }(), tn = Rt, pn = function (o, s) {
                return function (u, a) {
                    var c = "http" + (s ? "s" : "") + "://", g = c + (o.host || o.options.host) + o.options.path,
                        E = Z.createJSONPRequest(g, u), L = Z.ScriptReceivers.create(function (W, j) {
                            M.remove(L), E.cleanup(), j && j.host && (o.host = j.host), a && a(W, j)
                        });
                    E.send(L)
                }
            }, ei = {name: "jsonp", getAgent: pn}, Fn = ei;

            function Ir(o, s, u) {
                var a = o + (s.useTLS ? "s" : ""), c = s.useTLS ? s.hostTLS : s.hostNonTLS;
                return a + "://" + c + u
            }

            function Nr(o, s) {
                var u = "/app/" + o,
                    a = "?protocol=" + B.PROTOCOL + "&client=js&version=" + B.VERSION + (s ? "&" + s : "");
                return u + a
            }

            var Eo = {
                getInitial: function (o, s) {
                    var u = (s.httpPath || "") + Nr(o, "flash=false");
                    return Ir("ws", s, u)
                }
            }, On = {
                getInitial: function (o, s) {
                    var u = (s.httpPath || "/pusher") + Nr(o);
                    return Ir("http", s, u)
                }
            }, Wn = {
                getInitial: function (o, s) {
                    return Ir("http", s, s.httpPath || "/pusher")
                }, getPath: function (o, s) {
                    return Nr(o)
                }
            }, Mi = function () {
                function o() {
                    this._callbacks = {}
                }

                return o.prototype.get = function (s) {
                    return this._callbacks[ut(s)]
                }, o.prototype.add = function (s, u, a) {
                    var c = ut(s);
                    this._callbacks[c] = this._callbacks[c] || [], this._callbacks[c].push({fn: u, context: a})
                }, o.prototype.remove = function (s, u, a) {
                    if (!s && !u && !a) {
                        this._callbacks = {};
                        return
                    }
                    var c = s ? [ut(s)] : Bn(this._callbacks);
                    u || a ? this.removeCallback(c, u, a) : this.removeAllCallbacks(c)
                }, o.prototype.removeCallback = function (s, u, a) {
                    en(s, function (c) {
                        this._callbacks[c] = Pt(this._callbacks[c] || [], function (g) {
                            return u && u !== g.fn || a && a !== g.context
                        }), this._callbacks[c].length === 0 && delete this._callbacks[c]
                    }, this)
                }, o.prototype.removeAllCallbacks = function (s) {
                    en(s, function (u) {
                        delete this._callbacks[u]
                    }, this)
                }, o
            }(), qi = Mi;

            function ut(o) {
                return "_" + o
            }

            var at = function () {
                    function o(s) {
                        this.callbacks = new qi, this.global_callbacks = [], this.failThrough = s
                    }

                    return o.prototype.bind = function (s, u, a) {
                        return this.callbacks.add(s, u, a), this
                    }, o.prototype.bind_global = function (s) {
                        return this.global_callbacks.push(s), this
                    }, o.prototype.unbind = function (s, u, a) {
                        return this.callbacks.remove(s, u, a), this
                    }, o.prototype.unbind_global = function (s) {
                        return s ? (this.global_callbacks = Pt(this.global_callbacks || [], function (u) {
                            return u !== s
                        }), this) : (this.global_callbacks = [], this)
                    }, o.prototype.unbind_all = function () {
                        return this.unbind(), this.unbind_global(), this
                    }, o.prototype.emit = function (s, u, a) {
                        for (var c = 0; c < this.global_callbacks.length; c++) this.global_callbacks[c](s, u);
                        var g = this.callbacks.get(s), E = [];
                        if (a ? E.push(u, a) : u && E.push(u), g && g.length > 0) for (var c = 0; c < g.length; c++) g[c].fn.apply(g[c].context || window, E); else this.failThrough && this.failThrough(s, u);
                        return this
                    }, o
                }(), St = at, ko = function () {
                    var o = function (s, u) {
                        return o = Object.setPrototypeOf || {__proto__: []} instanceof Array && function (a, c) {
                            a.__proto__ = c
                        } || function (a, c) {
                            for (var g in c) c.hasOwnProperty(g) && (a[g] = c[g])
                        }, o(s, u)
                    };
                    return function (s, u) {
                        o(s, u);

                        function a() {
                            this.constructor = s
                        }

                        s.prototype = u === null ? Object.create(u) : (a.prototype = u.prototype, new a)
                    }
                }(), Hi = function (o) {
                    ko(s, o);

                    function s(u, a, c, g, E) {
                        var L = o.call(this) || this;
                        return L.initialize = Z.transportConnectionInitializer, L.hooks = u, L.name = a, L.priority = c, L.key = g, L.options = E, L.state = "new", L.timeline = E.timeline, L.activityTimeout = E.activityTimeout, L.id = L.timeline.generateUniqueID(), L
                    }

                    return s.prototype.handlesActivityChecks = function () {
                        return Boolean(this.hooks.handlesActivityChecks)
                    }, s.prototype.supportsPing = function () {
                        return Boolean(this.hooks.supportsPing)
                    }, s.prototype.connect = function () {
                        var u = this;
                        if (this.socket || this.state !== "initialized") return !1;
                        var a = this.hooks.urls.getInitial(this.key, this.options);
                        try {
                            this.socket = this.hooks.getSocket(a, this.options)
                        } catch (c) {
                            return Be.defer(function () {
                                u.onError(c), u.changeState("closed")
                            }), !1
                        }
                        return this.bindListeners(), Pe.debug("Connecting", {
                            transport: this.name,
                            url: a
                        }), this.changeState("connecting"), !0
                    }, s.prototype.close = function () {
                        return this.socket ? (this.socket.close(), !0) : !1
                    }, s.prototype.send = function (u) {
                        var a = this;
                        return this.state === "open" ? (Be.defer(function () {
                            a.socket && a.socket.send(u)
                        }), !0) : !1
                    }, s.prototype.ping = function () {
                        this.state === "open" && this.supportsPing() && this.socket.ping()
                    }, s.prototype.onOpen = function () {
                        this.hooks.beforeOpen && this.hooks.beforeOpen(this.socket, this.hooks.urls.getPath(this.key, this.options)), this.changeState("open"), this.socket.onopen = void 0
                    }, s.prototype.onError = function (u) {
                        this.emit("error", {
                            type: "WebSocketError",
                            error: u
                        }), this.timeline.error(this.buildTimelineMessage({error: u.toString()}))
                    }, s.prototype.onClose = function (u) {
                        u ? this.changeState("closed", {
                            code: u.code,
                            reason: u.reason,
                            wasClean: u.wasClean
                        }) : this.changeState("closed"), this.unbindListeners(), this.socket = void 0
                    }, s.prototype.onMessage = function (u) {
                        this.emit("message", u)
                    }, s.prototype.onActivity = function () {
                        this.emit("activity")
                    }, s.prototype.bindListeners = function () {
                        var u = this;
                        this.socket.onopen = function () {
                            u.onOpen()
                        }, this.socket.onerror = function (a) {
                            u.onError(a)
                        }, this.socket.onclose = function (a) {
                            u.onClose(a)
                        }, this.socket.onmessage = function (a) {
                            u.onMessage(a)
                        }, this.supportsPing() && (this.socket.onactivity = function () {
                            u.onActivity()
                        })
                    }, s.prototype.unbindListeners = function () {
                        this.socket && (this.socket.onopen = void 0, this.socket.onerror = void 0, this.socket.onclose = void 0, this.socket.onmessage = void 0, this.supportsPing() && (this.socket.onactivity = void 0))
                    }, s.prototype.changeState = function (u, a) {
                        this.state = u, this.timeline.info(this.buildTimelineMessage({
                            state: u,
                            params: a
                        })), this.emit(u, a)
                    }, s.prototype.buildTimelineMessage = function (u) {
                        return We({cid: this.id}, u)
                    }, s
                }(St), ji = Hi, dn = function () {
                    function o(s) {
                        this.hooks = s
                    }

                    return o.prototype.isSupported = function (s) {
                        return this.hooks.isSupported(s)
                    }, o.prototype.createConnection = function (s, u, a, c) {
                        return new ji(this.hooks, s, u, a, c)
                    }, o
                }(), Lt = dn, ar = new Lt({
                    urls: Eo, handlesActivityChecks: !1, supportsPing: !1, isInitialized: function () {
                        return Boolean(Z.getWebSocketAPI())
                    }, isSupported: function () {
                        return Boolean(Z.getWebSocketAPI())
                    }, getSocket: function (o) {
                        return Z.createWebSocket(o)
                    }
                }), fr = {
                    urls: On, handlesActivityChecks: !1, supportsPing: !0, isInitialized: function () {
                        return !0
                    }
                }, Ui = We({
                    getSocket: function (o) {
                        return Z.HTTPFactory.createStreamingSocket(o)
                    }
                }, fr), Bi = We({
                    getSocket: function (o) {
                        return Z.HTTPFactory.createPollingSocket(o)
                    }
                }, fr), Fi = {
                    isSupported: function () {
                        return Z.isXHRSupported()
                    }
                }, Wi = new Lt(We({}, Ui, Fi)), Oo = new Lt(We({}, Bi, Fi)),
                Po = {ws: ar, xhr_streaming: Wi, xhr_polling: Oo}, cr = Po, $i = new Lt({
                    file: "sockjs",
                    urls: Wn,
                    handlesActivityChecks: !0,
                    supportsPing: !1,
                    isSupported: function () {
                        return !0
                    },
                    isInitialized: function () {
                        return window.SockJS !== void 0
                    },
                    getSocket: function (o, s) {
                        return new window.SockJS(o, null, {
                            js_path: re.getPath("sockjs", {useTLS: s.useTLS}),
                            ignore_null_origin: s.ignoreNullOrigin
                        })
                    },
                    beforeOpen: function (o, s) {
                        o.send(JSON.stringify({path: s}))
                    }
                }), Pn = {
                    isSupported: function (o) {
                        var s = Z.isXDRSupported(o.useTLS);
                        return s
                    }
                }, zi = new Lt(We({}, Ui, Pn)), ti = new Lt(We({}, Bi, Pn));
            cr.xdr_streaming = zi, cr.xdr_polling = ti, cr.sockjs = $i;
            var ni = cr, Dr = function () {
                var o = function (s, u) {
                    return o = Object.setPrototypeOf || {__proto__: []} instanceof Array && function (a, c) {
                        a.__proto__ = c
                    } || function (a, c) {
                        for (var g in c) c.hasOwnProperty(g) && (a[g] = c[g])
                    }, o(s, u)
                };
                return function (s, u) {
                    o(s, u);

                    function a() {
                        this.constructor = s
                    }

                    s.prototype = u === null ? Object.create(u) : (a.prototype = u.prototype, new a)
                }
            }(), Xi = function (o) {
                Dr(s, o);

                function s() {
                    var u = o.call(this) || this, a = u;
                    return window.addEventListener !== void 0 && (window.addEventListener("online", function () {
                        a.emit("online")
                    }, !1), window.addEventListener("offline", function () {
                        a.emit("offline")
                    }, !1)), u
                }

                return s.prototype.isOnline = function () {
                    return window.navigator.onLine === void 0 ? !0 : window.navigator.onLine
                }, s
            }(St), Mr = new Xi, lr = function () {
                function o(s, u, a) {
                    this.manager = s, this.transport = u, this.minPingDelay = a.minPingDelay, this.maxPingDelay = a.maxPingDelay, this.pingDelay = void 0
                }

                return o.prototype.createConnection = function (s, u, a, c) {
                    var g = this;
                    c = We({}, c, {activityTimeout: this.pingDelay});
                    var E = this.transport.createConnection(s, u, a, c), L = null, W = function () {
                        E.unbind("open", W), E.bind("closed", j), L = Be.now()
                    }, j = function (X) {
                        if (E.unbind("closed", j), X.code === 1002 || X.code === 1003) g.manager.reportDeath(); else if (!X.wasClean && L) {
                            var ue = Be.now() - L;
                            ue < 2 * g.maxPingDelay && (g.manager.reportDeath(), g.pingDelay = Math.max(ue / 2, g.minPingDelay))
                        }
                    };
                    return E.bind("open", W), E
                }, o.prototype.isSupported = function (s) {
                    return this.manager.isAlive() && this.transport.isSupported(s)
                }, o
            }(), hr = lr, ri = {
                decodeMessage: function (o) {
                    try {
                        var s = JSON.parse(o.data), u = s.data;
                        if (typeof u == "string") try {
                            u = JSON.parse(s.data)
                        } catch {
                        }
                        var a = {event: s.event, channel: s.channel, data: u};
                        return s.user_id && (a.user_id = s.user_id), a
                    } catch (c) {
                        throw {type: "MessageParseError", error: c, data: o.data}
                    }
                }, encodeMessage: function (o) {
                    return JSON.stringify(o)
                }, processHandshake: function (o) {
                    var s = ri.decodeMessage(o);
                    if (s.event === "pusher:connection_established") {
                        if (!s.data.activity_timeout) throw "No activity timeout specified in handshake";
                        return {
                            action: "connected",
                            id: s.data.socket_id,
                            activityTimeout: s.data.activity_timeout * 1e3
                        }
                    } else {
                        if (s.event === "pusher:error") return {
                            action: this.getCloseAction(s.data),
                            error: this.getCloseError(s.data)
                        };
                        throw "Invalid handshake"
                    }
                }, getCloseAction: function (o) {
                    return o.code < 4e3 ? o.code >= 1002 && o.code <= 1004 ? "backoff" : null : o.code === 4e3 ? "tls_only" : o.code < 4100 ? "refused" : o.code < 4200 ? "backoff" : o.code < 4300 ? "retry" : "refused"
                }, getCloseError: function (o) {
                    return o.code !== 1e3 && o.code !== 1001 ? {
                        type: "PusherError",
                        data: {code: o.code, message: o.reason || o.message}
                    } : null
                }
            }, gn = ri, Gi = function () {
                var o = function (s, u) {
                    return o = Object.setPrototypeOf || {__proto__: []} instanceof Array && function (a, c) {
                        a.__proto__ = c
                    } || function (a, c) {
                        for (var g in c) c.hasOwnProperty(g) && (a[g] = c[g])
                    }, o(s, u)
                };
                return function (s, u) {
                    o(s, u);

                    function a() {
                        this.constructor = s
                    }

                    s.prototype = u === null ? Object.create(u) : (a.prototype = u.prototype, new a)
                }
            }(), Ji = function (o) {
                Gi(s, o);

                function s(u, a) {
                    var c = o.call(this) || this;
                    return c.id = u, c.transport = a, c.activityTimeout = a.activityTimeout, c.bindListeners(), c
                }

                return s.prototype.handlesActivityChecks = function () {
                    return this.transport.handlesActivityChecks()
                }, s.prototype.send = function (u) {
                    return this.transport.send(u)
                }, s.prototype.send_event = function (u, a, c) {
                    var g = {event: u, data: a};
                    return c && (g.channel = c), Pe.debug("Event sent", g), this.send(gn.encodeMessage(g))
                }, s.prototype.ping = function () {
                    this.transport.supportsPing() ? this.transport.ping() : this.send_event("pusher:ping", {})
                }, s.prototype.close = function () {
                    this.transport.close()
                }, s.prototype.bindListeners = function () {
                    var u = this, a = {
                        message: function (g) {
                            var E;
                            try {
                                E = gn.decodeMessage(g)
                            } catch (L) {
                                u.emit("error", {type: "MessageParseError", error: L, data: g.data})
                            }
                            if (E !== void 0) {
                                switch (Pe.debug("Event recd", E), E.event) {
                                    case"pusher:error":
                                        u.emit("error", {type: "PusherError", data: E.data});
                                        break;
                                    case"pusher:ping":
                                        u.emit("ping");
                                        break;
                                    case"pusher:pong":
                                        u.emit("pong");
                                        break
                                }
                                u.emit("message", E)
                            }
                        }, activity: function () {
                            u.emit("activity")
                        }, error: function (g) {
                            u.emit("error", g)
                        }, closed: function (g) {
                            c(), g && g.code && u.handleCloseEvent(g), u.transport = null, u.emit("closed")
                        }
                    }, c = function () {
                        Je(a, function (g, E) {
                            u.transport.unbind(E, g)
                        })
                    };
                    Je(a, function (g, E) {
                        u.transport.bind(E, g)
                    })
                }, s.prototype.handleCloseEvent = function (u) {
                    var a = gn.getCloseAction(u), c = gn.getCloseError(u);
                    c && this.emit("error", c), a && this.emit(a, {action: a, error: c})
                }, s
            }(St), qr = Ji, Vi = function () {
                function o(s, u) {
                    this.transport = s, this.callback = u, this.bindListeners()
                }

                return o.prototype.close = function () {
                    this.unbindListeners(), this.transport.close()
                }, o.prototype.bindListeners = function () {
                    var s = this;
                    this.onMessage = function (u) {
                        s.unbindListeners();
                        var a;
                        try {
                            a = gn.processHandshake(u)
                        } catch (c) {
                            s.finish("error", {error: c}), s.transport.close();
                            return
                        }
                        a.action === "connected" ? s.finish("connected", {
                            connection: new qr(a.id, s.transport),
                            activityTimeout: a.activityTimeout
                        }) : (s.finish(a.action, {error: a.error}), s.transport.close())
                    }, this.onClosed = function (u) {
                        s.unbindListeners();
                        var a = gn.getCloseAction(u) || "backoff", c = gn.getCloseError(u);
                        s.finish(a, {error: c})
                    }, this.transport.bind("message", this.onMessage), this.transport.bind("closed", this.onClosed)
                }, o.prototype.unbindListeners = function () {
                    this.transport.unbind("message", this.onMessage), this.transport.unbind("closed", this.onClosed)
                }, o.prototype.finish = function (s, u) {
                    this.callback(We({transport: this.transport, action: s}, u))
                }, o
            }(), Ro = Vi, Ki = function () {
                function o(s, u) {
                    this.timeline = s, this.options = u || {}
                }

                return o.prototype.send = function (s, u) {
                    this.timeline.isEmpty() || this.timeline.send(Z.TimelineTransport.getAgent(this, s), u)
                }, o
            }(), Yi = Ki, ii = function () {
                var o = function (s, u) {
                    return o = Object.setPrototypeOf || {__proto__: []} instanceof Array && function (a, c) {
                        a.__proto__ = c
                    } || function (a, c) {
                        for (var g in c) c.hasOwnProperty(g) && (a[g] = c[g])
                    }, o(s, u)
                };
                return function (s, u) {
                    o(s, u);

                    function a() {
                        this.constructor = s
                    }

                    s.prototype = u === null ? Object.create(u) : (a.prototype = u.prototype, new a)
                }
            }(), oi = function (o) {
                ii(s, o);

                function s(u, a) {
                    var c = o.call(this, function (g, E) {
                        Pe.debug("No callbacks on " + u + " for " + g)
                    }) || this;
                    return c.name = u, c.pusher = a, c.subscribed = !1, c.subscriptionPending = !1, c.subscriptionCancelled = !1, c
                }

                return s.prototype.authorize = function (u, a) {
                    return a(null, {auth: ""})
                }, s.prototype.trigger = function (u, a) {
                    if (u.indexOf("client-") !== 0) throw new de("Event '" + u + "' does not start with 'client-'");
                    if (!this.subscribed) {
                        var c = J.buildLogSuffix("triggeringClientEvents");
                        Pe.warn("Client event triggered before channel 'subscription_succeeded' event . " + c)
                    }
                    return this.pusher.send_event(u, a, this.name)
                }, s.prototype.disconnect = function () {
                    this.subscribed = !1, this.subscriptionPending = !1
                }, s.prototype.handleEvent = function (u) {
                    var a = u.event, c = u.data;
                    if (a === "pusher_internal:subscription_succeeded") this.handleSubscriptionSucceededEvent(u); else if (a === "pusher_internal:subscription_count") this.handleSubscriptionCountEvent(u); else if (a.indexOf("pusher_internal:") !== 0) {
                        var g = {};
                        this.emit(a, c, g)
                    }
                }, s.prototype.handleSubscriptionSucceededEvent = function (u) {
                    this.subscriptionPending = !1, this.subscribed = !0, this.subscriptionCancelled ? this.pusher.unsubscribe(this.name) : this.emit("pusher:subscription_succeeded", u.data)
                }, s.prototype.handleSubscriptionCountEvent = function (u) {
                    u.data.subscription_count && (this.subscriptionCount = u.data.subscription_count), this.emit("pusher:subscription_count", u.data)
                }, s.prototype.subscribe = function () {
                    var u = this;
                    this.subscribed || (this.subscriptionPending = !0, this.subscriptionCancelled = !1, this.authorize(this.pusher.connection.socket_id, function (a, c) {
                        a ? (u.subscriptionPending = !1, Pe.error(a.toString()), u.emit("pusher:subscription_error", Object.assign({}, {
                            type: "AuthError",
                            error: a.message
                        }, a instanceof Bt ? {status: a.status} : {}))) : u.pusher.send_event("pusher:subscribe", {
                            auth: c.auth,
                            channel_data: c.channel_data,
                            channel: u.name
                        })
                    }))
                }, s.prototype.unsubscribe = function () {
                    this.subscribed = !1, this.pusher.send_event("pusher:unsubscribe", {channel: this.name})
                }, s.prototype.cancelSubscription = function () {
                    this.subscriptionCancelled = !0
                }, s.prototype.reinstateSubscription = function () {
                    this.subscriptionCancelled = !1
                }, s
            }(St), Ke = oi, Rn = function () {
                var o = function (s, u) {
                    return o = Object.setPrototypeOf || {__proto__: []} instanceof Array && function (a, c) {
                        a.__proto__ = c
                    } || function (a, c) {
                        for (var g in c) c.hasOwnProperty(g) && (a[g] = c[g])
                    }, o(s, u)
                };
                return function (s, u) {
                    o(s, u);

                    function a() {
                        this.constructor = s
                    }

                    s.prototype = u === null ? Object.create(u) : (a.prototype = u.prototype, new a)
                }
            }(), $n = function (o) {
                Rn(s, o);

                function s() {
                    return o !== null && o.apply(this, arguments) || this
                }

                return s.prototype.authorize = function (u, a) {
                    return this.pusher.config.channelAuthorizer({channelName: this.name, socketId: u}, a)
                }, s
            }(Ke), si = $n, Qi = function () {
                function o() {
                    this.reset()
                }

                return o.prototype.get = function (s) {
                    return Object.prototype.hasOwnProperty.call(this.members, s) ? {id: s, info: this.members[s]} : null
                }, o.prototype.each = function (s) {
                    var u = this;
                    Je(this.members, function (a, c) {
                        s(u.get(c))
                    })
                }, o.prototype.setMyID = function (s) {
                    this.myID = s
                }, o.prototype.onSubscription = function (s) {
                    this.members = s.presence.hash, this.count = s.presence.count, this.me = this.get(this.myID)
                }, o.prototype.addMember = function (s) {
                    return this.get(s.user_id) === null && this.count++, this.members[s.user_id] = s.user_info, this.get(s.user_id)
                }, o.prototype.removeMember = function (s) {
                    var u = this.get(s.user_id);
                    return u && (delete this.members[s.user_id], this.count--), u
                }, o.prototype.reset = function () {
                    this.members = {}, this.count = 0, this.myID = null, this.me = null
                }, o
            }(), zn = Qi, ui = function () {
                var o = function (s, u) {
                    return o = Object.setPrototypeOf || {__proto__: []} instanceof Array && function (a, c) {
                        a.__proto__ = c
                    } || function (a, c) {
                        for (var g in c) c.hasOwnProperty(g) && (a[g] = c[g])
                    }, o(s, u)
                };
                return function (s, u) {
                    o(s, u);

                    function a() {
                        this.constructor = s
                    }

                    s.prototype = u === null ? Object.create(u) : (a.prototype = u.prototype, new a)
                }
            }(), Hr = function (o, s, u, a) {
                function c(g) {
                    return g instanceof u ? g : new u(function (E) {
                        E(g)
                    })
                }

                return new (u || (u = Promise))(function (g, E) {
                    function L(X) {
                        try {
                            j(a.next(X))
                        } catch (ue) {
                            E(ue)
                        }
                    }

                    function W(X) {
                        try {
                            j(a.throw(X))
                        } catch (ue) {
                            E(ue)
                        }
                    }

                    function j(X) {
                        X.done ? g(X.value) : c(X.value).then(L, W)
                    }

                    j((a = a.apply(o, s || [])).next())
                })
            }, ai = function (o, s) {
                var u = {
                    label: 0, sent: function () {
                        if (g[0] & 1) throw g[1];
                        return g[1]
                    }, trys: [], ops: []
                }, a, c, g, E;
                return E = {
                    next: L(0),
                    throw: L(1),
                    return: L(2)
                }, typeof Symbol == "function" && (E[Symbol.iterator] = function () {
                    return this
                }), E;

                function L(j) {
                    return function (X) {
                        return W([j, X])
                    }
                }

                function W(j) {
                    if (a) throw new TypeError("Generator is already executing.");
                    for (; u;) try {
                        if (a = 1, c && (g = j[0] & 2 ? c.return : j[0] ? c.throw || ((g = c.return) && g.call(c), 0) : c.next) && !(g = g.call(c, j[1])).done) return g;
                        switch (c = 0, g && (j = [j[0] & 2, g.value]), j[0]) {
                            case 0:
                            case 1:
                                g = j;
                                break;
                            case 4:
                                return u.label++, {value: j[1], done: !1};
                            case 5:
                                u.label++, c = j[1], j = [0];
                                continue;
                            case 7:
                                j = u.ops.pop(), u.trys.pop();
                                continue;
                            default:
                                if (g = u.trys, !(g = g.length > 0 && g[g.length - 1]) && (j[0] === 6 || j[0] === 2)) {
                                    u = 0;
                                    continue
                                }
                                if (j[0] === 3 && (!g || j[1] > g[0] && j[1] < g[3])) {
                                    u.label = j[1];
                                    break
                                }
                                if (j[0] === 6 && u.label < g[1]) {
                                    u.label = g[1], g = j;
                                    break
                                }
                                if (g && u.label < g[2]) {
                                    u.label = g[2], u.ops.push(j);
                                    break
                                }
                                g[2] && u.ops.pop(), u.trys.pop();
                                continue
                        }
                        j = s.call(o, u)
                    } catch (X) {
                        j = [6, X], c = 0
                    } finally {
                        a = g = 0
                    }
                    if (j[0] & 5) throw j[1];
                    return {value: j[0] ? j[1] : void 0, done: !0}
                }
            }, Zi = function (o) {
                ui(s, o);

                function s(u, a) {
                    var c = o.call(this, u, a) || this;
                    return c.members = new zn, c
                }

                return s.prototype.authorize = function (u, a) {
                    var c = this;
                    o.prototype.authorize.call(this, u, function (g, E) {
                        return Hr(c, void 0, void 0, function () {
                            var L, W;
                            return ai(this, function (j) {
                                switch (j.label) {
                                    case 0:
                                        return g ? [3, 3] : (E = E, E.channel_data == null ? [3, 1] : (L = JSON.parse(E.channel_data), this.members.setMyID(L.user_id), [3, 3]));
                                    case 1:
                                        return [4, this.pusher.user.signinDonePromise];
                                    case 2:
                                        if (j.sent(), this.pusher.user.user_data != null) this.members.setMyID(this.pusher.user.user_data.id); else return W = J.buildLogSuffix("authorizationEndpoint"), Pe.error("Invalid auth response for channel '" + this.name + "', " + ("expected 'channel_data' field. " + W + ", ") + "or the user should be signed in."), a("Invalid auth response"), [2];
                                        j.label = 3;
                                    case 3:
                                        return a(g, E), [2]
                                }
                            })
                        })
                    })
                }, s.prototype.handleEvent = function (u) {
                    var a = u.event;
                    if (a.indexOf("pusher_internal:") === 0) this.handleInternalEvent(u); else {
                        var c = u.data, g = {};
                        u.user_id && (g.user_id = u.user_id), this.emit(a, c, g)
                    }
                }, s.prototype.handleInternalEvent = function (u) {
                    var a = u.event, c = u.data;
                    switch (a) {
                        case"pusher_internal:subscription_succeeded":
                            this.handleSubscriptionSucceededEvent(u);
                            break;
                        case"pusher_internal:subscription_count":
                            this.handleSubscriptionCountEvent(u);
                            break;
                        case"pusher_internal:member_added":
                            var g = this.members.addMember(c);
                            this.emit("pusher:member_added", g);
                            break;
                        case"pusher_internal:member_removed":
                            var E = this.members.removeMember(c);
                            E && this.emit("pusher:member_removed", E);
                            break
                    }
                }, s.prototype.handleSubscriptionSucceededEvent = function (u) {
                    this.subscriptionPending = !1, this.subscribed = !0, this.subscriptionCancelled ? this.pusher.unsubscribe(this.name) : (this.members.onSubscription(u.data), this.emit("pusher:subscription_succeeded", this.members))
                }, s.prototype.disconnect = function () {
                    this.members.reset(), o.prototype.disconnect.call(this)
                }, s
            }(si), fi = Zi, It = S(1), pr = S(0), Ln = function () {
                var o = function (s, u) {
                    return o = Object.setPrototypeOf || {__proto__: []} instanceof Array && function (a, c) {
                        a.__proto__ = c
                    } || function (a, c) {
                        for (var g in c) c.hasOwnProperty(g) && (a[g] = c[g])
                    }, o(s, u)
                };
                return function (s, u) {
                    o(s, u);

                    function a() {
                        this.constructor = s
                    }

                    s.prototype = u === null ? Object.create(u) : (a.prototype = u.prototype, new a)
                }
            }(), ci = function (o) {
                Ln(s, o);

                function s(u, a, c) {
                    var g = o.call(this, u, a) || this;
                    return g.key = null, g.nacl = c, g
                }

                return s.prototype.authorize = function (u, a) {
                    var c = this;
                    o.prototype.authorize.call(this, u, function (g, E) {
                        if (g) {
                            a(g, E);
                            return
                        }
                        var L = E.shared_secret;
                        if (!L) {
                            a(new Error("No shared_secret key in auth payload for encrypted channel: " + c.name), null);
                            return
                        }
                        c.key = Object(pr.decode)(L), delete E.shared_secret, a(null, E)
                    })
                }, s.prototype.trigger = function (u, a) {
                    throw new p("Client events are not currently supported for encrypted channels")
                }, s.prototype.handleEvent = function (u) {
                    var a = u.event, c = u.data;
                    if (a.indexOf("pusher_internal:") === 0 || a.indexOf("pusher:") === 0) {
                        o.prototype.handleEvent.call(this, u);
                        return
                    }
                    this.handleEncryptedEvent(a, c)
                }, s.prototype.handleEncryptedEvent = function (u, a) {
                    var c = this;
                    if (!this.key) {
                        Pe.debug("Received encrypted event before key has been retrieved from the authEndpoint");
                        return
                    }
                    if (!a.ciphertext || !a.nonce) {
                        Pe.error("Unexpected format for encrypted event, expected object with `ciphertext` and `nonce` fields, got: " + a);
                        return
                    }
                    var g = Object(pr.decode)(a.ciphertext);
                    if (g.length < this.nacl.secretbox.overheadLength) {
                        Pe.error("Expected encrypted event ciphertext length to be " + this.nacl.secretbox.overheadLength + ", got: " + g.length);
                        return
                    }
                    var E = Object(pr.decode)(a.nonce);
                    if (E.length < this.nacl.secretbox.nonceLength) {
                        Pe.error("Expected encrypted event nonce length to be " + this.nacl.secretbox.nonceLength + ", got: " + E.length);
                        return
                    }
                    var L = this.nacl.secretbox.open(g, E, this.key);
                    if (L === null) {
                        Pe.debug("Failed to decrypt an event, probably because it was encrypted with a different key. Fetching a new key from the authEndpoint..."), this.authorize(this.pusher.connection.socket_id, function (W, j) {
                            if (W) {
                                Pe.error("Failed to make a request to the authEndpoint: " + j + ". Unable to fetch new key, so dropping encrypted event");
                                return
                            }
                            if (L = c.nacl.secretbox.open(g, E, c.key), L === null) {
                                Pe.error("Failed to decrypt event with new key. Dropping encrypted event");
                                return
                            }
                            c.emit(u, c.getDataToEmit(L))
                        });
                        return
                    }
                    this.emit(u, this.getDataToEmit(L))
                }, s.prototype.getDataToEmit = function (u) {
                    var a = Object(It.decode)(u);
                    try {
                        return JSON.parse(a)
                    } catch {
                        return a
                    }
                }, s
            }(si), Xn = ci, vn = function () {
                var o = function (s, u) {
                    return o = Object.setPrototypeOf || {__proto__: []} instanceof Array && function (a, c) {
                        a.__proto__ = c
                    } || function (a, c) {
                        for (var g in c) c.hasOwnProperty(g) && (a[g] = c[g])
                    }, o(s, u)
                };
                return function (s, u) {
                    o(s, u);

                    function a() {
                        this.constructor = s
                    }

                    s.prototype = u === null ? Object.create(u) : (a.prototype = u.prototype, new a)
                }
            }(), yn = function (o) {
                vn(s, o);

                function s(u, a) {
                    var c = o.call(this) || this;
                    c.state = "initialized", c.connection = null, c.key = u, c.options = a, c.timeline = c.options.timeline, c.usingTLS = c.options.useTLS, c.errorCallbacks = c.buildErrorCallbacks(), c.connectionCallbacks = c.buildConnectionCallbacks(c.errorCallbacks), c.handshakeCallbacks = c.buildHandshakeCallbacks(c.errorCallbacks);
                    var g = Z.getNetwork();
                    return g.bind("online", function () {
                        c.timeline.info({netinfo: "online"}), (c.state === "connecting" || c.state === "unavailable") && c.retryIn(0)
                    }), g.bind("offline", function () {
                        c.timeline.info({netinfo: "offline"}), c.connection && c.sendActivityCheck()
                    }), c.updateStrategy(), c
                }

                return s.prototype.connect = function () {
                    if (!(this.connection || this.runner)) {
                        if (!this.strategy.isSupported()) {
                            this.updateState("failed");
                            return
                        }
                        this.updateState("connecting"), this.startConnecting(), this.setUnavailableTimer()
                    }
                }, s.prototype.send = function (u) {
                    return this.connection ? this.connection.send(u) : !1
                }, s.prototype.send_event = function (u, a, c) {
                    return this.connection ? this.connection.send_event(u, a, c) : !1
                }, s.prototype.disconnect = function () {
                    this.disconnectInternally(), this.updateState("disconnected")
                }, s.prototype.isUsingTLS = function () {
                    return this.usingTLS
                }, s.prototype.startConnecting = function () {
                    var u = this, a = function (c, g) {
                        c ? u.runner = u.strategy.connect(0, a) : g.action === "error" ? (u.emit("error", {
                            type: "HandshakeError",
                            error: g.error
                        }), u.timeline.error({handshakeError: g.error})) : (u.abortConnecting(), u.handshakeCallbacks[g.action](g))
                    };
                    this.runner = this.strategy.connect(0, a)
                }, s.prototype.abortConnecting = function () {
                    this.runner && (this.runner.abort(), this.runner = null)
                }, s.prototype.disconnectInternally = function () {
                    if (this.abortConnecting(), this.clearRetryTimer(), this.clearUnavailableTimer(), this.connection) {
                        var u = this.abandonConnection();
                        u.close()
                    }
                }, s.prototype.updateStrategy = function () {
                    this.strategy = this.options.getStrategy({
                        key: this.key,
                        timeline: this.timeline,
                        useTLS: this.usingTLS
                    })
                }, s.prototype.retryIn = function (u) {
                    var a = this;
                    this.timeline.info({
                        action: "retry",
                        delay: u
                    }), u > 0 && this.emit("connecting_in", Math.round(u / 1e3)), this.retryTimer = new mt(u || 0, function () {
                        a.disconnectInternally(), a.connect()
                    })
                }, s.prototype.clearRetryTimer = function () {
                    this.retryTimer && (this.retryTimer.ensureAborted(), this.retryTimer = null)
                }, s.prototype.setUnavailableTimer = function () {
                    var u = this;
                    this.unavailableTimer = new mt(this.options.unavailableTimeout, function () {
                        u.updateState("unavailable")
                    })
                }, s.prototype.clearUnavailableTimer = function () {
                    this.unavailableTimer && this.unavailableTimer.ensureAborted()
                }, s.prototype.sendActivityCheck = function () {
                    var u = this;
                    this.stopActivityCheck(), this.connection.ping(), this.activityTimer = new mt(this.options.pongTimeout, function () {
                        u.timeline.error({pong_timed_out: u.options.pongTimeout}), u.retryIn(0)
                    })
                }, s.prototype.resetActivityCheck = function () {
                    var u = this;
                    this.stopActivityCheck(), this.connection && !this.connection.handlesActivityChecks() && (this.activityTimer = new mt(this.activityTimeout, function () {
                        u.sendActivityCheck()
                    }))
                }, s.prototype.stopActivityCheck = function () {
                    this.activityTimer && this.activityTimer.ensureAborted()
                }, s.prototype.buildConnectionCallbacks = function (u) {
                    var a = this;
                    return We({}, u, {
                        message: function (c) {
                            a.resetActivityCheck(), a.emit("message", c)
                        }, ping: function () {
                            a.send_event("pusher:pong", {})
                        }, activity: function () {
                            a.resetActivityCheck()
                        }, error: function (c) {
                            a.emit("error", c)
                        }, closed: function () {
                            a.abandonConnection(), a.shouldRetry() && a.retryIn(1e3)
                        }
                    })
                }, s.prototype.buildHandshakeCallbacks = function (u) {
                    var a = this;
                    return We({}, u, {
                        connected: function (c) {
                            a.activityTimeout = Math.min(a.options.activityTimeout, c.activityTimeout, c.connection.activityTimeout || 1 / 0), a.clearUnavailableTimer(), a.setConnection(c.connection), a.socket_id = a.connection.id, a.updateState("connected", {socket_id: a.socket_id})
                        }
                    })
                }, s.prototype.buildErrorCallbacks = function () {
                    var u = this, a = function (c) {
                        return function (g) {
                            g.error && u.emit("error", {type: "WebSocketError", error: g.error}), c(g)
                        }
                    };
                    return {
                        tls_only: a(function () {
                            u.usingTLS = !0, u.updateStrategy(), u.retryIn(0)
                        }), refused: a(function () {
                            u.disconnect()
                        }), backoff: a(function () {
                            u.retryIn(1e3)
                        }), retry: a(function () {
                            u.retryIn(0)
                        })
                    }
                }, s.prototype.setConnection = function (u) {
                    this.connection = u;
                    for (var a in this.connectionCallbacks) this.connection.bind(a, this.connectionCallbacks[a]);
                    this.resetActivityCheck()
                }, s.prototype.abandonConnection = function () {
                    if (!!this.connection) {
                        this.stopActivityCheck();
                        for (var u in this.connectionCallbacks) this.connection.unbind(u, this.connectionCallbacks[u]);
                        var a = this.connection;
                        return this.connection = null, a
                    }
                }, s.prototype.updateState = function (u, a) {
                    var c = this.state;
                    if (this.state = u, c !== u) {
                        var g = u;
                        g === "connected" && (g += " with new socket ID " + a.socket_id), Pe.debug("State changed", c + " -> " + g), this.timeline.info({
                            state: u,
                            params: a
                        }), this.emit("state_change", {previous: c, current: u}), this.emit(u, a)
                    }
                }, s.prototype.shouldRetry = function () {
                    return this.state === "connecting" || this.state === "connected"
                }, s
            }(St), li = yn, eo = function () {
                function o() {
                    this.channels = {}
                }

                return o.prototype.add = function (s, u) {
                    return this.channels[s] || (this.channels[s] = hi(s, u)), this.channels[s]
                }, o.prototype.all = function () {
                    return bt(this.channels)
                }, o.prototype.find = function (s) {
                    return this.channels[s]
                }, o.prototype.remove = function (s) {
                    var u = this.channels[s];
                    return delete this.channels[s], u
                }, o.prototype.disconnect = function () {
                    Je(this.channels, function (s) {
                        s.disconnect()
                    })
                }, o
            }(), Gn = eo;

            function hi(o, s) {
                if (o.indexOf("private-encrypted-") === 0) {
                    if (s.config.nacl) return zt.createEncryptedChannel(o, s, s.config.nacl);
                    var u = "Tried to subscribe to a private-encrypted- channel but no nacl implementation available",
                        a = J.buildLogSuffix("encryptedChannelSupport");
                    throw new p(u + ". " + a)
                } else {
                    if (o.indexOf("private-") === 0) return zt.createPrivateChannel(o, s);
                    if (o.indexOf("presence-") === 0) return zt.createPresenceChannel(o, s);
                    if (o.indexOf("#") === 0) throw new Te('Cannot create a channel with name "' + o + '".');
                    return zt.createChannel(o, s)
                }
            }

            var jr = {
                createChannels: function () {
                    return new Gn
                }, createConnectionManager: function (o, s) {
                    return new li(o, s)
                }, createChannel: function (o, s) {
                    return new Ke(o, s)
                }, createPrivateChannel: function (o, s) {
                    return new si(o, s)
                }, createPresenceChannel: function (o, s) {
                    return new fi(o, s)
                }, createEncryptedChannel: function (o, s, u) {
                    return new Xn(o, s, u)
                }, createTimelineSender: function (o, s) {
                    return new Yi(o, s)
                }, createHandshake: function (o, s) {
                    return new Ro(o, s)
                }, createAssistantToTheTransportManager: function (o, s, u) {
                    return new hr(o, s, u)
                }
            }, zt = jr, to = function () {
                function o(s) {
                    this.options = s || {}, this.livesLeft = this.options.lives || 1 / 0
                }

                return o.prototype.getAssistant = function (s) {
                    return zt.createAssistantToTheTransportManager(this, s, {
                        minPingDelay: this.options.minPingDelay,
                        maxPingDelay: this.options.maxPingDelay
                    })
                }, o.prototype.isAlive = function () {
                    return this.livesLeft > 0
                }, o.prototype.reportDeath = function () {
                    this.livesLeft -= 1
                }, o
            }(), no = to, pi = function () {
                function o(s, u) {
                    this.strategies = s, this.loop = Boolean(u.loop), this.failFast = Boolean(u.failFast), this.timeout = u.timeout, this.timeoutLimit = u.timeoutLimit
                }

                return o.prototype.isSupported = function () {
                    return xt(this.strategies, Be.method("isSupported"))
                }, o.prototype.connect = function (s, u) {
                    var a = this, c = this.strategies, g = 0, E = this.timeout, L = null, W = function (j, X) {
                        X ? u(null, X) : (g = g + 1, a.loop && (g = g % c.length), g < c.length ? (E && (E = E * 2, a.timeoutLimit && (E = Math.min(E, a.timeoutLimit))), L = a.tryStrategy(c[g], s, {
                            timeout: E,
                            failFast: a.failFast
                        }, W)) : u(!0))
                    };
                    return L = this.tryStrategy(c[g], s, {
                        timeout: E,
                        failFast: this.failFast
                    }, W), {
                        abort: function () {
                            L.abort()
                        }, forceMinPriority: function (j) {
                            s = j, L && L.forceMinPriority(j)
                        }
                    }
                }, o.prototype.tryStrategy = function (s, u, a, c) {
                    var g = null, E = null;
                    return a.timeout > 0 && (g = new mt(a.timeout, function () {
                        E.abort(), c(!0)
                    })), E = s.connect(u, function (L, W) {
                        L && g && g.isRunning() && !a.failFast || (g && g.ensureAborted(), c(L, W))
                    }), {
                        abort: function () {
                            g && g.ensureAborted(), E.abort()
                        }, forceMinPriority: function (L) {
                            E.forceMinPriority(L)
                        }
                    }
                }, o
            }(), In = pi, Lo = function () {
                function o(s) {
                    this.strategies = s
                }

                return o.prototype.isSupported = function () {
                    return xt(this.strategies, Be.method("isSupported"))
                }, o.prototype.connect = function (s, u) {
                    return Io(this.strategies, s, function (a, c) {
                        return function (g, E) {
                            if (c[a].error = g, g) {
                                di(c) && u(!0);
                                return
                            }
                            en(c, function (L) {
                                L.forceMinPriority(E.transport.priority)
                            }), u(null, E)
                        }
                    })
                }, o
            }(), dr = Lo;

            function Io(o, s, u) {
                var a = Pr(o, function (c, g, E, L) {
                    return c.connect(s, u(g, L))
                });
                return {
                    abort: function () {
                        en(a, No)
                    }, forceMinPriority: function (c) {
                        en(a, function (g) {
                            g.forceMinPriority(c)
                        })
                    }
                }
            }

            function di(o) {
                return st(o, function (s) {
                    return Boolean(s.error)
                })
            }

            function No(o) {
                !o.error && !o.aborted && (o.abort(), o.aborted = !0)
            }

            var Do = function () {
                function o(s, u, a) {
                    this.strategy = s, this.transports = u, this.ttl = a.ttl || 1800 * 1e3, this.usingTLS = a.useTLS, this.timeline = a.timeline
                }

                return o.prototype.isSupported = function () {
                    return this.strategy.isSupported()
                }, o.prototype.connect = function (s, u) {
                    var a = this.usingTLS, c = qo(a), g = [this.strategy];
                    if (c && c.timestamp + this.ttl >= Be.now()) {
                        var E = this.transports[c.transport];
                        E && (this.timeline.info({
                            cached: !0,
                            transport: c.transport,
                            latency: c.latency
                        }), g.push(new In([E], {timeout: c.latency * 2 + 1e3, failFast: !0})))
                    }
                    var L = Be.now(), W = g.pop().connect(s, function j(X, ue) {
                        X ? (Re(a), g.length > 0 ? (L = Be.now(), W = g.pop().connect(s, j)) : u(X)) : (De(a, ue.transport.name, Be.now() - L), u(null, ue))
                    });
                    return {
                        abort: function () {
                            W.abort()
                        }, forceMinPriority: function (j) {
                            s = j, W && W.forceMinPriority(j)
                        }
                    }
                }, o
            }(), Mo = Do;

            function gi(o) {
                return "pusherTransport" + (o ? "TLS" : "NonTLS")
            }

            function qo(o) {
                var s = Z.getLocalStorage();
                if (s) try {
                    var u = s[gi(o)];
                    if (u) return JSON.parse(u)
                } catch {
                    Re(o)
                }
                return null
            }

            function De(o, s, u) {
                var a = Z.getLocalStorage();
                if (a) try {
                    a[gi(o)] = Ve({timestamp: Be.now(), transport: s, latency: u})
                } catch {
                }
            }

            function Re(o) {
                var s = Z.getLocalStorage();
                if (s) try {
                    delete s[gi(o)]
                } catch {
                }
            }

            var ro = function () {
                function o(s, u) {
                    var a = u.delay;
                    this.strategy = s, this.options = {delay: a}
                }

                return o.prototype.isSupported = function () {
                    return this.strategy.isSupported()
                }, o.prototype.connect = function (s, u) {
                    var a = this.strategy, c, g = new mt(this.options.delay, function () {
                        c = a.connect(s, u)
                    });
                    return {
                        abort: function () {
                            g.ensureAborted(), c && c.abort()
                        }, forceMinPriority: function (E) {
                            s = E, c && c.forceMinPriority(E)
                        }
                    }
                }, o
            }(), Jn = ro, oo = function () {
                function o(s, u, a) {
                    this.test = s, this.trueBranch = u, this.falseBranch = a
                }

                return o.prototype.isSupported = function () {
                    var s = this.test() ? this.trueBranch : this.falseBranch;
                    return s.isSupported()
                }, o.prototype.connect = function (s, u) {
                    var a = this.test() ? this.trueBranch : this.falseBranch;
                    return a.connect(s, u)
                }, o
            }(), Vn = oo, vi = function () {
                function o(s) {
                    this.strategy = s
                }

                return o.prototype.isSupported = function () {
                    return this.strategy.isSupported()
                }, o.prototype.connect = function (s, u) {
                    var a = this.strategy.connect(s, function (c, g) {
                        g && a.abort(), u(c, g)
                    });
                    return a
                }, o
            }(), Ho = vi;

            function Kn(o) {
                return function () {
                    return o.isSupported()
                }
            }

            var jo = function (o, s, u) {
                var a = {};

                function c(Si, Zn, ao, fs, fo) {
                    var Xo = u(o, Si, Zn, ao, fs, fo);
                    return a[Si] = Xo, Xo
                }

                var g = Object.assign({}, s, {
                        hostNonTLS: o.wsHost + ":" + o.wsPort,
                        hostTLS: o.wsHost + ":" + o.wssPort,
                        httpPath: o.wsPath
                    }), E = Object.assign({}, g, {useTLS: !0}), L = Object.assign({}, s, {
                        hostNonTLS: o.httpHost + ":" + o.httpPort,
                        hostTLS: o.httpHost + ":" + o.httpsPort,
                        httpPath: o.httpPath
                    }), W = {loop: !0, timeout: 15e3, timeoutLimit: 6e4},
                    j = new no({lives: 2, minPingDelay: 1e4, maxPingDelay: o.activityTimeout}),
                    X = new no({lives: 2, minPingDelay: 1e4, maxPingDelay: o.activityTimeout}),
                    ue = c("ws", "ws", 3, g, j), se = c("wss", "ws", 3, E, j), me = c("sockjs", "sockjs", 1, L),
                    ze = c("xhr_streaming", "xhr_streaming", 1, L, X),
                    rt = c("xdr_streaming", "xdr_streaming", 1, L, X), Xe = c("xhr_polling", "xhr_polling", 1, L),
                    pt = c("xdr_polling", "xdr_polling", 1, L), Vt = new In([ue], W), pe = new In([se], W),
                    Ks = new In([me], W), Wo = new In([new Vn(Kn(ze), ze, rt)], W),
                    xi = new In([new Vn(Kn(Xe), Xe, pt)], W),
                    as = new In([new Vn(Kn(Wo), new dr([Wo, new Jn(xi, {delay: 4e3})]), xi)], W),
                    $o = new Vn(Kn(as), as, Ks), zo;
                return s.useTLS ? zo = new dr([Vt, new Jn($o, {delay: 2e3})]) : zo = new dr([Vt, new Jn(pe, {delay: 2e3}), new Jn($o, {delay: 5e3})]), new Mo(new Ho(new Vn(Kn(ue), zo, $o)), a, {
                    ttl: 18e5,
                    timeline: s.timeline,
                    useTLS: s.useTLS
                })
            }, je = jo, Ur = function () {
                var o = this;
                o.timeline.info(o.buildTimelineMessage({transport: o.name + (o.options.useTLS ? "s" : "")})), o.hooks.isInitialized() ? o.changeState("initialized") : o.hooks.file ? (o.changeState("initializing"), re.load(o.hooks.file, {useTLS: o.options.useTLS}, function (s, u) {
                    o.hooks.isInitialized() ? (o.changeState("initialized"), u(!0)) : (s && o.onError(s), o.onClose(), u(!1))
                })) : o.onClose()
            }, nn = {
                getRequest: function (o) {
                    var s = new window.XDomainRequest;
                    return s.ontimeout = function () {
                        o.emit("error", new Ne), o.close()
                    }, s.onerror = function (u) {
                        o.emit("error", u), o.close()
                    }, s.onprogress = function () {
                        s.responseText && s.responseText.length > 0 && o.onChunk(200, s.responseText)
                    }, s.onload = function () {
                        s.responseText && s.responseText.length > 0 && o.onChunk(200, s.responseText), o.emit("finished", 200), o.close()
                    }, s
                }, abortRequest: function (o) {
                    o.ontimeout = o.onerror = o.onprogress = o.onload = null, o.abort()
                }
            }, so = nn, yi = function () {
                var o = function (s, u) {
                    return o = Object.setPrototypeOf || {__proto__: []} instanceof Array && function (a, c) {
                        a.__proto__ = c
                    } || function (a, c) {
                        for (var g in c) c.hasOwnProperty(g) && (a[g] = c[g])
                    }, o(s, u)
                };
                return function (s, u) {
                    o(s, u);

                    function a() {
                        this.constructor = s
                    }

                    s.prototype = u === null ? Object.create(u) : (a.prototype = u.prototype, new a)
                }
            }(), Ct = 256 * 1024, n = function (o) {
                yi(s, o);

                function s(u, a, c) {
                    var g = o.call(this) || this;
                    return g.hooks = u, g.method = a, g.url = c, g
                }

                return s.prototype.start = function (u) {
                    var a = this;
                    this.position = 0, this.xhr = this.hooks.getRequest(this), this.unloader = function () {
                        a.close()
                    }, Z.addUnloadListener(this.unloader), this.xhr.open(this.method, this.url, !0), this.xhr.setRequestHeader && this.xhr.setRequestHeader("Content-Type", "application/json"), this.xhr.send(u)
                }, s.prototype.close = function () {
                    this.unloader && (Z.removeUnloadListener(this.unloader), this.unloader = null), this.xhr && (this.hooks.abortRequest(this.xhr), this.xhr = null)
                }, s.prototype.onChunk = function (u, a) {
                    for (; ;) {
                        var c = this.advanceBuffer(a);
                        if (c) this.emit("chunk", {status: u, data: c}); else break
                    }
                    this.isBufferTooLong(a) && this.emit("buffer_too_long")
                }, s.prototype.advanceBuffer = function (u) {
                    var a = u.slice(this.position), c = a.indexOf(`
`);
                    return c !== -1 ? (this.position += c + 1, a.slice(0, c)) : null
                }, s.prototype.isBufferTooLong = function (u) {
                    return this.position === u.length && u.length > Ct
                }, s
            }(St), i = n, f;
            (function (o) {
                o[o.CONNECTING = 0] = "CONNECTING", o[o.OPEN = 1] = "OPEN", o[o.CLOSED = 3] = "CLOSED"
            })(f || (f = {}));
            var l = f, v = 1, y = function () {
                function o(s, u) {
                    this.hooks = s, this.session = H(1e3) + "/" + U(8), this.location = b(u), this.readyState = l.CONNECTING, this.openStream()
                }

                return o.prototype.send = function (s) {
                    return this.sendRaw(JSON.stringify([s]))
                }, o.prototype.ping = function () {
                    this.hooks.sendHeartbeat(this)
                }, o.prototype.close = function (s, u) {
                    this.onClose(s, u, !0)
                }, o.prototype.sendRaw = function (s) {
                    if (this.readyState === l.OPEN) try {
                        return Z.createSocketRequest("POST", k(P(this.location, this.session))).start(s), !0
                    } catch {
                        return !1
                    } else return !1
                }, o.prototype.reconnect = function () {
                    this.closeStream(), this.openStream()
                }, o.prototype.onClose = function (s, u, a) {
                    this.closeStream(), this.readyState = l.CLOSED, this.onclose && this.onclose({
                        code: s,
                        reason: u,
                        wasClean: a
                    })
                }, o.prototype.onChunk = function (s) {
                    if (s.status === 200) {
                        this.readyState === l.OPEN && this.onActivity();
                        var u, a = s.data.slice(0, 1);
                        switch (a) {
                            case"o":
                                u = JSON.parse(s.data.slice(1) || "{}"), this.onOpen(u);
                                break;
                            case"a":
                                u = JSON.parse(s.data.slice(1) || "[]");
                                for (var c = 0; c < u.length; c++) this.onEvent(u[c]);
                                break;
                            case"m":
                                u = JSON.parse(s.data.slice(1) || "null"), this.onEvent(u);
                                break;
                            case"h":
                                this.hooks.onHeartbeat(this);
                                break;
                            case"c":
                                u = JSON.parse(s.data.slice(1) || "[]"), this.onClose(u[0], u[1], !0);
                                break
                        }
                    }
                }, o.prototype.onOpen = function (s) {
                    this.readyState === l.CONNECTING ? (s && s.hostname && (this.location.base = N(this.location.base, s.hostname)), this.readyState = l.OPEN, this.onopen && this.onopen()) : this.onClose(1006, "Server lost session", !0)
                }, o.prototype.onEvent = function (s) {
                    this.readyState === l.OPEN && this.onmessage && this.onmessage({data: s})
                }, o.prototype.onActivity = function () {
                    this.onactivity && this.onactivity()
                }, o.prototype.onError = function (s) {
                    this.onerror && this.onerror(s)
                }, o.prototype.openStream = function () {
                    var s = this;
                    this.stream = Z.createSocketRequest("POST", k(this.hooks.getReceiveURL(this.location, this.session))), this.stream.bind("chunk", function (u) {
                        s.onChunk(u)
                    }), this.stream.bind("finished", function (u) {
                        s.hooks.onFinished(s, u)
                    }), this.stream.bind("buffer_too_long", function () {
                        s.reconnect()
                    });
                    try {
                        this.stream.start()
                    } catch (u) {
                        Be.defer(function () {
                            s.onError(u), s.onClose(1006, "Could not start streaming", !1)
                        })
                    }
                }, o.prototype.closeStream = function () {
                    this.stream && (this.stream.unbind_all(), this.stream.close(), this.stream = null)
                }, o
            }();

            function b(o) {
                var s = /([^\?]*)\/*(\??.*)/.exec(o);
                return {base: s[1], queryString: s[2]}
            }

            function P(o, s) {
                return o.base + "/" + s + "/xhr_send"
            }

            function k(o) {
                var s = o.indexOf("?") === -1 ? "?" : "&";
                return o + s + "t=" + +new Date + "&n=" + v++
            }

            function N(o, s) {
                var u = /(https?:\/\/)([^\/:]+)((\/|:)?.*)/.exec(o);
                return u[1] + s + u[3]
            }

            function H(o) {
                return Z.randomInt(o)
            }

            function U(o) {
                for (var s = [], u = 0; u < o; u++) s.push(H(32).toString(32));
                return s.join("")
            }

            var q = y, K = {
                getReceiveURL: function (o, s) {
                    return o.base + "/" + s + "/xhr_streaming" + o.queryString
                }, onHeartbeat: function (o) {
                    o.sendRaw("[]")
                }, sendHeartbeat: function (o) {
                    o.sendRaw("[]")
                }, onFinished: function (o, s) {
                    o.onClose(1006, "Connection interrupted (" + s + ")", !1)
                }
            }, ne = K, ve = {
                getReceiveURL: function (o, s) {
                    return o.base + "/" + s + "/xhr" + o.queryString
                }, onHeartbeat: function () {
                }, sendHeartbeat: function (o) {
                    o.sendRaw("[]")
                }, onFinished: function (o, s) {
                    s === 200 ? o.reconnect() : o.onClose(1006, "Connection interrupted (" + s + ")", !1)
                }
            }, ge = ve, Ye = {
                getRequest: function (o) {
                    var s = Z.getXHRAPI(), u = new s;
                    return u.onreadystatechange = u.onprogress = function () {
                        switch (u.readyState) {
                            case 3:
                                u.responseText && u.responseText.length > 0 && o.onChunk(u.status, u.responseText);
                                break;
                            case 4:
                                u.responseText && u.responseText.length > 0 && o.onChunk(u.status, u.responseText), o.emit("finished", u.status), o.close();
                                break
                        }
                    }, u
                }, abortRequest: function (o) {
                    o.onreadystatechange = null, o.abort()
                }
            }, Ue = Ye, Xt = {
                createStreamingSocket: function (o) {
                    return this.createSocket(ne, o)
                }, createPollingSocket: function (o) {
                    return this.createSocket(ge, o)
                }, createSocket: function (o, s) {
                    return new q(o, s)
                }, createXHR: function (o, s) {
                    return this.createRequest(Ue, o, s)
                }, createRequest: function (o, s, u) {
                    return new i(o, s, u)
                }
            }, Nt = Xt;
            Nt.createXDR = function (o, s) {
                return this.createRequest(so, o, s)
            };
            var we = Nt, _n = {
                nextAuthCallbackID: 1,
                auth_callbacks: {},
                ScriptReceivers: M,
                DependenciesReceivers: ae,
                getDefaultStrategy: je,
                Transports: ni,
                transportConnectionInitializer: Ur,
                HTTPFactory: we,
                TimelineTransport: Fn,
                getXHRAPI: function () {
                    return window.XMLHttpRequest
                },
                getWebSocketAPI: function () {
                    return window.WebSocket || window.MozWebSocket
                },
                setup: function (o) {
                    var s = this;
                    window.Pusher = o;
                    var u = function () {
                        s.onDocumentBody(o.ready)
                    };
                    window.JSON ? u() : re.load("json2", {}, u)
                },
                getDocument: function () {
                    return document
                },
                getProtocol: function () {
                    return this.getDocument().location.protocol
                },
                getAuthorizers: function () {
                    return {ajax: Co, jsonp: Rr}
                },
                onDocumentBody: function (o) {
                    var s = this;
                    document.body ? o() : setTimeout(function () {
                        s.onDocumentBody(o)
                    }, 0)
                },
                createJSONPRequest: function (o, s) {
                    return new tn(o, s)
                },
                createScriptRequest: function (o) {
                    return new kn(o)
                },
                getLocalStorage: function () {
                    try {
                        return window.localStorage
                    } catch {
                        return
                    }
                },
                createXHR: function () {
                    return this.getXHRAPI() ? this.createXMLHttpRequest() : this.createMicrosoftXHR()
                },
                createXMLHttpRequest: function () {
                    var o = this.getXHRAPI();
                    return new o
                },
                createMicrosoftXHR: function () {
                    return new ActiveXObject("Microsoft.XMLHTTP")
                },
                getNetwork: function () {
                    return Mr
                },
                createWebSocket: function (o) {
                    var s = this.getWebSocketAPI();
                    return new s(o)
                },
                createSocketRequest: function (o, s) {
                    if (this.isXHRSupported()) return this.HTTPFactory.createXHR(o, s);
                    if (this.isXDRSupported(s.indexOf("https:") === 0)) return this.HTTPFactory.createXDR(o, s);
                    throw "Cross-origin HTTP requests are not supported"
                },
                isXHRSupported: function () {
                    var o = this.getXHRAPI();
                    return Boolean(o) && new o().withCredentials !== void 0
                },
                isXDRSupported: function (o) {
                    var s = o ? "https:" : "http:", u = this.getProtocol();
                    return Boolean(window.XDomainRequest) && u === s
                },
                addUnloadListener: function (o) {
                    window.addEventListener !== void 0 ? window.addEventListener("unload", o, !1) : window.attachEvent !== void 0 && window.attachEvent("onunload", o)
                },
                removeUnloadListener: function (o) {
                    window.addEventListener !== void 0 ? window.removeEventListener("unload", o, !1) : window.detachEvent !== void 0 && window.detachEvent("onunload", o)
                },
                randomInt: function (o) {
                    var s = function () {
                        var u = window.crypto || window.msCrypto, a = u.getRandomValues(new Uint32Array(1))[0];
                        return a / Math.pow(2, 32)
                    };
                    return Math.floor(s() * o)
                }
            }, Z = _n, Le;
            (function (o) {
                o[o.ERROR = 3] = "ERROR", o[o.INFO = 6] = "INFO", o[o.DEBUG = 7] = "DEBUG"
            })(Le || (Le = {}));
            var mn = Le, Br = function () {
                function o(s, u, a) {
                    this.key = s, this.session = u, this.events = [], this.options = a || {}, this.sent = 0, this.uniqueID = 0
                }

                return o.prototype.log = function (s, u) {
                    s <= this.options.level && (this.events.push(We({}, u, {timestamp: Be.now()})), this.options.limit && this.events.length > this.options.limit && this.events.shift())
                }, o.prototype.error = function (s) {
                    this.log(mn.ERROR, s)
                }, o.prototype.info = function (s) {
                    this.log(mn.INFO, s)
                }, o.prototype.debug = function (s) {
                    this.log(mn.DEBUG, s)
                }, o.prototype.isEmpty = function () {
                    return this.events.length === 0
                }, o.prototype.send = function (s, u) {
                    var a = this, c = We({
                        session: this.session,
                        bundle: this.sent + 1,
                        key: this.key,
                        lib: "js",
                        version: this.options.version,
                        cluster: this.options.cluster,
                        features: this.options.features,
                        timeline: this.events
                    }, this.options.params);
                    return this.events = [], s(c, function (g, E) {
                        g || a.sent++, u && u(g, E)
                    }), !0
                }, o.prototype.generateUniqueID = function () {
                    return this.uniqueID++, this.uniqueID
                }, o
            }(), Dt = Br, Nn = function () {
                function o(s, u, a, c) {
                    this.name = s, this.priority = u, this.transport = a, this.options = c || {}
                }

                return o.prototype.isSupported = function () {
                    return this.transport.isSupported({useTLS: this.options.useTLS})
                }, o.prototype.connect = function (s, u) {
                    var a = this;
                    if (this.isSupported()) {
                        if (this.priority < s) return Gt(new He, u)
                    } else return Gt(new _e, u);
                    var c = !1,
                        g = this.transport.createConnection(this.name, this.priority, this.options.key, this.options),
                        E = null, L = function () {
                            g.unbind("initialized", L), g.connect()
                        }, W = function () {
                            E = zt.createHandshake(g, function (se) {
                                c = !0, ue(), u(null, se)
                            })
                        }, j = function (se) {
                            ue(), u(se)
                        }, X = function () {
                            ue();
                            var se;
                            se = Ve(g), u(new et(se))
                        }, ue = function () {
                            g.unbind("initialized", L), g.unbind("open", W), g.unbind("error", j), g.unbind("closed", X)
                        };
                    return g.bind("initialized", L), g.bind("open", W), g.bind("error", j), g.bind("closed", X), g.initialize(), {
                        abort: function () {
                            c || (ue(), E ? E.close() : g.close())
                        }, forceMinPriority: function (se) {
                            c || a.priority < se && (E ? E.close() : g.close())
                        }
                    }
                }, o
            }(), Tt = Nn;

            function Gt(o, s) {
                return Be.defer(function () {
                    s(o)
                }), {
                    abort: function () {
                    }, forceMinPriority: function () {
                    }
                }
            }

            var bn = Z.Transports, ft = function (o, s, u, a, c, g) {
                var E = bn[u];
                if (!E) throw new tt(u);
                var L = (!o.enabledTransports || ir(o.enabledTransports, s) !== -1) && (!o.disabledTransports || ir(o.disabledTransports, s) === -1),
                    W;
                return L ? (c = Object.assign({ignoreNullOrigin: o.ignoreNullOrigin}, c), W = new Tt(s, a, g ? g.getAssistant(E) : E, c)) : W = gr, W
            }, gr = {
                isSupported: function () {
                    return !1
                }, connect: function (o, s) {
                    var u = Be.defer(function () {
                        s(new _e)
                    });
                    return {
                        abort: function () {
                            u.ensureAborted()
                        }, forceMinPriority: function () {
                        }
                    }
                }
            }, rn = function (o, s) {
                var u = "socket_id=" + encodeURIComponent(o.socketId);
                for (var a in s.params) u += "&" + encodeURIComponent(a) + "=" + encodeURIComponent(s.params[a]);
                if (s.paramsProvider != null) {
                    var c = s.paramsProvider();
                    for (var a in c) u += "&" + encodeURIComponent(a) + "=" + encodeURIComponent(c[a])
                }
                return u
            }, Jt = function (o) {
                if (typeof Z.getAuthorizers()[o.transport] == "undefined") throw "'" + o.transport + "' is not a recognized auth transport";
                return function (s, u) {
                    var a = rn(s, o);
                    Z.getAuthorizers()[o.transport](Z, a, o, G.UserAuthentication, u)
                }
            }, lt = Jt, _i = function (o, s) {
                var u = "socket_id=" + encodeURIComponent(o.socketId);
                u += "&channel_name=" + encodeURIComponent(o.channelName);
                for (var a in s.params) u += "&" + encodeURIComponent(a) + "=" + encodeURIComponent(s.params[a]);
                if (s.paramsProvider != null) {
                    var c = s.paramsProvider();
                    for (var a in c) u += "&" + encodeURIComponent(a) + "=" + encodeURIComponent(c[a])
                }
                return u
            }, vr = function (o) {
                if (typeof Z.getAuthorizers()[o.transport] == "undefined") throw "'" + o.transport + "' is not a recognized auth transport";
                return function (s, u) {
                    var a = _i(s, o);
                    Z.getAuthorizers()[o.transport](Z, a, o, G.ChannelAuthorization, u)
                }
            }, Oe = vr, yr = function (o, s, u) {
                var a = {
                    authTransport: s.transport,
                    authEndpoint: s.endpoint,
                    auth: {params: s.params, headers: s.headers}
                };
                return function (c, g) {
                    var E = o.channel(c.channelName), L = u(E, a);
                    L.authorize(c.socketId, g)
                }
            }, nt = function () {
                return nt = Object.assign || function (o) {
                    for (var s, u = 1, a = arguments.length; u < a; u++) {
                        s = arguments[u];
                        for (var c in s) Object.prototype.hasOwnProperty.call(s, c) && (o[c] = s[c])
                    }
                    return o
                }, nt.apply(this, arguments)
            };

            function Yn(o, s) {
                var u = {
                    activityTimeout: o.activityTimeout || B.activityTimeout,
                    cluster: o.cluster || B.cluster,
                    httpPath: o.httpPath || B.httpPath,
                    httpPort: o.httpPort || B.httpPort,
                    httpsPort: o.httpsPort || B.httpsPort,
                    pongTimeout: o.pongTimeout || B.pongTimeout,
                    statsHost: o.statsHost || B.stats_host,
                    unavailableTimeout: o.unavailableTimeout || B.unavailableTimeout,
                    wsPath: o.wsPath || B.wsPath,
                    wsPort: o.wsPort || B.wsPort,
                    wssPort: o.wssPort || B.wssPort,
                    enableStats: bi(o),
                    httpHost: Uo(o),
                    useTLS: At(o),
                    wsHost: Bo(o),
                    userAuthenticator: wn(o),
                    channelAuthorizer: Qn(o, s)
                };
                return "disabledTransports" in o && (u.disabledTransports = o.disabledTransports), "enabledTransports" in o && (u.enabledTransports = o.enabledTransports), "ignoreNullOrigin" in o && (u.ignoreNullOrigin = o.ignoreNullOrigin), "timelineParams" in o && (u.timelineParams = o.timelineParams), "nacl" in o && (u.nacl = o.nacl), u
            }

            function Uo(o) {
                return o.httpHost ? o.httpHost : o.cluster ? "sockjs-" + o.cluster + ".pusher.com" : B.httpHost
            }

            function Bo(o) {
                return o.wsHost ? o.wsHost : o.cluster ? mi(o.cluster) : mi(B.cluster)
            }

            function mi(o) {
                return "ws-" + o + ".pusher.com"
            }

            function At(o) {
                return Z.getProtocol() === "https:" ? !0 : o.forceTLS !== !1
            }

            function bi(o) {
                return "enableStats" in o ? o.enableStats : "disableStats" in o ? !o.disableStats : !1
            }

            function wn(o) {
                var s = nt(nt({}, B.userAuthentication), o.userAuthentication);
                return "customHandler" in s && s.customHandler != null ? s.customHandler : lt(s)
            }

            function Fr(o, s) {
                var u;
                return "channelAuthorization" in o ? u = nt(nt({}, B.channelAuthorization), o.channelAuthorization) : (u = {
                    transport: o.authTransport || B.authTransport,
                    endpoint: o.authEndpoint || B.authEndpoint
                }, "auth" in o && ("params" in o.auth && (u.params = o.auth.params), "headers" in o.auth && (u.headers = o.auth.headers)), "authorizer" in o && (u.customHandler = yr(s, u, o.authorizer))), u
            }

            function Qn(o, s) {
                var u = Fr(o, s);
                return "customHandler" in u && u.customHandler != null ? u.customHandler : Oe(u)
            }

            var Mt = function () {
                var o = function (s, u) {
                    return o = Object.setPrototypeOf || {__proto__: []} instanceof Array && function (a, c) {
                        a.__proto__ = c
                    } || function (a, c) {
                        for (var g in c) c.hasOwnProperty(g) && (a[g] = c[g])
                    }, o(s, u)
                };
                return function (s, u) {
                    o(s, u);

                    function a() {
                        this.constructor = s
                    }

                    s.prototype = u === null ? Object.create(u) : (a.prototype = u.prototype, new a)
                }
            }(), Dn = function (o) {
                Mt(s, o);

                function s(u) {
                    var a = o.call(this, function (c, g) {
                        Pe.debug("No callbacks on watchlist events for " + c)
                    }) || this;
                    return a.pusher = u, a.bindWatchlistInternalEvent(), a
                }

                return s.prototype.handleEvent = function (u) {
                    var a = this;
                    u.data.events.forEach(function (c) {
                        a.emit(c.name, c)
                    })
                }, s.prototype.bindWatchlistInternalEvent = function () {
                    var u = this;
                    this.pusher.connection.bind("message", function (a) {
                        var c = a.event;
                        c === "pusher_internal:watchlist_events" && u.handleEvent(a)
                    })
                }, s
            }(St), wi = Dn;

            function Fo() {
                var o, s, u = new Promise(function (a, c) {
                    o = a, s = c
                });
                return {promise: u, resolve: o, reject: s}
            }

            var Wr = Fo, xn = function () {
                var o = function (s, u) {
                    return o = Object.setPrototypeOf || {__proto__: []} instanceof Array && function (a, c) {
                        a.__proto__ = c
                    } || function (a, c) {
                        for (var g in c) c.hasOwnProperty(g) && (a[g] = c[g])
                    }, o(s, u)
                };
                return function (s, u) {
                    o(s, u);

                    function a() {
                        this.constructor = s
                    }

                    s.prototype = u === null ? Object.create(u) : (a.prototype = u.prototype, new a)
                }
            }(), ht = function (o) {
                xn(s, o);

                function s(u) {
                    var a = o.call(this, function (c, g) {
                        Pe.debug("No callbacks on user for " + c)
                    }) || this;
                    return a.signin_requested = !1, a.user_data = null, a.serverToUserChannel = null, a.signinDonePromise = null, a._signinDoneResolve = null, a._onAuthorize = function (c, g) {
                        if (c) {
                            Pe.warn("Error during signin: " + c), a._cleanup();
                            return
                        }
                        a.pusher.send_event("pusher:signin", {auth: g.auth, user_data: g.user_data})
                    }, a.pusher = u, a.pusher.connection.bind("state_change", function (c) {
                        var g = c.previous, E = c.current;
                        g !== "connected" && E === "connected" && a._signin(), g === "connected" && E !== "connected" && (a._cleanup(), a._newSigninPromiseIfNeeded())
                    }), a.watchlist = new wi(u), a.pusher.connection.bind("message", function (c) {
                        var g = c.event;
                        g === "pusher:signin_success" && a._onSigninSuccess(c.data), a.serverToUserChannel && a.serverToUserChannel.name === c.channel && a.serverToUserChannel.handleEvent(c)
                    }), a
                }

                return s.prototype.signin = function () {
                    this.signin_requested || (this.signin_requested = !0, this._signin())
                }, s.prototype._signin = function () {
                    !this.signin_requested || (this._newSigninPromiseIfNeeded(), this.pusher.connection.state === "connected" && this.pusher.config.userAuthenticator({socketId: this.pusher.connection.socket_id}, this._onAuthorize))
                }, s.prototype._onSigninSuccess = function (u) {
                    try {
                        this.user_data = JSON.parse(u.user_data)
                    } catch {
                        Pe.error("Failed parsing user data after signin: " + u.user_data), this._cleanup();
                        return
                    }
                    if (typeof this.user_data.id != "string" || this.user_data.id === "") {
                        Pe.error("user_data doesn't contain an id. user_data: " + this.user_data), this._cleanup();
                        return
                    }
                    this._signinDoneResolve(), this._subscribeChannels()
                }, s.prototype._subscribeChannels = function () {
                    var u = this, a = function (c) {
                        c.subscriptionPending && c.subscriptionCancelled ? c.reinstateSubscription() : !c.subscriptionPending && u.pusher.connection.state === "connected" && c.subscribe()
                    };
                    this.serverToUserChannel = new Ke("#server-to-user-" + this.user_data.id, this.pusher), this.serverToUserChannel.bind_global(function (c, g) {
                        c.indexOf("pusher_internal:") === 0 || c.indexOf("pusher:") === 0 || u.emit(c, g)
                    }), a(this.serverToUserChannel)
                }, s.prototype._cleanup = function () {
                    this.user_data = null, this.serverToUserChannel && (this.serverToUserChannel.unbind_all(), this.serverToUserChannel.disconnect(), this.serverToUserChannel = null), this.signin_requested && this._signinDoneResolve()
                }, s.prototype._newSigninPromiseIfNeeded = function () {
                    if (!!this.signin_requested && !(this.signinDonePromise && !this.signinDonePromise.done)) {
                        var u = Wr(), a = u.promise, c = u.resolve;
                        a.done = !1;
                        var g = function () {
                            a.done = !0
                        };
                        a.then(g).catch(g), this.signinDonePromise = a, this._signinDoneResolve = c
                    }
                }, s
            }(St), uo = ht, $r = function () {
                function o(s, u) {
                    var a = this;
                    if (T(s), u = u || {}, !u.cluster && !(u.wsHost || u.httpHost)) {
                        var c = J.buildLogSuffix("javascriptQuickStart");
                        Pe.warn("You should always specify a cluster when connecting. " + c)
                    }
                    "disableStats" in u && Pe.warn("The disableStats option is deprecated in favor of enableStats"), this.key = s, this.config = Yn(u, this), this.channels = zt.createChannels(), this.global_emitter = new St, this.sessionID = Z.randomInt(1e9), this.timeline = new Dt(this.key, this.sessionID, {
                        cluster: this.config.cluster,
                        features: o.getClientFeatures(),
                        params: this.config.timelineParams || {},
                        limit: 50,
                        level: mn.INFO,
                        version: B.VERSION
                    }), this.config.enableStats && (this.timelineSender = zt.createTimelineSender(this.timeline, {
                        host: this.config.statsHost,
                        path: "/timeline/v2/" + Z.TimelineTransport.name
                    }));
                    var g = function (E) {
                        return Z.getDefaultStrategy(a.config, E, ft)
                    };
                    this.connection = zt.createConnectionManager(this.key, {
                        getStrategy: g,
                        timeline: this.timeline,
                        activityTimeout: this.config.activityTimeout,
                        pongTimeout: this.config.pongTimeout,
                        unavailableTimeout: this.config.unavailableTimeout,
                        useTLS: Boolean(this.config.useTLS)
                    }), this.connection.bind("connected", function () {
                        a.subscribeAll(), a.timelineSender && a.timelineSender.send(a.connection.isUsingTLS())
                    }), this.connection.bind("message", function (E) {
                        var L = E.event, W = L.indexOf("pusher_internal:") === 0;
                        if (E.channel) {
                            var j = a.channel(E.channel);
                            j && j.handleEvent(E)
                        }
                        W || a.global_emitter.emit(E.event, E.data)
                    }), this.connection.bind("connecting", function () {
                        a.channels.disconnect()
                    }), this.connection.bind("disconnected", function () {
                        a.channels.disconnect()
                    }), this.connection.bind("error", function (E) {
                        Pe.warn(E)
                    }), o.instances.push(this), this.timeline.info({instances: o.instances.length}), this.user = new uo(this), o.isReady && this.connect()
                }

                return o.ready = function () {
                    o.isReady = !0;
                    for (var s = 0, u = o.instances.length; s < u; s++) o.instances[s].connect()
                }, o.getClientFeatures = function () {
                    return Bn(Di({ws: Z.Transports.ws}, function (s) {
                        return s.isSupported({})
                    }))
                }, o.prototype.channel = function (s) {
                    return this.channels.find(s)
                }, o.prototype.allChannels = function () {
                    return this.channels.all()
                }, o.prototype.connect = function () {
                    if (this.connection.connect(), this.timelineSender && !this.timelineSenderTimer) {
                        var s = this.connection.isUsingTLS(), u = this.timelineSender;
                        this.timelineSenderTimer = new Or(6e4, function () {
                            u.send(s)
                        })
                    }
                }, o.prototype.disconnect = function () {
                    this.connection.disconnect(), this.timelineSenderTimer && (this.timelineSenderTimer.ensureAborted(), this.timelineSenderTimer = null)
                }, o.prototype.bind = function (s, u, a) {
                    return this.global_emitter.bind(s, u, a), this
                }, o.prototype.unbind = function (s, u, a) {
                    return this.global_emitter.unbind(s, u, a), this
                }, o.prototype.bind_global = function (s) {
                    return this.global_emitter.bind_global(s), this
                }, o.prototype.unbind_global = function (s) {
                    return this.global_emitter.unbind_global(s), this
                }, o.prototype.unbind_all = function (s) {
                    return this.global_emitter.unbind_all(), this
                }, o.prototype.subscribeAll = function () {
                    var s;
                    for (s in this.channels.channels) this.channels.channels.hasOwnProperty(s) && this.subscribe(s)
                }, o.prototype.subscribe = function (s) {
                    var u = this.channels.add(s, this);
                    return u.subscriptionPending && u.subscriptionCancelled ? u.reinstateSubscription() : !u.subscriptionPending && this.connection.state === "connected" && u.subscribe(), u
                }, o.prototype.unsubscribe = function (s) {
                    var u = this.channels.find(s);
                    u && u.subscriptionPending ? u.cancelSubscription() : (u = this.channels.remove(s), u && u.subscribed && u.unsubscribe())
                }, o.prototype.send_event = function (s, u, a) {
                    return this.connection.send_event(s, u, a)
                }, o.prototype.shouldUseTLS = function () {
                    return this.config.useTLS
                }, o.prototype.signin = function () {
                    this.user.signin()
                }, o.instances = [], o.isReady = !1, o.logToConsole = !1, o.Runtime = Z, o.ScriptReceivers = Z.ScriptReceivers, o.DependenciesReceivers = Z.DependenciesReceivers, o.auth_callbacks = Z.auth_callbacks, o
            }(), zr = A.default = $r;

            function T(o) {
                if (o == null) throw "You must pass your app key when you instantiate Pusher."
            }

            Z.setup($r)
        }])
    })
})(Ec);
var kc = Lv(Ec.exports);
window._ = Iv;
try {
    window.Popper = require("popper.js").default, window.$ = window.jQuery = require("jquery"), require("bootstrap")
} catch {
}
window.axios = o0;
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
window.Pusher = kc;
window.Echo = new fa({
    broadcaster: "pusher",
    key: {}.MIX_PUSHER_APP_KEY,
    cluster: {}.MIX_PUSHER_APP_CLUSTER,
    encrypted: !0
});
var Oc = {exports: {}};/*!
 * jQuery JavaScript Library v3.7.1
 * https://jquery.com/
 *
 * Copyright OpenJS Foundation and other contributors
 * Released under the MIT license
 * https://jquery.org/license
 *
 * Date: 2023-08-28T13:37Z
 */
(function (C) {
    (function (m, d) {
        C.exports = m.document ? d(m, !0) : function (A) {
            if (!A.document) throw new Error("jQuery requires a window with a document");
            return d(A)
        }
    })(typeof window != "undefined" ? window : wo, function (m, d) {
        var A = [], S = Object.getPrototypeOf, I = A.slice, M = A.flat ? function (n) {
                return A.flat.call(n)
            } : function (n) {
                return A.concat.apply([], n)
            }, ie = A.push, B = A.indexOf, qe = {}, Se = qe.toString, ae = qe.hasOwnProperty, re = ae.toString,
            ee = re.call(Object), Q = {}, J = function (i) {
                return typeof i == "function" && typeof i.nodeType != "number" && typeof i.item != "function"
            }, G = function (i) {
                return i != null && i === i.window
            }, F = m.document, de = {type: !0, src: !0, nonce: !0, noModule: !0};

        function Te(n, i, f) {
            f = f || F;
            var l, v, y = f.createElement("script");
            if (y.text = n, i) for (l in de) v = i[l] || i.getAttribute && i.getAttribute(l), v && y.setAttribute(l, v);
            f.head.appendChild(y).parentNode.removeChild(y)
        }

        function Ne(n) {
            return n == null ? n + "" : typeof n == "object" || typeof n == "function" ? qe[Se.call(n)] || "object" : typeof n
        }

        var He = "3.7.1", et = /HTML$/i, p = function (n, i) {
            return new p.fn.init(n, i)
        };
        p.fn = p.prototype = {
            jquery: He, constructor: p, length: 0, toArray: function () {
                return I.call(this)
            }, get: function (n) {
                return n == null ? I.call(this) : n < 0 ? this[n + this.length] : this[n]
            }, pushStack: function (n) {
                var i = p.merge(this.constructor(), n);
                return i.prevObject = this, i
            }, each: function (n) {
                return p.each(this, n)
            }, map: function (n) {
                return this.pushStack(p.map(this, function (i, f) {
                    return n.call(i, f, i)
                }))
            }, slice: function () {
                return this.pushStack(I.apply(this, arguments))
            }, first: function () {
                return this.eq(0)
            }, last: function () {
                return this.eq(-1)
            }, even: function () {
                return this.pushStack(p.grep(this, function (n, i) {
                    return (i + 1) % 2
                }))
            }, odd: function () {
                return this.pushStack(p.grep(this, function (n, i) {
                    return i % 2
                }))
            }, eq: function (n) {
                var i = this.length, f = +n + (n < 0 ? i : 0);
                return this.pushStack(f >= 0 && f < i ? [this[f]] : [])
            }, end: function () {
                return this.prevObject || this.constructor()
            }, push: ie, sort: A.sort, splice: A.splice
        }, p.extend = p.fn.extend = function () {
            var n, i, f, l, v, y, b = arguments[0] || {}, P = 1, k = arguments.length, N = !1;
            for (typeof b == "boolean" && (N = b, b = arguments[P] || {}, P++), typeof b != "object" && !J(b) && (b = {}), P === k && (b = this, P--); P < k; P++) if ((n = arguments[P]) != null) for (i in n) l = n[i], !(i === "__proto__" || b === l) && (N && l && (p.isPlainObject(l) || (v = Array.isArray(l))) ? (f = b[i], v && !Array.isArray(f) ? y = [] : !v && !p.isPlainObject(f) ? y = {} : y = f, v = !1, b[i] = p.extend(N, y, l)) : l !== void 0 && (b[i] = l));
            return b
        }, p.extend({
            expando: "jQuery" + (He + Math.random()).replace(/\D/g, ""), isReady: !0, error: function (n) {
                throw new Error(n)
            }, noop: function () {
            }, isPlainObject: function (n) {
                var i, f;
                return !n || Se.call(n) !== "[object Object]" ? !1 : (i = S(n), i ? (f = ae.call(i, "constructor") && i.constructor, typeof f == "function" && re.call(f) === ee) : !0)
            }, isEmptyObject: function (n) {
                var i;
                for (i in n) return !1;
                return !0
            }, globalEval: function (n, i, f) {
                Te(n, {nonce: i && i.nonce}, f)
            }, each: function (n, i) {
                var f, l = 0;
                if (tt(n)) for (f = n.length; l < f && i.call(n[l], l, n[l]) !== !1; l++) ; else for (l in n) if (i.call(n[l], l, n[l]) === !1) break;
                return n
            }, text: function (n) {
                var i, f = "", l = 0, v = n.nodeType;
                if (!v) for (; i = n[l++];) f += p.text(i);
                return v === 1 || v === 11 ? n.textContent : v === 9 ? n.documentElement.textContent : v === 3 || v === 4 ? n.nodeValue : f
            }, makeArray: function (n, i) {
                var f = i || [];
                return n != null && (tt(Object(n)) ? p.merge(f, typeof n == "string" ? [n] : n) : ie.call(f, n)), f
            }, inArray: function (n, i, f) {
                return i == null ? -1 : B.call(i, n, f)
            }, isXMLDoc: function (n) {
                var i = n && n.namespaceURI, f = n && (n.ownerDocument || n).documentElement;
                return !et.test(i || f && f.nodeName || "HTML")
            }, merge: function (n, i) {
                for (var f = +i.length, l = 0, v = n.length; l < f; l++) n[v++] = i[l];
                return n.length = v, n
            }, grep: function (n, i, f) {
                for (var l, v = [], y = 0, b = n.length, P = !f; y < b; y++) l = !i(n[y], y), l !== P && v.push(n[y]);
                return v
            }, map: function (n, i, f) {
                var l, v, y = 0, b = [];
                if (tt(n)) for (l = n.length; y < l; y++) v = i(n[y], y, f), v != null && b.push(v); else for (y in n) v = i(n[y], y, f), v != null && b.push(v);
                return M(b)
            }, guid: 1, support: Q
        }), typeof Symbol == "function" && (p.fn[Symbol.iterator] = A[Symbol.iterator]), p.each("Boolean Number String Function Array Date RegExp Object Error Symbol".split(" "), function (n, i) {
            qe["[object " + i + "]"] = i.toLowerCase()
        });

        function tt(n) {
            var i = !!n && "length" in n && n.length, f = Ne(n);
            return J(n) || G(n) ? !1 : f === "array" || i === 0 || typeof i == "number" && i > 0 && i - 1 in n
        }

        function _e(n, i) {
            return n.nodeName && n.nodeName.toLowerCase() === i.toLowerCase()
        }

        var Bt = A.pop, So = A.sort, Co = A.splice, Ie = "[\\x20\\t\\r\\n\\f]",
            Ft = new RegExp("^" + Ie + "+|((?:^|[^\\\\])(?:\\\\.)*)" + Ie + "+$", "g");
        p.contains = function (n, i) {
            var f = i && i.parentNode;
            return n === f || !!(f && f.nodeType === 1 && (n.contains ? n.contains(f) : n.compareDocumentPosition && n.compareDocumentPosition(f) & 16))
        };
        var kr = /([\0-\x1f\x7f]|^-?\d)|^-$|[^\x80-\uFFFF\w-]/g;

        function To(n, i) {
            return i ? n === "\0" ? "\uFFFD" : n.slice(0, -1) + "\\" + n.charCodeAt(n.length - 1).toString(16) + " " : "\\" + n
        }

        p.escapeSelector = function (n) {
            return (n + "").replace(kr, To)
        };
        var it = F, Wt = ie;
        (function () {
            var n, i, f, l, v, y = Wt, b, P, k, N, H, U = p.expando, q = 0, K = 0, ne = yr(), ve = yr(), ge = yr(),
                Ye = yr(), Ue = function (T, o) {
                    return T === o && (v = !0), 0
                },
                Xt = "checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|ismap|loop|multiple|open|readonly|required|scoped",
                Nt = "(?:\\\\[\\da-fA-F]{1,6}" + Ie + "?|\\\\[^\\r\\n\\f]|[\\w-]|[^\0-\\x7f])+",
                we = "\\[" + Ie + "*(" + Nt + ")(?:" + Ie + "*([*^$|!~]?=)" + Ie + `*(?:'((?:\\\\.|[^\\\\'])*)'|"((?:\\\\.|[^\\\\"])*)"|(` + Nt + "))|)" + Ie + "*\\]",
                _n = ":(" + Nt + `)(?:\\((('((?:\\\\.|[^\\\\'])*)'|"((?:\\\\.|[^\\\\"])*)")|((?:\\\\.|[^\\\\()[\\]]|` + we + ")*)|.*)\\)|)",
                Z = new RegExp(Ie + "+", "g"), Le = new RegExp("^" + Ie + "*," + Ie + "*"),
                mn = new RegExp("^" + Ie + "*([>+~]|" + Ie + ")" + Ie + "*"), Br = new RegExp(Ie + "|>"),
                Dt = new RegExp(_n), Nn = new RegExp("^" + Nt + "$"), Tt = {
                    ID: new RegExp("^#(" + Nt + ")"),
                    CLASS: new RegExp("^\\.(" + Nt + ")"),
                    TAG: new RegExp("^(" + Nt + "|[*])"),
                    ATTR: new RegExp("^" + we),
                    PSEUDO: new RegExp("^" + _n),
                    CHILD: new RegExp("^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\(" + Ie + "*(even|odd|(([+-]|)(\\d*)n|)" + Ie + "*(?:([+-]|)" + Ie + "*(\\d+)|))" + Ie + "*\\)|)", "i"),
                    bool: new RegExp("^(?:" + Xt + ")$", "i"),
                    needsContext: new RegExp("^" + Ie + "*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\(" + Ie + "*((?:-\\d)?\\d*)" + Ie + "*\\)|)(?=[^-]|$)", "i")
                }, Gt = /^(?:input|select|textarea|button)$/i, bn = /^h\d$/i, ft = /^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/,
                gr = /[+~]/, rn = new RegExp("\\\\[\\da-fA-F]{1,6}" + Ie + "?|\\\\([^\\r\\n\\f])", "g"),
                Jt = function (T, o) {
                    var s = "0x" + T.slice(1) - 65536;
                    return o || (s < 0 ? String.fromCharCode(s + 65536) : String.fromCharCode(s >> 10 | 55296, s & 1023 | 56320))
                }, lt = function () {
                    wn()
                }, _i = Dn(function (T) {
                    return T.disabled === !0 && _e(T, "fieldset")
                }, {dir: "parentNode", next: "legend"});

            function vr() {
                try {
                    return b.activeElement
                } catch {
                }
            }

            try {
                y.apply(A = I.call(it.childNodes), it.childNodes), A[it.childNodes.length].nodeType
            } catch {
                y = {
                    apply: function (o, s) {
                        Wt.apply(o, I.call(s))
                    }, call: function (o) {
                        Wt.apply(o, I.call(arguments, 1))
                    }
                }
            }

            function Oe(T, o, s, u) {
                var a, c, g, E, L, W, j, X = o && o.ownerDocument, ue = o ? o.nodeType : 9;
                if (s = s || [], typeof T != "string" || !T || ue !== 1 && ue !== 9 && ue !== 11) return s;
                if (!u && (wn(o), o = o || b, k)) {
                    if (ue !== 11 && (L = ft.exec(T))) if (a = L[1]) {
                        if (ue === 9) if (g = o.getElementById(a)) {
                            if (g.id === a) return y.call(s, g), s
                        } else return s; else if (X && (g = X.getElementById(a)) && Oe.contains(o, g) && g.id === a) return y.call(s, g), s
                    } else {
                        if (L[2]) return y.apply(s, o.getElementsByTagName(T)), s;
                        if ((a = L[3]) && o.getElementsByClassName) return y.apply(s, o.getElementsByClassName(a)), s
                    }
                    if (!Ye[T + " "] && (!N || !N.test(T))) {
                        if (j = T, X = o, ue === 1 && (Br.test(T) || mn.test(T))) {
                            for (X = gr.test(T) && bi(o.parentNode) || o, (X != o || !Q.scope) && ((E = o.getAttribute("id")) ? E = p.escapeSelector(E) : o.setAttribute("id", E = U)), W = Qn(T), c = W.length; c--;) W[c] = (E ? "#" + E : ":scope") + " " + Mt(W[c]);
                            j = W.join(",")
                        }
                        try {
                            return y.apply(s, X.querySelectorAll(j)), s
                        } catch {
                            Ye(T, !0)
                        } finally {
                            E === U && o.removeAttribute("id")
                        }
                    }
                }
                return zr(T.replace(Ft, "$1"), o, s, u)
            }

            function yr() {
                var T = [];

                function o(s, u) {
                    return T.push(s + " ") > i.cacheLength && delete o[T.shift()], o[s + " "] = u
                }

                return o
            }

            function nt(T) {
                return T[U] = !0, T
            }

            function Yn(T) {
                var o = b.createElement("fieldset");
                try {
                    return !!T(o)
                } catch {
                    return !1
                } finally {
                    o.parentNode && o.parentNode.removeChild(o), o = null
                }
            }

            function Uo(T) {
                return function (o) {
                    return _e(o, "input") && o.type === T
                }
            }

            function Bo(T) {
                return function (o) {
                    return (_e(o, "input") || _e(o, "button")) && o.type === T
                }
            }

            function mi(T) {
                return function (o) {
                    return "form" in o ? o.parentNode && o.disabled === !1 ? "label" in o ? "label" in o.parentNode ? o.parentNode.disabled === T : o.disabled === T : o.isDisabled === T || o.isDisabled !== !T && _i(o) === T : o.disabled === T : "label" in o ? o.disabled === T : !1
                }
            }

            function At(T) {
                return nt(function (o) {
                    return o = +o, nt(function (s, u) {
                        for (var a, c = T([], s.length, o), g = c.length; g--;) s[a = c[g]] && (s[a] = !(u[a] = s[a]))
                    })
                })
            }

            function bi(T) {
                return T && typeof T.getElementsByTagName != "undefined" && T
            }

            function wn(T) {
                var o, s = T ? T.ownerDocument || T : it;
                return s == b || s.nodeType !== 9 || !s.documentElement || (b = s, P = b.documentElement, k = !p.isXMLDoc(b), H = P.matches || P.webkitMatchesSelector || P.msMatchesSelector, P.msMatchesSelector && it != b && (o = b.defaultView) && o.top !== o && o.addEventListener("unload", lt), Q.getById = Yn(function (u) {
                    return P.appendChild(u).id = p.expando, !b.getElementsByName || !b.getElementsByName(p.expando).length
                }), Q.disconnectedMatch = Yn(function (u) {
                    return H.call(u, "*")
                }), Q.scope = Yn(function () {
                    return b.querySelectorAll(":scope")
                }), Q.cssHas = Yn(function () {
                    try {
                        return b.querySelector(":has(*,:jqfake)"), !1
                    } catch {
                        return !0
                    }
                }), Q.getById ? (i.filter.ID = function (u) {
                    var a = u.replace(rn, Jt);
                    return function (c) {
                        return c.getAttribute("id") === a
                    }
                }, i.find.ID = function (u, a) {
                    if (typeof a.getElementById != "undefined" && k) {
                        var c = a.getElementById(u);
                        return c ? [c] : []
                    }
                }) : (i.filter.ID = function (u) {
                    var a = u.replace(rn, Jt);
                    return function (c) {
                        var g = typeof c.getAttributeNode != "undefined" && c.getAttributeNode("id");
                        return g && g.value === a
                    }
                }, i.find.ID = function (u, a) {
                    if (typeof a.getElementById != "undefined" && k) {
                        var c, g, E, L = a.getElementById(u);
                        if (L) {
                            if (c = L.getAttributeNode("id"), c && c.value === u) return [L];
                            for (E = a.getElementsByName(u), g = 0; L = E[g++];) if (c = L.getAttributeNode("id"), c && c.value === u) return [L]
                        }
                        return []
                    }
                }), i.find.TAG = function (u, a) {
                    return typeof a.getElementsByTagName != "undefined" ? a.getElementsByTagName(u) : a.querySelectorAll(u)
                }, i.find.CLASS = function (u, a) {
                    if (typeof a.getElementsByClassName != "undefined" && k) return a.getElementsByClassName(u)
                }, N = [], Yn(function (u) {
                    var a;
                    P.appendChild(u).innerHTML = "<a id='" + U + "' href='' disabled='disabled'></a><select id='" + U + "-\r\\' disabled='disabled'><option selected=''></option></select>", u.querySelectorAll("[selected]").length || N.push("\\[" + Ie + "*(?:value|" + Xt + ")"), u.querySelectorAll("[id~=" + U + "-]").length || N.push("~="), u.querySelectorAll("a#" + U + "+*").length || N.push(".#.+[+~]"), u.querySelectorAll(":checked").length || N.push(":checked"), a = b.createElement("input"), a.setAttribute("type", "hidden"), u.appendChild(a).setAttribute("name", "D"), P.appendChild(u).disabled = !0, u.querySelectorAll(":disabled").length !== 2 && N.push(":enabled", ":disabled"), a = b.createElement("input"), a.setAttribute("name", ""), u.appendChild(a), u.querySelectorAll("[name='']").length || N.push("\\[" + Ie + "*name" + Ie + "*=" + Ie + `*(?:''|"")`)
                }), Q.cssHas || N.push(":has"), N = N.length && new RegExp(N.join("|")), Ue = function (u, a) {
                    if (u === a) return v = !0, 0;
                    var c = !u.compareDocumentPosition - !a.compareDocumentPosition;
                    return c || (c = (u.ownerDocument || u) == (a.ownerDocument || a) ? u.compareDocumentPosition(a) : 1, c & 1 || !Q.sortDetached && a.compareDocumentPosition(u) === c ? u === b || u.ownerDocument == it && Oe.contains(it, u) ? -1 : a === b || a.ownerDocument == it && Oe.contains(it, a) ? 1 : l ? B.call(l, u) - B.call(l, a) : 0 : c & 4 ? -1 : 1)
                }), b
            }

            Oe.matches = function (T, o) {
                return Oe(T, null, null, o)
            }, Oe.matchesSelector = function (T, o) {
                if (wn(T), k && !Ye[o + " "] && (!N || !N.test(o))) try {
                    var s = H.call(T, o);
                    if (s || Q.disconnectedMatch || T.document && T.document.nodeType !== 11) return s
                } catch {
                    Ye(o, !0)
                }
                return Oe(o, b, null, [T]).length > 0
            }, Oe.contains = function (T, o) {
                return (T.ownerDocument || T) != b && wn(T), p.contains(T, o)
            }, Oe.attr = function (T, o) {
                (T.ownerDocument || T) != b && wn(T);
                var s = i.attrHandle[o.toLowerCase()],
                    u = s && ae.call(i.attrHandle, o.toLowerCase()) ? s(T, o, !k) : void 0;
                return u !== void 0 ? u : T.getAttribute(o)
            }, Oe.error = function (T) {
                throw new Error("Syntax error, unrecognized expression: " + T)
            }, p.uniqueSort = function (T) {
                var o, s = [], u = 0, a = 0;
                if (v = !Q.sortStable, l = !Q.sortStable && I.call(T, 0), So.call(T, Ue), v) {
                    for (; o = T[a++];) o === T[a] && (u = s.push(a));
                    for (; u--;) Co.call(T, s[u], 1)
                }
                return l = null, T
            }, p.fn.uniqueSort = function () {
                return this.pushStack(p.uniqueSort(I.apply(this)))
            }, i = p.expr = {
                cacheLength: 50,
                createPseudo: nt,
                match: Tt,
                attrHandle: {},
                find: {},
                relative: {
                    ">": {dir: "parentNode", first: !0},
                    " ": {dir: "parentNode"},
                    "+": {dir: "previousSibling", first: !0},
                    "~": {dir: "previousSibling"}
                },
                preFilter: {
                    ATTR: function (T) {
                        return T[1] = T[1].replace(rn, Jt), T[3] = (T[3] || T[4] || T[5] || "").replace(rn, Jt), T[2] === "~=" && (T[3] = " " + T[3] + " "), T.slice(0, 4)
                    }, CHILD: function (T) {
                        return T[1] = T[1].toLowerCase(), T[1].slice(0, 3) === "nth" ? (T[3] || Oe.error(T[0]), T[4] = +(T[4] ? T[5] + (T[6] || 1) : 2 * (T[3] === "even" || T[3] === "odd")), T[5] = +(T[7] + T[8] || T[3] === "odd")) : T[3] && Oe.error(T[0]), T
                    }, PSEUDO: function (T) {
                        var o, s = !T[6] && T[2];
                        return Tt.CHILD.test(T[0]) ? null : (T[3] ? T[2] = T[4] || T[5] || "" : s && Dt.test(s) && (o = Qn(s, !0)) && (o = s.indexOf(")", s.length - o) - s.length) && (T[0] = T[0].slice(0, o), T[2] = s.slice(0, o)), T.slice(0, 3))
                    }
                },
                filter: {
                    TAG: function (T) {
                        var o = T.replace(rn, Jt).toLowerCase();
                        return T === "*" ? function () {
                            return !0
                        } : function (s) {
                            return _e(s, o)
                        }
                    }, CLASS: function (T) {
                        var o = ne[T + " "];
                        return o || (o = new RegExp("(^|" + Ie + ")" + T + "(" + Ie + "|$)")) && ne(T, function (s) {
                            return o.test(typeof s.className == "string" && s.className || typeof s.getAttribute != "undefined" && s.getAttribute("class") || "")
                        })
                    }, ATTR: function (T, o, s) {
                        return function (u) {
                            var a = Oe.attr(u, T);
                            return a == null ? o === "!=" : o ? (a += "", o === "=" ? a === s : o === "!=" ? a !== s : o === "^=" ? s && a.indexOf(s) === 0 : o === "*=" ? s && a.indexOf(s) > -1 : o === "$=" ? s && a.slice(-s.length) === s : o === "~=" ? (" " + a.replace(Z, " ") + " ").indexOf(s) > -1 : o === "|=" ? a === s || a.slice(0, s.length + 1) === s + "-" : !1) : !0
                        }
                    }, CHILD: function (T, o, s, u, a) {
                        var c = T.slice(0, 3) !== "nth", g = T.slice(-4) !== "last", E = o === "of-type";
                        return u === 1 && a === 0 ? function (L) {
                            return !!L.parentNode
                        } : function (L, W, j) {
                            var X, ue, se, me, ze, rt = c !== g ? "nextSibling" : "previousSibling", Xe = L.parentNode,
                                pt = E && L.nodeName.toLowerCase(), Vt = !j && !E, pe = !1;
                            if (Xe) {
                                if (c) {
                                    for (; rt;) {
                                        for (se = L; se = se[rt];) if (E ? _e(se, pt) : se.nodeType === 1) return !1;
                                        ze = rt = T === "only" && !ze && "nextSibling"
                                    }
                                    return !0
                                }
                                if (ze = [g ? Xe.firstChild : Xe.lastChild], g && Vt) {
                                    for (ue = Xe[U] || (Xe[U] = {}), X = ue[T] || [], me = X[0] === q && X[1], pe = me && X[2], se = me && Xe.childNodes[me]; se = ++me && se && se[rt] || (pe = me = 0) || ze.pop();) if (se.nodeType === 1 && ++pe && se === L) {
                                        ue[T] = [q, me, pe];
                                        break
                                    }
                                } else if (Vt && (ue = L[U] || (L[U] = {}), X = ue[T] || [], me = X[0] === q && X[1], pe = me), pe === !1) for (; (se = ++me && se && se[rt] || (pe = me = 0) || ze.pop()) && !((E ? _e(se, pt) : se.nodeType === 1) && ++pe && (Vt && (ue = se[U] || (se[U] = {}), ue[T] = [q, pe]), se === L));) ;
                                return pe -= a, pe === u || pe % u === 0 && pe / u >= 0
                            }
                        }
                    }, PSEUDO: function (T, o) {
                        var s,
                            u = i.pseudos[T] || i.setFilters[T.toLowerCase()] || Oe.error("unsupported pseudo: " + T);
                        return u[U] ? u(o) : u.length > 1 ? (s = [T, T, "", o], i.setFilters.hasOwnProperty(T.toLowerCase()) ? nt(function (a, c) {
                            for (var g, E = u(a, o), L = E.length; L--;) g = B.call(a, E[L]), a[g] = !(c[g] = E[L])
                        }) : function (a) {
                            return u(a, 0, s)
                        }) : u
                    }
                },
                pseudos: {
                    not: nt(function (T) {
                        var o = [], s = [], u = $r(T.replace(Ft, "$1"));
                        return u[U] ? nt(function (a, c, g, E) {
                            for (var L, W = u(a, null, E, []), j = a.length; j--;) (L = W[j]) && (a[j] = !(c[j] = L))
                        }) : function (a, c, g) {
                            return o[0] = a, u(o, null, g, s), o[0] = null, !s.pop()
                        }
                    }), has: nt(function (T) {
                        return function (o) {
                            return Oe(T, o).length > 0
                        }
                    }), contains: nt(function (T) {
                        return T = T.replace(rn, Jt), function (o) {
                            return (o.textContent || p.text(o)).indexOf(T) > -1
                        }
                    }), lang: nt(function (T) {
                        return Nn.test(T || "") || Oe.error("unsupported lang: " + T), T = T.replace(rn, Jt).toLowerCase(), function (o) {
                            var s;
                            do if (s = k ? o.lang : o.getAttribute("xml:lang") || o.getAttribute("lang")) return s = s.toLowerCase(), s === T || s.indexOf(T + "-") === 0; while ((o = o.parentNode) && o.nodeType === 1);
                            return !1
                        }
                    }), target: function (T) {
                        var o = m.location && m.location.hash;
                        return o && o.slice(1) === T.id
                    }, root: function (T) {
                        return T === P
                    }, focus: function (T) {
                        return T === vr() && b.hasFocus() && !!(T.type || T.href || ~T.tabIndex)
                    }, enabled: mi(!1), disabled: mi(!0), checked: function (T) {
                        return _e(T, "input") && !!T.checked || _e(T, "option") && !!T.selected
                    }, selected: function (T) {
                        return T.parentNode && T.parentNode.selectedIndex, T.selected === !0
                    }, empty: function (T) {
                        for (T = T.firstChild; T; T = T.nextSibling) if (T.nodeType < 6) return !1;
                        return !0
                    }, parent: function (T) {
                        return !i.pseudos.empty(T)
                    }, header: function (T) {
                        return bn.test(T.nodeName)
                    }, input: function (T) {
                        return Gt.test(T.nodeName)
                    }, button: function (T) {
                        return _e(T, "input") && T.type === "button" || _e(T, "button")
                    }, text: function (T) {
                        var o;
                        return _e(T, "input") && T.type === "text" && ((o = T.getAttribute("type")) == null || o.toLowerCase() === "text")
                    }, first: At(function () {
                        return [0]
                    }), last: At(function (T, o) {
                        return [o - 1]
                    }), eq: At(function (T, o, s) {
                        return [s < 0 ? s + o : s]
                    }), even: At(function (T, o) {
                        for (var s = 0; s < o; s += 2) T.push(s);
                        return T
                    }), odd: At(function (T, o) {
                        for (var s = 1; s < o; s += 2) T.push(s);
                        return T
                    }), lt: At(function (T, o, s) {
                        var u;
                        for (s < 0 ? u = s + o : s > o ? u = o : u = s; --u >= 0;) T.push(u);
                        return T
                    }), gt: At(function (T, o, s) {
                        for (var u = s < 0 ? s + o : s; ++u < o;) T.push(u);
                        return T
                    })
                }
            }, i.pseudos.nth = i.pseudos.eq;
            for (n in {radio: !0, checkbox: !0, file: !0, password: !0, image: !0}) i.pseudos[n] = Uo(n);
            for (n in {submit: !0, reset: !0}) i.pseudos[n] = Bo(n);

            function Fr() {
            }

            Fr.prototype = i.filters = i.pseudos, i.setFilters = new Fr;

            function Qn(T, o) {
                var s, u, a, c, g, E, L, W = ve[T + " "];
                if (W) return o ? 0 : W.slice(0);
                for (g = T, E = [], L = i.preFilter; g;) {
                    (!s || (u = Le.exec(g))) && (u && (g = g.slice(u[0].length) || g), E.push(a = [])), s = !1, (u = mn.exec(g)) && (s = u.shift(), a.push({
                        value: s,
                        type: u[0].replace(Ft, " ")
                    }), g = g.slice(s.length));
                    for (c in i.filter) (u = Tt[c].exec(g)) && (!L[c] || (u = L[c](u))) && (s = u.shift(), a.push({
                        value: s,
                        type: c,
                        matches: u
                    }), g = g.slice(s.length));
                    if (!s) break
                }
                return o ? g.length : g ? Oe.error(T) : ve(T, E).slice(0)
            }

            function Mt(T) {
                for (var o = 0, s = T.length, u = ""; o < s; o++) u += T[o].value;
                return u
            }

            function Dn(T, o, s) {
                var u = o.dir, a = o.next, c = a || u, g = s && c === "parentNode", E = K++;
                return o.first ? function (L, W, j) {
                    for (; L = L[u];) if (L.nodeType === 1 || g) return T(L, W, j);
                    return !1
                } : function (L, W, j) {
                    var X, ue, se = [q, E];
                    if (j) {
                        for (; L = L[u];) if ((L.nodeType === 1 || g) && T(L, W, j)) return !0
                    } else for (; L = L[u];) if (L.nodeType === 1 || g) if (ue = L[U] || (L[U] = {}), a && _e(L, a)) L = L[u] || L; else {
                        if ((X = ue[c]) && X[0] === q && X[1] === E) return se[2] = X[2];
                        if (ue[c] = se, se[2] = T(L, W, j)) return !0
                    }
                    return !1
                }
            }

            function wi(T) {
                return T.length > 1 ? function (o, s, u) {
                    for (var a = T.length; a--;) if (!T[a](o, s, u)) return !1;
                    return !0
                } : T[0]
            }

            function Fo(T, o, s) {
                for (var u = 0, a = o.length; u < a; u++) Oe(T, o[u], s);
                return s
            }

            function Wr(T, o, s, u, a) {
                for (var c, g = [], E = 0, L = T.length, W = o != null; E < L; E++) (c = T[E]) && (!s || s(c, u, a)) && (g.push(c), W && o.push(E));
                return g
            }

            function xn(T, o, s, u, a, c) {
                return u && !u[U] && (u = xn(u)), a && !a[U] && (a = xn(a, c)), nt(function (g, E, L, W) {
                    var j, X, ue, se, me = [], ze = [], rt = E.length, Xe = g || Fo(o || "*", L.nodeType ? [L] : L, []),
                        pt = T && (g || !o) ? Wr(Xe, me, T, L, W) : Xe;
                    if (s ? (se = a || (g ? T : rt || u) ? [] : E, s(pt, se, L, W)) : se = pt, u) for (j = Wr(se, ze), u(j, [], L, W), X = j.length; X--;) (ue = j[X]) && (se[ze[X]] = !(pt[ze[X]] = ue));
                    if (g) {
                        if (a || T) {
                            if (a) {
                                for (j = [], X = se.length; X--;) (ue = se[X]) && j.push(pt[X] = ue);
                                a(null, se = [], j, W)
                            }
                            for (X = se.length; X--;) (ue = se[X]) && (j = a ? B.call(g, ue) : me[X]) > -1 && (g[j] = !(E[j] = ue))
                        }
                    } else se = Wr(se === E ? se.splice(rt, se.length) : se), a ? a(null, E, se, W) : y.apply(E, se)
                })
            }

            function ht(T) {
                for (var o, s, u, a = T.length, c = i.relative[T[0].type], g = c || i.relative[" "], E = c ? 1 : 0, L = Dn(function (X) {
                    return X === o
                }, g, !0), W = Dn(function (X) {
                    return B.call(o, X) > -1
                }, g, !0), j = [function (X, ue, se) {
                    var me = !c && (se || ue != f) || ((o = ue).nodeType ? L(X, ue, se) : W(X, ue, se));
                    return o = null, me
                }]; E < a; E++) if (s = i.relative[T[E].type]) j = [Dn(wi(j), s)]; else {
                    if (s = i.filter[T[E].type].apply(null, T[E].matches), s[U]) {
                        for (u = ++E; u < a && !i.relative[T[u].type]; u++) ;
                        return xn(E > 1 && wi(j), E > 1 && Mt(T.slice(0, E - 1).concat({value: T[E - 2].type === " " ? "*" : ""})).replace(Ft, "$1"), s, E < u && ht(T.slice(E, u)), u < a && ht(T = T.slice(u)), u < a && Mt(T))
                    }
                    j.push(s)
                }
                return wi(j)
            }

            function uo(T, o) {
                var s = o.length > 0, u = T.length > 0, a = function (c, g, E, L, W) {
                    var j, X, ue, se = 0, me = "0", ze = c && [], rt = [], Xe = f, pt = c || u && i.find.TAG("*", W),
                        Vt = q += Xe == null ? 1 : Math.random() || .1, pe = pt.length;
                    for (W && (f = g == b || g || W); me !== pe && (j = pt[me]) != null; me++) {
                        if (u && j) {
                            for (X = 0, !g && j.ownerDocument != b && (wn(j), E = !k); ue = T[X++];) if (ue(j, g || b, E)) {
                                y.call(L, j);
                                break
                            }
                            W && (q = Vt)
                        }
                        s && ((j = !ue && j) && se--, c && ze.push(j))
                    }
                    if (se += me, s && me !== se) {
                        for (X = 0; ue = o[X++];) ue(ze, rt, g, E);
                        if (c) {
                            if (se > 0) for (; me--;) ze[me] || rt[me] || (rt[me] = Bt.call(L));
                            rt = Wr(rt)
                        }
                        y.apply(L, rt), W && !c && rt.length > 0 && se + o.length > 1 && p.uniqueSort(L)
                    }
                    return W && (q = Vt, f = Xe), ze
                };
                return s ? nt(a) : a
            }

            function $r(T, o) {
                var s, u = [], a = [], c = ge[T + " "];
                if (!c) {
                    for (o || (o = Qn(T)), s = o.length; s--;) c = ht(o[s]), c[U] ? u.push(c) : a.push(c);
                    c = ge(T, uo(a, u)), c.selector = T
                }
                return c
            }

            function zr(T, o, s, u) {
                var a, c, g, E, L, W = typeof T == "function" && T, j = !u && Qn(T = W.selector || T);
                if (s = s || [], j.length === 1) {
                    if (c = j[0] = j[0].slice(0), c.length > 2 && (g = c[0]).type === "ID" && o.nodeType === 9 && k && i.relative[c[1].type]) {
                        if (o = (i.find.ID(g.matches[0].replace(rn, Jt), o) || [])[0], o) W && (o = o.parentNode); else return s;
                        T = T.slice(c.shift().value.length)
                    }
                    for (a = Tt.needsContext.test(T) ? 0 : c.length; a-- && (g = c[a], !i.relative[E = g.type]);) if ((L = i.find[E]) && (u = L(g.matches[0].replace(rn, Jt), gr.test(c[0].type) && bi(o.parentNode) || o))) {
                        if (c.splice(a, 1), T = u.length && Mt(c), !T) return y.apply(s, u), s;
                        break
                    }
                }
                return (W || $r(T, j))(u, o, !k, s, !o || gr.test(T) && bi(o.parentNode) || o), s
            }

            Q.sortStable = U.split("").sort(Ue).join("") === U, wn(), Q.sortDetached = Yn(function (T) {
                return T.compareDocumentPosition(b.createElement("fieldset")) & 1
            }), p.find = Oe, p.expr[":"] = p.expr.pseudos, p.unique = p.uniqueSort, Oe.compile = $r, Oe.select = zr, Oe.setDocument = wn, Oe.tokenize = Qn, Oe.escape = p.escapeSelector, Oe.getText = p.text, Oe.isXML = p.isXMLDoc, Oe.selectors = p.expr, Oe.support = p.support, Oe.uniqueSort = p.uniqueSort
        })();
        var Un = function (n, i, f) {
            for (var l = [], v = f !== void 0; (n = n[i]) && n.nodeType !== 9;) if (n.nodeType === 1) {
                if (v && p(n).is(f)) break;
                l.push(n)
            }
            return l
        }, rr = function (n, i) {
            for (var f = []; n; n = n.nextSibling) n.nodeType === 1 && n !== i && f.push(n);
            return f
        }, _t = p.expr.match.needsContext, Yr = /^<([a-z][^\/\0>:\x20\t\r\n\f]*)[\x20\t\r\n\f]*\/?>(?:<\/\1>|)$/i;

        function Qr(n, i, f) {
            return J(i) ? p.grep(n, function (l, v) {
                return !!i.call(l, v, l) !== f
            }) : i.nodeType ? p.grep(n, function (l) {
                return l === i !== f
            }) : typeof i != "string" ? p.grep(n, function (l) {
                return B.call(i, l) > -1 !== f
            }) : p.filter(i, n, f)
        }

        p.filter = function (n, i, f) {
            var l = i[0];
            return f && (n = ":not(" + n + ")"), i.length === 1 && l.nodeType === 1 ? p.find.matchesSelector(l, n) ? [l] : [] : p.find.matches(n, p.grep(i, function (v) {
                return v.nodeType === 1
            }))
        }, p.fn.extend({
            find: function (n) {
                var i, f, l = this.length, v = this;
                if (typeof n != "string") return this.pushStack(p(n).filter(function () {
                    for (i = 0; i < l; i++) if (p.contains(v[i], this)) return !0
                }));
                for (f = this.pushStack([]), i = 0; i < l; i++) p.find(n, v[i], f);
                return l > 1 ? p.uniqueSort(f) : f
            }, filter: function (n) {
                return this.pushStack(Qr(this, n || [], !1))
            }, not: function (n) {
                return this.pushStack(Qr(this, n || [], !0))
            }, is: function (n) {
                return !!Qr(this, typeof n == "string" && _t.test(n) ? p(n) : n || [], !1).length
            }
        });
        var Ni, mt = /^(?:\s*(<[\w\W]+>)[^>]*|#([\w-]+))$/, Or = p.fn.init = function (n, i, f) {
            var l, v;
            if (!n) return this;
            if (f = f || Ni, typeof n == "string") if (n[0] === "<" && n[n.length - 1] === ">" && n.length >= 3 ? l = [null, n, null] : l = mt.exec(n), l && (l[1] || !i)) if (l[1]) {
                if (i = i instanceof p ? i[0] : i, p.merge(this, p.parseHTML(l[1], i && i.nodeType ? i.ownerDocument || i : F, !0)), Yr.test(l[1]) && p.isPlainObject(i)) for (l in i) J(this[l]) ? this[l](i[l]) : this.attr(l, i[l]);
                return this
            } else return v = F.getElementById(l[2]), v && (this[0] = v, this.length = 1), this; else return !i || i.jquery ? (i || f).find(n) : this.constructor(i).find(n); else {
                if (n.nodeType) return this[0] = n, this.length = 1, this;
                if (J(n)) return f.ready !== void 0 ? f.ready(n) : n(p)
            }
            return p.makeArray(n, this)
        };
        Or.prototype = p.fn, Ni = p(F);
        var Ao = /^(?:parents|prev(?:Until|All))/, Be = {children: !0, contents: !0, next: !0, prev: !0};
        p.fn.extend({
            has: function (n) {
                var i = p(n, this), f = i.length;
                return this.filter(function () {
                    for (var l = 0; l < f; l++) if (p.contains(this, i[l])) return !0
                })
            }, closest: function (n, i) {
                var f, l = 0, v = this.length, y = [], b = typeof n != "string" && p(n);
                if (!_t.test(n)) {
                    for (; l < v; l++) for (f = this[l]; f && f !== i; f = f.parentNode) if (f.nodeType < 11 && (b ? b.index(f) > -1 : f.nodeType === 1 && p.find.matchesSelector(f, n))) {
                        y.push(f);
                        break
                    }
                }
                return this.pushStack(y.length > 1 ? p.uniqueSort(y) : y)
            }, index: function (n) {
                return n ? typeof n == "string" ? B.call(p(n), this[0]) : B.call(this, n.jquery ? n[0] : n) : this[0] && this[0].parentNode ? this.first().prevAll().length : -1
            }, add: function (n, i) {
                return this.pushStack(p.uniqueSort(p.merge(this.get(), p(n, i))))
            }, addBack: function (n) {
                return this.add(n == null ? this.prevObject : this.prevObject.filter(n))
            }
        });

        function We(n, i) {
            for (; (n = n[i]) && n.nodeType !== 1;) ;
            return n
        }

        p.each({
            parent: function (n) {
                var i = n.parentNode;
                return i && i.nodeType !== 11 ? i : null
            }, parents: function (n) {
                return Un(n, "parentNode")
            }, parentsUntil: function (n, i, f) {
                return Un(n, "parentNode", f)
            }, next: function (n) {
                return We(n, "nextSibling")
            }, prev: function (n) {
                return We(n, "previousSibling")
            }, nextAll: function (n) {
                return Un(n, "nextSibling")
            }, prevAll: function (n) {
                return Un(n, "previousSibling")
            }, nextUntil: function (n, i, f) {
                return Un(n, "nextSibling", f)
            }, prevUntil: function (n, i, f) {
                return Un(n, "previousSibling", f)
            }, siblings: function (n) {
                return rr((n.parentNode || {}).firstChild, n)
            }, children: function (n) {
                return rr(n.firstChild)
            }, contents: function (n) {
                return n.contentDocument != null && S(n.contentDocument) ? n.contentDocument : (_e(n, "template") && (n = n.content || n), p.merge([], n.childNodes))
            }
        }, function (n, i) {
            p.fn[n] = function (f, l) {
                var v = p.map(this, i, f);
                return n.slice(-5) !== "Until" && (l = f), l && typeof l == "string" && (v = p.filter(l, v)), this.length > 1 && (Be[n] || p.uniqueSort(v), Ao.test(n) && v.reverse()), this.pushStack(v)
            }
        });
        var $t = /[^\x20\t\r\n\f]+/g;

        function ir(n) {
            var i = {};
            return p.each(n.match($t) || [], function (f, l) {
                i[l] = !0
            }), i
        }

        p.Callbacks = function (n) {
            n = typeof n == "string" ? ir(n) : p.extend({}, n);
            var i, f, l, v, y = [], b = [], P = -1, k = function () {
                for (v = v || n.once, l = i = !0; b.length; P = -1) for (f = b.shift(); ++P < y.length;) y[P].apply(f[0], f[1]) === !1 && n.stopOnFalse && (P = y.length, f = !1);
                n.memory || (f = !1), i = !1, v && (f ? y = [] : y = "")
            }, N = {
                add: function () {
                    return y && (f && !i && (P = y.length - 1, b.push(f)), function H(U) {
                        p.each(U, function (q, K) {
                            J(K) ? (!n.unique || !N.has(K)) && y.push(K) : K && K.length && Ne(K) !== "string" && H(K)
                        })
                    }(arguments), f && !i && k()), this
                }, remove: function () {
                    return p.each(arguments, function (H, U) {
                        for (var q; (q = p.inArray(U, y, q)) > -1;) y.splice(q, 1), q <= P && P--
                    }), this
                }, has: function (H) {
                    return H ? p.inArray(H, y) > -1 : y.length > 0
                }, empty: function () {
                    return y && (y = []), this
                }, disable: function () {
                    return v = b = [], y = f = "", this
                }, disabled: function () {
                    return !y
                }, lock: function () {
                    return v = b = [], !f && !i && (y = f = ""), this
                }, locked: function () {
                    return !!v
                }, fireWith: function (H, U) {
                    return v || (U = U || [], U = [H, U.slice ? U.slice() : U], b.push(U), i || k()), this
                }, fire: function () {
                    return N.fireWith(this, arguments), this
                }, fired: function () {
                    return !!l
                }
            };
            return N
        };

        function Je(n) {
            return n
        }

        function Bn(n) {
            throw n
        }

        function bt(n, i, f, l) {
            var v;
            try {
                n && J(v = n.promise) ? v.call(n).done(i).fail(f) : n && J(v = n.then) ? v.call(n, i, f) : i.apply(void 0, [n].slice(l))
            } catch (y) {
                f.apply(void 0, [y])
            }
        }

        p.extend({
            Deferred: function (n) {
                var i = [["notify", "progress", p.Callbacks("memory"), p.Callbacks("memory"), 2], ["resolve", "done", p.Callbacks("once memory"), p.Callbacks("once memory"), 0, "resolved"], ["reject", "fail", p.Callbacks("once memory"), p.Callbacks("once memory"), 1, "rejected"]],
                    f = "pending", l = {
                        state: function () {
                            return f
                        }, always: function () {
                            return v.done(arguments).fail(arguments), this
                        }, catch: function (y) {
                            return l.then(null, y)
                        }, pipe: function () {
                            var y = arguments;
                            return p.Deferred(function (b) {
                                p.each(i, function (P, k) {
                                    var N = J(y[k[4]]) && y[k[4]];
                                    v[k[1]](function () {
                                        var H = N && N.apply(this, arguments);
                                        H && J(H.promise) ? H.promise().progress(b.notify).done(b.resolve).fail(b.reject) : b[k[0] + "With"](this, N ? [H] : arguments)
                                    })
                                }), y = null
                            }).promise()
                        }, then: function (y, b, P) {
                            var k = 0;

                            function N(H, U, q, K) {
                                return function () {
                                    var ne = this, ve = arguments, ge = function () {
                                        var Ue, Xt;
                                        if (!(H < k)) {
                                            if (Ue = q.apply(ne, ve), Ue === U.promise()) throw new TypeError("Thenable self-resolution");
                                            Xt = Ue && (typeof Ue == "object" || typeof Ue == "function") && Ue.then, J(Xt) ? K ? Xt.call(Ue, N(k, U, Je, K), N(k, U, Bn, K)) : (k++, Xt.call(Ue, N(k, U, Je, K), N(k, U, Bn, K), N(k, U, Je, U.notifyWith))) : (q !== Je && (ne = void 0, ve = [Ue]), (K || U.resolveWith)(ne, ve))
                                        }
                                    }, Ye = K ? ge : function () {
                                        try {
                                            ge()
                                        } catch (Ue) {
                                            p.Deferred.exceptionHook && p.Deferred.exceptionHook(Ue, Ye.error), H + 1 >= k && (q !== Bn && (ne = void 0, ve = [Ue]), U.rejectWith(ne, ve))
                                        }
                                    };
                                    H ? Ye() : (p.Deferred.getErrorHook ? Ye.error = p.Deferred.getErrorHook() : p.Deferred.getStackHook && (Ye.error = p.Deferred.getStackHook()), m.setTimeout(Ye))
                                }
                            }

                            return p.Deferred(function (H) {
                                i[0][3].add(N(0, H, J(P) ? P : Je, H.notifyWith)), i[1][3].add(N(0, H, J(y) ? y : Je)), i[2][3].add(N(0, H, J(b) ? b : Bn))
                            }).promise()
                        }, promise: function (y) {
                            return y != null ? p.extend(y, l) : l
                        }
                    }, v = {};
                return p.each(i, function (y, b) {
                    var P = b[2], k = b[5];
                    l[b[1]] = P.add, k && P.add(function () {
                        f = k
                    }, i[3 - y][2].disable, i[3 - y][3].disable, i[0][2].lock, i[0][3].lock), P.add(b[3].fire), v[b[0]] = function () {
                        return v[b[0] + "With"](this === v ? void 0 : this, arguments), this
                    }, v[b[0] + "With"] = P.fireWith
                }), l.promise(v), n && n.call(v, v), v
            }, when: function (n) {
                var i = arguments.length, f = i, l = Array(f), v = I.call(arguments), y = p.Deferred(),
                    b = function (P) {
                        return function (k) {
                            l[P] = this, v[P] = arguments.length > 1 ? I.call(arguments) : k, --i || y.resolveWith(l, v)
                        }
                    };
                if (i <= 1 && (bt(n, y.done(b(f)).resolve, y.reject, !i), y.state() === "pending" || J(v[f] && v[f].then))) return y.then();
                for (; f--;) bt(v[f], b(f), y.reject);
                return y.promise()
            }
        });
        var en = /^(Eval|Internal|Range|Reference|Syntax|Type|URI)Error$/;
        p.Deferred.exceptionHook = function (n, i) {
            m.console && m.console.warn && n && en.test(n.name) && m.console.warn("jQuery.Deferred exception: " + n.message, n.stack, i)
        }, p.readyException = function (n) {
            m.setTimeout(function () {
                throw n
            })
        };
        var Pr = p.Deferred();
        p.fn.ready = function (n) {
            return Pr.then(n).catch(function (i) {
                p.readyException(i)
            }), this
        }, p.extend({
            isReady: !1, readyWait: 1, ready: function (n) {
                (n === !0 ? --p.readyWait : p.isReady) || (p.isReady = !0, !(n !== !0 && --p.readyWait > 0) && Pr.resolveWith(F, [p]))
            }
        }), p.ready.then = Pr.then;

        function wt() {
            F.removeEventListener("DOMContentLoaded", wt), m.removeEventListener("load", wt), p.ready()
        }

        F.readyState === "complete" || F.readyState !== "loading" && !F.documentElement.doScroll ? m.setTimeout(p.ready) : (F.addEventListener("DOMContentLoaded", wt), m.addEventListener("load", wt));
        var Pt = function (n, i, f, l, v, y, b) {
            var P = 0, k = n.length, N = f == null;
            if (Ne(f) === "object") {
                v = !0;
                for (P in f) Pt(n, i, P, f[P], !0, y, b)
            } else if (l !== void 0 && (v = !0, J(l) || (b = !0), N && (b ? (i.call(n, l), i = null) : (N = i, i = function (H, U, q) {
                return N.call(p(H), q)
            })), i)) for (; P < k; P++) i(n[P], f, b ? l : l.call(n[P], P, i(n[P], f)));
            return v ? n : N ? i.call(n) : k ? i(n[0], f) : y
        }, Di = /^-ms-/, or = /-([a-z])/g;

        function xt(n, i) {
            return i.toUpperCase()
        }

        function st(n) {
            return n.replace(Di, "ms-").replace(or, xt)
        }

        var hn = function (n) {
            return n.nodeType === 1 || n.nodeType === 9 || !+n.nodeType
        };

        function sr() {
            this.expando = p.expando + sr.uid++
        }

        sr.uid = 1, sr.prototype = {
            cache: function (n) {
                var i = n[this.expando];
                return i || (i = {}, hn(n) && (n.nodeType ? n[this.expando] = i : Object.defineProperty(n, this.expando, {
                    value: i,
                    configurable: !0
                }))), i
            }, set: function (n, i, f) {
                var l, v = this.cache(n);
                if (typeof i == "string") v[st(i)] = f; else for (l in i) v[st(l)] = i[l];
                return v
            }, get: function (n, i) {
                return i === void 0 ? this.cache(n) : n[this.expando] && n[this.expando][st(i)]
            }, access: function (n, i, f) {
                return i === void 0 || i && typeof i == "string" && f === void 0 ? this.get(n, i) : (this.set(n, i, f), f !== void 0 ? f : i)
            }, remove: function (n, i) {
                var f, l = n[this.expando];
                if (l !== void 0) {
                    if (i !== void 0) for (Array.isArray(i) ? i = i.map(st) : (i = st(i), i = i in l ? [i] : i.match($t) || []), f = i.length; f--;) delete l[i[f]];
                    (i === void 0 || p.isEmptyObject(l)) && (n.nodeType ? n[this.expando] = void 0 : delete n[this.expando])
                }
            }, hasData: function (n) {
                var i = n[this.expando];
                return i !== void 0 && !p.isEmptyObject(i)
            }
        };
        var oe = new sr, Ve = new sr, ur = /^(?:\{[\w\W]*\}|\[[\w\W]*\])$/, Pe = /[A-Z]/g;

        function Zr(n) {
            return n === "true" ? !0 : n === "false" ? !1 : n === "null" ? null : n === +n + "" ? +n : ur.test(n) ? JSON.parse(n) : n
        }

        function Rr(n, i, f) {
            var l;
            if (f === void 0 && n.nodeType === 1) if (l = "data-" + i.replace(Pe, "-$&").toLowerCase(), f = n.getAttribute(l), typeof f == "string") {
                try {
                    f = Zr(f)
                } catch {
                }
                Ve.set(n, i, f)
            } else f = void 0;
            return f
        }

        p.extend({
            hasData: function (n) {
                return Ve.hasData(n) || oe.hasData(n)
            }, data: function (n, i, f) {
                return Ve.access(n, i, f)
            }, removeData: function (n, i) {
                Ve.remove(n, i)
            }, _data: function (n, i, f) {
                return oe.access(n, i, f)
            }, _removeData: function (n, i) {
                oe.remove(n, i)
            }
        }), p.fn.extend({
            data: function (n, i) {
                var f, l, v, y = this[0], b = y && y.attributes;
                if (n === void 0) {
                    if (this.length && (v = Ve.get(y), y.nodeType === 1 && !oe.get(y, "hasDataAttrs"))) {
                        for (f = b.length; f--;) b[f] && (l = b[f].name, l.indexOf("data-") === 0 && (l = st(l.slice(5)), Rr(y, l, v[l])));
                        oe.set(y, "hasDataAttrs", !0)
                    }
                    return v
                }
                return typeof n == "object" ? this.each(function () {
                    Ve.set(this, n)
                }) : Pt(this, function (P) {
                    var k;
                    if (y && P === void 0) return k = Ve.get(y, n), k !== void 0 || (k = Rr(y, n), k !== void 0) ? k : void 0;
                    this.each(function () {
                        Ve.set(this, n, P)
                    })
                }, null, i, arguments.length > 1, null, !0)
            }, removeData: function (n) {
                return this.each(function () {
                    Ve.remove(this, n)
                })
            }
        }), p.extend({
            queue: function (n, i, f) {
                var l;
                if (n) return i = (i || "fx") + "queue", l = oe.get(n, i), f && (!l || Array.isArray(f) ? l = oe.access(n, i, p.makeArray(f)) : l.push(f)), l || []
            }, dequeue: function (n, i) {
                i = i || "fx";
                var f = p.queue(n, i), l = f.length, v = f.shift(), y = p._queueHooks(n, i), b = function () {
                    p.dequeue(n, i)
                };
                v === "inprogress" && (v = f.shift(), l--), v && (i === "fx" && f.unshift("inprogress"), delete y.stop, v.call(n, b, y)), !l && y && y.empty.fire()
            }, _queueHooks: function (n, i) {
                var f = i + "queueHooks";
                return oe.get(n, f) || oe.access(n, f, {
                    empty: p.Callbacks("once memory").add(function () {
                        oe.remove(n, [i + "queue", f])
                    })
                })
            }
        }), p.fn.extend({
            queue: function (n, i) {
                var f = 2;
                return typeof n != "string" && (i = n, n = "fx", f--), arguments.length < f ? p.queue(this[0], n) : i === void 0 ? this : this.each(function () {
                    var l = p.queue(this, n, i);
                    p._queueHooks(this, n), n === "fx" && l[0] !== "inprogress" && p.dequeue(this, n)
                })
            }, dequeue: function (n) {
                return this.each(function () {
                    p.dequeue(this, n)
                })
            }, clearQueue: function (n) {
                return this.queue(n || "fx", [])
            }, promise: function (n, i) {
                var f, l = 1, v = p.Deferred(), y = this, b = this.length, P = function () {
                    --l || v.resolveWith(y, [y])
                };
                for (typeof n != "string" && (i = n, n = void 0), n = n || "fx"; b--;) f = oe.get(y[b], n + "queueHooks"), f && f.empty && (l++, f.empty.add(P));
                return P(), v.promise(i)
            }
        });
        var Lr = /[+-]?(?:\d*\.|)\d+(?:[eE][+-]?\d+|)/.source,
            kn = new RegExp("^(?:([+-])=|)(" + Lr + ")([a-z%]*)$", "i"), Rt = ["Top", "Right", "Bottom", "Left"],
            tn = F.documentElement, pn = function (n) {
                return p.contains(n.ownerDocument, n)
            }, ei = {composed: !0};
        tn.getRootNode && (pn = function (n) {
            return p.contains(n.ownerDocument, n) || n.getRootNode(ei) === n.ownerDocument
        });
        var Fn = function (n, i) {
            return n = i || n, n.style.display === "none" || n.style.display === "" && pn(n) && p.css(n, "display") === "none"
        };

        function Ir(n, i, f, l) {
            var v, y, b = 20, P = l ? function () {
                    return l.cur()
                } : function () {
                    return p.css(n, i, "")
                }, k = P(), N = f && f[3] || (p.cssNumber[i] ? "" : "px"),
                H = n.nodeType && (p.cssNumber[i] || N !== "px" && +k) && kn.exec(p.css(n, i));
            if (H && H[3] !== N) {
                for (k = k / 2, N = N || H[3], H = +k || 1; b--;) p.style(n, i, H + N), (1 - y) * (1 - (y = P() / k || .5)) <= 0 && (b = 0), H = H / y;
                H = H * 2, p.style(n, i, H + N), f = f || []
            }
            return f && (H = +H || +k || 0, v = f[1] ? H + (f[1] + 1) * f[2] : +f[2], l && (l.unit = N, l.start = H, l.end = v)), v
        }

        var Nr = {};

        function Eo(n) {
            var i, f = n.ownerDocument, l = n.nodeName, v = Nr[l];
            return v || (i = f.body.appendChild(f.createElement(l)), v = p.css(i, "display"), i.parentNode.removeChild(i), v === "none" && (v = "block"), Nr[l] = v, v)
        }

        function On(n, i) {
            for (var f, l, v = [], y = 0, b = n.length; y < b; y++) l = n[y], l.style && (f = l.style.display, i ? (f === "none" && (v[y] = oe.get(l, "display") || null, v[y] || (l.style.display = "")), l.style.display === "" && Fn(l) && (v[y] = Eo(l))) : f !== "none" && (v[y] = "none", oe.set(l, "display", f)));
            for (y = 0; y < b; y++) v[y] != null && (n[y].style.display = v[y]);
            return n
        }

        p.fn.extend({
            show: function () {
                return On(this, !0)
            }, hide: function () {
                return On(this)
            }, toggle: function (n) {
                return typeof n == "boolean" ? n ? this.show() : this.hide() : this.each(function () {
                    Fn(this) ? p(this).show() : p(this).hide()
                })
            }
        });
        var Wn = /^(?:checkbox|radio)$/i, Mi = /<([a-z][^\/\0>\x20\t\r\n\f]*)/i,
            qi = /^$|^module$|\/(?:java|ecma)script/i;
        (function () {
            var n = F.createDocumentFragment(), i = n.appendChild(F.createElement("div")), f = F.createElement("input");
            f.setAttribute("type", "radio"), f.setAttribute("checked", "checked"), f.setAttribute("name", "t"), i.appendChild(f), Q.checkClone = i.cloneNode(!0).cloneNode(!0).lastChild.checked, i.innerHTML = "<textarea>x</textarea>", Q.noCloneChecked = !!i.cloneNode(!0).lastChild.defaultValue, i.innerHTML = "<option></option>", Q.option = !!i.lastChild
        })();
        var ut = {
            thead: [1, "<table>", "</table>"],
            col: [2, "<table><colgroup>", "</colgroup></table>"],
            tr: [2, "<table><tbody>", "</tbody></table>"],
            td: [3, "<table><tbody><tr>", "</tr></tbody></table>"],
            _default: [0, "", ""]
        };
        ut.tbody = ut.tfoot = ut.colgroup = ut.caption = ut.thead, ut.th = ut.td, Q.option || (ut.optgroup = ut.option = [1, "<select multiple='multiple'>", "</select>"]);

        function at(n, i) {
            var f;
            return typeof n.getElementsByTagName != "undefined" ? f = n.getElementsByTagName(i || "*") : typeof n.querySelectorAll != "undefined" ? f = n.querySelectorAll(i || "*") : f = [], i === void 0 || i && _e(n, i) ? p.merge([n], f) : f
        }

        function St(n, i) {
            for (var f = 0, l = n.length; f < l; f++) oe.set(n[f], "globalEval", !i || oe.get(i[f], "globalEval"))
        }

        var ko = /<|&#?\w+;/;

        function Hi(n, i, f, l, v) {
            for (var y, b, P, k, N, H, U = i.createDocumentFragment(), q = [], K = 0, ne = n.length; K < ne; K++) if (y = n[K], y || y === 0) if (Ne(y) === "object") p.merge(q, y.nodeType ? [y] : y); else if (!ko.test(y)) q.push(i.createTextNode(y)); else {
                for (b = b || U.appendChild(i.createElement("div")), P = (Mi.exec(y) || ["", ""])[1].toLowerCase(), k = ut[P] || ut._default, b.innerHTML = k[1] + p.htmlPrefilter(y) + k[2], H = k[0]; H--;) b = b.lastChild;
                p.merge(q, b.childNodes), b = U.firstChild, b.textContent = ""
            }
            for (U.textContent = "", K = 0; y = q[K++];) {
                if (l && p.inArray(y, l) > -1) {
                    v && v.push(y);
                    continue
                }
                if (N = pn(y), b = at(U.appendChild(y), "script"), N && St(b), f) for (H = 0; y = b[H++];) qi.test(y.type || "") && f.push(y)
            }
            return U
        }

        var ji = /^([^.]*)(?:\.(.+)|)/;

        function dn() {
            return !0
        }

        function Lt() {
            return !1
        }

        function ar(n, i, f, l, v, y) {
            var b, P;
            if (typeof i == "object") {
                typeof f != "string" && (l = l || f, f = void 0);
                for (P in i) ar(n, P, f, l, i[P], y);
                return n
            }
            if (l == null && v == null ? (v = f, l = f = void 0) : v == null && (typeof f == "string" ? (v = l, l = void 0) : (v = l, l = f, f = void 0)), v === !1) v = Lt; else if (!v) return n;
            return y === 1 && (b = v, v = function (k) {
                return p().off(k), b.apply(this, arguments)
            }, v.guid = b.guid || (b.guid = p.guid++)), n.each(function () {
                p.event.add(this, i, v, l, f)
            })
        }

        p.event = {
            global: {}, add: function (n, i, f, l, v) {
                var y, b, P, k, N, H, U, q, K, ne, ve, ge = oe.get(n);
                if (!!hn(n)) for (f.handler && (y = f, f = y.handler, v = y.selector), v && p.find.matchesSelector(tn, v), f.guid || (f.guid = p.guid++), (k = ge.events) || (k = ge.events = Object.create(null)), (b = ge.handle) || (b = ge.handle = function (Ye) {
                    return typeof p != "undefined" && p.event.triggered !== Ye.type ? p.event.dispatch.apply(n, arguments) : void 0
                }), i = (i || "").match($t) || [""], N = i.length; N--;) P = ji.exec(i[N]) || [], K = ve = P[1], ne = (P[2] || "").split(".").sort(), K && (U = p.event.special[K] || {}, K = (v ? U.delegateType : U.bindType) || K, U = p.event.special[K] || {}, H = p.extend({
                    type: K,
                    origType: ve,
                    data: l,
                    handler: f,
                    guid: f.guid,
                    selector: v,
                    needsContext: v && p.expr.match.needsContext.test(v),
                    namespace: ne.join(".")
                }, y), (q = k[K]) || (q = k[K] = [], q.delegateCount = 0, (!U.setup || U.setup.call(n, l, ne, b) === !1) && n.addEventListener && n.addEventListener(K, b)), U.add && (U.add.call(n, H), H.handler.guid || (H.handler.guid = f.guid)), v ? q.splice(q.delegateCount++, 0, H) : q.push(H), p.event.global[K] = !0)
            }, remove: function (n, i, f, l, v) {
                var y, b, P, k, N, H, U, q, K, ne, ve, ge = oe.hasData(n) && oe.get(n);
                if (!(!ge || !(k = ge.events))) {
                    for (i = (i || "").match($t) || [""], N = i.length; N--;) {
                        if (P = ji.exec(i[N]) || [], K = ve = P[1], ne = (P[2] || "").split(".").sort(), !K) {
                            for (K in k) p.event.remove(n, K + i[N], f, l, !0);
                            continue
                        }
                        for (U = p.event.special[K] || {}, K = (l ? U.delegateType : U.bindType) || K, q = k[K] || [], P = P[2] && new RegExp("(^|\\.)" + ne.join("\\.(?:.*\\.|)") + "(\\.|$)"), b = y = q.length; y--;) H = q[y], (v || ve === H.origType) && (!f || f.guid === H.guid) && (!P || P.test(H.namespace)) && (!l || l === H.selector || l === "**" && H.selector) && (q.splice(y, 1), H.selector && q.delegateCount--, U.remove && U.remove.call(n, H));
                        b && !q.length && ((!U.teardown || U.teardown.call(n, ne, ge.handle) === !1) && p.removeEvent(n, K, ge.handle), delete k[K])
                    }
                    p.isEmptyObject(k) && oe.remove(n, "handle events")
                }
            }, dispatch: function (n) {
                var i, f, l, v, y, b, P = new Array(arguments.length), k = p.event.fix(n),
                    N = (oe.get(this, "events") || Object.create(null))[k.type] || [],
                    H = p.event.special[k.type] || {};
                for (P[0] = k, i = 1; i < arguments.length; i++) P[i] = arguments[i];
                if (k.delegateTarget = this, !(H.preDispatch && H.preDispatch.call(this, k) === !1)) {
                    for (b = p.event.handlers.call(this, k, N), i = 0; (v = b[i++]) && !k.isPropagationStopped();) for (k.currentTarget = v.elem, f = 0; (y = v.handlers[f++]) && !k.isImmediatePropagationStopped();) (!k.rnamespace || y.namespace === !1 || k.rnamespace.test(y.namespace)) && (k.handleObj = y, k.data = y.data, l = ((p.event.special[y.origType] || {}).handle || y.handler).apply(v.elem, P), l !== void 0 && (k.result = l) === !1 && (k.preventDefault(), k.stopPropagation()));
                    return H.postDispatch && H.postDispatch.call(this, k), k.result
                }
            }, handlers: function (n, i) {
                var f, l, v, y, b, P = [], k = i.delegateCount, N = n.target;
                if (k && N.nodeType && !(n.type === "click" && n.button >= 1)) {
                    for (; N !== this; N = N.parentNode || this) if (N.nodeType === 1 && !(n.type === "click" && N.disabled === !0)) {
                        for (y = [], b = {}, f = 0; f < k; f++) l = i[f], v = l.selector + " ", b[v] === void 0 && (b[v] = l.needsContext ? p(v, this).index(N) > -1 : p.find(v, this, null, [N]).length), b[v] && y.push(l);
                        y.length && P.push({elem: N, handlers: y})
                    }
                }
                return N = this, k < i.length && P.push({elem: N, handlers: i.slice(k)}), P
            }, addProp: function (n, i) {
                Object.defineProperty(p.Event.prototype, n, {
                    enumerable: !0, configurable: !0, get: J(i) ? function () {
                        if (this.originalEvent) return i(this.originalEvent)
                    } : function () {
                        if (this.originalEvent) return this.originalEvent[n]
                    }, set: function (f) {
                        Object.defineProperty(this, n, {enumerable: !0, configurable: !0, writable: !0, value: f})
                    }
                })
            }, fix: function (n) {
                return n[p.expando] ? n : new p.Event(n)
            }, special: {
                load: {noBubble: !0}, click: {
                    setup: function (n) {
                        var i = this || n;
                        return Wn.test(i.type) && i.click && _e(i, "input") && fr(i, "click", !0), !1
                    }, trigger: function (n) {
                        var i = this || n;
                        return Wn.test(i.type) && i.click && _e(i, "input") && fr(i, "click"), !0
                    }, _default: function (n) {
                        var i = n.target;
                        return Wn.test(i.type) && i.click && _e(i, "input") && oe.get(i, "click") || _e(i, "a")
                    }
                }, beforeunload: {
                    postDispatch: function (n) {
                        n.result !== void 0 && n.originalEvent && (n.originalEvent.returnValue = n.result)
                    }
                }
            }
        };

        function fr(n, i, f) {
            if (!f) {
                oe.get(n, i) === void 0 && p.event.add(n, i, dn);
                return
            }
            oe.set(n, i, !1), p.event.add(n, i, {
                namespace: !1, handler: function (l) {
                    var v, y = oe.get(this, i);
                    if (l.isTrigger & 1 && this[i]) {
                        if (y) (p.event.special[i] || {}).delegateType && l.stopPropagation(); else if (y = I.call(arguments), oe.set(this, i, y), this[i](), v = oe.get(this, i), oe.set(this, i, !1), y !== v) return l.stopImmediatePropagation(), l.preventDefault(), v
                    } else y && (oe.set(this, i, p.event.trigger(y[0], y.slice(1), this)), l.stopPropagation(), l.isImmediatePropagationStopped = dn)
                }
            })
        }

        p.removeEvent = function (n, i, f) {
            n.removeEventListener && n.removeEventListener(i, f)
        }, p.Event = function (n, i) {
            if (!(this instanceof p.Event)) return new p.Event(n, i);
            n && n.type ? (this.originalEvent = n, this.type = n.type, this.isDefaultPrevented = n.defaultPrevented || n.defaultPrevented === void 0 && n.returnValue === !1 ? dn : Lt, this.target = n.target && n.target.nodeType === 3 ? n.target.parentNode : n.target, this.currentTarget = n.currentTarget, this.relatedTarget = n.relatedTarget) : this.type = n, i && p.extend(this, i), this.timeStamp = n && n.timeStamp || Date.now(), this[p.expando] = !0
        }, p.Event.prototype = {
            constructor: p.Event,
            isDefaultPrevented: Lt,
            isPropagationStopped: Lt,
            isImmediatePropagationStopped: Lt,
            isSimulated: !1,
            preventDefault: function () {
                var n = this.originalEvent;
                this.isDefaultPrevented = dn, n && !this.isSimulated && n.preventDefault()
            },
            stopPropagation: function () {
                var n = this.originalEvent;
                this.isPropagationStopped = dn, n && !this.isSimulated && n.stopPropagation()
            },
            stopImmediatePropagation: function () {
                var n = this.originalEvent;
                this.isImmediatePropagationStopped = dn, n && !this.isSimulated && n.stopImmediatePropagation(), this.stopPropagation()
            }
        }, p.each({
            altKey: !0,
            bubbles: !0,
            cancelable: !0,
            changedTouches: !0,
            ctrlKey: !0,
            detail: !0,
            eventPhase: !0,
            metaKey: !0,
            pageX: !0,
            pageY: !0,
            shiftKey: !0,
            view: !0,
            char: !0,
            code: !0,
            charCode: !0,
            key: !0,
            keyCode: !0,
            button: !0,
            buttons: !0,
            clientX: !0,
            clientY: !0,
            offsetX: !0,
            offsetY: !0,
            pointerId: !0,
            pointerType: !0,
            screenX: !0,
            screenY: !0,
            targetTouches: !0,
            toElement: !0,
            touches: !0,
            which: !0
        }, p.event.addProp), p.each({focus: "focusin", blur: "focusout"}, function (n, i) {
            function f(l) {
                if (F.documentMode) {
                    var v = oe.get(this, "handle"), y = p.event.fix(l);
                    y.type = l.type === "focusin" ? "focus" : "blur", y.isSimulated = !0, v(l), y.target === y.currentTarget && v(y)
                } else p.event.simulate(i, l.target, p.event.fix(l))
            }

            p.event.special[n] = {
                setup: function () {
                    var l;
                    if (fr(this, n, !0), F.documentMode) l = oe.get(this, i), l || this.addEventListener(i, f), oe.set(this, i, (l || 0) + 1); else return !1
                }, trigger: function () {
                    return fr(this, n), !0
                }, teardown: function () {
                    var l;
                    if (F.documentMode) l = oe.get(this, i) - 1, l ? oe.set(this, i, l) : (this.removeEventListener(i, f), oe.remove(this, i)); else return !1
                }, _default: function (l) {
                    return oe.get(l.target, n)
                }, delegateType: i
            }, p.event.special[i] = {
                setup: function () {
                    var l = this.ownerDocument || this.document || this, v = F.documentMode ? this : l,
                        y = oe.get(v, i);
                    y || (F.documentMode ? this.addEventListener(i, f) : l.addEventListener(n, f, !0)), oe.set(v, i, (y || 0) + 1)
                }, teardown: function () {
                    var l = this.ownerDocument || this.document || this, v = F.documentMode ? this : l,
                        y = oe.get(v, i) - 1;
                    y ? oe.set(v, i, y) : (F.documentMode ? this.removeEventListener(i, f) : l.removeEventListener(n, f, !0), oe.remove(v, i))
                }
            }
        }), p.each({
            mouseenter: "mouseover",
            mouseleave: "mouseout",
            pointerenter: "pointerover",
            pointerleave: "pointerout"
        }, function (n, i) {
            p.event.special[n] = {
                delegateType: i, bindType: i, handle: function (f) {
                    var l, v = this, y = f.relatedTarget, b = f.handleObj;
                    return (!y || y !== v && !p.contains(v, y)) && (f.type = b.origType, l = b.handler.apply(this, arguments), f.type = i), l
                }
            }
        }), p.fn.extend({
            on: function (n, i, f, l) {
                return ar(this, n, i, f, l)
            }, one: function (n, i, f, l) {
                return ar(this, n, i, f, l, 1)
            }, off: function (n, i, f) {
                var l, v;
                if (n && n.preventDefault && n.handleObj) return l = n.handleObj, p(n.delegateTarget).off(l.namespace ? l.origType + "." + l.namespace : l.origType, l.selector, l.handler), this;
                if (typeof n == "object") {
                    for (v in n) this.off(v, i, n[v]);
                    return this
                }
                return (i === !1 || typeof i == "function") && (f = i, i = void 0), f === !1 && (f = Lt), this.each(function () {
                    p.event.remove(this, n, f, i)
                })
            }
        });
        var Ui = /<script|<style|<link/i, Bi = /checked\s*(?:[^=]|=\s*.checked.)/i, Fi = /^\s*<!\[CDATA\[|\]\]>\s*$/g;

        function Wi(n, i) {
            return _e(n, "table") && _e(i.nodeType !== 11 ? i : i.firstChild, "tr") && p(n).children("tbody")[0] || n
        }

        function Oo(n) {
            return n.type = (n.getAttribute("type") !== null) + "/" + n.type, n
        }

        function Po(n) {
            return (n.type || "").slice(0, 5) === "true/" ? n.type = n.type.slice(5) : n.removeAttribute("type"), n
        }

        function cr(n, i) {
            var f, l, v, y, b, P, k;
            if (i.nodeType === 1) {
                if (oe.hasData(n) && (y = oe.get(n), k = y.events, k)) {
                    oe.remove(i, "handle events");
                    for (v in k) for (f = 0, l = k[v].length; f < l; f++) p.event.add(i, v, k[v][f])
                }
                Ve.hasData(n) && (b = Ve.access(n), P = p.extend({}, b), Ve.set(i, P))
            }
        }

        function $i(n, i) {
            var f = i.nodeName.toLowerCase();
            f === "input" && Wn.test(n.type) ? i.checked = n.checked : (f === "input" || f === "textarea") && (i.defaultValue = n.defaultValue)
        }

        function Pn(n, i, f, l) {
            i = M(i);
            var v, y, b, P, k, N, H = 0, U = n.length, q = U - 1, K = i[0], ne = J(K);
            if (ne || U > 1 && typeof K == "string" && !Q.checkClone && Bi.test(K)) return n.each(function (ve) {
                var ge = n.eq(ve);
                ne && (i[0] = K.call(this, ve, ge.html())), Pn(ge, i, f, l)
            });
            if (U && (v = Hi(i, n[0].ownerDocument, !1, n, l), y = v.firstChild, v.childNodes.length === 1 && (v = y), y || l)) {
                for (b = p.map(at(v, "script"), Oo), P = b.length; H < U; H++) k = v, H !== q && (k = p.clone(k, !0, !0), P && p.merge(b, at(k, "script"))), f.call(n[H], k, H);
                if (P) for (N = b[b.length - 1].ownerDocument, p.map(b, Po), H = 0; H < P; H++) k = b[H], qi.test(k.type || "") && !oe.access(k, "globalEval") && p.contains(N, k) && (k.src && (k.type || "").toLowerCase() !== "module" ? p._evalUrl && !k.noModule && p._evalUrl(k.src, {nonce: k.nonce || k.getAttribute("nonce")}, N) : Te(k.textContent.replace(Fi, ""), k, N))
            }
            return n
        }

        function zi(n, i, f) {
            for (var l, v = i ? p.filter(i, n) : n, y = 0; (l = v[y]) != null; y++) !f && l.nodeType === 1 && p.cleanData(at(l)), l.parentNode && (f && pn(l) && St(at(l, "script")), l.parentNode.removeChild(l));
            return n
        }

        p.extend({
            htmlPrefilter: function (n) {
                return n
            }, clone: function (n, i, f) {
                var l, v, y, b, P = n.cloneNode(!0), k = pn(n);
                if (!Q.noCloneChecked && (n.nodeType === 1 || n.nodeType === 11) && !p.isXMLDoc(n)) for (b = at(P), y = at(n), l = 0, v = y.length; l < v; l++) $i(y[l], b[l]);
                if (i) if (f) for (y = y || at(n), b = b || at(P), l = 0, v = y.length; l < v; l++) cr(y[l], b[l]); else cr(n, P);
                return b = at(P, "script"), b.length > 0 && St(b, !k && at(n, "script")), P
            }, cleanData: function (n) {
                for (var i, f, l, v = p.event.special, y = 0; (f = n[y]) !== void 0; y++) if (hn(f)) {
                    if (i = f[oe.expando]) {
                        if (i.events) for (l in i.events) v[l] ? p.event.remove(f, l) : p.removeEvent(f, l, i.handle);
                        f[oe.expando] = void 0
                    }
                    f[Ve.expando] && (f[Ve.expando] = void 0)
                }
            }
        }), p.fn.extend({
            detach: function (n) {
                return zi(this, n, !0)
            }, remove: function (n) {
                return zi(this, n)
            }, text: function (n) {
                return Pt(this, function (i) {
                    return i === void 0 ? p.text(this) : this.empty().each(function () {
                        (this.nodeType === 1 || this.nodeType === 11 || this.nodeType === 9) && (this.textContent = i)
                    })
                }, null, n, arguments.length)
            }, append: function () {
                return Pn(this, arguments, function (n) {
                    if (this.nodeType === 1 || this.nodeType === 11 || this.nodeType === 9) {
                        var i = Wi(this, n);
                        i.appendChild(n)
                    }
                })
            }, prepend: function () {
                return Pn(this, arguments, function (n) {
                    if (this.nodeType === 1 || this.nodeType === 11 || this.nodeType === 9) {
                        var i = Wi(this, n);
                        i.insertBefore(n, i.firstChild)
                    }
                })
            }, before: function () {
                return Pn(this, arguments, function (n) {
                    this.parentNode && this.parentNode.insertBefore(n, this)
                })
            }, after: function () {
                return Pn(this, arguments, function (n) {
                    this.parentNode && this.parentNode.insertBefore(n, this.nextSibling)
                })
            }, empty: function () {
                for (var n, i = 0; (n = this[i]) != null; i++) n.nodeType === 1 && (p.cleanData(at(n, !1)), n.textContent = "");
                return this
            }, clone: function (n, i) {
                return n = n == null ? !1 : n, i = i == null ? n : i, this.map(function () {
                    return p.clone(this, n, i)
                })
            }, html: function (n) {
                return Pt(this, function (i) {
                    var f = this[0] || {}, l = 0, v = this.length;
                    if (i === void 0 && f.nodeType === 1) return f.innerHTML;
                    if (typeof i == "string" && !Ui.test(i) && !ut[(Mi.exec(i) || ["", ""])[1].toLowerCase()]) {
                        i = p.htmlPrefilter(i);
                        try {
                            for (; l < v; l++) f = this[l] || {}, f.nodeType === 1 && (p.cleanData(at(f, !1)), f.innerHTML = i);
                            f = 0
                        } catch {
                        }
                    }
                    f && this.empty().append(i)
                }, null, n, arguments.length)
            }, replaceWith: function () {
                var n = [];
                return Pn(this, arguments, function (i) {
                    var f = this.parentNode;
                    p.inArray(this, n) < 0 && (p.cleanData(at(this)), f && f.replaceChild(i, this))
                }, n)
            }
        }), p.each({
            appendTo: "append",
            prependTo: "prepend",
            insertBefore: "before",
            insertAfter: "after",
            replaceAll: "replaceWith"
        }, function (n, i) {
            p.fn[n] = function (f) {
                for (var l, v = [], y = p(f), b = y.length - 1, P = 0; P <= b; P++) l = P === b ? this : this.clone(!0), p(y[P])[i](l), ie.apply(v, l.get());
                return this.pushStack(v)
            }
        });
        var ti = new RegExp("^(" + Lr + ")(?!px)[a-z%]+$", "i"), ni = /^--/, Dr = function (n) {
            var i = n.ownerDocument.defaultView;
            return (!i || !i.opener) && (i = m), i.getComputedStyle(n)
        }, Xi = function (n, i, f) {
            var l, v, y = {};
            for (v in i) y[v] = n.style[v], n.style[v] = i[v];
            l = f.call(n);
            for (v in i) n.style[v] = y[v];
            return l
        }, Mr = new RegExp(Rt.join("|"), "i");
        (function () {
            function n() {
                if (!!N) {
                    k.style.cssText = "position:absolute;left:-11111px;width:60px;margin-top:1px;padding:0;border:0", N.style.cssText = "position:relative;display:block;box-sizing:border-box;overflow:scroll;margin:auto;border:1px;padding:1px;width:60%;top:1%", tn.appendChild(k).appendChild(N);
                    var H = m.getComputedStyle(N);
                    f = H.top !== "1%", P = i(H.marginLeft) === 12, N.style.right = "60%", y = i(H.right) === 36, l = i(H.width) === 36, N.style.position = "absolute", v = i(N.offsetWidth / 3) === 12, tn.removeChild(k), N = null
                }
            }

            function i(H) {
                return Math.round(parseFloat(H))
            }

            var f, l, v, y, b, P, k = F.createElement("div"), N = F.createElement("div");
            !N.style || (N.style.backgroundClip = "content-box", N.cloneNode(!0).style.backgroundClip = "", Q.clearCloneStyle = N.style.backgroundClip === "content-box", p.extend(Q, {
                boxSizingReliable: function () {
                    return n(), l
                }, pixelBoxStyles: function () {
                    return n(), y
                }, pixelPosition: function () {
                    return n(), f
                }, reliableMarginLeft: function () {
                    return n(), P
                }, scrollboxSize: function () {
                    return n(), v
                }, reliableTrDimensions: function () {
                    var H, U, q, K;
                    return b == null && (H = F.createElement("table"), U = F.createElement("tr"), q = F.createElement("div"), H.style.cssText = "position:absolute;left:-11111px;border-collapse:separate", U.style.cssText = "box-sizing:content-box;border:1px solid", U.style.height = "1px", q.style.height = "9px", q.style.display = "block", tn.appendChild(H).appendChild(U).appendChild(q), K = m.getComputedStyle(U), b = parseInt(K.height, 10) + parseInt(K.borderTopWidth, 10) + parseInt(K.borderBottomWidth, 10) === U.offsetHeight, tn.removeChild(H)), b
                }
            }))
        })();

        function lr(n, i, f) {
            var l, v, y, b, P = ni.test(i), k = n.style;
            return f = f || Dr(n), f && (b = f.getPropertyValue(i) || f[i], P && b && (b = b.replace(Ft, "$1") || void 0), b === "" && !pn(n) && (b = p.style(n, i)), !Q.pixelBoxStyles() && ti.test(b) && Mr.test(i) && (l = k.width, v = k.minWidth, y = k.maxWidth, k.minWidth = k.maxWidth = k.width = b, b = f.width, k.width = l, k.minWidth = v, k.maxWidth = y)), b !== void 0 ? b + "" : b
        }

        function hr(n, i) {
            return {
                get: function () {
                    if (n()) {
                        delete this.get;
                        return
                    }
                    return (this.get = i).apply(this, arguments)
                }
            }
        }

        var ri = ["Webkit", "Moz", "ms"], gn = F.createElement("div").style, Gi = {};

        function Ji(n) {
            for (var i = n[0].toUpperCase() + n.slice(1), f = ri.length; f--;) if (n = ri[f] + i, n in gn) return n
        }

        function qr(n) {
            var i = p.cssProps[n] || Gi[n];
            return i || (n in gn ? n : Gi[n] = Ji(n) || n)
        }

        var Vi = /^(none|table(?!-c[ea]).+)/, Ro = {position: "absolute", visibility: "hidden", display: "block"},
            Ki = {letterSpacing: "0", fontWeight: "400"};

        function Yi(n, i, f) {
            var l = kn.exec(i);
            return l ? Math.max(0, l[2] - (f || 0)) + (l[3] || "px") : i
        }

        function ii(n, i, f, l, v, y) {
            var b = i === "width" ? 1 : 0, P = 0, k = 0, N = 0;
            if (f === (l ? "border" : "content")) return 0;
            for (; b < 4; b += 2) f === "margin" && (N += p.css(n, f + Rt[b], !0, v)), l ? (f === "content" && (k -= p.css(n, "padding" + Rt[b], !0, v)), f !== "margin" && (k -= p.css(n, "border" + Rt[b] + "Width", !0, v))) : (k += p.css(n, "padding" + Rt[b], !0, v), f !== "padding" ? k += p.css(n, "border" + Rt[b] + "Width", !0, v) : P += p.css(n, "border" + Rt[b] + "Width", !0, v));
            return !l && y >= 0 && (k += Math.max(0, Math.ceil(n["offset" + i[0].toUpperCase() + i.slice(1)] - y - k - P - .5)) || 0), k + N
        }

        function oi(n, i, f) {
            var l = Dr(n), v = !Q.boxSizingReliable() || f, y = v && p.css(n, "boxSizing", !1, l) === "border-box",
                b = y, P = lr(n, i, l), k = "offset" + i[0].toUpperCase() + i.slice(1);
            if (ti.test(P)) {
                if (!f) return P;
                P = "auto"
            }
            return (!Q.boxSizingReliable() && y || !Q.reliableTrDimensions() && _e(n, "tr") || P === "auto" || !parseFloat(P) && p.css(n, "display", !1, l) === "inline") && n.getClientRects().length && (y = p.css(n, "boxSizing", !1, l) === "border-box", b = k in n, b && (P = n[k])), P = parseFloat(P) || 0, P + ii(n, i, f || (y ? "border" : "content"), b, l, P) + "px"
        }

        p.extend({
            cssHooks: {
                opacity: {
                    get: function (n, i) {
                        if (i) {
                            var f = lr(n, "opacity");
                            return f === "" ? "1" : f
                        }
                    }
                }
            },
            cssNumber: {
                animationIterationCount: !0,
                aspectRatio: !0,
                borderImageSlice: !0,
                columnCount: !0,
                flexGrow: !0,
                flexShrink: !0,
                fontWeight: !0,
                gridArea: !0,
                gridColumn: !0,
                gridColumnEnd: !0,
                gridColumnStart: !0,
                gridRow: !0,
                gridRowEnd: !0,
                gridRowStart: !0,
                lineHeight: !0,
                opacity: !0,
                order: !0,
                orphans: !0,
                scale: !0,
                widows: !0,
                zIndex: !0,
                zoom: !0,
                fillOpacity: !0,
                floodOpacity: !0,
                stopOpacity: !0,
                strokeMiterlimit: !0,
                strokeOpacity: !0
            },
            cssProps: {},
            style: function (n, i, f, l) {
                if (!(!n || n.nodeType === 3 || n.nodeType === 8 || !n.style)) {
                    var v, y, b, P = st(i), k = ni.test(i), N = n.style;
                    if (k || (i = qr(P)), b = p.cssHooks[i] || p.cssHooks[P], f !== void 0) {
                        if (y = typeof f, y === "string" && (v = kn.exec(f)) && v[1] && (f = Ir(n, i, v), y = "number"), f == null || f !== f) return;
                        y === "number" && !k && (f += v && v[3] || (p.cssNumber[P] ? "" : "px")), !Q.clearCloneStyle && f === "" && i.indexOf("background") === 0 && (N[i] = "inherit"), (!b || !("set" in b) || (f = b.set(n, f, l)) !== void 0) && (k ? N.setProperty(i, f) : N[i] = f)
                    } else return b && "get" in b && (v = b.get(n, !1, l)) !== void 0 ? v : N[i]
                }
            },
            css: function (n, i, f, l) {
                var v, y, b, P = st(i), k = ni.test(i);
                return k || (i = qr(P)), b = p.cssHooks[i] || p.cssHooks[P], b && "get" in b && (v = b.get(n, !0, f)), v === void 0 && (v = lr(n, i, l)), v === "normal" && i in Ki && (v = Ki[i]), f === "" || f ? (y = parseFloat(v), f === !0 || isFinite(y) ? y || 0 : v) : v
            }
        }), p.each(["height", "width"], function (n, i) {
            p.cssHooks[i] = {
                get: function (f, l, v) {
                    if (l) return Vi.test(p.css(f, "display")) && (!f.getClientRects().length || !f.getBoundingClientRect().width) ? Xi(f, Ro, function () {
                        return oi(f, i, v)
                    }) : oi(f, i, v)
                }, set: function (f, l, v) {
                    var y, b = Dr(f), P = !Q.scrollboxSize() && b.position === "absolute", k = P || v,
                        N = k && p.css(f, "boxSizing", !1, b) === "border-box", H = v ? ii(f, i, v, N, b) : 0;
                    return N && P && (H -= Math.ceil(f["offset" + i[0].toUpperCase() + i.slice(1)] - parseFloat(b[i]) - ii(f, i, "border", !1, b) - .5)), H && (y = kn.exec(l)) && (y[3] || "px") !== "px" && (f.style[i] = l, l = p.css(f, i)), Yi(f, l, H)
                }
            }
        }), p.cssHooks.marginLeft = hr(Q.reliableMarginLeft, function (n, i) {
            if (i) return (parseFloat(lr(n, "marginLeft")) || n.getBoundingClientRect().left - Xi(n, {marginLeft: 0}, function () {
                return n.getBoundingClientRect().left
            })) + "px"
        }), p.each({margin: "", padding: "", border: "Width"}, function (n, i) {
            p.cssHooks[n + i] = {
                expand: function (f) {
                    for (var l = 0, v = {}, y = typeof f == "string" ? f.split(" ") : [f]; l < 4; l++) v[n + Rt[l] + i] = y[l] || y[l - 2] || y[0];
                    return v
                }
            }, n !== "margin" && (p.cssHooks[n + i].set = Yi)
        }), p.fn.extend({
            css: function (n, i) {
                return Pt(this, function (f, l, v) {
                    var y, b, P = {}, k = 0;
                    if (Array.isArray(l)) {
                        for (y = Dr(f), b = l.length; k < b; k++) P[l[k]] = p.css(f, l[k], !1, y);
                        return P
                    }
                    return v !== void 0 ? p.style(f, l, v) : p.css(f, l)
                }, n, i, arguments.length > 1)
            }
        });

        function Ke(n, i, f, l, v) {
            return new Ke.prototype.init(n, i, f, l, v)
        }

        p.Tween = Ke, Ke.prototype = {
            constructor: Ke, init: function (n, i, f, l, v, y) {
                this.elem = n, this.prop = f, this.easing = v || p.easing._default, this.options = i, this.start = this.now = this.cur(), this.end = l, this.unit = y || (p.cssNumber[f] ? "" : "px")
            }, cur: function () {
                var n = Ke.propHooks[this.prop];
                return n && n.get ? n.get(this) : Ke.propHooks._default.get(this)
            }, run: function (n) {
                var i, f = Ke.propHooks[this.prop];
                return this.options.duration ? this.pos = i = p.easing[this.easing](n, this.options.duration * n, 0, 1, this.options.duration) : this.pos = i = n, this.now = (this.end - this.start) * i + this.start, this.options.step && this.options.step.call(this.elem, this.now, this), f && f.set ? f.set(this) : Ke.propHooks._default.set(this), this
            }
        }, Ke.prototype.init.prototype = Ke.prototype, Ke.propHooks = {
            _default: {
                get: function (n) {
                    var i;
                    return n.elem.nodeType !== 1 || n.elem[n.prop] != null && n.elem.style[n.prop] == null ? n.elem[n.prop] : (i = p.css(n.elem, n.prop, ""), !i || i === "auto" ? 0 : i)
                }, set: function (n) {
                    p.fx.step[n.prop] ? p.fx.step[n.prop](n) : n.elem.nodeType === 1 && (p.cssHooks[n.prop] || n.elem.style[qr(n.prop)] != null) ? p.style(n.elem, n.prop, n.now + n.unit) : n.elem[n.prop] = n.now
                }
            }
        }, Ke.propHooks.scrollTop = Ke.propHooks.scrollLeft = {
            set: function (n) {
                n.elem.nodeType && n.elem.parentNode && (n.elem[n.prop] = n.now)
            }
        }, p.easing = {
            linear: function (n) {
                return n
            }, swing: function (n) {
                return .5 - Math.cos(n * Math.PI) / 2
            }, _default: "swing"
        }, p.fx = Ke.prototype.init, p.fx.step = {};
        var Rn, $n, si = /^(?:toggle|show|hide)$/, Qi = /queueHooks$/;

        function zn() {
            $n && (F.hidden === !1 && m.requestAnimationFrame ? m.requestAnimationFrame(zn) : m.setTimeout(zn, p.fx.interval), p.fx.tick())
        }

        function ui() {
            return m.setTimeout(function () {
                Rn = void 0
            }), Rn = Date.now()
        }

        function Hr(n, i) {
            var f, l = 0, v = {height: n};
            for (i = i ? 1 : 0; l < 4; l += 2 - i) f = Rt[l], v["margin" + f] = v["padding" + f] = n;
            return i && (v.opacity = v.width = n), v
        }

        function ai(n, i, f) {
            for (var l, v = (It.tweeners[i] || []).concat(It.tweeners["*"]), y = 0, b = v.length; y < b; y++) if (l = v[y].call(f, i, n)) return l
        }

        function Zi(n, i, f) {
            var l, v, y, b, P, k, N, H, U = "width" in i || "height" in i, q = this, K = {}, ne = n.style,
                ve = n.nodeType && Fn(n), ge = oe.get(n, "fxshow");
            f.queue || (b = p._queueHooks(n, "fx"), b.unqueued == null && (b.unqueued = 0, P = b.empty.fire, b.empty.fire = function () {
                b.unqueued || P()
            }), b.unqueued++, q.always(function () {
                q.always(function () {
                    b.unqueued--, p.queue(n, "fx").length || b.empty.fire()
                })
            }));
            for (l in i) if (v = i[l], si.test(v)) {
                if (delete i[l], y = y || v === "toggle", v === (ve ? "hide" : "show")) if (v === "show" && ge && ge[l] !== void 0) ve = !0; else continue;
                K[l] = ge && ge[l] || p.style(n, l)
            }
            if (k = !p.isEmptyObject(i), !(!k && p.isEmptyObject(K))) {
                U && n.nodeType === 1 && (f.overflow = [ne.overflow, ne.overflowX, ne.overflowY], N = ge && ge.display, N == null && (N = oe.get(n, "display")), H = p.css(n, "display"), H === "none" && (N ? H = N : (On([n], !0), N = n.style.display || N, H = p.css(n, "display"), On([n]))), (H === "inline" || H === "inline-block" && N != null) && p.css(n, "float") === "none" && (k || (q.done(function () {
                    ne.display = N
                }), N == null && (H = ne.display, N = H === "none" ? "" : H)), ne.display = "inline-block")), f.overflow && (ne.overflow = "hidden", q.always(function () {
                    ne.overflow = f.overflow[0], ne.overflowX = f.overflow[1], ne.overflowY = f.overflow[2]
                })), k = !1;
                for (l in K) k || (ge ? "hidden" in ge && (ve = ge.hidden) : ge = oe.access(n, "fxshow", {display: N}), y && (ge.hidden = !ve), ve && On([n], !0), q.done(function () {
                    ve || On([n]), oe.remove(n, "fxshow");
                    for (l in K) p.style(n, l, K[l])
                })), k = ai(ve ? ge[l] : 0, l, q), l in ge || (ge[l] = k.start, ve && (k.end = k.start, k.start = 0))
            }
        }

        function fi(n, i) {
            var f, l, v, y, b;
            for (f in n) if (l = st(f), v = i[l], y = n[f], Array.isArray(y) && (v = y[1], y = n[f] = y[0]), f !== l && (n[l] = y, delete n[f]), b = p.cssHooks[l], b && "expand" in b) {
                y = b.expand(y), delete n[l];
                for (f in y) f in n || (n[f] = y[f], i[f] = v)
            } else i[l] = v
        }

        function It(n, i, f) {
            var l, v, y = 0, b = It.prefilters.length, P = p.Deferred().always(function () {
                delete k.elem
            }), k = function () {
                if (v) return !1;
                for (var U = Rn || ui(), q = Math.max(0, N.startTime + N.duration - U), K = q / N.duration || 0, ne = 1 - K, ve = 0, ge = N.tweens.length; ve < ge; ve++) N.tweens[ve].run(ne);
                return P.notifyWith(n, [N, ne, q]), ne < 1 && ge ? q : (ge || P.notifyWith(n, [N, 1, 0]), P.resolveWith(n, [N]), !1)
            }, N = P.promise({
                elem: n,
                props: p.extend({}, i),
                opts: p.extend(!0, {specialEasing: {}, easing: p.easing._default}, f),
                originalProperties: i,
                originalOptions: f,
                startTime: Rn || ui(),
                duration: f.duration,
                tweens: [],
                createTween: function (U, q) {
                    var K = p.Tween(n, N.opts, U, q, N.opts.specialEasing[U] || N.opts.easing);
                    return N.tweens.push(K), K
                },
                stop: function (U) {
                    var q = 0, K = U ? N.tweens.length : 0;
                    if (v) return this;
                    for (v = !0; q < K; q++) N.tweens[q].run(1);
                    return U ? (P.notifyWith(n, [N, 1, 0]), P.resolveWith(n, [N, U])) : P.rejectWith(n, [N, U]), this
                }
            }), H = N.props;
            for (fi(H, N.opts.specialEasing); y < b; y++) if (l = It.prefilters[y].call(N, n, H, N.opts), l) return J(l.stop) && (p._queueHooks(N.elem, N.opts.queue).stop = l.stop.bind(l)), l;
            return p.map(H, ai, N), J(N.opts.start) && N.opts.start.call(n, N), N.progress(N.opts.progress).done(N.opts.done, N.opts.complete).fail(N.opts.fail).always(N.opts.always), p.fx.timer(p.extend(k, {
                elem: n,
                anim: N,
                queue: N.opts.queue
            })), N
        }

        p.Animation = p.extend(It, {
            tweeners: {
                "*": [function (n, i) {
                    var f = this.createTween(n, i);
                    return Ir(f.elem, n, kn.exec(i), f), f
                }]
            }, tweener: function (n, i) {
                J(n) ? (i = n, n = ["*"]) : n = n.match($t);
                for (var f, l = 0, v = n.length; l < v; l++) f = n[l], It.tweeners[f] = It.tweeners[f] || [], It.tweeners[f].unshift(i)
            }, prefilters: [Zi], prefilter: function (n, i) {
                i ? It.prefilters.unshift(n) : It.prefilters.push(n)
            }
        }), p.speed = function (n, i, f) {
            var l = n && typeof n == "object" ? p.extend({}, n) : {
                complete: f || !f && i || J(n) && n,
                duration: n,
                easing: f && i || i && !J(i) && i
            };
            return p.fx.off ? l.duration = 0 : typeof l.duration != "number" && (l.duration in p.fx.speeds ? l.duration = p.fx.speeds[l.duration] : l.duration = p.fx.speeds._default), (l.queue == null || l.queue === !0) && (l.queue = "fx"), l.old = l.complete, l.complete = function () {
                J(l.old) && l.old.call(this), l.queue && p.dequeue(this, l.queue)
            }, l
        }, p.fn.extend({
            fadeTo: function (n, i, f, l) {
                return this.filter(Fn).css("opacity", 0).show().end().animate({opacity: i}, n, f, l)
            }, animate: function (n, i, f, l) {
                var v = p.isEmptyObject(n), y = p.speed(i, f, l), b = function () {
                    var P = It(this, p.extend({}, n), y);
                    (v || oe.get(this, "finish")) && P.stop(!0)
                };
                return b.finish = b, v || y.queue === !1 ? this.each(b) : this.queue(y.queue, b)
            }, stop: function (n, i, f) {
                var l = function (v) {
                    var y = v.stop;
                    delete v.stop, y(f)
                };
                return typeof n != "string" && (f = i, i = n, n = void 0), i && this.queue(n || "fx", []), this.each(function () {
                    var v = !0, y = n != null && n + "queueHooks", b = p.timers, P = oe.get(this);
                    if (y) P[y] && P[y].stop && l(P[y]); else for (y in P) P[y] && P[y].stop && Qi.test(y) && l(P[y]);
                    for (y = b.length; y--;) b[y].elem === this && (n == null || b[y].queue === n) && (b[y].anim.stop(f), v = !1, b.splice(y, 1));
                    (v || !f) && p.dequeue(this, n)
                })
            }, finish: function (n) {
                return n !== !1 && (n = n || "fx"), this.each(function () {
                    var i, f = oe.get(this), l = f[n + "queue"], v = f[n + "queueHooks"], y = p.timers,
                        b = l ? l.length : 0;
                    for (f.finish = !0, p.queue(this, n, []), v && v.stop && v.stop.call(this, !0), i = y.length; i--;) y[i].elem === this && y[i].queue === n && (y[i].anim.stop(!0), y.splice(i, 1));
                    for (i = 0; i < b; i++) l[i] && l[i].finish && l[i].finish.call(this);
                    delete f.finish
                })
            }
        }), p.each(["toggle", "show", "hide"], function (n, i) {
            var f = p.fn[i];
            p.fn[i] = function (l, v, y) {
                return l == null || typeof l == "boolean" ? f.apply(this, arguments) : this.animate(Hr(i, !0), l, v, y)
            }
        }), p.each({
            slideDown: Hr("show"),
            slideUp: Hr("hide"),
            slideToggle: Hr("toggle"),
            fadeIn: {opacity: "show"},
            fadeOut: {opacity: "hide"},
            fadeToggle: {opacity: "toggle"}
        }, function (n, i) {
            p.fn[n] = function (f, l, v) {
                return this.animate(i, f, l, v)
            }
        }), p.timers = [], p.fx.tick = function () {
            var n, i = 0, f = p.timers;
            for (Rn = Date.now(); i < f.length; i++) n = f[i], !n() && f[i] === n && f.splice(i--, 1);
            f.length || p.fx.stop(), Rn = void 0
        }, p.fx.timer = function (n) {
            p.timers.push(n), p.fx.start()
        }, p.fx.interval = 13, p.fx.start = function () {
            $n || ($n = !0, zn())
        }, p.fx.stop = function () {
            $n = null
        }, p.fx.speeds = {slow: 600, fast: 200, _default: 400}, p.fn.delay = function (n, i) {
            return n = p.fx && p.fx.speeds[n] || n, i = i || "fx", this.queue(i, function (f, l) {
                var v = m.setTimeout(f, n);
                l.stop = function () {
                    m.clearTimeout(v)
                }
            })
        }, function () {
            var n = F.createElement("input"), i = F.createElement("select"),
                f = i.appendChild(F.createElement("option"));
            n.type = "checkbox", Q.checkOn = n.value !== "", Q.optSelected = f.selected, n = F.createElement("input"), n.value = "t", n.type = "radio", Q.radioValue = n.value === "t"
        }();
        var pr, Ln = p.expr.attrHandle;
        p.fn.extend({
            attr: function (n, i) {
                return Pt(this, p.attr, n, i, arguments.length > 1)
            }, removeAttr: function (n) {
                return this.each(function () {
                    p.removeAttr(this, n)
                })
            }
        }), p.extend({
            attr: function (n, i, f) {
                var l, v, y = n.nodeType;
                if (!(y === 3 || y === 8 || y === 2)) {
                    if (typeof n.getAttribute == "undefined") return p.prop(n, i, f);
                    if ((y !== 1 || !p.isXMLDoc(n)) && (v = p.attrHooks[i.toLowerCase()] || (p.expr.match.bool.test(i) ? pr : void 0)), f !== void 0) {
                        if (f === null) {
                            p.removeAttr(n, i);
                            return
                        }
                        return v && "set" in v && (l = v.set(n, f, i)) !== void 0 ? l : (n.setAttribute(i, f + ""), f)
                    }
                    return v && "get" in v && (l = v.get(n, i)) !== null ? l : (l = p.find.attr(n, i), l == null ? void 0 : l)
                }
            }, attrHooks: {
                type: {
                    set: function (n, i) {
                        if (!Q.radioValue && i === "radio" && _e(n, "input")) {
                            var f = n.value;
                            return n.setAttribute("type", i), f && (n.value = f), i
                        }
                    }
                }
            }, removeAttr: function (n, i) {
                var f, l = 0, v = i && i.match($t);
                if (v && n.nodeType === 1) for (; f = v[l++];) n.removeAttribute(f)
            }
        }), pr = {
            set: function (n, i, f) {
                return i === !1 ? p.removeAttr(n, f) : n.setAttribute(f, f), f
            }
        }, p.each(p.expr.match.bool.source.match(/\w+/g), function (n, i) {
            var f = Ln[i] || p.find.attr;
            Ln[i] = function (l, v, y) {
                var b, P, k = v.toLowerCase();
                return y || (P = Ln[k], Ln[k] = b, b = f(l, v, y) != null ? k : null, Ln[k] = P), b
            }
        });
        var ci = /^(?:input|select|textarea|button)$/i, Xn = /^(?:a|area)$/i;
        p.fn.extend({
            prop: function (n, i) {
                return Pt(this, p.prop, n, i, arguments.length > 1)
            }, removeProp: function (n) {
                return this.each(function () {
                    delete this[p.propFix[n] || n]
                })
            }
        }), p.extend({
            prop: function (n, i, f) {
                var l, v, y = n.nodeType;
                if (!(y === 3 || y === 8 || y === 2)) return (y !== 1 || !p.isXMLDoc(n)) && (i = p.propFix[i] || i, v = p.propHooks[i]), f !== void 0 ? v && "set" in v && (l = v.set(n, f, i)) !== void 0 ? l : n[i] = f : v && "get" in v && (l = v.get(n, i)) !== null ? l : n[i]
            }, propHooks: {
                tabIndex: {
                    get: function (n) {
                        var i = p.find.attr(n, "tabindex");
                        return i ? parseInt(i, 10) : ci.test(n.nodeName) || Xn.test(n.nodeName) && n.href ? 0 : -1
                    }
                }
            }, propFix: {for: "htmlFor", class: "className"}
        }), Q.optSelected || (p.propHooks.selected = {
            get: function (n) {
                var i = n.parentNode;
                return i && i.parentNode && i.parentNode.selectedIndex, null
            }, set: function (n) {
                var i = n.parentNode;
                i && (i.selectedIndex, i.parentNode && i.parentNode.selectedIndex)
            }
        }), p.each(["tabIndex", "readOnly", "maxLength", "cellSpacing", "cellPadding", "rowSpan", "colSpan", "useMap", "frameBorder", "contentEditable"], function () {
            p.propFix[this.toLowerCase()] = this
        });

        function vn(n) {
            var i = n.match($t) || [];
            return i.join(" ")
        }

        function yn(n) {
            return n.getAttribute && n.getAttribute("class") || ""
        }

        function li(n) {
            return Array.isArray(n) ? n : typeof n == "string" ? n.match($t) || [] : []
        }

        p.fn.extend({
            addClass: function (n) {
                var i, f, l, v, y, b;
                return J(n) ? this.each(function (P) {
                    p(this).addClass(n.call(this, P, yn(this)))
                }) : (i = li(n), i.length ? this.each(function () {
                    if (l = yn(this), f = this.nodeType === 1 && " " + vn(l) + " ", f) {
                        for (y = 0; y < i.length; y++) v = i[y], f.indexOf(" " + v + " ") < 0 && (f += v + " ");
                        b = vn(f), l !== b && this.setAttribute("class", b)
                    }
                }) : this)
            }, removeClass: function (n) {
                var i, f, l, v, y, b;
                return J(n) ? this.each(function (P) {
                    p(this).removeClass(n.call(this, P, yn(this)))
                }) : arguments.length ? (i = li(n), i.length ? this.each(function () {
                    if (l = yn(this), f = this.nodeType === 1 && " " + vn(l) + " ", f) {
                        for (y = 0; y < i.length; y++) for (v = i[y]; f.indexOf(" " + v + " ") > -1;) f = f.replace(" " + v + " ", " ");
                        b = vn(f), l !== b && this.setAttribute("class", b)
                    }
                }) : this) : this.attr("class", "")
            }, toggleClass: function (n, i) {
                var f, l, v, y, b = typeof n, P = b === "string" || Array.isArray(n);
                return J(n) ? this.each(function (k) {
                    p(this).toggleClass(n.call(this, k, yn(this), i), i)
                }) : typeof i == "boolean" && P ? i ? this.addClass(n) : this.removeClass(n) : (f = li(n), this.each(function () {
                    if (P) for (y = p(this), v = 0; v < f.length; v++) l = f[v], y.hasClass(l) ? y.removeClass(l) : y.addClass(l); else (n === void 0 || b === "boolean") && (l = yn(this), l && oe.set(this, "__className__", l), this.setAttribute && this.setAttribute("class", l || n === !1 ? "" : oe.get(this, "__className__") || ""))
                }))
            }, hasClass: function (n) {
                var i, f, l = 0;
                for (i = " " + n + " "; f = this[l++];) if (f.nodeType === 1 && (" " + vn(yn(f)) + " ").indexOf(i) > -1) return !0;
                return !1
            }
        });
        var eo = /\r/g;
        p.fn.extend({
            val: function (n) {
                var i, f, l, v = this[0];
                return arguments.length ? (l = J(n), this.each(function (y) {
                    var b;
                    this.nodeType === 1 && (l ? b = n.call(this, y, p(this).val()) : b = n, b == null ? b = "" : typeof b == "number" ? b += "" : Array.isArray(b) && (b = p.map(b, function (P) {
                        return P == null ? "" : P + ""
                    })), i = p.valHooks[this.type] || p.valHooks[this.nodeName.toLowerCase()], (!i || !("set" in i) || i.set(this, b, "value") === void 0) && (this.value = b))
                })) : v ? (i = p.valHooks[v.type] || p.valHooks[v.nodeName.toLowerCase()], i && "get" in i && (f = i.get(v, "value")) !== void 0 ? f : (f = v.value, typeof f == "string" ? f.replace(eo, "") : f == null ? "" : f)) : void 0
            }
        }), p.extend({
            valHooks: {
                option: {
                    get: function (n) {
                        var i = p.find.attr(n, "value");
                        return i != null ? i : vn(p.text(n))
                    }
                }, select: {
                    get: function (n) {
                        var i, f, l, v = n.options, y = n.selectedIndex, b = n.type === "select-one", P = b ? null : [],
                            k = b ? y + 1 : v.length;
                        for (y < 0 ? l = k : l = b ? y : 0; l < k; l++) if (f = v[l], (f.selected || l === y) && !f.disabled && (!f.parentNode.disabled || !_e(f.parentNode, "optgroup"))) {
                            if (i = p(f).val(), b) return i;
                            P.push(i)
                        }
                        return P
                    }, set: function (n, i) {
                        for (var f, l, v = n.options, y = p.makeArray(i), b = v.length; b--;) l = v[b], (l.selected = p.inArray(p.valHooks.option.get(l), y) > -1) && (f = !0);
                        return f || (n.selectedIndex = -1), y
                    }
                }
            }
        }), p.each(["radio", "checkbox"], function () {
            p.valHooks[this] = {
                set: function (n, i) {
                    if (Array.isArray(i)) return n.checked = p.inArray(p(n).val(), i) > -1
                }
            }, Q.checkOn || (p.valHooks[this].get = function (n) {
                return n.getAttribute("value") === null ? "on" : n.value
            })
        });
        var Gn = m.location, hi = {guid: Date.now()}, jr = /\?/;
        p.parseXML = function (n) {
            var i, f;
            if (!n || typeof n != "string") return null;
            try {
                i = new m.DOMParser().parseFromString(n, "text/xml")
            } catch {
            }
            return f = i && i.getElementsByTagName("parsererror")[0], (!i || f) && p.error("Invalid XML: " + (f ? p.map(f.childNodes, function (l) {
                return l.textContent
            }).join(`
`) : n)), i
        };
        var zt = /^(?:focusinfocus|focusoutblur)$/, to = function (n) {
            n.stopPropagation()
        };
        p.extend(p.event, {
            trigger: function (n, i, f, l) {
                var v, y, b, P, k, N, H, U, q = [f || F], K = ae.call(n, "type") ? n.type : n,
                    ne = ae.call(n, "namespace") ? n.namespace.split(".") : [];
                if (y = U = b = f = f || F, !(f.nodeType === 3 || f.nodeType === 8) && !zt.test(K + p.event.triggered) && (K.indexOf(".") > -1 && (ne = K.split("."), K = ne.shift(), ne.sort()), k = K.indexOf(":") < 0 && "on" + K, n = n[p.expando] ? n : new p.Event(K, typeof n == "object" && n), n.isTrigger = l ? 2 : 3, n.namespace = ne.join("."), n.rnamespace = n.namespace ? new RegExp("(^|\\.)" + ne.join("\\.(?:.*\\.|)") + "(\\.|$)") : null, n.result = void 0, n.target || (n.target = f), i = i == null ? [n] : p.makeArray(i, [n]), H = p.event.special[K] || {}, !(!l && H.trigger && H.trigger.apply(f, i) === !1))) {
                    if (!l && !H.noBubble && !G(f)) {
                        for (P = H.delegateType || K, zt.test(P + K) || (y = y.parentNode); y; y = y.parentNode) q.push(y), b = y;
                        b === (f.ownerDocument || F) && q.push(b.defaultView || b.parentWindow || m)
                    }
                    for (v = 0; (y = q[v++]) && !n.isPropagationStopped();) U = y, n.type = v > 1 ? P : H.bindType || K, N = (oe.get(y, "events") || Object.create(null))[n.type] && oe.get(y, "handle"), N && N.apply(y, i), N = k && y[k], N && N.apply && hn(y) && (n.result = N.apply(y, i), n.result === !1 && n.preventDefault());
                    return n.type = K, !l && !n.isDefaultPrevented() && (!H._default || H._default.apply(q.pop(), i) === !1) && hn(f) && k && J(f[K]) && !G(f) && (b = f[k], b && (f[k] = null), p.event.triggered = K, n.isPropagationStopped() && U.addEventListener(K, to), f[K](), n.isPropagationStopped() && U.removeEventListener(K, to), p.event.triggered = void 0, b && (f[k] = b)), n.result
                }
            }, simulate: function (n, i, f) {
                var l = p.extend(new p.Event, f, {type: n, isSimulated: !0});
                p.event.trigger(l, null, i)
            }
        }), p.fn.extend({
            trigger: function (n, i) {
                return this.each(function () {
                    p.event.trigger(n, i, this)
                })
            }, triggerHandler: function (n, i) {
                var f = this[0];
                if (f) return p.event.trigger(n, i, f, !0)
            }
        });
        var no = /\[\]$/, pi = /\r?\n/g, In = /^(?:submit|button|image|reset|file)$/i,
            Lo = /^(?:input|select|textarea|keygen)/i;

        function dr(n, i, f, l) {
            var v;
            if (Array.isArray(i)) p.each(i, function (y, b) {
                f || no.test(n) ? l(n, b) : dr(n + "[" + (typeof b == "object" && b != null ? y : "") + "]", b, f, l)
            }); else if (!f && Ne(i) === "object") for (v in i) dr(n + "[" + v + "]", i[v], f, l); else l(n, i)
        }

        p.param = function (n, i) {
            var f, l = [], v = function (y, b) {
                var P = J(b) ? b() : b;
                l[l.length] = encodeURIComponent(y) + "=" + encodeURIComponent(P == null ? "" : P)
            };
            if (n == null) return "";
            if (Array.isArray(n) || n.jquery && !p.isPlainObject(n)) p.each(n, function () {
                v(this.name, this.value)
            }); else for (f in n) dr(f, n[f], i, v);
            return l.join("&")
        }, p.fn.extend({
            serialize: function () {
                return p.param(this.serializeArray())
            }, serializeArray: function () {
                return this.map(function () {
                    var n = p.prop(this, "elements");
                    return n ? p.makeArray(n) : this
                }).filter(function () {
                    var n = this.type;
                    return this.name && !p(this).is(":disabled") && Lo.test(this.nodeName) && !In.test(n) && (this.checked || !Wn.test(n))
                }).map(function (n, i) {
                    var f = p(this).val();
                    return f == null ? null : Array.isArray(f) ? p.map(f, function (l) {
                        return {
                            name: i.name, value: l.replace(pi, `\r
`)
                        }
                    }) : {
                        name: i.name, value: f.replace(pi, `\r
`)
                    }
                }).get()
            }
        });
        var Io = /%20/g, di = /#.*$/, No = /([?&])_=[^&]*/, Do = /^(.*?):[ \t]*([^\r\n]*)$/mg,
            Mo = /^(?:about|app|app-storage|.+-extension|file|res|widget):$/, gi = /^(?:GET|HEAD)$/, qo = /^\/\//,
            De = {}, Re = {}, ro = "*/".concat("*"), Jn = F.createElement("a");
        Jn.href = Gn.href;

        function oo(n) {
            return function (i, f) {
                typeof i != "string" && (f = i, i = "*");
                var l, v = 0, y = i.toLowerCase().match($t) || [];
                if (J(f)) for (; l = y[v++];) l[0] === "+" ? (l = l.slice(1) || "*", (n[l] = n[l] || []).unshift(f)) : (n[l] = n[l] || []).push(f)
            }
        }

        function Vn(n, i, f, l) {
            var v = {}, y = n === Re;

            function b(P) {
                var k;
                return v[P] = !0, p.each(n[P] || [], function (N, H) {
                    var U = H(i, f, l);
                    if (typeof U == "string" && !y && !v[U]) return i.dataTypes.unshift(U), b(U), !1;
                    if (y) return !(k = U)
                }), k
            }

            return b(i.dataTypes[0]) || !v["*"] && b("*")
        }

        function vi(n, i) {
            var f, l, v = p.ajaxSettings.flatOptions || {};
            for (f in i) i[f] !== void 0 && ((v[f] ? n : l || (l = {}))[f] = i[f]);
            return l && p.extend(!0, n, l), n
        }

        function Ho(n, i, f) {
            for (var l, v, y, b, P = n.contents, k = n.dataTypes; k[0] === "*";) k.shift(), l === void 0 && (l = n.mimeType || i.getResponseHeader("Content-Type"));
            if (l) {
                for (v in P) if (P[v] && P[v].test(l)) {
                    k.unshift(v);
                    break
                }
            }
            if (k[0] in f) y = k[0]; else {
                for (v in f) {
                    if (!k[0] || n.converters[v + " " + k[0]]) {
                        y = v;
                        break
                    }
                    b || (b = v)
                }
                y = y || b
            }
            if (y) return y !== k[0] && k.unshift(y), f[y]
        }

        function Kn(n, i, f, l) {
            var v, y, b, P, k, N = {}, H = n.dataTypes.slice();
            if (H[1]) for (b in n.converters) N[b.toLowerCase()] = n.converters[b];
            for (y = H.shift(); y;) if (n.responseFields[y] && (f[n.responseFields[y]] = i), !k && l && n.dataFilter && (i = n.dataFilter(i, n.dataType)), k = y, y = H.shift(), y) {
                if (y === "*") y = k; else if (k !== "*" && k !== y) {
                    if (b = N[k + " " + y] || N["* " + y], !b) {
                        for (v in N) if (P = v.split(" "), P[1] === y && (b = N[k + " " + P[0]] || N["* " + P[0]], b)) {
                            b === !0 ? b = N[v] : N[v] !== !0 && (y = P[0], H.unshift(P[1]));
                            break
                        }
                    }
                    if (b !== !0) if (b && n.throws) i = b(i); else try {
                        i = b(i)
                    } catch (U) {
                        return {state: "parsererror", error: b ? U : "No conversion from " + k + " to " + y}
                    }
                }
            }
            return {state: "success", data: i}
        }

        p.extend({
            active: 0,
            lastModified: {},
            etag: {},
            ajaxSettings: {
                url: Gn.href,
                type: "GET",
                isLocal: Mo.test(Gn.protocol),
                global: !0,
                processData: !0,
                async: !0,
                contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                accepts: {
                    "*": ro,
                    text: "text/plain",
                    html: "text/html",
                    xml: "application/xml, text/xml",
                    json: "application/json, text/javascript"
                },
                contents: {xml: /\bxml\b/, html: /\bhtml/, json: /\bjson\b/},
                responseFields: {xml: "responseXML", text: "responseText", json: "responseJSON"},
                converters: {"* text": String, "text html": !0, "text json": JSON.parse, "text xml": p.parseXML},
                flatOptions: {url: !0, context: !0}
            },
            ajaxSetup: function (n, i) {
                return i ? vi(vi(n, p.ajaxSettings), i) : vi(p.ajaxSettings, n)
            },
            ajaxPrefilter: oo(De),
            ajaxTransport: oo(Re),
            ajax: function (n, i) {
                typeof n == "object" && (i = n, n = void 0), i = i || {};
                var f, l, v, y, b, P, k, N, H, U, q = p.ajaxSetup({}, i), K = q.context || q,
                    ne = q.context && (K.nodeType || K.jquery) ? p(K) : p.event, ve = p.Deferred(),
                    ge = p.Callbacks("once memory"), Ye = q.statusCode || {}, Ue = {}, Xt = {}, Nt = "canceled", we = {
                        readyState: 0, getResponseHeader: function (Z) {
                            var Le;
                            if (k) {
                                if (!y) for (y = {}; Le = Do.exec(v);) y[Le[1].toLowerCase() + " "] = (y[Le[1].toLowerCase() + " "] || []).concat(Le[2]);
                                Le = y[Z.toLowerCase() + " "]
                            }
                            return Le == null ? null : Le.join(", ")
                        }, getAllResponseHeaders: function () {
                            return k ? v : null
                        }, setRequestHeader: function (Z, Le) {
                            return k == null && (Z = Xt[Z.toLowerCase()] = Xt[Z.toLowerCase()] || Z, Ue[Z] = Le), this
                        }, overrideMimeType: function (Z) {
                            return k == null && (q.mimeType = Z), this
                        }, statusCode: function (Z) {
                            var Le;
                            if (Z) if (k) we.always(Z[we.status]); else for (Le in Z) Ye[Le] = [Ye[Le], Z[Le]];
                            return this
                        }, abort: function (Z) {
                            var Le = Z || Nt;
                            return f && f.abort(Le), _n(0, Le), this
                        }
                    };
                if (ve.promise(we), q.url = ((n || q.url || Gn.href) + "").replace(qo, Gn.protocol + "//"), q.type = i.method || i.type || q.method || q.type, q.dataTypes = (q.dataType || "*").toLowerCase().match($t) || [""], q.crossDomain == null) {
                    P = F.createElement("a");
                    try {
                        P.href = q.url, P.href = P.href, q.crossDomain = Jn.protocol + "//" + Jn.host != P.protocol + "//" + P.host
                    } catch {
                        q.crossDomain = !0
                    }
                }
                if (q.data && q.processData && typeof q.data != "string" && (q.data = p.param(q.data, q.traditional)), Vn(De, q, i, we), k) return we;
                N = p.event && q.global, N && p.active++ === 0 && p.event.trigger("ajaxStart"), q.type = q.type.toUpperCase(), q.hasContent = !gi.test(q.type), l = q.url.replace(di, ""), q.hasContent ? q.data && q.processData && (q.contentType || "").indexOf("application/x-www-form-urlencoded") === 0 && (q.data = q.data.replace(Io, "+")) : (U = q.url.slice(l.length), q.data && (q.processData || typeof q.data == "string") && (l += (jr.test(l) ? "&" : "?") + q.data, delete q.data), q.cache === !1 && (l = l.replace(No, "$1"), U = (jr.test(l) ? "&" : "?") + "_=" + hi.guid++ + U), q.url = l + U), q.ifModified && (p.lastModified[l] && we.setRequestHeader("If-Modified-Since", p.lastModified[l]), p.etag[l] && we.setRequestHeader("If-None-Match", p.etag[l])), (q.data && q.hasContent && q.contentType !== !1 || i.contentType) && we.setRequestHeader("Content-Type", q.contentType), we.setRequestHeader("Accept", q.dataTypes[0] && q.accepts[q.dataTypes[0]] ? q.accepts[q.dataTypes[0]] + (q.dataTypes[0] !== "*" ? ", " + ro + "; q=0.01" : "") : q.accepts["*"]);
                for (H in q.headers) we.setRequestHeader(H, q.headers[H]);
                if (q.beforeSend && (q.beforeSend.call(K, we, q) === !1 || k)) return we.abort();
                if (Nt = "abort", ge.add(q.complete), we.done(q.success), we.fail(q.error), f = Vn(Re, q, i, we), !f) _n(-1, "No Transport"); else {
                    if (we.readyState = 1, N && ne.trigger("ajaxSend", [we, q]), k) return we;
                    q.async && q.timeout > 0 && (b = m.setTimeout(function () {
                        we.abort("timeout")
                    }, q.timeout));
                    try {
                        k = !1, f.send(Ue, _n)
                    } catch (Z) {
                        if (k) throw Z;
                        _n(-1, Z)
                    }
                }

                function _n(Z, Le, mn, Br) {
                    var Dt, Nn, Tt, Gt, bn, ft = Le;
                    k || (k = !0, b && m.clearTimeout(b), f = void 0, v = Br || "", we.readyState = Z > 0 ? 4 : 0, Dt = Z >= 200 && Z < 300 || Z === 304, mn && (Gt = Ho(q, we, mn)), !Dt && p.inArray("script", q.dataTypes) > -1 && p.inArray("json", q.dataTypes) < 0 && (q.converters["text script"] = function () {
                    }), Gt = Kn(q, Gt, we, Dt), Dt ? (q.ifModified && (bn = we.getResponseHeader("Last-Modified"), bn && (p.lastModified[l] = bn), bn = we.getResponseHeader("etag"), bn && (p.etag[l] = bn)), Z === 204 || q.type === "HEAD" ? ft = "nocontent" : Z === 304 ? ft = "notmodified" : (ft = Gt.state, Nn = Gt.data, Tt = Gt.error, Dt = !Tt)) : (Tt = ft, (Z || !ft) && (ft = "error", Z < 0 && (Z = 0))), we.status = Z, we.statusText = (Le || ft) + "", Dt ? ve.resolveWith(K, [Nn, ft, we]) : ve.rejectWith(K, [we, ft, Tt]), we.statusCode(Ye), Ye = void 0, N && ne.trigger(Dt ? "ajaxSuccess" : "ajaxError", [we, q, Dt ? Nn : Tt]), ge.fireWith(K, [we, ft]), N && (ne.trigger("ajaxComplete", [we, q]), --p.active || p.event.trigger("ajaxStop")))
                }

                return we
            },
            getJSON: function (n, i, f) {
                return p.get(n, i, f, "json")
            },
            getScript: function (n, i) {
                return p.get(n, void 0, i, "script")
            }
        }), p.each(["get", "post"], function (n, i) {
            p[i] = function (f, l, v, y) {
                return J(l) && (y = y || v, v = l, l = void 0), p.ajax(p.extend({
                    url: f,
                    type: i,
                    dataType: y,
                    data: l,
                    success: v
                }, p.isPlainObject(f) && f))
            }
        }), p.ajaxPrefilter(function (n) {
            var i;
            for (i in n.headers) i.toLowerCase() === "content-type" && (n.contentType = n.headers[i] || "")
        }), p._evalUrl = function (n, i, f) {
            return p.ajax({
                url: n,
                type: "GET",
                dataType: "script",
                cache: !0,
                async: !1,
                global: !1,
                converters: {
                    "text script": function () {
                    }
                },
                dataFilter: function (l) {
                    p.globalEval(l, i, f)
                }
            })
        }, p.fn.extend({
            wrapAll: function (n) {
                var i;
                return this[0] && (J(n) && (n = n.call(this[0])), i = p(n, this[0].ownerDocument).eq(0).clone(!0), this[0].parentNode && i.insertBefore(this[0]), i.map(function () {
                    for (var f = this; f.firstElementChild;) f = f.firstElementChild;
                    return f
                }).append(this)), this
            }, wrapInner: function (n) {
                return J(n) ? this.each(function (i) {
                    p(this).wrapInner(n.call(this, i))
                }) : this.each(function () {
                    var i = p(this), f = i.contents();
                    f.length ? f.wrapAll(n) : i.append(n)
                })
            }, wrap: function (n) {
                var i = J(n);
                return this.each(function (f) {
                    p(this).wrapAll(i ? n.call(this, f) : n)
                })
            }, unwrap: function (n) {
                return this.parent(n).not("body").each(function () {
                    p(this).replaceWith(this.childNodes)
                }), this
            }
        }), p.expr.pseudos.hidden = function (n) {
            return !p.expr.pseudos.visible(n)
        }, p.expr.pseudos.visible = function (n) {
            return !!(n.offsetWidth || n.offsetHeight || n.getClientRects().length)
        }, p.ajaxSettings.xhr = function () {
            try {
                return new m.XMLHttpRequest
            } catch {
            }
        };
        var jo = {0: 200, 1223: 204}, je = p.ajaxSettings.xhr();
        Q.cors = !!je && "withCredentials" in je, Q.ajax = je = !!je, p.ajaxTransport(function (n) {
            var i, f;
            if (Q.cors || je && !n.crossDomain) return {
                send: function (l, v) {
                    var y, b = n.xhr();
                    if (b.open(n.type, n.url, n.async, n.username, n.password), n.xhrFields) for (y in n.xhrFields) b[y] = n.xhrFields[y];
                    n.mimeType && b.overrideMimeType && b.overrideMimeType(n.mimeType), !n.crossDomain && !l["X-Requested-With"] && (l["X-Requested-With"] = "XMLHttpRequest");
                    for (y in l) b.setRequestHeader(y, l[y]);
                    i = function (P) {
                        return function () {
                            i && (i = f = b.onload = b.onerror = b.onabort = b.ontimeout = b.onreadystatechange = null, P === "abort" ? b.abort() : P === "error" ? typeof b.status != "number" ? v(0, "error") : v(b.status, b.statusText) : v(jo[b.status] || b.status, b.statusText, (b.responseType || "text") !== "text" || typeof b.responseText != "string" ? {binary: b.response} : {text: b.responseText}, b.getAllResponseHeaders()))
                        }
                    }, b.onload = i(), f = b.onerror = b.ontimeout = i("error"), b.onabort !== void 0 ? b.onabort = f : b.onreadystatechange = function () {
                        b.readyState === 4 && m.setTimeout(function () {
                            i && f()
                        })
                    }, i = i("abort");
                    try {
                        b.send(n.hasContent && n.data || null)
                    } catch (P) {
                        if (i) throw P
                    }
                }, abort: function () {
                    i && i()
                }
            }
        }), p.ajaxPrefilter(function (n) {
            n.crossDomain && (n.contents.script = !1)
        }), p.ajaxSetup({
            accepts: {script: "text/javascript, application/javascript, application/ecmascript, application/x-ecmascript"},
            contents: {script: /\b(?:java|ecma)script\b/},
            converters: {
                "text script": function (n) {
                    return p.globalEval(n), n
                }
            }
        }), p.ajaxPrefilter("script", function (n) {
            n.cache === void 0 && (n.cache = !1), n.crossDomain && (n.type = "GET")
        }), p.ajaxTransport("script", function (n) {
            if (n.crossDomain || n.scriptAttrs) {
                var i, f;
                return {
                    send: function (l, v) {
                        i = p("<script>").attr(n.scriptAttrs || {}).prop({
                            charset: n.scriptCharset,
                            src: n.url
                        }).on("load error", f = function (y) {
                            i.remove(), f = null, y && v(y.type === "error" ? 404 : 200, y.type)
                        }), F.head.appendChild(i[0])
                    }, abort: function () {
                        f && f()
                    }
                }
            }
        });
        var Ur = [], nn = /(=)\?(?=&|$)|\?\?/;
        p.ajaxSetup({
            jsonp: "callback", jsonpCallback: function () {
                var n = Ur.pop() || p.expando + "_" + hi.guid++;
                return this[n] = !0, n
            }
        }), p.ajaxPrefilter("json jsonp", function (n, i, f) {
            var l, v, y,
                b = n.jsonp !== !1 && (nn.test(n.url) ? "url" : typeof n.data == "string" && (n.contentType || "").indexOf("application/x-www-form-urlencoded") === 0 && nn.test(n.data) && "data");
            if (b || n.dataTypes[0] === "jsonp") return l = n.jsonpCallback = J(n.jsonpCallback) ? n.jsonpCallback() : n.jsonpCallback, b ? n[b] = n[b].replace(nn, "$1" + l) : n.jsonp !== !1 && (n.url += (jr.test(n.url) ? "&" : "?") + n.jsonp + "=" + l), n.converters["script json"] = function () {
                return y || p.error(l + " was not called"), y[0]
            }, n.dataTypes[0] = "json", v = m[l], m[l] = function () {
                y = arguments
            }, f.always(function () {
                v === void 0 ? p(m).removeProp(l) : m[l] = v, n[l] && (n.jsonpCallback = i.jsonpCallback, Ur.push(l)), y && J(v) && v(y[0]), y = v = void 0
            }), "script"
        }), Q.createHTMLDocument = function () {
            var n = F.implementation.createHTMLDocument("").body;
            return n.innerHTML = "<form></form><form></form>", n.childNodes.length === 2
        }(), p.parseHTML = function (n, i, f) {
            if (typeof n != "string") return [];
            typeof i == "boolean" && (f = i, i = !1);
            var l, v, y;
            return i || (Q.createHTMLDocument ? (i = F.implementation.createHTMLDocument(""), l = i.createElement("base"), l.href = F.location.href, i.head.appendChild(l)) : i = F), v = Yr.exec(n), y = !f && [], v ? [i.createElement(v[1])] : (v = Hi([n], i, y), y && y.length && p(y).remove(), p.merge([], v.childNodes))
        }, p.fn.load = function (n, i, f) {
            var l, v, y, b = this, P = n.indexOf(" ");
            return P > -1 && (l = vn(n.slice(P)), n = n.slice(0, P)), J(i) ? (f = i, i = void 0) : i && typeof i == "object" && (v = "POST"), b.length > 0 && p.ajax({
                url: n,
                type: v || "GET",
                dataType: "html",
                data: i
            }).done(function (k) {
                y = arguments, b.html(l ? p("<div>").append(p.parseHTML(k)).find(l) : k)
            }).always(f && function (k, N) {
                b.each(function () {
                    f.apply(this, y || [k.responseText, N, k])
                })
            }), this
        }, p.expr.pseudos.animated = function (n) {
            return p.grep(p.timers, function (i) {
                return n === i.elem
            }).length
        }, p.offset = {
            setOffset: function (n, i, f) {
                var l, v, y, b, P, k, N, H = p.css(n, "position"), U = p(n), q = {};
                H === "static" && (n.style.position = "relative"), P = U.offset(), y = p.css(n, "top"), k = p.css(n, "left"), N = (H === "absolute" || H === "fixed") && (y + k).indexOf("auto") > -1, N ? (l = U.position(), b = l.top, v = l.left) : (b = parseFloat(y) || 0, v = parseFloat(k) || 0), J(i) && (i = i.call(n, f, p.extend({}, P))), i.top != null && (q.top = i.top - P.top + b), i.left != null && (q.left = i.left - P.left + v), "using" in i ? i.using.call(n, q) : U.css(q)
            }
        }, p.fn.extend({
            offset: function (n) {
                if (arguments.length) return n === void 0 ? this : this.each(function (v) {
                    p.offset.setOffset(this, n, v)
                });
                var i, f, l = this[0];
                if (!!l) return l.getClientRects().length ? (i = l.getBoundingClientRect(), f = l.ownerDocument.defaultView, {
                    top: i.top + f.pageYOffset,
                    left: i.left + f.pageXOffset
                }) : {top: 0, left: 0}
            }, position: function () {
                if (!!this[0]) {
                    var n, i, f, l = this[0], v = {top: 0, left: 0};
                    if (p.css(l, "position") === "fixed") i = l.getBoundingClientRect(); else {
                        for (i = this.offset(), f = l.ownerDocument, n = l.offsetParent || f.documentElement; n && (n === f.body || n === f.documentElement) && p.css(n, "position") === "static";) n = n.parentNode;
                        n && n !== l && n.nodeType === 1 && (v = p(n).offset(), v.top += p.css(n, "borderTopWidth", !0), v.left += p.css(n, "borderLeftWidth", !0))
                    }
                    return {
                        top: i.top - v.top - p.css(l, "marginTop", !0),
                        left: i.left - v.left - p.css(l, "marginLeft", !0)
                    }
                }
            }, offsetParent: function () {
                return this.map(function () {
                    for (var n = this.offsetParent; n && p.css(n, "position") === "static";) n = n.offsetParent;
                    return n || tn
                })
            }
        }), p.each({scrollLeft: "pageXOffset", scrollTop: "pageYOffset"}, function (n, i) {
            var f = i === "pageYOffset";
            p.fn[n] = function (l) {
                return Pt(this, function (v, y, b) {
                    var P;
                    if (G(v) ? P = v : v.nodeType === 9 && (P = v.defaultView), b === void 0) return P ? P[i] : v[y];
                    P ? P.scrollTo(f ? P.pageXOffset : b, f ? b : P.pageYOffset) : v[y] = b
                }, n, l, arguments.length)
            }
        }), p.each(["top", "left"], function (n, i) {
            p.cssHooks[i] = hr(Q.pixelPosition, function (f, l) {
                if (l) return l = lr(f, i), ti.test(l) ? p(f).position()[i] + "px" : l
            })
        }), p.each({Height: "height", Width: "width"}, function (n, i) {
            p.each({padding: "inner" + n, content: i, "": "outer" + n}, function (f, l) {
                p.fn[l] = function (v, y) {
                    var b = arguments.length && (f || typeof v != "boolean"),
                        P = f || (v === !0 || y === !0 ? "margin" : "border");
                    return Pt(this, function (k, N, H) {
                        var U;
                        return G(k) ? l.indexOf("outer") === 0 ? k["inner" + n] : k.document.documentElement["client" + n] : k.nodeType === 9 ? (U = k.documentElement, Math.max(k.body["scroll" + n], U["scroll" + n], k.body["offset" + n], U["offset" + n], U["client" + n])) : H === void 0 ? p.css(k, N, P) : p.style(k, N, H, P)
                    }, i, b ? v : void 0, b)
                }
            })
        }), p.each(["ajaxStart", "ajaxStop", "ajaxComplete", "ajaxError", "ajaxSuccess", "ajaxSend"], function (n, i) {
            p.fn[i] = function (f) {
                return this.on(i, f)
            }
        }), p.fn.extend({
            bind: function (n, i, f) {
                return this.on(n, null, i, f)
            }, unbind: function (n, i) {
                return this.off(n, null, i)
            }, delegate: function (n, i, f, l) {
                return this.on(i, n, f, l)
            }, undelegate: function (n, i, f) {
                return arguments.length === 1 ? this.off(n, "**") : this.off(i, n || "**", f)
            }, hover: function (n, i) {
                return this.on("mouseenter", n).on("mouseleave", i || n)
            }
        }), p.each("blur focus focusin focusout resize scroll click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup contextmenu".split(" "), function (n, i) {
            p.fn[i] = function (f, l) {
                return arguments.length > 0 ? this.on(i, null, f, l) : this.trigger(i)
            }
        });
        var so = /^[\s\uFEFF\xA0]+|([^\s\uFEFF\xA0])[\s\uFEFF\xA0]+$/g;
        p.proxy = function (n, i) {
            var f, l, v;
            if (typeof i == "string" && (f = n[i], i = n, n = f), !!J(n)) return l = I.call(arguments, 2), v = function () {
                return n.apply(i || this, l.concat(I.call(arguments)))
            }, v.guid = n.guid = n.guid || p.guid++, v
        }, p.holdReady = function (n) {
            n ? p.readyWait++ : p.ready(!0)
        }, p.isArray = Array.isArray, p.parseJSON = JSON.parse, p.nodeName = _e, p.isFunction = J, p.isWindow = G, p.camelCase = st, p.type = Ne, p.now = Date.now, p.isNumeric = function (n) {
            var i = p.type(n);
            return (i === "number" || i === "string") && !isNaN(n - parseFloat(n))
        }, p.trim = function (n) {
            return n == null ? "" : (n + "").replace(so, "$1")
        };
        var yi = m.jQuery, Ct = m.$;
        return p.noConflict = function (n) {
            return m.$ === p && (m.$ = Ct), n && m.jQuery === p && (m.jQuery = yi), p
        }, typeof d == "undefined" && (m.jQuery = m.$ = p), p
    })
})(Oc);
var Y = Oc.exports;
const Fe = new Metered.Meeting;
let Er = !1, Li = !1, Ju = !1, Ut = null, xo = null, fc = {};

async function y0() {
    const C = await Fe.listVideoInputDevices(), m = [];
    for (let S of C) m.push(`<option value="${S.deviceId}">${S.label}</option>`);
    Y("#cameraSelectBox").html(m.join(""));
    const d = await Fe.listAudioInputDevices(), A = [];
    for (let S of d) A.push(`<option value="${S.deviceId}">${S.label}</option>`);
    Y("#microphoneSelectBox").html(A.join("")), Y("#waitingAreaToggleMicrophone").on("click", function () {
        Li ? (Li = !1, Y("#waitingAreaToggleMicrophone").removeClass("bg-gray-500"), Y("#waitingAreaToggleMicrophone").addClass("bg-gray-400")) : (Li = !0, Y("#waitingAreaToggleMicrophone").removeClass("bg-gray-400"), Y("#waitingAreaToggleMicrophone").addClass("bg-gray-500"))
    }), Y("#waitingAreaToggleCamera").on("click", async function () {
        Er ? (Er = !1, Y("#waitingAreaToggleCamera").removeClass("bg-gray-500"), Y("#waitingAreaToggleCamera").addClass("bg-gray-400"), Ut.getTracks().forEach(function (I) {
            I.stop()
        }), Ut = null, Y("#waitingAreaLocalVideo")[0].srcObject = null) : (Er = !0, Y("#waitingAreaToggleCamera").removeClass("bg-gray-400"), Y("#waitingAreaToggleCamera").addClass("bg-gray-500"), Ut = await Fe.getLocalVideoStream(), Y("#waitingAreaLocalVideo")[0].srcObject = Ut, Er = !0)
    }), Y("#cameraSelectBox").on("change", async function () {
        const S = Y("#cameraSelectBox").val();
        await Fe.chooseVideoInputDevice(S), Er && (Ut = await Fe.getLocalVideoStream(), Y("#waitingAreaLocalVideo")[0].srcObject = Ut)
    }), Y("#microphoneSelectBox").on("change", async function () {
        const S = Y("#microphoneSelectBox").val();
        await Fe.chooseAudioInputDevice(S)
    })
}

y0();
Y("#joinMeetingBtn").on("click", async function () {
    var C = Y("#username").val();
    if (!C) return alert("Please enter a username");
    try {
        fc = await Fe.join({
            roomURL: `${window.METERED_DOMAIN}/${window.MEETING_ID}`,
            name: C
        }), console.log("Meeting joined", fc), Y("#waitingArea").addClass("hidden"), Y("#meetingView").removeClass("hidden"), Y("#meetingAreaUsername").text(C), Er && (await Fe.startVideo(), Y("#localVideoTag")[0].srcObject = Ut, Y("#localVideoTag")[0].play(), Y("#toggleCamera").removeClass("bg-gray-400"), Y("#toggleCamera").addClass("bg-gray-500")), Li && (Y("#toggleMicrophone").removeClass("bg-gray-400"), Y("#toggleMicrophone").addClass("bg-gray-500"), await Fe.startAudio())
    } catch (m) {
        console.log("Error occurred when joining the meeting", m)
    }
});
Fe.on("onlineParticipants", function (C) {
    for (let m of C) !Y(`#participant-${m._id}`)[0] && m._id !== Fe.participantInfo._id && Y("#remoteParticipantContainer").append(`
          <div id="participant-${m._id}" class="w-48 h-48 rounded-3xl bg-gray-900 relative">
            <video id="video-${m._id}" src="" autoplay class="object-contain w-full rounded-t-3xl"></video>
            <video id="audio-${m._id}" src="" autoplay class="hidden"></video>
            <div class="absolute h-8 w-full bg-gray-700 rounded-b-3xl bottom-0 text-white text-center font-bold pt-1">
                ${m.name}
            </div>
          </div>
          `)
});
Fe.on("participantLeft", function (C) {
    Y("#participant-" + C._id).remove(), C._id === xo && (Y("#activeSpeakerUsername").text(""), Y("#activeSpeakerUsername").addClass("hidden"))
});
Fe.on("remoteTrackStarted", function (C) {
    if (Y("#activeSpeakerUsername").removeClass("hidden"), C.type === "video") {
        let m = new MediaStream;
        m.addTrack(C.track), Y("#video-" + C.participantSessionId)[0] && (Y("#video-" + C.participantSessionId)[0].srcObject = m, Y("#video-" + C.participantSessionId)[0].play())
    }
    if (C.type === "audio") {
        let m = new MediaStream;
        m.addTrack(C.track), Y("#video-" + C.participantSessionId)[0] && (Y("#audio-" + C.participantSessionId)[0].srcObject = m, Y("#audio-" + C.participantSessionId)[0].play())
    }
    Pc(C)
});
Fe.on("remoteTrackStopped", function (C) {
    C.type === "video" && (Y("#video-" + C.participantSessionId)[0] && (Y("#video-" + C.participantSessionId)[0].srcObject = null, Y("#video-" + C.participantSessionId)[0].pause()), C.participantSessionId === xo && (Y("#activeSpeakerVideo")[0].srcObject = null, Y("#activeSpeakerVideo")[0].pause())), C.type === "audio" && Y("#audio-" + C.participantSessionId)[0] && (Y("#audio-" + C.participantSessionId)[0].srcObject = null, Y("#audio-" + C.participantSessionId)[0].pause())
});
Fe.on("activeSpeaker", function (C) {
    Pc(C)
});

function Pc(C) {
    if (xo != C.participantSessionId && Y(`#participant-${xo}`).show(), xo = C.participantSessionId, Y(`#participant-${xo}`).hide(), Y("#activeSpeakerUsername").text(C.name || C.participant.name), Y(`#video-${C.participantSessionId}`)[0]) {
        let m = Y(`#video-${C.participantSessionId}`)[0].srcObject;
        Y("#activeSpeakerVideo")[0].srcObject = m.clone()
    }
    if (C.participantSessionId === Fe.participantSessionId) {
        let m = Y("#localVideoTag")[0].srcObject;
        m && (Y("#localVideoTag")[0].srcObject = m.clone())
    }
}

Y("#toggleMicrophone").on("click", async function () {
    Li ? (Y("#toggleMicrophone").removeClass("bg-gray-500"), Y("#toggleMicrophone").addClass("bg-gray-400"), Li = !1, await Fe.stopAudio()) : (Y("#toggleMicrophone").removeClass("bg-gray-400"), Y("#toggleMicrophone").addClass("bg-gray-500"), Li = !0, await Fe.startAudio())
});
Y("#toggleCamera").on("click", async function () {
    Er ? (Y("#toggleCamera").removeClass("bg-gray-500"), Y("#toggleCamera").addClass("bg-gray-400"), Y("#toggleScreen").removeClass("bg-gray-500"), Y("#toggleScreen").addClass("bg-gray-400"), Er = !1, await Fe.stopVideo(), Ut.getTracks().forEach(function (m) {
        m.stop()
    }), Ut = null, Y("#localVideoTag")[0].srcObject = null) : (Y("#toggleCamera").removeClass("bg-gray-400"), Y("#toggleCamera").addClass("bg-gray-500"), Er = !0, await Fe.startVideo(), Ut = await Fe.getLocalVideoStream(), Y("#localVideoTag")[0].srcObject = Ut)
});
Y("#toggleScreen").on("click", async function () {
    Ju ? (Y("#toggleScreen").removeClass("bg-gray-500"), Y("#toggleScreen").addClass("bg-gray-400"), Ju = !1, await Fe.stopVideo(), Ut.getTracks().forEach(function (m) {
        m.stop()
    }), Ut = null, Y("#localVideoTag")[0].srcObject = null) : (Y("#toggleScreen").removeClass("bg-gray-400"), Y("#toggleScreen").addClass("bg-gray-500"), Y("#toggleCamera").removeClass("bg-gray-500"), Y("#toggleCamera").addClass("bg-gray-400"), Ju = !0, Ut = await Fe.startScreenShare(), Y("#localVideoTag")[0].srcObject = Ut)
});
Y("#leaveMeeting").on("click", async function () {
    await Fe.leaveMeeting(), Y("#meetingView").addClass("hidden"), Y("#leaveMeetingView").removeClass("hidden")
});
window.Vue = require("vue");
new Vue({el: "#app", components: {}});
window.Pusher = kc;
window.Echo = new fa({
    broadcaster: "pusher",
    key: {}.MIX_PUSHER_APP_KEY,
    cluster: {}.MIX_PUSHER_APP_CLUSTER,
    encrypted: !0
});
fa.channel(`messages.${globalThis.user.id}`).listen("NewMessage", C => {
    globalThis.handleIncoming(C.message)
});
