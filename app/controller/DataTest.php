<?php


namespace app\controller;


use app\model\Config;
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
        $users = Config::select();
        return json($users);
    }
    public function time(){
        $users = Db::name('config')->where("set_time","between","[2018-1-1,2020-1-1]")->select();
        return json($users);
    }
}