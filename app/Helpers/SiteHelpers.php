<?php

namespace App\Helpers;

use App\Models\Menu;   //nama model
use App\Models\SubMenu;   //nama model
use App\Models\MenuAccess;   //nama model
use App\Models\SubMenuAccess;   //nama model
use App\Models\Slider;   //nama model
use App\Models\Setting;   //nama model
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class SiteHelpers
{
    
    public static function setting()
    {
        $setting = Setting::find(1);
        return $setting;
    }


}
