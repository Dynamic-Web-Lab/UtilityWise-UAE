<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class AlertController extends Controller
{
    public function index(Request $request): View
    {
        $alerts = $request->user()
            ->alerts()
            ->latest()
            ->paginate(20);

        return view('alerts.index', compact('alerts'));
    }
}
