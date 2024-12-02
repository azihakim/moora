<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RekapController extends Controller
{
    function rekapHrd()
    {
        return view('rekap.pdf-rekapHrd');
    }
}
