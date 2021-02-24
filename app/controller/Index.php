<?php

namespace app\controller;

use app\BaseController;
use app\model\Brand;
use app\model\User;
use think\facade\View;


class Index extends BaseController
{

    /**
     * 控制器中间件
     * @var array
     */
    protected $middleware = ['app\middleware\UserCheck'];

    public function index()
    {
        $uid = $this->request->uid;
        $usr = (new User())::field("username,phone,userimg,userrole")->find($uid);
        $usr->role = $usr->userrole === 1 ? "超级管理员" : "普通用户";
        return
            View::fetch('index', [
                'admin' => $usr,
                'img' => $usr->userimg,
            ]);
    }

    public function home()
    {
        $brandList = (new Brand())->field('id,name,remark,order,uname,createtime')->select();
        return View::fetch('home', [
            'brandList' => $brandList,
        ]);
    }

    public function user()
    {
        $userList = (new User())->select();
        return View::fetch('user', [
            'userList' => $userList,
        ]);
    }

    public function addBrand()
    {
        $bId = (int)trim(input('post.bId'));
        $bName = (string)trim(input('post.bName'));
        $bOrder = (int)trim(input('post.bOrder'));
        $bRemark = (string)trim(input('post.bRemark'));
        $uid = $this->request->uid;
        $uname = $this->request->uname;
        if ($bId === -1) {
            $save = (new Brand())->save([
                'name' => $bName,
                'order' => $bOrder,
                'remark' => $bRemark,
                'uid' => $uid,
                'uname' => $uname,
                'createtime' => time(),
            ]);
            if ($save) {
                $data['code'] = 200;
                $data['message'] = '添加成功！';
            } else {
                $data['code'] = -1;
                $data['message'] = '添加失败！';
            }
        } else {
            $save = (new Brand())->update([
                'id' => $bId,
                'name' => $bName,
                'order' => $bOrder,
                'remark' => $bRemark,
            ]);
            if ($save) {
                $data['code'] = 200;
                $data['message'] = '修改成功！';
            } else {
                $data['code'] = -1;
                $data['message'] = '修改失败！';
            }
        }
        return $data;
    }
}
