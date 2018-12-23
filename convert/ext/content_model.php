<?php
$model_fieds = getcache('dede_model', 'conversion');
//ģ��ԭ�ʹ洢·��
define('MODEL_PATH',PC_PATH.'modules'.DIRECTORY_SEPARATOR.'content'.DIRECTORY_SEPARATOR.'fields'.DIRECTORY_SEPARATOR);
//ģ�ͻ���·��
define('CACHE_MODEL_PATH',PHPCMS_PATH.'caches'.DIRECTORY_SEPARATOR.'caches_model'.DIRECTORY_SEPARATOR.'caches_data'.DIRECTORY_SEPARATOR);

$model_default_value = Array ( 'name' => '','tablename' => '','description' => '', 'default_style' => 'default', 'siteid' => $configs['siteid'], 'category_template' => 'category', 'list_template' => 'list', 'show_template' => 'show');

$model_db = pc_base::load_model('sitemodel_model');
$dede_config = config();
foreach ($model_fieds as $k=>$v) {
	$tablename = str_replace('addon', '', $v['addtable']);
	$model_db_value = array_merge($model_default_value, array('name'=>$v['typename'], 'tablename'=>$tablename));
	$id = $model_db->insert($model_db_value, 1);
	$model_fieds[$k]['v9_mid'] = $id;
	$model_fieds[$k]['v9_tablename'] = $tablename;
	$model_fieds[$k]['v9_tablename_data'] = $tablename.'_data';
}
setcache('dede_model', $model_fieds, 'conversion');

//�����ݿ���������ݱ�ṹ
$model_default_sql = file_get_contents(MODEL_PATH.'model.sql');
$tablepre = $model_db->db_tablepre;

$type_db = pc_base::load_model('type_model');

foreach ($model_fieds as $k=>$v) {
	$tablename = $v['v9_tablename'];
	$model_sql = str_replace('$basic_table', $tablepre.$tablename, $model_default_sql);
	$model_sql = str_replace('$table_data',$tablepre.$tablename.'_data', $model_sql);
	$model_sql = str_replace('$table_model_field',$tablepre.'model_field', $model_sql);
	$model_sql = str_replace('$modelid',$v['v9_mid'],$model_sql);
	$model_sql = str_replace('$siteid',$configs['siteid'],$model_sql);
	$model_db->sql_execute($model_sql);
	cache_field($v['v9_mid']);
	//����ȫվ�������ӿ�
	
	$type_db->insert(array('name'=>$v['typename'],'module'=>'search','modelid'=>$v['v9_mid'],'siteid'=>$configs['siteid']));
	$cache_api = pc_base::load_app_class('cache_api','admin');
	$cache_api->cache('type');
	$cache_api->search_type();
}
ext_go('��ʼΪÿ��ģ�ʹ����ֶΡ�<br>��ʼ��������ģ�͵�PHPCMS V9��ɡ�', 'filename=content_fields');
