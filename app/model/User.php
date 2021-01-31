<?php


namespace app\model;

use think\Collection;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;
use think\Model;

class User extends Model
{
    /**
     * @param String $username 手机号  或  用户名
     * @param String $userpawd 密码
     * @return array|string
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function Login(String $username,String $userpawd)
    {
        $model = $this->where([
            'userpawd' => $userpawd,
        ])->where(
            function ($query) use ($username) {
                $query->whereOr([
                    'username' => $username,
                ])->whereOr([
                    'phone' => $username,
                ]);
            })->limit(1)->find();
        return $model===null?'':$model->toArray();
    }
}