<?php


namespace app\controller;

use think\facade\Cache;
use think\facade\Cookie;
use think\facade\Request;
use think\facade\Session;

class Store
{
    public function session()
    {
        Session::set('12345', 'Mr.Lee');
//        return Session::get('user');
        return Session::get("12345");
    }

    public function cookie()
    {
//        Cookie::set
    }

    public function redis()
    {
        Cache::set("user", "Mr.Less");
        dump(Cache::get('user', ""));
        dump(Cache::has('user'));
        Cache::set("arr", [1, 2, 3, 4, 5]);
        Cache::push('arr', 6);
        dump(Cache::get("arr"));
//        Cache::delete('user');
        Cache::pull('user');
        dump(Cache::remember("start_time", time()));
//        Cache::clear();

        Cache::tag('tag')->set("age",100);
//        Cache::tag("tag")->clear();
    }

}