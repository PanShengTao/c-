<?php


namespace app\controller;

use app\model\User;
use think\facade\Cookie;
use think\facade\View;

class Account
{

    public function login()
    {
        return View::fetch();
    }

    public function doLogin()
    {
        $username = (string)trim(input('post.username'));
        $userpawd = (string)trim(input('post.pwd'));
        $data['code'] = -1;
        $token = (new User())->Login($username, $userpawd);
        if (empty($token)) {
            $data['message'] = "用户名或密码不正确";
            $data['code'] = -1;
            return $data;
        }
        Cookie::set('token', $token, 3600 * 24 * 30);
        $data['code'] = 200;
        $data['message'] = '登录成功';
        return $data;;
    }
    public function doExit()
    {
        Cookie::set('token', "", 3600 * 24 * 30);
        $data['code'] = 200;
        $data['message'] = '退出成功';
        return $data;;
    }
//    private function makeToken()
//    {
//        $str = md5(uniqid(md5(microtime(true)), true)); //生成一个不会重复的字符串
//        $str = sha1($str); //加密
//        return $str;
//    }
}