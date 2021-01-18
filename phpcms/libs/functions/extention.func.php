<?php

function getNickName($userid = '', $field = '')
{
    $return = '';
    if (is_numeric($userid)) {
        $member_db = pc_base::load_model('member_model');
        $memberinfo = $member_db->get_one(array('userid' => $userid));
        if (!empty($field) && $field != 'nickname' && isset($memberinfo[$field]) && !empty($memberinfo[$field])) {
            $return = $memberinfo[$field];
        } else {
            $return = isset($memberinfo['nickname']) && !empty($memberinfo['nickname']) ? $memberinfo['nickname'] . '(' . $memberinfo['username'] . ')' : $memberinfo['username'];
        }
    } else {
        if (param::get_cookie('_nickname')) {
            $return .= param::get_cookie('_nickname');
        } else {
            $return .= param::get_cookie('_username');
        }
    }
    return $return;
}

function getNewsModelItemId($siteid = 1)
{
    $CATEGORYS = getcache('category_content_' . $siteid, 'commons');
    foreach ($CATEGORYS as $key => $value) {
        if ($value['siteid'] == $siteid && $value['modelid'] == 1 && $value['parentid'] == 0) {
            return $key;
        }
    }
    return 0;
}

function getCourseModelItemId($siteid = 1)
{
    $CATEGORYS = getcache('category_content_' . $siteid, 'commons');
    foreach ($CATEGORYS as $key => $value) {
        if ($value['siteid'] == $siteid && $value['modelid'] == 14 && $value['parentid'] == 0) {
            return $key;
        }
    }
    return 0;
}

function getTeacherModelItemId($siteid=1) {
    $CATEGORYS = getcache('category_content_' . $siteid, 'commons');
    foreach ($CATEGORYS as $key => $value) {
        if ($value['siteid'] == $siteid && $value['modelid'] == 15 && $value['parentid'] == 0) {
            return $key;
        }
    }
    return 0;
}

function getActivityModelItemId($siteid=1) {
    $CATEGORYS = getcache('category_content_' . $siteid, 'commons');
    foreach ($CATEGORYS as $key => $value) {
        if ($value['siteid'] == $siteid && $value['modelid'] == 17 && $value['parentid'] == 0) {
            return $key;
        }
    }
    return 0;
}

function getAllTypeBySiteId($siteid = 1)
{
    $type_data = getcache('type_content_' . $siteid, 'commons');
    return $type_data;
}

function getTypeBySiteIdAndTypeId($typeid, $siteid = 1)
{
    $type_data = getAllTypeBySiteId($siteid);
    if (!$typeid) {
        return '';
    }
    foreach ($type_data as $key => $value) {
        if ($key == $typeid) {
            return $value['name'];
        }
    }
    return '';
}

function getCatNameByCatId($catid, $siteid = 1)
{
    $CATEGORYS = getcache('category_content_' . $siteid, 'commons');
    foreach ($CATEGORYS as $key => $value) {
        if ($key == $catid) {
            return $value['catname'];
        }
    }
    return '';
}

function replaceUrl4course($url) {
    $findUrl = siteurl(1);
    $replaceUrl = siteurl(2);
    $courseUrl = str_replace($findUrl, $replaceUrl, $url);
    return $courseUrl;
}

function replaceUrl4activity($url) {
    $findUrl = siteurl(1);
    $replaceUrl = siteurl(3);
    $courseUrl = str_replace($findUrl, $replaceUrl, $url);
    return $courseUrl;
}

function getCourseById($id, $siteid = 2) {
    if(!$id) return [];

    $MODEL = getcache('model','commons');
    $modelid = getCourseModelItemId($siteid);

    $db = pc_base::load_model('content_model');

    $r = $db->get_one(array('id'=>$id));
    if(!$r || $r['status'] != 99) return [];

    return $r;
}

function isMobile()
{
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
    {
        return true;
    }
    // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset ($_SERVER['HTTP_VIA']))
    {
        // 找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    }
    // 脑残法，判断手机发送的客户端标志,兼容性有待提高
    if (isset ($_SERVER['HTTP_USER_AGENT']))
    {
        $clientkeywords = array ('nokia',
            'sony',
            'ericsson',
            'mot',
            'samsung',
            'htc',
            'sgh',
            'lg',
            'sharp',
            'sie-',
            'philips',
            'panasonic',
            'alcatel',
            'lenovo',
            'iphone',
            'ipod',
            'blackberry',
            'meizu',
            'android',
            'netfront',
            'symbian',
            'ucweb',
            'windowsce',
            'palm',
            'operamini',
            'operamobi',
            'openwave',
            'nexusone',
            'cldc',
            'midp',
            'wap',
            'mobile'
        );
        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
        {
            return true;
        }
    }
    // 协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT']))
    {
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false ||(strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
        {
            return true;
        }
    }
    return false;
}


?>