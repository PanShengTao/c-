<?php


namespace app\controller;


use app\BaseController;
use think\facade\View;

class Visit extends BaseController
{
    public function index()
    {
        return View::fetch('visit');
    }

    public function VisitCount()
    {
        $visitCount = (new \app\model\Visit())->VisitCount();
        $data["code"] = 200;
        $data["visitCount"] = $visitCount;
        if (empty($visitCount)) {
            $data["code"] = -1;
        }
        return $data;
    }


    public function searchVisit()
    {
        $sTime = (string)trim(input('post.sTime'));
        $eTime = (string)trim(input('post.eTime'));
        $visitList = (new \app\model\Visit())->field('id,uname,sname,vsuccess,vtime')->
        whereBetweenTime('vtime', $sTime, $eTime)->select()->order("id",'asc');
        if ($visitList) {
            $data['code']=200;
            $data["visitList"]=$visitList;
        } else {
            $data['code']=-1;
            $data['message']='';
        }
        return $data;
    }
}