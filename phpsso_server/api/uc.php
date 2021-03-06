<?php

error_reporting(0);

define('UC_CLIENT_VERSION', '1.6.0');
define('UC_CLIENT_RELEASE', '20170101');

define('API_RETURN_SUCCEED', '1');
define('API_RETURN_FAILED', '-1');
define('API_RETURN_FORBIDDEN', '-2');

define('API_SYNLOGIN', 1);
define('API_SYNLOGOUT', 1);
define('API_DELETEUSER', 1);
define('API_RENAMEUSER', 1);
define('API_UPDATEPW', 1);
define('API_UPDATEBADWORDS', 1);
define('API_UPDATEHOSTS', 1);
define('API_UPDATEAPPS', 1);
define('API_UPDATECLIENT', 1);
define('API_UPDATECREDIT', 1);
define('API_GETCREDIT', 1);
define('API_GETCREDITSETTINGS', 1);
define('API_UPDATECREDITSETTINGS', 1);
define('API_GETTAG', 1);
define('API_ADDFEED', 0);

define('IN_API', true);
define('CURSCRIPT', 'api');


if (!defined('IN_UC')) {

    define('PHPCMS_PATH', dirname(__FILE__) . '/../');

    if (!defined('IN_PHPCMS')) include_once PHPCMS_PATH . 'phpcms/base.php';

    define('UC_KEY', pc_base::load_config('system', 'uc_key'));
    define('UCUSE', pc_base::load_config('system', 'ucuse'));

    $get = $post = array();

    $code = @$_GET['code'];
    parse_str(authcode($code, 'DECODE', UC_KEY), $get);

    if (time() - $get['time'] > 3600) {
        exit('Authracation has expiried');
    }
    if (empty($get)) {
        exit('Invalid Request');
    }

    include_once PHPCMS_PATH . 'api/uc_client/lib/xml.class.php';
    $post = xml_unserialize(file_get_contents('php://input'));

    if (in_array($get['action'], array('test', 'deleteuser', 'renameuser', 'gettag', 'synlogin', 'synlogout', 'updatepw', 'updatebadwords', 'updatehosts', 'updateapps', 'updateclient', 'updatecredit', 'getcredit', 'getcreditsettings', 'updatecreditsettings', 'addfeed'))) {
        $uc_note = new uc_note();
        //header('Content-type: text/html; charset=' . pc_base::load_config('system', 'charset'));
        echo call_user_func(array($uc_note, $get['action']), $get, $post);
        exit();
    } else {
        exit(API_RETURN_FAILED);
    }
} else {
    exit;
}

class uc_note
{

    private $member_db, $uc_db, $applist, $uc_client_cache_path;

    var $dbconfig = '';
    var $db = '';
    var $tablepre = '';
    var $appdir = '';

    function _serialize($arr, $htmlon = 0)
    {
        if (!function_exists('xml_serialize')) {
            include_once PHPCMS_PATH . 'api/uc_client/lib/xml.class.php';
        }
        return xml_serialize($arr, $htmlon);
    }

    function __construct()
    {
        require_once PHPCMS_PATH . 'caches/configs/uc_config.php';
        require_once PHPCMS_PATH . 'api/uc_client/client.php';
        $this->member_db = pc_base::load_model('member_model');
        pc_base::load_sys_class('uc_model', 'model', 0);
        $db_config = get_uc_database();
        $this->uc_db = new uc_model($db_config);
        $this->applist = getcache('applist', 'admin');
        $this->uc_client_cache_path = PHPCMS_PATH . 'api/uc_client/data/cache';
    }

    //测试通信
    public function test()
    {
        //$r = $this->uc_db->get_one(array('uid' => 3));
        //error_log(var_export($r, true), 3, CACHE_PATH.'uc_error_log.php');
        return API_RETURN_SUCCEED;
    }

