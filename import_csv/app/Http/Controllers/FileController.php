<?php

namespace App\Http\Controllers;

use App\File;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function statistics() 
    {
        $file = File::latest()->first();
        $imported_records = round(($file->imported_records_qty / $file->records_qty) * 100);

        return view('file.statistics', [
            'file' => $file,
            'imported_records' => $imported_records . '%'
        ]);
    }
}
