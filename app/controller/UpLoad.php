<?php


namespace app\controller;


use app\BaseController;
use app\model\Brand;
use app\model\User;
use think\facade\Filesystem;
use think\facade\Request;
use think\facade\Validate;
use think\facade\View;

class UpLoad extends BaseController
{
    public function index()
    {
        return View::fetch('upload');
    }

    public function upload()
    {
        $uploadedFile = Request::file('image');
        //编写规则
        $validate = Validate::rule([
            'image' => 'file|fileExt:jpg,png,gif',
        ]);
        //验证规则
        $result = $validate->check([
            'image' => $uploadedFile
        ]);
        $uid = $this->request->uid;
        if ($result && $uid !== -1) {
            $putfile = '/uploadFile/' . Filesystem::putfile('headImg', $uploadedFile);
            $str_replace = str_replace("\\", '//', $putfile);
            (new User())::update([
                'id' => $uid,
                "userimg" => $str_replace,
            ]);
            echo "<script> headImg = top.document.getElementById('head_img');
                            headImg.src='{$str_replace}';
                    </script>";
        } else {
            echo "<script> parent.layer.msg('{$validate->getError()}');</script>";
        }

    }

    public function uploadXlsx()
    {
        $uploadedFile = Request::file('xlsx');
        //编写规则
        $validate = Validate::rule([
            'xlsx' => 'file|fileExt:xlsx,xls,excel',
        ]);
        //验证规则
        $result = $validate->check([
            'xlsx' => $uploadedFile
        ]);

        $uname = $this->request->uname;
        if ($result) {
            $identify = \PHPExcel_IOFactory::identify($uploadedFile);
            $reader = \PHPExcel_IOFactory::createReader($identify);
            $PHPExcel = $reader->load($uploadedFile);
            $sheet = $PHPExcel->getSheet(0);//第一个工作表
            $sheetContent = $sheet->toArray();
            unset($sheetContent[0]);
            foreach ($sheetContent as $k => $value) {
                $arr['name'] = $value[0];
                $arr['uname']=$uname;
                $arr['createtime'] =time();
                $res[] = $arr;
            }
            $insert = (new Brand())->insertAll($res);
            echo "<script> parent.layer.msg('上传成功');</script>";
        } else {
            echo "<script> parent.layer.msg('{$validate->getError()}');</script>";
        }

    }

    public function upLoadList()
    {
        $uploadedFiles = Request::file('image');
        $putfiles = [];
        foreach ($uploadedFiles as $file) {
            $putfiles[] = Filesystem::putfile('headImg', $file);
        }
        dump($putfiles);
    }
}