    //同步登录
    public function synlogin($get, $post)
    {
        if (!API_SYNLOGIN) {
            return API_RETURN_FORBIDDEN;
        }
        header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
        $uid = intval($get['uid']);
        if (empty($uid)) return API_RETURN_FAILED;

        //获取UC中用户的信息
        $r = $this->uc_db->get_one(array('uid' => $uid));

        if ($data = $this->member_db->get_one(array('ucuserid' => $uid))) {//当用户存在时，获取用户的登陆信息
            $this->member_db->update(array('lastip' => $r['lastloginip'], 'lastdate' => $r['lastlogindate']), array('uid' => $data['uid']));
        } else { //当用户不存在是注册新用户
            $datas = $data = array('username' => $r['username'], 'password' => $r['password'], 'random' => $r['salt'], 'email' => $r['email'], 'regip' => $r['regip'], 'regdate' => $r['regdate'], 'lastdate' => $r['lastlogindate'], 'appname' => 'ucenter', 'type' => 'app');
            $datas['ucuserid'] = $uid;
            $datas['lastip'] = $r['lastloginip'];
            if ($s = $this->member_db->get_one(array('username' => $r['username']))) {
                $this->member_db->update($datas, array('uid' => $s['uid']));
                $data['uid'] = $s;
            } else {
                $data['uid'] = $this->member_db->insert($datas, true);
            }
            //向所有的应用中发布新用户注册通知
            pc_base::load_app_func('global', 'admin');
            pc_base::load_app_class('messagequeue', 'admin', 0);
            messagequeue::add('member_add', $data);
        }

        //输出应用登陆
        $res = '';
        foreach ($this->applist as $v) {
            if (!$v['synlogin']) continue;
            $f = strstr($v['url'] . $v['apifilename'], '?') ? '&' : '?';
            $res .= '<script type="text/javascript" src="' . $v['url'] . $v['apifilename'] . $f . 'time=' . SYS_TIME . '&code=' . urlencode(sys_auth('action=synlogin&username=&uid=' . $data['uid'] . '&password=&time=' . SYS_TIME, 'ENCODE', $v['authkey'])) . '" reload="1"></script>';
        }
        header("Content-type: text/javascript");
        return format_js($res);
    }

    //同步退出登录
    public function synlogout($get, $post)
    {
        if (!API_SYNLOGOUT) {
            return API_RETURN_FORBIDDEN;
        }
        $res = '';
        foreach ($this->applist as $v) {
            if ($v['appid'] != $this->appid) {
                $f = strstr($v['url'] . $v['apifilename'], '?') ? '&' : '?';
                $res .= '<script type="text/javascript" src="' . $v['url'] . $v['apifilename'] . $f . 'time=' . SYS_TIME . '&code=' . urlencode(sys_auth('action=synlogout&time=' . SYS_TIME, 'ENCODE', $v['authkey'])) . '" reload="1"></script>';
            }
        }
        header("Content-type: text/javascript");
        return format_js($res);
    }

    public function deleteuser($get, $post)
    {
        if (!API_DELETEUSER) {
            return API_RETURN_FORBIDDEN;
        }
        pc_base::load_app_func('global', 'admin');
        pc_base::load_app_class('messagequeue', 'admin', 0);
        $ids = new_stripslashes($get['ids']);
        $ids = array_map('intval', explode(',', $ids));
        $ids = implode(',', $ids);
        $s = $this->member_db->select("ucuserid in ($ids)", "uid");
        $this->member_db->delete("ucuserid in ($ids)");
        $noticedata['uids'] = array();
        if ($s) {
            foreach ($s as $key => $v) {
                $noticedata['uids'][$key] = $v['uid'];
            }
        } else {
            return API_RETURN_FAILED;
        }
        messagequeue::add('member_delete', $noticedata);
        return API_RETURN_SUCCEED;
    }

    public function renameuser($get, $post)
    {
        if (!API_RENAMEUSER) {
            return API_RETURN_FORBIDDEN;
        }
        $this->member_db->update(array('username' => $get['newusername']), array('userid' => $get['uid']));
        return API_RETURN_SUCCEED;
    }

    public function updatepw($get, $post)
    {
        if (!API_UPDATEPW) {
            return API_RETURN_FORBIDDEN;
        }
        $username = $get['username'];
        $r = $this->uc_db->get_one(array('username' => $username));
        if ($r) {
            $this->member_db->update(array('password' => $r['password'], 'random' => $r['salt']), array('username' => $username));
        }
        return API_RETURN_SUCCEED;
    }

