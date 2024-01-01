<?php

namespace App\Helpers;

class MonthHelpers
{
    
    public static function month_name($month) {
        switch ($month) {
            case "01":
                return "JANUARI";
            case "02":
                return "FEBRUARI";
            case "03":
                return "MARET";
            case "04":
                return "APRIL";
            case "05":
                return "MEI";
            case "06":
                return "JUNI";
            case "07":
                return "JULI";
            case "08":
                return "AGUSTUS";
            case "09":
                return "SEPTEMBER";
            case "10":
                return "OKTOBER";
            case "11":
                return "NOVEMBER";
            case "12":
                return "DESEMBER";
            default:
                return "Nomor hari tidak valid. Masukkan nomor antara 1 dan 7.";
        }
    }
    
}
