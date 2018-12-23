<?php
/**
 *
 * SupeSite����ģ����չ�ֶη�����
 * @param $str ����ģ����չ�ֶ�������Ϣ
 */
function model_field($str)
{
    $str = str_replace(array("\r", "\n"), '', $str);
    preg_match_all('/<field:([^\s]*)[\s]?([^>]*)>/i', $str, $out);
    $data = array();
    if (isset($out[1])) foreach ($out[1] as $k => $v) {
        if (isset($out[2][$k])) {
            preg_match_all('/([^\s]*)=["|\']([^\"\']*)["|\']/i', $out[2][$k], $str_out);
            foreach ($str_out[1] as $a => $c) {
                if (in_array($c, array('autofield', 'notsend', 'isnull', 'islist'))) continue;
                if (isset($str_out[2][$a])) $data[$v][$c] = $str_out[2][$a];
            }
        }
    }
    return $data;
}

/**
 *
 * SupeSite����ת��ΪPHPCMS V9����
 * @param $type SupeSite����
 */
function field_type($type)
{
    switch ($type) {
        case 'text':
        case 'textchar':
        case 'media':
        case 'addon':
        case 'imgfile':
            return 'text';
            break;

        case 'multitext':
        case 'textdata':
            return 'textarea';
            break;

        case 'htmltext':
            return 'editor';
            break;

        case 'int':
        case 'float':
        case 'number':
            return 'number';
            break;

        case 'datetime':
            return 'datetime';
            break;

        case 'img':
            return 'images';
            break;

        case 'select':
        case 'radio':
        case 'checkbox':
            return 'box';
            break;

        case 'copyfrom':
            return 'copyfrom';
            break;

        case 'softlinks':
            return 'downfiles';
            break;
    }
    return false;
}

/**
 *
 * ��SupeSite���ͣ�����PHPCMS V9�������á�
 * @param $type  SupeSite����
 */
function field_setting($type)
{
    $setting = array();
    switch ($type) {
        case 'multittext':
            $setting['width'] = '100%';
            $setting['height'] = '46';
            $setting['enablehtml'] = 0;
            break;
        case 'textdata':
            $setting['width'] = '100%';
            $setting['height'] = '46';
            $setting['enablehtml'] = 1;
            break;

        case 'htmltext':
            $setting['toolbar'] = 'full';
            $setting['enablekeylink'] = 0;
            $setting['link_mode'] = 0;
            $setting['enablesaveimage'] = 1;
            $setting['height'] = 200;
            break;

        case 'int':
        case 'number':
            $setting['minnumber'] = 1;
            $setting['maxnumber'] = '';
            $setting['decimaldigits'] = 0;
            break;

        case 'float':
            $setting['minnumber'] = 1;
            $setting['maxnumber'] = '';
            $setting['decimaldigits'] = -1;
            break;

        case 'datetime':
            $setting['fieldtype'] = 'datetime';
            $setting['format'] = 'Y-m-d H:i:s';
            break;

        case 'img':
            $setting['upload_allowext'] = 'gif|jpg|jpeg|png|bmp';
            $setting['isselectimage'] = 1;
            $setting['upload_number'] = 10;
            break;

        case 'select':
            $setting['boxtype'] = 'select';
            $setting['fieldtype'] = 'varchar';
            $setting['outputtype'] = 1;
            break;

        case 'radio':
            $setting['boxtype'] = 'radio';
            $setting['fieldtype'] = 'varchar';
            $setting['outputtype'] = 1;
            break;

        case 'checkbox':
            $setting['boxtype'] = 'checkbox';
            $setting['fieldtype'] = 'varchar';
            $setting['outputtype'] = 1;
            break;

        case 'copyfrom':
            $field_config['listorder'] = 8;
            break;

        case 'softlinks':
            $setting['upload_allowext'] = 'rar|zip';
            $setting['isselectfile'] = 1;
            $setting['upload_number'] = 10;
            $setting['downloadlink'] = 1;
            $setting['downloadtype'] = 0;
            break;
    }
    return $setting;
}

/**
 *
 * ԭ�г��������ļ�������
 */
