<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo pc_base::load_config('system','charset')?>" />
<title><?php echo $configs['from_application']?> TO PHPCMS V9 转换程序</title>
<script src="<?php echo JS_PATH?>jquery.min.js"></script>
<style>
*{padding:0; margin:0;font:12px/22px tahoma,arial,\5b8b\4f53,sans-serif; vertical-align:middle; color:#666}
body,html,input{font:12px/1.5 tahoma,arial,\5b8b\4f53,sans-serif;}
table{border-collapse:collapse;border-spacing:0;}
ul,li{list-style-type: none}
a{text-decoration:none;}
a:hover{text-decoration:underline;}
.input-text{border-left:1px solid #e0e0e0;border-top:1px solid #e0e0e0;border-right:1px solid #c5c5c5;border-bottom:1px solid #c5c5c5; height:20px; vertical-align:middle; line-height:20px; padding-left:5px; font-family:"宋体"}
.input-button{ background-color:#2776b9; color:#fff; border:none; font-family:"宋体"; padding:3px 10px; font-weight:700}
.input-button:hover{background-color: #F60;}
.header{background-color:#2776b9; padding:10px; margin-bottom:20px}
.header div{font:18px/18px "MicroSoft YaHei","SimHei"; color:#fff; }
.header div,.container,.footer{width:880px; margin: auto}
.container{}

.guild{ margin-bottom:1px; font-family:Arial, Helvetica, sans-serif}
.guild,.guild li{height:20px; overflow:hidden;font-family:Arial, Helvetica, sans-serif}
.guild li{float:left; margin-left:1px; background-color:#e2e2e2; width:175px; text-align:center; font-size:12px; line-height:20px}
.guild li.on{ background-color:#2776b9; color:#fff}

.help{ border:1px solid #cde1e6; border-bottom:none; padding:8px 10px}
.help h5{font:14px/24px "宋体"; font-weight:700; color:#006fc8;}

.list{}
.list,.list thead tr td,.list tbody td {border:1px solid #cde1e6}
.list thead tr td,.list tbody td{ border-top:none;}
.list tbody td{padding:8px}
.list thead tr{ background-color:#e4eef1;}
.list thead tr td{border-bottom:none;}
.list thead tr td span{ display:block; border:1px solid #fff; border-right:none; border-bottom:none;height:24px; line-height:24px; text-align:center}

h4.title{ background-color:#f0f0f0; padding:3px 5px; font-family:"宋体"; margin:10px 0}
.checkbox label{display:inline-block;display:-moz-inline-stack;zoom:1;*display:inline; width:25%}

.font-red{color:red}

.footer{text-align:center; height:34px; line-height:34px}
</style>
</head>

<body>
<div class="header"><div><?php echo $configs['from_application']?> TO PHPCMS V9 转换程序</div></div>
<div class="container">
	<ul class="guild">
    	<li <?php if($op == '1'):?>class="on"<?php endif;?> style="margin:0; width:176px">1.转换说明</li>
        <li <?php if($op == '2'):?>class="on"<?php endif;?> >2.转换设置</li>
        <li <?php if($op == '3'):?>class="on"<?php endif;?> >3.开始转换</li>
		<li <?php if($op == '4'):?>class="on"<?php endif;?> >4.转换结束</li>
    </ul>
    <?php switch ($op) {
    	case 1:
    ?>
    <div class="help">
    	<h5>转换提示</h5>
    	 <span class="font-red">1.请先安装PHPCMS V9系统，并把转换程序文件夹上传到V9的根目录中。</span><br />
    	 <span class="font-red">2.转换前请对数据库和网站程序进行备份。</span><br />
        3.请正确的选择程序版本进行转换<br />
        <span  class="font-red">4.转换完成后，请到后台更新缓存。<br />
       5.转换完成后，请删除转换程序。</span>
    </div>
<table class="list" width="100%">
<thead>
  <tr>
    <td width="150"><span>原始版本</span></td>
    <td width="150"><span>目标版本</span></td>
    <td><span>介绍</span></td>
    <td width="80"><span>开始转换</span></td>
  </tr>
</thead>
<tbody>
  <tr>
    <td><?php echo $configs['from_application']?></td>
    <td><?php echo $configs['to_version']?></td>
    <td><div class="descripton"><?php echo str_replace("\r\n", "<br />", $configs['version_description'])?><?php if (!$config_exists):?><br><span class="font-red">请把原有系统的数据库配置文件，上传到转换程序文件夹中。并命名为config.bak.php</span><?php endif;?></div></td>
    <td>&nbsp;<?php if (!$config_exists):?><span style="color:#ccc">点击转换</span><?php else :?><a href="?op=2">点击转换</a><?php endif;?></td>
  </tr>
</tbody>
</table>
<script type="text/javascript">
$(function(){
	$('.descripton').each(function(i,n){
			if ($(this).height() > 100) {
				$(this).data('oldheight', $(this).height());
				$(this).height('100px').css('overflow', 'hidden');
				$(this).parent().append('<a href="javascript:void(0)" onclick="show_all(this)">↓全部</a>');
			}
		});
})
function show_all(obj) {
	$(obj).parent('td').children('div').height($(obj).parent('td').children('div').data('oldheight')+'px');
	$(obj).parent().append('<a href="javascript:void(0)" onclick="hidden_all(this)">↑隐藏</a>');
	$(obj).remove();
}

function hidden_all(obj) {
	$(obj).parent('td').children('div').height('100px');
	$(obj).parent().append('<a href="javascript:void(0)" onclick="show_all(this)">↓全部</a>');
	$(obj).remove();
}
</script>
<?php break;
case 2:
?>
<div class="help">
    	<h5>确认配置信息</h5>
    	 请确认以下的配置信息是否正确，如果不正确请修改正确后，进行数据转换。<br />
    </div>
    <form action="index.php?op=3">
<table class="list" width="880">

<thead>

  <tr>

    <td colspan="2"><span>数据源服务器</span></td>

    </tr>

</thead>

<tbody>
  <tr>

    <td width="146">数据库服务器<br /></td>

    <td><?php echo $old_config['hostname']?></td>


    </tr>

  <tr>

    <td>数据库用户名<br /></td>

    <td><?php echo $old_config['username']?></td>


    </tr>

  <tr>

    <td>数据库密码<br /></td>

    <td>出于安全考虑，此处不显示密码。</td>


    </tr>

  <tr>

    <td>数据库<br /></td>

    <td><?php echo $old_config['database']?></td>


    </tr>

  <tr>

    <td>数据表前缀<br /></td>

    <td><?php echo $old_config['tablepre']?></td>


    </tr>

  <tr>

    <td>数据表字符集（可选）<br /></td>

    <td><?php echo $old_config['charset']?></td>


    </tr>


  <tr>

    <td colspan="4" align="center"><input type="button" value="下一步" class="input-button" onclick="location.href='?op=3'" /></td>

    </tr>

</tbody>

</table>
</form>

<?php break;
case 3:
?>
 <div class="help" style="height:300px;overflow:auto;">
</div>
<table class="list" width="100%">
<thead>
  <tr>
    <td width="150"><span class="success">请等待，程序正在转换中...</span></td>
  </tr>
</thead>
</table>
<script type="text/javascript">
$(function(){
	install('程序开始进行转换，请不要停止浏览器', '?op=3&step=1&filename=index');
})

function install(msg, url) {
	$.ajax({type:"GET",
		cache:false,
		url:url+"&"+Math.random(),
		beforeSend:function(){$('.help').prepend(msg+"<br>");},
		dataType :'json',
		success:function(data){
			if (typeof(data.status) == 'undefined') {
				alert('程序出错了。');
			} else {
				switch(data.status) {
				case 1:
					$('.success').html("<a href='index.php?op=4' style=\"font-weight:bold;color:red\">程序运行完成，进入下一步。</a>");
					break;
				case -1:
					alert(data.msg);
					break;
				default:
					install(data.msg, data.url);
					break;
				}
			}
		}
	});
}</script>
<?php break;
case 4:
?>
    <div class="help">
    	<h5>转换完成 </h5>
        <span style="color:red">1.转换完成后，请到后台通过内容->批量更新URL，然后更新缓存。<br />
       3.转换完成后，请删除转换程序。
       </span>
    </div>
    <table class="list" width="100%">
<thead>
  <tr>
    <td width="150"><span><a href="<?php echo APP_PATH?>admin.php" style="font-weight:bold">恭喜您，转换成功！点此进入后台，记得更新缓存哟。</a></span></td>
  </tr>
</thead>
</table>
<?php };?>
</div>

<div class="footer">
Powered by phpcms v9 &copy; 2018
</div>
</body>
</html>
