<?php


namespace app\admin\validate;


use think\Validate;

class Nav extends Validate
{
    protected $rule = [
        'name' =>  'require',
        'ename'     =>   'require',
        'template'     =>   'require',
        'sort'     =>   'require',
        'thumb'     =>   'require'
    ];

    protected $message = [
        'name'  =>  '导航名称必填',
        'ename' =>  '导航英文名称必填',
        'template'    =>   '模板地址必填',
        'sort'    =>   '排序必填',
        'thumb'    =>   '图片必填'
    ];

}