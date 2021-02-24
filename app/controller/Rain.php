<?php


namespace app\controller;


use think\facade\View;

class Rain
{
    public function index()
    {
        return View::fetch('rain');
    }
}