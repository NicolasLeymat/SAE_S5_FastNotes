<?php

namespace App\Imports;

use App\Models\Utilisateur;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ElevesImport implements ToCollection
{
    /**
    * @param Collection $rows
    */
    public function collection(Collection $rows)
    {
        foreach($rows as row)
        {
            Utilisateur::create([

            ]);
        }
    }
}
