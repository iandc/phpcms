<?php

defined('IN_PHPCMS') or exit('No permission resources.');

$url = 'https://study.163.com/j/cp/courseList.json?';

$query = [
    'limit' => 100,
    'offset' => 0,
    'pageIndex' => 1,
    'pageSize' => 10,
    'relativeOffset' => 0,
    'providerId' => 400000000537049,
    'productType' => 0,
    'orderType' => 1,
    't' => 0,
];

$db = pc_base::load_model('content_model');
$db->table_name = $db->db_tablepre . 'course';
$pageIndex = 1;
$num = $num1 = 0;
while (1) {
    $courseList = getCourseList($url, $query, $pageIndex);
    $courseList = json_decode($courseList, true);
    if (empty($courseList['result']['list'])) {
        echo "没有数据了<br>";
        break;
    } else {
        $total = count($courseList['result']['list']);
        echo "成功获取第{$pageIndex}页的数据:{$total}条<br>";
        //echo "<pre>";print_r($courseList);
        $list = $courseList['result']['list'];
        foreach ($list as $key => $value) {
            $title = trim($value['productName']);
            $user_num = intval($value['learnerCount']);
            $originalPrice = floatval($value['originalPrice']);
            if (is_null($value['discountPrice'])) {
                $value['discountPrice'] = $originalPrice;
            }
            $discountPrice = floatval($value['discountPrice']);
            $description = trim($value['description']);

            $lessonCount = intval($value['lessonCount']);
            $imgUrl = trim($value['imgUrl']);
            $bigImgUrl = trim($value['bigImgUrl']);
            $score = floatval($value['score']);
            $scoreLevel = intval($value['scoreLevel']);

            //$discountRate = floatval($value['discountRate']);
            $data = [
                'user_num' => $user_num,
                'price' => $originalPrice,
                'present_price' => $discountPrice,
                //'description' => $description,
            ];
            $where = [
                'title' => $title,
            ];
            $db->table_name = $db->db_tablepre . 'course';
            $db->update($data, $where);
            $num += $db->affected_rows();

            $r = $db->get_one(['title' => $title]);
            if ($r) {
                $data = [
                    'score' => $score,
                    'class_hour' => $lessonCount,
                    'brief_introduction' => $description,
                ];
                $where = [
                    'id' => $r['id'],
                ];
                $db->table_name = $db->db_tablepre . 'course_data';
                $num1 += $db->update($data, $where);
            }
        }
    }
    $s = rand(500, 1000);
    usleep($s);
    $pageIndex++;
}

echo "成功修改数据:{$num}条主表,{$num1}条附表<br>";

function getCourseList($url, $query, $pageIndex = 1, $pageSize = 10)
{
    $query['pageIndex'] = $pageIndex;
    $query['pageSize'] = $pageSize;
    $addUrl = http_build_query($query);
    $url .= $addUrl;
    return file_get_contents($url);

    /*
    $http = pc_base::load_sys_class('http');
    $http->get($url);
    if ($http->is_ok()) {
        if (CHARSET != 'utf-8') {
            return $http->get_data();
        } else {
            return iconv('gbk', 'utf-8', $http->get_data());
        }
    }
    return 'errno:'.$http->errno.' errmsg:'.$http->errmsg;
    */
}


?>
