<script src="http://www.eetop.cn/statics/js/jquery.cookie.js" type="text/javascript" language="javascript"></script>

      
<style type="text/css">
        *{
                margin:0;
                padding:0;
        }

     .alert_windows{
                float:right;
                display:none;
                position:absolute;
                z-index:10;
                width:120px;
                height:300px;
                right: 0 !important;
        }        
     

 .alert_windows span{
               border-top:1px solid #c0dc0c0
               #margin-top:-10px;
                 #z-index:20;
                float:right;
                width:120px;
                height:15px;
                text-align:right;
                font:11px/15px Microsoft Yahei;
                cursor:pointer;
                color:#333;
                background:#50c0b0;
        }

        .alert_windows span:hover{
                color:#EEE;
                background:red;
        }
         
 .alert_windows10{
                 float:left;
                display:none;
                position:absolute;
                z-index:10;
                width:120px;
                height:300px;
                left: 0 !important;
        }

        .alert_windows10 span{
                border-top:1px solid #c0dc0c0
               #margin-top:-10px;
                 #z-index:20;
                float:left;
                width:120px;
                height:15px;
                text-align:right;
                font:11px/15px Microsoft Yahei;
                cursor:pointer;
                color:#333;
                background:#50c0b0;
        }

        .alert_windows10 span:hover{
                color:#EEE;
                background:red;
        }
        
          .alert_windows2{
                float:right;
                display:none;
                position:absolute;
                #z-index:10;
                width:120px;
                height:142px;
                right: 0 !important;
        }

        .alert_windows2 span{
                border-top:1px solid #c0dc0c0
               #margin-top:-10px;
                 #z-index:20;
                float:right;
                width:120px;
                height:15px;
                text-align:right;
                font:11px/15px Microsoft Yahei;
                cursor:pointer;
                color:#333;
                background:#50c0b0;
        }

        .alert_windows2 span:hover{
                color:#EEE;
                background:red;
        }
             
    .alert_windows3{
                float:left;
                display:none;
                #position:absolute;
                z-index:10;
                width:120px;
                height:100px;
               position: fixed;
        }
         
  
        .alert_windows3 span{
            display: inline-block;
               border-top:1px solid #c0dc0c0
               #margin-top:-10px;
                 #z-index:20;
                width:15px;
                height:15px;
                line-height: 10px;
                font-size: 16px;
                font-weight: 600;
                text-align:center;
                font:11px/15px Microsoft Yahei;
                cursor:pointer;
                color:#333;
                background:#50c0b0;
        }

        .alert_windows3 span:hover{
                color:#EEE;
                background:red;
        }  
         .alert_windows4{
                float:left;
                display:none;
                #position:absolute;
                z-index:10;
                width:40px;
                height:600px;
               
        }
        
         .alert_windows4 span{
               border-top:1px solid #c0dc0c0
               #margin-top:-10px;
                 #z-index:20;
                float:left;
                width:40px;
                height:15px;
                text-align:left;
                font:11px/15px Microsoft Yahei;
                cursor:pointer;
                color:#333;
                background:#50c0b0;
        }

        .alert_windows4 span:hover{
                color:#EEE;
                background:red;
        }  
        
 .alert_windows5{
                display:none;
                #position:absolute;
                position:fixed;
                z-index:10;
                width:600px;
                height:400px;
               
}
 .alert_windows5 span{
                float:right;
                width:20px;
                height:20px;
                text-align:center;
                font:12px/20px Microsoft Yahei;
                cursor:pointer;
                color:#333;
                background:lightblue;
                position: absolute;
                top: 0;
                right: 0;
        }

        .alert_windows5 span:hover{
                color:#EEE;
                background:red;
        }



</style>




<script type="text/javascript">
        jQuery(function(){
                if(jQuery.cookie("isClose3") != 'yes'){
                 jQuery(".alert_windows3").css({"right":0,"top":30});  
                        jQuery(".alert_windows3").show();
                        jQuery(".alert_windows3").animate({"right":0,"top":30},1000);
                        jQuery(".alert_windows3 span").click(function(){
                        jQuery(this).parent().fadeOut(500);
                        jQuery.cookie("isClose3",'yes',{ expires:2*60/86400});      //60/86400 一分钟
                        });
                }
        });
</script>
<div class="alert_windows3" style="top: 0 !important; right: 2px; border:1px; height:30px">
    <p>
        <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=1223096497&site=qq&menu=yes"><img style="position: relative; top: 8px;" border="0" src="http://bbs.eetop.cn/static/image/common/site_qq.jpg" alt="QQ" title="QQ"/></a>
        <span>×</span>
    </p>
</div>





<script type="text/javascript">
        jQuery(function(){
                if(jQuery.cookie("isClose") != 'yes'){
                   var winWid = jQuery(window).width()/2 - jQuery('.alert_windows').width()/2;
                         var winHig = jQuery(window).height()/2 - jQuery('.alert_windows').height()/2;
                        jQuery(".alert_windows").css({"right":0,"top":92}); 
                        jQuery(".alert_windows").show();
                        jQuery(".alert_windows").animate({"right":0,"top":92},1000);
                        jQuery(".alert_windows span").click(function(){
                        jQuery(this).parent().fadeOut(500);
                        jQuery.cookie("isClose",'yes',{ expires:60/86400});     //60/86400 一分钟
                        });
                }
        });
