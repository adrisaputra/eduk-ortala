<?php

namespace App\Imports;

use App\Models\Purpose;
use App\Models\GoalIndicator;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithStartRow;

class GoalIndicatorImport implements ToCollection, WithStartRow
{
    public function  __construct($purpose_id)
    {
        $this->purpose_id= $purpose_id;
    }

    public function collection(Collection $rows)
    {

        foreach ($rows as $row) 
        { 
            GoalIndicator::create([
                'purpose_id' => $this->purpose_id,
                'name' => $row[1]
            ]);

        }

    }

    public function startRow(): int
    {
        return 2;
    }

}
