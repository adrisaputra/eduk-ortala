<?php

namespace App\Helpers;

use App\Models\Setting;   //nama model
use App\Models\Promotion;   //nama model
use App\Models\SalaryIncrease;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class SiteHelpers
{
    
    public static function setting()
    {
        $setting = Setting::find(1);
        return $setting;
    }

    public static function notification()
    {
        $count = Promotion::where('status','Dikirim')->count();
        return $count;
    }

    public static function notification2()
    {
        $count = SalaryIncrease::where('status','Dikirim')->count();
        return $count;
    }

    public static function total_notification()
    {
        $count = static::notification() + static::notification2();
        return $count;
    }


}
