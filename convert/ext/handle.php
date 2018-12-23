<?php

$find = [
    'http://www.eetop.cn/blog/attachments',
];

$replace = [
    'http://www.eetop.cn/uploadfile',
];

$sTableName = trim($_GET['table']);
$tTableNmae = current(array_keys($converts[$sTableName]));

$pageSize = 50;

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
            $value = new_addslashes($value);
            $insert1 = array_flip($converts[$sTableName][$tTableNmae]);
            $insert2 = $converts[$sTableName]['create'];
            foreach ($insert1 as $k => $v) {
                $insert1[$k] = $value[$v];
            }

            foreach ($insert2 as $k => $v) {
                if($k == 'authcode') {
                    $insert2[$k] = md5($value['filepath']);
                } else if($k == 'status') {
                    $insert2[$k] = pc_base::load_config('system','attachment_stat') ? 0 : 1;
                }
            }

            $insert = $insert1 + $insert2;

            $sql = "INSERT INTO " . $pcdb_pre . $tTableNmae . " SET " . to_sqls($insert, ',');
            $pcdb->query($sql);
            $id = $pcdb->insert_id();

            $insert3 = [
                'keyid' => 'c-'.$insert['catid'].'-'.$insert['aid'],
                'aid' => $insert['aid'],
            ];
            $sql = "INSERT INTO  ". $pcdb_pre. "attachment_index SET " . to_sqls($insert3, ',');
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
            $value = new_addslashes($value);
            $insert1 = array_flip($converts[$sTableName][$tTableNmae]);
            $insert2 = $converts[$sTableName]['create'];
            foreach ($insert1 as $k => $v) {
                $insert1[$k] = $value[$v];
            }

            foreach ($insert2 as $k => $v) {
                if($k == 'pinyin') {
                    $word = safe_replace(addslashes($value['tagname']));
                    $word = str_replace(array('//','#','.'),' ',$word);
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
            $value = new_addslashes($value);
            $insert1 = array_flip($converts[$sTableName][$tTableNmae]);
            $insert2 = $converts[$sTableName]['create'];
            foreach ($insert1 as $k => $v) {
                $insert1[$k] = $value[$v];

            }
            foreach ($insert2 as $k => $v) {
                if($k == 'contentid') {
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
    $download_setting = '{"workflowid":"","ishtml":"0","content_ishtml":"0","create_to_html_root":"0","template_list":"default","category_template":"category_download","list_template":"list_download","show_template":"show_download","meta_title":"","meta_keywords":"","meta_description":"","presentpoint":"1","defaultchargepoint":"0","paytype":"0","repeatchargedays":"1","category_ruleid":"6","show_ruleid":"16"}';
    if ($page == 1) {
        $sql = "delete from {$pcdb_pre}category where catid > 5";
        $pcdb->query($sql);
        $sql = "OPTIMIZE table {$pcdb_pre}category";
        $pcdb->query($sql);
        $sql = "REPAIR table {$pcdb_pre}category";
        $pcdb->query($sql);

        $firstCategory = [
            'siteid' => 1,
            'module' => 'content',
            'type' => 0,//1 ����ҳ 0 ��ͨ��Ŀ
            'modelid' => 1,
            'catname' => '��Ѷ',
            'catdir' => 'zixun',
            'child'  => 1,
            'parentid' => 0,
            'setting' => new_addslashes($converts[$sTableName]['create']['setting']),
        ];
        $sql = "INSERT INTO " . $pcdb_pre . $tTableNmae . " SET " . to_sqls($firstCategory, ',');
        $pcdb->query($sql);
        $pid1 = $pcdb->insert_id();
        /*$firstCategory = [
            'siteid' => 1,
            'module' => 'content',
            'type' => 0,//1 ����ҳ 0 ��ͨ��Ŀ
            'modelid' => 2,
            'catname' => '����',
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
            $value = new_addslashes($value);
            $insert1 = array_flip($converts[$sTableName][$tTableNmae]);
            $insert2 = $converts[$sTableName]['create'];

            foreach ($insert1 as $k1 => $v1) {
                $insert1[$k1] = $value[$v1];
            }
            foreach ($insert2 as $k2 => $v2) {
                if($value['type'] == 'news') {
                    $pid = $pid1;
                } else {
                    $pid = $pid2;
                }
                if ($k2 == 'parentid') {
                    $insert2[$k2] = $pid;
                } else if($k2 == 'catdir') {
                    $insert2[$k2] = 'category_' . $value['catid'];
                } else if($k2 == 'setting') {
                    if($value['type'] == 'file') {
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
        /*$sql = "truncate table {$pcdb_pre}comment";
        $pcdb->query($sql);
        $sql = "truncate table {$pcdb_pre}comment_data_1";
        $pcdb->query($sql);*/
        $sql = "truncate table {$pcdb_pre}hits";
        $pcdb->query($sql);
    }

    $sql = "SELECT * FROM " . $ssdb_pre . $sTableName . " WHERE `type`='news' LIMIT $start, $pageSize";

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
                    $insert2[$k2] = $value['lastpost'] ? $value['lastpost']:$value['dateline'];
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
                'updatetime' => $value['lastpost'] ? $value['lastpost']:$value['dateline'] ,
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
    $sql = "SELECT $ssdb_pre$sTableName.* FROM  $ssdb_pre$sTableName LEFT JOIN $ssdb_pre$pTableName on $ssdb_pre$sTableName.itemid=$ssdb_pre$pTableName.itemid WHERE $ssdb_pre$pTableName.`type`='news' LIMIT $start, $pageSize";

    $r = $ssdb->query($sql);
    $list = $ssdb->fetch_array();

    $insert = $insert2 = [];

    if ($list) {
        foreach ($list as $key => $value) {
            $value = new_addslashes($value);
            $insert1 = array_flip($converts[$sTableName][$tTableNmae]);
            $insert2 = $converts[$sTableName]['create'];
            foreach ($insert1 as $k => $v) {
                if($k == 'content') {
                    $insert1[$k] = new_addslashes(str_replace($find[0], $replace[0], new_stripslashes($value[$v])));
                } else {
                    $insert1[$k] = $value[$v];
                }
            }

            $insert = $insert1 + $insert2;

            $sql = "INSERT INTO " . $pcdb_pre . $tTableNmae . " SET " . to_sqls($insert, ',');
            $pcdb->query($sql);
            $id = $pcdb->insert_id();
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
                    $insert2[$k2] = $value['lastpost'] ? $value['lastpost']:$value['dateline'];
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
    ext_go("ת�� $sTableName ��ĵ� " . ($page - 1) . " ҳ�������", "filename=handle&table=$sTableName&page=$page");
}

$keys = array_keys($converts);
$table = $keys[array_search($sTableName, $keys) + 1];

$status = 0;
if (!$table) {
    ext_go("ת�����б���ɣ�������һ��", '', 1);
} else {
    ext_go("ת�� $sTableName �� $tTableNmae ��ɣ�������һ����", "filename=handle&table=$table", 0);
}

//write_log(print_r($pcdb, true));
