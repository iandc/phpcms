function g(o) {
    if (o) {
        return document.getElementById(o);
    }
}

function HoverLi(n) {
    for (var i = 1; i <= 25; i++) {
        if (g('tb_' + i) != null) {
            g('tb_' + i).className = 'normaltab_top';
            g('tbc_0' + i).className = 'undis_top';
        }
    }
    g('tbc_0' + n).className = 'dis_top';
    g('tb_' + n).className = 'hovertab_top';
}


function scrollLeft(wrap, option) {

    var jQuerywrap = jQuery(wrap), // 婢舵牕鐪伴崗鍐
        jQuerycontent = jQuery(wrap + ' ul'), // 閸愬懎鐪伴崗鍐
        jQueryelement = jQuery(wrap + ' li'), // 鐎涙劕鐪伴崗鍐
        jQuerycloneElement = jQueryelement.clone(true), // 閸忓娈曠€涙劕鐪伴崗鍐
        _width = jQueryelement.size() * jQueryelement.outerWidth(true), // 閹顔旀惔锟�
        _scrollValue = 0, // 閸嬪繒些闁诧拷
        option = option || {}, // 閸欘垶鈧鍘ょ純锟�
        t;

    option.speed = option.speed || '25';
    // 婵″倹鐏夌€涙劕鐪伴崗鍐閹顔旀惔锕€鐨禍搴☆樆鐏炲倸鍘撶槐鐘差啍鎼达讣绱濋崚娆掔箲閸ワ拷
    if (_width <= jQuerywrap.width()) {
        return false;
    }
    // 閸︺劌鍞寸仦鍌氬帗缁辩姳鑵戦幓鎺戝弳閸忓娈曠€涙劕鐪伴崗鍐
    jQuerycontent.append(jQuerycloneElement);
    // 閸愬懎鐪伴崗鍐濞ｈ濮炵€硅棄瀹抽敍宀€娲伴惃鍕Ц鐠佲晛鐡欑仦鍌氬帗缁辩姵妯夌粈杞拌礋娑撯偓鐞涳拷
    jQuerycontent.css('width', _width * 2);

    // 濠婃艾濮╅弫鍫熺亯
    function marquee() {
        // clearTimeout(t);
        _scrollValue = _scrollValue >= _width ? 0 : _scrollValue;
        jQuerywrap.scrollLeft(_scrollValue);
        _scrollValue++;
        // 娴ｈ法鏁etTimeout閸滃矂鈧帒缍婄拫鍐暏娴狅絾娴泂etInterval
        t = setTimeout(function () {
            marquee();
        }, option.speed);
    }

    // 閹笛嗩攽濠婃艾濮╅弫鍫熺亯閸戣姤鏆�
    marquee();

    // 姒х姵鐖ｇ紒蹇氱箖閿涘本绔诲Δ姘暰閺冭泛娅掗敍灞炬畯閸嬫粍绮撮崝銊︽櫏閺嬶拷
    jQuery('body').on('mouseover', wrap, function () {
        clearTimeout(t);
    });

    // 姒х姵鐖ｇ粋璇茬磻閿涘苯娲栨径宥呯暰閺冭泛娅掗敍灞界磻婵绮撮崝锟�
    jQuery('body').on('mouseout', wrap, function () {
        t = setTimeout(function () {
            marquee();
        }, option.speed);
    });

}

/*
 * Cookie閿熸枻鎷烽敓鏂ゆ嫹
 */

//var domain = "www.ofweekb2b.com";

function setCookie(name, value, expires) {
    document.cookie = name + "=" + escape(value)
        + ("; path=/; domain=" + domain)
        + ((expires) ? "; expires=" + expires.toGMTString() : "");
}

function getCookie(name) {

    var prefix = name + "=";
    var start = document.cookie.indexOf(prefix);
    if (start == -1)
        return null;
    var end = document.cookie.indexOf(";", start + prefix.length);
    if (end == -1)
        end = document.cookie.length;
    var value = document.cookie.substring(start + prefix.length, end);
    value = decodeURIComponent(value)
    return value;
}

function deleteCookie(name) {
    if (getCookie(name))
        document.cookie = name + "=" + ("; path=/; domain=" + domain)
            + ";expires=Fri, 31 Dec 1999 23:59:59 GMT;";
}

