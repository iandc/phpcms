<?php

error_reporting(7);

define('PHPCMS_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR . '../');
define('PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);
include PHPCMS_PATH . '/phpcms/base.php';
pc_base::load_sys_class('param', '', '', '0');

if (!function_exists('json_encode')) {
    showmessage('您的服务器不支持json，请安装json扩展。');
}

//升级程序配置
$configs = include PATH . 'config.php';

$converts = include PATH . 'db.php';

$op = isset($_GET['op']) && trim($_GET['op']) ? trim($_GET['op']) : '1';

//检查原有系统的配置文件是否存在。
if ($op != 1 && !file_exists(PATH . 'ssdb.config.php')) {
    showmessage('ssdb.config.php文件不存在，请先设置ssdb数据库配置');
}

include PATH . 'global.php';

//版本文件地址
$version_filepath = CACHE_PATH . 'configs' . DIRECTORY_SEPARATOR . 'version.php';

//echo "<pre>";print_r($converts);exit;


$now_version = pc_base::load_config('version', 'pc_version');
$now_release = pc_base::load_config('version', 'pc_release');

switch ($op) {
    //转换第一步
    case '1':
        $config_exists = 0;
        if (file_exists(PATH . 'ssdb.config.php')) {
            $config_exists = 1;
        }
        break;

    //转换第二步，配置程序
    case '2':
        $old_config = config();
        break;

    //转换第三步，进行配置程序升级
    case '3':
        if (isset($_GET['step'])) {
            $filename = isset($_GET['filename']) && trim($_GET['filename']) ? trim($_GET['filename']) : 'index';
            $ext_path = PATH . 'ext' . DIRECTORY_SEPARATOR . $filename . '.php';
            if (file_exists($ext_path)) {
                pc_base::load_sys_class("get_model", "model", 0);
                $db_config = array('supesite' => config());
                $ssdb = new get_model($db_config, 'supesite');
                $pcdb = new get_model();
                include $ext_path;
            } else {
                ext_go('程序运行出现错误，无法找到正确的运行程序', '', -1);
            }
            exit;
        }
        break;

    //转换完成
    case '4':
        $data = array('pc_version' => $configs['to_version'], 'pc_release' => $configs['to_release']);
        $version_update_success = 0;
        if (@file_put_contents($version_filepath, '<?php return ' . var_export($data, true) . '?>')) {
            $version_update_success = 1;
        }
        break;
}
include PATH . 'template' . DIRECTORY_SEPARATOR . 'index.php';
?>