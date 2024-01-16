<?php

namespace App\Imports;

use App\Models\Evaluation;
use App\Models\Utilisateur;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class EvaluationImport implements ToCollection, WithStartRow,WithCalculatedFormulas
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row){
            //dd($row);
            if(strcmp($row[1], "Semestre 5") == 0)
            {
                if($row[20] != null && $row[10]!=null){
                    if($row[21] == null){
                        $nbEval = 1;
                    }else if ($row[22] == null){
                        $nbEval = 2;
                    }else if ($row[23] == null){
                        $nbEval = 3;
                    }
                    //dd(explode(" - ",$row[20])[1]);
                    $currentNamenumber = 20;
                    $currentTypeNumber = 10;
                    $currentCoefNumber = 11;
                    if($nbEval == 1){
                        Evaluation::create([
                            "libelle" => explode(" - ",$row[$currentNamenumber])[1],
                            "coefficient" =>$row[$currentCoefNumber],
                            "type" => $row[$currentTypeNumber],
                            "code_ressource" => $row[4]
                        ]);
                    }else{
                        for($i=1; $i<$nbEval+1; $i++){
                            $currentType = $row[$currentTypeNumber];
                            $currentCoef = $row[$currentCoefNumber];
                            Evaluation::create([
                            "libelle" => explode(" - ",$row[$currentNamenumber])[1],
                            "coefficient" => $currentCoef,
                            "type" => $currentType,
                            "code_ressource" => $row[4]
                            ]);
                            $currentTypeNumber += 2;
                            $currentCoefNumber += 2;
                            $currentNamenumber += 1;
                        }
                    }
                }
            }
        }
    }

    public function startRow(): int{
        return 3;
    }
}
