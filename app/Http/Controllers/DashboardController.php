<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $consumptionByMonth = $user->consumptionRecords()
            ->selectRaw('YEAR(record_date) as year, MONTH(record_date) as month, SUM(kwh) as total_kwh, SUM(gallons) as total_gallons, SUM(amount_aed) as total_aed')
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $recentBills = $user->bills()->latest('bill_date')->take(5)->get();
        $alertsCount = $user->alerts()->where('read_at', null)->count();

        return view('dashboard', [
            'consumptionByMonth' => $consumptionByMonth,
            'recentBills' => $recentBills,
            'alertsCount' => $alertsCount,
        ]);
    }
}
