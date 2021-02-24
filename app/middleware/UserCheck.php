<?php

namespace app\middleware;

use app\model\User;
use think\facade\Cache;

class UserCheck
{
    public function handle($request, \Closure $next)
    {
        $token = $request->cookie("token");
        $checkToken = (new User())->checkToken((string)$token);
        if ($checkToken['code'] === 1) {
            $request->uid = $checkToken['data']->uid;
            $request->uname = $checkToken['data']->name;
            $var = Cache::get("" . $checkToken["data"]->uid, 1);
            if ($checkToken["time"] !== intval($var)) {
                return redirect('/index.php/account/login');
            }
            if ($checkToken['data']->role==='普通用户'){
                return redirect('/index.php/search/index');
            }
        } else {
            return redirect('/index.php/account/login');
        }
        return $next($request);
    }

}
