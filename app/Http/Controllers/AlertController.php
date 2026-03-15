<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AlertController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Alert::class, 'alert');
    }

    public function index(Request $request): View
    {
        $this->authorize('viewAny', Alert::class);

        $alerts = $request->user()
            ->alerts()
            ->latest()
            ->paginate(20);

        return view('alerts.index', compact('alerts'));
    }
}
