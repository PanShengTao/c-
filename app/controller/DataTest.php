<?php


namespace app\controller;


use app\model\User;
use think\facade\Cache;
use think\facade\Db;

class DataTest
{
    public function index()
    {
//        $users = Db::table("sys_config")->select();
        $users = Db::table("sys_config")->select()->toArray();

//        $users = Db::table("sys_config")->where('value',100)->find();

        dump($users);
//        return json($users);
    }

    public function getConfig()
    {
        $token = (new User())->Login('18385642411', '123456');
        $checkToken = (new User())->checkToken($token, 'asd');
        $var = Cache::get("" . $checkToken["data"]->uid, 1);
        dump($checkToken['time']===intval($var));
        return 1;
    }

    public function time()
    {
        $users = Db::name('config')->where("set_time", "between", "[2018-1-1,2020-1-1]")->select();
        return json($users);
    }
}