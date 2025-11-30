<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class SurveyController extends Controller
{
    public function index()
    {
        return view('admin.survey.index');
    }
}
