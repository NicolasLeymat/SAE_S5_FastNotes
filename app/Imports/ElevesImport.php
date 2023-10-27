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
            //dd($rows);
            Utilisateur::create([
                'code' => $row["code"],
                'identification' => $row["identifiant"],
                'nom' => $row["nom"],
                'prenom' =>$row["prenom"],
                'email' => $row["email"],
                'password' => Hash::make($row["nom"].$row["prenom"].$row["groupe"]),
                'isProf' => 0,
                'isAdmin' => 0,
                'idGroupe' => $row["groupe"]
            ]);
        }
    }
}
