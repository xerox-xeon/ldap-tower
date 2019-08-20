<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/8/17
 * Time: 14:26
 */

namespace App\Http\Services;

use Illuminate\Support\Facades\DB;

class HomeService
{
    /**
     * @param $host
     * @return int|mixed
     */
    public function getHostStatus($host) {
        $defaultStatus = -1;
        $res = DB::table('tb_site_domain')->select('status')->where('domain_url', '=', $host)->first();
        if ($res) {
            return $res->status;
        }
        return $defaultStatus;

    }

    /**
     * @param $host
     * @return mixed|string
     */
    public function getHostSiteRes($host) {
        $defaultSiteFolder = 'default';
        $res = DB::table('tb_site_domain')->where('domain_url', '=', $host)->first();
        if ($res) {
            return $res;
        }
        return $defaultSiteFolder;

    }


    public function getHostSiteInfo($siteId) {
        $defaultSiteInfo = 'none';
        $res = DB::table('tb_site_identification')->where('site_id', '=', $siteId)->first();
        if ($res) {
            return $res;
        }
        return $defaultSiteInfo;

    }


    public function getExternalUrl($host) {
        $defaultExternalUrl = 'none';
        $res = DB::table('tb_site_domain_popu')->where('external_url', '=', $host)->first();
        if ($res) {
            return $res;
        }
        return $defaultExternalUrl;
    }

}