<?php


namespace app\admin\validate;
use think\Validate;

class Login extends Validate
{
    protected $rule = [
        'username'  => 'require',
        'password' =>  'require',
        'code'     =>   'require'
    ];

    protected $message = [
        'username'  =>  '用户名必填',
       'password' =>  '密码必填',
        'code'    =>   '验证码必填'
    ];


}