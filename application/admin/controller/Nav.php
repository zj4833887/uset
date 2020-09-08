<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Loader;
use think\Request;
use think\View;

class Nav extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {

        return \view();
        //
    }
    public function query(){
        $data=Db::table('nav')->select();
        $res=[
            'code'=>0,
            'msg'=>"查询成功",
            'count'=>100,
            'data'=>$data
        ];
        return $res;
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
        $validate = Loader::validate('Nav');
        if(!$validate->check($data)){
            return  json([
                'code'=>404,
                'msg'=>$validate->getError()
            ]);
        }
        $name=Db::table('nav')->where('name',$data['name'])->find();
        if ($name){
            return json([
                'code'=>404,
                'msg'=>'导航名称不可以重复'
            ]);
        }
        $res=Db::table('nav')->insert($data);
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
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function select()
    {

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
        $res=Db::table('nav')->where('nid',$data['id'])->find();
        $this->assign("data",$res);
        return view("edit");
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
//        var_dump($data);
        if (!empty($data['ordimg'])){
            $src='../'.substr($data['ordimg'],6);
            unlink($src);
        }
        unset($data['file']);
        unset($data['ordimg']);
        $res=Db::table('nav')->where('nid',$data['nid'])
            ->update(['name'=>$data['name'],'ename'=>$data['ename'],'template'=>$data['template'],'sort'=>$data['sort'],'thumb'=>$data['thumb']]);
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
        $request=\request();
        $num=$request->post();
        $thumb=$num['thumb'];
        $thumb=substr("$thumb",6);
        $thumb="../$thumb";
        unlink("$thumb");
        $res=Db::table('nav')->where('nid',$num['nid'])->delete();
        if ($res){
            $data=[
                'code'=>200,
                'msg'=>"删除成功"
            ];
        }else{
            $data=[
                'code'=>404,
                'msg'=>"删除失败"
            ];
        }
        return $data;
    }
}
//删除图片
//1.接受数据
//2.图片是否上传。thumb有值
//3.上传，修改数据，删除图片
//没有 修改数据 unset（） 删除多余数据