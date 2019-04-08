<?php
defined('IN_PHPCMS') or exit('No permission resources.');
//ģ�ͻ���·��
define('CACHE_MODEL_PATH', CACHE_PATH . 'caches_model' . DIRECTORY_SEPARATOR . 'caches_data' . DIRECTORY_SEPARATOR);
pc_base::load_app_func('util', 'content');

class MY_index extends index
{
    private $db;

    function __construct()
    {
        parent::__construct();
    }

    public function test() {
        echo getNewsModelItemId();
    }

    public function lists()
    {
        if(is_numeric($_GET['catid'])) {
            $catid = $_GET['catid'] = intval($_GET['catid']);
        } else if(is_string($_GET['catid'])) {
            $catid = 0;
            $siteid = 1;
            $CATEGORYS = getcache('category_content_' . $siteid, 'commons');
            foreach ($CATEGORYS as $value) {
                if($value['catdir'] && $value['catdir'] == trim($_GET['catid'])) {
                    $catid = $value['catid'];
                    $catdir = $value['catdir'];
                    break;
                }
            }
        } else if(empty($catid)) {
            $catid = getNewsModelItemId();
        }

        $typeid = 0;
        if(is_numeric($_GET['typeid'])) {
            $typeid = $_GET['typeid'] = intval($_GET['typeid']);
        } else if(is_string($_GET['typeid'])) {
            $siteid = 1;
            $typeList = getcache('type_content_'.$siteid, 'commons');
            foreach ($typeList as $value) {
                if($_GET['typeid'] == $value['description']) {
                    $typeid = $value['typeid'];
                    $typename = $value['description'];
                    break;
                }
            }
        } else {
            $typeid = 0;
        }

        $_priv_data = $this->_category_priv($catid);
        if ($_priv_data == '-1') {
            $forward = urlencode(get_url());
            showmessage(L('login_website'), APP_PATH . 'index.php?m=member&c=index&a=login&forward=' . $forward);
        } elseif ($_priv_data == '-2') {
            showmessage(L('no_priv'));
        }
        $_userid = $this->_userid;
        $_username = $this->_username;
        $_groupid = $this->_groupid;

        if (!$catid) showmessage(L('category_not_exists'), 'blank');
        $siteids = getcache('category_content', 'commons');
        $siteid = $siteids[$catid];
        $CATEGORYS = getcache('category_content_' . $siteid, 'commons');
        if (!isset($CATEGORYS[$catid])) showmessage(L('category_not_exists'), 'blank');
        $CAT = $CATEGORYS[$catid];
        $siteid = $GLOBALS['siteid'] = $CAT['siteid'];
        extract($CAT);
        $setting = string2array($setting);
        //SEO
        if (!$setting['meta_title']) $setting['meta_title'] = $catname;
        $SEO = seo($siteid, '', $setting['meta_title'], $setting['meta_description'], $setting['meta_keywords']);
        define('STYLE', $setting['template_list']);
        $page = intval($_GET['page']);

        $template = $setting['category_template'] ? $setting['category_template'] : 'category';
        $template_list = $setting['list_template'] ? $setting['list_template'] : 'list';

        if ($type == 0) {
            $template = $child ? $template : $template_list;
            $arrparentid = explode(',', $arrparentid);
            $top_parentid = $arrparentid[1] ? $arrparentid[1] : $catid;
            $array_child = array();
            $self_array = explode(',', $arrchildid);
            foreach ($self_array as $arr) {
                if ($arr != $catid && $CATEGORYS[$arr]['parentid'] == $catid) {
                    $array_child[] = $arr;
                }
            }
            $arrchildid = implode(',', $array_child);
            //URL
            $urlrules = getcache('urlrules', 'commons');
            $urlrules = str_replace('|', '~', $urlrules[$category_ruleid]);

            $urlrules = '{$page}';
            $tmp_urls = explode('~', $urlrules);
            $tmp_urls = isset($tmp_urls[1]) ? $tmp_urls[1] : $tmp_urls[0];
            preg_match_all('/{\$([a-z0-9_]+)}/i', $tmp_urls, $_urls);

            if (!empty($_urls[1])) {
                foreach ($_urls[1] as $_v) {
                    $GLOBALS['URL_ARRAY'][$_v] = $_GET[$_v];
                }
            }
            define('URLRULE', $urlrules);
            $GLOBALS['URL_ARRAY']['categorydir'] = $categorydir;
            $GLOBALS['URL_ARRAY']['catdir'] = $catdir;
            $GLOBALS['URL_ARRAY']['catid'] = $catid;
            $GLOBALS['URL_ARRAY']['typeid'] = $typeid;
            $GLOBALS['URL_ARRAY']['typename'] = $typename;
            include template('content', $template);
        } else {
            $this->page_db = pc_base::load_model('page_model');
            $r = $this->page_db->get_one(array('catid' => $catid));
            if ($r) extract($r);
            $template = $setting['page_template'] ? $setting['page_template'] : 'page';
            $arrchild_arr = $CATEGORYS[$parentid]['arrchildid'];
            if ($arrchild_arr == '') $arrchild_arr = $CATEGORYS[$catid]['arrchildid'];
            $arrchild_arr = explode(',', $arrchild_arr);
            array_shift($arrchild_arr);
            $keywords = $keywords ? $keywords : $setting['meta_keywords'];
            $SEO = seo($siteid, 0, $title, $setting['meta_description'], $keywords);
            include template('content', $template);
        }
    }