function xiala(type) {
    document.getElementById("type").value = type;

}

function xialanew(type) {
    document.getElementById("mytype").value = type;
}

//閿熸枻鎷烽〉閿熸枻鎷烽敓鏂ゆ嫹閿熸枻鎷烽〉涓撻敓鏂ゆ嫹
function querynew() {

    var element = document.getElementById("mytype");

    var type = "";
    if (element.options) {
        type = element.options[element.selectedIndex].value;
    } else {
        type = element.value;
    }
    //var keywords = encodeURIComponent(document.getElementById("searchkeywords").value);
    var keywords = document.getElementById("searchkeywords").value;

    //keywords = keywords.replace(new RegExp("%20", "gm"), "%2520").replace(new RegExp("%26", "gm"), "%2526").replace(new RegExp("%2F", "gm"), "%252F");

    if (type == '0' || type == '1') {
        //window.open("http://www.ofweek.com/SEARCH/WENZHANG/"+encodeURIComponent(keywords)+".HTM");
        window.location.href = "http://www.ofweek.com/newquery.action?keywords=" + encodeURIComponent(keywords) + "&type=" + type;
    } else if (type == '2') {
        //window.open("http://www.ofweek.com/SEARCH/WENKU/"+encodeURIComponent(keywords)+".HTM");
        window.location.href = "http://www.ofweek.com/newquery.action?keywords=" + encodeURIComponent(keywords) + "&type=" + type;
    } else if (type == '3') {
        //window.open("http://www.ofweek.com/SEARCH/PRODUCT/"+encodeURIComponent(keywords)+".HTM");
        window.location.href = "http://www.ofweek.com/newquery.action?keywords=" + encodeURIComponent(keywords) + "&type=" + type;
    } else if (type == '4') {
        //window.open("http://www.ofweek.com/SEARCH/BBS/"+encodeURIComponent(keywords)+".HTM");
        window.location.href = "http://www.ofweek.com/newquery.action?keywords=" + encodeURIComponent(keywords) + "&type=" + type;
    } else if (type == '5') {
        //window.open("http://www.ofweek.com/SEARCH/JOB/"+encodeURIComponent(keywords)+".HTM");
        window.location.href = "http://www.ofweek.com/newquery.action?keywords=" + encodeURIComponent(keywords) + "&type=" + type;
    } else if (type == '6') {
        //window.open("http://www.ofweek.com/SEARCH/REPORT/"+encodeURIComponent(keywords)+".HTM");
        window.location.href = "http://www.ofweek.com/newquery.action?keywords=" + encodeURIComponent(keywords) + "&type=" + type;
    }


}


