<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\ConferenceApplication;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class ToolController extends Controller
{
    public function indexExcel()
    {
      $applications = ConferenceApplication::all();
      Excel::create('TFC - Registrazioni Conferenza', function($excel) use($applications) {
          $excel->setTitle('Registrazioni');
          $excel->sheet('Registrazioni', function($sheet) use($applications){
              $sheet->row(1, ['Nome', 'Cognome', 'Email', 'Istituzione', 'Ruolo']);
              $sheet->cells('A1:E1', function($cells) {
                $cells->setBackground('#f3f3f3');
                $cells->setFontSize('16');
                $cells->setFontWeight('bold');
              });
              foreach ($applications as $key => $application) {
                $sheet->row(($key+2), [$application->name, $application->surname, $application->email, $application->institution, $application->role]);
              }
          });
      })->download('xlsx');
    }
}
