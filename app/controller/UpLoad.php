<?php


namespace app\controller;


use think\facade\Filesystem;
use think\facade\Request;
use think\facade\Validate;
use think\facade\View;

class UpLoad
{
    public function index(){
        return View::fetch('upload');
    }

    public function upload(){
        $uploadedFile = Request::file('image');

        //编写规则
        $validate = Validate::rule([
            'image' => 'file|fileExt:jpg,png,gif',
        ]);
        //验证规则
        $result = $validate->check([
            'image' => $uploadedFile
        ]);

        if ($result){
            $putfile = Filesystem::putfile('headImg', $uploadedFile);
            dump($putfile);
        }else{
            dump($validate->getError());
        }


    }
    public function upLoadList(){
        $uploadedFiles = Request::file('image');
        $putfiles=[];
        foreach ($uploadedFiles as $file){
            $putfiles[] = Filesystem::putfile('headImg', $file);
        }
        dump($putfiles);
    }
}