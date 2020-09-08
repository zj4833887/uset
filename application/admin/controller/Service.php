<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Request;

class Service extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        return view();

//        return view();
    }
    public function add(){
        $requst=\request()->post();
        $data=Db::table('service')->insert($requst);
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
    public function insert(){
        $data=Db::table('category')->select();
        $this->assign('data',$data);
        return view();
    }

    public function edit()
    {
        $request=\request();
        $data=$request->get();
        $res=Db::table('category')->select();
        $this->assign('res',$res);
        $data=Db::table('service')->where('sid',$data['id'])->find();
        $this->assign("data",$data);
        return view("edit");
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function query()
    {
        $res=Db::table('service')->alias('a')
            ->join('category b','b.cid= a.cid')
            ->select();
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
        $res=Db::table('service')->where('sid',$data['id'])
            ->update(['sname'=>$data['name'],'thumb'=>$data['thumb'],'cid'=>$data['cid']]);
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
//        var_dump($thumb);
        $res=Db::table('service')->where('sid',$requst['sid'])->delete();

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