function config()
{
    include PATH . 'config.bak.php';
    return array(
        'hostname' => $cfg_dbhost,
        'database' => $cfg_dbname,
        'username' => $cfg_dbuser,
        'password' => $cfg_dbpwd,
        'tablepre' => $cfg_dbprefix,
        'charset' => $cfg_db_language,
        'type' => 'mysql',
        'debug' => 0,
        'pconnect' => 0,
        'autoconnect' => 0
    );
}

/**
 *
 * ����ֲ�������
 * @param $msg ��ʾ��ǰ������״̬
 * @param $url ��һ��Ҫ���еĳ���
 * @param $status �Ƿ�Ϊ���һ��������Ϊ1��
 */
function ext_go($msg, $url = '', $status = 0)
{
    $dbconfig = config();
    $array = array('status' => $status, 'msg' => (strtolower($dbconfig['charset']) == 'gbk' ? iconv('gbk', 'utf-8', $msg) : $msg), 'url' => 'index.php?op=3&step=1&' . $url);
    exit(json_encode($array));
}

/**
 *
 * ����ָ��ģ���ֶλ���
 * @param $modelid
 */
function cache_field($modelid = 0)
{
    $field_db = pc_base::load_model('sitemodel_field_model');
    $field_array = array();
    $fields = $field_db->select(array('modelid' => $modelid, 'disabled' => $disabled), '*', 100, 'listorder ASC');
    foreach ($fields as $_value) {
        $setting = string2array($_value['setting']);
        $_value = array_merge($_value, $setting);
        $field_array[$_value['field']] = $_value;
    }
    setcache('model_field_' . $modelid, $field_array, 'model');
    return true;
}

/**
 *
 * SupeSite��Ŀ�ݹ�
 * @param $parentid  ָ����ĿID
 * @param $v9_catid  V9�е���ĿID��
 */
function SupeSite_subcat($parentid = 0, $v9_catid = 0)
{
    global $dede_cat;
    if (empty($dede_cat)) {
        $dede_cat = getcache('dede_cat', 'conversion');
    }
    $data = array();
    foreach ($dede_cat as $k => $v) {
        if ($v['reid'] == $parentid && $parentid != $k) {
            if (!isset($v['v9_catid'])) $v['v9_catid'] = $v9_catid;
            $dede_cat[$k]['v9_catid'] = $catid = add_cat($v['v9_catid'], $v);
            if ($str = SupeSite_subcat($k, $catid)) {
                $parentid != 0 ? $data[$k] = $str : $data[$parentid][$k] = $str;
            } else {
                $parentid != 0 ? $data[$k] = $k : $data[$parentid][$k] = $catid;
            }
        }
    }
    if (empty($data)) {
        return false;
    } else {
        return $data;
    }
}

/**
 *
 * �����Ŀ��v9���ݿ���
 * @param $parentid
 * @param $v
 */
function add_cat($parentid = 0, $v)
{
    global $model_fieds, $configs;
    $db = pc_base::load_model('category_model');
    $modelid = $model_fieds[$v['channeltype']]['v9_mid'];
    if ($v['ispart'] == 0 || $v['ispart'] == 1) {
        $sql = array('modelid' => $modelid, 'parentid' => $parentid, 'catname' => $v['typename'], 'catdir' => 'de_' . basename($v['typedir']), 'image' => '', 'description' => $v['description'], 'ismenu' => ($v['ishidden'] ? 0 : 1), 'url' => '', 'type' => 0, 'siteid' => $configs['siteid'], 'module' => 'content', 'sethtml' => '0', 'setting' => 'array ( \'workflowid\' => \'\', \'ishtml\' => \'0\', \'content_ishtml\' => \'0\', \'create_to_html_root\' => \'0\', \'template_list\' => \'default\', \'category_template\' => \'category\', \'list_template\' => \'list\', \'show_template\' => \'show\', \'meta_title\' => \'' . $v['seotitle'] . '\', \'meta_keywords\' => \'' . $v['keywords'] . '\', \'meta_description\' => \'' . $v['description'] . '\', \'presentpoint\' => \'1\', \'defaultchargepoint\' => \'0\', \'paytype\' => \'0\', \'repeatchargedays\' => \'1\', \'category_ruleid\' => \'6\', \'show_ruleid\' => \'16\', )', 'letter' => '',);
    } elseif ($v['ispart'] == 2) {
        $sql = array('siteid' => $configs['siteid'], 'module' => 'content', 'type' => 2, 'modelid' => 0, 'parentid' => $parentid, 'catname' => $v['typename'], 'url' => $v['typedir'], 'ismenu' => ($v['ishidden'] ? 0 : 1));
    }

    $id = $db->insert(new_addslashes($sql), true);
    return $id;
}

