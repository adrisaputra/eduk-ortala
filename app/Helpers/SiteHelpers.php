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
    
    // public static function config_menu()
    // {
    //     $menu = MenuAccess::leftJoin('groups', 'menu_accesses.group_id', '=', 'groups.id')
    //             ->leftJoin('menus', 'menu_accesses.menu_id', '=', 'menus.id')
    //             ->where('menu_accesses.group_id',Auth::user()->group_id)
    //             ->where('menus.status',1)
    //             ->where('menus.category',1)
    //             ->orderBy('menus.position','ASC')
    //             ->get();
    //     return $menu;
    // }

    // public static function main_menu()
    // {
    //     $menu = MenuAccess::leftJoin('groups', 'menu_accesses.group_id', '=', 'groups.id')
    //             ->leftJoin('menus', 'menu_accesses.menu_id', '=', 'menus.id')
    //             ->where('menu_accesses.group_id',Auth::user()->group_id)
    //             ->where('menus.status',1)
    //             ->where('menus.category',2)
    //             ->orderBy('menus.position','ASC')
    //             ->get();
    //     return $menu;
    // }

    // public static function submenu($menu_id)
    // {
    //     $submenu = SubMenuAccess::leftJoin('groups', 'sub_menu_accesses.group_id', '=', 'groups.id')
    //                 ->leftJoin('sub_menus', 'sub_menu_accesses.sub_menu_id', '=', 'sub_menus.id')
    //                 ->where('sub_menu_accesses.group_id',Auth::user()->group_id)
    //                 ->where('sub_menus.status',1)
    //                 ->where('sub_menus.menu_id',$menu_id)
    //                 ->orderBy('position','ASC')->get();
    //     return $submenu;
    // }

    public static function slider()
    {
        $slider = Slider::get();
        return $slider;
    }
    
    public static function setting()
    {
        $setting = Setting::find(1);
        return $setting;
    }


}
