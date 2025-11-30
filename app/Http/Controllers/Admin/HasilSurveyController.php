<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class HasilSurveyController extends Controller
{
    public function index()
    {
        return view('admin.hasil-survey.index');
    }
}
