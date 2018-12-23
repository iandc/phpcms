<?php
//模型原型存储路径
define('MODEL_PATH', PC_PATH . 'modules' . DIRECTORY_SEPARATOR . 'content' . DIRECTORY_SEPARATOR . 'fields' . DIRECTORY_SEPARATOR);
//模型缓存路径
define('CACHE_MODEL_PATH', PHPCMS_PATH . 'caches' . DIRECTORY_SEPARATOR . 'caches_model' . DIRECTORY_SEPARATOR . 'caches_data' . DIRECTORY_SEPARATOR);

define('IN_ADMIN', 'true');

/**
 *
 * 为模型中添加扩展字段
 * @author chenzhouyu
 *
 */
class creat_fields
{
    protected $db;

    function __construct()
    {
        $this->db = pc_base::load_model('sitemodel_field_model');
    }

    function creat_field()
    {
        global $configs;
        $model_cache = getcache('model', 'commons');
        $model_fieds = getcache('dede_model', 'conversion');
        foreach ($model_fieds as $k => $v) {
            $tablename = $this->db->db_tablepre . $v['v9_tablename_data'];
            $modelid = $v['v9_mid'];
            $v['fields']['copyfrom'] = array('itemname' => '来源', 'type' => 'copyfrom', 'default' => '', 'maxlength' => '', 'page' => '');
            foreach ($v['fields'] as $key => $val) {
                if ($key == 'needmoney') continue;
                if ($key == 'body' && $val['type'] == 'htmltext') continue;
                if (!$formtype = field_type($val['type'])) continue;
                $field_config = array('formtype' => $formtype, 'issystem' => '0', 'field' => $key, 'name' => $val['itemname'], 'tips' => '', 'formattribute' => '', 'css' => '', 'minlength' => '0', 'maxlength' => $val['maxlength'], 'pattern' => '', 'errortips' => '', 'isbase' => '1', 'issearch' => '0', 'isadd' => '1', 'isomnipotent' => '0', 'isposition' => '0', 'modelid' => $modelid, 'setting' => '', 'siteid' => $configs['siteid'], 'unsetgroupids' => '', 'unsetroleids' => '',);
                $field = $field_config['field'];
                $minlength = 0;
                $maxlength = $field_config['maxlength'];
                $field_type = $field_config['formtype'];

                require MODEL_PATH . $field_type . DIRECTORY_SEPARATOR . 'config.inc.php';
                $setting = array();
                $setting['defaultvalue'] = $val['default'];

                //为box类型设置他们的选项
                if ($val['type'] == 'select' || $val['type'] == 'radio' || $val['type'] == 'checkbox') {
                    $setting['defaultvalue'] = '';
                    $option = '';
                    if (!empty($val['default'])) {
                        $option = explode(',', $val['default']);
                        foreach ($option as $a => $b) {
                            $option[$a] = $b . '|' . $b;
                        }
                        $setting['options'] = implode("\n", $option);
                    }
                }


                require MODEL_PATH . 'add.sql.php';

                $setting = field_setting($val['type']);

                $field_config['setting'] = array2string($setting);
                $this->db->insert($field_config);

                cache_field($modelid);
            }

        }
    }
}


$creat_fields = new creat_fields();
$creat_fields->creat_field();
ext_go('开始创建栏目。<br>为每个模型创建字段完成。', 'filename=content_category');
