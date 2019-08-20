<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/8/19
 * Time: 10:12
 */

namespace App\Facades;
use Illuminate\Support\Facades\Facade;

class HomeFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'HomeService';
    }
}