//report 涓撻敓鏂ゆ嫹
function reportquery() {
    var element = document.getElementById("newtype");
    var sort = document.getElementById("sort");

    var type = "";
    var sortvalue = "0";
    if (element.options) {
        type = element.options[element.selectedIndex].value;
    } else {
        type = element.value;
    }
    if (sort != null) {
        if (sort.options) {
            sortvalue = sort.options[sort.selectedIndex].value;
        } else {
            sortvalue = sort.value;
        }
    }


    var keywords = encodeURIComponent(document.getElementById("searchkeywords").value);

    keywords = keywords.replace(new RegExp("%20", "gm"), "%2520").replace(new RegExp("%26", "gm"), "%2526").replace(new RegExp("%2F", "gm"), "%252F");

    if (sort == null) {
        if (type == '0' || type == '1') {
            //window.open("http://www.ofweek.com/SEARCH/WENZHANG/"+encodeURIComponent(keywords)+".HTM");
            window.location.href = "http://www.ofweek.com/newquery.action?keywords=" + encodeURIComponent(keywords) + "&type=" + type;
        } else if (type == '2') {
            //window.open( "http://www.ofweek.com/SEARCH/WENKU/"+encodeURIComponent(keywords)+".HTM");
            window.location.href = "http://www.ofweek.com/newquery.action?keywords=" + encodeURIComponent(keywords) + "&type=" + type;
        } else if (type == '3') {
            //window.open( "http://www.ofweek.com/SEARCH/PRODUCT/"+encodeURIComponent(keywords)+".HTM");
            window.location.href = "http://www.ofweek.com/newquery.action?keywords=" + encodeURIComponent(keywords) + "&type=" + type;
        } else if (type == '4') {
            //window.open("http://www.ofweek.com/SEARCH/BBS/"+encodeURIComponent(keywords)+".HTM");
            window.location.href = "http://www.ofweek.com/newquery.action?keywords=" + encodeURIComponent(keywords) + "&type=" + type;
        } else if (type == '5') {
            //window.open("http://www.ofweek.com/SEARCH/JOB/"+encodeURIComponent(keywords)+".HTM");
            window.location.href = "http://www.ofweek.com/newquery.action?keywords=" + encodeURIComponent(keywords) + "&type=" + type;
        } else if (type == '6') {
            if (sortvalue == '1') {
                window.open("http://www.ofweek.com/research/search.do?keywords=" + encodeURIComponent(keywords) + "&sort=1");
            } else {
                //window.open("http://research.ofweek.com/search/"+encodeURIComponent(keywords)+".HTM");
                window.open("http://www.ofweek.com/research/search.do?keywords=" + encodeURIComponent(keywords));
            }
        }
    } else {
        if (type == '0' || type == '1') {
            //window.location.href="http://www.ofweek.com/SEARCH/WENZHANG/"+encodeURIComponent(keywords)+".HTM";
            window.location.href = "http://www.ofweek.com/newquery.action?keywords=" + encodeURIComponent(keywords) + "&type=" + type;
        } else if (type == '2') {
            //window.location.href="http://www.ofweek.com/SEARCH/WENKU/"+encodeURIComponent(keywords)+".HTM";
            window.location.href = "http://www.ofweek.com/newquery.action?keywords=" + encodeURIComponent(keywords) + "&type=" + type;
        } else if (type == '3') {
            //window.location.href= "http://www.ofweek.com/SEARCH/PRODUCT/"+encodeURIComponent(keywords)+".HTM";
            window.location.href = "http://www.ofweek.com/newquery.action?keywords=" + encodeURIComponent(keywords) + "&type=" + type;
        } else if (type == '4') {
            //window.location.href="http://www.ofweek.com/SEARCH/BBS/"+encodeURIComponent(keywords)+".HTM";
            window.location.href = "http://www.ofweek.com/newquery.action?keywords=" + encodeURIComponent(keywords) + "&type=" + type;
        } else if (type == '5') {
            //window.location.href="http://www.ofweek.com/SEARCH/JOB/"+encodeURIComponent(keywords)+".HTM";
            window.location.href = "http://www.ofweek.com/newquery.action?keywords=" + encodeURIComponent(keywords) + "&type=" + type;
        } else if (type == '6') {
            if (sortvalue == '1') {
                window.location.href = "http://www.ofweek.com/research/search.do?keywords=" + encodeURIComponent(keywords) + "&sort=1";
            } else {
                //window.location.href="http://research.ofweek.com/search/"+encodeURIComponent(keywords)+".HTM";
                window.location.href = "http://www.ofweek.com/research/search.do?keywords=" + encodeURIComponent(keywords);
            }
        }
    }


}


function reportprivatequery() {
    var element = document.getElementById("newtype");
    var sort = document.getElementById("sort");

    var type = "";
    var sortvalue = "0";
    if (element.options) {
        type = element.options[element.selectedIndex].value;
    } else {
        type = element.value;
    }
    if (sort != null) {
        if (sort.options) {
            sortvalue = sort.options[sort.selectedIndex].value;
        } else {
            sortvalue = sort.value;
        }
    }


    var keywords = encodeURIComponent(document.getElementById("searchkeywords").value);

    keywords = keywords.replace(new RegExp("%20", "gm"), "%2520").replace(new RegExp("%26", "gm"), "%2526").replace(new RegExp("%2F", "gm"), "%252F");


    if (type == '0' || type == '1') {
        //window.location.href="http://www.ofweek.com/SEARCH/WENZHANG/"+encodeURIComponent(keywords)+".HTM";
        window.location.href = "http://www.ofweek.com/newquery.action?keywords=" + encodeURIComponent(keywords) + "&type=" + type;
    } else if (type == '2') {
        //window.location.href="http://www.ofweek.com/SEARCH/WENKU/"+encodeURIComponent(keywords)+".HTM";
        window.location.href = "http://www.ofweek.com/newquery.action?keywords=" + encodeURIComponent(keywords) + "&type=" + type;
    } else if (type == '3') {
        //window.location.href= "http://www.ofweek.com/SEARCH/PRODUCT/"+encodeURIComponent(keywords)+".HTM";
        window.location.href = "http://www.ofweek.com/newquery.action?keywords=" + encodeURIComponent(keywords) + "&type=" + type;
    } else if (type == '4') {
        //window.location.href="http://www.ofweek.com/SEARCH/BBS/"+encodeURIComponent(keywords)+".HTM";
        window.location.href = "http://www.ofweek.com/newquery.action?keywords=" + encodeURIComponent(keywords) + "&type=" + type;
    } else if (type == '5') {
        //window.location.href="http://www.ofweek.com/SEARCH/JOB/"+encodeURIComponent(keywords)+".HTM";
        window.location.href = "http://www.ofweek.com/newquery.action?keywords=" + encodeURIComponent(keywords) + "&type=" + type;
    } else if (type == '6') {
        if (sortvalue == '1') {
            window.location.href = "http://www.ofweek.com/research/search.do?keywords=" + encodeURIComponent(keywords) + "&sort=1";
        } else {
            //window.location.href="http://research.ofweek.com/search/"+encodeURIComponent(keywords)+".HTM";
            window.location.href = "http://www.ofweek.com/research/search.do?keywords=" + encodeURIComponent(keywords);
        }
    }

}

