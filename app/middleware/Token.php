<?php

namespace app\middleware;

use app\model\User;

class Token
{
    public function handle($request, \Closure $next)
    {
		$token = $request->header('token');
		$data = explode('.', $token);
		if (count($data) == 3) {
			$request->user_id = (new User())->token_check($token);
		}else{
			$request->user_id = 0;
		}

		return $next($request);
    }

}
