<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data['side_index'] = 0;
        return view('dashboard',$data);
    }
}