//閿熸枻鎷烽敓鏂ゆ嫹棰戦敓鏂ゆ嫹涓撻敓鏂ゆ嫹
function querynewChannel() {

    var element = document.getElementById("newtype");

    var type = "";
    if (element.options) {
        type = element.options[element.selectedIndex].value;
    } else {
        type = element.value;
    }

    //var keywords = encodeURIComponent(document.getElementById("searchkeywords").value);
    var keywords = document.getElementById("searchkeywords").value;
    //keywords = keywords.replace(new RegExp("%20", "gm"), "%2520").replace(new RegExp("%26", "gm"), "%2526").replace(new RegExp("%2F", "gm"), "%252F");

    if (type == '0' || type == '1') {

        window.location.href = "http://www.ofweek.com/newquery.action?keywords=" + encodeURIComponent(keywords) + "&type=" + type;
    } else if (type == '2') {

        window.location.href = "http://www.ofweek.com/newquery.action?keywords=" + encodeURIComponent(keywords) + "&type=" + type;
    } else if (type == '3') {

        window.location.href = "http://www.ofweek.com/newquery.action?keywords=" + encodeURIComponent(keywords) + "&type=" + type;
    } else if (type == '4') {

        window.location.href = "http://www.ofweek.com/newquery.action?keywords=" + encodeURIComponent(keywords) + "&type=" + type;
    } else if (type == '5') {

        window.location.href = "http://www.ofweek.com/newquery.action?keywords=" + encodeURIComponent(keywords) + "&type=" + type;
    } else if (type == '6') {

        window.location.href = "http://www.ofweek.com/newquery.action?keywords=" + encodeURIComponent(keywords) + "&type=" + type;
    }

}

//閿熸枻鎷烽敓鏂ゆ嫹棰戦敓鏂ゆ嫹澶撮敓鏂ゆ嫹閿熸枻鎷烽敓鏂ゆ嫹閿熸枻鎷疯浆閿熸枻鎷烽敓鏂ゆ嫹璁敓鏂ゆ嫹閿熸枻鎷烽〉 miya
function querynewChannelpingce() {

    var keywords = encodeURIComponent(document.getElementById("searchkeywords").value);
    keywords = keywords.replace(new RegExp("%20", "gm"), "%2520").replace(new RegExp("%26", "gm"), "%2526").replace(new RegExp("%2F", "gm"), "%252F");
    window.location.href = "http://www.ofweek.com/newquery.action?keywords=" + encodeURIComponent(keywords) + "&type=" + 1;
}


