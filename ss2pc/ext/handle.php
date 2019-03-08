<?php


$find = [
    'http://www.eetop.cn/blog/attachments',
];

$replace = [
    'http://www.eetop.cn/uploadfile',
];

$sTableName = trim($_GET['table']);
$tTableNmae = current(array_keys($converts[$sTableName]));

$pageSize = 500;

$page = empty($_GET['page']) ? 1 : intval($_GET['page']);
if ($page < 1) $page = 1;

$start = ($page - 1) * $pageSize;

$ssdb_pre = $ssdb->db_tablepre;
$pcdb_pre = $pcdb->db_tablepre;

$list = [];

if ($sTableName == 'attachments') {
    if ($page == 1) {
        $sql = "truncate table {$pcdb_pre}attachment_index";
        $pcdb->query($sql);
    }

    $sql = "SELECT * FROM " . $ssdb_pre . $sTableName . " WHERE `type`='news' LIMIT $start, $pageSize";

    $r = $ssdb->query($sql);
    $list = $ssdb->fetch_array();

    $insert = $insert2 = [];

    if ($list) {
        foreach ($list as $key => $value) {
            $value = new_stripslashes($value);
            $value = new_addslashes($value);
            $insert1 = array_flip($converts[$sTableName][$tTableNmae]);
            $insert2 = $converts[$sTableName]['create'];
            foreach ($insert1 as $k => $v) {
                $insert1[$k] = $value[$v];
            }

            foreach ($insert2 as $k => $v) {
                if ($k == 'authcode') {
                    $insert2[$k] = md5($value['filepath']);
                } else if ($k == 'status') {
                    $insert2[$k] = pc_base::load_config('system', 'attachment_stat') ? 0 : 1;
                }
            }

            $insert = $insert1 + $insert2;

            $sql = "INSERT INTO " . $pcdb_pre . $tTableNmae . " SET " . to_sqls($insert, ',');
            $pcdb->query($sql);
            $id = $pcdb->insert_id();

            $insert3 = [
                'keyid' => 'c-' . $insert['catid'] . '-' . $insert['aid'],
                'aid' => $insert['aid'],
            ];
            $sql = "INSERT INTO  " . $pcdb_pre . "attachment_index SET " . to_sqls($insert3, ',');
            $pcdb->query($sql);
        }
    }
} else if ($sTableName == 'tags') {
    $sql = "SELECT * FROM " . $ssdb_pre . $sTableName . " WHERE 1 LIMIT $start, $pageSize";

    $r = $ssdb->query($sql);
    $list = $ssdb->fetch_array();

    $insert = $insert2 = [];

    pc_base::load_sys_func('iconv');

    if ($list) {
        foreach ($list as $key => $value) {
            $value = new_stripslashes($value);
            $value = new_addslashes($value);
            $insert1 = array_flip($converts[$sTableName][$tTableNmae]);
            $insert2 = $converts[$sTableName]['create'];
            foreach ($insert1 as $k => $v) {
                $insert1[$k] = $value[$v];
            }

            foreach ($insert2 as $k => $v) {
                if ($k == 'pinyin') {
                    $word = safe_replace(addslashes($value['tagname']));
                    $word = str_replace(array('//', '#', '.'), ' ', $word);
                    $letters = gbk_to_pinyin($word);
                    $letter = strtolower(implode('', $letters));
                    $insert2[$k] = $letter;
                }
            }

            $insert = $insert1 + $insert2;

            $sql = "INSERT INTO " . $pcdb_pre . $tTableNmae . " SET " . to_sqls($insert, ',');
            $pcdb->query($sql);
            $id = $pcdb->insert_id();
        }
    }
} else if ($sTableName == 'spacetags') {
    $sql = "SELECT * FROM " . $ssdb_pre . $sTableName . " WHERE `type`='news' LIMIT $start, $pageSize";

    $r = $ssdb->query($sql);
    $list = $ssdb->fetch_array();

    $insert = $insert2 = [];

    if ($list) {
        foreach ($list as $key => $value) {
            $value = new_stripslashes($value);
            $value = new_addslashes($value);
            $insert1 = array_flip($converts[$sTableName][$tTableNmae]);
            $insert2 = $converts[$sTableName]['create'];
            foreach ($insert1 as $k => $v) {
                $insert1[$k] = $value[$v];

            }
            foreach ($insert2 as $k => $v) {
                if ($k == 'contentid') {
                    $insert2[$k] = $value['itemid'] . '-1';
                }
            }

            $insert = $insert1 + $insert2;

            $sql = "INSERT INTO " . $pcdb_pre . $tTableNmae . " SET " . to_sqls($insert, ',');
            $pcdb->query($sql);
            $id = $pcdb->insert_id();
        }
    }
} else if ($sTableName == 'categories') {
    $download_setting = '{"workflowid":"","ishtml":"0","content_ishtml":"0","create_to_html_root":"0","template_list":"drivers","category_template":"category","list_template":"list","show_template":"show","meta_title":"","meta_keywords":"","meta_description":"","presentpoint":"1","defaultchargepoint":"0","paytype":"0","repeatchargedays":"1","category_ruleid":"33","show_ruleid":"32"}';
    if ($page == 1) {
        $firstCategory = [
            'siteid' => 1,
            'module' => 'content',
            'type' => 0,//1 单网页 0 普通栏目
            'modelid' => 1,
            'catname' => '资讯',
            'catdir' => 'zixun',
            'child' => 1,
            'parentid' => 0,
            'setting' => new_addslashes($converts[$sTableName]['create']['setting']),
        ];
        $sql = "INSERT INTO " . $pcdb_pre . $tTableNmae . " SET " . to_sqls($firstCategory, ',');
        $pcdb->query($sql);
        $pid1 = $pcdb->insert_id();
        /*$firstCategory = [
            'siteid' => 1,
            'module' => 'content',
            'type' => 0,//1 单网页 0 普通栏目
            'modelid' => 2,
            'catname' => '下载',
            'catdir' => 'xiazai',
            'child'  => 1,
            'parentid' => 0,
            'setting' => new_addslashes($download_setting),
        ];
        $sql = "INSERT INTO " . $pcdb_pre . $tTableNmae . " SET " . to_sqls($firstCategory, ',');
        $pcdb->query($sql);*/
        $pid2 = $pcdb->insert_id();
    }

    $sql = "SELECT * FROM " . $ssdb_pre . $sTableName . " WHERE `type` IN ('news') LIMIT $start, $pageSize";

    $r = $ssdb->query($sql);
    $list = $ssdb->fetch_array();

    $insert = $insert2 = [];

    if ($list) {
        foreach ($list as $key => $value) {
            $value = new_stripslashes($value);
            $value = new_addslashes($value);
            $insert1 = array_flip($converts[$sTableName][$tTableNmae]);
            $insert2 = $converts[$sTableName]['create'];

            foreach ($insert1 as $k1 => $v1) {
                $insert1[$k1] = $value[$v1];
            }
            foreach ($insert2 as $k2 => $v2) {
                if ($value['type'] == 'news') {
                    $pid = $pid1;
                } else {
                    $pid = $pid2;
                }
                if ($k2 == 'parentid') {
                    $insert2[$k2] = $pid;
                } else if ($k2 == 'catdir') {
                    $catDir = getCatDirName($value['name']);
                    if(!$catDir) {
                        $catDir = 'category_' . $value['catid'];
                    }
                    $insert2[$k2] = $catDir;
                } else if ($k2 == 'setting') {
                    if ($value['type'] == 'file') {
                        $insert2['setting'] = new_addslashes($download_setting);
                    } else {
                        $insert2[$k2] = new_addslashes($v2);
                    }
                } else {
                    $insert2[$k2] = new_addslashes($v2);
                }
            }
            $insert = $insert1 + $insert2;

            $sql = "INSERT INTO " . $pcdb_pre . $tTableNmae . " SET " . to_sqls($insert, ',');
            $pcdb->query($sql);
            $id = $pcdb->insert_id();
        }
    }
} else if ($sTableName == 'spaceitems') {
    if ($page == 1) {
        $sql = "truncate table {$pcdb_pre}hits";
        $pcdb->query($sql);
    }
    $sql = "SELECT * FROM " . $ssdb_pre . $sTableName . " WHERE `type`='news' LIMIT $start, $pageSize";

    $r = $ssdb->query($sql);
    $list = $ssdb->fetch_array();

    $insert = $insert2 = [];

    if ($list) {
        foreach ($list as $key => $value) {
            $value = new_stripslashes($value);
            $value = new_addslashes($value);
            $insert1 = array_flip($converts[$sTableName][$tTableNmae]);
            $insert2 = $converts[$sTableName]['create'];
            foreach ($insert1 as $k => $v) {
                $insert1[$k] = $value[$v];
            }

            foreach ($insert2 as $k2 => $v2) {
                if ($k2 == 'updatetime') {
                    $insert2[$k2] = $value['lastpost'] ? $value['lastpost'] : $value['dateline'];
                }
            }

            $insert = $insert1 + $insert2;

            $sql = "INSERT INTO " . $pcdb_pre . $tTableNmae . " SET " . to_sqls($insert, ',');
            $pcdb->query($sql);
            $id = $pcdb->insert_id();
            $siteid = 1;
            $hits = [
                'hitsid' => "c-{$siteid}-{$value['itemid']}",
                'catid' => $value['catid'],
                'views' => $value['viewnum'],
                'updatetime' => $value['lastpost'] ? $value['lastpost'] : $value['dateline'],
            ];

            $sql = "INSERT INTO " . $pcdb_pre . "hits  SET " . to_sqls($hits, ',');
            $pcdb->query($sql);

            $catid = $value['catid'];
            $itemid = $value['itemid'];

            /*$sql = "SELECT * FROM {$ssdb_pre}spacecomments WHERE itemid='$itemid' AND `type`='news'";
            $r = $ssdb->query($sql);
            $commentlist = $ssdb->fetch_array();
            $siteid = 1;
            $title = '';
            $url = '';
            $id = '';
            $commentObj = pc_base::load_app_class('comment', 'comment');
            if ($commentlist) {
                $commentid = 'content_' . $catid . '-' . $itemid . '-' . $siteid;
                foreach ($commentlist as $k => $v) {
                    $data = [
                        'userid' => $v['authorid'],
                        'username' => $v['author'],
                        'content' => new_addslashes($v['message']),
                        'ip' => $v['ip'],
                        'creat_at' => $v['dateline'],
                    ];
                    $commentObj->add($commentid, $siteid, $data, $id, $title, $url);
                }
            }*/
        }
    }
} else if ($sTableName == 'spacenews') {
    $keys = array_keys($converts);
    $pTableName = $keys[array_search($sTableName, $keys) - 1];
    $sql = "SELECT {$ssdb_pre}{$sTableName}.* FROM  {$ssdb_pre}{$sTableName} LEFT JOIN {$ssdb_pre}{$pTableName} on {$ssdb_pre}{$sTableName}.itemid={$ssdb_pre}{$pTableName}.itemid WHERE {$ssdb_pre}{$pTableName}.`type`='news' LIMIT $start, $pageSize";

    $r = $ssdb->query($sql);
    $list = $ssdb->fetch_array();

    $insert = $insert2 = [];

    if ($list) {
        foreach ($list as $key => $value) {
            $value = new_stripslashes($value);
            $value = new_addslashes($value);
            $insert1 = array_flip($converts[$sTableName][$tTableNmae]);
            $insert2 = $converts[$sTableName]['create'];
            foreach ($insert1 as $k => $v) {
                //ss message为空取newsurl 对应pc的islink=1 和 url
                if ($k == 'url' && $value[$v]) {
                    $insert1['islink'] = 1;
                    $url = new_addslashes($value[$v]);
                }
                if ($k == 'content') {
                    $content = new_stripslashes($value[$v]);
                    $content = str_replace($find[0], $replace[0], new_stripslashes($value[$v]));
                    $insert1[$k] = new_addslashes($content);
                    $thumb = '';
                    if (preg_match_all("/(src)=([\"|']?)([^ \"'>]+\.(gif|jpg|jpeg|bmp|png))\\2/i", $content, $matches)) {
                        $auto_thumb_no = 1;//取第一张图为缩略图
                        $thumb = $matches[3][$auto_thumb_no];
                    }
                    $description = new_addslashes(str_cut(str_replace(array("\r\n", "\t", '[page]', '[/page]', '&ldquo;', '&rdquo;', '&nbsp;'), '', strip_tags($content)), 200, ''));
                } else {
                    $insert1[$k] = $value[$v];
                }
            }

            $insert = $insert1 + $insert2;

            $sql = "INSERT INTO " . $pcdb_pre . $tTableNmae . " SET " . to_sqls($insert, ',');

            $pcdb->query($sql);
            $id = $pcdb->insert_id();
            $sql = "update {$pcdb_pre}news SET `url`='$url',`description`='$description',thumb='$thumb' WHERE id={$insert['id']}";
            $pcdb->query($sql);
        }
    }
} else if ($sTableName == 'spacefiles') {
    if ($page == 1) {
        $sql = "truncate table {$pcdb_pre}download";
        $pcdb->query($sql);
        $sql = "truncate table {$pcdb_pre}download_data";
        $pcdb->query($sql);
    }

    $keys = array_keys($converts);
    $pTableName = $keys[array_search($sTableName, $keys) - 2];

    $sql = "SELECT {$ssdb_pre}{$sTableName}.*,{$ssdb_pre}{$pTableName}.catid,{$ssdb_pre}{$pTableName}.lastpost,{$ssdb_pre}{$pTableName}.dateline FROM  $ssdb_pre$sTableName LEFT JOIN $ssdb_pre$pTableName on $ssdb_pre$sTableName.itemid=$ssdb_pre$pTableName.itemid WHERE $ssdb_pre$pTableName.`type`='file' LIMIT $start, $pageSize";

    $r = $ssdb->query($sql);
    $list = $ssdb->fetch_array();

    $insert = $insert2 = [];

    if ($list) {
        foreach ($list as $key => $value) {
            $value = new_addslashes($value);
            $insert1 = array_flip($converts[$sTableName][$tTableNmae]);
            $insert2 = $converts[$sTableName]['create'];
            foreach ($insert1 as $k => $v) {
                $insert1[$k] = $value[$v];
            }

            foreach ($insert2 as $k2 => $v2) {
                if ($k2 == 'updatetime') {
                    $insert2[$k2] = $value['lastpost'] ? $value['lastpost'] : $value['dateline'];
                }
            }

            $insert = $insert1 + $insert2;

            $sql = "INSERT INTO " . $pcdb_pre . $tTableNmae . " SET " . to_sqls($insert, ',');
            $pcdb->query($sql);
            $id = $pcdb->insert_id();

            $insert3 = [
                'id' => $value['itemid'],
                'content' => $value['message'],
                'downfiles' => '',
                'template' => 'show_download',
            ];

            $tTableNmae = 'download_data';

            $sql = "INSERT INTO " . $pcdb_pre . $tTableNmae . " SET " . to_sqls($insert3, ',');
            $pcdb->query($sql);
        }
    }
}

