/**
 * 鍒ゆ柇娴忚鍣ㄦ槸鍚︿负IE鍙婂垽鏂叾鐗堟湰
 */
function IEVersion() {
    var userAgent = navigator.userAgent; //鍙栧緱娴忚鍣ㄧ殑userAgent瀛楃涓�  
    var isIE = userAgent.indexOf("compatible") > -1 && userAgent.indexOf("MSIE") > -1; //鍒ゆ柇鏄惁IE<11娴忚鍣�  
    var isEdge = userAgent.indexOf("Edge") > -1 && !isIE; //鍒ゆ柇鏄惁IE鐨凟dge娴忚鍣�  
    var isIE11 = userAgent.indexOf('Trident') > -1 && userAgent.indexOf("rv:11.0") > -1;
    if (isIE) {
        var reIE = new RegExp("MSIE (\\d+\\.\\d+);");
        reIE.test(userAgent);
        var fIEVersion = parseFloat(RegExp["$1"]);
        if (fIEVersion == 7) {
            return 7;
        } else if (fIEVersion == 8) {
            return 8;
        } else if (fIEVersion == 9) {
            return 9;
        } else if (fIEVersion == 10) {
            return 10;
        } else {
            return 6;//IE鐗堟湰<=7
        }
    } else if (isEdge) {
        return 'edge';//edge
    } else if (isIE11) {
        return 11; //IE11  
    } else {
        return -1;//涓嶆槸ie娴忚鍣�
    }
}

// jQ_cookie
/*!
 * jQuery Cookie 鎻掍欢 v1.4.1
 * https://github.com/carhartl/jquery-cookie
 *
 * Copyright 2013 Klaus Hartl
 * Released under the MIT license
 */
(function (factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD
        define(['jquery'], factory);
    } else if (typeof exports === 'object') {
        // CommonJS
        factory(require('jquery'));
    } else {
        // Browser globals
        factory(jQuery);
    }
}(function ($) {

    var pluses = /\+/g;

    function encode(s) {
        return config.raw ? s : encodeURIComponent(s);
    }

    function decode(s) {
        return config.raw ? s : decodeURIComponent(s);
    }

    function stringifyCookieValue(value) {
        return encode(config.json ? JSON.stringify(value) : String(value));
    }

    function parseCookieValue(s) {
        if (s.indexOf('"') === 0) {
            // This is a quoted cookie as according to RFC2068, unescape...
            s = s.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, '\\');
        }

        try {
            // Replace server-side written pluses with spaces.
            // If we can't decode the cookie, ignore it, it's unusable.
            // If we can't parse the cookie, ignore it, it's unusable.
            s = decodeURIComponent(s.replace(pluses, ' '));
            return config.json ? JSON.parse(s) : s;
        } catch (e) {
        }
    }

    function read(s, converter) {
        var value = config.raw ? s : parseCookieValue(s);
        return $.isFunction(converter) ? converter(value) : value;
    }

    var config = $.cookie = function (key, value, options) {

        // Write

        if (value !== undefined && !$.isFunction(value)) {
            options = $.extend({}, config.defaults, options);

            if (typeof options.expires === 'number') {
                var days = options.expires, t = options.expires = new Date();
                t.setTime(+t + days * 864e+5);
            }

            return (document.cookie = [
                encode(key), '=', stringifyCookieValue(value),
                options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
                options.path ? '; path=' + options.path : '',
                options.domain ? '; domain=' + options.domain : '',
                options.secure ? '; secure' : ''
            ].join(''));
        }

        // Read

        var result = key ? undefined : {};

        // To prevent the for loop in the first place assign an empty array
        // in case there are no cookies at all. Also prevents odd result when
        // calling $.cookie().
        var cookies = document.cookie ? document.cookie.split('; ') : [];

        for (var i = 0, l = cookies.length; i < l; i++) {
            var parts = cookies[i].split('=');
            var name = decode(parts.shift());
            var cookie = parts.join('=');

            if (key && key === name) {
                // If second argument (value) is a function it's a converter...
                result = read(cookie, value);
                break;
            }

            // Prevent storing a cookie that we couldn't decode.
            if (!key && (cookie = read(cookie)) !== undefined) {
                result[name] = cookie;
            }
        }

        return result;
    };

    config.defaults = {};

    $.removeCookie = function (key, options) {
        if ($.cookie(key) === undefined) {
            return false;
        }

        // Must not alter options, thus extending a fresh object...
        $.cookie(key, '', $.extend({}, options, {expires: -1}));
        return !$.cookie(key);
    };

}));


/**
 * @method 鍒ゆ柇娴忚鍣ㄦ槸鍚︿负360鏋侀€熷唴鏍�
 */

    // https://github.com/cloudcome/alien/issues/4