    public function category()
    {
        if(is_int($_GET['catid'])) {
            $catid = $_GET['catid'] = intval($_GET['catid']);
        } else if(is_string($_GET['catdir'])) {
            $siteid = 1;
            $CATEGORYS = getcache('category_content_' . $siteid, 'commons');
            foreach ($CATEGORYS as $value) {
                if($value['catdir'] && $value['catdir'] == trim($_GET['catdir'])) {
                    $catid = $value['catid'];
                    break;
                }
            }
            $catdir = $_GET['catid'] = strval($_GET['catid']);
        } else if(empty($catid)) {
            $catid = getNewsModelItemId();
        }

        $_priv_data = $this->_category_priv($catid);
        if ($_priv_data == '-1') {
            $forward = urlencode(get_url());
            showmessage(L('login_website'), APP_PATH . 'index.php?m=member&c=index&a=login&forward=' . $forward);
        } elseif ($_priv_data == '-2') {
            showmessage(L('no_priv'));
        }
        $_userid = $this->_userid;
        $_username = $this->_username;
        $_groupid = $this->_groupid;

        if (!$catid) showmessage(L('category_not_exists'), 'blank');
        $siteids = getcache('category_content', 'commons');
        $siteid = $siteids[$catid];
        $CATEGORYS = getcache('category_content_' . $siteid, 'commons');
        if (!isset($CATEGORYS[$catid])) showmessage(L('category_not_exists'), 'blank');
        $CAT = $CATEGORYS[$catid];
        $siteid = $GLOBALS['siteid'] = $CAT['siteid'];
        extract($CAT);
        $setting = string2array($setting);
        //SEO
        if (!$setting['meta_title']) $setting['meta_title'] = $catname;
        $SEO = seo($siteid, '', $setting['meta_title'], $setting['meta_description'], $setting['meta_keywords']);
        define('STYLE', $setting['template_list']);
        $page = intval($_GET['page']);

        $template = 'category';
        $template_list = 'category';

        if ($type == 0) {
            $template = $child ? $template : $template_list;
            $arrparentid = explode(',', $arrparentid);
            $top_parentid = $arrparentid[1] ? $arrparentid[1] : $catid;
            $array_child = array();
            $self_array = explode(',', $arrchildid);
            foreach ($self_array as $arr) {
                if ($arr != $catid && $CATEGORYS[$arr]['parentid'] == $catid) {
                    $array_child[] = $arr;
                }
            }
            $arrchildid = implode(',', $array_child);
            //URL
            $urlrules = getcache('urlrules', 'commons');
            $urlrules = str_replace('|', '~', $urlrules[$category_ruleid]);
            $tmp_urls = explode('~', $urlrules);
            $tmp_urls = isset($tmp_urls[1]) ? $tmp_urls[1] : $tmp_urls[0];
            preg_match_all('/{\$([a-z0-9_]+)}/i', $tmp_urls, $_urls);
            if (!empty($_urls[1])) {
                foreach ($_urls[1] as $_v) {
                    $GLOBALS['URL_ARRAY'][$_v] = $_GET[$_v];
                }
            }
            define('URLRULE', $urlrules);
            $GLOBALS['URL_ARRAY']['categorydir'] = $categorydir;
            $GLOBALS['URL_ARRAY']['catdir'] = $catdir;
            $GLOBALS['URL_ARRAY']['catid'] = $catid;
            include template('content', $template);
        }
    }

}

?>