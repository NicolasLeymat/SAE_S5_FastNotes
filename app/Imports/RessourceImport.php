<?php

namespace App\Imports;

use App\Models\Ressource;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RessourceImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $rows
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row){
            Ressource::create([
                'code' => $row['code'],
                'libelle' => $row['libelle']
            ]);
        }
    }

    public function sheets(): array{
        return ["INFOS-RESSOURCES"=> $this];
    }
}
