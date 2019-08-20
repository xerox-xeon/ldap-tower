<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/8/17
 * Time: 14:21
 */

namespace App\Http\Services;


class Service
{
    /**
     * @param $serviceName
     * @return mixed
     */
    public static function factory($serviceName) {
        $className = 'App\\Http\\Services\\'.$serviceName;
        return new $className;
    }
}