<?php


namespace app\controller;

//验证码验证类
use think\facade\Validate;
use think\facade\View;

class Code
{
    public function form(){
        return View::fetch('form');
    }

    public function check(){
//        $validate = Validate::rule([
//            'captcha'  => 'require|captcha'
//        ]);
//        $result = $validate->check([
//            'captcha' => input('post.code')
//        ]);
//        dump($result);
        $input = input('post.code');
        echo $input;
        if (captcha_check($input)){
            echo '验证成功';
        }else {
            echo '验证失败';
        }
    }
}