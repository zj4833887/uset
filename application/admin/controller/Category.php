<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Loader;
use think\Request;

class Category extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        return view();
        //
    }
    public function insert(){
        return view();
    }
    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        $requst=\request();
        $data=$requst->post();
        unset($data['file']);
        $name=Db::table('category')->where('name',$data['name'])->find();
        if ($name){
            return json([
                'code'=>404,
                'msg'=>'分类名称不可以重复'
            ]);
        }
        $res=Db::table('category')->insert($data);
        if ($res){
            $data=[
                'code'=>200,
                'msg'=>"插入成功"
            ];
        }else{
            $data=[
                'code'=>404,
                'msg'=>"插入失敗"
            ];
        }
        return $data;
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function query()
    {
        $res=Db::table('category')->select();
        if ($res){
            $data=[
                'code'=>0,
                'msg'=>"查看成功",
                'count'=>1000,
                'data'=>$res
            ];
        }else{
            $data=[
                'code'=>404,
                'msg'=>"查看失败"
            ];
        }
        return $data;
        //
    }




    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete()
    {
        $requst=\request()->post();
        $thumb=$requst['thumb'];
        $thumb=substr("$thumb",6);
        $thumb="../$thumb";
        unlink("$thumb");
        var_dump($thumb);
        $res=Db::table('category')->where('cid',$requst['cid'])->delete();

        if ($res){
            $data=[
                'code'=>200,
                'msg'=>"删除成功",
            ];
        }else{
            $data=[
                'code'=>404,
                'msg'=>"删除失败",
            ];
        }
        return $data;
        //
    }
}
