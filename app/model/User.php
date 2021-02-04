<?php


namespace app\model;

use Exception;
use Firebase\JWT\JWT;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;
use think\facade\Cache;
use think\Model;

class User extends Model
{
    /**
     * @param String $username 手机号  或  用户名
     * @param String $userpawd 密码
     * @return string
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function Login(String $username, String $userpawd)
    {
        $user = $this->where([
            'userpawd' => $userpawd,
        ])->where(
            function ($query) use ($username) {
                $query->whereOr([
                    'username' => $username,
                ])->whereOr([
                    'phone' => $username,
                ]);
            })->limit(1)->find();
        if (empty($user)) {
            return '';
        }
        return $this->signToken($user["id"], $user["username"], $user["userimg"], $user["userrole"] === 1 ? "超级管理员" : "普通用户");
    }


    //生成验签
    function signToken($uid, $name, $img, $role)
    {
        $time = time();
        Cache::set((string)$uid, $time);
        $key = '!@#$%*&';         //这里是自定义的一个随机字串，应该写在config文件中的，解密时也会用，相当    于加密中常用的 盐  salt
        $token = array(
            "iss" => $key,        //签发者 可以为空
            "aud" => '',          //面象的用户，可以为空
            "iat" => $time,      //签发时间
            "nbf" => time() + 3,    //在什么时候jwt开始生效  （这里表示生成100秒后才生效）
            "exp" => time() + 3600 * 750, //token 过期时间
            "data" => [           //记录的userid的信息，这里是自已添加上去的，如果有其它信息，可以再添加数组的键值对
                'uid' => $uid,
                'name' => $name,
                'img' => $img,
                'role' => $role,
            ]
        );
        //  print_r($token);
        $jwt = JWT::encode($token, $key, "HS256");  //根据参数生成了 token
        return $jwt;
    }


//验证token
    function checkToken($token)
    {
        $key = '!@#$%*&';
        $status = array("code" => 2);
        try {
            JWT::$leeway = 60;//当前时间减去60，把时间留点余地
            $decoded = JWT::decode($token, $key, array('HS256')); //HS256方式，这里要和签发的时候对应
            $arr = (array)$decoded;
            $res['code'] = 1;
            $res['data'] = $arr['data'];
            $res['time'] = $arr['iat'];
            return $res;

        } catch (\Firebase\JWT\SignatureInvalidException $e) { //签名不正确
            $status['msg'] = "签名不正确";
            return $status;
        } catch (\Firebase\JWT\BeforeValidException $e) { // 签名在某个时间点之后才能用
            $status['msg'] = "token失效";
            return $status;
        } catch (\Firebase\JWT\ExpiredException $e) { // token过期
            $status['msg'] = "token失效";
            return $status;
        } catch (Exception $e) { //其他错误
            $status['msg'] = "未知错误";
            return $status;
        }
    }
}