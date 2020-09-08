<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Loader;
use think\Request;

class  Login extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
        return view("login");
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //1.验证
        $request=\request();
        if (!Request::instance()->isPost()){
             return json([
                 "code"=>"404",
                 "msg"=>"请求方式错误"
             ]);
        }else{
            $data=$request->post();
            $validate = Loader::validate('Login');
            if(!$validate->check($data)){
                return json([
                    "code"=>"404",
                    "msg"=>$validate->getError()
                ]);
            }
        }
        if(captcha_check($data['code'])){
            return json([
                "code"=>"404",
                "msg"=>"验证码错误"
            ]);
        }else{
            $res=Db::table('manager')->where('username',$data['username'])->find();
            if (empty($res)){
                return json([
                    "code"=>"404",
                    "msg"=>"用户名不存在"
                ]);
            }else{
                if ($res['password']==$data['password']){
                    session('username',$res['username']);
                    return json([
                        "code"=>"200",
                        "msg"=>"登录成功"
                    ]);
                }else{
                    return json([
                        "code"=>"404",
                        "msg"=>"密码错误"
                    ]);
                }
            }
        }
    }
    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function loginout()
    {
        session(null);
        $this->redirect('/uset/public/admin/login/index');
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
