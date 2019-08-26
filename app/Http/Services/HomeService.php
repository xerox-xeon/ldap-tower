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
    public function getHostUrl($host)
    {
        $hostUrl = 'none';
        $first   = DB::table('tb_site_domain')->select('domain_url')->where('domain_url', '=', $host);
        $res     = DB::table('tb_site_domain_popu')->select('domain_url')->where('domain_url', '=', $host)->union($first)->first();

        if ($res) {
            $hostUrl = $res->domain_url;
        }
        return $hostUrl;

    }

    public function getHostStatus($host)
    {
        $hostStatus = '1';
        $res        = DB::table('tb_site_domain')->select('status')->where('domain_url', '=', $host)->first();
        if ($res) {
            $hostStatus = $res->status;
        }
        return $hostStatus;
    }

    /**
     * @param $host
     * @return mixed|string
     */
    public function getHostSiteId($host)
    {
        $siteId = 'default';
        $first  = DB::table('tb_site_domain')->select('site_id')->where('domain_url', '=', $host);
        $res    = DB::table('tb_site_domain_popu')->select('site_id')->where('domain_url', '=', $host)->union($first)->first();
        if ($res) {
            $siteId = $res->site_id;
        }
        return $siteId;
    }


    /**
     * @param $siteId
     * @return mixed|string
     */
    public function getHostSiteFolder($siteId)
    {
        $siteFolder = 'none';
        $res        = DB::table('tb_site_domain')->select('site_folder')->where('site_id', '=', $siteId)->first();
        if ($res) {
            $siteFolder = $res->site_folder;
        }
        return $siteFolder;
    }

    /**
     * @param $siteId
     * @return mixed|string
     */
    public function getHostSiteName($siteId)
    {
        $siteName = 'none';
        $res      = DB::table('tb_site_identification')->select('site_name')->where('site_id', '=', $siteId)->first();
        if ($res) {
            $siteName = $res->site_name;
        }
        return $siteName;
    }


    /**
     * @param $host
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|string|null
     */
    public function getExternalUrl($host)
    {
        $externalUrl = 'none';
        $res         = DB::table('tb_site_domain_popu')->where('external_url', '=', $host)->first();
        if ($res) {
            $externalUrl = $res;
        }
        return $externalUrl;
    }

}