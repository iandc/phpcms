<?php
$r = $db->query("SELECT * FROM phpcms_arctype");
while ($s = $db->fetch_next()) {
    $dede_cat[$s['id']] = $s;
}

$model_fieds = getcache('dede_model', 'conversion');

$f_categorys = dedecms_subcat(0);

setcache('dede_cat', $dede_cat, 'conversion');
ext_go('��Ŀ������ɡ�<br>��ʼ��ģ�͵������ݡ�', 'filename=import');