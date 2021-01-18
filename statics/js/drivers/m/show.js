$("body").click(function(){
    $("#huifu").css("background","#eee !important")
})

var winHeight = $(window).height();  //获取当前页面高度
$(window).resize(function () {
    var thisHeight = $(this).height();
    if ( winHeight - thisHeight > 140 ) {
        //键盘弹出
        $('#huifu').css('position','static');
    } else {
        //键盘收起
        $('#huifu').css({'position':'fixed','bottom':'300px'});
        
    }
})

$("#but_txt").focus(function(){
    $("#bodyheight").css("display","block");
    $("#huifu").css("display","none")
});
$("#qx").click(function(){
    $("#bodyheight").css("display","none");
    $("#huifu").css("display","block")
})

$("#show_content").click(function(){
    $("#bodyheight").css("display","none");
    $("#huifu").css("display","block")
})

$("#fx").click(function(){
    $('html,body').animate({ scrollTop: $("#bodyheight").offset().top + 1600 }, 200)
})

$(function(){
                $(window).scroll(function(){ //scroll--浏览器滚动条滚动式触发
                    var wHeight=$(window).height(); //获取浏览器可视窗口高度
                    var wTop=$(window).scrollTop(); //获取滚动条距离顶部高度
                    
                  });
                  $("#hddb").click(function(){
                      $("html,body").animate({scrollTop:0},500); //页面500毫秒返回顶部
                  });
             });