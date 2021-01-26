<?php


namespace app\controller;

use think\facade\View;
use think\facade\Cookie;
class Account
{
    public function login()
    {
        return View::fetch();
    }
    public function TestJson(){

        $data['code']=1;
        $data['message']='asdfasdf';

        return json($data);
    }
    public function dologin()
    {

        $user['username'] = (string)trim(input('post.username'));
        $user['userpawd'] = (string)trim(input('post.pwd'));
        $data['code'] = 0;
        if ($user['username'] === '') {
            $data['code'] = -1;
            $data['message'] = "用户名不存在";
            return $data;;
        }
        if ($user['userpawd'] === '123456') {
            $data['message'] = "密码不可以为连续数字";
            $data['code'] = -1;
            return $data;;
        }
//        $obj_user=serialize($user);
        Cookie::set('user',$user['username'],3600*24*30);
        $data['message'] = "登陆成功";
        return $data;;
    }
}