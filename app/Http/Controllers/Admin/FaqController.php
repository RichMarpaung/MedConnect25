<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

class FaqController extends Controller
{
    public function index()
    {
        return view('admin.faq.index');
    }
}