if ($list) {
    $page++;
    ext_go("转换 $sTableName 表的第 " . ($page - 1) . " 页数据完成", "filename=handle&table=$sTableName&page=$page");
}

$keys = array_keys($converts);
$table = $keys[array_search($sTableName, $keys) + 1];

$status = 0;
if (!$table) {
    ext_go("转换所有表完成，继续下一步", '', 1);
} else {
    ext_go("转换 $sTableName 表到 $tTableNmae 完成，继续下一个表", "filename=handle&table=$table", 0);
}


function getCatDirName($catName = '')
{
    $catDirNameList = [
        'semi' => '半导体/EDA',
        'fpga' => '可编程逻辑',
        'eda-pcb' => 'EDA/PCB',
        'cpu-soc' => '处理器',
        'analog-power' => '模拟/电源',
        'rf' => '射频微波',
        'embedded' => '嵌入式',
        'measurement' => '测试测量',
        'sensor' => '传感器',
        'communication' => '通信/手机',
        'ai' => '人工智能',
        'iot' => '物联网',
        'auto' => '汽车电子',
        'medical' => '医疗电子',
        'industrial' => '工业电子',
        'consumer' => '综合电子',
        'Wearable' => '可穿戴',
        'robot' => '飞行/机器人',
        'othertech' => '其他科技',
    ];
    foreach ($catDirNameList as $key => $value) {
        if ($value == trim($catName)) {
            return $key;
        }
    }
    return '';
}



//write_log(print_r($pcdb, true));
