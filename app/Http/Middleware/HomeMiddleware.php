<?php

namespace App\Http\Middleware;

use Closure;

class HomeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    protected $home;

    public function __construct()
    {
        $this->homeService = app()->make('HomeService');
    }

    public function handle($request, Closure $next)
    {
        $msg = [
            '-1' => '后台未添加域名！',
            '0' => '站点已经禁用！',
        ];
        $httpHost = $request->getHost();
        //$httpHost = 'www.huihuang200.com';
        $res = $this->homeService->getHostStatus($httpHost);
        if ($res != '1') {
            $data  = ['res' => 'Site Info error', 'msg' => $msg[$res]];
            return response()->json($data, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
            exit;
        }
        return $next($request);
    }
}