var win = window;
var nav = win.navigator;
var doc = win.document;
var ieAX = win.ActiveXObject;
var ieMode = doc.documentMode;
var REG_APPLE = /^Apple/;
var ieVer = _getIeVersion() || ieMode || 0;
var isIe = ieAX || ieMode;
var chromiumType = _getChromiumType();

var defineBrowser = {
    /**
     * 鍒ゆ柇鏄惁涓� IE 娴忚鍣�
     *
     * @example
     * shell.isIE;
     * // true or false
     */
    isIE: (function () {
        return !!ieVer;
    })(),
    /**
     * IE 鐗堟湰
     *
     * @example
     * shell.ieVersion;
     * // 6/7/8/9/10/11/12...
     */
    ieVersion: (function () {
        return ieVer;
    })(),
    /**
     * 鏄惁涓鸿胺姝� chrome 娴忚鍣�
     *
     * @example
     * shell.isChrome;
     * // true or false
     */
    isChrome: (function () {
        return chromiumType === 'chrome';
    })(),
    /**
     * 鏄惁涓�360瀹夊叏娴忚鍣�
     *
     * @example
     * shell.is360se;
     * // true or false
     */
    is360se: (function () {
        return chromiumType === '360se';
    })(),
    /**
     * 鏄惁涓�360鏋侀€熸祻瑙堝櫒
     *
     * @example
     * shell.is360ee;
     * // true or false
     */
    is360ee: (function () {
        return chromiumType === '360ee';
    })(),
    /**
     * 鏄惁涓虹寧璞瑰畨鍏ㄦ祻瑙堝櫒
     *
     * @example
     * shell.isLiebao;
     * // true or false
     */
    isLiebao: (function () {
        return chromiumType === 'liebao';
    })(),
    /**
     * 鏄惁鎼滅嫍楂橀€熸祻瑙堝櫒
     *
     * @example
     * shell.isSogou;
     * // true or false
     */
    isSogou: (function () {
        return chromiumType === 'sogou';
    })(),
    /**
     * 鏄惁涓� QQ 娴忚鍣�
     *
     * @example
     * shell.isQQ;
     * // true or false
     */
    isQQ: (function () {
        return chromiumType === 'qq';
    })()
};


/**
 * 妫€娴� external 鏄惁鍖呭惈璇ュ瓧娈�
 * @param reg 姝ｅ垯
 * @param type 妫€娴嬬被鍨嬶紝0涓洪敭锛�1涓哄€�
 * @returns {boolean}
 * @private
 */
function _testExternal(reg, type) {
    var external = win.external || {};

    for (var i in external) {
        if (reg.test(type ? external[i] : i)) {
            return true;
        }
    }

    return false;
}


/**
 * 鑾峰彇 Chromium 鍐呮牳娴忚鍣ㄧ被鍨�
 * @link http://www.adtchrome.com/js/help.js
 * @link https://ext.chrome.360.cn/webstore
 * @link https://ext.se.360.cn
 * @return {String}
 *         360ee 360鏋侀€熸祻瑙堝櫒
 *         360se 360瀹夊叏娴忚鍣�
 *         sougou 鎼滅嫍娴忚鍣�
 *         liebao 鐚庤惫娴忚鍣�
 *         chrome 璋锋瓕娴忚鍣�
 *         ''    鏃犳硶鍒ゆ柇
 * @version 1.0
 * 2014骞�3鏈�12鏃�20:39:55
 */

function _getChromiumType() {
    if (isIe || typeof win.scrollMaxX !== 'undefined' || REG_APPLE.test(nav.vendor || '')) {
        return '';
    }

    var _track = 'track' in document.createElement('track');
    var webstoreKeysLength = win.chrome && win.chrome.webstore ? Object.keys(win.chrome.webstore).length : 0;

    // 鎼滅嫍娴忚鍣�
    if (_testExternal(/^sogou/i, 0)) {
        return 'sogou';
    }

    // 鐚庤惫娴忚鍣�
    if (_testExternal(/^liebao/i, 0)) {
        return 'liebao';
    }

    // chrome
    if (win.clientInformation && win.clientInformation.permissions) {
        return 'chrome';
    }

    if (_track) {
        // 360鏋侀€熸祻瑙堝櫒
        // 360瀹夊叏娴忚鍣�
        return webstoreKeysLength > 1 ? '360ee' : '360se';
    }

    return '';
}


// 鑾峰緱ie娴忚鍣ㄧ増鏈�

function _getIeVersion() {
    var v = 3,
        p = document.createElement('p'),
        all = p.getElementsByTagName('i');

    while (
        p.innerHTML = '<!--[if gt IE ' + (++v) + ']><i></i><![endif]-->',
            all[0]) ;

    return v > 4 ? v : 0;
}
