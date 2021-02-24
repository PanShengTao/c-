<?php

namespace app\controller;

use app\BaseController;
use app\model\Brand;
use app\model\User;
use app\model\Visit;
use think\facade\View;

class Search extends BaseController
{
    public function index()
    {
        $uid = $this->request->uid;
        return View::fetch('search');
    }

    public function brand()
    {

        $searchName = (string)trim(input('post.searchName'));
        $uid = $this->request->uid;
        $uname = $this->request->uname;
        $model = (new Brand())->where('name', $searchName)->limit(1)->find();
        if (!empty($model)) {
            (new Visit())->save([
                'uid'=>$uid,
                'uname'=>$uname,
                'sname'=>$searchName,
                'vsuccess'=>1,
                'vtime'=>time(),
                ]);
            $data['code'] = 200;
            $data['message'] = '品牌名字:' . $model['name'];
        } else {
            (new Visit())->save([
                'uid'=>$uid,
                'uname'=>$uname,
                'sname'=>$searchName,
                'vsuccess'=>1,
                'vtime'=>time(),
            ]);
            $data['code'] = 1;
            $data['message'] = '搜索品牌' . $searchName . '不存在！';
        }
        return $data;
    }
    public function searchVisit(){
        $searchName = (string)trim(input('post.searchName'));
    }
}
