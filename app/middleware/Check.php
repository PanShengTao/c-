<?php
declare (strict_types = 1);

namespace app\middleware;

class Check
{
    /**
     * 处理请求
     *
     * @param \think\Request $request
     * @param \Closure       $next
     * @return \think\response\Redirect
     */
    public function handle($request, \Closure $next)
    {
        // 获取请求中的token，
        $accessToken = $request->header('access-token');
        // 没有token信息，则跳转到登录界面
        if(!$accessToken) {
            return redirect('/index.php/account/login');
        }
        // 根据token信息去缓存当中查找结果，假设我们缓存的是用户信息
        $res = cache('123'.$accessToken);
        // 如果没有查找到用户信息，则跳转到登录界面
        // 可以进一步验证用户信息的完整性和合法性，此处略
        if (!$res) {
            return redirect('/index.php/account/login');
        }
        return $next($request);
    }
}