function query() {
    var element = document.getElementById("type");
    var type = "";
    if (element.options) {
        type = element.options[element.selectedIndex].value;
    } else {
        type = element.value;
    }
    var keywords = encodeURIComponent(document.getElementById("keyword").value);
    keywords = keywords.replace(new RegExp("%20", "gm"), "%2520").replace(new RegExp("%26", "gm"), "%2526").replace(new RegExp("%2F", "gm"), "%252F");

    if (type == 'CHANPIN') {
        window.open("http://b2b.ofweek.com/search/productlist/" + keywords + ".html");
    } else if (type == 'GONGSI') {
        window.open("http://b2b.ofweek.com/search/companies/" + document.getElementById("keyword").value + ".html");
    } else if (type == 'BLOG') {
        window.open("http://bbs.ofweek.com/search.php?mod=blog&orderby=lastpost&ascdesc=desc&searchsubmit=yes&srchtxt=" + document.getElementById("keyword").value);
    } else if (type == 'DOWN') {
        var link = "http://download.ofweek.com/search-" + 1 + "-" + encodeURIComponent(keywords) + "-1.html";
        window.location.href = link;
    } else if (type == 'BAIKE') {
        window.open("http://baike.ofweek.com/bksearch-" + document.getElementById("keyword").value + ".html");
    } else if (type == 'QIUGOU') {
        window.open("http://b2b.ofweek.com/search/tradeleads/" + document.getElementById("keyword").value + ".html");
    } else if (type == 'HR') {
        window.open("http://hr.ofweek.com/jobs/?key=" + document.getElementById("keyword").value);
    } else if (type == 'BBS') {
        window.open("http://bbs.ofweek.com/search.php?mod=forum&srchtxt=" + keywords + "&orderby=lastpost&ascdesc=desc&searchsubmit=yes");
    } else {
        window.location.href = "http://www.ofweek.com/SEARCH/" + type + "/" + keywords + ".HTM";
    }
}


function selector(type) {
    if (type == "show") {
        document.getElementById('selector').style.display = 'block';
        if (document.getElementById('menu-back-div')) {
            document.getElementById('menu-back-div').style.zIndex = -2;
            document.getElementById('menu-div').style.zIndex = -1;
        }
    } else {
        document.getElementById('selector').style.display = 'none';
        if (document.getElementById('menu-back-div')) {
            document.getElementById('menu-back-div').style.zIndex = 0;
            document.getElementById('menu-div').style.zIndex = 0;
        }
    }
}


function ViverJavaPageTurnB2B(Formname, PageHideName) {
    document.getElementById(PageHideName).value = document.getElementById('ViverGoTopages').value;
    var hrefpath = document.getElementById("hiddenhtmlHref").value + document.getElementById('ViverGoTopages').value + ".html";
    document.getElementById(Formname).action = hrefpath;
    document.getElementById(Formname).submit();
}

function secBoard(elementID, listName, elementname, n) {
    var elem = document.getElementById(elementID);
    var elemlist = elem.getElementsByTagName(elementname);
    for (var i = 0; i < elemlist.length; i++) {
        elemlist[i].className = "sel02";
        var m = i + 1;
        document.getElementById(listName + "_" + m).style.display = "none";
    }
    elemlist[n - 1].className = "sel01";
    document.getElementById(listName + "_" + n).style.display = "block";
}

function changeNavBG() {
    if (this.href == location.href) {
        //jQuery(this).remove();
        var borderSizeMin = '2';
        var borderSizeMax = '4';
        jQuery(this).parents('div').each(function () {
            if (location.href.indexOf('gongkong.ofweek.com') > 0 ||
                (location.href.indexOf('robot.ofweek.com') > 0 && location.href.length < 24) ||
                location.href.indexOf('download.ofweek.com') > 0 ||
                location.href.indexOf('wearable.ofweek.com') > 0) {
                // 鏉╂瑥鍤戞稉顏嗙秹缁旀瑧娈戞潏瑙勵攱閺勶拷2px
                borderSizeMin = '1';
                borderSizeMax = '3';
            }
            var borderTopColor = jQuery(this).css('border-top-color');
            var borderTopStyle = jQuery(this).css('border-top-style');
            var borderTopSize = jQuery(this).css('border-top-width');
            var borderBottomColor = jQuery(this).css('border-bottom-color');
            var borderBottomStyle = jQuery(this).css('border-bottom-style');
            var borderBottomSize = jQuery(this).css('border-bottom-width');
            if (borderTopSize > borderSizeMin && borderTopSize < borderSizeMax) {
                // 妞ゅ爼鍎撮弰锟�
                colorStr = borderTopColor;
            } else if (borderBottomSize > borderSizeMin && borderBottomSize < borderSizeMax) {
                // 鎼存洟鍎撮弰锟�
                colorStr = borderBottomColor;
            } else {
                colorStr = '';
            }
        });
        /* if(colorStr.trim() == '') {
            return;
        } */
        if (jQuery.trim(colorStr) == '') {
            return;
        }
        // console.info('colorStr :' + colorStr);
        if (location.href.indexOf('dianyuan.ofweek.com') > 0 ||
            location.href.indexOf('lighting.ofweek.com') > 0 ||
            (location.href.indexOf('robot.ofweek.com') > 0 && location.href.length > 24)) {
            jQuery(this).find('span').css('background', colorStr);
        } else if (location.href.indexOf('gongkong.ofweek.com') > 0 && location.href.indexOf('CAT') > 0 && location.href.indexOf('CATList') <= 0) {
            return;
            //	  				jQuery('.on').removeClass('on');
            //	  				jQuery(this).parent().addClass('on');
        } else {
            jQuery(this).css('background', colorStr);
        }
        jQuery(this).css({'color': '#fff'}, {'font-weight': 'bold'});
    }
}

