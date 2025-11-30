<?php
namespace App\Http\Controllers;
use App\Models\Reservation;

class SurveyController extends Controller
{
    public function create(Reservation $reservasi)
    {
        // Tampilkan view wrapper
        return view('survey.create', ['reservasi' => $reservasi]);
    }
     public function index()
    {
        return view('admin.survey.index');
    }

}