    function updatebadwords($get, $post)
    {
        if (!API_UPDATEBADWORDS) {
            return API_RETURN_FORBIDDEN;
        }

        $data = array();
        if (is_array($post)) {
            foreach ($post as $k => $v) {
                if (substr($v['findpattern'], 0, 1) != '/' || substr($v['findpattern'], -3) != '/is') {
                    $v['findpattern'] = '/' . preg_quote($v['findpattern'], '/') . '/is';
                }
                $data['findpattern'][$k] = $v['findpattern'];
                $data['replace'][$k] = $v['replacement'];
            }
        }
        $cachefile = $this->uc_client_cache_path . '/badwords.php';
        $fp = fopen($cachefile, 'w');
        $s = "<?php\r\n";
        $s .= '$_CACHE[\'badwords\'] = ' . var_export($data, TRUE) . ";\r\n";
        fwrite($fp, $s);
        fclose($fp);

        return API_RETURN_SUCCEED;
    }

    function updatehosts($get, $post)
    {
        if (!API_UPDATEHOSTS) {
            return API_RETURN_FORBIDDEN;
        }

        $cachefile = $this->uc_client_cache_path . '/hosts.php';
        $fp = fopen($cachefile, 'w');
        $s = "<?php\r\n";
        $s .= '$_CACHE[\'hosts\'] = ' . var_export($post, TRUE) . ";\r\n";
        fwrite($fp, $s);
        fclose($fp);

        return API_RETURN_SUCCEED;
    }

    function updateclient($get, $post)
    {
        if (!API_UPDATECLIENT) {
            return API_RETURN_FORBIDDEN;
        }

        $cachefile = $this->uc_client_cache_path . '/settings.php';
        $fp = fopen($cachefile, 'w');
        $s = "<?php\r\n";
        $s .= '$_CACHE[\'settings\'] = ' . var_export($post, TRUE) . ";\r\n";
        fwrite($fp, $s);
        fclose($fp);

        return API_RETURN_SUCCEED;
    }

    public function updateapps($get, $post)
    {
        if (!API_UPDATEAPPS) {
            return API_RETURN_FORBIDDEN;
        }

        $UC_API = '';
        if ($post['UC_API']) {
            $UC_API = str_replace(array('\'', '"', '\\', "\0", "\n", "\r"), '', $post['UC_API']);
            unset($post['UC_API']);
        }

        $cachefile = $this->uc_client_cache_path . '/apps.php';
        $fp = fopen($cachefile, 'w');
        $s = "<?php\r\n";
        $s .= '$_CACHE[\'apps\'] = ' . var_export($post, TRUE) . ";\r\n";
        fwrite($fp, $s);
        fclose($fp);

        $uc_config_filename = PHPCMS_PATH . 'caches/configs/uc_config.php';
        if ($UC_API && is_writeable($uc_config_filename)) {
            if (preg_match('/^https?:\/\//is', $UC_API)) {
                $configfile = trim(file_get_contents($uc_config_filename));
                $configfile = substr($configfile, -2) == '?>' ? substr($configfile, 0, -2) : $configfile;
                $configfile = preg_replace("/define\('UC_API',\s*'.*?'\);/i", "define('UC_API', '" . addslashes($UC_API) . "');", $configfile);
                if ($fp = @fopen($uc_config_filename, 'w')) {
                    @fwrite($fp, trim($configfile));
                    @fclose($fp);
                }
            }
        }
        return API_RETURN_SUCCEED;
    }
}

function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0)
{

    $ckey_length = 4;

    $key = md5($key ? $key : UC_KEY);
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()), -$ckey_length)) : '';

    $cryptkey = $keya . md5($keya . $keyc);
    $key_length = strlen($cryptkey);

    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
    $string_length = strlen($string);

    $result = '';
    $box = range(0, 255);

    $rndkey = array();
    for ($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }

    for ($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }

    for ($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }

    if ($operation == 'DECODE') {
        if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        return $keyc . str_replace('=', '', base64_encode($result));
    }

}

