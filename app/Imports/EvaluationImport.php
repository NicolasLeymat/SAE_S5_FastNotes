<?php

namespace App\Imports;

use App\Models\Utilisateur;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;

class ElevesImport implements ToModel
{
    /**
    * @param Collection $collection
    */
    public function model(array $collection)
    {
        return new Utilisateur;
    }
}
