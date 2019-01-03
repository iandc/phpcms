<?php
return [
    /*'attachments' => [
        'attachment' => [
            'aid' => 'aid',
            'catid' => 'catid',
            'filename' => 'filename',
            'filepath' => 'filepath',
            'size' => 'filesize',
            'attachtype' => 'fileext',
            'isimage' => 'isimage',
            'downloads' => 'downloads',
            'uid' => 'userid',
            'dateline' => 'uploadtime',
        ],
        'create' => [
            'module' => 'content',
            'isthumb' => 0,
            'uploadip' => '',
            'status' => 0,
            'authcode' => '',
            'siteid' => 1,
        ],
    ],

    'tags' => [
        'keyword' => [
            'tagid' => 'id',
            'tagname' => 'keyword',
            'spacevideonum' => 'videonum',
        ],
        'create' => [
            'siteid' => 1,
            'pinyin' => '',
            'searchnums' => 0,
        ],
    ],

    'spacetags' => [
        'keyword_data' => [
            'tagid' => 'tagid',
        ],
        'create' => [
            'siteid' => 1,
            'contentid' => '', //contentid-modelid
        ],
    ],

    /*'categories' => [ //转换到子栏目
        'category' => [
            'catid' => 'catid',
            'name' => 'catname',
        ],
        'create' => [
            'siteid' => 1,
            'module' => 'content',
            'type' => 0,
            'modelid' => 1,
            'parentid' => 0,
            'catdir' => '',
            'child' => 0,
            'setting' => '{"workflowid":"","ishtml":"0","content_ishtml":"0","create_to_html_root":"1","template_list":"default","category_template":"category","list_template":"list","show_template":"show","meta_title":"","meta_keywords":"","meta_description":"","presentpoint":"1","defaultchargepoint":"0","paytype":"0","repeatchargedays":"1","category_ruleid":"6","show_ruleid":"16"}'
        ],
    ],*/

    'spaceitems' => [
        'news' => [
            'itemid' => 'id',
            'catid' => 'catid',
            'subject' => 'title',
            'username' => 'username',
            'dateline' => 'inputtime',
        ],
        'create' => [
            'typeid' => rand(54, 55),
            'sysadd' => 1, //1 后台管理员添加
            'status' => 99, // 0退稿，1~4审核状态 99通过
            'description' => '',
            'updatetime' => 0,
        ],
    ],

    'spacenews' => [
        'news_data' => [
            'itemid' => 'id',
            'newsfrom' => 'copyfrom',
            'message' => 'content',
        ],
        'create' => [
            'allow_comment' => 1,
        ],
    ],

    /*'spacefiles' => [
        'download' => [
            'itemid' => 'id',
            'catid' => 'catid',
            'filesize' => 'filesize',
            'version' =>  'version',
            'producer' => 'classtype',
            'language' => 'language',
            'permission' => 'copytype',
            'system' => 'systems',
            'dateline' => 'inputtime',
        ],
        'create' => [
            'status' => 99,
            'sysadd' => 1,
            'updatetime' => 0,
        ],
    ],*/

];
