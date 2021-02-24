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
        return $data;
    }

    public function doExit()
    {
        Cookie::set('token', "", 3600 * 24 * 30);
        $data['code'] = 200;
        $data['message'] = '退出成功';
        return $data;;
    }


    public function doDelete()
    {

        $uid = (string)trim(input('post.id'));
        $destroy = (new User())->destroy($uid);
        if ($destroy) {
            $data['code'] = 200;
            $data['message'] = '删除成功！';
        } else {
            $data['code'] = -1;
            $data['message'] = '删除失败！';
        }
        return $data;
    }

    public function doEdit()
    {
        $uid = (int)trim(input('post.uid'));
        $uname = (string)trim(input('post.uname'));
        $uphone = (string)trim(input('post.uphone'));
        $upasswd = (string)trim(input('post.upasswd'));
        $urole = (int)trim(input('post.urole'));


        if ($uid !== -1) {
            $model = (new User())->where("username", $uname)->whereRaw('id!='.$uid)->find();
            if ($model){
                $data['code'] = -1;
                $data['message'] = '用户名已存在！';
                return $data;
            }
            $model = (new User())->where("phone", $uphone)->whereRaw('id!='.$uid)->find();
            if ($model){
                $data['code'] = -1;
                $data['message'] = '手机号码已存在！';
                return $data;
            }
            $user = (new User())->update(['id' => $uid, 'username' => $uname, 'phone' => $uphone, 'userpawd' => $upasswd,'userrole'=>$urole]);

            if ($user) {
                $data['code'] = 200;
                $data['message'] = '修改成功！';
            } else {
                $data['code'] = -1;
                $data['message'] = '修改失败！';
            }
        } else {
            $model = (new User())->where("username", $uname)->find();
            if ($model){
                $data['code'] = -1;
                $data['message'] = '用户名已存在！';
                return $data;
            }
            $model = (new User())->where("phone", $uphone)->find();
            if ($model){
                $data['code'] = -1;
                $data['message'] = '手机号码已存在！';
                return $data;
            }
            $save = (new User())->save(['username' => $uname, 'phone' => $uphone, 'userpawd' => $upasswd,'userrole'=>$urole]);
            if ($save) {
                $data['code'] = 200;
                $data['message'] = '添加成功！';
            } else {
                $data['code'] = -1;
                $data['message'] = '添加失败！';
            }
        }

        return $data;
    }
}