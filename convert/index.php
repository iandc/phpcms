<?php
define('PHPCMS_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR . '../');
define('PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);
include PHPCMS_PATH . '/phpcms/base.php';
pc_base::load_sys_class('param', '', '', '0');

if (!function_exists('json_encode')) {
    showmessage('���ķ�������֧��json���밲װjson��չ��');
}

//������������
$configs = include PATH . 'config.php';

$converts = include PATH . 'db.php';

$op = isset($_GET['op']) && trim($_GET['op']) ? trim($_GET['op']) : '1';

//���ԭ��ϵͳ�������ļ��Ƿ���ڡ�
if ($op != 1 && !file_exists(PATH . 'ssdb.config.php')) {
    showmessage('ssdb.config.php�ļ������ڣ���������ssdb���ݿ�����');
}

include PATH . 'global.php';

//�汾�ļ���ַ
$version_filepath = CACHE_PATH . 'configs' . DIRECTORY_SEPARATOR . 'version.php';

//echo "<pre>";print_r($converts);exit;


$now_version = pc_base::load_config('version', 'pc_version');
$now_release = pc_base::load_config('version', 'pc_release');

switch ($op) {
    //ת����һ��
    case '1':
        $config_exists = 0;
        if (file_exists(PATH . 'ssdb.config.php')) {
            $config_exists = 1;
        }
        break;

    //ת���ڶ��������ó���
    case '2':
        $old_config = config();
        break;

    //ת�����������������ó�������
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
                ext_go('�������г��ִ����޷��ҵ���ȷ�����г���', '', -1);
            }
            exit;
        }
        break;

    //ת�����
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