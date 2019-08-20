<?php

namespace App\Http\Controllers;

//use Laravel\Lumen\Routing\UrlGenerator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

    public function clientIp(Request $request) {
        $timestamp = Carbon::now()->timestamp;
        $ip = $request->getClientIp();
        $data = [
            'timestamp' => $timestamp,
            'client' => $ip
        ];
        return response()->json($data);
    }

    public function showHomePage(Request $request) {
        $siteBasePath = 'website';

        $httpHost = $request->getHost();
        //$httpHost = 'www.huihuang200.com';

        $ExternalUrl = $this->homeService->getExternalUrl($httpHost);

        if ($ExternalUrl != 'none') {
            return view('middle.index');
        }

        $siteRes = $this->homeService->getHostSiteRes($httpHost);
        //$siteFolder = $this->$this->homeService->getHostSiteFolder($httpHost);
        $siteInfo = $this->homeService->getHostSiteInfo($siteRes->site_id);

        $data = [
            'site_id' => $siteRes->site_id,
            'site_name' => $siteInfo->site_name
        ];

        $sitePath = $siteBasePath.'/'.$siteRes->site_folder.'/pc/dist';

        if (!file_exists(resource_path('views/'.$sitePath))) {
            return view('default.index', $data);
        }

        $siteViewPath = Str::replaceArray('/', ['.'], $sitePath);

        return view($siteViewPath.'.index');
    }
    //
}

