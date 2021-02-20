<?php

namespace app\controller;

use app\BaseController;
use app\model\Brand;
use app\model\User;
use think\facade\View;

class Index extends BaseController
{
    public function index()
    {
        $uid = $this->request->uid;
        $usr = (new User())::field("username,phone,userimg,userrole")->find($uid);
        $usr->role=$usr->userrole===1?"超级管理员":"普通用户";
        return
            View::fetch('index', [
                'admin' => $usr,
                'img' => $usr->userimg,
            ]);
    }

    public function home()
    {
        $brandList = (new Brand())->select();
        return View::fetch('home',[
            'brandList'=>$brandList,
        ]);
    }
    public function user()
    {
        $userList = (new User())->select();
        return View::fetch('user',[
            'userList'=>$userList,
        ]);
    }
    public function test()
    {
        return View::fetch();
    }
}
