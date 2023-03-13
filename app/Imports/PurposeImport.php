<?php

namespace App\Imports;

use App\Models\Mission;
use App\Models\Purpose;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithStartRow;

class PurposeImport implements ToCollection, WithStartRow
{
    
    public function collection(Collection $rows)
    {

        foreach ($rows as $row) 
        { 
            $mission = Mission::where('name','like',$row[1])->first();
            
            Purpose::create([
                'mission_id' => $mission->id,
                'name' => $row[2]
            ]);

        }

    }

    public function startRow(): int
    {
        return 2;
    }

}
