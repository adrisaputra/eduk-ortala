<?php

namespace App\Imports;

use App\Models\GoalIndicator;
use App\Models\Target;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithStartRow;

class TargetImport implements ToCollection, WithStartRow
{
    public function  __construct($goal_indicator_id)
    {
        $this->goal_indicator_id= $goal_indicator_id;
    }

    public function collection(Collection $rows)
    {

        foreach ($rows as $row) 
        { 
            Target::create([
                'goal_indicator_id' => $this->goal_indicator_id,
                'name' => $row[1]
            ]);

        }

    }

    public function startRow(): int
    {
        return 2;
    }

}