jQuery(document).ready(function (jQuery) {

    jQuery('.textlinkAd').click(function () {
        jQuery.get("http://www.ofweek.com/incrTextlinkAdClick.do?method=incrTextlinkAdClick&id=" + jQuery(this).attr('data-id'), function () {
        });
    });

    // $("ul.newslist-2 li").hover(function () {
    //     if ($(this).is(".wenzi")) {
    //         $("ul.newslist-2 .tuwen-con").prev().css("display", "block");
    //         $("ul.newslist-2 .tuwen-con").css("display", "none");
    //         $(this).next().css("display", "block");
    //         $(this).css("display", "none");
    //     }
    // });
    jQuery("body").on("mouseover", "ul.newslist-2 li", function () {
        if (jQuery(this).is(".wenzi")) {
            jQuery("ul.newslist-2 .tuwen-con").prev().css("display", "block");
            jQuery("ul.newslist-2 .tuwen-con").css("display", "none");
            jQuery(this).next().css("display", "block");
            jQuery(this).css("display", "none");
        }
    })

    // $(".xiala span").click(function () {
    //     $(".xiala ul").css("display", "block");
    // });
    jQuery("body").on("click", ".xiala span", function () {
        jQuery(".xiala ul").css("display", "block");
    })

    // $(".xiala ul").hover(function () {
    //     $(this).css("display", "block");
    // }, function () {
    //     $(this).css("display", "none");
    // });
    jQuery("body").on("mouseenter", ".xiala ul", function () {
        jQuery(this).css("display", "block");
    })
    jQuery("body").on("mouseleave", ".xiala ul", function () {
        jQuery(this).css("display", "none");
    })

    // $(".xiala li").hover(function () {
    //     $(this).addClass("bg");
    // }, function () {
    //     $(this).removeClass("bg");
    // });
    jQuery("body").on("mouseenter", ".xiala li", function () {
        jQuery(this).addClass("bg");
    })
    jQuery("body").on("mouseleave", ".xiala li", function () {
        jQuery(this).removeClass("bg");
    })

    // $(".xiala li").click(function () {
    //     $(".xiala span").text($(this).text());
    //     $(".xiala ul").css("display", "none");
    // });
    jQuery("body").on("click", ".xiala li", function () {
        jQuery(".xiala span").text(jQuery(this).text());
        jQuery(".xiala ul").css("display", "none");
    })


    if (location.href.indexOf('sensor.ofweek.com') > 0 || location.href.indexOf('auto.ofweek.com') > 0
        || location.href.indexOf('nev.ofweek.com') > 0 || location.href.indexOf('ecep.ofweek.com') > 0
    ) {
        jQuery('.hover').removeClass('hover');
    }
    if (location.href.indexOf('finance.ofweek.com') <= 0 &&
        location.href.indexOf('cloud.ofweek.com') <= 0 &&
        location.href.indexOf('ai.ofweek.com') <= 0 &&
        location.href.indexOf('exhibition.ofweek.com') <= 0 &&
        location.href.indexOf('www.ofweek.com') <= 0 &&
        location.href.indexOf('download.ofweek.com') <= 0) {
        var colorStr = '';
        jQuery('.header li a').each(changeNavBG);
        jQuery('#header li a').each(changeNavBG);
        jQuery('.top_nav1 li a').each(changeNavBG);

    }
});