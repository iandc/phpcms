<?php

$ssdb_pre = $ssdb->db_tablepre;
$pcdb_pre = $pcdb->db_tablepre;

$keys = array_keys($converts);
$table = $keys[0];

foreach ($converts as $value) {
    $keys = array_keys($value);
    $dbname = $keys[0];
    $sql = "truncate table ".$pcdb_pre.$dbname;
    $pcdb->query($sql);
    $sql = "OPTIMIZE table ".$pcdb_pre.$dbname;
    $pcdb->query($sql);
    $sql = "REPAIR table ".$pcdb_pre.$dbname;
    $pcdb->query($sql);
}

ext_go('转换前的基本配置完成，下一步开始转换各个表', "filename=handle&table=$table");