/**
 *
 * ѡ������ģ��
 * @param $modelid ģ��ID {��������ģ��ID��ʱ�򣬻�ѡ���ģ��֮���һ��ģ��}
 */
function chose_model($modelid = 0)
{
    global $dede_models;
    if (empty($dede_models)) {
        $dede_models = getcache('dede_model', 'conversion');
    }
    $now = 0;
    foreach ($dede_models as $k => $v) {
        if ($now == 1) return $k;
        if (empty($modelid) && $now == 0) {
            return $k;
        } else {
            if ($k == $modelid) {
                $now = 1;
            }
        }
    }
    return false;
}

/**
 *
 * ��������ģ������
 * @param $modelid ģ��ID
 */
function count_model_total($modelid)
{
    global $db;
    $r = $db->query("SELECT COUNT(*) AS num FROM phpcms_archives WHERE	channel='$modelid'");
    $s = $db->fetch_next();
    return $s['num'];
}

/**
 *
 * SupeSite��������ת��ΪPHPCMS V9����
 * @param $data     ����
 * @param $modelid  ģ��ID
 */
function content_format_data($data, $modelid)
{
    global $dede_models;
    $main_table = $model_table = array();
    if (!$catid = format_catid($data['typeid'])) return false;
    $main_table = array('catid' => $catid, 'title' => $data['title'], 'style' => $data['color'] . ';', 'thumb' => $data['litpic'], 'inputtime' => $data['pubdate'], 'keywords' => $data['keywords'], 'description' => $data['description'], 'status' => 99);
    if (empty($dede_models)) {
        $dede_models = getcache('dede_model', 'conversion');
    }
    $model = $dede_models[$modelid];
    if (isset($data['source'])) $model_table['copyfrom'] = $data['source'] . '|0';
    foreach ($model['fields'] as $k => $v) {
        if (!isset($data[$k])) continue;
        if ($k == 'body' && $v['type'] = 'htmltext') {
            $model_table['paginationtype'] = 0;
            if ($data[$k] = preg_replace('/#p#(.*)#e#/i', "[page]\$1[/page]", $data[$k])) {
                $model_table['paginationtype'] = 2;
            }
            if ($data[$k] = str_replace('#p#', '[page]', $data[$k])) {
                $model_table['paginationtype'] = 2;
            }
            $model_table['content'] = $data[$k];
            continue;
        } elseif ($k == 'softlinks') {
            preg_match_all('/\{dede:link[^text]*text=[\'|"]?([^\'"]*)[\'|"]?\}([^\{\}]*)\{\/dede:link\}/i', $data[$k], $out);
            $urls = array();
            foreach ($out[1] as $ke => $v) {
                if (isset($out[2][$ke])) {
                    $urls[$ke] = array('filename' => $v, 'fileurl' => $out[2][$ke]);
                } else {
                    continue;
                }
            }
            $model_table[$k] = var_export($urls, true);
        } elseif ($k == 'needmoney' && $model['addtable'] == 'dede_addonsoft') {
            $model_table['readpoint'] = $data[$k];
            $model_table['paytype'] = 1;
        } elseif ($v['type'] == 'img') {
            preg_match_all('/\{dede:img.*\}([^\{\}]*)\{\/dede:img\}/i', $data[$k], $out);
            $urls = array();
            foreach ($out[1] as $ke => $v) {
                $urls[$ke] = array('url' => $v, 'alt' => '');
            }
            $model_table[$k] = var_export($urls, true);
        } else {
            $model_table[$k] = $data[$k];
        }
    }
    return new_addslashes(array('main_table' => $main_table, 'model_table' => $model_table));
}

