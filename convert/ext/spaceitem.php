<?php

$sTableName = trim($_GET['filename']);
$tTableNmae = current(array_keys($converts[$sTableName]));

$pageSize = 500;

$page = empty($_GET['page']) ? 1 : intval($_GET['page']);
if ($page < 1) $page = 1;

$start = ($page - 1) * $pageSize;

$ssdb_pre = $ssdb->db_tablepre;
$pcdb_pre = $pcdb->db_tablepre;

$sql = "SELECT * FROM " . $ssdb_pre . $sTableName . " WHERE `type`='news' LIMIT $start, $pageSize";

$r = $ssdb->query($sql);
$list = $ssdb->fetch_array();

$insert = $insert2 = [];

if ($list) {
    foreach ($list as $key => $value) {
        $insert1 = array_flip($converts[$sTableName][$tTableNmae]);
        foreach ($insert1 as $k => $v) {
            $insert1[$k] = $value[$v];
        }
        $insert2 = $converts[$sTableName]['create'];
        $insert = $insert1 + $insert2;

        $sql = "INSERT INTO " . $pcdb_pre . $tTableNmae . " SET " . to_sqls($insert, ',');
        $pcdb->query($sql);
        $id = $pcdb->insert_id();
    }
    $page++;
    ext_go("转换 $sTableName 表的第 " . ($page - 1) . " 页数据完成", "filename=$sTableName&page=$page");
}

$keys = array_keys($converts);
$filename = $keys[array_search($sTableName, $keys) + 1];

$status = 0;
if (!$filename) {
    $status = 1;
}
ext_go("转换 $sTableName 表到 $tTableNmae 完成，继续下一个表", "filename=$filename", $status);

//write_log(print_r($pcdb, true));
