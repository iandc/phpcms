<?php
set_time_limit(600);
$dede_models = getcache('dede_model', 'conversion');
$dede_catid = getcache('dede_cat', 'conversion');

$now_modelid = isset($_GET['now_modelid']) ? $_GET['now_modelid'] : 0;
$total = isset($_GET['total']) && intval($_GET['total']) ? intval($_GET['total']) : 0;
$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
$pagesize = 500;

if (empty($now_modelid)) {
	$now_modelid = chose_model();
	$total = 0;
	$page = 1;
}

if (empty($total)) {
	$total = count_model_total($now_modelid);
}

$offset = ($page-1) * $pagesize;


if ($offset >= $total) {
	$now_modelid = chose_model($now_modelid);
	if (!$now_modelid) ext_go('��ʼ�����Ա���ݡ�<br>�������ݵ�����ɡ�', 'filename=member_model');
	$total = count_model_total($now_modelid);
	$page = 1;
	$offset = 0;
}

$dede_model = $dede_models[$now_modelid];
$tablename = str_replace($db_config['dedecms']['tablepre'], 'phpcms_', $dede_model['addtable']);

$content_db = pc_base::load_model('content_model');

$sql = "SELECT * FROM phpcms_archives as a, $tablename as c WHERE a.id = c.aid LIMIT $offset,$pagesize";
$r = $db->query($sql);
while ($s = $db->fetch_next()) {
	$data = content_format_data($s, $s['channel']);
	if(!empty($data['main_table']) || !empty($data['model_table'])) {
		$content_db->query("INSERT INTO phpcms_".$dede_model['v9_tablename'].' SET '.to_sqls($data['main_table'], ','));
		$id = $content_db->insert_id();
		$data['model_table']['id'] = $id;
		$content_db->query("INSERT INTO phpcms_".$dede_model['v9_tablename_data'].' SET '.to_sqls($data['model_table'], ','));
		$content_db->query("INSERT INTO phpcms_hits SET hitsid='c-".$dede_model['v9_mid']."-".$id."', views='".$s['click']."'");
	}
}


ext_go('���ڵ���'.$dede_models[$now_modelid]['typename'].'('.($offset < $total ? ($offset >= 0 ? (($pagesize*$page)>=$total ? $total : ($pagesize*$page)) : $pagesize) : 0).'/'.$total.')', 'filename=content_import&now_modelid='.$now_modelid.'&total='.$total.'&page='.($page+1));