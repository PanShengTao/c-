<?php


namespace app\controller;

use app\model\User;
use think\facade\Cache;
use think\facade\Cookie;
use think\facade\Session;
use think\facade\View;

class Account
{

    public function login()
    {
        return View::fetch();
    }

    public function dologin()
    {

        $username = (string)trim(input('post.username'));
        $userpawd = (string)trim(input('post.pwd'));
        $data['code'] = -1;
        $user = (new User())->Login($username, $userpawd);
        if (empty($user)) {
            $data['message'] = "用户名或密码不正确";
            $data['code'] = -1;
            return $data;
        }
        Cache::set($user['username'], Session::getId());
        $serialize = serialize($user);
        Cookie::set('user', $serialize, 3600 * 24 * 30);
        $data['code'] = 200;
        $data['message'] = '登录成功';
        return $data;;
    }

    private function makeToken()
    {
        $str = md5(uniqid(md5(microtime(true)), true)); //生成一个不会重复的字符串
        $str = sha1($str); //加密
        return $str;
    }
}