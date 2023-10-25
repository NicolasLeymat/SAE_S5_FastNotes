<?php

namespace App\Imports;

use App\Models\Utilisateur;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ElevesImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $rows
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            Utilisateur::create([
                'code' => $row["Code"],
                'identification' => $row["Identifiant"],
                'nom' => $row["Nom"],
                'prenom' =>$row["Prenom"],
                'email' => $row["Email"],
                'password' => Hash::make($row["Nom"]+$row["Prenom"]+$row["Groupe"]),
                'isProf' => 0,
                'isAdmin' => 0,
                'idGroupe' => $row["Groupe"]
            ]);
        }
    }
}
