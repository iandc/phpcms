<?php

$now_modelid = isset($_GET['now_modelid']) ? urldecode($_GET['now_modelid']) : 0;
$total = isset($_GET['total']) && intval($_GET['total']) ? intval($_GET['total']) : 0;
$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;
$pagesize = 500;

$member_model = getcache('member_model', 'conversion');



if (empty($now_modelid)) {
	$now_modelid = member_chose_model();
	$total = 0;
	$page = 1;
}

if (empty($total)) {
	$total = $db->query("SELECT COUNT(*) as num FROM ".$member_model[$now_modelid]['table']);
	$total = $db->fetch_next();
	$total = $total['num'];
}

$offset = ($page-1) * $pagesize;

if ($offset >= $total) {
	$now_modelid = member_chose_model($now_modelid);
	if (!$now_modelid) ext_go('数据导入完成。', '', 1);
	$total = $db->query("SELECT COUNT(*) as num FROM ".$member_model[$now_modelid]['table']);
	$total = $db->fetch_next();
	$total = $total['num'];
	$page = 1;
	$offset = 0;
}

$MODEL = $member_model[$now_modelid];

$member_db = pc_base::load_model('member_model');

/*var_export($member_db->get_one(array('userid'=>1)));
exit;*/

$sql = "SELECT * FROM phpcms_member as m, ".$MODEL['table']." as c WHERE m.mid = c.mid LIMIT $offset,$pagesize";
$r = $db->query($sql);
while ($s = $db->fetch_next()) {
	$data = member_format_data($s);
	$member_db->query("INSERT INTO phpcms_sso_members SET ".to_sqls($data['sso_table'], ','));
	$sso_id = $member_db->insert_id();
	$data['main_table']['phpssouid'] = $sso_id;
	$member_db->set_model();
	$member_db->insert($data['main_table']);
	$uid = $member_db->insert_id();
	$data['model_table']['userid'] = $uid;
	$member_db->set_model($data['main_table']['modelid']);
	$member_db->insert($data['model_table']);
}
ext_go('正在导入"'.$MODEL['name'].'"会员模型('.($offset < $total ? ($offset >= 0 ? (($pagesize*$page)>=$total ? $total : ($pagesize*$page)) : $pagesize) : 0).'/'.$total.')', 'filename=member_import&now_modelid='.urlencode($now_modelid).'&total='.$total.'&page='.($page+1));