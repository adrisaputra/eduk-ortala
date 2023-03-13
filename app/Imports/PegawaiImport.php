<?php

namespace App\Imports;

use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Facades\Hash;

class PegawaiImport implements ToCollection
{
    public function collection(Collection $rows)
    {

        foreach ($rows as $row) 
        { 
            Pegawai::create([
                'nip' => $row[0],
                'nama_pegawai' => $row[1]
            ]);

        }

    }
}
