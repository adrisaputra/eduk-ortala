<?php

namespace App\Imports;

use App\Models\Mission;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithStartRow;

class MissionImport implements ToCollection, WithStartRow
{
    public function  __construct($vision_id)
    {
        $this->vision_id= $vision_id;
    }

    public function collection(Collection $rows)
    {

        foreach ($rows as $row) 
        { 
            Mission::create([
                'vision_id' => $this->vision_id,
                'name' => $row[1]
            ]);

        }

    }
    
    public function startRow(): int
    {
        return 2;
    }
}
