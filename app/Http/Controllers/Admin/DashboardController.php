<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $data = Auth::user();
        return view('pages.admin.dashboard', [
            'judul' => 'Dashboard',
            'user' => $data
        ]);
    }
}