/**
 *
 * ��SupeSite����ĿIDת��ΪV9����ĿID
 * @param $catid SupeSite����ĿID
 */
function format_catid($catid)
{
    global $dede_catid;
    if (empty($dede_catid)) {
        $dede_catid = getcache('dede_cat', 'conversion');
    }
    if ($cat = $dede_catid[$catid]) {
        return $cat['v9_catid'];
    } else {
        return false;
    }
}

/**
 *
 * SupeSite��Ա����ת��ΪPHPCMS V9��Ա����
 * @param $data SupeSite��Ա����
 */
function member_format_data($data)
{
    global $configs;
    static $member_model;
    if (empty($member_model)) {
        $member_model = getcache('member_model', 'conversion');
    }
    $MODEL = $member_model[$data['mtype']];

    $encrypt = create_randomstr(6);
    $password = md5($data['pwd'] . $encrypt);

    $datas['sso_table'] = array('username' => $data['userid'], 'password' => $password, 'random' => $encrypt, 'email' => $data['email'], 'regip' => $data['joinip'], 'regdate' => $data['jointime'], 'lastip' => $data['loginip'], 'lastdate' => $data['logintime'], 'appname' => 'phpcms v9', 'type' => 'app', 'avatar' => 0, 'ucuserid' => 0);

    $datas['main_table'] = array('phpssouid' => '0', 'username' => $data['userid'], 'password' => $password, 'encrypt' => $encrypt, 'nickname' => $data['uname'], 'regdate' => $data['jointime'], 'lastdate' => $data['logintime'], 'regip' => $data['joinip'], 'lastip' => $data['loginip'], 'loginnum' => '0', 'email' => $data['email'], 'groupid' => member_groupid_id($data['rank']), 'areaid' => '0', 'amount' => $data['money'], 'point' => $data['scores'], 'modelid' => $MODEL['v9_member_mid'], 'message' => '0', 'islock' => '0', 'vip' => '0', 'overduedate' => '0', 'siteid' => $configs['siteid'],);

    $datas['model_table'] = array();

    foreach ($MODEL['fields'] as $key => $val) {
        if (!isset($data[$key])) {
            continue;
        }
        switch ($val['type']) {
            case 'img':
                preg_match_all('/\{dede:img.*\}([^\{\}]*)\{\/dede:img\}/i', $data[$key], $out);
                $urls = array();
                foreach ($out[1] as $ke => $v) {
                    $urls[$ke] = array('url' => $v, 'alt' => '');
                }
                $datas['model_table'][$key] = var_export($urls, true);
                break;
            default:
                $datas['model_table'][$key] = $data[$key];
        }
    }
    return new_addslashes($datas);
}

/**
 *
 * ��Ա��ת��
 * @param $rank ��Ա�ȼ�
 */
function member_groupid_id($rank)
{
    static $member_group;
    if (empty($member_group)) {
        $member_group = getcache('member_group', 'conversion');
    }
    foreach ($member_group as $k => $v) {
        if ($v['rank'] == $rank) return $v['v9_gid'];
    }
    return 6;
}

/**
 *
 * ����Ա������ѡ���Աģ��
 * @param $modelid  ģ��ID
 */
function member_model($modelid)
{
    static $member_model;
    if (empty($member_model)) {
        $member_model = getcache('member_model', 'conversion');
    }
    if (isset($member_model[$modelid])) {
        return $member_model[$modelid];
    } else {
        return false;
    }
}

/**
 *
 * ��Աģ��ѡ��ģ��
 * @param $modelid ģ��ID
 */
function member_chose_model($modelid = '')
{
    $now = 0;
    static $member_model;
    if (empty($member_model)) {
        $member_model = getcache('member_model', 'conversion');
    }

    foreach ($member_model as $k => $val) {
        if ($now == 1) return $k;
        if ($modelid == '' && $now == 0) {
            return $k;
        } elseif (!empty($modelid) && $k == $modelid) {
            $now = 1;
        }
    }
    return false;
}

function  write_log($info) {
    $fp = fopen(PATH."log/convert_log.txt","a");
    flock($fp, LOCK_EX) ;
    fwrite($fp, $info."\n");
    flock($fp, LOCK_UN);
    fclose($fp);
}