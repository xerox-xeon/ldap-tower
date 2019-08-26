<?php

namespace App\Http\Controllers;

//use Laravel\Lumen\Routing\UrlGenerator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $homeService;

    public function __construct()
    {
        $this->homeService = app('HomeService');
    }

    public function clientIp(Request $request)
    {
        $timestamp = Carbon::now()->timestamp;
        $ip        = $request->getClientIp();
        $data      = [
            'timestamp' => $timestamp,
            'client'    => $ip
        ];
        return response()->json($data);
    }

    public function showHomePage(Request $request)
    {
        $siteBasePath = 'website';
        $httpHost     = $request->getHost();
        $siteId       = $this->homeService->getHostSiteId($httpHost);
        $siteName     = $this->homeService->getHostSiteName($siteId);
        $siteFolder   = $this->homeService->getHostSiteFolder($siteId);

        $sitePath     = $siteBasePath . '/' . $siteFolder . '/pc/dist';
        $siteViewPath = Str::replaceArray('/', ['.'], $sitePath);
        $data         = [
            'site_id'   => $siteId,
            'site_name' => $siteName,
            'site_path' => $siteFolder . '/pc/dist'
        ];

        if (!File::exists(resource_path('views/' . $sitePath))) {
            Log::error('path directory:', ['domain' => $httpHost, 'path' => $sitePath]);
            return view( 'default.index', $data);
        }

        return view($siteViewPath . '.index');
    }
    //
}

