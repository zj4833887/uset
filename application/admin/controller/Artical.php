<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\View;

class Artical extends Controller
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
    public function add(){
        $requst=\request()->post();
        $data=Db::table('article')->insert($requst);
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
        $data=Db::table('nav')->select();
        $this->assign('data',$data);
        return view("insert");
     }
     public function query(){
        $requst=\request();
        $page=$requst->get('page');
        $limit=$requst->get('limit');
        if (isset($page)&&!empty($page)){
            $page=$page;
        }else{
            $page=1;
        }
         if (isset($limit)&&!empty($limit)){
             $limit=$limit;
         }else{
             $limit=10;
         }
        $res=Db::table('article')
            ->alias('a')
            ->join('nav','nav.nid=a.cid')
            ->field('id,anames,nename,content,name')
            ->page($page,$limit)
            ->select();
        $tot=\db('article')->count();
        if ($res){
            $data=[
                'code'=>0,
                'msg'=>'查询成功',
                'count'=>$tot,
                'data'=>$res
            ];
        }else{
            $data=[
                'code'=>0,
                'msg'=>'查询失败',
            ];
        }
        return $data;
     }
    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
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
        $res=Db::table('article')
            ->alias('a')
            ->join('nav','nav.nid=a.cid')
            ->field('id,anames,nename,content,cid,name')
            ->where('id',$data['id'])
            ->find();
        $this->assign("data",$res);
        $nav=Db::table('nav')->select();
        $this->assign("nav",$nav);
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
//        if (!empty($data['content'])){
//            $thumb=explode('"',$data['content']);
//            $thumb=substr("$thumb[1]",6);
//            $thumb="../$thumb";
//            unlink("$thumb");
//        }
        $res=Db::table('article')->where('id',$data['id'])
            ->update(['anames'=>$data['anames'],'nename'=>$data['nename'],'content'=>$data['content'],
                'cid'=>$data['cid']]);
        if ($res){
            $data=[
                'code'=>200,
                'msg'=>"修改成功"
            ];
        }else{
            $data=[
                'code'=>200,
                'msg'=>"修改成功"
            ];
        }
        return $data;
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
        $thumb=$requst['content'];
        $thumb=explode('"',$thumb);
        $thumb=substr("$thumb[1]",6);
        $thumb="../$thumb";
        unlink("$thumb");
        $res=Db::table('article')->where('id',$requst['id'])->delete();
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
