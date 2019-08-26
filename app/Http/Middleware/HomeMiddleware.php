<?php

namespace App\Http\Middleware;

use Closure;

class HomeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    protected $home;

    public function __construct()
    {
        $this->homeService = app()->make('HomeService');
    }

    /**
     * @param $request
     * @param Closure $next
     * @return \Illuminate\Http\Response|\Illuminate\View\View|\Laravel\Lumen\Http\ResponseFactory|mixed
     */
    public function handle($request, Closure $next)
    {
        $siteBasePath = 'website';
        $httpHost = $request->getHost();
        $hostUrl  = $this->homeService->getHostUrl($httpHost);
        $hostStatus  = $this->homeService->getHostStatus($httpHost);
        //跳转(external_domain)域名过滤处理
        $external = $this->homeService->getExternalUrl($httpHost);
        if ($external != 'none') {
            if ($hostUrl != 'none') {
                return response('非法跳转域名，请处理！', 401);
            } elseif (trim($external->external_url) == trim($external->domain_url))
                return response('跳转域名重复，请处理！', 401);
            else
                return view($siteBasePath . '.middle.index');
        }

        //主域名/推广域名是否存在过滤处理
        if ($hostUrl == 'none') {
            return response('后台未添加此域名!', 401);
        }
        //主域名是否禁用处理
        if ($hostStatus == '0') {
            return response('此站点域名已被禁止访问!', 401);
        }
        return $next($request);
    }
}
