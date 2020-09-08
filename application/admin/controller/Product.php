<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\View;

class Product extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
        return view();
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
        $requst=\request()->post();
        $data=Db::table('product')->insert($requst);
        if ($data){
            $data=[
                'code'=>200,
                'msg'=>"插入成功"
            ];
        }else{
            $data=[
                'code'=>200,
                'msg'=>"插入成功"
            ];
        }
        return $data;
    }

    public function query()
    {
        $res=Db::table('product')->select();
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
    public function edit()
    {
        $request=\request();
        $data=$request->get();
        $data=Db::table('product')->where('pid',$data['id'])->find();
        $this->assign("data",$data);
        return view();
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update()
    {
        $request=\request();
        $data=$request->post();
        if (!empty($data['ordimg'])){
            $src='../'.substr($data['ordimg'],6);
            unlink($src);
        }
        unset($data['file']);
        unset($data['ordimg']);
        $res=Db::table('product')->where('pid',$data['id'])
            ->update(['name'=>$data['name'],'ename'=>$data['ename'],'info'=>$data['info'],'thumb'=>$data['thumb'],'type'=>$data['type']]);
        if ($res){
            $data1=[
                'code'=>200,
                'msg'=>"修改成功"
            ];
        }else{
            $data1=[
                'code'=>200,
                'msg'=>"修改成功"
            ];
        }
        return $data1;
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
        $res=Db::table('product')->where('pid',$requst['pid'])->delete();
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
    }
}
