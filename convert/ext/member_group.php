<?php
$member_group_db = pc_base::load_model('member_group_model');

$default_member_setting = array ( 'name' => '', 'issystem' => '0', 'starnum' => '2', 'point' => '100', 'allowmessage' => '150', 'allowvisit' => '0', 'allowpost' => '1', 'allowpostverify' => '0', 'allowsearch' => '0', 'allowupgrade' => '0', 'allowsendmessage' => '0', 'allowpostnum' => '0', 'allowattachment' => '0', 'price_y' => '0.00', 'price_m' => '0.00', 'price_d' => '0.00', 'icon' => '', 'usernamecolor' => '', 'description' => '', 'disabled' => '0');

$r = $db->query("SELECT * FROM phpcms_arcrank WHERE adminrank = 5");
$data = array();

while ($s = $db->fetch_next()) {
	$m['name'] = $s['membername'];
	$m['point'] = $s['scores'];
	$m = array_merge($default_member_setting, $m);
	$id = $member_group_db->insert($m, TRUE);
	if (empty($id)) continue;
	$s['v9_gid'] = $id;
	$data[$s['id']] = $s;
}
setcache('member_group', $data, 'conversion');
ext_go('开始导入会员数据。<br>会员组数据导入完成。', 'filename=member_import');