</script>

<div id="alert_windows" class="alert_windows"  style="TOP: 0px; right: 2px; border:1px; height:310px" > 

<ins class='dcmads' style='display:inline-block;width:120px;height:300px'
    data-dcm-placement='N4481.1747347EETOP.CN/B20360904.252399226'
    data-dcm-rendering-mode='script'
    data-dcm-https-only
    data-dcm-resettable-device-id=''
    data-dcm-app-id=''
    data-dcm-click-tracker=''>
  <script src='https://www.googletagservices.com/dcm/dcmads.js'></script>
</ins>


<span>关闭</span>
</div>
<script>
    jQuery(document).ready(function(){
        var menuYloc = jQuery("#alert_windows").offset().top;
        jQuery(window).scroll(function (){
        var offsetTop = menuYloc + jQuery(window).scrollTop() +"px";
        jQuery("#alert_windows").animate({top : offsetTop },{ duration:50 , queue:false });
        });
        });
</script>


<script type="text/javascript">
        jQuery(function(){
                if(jQuery.cookie("isClose2") != 'yes'){
                 jQuery(".alert_windows2").css({"right":0,"top":410});  
                        jQuery(".alert_windows2").show();
                        jQuery(".alert_windows2").animate({"right":0,"top":410},1000);
                        jQuery(".alert_windows2 span").click(function(){
                        jQuery(this).parent().fadeOut(500);
                        jQuery.cookie("isClose2",'yes',{ expires:2*60/86400});      //60/86400 一分钟
                        });
                }
        });
</script>


<div id="alert_windows2" class="alert_windows2" style="TOP: 0px; right: 2px; " > 
<a href="http://bbs.eetop.cn/thread-659917-1-1.html" target="_blank"><img src="http://bbs.eetop.cn/images/weixin.jpg"style=border:1px;/> </a>
<span>关闭</span>
</div>
<script>
    jQuery(document).ready(function(){
        var menuYloc = jQuery("#alert_windows2").offset().top;
        jQuery(window).scroll(function (){
        var offsetTop = menuYloc + jQuery(window).scrollTop() +"px";
        jQuery("#alert_windows2").animate({top : offsetTop },{ duration:50 , queue:false });
        });
        });
</script>




<script type="text/javascript">
        jQuery(function(){
                if(jQuery.cookie("isClose10") != 'yes'){
                   var winWid = jQuery(window).width()/2 - jQuery('.alert_windows10').width()/2;
                         var winHig = jQuery(window).height()/2 - jQuery('.alert_windows10').height()/2;
                        jQuery(".alert_windows10").css({"left":0,"top":92}); 
                        jQuery(".alert_windows10").show();
                        jQuery(".alert_windows10").animate({"left":0,"top":92},1000);
                        jQuery(".alert_windows10 span").click(function(){
                        jQuery(this).parent().fadeOut(500);
                        jQuery.cookie("isClose10",'yes',{ expires:60/86400});     //60/86400 一分钟
                        });
                }
        });
</script>
<script>
    jQuery(document).ready(function(){
        var menuYloc = jQuery("#alert_windows10").offset().top;
        jQuery(window).scroll(function (){
        var offsetTop = menuYloc + jQuery(window).scrollTop() +"px";
        jQuery("#alert_windows10").animate({top : offsetTop },{ duration:50 , queue:false });
        });

    });
</script>

    
<div id="alert_windows10" class="alert_windows10"  style="TOP: 0px; left: 2px; border:1px; height:300px" > 

<script>
(function() {
    var s = "_" + Math.random().toString(36).slice(2);
    document.write('<div id="' + s + '"></div>');
    (window.slotbydup=window.slotbydup || []).push({
        id: '6306807',
        container: s,
        size: '120,300',
        display: 'inlay-fix'
    });
})();
</script>

<span>×</span>
</div>


<script type="text/javascript">
        jQuery(function(){
                if(jQuery.cookie("isClose5") != 'yes'){
                        var winWid = jQuery(window).width()/2 - jQuery('.alert_windows5').width()/2;
                        var winHig = jQuery(window).height()/2 - jQuery('.alert_windows5').height()/2;
                        jQuery(".alert_windows5").css({"left":winWid,"top":-winHig*2});       //鑷笂鑰屼笅
                        jQuery(".alert_windows5").show();
                        jQuery(".alert_windows5").animate({"left":winWid,"top":winHig+70},2000);
                        jQuery(".alert_windows5 span").click(function(){
                                jQuery(this).parent().fadeOut(500);
                                jQuery.cookie("isClose5",'yes',{ expires:30*60/86400});    //30分钟
                                //jQuery.cookie("isClose5",'yes',{ expires:1});               涓€澶?
                        });
                }
        });
</script>


<div class="alert_windows5"   style="TOP: 220px; border:1px; height:400px">
<!-- 广告位：on-弹幕 -->
<!-- 广告位：917 -->
<script>
(function() {
    var s = "_" + Math.random().toString(36).slice(2);
    document.write('<div id="' + s + '"></div>');
    (window.slotbydup=window.slotbydup || []).push({
        id: '6493991',
        container: s,
        size: '600,400',
        display: 'inlay-fix'
    });
})();
</script>
<script src="http://dup.baidustatic.com/js/os.js"></script>
<span>X</span>

</div> 