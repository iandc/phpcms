<?php

$ssdb_pre = $ssdb->db_tablepre;
$pcdb_pre = $pcdb->db_tablepre;

$keys = array_keys($converts);
$table = $keys[0];

foreach ($converts as $value) {
    $keys = array_keys($value);
    $dbname = $keys[0];
    if($dbname == 'category') {
        continue;
    }
    $sql = "truncate table ".$pcdb_pre.$dbname;
    $pcdb->query($sql);
    $sql = "OPTIMIZE table ".$pcdb_pre.$dbname;
    $pcdb->query($sql);
    $sql = "REPAIR table ".$pcdb_pre.$dbname;
    $pcdb->query($sql);
}

ext_go('ת��ǰ�Ļ���������ɣ���һ����ʼת��������', "filename=handle&table=$table");
