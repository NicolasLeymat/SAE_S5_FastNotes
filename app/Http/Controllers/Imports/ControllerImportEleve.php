<?php

namespace App\Http\Controllers;

use App\Imports\ElevesImport;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Maatwebsite\Excel\Facades\Excel;
use Request;

class ControllerImportEleve extends BaseController
{
    public function export(Request $request){
        
    }

    public function import(Request $request){
        Excel::import(new ElevesImport, $request->file('eleves'));
    }
}
