<?php

defined('IN_PHPCMS') or exit('No permission resources.');

$page = 1;
$pageSize = 10;

$db = pc_base::load_model('content_model');
$db->table_name = $db->db_tablepre . 'course';
$pdb = pc_base::load_model('position_data_model');
$num = 0;
while (1) {
    $start = ($page - 1) * $pageSize;
    $courseList = $db->select('1', '*', "$start, $pageSize", 'id ASC');;
    if (empty($courseList)) {
        echo "没有数据了<br>";
        break;
    } else {
        $total = count($courseList);
        echo "成功获取第{$page}页的数据:{$total}条<br>";
        //print_r($courseList);
        foreach ($courseList as $key => $value) {
            $id = intval($value['id']);
            $catid = intval($value['catid']);
            $title = trim($value['title']);
            $user_num = intval($value['user_num']);
            $price = floatval($value['price']);
            $present_price = floatval($value['present_price']);
            $where = [
                'id' => $id,
                'catid' => $catid,
                'modelid' => 14,
                'siteid' => 2,
            ];
            $positionData = (array)$pdb->get_one($where);
            if(empty($positionData)) {
                continue;
            }
            //print_r($positionData);
            $data = string2array($positionData['data']);
            //print_r($data);
            if(empty($data)) {
                continue;
            }
            if (trim($data['title']) == $title) {
                $data['user_num'] = $user_num;
                $data['price'] = $price;
                $data['present_price'] = $present_price;
            }
            $update = [
                'data' => array2string($data)
            ];
            $pdb->update($update, $where);
            $num += $pdb->affected_rows();
        }
    }
    $page++;
}

echo "成功修改数据:{$num}条<br>";


?>
