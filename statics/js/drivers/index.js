// banner下拉菜单显隐藏
$(".banner-item:first, .banner-item:last").on("mouseenter", function () {
    jQuery(this)
        .children(".hideNav")
        .show();
    jQuery(this)
        .find(".arrowToBottom")
        .hide();
    jQuery(this)
        .find(".arrowToTop")
        .show();
});
$(".banner-item:first, .banner-item:last").on("mouseleave", function () {
    jQuery(this)
        .children(".hideNav")
        .hide().find(".hideNav-item a").removeClass("hover");
    jQuery(this)
        .find(".arrowToBottom")
        .show();
    jQuery(this)
        .find(".arrowToTop")
        .hide();
});

// 下拉菜单标签高亮
$(
    ".hideNavwrap:eq(0) a,.hideNavwrap:eq(1) a,.hideNavwrap:eq(2) a,.hideNavwrap:eq(3) a"
).on("mouseover", function () {
    jQuery(this)
        .addClass("hover")
        .parent()
        .siblings()
        .children("a")
        .removeClass("hover");
});

/**
 * OFweek首页改版
 */
(function ($) {
    window.lazySizesConfig = window.lazySizesConfig || {};

    lazySizesConfig.preloadAfterLoad = false;


    /**
     * @method Tab切换
     * @param {String} 参数一：nav栏标签；参数二：content栏标签;参数三：激活样式
     */
    function tabSwitch(navEle, contentEle, activeClass, callBack) {
        $(navEle).on("mouseover", function () {
            $(this)
                .siblings()
                .removeClass(activeClass);
            $(this).addClass(activeClass);
            $(contentEle).hide();
            $(contentEle)
                .eq($(this).index())
                .show();
            if (callBack) {
                callBack();
            }
        });
    }

    /**
     * @method 实现轮播图轮播功能
     */
    function slider(option) {
        var length,
            currentIndex = 0,
            interval,
            hasStarted = false, //是否已经开r始轮播
            t = option.intervalTime; //轮播时间间隔
        length = $(option.sliderItem).length;
        //将除了第一张图片隐藏
        $(option.sliderItem + ":not(:first)").hide();
        //将第一个slider-item设为激活状态
        $(option.sliderNavBtn + ":first").addClass(option.sliderItemSelectedClass);
        //隐藏向前、向后翻按钮
        $(option.sliderPage).hide();
        //鼠标上悬时显示向前、向后翻按钮,停止滑动，鼠标离开时隐藏向前、向后翻按钮，开始滑动
        $(
            option.sliderItem + "," + option.sliderPre + "," + option.sliderNext
        ).hover(
            function () {
                stop();
                $(option.sliderPage).show();
            },
            function () {
                $(option.sliderPage).hide();
                start();
            }
        );
        $(option.sliderNavBtn).hover(
            function (e) {
                stop();
                //获取激活圆点
                var preIndex = $(option.sliderNavBtn)
                    .filter("." + option.sliderItemSelectedClass)
                    .eq(0)
                    .index();
                //获取鼠标选中圆点
                currentIndex = $(this).index();
                play(preIndex, currentIndex);
            },
            function () {
                start();
            }
        );

        $(option.sliderPre).unbind("click");
        $(option.sliderPre).bind("click", function () {
            pre();
        });
        $(option.sliderNext).unbind("click");
        $(option.sliderNext).bind("click", function () {
            next();
        });

        /**
         * 向前翻页
         */
        function pre() {
            var preIndex = currentIndex;
            currentIndex = (--currentIndex + length) % length;
            play(preIndex, currentIndex);
        }

        /**
         * 向后翻页
         */
        function next() {
            var preIndex = currentIndex;
            currentIndex = ++currentIndex % length;
            play(preIndex, currentIndex);
        }

        /**
         * 从preIndex页翻到currentIndex页
         * preIndex 整数，翻页的起始页
         * currentIndex 整数，翻到的那页
         */
        function play(preIndex, currentIndex) {
            $(option.sliderItem)
                .eq(preIndex)
                .fadeOut()
                .parent()
                .children()
                .eq(currentIndex)
                .fadeIn();
            $(option.sliderNavBtn).removeClass(option.sliderItemSelectedClass);
            $(option.sliderNavBtn)
                .eq(currentIndex)
                .addClass(option.sliderItemSelectedClass);
            //添加轮播图底部文字跟随轮播图切换功能
            $(option.sliderTitItem)
                .eq(currentIndex)
                .show()
                .siblings()
                .hide();
        }

        /**
         * 开始轮播
         */
        function start() {
            if (!hasStarted) {
                hasStarted = true;
                interval = setInterval(next, t);
            }
        }

        /**
         * 停止轮播
         */
        function stop() {
            clearInterval(interval);
            hasStarted = false;
        }

        //开始轮播
        start();
    }

    //轮播图下放后跟随文字样式适配IE
    window.onload = function () {
        if (isIE()) {
            $(".slider-tit-item a")
                .height(32)
                .css({
                    "line-height": "16px"
                });
        }
    };

    /**
     * @method 实现图片放大效果
     * @param {Object} option{el:元素选择器,originWidth:{Number},originHeight:{Number}}
     */
    function picMagnify(option) {
        $(option.el).hover(
            function () {
                $(this).animate({
                        width: option.originWidth * 1.1 + "px",
                        height: option.originHeight * 1.1 + "px",
                        "margin-left": -option.originWidth / 20 + "px",
                        "margin-top": -option.originHeight / 20 + "px"
                    },
                    500
                );
            },
            function () {
                $(this).animate({
                        width: option.originWidth + "px",
                        height: option.originHeight + "px",
                        "margin-left": "0px",
                        "margin-top": "0px"
                    },
                    500
                );
            }
        );
    }

    /**
     * @method 改变右侧栏目标题栏背景色
     * @param {*String} el
     */
    function bgColorChange(el) {
        $(el).hover(
            function () {
                $(this).css({
                    "background-color": "#FAFAFA"
                });
            },
            function () {
                $(this).css({
                    "background-color": "#F1F1F1"
                });
            }
        );
    }

    /**
     * @method 判断浏览器是否为IE（兼容IE11）
     */
    function isIE() {
        //ie?
        if (!!window.ActiveXObject || "ActiveXObject" in window) return true;
        else return false;
    }

    //右侧控件效果
    var scrollTopFlag = $(".news-layout-two").offset().top;
    $(window).scroll(function () {
        var scrollTop = $(this).scrollTop();
        if (scrollTop < scrollTopFlag) {
            $(".rightWidget").animate({
                    bottom: "-38px"
                },
                30
            );
        }
        if (scrollTop >= scrollTopFlag) {
            $(".rightWidget").animate({
                    bottom: "25px"
                },
                30
            );
        }
    });

    //top-nav
    // 登录样式显隐藏
    var str_cookie = getCookie("www_ofweekmember");
    if (str_cookie != null) {
        // document.getElementById("loginshow").style.display = "none";
        $(".nth-child-1,.nth-child-2").hide();
        var str = str_cookie.split("NPofweek");
        var nick = str[2];
        // document.getElementById("logininfo").style.display = "";
        $("#logininfo").removeClass("hide");
        document.getElementById("logininfo").innerHTML +=
            " 欢迎您：" + nick + " ！";
    }
    //banner下拉菜单
    /*搜索框 */
    var hideListFLag = true;
    $("#queryForm .list span").on("click", function () {
        $(".hideList").show();
    });
    $("#queryForm .list").on("mouseleave", function () {
        $(".hideList").hide();
    });
    $("#queryForm .hideList li").on("click", function () {
        var text = $(this).text();
        $(this)
            .parent()
            .siblings("span")
            .html(text)
            .siblings(".hideList")
            .hide();
    });

    /*news-layout-two*/
    //开启轮播图
    slider({
        intervalTime: 2000,
        sliderItem: ".slider-panel1",
        sliderNavBtn: ".slider-item1",
        sliderPage: ".slider-page1",
        sliderPre: ".slider-pre1",
        sliderNext: ".slider-next1",
        sliderItemSelectedClass: "slider-item-selected",
        sliderTitItem: ".slider-tit-item1"
    });
    // news-layout-two
    //content-mid Tab切换
    tabSwitch(
        ".news-layout-two .content-mid .nav-item",
        ".news-layout-two .content-mid .content-main-wrap>li",
        "active"
    );

    //图片放大效果
    picMagnify({
        el: ".news-layout-two .pic-wrap img",
        originWidth: 120,
        originHeight: 90
    });

    /*news-layout-four*/
    //content-left Tab切换
    tabSwitch(
        ".news-layout-four .content-left .nav-item",
        ".news-layout-four .content-left .content-main-wrap>li",
        "active"
    );
    //block1开启轮播图
    slider({
        intervalTime: 2000,
        sliderItem: ".slider-panel2",
        sliderNavBtn: ".slider-item2",
        sliderPage: ".slider-page2",
        sliderPre: ".slider-pre2",
        sliderNext: ".slider-next2",
        sliderItemSelectedClass: "slider-item-selected",
        sliderTitItem: ".slider-tit-item2"
    });
    //block2开启轮播图
    slider({
        intervalTime: 2000,
        sliderItem: ".slider-panel3",
        sliderNavBtn: ".slider-item3",
        sliderPage: ".slider-page3",
        sliderPre: ".slider-pre3",
        sliderNext: ".slider-next3",
        sliderItemSelectedClass: "slider-item-selected",
        sliderTitItem: ".slider-tit-item3"
    });
    //block3开启轮播图
    slider({
        intervalTime: 2000,
        sliderItem: ".slider-panel4",
        sliderNavBtn: ".slider-item4",
        sliderPage: ".slider-page4",
        sliderPre: ".slider-pre4",
        sliderNext: ".slider-next4",
        sliderItemSelectedClass: "slider-item-selected",
        sliderTitItem: ".slider-tit-item4"
    });
    //block4开启轮播图
    slider({
        intervalTime: 2000,
        sliderItem: ".slider-panel4x",
        sliderNavBtn: ".slider-item4x",
        sliderPage: ".slider-page4x",
        sliderPre: ".slider-pre4x",
        sliderNext: ".slider-next4x",
        sliderItemSelectedClass: "slider-item-selected",
        sliderTitItem: ".slider-tit-item4x"
    });

    //图片放大效果
    // picMagnify({
    //   el: ".news-layout-four .pic-wrap img",
    //   originWidth: 120,
    //   originHeight: 70
    // });

    /*news-layout-six*/
    // 图片持续轮播及悬停
    var company = document.getElementById("company");
    var leader = 0;
    var timeId = null;
    var scrollWidth =
        $("#company .company-item").length *
        ($("#company .company-item").width() + 10) -
        $(".news-layout-six .layout-content").width() +
        50;
    //轮播
    timeId = setInterval(play, 20);

    function play() {
        //防止定时器叠加，每次循环清除一次；
        // clearInterval(timeId);
        if (leader < scrollWidth) {
            leader += 1;
            company.style.left = -leader + "px";
        } else {
            clearInterval(timeId);
            leader = 0;
            company.style.left = "0px";
            timeId = setInterval(play, 20);
        }
    }

    //悬停
    $(".news-layout-six .layout-content").hover(
        function () {
            clearInterval(timeId);
        },
        function () {
            timeId = setInterval(play, 20);
        }
    );

    /*news-layout-seven*/
    //content-left Tab切换
    tabSwitch(
        ".news-layout-seven .content-left .nav-item",
        ".news-layout-seven .content-left .content-main-wrap>li",
        "active"
    );
    //block1开启轮播图
    slider({
        intervalTime: 2000,
        sliderItem: ".slider-panel5",
        sliderNavBtn: ".slider-item5",
        sliderPage: ".slider-page5",
        sliderPre: ".slider-pre5",
        sliderNext: ".slider-next5",
        sliderItemSelectedClass: "slider-item-selected",
        sliderTitItem: ".slider-tit-item5"
    });
    //block2开启轮播图
    slider({
        intervalTime: 2000,
        sliderItem: ".slider-panel30",
        sliderNavBtn: ".slider-item30",
        sliderPage: ".slider-page30",
        sliderPre: ".slider-pre30",
        sliderNext: ".slider-next30",
        sliderItemSelectedClass: "slider-item-selected",
        sliderTitItem: ".slider-tit-item30"
    });
    //block3开启轮播图
    slider({
        intervalTime: 2000,
        sliderItem: ".slider-panel6",
        sliderNavBtn: ".slider-item6",
        sliderPage: ".slider-page6",
        sliderPre: ".slider-pre6",
        sliderNext: ".slider-next6",
        sliderItemSelectedClass: "slider-item-selected",
        sliderTitItem: ".slider-tit-item6"
    });
    //block4开启轮播图
    slider({
        intervalTime: 2000,
        sliderItem: ".slider-panel7",
        sliderNavBtn: ".slider-item7",
        sliderPage: ".slider-page7",
        sliderPre: ".slider-pre7",
        sliderNext: ".slider-next7",
        sliderItemSelectedClass: "slider-item-selected",
        sliderTitItem: ".slider-tit-item7"
    });
    //图片放大效果
    // picMagnify({
    //   el: ".news-layout-seven .pic-wrap img",
    //   originWidth: 120,
    //   originHeight: 70
    // });

    // news-layout-nine
    //content-left Tab切换
    tabSwitch(
        ".news-layout-nine .content-left .nav-item",
        ".news-layout-nine .content-left .content-main-wrap>li",
        "active"
    );
    //block1开启轮播图
    slider({
        intervalTime: 2000,
        sliderItem: ".slider-panel8",
        sliderNavBtn: ".slider-item8",
        sliderPage: ".slider-page8",
        sliderPre: ".slider-pre8",
        sliderNext: ".slider-next8",
        sliderItemSelectedClass: "slider-item-selected",
        sliderTitItem: ".slider-tit-item8"
    });
    //block2开启轮播图
    slider({
        intervalTime: 2000,
        sliderItem: ".slider-panel9",
        sliderNavBtn: ".slider-item9",
        sliderPage: ".slider-page9",
        sliderPre: ".slider-pre9",
        sliderNext: ".slider-next9",
        sliderItemSelectedClass: "slider-item-selected",
        sliderTitItem: ".slider-tit-item9"
    });
    //block3开启轮播图
    slider({
        intervalTime: 2000,
        sliderItem: ".slider-panel9x",
        sliderNavBtn: ".slider-item9x",
        sliderPage: ".slider-page9x",
        sliderPre: ".slider-pre9x",
        sliderNext: ".slider-next9x",
        sliderItemSelectedClass: "slider-item-selected",
        sliderTitItem: ".slider-tit-item9x"
    });
    slider({
        intervalTime: 2000,
        sliderItem: ".slider-panel42",
        sliderNavBtn: ".slider-item42",
        sliderPage: ".slider-page42",
        sliderPre: ".slider-pre42",
        sliderNext: ".slider-next42",
        sliderItemSelectedClass: "slider-item-selected",
        sliderTitItem: ".slider-tit-item42"
    });
    slider({
        intervalTime: 2000,
        sliderItem: ".slider-panel43",
        sliderNavBtn: ".slider-item43",
        sliderPage: ".slider-page43",
        sliderPre: ".slider-pre43",
        sliderNext: ".slider-next43",
        sliderItemSelectedClass: "slider-item-selected",
        sliderTitItem: ".slider-tit-item43"
    });
    slider({
        intervalTime: 2000,
        sliderItem: ".slider-panel44",
        sliderNavBtn: ".slider-item44",
        sliderPage: ".slider-page44",
        sliderPre: ".slider-pre44",
        sliderNext: ".slider-next44",
        sliderItemSelectedClass: "slider-item-selected",
        sliderTitItem: ".slider-tit-item44"
    });
    //图片放大效果
    // picMagnify({
    //   el: ".news-layout-nine .pic-wrap img",
    //   originWidth: 120,
    //   originHeight: 70
    // });

    // news-layout-ten
    //content-left Tab切换
    tabSwitch(
        ".news-layout-ten .store-tit-item",
        ".news-layout-ten .store-content .store-content-wrap>li",
        "active",
        function () {
            if (
                $(".news-layout-ten .store-tit-item")
                    .eq(1)
                    .hasClass("active")
            ) {
                $(".news-layout-ten .product").show();
            } else if (!$(".news-layout-ten .store-tit-item")
                .eq(1)
                .hasClass("active")
            ) {
                $(".news-layout-ten .product").hide();
            }
        }
    );

    // 外贸网搜索  --判断不能输入中文
    var isEnglish = function (str) {
        var reg = /^[a-zA-Z0-9\-\s]*$/;
        return reg.test(str);
    };

    function queryEnPro() {
        var keywords = document.getElementById("keywordEnp").value;
        if (keywords == "solar") {
            window.open("http://en.ofweek.com/manufacturer/solar");
        } else if (keywords == "lighting") {
            window.open("http://en.ofweek.com/manufacturer/lighting");
        } else if (keywords == "LED") {
            window.open("http://en.ofweek.com/manufacturer/led");
        } else if (keywords == "telecom") {
            window.open("http://en.ofweek.com/manufacturer/telecom");
        } else if (keywords == "fiber") {
            window.open("http://en.ofweek.com/manufacturer/fiber");
        } else if (keywords == "laser") {
            window.open("http://en.ofweek.com/manufacturer/laser");
        } else if (keywords == "security") {
            window.open("http://en.ofweek.com/manufacturer/security");
        } else if (keywords == "power") {
            window.open("http://en.ofweek.com/manufacturer/power");
        } else if (keywords == "electronics") {
            window.open("http://en.ofweek.com/manufacturer/electronics");
        } else if (keywords == "automation") {
            window.open("http://en.ofweek.com/manufacturer/automation");
        } else if (keywords == "optical lens") {
            window.open("http://en.ofweek.com/manufacturer/optical-lens");
        } else if (keywords == "auto parts") {
            window.open("http://en.ofweek.com/manufacturer/auto-parts");
        } else if (keywords == "solar power") {
            window.open("http://en.ofweek.com/manufacturer/solar-power");
        } else if (keywords == "led display") {
            window.open("http://en.ofweek.com/manufacturer/led-display");
        } else if (keywords == "medical") {
            window.open("http://en.ofweek.com/manufacturer/medical");
        } else if (keywords == "instrument") {
            window.open("http://en.ofweek.com/manufacturer/instrument");
        } else {
            if (!isEnglish(keywords)) {
                alert("请输入英文关键字");
                return false;
            }
            window.open(
                "http://en.ofweek.com/of_product_list.php?type=item&key=" + keywords
            );
        }
    }

    // 图片持续轮播及悬停
    (function () {
        var store1 = document.getElementById("store1");
        var leader = 0;
        var timeId = null;
        //轮播
        timeId = setInterval(play, 20);

        function play() {
            //防止定时器叠加，每次循环清除一次；
            // clearInterval(timeId);
            if (leader < 490) {
                leader += 1;
                store1.style.marginLeft = -leader + "px";
            } else {
                clearInterval(timeId);
                leader = 0;
                store1.style.marginLeft = "0px";
                timeId = setInterval(play, 20);
            }
        }

        //悬停
        $(".news-layout-ten .store-content-wrap").hover(
            function () {
                clearInterval(timeId);
            },
            function () {
                timeId = setInterval(play, 20);
            }
        );
    })();

    // news-layout-eleven
    //content-left Tab切换
    tabSwitch(
        ".news-layout-eleven .content-left .nav-item",
        ".news-layout-eleven .content-left .content-main-wrap>li",
        "active"
    );
    //block1开启轮播图
    slider({
        intervalTime: 2000,
        sliderItem: ".slider-panel10",
        sliderNavBtn: ".slider-item10",
        sliderPage: ".slider-page10",
        sliderPre: ".slider-pre10",
        sliderNext: ".slider-next10",
        sliderItemSelectedClass: "slider-item-selected",
        sliderTitItem: ".slider-tit-item10"
    });
    //block2开启轮播图
    slider({
        intervalTime: 2000,
        sliderItem: ".slider-panel11",
        sliderNavBtn: ".slider-item11",
        sliderPage: ".slider-page11",
        sliderPre: ".slider-pre11",
        sliderNext: ".slider-next11",
        sliderItemSelectedClass: "slider-item-selected",
        sliderTitItem: ".slider-tit-item11"
    });
    //block3开启轮播图
    slider({
        intervalTime: 2000,
        sliderItem: ".slider-panel12",
        sliderNavBtn: ".slider-item12",
        sliderPage: ".slider-page12",
        sliderPre: ".slider-pre12",
        sliderNext: ".slider-next12",
        sliderItemSelectedClass: "slider-item-selected",
        sliderTitItem: ".slider-tit-item12"
    });
    //block4开启轮播图
    slider({
        intervalTime: 2000,
        sliderItem: ".slider-panel13",
        sliderNavBtn: ".slider-item13",
        sliderPage: ".slider-page13",
        sliderPre: ".slider-pre13",
        sliderNext: ".slider-next13",
        sliderItemSelectedClass: "slider-item-selected",
        sliderTitItem: ".slider-tit-item13"
    });
    //图片放大效果
    // picMagnify({
    //   el: ".news-layout-eleven .pic-wrap img",
    //   originWidth: 120,
    //   originHeight: 70
    // });

    // news-layout-thirdteen
    //Tab切换
    tabSwitch(
        ".news-layout-thirdteen .content-left .nav-item",
        ".news-layout-thirdteen .content-left .content-main-wrap>li",
        "active"
    );
    //block1开启轮播图
    slider({
        intervalTime: 2000,
        sliderItem: ".slider-panel14",
        sliderNavBtn: ".slider-item14",
        sliderPage: ".slider-page14",
        sliderPre: ".slider-pre14",
        sliderNext: ".slider-next14",
        sliderItemSelectedClass: "slider-item-selected",
        sliderTitItem: ".slider-tit-item14"
    });
    //block2开启轮播图
    slider({
        intervalTime: 2000,
        sliderItem: ".slider-panel15",
        sliderNavBtn: ".slider-item15",
        sliderPage: ".slider-page15",
        sliderPre: ".slider-pre15",
        sliderNext: ".slider-next15",
        sliderItemSelectedClass: "slider-item-selected",
        sliderTitItem: ".slider-tit-item15"
    });

    slider({
        intervalTime: 2000,
        sliderItem: ".slider-panel40",
        sliderNavBtn: ".slider-item40",
        sliderPage: ".slider-page40",
        sliderPre: ".slider-pre40",
        sliderNext: ".slider-next40",
        sliderItemSelectedClass: "slider-item-selected",
        sliderTitItem: ".slider-tit-item40"
    });
    //图片放大效果
    // picMagnify({
    //   el: ".news-layout-thirdteen .pic-wrap img",
    //   originWidth: 120,
    //   originHeight: 70
    // });

    // news-layout-fourteen
    tabSwitch(
        ".news-layout-fourteen .content-left .nav-item",
        ".news-layout-fourteen .content-left .content-main-wrap>li",
        "active"
    );
    //block1开启轮播图
    slider({
        intervalTime: 2000,
        sliderItem: ".slider-panel17",
        sliderNavBtn: ".slider-item17",
        sliderPage: ".slider-page17",
        sliderPre: ".slider-pre17",
        sliderNext: ".slider-next17",
        sliderItemSelectedClass: "slider-item-selected",
        sliderTitItem: ".slider-tit-item17"
    });
    //block2开启轮播图
    slider({
        intervalTime: 2000,
        sliderItem: ".slider-panel18",
        sliderNavBtn: ".slider-item18",
        sliderPage: ".slider-page18",
        sliderPre: ".slider-pre18",
        sliderNext: ".slider-next18",
        sliderItemSelectedClass: "slider-item-selected",
        sliderTitItem: ".slider-tit-item18"
    });
    //block3开启轮播图
    slider({
        intervalTime: 2000,
        sliderItem: ".slider-panel19",
        sliderNavBtn: ".slider-item19",
        sliderPage: ".slider-page19",
        sliderPre: ".slider-pre19",
        sliderNext: ".slider-next19",
        sliderItemSelectedClass: "slider-item-selected",
        sliderTitItem: ".slider-tit-item19"
    });
    //block4开启轮播图
    slider({
        intervalTime: 2000,
        sliderItem: ".slider-panel32",
        sliderNavBtn: ".slider-item32",
        sliderPage: ".slider-page32",
        sliderPre: ".slider-pre32",
        sliderNext: ".slider-next32",
        sliderItemSelectedClass: "slider-item-selected",
        sliderTitItem: ".slider-tit-item32"
    });
    slider({
        intervalTime: 2000,
        sliderItem: ".slider-panel41",
        sliderNavBtn: ".slider-item41",
        sliderPage: ".slider-page41",
        sliderPre: ".slider-pre41",
        sliderNext: ".slider-next41",
        sliderItemSelectedClass: "slider-item-selected",
        sliderTitItem: ".slider-tit-item41"
    });
    //图片放大效果
    // picMagnify({
    //   el: ".news-layout-fourteen .pic-wrap img",
    //   originWidth: 120,
    //   originHeight: 70
    // });

    // news-layout-fifteen
    tabSwitch(
        ".news-layout-fifteen .content-left .nav-item",
        ".news-layout-fifteen .content-left .content-main-wrap>li",
        "active"
    );
    //block1开启轮播图
    slider({
        intervalTime: 2000,
        sliderItem: ".slider-panel20",
        sliderNavBtn: ".slider-item20",
        sliderPage: ".slider-page20",
        sliderPre: ".slider-pre20",
        sliderNext: ".slider-next20",
        sliderItemSelectedClass: "slider-item-selected",
        sliderTitItem: ".slider-tit-item20"
    });
    //block2开启轮播图
    slider({
        intervalTime: 2000,
        sliderItem: ".slider-panel31",
        sliderNavBtn: ".slider-item31",
        sliderPage: ".slider-page31",
        sliderPre: ".slider-pre31",
        sliderNext: ".slider-next31",
        sliderItemSelectedClass: "slider-item-selected",
        sliderTitItem: ".slider-tit-item31"
    });
    //block3开启轮播图
    slider({
        intervalTime: 2000,
        sliderItem: ".slider-panel21",
        sliderNavBtn: ".slider-item21",
        sliderPage: ".slider-page21",
        sliderPre: ".slider-pre21",
        sliderNext: ".slider-next21",
        sliderItemSelectedClass: "slider-item-selected",
        sliderTitItem: ".slider-tit-item21"
    });
    //block4开启轮播图
    slider({
        intervalTime: 2000,
        sliderItem: ".slider-panel22",
        sliderNavBtn: ".slider-item22",
        sliderPage: ".slider-page22",
        sliderPre: ".slider-pre22",
        sliderNext: ".slider-next22",
        sliderItemSelectedClass: "slider-item-selected",
        sliderTitItem: ".slider-tit-item22"
    });
    //block5开启轮播图
    slider({
        intervalTime: 2000,
        sliderItem: ".slider-panel22x",
        sliderNavBtn: ".slider-item22x",
        sliderPage: ".slider-page22x",
        sliderPre: ".slider-pre22x",
        sliderNext: ".slider-next22x",
        sliderItemSelectedClass: "slider-item-selected",
        sliderTitItem: ".slider-tit-item22x"
    });
//block6开启轮播图
    slider({
        intervalTime: 2000,
        sliderItem: ".slider-panel33",
        sliderNavBtn: ".slider-item33",
        sliderPage: ".slider-page33",
        sliderPre: ".slider-pre33",
        sliderNext: ".slider-next33",
        sliderItemSelectedClass: "slider-item-selected",
        sliderTitItem: ".slider-tit-item33"
    });
    //图片放大效果
    // picMagnify({
    //   el: ".news-layout-fifteen .pic-wrap img",
    //   originWidth: 120,
    //   originHeight: 70
    // });

    // news-layout-sixteen
    tabSwitch(
        ".news-layout-sixteen .content-left .nav-item",
        ".news-layout-sixteen .content-left .content-main-wrap>li",
        "active"
    );
    //block1开启轮播图
    slider({
        intervalTime: 2000,
        sliderItem: ".slider-panel23",
        sliderNavBtn: ".slider-item23",
        sliderPage: ".slider-page23",
        sliderPre: ".slider-pre23",
        sliderNext: ".slider-next23",
        sliderItemSelectedClass: "slider-item-selected",
        sliderTitItem: ".slider-tit-item23"
    });
    //block2开启轮播图
    slider({
        intervalTime: 2000,
        sliderItem: ".slider-panel24",
        sliderNavBtn: ".slider-item24",
        sliderPage: ".slider-page24",
        sliderPre: ".slider-pre24",
        sliderNext: ".slider-next24",
        sliderItemSelectedClass: "slider-item-selected",
        sliderTitItem: ".slider-tit-item24"
    });
    //block3开启轮播图
    slider({
        intervalTime: 2000,
        sliderItem: ".slider-panel25",
        sliderNavBtn: ".slider-item25",
        sliderPage: ".slider-page25",
        sliderPre: ".slider-pre25",
        sliderNext: ".slider-next25",
        sliderItemSelectedClass: "slider-item-selected",
        sliderTitItem: ".slider-tit-item25"
    });
    //图片放大效果
    // picMagnify({
    //   el: ".news-layout-sixteen .pic-wrap img",
    //   originWidth: 120,
    //   originHeight: 70
    // });

    // news-layout-seventeen
    // tabSwitch(
    //   ".news-layout-seventeen .content-left .nav-item",
    //   ".news-layout-seventeen .content-left .content-main-wrap>li",
    //   "active"
    // );
    // //block1开启轮播图
    // slider({
    //   intervalTime: 2000,
    //   sliderItem: ".slider-panel26",
    //   sliderNavBtn: ".slider-item26",
    //   sliderPage: ".slider-page26",
    //   sliderPre: ".slider-pre26",
    //   sliderNext: ".slider-next26",
    //   sliderItemSelectedClass: "slider-item-selected",
    //   sliderTitItem: ".slider-tit-item26"
    // });
    // //block2开启轮播图
    // slider({
    //   intervalTime: 2000,
    //   sliderItem: ".slider-panel27",
    //   sliderNavBtn: ".slider-item27",
    //   sliderPage: ".slider-page27",
    //   sliderPre: ".slider-pre27",
    //   sliderNext: ".slider-next27",
    //   sliderItemSelectedClass: "slider-item-selected",
    //   sliderTitItem: ".slider-tit-item27"
    // });
    // //block3开启轮播图
    // slider({
    //   intervalTime: 2000,
    //   sliderItem: ".slider-panel28",
    //   sliderNavBtn: ".slider-item28",
    //   sliderPage: ".slider-page28",
    //   sliderPre: ".slider-pre28",
    //   sliderNext: ".slider-next28",
    //   sliderItemSelectedClass: "slider-item-selected",
    //   sliderTitItem: ".slider-tit-item28"
    // });
    //图片放大效果
    // picMagnify({
    //   el: ".news-layout-seventeen .pic-wrap img",
    //   originWidth: 120,
    //   originHeight: 70
    // });

    // news-layout-eighteen
    //Tab切换
    tabSwitch(
        ".news-layout-eighteen .content-left .nav-item",
        ".news-layout-eighteen .content-left .content-main-wrap>li",
        "active"
    );

    function slider_2() {
        var length,
            currentIndex = 0,
            interval,
            hasStarted = false, //是否已经开r始轮播
            t = 2000; //轮播时间间隔
        length = $(".slider-panel29").length;
        if (length == 1) {
            $(".slider-page29").hide();
            return;
        }
        //将除了第一张图片隐藏
        $(".slider-panel29:not(:first)").hide();
        //隐藏向前、向后翻按钮
        $(".slider-panel29").hide();
        //鼠标上悬时显示向前、向后翻按钮,停止滑动，鼠标离开时隐藏向前、向后翻按钮，开始滑动
        $(".pic-slider .main-carousel").hover(
            function () {
                stop();
                $(".slider-page29").show();
            },
            function () {
                $(".slider-page29").hide();
                start();
            }
        );
        $(".new-slider-pre").unbind("click");
        $(".new-slider-pre").bind("click", function () {
            pre();
        });
        $(".new-slider-next").unbind("click");
        $(".new-slider-next").bind("click", function () {
            next();
        });

        /**
         * 向前翻页
         */
        function pre() {
            var preIndex = currentIndex;
            currentIndex = (--currentIndex + length) % length;
            play(preIndex, currentIndex);
        }

        /**
         * 向后翻页
         */
        function next() {
            var preIndex = currentIndex;
            currentIndex = ++currentIndex % length;
            play(preIndex, currentIndex);
        }

        /**
         * 从preIndex页翻到currentIndex页
         * preIndex 整数，翻页的起始页
         * currentIndex 整数，翻到的那页
         */
        function play(preIndex, currentIndex) {
            $(".slider-panel29")
                .eq(preIndex)
                .fadeOut()
                .parent()
                .children()
                .eq(currentIndex)
                .fadeIn();
        }

        /**
         * 开始轮播
         */
        function start() {
            if (!hasStarted) {
                hasStarted = true;
                interval = setInterval(next, t);
            }
        }

        /**
         * 停止轮播
         */
        function stop() {
            clearInterval(interval);
            hasStarted = false;
        }

        //开始轮播
        start();
    }

    slider_2();

    //news-layout-nineteen
    // 求职搜索框
    function queryHr() {
        var keywords = document.getElementById("keywordHr").value;
        var encodeKeyWords = encodeURI(keywords);
        var address = document.getElementById("yxdq").value;
        window.open(
            "http://hr.ofweek.com/jobs/?key=" +
            encodeKeyWords +
            "&district[]=" +
            address
        );
    }

    //side-box-three
    //Tab切换
    tabSwitch(
        ".side-box-three .sub-area-bottom .bottom-area-nav-item",
        ".side-box-three .bottom-area-content>li",
        "active"
    );
    var adduilainFlag = true;
    $(window).scroll(function () {
        var flag1 = $(".news-layout-fifteen").offset().top + 0;
        var flag2 = $(".news-layout-twenty").offset().top - 790;
        var scrollTop = $(this).scrollTop();
        if (scrollTop < flag1) {
            $(".side-box-two,.side-box-five")
                .removeClass("fixed")
                .addClass("modify");
        } else if (scrollTop <= flag2) {
            $(".side-box-two,.side-box-five")
                .removeClass("modify")
                .removeClass("top")
                .addClass("fixed");
        } else {
            $(".side-box-two,.side-box-five")
                .removeClass("fixed")
                .addClass("modify")
                .addClass("top");
        }

        //控制对联广告

        /*$(".duilian span.closed").on("click",function(){
        	adduilainFlag = false;
        })
        if (scrollTop < 600) {
          $(".duilian").hide()
        } else if ( (scrollTop > 600) && adduilainFlag) {
          $(".duilian").show()
        }*/
    });

    //side-box-fourteen标签高亮效果；
    $(".side-box-fourteen .tags-box>li").on("mouseover", function () {
        $(this)
            .addClass("active")
            .siblings()
            .removeClass("active");
    });
    $(".side-box-fourteen .tags-box>li").on("mouseleave", function () {
        $(this).removeClass("active");
    });

    //右侧栏目标题栏悬停效果;
    bgColorChange(
        ".activetis-tit,.special-recommand-tit,.publicPlatform-tit,.finance-tit,.human-tit"
    );

    //在线咨询悬停效果
    $(".consult").hover(
        function () {
            $(this).addClass("consultActive");
        },
        function () {
            $(this).removeClass("consultActive");
        }
    );

    //置顶按钮效果
    $(".scrollTop")
        .hover(
            function () {
                $(this).addClass("scrollTopActive");
            },
            function () {
                $(this).removeClass("scrollTopActive");
            }
        )
        .on("click", function () {
            $("html,body").animate({
                    scrollTop: 0
                },
                800
            );
        });

    //a标签hover变色修复
    var originAtagColorArr = [];
    for (
        var i = 0, len = $(".news-layout-one .news-right-item").length; i < len; i++
    ) {
        var originAtagColorEle = $(".news-layout-one .news-right-item")
            .eq(i)
            .find("a")
            .css("color");
        originAtagColorArr.push(originAtagColorEle);
    }
    $(".news-layout-one .news-right-item a").hover(
        function () {
            $(this).css({
                color: "#cc0000"
            });
        },
        function () {
            if (
                $(this)
                    .parent()
                    .index() == 0
            ) {
                $(this).css({
                    color: originAtagColorArr[0]
                });
            } else if (
                $(this)
                    .parent()
                    .index() == 1
            ) {
                $(this).css({
                    color: originAtagColorArr[1]
                });
            } else if (
                $(this)
                    .parent()
                    .index() == 2
            ) {
                $(this).css({
                    color: originAtagColorArr[2]
                });
            } else if (
                $(this)
                    .parent()
                    .index() == 3
            ) {
                $(this).css({
                    color: originAtagColorArr[3]
                });
            }
        }
    );

    $(".news-layout-one .news-right-item a").on("mouseenter");
    var originAtagColor5 = $(".side-box-two .content-right a").css("color");
    $(".side-box-two .content-right a").hover(
        function () {
            $(this).css({
                color: "#cc0000"
            });
        },
        function () {
            $(this).css({
                color: originAtagColor5
            });
        }
    );

    //返回旧版悬停效果
    $(".returntoOldUrl a").hover(
        function () {
            $(this).addClass("returntoOldUrlColorChange");
        },
        function () {
            $(this).removeClass("returntoOldUrlColorChange");
        }
    );

    //slide-box-five左右滚动效果-----------------------------------------------------------------------

    var innerGroup = $(".swiperItem");
    var itemWidth =
        $(".swiperItem")
            .eq(0)
            .width() + 10;
    var _index = 0;
    var timer = null;
    var flag = true;

    $(".container").hover(
        function () {
            //鼠标移入
            clearInterval(timer);
            flag = false;
        },
        function () {
            flag = true;
            timer = setInterval(go, 7000);
        }
    );

    function autoGo(bol) {
        //自动行走
        if (bol) {
            timer = setInterval(go, 7000);
        }
    }

    autoGo(flag);

    function go() {
        //计时器的函数
        _index++;
        selectPic(_index);
    }

    function selectPic(num) {
        $(".side-box-five .publicPlatform-content .container").animate({
                /*left: -num * itemWidth*/
                left: -num * 289
            },
            800,
            function () {
                //检查是否到最后一张
                if (_index == innerGroup.length - 1) {
                    _index = 0;
                    $(".side-box-five .publicPlatform-content .container").css(
                        "left",
                        "0px"
                    );
                }
            }
        );
    }

    function indexSearch() {
        $('#queryForm').submit();
    }

})(jQuery);