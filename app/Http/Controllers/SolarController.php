<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class SolarController extends Controller
{
    /**
     * Basic solar ROI calculator (Phase 2).
     * Formula-based estimate using typical UAE rates; not financial advice.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        $avgMonthlyKwh = $user->consumptionRecords()
            ->whereNotNull('kwh')
            ->where('kwh', '>', 0)
            ->avg('kwh');
        $avgMonthlyKwh = $avgMonthlyKwh ? round($avgMonthlyKwh, 0) : null;

        return view('solar.index', [
            'avgMonthlyKwh' => $avgMonthlyKwh,
            'typicalRateAedPerKwh' => 0.35,
            'typicalInstallCostPerKw' => 12000,
        ]);
    }

    /**
     * Calculate estimate (no persistence; display only).
     */
    public function calculate(Request $request): View
    {
        $request->validate([
            'monthly_kwh' => ['required', 'numeric', 'min:100', 'max:10000'],
            'rate_per_kwh' => ['nullable', 'numeric', 'min:0.1', 'max:2'],
            'install_cost_per_kw' => ['nullable', 'numeric', 'min:5000', 'max:25000'],
            'panel_kw' => ['nullable', 'numeric', 'min:1', 'max:100'],
        ]);

        $monthlyKwh = (float) $request->input('monthly_kwh');
        $ratePerKwh = (float) ($request->input('rate_per_kwh') ?: 0.35);
        $costPerKw = (float) ($request->input('install_cost_per_kw') ?: 12000);

        // System size: monthly_kwh ≈ kW × sun_hrs/day × 30 → kW = monthly_kwh / (4 × 30)
        $panelKw = $request->filled('panel_kw')
            ? (float) $request->input('panel_kw')
            : min($monthlyKwh / 120, 20);

        $monthlySavings = $panelKw * 4 * 30 * $ratePerKwh; // 4 hrs/day, 30 days, AED per kWh
        $annualSavings = $monthlySavings * 12;
        $totalCost = $panelKw * $costPerKw;
        $paybackYears = ($annualSavings > 0.01) ? round($totalCost / $annualSavings, 1) : 0;

        return view('solar.result', [
            'monthlyKwh' => $monthlyKwh,
            'panelKw' => $panelKw,
            'ratePerKwh' => $ratePerKwh,
            'costPerKw' => $costPerKw,
            'monthlySavings' => round($monthlySavings, 2),
            'annualSavings' => round($annualSavings, 2),
            'totalCost' => round($totalCost, 0),
            'paybackYears' => $paybackYears,
        ]);
    }
}
