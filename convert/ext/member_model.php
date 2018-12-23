<?php
//模型原型存储路径
define('MODEL_PATH',PC_PATH.'modules'.DIRECTORY_SEPARATOR.'member'.DIRECTORY_SEPARATOR.'fields'.DIRECTORY_SEPARATOR);
//模型缓存路径
define('CACHE_MODEL_PATH',PHPCMS_PATH.'caches'.DIRECTORY_SEPARATOR.'caches_model'.DIRECTORY_SEPARATOR.'caches_data'.DIRECTORY_SEPARATOR);

define('IN_ADMIN', 'true');


class member_model{
	
	public function __construct() {
		$this->db = pc_base::load_model('sitemodel_field_model');
	}
	
	public function create_fields($db, $configs) {
		$r = $db->query("SELECT * FROM phpcms_member_model");

		$sitemodel_db = pc_base::load_model('sitemodel_model');
		
		while ($s = $db->fetch_next()) {
			$s['fields'] = model_field($s['info']);
			unset($s['info']);
			
			$sql = array ( 'name' => $s['name'], 'tablename' => str_replace($db_config['dedecms']['tablepre'], '', $s['table']), 'description' => $s['description'], 'type' => 2, 'siteid' => $configs['siteid']);
			$s['v9_member_mid'] = $sitemodel_db->insert($sql, true);
			
			if ($s['v9_member_mid']) {
				$model_sql = file_get_contents(MODEL_PATH.'model.sql');
				$tablepre = $sitemodel_db->db_tablepre;
				$model_sql = str_replace('$tablename', $tablepre.$sql['tablename'], $model_sql);
				
				$sitemodel_db->sql_execute($model_sql);
				
				
				$tablename = $tablepre.$sql['tablename'];
				$s['v9_tablename'] = $tablename;
				foreach($s['fields'] as $k=>$v) {
					//修改模型表字段
					$field = $k;
					$minlength =  0;
					$maxlength = $v['maxlength'] ? $v['maxlength'] : 0;
					$field_type = field_type($v['type']);
					if (empty($field_type)) {
						continue;
					}
					require MODEL_PATH.$field_type.DIRECTORY_SEPARATOR.'config.inc.php';	
					require MODEL_PATH.'add.sql.php';
					
					$m = array ( 'formtype' => field_type($v['type']), 'issystem' => '0', 'field' => $k, 'name' => $v['itemname'], 'tips' => '', 'formattribute' => '', 'css' => '', 'minlength' => '0', 'maxlength' => $v['maxlength'], 'pattern' => '', 'errortips' => '', 'isbase' => '0', 'issearch' => '0', 'isadd' => '1', 'isomnipotent' => '0', 'isposition' => '0', 'modelid' => $s['v9_member_mid'], 'setting' => '', 'siteid' => $configs['siteid'], 'unsetgroupids' => '', 'unsetroleids' => '', );
					
					$setting['defaultvalue'] = $v['default'];
					
					$m['setting'] = field_setting($v['type']);
					
					//为box类型设置他们的选项
					if ($m['formtype'] == 'box') {
						$m['setting']['defaultvalue'] = '';
						$option = '';
						if (!empty($v['default'])) {
							$option = explode(',', $v['default']);
							foreach ($option as $a=>$b) {
								$option[$a] = $b.'|'.$b;
							}
							$m['setting']['options'] = implode("\n", $option);
						}
					}
		
					$m['setting'] = array2string($m['setting']);
						
					$fieldid = $this->db->insert($m, 1);
				}
				//更新模型缓存
				pc_base::load_app_class('member_cache','member','');
				member_cache::update_cache_model();
			}
			
			
			$data[$s['name']] = $s;
		}
		
		setcache('member_model', $data, 'conversion');
	}
}

$member_model = new member_model;
$member_model->create_fields($db, $configs);
ext_go('开始导入会员组数据。<br>会员模型导入完成。', 'filename=member_group');